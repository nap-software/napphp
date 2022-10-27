<?php

/**
 * Function to ''kill'' a running program.
 */
function napphp_shell_killRunningProgram($prog_pid, $proc) {
	proc_terminate($proc);
	posix_kill($prog_pid, SIGKILL);
}

/**
 * Wrapper function to execute a program with or
 * without a timeout.
 * 
 * Returns exit code or -9999 if timeout occurred.
 */
function napphp_shell_executeProgramWithTimeout(
	$that, $script_path, $timeout_in_seconds
) {
	// use system() if program should not timeout
	if (0 >= $timeout_in_seconds) {
		$exit_code = 1;

		system(escapeshellcmd($script_path), $exit_code);

		return $exit_code;
	}

	$proc = proc_open(escapeshellcmd($script_path), [
		/** use ''transparent'' execute just like system() **/
		0 => STDIN,
		1 => STDOUT,
		2 => STDERR
	], $pipes);

	if (!is_resource($proc)) {
		$that->int_raiseError("Failed to proc_open '$script_path'.");
	}

	$prog_pid      = -1;
	$prog_exitcode = -1;
	// Save start time to see when time's up...
	$start         = $that->sys_getHRTime();
	$max_time      = $timeout_in_seconds * 1000;

	while (true) {
		$elapsed_time = $that->sys_getHRTime() - $start;

		if ($elapsed_time >= $max_time) {
			$prog_exitcode = -9999;

			napphp_shell_killRunningProgram($prog_pid, $proc);

			break;
		}

		$proc_status = proc_get_status($proc);

		if ($prog_pid === -1) {
			$prog_pid = $proc_status["pid"];
		}

		if (!$proc_status["running"]) {
			$prog_exitcode = $proc_status["exitcode"];

			break;
		}

		$that->sys_delay(500);
	}

	proc_close($proc);

	return $prog_exitcode;
}

return function($command, $options = []) {
	$escaped_command = escapeshellcmd($command);
	$escaped_command_args = $this->arr_join(
		$this->arr_map($options["args"] ?? [], "escapeshellarg"), " "
	);
	$cwd = $options["cwd"] ?? $this->proc_getCurrentWorkingDirectory();
	$full_command = "$escaped_command";

	if (strlen($escaped_command_args)) {
		$full_command .= " $escaped_command_args";
	}

	$local_env_variables = "";

	if ($this->arr_keyExists($options, "env") && sizeof($options["env"])) {
		$tmp = [];

		foreach ($options["env"] as $env_name => $env_value) {
			array_push($tmp, strtoupper($env_name)."=".escapeshellarg($env_value));
		}

		$local_env_variables = $this->arr_join($tmp, " ")." ";
	}

	$stdout_destination = $options["stdout"] ?? "inherit";
	$stderr_destination = $options["stderr"] ?? "inherit";

	/*
	 * handle case where 'stdout' and 'stderr' *both* point to the same destination
	 */
	if (
		$stdout_destination === $stderr_destination
	) {
		if ($stdout_destination !== "inherit") {
			$full_command .= " 1> ".escapeshellarg($stdout_destination)." 2>&1";
		}
	} else {
		if ($stdout_destination !== "inherit") {
			$full_command .= " 1> ".escapeshellarg($stdout_destination);
		}

		if ($stderr_destination !== "inherit") {
			$full_command .= " 2> ".escapeshellarg($stderr_destination);
		}
	}

	/**
	 * Create temporary script.
	 */
	$script  = "#!/bin/sh -e\n";
	$script .= "cd ".escapeshellarg($cwd)."\n";
	$script .= "$local_env_variables$full_command\n";

	if (($options["_unitTest"] ?? false)) {
		return $script;
	}

	$script_path = $this->tmp_createFile(".sh");

	$this->fs_writeFileStringAtomic($script_path, $script);
	$this->fs_setFileMode($script_path, 0700);

	$exit_code = napphp_shell_executeProgramWithTimeout(
		$this, $script_path, $options["timeout"] ?? 0
	);

	clearstatcache();

	$debug_moveTo = $options["_debug"]["moveTo"] ?? "";

	if (strlen($debug_moveTo)) {
		$this->fs_rename($script_path, $options["_debug"]["moveTo"]);
	} else {
		$this->fs_unlink($script_path);
	}

	/**
	 * never complain about a timeout because a user setting a timeout
	 * is expected to handle a timeout event...
	 */
	if ($exit_code === 0 || $exit_code === -9999) {
		if ($exit_code === -9999) {
			return "timeout";
		}

		return 0;
	}

	$allow_non_zero_exit_code = $options["allow_non_zero_exit_code"] ?? false;

	if ($allow_non_zero_exit_code) {
		return $exit_code;
	}

	$this->int_raiseError(
		"Command $escaped_command failed with exit code $exit_code."
	);
};

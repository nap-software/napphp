<?php

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
	$this->fs_setFileMode($script_path, 0744);

	$exit_code = 1;

	system(
		escapeshellcmd($script_path), $exit_code
	);

	clearstatcache();

	$debug_moveTo = $options["_debug"]["moveTo"] ?? "";

	if (strlen($debug_moveTo)) {
		$this->fs_rename($script_path, $options["_debug"]["moveTo"]);
	} else {
		$this->fs_unlink($script_path);
	}

	if ($exit_code === 0) {
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

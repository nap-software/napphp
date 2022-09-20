<?php

return function($command, $args = []) {
	$this->int_raiseDeprecationWarning("proc_exec", "shell_execute");

	$args = array_map("escapeshellarg", $args);
	$args = implode(" ", $args);
	$full_command = "$command $args";

	$last_line = system($full_command, $exit_code);

	if ($exit_code !== 0) {
		$this->int_raiseError(
			"Failed to execute '$full_command'."
		);
	}

	return $last_line;
};

<?php

return function($command, $args = []) {
	$args = array_map("escapeshellarg", $args);
	$args = implode(" ", $args);
	$full_command = "$command $args";

	exec($full_command, $lines, $exit_code);

	if ($exit_code !== 0) {
		$this->int_raiseError(
			"Failed to execute '$full_command'."
		);
	}

	return $lines;
};

<?php

return function() {
	exec("git rev-parse HEAD", $output, $exit_code);

	if ($exit_code !== 0) {
		$this->int_raiseError("Failed to execute 'git rev-parse HEAD'.");
	}

	return trim($output[0]);
};

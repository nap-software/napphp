<?php

return function() {
	if (strlen(getenv("NAPPHP_OVERRIDE_GIT_BRANCH"))) {
		$git_branch = getenv("NAPPHP_OVERRIDE_GIT_BRANCH");
	} else {
		exec("git rev-parse --abbrev-ref HEAD", $output, $exit_code);

		if ($exit_code !== 0) {
			$this->int_raiseError("Failed to execute 'git rev-parse'.");
		}

		$git_branch = $output[0];
	}

	return trim($git_branch);
};

<?php

return function() {
	if (strlen(getenv("NAPPHP_OVERRIDE_GIT_BRANCH"))) {
		$git_branch = getenv("NAPPHP_OVERRIDE_GIT_BRANCH");
	} else {
		$git_branch = $this->proc_exec(
			"git rev-parse --abbrev-ref HEAD"
		)[0];
	}

	return trim($git_branch);
};

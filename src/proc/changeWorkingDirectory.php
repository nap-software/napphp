<?php

function napphp_proc_changeWorkingDirectoryCB($that, $path, $fn) {
	$saved_cwd = $that->invoke("proc_getCurrentWorkingDirectory");

	try {
		$that->invoke("proc_changeWorkingDirectory", $path);
		$fn();
	} finally {
		$that->invoke("proc_changeWorkingDirectory", $saved_cwd);
	}
}

return function($path, $fn = NULL) {
	// use chdir() when $fn is not passed
	if (!$fn) {
		if (!chdir($path)) {
			$this->raiseError(
				"Failed to change working directory to '$path'."
			);
		}
	}
	// run $fn with changed directory
	else {
		napphp_proc_changeWorkingDirectoryCB($this, $path, $fn);
	}
};

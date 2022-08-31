<?php

return function($path) {
	$perms = fileperms($path);

	if ($perms === false) {
		$this->int_raiseError(
			"Failed to get permissions for '$path'"
		);
	}

	return $perms & 0777;
};

<?php

return function ($path) {
	$realpath = realpath($path);

	if (!$realpath) {
		$this->raiseError(
			"Failed to resolve '$path'."
		);
	}

	return $realpath;
};

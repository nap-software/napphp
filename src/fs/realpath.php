<?php

return function ($path) {
	$realpath = realpath($path);

	if (!$realpath) {
		$this->int_raiseError(
			"Failed to resolve '$path'."
		);
	}

	return $realpath;
};

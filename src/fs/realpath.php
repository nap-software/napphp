<?php

return function ($path) {
	$realpath = @realpath($path);
	$this->int_saveLastPHPError();

	if (!$realpath) {
		$this->int_raiseError(
			"Failed to resolve '$path'."
		);
	}

	return $realpath;
};

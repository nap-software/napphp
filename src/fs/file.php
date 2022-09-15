<?php

return function($file, $flags = 0) {
	$lines = @file($file, $flags);
	$this->int_saveLastPHPError();

	if (!is_array($lines)) {
		$this->int_raiseError(
			"Failed to read file '$file' into lines."
		);
	}

	return $lines;
};

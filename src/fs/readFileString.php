<?php

return function($file) {
	$contents = @file_get_contents($file);
	$this->int_saveLastPHPError();

	if ($contents === false) {
		$this->int_raiseError(
			"Failed to read file '$file'."
		);
	}

	return $contents;
};

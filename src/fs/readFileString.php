<?php

return function($file) {
	$contents = file_get_contents($file);

	if ($contents === false) {
		$this->raiseError(
			"Failed to read file '$file'."
		);
	}

	return $contents;
};

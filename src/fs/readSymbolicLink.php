<?php

return function($path) {
	if (!is_link($path)) {
		$this->int_raiseError(
			"Path '$path' is not a symbolic link."
		);
	}

	$link = readlink($path);

	var_dump($link);

	return $link;
};

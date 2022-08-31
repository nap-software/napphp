<?php

return function() {
	$pwd = getcwd();

	if (!$pwd) {
		$this->int_raiseError(
			"Failed to get current working directory."
		);
	}

	return $pwd;
};

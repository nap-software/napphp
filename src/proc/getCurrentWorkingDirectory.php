<?php

return function() {
	$pwd = getcwd();

	if (!$pwd) {
		$this->raiseError(
			"Failed to get current working directory."
		);
	}

	return $pwd;
};

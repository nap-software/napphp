<?php

return function ($path) {
	$entries = @scandir($path);
	$this->int_saveLastPHPError();

	if (!is_array($entries)) {
		$this->int_raiseError(
			"Failed to scandir '$path'."
		);
	}

	// remove "." and ".." entries
	return array_filter($entries, function($entry) {
		if ($entry === ".") return false;
		if ($entry === "..") return false;

		return true;
	});
};

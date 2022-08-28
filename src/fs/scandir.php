<?php

return function ($path) {
	$entries = scandir($path);

	if (!is_array($entries)) {
		$this->raiseError(
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

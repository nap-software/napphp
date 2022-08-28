<?php

return function ($dir) {
	if (!mkdir($dir)) {
		$is_dir = $this->invoke("fs_isDirectory", $dir);

		// Only raise error IF $dir is not a directory after creation
		if (!$is_dir) {
			$this->raiseError(
				"Failed to create directory '$dir'."
			);
		}
	}
};

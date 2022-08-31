<?php

return function ($dir, $perm = 0777) {
	if (!mkdir($dir, $perm, true)) {
		$is_dir = $this->invoke("fs_isDirectory", $dir);

		// Only raise error IF $dir is not a directory after creation
		if (!$is_dir) {
			$this->int_raiseError(
				"Failed to create directory '$dir'."
			);
		}
	}
};

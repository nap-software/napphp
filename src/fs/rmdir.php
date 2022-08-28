<?php

return function ($path, $silent = false) {
	if (!rmdir($path)) {
		$path_exists = $this->invoke("fs_exists", $path);

		// Only raise error IF $path still exists after deletion
		if ($path_exists) {
			// never raise error if $silent is set
			if ($silent) return;

			$this->raiseError(
				"Failed to remove '$path' (dir)."
			);
		}
	}
};

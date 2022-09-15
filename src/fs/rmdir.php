<?php

return function ($path, $silent = false) {
	if (!@rmdir($path)) {
		$this->int_saveLastPHPError();

		$path_exists = $this->fs_exists($path);

		// Only raise error IF $path still exists after deletion
		if ($path_exists) {
			// never raise error if $silent is set
			if ($silent) return;

			$this->int_raiseError(
				"Failed to remove '$path' (dir)."
			);
		}
	}
};

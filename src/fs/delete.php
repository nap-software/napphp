<?php

function napphp_fs_deleteDirectory($that, $path, $silent) {
	$entries = $that->fs_scandir($path);

	foreach ($entries as $entry) {
		$entry_path = "$path/$entry";

		if ($that->fs_isDirectory($entry_path)) {
			napphp_fs_deleteDirectory($that, $entry_path, $silent);
		} else {
			$that->fs_unlink($entry_path, $silent);
		}
	}

	$that->fs_rmdir($path, $silent);
}

return function ($path, $silent = false) {
	$is_directory = $this->fs_isDirectory($path);

	if ($is_directory) {
		napphp_fs_deleteDirectory($this, $path, $silent);
	} else {
		$this->fs_unlink($path, $silent);
	}
};

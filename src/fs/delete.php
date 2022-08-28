<?php

function napphp_fs_deleteDirectory($that, $path, $silent) {
	$entries = $that->invoke("fs_scandir", $path);

	foreach ($entries as $entry) {
		$entry_path = "$path/$entry";

		if ($that->invoke("fs_isDirectory", $entry_path)) {
			napphp_fs_deleteDirectory($that, $entry_path, $silent);
		} else {
			$that->invoke("fs_unlink", $entry_path, $silent);
		}
	}

	$that->invoke("fs_rmdir", $path, $silent);
}

return function ($path, $silent = false) {
	$is_directory = $this->invoke("fs_isDirectory", $path);

	if ($is_directory) {
		napphp_fs_deleteDirectory($this, $path, $silent);
	} else {
		$this->invoke("fs_unlink", $path, $silent);
	}
};

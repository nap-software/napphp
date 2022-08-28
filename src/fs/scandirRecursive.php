<?php

function napphp_fs_scandirRecursive($that, $path, &$ret_entries = []) {
	$entries = $that->invoke("fs_scandir", $path);

	foreach ($entries as $entry) {
		$entry_path = "$path/$entry";

		array_push($ret_entries, $entry_path);

		if ($that->invoke("fs_isDirectory", $entry_path)) {
			napphp_fs_scandirRecursive($that, $entry_path, $ret_entries);
		}
	}

	return $ret_entries;
}

return function($path) {
	return napphp_fs_scandirRecursive($this, $path);
};

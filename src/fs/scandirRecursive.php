<?php

function napphp_fs_scandirRecursive(
	$that,
	$path_to_scan,
	$path_chain = [],
	&$ret_entries = []
) {
	$entries = $that->fs_scandir($path_to_scan);

	foreach ($entries as $entry) {
		$entry_path = "$path_to_scan/$entry";
		$entry_path_chain = array_merge($path_chain, [$entry]);
		$entry_path_type = "file";

		if ($that->fs_isDirectory($entry_path)) {
			$entry_path_type = "directory";
		}

		array_push(
			$ret_entries,
			[
				"basename" => $entry,
				"path" => $entry_path,
				"relative_path" => $that->arr_join($entry_path_chain, "/"),
				"type" => $entry_path_type
			]
		);

		# recurse if true directory
		if ($entry_path_type === "directory") {
			napphp_fs_scandirRecursive(
				$that,
				$entry_path,
				$entry_path_chain,
				$ret_entries
			);
		}
	}

	return $ret_entries;
}

return function($path) {
	return napphp_fs_scandirRecursive($this, $path);
};

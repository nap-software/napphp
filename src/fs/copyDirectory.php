<?php

return function($src, $dst) {
	$entries = $this->fs_scandirRecursive($src);

	// clone directory tree structure
	foreach ($entries as $entry) {
		if ($entry["type"] !== "directory") continue;

		$this->fs_mkdir("$dst/".$entry["relative_path"]);

		$original_permissions = $this->fs_getFileMode($entry["path"]);
		$this->fs_setFileMode("$dst/".$entry["relative_path"], $original_permissions);
	}

	// copy files and symbolic links
	foreach ($entries as $entry) {
		if ($entry["type"] !== "file") continue;

		$src_path = "$src/".$entry["relative_path"];
		$dst_path = "$dst/".$entry["relative_path"];

		// is file a symbolic link?
		$is_link = is_link($entry["path"]);

		if ($is_link) {
			$this->fs_copySymbolicLink($src_path, $dst_path);
		} else {
			$this->fs_copyFile($src_path, $dst_path);
		}
	}
};

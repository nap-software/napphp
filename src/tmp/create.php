<?php

return function($type, $file_extension = "", $persistent = false) {
	$tmp_dir = $persistent ? "/var/tmp/" : "/tmp/";

	if (!$this->int_storeKeyExists("tmp_paths")) {
		$tmp_paths = [];
	} else {
		$tmp_paths = $this->int_storeGetKey("tmp_paths");
	}

	$random_identifier = $this->util_randomIdentifier(10);
	$tmp_name = "$random_identifier.tmp";
	$tmp_path = "$tmp_dir/$tmp_name$file_extension";

	if ($type === "dir") {
		$this->fs_mkdir($tmp_path);
	} else if ($type === "file") {
		// use something else instead of "touch"
		// touch updates filemtime when path exists
		$this->fs_touch($tmp_path);
	} else {
		$this->int_raiseError("Unkown type '$type'.");
	}

	array_push($tmp_paths, $tmp_path);

	if ($persistent !== true) {
		$this->int_storeSetKey("tmp_paths", $tmp_paths);
	}

	return $tmp_path;
};

<?php

return function() {
	if (!$this->storeKeyExists("tmp_paths")) {
		return 0;
	}

	$tmp_paths = $this->storeGetKey("tmp_paths");
	$this->storeSetKey("tmp_paths", []);

	foreach ($tmp_paths as $tmp_path) {
		$this->invoke("fs_delete", $tmp_path);
	}

	return sizeof($tmp_paths);
};

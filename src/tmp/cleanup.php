<?php

return function() {
	if (!$this->int_storeKeyExists("tmp_paths")) {
		return 0;
	}

	$tmp_paths = $this->int_storeGetKey("tmp_paths");
	$this->int_storeSetKey("tmp_paths", []);

	foreach ($tmp_paths as $tmp_path) {
		$this->invoke("fs_delete", $tmp_path);
	}

	return sizeof($tmp_paths);
};

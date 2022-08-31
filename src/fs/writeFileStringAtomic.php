<?php

return function($file, $data) {
	$dir_path = dirname($file);
	$file_name = basename($file);
	$random_identifier = $this->util_randomIdentifier(10);
	$temp_file_name = "$random_identifier.tmp";

	$tmp_path = "$dir_path/$temp_file_name";

	$this->fs_writeFileString($tmp_path, $data);
	$this->fs_rename($tmp_path, "$dir_path/$file_name");
};

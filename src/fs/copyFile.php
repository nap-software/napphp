<?php

return function($src, $dst) {
	if (!copy($src, $dst)) {
		$this->int_raiseError(
			"Failed to copy '$src' to '$dst'"
		);
	}

	$original_permissions = $this->fs_getFileMode($src);
	$this->fs_setFileMode($dst, $original_permissions);
};

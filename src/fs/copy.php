<?php

return function($src, $dst) {
	if ($this->fs_isDirectory($src)) {
		$this->fs_copyDirectory($src, $dst);
	} else if ($this->fs_isFile($src)) {
		$this->fs_copyFile($src, $dst);
	} else {
		$this->fs_copySymbolicLink($src, $dst);
	}
};

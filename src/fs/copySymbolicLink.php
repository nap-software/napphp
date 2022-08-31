<?php

return function($src, $dst) {
	$original_link = $this->fs_readSymbolicLink($src);

	$this->fs_createSymbolicLink(
		$dst, $original_link
	);
};

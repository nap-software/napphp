<?php

return function($dest, $target) {
	if (!symlink($target, $dest)) {
		// maybe add is_link() check after creation

		$this->int_raiseError(
			"Failed to create symbolic link '$target' (existing) -> '$dest'."
		);
	}
};

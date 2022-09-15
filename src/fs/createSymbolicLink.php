<?php

return function($dest, $target) {
	if (!@symlink($target, $dest)) {
		$this->int_saveLastPHPError();

		// maybe add is_link() check after creation

		$this->int_raiseError(
			"Failed to create symbolic link '$target' (existing) -> '$dest'."
		);
	}
};

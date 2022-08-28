<?php

return function ($src, $dst) {
	if (!rename($src, $dst)) {
		$this->raiseError(
			"Failed to rename '$src' -> '$dst'."
		);
	}
};

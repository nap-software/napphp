<?php

return function ($src, $dst) {
	if (!@rename($src, $dst)) {
		$this->int_saveLastPHPError();

		$this->int_raiseError(
			"Failed to rename '$src' -> '$dst'."
		);
	}
};

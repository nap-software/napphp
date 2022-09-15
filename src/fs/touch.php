<?php

return function ($path) {
	if (!@touch($path)) {
		$this->int_saveLastPHPError();

		$this->int_raiseError(
			"Failed to touch '$path'."
		);
	}
};

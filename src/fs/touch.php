<?php

return function ($path) {
	if (!touch($path)) {
		$this->raiseError(
			"Failed to touch '$path'."
		);
	}
};

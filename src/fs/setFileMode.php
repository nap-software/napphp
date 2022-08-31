<?php

return function($path, $mode) {
	if (!chmod($path, $mode)) {
		$this->int_raiseError(
			"Failed to set mode '$mode' for path '$path'"
		);
	}
};

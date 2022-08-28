<?php

return function($json) {
	$data = json_decode($json, true);

	if (json_last_error() !== JSON_ERROR_NONE) {
		$this->raiseError(
			"Failed to decode JSON string: ".json_last_error_msg()."."
		);
	}

	return $data;
};

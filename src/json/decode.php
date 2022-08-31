<?php

return function($json, $as_array = true) {
	$data = json_decode($json, $as_array);

	if (json_last_error() !== JSON_ERROR_NONE) {
		$this->int_raiseError(
			"Failed to decode JSON string: ".json_last_error_msg()."."
		);
	}

	return $data;
};

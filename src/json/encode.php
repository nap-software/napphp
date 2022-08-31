<?php

return function($data, $pretty = false) {
	if ($pretty) {
		$json = json_encode($data, JSON_PRETTY_PRINT);
	} else {
		$json = json_encode($data);
	}

	if (json_last_error() !== JSON_ERROR_NONE) {
		$this->int_raiseError(
			"Failed to encode data to JSON: ".json_last_error_msg()."."
		);
	}

	return $json;
};

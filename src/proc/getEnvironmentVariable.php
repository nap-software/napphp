<?php

return function($env_name, $env_fallback = NULL) {
	$env_value = getenv($env_name);

	if ($env_value === false) {
		// only throw error if no fallback value
		// was given
		if ($env_fallback === NULL) {
			$this->int_raiseError(
				"Failed to read environment variable '$env_name'."
			);
		}

		return $env_fallback;
	}

	return $env_value;
};

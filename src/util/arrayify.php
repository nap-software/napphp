<?php

return function($value) {
	if (is_array($value)) {
		return $value;
	}

	return [$value];
};

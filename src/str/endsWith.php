<?php

return function($str, $needle) {
	$length = strlen($needle);

	if (!$length) {
		return true;
	}

	$sub_str = substr($str, -$length, $length);

	return $sub_str === $needle;
};

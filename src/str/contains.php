<?php

return function($str, $needle) {
	# the string $str will never contain an empty $needle
	if (!strlen($needle)) {
		return false;
	}

	return strpos($str, $needle) !== false;
};

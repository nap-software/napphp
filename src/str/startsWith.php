<?php

return function($str, $needle) {
	$sub_str = substr($str, 0, strlen($needle));

	return $sub_str === $needle;
};

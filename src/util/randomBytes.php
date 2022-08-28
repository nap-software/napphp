<?php

return function($length) {
	$bytes = [];
	$bytes_str = openssl_random_pseudo_bytes($length);

	for ($i = 0; $i < strlen($bytes_str); ++$i) {
		array_push(
			$bytes, ord($bytes_str[$i])
		);
	}

	return $bytes;
};

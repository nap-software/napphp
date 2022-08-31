<?php

return function($length) {
	$random_bytes = $this->util_randomBytes($length);
	$identifier = "";

	for ($i = 0; $i < $length; ++$i) {
		$identifier .= substr(dechex($random_bytes[$i]), 0, 1);
	}

	return $identifier;
};

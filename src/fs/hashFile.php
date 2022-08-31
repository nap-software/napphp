<?php

return function($file, $algo) {
	$hash = hash_file($algo, $file);

	if (!$hash) {
		$this->int_raiseError(
			"Failed to hash file (algo='$algo') '$file'."
		);
	}

	return $hash;
};

<?php

return function($file, $algo) {
	$hash = @hash_file($algo, $file);
	$this->int_saveLastPHPError();

	if (!$hash) {
		$this->int_raiseError(
			"Failed to hash file (algo='$algo') '$file'."
		);
	}

	return $hash;
};

<?php

return function($file, $as_array = true) {
	$json = $this->fs_readFileString($file);
	$data = $this->json_decode($json, $as_array);

	return $data;
};

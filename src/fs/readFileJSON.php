<?php

return function($file) {
	$json = $this->fs_readFileString($file);
	$data = $this->json_decode($json);

	return $data;
};

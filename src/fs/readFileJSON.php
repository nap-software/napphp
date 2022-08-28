<?php

return function($file) {
	$json = $this->invoke("fs_readFileString", $file);
	$data = $this->invoke("json_decode", $json);

	return $data;
};

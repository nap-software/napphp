<?php

return function($file, $data) {
	$json = $this->invoke("json_encode", $data);
	$this->invoke("fs_writeFileString", $file, $json);
};

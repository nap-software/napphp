<?php

return function($file, $data) {
	$json = $this->json_encode($data);
	$this->fs_writeFileString($file, $json);
};

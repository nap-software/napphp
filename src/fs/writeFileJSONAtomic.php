<?php

return function($file, $data, $pretty_print = false) {
	$json = $this->json_encode($data, $pretty_print);
	$this->fs_writeFileStringAtomic($file, $json);
};

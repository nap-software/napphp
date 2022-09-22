<?php

return function($file_extension = "", $persistent = false) {
	return $this->tmp_create("file", $file_extension, $persistent);
};

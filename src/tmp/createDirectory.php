<?php

return function($persistent = false) {
	return $this->tmp_create("dir", "", $persistent);
};

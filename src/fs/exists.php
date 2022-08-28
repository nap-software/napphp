<?php

return function($path) {
	clearstatcache();

	if (is_link($path)) return true;

	return is_dir($path) || is_file($path);
};

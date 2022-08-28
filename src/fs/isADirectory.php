<?php

return function ($path) {
	clearstatcache();

	return is_dir($path);
};

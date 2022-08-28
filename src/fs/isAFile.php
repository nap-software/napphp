<?php

return function ($path) {
	clearstatcache();

	return is_file($path);
};

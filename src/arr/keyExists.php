<?php

return function($array, $key) {
	return array_key_exists($key, $array);
};

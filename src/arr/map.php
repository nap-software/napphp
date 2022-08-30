<?php

return function($array, $map_fn) {
	return array_map($map_fn, $array);
};

<?php

return function($array, $filter_fn) {
	return array_values(
		array_filter($array, $filter_fn)
	);
};

<?php

testing::case("should work as expected", function() {

	$array = [1, 2, 3, 4, 5, 6];

	$array_filtered = napphp::arr_filter($array, function($item) {
		return ($item % 2) === 0;
	});

	testing::assert(sizeof($array_filtered) === 3);
	testing::assert($array_filtered[0] === 2);
	testing::assert($array_filtered[1] === 4);
	testing::assert($array_filtered[2] === 6);
});

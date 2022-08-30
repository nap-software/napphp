<?php

testing::case("should work as expected", function() {
	$array = [1, 2, 3];

	$array_mapped = napphp::arr_map($array, function($item) {
		return $item * 3;
	});

	testing::assert($array_mapped[0] === 3);
	testing::assert($array_mapped[1] === 6);
	testing::assert($array_mapped[2] === 9);
});

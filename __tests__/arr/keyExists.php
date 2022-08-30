<?php

testing::case("should work as expected", function() {
	$array = [
		"key" => 1
	];

	testing::assert(napphp::arr_keyExists($array, "key"));
	testing::assert(!napphp::arr_keyExists($array, "key2"));
});

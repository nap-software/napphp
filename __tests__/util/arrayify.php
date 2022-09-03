<?php

testing::case("should convert a string to an array", function() {
	$array = napphp::util_arrayify("abc");

	testing::assert(sizeof($array) === 1);
	testing::assert($array[0] === "abc");
});

testing::case("should not convert an array", function() {
	$array = napphp::util_arrayify(["abc"]);

	testing::assert(sizeof($array) === 1);
	testing::assert($array[0] === "abc");
});

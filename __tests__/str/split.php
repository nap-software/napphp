<?php

testing::case("should work as expected", function() {
	$items = napphp::str_split("a/b/c", "/");

	testing::assert(sizeof($items) === 3);
	testing::assert($items[0] === "a");
	testing::assert($items[1] === "b");
	testing::assert($items[2] === "c");
});

testing::case("should respect the limit parameter", function() {
	$items = napphp::str_split("a/b/c", "/", 2);

	testing::assert(sizeof($items) === 2);
	testing::assert($items[0] === "a");
	testing::assert($items[1] === "b/c");
});

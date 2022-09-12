<?php

testing::case("should work as expected", function() {
	$items = napphp::str_split("a/b/c", "/");

	testing::assert(napphp::str_contains("abc", "a"));
	testing::assert(napphp::str_contains("abc", "bc"));
	testing::assert(napphp::str_contains("abc", "abc"));
	testing::assert(!napphp::str_contains("abc", ""));
});

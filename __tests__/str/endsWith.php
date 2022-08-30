<?php

testing::case("should work as expected", function() {
	testing::assert(napphp::str_endsWith("abc", "c"));
	testing::assert(napphp::str_endsWith("abc", "bc"));
	testing::assert(napphp::str_endsWith("abc", "abc"));
	testing::assert(napphp::str_endsWith("abc", ""));

	testing::assert(!napphp::str_endsWith("abc", "d"));
});

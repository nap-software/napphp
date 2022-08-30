<?php

testing::case("should work as expected", function() {
	testing::assert(napphp::str_startsWith("abc", ""));
	testing::assert(napphp::str_startsWith("abc", "a"));
	testing::assert(napphp::str_startsWith("abc", "ab"));
	testing::assert(napphp::str_startsWith("abc", "abc"));

	testing::assert(!napphp::str_startsWith("abc", "ac"));
});

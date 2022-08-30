<?php

testing::case("should work as expected", function() {
	testing::assert(napphp::str_replace("%abc%", "%", "X") === "XabcX");
});

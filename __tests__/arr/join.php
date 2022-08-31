<?php

testing::case("should work as expected", function() {
	$array = [1, 2, 3, 4, 5, 6];

	testing::assert(napphp::arr_join($array, "/") === "1/2/3/4/5/6");
});

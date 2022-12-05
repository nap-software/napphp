<?php

testing::case("should work", function() {
	testing::assert(
		napphp::importOnce(__DIR__."/../_double_import.php") === "undefined"
	);

	testing::assert(
		napphp::importOnce(__DIR__."/../_double_import.php") === "undefined"
	);
});

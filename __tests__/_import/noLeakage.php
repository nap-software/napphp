<?php

testing::case("should not leak variables", function() {
	napphp::import(__DIR__."/../_leaky_import.php");

	testing::assert(sizeof(get_defined_vars()) === 0);
});

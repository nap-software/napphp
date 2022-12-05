<?php

testing::case("should work", function() {
	$returned_value = napphp::import(__DIR__."/../_leaky_import.php");

	testing::assert(!array_key_exists("leaked_var", get_defined_vars()));
	testing::assert($returned_value === 4040);
});

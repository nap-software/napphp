<?php

if (array_key_exists("napphp_importOnce_test_var", $GLOBALS)) {
	return "defined";
}

$GLOBALS["napphp_importOnce_test_var"] = 1;

return "undefined";

<?php

return function($input, &$result) {
	testing::assert($input === "a");

	$result["b"] = $result["a"] + 1;

	return "c";
};

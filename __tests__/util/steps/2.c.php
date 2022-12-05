<?php

return function($input, &$result) {
	testing::assert($input === "c");

	$result["c"] = $result["b"] + 1;

	return "done";
};

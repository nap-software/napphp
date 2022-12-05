<?php

return function($input, &$result) {
	testing::assert($input === "initial");

	$result["a"] = 1;

	return "a";
};

<?php

testing::case("should work as expected", function() {
	$result = napphp::util_runStepsInSequence(__DIR__."/steps/", "initial");

	testing::assert($result["a"] === 1);
	testing::assert($result["b"] === 2);
	testing::assert($result["c"] === 3);
});

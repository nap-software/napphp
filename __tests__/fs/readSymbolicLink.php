<?php

testing::case("should work as expected", function() {
	$link = napphp::fs_readSymbolicLink(__DIR__."/test-dir/broken-link");

	testing::assert($link === "non-existing");
});

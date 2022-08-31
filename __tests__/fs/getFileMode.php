<?php

testing::case("should work as expected", function() {
	$mode = napphp::fs_getFileMode(
		__DIR__."/test-files/perm-1"
	);

	testing::assert($mode === 0742);
});

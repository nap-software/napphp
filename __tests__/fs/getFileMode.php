<?php

testing::case("should work as expected", function() {
	$mode = napphp::fs_getFileMode(
		__DIR__."/test-files/perm-1"
	);
	var_dump($mode);

	system(
		"stat -c '%A %a %h %U %G %s %y %n' ".escapeshellarg(
			__DIR__."/test-files/perm-1"
		)
	);

	testing::assert($mode === 0742);
});

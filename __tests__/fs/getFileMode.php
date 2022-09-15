<?php

/*

Not possible to test in CI environment because git does not retain
any other permission bits than "executable":
https://stackoverflow.com/a/11231682/2005038

This is by design. While the git data structure can technically store unix mode bits in its trees,
it was found early on in git's history that respecting anything beyond a simple executable
bit ended up being more cumbersome for git's normal use cases (i.e., people storing code
or other shared files in a repository).

testing::case("should work as expected", function() {
	$mode = napphp::fs_getFileMode(
		__DIR__."/test-files/perm-1"
	);

	testing::assert($mode === 0742);
});
*/

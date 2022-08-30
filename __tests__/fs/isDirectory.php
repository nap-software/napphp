<?php

testing::case("should return 'true' for a directory", function() {
	testing::assert(
		napphp::fs_isDirectory(__DIR__."/test-dir")
	);
});

testing::case("should return 'false' for symbolic link to a directory", function() {
	testing::assert(
		!napphp::fs_isDirectory(__DIR__."/test-dir/link-to-a-dir")
	);
});

testing::case("should return 'false' for a file", function() {
	testing::assert(
		!napphp::fs_isDirectory(__DIR__."/test-dir/test-file")
	);
});

testing::case("should return 'false' for a symbolic link to a file", function() {
	testing::assert(
		!napphp::fs_isDirectory(__DIR__."/test-dir/link-to-a-file")
	);
});

testing::case("should return 'false' for a broken symbolic link", function() {
	testing::assert(
		!napphp::fs_isDirectory(__DIR__."/test-dir/broken-link")
	);
});

<?php

testing::case("should work as expected", function() {
	$entries = napphp::fs_scandirRecursive(__DIR__."/test-dir");

	usort($entries, function($a, $b) {
		return strnatcmp($b["relative_path"], $a["relative_path"]);
	});

#	print_r($entries);

	testing::assert(sizeof($entries) === 9);

	testing::assert($entries[0]["basename"] === "test-file");
	testing::assert($entries[0]["path"] === __DIR__."/test-dir/test-file");
	testing::assert($entries[0]["relative_path"] === "test-file");
	testing::assert($entries[0]["type"] === "file");

	testing::assert($entries[4]["basename"] === "file");
	testing::assert($entries[4]["path"] === __DIR__."/test-dir/another-dir/a/b/file");
	testing::assert($entries[4]["relative_path"] === "another-dir/a/b/file");
	testing::assert($entries[4]["type"] === "file");
});

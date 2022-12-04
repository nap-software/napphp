<?php
require __DIR__."/src/index.php";
require __DIR__."/src/index.php";

var_dump(napphp::tmp_createFile());
var_dump(napphp::tmp_createFile());
var_dump(napphp::tmp_createFile());

var_dump(sizeof(napphp::int_getInstanceObject()->int_storeGetKey("tmp_paths")) === 3);

# Create random identifier of length 10
echo napphp::util_randomIdentifier(10)."\n";

echo napphp::fs_hashFile(__FILE__, "sha256")."\n";

napphp::proc_changeWorkingDirectory("/tmp", function() {
	var_dump(getcwd());
});

var_dump(getcwd());

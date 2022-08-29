<?php
$napphp = require __DIR__."/src/__load.php";
$napphp2 = require __DIR__."/src/__load.php";

$napphp::getInstance()->storeSetKey("tmp_dir", "/tmp/");

var_dump($napphp::tmp_createFile());
var_dump($napphp::tmp_createFile());
var_dump($napphp2::tmp_createFile());

var_dump(sizeof($napphp::getInstance()->storeGetKey("tmp_paths")) === 3);

# Create random identifier of length 10
echo $napphp::util_randomIdentifier(10)."\n";

echo $napphp::fs_hashFile(__FILE__, "sha256")."\n";

$napphp::proc_changeWorkingDirectory("/tmp", function() {
	var_dump(getcwd());
});

var_dump(getcwd());

<?php
$napphp = require __DIR__."/src/__load.php";

# Create random identifier of length 10
echo $napphp::util_randomIdentifier(10)."\n";

echo $napphp::fs_hashFile(__FILE__, "sha256")."\n";

$napphp::proc_changeWorkingDirectory("/tmp", function() {
	var_dump(getcwd());
});

var_dump(getcwd());

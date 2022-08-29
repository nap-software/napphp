<?php
$napphp = require __DIR__."/src/__load.php";

# Create random identifier of length 10
echo $napphp::util_randomIdentifier(10)."\n";

<?php

testing::case("should return the same interface if included twice", function() {
	$interface1 = require __DIR__."/../../src/__load.php";
	$interface2 = require __DIR__."/../../src/__load.php";

	testing::assert($interface1 === $interface2);
});

testing::case("should be using the same instance if included twice", function() {
	$interface1 = require __DIR__."/../../src/__load.php";
	$interface2 = require __DIR__."/../../src/__load.php";

	$instance1 = $interface1::int_getInstanceObject();
	$instance2 = $interface2::int_getInstanceObject();

	testing::assert($instance1 === $instance2);
});

testing::case("should be using same instance (__load vs __loadAsClass)", function() {
	$interface = require __DIR__."/../../src/__load.php";

	$instance1 = $interface::int_getInstanceObject();
	$instance2 = napphp::int_getLoadedInstance();

	testing::assert($instance1 === $instance2);
});

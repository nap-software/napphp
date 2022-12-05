<?php

testing::case("should work as expected", function() {
	$lib = napphp::loadLibrary(__DIR__."/lib/");

	testing::assert($lib::a("test") === "testa");
	testing::assert($lib::b("test") === "btest");
});

testing::case("should cache loaded libraries", function() {
	$lib1 = napphp::loadLibrary(__DIR__."/./lib/");
	$lib2 = napphp::loadLibrary(__DIR__."/././lib/");
	$lib3 = napphp::loadLibrary(__DIR__."/././lib/../lib/");

	testing::assert($lib1 === $lib2);
	testing::assert($lib1 === $lib3);
});

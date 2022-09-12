<?php

return function($string, $color, $bright = false) {
	static $map = [
		"black"   => 30,
		"red"     => 31,
		"green"   => 32,
		"yellow"  => 33,
		"blue"    => 34,
		"magenta" => 35,
		"cyan"    => 36,
		"white"   => 37
	];

	if ($this->str_contains($color, ":")) {
		$tmp = $this->str_split($color, ":");

		$color = $tmp[0];
		$mode = $tmp[1];

		if ($mode === "bright") {
			$bright = true;
		}
	}

	$code = $map[$color];

	$ret  = "\033[";
	$ret .= ($bright ? "1" : "0");
	$ret .= ";$code";
	$ret .= "m";
	$ret .= $string;
	$ret .= "\033[0;0m";

	return $ret;
};

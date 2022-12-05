<?php

return function(string $path, $input = NULL) {
	$context = $input;
	$result = [];

	$entries = $this->fs_scandir($path);
	$steps = [];

	foreach ($entries as $entry) {
		if (!napphp::str_endsWith($entry, ".php")) continue;
		// ignore steps that start with _
		if (napphp::str_startsWith($entry, "_")) continue;

		$tmp = napphp::str_split($entry, ".");
		$no = (int)$tmp[0];

		$import = $this->import("$path/$entry");

		// ignore steps that export something that isn't callable
		if (!is_callable($import)) continue;

		$steps["step-$no"] = $import;
	}

	uksort($steps, function($a, $b) {
		$a = (int)substr($a, strlen("step-"));
		$b = (int)substr($b, strlen("step-"));

		return ($a > $b) ? 1 : -1;
	});

	foreach ($steps as $step_name => $step_fn) {
		$context = $step_fn($context, $result);
	}

	return $result;
};

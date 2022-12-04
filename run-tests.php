<?php

require_once __DIR__."/src/index.php";

class NAPSoftwareTestingAssertion extends Exception {
	public function __construct($message) {
		parent::__construct($message);
	}
}

abstract class testing {
	static public function assert($expr) {
		if (!$expr) {
			throw new NAPSoftwareTestingAssertion("Assertion failed.");
		}
	}

	static public function case($label, $fn) {
		$ctx = &$GLOBALS["NAPSoftware_napphp_testing_context"];

		if (!is_array($ctx)) {
			throw new Exception("Bogus use of testing::case().");
		}

		array_push($ctx, [
			"label" => $label,
			"fn"    => $fn
		]);
	}
}

$src_entries = scandir(__DIR__."/__tests__/");
$modules = [];

foreach ($src_entries as $src_entry) {
	if (substr($src_entry, 0, 1) === ".") continue;

	if (is_dir(__DIR__."/__tests__/$src_entry")) {
		array_push($modules, $src_entry);
	}
}

$modules_tests = [];

foreach ($modules as $module) {
	$module_tests[$module] = [];

	$module_functions = array_filter(scandir(__DIR__."/__tests__/$module/"), function($entry) {
		return substr($entry, -4, 4) === ".php";
	});

	foreach ($module_functions as $module_function) {
		$module_function_name = substr($module_function, 0, strlen($module_function) - 4);
		$modules_tests[$module][$module_function_name] = [];

		$GLOBALS["NAPSoftware_napphp_testing_context"] = &$modules_tests[$module][$module_function_name];

		require __DIR__."/__tests__/$module/$module_function";
	}
}

$num_passed_tests = 0;
$num_failed_tests = 0;

foreach ($modules_tests as $module_name => $module_tests) {
	fwrite(STDERR, "* $module_name\n");

	foreach ($module_tests as $function_name => $tests) {
		fwrite(STDERR, "    - $function_name\n");

		foreach ($tests as $test) {
			$label = str_pad($test["label"]." ", 75, ".", STR_PAD_RIGHT);

			fwrite(STDERR, "        :: $label ");

			$fn = $test["fn"];

			try {
				$fn();
				fwrite(STDERR, "\033[0;32mpass\033[0;0m\n");

				++$num_passed_tests;
			} catch (NAPSoftwareTestingAssertion $e) {
				fwrite(STDERR, "\033[0;31mfail\033[0;0m\n");

				++$num_failed_tests;
			} catch (Exception $e) {
				fwrite(STDERR, "\033[0;31merror\033[0;0m\n");

				var_dump($e);
				exit(127);
			}
		}
	}
}

fwrite(STDERR, "Num Tests Passed: $num_passed_tests\n");
fwrite(STDERR, "Num Tests Failed: $num_failed_tests\n");

if ($num_failed_tests > 0) {
	exit(1);
}

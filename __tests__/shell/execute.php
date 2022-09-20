<?php

testing::case("should work (basic usage)", function() {
	$script_output = napphp::shell_execute("ls", [
		"_unitTest" => true
	]);

	$cwd = escapeshellarg(getcwd());

	$expected_script = <<<STR
#!/bin/sh -e
cd $cwd
ls

STR;

	testing::assert(
		$expected_script === $script_output
	);
});

testing::case("should work (basic usage, stdout redir)", function() {
	$script_output = napphp::shell_execute("ls", [
		"_unitTest" => true,
		"stdout" => "/tmp/stdout.log"
	]);

	$cwd = escapeshellarg(getcwd());

	$expected_script = <<<STR
#!/bin/sh -e
cd $cwd
ls 1> '/tmp/stdout.log'

STR;

	testing::assert(
		$expected_script === $script_output
	);
});

testing::case("should work (basic usage, stderr redir)", function() {
	$script_output = napphp::shell_execute("ls", [
		"_unitTest" => true,
		"stderr" => "/tmp/stderr.log"
	]);

	$cwd = escapeshellarg(getcwd());

	$expected_script = <<<STR
#!/bin/sh -e
cd $cwd
ls 2> '/tmp/stderr.log'

STR;

	testing::assert(
		$expected_script === $script_output
	);
});

testing::case("should work (basic usage, stdout=stderr redir)", function() {
	$script_output = napphp::shell_execute("ls", [
		"_unitTest" => true,
		"stdout" => "/tmp/output.log",
		"stderr" => "/tmp/output.log"
	]);

	$cwd = escapeshellarg(getcwd());

	$expected_script = <<<STR
#!/bin/sh -e
cd $cwd
ls 1> '/tmp/output.log' 2>&1

STR;

	testing::assert(
		$expected_script === $script_output
	);
});

testing::case("should work (with args)", function() {
	$script_output = napphp::shell_execute("ls", [
		"_unitTest" => true,
		"args" => [
			"a", "b", "c"
		]
	]);

	$cwd = escapeshellarg(getcwd());

	$expected_script = <<<STR
#!/bin/sh -e
cd $cwd
ls 'a' 'b' 'c'

STR;

	testing::assert(
		$expected_script === $script_output
	);
});

testing::case("should work (with env)", function() {
	$script_output = napphp::shell_execute("ls", [
		"_unitTest" => true,
		"env" => [
			"SOME_VARIABLE" => "SOME_VALUE"
		]
	]);

	$cwd = escapeshellarg(getcwd());

	$expected_script = <<<STR
#!/bin/sh -e
cd $cwd
SOME_VARIABLE='SOME_VALUE' ls

STR;

	testing::assert(
		$expected_script === $script_output
	);
});

testing::case("should work (with cwd)", function() {
	$script_output = napphp::shell_execute("ls", [
		"_unitTest" => true,
		"cwd" => "/tmp/"
	]);

	$expected_script = <<<STR
#!/bin/sh -e
cd '/tmp/'
ls

STR;

	testing::assert(
		$expected_script === $script_output
	);
});

testing::case("should work (with args, cwd and env)", function() {
	$script_output = napphp::shell_execute("ls", [
		"_unitTest" => true,
		"cwd" => "/tmp/",
		"args" => [
			"a", "b", "c"
		],
		"env" => [
			"SOME_VARIABLE" => "SOME_VALUE"
		]
	]);

	$expected_script = <<<STR
#!/bin/sh -e
cd '/tmp/'
SOME_VARIABLE='SOME_VALUE' ls 'a' 'b' 'c'

STR;

	testing::assert(
		$expected_script === $script_output
	);
});

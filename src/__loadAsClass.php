<?php

abstract class napphp {
	static private $_napphp = NULL;

	static public function set($key, $value) {
		return self::int_getInstanceObject()->int_storeSetKey($key, $value);
	}

	static public function get($key) {
		return self::int_getInstanceObject()->int_storeGetKey($key);
	}

	static public function __callStatic($fn_name, $fn_args) {
		if (self::$_napphp === NULL) {
			self::$_napphp = require __DIR__."/__load.php";
		}

		return self::$_napphp->int_getInstanceObject()->invoke(
			$fn_name,
			...$fn_args
		);
	}
}

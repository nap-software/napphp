<?php

abstract class napphp {
	static private $_napphp = NULL;

	static private function int_getLoadedInstance() {
		if (self::$_napphp === NULL) {
			self::$_napphp = require __DIR__."/__load.php";
		}

		return self::$_napphp->int_getInstanceObject();
	}

	static public function set($key, $value) {
		$napphp_instance = self::int_getLoadedInstance();

		return $napphp_instance->int_storeSetKey($key, $value);
	}

	static public function get($key) {
		$napphp_instance = self::int_getLoadedInstance();

		return $napphp_instance->int_storeGetKey($key);
	}

	static public function __callStatic($fn_name, $fn_args) {
		$napphp_instance = self::int_getLoadedInstance();

		return $napphp_instance->invoke(
			$fn_name,
			...$fn_args
		);
	}
}

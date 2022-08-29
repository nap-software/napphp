<?php

abstract class napphp {
	static private $_napphp = NULL;

	static public function __callStatic($fn_name, $fn_args) {
		if (self::$_napphp === NULL) {
			self::$_napphp = require __DIR__."/__load.php";
		}

		return self::$_napphp->getInstance()->invoke(
			$fn_name,
			...$fn_args
		);
	}
}

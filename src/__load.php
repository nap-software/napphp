<?php

return new class {
	private $_warnings = [];
	private $_store = [];

	public function storeSetKey($key, $value) {
		$this->_store[$key] = $value;
	}

	public function storeKeyExists($key) {
		return array_key_exists($key, $this->_store);
	}

	public function storeGetKey($key) {
		if ($this->storeKeyExists($key)) {
			return $this->_store[$key];
		}

		$this->raiseError(
			"Unknown store key '$key'."
		);
	}

	public function addWarning($message) {
		array_push($this->_warnings, $message);
	}

	public function raiseError($message) {
		throw new Exception("napphp: $message");
	}

	public function invoke() {
		$args = func_get_args();
		$fn_name = array_shift($args);

		return self::invokeStatically($fn_name, $args);
	}

	static private $_instance = NULL;
	static private $_loaded_functions = [];

	static public function getInstance() {
		if (!self::$_instance) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	static public function invokeStatically($fn_name, $fn_args) {
		$fn_bound = NULL;

		if (array_key_exists($fn_name, self::$_loaded_functions)) {
			$fn_bound = self::$_loaded_functions[$fn_name];
		} else {
			$fn_path = __DIR__."/".str_replace("_", "/", $fn_name).".php";

			if (!is_file($fn_path)) {
				throw new Exception("Unable to find function '$fn_name'.");
			}

			$fn = require $fn_path;
			$fn_bound = Closure::bind($fn, self::getInstance());

			self::$_loaded_functions[$fn_name] = $fn_bound;
		}

		return call_user_func_array($fn_bound, $fn_args);
	}

	static public function __callStatic($fn_name, $fn_args) {
		return self::invokeStatically($fn_name, $fn_args);
	}
};

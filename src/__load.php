<?php

/**
 * Return an anonymous class representing napphp.
 * Usage:
 * 
 * $napphp = require "__load.php";
 * 
 * $napphp::util_randomIdentifier(10);
 */
if (!array_key_exists("NAPSoftware_napphp", $GLOBALS)) {

	// define the class only *once* in a program's lifecycle
	$GLOBALS["NAPSoftware_napphp"] = new class {
		/**
		 *  ##################################
		 *  # Instance variables and methods #
		 *  ##################################
		 */
		private $_warnings = [];
		private $_store = [];

		// used internally
		public function int_raiseError($message) {
			throw new Exception("napphp: $message");
		}

		// used internally
		public function int_storeSetKey($key, $value) {
			$this->_store[$key] = $value;
		}

		// used internally
		public function int_storeKeyExists($key) {
			return array_key_exists($key, $this->_store);
		}

		// used internally
		public function int_storeGetKey($key) {
			if ($this->int_storeKeyExists($key)) {
				return $this->_store[$key];
			}

			$this->int_raiseError(
				"Unknown store key '$key'."
			);
		}

		public function addWarning($message) {
			array_push($this->_warnings, $message);
		}

		// used internally
		public function invoke() {
			$args = func_get_args();
			$fn_name = array_shift($args);

			return self::int_invokeStatic($fn_name, $args);
		}

		public function __call($fn_name, $fn_args) {
			return $this->invoke($fn_name, ...$fn_args);
		}

		/**
		 *  ################################
		 *  # Static variables and methods #
		 *  ################################
		 */
		static private $_instance = NULL;
		static private $_loaded_functions = [];

		// used internally
		static public function int_getInstanceObject() {
			if (!self::$_instance) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		// used internally
		static public function int_invokeStatic($fn_name, $fn_args) {
			$fn_bound = NULL;

			if (array_key_exists($fn_name, self::$_loaded_functions)) {
				$fn_bound = self::$_loaded_functions[$fn_name];
			} else {
				$fn_path = __DIR__."/".str_replace("_", "/", $fn_name).".php";

				if (!is_file($fn_path)) {
					throw new Exception("Unable to find function '$fn_name'.");
				}

				$fn = require $fn_path;
				$fn_bound = Closure::bind($fn, self::int_getInstanceObject());

				self::$_loaded_functions[$fn_name] = $fn_bound;
			}

			return call_user_func_array($fn_bound, $fn_args);
		}

		static public function set($key, $value) {
			$napphp_instance = self::int_getInstanceObject();

			return $napphp_instance->int_storeSetKey($key, $value);
		}

		static public function get($key) {
			$napphp_instance = self::int_getInstanceObject();

			return $napphp_instance->int_storeGetKey($key);
		}

		static public function __callStatic($fn_name, $fn_args) {
			return self::int_invokeStatic($fn_name, $fn_args);
		}
	};

}

return $GLOBALS["NAPSoftware_napphp"];

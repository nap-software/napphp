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
		private $_last_php_error = NULL;

		// used internally
		public function int_clearLastPHPError() {
			$this->_last_php_error = NULL;
		}

		// used internally
		public function int_saveLastPHPError() {
			$this->_last_php_error = error_get_last();
		}

		// used internally
		public function int_raiseError($message) {
			$last_error_message = "";

			if ($this->_last_php_error !== NULL) {
				$last_error_message .= "\n\nInformation about last PHP error:\n\n";
				$last_error_message .= "    message = ".$this->_last_php_error["message"]."\n";
				$last_error_message .= "    file    = ".$this->_last_php_error["file"]."\n";
				$last_error_message .= "    line    = ".$this->_last_php_error["line"]."\n\n";
			}

			throw new Exception(
				"napphp: '$message'$last_error_message"
			);
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

		// used internally
		public function int_raiseWarning($message) {
			$lines = explode("\n", $message);
			$formatted_lines = array_map(function($line) {
				return "!!!! nap-software/napphp warning: $line";
			}, $lines);
			$formatted_message = implode("\n", $formatted_lines);

			if (defined("STDERR")) {
				fwrite(STDERR, "$formatted_message\n");
			} else {
				echo "$formatted_message\n";
			}
		}

		// used internally
		public function int_raiseDeprecationWarning($old_fn, $new_fn = NULL) {
			$message = "This function ($old_fn) has been deprecated.\n";

			if ($new_fn !== NULL) {
				$message .= "Please use '$new_fn' instead.";
			}

			$this->int_raiseWarning($message);
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

			$instance = self::int_getInstanceObject();

			# clear last php error when invoking any library function
			$instance->int_clearLastPHPError();

			$result = call_user_func_array($fn_bound, $fn_args);

			# clear last php error after invoking any library function
			$instance->int_clearLastPHPError();

			return $result;
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

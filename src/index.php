<?php
declare(ticks=1);

namespace napphp {
	if (!class_exists("napphp\\Exception")) {
		class Exception extends \Exception {
			public function __construct($msg) {
				parent::__construct("napphp: $msg");
			}
		}
	}
}

namespace {
	// define the class only *once* in a program's lifecycle
	if (!class_exists("napphp")) {
		class napphpImplementation {
			public function __construct() {
				if (array_key_exists("nap-software_napphp_defined", $GLOBALS)) {
					throw new napphp\Exception("napphpImplementation should only be instantiated **once**.");
				}

				$GLOBALS["nap-software_napphp_defined"] = 1;
			}

			private $_store = [];

			public function int_storeSetKey($key, $value) {
				$this->_store[$key] = $value;
			}

			public function int_storeKeyExists($key) {
				return array_key_exists($key, $this->_store);
			}

			public function int_storeGetKey($key) {
				if ($this->int_storeKeyExists($key)) {
					return $this->_store[$key];
				}

				throw new napphp\Exception("Unknown store key '$key'.");
			}

			private $_last_php_error = NULL;

			public function int_clearLastPHPError() {
				$this->_last_php_error = NULL;
			}

			public function int_saveLastPHPError() {
				$this->_last_php_error = error_get_last();
			}

			public function int_raiseError($message) {
				$last_error_message = "";

				if ($this->_last_php_error !== NULL) {
					$last_error_message .= "\n\nInformation about last PHP error:\n\n";
					$last_error_message .= "    message = ".$this->_last_php_error["message"]."\n";
					$last_error_message .= "    file    = ".$this->_last_php_error["file"]."\n";
					$last_error_message .= "    line    = ".$this->_last_php_error["line"]."\n\n";
				}

				throw new napphp\Exception("$message$last_error_message");
			}

			public function __call($fn_name, $fn_args) {
				return napphp::int_invokeStatic($fn_name, $fn_args);
			}
		}

		abstract class napphp {
			static private $_instance = NULL;
			static private $_loaded_functions = [];

			static public function int_getInstanceObject() {
				if (!self::$_instance) {
					self::$_instance = new napphpImplementation();
				}

				return self::$_instance;
			}

			static public function int_invokeStatic($fn_name, $fn_args) {
				$instance = self::int_getInstanceObject();

				if (!array_key_exists($fn_name, self::$_loaded_functions)) {
					$fn_path = __DIR__."/".str_replace("_", "/", $fn_name).".php";

					if (!is_file($fn_path)) {
						throw new napphp\Exception(
							"Unable to locate function '$fn_name'."
						);
					}

					$tmp = require $fn_path;

					self::$_loaded_functions[$fn_name] = Closure::bind($tmp, $instance);
				}

				$fn = self::$_loaded_functions[$fn_name];

				// clear last php error before invoking any library function
				$instance->int_clearLastPHPError();

				$result = call_user_func_array($fn, $fn_args);

				// clear last php error after invoking any library function
				$instance->int_clearLastPHPError();

				return $result;
			}

			static public function __callStatic($fn_name, $fn_args) {
				return self::int_invokeStatic($fn_name, $fn_args);
			}
		}

		// clean up handlers
		// it is safe to call tmp_cleanup() multiple times.
		pcntl_signal(SIGTERM, function() { napphp::tmp_cleanup(); });
		pcntl_signal(SIGINT, function() { napphp::tmp_cleanup(); });
		register_shutdown_function(function() { napphp::tmp_cleanup(); });

		set_error_handler(function($errno, $errstr, $errfile, $errline) {
			// ignore errors that were silenced with '@'
			if (!(error_reporting() & $errno)) return true;

			throw new napphp\Exception("PHP-Error '$errstr' in file $errfile (line $errline)");
		});
	}
}

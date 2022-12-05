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

			public function import($file) {
				return napphp::import($file);
			}

			public function importOnce($file) {
				return napphp::importOnce($file);
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

			/**
			 * Imports a file without leaking variables into the current scope.
			 */
			static private $_imported_files = [];

			static public function import($file) {
				$load_file = function($__napphp_file_to_import) {
					return require $__napphp_file_to_import;
				};

				return $load_file($file);
			}

			static public function importOnce($file) {
				// get the realpath so we can use it as a cache key
				$realpath = realpath($file);

				if ($realpath === false) {
					throw new napphp\Exception("Unable to resolve path '$file'.");
				}

				if (!array_key_exists($realpath, self::$_imported_files)) {
					self::$_imported_files[$realpath] = self::import($file);
				}

				return self::$_imported_files[$realpath];
			}

			/**
			 * Load an external library
			 */
			static private $_loaded_libraries = [];

			static public function loadLibrary($path) {
				// get the realpath so we can use it as a cache key
				$realpath = realpath($path);

				if ($realpath === false) {
					throw new napphp\Exception("Unable to resolve path '$path'.");
				}

				if (!array_key_exists($realpath, self::$_loaded_libraries)) {
					$library = [];

					foreach (self::fs_scandir($path) as $entry) {
						if (substr($entry, 0, 1) === ".") continue;
						if (substr($entry, 0, 1) === "_") continue;
						if (substr($entry, -4, 4) !== ".php") continue;

						$library[
							substr($entry, 0, strlen($entry) - 4)
						] = self::import("$path/$entry");
					}

					$cls = new class() {
						static private $_library = NULL;

						static public function __napphpInitLibrary($library) {
							if (self::$_library !== NULL) return;

							self::$_library = $library;
						}

						static public function __callStatic($fn_name, $fn_args) {
							if (!array_key_exists($fn_name, self::$_library)) {
								throw new napphp\Exception(
									"Unable to locate '$fn_name' in library object."
								);
							}

							return call_user_func_array(
								self::$_library[$fn_name], $fn_args
							);
						}
					};

					$cls::__napphpInitLibrary($library);

					self::$_loaded_libraries[$realpath] = $cls;
				}

				return self::$_loaded_libraries[$realpath];
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

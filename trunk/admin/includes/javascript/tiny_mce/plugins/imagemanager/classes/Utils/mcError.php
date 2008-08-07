<?php
/**
 * mcError.php
 *
 * @package MCFileManager.utils
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

// Define it on PHP4
if (!defined(E_STRICT))
	define('E_STRICT', 2048);

/**
 * This class handles Error messages.
 *
 * @package MCFileManager.utils
 */
class mcError {
	var $log;
	var $logfile;

	function mcError($log=false, $logfile="./error.log") {
		$this->log = $log;
		$this->logfile = $logfile;
	}

	function handleError($errno, $errstr, $errfile, $errline, $errcontext) {
		$error = array();

		$error['title'] = "";
		$error['break'] = false;
		$error['errstr'] = $errstr;
		$error['errfile'] = $errfile;
		$error['errline'] = $errline;
		$error['errcontext'] = $errcontext;

		switch ($errno) {
			case E_USER_ERROR:
				$error['title'] = "Fatal Error";
				$error['break'] = true;
			break;

			case E_USER_NOTICE:
				$error['title'] = "Notice";
				$error['break'] = false;
			break;

			case E_USER_WARNING:
				$error['title'] = "Warning";
				$error['break'] = true;
			break;

			case E_PARSE:
				$error['title'] = "PHP Parse Error";
				$error['break'] = true;
			break;

			case E_ERROR:
				$error['title'] = "PHP Error";
				$error['break'] = true;
			break;

			case E_CORE_ERROR:
				$error['title'] = "PHP Error : Core Error";
				$error['break'] = true;
			break;

			case E_CORE_WARNING:
				$error['title'] = "PHP Error : Core Warning";
				$error['break'] = true;
			break;

			case E_COMPILE_ERROR:
				$error['title'] = "PHP Error : Compile Error";
				$error['break'] = true;
			break;

			case E_COMPILE_WARNING:
				$error['title'] = "PHP Error : Compile Warning";
				$error['break'] = true;
			break;

			case E_NOTICE:
				$error['title'] = "PHP Notice";
				$error['break'] = false;
			break;

			case E_STRICT:
				$error['title'] = "PHP Strict";
				$error['break'] = false;
			break;
		}

		if ($this->log)
			$this->logError($error);

		return $error;
	}

	function logError($error) {
		// Ignore all errors
		$fh = @fopen($this->logfile, "a+");

		if ($fh) {
			$errorMessage = "[" . date("Y-m-d H:i:s", time()) . "] ". $error['title'] . "\n".
							"Error message: ". $error['errstr'] ."\n".
							"Error on line ". $error['errline'] ." in ". $error['errfile'] ."\n\n";

			@fwrite($fh, $errorMessage);
			@fclose($fh);
		}
	}
}

?>
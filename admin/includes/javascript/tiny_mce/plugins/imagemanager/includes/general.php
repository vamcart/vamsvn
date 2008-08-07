<?php
/**
 * general.php
 *
 * @package MCImageManager.includes
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

// * * Get site root absolute path
global $rootPath, $mcLanguage;
$rootPath = dirname(dirname(__FILE__));
$mcLanguage = array();

@session_start();

// Define error levels
define('FATAL', E_USER_ERROR);
define('ERROR', E_USER_WARNING);
define('WARNING', E_USER_NOTICE);

error_reporting(E_ALL ^ E_NOTICE);

require_once(getAbsPath("../classes/Savant2.php"));
require_once(getAbsPath("../classes/Utils/mcError.php"));
require_once(getAbsPath("../classes/Utils/LanguageReader.php"));
require_once(getAbsPath("../file_types.php"));

require_once(getAbsPath("../classes/FileSystems/FileFactory.php"));
require_once(getAbsPath("../classes/Authenticators/BaseAuthenticator.php"));

require_once(getAbsPath("default_config.php"));
require_once(getAbsPath("../config.php"));
require_once(getAbsPath("../classes/Utils/" . $mcImageManagerConfig['thumbnail'] . ".php"));

// Grab config from session if test mode is enabled
if (realpath("testcases") != "" && isset($_SESSION['mc_imagemanager_config_file']))
	require_once($_SESSION['mc_imagemanager_config_file']);
else
	require_once(getAbsPath("../config.php"));

// Switch error reporting level on debug
if ($mcImageManagerConfig['general.debug'])
	error_reporting(E_ALL);
else
	error_reporting(E_ALL ^ E_NOTICE);

$mcImageManagerErrorHandler = new mcError($mcImageManagerConfig['general.error_log'] != "", addTrailingSlash(realpath(".")) . $mcImageManagerConfig['general.error_log']);
set_error_handler("mcErrorHandler");

// Include LocalFileSystem
if (isset($mcImageManagerConfig['filesystem']) && $mcImageManagerConfig['filesystem'] == "LocalFileImpl")
	require_once(getAbsPath("../classes/FileSystems/LocalFileImpl.php"));

// Include authenticator
if (isset($mcImageManagerConfig['authenticator']) && $mcImageManagerConfig['authenticator'] == "SessionAuthenticatorImpl")
	require_once(getAbsPath("../classes/Authenticators/SessionAuthenticatorImpl.php"));

/**
 * Redirects to the login page if the user isn't logged in.
 * This will also setup the path and rootpath config variables based on session and input parameters.
 *
 * @param Array $config Name/Value array of config items.
 */
function verifyAccess(&$config) {
	// Store away rootpaths
	$rootPaths =& getRootPaths($config["filesystem.rootpath"], false);
	$hasVariables = strpos($config["filesystem.rootpath"], '${') !== false;
	$auth = null;

	// Setup custom data
	$customData = getRequestParam("custom_data");
	if ($customData)
		$_SESSION['mc_custom_data'] = $customData;

	// Execute authenticator
	if (isset($config['authenticator'])) {
		$auth =& new $config['authenticator']();
		$auth->init($config);
	}

	// User isn't logged in, redirect to login page
	if (!is_null($auth) && !$auth->isLoggedIn()) {
		header("Location: " . $config['general.login_page'] . "?" . $_SERVER['QUERY_STRING']);
		die;
	}

	// Verify rootpaths specified by authenticator but not when they contain variables
	$newRootPaths =& getRootPaths($config["filesystem.rootpath"]);
	if (!$hasVariables) {
		foreach ($newRootPaths as $newRootPath) {
			if (!isChildPath($rootPaths, $newRootPath)) {
				$msg = "The Authenticator specified a invalid root path " . $newRootPath . ", root paths must be inside the paths returned by the root config.<br /><br /><strong>Valid root paths are:</strong><br />" . implode("<br />", $rootPaths);
				trigger_error($msg, FATAL);
			}
		}
	}

	$rootPaths =& $newRootPaths;

	// Override root path with JS, must be inside authenicator rootpath
	$inputPath = getRequestParam("initial_rootpath");
	if ($inputPath) {
		if ($inputPath != "mce_clear")
			$_SESSION["mc_javascript_rootpath"] = $inputPath;
		else
			unset($_SESSION["mc_javascript_rootpath"]);
	}

	// Use session rootpath, if it's inside authenticator rootpath
	if (isset($_SESSION["mc_javascript_rootpath"])) {
		if (strpos($_SESSION["mc_javascript_rootpath"], '${') !== false)
			trigger_error("Paths containing variables in JavaScript paths is not supported becurse of possible security issues.", FATAL);

		$newRootPaths =& getRootPaths($_SESSION["mc_javascript_rootpath"]);

		foreach ($newRootPaths as $newRootPath) {
			if (!isChildPath($rootPaths, $newRootPath)) {
				$msg = "The Javascipt specified a invalid root path " . $newRootPath . ", root paths must be inside the paths returned by the root config and Authenticator.<br /><br /><strong>Valid root paths are:</strong><br />" . implode("<br />", $rootPaths);
				trigger_error($msg, FATAL);
			}
		}

		// Override rootpaths with JS rootpaths
		$rootPaths =& $newRootPaths;
		$config["filesystem.rootpath"] = $_SESSION["mc_javascript_rootpath"];
	}

	// Override path with JS, must be inside authenicator rootpath
	$inputPath = getRequestParam("initial_path");
	if ($inputPath) {
		if ($inputPath != "mce_clear")
			$_SESSION["mc_javascript_path"] = $inputPath;
		else
			unset($_SESSION["mc_javascript_path"]);
	}

	// Use session path and matching root, if it's inside Authenticator rootpath
	if (isset($_SESSION["mc_javascript_path"])) {
		if (strpos($_SESSION["mc_javascript_path"], '${') !== false)
			trigger_error("Paths containing variables in JavaScript paths is not supported becurse of possible security issues.", FATAL);

		$jsPath = resolvePath($_SESSION["mc_javascript_path"], false);
		$rootPath = isChildPath($rootPaths, $jsPath);

		if ($rootPath && $jsPath != "" && file_exists($jsPath)) {
			$config["filesystem.path"] = $jsPath;
			$config["filesystem.rootpath"] = $rootPath;
		}
	}

	// Grab path from session
	if (getRequestParam("remember", "") == "false")
		unset($_SESSION['mc_imagemanager_lastpath']);

	if (isset($_SESSION['mc_imagemanager_lastpath'])) {
		$config["filesystem.path"] = resolvePath($config["filesystem.path"], false);
		$inputPath = $_SESSION['mc_imagemanager_lastpath'];
		$rootPath = isChildPath($rootPaths, $inputPath);

		if ($rootPath && $inputPath && file_exists($inputPath) && ($config["filesystem.path"] == "" || isChildPath($config["filesystem.path"], $inputPath))) {
			$config["filesystem.path"] = $inputPath;
			$config["filesystem.rootpath"] = $rootPath;
		}
	}

	// Override path and matching root path by the specified input path
	$inputPath = removeTrailingSlash(resolvePath(getRequestParam("path", ""), false));
	$rootPath = isChildPath($rootPaths, $inputPath);
	if ($rootPath) {
		$config["filesystem.path"] = $inputPath;
		$config["filesystem.rootpath"] = $rootPath;
	}

	// Find root path based on path
	if ($config["filesystem.path"] != "") {
		$config["filesystem.path"] = resolvePath($config["filesystem.path"], false);
		$rootPath = isChildPath($rootPaths, $config["filesystem.path"]);

		if ($rootPath)
			$config["filesystem.rootpath"] = $rootPath;
	}

	setupPathFromURL($rootPaths, $config);

	// Force UTF-8
	header('Content-Type: text/html; charset=utf-8');
	loadLanguagePack($config);

	// Set rootpath to _unknown_root_path_
	if (count(array_keys(getRootPaths($config["filesystem.rootpath"]))) > 1 || getRequestParam("path", "") == "_mc_root_path_")
		$config["filesystem.rootpath"] = "_mc_unknown_root_path_";

	// If only renamed rootpath
	if (strpos($config["filesystem.rootpath"], '=') > 0) {
		$rootPaths =& getRootPaths($config["filesystem.rootpath"]);
		$keys = array_keys($rootPaths);
		$config["filesystem.rootpath"] = $rootPaths[$keys[0]];
		$config["filesystem.rootname"] = $keys[0];
		return;
	}

	// Make sure that the path is a resolved path
	$config["filesystem.path"] = resolvePath($config["filesystem.path"], false);

	// Make sure that root path is a resolved path
	if ($config["filesystem.rootpath"] != "_mc_unknown_root_path_")
		$config["filesystem.rootpath"] = resolvePath($config["filesystem.rootpath"]);

	// Inject Array of rootpaths
	$config["filesystem.rootpaths"] = $rootPaths;

	// Setup global rootname, skip it if it's only one root
	$config["filesystem.rootname"] = "";
	$keys = array_keys($rootPaths);
	if (count($keys) > 1 || $keys[0] != basename($rootPaths[$keys[0]])) {
		foreach ($rootPaths as $rootName => $rootPath) {
			if ($rootPath == $config["filesystem.rootpath"]) {
				$config["filesystem.rootname"] = $rootName;
				break;
			}
		}
	}

//	die("Root path:" . $config["filesystem.rootpath"] . ", Path: " . $config["filesystem.path"]);
}

/**
 * Sets the filesystem.path option value based on the url input value.
 *
 * @param $config Config name/value array to modify.
 */
function setupPathFromURL(&$root_paths, &$config) {
	$url = getRequestParam("url", "");
	$wwwRoot = getWWWRoot($config);

	if ($url != "") {
		// Is absolute URL
		if (strpos($url, $config['preview.urlprefix']) === 0) {
			// Trim away prefix
			$path = substr($url, strlen($config['preview.urlprefix']) - 1);
			$path = toUnixPath($wwwRoot . $path);

			$rootPath = isChildPath($root_paths, $path);
			if ($rootPath) {
				// Try file
				if (file_exists($path)) {
					$config['filesystem.path'] = $path;
					$config['filesystem.rootpath'] = $rootPath;
				} else {
					// Try the dir if the file wasn't found
					$path = dirname($path);

					if (file_exists($path)) {
						$config['filesystem.path'] = $path;
						$config['filesystem.rootpath'] = $rootPath;
					}
				}

				return;
			}
		}

		// Is site absolute URL
		$path = toUnixPath($wwwRoot . $url);
		$rootPath = isChildPath($root_paths, $path);
		if ($rootPath) {
			// Try file
			if (file_exists($path)) {
				$config["filesystem.path"] = $path;
				$config['filesystem.rootpath'] = $rootPath;
			} else {
				// Try the dir if the file wasn't found
				$path = dirname($path);

				if (file_exists($path)) {
					$config['filesystem.path'] = $path;
					$config['filesystem.rootpath'] = $rootPath;
				}
			}

			return;
		}
	}
}

/**
 * Parses a root path string and returns a name/value array.
 *
 * @param $path Path to parse root paths from.
 * @param $verify Optional verify bool, set to true by default.
 * @return Name/Value array with rootpaths.
 */
function getRootPaths($path, $verify = true) {
	$paths = explode(';', $path);
	$outputPaths = array();

	foreach ($paths as $path) {
		$nameValue = explode('=', $path);

		if (count($nameValue) > 1)
			$path = $nameValue[1];
		else {
			$path = $nameValue[0];
			$nameValue[0] = basename($nameValue[0]); // Remove whole path
		}

		$newPath = toUnixPath(realpath(toOSPath($path)));

		if ($newPath)
			$outputPaths[$nameValue[0]] = $newPath;
		else {
			if ($verify)
				trigger_error('Could not resolve path "' . $path . '", maybe it doesn\'t exist or the path to it is incorrect.', FATAL);

			$outputPaths[$nameValue[0]] = toUnixPath($path);
		}
	}

	return $outputPaths;
}

/**
 * Returns a config parameter by name of the default value if it wasn't found.
 *
 * @param $name Name of param to retrive.
 * @return Config value.
 */
function getConfigParam(&$config, $name, $default_value = false) {
	if (!isset($name))
		return $default_value;

	return $config[$name];
}

/**
 * Redirects to the login page if the user isn't logged in.
 *
 * @param Array $config Name/Value array of config items.
 */
function addFileEventListeners(&$file_factory) {
	global $mcImageManagerConfig;

	// Include file listeners
	if (isset($mcImageManagerConfig['filesystem.file_event_listeners'])) {
		 $listenerNames = explode(",", $mcImageManagerConfig['filesystem.file_event_listeners']);

		 foreach ($listenerNames as $listenerName) {
			if ($listenerName != "") {
				$listener =& new $listenerName();

				$listener->init($mcImageManagerConfig);

				$file_factory->addFileEventListener($listener);
			}
		 }
	}
}

/**
 * Adds no cache headers to HTTP response.
 */
function addNoCacheHeaders() {
	// Date in the past
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

	// always modified
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

	// HTTP/1.1
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);

	// HTTP/1.0
	header("Pragma: no-cache");
}

/**
 * Returns a absolute path from a virtual path.
 *
 * @param String $path Virtual path to map.
 * @return String Returns a absolute path from a virtual path.
 */
function getAbsPath($path) {
	global $rootPath;

	if (substr($path, 0, 1) == "/")
		return toOSPath($rootPath . $path);

	return toOSPath(dirname(__FILE__) . "/" . $path);
}

/**
 * Returns an request value by name without magic quoting.
 *
 * @param String $name Name of parameter to get.
 * @param String $default_value Default value to return if value not found.
 * @return String request value by name without magic quoting or default value.
 */
function getRequestParam($name, $default_value = false) {
	if (!isset($_REQUEST[$name]))
		return $default_value;

	if (!isset($_GLOBALS['magic_quotes_gpc']))
		$_GLOBALS['magic_quotes_gpc'] = ini_get("magic_quotes_gpc");

	if (isset($_GLOBALS['magic_quotes_gpc'])) {
		if (is_array($_REQUEST[$name])) {
			$newarray = array();

			foreach($_REQUEST[$name] as $name => $value)
				$newarray[stripslashes($name)] = stripslashes($value);

			return $newarray;
		}
		return stripslashes($_REQUEST[$name]);
	}

	return $_REQUEST[$name];
}

/**
 * Loads and initializes the mcLanguage array based on config.
 *
 * @param Array $config Name/Value config array.
 */
function loadLanguagePack($config) {
	global $mcImageManagerConfig, $mcLanguage;

	$language = $config['general.language'];
	$languageDefault = "en";

	$langReader =& new LanguageReader();
	$langReader->loadXML(realpath("langs/". $language .".xml"));

	$foreignLanguage = $langReader->_items;

	// Load default language and merge arrays
	if ($language != $languageDefault) {
		$defaultLangReader =& new LanguageReader();
		$defaultLangReader->loadXML(realpath("langs/". $languageDefault .".xml"));
		$defaultLanguage = $defaultLangReader->_items;

		// Merge arrays
		foreach ($foreignLanguage as $ftarget => $fvalue) {
			foreach($fvalue as $iname => $ivalue)
				$defaultLanguage[$ftarget][$iname] = $ivalue;
		}

		$lang = isset($defaultLanguage[getScriptName()]) ? $defaultLanguage[getScriptName()] : array();
		$commonLang = isset($defaultLanguage["common"]) ? $defaultLanguage["common"] : array();
	} else {
		$lang = isset($foreignLanguage[getScriptName()]) ? $foreignLanguage[getScriptName()] : array();
		$commonLang = isset($foreignLanguage["common"]) ? $foreignLanguage["common"] : array();
	}

	$mcLanguage = array_merge($commonLang, $lang);
}

/**
 * Renders a page to output stream using smarty template and data.
 *
 * @param String $template Template filename to be used for rendering.
 * @param Array $data Array of data items to be appended to smarty.
 * @param Array $config Optional config array.
 */
function renderPage($template, $data, $config = -1) {
	global $mcImageManagerConfig, $rootPath, $mcLanguage;

	// Savant Integration
	$savant = & new Savant2();

	// Assign smarty items
	$savant->assign('langCode', $mcImageManagerConfig['general.language']);
	$savant->assign('theme', $mcImageManagerConfig['general.theme']);
	$savant->assign('data', $data);
	$savant->assign('lang', $mcLanguage);
	$savant->addPath("template", "themes/" . $mcImageManagerConfig['general.theme']);

	// Display Data through Smarty
	$err = $savant->display($template);
	if ($savant->isError($err))
		echo "There was an error displaying the template:<br />[" . $err->code . "] " . $err->text . ".<br />";

	die;
}

/**
 * Removes illegal characters from a filename and returns the cleaned one.
 *
 * @param String $filename Name of file to check
 * @return String a filename containing only allowed characters
 */
function cleanFilename($filename) {
	$charLookup = array(
		"å" => "a", 
		"ä" => "a", 
		"ö" => "o",
		"Å" => "a", 
		"Ä" => "a", 
		"Ö" => "o",
		" " => "_"
	);

	$filename = strtolower($filename);
	$filename = strtr($filename, $charLookup);
	$strlen = strlen($filename);

	for ($i=0;$i<=$strlen;$i++) {
		$chr = substr($filename, $i, 1);
		$ord = ord($chr);

		if ( ( ($ord >= ord('0')) AND ($ord <= ord('9')) ) OR ( ($ord >= ord('a')) AND ($ord <= ord('z')) ) OR (ord('_') == $ord ) )
			$outstr .= $chr;
	}

	return $outstr;
}

/**
 * Checks for an already existing file with the same name, and
 * renames the active file to a unique name if one is found.
 *
 * @param String $path Path of file
 * @param String $filename Name of file
 * @return String A unique filename.
 */
function getUniqueFilename($path, $filename) {
	if (file_exists($path . "/" . $filename)) {
		$ar = explode('.', $filename);
		$fileext  = array_pop($ar);
		$basename = basename($filename, '.'.$fileext);
		$instance = 2;

		while(file_exists($path . "/" . $basename . "_" . $instance . "." . $fileext))
			$instance++;

		return $basename . "_" . $instance . "." . $fileext;
	}

	return $filename;
}

/**
 * Returns a filesize as a nice truncated string like "10.3 MB".
 *
 * @param int $size File size to convert.
 * @return String Nice truncated string of the file size.
 */
function getSizeStr($size) {
	// MB
	if ($size > 1048576)
		return round($size / 1048576, 1) . " MB";

	// KB
	if ($size > 1024)
		return round($size / 1024, 1) . " KB";

	return $size . " bytes";
}

/**
 * Returns the file type of a file.
 *
 * @param String file name
 * @return Array Array with file type info.
 */
function getFileType($file_name) {
	global $mcImageManagerFileTypes;

	$ar = explode('.', $file_name);
	$ext = strtolower(array_pop($ar));

	// Search for extention
	foreach ($mcImageManagerFileTypes as $type) {
		foreach ($type[0] as $targetExt) {
			if ($ext == strtolower($targetExt))
				return array("icon" => $type[1], "type" => $type[2], "preview" => $type[3], "ext" => $ext);
		}
	}

	// Not in list
	return array("icon" => "unknown.gif", "type" => "Normal file", "preview" => false, "ext" => $ext);
}

/**
 * Removes the trailing slash from a path.
 *
 * @param String path Path to remove trailing slash from.
 * @return String New path without trailing slash.
 */
function removeTrailingSlash($path) {
	// Is root
	if ($path == "/")
		return $path;

	if ($path == "")
		return $path;

	if ($path[strlen($path)-1] == '/')
		$path = substr($path, 0, strlen($path)-1);

	return $path;
}

/**
 * Adds a trailing slash to a path.
 *
 * @param String path Path to add trailing slash on.
 * @return String New path with trailing slash.
 */
function addTrailingSlash($path) {
	if (strlen($path) > 0 && $path[strlen($path)-1] != '/')
		$path .= '/';

	return $path;
}

/**
 * Returns the user path, the path that the users sees.
 *
 * @param String $path Absolute file path.
 * @return String Visual path, user friendly path.
 */
function getUserFriendlyPath($path, $max_len = -1) {
	global $mcImageManagerConfig;

	if (checkBool($mcImageManagerConfig['general.user_friendly_paths'])) {
		$path = substr($path, strlen(removeTrailingSlash(getRealPath($mcImageManagerConfig, 'filesystem.rootpath'))));

		if ($path == "")
			$path = "/";
	}

	if ($max_len != -1 && strlen($path) > $max_len)
		$path = "... " . substr($path, strlen($path)-$max_len);

	// Add slash in front
	if (strlen($path) > 0 && $path[0] != '/')
		$path = "/" . $path;

	return $path;
}

/**
 * Check if a value is true/false.
 *
 * @param string $str True/False value.
 * @return bool true/false
 */
function checkBool($str) {
	if ($str === true)
		return true;

	if ($str === false)
		return false;

	$str = strtolower($str);

	if ($str == "true")
		return true;

	return false;
}

/**
 * Converts a Unix path to OS specific path.
 *
 * @param String $path Unix path to convert.
 */
function toOSPath($path) {
	return str_replace("/", DIRECTORY_SEPARATOR, $path);
}

/**
 * Converts a OS specific path to Unix path.
 *
 * @param String $path OS path to convert to Unix style.
 */
function toUnixPath($path) {
	return str_replace(DIRECTORY_SEPARATOR, "/", $path);
}

/**
 * Returns the absolute path of a config key or die on failure.
 *
 * @param String $config Configuration name/value array.
 * @param String $key Path key to retrive.
 */
function getRealPath($config, $key) {
	return resolvePath($config[$key]);
}

/**
 * Resize information regarding image.
 *
 * @param Int $width Width of image.
 * @param Int $height Height of image.
 * @param Int $target Target to scale for.
 * @return Array $imageinfo Array with width, height and scale info.
 */
function imageResize($width, $height, $target) {
	$percentage = 0;
	$imageinfo = array();

	if ($width > $height)
		$percentage = ($target / $width);
	else
		$percentage = ($target / $height);

	if ($percentage <= 1) {
		$width = round($width * $percentage);
		$height = round($height * $percentage);
	} else {
		$percentage = 0;
	}
	//echo "P" . $percentage . " - W" . $width . " - H" . $height ." - T". $target ."\n";
	$imageinfo['width'] = $width;
	$imageinfo['height'] = $height;
	$imageinfo['scale'] = round($percentage, 2)*100;

	return $imageinfo;
} 

/**
 * Returns the wwwroot or null string if it was impossible to get.
 *
 * @return String wwwroot or null string if it was impossible to get.
 */
function getWWWRoot($config) {
	if (isset($config['preview.wwwroot']) && $config['preview.wwwroot'])
		return getRealPath($config, 'preview.wwwroot');
	
	// Check document root
	if (isset($_SERVER['DOCUMENT_ROOT']))
		return resolvePath($_SERVER['DOCUMENT_ROOT']);

	// Try script file
	if (isset($_SERVER["SCRIPT_NAME"]) && isset($_SERVER["SCRIPT_FILENAME"])) {
		$path = str_replace(toUnixPath($_SERVER["SCRIPT_NAME"]), "", toUnixPath($_SERVER["SCRIPT_FILENAME"]));
		if (is_dir($path))
			return toOSPath($path);
	}

	// If all else fails, try this.
	if (isset($_SERVER["SCRIPT_NAME"]) && isset($_SERVER["PATH_TRANSLATED"])) {
		$path = str_replace(toUnixPath($_SERVER["SCRIPT_NAME"]), "", str_replace("//", "/", toUnixPath($_SERVER["PATH_TRANSLATED"])));
		if (is_dir($path))
			return toOSPath($path);
	}

	die("Could not resolve WWWROOT path, please set an absolute path in preview.wwwroot config option.");
	return null;
}

/**
 * Check for the EXIF functions that are beeing used.
 * @return Bool true or false depending on success or not.
 */
function exifExists() {
	if (!function_exists("exif_thumbnail"))
		return false;

	return true;
}

/**
 * Resolves relative path to absolute path. The output path is in unix format.
 */
function resolvePath($path, $verify = true) {
	$result = realpath($path);
	$result = preg_replace("/(\\\\)/","\\", $result);
	
	if ($result == "" && $verify)
		trigger_error("Check your rootpath & path config (or other paths), could not resolve path: \"". $path . "\".", FATAL);

	return toUnixPath($result);
}

/**
 * Verifies that a path is within the parent path.
 */
function isChildPath($parent_paths, $path) {
	// Is child of any of the specified paths
	if (is_array($parent_paths)) {
		foreach ($parent_paths as $key => $validPath) {
			if (strpos(strtolower(addTrailingSlash($path)), strtolower(addTrailingSlash($validPath))) === 0)
				return $validPath;
		}
		return false;
	}
	return strpos(strtolower(addTrailingSlash($path)), strtolower(addTrailingSlash($parent_paths))) === 0;
}

/**
 * Returns the script name.
 *
 * @return String script name.
 */
function getScriptName() {
	$arrayShifter = "";

	if (isset($_SERVER["PHP_SELF"])) {
		$arrayShifter = explode(".", basename($_SERVER["PHP_SELF"]));
		return array_shift($arrayShifter);
	}

	if (isset($_SERVER["SCRIPT_NAME"])) {
		$arrayShifter = explode(".", basename($_SERVER["SCRIPT_NAME"]));
		return array_shift($arrayShifter);
	}
}

/**
 * Writes file to output buffer, if read fails, it tries to redirect to it instead.
 *
 * @param String $path Full absolute path to image.
 * @param Int $type Type of image to.
 * @param String $preview The preview path.
 * @return Bool Just return true for now.
 */
function streamImage($path, $type, $preview) {
	header('Content-type: ' . image_type_to_mime_type($type));
	if (!readfile($path))
		header("Location: ". $preview);

	die();
}

/**
 * Calls the mcError class, returns true.
 *
 * @param Int $errno Number of the error.
 * @param String $errstr Error message.
 * @param String $errfile The file the error occured in.
 * @param String $errline The line in the file where error occured.
 * @param Array $errcontext Error context array, contains all variables.
 * @return Bool Just return true for now.
 */
function mcErrorHandler($errno, $errstr, $errfile, $errline, $errcontext) {
	global $mcImageManagerConfig, $mcImageManagerErrorHandler;

	// Ignore these
	if ($errno == E_STRICT)
		return true;

	// Just pass it through	to the class.
	$data = $mcImageManagerErrorHandler->handleError($errno, $errstr, $errfile, $errline, $errcontext);

	if ($data['break']) {
		$data['backtrace'] = array();

		if ($mcImageManagerConfig['general.debug'] && function_exists("debug_backtrace"))
			$data['backtrace'] = debug_backtrace();

		renderPage("error.tpl.php", $data);
	}

	return true;
}

?>
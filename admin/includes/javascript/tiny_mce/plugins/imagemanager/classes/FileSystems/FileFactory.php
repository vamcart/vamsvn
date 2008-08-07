<?php
/**
 * FileFactory.php
 *
 * @package MCFileManager.filesystems
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

// File type contstants
define('MC_IS_FILE', 0);
define('MC_IS_DIRECTORY', 1);

/**
 * This class creates new File implemented objects out of paths.
 *
 * @package MCFileManager.filesystems
 */
class FileFactory {
	// Private fields
	var $_rootPath;
	var $_fileEventListeners;
	var $_config;

	/**
	 * File factory constructor.
	 *
	 * @param Array $config Configuration array.
	 * @param String $root_path Root path, files above this path are not accessable.
	 */
	function FileFactory(&$config, $root_path) {
		$this->_config = $config;
		$this->_rootPath = $root_path;
		$this->_fileEventListeners = array();
	}

	/**
	 * Returns the root path.
	 *
	 * @return String root path.
	 */
	function getRootPath() {
		return $this->_rootPath;
	}

	/**
	 * Returns the global root config.
	 *
	 * @return Array Global root config.
	 */
	function getConfig() {
		return $this->_config;
	}

	/**
	 * Returns true or false if the path is a valid path or not.
	 *
	 * @param String $abs_path Absolute file path to verify.
	 * @return true - File path is valid, false it's not valid.
	 */
	function verifyPath($abs_path) {
		$abs_path = removeTrailingSlash(strtolower(toUnixPath($abs_path)));
		$rootPath = removeTrailingSlash(strtolower(toUnixPath(getRealPath($this->_config, 'filesystem.rootpath'))));

		if ($abs_path == $rootPath)
			return true;

		// Fix root paths
		$abs_path = $abs_path == "" ? "/" : $abs_path;
		$rootPath = $rootPath == "" ? "/" : $rootPath;

		// Hack attempt
		$pos1 = strpos($abs_path, $rootPath);
		$pos2 = strpos($abs_path, "..");

		return !($pos1 === false || $pos1 != 0 || $pos2 !== false);
	}

	/**
	 * Returns a new file instance of a absolute path.
	 * 
	 * @param String $abs_path Absolute file path.
	 * @param String $file_name Optional file name.
	 * @param String $type Optional file type.
	 * @return File File object instance based on absolute path.
	 */
	function &getFile($abs_path, $file_name = "", $type = MC_IS_FILE) {
		$rootPath = removeTrailingSlash(toUnixPath(getRealPath($this->_config, 'filesystem.rootpath')));

		if (!$this->verifyPath($abs_path)) {
			trigger_error("Trying to get out of defined root path. Root: " . $rootPath . ", Path: " . $abs_path, E_USER_ERROR);
			die;
		}

		// Fix the absolute path
		$abs_path = removeTrailingSlash(toUnixPath($abs_path));
		$abs_path = $abs_path == "" ? "/" : $abs_path;
		$file =& new $this->_config['filesystem']($this, $abs_path, $file_name, $type);

		return $file;
	}

	/**
	 * Adds a file event listener to this file object.
	 *
	 * @param FileEventListener $listener Listener that gets triggered if when diffrent file events occur.
	 * @return FileEventListener Listener instance that was added.
	 */
	function addFileEventListener(&$listener) {
		$this->_fileEventListeners[] = $listener;

		return $listener;
	}

	/**
	 * Returns a array of file event listeners.
	 *
	 * @return Array of file event listeners.
	 */
	function getFileEventListeners() {
		return $this->_fileEventListeners;
	}

	/**
	 * Removes a file event listener instance.
	 *
	 * @param FileEventListner $listener Listener instance to remove.
	 * @return FileEventListner File event listnener instance or null if it wasn't found.
	 */
	function removeFileEventListener(&$listener) {
		// Get instance index
		for ($i=0; $i<count($this->_fileEventListeners); $i++) {
			if ($this->_fileEventListeners[$i] == $listener)
				break;
		}

		// Remove instance
		$this->_fileEventListeners = array_splice($this->_fileEventListeners, $i);

		return $listener;
	}

	/**
	 * Dispatches a file event to all listeners.
	 *
	 * @param int $action Action ID.
	 * @param File $file1 File object 1.
	 * @param File $file2 File object 2.
	 */
	function dispatchFileEvent($action, $file1= -1, $file2 = -1) {
		if ($file1 == -1)
			$file1 = NULL;

		if ($file2 == -1)
			$file2 = NULL;

		foreach ($this->_fileEventListeners as $listener)
			$listener->handleFileAction($action, $file1, $file2);
	}
}
?>
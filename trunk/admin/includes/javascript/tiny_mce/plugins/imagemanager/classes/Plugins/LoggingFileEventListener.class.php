<?php
/**
 * LoggingFileEventListener.php
 *
 * @package MCFileManager.filesystems
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

/**
 * This class logs any modifications made by the MCFileManager.
 */
class LoggingFileEventListener {
	// Private fields
	var $_logPath;
	var $_logPrefix;
	var $_logMaxSize;
	var $_logMaxFiles;
	var $_logMaxSizeBytes;

	/**
	 * Initializes the FileEventListener by the specified config.
	 *
	 * @param Array name/value array of config data.
	 */
	function init(&$config) {
		// Setup logger
		$this->_logPath = getRealPath($config, "LoggingFileEventListener.path");
		$this->_logPrefix = getConfigParam($config, "LoggingFileEventListener.prefix", "mcfilemanager");
		$this->_logMaxSize = getConfigParam($config, "LoggingFileEventListener.max_size", "100k");
		$this->_logMaxFiles = getConfigParam($config, "LoggingFileEventListener.max_files", "10");

		// Fix log max size
		$logMaxSizeBytes = intval(preg_replace("/[^0-9]/", "", $this->_logMaxSize));

		// Is KB
		if (strpos((strtolower($this->_logMaxSize)), "k") > 0)
			$logMaxSizeBytes *= 1024;

		// Is MB
		if (strpos((strtolower($this->_logMaxSize)), "m") > 0)
			$logMaxSizeBytes *= (1024 * 1024);

		$this->_logMaxSizeBytes = $logMaxSizeBytes;
	}

	/**
	 * Action event handler.
	 *
	 * @param int $action Action ID.
	 * @param File $file1 File object 1.
	 * @param File $file2 File object 2.
	 */
	function handleFileAction($action, $file1, $file2) {
		switch ($action) {
			case DELETE_ACTION:
				$this->_logMsg("Deleted file: " . $file1->getAbsolutePath());
				break;

			case ADD_ACTION:
				$this->_logMsg("Added file: " . $file1->getAbsolutePath());
				break;

			case UPDATE_ACTION:
				$this->_logMsg("Updated file: " . $file1->getAbsolutePath());
				break;

			case RENAME_ACTION:
				$this->_logMsg("Renamed file: " . $file1->getAbsolutePath() . " to " . $file2->getAbsolutePath());
				break;

			case COPY_ACTION:
				$this->_logMsg("Copied file: " . $file1->getAbsolutePath() . " to " . $file2->getAbsolutePath());
				break;

			case MKDIR_ACTION:
				$this->_logMsg("Created directory: " . $file1->getAbsolutePath());
				break;

			case RMDIR_ACTION:
				$this->_logMsg("Removed directory: " . $file1->getAbsolutePath());
				break;

			default:
				$this->_logMsg("Unknown action: " . $action . "," . $file1->getAbsolutePath() . "," . $file1->getAbsolutePath());
		}
	}

	function _logMsg($message) {
		$logFile = toOSPath($this->_logPath . "/" . $this->_logPrefix . ".log");

		// Check filesize
		$size = @filesize($logFile);
		$roll = false;
		if ($size > $this->_logMaxSizeBytes)
			$roll = true;

		// Roll if the size is right
		if ($roll) {
			for ($i=$this->_logMaxFiles-1; $i>=1; $i--) {
				$rfile = toOSPath($this->_logPath . "/" . $this->_logPrefix . ".log." . $i);
				$nfile = toOSPath($this->_logPath . "/" . $this->_logPrefix . ".log." . ($i+1));

				if (file_exists($rfile))
					rename($rfile, $nfile);
			}

			rename($logFile, toOSPath($this->_logPath . "/" . $this->_logPrefix . ".log.1"));

			// Delete last logfile
			$delfile = toOSPath($this->_logPath . "/" . $this->_logPrefix . ".log." . ($this->_logMaxFiles+1));
			if (file_exists($delfile))
				unlink($delfile);
		}

		// Append log line
		if (($fp = fopen($logFile, "a")) != null) {
			fputs($fp, "[" . date("Y-m-d H:i:s") . "] " . $message . "\r\n");
			fflush($fp);
			fclose($fp);
		}
	}
}

?>

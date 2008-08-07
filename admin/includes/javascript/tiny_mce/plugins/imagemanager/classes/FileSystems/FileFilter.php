<?php
/**
 * FileFilter.php
 *
 * @package MCFileManager.filesystems
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

/**
 * This class is the base FileFilter class and is to be extended by all custom FileFilter implementations.
 *
 * @package mce.core
 */
class FileFilter {
	/**
	 * Returns true or false if the file is accepted or not.
	 * 
	 * @param MCE_File $file File to grant or deny.
	 * @return boolean true or false if the file is accepted or not.
	 */
	function accept($file) {
		// code here...
	}
}

/**
 * DummyFileFiler this filter accepts all files.
 *
 * @package mce.core
 */
class DummyFileFilter extends FileFilter {
	/**
	 * Returns true or false if the file is accepted or not.
	 * Note: This dummb method allways returns true.
	 * 
	 * @param MCE_File $file File to grant or deny.
	 * @return boolean true or false if the file is accepted or not.
	 */
	function accept($file) {
		return true;
	}
}

// Define reason constants
define('_BASIC_FILEFILTER_INVALID_EXTENSION', 1);
define('_BASIC_FILEFILTER_INVALID_NAME', 2);

/**
 * Basic file filter, this class handles some common filter problems
 * and is possible to extend if needed.
 *
 * @package mce.core
 */
class BasicFileFilter extends FileFilter {
    /**#@+
	 * @access private
	 */

	var $_excludeFolders;
	var $_includeFolders;
	var $_excludeFiles;
	var $_includeFiles;
	var $_includeFilePattern;
	var $_excludeFilePattern;
	var $_includeDirectoryPattern;
	var $_excludeDirectoryPattern;
	var $_filesOnly;
	var $_dirsOnly;
	var $_includeWildcardPattern;
	var $_excludeWildcardPattern;
	var $_maxLevels;
	var $_debug;
	var $_reason;

    /**#@+
	 * @access public
	 */

	/**
	 * Main constructor.
	 */
	function BasicFileFilter() {
		$this->_debug = false;
		$this->_extensions = "";
	}

	/**
	 * Sets if debug mode is on or off, default off.
	 * 
	 * @param boolean $state if true debug mode is enabled.
	 */
	function setDebugMode($state) {
		$this->_debug = $state;
	}

	/**
	 * Sets if only files are to be accepted in result.
	 * 
	 * @param boolean $files_only True if only files are to be accepted.
	 */
	function setOnlyFiles($files_only) {
		$this->_filesOnly = $files_only;
	}

	/**
	 * Sets if only dirs are to be accepted in result.
	 * 
	 * @param boolean $dirs_only True if only dirs are to be accepted.
	 */
	function setOnlyDirs($dirs_only) {
		$this->_dirsOnly = $dirs_only;
	}

	/**
	 * Sets maximum number of directory levels to accept.
	 * 
	 * @param int $max_levels Maximum number of directory levels to accept.
	 */
	function setMaxLevels($max_levels) {
		$this->_maxLevels = $max_levels;
	}

	/**
	 * Sets a comma separated list of valid file extensions.
	 *
	 * @param String $extensions Comma separated list of valid file extensions.
	 */
	function setIncludeExtensions($extensions) {
		if ($extensions == "*" || $extensions == "")
			return;

		$this->_extensions = explode(',', strtolower($extensions));
	}

	/**
	 * Sets comma separated string list of filenames to exclude.
	 * 
	 * @param String $files separated string list of filenames to exclude.
	 */
	function setExcludeFiles($files) {
		if ($files != "")
			$this->_excludeFiles = split(',', $files);
	}

	/**
	 * Sets comma separated string list of filenames to include.
	 * 
	 * @param String $files separated string list of filenames to include.
	 */
	function setIncludeFiles($files) {
		if ($files != "")
			$this->_includeFiles = split(',', $files);
	}

	/**
	 * Sets comma separated string list of foldernames to exclude.
	 * 
	 * @param String $folders separated string list of foldernames to exclude.
	 */
	function setExcludeFolders($folders) {
		if ($folders != "")
			$this->_excludeFolders = split(',', $folders);
	}

	/**
	 * Sets comma separated string list of foldernames to include.
	 * 
	 * @param String $folders separated string list of foldernames to include.
	 */
	function setIncludeFolders($folders) {
		if ($folders != "")
			$this->_includeFolders = split(',', $folders);
	}

	/**
	 * Sets a regexp pattern that is used to accept files path parts.
	 * 
	 * @param String $pattern regexp pattern that is used to accept files path parts.
	 */
	function setIncludeFilePattern($pattern) {
		$this->_includeFilePattern = $pattern;
	}

	/**
	 * Sets a regexp pattern that is used to deny files path parts.
	 * 
	 * @param String $pattern regexp pattern that is used to deny files path parts.
	 */
	function setExcludeFilePattern($pattern) {
		$this->_excludeFilePattern = $pattern;
	}

	/**
	 * Sets a regexp pattern that is used to accept directory path parts.
	 * 
	 * @param String $pattern regexp pattern that is used to accept directory path parts.
	 */
	function setIncludeDirectoryPattern($pattern) {
		$this->_includeDirectoryPattern = $pattern;
	}

	/**
	 * Sets a regexp pattern that is used to deny directory path parts.
	 * 
	 * @param String $pattern regexp pattern that is used to deny directory path parts.
	 */
	function setExcludeDirectoryPattern($pattern) {
		$this->_excludeDirectoryPattern = $pattern;
	}

	/**
	 * Sets a wildcard pattern that is used to accept files path parts.
	 * 
	 * @param String $pattern wildcard pattern that is used to accept files path parts.
	 */
	function setIncludeWildcardPattern($pattern) {
		if ($pattern != "")
			$this->_includeWildcardPattern = $pattern;
	}

	/**
	 * Sets a wildcard pattern that is used to deny files path parts.
	 * 
	 * @param String $pattern wildcard pattern that is used to deny files path parts.
	 */
	function setExcludeWildcardPattern($pattern) {
		if ($pattern != "")
			$this->_excludeWildcardPattern = $pattern;
	}

	/**
	 * Returns a status code why the accept failed. These status codes are defined as constants.
	 *
	 * @return int Reason status code.
	 */
	function getReason() {
		return $this->_reason;
	}

	/**
	 * Returns true or false if the file is accepted or not.
	 * 
	 * @param MCE_File $file File to grant or deny.
	 * @return boolean true or false if the file is accepted or not.
	 */
	function accept($file) {
		$this->_reason = 0;

		// Handle exclude folders
		if (is_array($this->_excludeFolders)) {
			foreach ($this->_excludeFolders as $folder) {
				if (strpos($file->getAbsolutePath(), $folder) != "") {
					if ($this->_debug)
						echo "File denied \"" . $file->getAbsolutePath() . "\" by \"excludeFolders\".<br>";

					$this->_reason = _BASIC_FILEFILTER_INVALID_NAME;

					return false;
				}
			}
		}

		// Handle include folders
		if (is_array($this->_includeFolders)) {
			$state = false;

			foreach ($this->_includeFolders as $folder) {
				if (strpos($file->getAbsolutePath(), $folder) != "") {
					$state = true;
					break;
				}
			}

			if (!$state) {
				if ($this->_debug)
					echo "File \"" . $file->getAbsolutePath() . "\" denied by \"includeFolders\".<br>";

				$this->_reason = _BASIC_FILEFILTER_INVALID_NAME;

				return false;
			}
		}

		// Handle exclude files
		if (is_array($this->_excludeFiles) && $file->isFile()) {
			foreach ($this->_excludeFiles as $fileName) {
				if ($file->getName() == $fileName) {
					if ($this->_debug)
						echo "File \"" . $file->getAbsolutePath() . "\" denied by \"excludeFiles\".<br>";

					$this->_reason = _BASIC_FILEFILTER_INVALID_NAME;

					return false;
				}
			}
		}

		// Handle include files
		if (is_array($this->_includeFiles) && $file->isFile()) {
			$state = false;

			foreach ($this->_includeFiles as $fileName) {
				if ($file->getName() == $fileName) {
					$state = true;
					break;
				}
			}

			if (!$state) {
				if ($this->_debug)
					echo "File \"" . $file->getAbsolutePath() . "\" denied by \"includeFiles\".<br>";

				$this->_reason = _BASIC_FILEFILTER_INVALID_NAME;

				return false;
			}
		}

		// Handle file patterns
		if ($file->isFile()) {
			if ($this->_dirsOnly) {
				if ($this->_debug)
					echo "File denied \"" . $file->getAbsolutePath() . "\" by \"dirsOnly\".<br>";

				$this->_reason = _BASIC_FILEFILTER_INVALID_NAME;

				return false;
			}

			// Handle exclude pattern
			if ($this->_excludeFilePattern && preg_match($this->_excludeFilePattern, $file->getName())) {
				if ($this->_debug)
					echo "File \"" . $file->getAbsolutePath() . "\" denied by \"excludeFilePattern\".<br>";

				$this->_reason = _BASIC_FILEFILTER_INVALID_NAME;

				return false;
			}

			// Handle include pattern
			if ($this->_includeFilePattern && !preg_match($this->_includeFilePattern, $file->getName())) {
				if ($this->_debug)
					echo "File \"" . $file->getAbsolutePath() . "\" denied by \"includeFilePattern\".<br>";

				$this->_reason = _BASIC_FILEFILTER_INVALID_NAME;

				return false;
			}
		} else {
			if ($this->_filesOnly) {
				if ($this->_debug)
					echo "Dir denied \"" . $file->getAbsolutePath() . "\" by \"filesOnly\".<br>";

				$this->_reason = _BASIC_FILEFILTER_INVALID_NAME;

				return false;
			}

			// Handle exclude pattern
			if ($this->_excludeDirectoryPattern && preg_match($this->_excludeDirectoryPattern, $file->getName())) {
				if ($this->_debug)
					echo "File \"" . $file->getAbsolutePath() . "\" denied by \"excludeDirectoryPattern\".<br>";

				$this->_reason = _BASIC_FILEFILTER_INVALID_NAME;

				return false;
			}

			// Handle include pattern
			if ($this->_includeDirectoryPattern && !preg_match($this->_includeDirectoryPattern, $file->getName())) {
				if ($this->_debug)
					echo "File \"" . $file->getAbsolutePath() . "\" denied by \"includeDirectoryPattern\".<br>";

				$this->_reason = _BASIC_FILEFILTER_INVALID_NAME;

				return false;
			}
		}

		// Handle include wildcard pattern
		if ($this->_includeWildcardPattern && !$this->_fnmatch($this->_includeWildcardPattern, $file->getName())) {
			if ($this->_debug)
				echo "File \"" . $file->getAbsolutePath() . "\" denied by \"includeWildcardPattern\".<br>";

			$this->_reason = _BASIC_FILEFILTER_INVALID_NAME;

			return false;
		}

		// Handle exclude wildcard pattern
		if ($this->_excludeWildcardPattern && $this->_fnmatch($this->_excludeWildcardPattern, $file->getName())) {
			if ($this->_debug)
				echo "File \"" . $file->getAbsolutePath() . "\" denied by \"excludeWildcardPattern\".<br>";

			$this->_reason = _BASIC_FILEFILTER_INVALID_NAME;

			return false;
		}

		// Handle file exntetion pattern
		if (is_array($this->_extensions) && $file->isFile()) {
			$ar = explode('.', $file->getAbsolutePath());
			$ext = strtolower(array_pop($ar));
			$valid = false;

			foreach ($this->_extensions as $extension) {
				if ($extension == $ext) {
					$valid = true;
					break;
				}
			}

			if (!$valid) {
				$this->_reason = _BASIC_FILEFILTER_INVALID_EXTENSION;
				return false;
			}
		}

		return true;
	}

	function _fnmatch($pattern, $file) {
		return ereg($this->_fnmatch2regexp($pattern), $file);
	}

	function _fnmatch2regexp($str) {
		$s = "";

		for ($i = 0; $i<strlen($str); $i++) {
			$c = $str{$i};
			if ($c =='?')
				$s .= '.'; // any character
			else if ($c == '*')  
				$s .= '.*'; // 0 or more any characters
			else if ($c == '[' || $c == ']')
				$s .= $c;  // one of characters within []
			else
				$s .= '\\' . $c;
		}

		$s = '^' . $s . '$';

		//trim redundant ^ or $
		//eg ^.*\.txt$ matches exactly the same as \.txt$
		if (substr($s,0,3) == "^.*")
			$s = substr($s, 3);

		if (substr($s,-3,3) == ".*$")
			$s = substr($s, 0, -3);

		return $s;
	}

	/**#@-*/
}
?>
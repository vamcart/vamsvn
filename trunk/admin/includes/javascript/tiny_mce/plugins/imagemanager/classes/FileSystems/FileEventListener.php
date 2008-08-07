<?php
/**
 * FileEventListener.php
 *
 * @package MCFileManager.filesystems
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

// Action constants
define('DELETE_ACTION', 1);
define('ADD_ACTION', 2);
define('UPDATE_ACTION', 3);
define('RENAME_ACTION', 4);
define('COPY_ACTION', 5);
define('MKDIR_ACTION', 6);
define('RMDIR_ACTION', 7);

/**
 * This class/interface is to be extended with your custom FileEventListener logic.
 */
class FileEventListener {
	/**
	 * Initializes the FileEventListener by the specified config.
	 *
	 * @param Array name/value array of config data.
	 */
	function init(&$config) {
	}

	/**
	 * Action event handler.
	 *
	 * @param int $action Action ID.
	 * @param File $file1 File object 1.
	 * @param File $file2 File object 2.
	 */
	function handleFileAction($action, $file1, $file2) {
	}
}

?>

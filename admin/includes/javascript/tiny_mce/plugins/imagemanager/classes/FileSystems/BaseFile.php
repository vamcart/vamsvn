<?php
/**
 * BaseFile.php
 *
 * @package MCFileManager.filesystems
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

/**
 * This class is the base MCE_File class and is to be extended by all MCE_File implementations.
 *
 * @package MCFileManager.filesystems
 */
class BaseFile {

	/**
	 * Set a bool regarding events triggering.
	 *
	 * @param Bool $trigger Trigger or not to trigger.
	 */
	function setTriggerEvents($trigger) {
	}

	/**
	 * Returns bool if events are to be triggered or not.
	 *
	 * @return Bool bool for triggering events or not.
	 */
	function getTriggerEvents() {
	}

	/**
	 * Returns the parent files absolute path.
	 *
	 * @return String parent files absolute path.
	 */
	function getParent() {
	}

	/**
	 * Returns the parent files MCE_File instance.
	 *
	 * @return MCE_File parent files MCE_File instance or false if there is no more parents.
	 */
	function getParentFile() {
	}

	/**
	 * Returns the file name of a file.
	 *
	 * @return string File name of file.
	 */
	function getName() {
	}

	/**
	 * Returns the absolute path of the file.
	 *
	 * @return String absolute path of the file.
	 */
	function getAbsolutePath() {
	}

	/**
	 * Imports a local file to the file system, for example when users upload files.
	 *											   
	 * @param String $local_absolute_path Absolute path to local file
	 */
	function importFile($local_absolute_path) {
	}

	/**
	 * Returns true if the file has the specified access.
	 *
	 * @return boolean true if the file has the specified access.
	 */
	function verifyAccess($access) {
	}

	/**
	 * Returns true if the file exists.
	 *
	 * @return boolean true if the file exists.
	 */
	function exists() {
	}

	/**
	 * Returns true if the file is a directory.
	 *
	 * @return boolean true if the file is a directory.
	 */
	function isDirectory() {
	}

	/**
	 * Returns true if the file is a file.
	 *
	 * @return boolean true if the file is a file.
	 */
	function isFile() {
	}

	/**
	 * Returns last modification date in ms as an long.
	 *
	 * @return long last modification date in ms as an long.
	 */
	function lastModified() {
	}

	/**
	 * Returns creation date in ms as an long.
	 *
	 * @return long creation date in ms as an long.
	 */
	function creationDate() {
	}

	/**
	 * Returns true if the files is readable.
	 *
	 * @return boolean true if the files is readable.
	 */
	function canRead() {
	}
	
	/**
	 * Returns true if the files is writable.
	 *
	 * @return boolean true if the files is writable.
	 */
	function canWrite() {
	}

	/**
	 * Returns file size as an long.
	 *
	 * @return long file size as an long.
	 */
	function length() {
	}

	/**
	 * Copies this file to the specified file instance.
	 *
	 * @param MCE_File $dest File to copy to.
	 * @return boolean true - success, false - failure
	 */
	function copyTo($dest) {
	}

	/**
	 * Creates a new empty file.
	 *
	 * @return boolean true - success, false - failure
	 */
	function createNewFile() {
	}

	/**
	 * Deletes the file.
	 *
	 * @param boolean $deep If this option is enabled files will be deleted recurive.
	 * @return boolean true - success, false - failure
	 */
	function delete($deep = false) {
	}

	/**
	 * Returns an array of MCE_File instances.
	 *
	 * @return Array array of MCE_File instances.
	 */
	function listFiles() {
	}

	/**
	 * Returns an array of MCE_File instances based on the specified filter instance.
	 *
	 * @param MCE_FileFilter &$filter MCE_FileFilter instance to filter files by.
	 * @return Array array of MCE_File instances based on the specified filter instance.
	 */
	function listFilesFiltered(&$filter) {
	}

	/**
	 * Lists the file as an tree and calls the specified MCE_FileTreeHandler instance on each file. 
	 *
	 * @param MCE_FileTreeHandler &$file_tree_handler MCE_FileTreeHandler to invoke on each file.
	 */
	function listTree(&$file_tree_handler) {
	}

	/**
	 * Lists the file as an tree and calls the specified MCE_FileTreeHandler instance on each file
	 * if the file filter accepts the file.
	 *
	 * @param MCE_FileTreeHandler &$file_tree_handler MCE_FileTreeHandler to invoke on each file.
	 * @param MCE_FileTreeHandler &$file_filter MCE_FileFilter instance to filter files by.
	 */
	function listTreeFiltered(&$file_tree_handler, &$file_filter) {
	}

	/**
	 * Creates a new directory.
	 *
	 * @return boolean true- success, false - failure
	 */
	function mkdir() {
	}

	/**
	 * Renames/Moves this file to the specified file instance.
	 *
	 * @param MCE_File $dest File to rename/move to.
	 * @return boolean true- success, false - failure
	 */
	function renameTo($dest) {
	}

	/**
	 * Sets the last-modified time of the file or directory.
	 *
	 * @param String $datetime The new date/time to set the file, in timestamp format
	 * @return boolean true - success, false - failure
	 */
	function setLastModified($datetime) {
	}

	/**
	 * Returns a name/value array with file information. This array
	 * contains the filename/extension.
	 *
	 * @return Array Name/value array with file information.
	 */
	function getInfo() {
	}

	/**
	 * Returns a merged name/value array of config elements.
	 *
	 * @return Array Merged name/value array of config elements.
	 */
	function getConfig() {
	}
}
?>
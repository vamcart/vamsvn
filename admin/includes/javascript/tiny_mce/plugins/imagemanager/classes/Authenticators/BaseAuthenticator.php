<?php
/**
 * BaseAuthenticator.php
 *
 * @package MCFileManager.authenicators
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

/**
 * This is the base authenticator class, this is to be extended by all authenicator implementations.
 *
 * @package MCFileManager.Authenticators
 */
class BaseAuthenticator {
	/**
	 * Initializes the authenicator.
	 *
	 * @param Array $config Name/Value collection of config items.
	 */
	function init(&$config) {
	}

	/**
	 * Returns a array with group names that the user is bound to.
	 *
	 * @return Array with group names that the user is bound to.
	 */
	function getGroups() {
		return "";
	}

	/**
	 * Returns true/false if the user is logged in or not.
	 *
	 * @return bool true/false if the user is logged in or not.
	 */
	function isLoggedin() {
		return true;
	}
}

?>

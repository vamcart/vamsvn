<?php
/**
 * PHPNukeAuthenticatorImpl.php
 *
 * @package MCFileManager.authenicators
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

// Include PHPNuke logic
@session_destroy();
chdir("../../../../");
require_once("mainfile.php");
chdir("includes/tiny_mce/plugins/imagemanager/");

/**
 * This class is a Drupal CMS authenticator implementation.
 *
 * @package MCFileManager.Authenticators
 */
class PHPNukeAuthenticatorImpl extends BaseAuthenticator {
    /**#@+
	 * @access public
	 */

	/**
	 * Main constructor.
	 */
	function PHPNukeAuthenticatorImpl() {
	}

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
		global $user;

		return is_user($user) == 1;
	}

	/**#@-*/
}

?>
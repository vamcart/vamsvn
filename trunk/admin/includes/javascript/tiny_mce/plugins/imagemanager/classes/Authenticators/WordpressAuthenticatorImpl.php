<?php
/**
 * WordpressAuthenticatorImpl.php
 *
 * @package MCImageManager.authenticators
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

// Include Wordpress user handling stuff, ugly... but it works, their codex site was down.
chdir("../../../../../wp-admin/");
require_once("admin.php");
chdir("../wp-includes/js/tinymce/plugins/imagemanager/");

/**
 * This class is a Wordpress CMS authenticator implementation.
 *
 * @package MCImageManager.Authenticators
 */
class WordpressAuthenticatorImpl extends BaseAuthenticator {
    /**#@+
	 * @access public
	 */

	/**
	 * Main constructor.
	 */
	function WordpressAuthenticatorImpl() {
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
		return user_can_richedit();
	}

	/**#@-*/
}

?>
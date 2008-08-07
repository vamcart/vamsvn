<?php
/**
 * DrupalAuthenticatorImpl.php
 *
 * @package MCImageManager.authenicators
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

// Include Drupal bootstrap logic
@session_destroy();
chdir("../../../../../../../");
require_once("includes/bootstrap.inc");
require_once("includes/common.inc");

if (function_exists("drupal_bootstrap"))
	drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

chdir("modules/tinymce/tinymce/jscripts/tiny_mce/plugins/imagemanager/");

/**
 * This class is a Drupal CMS authenticator implementation.
 *
 * @package MCImageManager.Authenticators
 */
class DrupalAuthenticatorImpl extends BaseAuthenticator {
    /**#@+
	 * @access public
	 */

	/**
	 * Main constructor.
	 */
	function DrupalAuthenticatorImpl() {
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
		return user_access('access tinymce');
	}

	/**#@-*/
}

?>
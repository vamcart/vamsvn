<?php
/**
 * SessionAuthenticatorImpl.php
 *
 * @package MCFileManager.authenicators
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 */

/**
 * This class is a session authenticator implementation, this implementation will check for session keys defined by the
 * config options "authenticator.session.logged_in_key, authenticator.session.groups_key".
 *
 * @package MCFileManager.Authenticators
 */
class SessionAuthenticatorImpl extends BaseAuthenticator {
    /**#@+
	 * @access private
	 */

	var $_loggedInKey;
	var $_groupsKey;
	var $_userKey;

    /**#@+
	 * @access public
	 */

	/**
	 * Main constructor.
	 */
	function SessionAuthenticatorImpl() {
	}

	/**
	 * Initializes the authenicator.
	 *
	 * @param Array $config Name/Value collection of config items.
	 */
	function init(&$config) {
		$this->_loggedInKey = $config['authenticator.session.logged_in_key'];
		$this->_groupsKey = $config['authenticator.session.groups_key'];
		$this->_userKey = $config['authenticator.session.user_key'];

		$user = isset($_SESSION[$this->_userKey]) ? $_SESSION[$this->_userKey] : "";
		$user = preg_replace('/[\\\\\\/:]/i', '', $user);

		foreach ($config as $key => $value) {
			if ($value === true || $value === false)
				continue;

			$value = str_replace('${user}', $user, $value);
			$config[$key] = $value;
		}
	}

	/**
	 * Returns a array with group names that the user is bound to.
	 *
	 * @return Array with group names that the user is bound to.
	 */
	function getGroups() {
		return isset($_SESSION[$this->_groupsKey]) ? $_SESSION[$this->_groupsKey] : "";
	}

	/**
	 * Returns true/false if the user is logged in or not.
	 *
	 * @return bool true/false if the user is logged in or not.
	 */
	function isLoggedin() {
		return isset($_SESSION[$this->_loggedInKey]) && checkBool($_SESSION[$this->_loggedInKey]);
	}

	/**#@-*/
}

?>
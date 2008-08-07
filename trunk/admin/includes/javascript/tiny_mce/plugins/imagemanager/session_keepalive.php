<?php
/**
 * session_keepalive.php
 *
 * @package MCImageManager.pages
 * @author Moxiecode
 * @copyright Copyright © 2005, Moxiecode Systems AB, All rights reserved.
 *
 * This page is requested once in awhile to keep the session alive and kicking.
 */

	// Keep it alive
	session_start();

	header('Location: themes/default/images/spacer.gif?rnd='. $_REQUEST['rnd']);
	die();
?>
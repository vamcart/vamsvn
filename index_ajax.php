<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2004 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: index_ajax.php 1.0.1 14.03.2006 6:08 Andrew Berezin $
//

	define('AJAX_APPLICATION_RUNNING', true);
//	if(defined('AJAX_APPLICATION_RUNNING')) {
//	}

	require('includes/classes/JsHttpRequest.php');
	$JsHttpRequest =& new Subsys_JsHttpRequest_Php('');

	require('includes/application_top.php');

	$JsHttpRequest->setEncoding($_SESSION['language_charset']);

	if (!isset($_GET['ajax_page']) || !xtc_not_null($_GET['ajax_page']) || !is_file(DIR_WS_MODULES . 'ajax/' . $_GET['ajax_page'] . '.php')) die('***ERROR*** Ajax page "' . $_GET['ajax_page'] . '" not define or not exist!!!');
	if(is_file(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $_GET['ajax_page'] . '.php'))
		require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $_GET['ajax_page'] . '.php');
	require(DIR_WS_MODULES . 'ajax/' . $_GET['ajax_page'] . '.php');

	exit;
?>
<?php
/* -----------------------------------------------------------------------------------------
   $Id: index_ajax.php 1321 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(index.php,v 1.84 2003/05/07); www.oscommerce.com
   (c) 2005	 Andrew Berezin (index.php,v 1.13 2003/08/17); zen-cart.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

	define('AJAX_APPLICATION_RUNNING', true);
//	if(defined('AJAX_APPLICATION_RUNNING')) {
//	}

	require('includes/classes/JsHttpRequest.php');
	$JsHttpRequest =& new JsHttpRequest('');

	require('includes/application_top.php');

	$JsHttpRequest->setEncoding($_SESSION['language_charset']);

	if (!isset($_GET['ajax_page']) || !xtc_not_null($_GET['ajax_page']) || !is_file(DIR_WS_MODULES . 'ajax/' . $_GET['ajax_page'] . '.php')) die('***ERROR*** Ajax page "' . $_GET['ajax_page'] . '" not define or not exist!!!');
	if(is_file(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $_GET['ajax_page'] . '.php'))
		require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $_GET['ajax_page'] . '.php');
	require(DIR_WS_MODULES . 'ajax/' . $_GET['ajax_page'] . '.php');

	exit;
?>
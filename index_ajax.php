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
	require_once('protect.inc.php');
	
	require('includes/application_top.php');

   // jQuery Image Upload Fix
   if ($_GET['q'] == 'includes/modules/ajax/ajaxUpload.php') $_POST['q'] = $_GET['q'];

	if($axhandler = (strtoupper($_SERVER['REQUEST_METHOD'])=='GET') ? $_GET['q'] : $_POST['q']) {
	  $axhandler = preg_replace('/[^A-Za-z0-9_\-\.\/]/', '', $axhandler);
	  $axhandler = realpath($axhandler) or die(); 
	  $directory = realpath(MODX_BASE_PATH.DIRECTORY_SEPARATOR.'/assets/snippets'); 
	  $axhandler = realpath($directory.str_replace($directory, '', $axhandler));
	  
	  if($axhandler && (strtolower(substr($axhandler,-4))=='.php')) {
		include_once($axhandler);
		exit;
	  }
	}	
    	
?>
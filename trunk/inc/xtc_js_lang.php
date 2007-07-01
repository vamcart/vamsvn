<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_js_lang.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (vam_js_lang.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_js_lang.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
   function vam_js_lang($message) {
   	
   	
   	$message = str_replace ("&auml;","%E4", $message );
   	$message = str_replace ("&Auml;","%C4", $message );
   	$message = str_replace ("&ouml;","%F6", $message );
   	$message = str_replace ("&Ouml;","%D6", $message );
   	$message = str_replace ("&uuml;","%FC", $message );
   	$message = str_replace ("&Uuml;","%DC", $message );
   	
   	return $message;
   	
   }
   
   
?>

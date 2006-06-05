<?php
/* -----------------------------------------------------------------------------------------
   $Id$

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2005 XT-Commerce


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
   function xtc_js_lang($message) {
   	
   	
   	$message = str_replace ("&auml;","%E4", $message );
   	$message = str_replace ("&Auml;","%C4", $message );
   	$message = str_replace ("&ouml;","%F6", $message );
   	$message = str_replace ("&Ouml;","%D6", $message );
   	$message = str_replace ("&uuml;","%FC", $message );
   	$message = str_replace ("&Uuml;","%DC", $message );
   	
   	return $message;
   	
   }
   
   
?>

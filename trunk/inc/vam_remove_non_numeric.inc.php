<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_remove_non_numeric.inc.php 829 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (vam_remove_non_numeric.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_remove_non_numeric.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
function vam_remove_non_numeric($var) 
	{	  
	  $var=preg_replace('/[^0-9]/','',$var);
	  return $var;
     }
 ?>
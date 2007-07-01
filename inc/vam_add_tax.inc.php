<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_add_tax.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (vam_add_tax.inc.php,v 1.4 2003/08/24); www.nextcommerce.org 
   (c) 2004 xt:Commerce (vam_add_tax.inc.php,v 1.4 2003/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
function vam_add_tax($price, $tax) 
	{ 
	  $price=$price+$price/100*$tax;
	  return $price;
	  }
 ?>
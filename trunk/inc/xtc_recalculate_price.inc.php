<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_recalculate_price.inc.php 1281 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (vam_recalculate_price.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_recalculate_price.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
function vam_recalculate_price($price, $discount) 
	{	  
	
	  $price=-100*$price/($discount-100)/100*$discount;
	  return $price;
      
	  }
 ?>
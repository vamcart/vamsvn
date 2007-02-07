<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_category_link.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (xtc_category_link.inc.php,v 1.4 2003/08/13); www.nextcommerce.org 
   (c) 2004 xt:Commerce (xtc_category_link.inc.php,v 1.4 2003/08/25); xt-commerce.com
 
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function xtc_category_link($cID,$cName='') {
		$cName = xtc_cleanName($cName);
		$link = 'cat=c'.$cID.'_'.$cName.'.html';
		return $link;
}
?>
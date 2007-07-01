<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_manufacturer_link.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (vam_manufacturer_link.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_manufacturer_link.inc.php,v 1.3 2003/08/13); xt-commerce.com
 
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function vam_manufacturer_link($mID,$mName='') {
		$mName = vam_cleanName($mName);
		$link = 'manu=m'.$mID.'_'.$mName.'.html';
		return $link;
}
?>
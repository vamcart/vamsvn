<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_category_link.inc.php 899 2005-04-29 02:40:57Z hhgag $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2005 XT-Commerce

 
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function xtc_category_link($cID,$cName='') {
		$cName = xtc_cleanName($cName);
		$link = 'cat=c'.$cID.'_'.$cName.'.html';
		return $link;
}
?>
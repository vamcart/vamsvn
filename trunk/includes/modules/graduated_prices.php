<?php
/* -----------------------------------------------------------------------------------------
   $Id: graduated_prices.php 1243 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com
   (c) 2003	 nextcommerce (graduated_prices.php,v 1.11 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (graduated_prices.php,v 1.11 2003/08/17); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$module_content = array ();

$staffel_data = $product->getGraduated();

if (sizeof($staffel_data) > 1) {
	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $staffel_data);
	// set cache ID

	$module->caching = 0;
	$module = $module->fetch(CURRENT_TEMPLATE.'/module/graduated_price.html');

	$info->assign('MODULE_graduated_price', $module);
}
?>
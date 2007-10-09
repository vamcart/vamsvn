<?php
/* -----------------------------------------------------------------------------------------
   $Id: also_purchased_products.php 1243 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(also_purchased_products.php,v 1.21 2003/02/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (also_purchased_products.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (also_purchased_products.php,v 1.9 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
// include needed files

$data = $product->getAlsoPurchased();
if (count($data) >= MIN_DISPLAY_ALSO_PURCHASED) {

	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $data);
	// set cache ID

	$module->caching = 0;
	$module = $module->fetch(CURRENT_TEMPLATE.'/module/also_purchased.html');

	$info->assign('MODULE_also_purchased', $module);

}
?>
<?php
/* -----------------------------------------------------------------------------------------
   $Id: cross_selling.php 1243 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(also_purchased_products.php,v 1.21 2003/02/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (also_purchased_products.php,v 1.9 2003/08/17); www.nextcommerce.org 
   (c) 2004 xt:Commerce (also_purchased_products.php,v 1.9 2005/10/25); xt-commerce.com 
   ---------------------------------------------------------------------------------------*/

if (XSELL_CART == 'true') {
$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$data = $product->getCrossSellsCart();
if (count($data) > 0) {
//выводит Также рекомендуем следующие товары:
    $module->assign('language', $_SESSION['language']);
    $module->assign('module_content', $data);
    // set cache ID
    $module->caching = 0;
    $module = $module->fetch(CURRENT_TEMPLATE.'/module/cross_selling_cart.html');
    $vamTemplate->assign('MODULE_cross_selling_cart', $module);
}
}
?>
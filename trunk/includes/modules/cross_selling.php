<?php

/* -----------------------------------------------------------------------------------------
   $Id: cross_selling.php 1243 2006-10-24 09:33:02Z VaM $ 

   VaM Shop - open source ecommerce solution
   http://vamshop.ru

   Copyright (c) 2006 VaM Shop

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(also_purchased_products.php,v 1.21 2003/02/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (also_purchased_products.php,v 1.9 2003/08/17); www.nextcommerce.org 
   (c) 2005 xt:Commerce (also_purchased_products.php,v 1.9 2005/10/25); www.xt-commerce.com 
   ---------------------------------------------------------------------------------------*/

$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$data = $product->getCrossSells();
if (count($data) > 0) {
//выводит Также рекомендуем следующие товары:
    $module_smarty->assign('language', $_SESSION['language']);
    $module_smarty->assign('module_content', $data);
    // set cache ID
    $module_smarty->caching = 0;
    $module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/cross_selling.html');
    $info_smarty->assign('MODULE_cross_selling', $module);
}
// reverse cross selling
if (ACTIVATE_REVERSE_CROSS_SELLING=='true') {
$module_smarty = new Smarty;
$ids = array();
// если текущий товар перекрестно ссылается на другой
if (count($data) > 0) {
foreach ($data as $v1) {
        foreach($v1[PRODUCTS] as $val){
                              $ids[$val[PRODUCTS_ID]] = true;
                              }
        }
}
        $data = array();
//  если на текущий товар имеется кросс-ссылка
$datarev = $product->getReverseCrossSells();
if (count($datarev) > 0) {
foreach ($datarev as $val) {
        if (!isset($ids[$val[PRODUCTS_ID]])) {
           $data[] = $val;
           }
        }
}
if (count($data) > 0) {
//выводит Обратите внимание на следующие товары:
    $module_smarty->assign('language', $_SESSION['language']);
    $module_smarty->assign('module_content', $data);
    // set cache ID
    $module_smarty->caching = 0;
    $module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/reverse_cross_selling.html');
    $info_smarty->assign('MODULE_reverse_cross_selling', $module);
}
}

?>
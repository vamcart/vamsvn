<?php
/* -----------------------------------------------------------------------------------------
   $Id: gift_cart.php 842 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(shopping_cart.php,v 1.32 2003/02/11); www.oscommerce.com
   (c) 2003     nextcommerce (shopping_cart.php,v 1.21 2003/08/17); www.nextcommerce.org
   (c) 2004     xt:Commerce (shopping_cart.php,v 1.21 2003/08/17); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:


   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

if (XSELL_CART == 'true') {
$cross_sell_cart = new vamTemplate;
$data = $product->getCrossSellsCart();
if (count($data) > 0) {
//выводит Также рекомендуем следующие товары:
$cross_sell_cart->caching = 0;
$cross_sell_cart->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$cross_sell_cart->assign('language', $_SESSION['language']);
$cross_sell_cart->assign('module_content', $data);
$module->assign('MODULE_cross_selling_cart_details', $cross_sell_cart->fetch(CURRENT_TEMPLATE.'/module/cross_selling_cart.html'));
}
}
?>
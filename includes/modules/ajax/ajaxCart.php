<?php

/* -----------------------------------------------------------------------------------------
  $Id: ajaxCart.php 1243 2007-02-06 20:41:56 VaM $

  VaM Shop - open source ecommerce solution
  http://vamshop.ru
  http://vamshop.com

  Copyright (c) 2007 VaM Shop
  -----------------------------------------------------------------------------------------
  based on:
  (c) 2006	 Andrew Berezin (loadStateXML.php,v 1.9 2003/08/17); zen-cart.com

  Released under the GNU General Public License
  --------------------------------------------------------------------------------------- */

$vamTemplate = new vamTemplate; 
$box_shopping_cart = false;
 
foreach ($_REQUEST as $key => $value)
    $_POST[$key] = $value;

require(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes/' . 'shopping_cart.php');

if (($i = strpos($box_shopping_cart, '<div id="divShoppingCartHeader">')) !== false) {
    $box_shopping_cart = substr($box_shopping_cart, $i + 32);
    $i = strrpos($box_shopping_cart, '</div>');
    $box_shopping_cart = substr($box_shopping_cart, 0, $i);
}

if (($i = strpos($box_shopping_cart, '<div id="divShoppingCart">')) !== false) {
    $box_shopping_cart = substr($box_shopping_cart, $i + 26);
    $i = strrpos($box_shopping_cart, '</div>');
    $box_shopping_cart = substr($box_shopping_cart, 0, $i);
}

if (isset($_POST['get_cart']) && $_POST['get_cart'] or isset($_GET['get_cart']) && $_GET['get_cart']) {
$ajax_cart = true;
require('shopping_cart.php');

if (($i = strpos($main_content, '<div id="ajax_cart">')) !== false) {
    $main_content = substr($main_content, $i + 20);
    $i = strrpos($main_content, '</div>');
    $main_content = substr($main_content, 0, $i);
}


$box_shopping_cart = $main_content;

$box_shopping_cart = $main_content;
}

$box_shopping_cart;


print $box_shopping_cart;
?>
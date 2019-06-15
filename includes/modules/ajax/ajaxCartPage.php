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
 
foreach ($_REQUEST as $key => $value)
    $_POST[$key] = $value;

$cart2 = str_replace('h3', 'h2', $box_shopping_cart);
$cart2 = str_replace('widget-title', 'title', $cart2);

$total = (int) ($_SESSION['cart']->show_total());
$qty = $_SESSION['cart']->show_quantity();


if (isset($_POST['get_cart']) && $_POST['get_cart']) {
   $aj_cart = true;
require('shopping_cart.php');
}

$arr = array("cart" => stripslashes($box_shopping_cart), 'cart2' => $cart2, "total" => $vamPrice->Format($total, true), "qty" => $qty, "cart3" => $main_content);


print json_encode($arr);
?>
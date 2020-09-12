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
$box_wishlist = false;
 
foreach ($_REQUEST as $key => $value)
    $_POST[$key] = $value;

require(DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes/' . 'wishlist.php');

if (($i = strpos($box_wishlist, '<div id="divWishlistHeader">')) !== false) {
    $box_wishlist = substr($box_wishlist, $i + 28);
    $i = strrpos($box_wishlist, '</div>');
    $box_wishlist = substr($box_wishlist, 0, $i);
}

if (($i = strpos($box_wishlist, '<div id="divWishlist">')) !== false) {
    $box_wishlist = substr($box_wishlist, $i + 22);
    $i = strrpos($box_wishlist, '</div>');
    $box_wishlist = substr($box_wishlist, 0, $i);
}

if (isset($_POST['get_wishlist']) && $_POST['get_wishlist'] or isset($_GET['get_wishlist']) && $_GET['get_wishlist']) {
$ajax_wishlist = true;
require('wishlist.php');

if (($i = strpos($main_content, '<div id="ajax_wishlist">')) !== false) {
    $main_content = substr($main_content, $i + 24);
    $i = strrpos($main_content, '</div>');
    $main_content = substr($main_content, 0, $i);
}


$box_wishlist = $main_content;

$box_wishlist = $main_content;
}

$box_wishlist;


print $box_wishlist;
?>
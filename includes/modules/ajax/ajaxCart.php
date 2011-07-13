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
   ---------------------------------------------------------------------------------------*/

  $vamTemplate = new vamTemplate;
  
   foreach( $_REQUEST as $key => $value) $_POST[$key]=$value;

  require(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes/' . 'shopping_cart.php');

  echo $box_shopping_cart;

?>
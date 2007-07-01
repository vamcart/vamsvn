<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_qty.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2004 xt:Commerce (vam_get_qty.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

   function vam_get_qty($products_id)  {

     if (strpos($products_id,'{'))  {
    $act_id=substr($products_id,0,strpos($products_id,'{'));
  } else {
    $act_id=$products_id;
  }

  return $_SESSION['actual_content'][$act_id]['qty'];

   }

?>
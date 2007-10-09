<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_products_mo_images.inc.php 1009 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2004 xt:Commerce (vam_get_products_mo_images.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
   function vam_get_products_mo_images($products_id = ''){
   $mo_query = "select image_id, image_nr, image_name from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . $products_id ."' ORDER BY image_nr";


   $products_mo_images_query = vamDBquery($mo_query);
   
  
   while ($row = vam_db_fetch_array($products_mo_images_query,true)) $results[($row['image_nr']-1)] = $row;
   if (is_array($results)) 
   {
       return $results;
   } else {
       return false;
   }
   }
   
   ?>
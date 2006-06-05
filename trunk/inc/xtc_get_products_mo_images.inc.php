<?PHP
/* -----------------------------------------------------------------------------------------
   $Id: xtc_get_products_mo_images.inc.php 1009 2005-07-11 16:19:29Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2004 XT-Commerce
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
   function xtc_get_products_mo_images($products_id = ''){
   $mo_query = "select image_id, image_nr, image_name from " . TABLE_PRODUCTS_IMAGES . " where products_id = '" . $products_id ."' ORDER BY image_nr";


   $products_mo_images_query = xtDBquery($mo_query);
   
  
   while ($row = xtc_db_fetch_array($products_mo_images_query,true)) $results[($row['image_nr']-1)] = $row;
   if (is_array($results)) 
   {
       return $results;
   } else {
       return false;
   }
   }
   
   ?>
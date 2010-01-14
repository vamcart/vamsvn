<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_show_category.inc.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com
   (c) 2003	 nextcommerce (vam_show_category.inc.php,v 1.4 2003/08/13); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (vam_show_category.inc.php,v 1.4 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

     function vam_show_category($counter) {
    global $foo, $categories_string, $id;
    
    $categories_string .= '<li class="CatLevel'.$foo[$counter]['level'].'';

    if ( ($id) && (in_array($counter, $id)) ) {
      $categories_string .=  ' Current">';
    } else {
      $categories_string .=  '">';
    }

      $categories_string .=  '<a href="';

        
	$cPath_new=vam_category_link($counter,$foo[$counter]['name']);
  
    $categories_string .= vam_href_link(FILENAME_DEFAULT, $cPath_new);
    $categories_string .= '">';

    // display category name
    $categories_string .= $foo[$counter]['name'];

    if (SHOW_COUNTS == 'true') {
      $products_in_category = vam_count_products_in_category($counter);
      if ($products_in_category > 0) {
        $categories_string .= '&nbsp;(' . $products_in_category . ')';
      }
    }

    $categories_string .= '</a></li>';

    if ($foo[$counter]['next_id']) {
        vam_show_category($foo[$counter]['next_id']);
    } else {
        $categories_string .= '';
    }

  }

?>
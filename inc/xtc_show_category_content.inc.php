<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_show_category_content.inc.php 899 2005-04-29 02:40:57Z hhgag $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_show_category_content.inc.php,v 1.4 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  function xtc_show_category_content($counter) {
    global $foo, $categories_string, $id;

    for ($a=0; $a<$foo[$counter]['level']; $a++) {
      $categories_string .= "&nbsp;&nbsp;";
    }

    $categories_string .= '<a href="';

    if ($foo[$counter]['parent'] == 0) {
      $cPath_new = 'cPath=' . $counter;
    } else {
      $cPath_new = 'cPath=' . $foo[$counter]['path'];
    }

    $categories_string .= xtc_href_link(FILENAME_DEFAULT, $cPath_new);
    $categories_string .= '">';

    if ( ($id) && (in_array($counter, $id)) ) {
      $categories_string .= '<b>';
    }

    // display category name
    $categories_string .= $foo[$counter]['name'];

    if ( ($id) && (in_array($counter, $id)) ) {
      $categories_string .= '</b>';
    }

    if (xtc_has_category_subcategories($counter)) {
      $categories_string .= '-&gt;';
    }

    $categories_string .= '</a>';

    //if (SHOW_COUNTS == 'true') {
    //  $products_in_category = xtc_count_products_in_category($counter);
    //  if ($products_in_category > 0) {
    //    $categories_string .= '&nbsp;(' . $products_in_category . ')';
    //  }
    //}

    $categories_string .= '<br />';

    if ($foo[$counter]['next_id']) {
      xtc_show_category_content($foo[$counter]['next_id']);
    }
  }
?>
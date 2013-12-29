<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_kupi_v_kredit.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(password_funcs.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_encrypt_password.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_encrypt_password.inc.php,v 1.4 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
  
	function signMessage($message, $salt, $iterationCount = 1102) {
	  $message = $message.$salt;
	  $result = md5($message).sha1($message);
	  for($i = 0; $i < $iterationCount; $i++)
		$result = md5($result);
		return $result;
	}

  function get_category_id($products_id) {
    $cPath = '';

    $category_query = "select p2c.categories_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p.products_id = '" . (int)$products_id . "' and p.products_status = '1' and p.products_id = p2c.products_id and p2c.categories_id != 0 limit 1";
    $category_query  = vam_db_query($category_query);
    if (vam_db_num_rows($category_query,true)) {
      $category = vam_db_fetch_array($category_query);

      $cat_id = $category['categories_id'];
	}
    return $cat_id;
  }

  function get_category_name($categories_id, $language = '') {

    if (empty($language)) $language = $_SESSION['languages_id'];

    $category_query = "select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . $categories_id . "' and language_id = '" . $language . "'";
    $category_query  = vamDBquery($category_query);
    $category = vam_db_fetch_array($category_query,true);

    return $category['categories_name'];
  }
  
 ?>
<?php
/* --------------------------------------------------------------
   $Id: new_attributes_change.php 899 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_attributes_change); www.oscommerce.com 
   (c) 2003	 nextcommerce (new_attributes_change.php,v 1.8 2003/08/14); www.nextcommerce.org
   (c) 2004 xt:Commerce (new_attributes_change.php,v 1.8 2003/08/14); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------
   Third Party contributions:
   New Attribute Manager v4b				Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/ 
   defined('_VALID_VAM') or die('Direct Access to this location is not allowed.');
   require_once(DIR_FS_INC .'vam_get_tax_rate.inc.php');
   require_once(DIR_FS_INC .'vam_get_tax_class_id.inc.php');
 //  require_once(DIR_FS_INC .'vam_format_price.inc.php');
  // I found the easiest way to do this is just delete the current attributes & start over =)
  // download function start
  $delete_sql = vam_db_query("SELECT products_attributes_id FROM ".TABLE_PRODUCTS_ATTRIBUTES." WHERE products_id = '" . $_POST['current_product_id'] . "'");
  while($delete_res = vam_db_fetch_array($delete_sql)) {
      $delete_download_sql = vam_db_query("SELECT products_attributes_filename FROM ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." WHERE products_attributes_id = '" . $delete_res['prducts_attributes_id'] . "'");
      $delete_download_file = vam_db_fetch_array($delete_download_sql);
      vam_db_query("DELETE FROM ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." WHERE products_attributes_id = '" . $delete_res['products_attributes_id'] . "'");
  }
  // download function end
  vam_db_query("DELETE FROM ".TABLE_PRODUCTS_ATTRIBUTES." WHERE products_id = '" . $_POST['current_product_id'] . "'" );

  // Simple, yet effective.. loop through the selected Option Values.. find the proper price & prefix.. insert.. yadda yadda yadda.
  for ($i = 0; $i < sizeof($_POST['optionValues']); $i++) {
    $query = "SELECT * FROM ".TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS." where products_options_values_id = '" . $_POST['optionValues'][$i] . "'";
    $result = vam_db_query($query);
    $matches = vam_db_num_rows($result);
    while ($line = vam_db_fetch_array($result)) {
      $optionsID = $line['products_options_id'];
    }

    $cv_id = $_POST['optionValues'][$i];
    $value_price =  $_POST[$cv_id . '_price'];

    if (PRICE_IS_BRUTTO=='true'){

    $value_price= ($value_price/((vam_get_tax_rate(vam_get_tax_class_id($_POST['current_product_id'])))+100)*100);
    }
          $value_price=vam_round($value_price,PRICE_PRECISION);


    $value_prefix = $_POST[$cv_id . '_prefix'];
    $value_sortorder = $_POST[$cv_id . '_sortorder'];
    $value_weight_prefix = $_POST[$cv_id . '_weight_prefix'];
    $value_model =  $_POST[$cv_id . '_model'];
    $value_stock =  $_POST[$cv_id . '_stock'];
    $value_weight =  $_POST[$cv_id . '_weight'];


      vam_db_query("INSERT INTO ".TABLE_PRODUCTS_ATTRIBUTES." (products_id, options_id, options_values_id, options_values_price, price_prefix ,attributes_model, attributes_stock, options_values_weight, weight_prefix,sortorder) VALUES ('" . $_POST['current_product_id'] . "', '" . $optionsID . "', '" . $_POST['optionValues'][$i] . "', '" . $value_price . "', '" . $value_prefix . "', '" . $value_model . "', '" . $value_stock . "', '" . $value_weight . "', '" . $value_weight_prefix . "','".$value_sortorder."')") or die(mysql_error());

    $products_attributes_id = vam_db_insert_id();

        if ($_POST[$cv_id . '_download_file'] != '') {
        	if (DOWNLOAD_ENABLED == 'true') {
        $value_download_file = $_POST[$cv_id . '_download_file'];
        $value_download_expire = $_POST[$cv_id . '_download_expire'];
        $value_download_count = $_POST[$cv_id . '_download_count'];

      $value_is_pin = $_POST[$cv_id . '_ispin'];
      $products_attributes_is_pin = isset($value_is_pin)?1:0;

        vam_db_query("INSERT INTO ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." (products_attributes_id, products_attributes_filename, products_attributes_maxdays, products_attributes_maxcount, products_attributes_is_pin) VALUES ('" . $products_attributes_id . "', '" . $value_download_file . "', '" . $value_download_expire . "', '" . $value_download_count . "', '" . $products_attributes_is_pin . "')") or die(mysql_error());
    }
   }
  }

?>
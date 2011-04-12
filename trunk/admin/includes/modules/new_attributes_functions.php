<?php
/* --------------------------------------------------------------
   $Id: new_attributes_functions.php 899 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_attributes_functions); www.oscommerce.com 
   (c) 2003	 nextcommerce (new_attributes_functions.php,v 1.8 2003/08/14); www.nextcommerce.org
   (c) 2004 xt:Commerce (new_attributes_functions.php,v 1.8 2003/08/14); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------
   Third Party contributions:
   New Attribute Manager v4b				Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/ 
defined('_VALID_VAM') or die('Direct Access to this location is not allowed.');
  // A simple little function to determine if the current value is already selected for the current product.
  function checkAttribute($current_value_id, $current_pid, $current_product_option_id) {
    global $attribute_value_price,$sortorder, $attribute_value_weight, $attribute_value_weight_prefix, $attribute_value_prefix, $attribute_value_model, $products_attributes_is_pin, $attribute_value_stock, $posCheck, $negCheck, $posCheck_weight, $negCheck_weight,$attribute_value_download_count, $attribute_value_download_expire,$attribute_value_download_filename;

    $query = "SELECT * FROM ".TABLE_PRODUCTS_ATTRIBUTES." where options_values_id = '" . $current_value_id . "' AND products_id = ' " . $current_pid . "' AND options_id = '" . $current_product_option_id . "'";
    $result = vam_db_query($query);
    $isFound = vam_db_num_rows($result);

    if ($isFound) {
      while($line = vam_db_fetch_array($result)) {
          // download function start
        $dl_sql = vam_db_query("SELECT products_attributes_maxdays, products_attributes_filename, products_attributes_maxcount, products_attributes_is_pin  FROM ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." WHERE products_attributes_id = '" . $line['products_attributes_id'] . "'") or die(mysql_error());
        $dl_res = vam_db_fetch_array($dl_sql);
        $attribute_value_download_filename= $dl_res['products_attributes_filename'];
        $attribute_value_download_count = $dl_res['products_attributes_maxcount'];
        $attribute_value_download_expire = $dl_res['products_attributes_maxdays'];
        $products_attributes_is_pin = $dl_res['products_attributes_is_pin'];
        // download function end
        $attribute_value_price = $line['options_values_price'];
        $sortorder = $line['sortorder'];
        $attribute_value_prefix = $line['price_prefix'];
        $attribute_value_weight_prefix = $line['weight_prefix'];
        $attribute_value_model = $line['attributes_model'];
        $attribute_value_stock = $line['attributes_stock'];
        $attribute_value_weight = $line['options_values_weight'];

        if ($attribute_value_prefix == '+') {
          $posCheck = ' SELECTED';
          $negCheck = '';
        } else {
          $posCheck = '';
          $negCheck = ' SELECTED';
        }
        if ($attribute_value_weight_prefix == '+') {
          $posCheck_weight = ' SELECTED';
          $negCheck_weight = '';
        } else {
          $posCheck_weight = '';
          $negCheck_weight = ' SELECTED';
        }
      }
      return true;
    } else {
      $attribute_value_price = '';
      $sortorder = '';
      $attribute_value_weight = '';
      $attribute_value_prefix = '';
      $attribute_value_weight_prefix = '';
      $attribute_value_model = '';
      $attribute_value_stock = '';
      $posCheck = '';
      $negCheck = '';
      $posCheck_weight = '';
      $negCheck_weight = '';
      return false;
    }
  }

  function rowClass($i) {
    $class1 = 'attributes-odd';
    $class2 = 'attributes-even';

    if ($i%2) {
      return $class1;
    } else {
     return $class2;
    }
  }

  // For Options Type Contribution
  function extraValues($current_value_id, $current_pid) {
    global $attribute_qty, $attribute_order, $attribute_linked, $attribute_prefix, $attribute_type, $isSelected;

    if ($isSelected) {
      $query = "SELECT * FROM ".TABLE_PRODUCTS_ATTRIBUTES." where options_values_id = '" . $current_value_id . "' AND products_id = '" . $current_pid . "'";
      $result = vam_db_query($query);
      while ($line = vam_db_fetch_array($result)) {
        $attribute_qty = $line['options_values_qty'];
        $attribute_order = $line['attribute_order'];
        $attribute_linked = $line['collegamento'];
        $attribute_prefix = $line['price_prefix'];
        $attribute_type = $line['options_type_id'];
      }
    } else {
      $attribute_qty = '1';
      $attribute_order = '100';
      $attribute_linked = '0';
      $attribute_prefix = '';
      $attribute_type = '';
    }
  }

  function displayOptionTypes($attribute_type) {
    global $isSelected;

    $availableTypes = array('Disabled' => '0', 'Select' => '1', 'Checkbox' => '2', 'Radio' => '3', 'Select Multiple' => '4', 'Text' => '5' );

    foreach($availableTypes as $name => $id) {
      if ($isSelected && $attribute_type == $id) {
          $SELECT = ' SELECTED';
      } else {
          $SELECT = '';
      }
      echo '<option value="' . $id . '"' . $SELECT . '>' . $name;
    }
  }

  // Get values for Linda McGrath's contribution
  function getSortCopyValues($current_value_id, $current_pid) {
    global $attribute_sort, $attribute_weight, $attribute_weight_prefix, $isSelected;

    if ($isSelected) {
      $query = "SELECT * FROM ".TABLE_PRODUCTS_ATTRIBUTES." where options_values_id = '" . $current_value_id . "' AND products_id = '" . $current_pid . "'";
      $result = vam_db_query($query);
      while ($line = vam_db_fetch_array($result)) {
        $attribute_sort = $line['products_options_sort_order'];
        $attribute_weight = $line['products_attributes_weight'];
        $attribute_weight_prefix = $line['products_attributes_weight_prefix'];
      }
    } else {
      $attribute_sort = '0';
      $attribute_weight = '';
      $attribute_weight_prefix = '';
    }
  }

  function sortCopyWeightPrefix($attribute_weight_prefix) {
    global $isSelected;

    $availablePrefixes = array('+', '-');
    foreach($availablePrefixes as $prefix) {
      if ($isSelected && $prefix == $attribute_weight_prefix) {
        $SELECT = ' SELECTED';
      } else {
          $SELECT = '';
      }
      echo '<option value="' . $prefix . '"' . $SELECT . '>' . $prefix;
    }
  }
?>
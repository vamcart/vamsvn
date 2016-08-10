<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_loworderfee.php 1002 2007-02-06 21:01:37 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_loworderfee.php,v 1.11 2003/02/14); www.oscommerce.com 
   (c) 2003	 nextcommerce (ot_loworderfee.php,v 1.7 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (ot_loworderfee.php,v 1.7 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   

  class ot_loworderfee {
    var $title, $output;

    function __construct() {
    	global $vamPrice;
      $this->code = 'ot_loworderfee';
      $this->title = MODULE_ORDER_TOTAL_LOWORDERFEE_TITLE;
      $this->description = MODULE_ORDER_TOTAL_LOWORDERFEE_DESCRIPTION;
      $this->enabled = ((MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS == 'true') ? true : false);
      $this->sort_order = MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER;

      $this->output = array();
    }

    function process() {
      global $order, $vamPrice;
      
      //include needed functions
      require_once(DIR_FS_INC . 'vam_calculate_tax.inc.php');
      
      if (MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE == 'true') {
        switch (MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION) {
          case 'national':
            if ($order->delivery['country_id'] == STORE_COUNTRY) $pass = true; break;
          case 'international':
            if ($order->delivery['country_id'] != STORE_COUNTRY) $pass = true; break;
          case 'both':
            $pass = true; break;
          default:
            $pass = false; break;
        }

        if ( ($pass == true) && ( ($order->info['total'] - $order->info['shipping_cost']) < MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER) ) {
          $tax = vam_get_tax_rate(MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS, $order->delivery['country']['id'], $order->delivery['zone_id']);
          $tax_description = vam_get_tax_description(MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS, $order->delivery['country']['id'], $order->delivery['zone_id']);



          

		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) {
		  $order->info['tax'] += vam_calculate_tax(MODULE_ORDER_TOTAL_LOWORDERFEE_FEE, $tax);
          $order->info['tax_groups'][TAX_ADD_TAX . "$tax_description"] += vam_calculate_tax(MODULE_ORDER_TOTAL_LOWORDERFEE_FEE, $tax);
          $order->info['total'] += MODULE_ORDER_TOTAL_LOWORDERFEE_FEE + vam_calculate_tax(MODULE_ORDER_TOTAL_LOWORDERFEE_FEE, $tax);
          $low_order_fee=vam_add_tax(MODULE_ORDER_TOTAL_LOWORDERFEE_FEE, $tax);
        }
        
        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		$low_order_fee=MODULE_ORDER_TOTAL_LOWORDERFEE_FEE;
		$order->info['tax'] += vam_calculate_tax(MODULE_ORDER_TOTAL_LOWORDERFEE_FEE, $tax);
        $order->info['tax_groups'][TAX_NO_TAX . "$tax_description"] += vam_calculate_tax(MODULE_ORDER_TOTAL_LOWORDERFEE_FEE, $tax);
		$order->info['subtotal'] += $low_order_fee;
        $order->info['total'] += $low_order_fee;
        }
        
        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] != 1) {
		$low_order_fee=MODULE_ORDER_TOTAL_LOWORDERFEE_FEE;
		$order->info['subtotal'] += $low_order_fee;
        $order->info['total'] += $low_order_fee;
        }



          $this->output[] = array('title' => $this->title . ':',
                                  'text' => $vamPrice->Format($low_order_fee, true),
                                  'value' => $low_order_fee);
        }
      }
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }

      return $this->_check;
    }

    function keys() {
      return array('MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS', 'MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER', 'MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE', 'MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER', 'MODULE_ORDER_TOTAL_LOWORDERFEE_FEE', 'MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION', 'MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS');
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS', 'true', '6', '1','vam_cfg_select_option(array(\'true\', \'false\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER', '4', '6', '2', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE', 'false', '6', '3', 'vam_cfg_select_option(array(\'true\', \'false\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, date_added) values ('MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER', '50','6', '4', 'currencies->format', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, date_added) values ('MODULE_ORDER_TOTAL_LOWORDERFEE_FEE', '5','6', '5', 'currencies->format', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION', 'both','6', '6', 'vam_cfg_select_option(array(\'national\', \'international\', \'both\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS', '0','6', '7', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }
?>
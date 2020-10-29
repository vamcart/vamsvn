<?php

/* -----------------------------------------------------------------------------------------
   $Id: russianpostapi.php 899 2010/05/29 13:24:46 oleg_vamsoft $

   Modified by Nagh
   http://www.tail.ru
   -----------------------------------------------------------------------------------------
   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(russianpostapi.php,v 1.39 2003/02/05); www.oscommerce.com
   (c) 2003	 nextcommerce (russianpostapi.php,v 1.7 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (russianpostapi.php,v 1.7 2003/08/24); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


class russianpostapi {

var $code, $title, $description, $icon, $enabled;

    function __construct() {
      global $order;

      $this->code = 'russianpostapi';
      $this->title = MODULE_SHIPPING_RUSSIANPOSTAPI_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_RUSSIANPOSTAPI_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_RUSSIANPOSTAPI_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'russianpost.png';
      $this->tax_class = MODULE_SHIPPING_RUSSIANPOSTAPI_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_RUSSIANPOSTAPI_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_RUSSIANPOSTAPI_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_RUSSIANPOSTAPI_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
        while ($check = vam_db_fetch_array($check_query)) {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $order->delivery['zone_id']) {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }


    function quote($method = '') {
      global $order,$shipping_weight;

		$store_zip_code = MODULE_SHIPPING_RUSSIANPOSTAPI_CITY;

		$total_weight = $shipping_weight*1000;      
      
      $url = file_get_contents("http://tariff.russianpost.ru/tariff/v1/calculate?json&object=3010&from=".$store_zip_code."&to=".$order->delivery['postcode']."&weight=".$total_weight."");
		$out = json_decode($url);
		
		//echo var_dump($out);

		$shipping_cost = 0;
		
	    if (isset($out->pay) && $out->pay > 0) {
	      $shipping_cost = $out->pay/100;    
	    }
      
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_RUSSIANPOSTAPI_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_RUSSIANPOSTAPI_TEXT_TITLE,
                                                     'cost' => MODULE_SHIPPING_RUSSIANPOSTAPI_HANDLING + $shipping_cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);

      if (!$order->delivery['postcode']) 
	    $this->quotes['error'] = 'Укажите почтовй индекс для расчёта стоимости доставки.';

      return $this->quotes;
    }


    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_RUSSIANPOSTAPI_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTAPI_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTAPI_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTAPI_CITY', '103426', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTAPI_HANDLING', '0', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTAPI_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTAPI_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTAPI_SORT_ORDER', '0', '6', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_RUSSIANPOSTAPI_STATUS', 'MODULE_SHIPPING_RUSSIANPOSTAPI_CITY', 'MODULE_SHIPPING_RUSSIANPOSTAPI_HANDLING','MODULE_SHIPPING_RUSSIANPOSTAPI_ALLOWED', 'MODULE_SHIPPING_RUSSIANPOSTAPI_TAX_CLASS', 'MODULE_SHIPPING_RUSSIANPOSTAPI_ZONE', 'MODULE_SHIPPING_RUSSIANPOSTAPI_SORT_ORDER');
    }
}

?>
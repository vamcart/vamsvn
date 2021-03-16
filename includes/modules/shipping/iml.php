<?php
/* -----------------------------------------------------------------------------------------
   $Id: iml.php 899 2020-02-06 21:19:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(iml.php,v 1.40 2003/02/05); www.oscommerce.com 
   (c) 2003	 nextcommerce (iml.php,v 1.7 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (iml.php,v 1.7 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


  class iml {
    var $code, $title, $description, $icon, $enabled;


    function __construct() {
      global $order;

      $this->code = 'iml';
      $this->title = MODULE_SHIPPING_IML_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_IML_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_IML_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'iml.png';
      $this->tax_class = MODULE_SHIPPING_IML_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_IML_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_IML_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_IML_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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

	    $login = MODULE_SHIPPING_IML_LOGIN;
	    $pass = MODULE_SHIPPING_IML_PASSWORD;
	    $cost = MODULE_SHIPPING_IML_COST;
	    $city_from = MODULE_SHIPPING_IML_CITY;
	    $shipping_cost = 0;
	    $total_weight = $shipping_weight;      
       $to_zip = $order->delivery['postcode'];
       $total = $order->info['total'];
       
       if ($login != '') {

//старый api
	//$url = "http://api.iml.ru/GetPrice?Job=C24&RegionFrom=".MODULE_SHIPPING_IML_CITY."&RegionTo=".$order->delivery['city']."&volume=1&Weigth=".$total_weight."&SpecialCode=1"; // url запроса
//новый api v5	
	$url = "http://api.iml.ru/v5/GetPrice?job=24&weigth=".$total_weight."&volume=1&regionFrom=".MODULE_SHIPPING_IML_CITY."&regionTo=".$order->delivery['city'];

	//логин и пароль, подходят от личного кабинета
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	//для получения ответа в формате XML раскомментируйте строку ниже
	//curl_setopt($curl, CURLOPT_HTTPHEADER, array("Accept:application/xml; charset=utf-8"));  
	curl_setopt($curl, CURLOPT_USERPWD, $login.":".$pass);
	curl_setopt($curl, CURLOPT_SSLVERSION, 3);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$response = curl_exec($curl);
	$result = json_decode($response, true); // результат запроса  
	
	//echo var_dump($response);
                
        $shipping_cost = $result['Price']+$cost;
        
      }
	    
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_IML_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_IML_TEXT_WAY,
                                                     'cost' => $shipping_cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);

      if (!$order->delivery['postcode']) 
	    $this->quotes['error'] = 'Укажите почтовый индекс для расчёта стоимости доставки.';

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_IML_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_IML_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_IML_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_IML_COST', '250', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_IML_CITY', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_IML_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_IML_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_IML_SORT_ORDER', '0', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_IML_LOGIN', '', '7', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_IML_PASSWORD', '', '8', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_IML_STATUS', 'MODULE_SHIPPING_IML_COST', 'MODULE_SHIPPING_IML_CITY', 'MODULE_SHIPPING_IML_ALLOWED', 'MODULE_SHIPPING_IML_TAX_CLASS', 'MODULE_SHIPPING_IML_ZONE', 'MODULE_SHIPPING_IML_SORT_ORDER', 'MODULE_SHIPPING_IML_LOGIN', 'MODULE_SHIPPING_IML_PASSWORD');
    }
  }
?>

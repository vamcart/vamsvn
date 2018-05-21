<?php

/* -----------------------------------------------------------------------------------------
   $Id: pek.php 899 2010/05/29 13:24:46 oleg_vamsoft $

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
   (c) 2002-2003 osCommerce(pek.php,v 1.39 2003/02/05); www.oscommerce.com
   (c) 2003	 nextcommerce (pek.php,v 1.7 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (pek.php,v 1.7 2003/08/24); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


class pek {

var $code, $title, $description, $icon, $enabled;

    function __construct() {
      global $order;

      $this->code = 'pek';
      $this->title = MODULE_SHIPPING_PEK_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_PEK_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_PEK_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'pek.png';
      $this->tax_class = MODULE_SHIPPING_PEK_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_PEK_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_PEK_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_PEK_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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

	    $sender_city = MODULE_SHIPPING_PEK_CITY;

	    //echo var_dump($sender_city);
	    
	    // Определяем ID номер города отправителя
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "https://pecom.ru/ru/calc/towns.php");
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    
	    $senderCity = json_decode($data, $assoc=true);

	    //if(!$senderCity[$sender_city]) {
		  //echo "Невозможно рассчитать стоимость доставки ПЭК. Свяжитесь с нами для уточнения стоимости доставки.";
	    //}
	    	    
	    $city_id = array_search($sender_city, $senderCity[$sender_city]);

		//echo var_dump($senderCity[$sender_city]);	
		//echo var_dump($city_id);

	    // Определяем ID номер города получаетеля
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "https://pecom.ru/ru/calc/towns.php");
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    
	    $delivery_city = json_decode($data, $assoc=true);
	    $deliveryCity = $order->delivery['city'];

	    //if(!$senderCity[$sender_city]) {
		  //echo "Невозможно рассчитать стоимость доставки ПЭК. Свяжитесь с нами для уточнения стоимости доставки.";
	    //}
	    	    
	    $delivery_city_id = array_search($deliveryCity, $delivery_city[$deliveryCity]);

	    //echo var_dump($deliveryCity);
	    //echo var_dump($delivery_city_id);
	    
	    //echo var_dump($order['OrderProduct']);
	    
	    $num = 0;
	    $shipping_cost = 0;
	    $goods_list = null;

       foreach ($order->products as $products)
	    {

	    $goods_list .= "&places[".$num."][]=".($products['width']/100).
									"&places[".$num."][]=".($products['length']/100).
									"&places[".$num."][]=".($products['height']/100).
									"&places[".$num."][]=".$products['volume'].
									"&places[".$num."][]=".$products['weight']*$products['qty'].
									"&places[".$num."][]=1&places[".$num."][]=1";
		
	    $num++;
	    }	
	    
	    //echo var_dump($goods_list);
			
	    // Получаем расчёт стоимости доставки
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "http://calc.pecom.ru/bitrix/components/pecom/calc/ajax.php?take[town]=".$city_id."&deliver[town]=".$delivery_city_id.$goods_list."");
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);

	    $senderCity = json_decode($data, $assoc=true);

	    //if(!$senderCity["deliver"][2]) {
		  //echo "Невозможно рассчитать стоимость доставки ПЭК. Свяжитесь с нами для уточнения стоимости доставки.";
	    //}
	    
	    //echo var_dump($senderCity);

		$shipping_cost = $senderCity["deliver"][2];
      
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_PEK_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_PEK_TEXT_TITLE,
                                                     'cost' => MODULE_SHIPPING_PEK_HANDLING + $shipping_cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);

      return $this->quotes;
    }


    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_PEK_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_PEK_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_PEK_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_PEK_CITY', 'Москва', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_PEK_HANDLING', '0', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_PEK_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_PEK_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_PEK_SORT_ORDER', '0', '6', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_PEK_STATUS', 'MODULE_SHIPPING_PEK_CITY', 'MODULE_SHIPPING_PEK_HANDLING','MODULE_SHIPPING_PEK_ALLOWED', 'MODULE_SHIPPING_PEK_TAX_CLASS', 'MODULE_SHIPPING_PEK_ZONE', 'MODULE_SHIPPING_PEK_SORT_ORDER');
    }
}

?>
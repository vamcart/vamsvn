<?php
/* -----------------------------------------------------------------------------------------
   $Id: russianpostems.php 899 2010/05/29 13:24:46 oleg_vamsoft $

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
   (c) 2002-2003 osCommerce(russianpostems.php,v 1.39 2003/02/05); www.oscommerce.com
   (c) 2003	 nextcommerce (russianpostems.php,v 1.7 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (russianpostems.php,v 1.7 2003/08/24); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


  class russianpostems {
    var $code, $title, $description, $icon, $enabled;


    function russianpostems() {
      global $order;

      $this->code = 'russianpostems';
      $this->title = MODULE_SHIPPING_RUSSIANPOSTEMS_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_RUSSIANPOSTEMS_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_RUSSIANPOSTEMS_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'shipping_ems.jpg';
      $this->tax_class = MODULE_SHIPPING_RUSSIANPOSTEMS_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_RUSSIANPOSTEMS_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_RUSSIANPOSTEMS_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_RUSSIANPOSTEMS_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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


// class methods
    function quote($method = '') {
      global $order, $shipping_weight, $total_count;

        $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_RUSSIANPOSTEMS_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_RUSSIANPOSTEMS_TEXT_NOTE)));

        if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);

        $urlCities = 'http://emspost.ru/api/rest?method=ems.get.locations&type=cities';

        // create curl resource
        $ch = curl_init();

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // set url
		curl_setopt($ch, CURLOPT_URL, $urlCities);
		$outCities = curl_exec($ch);


		//---- get city list
        $tocity = $order->delivery['city'];
        $citiesList = json_decode(utf8_encode($outCities), true);
        foreach ($citiesList['rsp']['locations'] as $city){
          if (strtolower($city['name']) == strtolower(MODULE_SHIPPING_RUSSIANPOSTEMS_CITY)){
            $from_city = $city['value'];
          }
          if (strtolower($city['name']) == strtolower($tocity)){
            $to_city = $city['value'];
          }
        }
    if ($from_city === null){
      $this->quotes['error']='Доставка из города '.MODULE_SHIPPING_RUSSIANPOSTEMS_CITY.' не производится!';
      return $this->quotes;
    } else if ($to_city === null){
      $this->quotes['error']='Доставка в город '.$order->delivery['city'].' не производится!';
      return $this->quotes;
    }
    //----

        
//Проверка на максимальный вес    
$urlWeight = 'http://emspost.ru/api/rest/?method=ems.get.max.weight';        
    
// create curl resource
        $ch = curl_init();

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // set url
        curl_setopt($ch, CURLOPT_URL, $urlWeight);
        $outWeight = curl_exec($ch);
    
        $WeightList = json_decode($outWeight, true);

       foreach ($WeightList as $weight){
       $max_weight = $weight['max_weight'];

    if ($shipping_weight > $max_weight){
      $this->quotes['error']='Превышен максимально возможный вес одного отправления. Разбейте заказ на несколько частей.';
      return $this->quotes;

}
}

        $url = 'http://emspost.ru/api/rest?method=ems.calculate&from='.$from_city.'&to='.$to_city.'&weight='.$shipping_weight;
        
        curl_setopt($ch, CURLOPT_URL, $url);
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);

        $contents = $output;
        $contents = utf8_encode($contents);
        $results = json_decode($contents, true);

        if ($results['rsp']['stat'] == 'fail'){
          $this->quotes['error'] = 'Ошибка: '.$results['rsp']['err']['msg'];
		  return $this->quotes;
		}
	$shPrice = $results['rsp']['price'];
	if (MODULE_SHIPPING_RUSSIANPOSTEMS_DCVAL_PERCENT >0){
	  $shPrice += $order->info['subtotal']*MODULE_SHIPPING_RUSSIANPOSTEMS_DCVAL_PERCENT/100;
	}
        $this->quotes['methods'][key($this->quotes['methods'])]['cost'] = $shPrice + MODULE_SHIPPING_RUSSIANPOSTEMS_HANDLING;
        $dlvr_min = $results['rsp']['term']['min'];
        $dlvr_max = $results['rsp']['term']['max'];
        if (($dlvr_min > 0) AND ( $dlvr_max > 0)){
          if ($dlvr_min == $dlvr_max){
            $this->quotes['methods'][key($this->quotes['methods'])]['title'] .= '<br /><i>(срок доставки '.$dlvr_max;
          } else {
            $this->quotes['methods'][key($this->quotes['methods'])]['title'] .= '<br /><i>(срок доставки '.$dlvr_min.' - '.$dlvr_max;
          }
          if ($dlvr_max == 1){
            $this->quotes['methods'][key($this->quotes['methods'])]['title'] .= ' день';
          } else if (($dlvr_max > 1) and ($dlvr_max < 5)){
            $this->quotes['methods'][key($this->quotes['methods'])]['title'] .= ' дня';
          } else {
            $this->quotes['methods'][key($this->quotes['methods'])]['title'] .= ' дней';
          }
          $this->quotes['methods'][key($this->quotes['methods'])]['title'] .= ') </i>';
        }

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }


      return $this->quotes;
    }


    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_RUSSIANPOSTEMS_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTEMS_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTEMS_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTEMS_CITY', 'Москва', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTEMS_HANDLING', '0', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTEMS_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTEMS_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTEMS_SORT_ORDER', '0', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTEMS_DCVAL_PERCENT', '0', '6', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_RUSSIANPOSTEMS_STATUS', 'MODULE_SHIPPING_RUSSIANPOSTEMS_CITY', 'MODULE_SHIPPING_RUSSIANPOSTEMS_HANDLING','MODULE_SHIPPING_RUSSIANPOSTEMS_ALLOWED', 'MODULE_SHIPPING_RUSSIANPOSTEMS_TAX_CLASS', 'MODULE_SHIPPING_RUSSIANPOSTEMS_ZONE', 'MODULE_SHIPPING_RUSSIANPOSTEMS_SORT_ORDER', 'MODULE_SHIPPING_RUSSIANPOSTEMS_DCVAL_PERCENT');
    }
  }
?>

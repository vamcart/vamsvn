<?php
/* -----------------------------------------------------------------------------------------
   $Id: boxberry.php 899 2020-02-06 21:19:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(boxberry.php,v 1.40 2003/02/05); www.oscommerce.com 
   (c) 2003	 nextcommerce (boxberry.php,v 1.7 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (boxberry.php,v 1.7 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


  class boxberry {
    var $code, $title, $description, $icon, $enabled;


    function __construct() {
      global $order;

      $this->code = 'boxberry';
      $this->title = MODULE_SHIPPING_BOXBERRY_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_BOXBERRY_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_BOXBERRY_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'boxberry.png';
      $this->tax_class = MODULE_SHIPPING_BOXBERRY_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_BOXBERRY_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_BOXBERRY_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_BOXBERRY_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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

	    $token = MODULE_SHIPPING_BOXBERRY_TOKEN;
	    $cost = MODULE_SHIPPING_BOXBERRY_COST;
	    $shipping_cost = 0;
	    $total_weight = $shipping_weight*1000;      
       $to_zip = $order->delivery['postcode'];
       $total = $order->info['total'];
       
       if ($token != '') {

        $url="http://api.boxberry.ru/json.php?token=".$token."&method=DeliveryCosts&weight=".$total_weight."&target=&ordersum=".$total."&deliverysum=".$cost."&targetstart=&height=&width=&depth=&zip=".$to_zip."";

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $url);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);  

        $contents = $output;
        $results = json_decode($contents, true); 

        //echo var_dump($results);
                
        $shipping_cost = $results['price']+$cost;
        
      }
	    
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_BOXBERRY_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_BOXBERRY_TEXT_WAY,
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
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_BOXBERRY_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_BOXBERRY_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRY_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRY_COST', '250', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_BOXBERRY_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_BOXBERRY_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRY_SORT_ORDER', '0', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRY_TOKEN', 'd6f33e419c16131e5325cbd84d5d6000', '7', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_BOXBERRY_STATUS', 'MODULE_SHIPPING_BOXBERRY_COST','MODULE_SHIPPING_BOXBERRY_ALLOWED', 'MODULE_SHIPPING_BOXBERRY_TAX_CLASS', 'MODULE_SHIPPING_BOXBERRY_ZONE', 'MODULE_SHIPPING_BOXBERRY_SORT_ORDER', 'MODULE_SHIPPING_BOXBERRY_TOKEN');
    }
  }
?>

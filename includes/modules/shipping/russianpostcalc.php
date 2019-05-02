<?php
/* -----------------------------------------------------------------------------------------
   $Id: flat.php 899 2007-02-06 21:19:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(flat.php,v 1.40 2003/02/05); www.oscommerce.com 
   (c) 2003	 nextcommerce (flat.php,v 1.7 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (flat.php,v 1.7 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


  class russianpostcalc {
    var $code, $title, $description, $icon, $enabled;


    function __construct() {
      global $order;

      $this->code = 'russianpostcalc';
      $this->title = MODULE_SHIPPING_RUSSIANPOSTCALC_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_RUSSIANPOSTCALC_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_RUSSIANPOSTCALC_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'russianpost.png';
      $this->tax_class = MODULE_SHIPPING_RUSSIANPOSTCALC_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_RUSSIANPOSTCALC_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_RUSSIANPOSTCALC_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_RUSSIANPOSTCALC_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
      global $order, $shipping_weight;

		$api_key = MODULE_SHIPPING_RUSSIANPOSTCALC_API_KEY;
		$api_password = MODULE_SHIPPING_RUSSIANPOSTCALC_API_PASSWORD;
		$store_zip_code = MODULE_SHIPPING_RUSSIANPOSTCALC_ZIP;

		$total_weight = $shipping_weight;
		
	    //запрос расчета стоимости отправления из 101000 МОСКВА во ВЛАДИМИР 600000.
	    $ret = $this->russianpostcalc_api_calc($api_key, $api_password, $store_zip_code, $order->delivery['postcode'], $total_weight, $order->info['total_value']);
	    
	    //if (isset($ret['msg']['type']) && $ret['msg']['type'] == "done")
	    //{
	        //echo "success! codepage: UTF-8 <br/>";
	        //print_r($ret);
	        //echo "<br/>";
	    //}else
	    //{
	        //echo "error! codepage: UTF-8 <br/>";
	        //print_r($ret);
	        //echo "<br/>";
	    //}
	
	    $shipping_cost = 0;
	    
	    if (isset($ret['calc']) && $ret['calc'][1]['cost'] > 0) {
	      $shipping_cost = $ret['calc'][1]['cost'];    
	    }
      
      
		if (MODULE_SHIPPING_RUSSIANPOSTCALC_COST > 0) $shipping_cost = $shipping_cost + MODULE_SHIPPING_RUSSIANPOSTCALC_COST;      
      
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_RUSSIANPOSTCALC_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_RUSSIANPOSTCALC_TEXT_TITLE,
                                                     'cost' => $shipping_cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_RUSSIANPOSTCALC_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTCALC_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTCALC_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTCALC_COST', '150', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTCALC_API_KEY', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTCALC_API_PASSWORD', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTCALC_ZIP', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTCALC_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTCALC_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTCALC_SORT_ORDER', '0', '6', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_RUSSIANPOSTCALC_STATUS', 'MODULE_SHIPPING_RUSSIANPOSTCALC_COST','MODULE_SHIPPING_RUSSIANPOSTCALC_API_KEY','MODULE_SHIPPING_RUSSIANPOSTCALC_API_PASSWORD','MODULE_SHIPPING_RUSSIANPOSTCALC_ZIP','MODULE_SHIPPING_RUSSIANPOSTCALC_ALLOWED', 'MODULE_SHIPPING_RUSSIANPOSTCALC_TAX_CLASS', 'MODULE_SHIPPING_RUSSIANPOSTCALC_ZONE', 'MODULE_SHIPPING_RUSSIANPOSTCALC_SORT_ORDER');
    }
    
private function _russianpostcalc_api_communicate($request)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://russianpostcalc.ru/api_v1.php");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($curl);
    
    curl_close($curl);
    if($data === false)
    {
	return "10000 server error";
    }
    
    $js = json_decode($data, $assoc=true);
    return $js;
}

private function russianpostcalc_api_calc($apikey, $password, $from_index, $to_index, $weight, $ob_cennost_rub)
{
    $request = array("apikey"=>$apikey, 
                        "method"=>"calc", 
                        "from_index"=>$from_index,
                        "to_index"=>$to_index,
                        "weight"=>$weight,
                        "ob_cennost_rub"=>$ob_cennost_rub
                    );

    if ($password != "")
    {
        //если пароль указан, аутентификация по методу API ключ + API пароль.
        $all_to_md5 = $request;
        $all_to_md5[] = $password;
        $hash = md5(implode("|", $all_to_md5));
        $request["hash"] = $hash;
    }

    $ret = $this->_russianpostcalc_api_communicate($request);

    return $ret;
}    
    
  }
?>

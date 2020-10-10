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


  class sdekpvz {
    var $code, $title, $description, $icon, $enabled;


    function __construct() {
      global $order;

      $this->code = 'sdekpvz';
      $this->title = MODULE_SHIPPING_SDEKPVZ_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_SDEKPVZ_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_SDEKPVZ_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'cdek.png';
      $this->tax_class = MODULE_SHIPPING_SDEKPVZ_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_SDEKPVZ_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_SDEKPVZ_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_SDEKPVZ_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
        
		$aut_login = MODULE_SHIPPING_SDEKPVZ_API_LOGIN;
		$auth_Password = MODULE_SHIPPING_SDEKPVZ_API_PASSWORD;
		$date_Execute = date('Y-m-d');			
		$sender_postcode = MODULE_SHIPPING_SDEKPVZ_ZIP;
		$total_weight = $shipping_weight;
		
		// узнаем id города
		if($order->delivery['city'] == "спб" || $order->delivery['city'] == "СПБ") $order->delivery['city'] = "Санкт-Петербург";
	    if($order->delivery['city'] == "Ростов" || $order->delivery['city'] == "ростов" || $order->delivery['city'] == "Ростов на дону" || $order->delivery['city'] == "ростов на дону") $order->delivery['city'] = "ростов-на-дону";
		

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "http://api.cdek.ru/city/getListByTerm/json.php?q=".$order->delivery['city']);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    
	    $senderCity = json_decode($data, $assoc=true);
	    $senderCityId = $senderCity["geonames"][0]["id"];
	    
		$receiverCityId = $senderCityId;
		
	    //запрос расчета стоимости отправления 
	    $ret = $this->sdekpvz_api_calc($aut_login, $auth_Password, $date_Execute, $sender_postcode, $order->delivery['postcode'], $total_weight, $receiverCityId);
		//print_r	($ret);	
	    $shipping_cost = 0;
	         
      // если вес больше указаного в переменой то: 
	  
	    $min_ves = 0.1; // вес после которого цена выше
	    
		if ($ret['result']['price'] > 0) {
		$shipping_cost = $ret['result']['price'];
		}

		if ($shipping_weight >= $min_ves) {			
		$shipping_cost = $shipping_cost + MODULE_SHIPPING_SDEKPVZ_COST;
		} else {
        $shipping_cost = $shipping_cost + MODULE_SHIPPING_SDEKPVZ_COST_2; 
        }
						
		// Расчет скидки
		
		$sum_akcii = MODULE_SHIPPING_SDEK_MIN_SUM; //сумма от которой начинается скидка
		$skidka = MODULE_SHIPPING_SDEK_PROCENT; // скидка на доставку
		$min_sum = MODULE_SHIPPING_SDEK_MIN_SUM_ORDER; // сумма от которой действует доставка
		$min_dozakaz = $sum_akcii - $_SESSION['cart']->show_total();
		
		if ($_SESSION['cart']->show_total() > $sum_akcii) {		
		$shipping_skidka = ($shipping_cost / 100) * $skidka;
		$shipping_cost = $shipping_cost - $shipping_skidka;
		$shipping_txt_min = '<b>Выберите пункт выдачи:</b>';
		} else {
		$shipping_txt_min = 'При сумме товаров от <b>' . $sum_akcii . '</b> руб., на эту доставку действует скидка <font color="red"><b>' . $skidka . '%</b></font>. Осталось добавить товаров мин. на: ' .$min_dozakaz . ' руб. <br /> <b>Выберите пункт выдачи:</b>';
		}	

        //if ($_SESSION['cart']->show_total() > $sum_akcii) {     
	    //$skidka_text = ', применена скидка <b>' .$skidka. '%</b> [-' . $shipping_skidka . ' руб.]</b>';	
        //}			
	 
		$min_vremya = $ret['result']['deliveryPeriodMin'];
		$max_vremya = $ret['result']['deliveryPeriodMax'];

        // запрос вывода списка пвз
		$ret_pvz = $this->sdekpvz_api_pvz($receiverCityId);
		
      //echo var_dump($ret_pvz);		
		
		$count_pvz = count($ret_pvz);
		$company = 'СДЭК';		
							
		if(isset($_POST['pvz'])) {
			$_SESSION['pvz'] = $_POST['pvz'];
		} else {
			unset($_SESSION['pvz']);
		}
		
		$check_city_pvz = vam_db_query("select distinct city, lat from markers_geocod where name = '" . $_SESSION['pvz'] . "' and company = '" . $company . "'");
		$city_pvz = vam_db_fetch_array($check_city_pvz);
				
		
		// получение списка пвз, занесение в базу		
		$value = 0; 
	
		if ($count_pvz < 1500) {  // чтобы вдруг какой нибудь весь огромный список всех городов не загрузился
		foreach($ret_pvz as $key => $value) {
		if($ret_pvz[$key]['attributes']['NAME'] != '') {
		$name_pvz1 = $ret_pvz[$key]['attributes']['NAME'] . ' (' . $ret_pvz[$key]['attributes']['ADDRESS'] . ')';
		$name_pvz[] = array('id' => $name_pvz1, 'text' => $name_pvz1);
		$city = $ret_pvz[$key]['attributes']['CITY']; 		
        				
		$worktime = $ret_pvz[$key]['attributes']['WORKTIME']; 
        		
		if ($city_pvz == '' && $_POST['pvz'] != '') {
        vam_db_query("insert into markers_geocod (name, address, city, company, worktime, telephon, lng, lat) values ('" . $name_pvz1 . "', '" . $ret_pvz[$key]['attributes']['ADDRESS'] . "', '" . $city . "', '" . $company . "', '" . $worktime . "', '" . $ret_pvz[$key]['attributes']['PHONE'] . "', '" . $ret_pvz[$key]['attributes']['COORDX'] . "', '" . $ret_pvz[$key]['attributes']['COORDY'] . "')");	
		}		
        $value++;		
		}
		}
		}
        		
		
        // добавление в файл результатов геокодирования
		
		if (!$_GET['oID'])
        require_once('includes/modules/yandex-map/geokoder_yandex_kart.php');
		
        // список пвз, выпадающее меню
        $pvz = vam_draw_pull_down_menu('pvz', $name_pvz, '', 'id="pvz_sdek" class="form-control"');
		
		if($_POST['pvz'] != '') $pvz_title = ', ' . $_POST['pvz'] . '';		

        $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_SDEKPVZ_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_SDEKPVZ_TEXT_TITLE_2 . $pvz_title . ' ' . $min_vremya . ($max_vremya > 0 ? '-'.$max_vremya.vam_format_by_count($max_vremya, ' день', ' дня', ' дней'):null) . '' . $skidka_text,
                                                     'cost' => $shipping_cost)));
													 				
				
		
	    $this->quotes['info'] .= $shipping_txt_min . '<br />';		

        $this->quotes['info'] .= $pvz;		

	  if ($this->tax_class > 0) {
		$this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
	  }

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);
	  
	  if ($error == true) 
	  $this->quotes['error'] = $err_msg;
  
     if ($receiverCityId == '') $this->quotes['error'] = 'До пункта выдачи. Возможно нужно правильно ввести город, чтобы был расчет стоимости.';
  
      // Если символов в индексе меньше 6, или не выбран регион, или стоимость доставки меньше указаной в переменной MODULE_SHIPPING_SDEKPVZ_COST, то:
	  
	  if ((strlen($order->delivery['city']) == '')) {

      $this->quotes['error'] = 'До пункта выдачи. Для расчета этой доставки введите как минимум <b>город</b>';	  
	  
	  } elseif ($_SESSION['cart']->show_total() < $min_sum) {
	
	  $this->quotes['error'] = 'До пункта выдачи. Действует при сумме товаров <b>от ' . $min_sum . ' руб.</b>';
	  } elseif (isset($ret['error'][0]['code']) || $shipping_cost <= MODULE_SHIPPING_SDEKPVZ_COST) {
		  
	  $this->quotes['error'] = 'Пункты выдачи. Доставка в этом направлении не осуществляется (или попробуйте <b>ввести также индекс</b>)'; 
	  } 
	  

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_SDEKPVZ_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_SDEKPVZ_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SDEKPVZ_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SDEKPVZ_COST', '150', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SDEKPVZ_COST_2', '100', '6', '0', now())");
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SDEKPVZ_API_LOGIN', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SDEKPVZ_API_PASSWORD', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SDEKPVZ_ZIP', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_SDEKPVZ_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_SDEKPVZ_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SDEKPVZ_SORT_ORDER', '0', '6', '0', now())");
	  
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SDEK_MIN_SUM', '', '6', '0', now())");
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SDEK_PROCENT', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SDEK_MIN_SUM_ORDER', '100', '6', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_SDEKPVZ_STATUS', 'MODULE_SHIPPING_SDEKPVZ_COST', 'MODULE_SHIPPING_SDEKPVZ_COST_2', 'MODULE_SHIPPING_SDEKPVZ_API_LOGIN', 'MODULE_SHIPPING_SDEKPVZ_API_PASSWORD', 'MODULE_SHIPPING_SDEKPVZ_ZIP','MODULE_SHIPPING_SDEKPVZ_ALLOWED', 'MODULE_SHIPPING_SDEKPVZ_TAX_CLASS', 'MODULE_SHIPPING_SDEKPVZ_ZONE', 'MODULE_SHIPPING_SDEKPVZ_SORT_ORDER', 'MODULE_SHIPPING_SDEK_MIN_SUM', 'MODULE_SHIPPING_SDEK_PROCENT', 'MODULE_SHIPPING_SDEK_MIN_SUM_ORDER');
    }
    
private function _sdekpvz_api_communicate($request)
{

if ($_SESSION['cart']->show_total() > $min_sum) {
	
	
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'http://api.edostavka.ru/calculator/calculate_price_by_json.php');
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_TIMEOUT, 5);
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    $data = curl_exec($curl);
    
    curl_close($curl);
    if($data === false)
    {
	return '10000 server error';
    }
    
    $js = json_decode($data, $assoc=true);
    return $js;
	
	}
}

private function sdekpvz_api_calc($autlogin, $authPassword, $dateExecute, $senderPostcode, $receiverPostcode, $weight, $idCity)
{	
	    if ($authPassword != '') {
        //аутентификация
        $secure = md5($dateExecute . '&' . $authPassword);
		
    }
    $request = array('version' => '1.0',
					'authLogin' => $autlogin,
					'secure' => $secure,
					'dateExecute' => $dateExecute, 
					'senderCityPostCode' => $senderPostcode,
					'receiverCityPostCode' => $receiverPostcode,
					'receiverCityId' => $idCity,
					'tariffId' => '136',
					'goods' => array(array('weight' => $weight,
										   'volume' => '0.01' )));


	
	 //print_r($request);

    $ret = $this->_sdekpvz_api_communicate($request);
    
    //echo var_dump($ret);
	
	return $ret;
}   

 private function sdekpvz_api_pvz($cityId) {  
	$ret_pvz = file_get_contents("https://integration.cdek.ru/pvzlist.php?cityid=" . $cityId);

	// разбор xml
    $p = xml_parser_create();
    xml_parse_into_struct($p, $ret_pvz, $vals, $index);

	//print_r($vals);
   
    return $vals; 
 }
    
  }
?>

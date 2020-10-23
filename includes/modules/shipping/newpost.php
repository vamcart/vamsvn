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


  class newpost {
    var $code, $title, $description, $icon, $enabled;


    function __construct() {
      global $order;

      $this->code = 'newpost';
      $this->title = MODULE_SHIPPING_NEWPOST_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_NEWPOST_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_NEWPOST_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'newpost.png';
      $this->tax_class = MODULE_SHIPPING_NEWPOST_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_NEWPOST_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_NEWPOST_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_NEWPOST_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
        
		$aut_login = MODULE_SHIPPING_NEWPOST_API_LOGIN;
		$auth_Password = MODULE_SHIPPING_NEWPOST_API_PASSWORD;
		$date_Execute = date('Y-m-d');			
		$sender_postcode = MODULE_SHIPPING_NEWPOST_ZIP;
		$total_weight = $shipping_weight;
		$shipping_cost = 0;

      // если вес больше указаного в переменой то: 
	  
	    $min_ves = 0.1; // вес после которого цена выше
	    
      if ($_SESSION['language'] == 'russian') {
      	$api_language = "ru";
      } else {
      	$api_language = "ua";
      }		

if ($order->delivery['country']['iso_code_2'] == 'UA') {
if ($order->delivery['city'] != '') {

// Узнаём ID номер города отправителя

    $sender_request = array("apiKey"=>MODULE_SHIPPING_NEWPOST_API_LOGIN, 
                        "modelName"=>"Address",
                        "calledMethod"=>"searchSettlements",
                        "methodProperties"=>array(
                        "Language"=>$api_language,
                        "CityName"=>MODULE_SHIPPING_NEWPOST_CITY,
                        "Limit"=>1,
                        )
    );
    
$sender_request = json_encode($sender_request); 

//echo var_dump($sender_request);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://api.novaposhta.ua/v2.0/json/");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $sender_request);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $sender_data = curl_exec($curl);
    
    //echo var_dump($sender_data);
    
    curl_close($curl);
    if($sender_data === false)
    {
	return "Заполните поле Город в настройках модуля доставки Новая почта в Админке - Модули - Доставка.";
    }
    
    $sender_city_data = json_decode(html_entity_decode($sender_data), $assoc=true);

//echo var_dump($sender_city_data);

if ($sender_city_data['success'] == true) {

$sender_city_ref = $sender_city_data['data'][0]['Addresses'][0]['Ref'];
}

//echo $sender_city_ref;

// Узнаём ID номер города  получателя

    $request = array("apiKey"=>MODULE_SHIPPING_NEWPOST_API_LOGIN, 
                        "modelName"=>"Address",
                        "calledMethod"=>"searchSettlements",
                        "methodProperties"=>array(
                        "Language"=>$api_language,
                        "CityName"=>$order->delivery['city'],
                        "Limit"=>1,
                        )
    );
    
$request = json_encode($request); 

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://api.novaposhta.ua/v2.0/json/");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($curl);
    
    //echo var_dump($data);
    
    curl_close($curl);
    if($data === false)
    {
	return "Заполните поле Город для расчёта стоимость доставки.";
    }
    
    $city_data = json_decode(html_entity_decode($data), $assoc=true);
    
    //echo var_dump($city_data);

if ($city_data['success'] === true) {

$recipient_city_ref = $city_data['data'][0]['Addresses'][0]['Ref'];

if ($recipient_city_ref != '') {
$receiverCityId = $recipient_city_ref;

// Вес товара
$weight = $total_weight;
// Цена в грн
$price = $order->info['total'];

// Получение стоимости доставки груза с указанным весом и стоимостью между складами в разных городах 

    $calculate_request = array("apiKey"=>MODULE_SHIPPING_NEWPOST_API_LOGIN, 
                        "modelName"=>"InternetDocument",
                        "calledMethod"=>"getDocumentPrice",
                        "methodProperties"=>array(
                        "Language"=>$api_language,
                        "CitySender"=>$sender_city_ref,
                        "CityRecipient"=>$recipient_city_ref,
                        "Weight"=>$weight,
                        "ServiceType"=>"WarehouseWarehouse",
                        "Cost"=>$price,
                        "CargoType"=>"Cargo",
                        "SeatsAmount"=>1
                        )
    );
    
$calculate_request = json_encode($calculate_request); 

//echo var_dump($calculate_request);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://api.novaposhta.ua/v2.0/json/");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $calculate_request);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $calculate_data = curl_exec($curl);
    
    //echo var_dump($calculate_data);
    
    curl_close($curl);
    if($calculate_data === false)
    {
	return "Доставка в указанный город не осуществляется.";
    }
    
    $calculate_city_data = json_decode(html_entity_decode($calculate_data), $assoc=true);

//echo var_dump($calculate_city_data);

if ($calculate_city_data['success'] == true) {

$shipping_cost = $calculate_city_data['data'][0]['Cost'];
}

//echo $shipping_cost;

}

if ($order->delivery['city'] != '') {
	
// Получаем список отделений новой почты

    $request_pvz = array("apiKey"=>MODULE_SHIPPING_NEWPOST_API_LOGIN, 
                        "modelName"=>"AddressGeneral",
                        "calledMethod"=>"getWarehouses",
                        "methodProperties"=>array(
                        "Language"=>$api_language,
                        "CityName"=>$order->delivery['city'],
                        "Limit"=>500,
                        )
    );
    
$request_pvz = json_encode($request_pvz); 

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://api.novaposhta.ua/v2.0/json/");
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request_pvz);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data_pvz = curl_exec($curl);
    
    //echo var_dump($data);
    
    curl_close($curl);
    if($data_pvz === false)
    {
	return "Не удалось загрузить список отделений новой почты для Вашего города.";
    }
    
    $warehouse_result = json_decode(html_entity_decode($data_pvz), $assoc=true);
    

//echo var_dump($warehouse_result);

$name_pvz = false;

foreach ($warehouse_result["data"] as $pvz) {
$name_pvz[] = array(
                      'id' => ($api_language == "ru") ? $pvz["DescriptionRu"] . ', ' . $pvz["CityDescriptionRu"] : $pvz["Description"] . ', ' . $pvz["CityDescription"], 
                      'text' => ($api_language == "ru") ? $pvz["DescriptionRu"] . ', ' . $pvz["CityDescriptionRu"] : $pvz["Description"] . ', ' . $pvz["CityDescription"]
                   );
}


//echo var_dump($name_pvz);
		
        // добавление в файл результатов геокодирования
		
        // список пвз, выпадающее меню
        $pvz = vam_draw_pull_down_menu('pvz', $name_pvz, $_POST['pvz'], 'id="pvz_newpost" class="form-control"');
}
}
}
}

		if($_POST['pvz'] != '') $pvz_title = ' ' . html_entity_decode($_POST['pvz']) . '';		

        $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_NEWPOST_TEXT_TITLE,
                            'description' => MODULE_SHIPPING_NEWPOST_JS,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_NEWPOST_TEXT_TITLE_2 . html_entity_decode($pvz_title) . ' ' . $min_vremya . ($max_vremya > 0 ? '-'.$max_vremya.vam_format_by_count($max_vremya, ' день', ' дня', ' дней'):null) . '' . $skidka_text,
                                                     'cost' => $shipping_cost)));
													 				
				
		
	    $this->quotes['info'] .= $shipping_txt_min . '<br />';		

        $this->quotes['info'] .= $pvz;		

	  if ($this->tax_class > 0) {
		$this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
	  }

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);
	  
	  if ($error == true) 
	  $this->quotes['error'] = $err_msg;
  
     if ($receiverCityId == '') $this->quotes['error'] = 'До отделения новой почты. Возможно нужно правильно ввести город, чтобы был расчет стоимости.';
  
      // Если символов в индексе меньше 6, или не выбран регион, или стоимость доставки меньше указаной в переменной MODULE_SHIPPING_NEWPOST_COST, то:
	  
	  if ((strlen($order->delivery['city']) == '')) {

      $this->quotes['error'] = 'До отделения новой почты. Для расчета стоимости доставки укажите <b>город</b>';	  
	  
	  } elseif ($_SESSION['cart']->show_total() < $min_sum) {
	
	  $this->quotes['error'] = 'До отделения новой почты. Действует при сумме товаров <b>от ' . $min_sum . ' руб.</b>';
	  } elseif (isset($ret['error'][0]['code']) || $shipping_cost <= MODULE_SHIPPING_NEWPOST_COST) {
		  
	  $this->quotes['error'] = 'Доставка в указанный город не осуществляется.'; 
	  } 
	  

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_NEWPOST_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_NEWPOST_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_NEWPOST_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_NEWPOST_COST', '100', '6', '0', now())");
	   vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_NEWPOST_API_LOGIN', '1b7370ef16ac81d3cf57937118fac9f5', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_NEWPOST_CITY', 'Одесса', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_NEWPOST_STATE', 'Одесская', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_NEWPOST_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_NEWPOST_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_NEWPOST_SORT_ORDER', '0', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_NEWPOST_MIN_SUM', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_NEWPOST_PROCENT', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_NEWPOST_MIN_SUM_ORDER', '100', '6', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_NEWPOST_STATUS', 'MODULE_SHIPPING_NEWPOST_COST', 'MODULE_SHIPPING_NEWPOST_API_LOGIN', 'MODULE_SHIPPING_NEWPOST_CITY','MODULE_SHIPPING_NEWPOST_STATE','MODULE_SHIPPING_NEWPOST_ALLOWED', 'MODULE_SHIPPING_NEWPOST_TAX_CLASS', 'MODULE_SHIPPING_NEWPOST_ZONE', 'MODULE_SHIPPING_NEWPOST_SORT_ORDER', 'MODULE_SHIPPING_NEWPOST_MIN_SUM', 'MODULE_SHIPPING_NEWPOST_PROCENT', 'MODULE_SHIPPING_NEWPOST_MIN_SUM_ORDER');
    }
    
  }
?>

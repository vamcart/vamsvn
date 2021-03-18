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
      global $order, $shipping_weight;
        
	    $login = MODULE_SHIPPING_IML_LOGIN;
	    $pass = MODULE_SHIPPING_IML_PASSWORD;
	    $cost = MODULE_SHIPPING_IML_COST;
	    $city_from = MODULE_SHIPPING_IML_CITY;
	    $shipping_cost = MODULE_SHIPPING_IML_COST;
	    $total_weight = $shipping_weight;      
       $to_zip = $order->delivery['postcode'];
       $total = $order->info['total'];      
       $iml_city_id = $order->delivery['city'];
      		
		// узнаем id города
		if($order->delivery['city'] == "спб" || $order->delivery['city'] == "СПБ") $order->delivery['city'] = "Санкт-Петербург";
	    if($order->delivery['city'] == "Ростов" || $order->delivery['city'] == "ростов" || $order->delivery['city'] == "Ростов на дону" || $order->delivery['city'] == "ростов на дону") $order->delivery['city'] = "ростов-на-дону";
	
if ($order->delivery['city'] != '' && $login != '') {

	    //Получаем список ПВЗ для указанного города
		// cache File Name
		$file5=SQL_CACHEDIR.'imlPVZ'.$iml_city_id.'.vam';
	    //$gzfile=SQL_CACHEDIR.$id.'.gz';

		// file life time
		$expire = 240000; // 240 hours

		if (file_exists($file5) && filemtime($file5) > (time() - $expire)) {

		// get cached resulst
        $iml_pvz_data = file_get_contents($file5);
		} 
		else {
		if (file_exists($file5)) @unlink($file5);

	$url = "http://list.iml.ru/sd?type=json&RegionCode=".$iml_city_id; // url запроса
	//логин и пароль, подходят от личного кабинета
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	//для получения ответа в формате XML раскомментируйте строку ниже
	//curl_setopt($curl, CURLOPT_HTTPHEADER, array("Accept:application/xml; charset=utf-8"));  
	curl_setopt($curl, CURLOPT_USERPWD, $login.":".$pass);
	curl_setopt($curl, CURLOPT_SSLVERSION, 3);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$iml_pvz_data = curl_exec($curl);
	    
	    curl_close($curl);
	    
		//$stream = $data;
		$fp2 = fopen($file5,"w");
        fwrite($fp2, $iml_pvz_data);
        fclose($fp2);
		
	    }
	    $ret_pvz_iml = json_decode($iml_pvz_data, $assoc=true);
	    //echo var_dump($ret_pvz_iml);
	    
}		

	 
		$count_pvz = count($ret_pvz_iml);
		$company = 'IML';			
							
		if(isset($_POST['pvz_iml'])) {
			$_SESSION['pvz_iml'] = $_POST['pvz_iml'];
		} else {
			unset($_SESSION['pvz_iml']);
		}
		
		//$check_city_pvz = vam_db_query("select distinct city, lat from markers_geocod where name = '" . $_SESSION['pvz_iml'] . "' and company = '" . $company . "'");
		//$city_pvz = vam_db_fetch_array($check_city_pvz);
				
		
		// получение списка пвз, занесение в базу		
		$value = 0; 
	
		if ($count_pvz < 10000) {  // чтобы вдруг какой нибудь весь огромный список всех городов не загрузился
		$name_pvz_iml[] = array('id' => '', 'text' => 'Выберите пункт выдачи заказов');
		foreach($ret_pvz_iml as $key => $value) {
		if($ret_pvz_iml[$key]['Code'] != '') {
		$name_pvz_iml1 = $ret_pvz_iml[$key]['Code'] .': ' . $ret_pvz_iml[$key]['Address'];
		$name_pvz_iml[] = array('id' => $name_pvz_iml1, 'text' => $name_pvz_iml1);
		$city = $ret_pvz_iml[$key]['RegionCode']; 		
		$vremya = $ret_pvz_iml[$key]['DeliveryPeriod'];
        				
		$worktime = $ret_pvz_iml[$key]['WorkShedule']; 
        		
		//if ($city_pvz == '' && $_POST['pvz_iml'] != '') {
        //vam_db_query("insert into markers_geocod (name, address, city, company, worktime, telephon, lng, lat) values ('" . $name_pvz_iml1 . "', '" . $ret_pvz_iml[$key]['Address'] . "', '" . $city . "', '" . $company . "', '" . $worktime . "', '" . $ret_pvz_iml[$key]['Phone'] . "', '" . $ret_pvz_iml[$key]['attributes']['GPS'] . "', '" . $ret_pvz_iml[$key]['GPS'] . "')");	
		//}		
        $value++;		
		}
		}
		}

        // добавление в файл результатов геокодирования
		
		//if (!$_GET['oID'])
        //require_once('includes/modules/yandex-map/geokoder_yandex_kart.php');
		
if ($order->delivery['city'] != '') {
        // список пвз, выпадающее меню
        $pvz_iml = vam_draw_pull_down_menu('pvz_iml', $name_pvz_iml, $_POST['pvz_iml'], 'id="pvz_iml" class="form-control"');
}
		
		if($_POST['pvz_iml'] != '') $pvz_iml_title_iml = ', ' . html_entity_decode($_POST['pvz_iml']) . '';		


	    //Считаем стоимость доставки в выбранный ПВЗ
	    
	    if ($POST['pvz_iml']) {
	    	$selected_pvz = strstr($_POST['pvz_iml'], ':', true);
	    } else {
	    	//$selected_pvz = '99451';
	    }
	    //echo var_dump($selected_pvz);

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
	$shipping_data = curl_exec($curl);
	    
	    $shipping = json_decode($shipping_data, $assoc=true);
	    
	    //echo var_dump($shipping);
	    	    
		if ($shipping['Price'] > 0) {
		$shipping_cost = $shipping['Price'];
		}

// Получаем время доставки

	    $vremya = date('d',strtotime($shipping['DeliveryDate']))-date("d");

	    //Получаем список ПВЗ для указанного города
		// cache File Name
		$file5=SQL_CACHEDIR.'imlPVZ'.$iml_city_id.'.vam';
	    //$gzfile=SQL_CACHEDIR.$id.'.gz';

		// file life time
		$expire = 240000; // 240 hours

		if (file_exists($file5) && filemtime($file5) > (time() - $expire)) {

		// get cached resulst
        $iml_pvz_data = file_get_contents($file5);
		} 
		else {
		if (file_exists($file5)) @unlink($file5);

	$url = "http://list.iml.ru/sd?type=json&RegionCode=".$iml_city_id; // url запроса
	//логин и пароль, подходят от личного кабинета
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	//для получения ответа в формате XML раскомментируйте строку ниже
	//curl_setopt($curl, CURLOPT_HTTPHEADER, array("Accept:application/xml; charset=utf-8"));  
	curl_setopt($curl, CURLOPT_USERPWD, $login.":".$pass);
	curl_setopt($curl, CURLOPT_SSLVERSION, 3);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$iml_pvz_data = curl_exec($curl);
	    
	    curl_close($curl);
	    
		//$stream = $data;
		$fp2 = fopen($file5,"w");
        fwrite($fp2, $iml_pvz_data);
        fclose($fp2);
		
	    }
	    $ret_pvz_iml = json_decode($iml_pvz_data, $assoc=true);
	    //echo var_dump($ret_pvz_iml);

		//echo var_dump($shipping_cost);

        $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_IML_TEXT_TITLE,
                            'description' => MODULE_SHIPPING_IML_JS,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_IML_TEXT_TITLE_2 . html_entity_decode($pvz_iml_title_iml) . ($vremya > 0 ? ' - ' . $vremya.vam_format_by_count($vremya, ' день', ' дня', ' дней'):null) . '' . $skidka_text,
                                                     'cost' => $shipping_cost)));
													 				
				
	    //$this->quotes['info'] .= $shipping_txt_min . '<br />';		

        $this->quotes['info'] .= $pvz_iml;		

	  if ($this->tax_class > 0) {
		$this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
	  }

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);
	  
	  if ($error == true) 
	  $this->quotes['error'] = $err_msg;


	    if ($POST['pvz_iml'])
	    $this->quotes['error'] = 'Выберите пункт выдачи заказов для расчёта стоимости.';

	    if ($order->delivery['city'] == '')
	    $this->quotes['error'] = 'Доставка IML в указанный город не осуществляется.';

  
     if ($order->delivery['city'] == '') $this->quotes['error'] = 'Доставка в этом направлении не осуществляется.';
  
      // Если символов в индексе меньше 6, или не выбран регион, или стоимость доставки меньше указаной в переменной MODULE_SHIPPING_IML_COST, то:
	  
	  if ((strlen($order->delivery['city']) == '')) {

      $this->quotes['error'] = 'До пункта выдачи. Для расчета стоимости доставки укажите <b>город</b>';	  
	  
	  } elseif ($_SESSION['cart']->show_total() < $min_sum) {
	
	  $this->quotes['error'] = 'До пункта выдачи. Действует при сумме товаров <b>от ' . $min_sum . ' руб.</b>';
	  } elseif (isset($ret['error'][0]['code']) || $shipping_cost <= MODULE_SHIPPING_IML_COST) {
		  
	  //$this->quotes['error'] = 'Пункты выдачи. Доставка в этом направлении не осуществляется.'; 
	  } 

      if (!$shipping['price'] && !$_POST['pvz_iml']) 
	    $this->quotes['error'] = 'Выберите пункт выдачи заказов.';

      if (!$order->delivery['city']) 
	    $this->quotes['error'] = 'Укажите город.';
		
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

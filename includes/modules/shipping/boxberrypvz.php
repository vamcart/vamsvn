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


  class boxberrypvz {
    var $code, $title, $description, $icon, $enabled;


    function __construct() {
      global $order;

      $this->code = 'boxberrypvz';
      $this->title = MODULE_SHIPPING_BOXBERRYPVZ_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_BOXBERRYPVZ_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_BOXBERRYPVZ_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'boxberry.png';
      $this->tax_class = MODULE_SHIPPING_BOXBERRYPVZ_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_BOXBERRYPVZ_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_BOXBERRYPVZ_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_BOXBERRYPVZ_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
        
		$aut_login = MODULE_SHIPPING_BOXBERRYPVZ_API_LOGIN;
		$date_Execute = date('Y-m-d');			
		$total_weight = $shipping_weight*1000;
		$boxberry_city_id = 0;
      $shipping_cost = MODULE_SHIPPING_BOXBERRYPVZ_COST;
      		
		// узнаем id города
		if($order->delivery['city'] == "спб" || $order->delivery['city'] == "СПБ") $order->delivery['city'] = "Санкт-Петербург";
	    if($order->delivery['city'] == "Ростов" || $order->delivery['city'] == "ростов" || $order->delivery['city'] == "Ростов на дону" || $order->delivery['city'] == "ростов на дону") $order->delivery['city'] = "ростов-на-дону";
	
if ($order->delivery['city'] != '') {

	    // Узнаём код города в boxberry по названию города, указанного на странице оформления заказа в поле Город.
        
		
		// get HASH ID for filename
		//$id=BoxCity
		//md5($query);


		// cache File Name
		$file=SQL_CACHEDIR.'boxcity.vam';
	    //$gzfile=SQL_CACHEDIR.$id.'.gz';

		// file life time
		$expire = 240000; // 240 hours

		if (file_exists($file) && filemtime($file) > (time() - $expire)) {

		// get cached resulst
        $data = file_get_contents($file);
		} 
		else {
		if (file_exists($file)) @unlink($file);
		
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "https://api.boxberry.ru/json.php?token=".MODULE_SHIPPING_BOXBERRYPVZ_API_LOGIN."&method=ListCities&CountryCode=643");
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    curl_close($curl);
		
		//$stream = $data;
		$fp = fopen($file,"w");
        fwrite($fp, $data);
        fclose($fp);
		
	    }
	    
		$receiverCity = json_decode($data, $assoc=true);

	    //echo var_dump($receiverCity);
	    	    
	    foreach($receiverCity as $cities) {
	    if ($cities['Name'] == $order->delivery['city']) {
	     $boxberry_city_id = $cities["Code"];
	    }
	    }
	    
	    if($boxberry_city_id > 0) {
	    $total = $order->info['total'];	
	    //Получаем список ПВЗ для указанного города
		// cache File Name
		$file2=SQL_CACHEDIR.'boxPVZ'.$boxberry_city_id.'.vam';
	    //$gzfile=SQL_CACHEDIR.$id.'.gz';

		// file life time
		$expire = 240000; // 240 hours

		if (file_exists($file2) && filemtime($file2) > (time() - $expire)) {

		// get cached resulst
        $pvz_data = file_get_contents($file2);
		} 
		else {
		if (file_exists($file2)) @unlink($file2);

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "https://api.boxberry.ru/json.php?token=".MODULE_SHIPPING_BOXBERRYPVZ_API_LOGIN."&method=ListPoints&prepaid=1&CityCode=".$boxberry_city_id."&CountryCode=643");
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $pvz_data = curl_exec($curl);
	    
	    curl_close($curl);
	    
		//$stream = $data;
		$fp2 = fopen($file2,"w");
        fwrite($fp2, $pvz_data);
        fclose($fp2);
		
	    }
	    $ret_pvz = json_decode($pvz_data, $assoc=true);
	    //echo var_dump($ret_pvz);
	    
	    }
	    
}		

      // если вес больше указаного в переменой то: 
	  
	    $min_ves = 0.1; // вес после которого цена выше

		// Расчет скидки
		
		$sum_akcii = MODULE_SHIPPING_BOXBERRYPVZ_MIN_SUM; //сумма от которой начинается скидка
		$skidka = MODULE_SHIPPING_BOXBERRYPVZ_PROCENT; // скидка на доставку
		$min_sum = MODULE_SHIPPING_BOXBERRYPVZ_MIN_SUM_ORDER; // сумма от которой действует доставка
		$min_dozakaz = $sum_akcii - $_SESSION['cart']->show_total();

if ($order->delivery['city'] != '') {
		if ($_SESSION['cart']->show_total() > $sum_akcii) {		
		$shipping_skidka = ($shipping_cost / 100) * $skidka;
		$shipping_cost = $shipping_cost - $shipping_skidka;
		//$shipping_txt_min = '<b>Выберите пункт выдачи:</b>';
		} else {
		//$shipping_txt_min = 'При сумме товаров от <b>' . $sum_akcii . '</b> руб., на эту доставку действует скидка <font color="red"><b>' . $skidka . '%</b></font>. Осталось добавить товаров мин. на: ' .$min_dozakaz . ' руб. <br /> <b>Выберите пункт выдачи:</b>';
		}	
}

        //if ($_SESSION['cart']->show_total() > $sum_akcii) {     
	    //$skidka_text = ', применена скидка <b>' .$skidka. '%</b> [-' . $shipping_skidka . ' руб.]</b>';	
        //}			
	 
		$count_pvz = count($ret_pvz);
		$company = 'BoxBerry';		
							
		if(isset($_POST['pvz_boxberry'])) {
			$_SESSION['pvz_boxberry'] = $_POST['pvz_boxberry'];
		} else {
			unset($_SESSION['pvz_boxberry']);
		}
		
		//$check_city_pvz = vam_db_query("select distinct city, lat from markers_geocod where name = '" . $_SESSION['pvz_boxberry'] . "' and company = '" . $company . "'");
		//$city_pvz = vam_db_fetch_array($check_city_pvz);
				
		
		// получение списка пвз, занесение в базу		
		$value = 0; 
	
		if ($count_pvz < 10000) {  // чтобы вдруг какой нибудь весь огромный список всех городов не загрузился
		$name_pvz[] = array('id' => '', 'text' => 'Выберите пункт выдачи заказов');
		foreach($ret_pvz as $key => $value) {
		if($ret_pvz[$key]['Code'] != '') {
		$name_pvz1 = $ret_pvz[$key]['Code'] .': ' . $ret_pvz[$key]['AddressReduce'];
		$name_pvz[] = array('id' => $name_pvz1, 'text' => $name_pvz1);
		$city = $ret_pvz[$key]['CityName']; 		
		$vremya = $ret_pvz[$key]['DeliveryPeriod'];
        				
		$worktime = $ret_pvz[$key]['WorkShedule']; 
        		
		//if ($city_pvz == '' && $_POST['pvz_boxberry'] != '') {
        //vam_db_query("insert into markers_geocod (name, address, city, company, worktime, telephon, lng, lat) values ('" . $name_pvz1 . "', '" . $ret_pvz[$key]['Address'] . "', '" . $city . "', '" . $company . "', '" . $worktime . "', '" . $ret_pvz[$key]['Phone'] . "', '" . $ret_pvz[$key]['attributes']['GPS'] . "', '" . $ret_pvz[$key]['GPS'] . "')");	
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
        $pvz = vam_draw_pull_down_menu('pvz_boxberry', $name_pvz, $_POST['pvz_boxberry'], 'id="pvz_boxberry" class="form-control"');
}
		
		if($_POST['pvz_boxberry'] != '') $pvz_title = ', ' . html_entity_decode($_POST['pvz_boxberry']) . '';		


	    //Считаем стоимость доставки в выбранный ПВЗ
	    
	    if ($POST['pvz_boxberry']) {
	    	$selected_pvz = strstr($_POST['pvz_boxberry'], ':', true);
	    } else {
	    	$selected_pvz = '99451';
	    }
	    //echo var_dump($selected_pvz);

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "https://api.boxberry.ru/json.php?token=".MODULE_SHIPPING_BOXBERRYPVZ_API_LOGIN."&method=DeliveryCosts&weight=".$total_weight."targetstart=&target=".strstr($_POST['pvz_boxberry'], ':', true)."&ordersum=".$total."&deliverysum=0&height=15&width=15&depth=15&paysum=");
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $shipping_data = curl_exec($curl);

	    curl_close($curl);
	    
	    $shipping = json_decode($shipping_data, $assoc=true);
	    //echo var_dump($shipping);
	    	    
		if ($shipping['price'] > 0) {
		$shipping_cost = $shipping['price'];
		}

		//echo var_dump($shipping_cost);

        $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_BOXBERRYPVZ_TEXT_TITLE,
                            'description' => MODULE_SHIPPING_BOXBERRYPVZ_JS,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_BOXBERRYPVZ_TEXT_TITLE_2 . html_entity_decode($pvz_title) . ($vremya > 0 ? ' - ' . $vremya.vam_format_by_count($vremya, ' день', ' дня', ' дней'):null) . '' . $skidka_text,
                                                     'cost' => $shipping_cost)));
													 				
				
	    //$this->quotes['info'] .= $shipping_txt_min . '<br />';		

        $this->quotes['info'] .= $pvz;		

	  if ($this->tax_class > 0) {
		$this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
	  }

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);
	  
	  if ($error == true) 
	  $this->quotes['error'] = $err_msg;


	    if ($POST['pvz_boxberry'])
	    $this->quotes['error'] = 'Выберите пункт выдачи заказов для расчёта стоимости.';

	    if ($boxberry_city_id == 0)
	    $this->quotes['error'] = 'Доставка Boxberry в указанный город не осуществляется.';

  
     if ($boxberry_city_id == '') $this->quotes['error'] = 'Доставка в этом направлении не осуществляется.';
  
      // Если символов в индексе меньше 6, или не выбран регион, или стоимость доставки меньше указаной в переменной MODULE_SHIPPING_BOXBERRYPVZ_COST, то:
	  
	  if ((strlen($order->delivery['city']) == '')) {

      $this->quotes['error'] = 'До пункта выдачи. Для расчета стоимости доставки укажите <b>город</b>';	  
	  
	  } elseif ($_SESSION['cart']->show_total() < $min_sum) {
	
	  $this->quotes['error'] = 'До пункта выдачи. Действует при сумме товаров <b>от ' . $min_sum . ' руб.</b>';
	  } elseif (isset($ret['error'][0]['code']) || $shipping_cost <= MODULE_SHIPPING_BOXBERRYPVZ_COST) {
		  
	  //$this->quotes['error'] = 'Пункты выдачи. Доставка в этом направлении не осуществляется.'; 
	  } 

      if (!$shipping['price'] && !$_POST['pvz_boxberry']) 
	    $this->quotes['error'] = 'Выберите пункт выдачи заказов.';

      if (!$order->delivery['city']) 
	    $this->quotes['error'] = 'Укажите город.';
		
      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_BOXBERRYPVZ_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_BOXBERRYPVZ_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYPVZ_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYPVZ_COST', '250', '6', '0', now())");
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYPVZ_API_LOGIN', 'd6f33e419c16131e5325cbd84d5d6000', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_BOXBERRYPVZ_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_BOXBERRYPVZ_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYPVZ_SORT_ORDER', '0', '6', '0', now())");
	  
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYPVZ_MIN_SUM', '', '6', '0', now())");
	  vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYPVZ_PROCENT', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_BOXBERRYPVZ_MIN_SUM_ORDER', '100', '6', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_BOXBERRYPVZ_STATUS', 'MODULE_SHIPPING_BOXBERRYPVZ_COST', 'MODULE_SHIPPING_BOXBERRYPVZ_API_LOGIN', 'MODULE_SHIPPING_BOXBERRYPVZ_ALLOWED', 'MODULE_SHIPPING_BOXBERRYPVZ_TAX_CLASS', 'MODULE_SHIPPING_BOXBERRYPVZ_ZONE', 'MODULE_SHIPPING_BOXBERRYPVZ_SORT_ORDER', 'MODULE_SHIPPING_BOXBERRYPVZ_MIN_SUM', 'MODULE_SHIPPING_BOXBERRYPVZ_PROCENT', 'MODULE_SHIPPING_BOXBERRYPVZ_MIN_SUM_ORDER');
    }
   
  }
?>

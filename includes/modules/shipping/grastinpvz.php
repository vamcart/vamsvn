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


  class grastinpvz {
    var $code, $title, $description, $icon, $enabled;


    function __construct() {
      global $order;

      $this->code = 'grastinpvz';
      $this->title = MODULE_SHIPPING_GRASTINPVZ_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_GRASTINPVZ_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_GRASTINPVZ_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'grastin.png';
      $this->tax_class = MODULE_SHIPPING_GRASTINPVZ_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_GRASTINPVZ_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_GRASTINPVZ_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_GRASTINPVZ_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
        
		$aut_login = MODULE_SHIPPING_GRASTINPVZ_API_LOGIN;
		$date_Execute = date('Y-m-d');			
		$total_weight = $shipping_weight;
		$order_total = number_format($order->info['total'],0,'.','');
		
		// узнаем id города
		if($order->delivery['city'] == "спб" || $order->delivery['city'] == "СПБ") $order->delivery['city'] = "Санкт-Петербург";
	    if($order->delivery['city'] == "Ростов" || $order->delivery['city'] == "ростов" || $order->delivery['city'] == "Ростов на дону" || $order->delivery['city'] == "ростов на дону") $order->delivery['city'] = "ростов-на-дону";
		
if ($order->delivery['city'] != '') {

foreach($order->products AS $products)
{
	$length = $products['length'];
	$width = $products['width'];
	$height = $products['height'];
	$volume = $products['volume'];
}	

        $xml = '
<File>
<API>'.$aut_login.'</API>
<Method>CalcShipingCost</Method>
<Orders>
  <Order number = "'.$order->info['id'].'"
        idregion= "e92ae8a3-074c-11e2-a6e5-00152d030203"
        selfpickup= "false"
        weight= "'.($shipping_weight*100).'"
        assessedsumma= "'.$order_total.'"
        summa= "'.$order_total.'"
        bulky= "false"
        volume= "0"
        width= "0"
        height= "0"
        length= "0"
        transportcompany= "false"
        paiddistance= "20"
  />
</Orders>
</File>        
        ';
        
        
$xmll = '
<File>
        <API>'.$aut_login.'</API>
        <Method>DeliveryRegion</Method>
</File>
';
        

		// get HASH ID for filename
		//$id=BoxCity
		//md5($query);


		// cache File Name
		$file=SQL_CACHEDIR.'grastinanswer.vam';
	    //$gzfile=SQL_CACHEDIR.$id.'.gz';

		// file life time
		$expire = 240000; // 240 hours

		if (file_exists($file) && filemtime($file) > (time() - $expire)) {

		// get cached resulst
        $result = file_get_contents($file);
		} 
		else {
		if (file_exists($file)) @unlink($file);
        
        $url = 'http://api.grastin.ru/api.php';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, 'XMLPackage='.urlencode($xml));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        curl_close($ch);

		//$stream = $data;
		$fp = fopen($file,"w");
        fwrite($fp, $result);
        fclose($fp);
        
}

//echo var_dump($result);

$shipping_cost_answer = simplexml_load_string($result);

//echo $shipping_cost_answer->Order->shippingcost;
//echo var_dump($shipping_cost_answer->Order->shippingcost);

}

		$receiverCityId = $order->delivery['city'];

	    $shipping_cost = 0;
	         
      // если вес больше указаного в переменой то: 
	  
	    $min_ves = 0.1; // вес после которого цена выше
	    
		if ($shipping_cost_answer->Order->shippingcost > 0) {
		$shipping_cost = $shipping_cost_answer->Order->shippingcost;
		}

		if ($shipping_weight >= $min_ves) {			
		$shipping_cost = $shipping_cost + MODULE_SHIPPING_GRASTINPVZ_COST;
		} else {
        $shipping_cost = $shipping_cost + MODULE_SHIPPING_GRASTINPVZ_COST_2; 
        }
						
		// Расчет скидки
		
		$sum_akcii = MODULE_SHIPPING_GRASTINPVZ_MIN_SUM; //сумма от которой начинается скидка
		$skidka = MODULE_SHIPPING_GRASTINPVZ_PROCENT; // скидка на доставку
		$min_sum = MODULE_SHIPPING_GRASTINPVZ_MIN_SUM_ORDER; // сумма от которой действует доставка
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
	 
		$min_vremya = $ret['result']['deliveryPeriodMin'];
		$max_vremya = $ret['result']['deliveryPeriodMax'];

        // запрос вывода списка пвз
if ($order->delivery['city'] != '') {
		$ret_pvz = $this->grastinpvz_api_pvz($receiverCityId);
		$ret_pvz = simplexml_load_string($ret_pvz);
}		
		
		$count_pvz = count($ret_pvz);
		$company = 'Grastin';		
							
		if(isset($_POST['pvz_grastin'])) {
			$_SESSION['pvz_grastin'] = $_POST['pvz_grastin'];
		} else {
			unset($_SESSION['pvz_grastin']);
		}
		
		//$check_city_pvz = vam_db_query("select distinct city, lat from markers_geocod where name = '" . $_SESSION['pvz_grastin'] . "' and company = '" . $company . "'");
		//$city_pvz = vam_db_fetch_array($check_city_pvz);
				
		
		// получение списка пвз, занесение в базу		
		$value = 0; 
		
		if ($count_pvz < 10000) {  // чтобы вдруг какой нибудь весь огромный список всех городов не загрузился
		$name_pvz[] = array('id' => '', 'text' => 'Выберите пункт выдачи заказов');
		foreach($ret_pvz as $grastin_pvz) {
		if($grastin_pvz->Name != '') {
		$name_pvz1 = $grastin_pvz->Name .': ' . $grastin_pvz->phone;
		$name_pvz[] = array('id' => $name_pvz1, 'text' => $name_pvz1);
		$city = $grastin_pvz->city; 		
        				
		$worktime = $grastin_pvz->timetable; 
        		
		//if ($city_pvz == '' && $_POST['pvz_grastin'] != '') {
        //vam_db_query("insert into markers_geocod (name, address, city, company, worktime, telephon, lng, lat) values ('" . $name_pvz1 . "', '" . $grastin_pvz->Name . "', '" . $city . "', '" . $company . "', '" . $worktime . "', '" . $grastin_pvz->phone . "', '" . $grastin_pvz->latitude . "', '" . $grastin_pvz->longitude . "')");	
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
        $pvz = vam_draw_pull_down_menu('pvz_grastin', $name_pvz, $_POST['pvz_grastin'], 'id="pvz_grastin" class="form-control"');
}

//echo var_dump($name_pvz);
		
		if($_POST['pvz_grastin'] != '') $pvz_title = ', ' . html_entity_decode($_POST['pvz_grastin']) . '';		

        $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_GRASTINPVZ_TEXT_TITLE,
                            'description' => MODULE_SHIPPING_GRASTINPVZ_JS,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_GRASTINPVZ_TEXT_TITLE_2 . html_entity_decode($pvz_title) . ' ' . $min_vremya . ($max_vremya > 0 ? '-'.$max_vremya.vam_format_by_count($max_vremya, ' день', ' дня', ' дней'):null) . '' . $skidka_text,
                                                     'cost' => $shipping_cost)));
													 				
				
	    //$this->quotes['info'] .= $shipping_txt_min . '<br />';		

        $this->quotes['info'] .= $pvz;		

	  if ($this->tax_class > 0) {
		$this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
	  }

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);
	  
	  if ($error == true) 
	  $this->quotes['error'] = $err_msg;
  
     if ($receiverCityId == '') $this->quotes['error'] = 'До пункта выдачи. Возможно нужно правильно ввести город, чтобы был расчет стоимости.';
  
      // Если символов в индексе меньше 6, или не выбран регион, или стоимость доставки меньше указаной в переменной MODULE_SHIPPING_GRASTINPVZ_COST, то:
	  
	  if ((strlen($order->delivery['city']) == '')) {

      $this->quotes['error'] = 'До пункта выдачи. Для расчета стоимости доставки укажите <b>город</b>';	  
	  
	  } elseif ($_SESSION['cart']->show_total() < $min_sum) {
	
	  $this->quotes['error'] = 'До пункта выдачи. Действует при сумме товаров <b>от ' . $min_sum . ' руб.</b>';
	  } elseif (isset($ret['error'][0]['code']) || $shipping_cost <= MODULE_SHIPPING_GRASTINPVZ_COST) {
		  
	  $this->quotes['error'] = 'Доставка в этом направлении не осуществляется.'; 
	  } 
	  

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_GRASTINPVZ_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_GRASTINPVZ_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_GRASTINPVZ_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_GRASTINPVZ_COST', '0', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_GRASTINPVZ_COST_2', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_GRASTINPVZ_API_LOGIN', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_GRASTINPVZ_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_GRASTINPVZ_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_GRASTINPVZ_SORT_ORDER', '0', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_GRASTINPVZ_MIN_SUM', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_GRASTINPVZ_PROCENT', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_GRASTINPVZ_MIN_SUM_ORDER', '100', '6', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_GRASTINPVZ_STATUS', 'MODULE_SHIPPING_GRASTINPVZ_COST', 'MODULE_SHIPPING_GRASTINPVZ_COST_2', 'MODULE_SHIPPING_GRASTINPVZ_API_LOGIN', 'MODULE_SHIPPING_GRASTINPVZ_ALLOWED', 'MODULE_SHIPPING_GRASTINPVZ_TAX_CLASS', 'MODULE_SHIPPING_GRASTINPVZ_ZONE', 'MODULE_SHIPPING_GRASTINPVZ_SORT_ORDER', 'MODULE_SHIPPING_GRASTINPVZ_MIN_SUM', 'MODULE_SHIPPING_GRASTINPVZ_PROCENT', 'MODULE_SHIPPING_GRASTINPVZ_MIN_SUM_ORDER');
    }
    
 private function grastinpvz_api_pvz($cityId) {  

$xmll = '<File>
        <API>'.MODULE_SHIPPING_GRASTINPVZ_API_LOGIN.'</API>
        <Method>selfpickup</Method>
</File>';
        

     // cache File Name
		$file3=SQL_CACHEDIR.'grastinPVZ'.$cityId.'.vam';
	    //$gzfile=SQL_CACHEDIR.$id.'.gz';

		// file life time
		$expire = 240000; // 240 hours

		if (file_exists($file3) && filemtime($file3) > (time() - $expire)) {

		// get cached resulst
        $vals = file_get_contents($file3);
		} 
		else {
		if (file_exists($file3)) @unlink($file3);
        
        $url = 'http://api.grastin.ru/api.php';
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS, 'XMLPackage='.urlencode($xmll));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $vals = curl_exec($ch);
        curl_close($ch);

		//$stream = $data;
		$fp = fopen($file3,"w");
        fwrite($fp, $vals);
        fclose($fp);
        
     }

    return $vals; 
 }
    
  }
?>

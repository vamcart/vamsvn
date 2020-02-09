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


  class cdek {
    var $code, $title, $description, $icon, $enabled;


    function __construct() {
      global $order;

      $this->code = 'cdek';
      $this->title = MODULE_SHIPPING_CDEK_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_CDEK_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_CDEK_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'cdek.png';
      $this->tax_class = MODULE_SHIPPING_CDEK_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_CDEK_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_CDEK_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_CDEK_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
      global $order, $shipping_weight, $total_count, $length, $width, $height, $volume;

		$api_key = MODULE_SHIPPING_CDEK_API_KEY;
		$api_password = MODULE_SHIPPING_CDEK_API_PASSWORD;
		$sender_city = MODULE_SHIPPING_CDEK_SENDER_CITY;
		$total_weight = $shipping_weight;
		$shipping_cost = 0;
		$error_block = false;

	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "http://api.cdek.ru/city/getListByTerm/json.php?q=".$sender_city);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    if($data === false) {
		  if (MODULE_SHIPPING_CDEK_DEBUG == 'test') $error_block = "ID номер для города отправителя посылки не найден.";
	    }
	    
	    $senderCity = json_decode($data, $assoc=true);
	    $senderCityId = $senderCity["geonames"][0]["id"];
	    
	    $dev_city = str_replace('г. ','',$order->delivery['city']);
	    $dev_city = str_replace('г.','',$dev_city);
	    $dev_city = str_replace('г ','',$dev_city);
	
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_URL, "http://api.cdek.ru/city/getListByTerm/json.php?q=".urlencode($dev_city));
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    $data = curl_exec($curl);
	    
	    curl_close($curl);
	    if($data === false) {
		  if (MODULE_SHIPPING_CDEK_DEBUG == 'test') $error_block = "ID номер для города получателя посылки не найден.";
	    }
	    
	    $receiverCity = json_decode($data, $assoc=true);
	    $receiverCityId = $receiverCity["geonames"][0]["id"];


		//подключаем файл с классом CalculatePriceDeliveryCdek
		include_once(DIR_FS_CATALOG.'includes/external/cdek/'.'CalculatePriceDeliveryCdek.php');
		
		try {
		
			//создаём экземпляр объекта CalculatePriceDeliveryCdek
			$calc = new CalculatePriceDeliveryCdek();
			
		    //Авторизация.
		    if ($api_key != '' && $api_password != '') $calc->setAuth($api_key, $api_password);
			
			//устанавливаем город-отправитель
			$calc->setSenderCityId($senderCityId);
			//устанавливаем город-получатель
			$calc->setReceiverCityId($receiverCityId);
			//устанавливаем дату планируемой отправки
			//$calc->setDateExecute();
			
			//задаём список тарифов с приоритетами
		    //$calc->addTariffPriority($_REQUEST['tariffList1']);
		    //$calc->addTariffPriority($_REQUEST['tariffList2']);
			
			//устанавливаем тариф по-умолчанию
			$calc->setTariffId('11');
				
			//устанавливаем режим доставки
			$calc->setModeDeliveryId(3);
			//добавляем места в отправление
			
				foreach($order->products AS $products)
				{
					$calc->addGoodsItemBySize($products['weight'], $products['length'], $products['width'], $products['height']*$products['qty']);
		
				}	
			
			if ($calc->calculate() === true) {
				$res = $calc->getResult();
				
				if (MODULE_SHIPPING_CDEK_DEBUG == 'test') $error_block = 'Цена доставки: ' . $res['result']['price'] . 'руб.<br />';
				if (MODULE_SHIPPING_CDEK_DEBUG == 'test') $error_block = 'Срок доставки: ' . $res['result']['deliveryPeriodMin'] . '-' . 
										 $res['result']['deliveryPeriodMax'] . ' дн.<br />';
				if (MODULE_SHIPPING_CDEK_DEBUG == 'test') $error_block = 'Планируемая дата доставки: c ' . $res['result']['deliveryDateMin'] . ' по ' . $res['result']['deliveryDateMax'] . '.<br />';
				if (MODULE_SHIPPING_CDEK_DEBUG == 'test') $error_block = 'id тарифа, по которому произведён расчёт: ' . $res['result']['tariffId'] . '.<br />';
		        if(array_key_exists('cashOnDelivery', $res['result'])) {
		            if (MODULE_SHIPPING_CDEK_DEBUG == 'test') $error_block = 'Ограничение оплаты наличными, от (руб): ' . $res['result']['cashOnDelivery'] . '.<br />';
		        }
			} else {
				$err = $calc->getError();
				if( isset($err['error']) && !empty($err) ) {
					if (MODULE_SHIPPING_CDEK_DEBUG == 'test') var_dump($err);
					foreach($err['error'] as $e) {
						if (MODULE_SHIPPING_CDEK_DEBUG == 'test') $error_block = 'Код ошибки: ' . $e['code'] . '.<br />';
						if (MODULE_SHIPPING_CDEK_DEBUG == 'test') $error_block = 'Текст ошибки: ' . $e['text'] . '.<br />';
					}
				}
			}
		    
		    //раскомментируйте, чтобы просмотреть исходный ответ сервера
		     //var_dump($calc->getResult());
		     //var_dump($calc->getError());
		
		} catch (Exception $e) {
		    if (MODULE_SHIPPING_CDEK_DEBUG == 'test') $error_block = 'Ошибка: ' . $e->getMessage() . " | ";
		}
			
		$shipping_cost=  $res['result']['price'];
		
		if (MODULE_SHIPPING_CDEK_COST > 0) $shipping_cost = $shipping_cost + MODULE_SHIPPING_CDEK_COST;

        $error_block = !empty($error_block) ? ' <span style=\'color: red;\'>| ' . $error_block . '</span>' : '';

      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_CDEK_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => MODULE_SHIPPING_CDEK_TEXT_PUBLIC_TITLE . $error_block,
                                                     'cost' => $shipping_cost)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);

      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_CDEK_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_CDEK_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_CDEK_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_CDEK_COST', '0', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_CDEK_API_KEY', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_CDEK_API_PASSWORD', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_CDEK_SENDER_CITY', 'Москва', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_CDEK_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_CDEK_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_CDEK_DEBUG', 'production', '6', '6', 'vam_cfg_select_option(array(\'test\', \'production\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_CDEK_SORT_ORDER', '0', '6', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_CDEK_STATUS', 'MODULE_SHIPPING_CDEK_COST','MODULE_SHIPPING_CDEK_API_KEY','MODULE_SHIPPING_CDEK_API_PASSWORD','MODULE_SHIPPING_CDEK_SENDER_CITY','MODULE_SHIPPING_CDEK_ALLOWED', 'MODULE_SHIPPING_CDEK_TAX_CLASS', 'MODULE_SHIPPING_CDEK_ZONE', 'MODULE_SHIPPING_CDEK_DEBUG', 'MODULE_SHIPPING_CDEK_SORT_ORDER');
    }
    
  }
?>

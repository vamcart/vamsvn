<?php
/* -----------------------------------------------------------------------------------------
   $Id: spsr.php 899 2010/05/29 13:24:46 oleg_vamsoft $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(spsr.php,v 1.39 2003/02/05); www.oscommerce.com 
   (c) 2003	 nextcommerce (spsr.php,v 1.7 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (spsr.php,v 1.7 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   

  class spsr {
    var $code, $title, $description, $icon, $enabled;


    function spsr() {
      global $order;

      $this->code = 'spsr';
      $this->title = MODULE_SHIPPING_SPSR_TEXT_TITLE;
      $this->description = MODULE_SHIPPING_SPSR_TEXT_DESCRIPTION;
      $this->sort_order = MODULE_SHIPPING_SPSR_SORT_ORDER;
      $this->icon = DIR_WS_ICONS . 'shipping_spsr.gif';
      $this->tax_class = MODULE_SHIPPING_SPSR_TAX_CLASS;
      $this->enabled = ((MODULE_SHIPPING_SPSR_STATUS == 'True') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_SPSR_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_SHIPPING_SPSR_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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
    	
		$check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key='STORE_ZONE'");
        $check = vam_db_fetch_array($check_query);
		$own_zone_id = $check['configuration_value'];	
	
	//переключатель Доставка по своему городу
	if (($this->enabled == true) && (MODULE_SHIPPING_SPSR_OWN_CITY_DELIVERY == 'False')){		         		        
		if (strtolower(MODULE_SHIPPING_SPSR_FROM_CITY) == strtolower($order->delivery['city'])){				
			$this->enabled = false;
		}
	}
			
	//Переключатель Доставка по своему региону
	if (($this->enabled == true) && (MODULE_SHIPPING_SPSR_OWN_REGION_DELIVERY == 'False'))	{		         		
		if ($own_zone_id == $order->delivery['zone_id']){				
			$this->enabled = false;
		}
	}
	
	//отключение доставки для отдельных городов
	if (($this->enabled == true) && (MODULE_SHIPPING_SPSR_DISABLE_CITIES !== '')){		         		        
		$disabled_cities = explode(',',MODULE_SHIPPING_SPSR_DISABLE_CITIES);
		foreach ($disabled_cities as $cityvalue){			
			if (strtolower($cityvalue) == strtolower($order->delivery['city'])){				
				$this->enabled = false;
			}
		}
	}
	
  }

// class methods
    function quote($method = '') {
      global $order, $cart, $shipping_weight, $own_zone_id;		  
				
		if ($shipping_weight == 0)
			{
			$shipping_weight = MODULE_SHIPPING_SPSR_DEFAULT_SHIPPING_WEIGHT;
			}
			
      if ($this->tax_class > 0) {
        $this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }
      	

		//вытаскиваем Region ID города назначения базы
		$region_id = vam_get_spsr_zone_id($order->delivery['zone_id']);
		
		//вытаскиваем свой Region ID из базы
		$own_cpcr_id = vam_get_spsr_zone_id($order->delivery['zone_id']);

	//oscommerce дважды запрашивает цену доставки c cpcr.ru - до подтверждения цены доставки (для показа пользователю) и после подтверждения цены доставки (нажатие кнопки "Продолжить"). Х.з. почему, видимо так работает oscommerce. Чтобы не запрашивать дважды кешируем $cost в hidden поле cost.
	if (!isset($_POST['cost'])) {		 		
		//составление запроса стоимости доставки
		if(isset($_POST['error_tocity']))
			{
			$request='http://cpcr.ru/cgi-bin/postxml.pl?TariffCompute&FromRegion='.$own_cpcr_id.'|0&FromCityName='.iconv("UTF-8","windows-1251", MODULE_SHIPPING_SPSR_FROM_CITY).'&Weight='. $shipping_weight .'&Nature='.MODULE_SHIPPING_SPSR_NATURE.'&Amount=0&Country=209|0&ToCity='.iconv("UTF-8","windows-1251", $_POST['error_tocity']);
			}
		else
			{
			$request='http://cpcr.ru/cgi-bin/postxml.pl?TariffCompute&FromRegion='.$own_cpcr_id.'|0&FromCityName='.iconv("UTF-8","windows-1251", MODULE_SHIPPING_SPSR_FROM_CITY).'&Weight='. $shipping_weight .'&Nature='.MODULE_SHIPPING_SPSR_NATURE.'&Amount=0&Country=209|0&ToRegion='.$region_id.'|0&ToCityName='.iconv("UTF-8","windows-1251", $order->delivery['city']);
			}
		
		//проверки связи с сервером
		$server_link = false;
		
		$file_headers = @get_headers($request);
		if(($file_headers[0] !== 'HTTP/1.1 404 Not Found') && ($file_headers!==false)) {
			$server_link = true;
		}
	
		//Запрос стоимости с cpcr.ru
		if ($server_link==true){
			$xmlstring= simplexml_load_file($request);
		}else{
			$title = "<font color=red>Нет связи с сервером cpcr.ru, стоимость доставки не определена.</font>";
			$cost = 0;
		}

		//получение цены доставки
		if ($xmlstring->PayTariff)
			{
			$find_symbols = array(chr(160),'р.',' '); //вместо пробела в стоимости доставки cpcr.ru использует симовл с ascii кодом 160.
			$cost = ceil(str_replace(',','.',str_replace($find_symbols,'',$xmlstring->Total)));
			$title .= 'Доставка в '.$order->delivery['city'].', '.$order->delivery['state'];
			if ($cost>0) {$title .= '<input type="hidden" name="cost" value="'.$cost.'">';}			
			}
	//если $cost уже был определен
	}else{
		$cost = $_POST['cost'];
		$title .= 'Доставка в '.$order->delivery['city'].', '.$order->delivery['state'];
		if ($cost>0) {$title .= '<input type="hidden" name="cost" value="'.$cost.'">';}	
	}			
		
		//Обработка ошибки Город не найден
		if ($xmlstring->Error->ToCity && $server_link == true)
			{
			$title .= "<font color=red>Ошибка, город \"".$order->delivery['city']."\" не найден. Либо в названии города допущена ошибка, либо в данный город СПСР доставку не производит.</font><br>";
			}
		
			//Уточнение названия города, для получения City_Id c сервера cpcr.ru
		if (!$xmlstring->Error->ToCity->City->CityName=='')
			{
			$title .= "<font color=red>Пожалуйста уточните название вашего города:</font><br>";
			if ($xmlstring->Error->ToCity->City)
				{
				foreach ($xmlstring->Error->ToCity->City as $city_value)
					{		
					$title .= "<input type=radio name=error_tocity value=\"".$city_value->City_Id."|".$city_value->City_Owner_Id."\" onChange=\"this.form.submit()\">".$city_value->CityName.", ".$city_value->RegionName."<br>";
					//начало код для унификации с калькулятором
					echo "<input type=hidden name=\"".$city_value->City_Id."|".$city_value->City_Owner_Id."\" value=\"".$city_value->CityName.", ".$city_value->RegionName."\">";	
					//конец код для унификации с калькулятором						
					}
				}
			}
			
		//Обработка ошибки Веса
		if ($xmlstring->Error->Weight)
			{
			$title .= "<br><font color=red>Ошибка! Неправильный формат веса</font>";
			}
		
		//Оюработка ошибки Оценочной стоимости	
		if ($xmlstring->Error->Amount)
			{
			$title .= "<br><font color=red>Ошибка! Неправильный формат оценочной стоимости</font>";
			}
		if (!isset($own_cpcr_id))
			{
			$title .= "<br><font color=red>Ошибка! Вы не выбрали зону! (Администрирование>Настройки>My store>Zone)</font>";
			}
			
		//Обработка ошибки Mutex Wait Timeout
		if ($xmlstring->Error['Type']=='Mutex' & $xmlstring->Error['SubType']=='Wait Timeout')  {
			$title .= "<br><font color=red>Ошибка! cpcr.ru не вернул ответ на запрос. Попробуйте обновить страницу.</font>";
		}
		
		//Обработка ошибки ComputeTariff CalcError
		if ($xmlstring->Error['Type']=='ComputeTariff' & $xmlstring->Error['SubType']=='CalcError')  {
			$title .= "<br><font color=red>Ошибка! Ошибка вычисления стоимости доставки.</font>";
		}		
		
		//Обработка ошибки Command Unknown
		if ($xmlstring->Error['Type']=='Command' & $xmlstring->Error['SubType']=='Unknown')  {
			$title .= "<br><font color=red>Ошибка! Неизвестная команда.</font>";
		}
		
		//Обработка ошибки Unknown Unknown (прочие ошибки)
		if ($xmlstring->Error['Type'])  {
			$title .= "<br><font color=red>Неизвестная ошибка, попробуйте позже.</font>";
		}		
		
		//Отображдение отладочной информации
		if(MODULE_SHIPPING_SPSR_DEBUG=='True')
			{
			$title .= "<br>".'$own_zone_id='.$own_zone_id."<br>".
			'$order->delivery[\'zone_id\']='.$order->delivery['zone_id']."<br>".
			'$own_cpcr_id='.$own_cpcr_id."<br>".
			'MODULE_SHIPPING_SPSR_OWN_CITY_DELIVERY='.MODULE_SHIPPING_SPSR_OWN_CITY_DELIVERY."<br>".
			'MODULE_SHIPPING_SPSR_OWN_REGION_DELIVERY='.MODULE_SHIPPING_SPSR_OWN_REGION_DELIVERY."<br>".			
			'$shipping_weight='.$shipping_weight."<br>".
			'MODULE_SHIPPING_SPSR_NATURE='.MODULE_SHIPPING_SPSR_NATURE."<br>".
			'$request='.$request."<br>".
			'$cost='.$cost."<br>".
			'$_POST[\'cost\']='.$_POST['cost'];
			'$xmlstring:'."<br>".
			(is_object($xmlstring)?"<textarea readonly=\"readonly\" rows=\"5\">".$xmlstring->asXML()."</textarea>":'');			
			}
			
      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_SPSR_TEXT_TITLE,
                            'methods' => array(array('id' => $this->code,
                                                     'title' => $title,
                                                     'cost' => $cost)));

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);
      return $this->quotes;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_SHIPPING_SPSR_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_SPSR_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SPSR_ALLOWED', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SPSR_FROM_CITY', 'Москва', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SPSR_DISABLE_CITIES', '', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_SPSR_OWN_CITY_DELIVERY', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_SPSR_OWN_REGION_DELIVERY', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SPSR_DEFAULT_SHIPPING_WEIGHT', '0.5', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SPSR_NATURE', '3', '6', '0', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_SHIPPING_SPSR_DEBUG', 'False', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_SPSR_TAX_CLASS', '0', '6', '0', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_SPSR_ZONE', '0', '6', '0', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_SPSR_SORT_ORDER', '0', '6', '0', now())");
    }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_SHIPPING_SPSR_STATUS', 'MODULE_SHIPPING_SPSR_FROM_CITY', 'MODULE_SHIPPING_SPSR_DISABLE_CITIES', 'MODULE_SHIPPING_SPSR_OWN_CITY_DELIVERY', 'MODULE_SHIPPING_SPSR_OWN_REGION_DELIVERY', 'MODULE_SHIPPING_SPSR_DEFAULT_SHIPPING_WEIGHT', 'MODULE_SHIPPING_SPSR_NATURE', 'MODULE_SHIPPING_SPSR_DEBUG', 'MODULE_SHIPPING_SPSR_ALLOWED', 'MODULE_SHIPPING_SPSR_TAX_CLASS', 'MODULE_SHIPPING_SPSR_ZONE', 'MODULE_SHIPPING_SPSR_SORT_ORDER');
    }
  }
?>

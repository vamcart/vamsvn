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

        $urlCities = "http://emspost.ru/api/rest?method=ems.get.locations&type=cities&plain=true";
        $urlWeight = "http://emspost.ru/api/rest?method=ems.get.max.weight";

        // create curl resource
        //$ch = curl_init();

        //return the transfer as a string
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // set url
		//curl_setopt($ch, CURLOPT_URL, $urlWeight);
		//$outWeight = curl_exec($ch);
		$outWeight = Curl_Page($urlWeight);
		
	    $WeightList = json_decode($outWeight, true);

       foreach ($WeightList as $weight){
	   $max_weight = $weight['max_weight'];

	if ($shipping_weight > $max_weight){
	  $this->quotes['error']='Превышен максимально возможный вес одного отправления. Разбейте заказ на несколько частей.';
	  return $this->quotes;

 }
 }
		
//Получаем список городов и регионов		

        $urlRussia = "http://emspost.ru/api/rest?method=ems.get.locations&type=russia&plain=true";

        // create curl resource
        //$ch = curl_init();

        //return the transfer as a string
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // set url
		//curl_setopt($ch, CURLOPT_URL, $urlRussia);
		//$outRussia = curl_exec($ch);
		$outRussia = Curl_Page($urlRussia);
		//print 'outRussia';
		//print_r($outRussia);

	
	//Вытягиваем регион магазина
		$zones_shop = STORE_ZONE;
		$zones_zones = vam_db_query("select zone_id, zone_name from " . TABLE_ZONES . " where (zone_id='$zones_shop')");
		$zones_id = vam_db_fetch_array($zones_zones);
		$zonesshop = $zones_id['zone_name'];
		//echo $zones_id['zone_name'];
	//Вытягиваем город получателя
	$tocity = $order->delivery['city'];
	//print $tocity;
	//Вытягиваем регион получателя 
	$tostate_id = $order->delivery['state']; 
	$tostate_tostate = vam_db_query("select zone_id, zone_name from " . TABLE_ZONES . " where (zone_name='$tostate_id')");
	//print_r($tostate_tostate['zone_id']);
	$tostate_tostate_id = vam_db_fetch_array($tostate_tostate);
	$tostate = $tostate_tostate_id['zone_name'];
	//print($tostate)."<br><br>";
	
		
		//проверяем город/регион отправителя/получателя
		$RussiaList = json_decode($outRussia, true);
        foreach ($RussiaList['rsp']['locations'] as $russia){
    		//print mb_convert_case($russia['name'], MB_CASE_UPPER, "UTF-8")."<br>";
//		print 
		$str = MODULE_SHIPPING_RUSSIANPOSTEMS_CITY;
		//print $str;
		//print "АПП".mb_convert_case($str, MB_CASE_UPPER, "UTF-8");
		$mode=MB_CASE_UPPER;
		$conv="UTF-8";
		$rus01 = mb_convert_case($russia['name'], MB_CASE_UPPER,"UTF-8");
		$rus02 = mb_convert_case($str, MB_CASE_UPPER,"UTF-8");
		//print "rus01".$rus02."<br>";
          if ($rus01 == $rus02){
            //print "rus01".$rus01."== rus02".$rus02."<br>";
            //$from = $rus01;
            $from = $russia['value'];
            //print "from1 ".$from."<br>";
		  }
		  if ($from === null){
		   if (mb_convert_case($russia['name'],$mode,$conv) == mb_convert_case($zonesshop,$mode,$conv)){
                  //print mb_convert_case($russia['name'],$mode,$conv). "==". mb_convert_case($zonesshop,$mode,$conv)."<br>";
            
            $from = $russia['value'];
            //print "from2 ".$from."<br>";
		   }
		  }
		  
		  if (mb_convert_case($russia['name'],$mode,$conv) == mb_convert_case($tocity,$mode,$conv)){
		    //print mb_convert_case($russia['name'],$mode,$conv) ."==". mb_convert_case($tocity,$mode,$conv)."<br>";

            $to = $russia['value'];
        		$tomessag = 'город: '. $russia['name'];
        		//print "To 1".$tomessag;
          }
		  if ($to === null){
		   if (mb_convert_case($russia['name'],$mode,$conv) == mb_convert_case($tostate,$mode,$conv)){
		    //print mb_convert_case($russia['name'],$mode,$conv) ."==". mb_convert_case($tostate,$mode,$conv)."<br>";

            $to = $russia['value'];
			$tomessag = 'регион: '. $russia['name'];
			//print "To 2".$tomessag;
		   }
		  }
		 }
	    //echo "russ list";
		//print_r($RussiaList);
  // Если вдруг ничего не нашлось		
		
	if ($from === null){
	  $this->quotes['error']='Доставка из города:  '. MODULE_SHIPPING_RUSSIANPOSTEMS_CITY. ' не производится! Возможно Вы допустили ошибку в адресе.';
	  return $this->quotes;
	} else if ($to === null){
	  $this->quotes['error']='Доставка в город:  '. $tocity. ' не производится! Возможно Вы допустили ошибку в адресе.';
	  return $this->quotes;
	}
	//----

		

		$url = "http://emspost.ru/api/rest?method=ems.calculate&from=".$from."&to=".$to."&weight=".$shipping_weight;
		//print "calculaded".$url;
		//curl_setopt($ch, CURLOPT_URL, $url);
        //$output = curl_exec($ch);
	$output = Curl_Page($url);
        // close curl resource to free up system resources
        //curl_close($ch);

        $contents = $output;
        $contents = $contents;
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
		$this->quotes['methods'][key($this->quotes['methods'])]['title'] = 'Доставка в ' . $tomessag. '. ';
        $dlvr_min = $results['rsp']['term']['min'];
        $dlvr_max = $results['rsp']['term']['max'];
        if (($dlvr_min > 0) AND ( $dlvr_max > 0)){
          if ($dlvr_min == $dlvr_max){
            $this->quotes['methods'][key($this->quotes['methods'])]['title'] .= '(<i>Срок доставки '.$dlvr_max;
          } else {
            $this->quotes['methods'][key($this->quotes['methods'])]['title'] .= '(<i>Срок доставки '.$dlvr_min.' - '.$dlvr_max;
          }
          if ($dlvr_max == 1){
            $this->quotes['methods'][key($this->quotes['methods'])]['title'] .= ' день';
          } else if (($dlvr_max > 1) and ($dlvr_max < 5)){
            $this->quotes['methods'][key($this->quotes['methods'])]['title'] .= ' дня';
          } else {
            $this->quotes['methods'][key($this->quotes['methods'])]['title'] .= ' дней';
          }
          $this->quotes['methods'][key($this->quotes['methods'])]['title'] .= '</i>)';
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
  
//date_default_timezone_set('Europe/Moscow');
//date_default_timezone_set('Europe/London');

$agent = "Mozilla/5.1 (Windows; U; Windows NT 5.0; ru-RU; rv:1.7.12) Gecko/20050919 Firefox/1.7.7" ;
// ставим, что наш броузер читает только файлы в html формате
$header [] = "Accept: text/html;q=0.9, text/plain;q=0.8, image/png, */*;q=0.5" ;
$header [] = "Accept_charset: windows-1251, utf-8, utf-16;q=0.6, *;q=0.1";
// говорим, что броузер не читает файлы в gzip формате
$header [] = "Accept_encoding: identity";
$header [] = "Accept_language: en-us,en;q=0.5";
$header [] = "Connection: close";
$header [] = "Cache-Control: no-store, no-cache, must-revalidate";
$header [] = "Keep_alive: 300";
$header [] = "Expires: Thu, 01 Jan 1970 00:00:01 GMT";
$cookie_file= "cookie.txt";
$cookie_file_dop= "cookie_dop_en.txt";



function data_encode ( $data , $keyprefix = "" , $keypostfix = "" ) {
    assert ( is_array ( $data ) );
            $vars = null ;
            foreach ( $data as $key => $value ) {
    if ( is_array ( $value )) $vars .= data_encode ( $value , $keyprefix . $key . $keypostfix . urlencode ( "[" ), urlencode ( "]" ));
        else $vars .= $keyprefix . $key . $keypostfix . "=" . urlencode ( $value ). "&" ;
                        }
        return $vars ;
}

// функция вывода страницы

function Curl_Page ( $path ) {
        // $path - страничка, какую смотрим
        global $agent, $header, $referer, $arr_cookie, $cookie_file;
        // вызываем сеанс Curl
        $ch = curl_init ( $path );
        // CURL будет возвращать результат, а не выводить его в печать
        curl_setopt ( $ch , CURLOPT_RETURNTRANSFER , 1 );
        // выводим подробные сообщения о всех действиях
        curl_setopt ( $ch , CURLOPT_VERBOSE , 0 ); //1
        // считываем страничку с хедером от сервера
        //curl_setopt ( $ch , CURLOPT_HEADER , 1 );
        // отправим серверу user_agent сформированный нами самими
        curl_setopt ( $ch , CURLOPT_USERAGENT , $agent );
        // оправляем $referer, что пришли с первой страницы сайта
        curl_setopt ( $ch , CURLOPT_REFERER , $referer );
        // оправляем на сервер хедер, который мы сами сформировали
        //curl_setopt ( $ch , CURLOPT_HTTPHEADER , $header );
        // при получении HTTP заголовка "Location: " будет 
        // происходить перенаправление
        curl_setopt ( $ch , CURLOPT_FOLLOWLOCATION , 1 );
        // запретить проверку сертификата удаленного сервера
        curl_setopt ( $ch , CURLOPT_SSL_VERIFYPEER, 0 );
        // не будем проверять существование имени
       curl_setopt ( $ch , CURLOPT_SSL_VERIFYHOST, 0 );
    // если есть массив с cookie, то отправим серверу, эти cookie
        if ( @is_array ($arr_cookie)){
          while (list($key, $val) = @each ($arr_cookie)){
            $COKKIES .= trim ($val[0])."=". trim ($val[1])."; ";
                     }
              @curl_setopt ( $ch , CURLOPT_COOKIE , $COKKIES." expires=Mon, 14-Apr-08 10:34:13 GMT" );
                  }
       // если с сервера пришло cookie, то запишем его в файл $cookie_file
        //@curl_setopt ( $ch , CURLOPT_COOKIEJAR , $cookie_file );
        //@curl_setopt ( $ch , CURLOPT_COOKIEFILE , $cookie_file );
       // если мы послали данные из формы, которая стоит 
      // на страничке $path, добавляем метод $_POST
      if (isset($_POST) and $_SERVER["REQUEST_METHOD"]=="POST"){
              curl_setopt ( $ch , CURLOPT_POST , 1 );
              curl_setopt ( $ch , CURLOPT_POSTFIELDS , substr ( data_encode ( $_POST ), 0 , - 1 ) );
               } 
    // получаем страничку $path с хедером
   $tmp = curl_exec ( $ch );
  // закрываем сеанс Curl
    curl_close ( $ch ); 
// если Curl ничего не вывел пробуем это сделать output_r();
// эта функция описана здесь, она использует сокет.
  if ($tmp==''){ $tmp = output_r ($path); }
//print $tmp;
return $tmp;
}
  
?>
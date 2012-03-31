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


//  class russianpostems {
//    var $code, $title, $description, $icon, $enabled;


//date_default_timezone_set('Europe/Moscow');
//date_default_timezone_set('Europe/London');

//$agent = "Mozilla/5.1 (Windows; U; Windows NT 5.0; ru-RU; rv:1.7.12) Gecko/20050919 Firefox/1.7.7" ;
// ставим, что наш броузер читает только файлы в html формате
//$header [] = "Accept: text/html;q=0.9, text/plain;q=0.8, image/png, */*;q=0.5" ;
//$header [] = "Accept_charset: windows-1251, utf-8, utf-16;q=0.6, *;q=0.1";
// говорим, что броузер не читает файлы в gzip формате
//$header [] = "Accept_encoding: identity";
//$header [] = "Accept_language: en-us,en;q=0.5";
//$header [] = "Connection: close";
//$header [] = "Cache-Control: no-store, no-cache, must-revalidate";
//$header [] = "Keep_alive: 300";
//$header [] = "Expires: Thu, 01 Jan 1970 00:00:01 GMT";
//$cookie_file= "cookie.txt";
//$cookie_file_dop= "cookie_dop_en.txt";


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
	
//$outRussia=<<<Q
//{"rsp":{"stat":"ok","locations":[{"value":"city--abakan","name":"\u0425\u0410\u041a\u0410\u0421\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--anadyr","name":"\u0427\u0423\u041a\u041e\u0422\u0421\u041a\u0418\u0419\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"city--anapa","name":"\u041a\u0420\u0410\u0421\u041d\u041e\u0414\u0410\u0420\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--arhangelsk","name":"\u0410\u0420\u0425\u0410\u041d\u0413\u0415\u041b\u042c\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--astrahan","name":"\u0410\u0421\u0422\u0420\u0410\u0425\u0410\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--bajkonur","name":"\u041a\u0410\u0417\u0410\u0425\u0421\u0422\u0410\u041d","type":"regions"},{"value":"city--barnaul","name":"\u0410\u041b\u0422\u0410\u0419\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--belgorod","name":"\u0411\u0415\u041b\u0413\u041e\u0420\u041e\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--birobidzhan","name":"\u0415\u0412\u0420\u0415\u0419\u0421\u041a\u0410\u042f\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--blagoveshhensk","name":"\u0410\u041c\u0423\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--brjansk","name":"\u0411\u0420\u042f\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--velikij-novgorod","name":"\u041d\u041e\u0412\u0413\u041e\u0420\u041e\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--vladivostok","name":"\u041f\u0420\u0418\u041c\u041e\u0420\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--vladikavkaz","name":"\u0421\u0415\u0412\u0415\u0420\u041d\u0410\u042f\u041e\u0421\u0415\u0422\u0418\u042f-\u0410\u041b\u0410\u041d\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--vladimir","name":"\u0412\u041b\u0410\u0414\u0418\u041c\u0418\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--volgograd","name":"\u0412\u041e\u041b\u0413\u041e\u0413\u0420\u0410\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--vologda","name":"\u0412\u041e\u041b\u041e\u0413\u041e\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--vorkuta","name":"\u041a\u041e\u041c\u0418\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--voronezh","name":"\u0412\u041e\u0420\u041e\u041d\u0415\u0416\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--gorno-altajsk","name":"\u0410\u041b\u0422\u0410\u0419\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--groznyj","name":"\u0427\u0415\u0427\u0415\u041d\u0421\u041a\u0410\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--dudinka","name":"\u041a\u0420\u0410\u0421\u041d\u041e\u042f\u0420\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--ekaterinburg","name":"\u0421\u0412\u0415\u0420\u0414\u041b\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--elizovo","name":"\u041a\u0410\u041c\u0427\u0410\u0422\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--ivanovo","name":"\u0418\u0412\u0410\u041d\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--izhevsk","name":"\u0423\u0414\u041c\u0423\u0420\u0422\u0421\u041a\u0410\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--irkutsk","name":"\u0418\u0420\u041a\u0423\u0422\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--ioshkar-ola","name":"\u041c\u0410\u0420\u0418\u0419\u042d\u041b\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--kazan","name":"\u0422\u0410\u0422\u0410\u0420\u0421\u0422\u0410\u041d\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--kaliningrad","name":"\u041a\u0410\u041b\u0418\u041d\u0418\u041d\u0413\u0420\u0410\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--kaluga","name":"\u041a\u0410\u041b\u0423\u0416\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--kemerovo","name":"\u041a\u0415\u041c\u0415\u0420\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--kirov","name":"\u041a\u0418\u0420\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--kostomuksha","name":"\u041a\u0410\u0420\u0415\u041b\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--kostroma","name":"\u041a\u041e\u0421\u0422\u0420\u041e\u041c\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--krasnodar","name":"\u041a\u0420\u0410\u0421\u041d\u041e\u0414\u0410\u0420\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--krasnojarsk","name":"\u041a\u0420\u0410\u0421\u041d\u041e\u042f\u0420\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--kurgan","name":"\u041a\u0423\u0420\u0413\u0410\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--kursk","name":"\u041a\u0423\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--kyzyl","name":"\u0422\u042b\u0412\u0410\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--lipeck","name":"\u041b\u0418\u041f\u0415\u0426\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--magadan","name":"\u041c\u0410\u0413\u0410\u0414\u0410\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--magnitogorsk","name":"\u0427\u0415\u041b\u042f\u0411\u0418\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--majkop","name":"\u0410\u0414\u042b\u0413\u0415\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--mahachkala","name":"\u0414\u0410\u0413\u0415\u0421\u0422\u0410\u041d\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--mineralnye-vody","name":"\u0421\u0422\u0410\u0412\u0420\u041e\u041f\u041e\u041b\u042c\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--mirnyj","name":"\u0421\u0410\u0425\u0410(\u042f\u041a\u0423\u0422\u0418\u042f)\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--moskva","name":"\u041c\u041e\u0421\u041a\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--murmansk","name":"\u041c\u0423\u0420\u041c\u0410\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--mytishhi","name":"\u041c\u041e\u0421\u041a\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--naberezhnye-chelny","name":"\u0422\u0410\u0422\u0410\u0420\u0421\u0422\u0410\u041d\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--nadym","name":"\u042f\u041c\u0410\u041b\u041e-\u041d\u0415\u041d\u0415\u0426\u041a\u0418\u0419\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"city--nazran","name":"\u0418\u041d\u0413\u0423\u0428\u0415\u0422\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--nalchik","name":"\u041a\u0410\u0411\u0410\u0420\u0414\u0418\u041d\u041e-\u0411\u0410\u041b\u041a\u0410\u0420\u0421\u041a\u0410\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--narjan-mar","name":"\u041d\u0415\u041d\u0415\u0426\u041a\u0418\u0419\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"city--nerjungri","name":"\u0421\u0410\u0425\u0410(\u042f\u041a\u0423\u0422\u0418\u042f)\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--neftejugansk","name":"\u0425\u0410\u041d\u0422\u042b-\u041c\u0410\u041d\u0421\u0418\u0419\u0421\u041a\u0418\u0419-\u042e\u0413\u0420\u0410\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"city--nizhnevartovsk","name":"\u0425\u0410\u041d\u0422\u042b-\u041c\u0410\u041d\u0421\u0418\u0419\u0421\u041a\u0418\u0419-\u042e\u0413\u0420\u0410\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"city--nizhnij-novgorod","name":"\u041d\u0418\u0416\u0415\u0413\u041e\u0420\u041e\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--novokuzneck","name":"\u041a\u0415\u041c\u0415\u0420\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--novorossijsk","name":"\u041a\u0420\u0410\u0421\u041d\u041e\u0414\u0410\u0420\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--novosibirsk","name":"\u041d\u041e\u0412\u041e\u0421\u0418\u0411\u0418\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--novyj-urengoj","name":"\u042f\u041c\u0410\u041b\u041e-\u041d\u0415\u041d\u0415\u0426\u041a\u0418\u0419\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"city--norilsk","name":"\u041a\u0420\u0410\u0421\u041d\u041e\u042f\u0420\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--nojabrsk","name":"\u042f\u041c\u0410\u041b\u041e-\u041d\u0415\u041d\u0415\u0426\u041a\u0418\u0419\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"city--omsk","name":"\u041e\u041c\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--orel","name":"\u041e\u0420\u041b\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--orenburg","name":"\u041e\u0420\u0415\u041d\u0411\u0423\u0420\u0413\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--penza","name":"\u041f\u0415\u041d\u0417\u0415\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--perm","name":"\u041f\u0415\u0420\u041c\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--petrozavodsk","name":"\u041a\u0410\u0420\u0415\u041b\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--petropavlovsk-kamchatskij","name":"\u041a\u0410\u041c\u0427\u0410\u0422\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--pskov","name":"\u041f\u0421\u041a\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--rostov-na-donu","name":"\u0420\u041e\u0421\u0422\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--rjazan","name":"\u0420\u042f\u0417\u0410\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--salehard","name":"\u042f\u041c\u0410\u041b\u041e-\u041d\u0415\u041d\u0415\u0426\u041a\u0418\u0419\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"city--samara","name":"\u0421\u0410\u041c\u0410\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--sankt-peterburg","name":"\u041b\u0415\u041d\u0418\u041d\u0413\u0420\u0410\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--saransk","name":"\u041c\u041e\u0420\u0414\u041e\u0412\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--saratov","name":"\u0421\u0410\u0420\u0410\u0422\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--smolensk","name":"\u0421\u041c\u041e\u041b\u0415\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--sochi","name":"\u041a\u0420\u0410\u0421\u041d\u041e\u0414\u0410\u0420\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--stavropol","name":"\u0421\u0422\u0410\u0412\u0420\u041e\u041f\u041e\u041b\u042c\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--strezhevoj","name":"\u0422\u041e\u041c\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--surgut","name":"\u0425\u0410\u041d\u0422\u042b-\u041c\u0410\u041d\u0421\u0418\u0419\u0421\u041a\u0418\u0419-\u042e\u0413\u0420\u0410\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"city--syktyvkar","name":"\u041a\u041e\u041c\u0418\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--tambov","name":"\u0422\u0410\u041c\u0411\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--tver","name":"\u0422\u0412\u0415\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--toljatti","name":"\u0421\u0410\u041c\u0410\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--tomsk","name":"\u0422\u041e\u041c\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--tula","name":"\u0422\u0423\u041b\u042c\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--tynda","name":"\u0410\u041c\u0423\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--tjumen","name":"\u0422\u042e\u041c\u0415\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--ulan-udje","name":"\u0411\u0423\u0420\u042f\u0422\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--uljanovsk","name":"\u0423\u041b\u042c\u042f\u041d\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--usinsk","name":"\u041a\u041e\u041c\u0418\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--ufa","name":"\u0411\u0410\u0428\u041a\u041e\u0420\u0422\u041e\u0421\u0422\u0410\u041d\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--uhta","name":"\u041a\u041e\u041c\u0418\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--khabarovsk","name":"\u0425\u0410\u0411\u0410\u0420\u041e\u0412\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--khanty-mansijsk","name":"\u0425\u0410\u041d\u0422\u042b-\u041c\u0410\u041d\u0421\u0418\u0419\u0421\u041a\u0418\u0419-\u042e\u0413\u0420\u0410\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"city--kholmsk","name":"\u0421\u0410\u0425\u0410\u041b\u0418\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--cheboksary","name":"\u0427\u0423\u0412\u0410\u0428\u0421\u041a\u0410\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--cheljabinsk","name":"\u0427\u0415\u041b\u042f\u0411\u0418\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--cherepovec","name":"\u0412\u041e\u041b\u041e\u0413\u041e\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--cherkessk","name":"\u041a\u0410\u0420\u0410\u0427\u0410\u0415\u0412\u041e-\u0427\u0415\u0420\u041a\u0415\u0421\u0421\u041a\u0410\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--chita","name":"\u0417\u0410\u0411\u0410\u0419\u041a\u0410\u041b\u042c\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"city--elista","name":"\u041a\u0410\u041b\u041c\u042b\u041a\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--yuzhno-sahalinsk","name":"\u0421\u0410\u0425\u0410\u041b\u0418\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"city--yakutsk","name":"\u0421\u0410\u0425\u0410(\u042f\u041a\u0423\u0422\u0418\u042f)\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"city--yaroslavl","name":"\u042f\u0420\u041e\u0421\u041b\u0410\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--respublika-adygeja","name":"\u0410\u0414\u042b\u0413\u0415\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--respublika-altaj","name":"\u0410\u041b\u0422\u0410\u0419\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--altajskij-kraj","name":"\u0410\u041b\u0422\u0410\u0419\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"region--amurskaja-oblast","name":"\u0410\u041c\u0423\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--arhangelskaja-oblast","name":"\u0410\u0420\u0425\u0410\u041d\u0413\u0415\u041b\u042c\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--astrahanskaja-oblast","name":"\u0410\u0421\u0422\u0420\u0410\u0425\u0410\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--respublika-bashkortostan","name":"\u0411\u0410\u0428\u041a\u041e\u0420\u0422\u041e\u0421\u0422\u0410\u041d\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--belgorodskaja-oblast","name":"\u0411\u0415\u041b\u0413\u041e\u0420\u041e\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--brjanskaja-oblast","name":"\u0411\u0420\u042f\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--respublika-burjatija","name":"\u0411\u0423\u0420\u042f\u0422\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--vladimirskaja-oblast","name":"\u0412\u041b\u0410\u0414\u0418\u041c\u0418\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--volgogradskaja-oblast","name":"\u0412\u041e\u041b\u0413\u041e\u0413\u0420\u0410\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--vologodskaja-oblast","name":"\u0412\u041e\u041b\u041e\u0413\u041e\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--voronezhskaja-oblast","name":"\u0412\u041e\u0420\u041e\u041d\u0415\u0416\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--respublika-dagestan","name":"\u0414\u0410\u0413\u0415\u0421\u0422\u0410\u041d\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--evrejskaja-ao","name":"\u0415\u0412\u0420\u0415\u0419\u0421\u041a\u0410\u042f\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--zabajkalskij-kraj","name":"\u0417\u0410\u0411\u0410\u0419\u041a\u0410\u041b\u042c\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"region--ivanovskaja-oblast","name":"\u0418\u0412\u0410\u041d\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--respublika-ingushetija","name":"\u0418\u041d\u0413\u0423\u0428\u0415\u0422\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--irkutskaja-oblast","name":"\u0418\u0420\u041a\u0423\u0422\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--kabardino-balkarskaja-respublika","name":"\u041a\u0410\u0411\u0410\u0420\u0414\u0418\u041d\u041e-\u0411\u0410\u041b\u041a\u0410\u0420\u0421\u041a\u0410\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--kaliningradskaja-oblast","name":"\u041a\u0410\u041b\u0418\u041d\u0418\u041d\u0413\u0420\u0410\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--respublika-kalmykija","name":"\u041a\u0410\u041b\u041c\u042b\u041a\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--kaluzhskaja-oblast","name":"\u041a\u0410\u041b\u0423\u0416\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--kamchatskij-kraj","name":"\u041a\u0410\u041c\u0427\u0410\u0422\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"region--karachaevo-cherkesskaja-respublika","name":"\u041a\u0410\u0420\u0410\u0427\u0410\u0415\u0412\u041e-\u0427\u0415\u0420\u041a\u0415\u0421\u0421\u041a\u0410\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--respublika-karelija","name":"\u041a\u0410\u0420\u0415\u041b\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--kemerovskaja-oblast","name":"\u041a\u0415\u041c\u0415\u0420\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--kirovskaja-oblast","name":"\u041a\u0418\u0420\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--respublika-komi","name":"\u041a\u041e\u041c\u0418\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--kostromskaja-oblast","name":"\u041a\u041e\u0421\u0422\u0420\u041e\u041c\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--krasnodarskij-kraj","name":"\u041a\u0420\u0410\u0421\u041d\u041e\u0414\u0410\u0420\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"region--krasnojarskij-kraj","name":"\u041a\u0420\u0410\u0421\u041d\u041e\u042f\u0420\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"region--kurganskaja-oblast","name":"\u041a\u0423\u0420\u0413\u0410\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--kurskaja-oblast","name":"\u041a\u0423\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--leningradskaja-oblast","name":"\u041b\u0415\u041d\u0418\u041d\u0413\u0420\u0410\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--lipeckaja-oblast","name":"\u041b\u0418\u041f\u0415\u0426\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--magadanskaja-oblast","name":"\u041c\u0410\u0413\u0410\u0414\u0410\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--respublika-marij-el","name":"\u041c\u0410\u0420\u0418\u0419\u042d\u041b\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--respublika-mordovija","name":"\u041c\u041e\u0420\u0414\u041e\u0412\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--moskovskaja-oblast","name":"\u041c\u041e\u0421\u041a\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--murmanskaja-oblast","name":"\u041c\u0423\u0420\u041c\u0410\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--neneckij-ao","name":"\u041d\u0415\u041d\u0415\u0426\u041a\u0418\u0419\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"region--nizhegorodskaja-oblast","name":"\u041d\u0418\u0416\u0415\u0413\u041e\u0420\u041e\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--novgorodskaja-oblast","name":"\u041d\u041e\u0412\u0413\u041e\u0420\u041e\u0414\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--novosibirskaja-oblast","name":"\u041d\u041e\u0412\u041e\u0421\u0418\u0411\u0418\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--omskaja-oblast","name":"\u041e\u041c\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--orenburgskaja-oblast","name":"\u041e\u0420\u0415\u041d\u0411\u0423\u0420\u0413\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--orlovskaja-oblast","name":"\u041e\u0420\u041b\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--penzenskaja-oblast","name":"\u041f\u0415\u041d\u0417\u0415\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--permskij-kraj","name":"\u041f\u0415\u0420\u041c\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"region--primorskij-kraj","name":"\u041f\u0420\u0418\u041c\u041e\u0420\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"region--pskovskaja-oblast","name":"\u041f\u0421\u041a\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--rostovskaja-oblast","name":"\u0420\u041e\u0421\u0422\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--rjazanskaja-oblast","name":"\u0420\u042f\u0417\u0410\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--samarskaja-oblast","name":"\u0421\u0410\u041c\u0410\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--saratovskaja-oblast","name":"\u0421\u0410\u0420\u0410\u0422\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--respublika-saha-yakutija","name":"\u0421\u0410\u0425\u0410(\u042f\u041a\u0423\u0422\u0418\u042f)\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--sahalinskaja-oblast","name":"\u0421\u0410\u0425\u0410\u041b\u0418\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--sverdlovskaja-oblast","name":"\u0421\u0412\u0415\u0420\u0414\u041b\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--respublika-sev.osetija-alanija","name":"\u0421\u0415\u0412\u0415\u0420\u041d\u0410\u042f\u041e\u0421\u0415\u0422\u0418\u042f-\u0410\u041b\u0410\u041d\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--smolenskaja-oblast","name":"\u0421\u041c\u041e\u041b\u0415\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--stavropolskij-kraj","name":"\u0421\u0422\u0410\u0412\u0420\u041e\u041f\u041e\u041b\u042c\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"region--tambovskaja-oblast","name":"\u0422\u0410\u041c\u0411\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--respublika-tatarstan","name":"\u0422\u0410\u0422\u0410\u0420\u0421\u0422\u0410\u041d\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--tverskaja-oblast","name":"\u0422\u0412\u0415\u0420\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--tomskaja-oblast","name":"\u0422\u041e\u041c\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--tulskaja-oblast","name":"\u0422\u0423\u041b\u042c\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--respublika-tyva","name":"\u0422\u042b\u0412\u0410\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--tjumenskaja-oblast","name":"\u0422\u042e\u041c\u0415\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--udmurtskaja-respublika","name":"\u0423\u0414\u041c\u0423\u0420\u0422\u0421\u041a\u0410\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--uljanovskaja-oblast","name":"\u0423\u041b\u042c\u042f\u041d\u041e\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--khabarovskij-kraj","name":"\u0425\u0410\u0411\u0410\u0420\u041e\u0412\u0421\u041a\u0418\u0419\u041a\u0420\u0410\u0419","type":"regions"},{"value":"region--respublika-khakasija","name":"\u0425\u0410\u041a\u0410\u0421\u0418\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--khanty-mansijskij-ao","name":"\u0425\u0410\u041d\u0422\u042b-\u041c\u0410\u041d\u0421\u0418\u0419\u0421\u041a\u0418\u0419-\u042e\u0413\u0420\u0410\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"region--cheljabinskaja-oblast","name":"\u0427\u0415\u041b\u042f\u0411\u0418\u041d\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--chuvashskaja-respublika","name":"\u0427\u0423\u0412\u0410\u0428\u0421\u041a\u0410\u042f\u0420\u0415\u0421\u041f\u0423\u0411\u041b\u0418\u041a\u0410","type":"regions"},{"value":"region--chukotskij-ao","name":"\u0427\u0423\u041a\u041e\u0422\u0421\u041a\u0418\u0419\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"region--yamalo-neneckij-ao","name":"\u042f\u041c\u0410\u041b\u041e-\u041d\u0415\u041d\u0415\u0426\u041a\u0418\u0419\u0410\u0412\u0422\u041e\u041d\u041e\u041c\u041d\u042b\u0419\u041e\u041a\u0420\u0423\u0413","type":"regions"},{"value":"region--yaroslavskaja-oblast","name":"\u042f\u0420\u041e\u0421\u041b\u0410\u0412\u0421\u041a\u0410\u042f\u041e\u0411\u041b\u0410\u0421\u0422\u042c","type":"regions"},{"value":"region--kazahstan","name":"\u041a\u0410\u0417\u0410\u0425\u0421\u0422\u0410\u041d","type":"regions"},{"value":"region--tajmyrskij-ao","name":"\u0422\u0410\u0419\u041c\u042b\u0420\u0421\u041a\u0418\u0419\u0410\u041e","type":"regions"}]}}
//Q;
//setlocale (LC_ALL, "ru_RU.UTF-8");

//$outRussia=<<<Q
//{"rsp":{"stat":"ok","locations":[{"value":"city--abakan","name":"АБАКАН","type":"cities"},{"value":"city--anadyr","name":"АНАДЫРЬ","type":"cities"},{"value":"city--anapa","name":"АНАПА","type":"cities"},{"value":"city--arhangelsk","name":"АРХАНГЕЛЬСК","type":"cities"},{"value":"city--astrahan","name":"АСТРАХАНЬ","type":"cities"},{"value":"city--bajkonur","name":"БАЙКОНУР","type":"cities"},{"value":"city--barnaul","name":"БАРНАУЛ","type":"cities"},{"value":"city--belgorod","name":"БЕЛГОРОД","type":"cities"},{"value":"city--birobidzhan","name":"БИРОБИДЖАН","type":"cities"},{"value":"city--blagoveshhensk","name":"БЛАГОВЕЩЕНСК","type":"cities"},{"value":"city--brjansk","name":"БРЯНСК","type":"cities"},{"value":"city--velikij-novgorod","name":"ВЕЛИКИЙ НОВГОРОД","type":"cities"},{"value":"city--vladivostok","name":"ВЛАДИВОСТОК","type":"cities"},{"value":"city--vladikavkaz","name":"ВЛАДИКАВКАЗ","type":"cities"},{"value":"city--vladimir","name":"ВЛАДИМИР","type":"cities"},{"value":"city--volgograd","name":"ВОЛГОГРАД","type":"cities"},{"value":"city--vologda","name":"ВОЛОГДА","type":"cities"},{"value":"city--vorkuta","name":"ВОРКУТА","type":"cities"},{"value":"city--voronezh","name":"ВОРОНЕЖ","type":"cities"},{"value":"city--gorno-altajsk","name":"ГОРНО-АЛТАЙСК","type":"cities"},{"value":"city--groznyj","name":"ГРОЗНЫЙ","type":"cities"},{"value":"city--dudinka","name":"ДУДИНКА","type":"cities"},{"value":"city--ekaterinburg","name":"ЕКАТЕРИНБУРГ","type":"cities"},{"value":"city--elizovo","name":"ЕЛИЗОВО","type":"cities"},{"value":"city--ivanovo","name":"ИВАНОВО","type":"cities"},{"value":"city--izhevsk","name":"ИЖЕВСК","type":"cities"},{"value":"city--irkutsk","name":"ИРКУТСК","type":"cities"},{"value":"city--ioshkar-ola","name":"ЙОШКАР-ОЛА","type":"cities"},{"value":"city--kazan","name":"КАЗАНЬ","type":"cities"},{"value":"city--kaliningrad","name":"КАЛИНИНГРАД","type":"cities"},{"value":"city--kaluga","name":"КАЛУГА","type":"cities"},{"value":"city--kemerovo","name":"КЕМЕРОВО","type":"cities"},{"value":"city--kirov","name":"КИРОВ","type":"cities"},{"value":"city--kostomuksha","name":"КОСТОМУКША","type":"cities"},{"value":"city--kostroma","name":"КОСТРОМА","type":"cities"},{"value":"city--krasnodar","name":"КРАСНОДАР","type":"cities"},{"value":"city--krasnojarsk","name":"КРАСНОЯРСК","type":"cities"},{"value":"city--kurgan","name":"КУРГАН","type":"cities"},{"value":"city--kursk","name":"КУРСК","type":"cities"},{"value":"city--kyzyl","name":"КЫЗЫЛ","type":"cities"},{"value":"city--lipeck","name":"ЛИПЕЦК","type":"cities"},{"value":"city--magadan","name":"МАГАДАН","type":"cities"},{"value":"city--magnitogorsk","name":"МАГНИТОГОРСК","type":"cities"},{"value":"city--majkop","name":"МАЙКОП","type":"cities"},{"value":"city--mahachkala","name":"МАХАЧКАЛА","type":"cities"},{"value":"city--mineralnye-vody","name":"МИНЕРАЛЬНЫЕ ВОДЫ","type":"cities"},{"value":"city--mirnyj","name":"МИРНЫЙ","type":"cities"},{"value":"city--moskva","name":"МОСКВА","type":"cities"},{"value":"city--murmansk","name":"МУРМАНСК","type":"cities"},{"value":"city--mytishhi","name":"МЫТИЩИ","type":"cities"},{"value":"city--naberezhnye-chelny","name":"НАБЕРЕЖНЫЕ ЧЕЛНЫ","type":"cities"},{"value":"city--nadym","name":"НАДЫМ","type":"cities"},{"value":"city--nazran","name":"НАЗРАНЬ","type":"cities"},{"value":"city--nalchik","name":"НАЛЬЧИК","type":"cities"},{"value":"city--narjan-mar","name":"НАРЬЯН-МАР","type":"cities"},{"value":"city--nerjungri","name":"НЕРЮНГРИ","type":"cities"},{"value":"city--neftejugansk","name":"НЕФТЕЮГАНСК","type":"cities"},{"value":"city--nizhnevartovsk","name":"НИЖНЕВАРТОВСК","type":"cities"},{"value":"city--nizhnij-novgorod","name":"НИЖНИЙ НОВГОРОД","type":"cities"},{"value":"city--novokuzneck","name":"НОВОКУЗНЕЦК","type":"cities"},{"value":"city--novorossijsk","name":"НОВОРОССИЙСК","type":"cities"},{"value":"city--novosibirsk","name":"НОВОСИБИРСК","type":"cities"},{"value":"city--novyj-urengoj","name":"НОВЫЙ УРЕНГОЙ","type":"cities"},{"value":"city--norilsk","name":"НОРИЛЬСК","type":"cities"},{"value":"city--nojabrsk","name":"НОЯБРЬСК","type":"cities"},{"value":"city--omsk","name":"ОМСК","type":"cities"},{"value":"city--orel","name":"ОРЁЛ","type":"cities"},{"value":"city--orenburg","name":"ОРЕНБУРГ","type":"cities"},{"value":"city--penza","name":"ПЕНЗА","type":"cities"},{"value":"city--perm","name":"ПЕРМЬ","type":"cities"},{"value":"city--petrozavodsk","name":"ПЕТРОЗАВОДСК","type":"cities"},{"value":"city--petropavlovsk-kamchatskij","name":"ПЕТРОПАВЛОВСК-КАМЧАТСКИЙ","type":"cities"},{"value":"city--pskov","name":"ПСКОВ","type":"cities"},{"value":"city--rostov-na-donu","name":"РОСТОВ-НА-ДОНУ","type":"cities"},{"value":"city--rjazan","name":"РЯЗАНЬ","type":"cities"},{"value":"city--salehard","name":"САЛЕХАРД","type":"cities"},{"value":"city--samara","name":"САМАРА","type":"cities"},{"value":"city--sankt-peterburg","name":"САНКТ-ПЕТЕРБУРГ","type":"cities"},{"value":"city--saransk","name":"САРАНСК","type":"cities"},{"value":"city--saratov","name":"САРАТОВ","type":"cities"},{"value":"city--smolensk","name":"СМОЛЕНСК","type":"cities"},{"value":"city--sochi","name":"СОЧИ","type":"cities"},{"value":"city--stavropol","name":"СТАВРОПОЛЬ","type":"cities"},{"value":"city--strezhevoj","name":"СТРЕЖЕВОЙ","type":"cities"},{"value":"city--surgut","name":"СУРГУТ","type":"cities"},{"value":"city--syktyvkar","name":"СЫКТЫВКАР","type":"cities"},{"value":"city--tambov","name":"ТАМБОВ","type":"cities"},{"value":"city--tver","name":"ТВЕРЬ","type":"cities"},{"value":"city--toljatti","name":"ТОЛЬЯТТИ","type":"cities"},{"value":"city--tomsk","name":"ТОМСК","type":"cities"},{"value":"city--tula","name":"ТУЛА","type":"cities"},{"value":"city--tynda","name":"ТЫНДА","type":"cities"},{"value":"city--tjumen","name":"ТЮМЕНЬ","type":"cities"},{"value":"city--ulan-udje","name":"УЛАН-УДЭ","type":"cities"},{"value":"city--uljanovsk","name":"УЛЬЯНОВСК","type":"cities"},{"value":"city--usinsk","name":"УСИНСК","type":"cities"},{"value":"city--ufa","name":"УФА","type":"cities"},{"value":"city--uhta","name":"УХТА","type":"cities"},{"value":"city--khabarovsk","name":"ХАБАРОВСК","type":"cities"},{"value":"city--khanty-mansijsk","name":"ХАНТЫ-МАНСИЙСК","type":"cities"},{"value":"city--kholmsk","name":"ХОЛМСК","type":"cities"},{"value":"city--cheboksary","name":"ЧЕБОКСАРЫ","type":"cities"},{"value":"city--cheljabinsk","name":"ЧЕЛЯБИНСК","type":"cities"},{"value":"city--cherepovec","name":"ЧЕРЕПОВЕЦ","type":"cities"},{"value":"city--cherkessk","name":"ЧЕРКЕССК","type":"cities"},{"value":"city--chita","name":"ЧИТА","type":"cities"},{"value":"city--elista","name":"ЭЛИСТА","type":"cities"},{"value":"city--yuzhno-sahalinsk","name":"ЮЖНО-САХАЛИНСК","type":"cities"},{"value":"city--yakutsk","name":"ЯКУТСК","type":"cities"},{"value":"city--yaroslavl","name":"ЯРОСЛАВЛЬ","type":"cities"},{"value":"region--respublika-adygeja","name":"АДЫГЕЯ РЕСПУБЛИКА","type":"regions"},{"value":"region--respublika-altaj","name":"АЛТАЙ РЕСПУБЛИКА","type":"regions"},{"value":"region--altajskij-kraj","name":"АЛТАЙСКИЙ КРАЙ","type":"regions"},{"value":"region--amurskaja-oblast","name":"АМУРСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--arhangelskaja-oblast","name":"АРХАНГЕЛЬСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--astrahanskaja-oblast","name":"АСТРАХАНСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--respublika-bashkortostan","name":"БАШКОРТОСТАН РЕСПУБЛИКА","type":"regions"},{"value":"region--belgorodskaja-oblast","name":"БЕЛГОРОДСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--brjanskaja-oblast","name":"БРЯНСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--respublika-burjatija","name":"БУРЯТИЯ РЕСПУБЛИКА","type":"regions"},{"value":"region--vladimirskaja-oblast","name":"ВЛАДИМИРСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--volgogradskaja-oblast","name":"ВОЛГОГРАДСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--vologodskaja-oblast","name":"ВОЛОГОДСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--voronezhskaja-oblast","name":"ВОРОНЕЖСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--respublika-dagestan","name":"ДАГЕСТАН РЕСПУБЛИКА","type":"regions"},{"value":"region--evrejskaja-ao","name":"ЕВРЕЙСКАЯ АВТОНОМНАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--zabajkalskij-kraj","name":"ЗАБАЙКАЛЬСКИЙ КРАЙ","type":"regions"},{"value":"region--ivanovskaja-oblast","name":"ИВАНОВСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--respublika-ingushetija","name":"ИНГУШЕТИЯ РЕСПУБЛИКА","type":"regions"},{"value":"region--irkutskaja-oblast","name":"ИРКУТСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--kabardino-balkarskaja-respublika","name":"КАБАРДИНО-БАЛКАРСКАЯ РЕСПУБЛИКА","type":"regions"},{"value":"region--kaliningradskaja-oblast","name":"КАЛИНИНГРАДСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--respublika-kalmykija","name":"КАЛМЫКИЯ РЕСПУБЛИКА","type":"regions"},{"value":"region--kaluzhskaja-oblast","name":"КАЛУЖСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--kamchatskij-kraj","name":"КАМЧАТСКИЙ КРАЙ","type":"regions"},{"value":"region--karachaevo-cherkesskaja-respublika","name":"КАРАЧАЕВО-ЧЕРКЕССКАЯ РЕСПУБЛИКА","type":"regions"},{"value":"region--respublika-karelija","name":"КАРЕЛИЯ РЕСПУБЛИКА","type":"regions"},{"value":"region--kemerovskaja-oblast","name":"КЕМЕРОВСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--kirovskaja-oblast","name":"КИРОВСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--respublika-komi","name":"КОМИ РЕСПУБЛИКА","type":"regions"},{"value":"region--kostromskaja-oblast","name":"КОСТРОМСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--krasnodarskij-kraj","name":"КРАСНОДАРСКИЙ КРАЙ","type":"regions"},{"value":"region--krasnojarskij-kraj","name":"КРАСНОЯРСКИЙ КРАЙ","type":"regions"},{"value":"region--kurganskaja-oblast","name":"КУРГАНСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--kurskaja-oblast","name":"КУРСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--leningradskaja-oblast","name":"ЛЕНИНГРАДСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--lipeckaja-oblast","name":"ЛИПЕЦКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--magadanskaja-oblast","name":"МАГАДАНСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--respublika-marij-el","name":"МАРИЙ ЭЛ РЕСПУБЛИКА","type":"regions"},{"value":"region--respublika-mordovija","name":"МОРДОВИЯ РЕСПУБЛИКА","type":"regions"},{"value":"region--moskovskaja-oblast","name":"МОСКОВСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--murmanskaja-oblast","name":"МУРМАНСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--neneckij-ao","name":"НЕНЕЦКИЙ АВТОНОМНЫЙ ОКРУГ","type":"regions"},{"value":"region--nizhegorodskaja-oblast","name":"НИЖЕГОРОДСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--novgorodskaja-oblast","name":"НОВГОРОДСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--novosibirskaja-oblast","name":"НОВОСИБИРСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--omskaja-oblast","name":"ОМСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--orenburgskaja-oblast","name":"ОРЕНБУРГСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--orlovskaja-oblast","name":"ОРЛОВСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--penzenskaja-oblast","name":"ПЕНЗЕНСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--permskij-kraj","name":"ПЕРМСКИЙ КРАЙ","type":"regions"},{"value":"region--primorskij-kraj","name":"ПРИМОРСКИЙ КРАЙ","type":"regions"},{"value":"region--pskovskaja-oblast","name":"ПСКОВСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--rostovskaja-oblast","name":"РОСТОВСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--rjazanskaja-oblast","name":"РЯЗАНСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--samarskaja-oblast","name":"САМАРСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--saratovskaja-oblast","name":"САРАТОВСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--respublika-saha-yakutija","name":"САХА (ЯКУТИЯ) РЕСПУБЛИКА","type":"regions"},{"value":"region--sahalinskaja-oblast","name":"САХАЛИНСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--sverdlovskaja-oblast","name":"СВЕРДЛОВСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--respublika-sev.osetija-alanija","name":"СЕВЕРНАЯ ОСЕТИЯ-АЛАНИЯ РЕСПУБЛИКА","type":"regions"},{"value":"region--smolenskaja-oblast","name":"СМОЛЕНСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--stavropolskij-kraj","name":"СТАВРОПОЛЬСКИЙ КРАЙ","type":"regions"},{"value":"region--tambovskaja-oblast","name":"ТАМБОВСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--respublika-tatarstan","name":"ТАТАРСТАН РЕСПУБЛИКА","type":"regions"},{"value":"region--tverskaja-oblast","name":"ТВЕРСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--tomskaja-oblast","name":"ТОМСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--tulskaja-oblast","name":"ТУЛЬСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--respublika-tyva","name":"ТЫВА РЕСПУБЛИКА","type":"regions"},{"value":"region--tjumenskaja-oblast","name":"ТЮМЕНСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--udmurtskaja-respublika","name":"УДМУРТСКАЯ РЕСПУБЛИКА","type":"regions"},{"value":"region--uljanovskaja-oblast","name":"УЛЬЯНОВСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--khabarovskij-kraj","name":"ХАБАРОВСКИЙ КРАЙ","type":"regions"},{"value":"region--respublika-khakasija","name":"ХАКАСИЯ РЕСПУБЛИКА","type":"regions"},{"value":"region--khanty-mansijskij-ao","name":"ХАНТЫ-МАНСИЙСКИЙ-ЮГРА АВТОНОМНЫЙ ОКРУГ","type":"regions"},{"value":"region--cheljabinskaja-oblast","name":"ЧЕЛЯБИНСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--chuvashskaja-respublika","name":"ЧУВАШСКАЯ РЕСПУБЛИКА","type":"regions"},{"value":"region--chukotskij-ao","name":"ЧУКОТСКИЙ АВТОНОМНЫЙ ОКРУГ","type":"regions"},{"value":"region--yamalo-neneckij-ao","name":"ЯМАЛО-НЕНЕЦКИЙ АВТОНОМНЫЙ ОКРУГ","type":"regions"},{"value":"region--yaroslavskaja-oblast","name":"ЯРОСЛАВСКАЯ ОБЛАСТЬ","type":"regions"},{"value":"region--kazahstan","name":"КАЗАХСТАН","type":"regions"},{"value":"region--tajmyrskij-ao","name":"ТАЙМЫРСКИЙ АО","type":"regions"}]}}
//Q;
		
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
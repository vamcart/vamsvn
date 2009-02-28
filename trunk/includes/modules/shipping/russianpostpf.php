<?php
/*
	Полный модуль доставки почтой России.
	Filename: modules/shipping/russianpostpf.php
	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	Написано Igel'ем.
	WWW:  http://igel.pp.ru/oscommerce/russianpost/
	MAIL: igel@weblight.us
	ICQ: 9006615
	06.11.2006.
	v.1.02 [24.11.2006]
	Modification: xtCommerce standart

   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------

*/

	class russianpostt{
		var $code, $title, $description, $enabled, $settings;


		function all_settings()
		{
			/* Запросим все настройки нашего модуля*/
            if(sizeof($this->settings) <= 1)
            {
				$sql = vam_db_query("SELECT configuration_key, configuration_value FROM " . TABLE_CONFIGURATION . "
				WHERE configuration_key LIKE '%\_RP\_%'");

				while($config_rows = vam_db_fetch_array($sql))
				{
	            	$crow[] = $config_rows['configuration_key'];
				}

				$this->settings = $crow;
			}
		}

		function is_wrapper($products)
		{
 			/* Узнаем посылка или бандероль */
 			$wrapper = 1;
      		foreach($products as $prod)
			{
				$signal_num = strpos($prod['model'], MODULE_SHIPPING_RP_WRAPPER_SEPARATOR);

				if ($signal_num === false)
				{
					$wrapper = 0;
					break;
				}

				$signal_table = constant('MODULE_SHIPPING_RP_WRAPPER_ISSET');
				$signals = split("[,]", $signal_table);
				if (!in_array(substr($prod['model'],0, $signal_num), $signals))
				{
					$wrapper = 0;
					break;
				}
			}
 			/*************/

 			return $wrapper;
		}

		function _install($module)
		{
			$this->all_settings();



			$zones = array(
				array(
						'Карелия республика,Ленинградская обл.,Новгородская обл.,Псковская обл.,Тверская обл.,Санкт-Петербург',
						'0.5:62,1:67,1.5:73,2:78,2.5:84,3:89,3.5:95,4:100,4.5:106,5:111,5.5:117,6:122,6.5:128,7:133,7.5:139,8:144,8.5:150,9:155,9.5:161,10:166',
						'0.5:20,1:39,1.5:58,2:77',
					 ),

				array(
						'Архангельская обл.,Белгородская обл.,Брянская обл.,Владимирская обл.,Волгоградская обл.,Вологодская обл.,Воронежская обл.,Ивановская обл.,Калининградская обл.,Калужская обл.,Кировская обл.,Коми,Костромская обл.,Самарская обл.,Курская обл.,Липецкая обл.,Марийская республика,Мордовская республика,Московская обл.,Мурманская обл.,Нижегородская обл.,Орловская обл.,Пензенская обл.,Пермская обл.,Ростовская обл.,Рязанская обл.,Саратовская обл.,Смоленская обл.,Тамбовская обл.,Татарстан,Тульская обл.,Удмурдская респ.,Ульяновская обл.,Чувашская респ.,Ярославская обл.,Москва',
						'0.5:65,1:71,1.5:77,2:83,2.5:89,3:95,3.5:101,4:107,4.5:112,5:118,5.5:124,6:130,6.5:136,7:142,7.5:148,8:154,8.5:160,9:166,9.5:171,10:177',
						'0.5:25,1:49,1.5:73,2:98',
					 ),
				array(
						'Адыгея,Алтайский край,Астраханская обл.,Башкортостан,Горный Алтай,Дагестан,Ингушетия,Кабардино-Балкария,Карачаево-Черкесская респ.,Кемеровская обл.,Краснодарский край,Красноярский край,Курганская обл.,Новосибирская обл.,Омская обл.,Оренбургская обл.,Свердловская обл.,Северная Осетия,Ставропольский край,Томская обл.,Тува,Тюменская обл.,Хакасия,Челябинская обл.,Чеченская республика',
						'0.5:78,1:85,1.5:93,2:100,2.5:107,3:115,3.5:122,4:130,4.5:137,5:144,5.5:152,6:159,6.5:167,7:174,7.5:181,8:189,8.5:196,9:204,9.5:211,10:218',
						'0.5:28,1:55,1.5:83,2:110',
					 ),
				array(
						'Бурятия,Иркутская обл.,Калмыкия,Читинская обл.',
						'0.5:104,1:113,1.5:123,2:132,2.5:142,3:151,3.5:161,4:170,4.5:180,5:189,5.5:199,6:208,6.5:217,7:227,7.5:236,8:246,8.5:255,9:265,9.5:274,10:284',
						'0.5:33,1:65,1.5:97,2:129',
					 ),
				array(
						'Амурская обл.,Еврейская авт.обл.,Камчатская обл.,Магаданская обл.,Приморский край,Сахалинская обл.,Хабаровский край,Чукотский АО,Якутия-Саха',
						'0.5:117,1:128,1.5:138,2:148,2.5:159,3:169,3.5:180,4:190,4.5:200,5:211,5.5:221,6:232,6.5:242,7:252,7.5:263,8:273,8.5:284,9:294,9.5:304,10:315',
						'0.5:36,1:71,1.5:106,2:142',
					 ),
			);

			$countries = array(
				array(
						'BY,EE,UZ',
						'0.1:28,0.25:44,0.5:71,1:112,2:150'
					 ),

				array(
						'*',
						'0.1:62,0.25:87,0.5:131,1:194,2:257'
					 ),
			);




			//таблица старого типа - туда не влезут все наши настроки
			//поэтому таблицу надо расширить (сделать тип поля TEXT)
			$sql = vam_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " LIMIT 1");
			$meta = vam_db_fetch_fields($sql);
			if($meta->blob == 0)
			{
				vam_db_query("ALTER TABLE `" . TABLE_CONFIGURATION . "` CHANGE `configuration_value` `configuration_value` TEXT NOT NULL");
				//нафига? vam_db_query("ALTER TABLE `" . TABLE_CONFIGURATION . "` CHANGE `configuration_title` `configuration_title` VARCHAR( 128 ) NOT NULL");
			}

			/*
			нафига?
			$sql = vam_db_query("SELECT configuration_description FROM " . TABLE_CONFIGURATION . " LIMIT 1");

			$meta = vam_db_fetch_fields($sql);
			if($meta->blob == 0)
			{
            	vam_db_query("ALTER TABLE `" . TABLE_CONFIGURATION . "` CHANGE `configuration_description` `configuration_description` TEXT NOT NULL");
			}
			*/



			/********** НАЛОЖКА **********
			*
			*
			******************************/
			if($module != 'prepay')
			{
				vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_RP_PARCEL_STATUS_PF', 'True', '6', '15', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
				vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ( 'MODULE_SHIPPING_RP_WRAPPER_STATUS_PF', 'True', '6', '18', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");

				vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_SORT_ORDER_PF', '9', '6', '24', now())");

				vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_RP_TAX_CLASS_PF', '0', '6', '21', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");

				//расходы магазина на наложку
		 		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_PARCEL_COST', '0', '6', '74', now())");
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_WRAPPER_COST', '0', '6', '77', now())");

			 	//ограничение регионов для наложки
				vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_PARCEL_LIMITATION_PF', '0', '6', '83', now())");
				vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_WRAPPER_LIMITATION_PF', '0', '6', '86', now())");

				// в какие страны можно посылать наложку
				vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTPF_ALLOWED', 'RU', '6', '86', now())");


			}


			/********* ПРЕДОПЛАТА *********
			*
			*
			******************************/
			if($module == 'prepay')
			{
				vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_RP_PARCEL_STATUS', 'True', '6', '3', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
				vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_RP_WRAPPER_STATUS', 'True',  '6', '6', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");

			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_SHIPPING_RP_TAX_CLASS', '0', '6', '21', 'vam_get_tax_class_title', 'vam_cfg_pull_down_tax_classes(', now())");

				vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_SORT_ORDER_PREPAY', '7', '6', '24', now())");

				//страны первого уровня - Беларусь, Узбекистан, Эстония
		   		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,
				configuration_group_id, sort_order, date_added) values (
				'MODULE_SHIPPING_RP_COUNTRY_1', '" . $countries[0][0]  ."', '6', '50', now())");

			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_COUNTRY_PRICE_1', '" . $countries[0][1]  ." ',  '6', '53', now())");

				//остальные страны
		   		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,
				configuration_group_id, sort_order, date_added) values (
				'MODULE_SHIPPING_RP_COUNTRY_2', '" . $countries[1][0]  ."', '6', '56', now())");
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ( 'MODULE_SHIPPING_RP_COUNTRY_PRICE_2', '" . $countries[1][1]  ." ',  '6', '59', now())");

				//оценочная сумма
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_PARCEL_INSURANCE_PRICE', '0',  '6', '68', now())");
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ( 'MODULE_SHIPPING_RP_WRAPPER_INSURANCE_PRICE', '0', '6', '71', now())");



		 		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_INTER_REG', '0', '6', '85', now())");

			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_INTER_MAXWEIGHT', '10',  '6', '65', now())");

				//бесплатная доставка
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_PARCEL_FREE', '0', '6', '86', now())");
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ( 'MODULE_SHIPPING_RP_WRAPPER_FREE', '0', '6', '89', now())");
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_INTER_FREE', '0', '6', '92', now())");

			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RUSSIANPOSTPREPAY_ALLOWED', '', '6', '86', now())");
			}


            //установка свежего модуля
			if(
			   !@in_array(MODULE_SHIPPING_RP_PARCEL_STATUS , $this->settings) &&
			   !@in_array(MODULE_SHIPPING_RP_WRAPPER_STATUS , $this->settings) &&
			   !@in_array(MODULE_SHIPPING_RP_PARCEL_STATUS_PF , $this->settings) &&
			   !@in_array(MODULE_SHIPPING_RP_WRAPPER_STATUS_PF , $this->settings)
			   )
			{

				//вычисление бандероли
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_WRAPPER_SEPARATOR', '-', '6', '9', now())");
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_WRAPPER_ISSET', 'bn,book', '6', '12', now())");


       	     //внутренние зоны
      	      $g = 0;
     	       for($i=1; $i<=5; $i++)
    	        {
  		          	$k = $i -1;
	   				vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value,configuration_group_id, sort_order,
	   				date_added) values (
					'MODULE_SHIPPING_RP_STATES_" . $i ."', '" . $zones[$k][0] . "', '6', '".(27+$g)."', now())");

			        vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_STATES_PRICE_PARCEL_" . $i ."', '" . $zones[$k][1]  ."', '6', '".(27+$g+1)."',  now())");
			        vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_STATES_PRICE_WRAPPER_" . $i ."', '" . $zones[$k][2]  ."', '6', '".(27+$g+2)."',  now())");
			        $g = $g+3;
	            }

		 		//страховые проценты
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_PARCEL_INSURANCE', '4', '6', '62', now())");
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_WRAPPER_INSURANCE', '3', '6', '65', now())");

			 	//максимальный вес
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_WRAPPER_MAXWEIGHT', '2', '6', '65', now())");
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_PARCEL_MAXWEIGHT', '10', '6', '65', now())");
			 	vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_RP_WRAPPERS_OR_PARCEL', 'True', '6', '6', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");


				//стоимость оформления почтового отправления
				vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_PARCEL_REG', '0','6', '80', now())");
		 		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_SHIPPING_RP_WRAPPER_REG', '0','6', '83', now())");

		 	}
	    }


		function _remove($module)
		{

            $this->all_settings();
			/********** НАЛОЖКА **********
			*
			*
			******************************/
			if($module != 'prepay' &&
			   !@in_array(MODULE_SHIPPING_RP_PARCEL_STATUS , $this->settings) &&
			   !@in_array(MODULE_SHIPPING_RP_WRAPPER_STATUS , $this->settings)
			   )
            		vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key IN ('" . implode("', '", $this->_keys('all')) . "')");




			/********* ПРЕДОПЛАТА *********
			*
			*
			******************************/
			if($module == 'prepay' &&
			   !@in_array(MODULE_SHIPPING_RP_PARCEL_STATUS_PF , $this->settings) &&
			   !@in_array(MODULE_SHIPPING_RP_WRAPPER_STATUS_PF , $this->settings)
			   )
            		vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key IN ('" . implode("', '", $this->_keys('all')) . "')");


			vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key IN ('" . implode("', '", $this->_keys($module)) . "')");
		}


		function _keys($module, $act='')
		{
			//обычная
			$Pkeys = array(
			0 => 'MODULE_SHIPPING_RP_PARCEL_STATUS',//вкл./выкл. ПОСЫЛКУ - 1
			3 => 'MODULE_SHIPPING_RP_WRAPPER_STATUS', //вкл./выкл. БАНДЕРОЛЬ - 1

			6 => 'MODULE_SHIPPING_RP_TAX_CLASS',//налог

			9 => 'MODULE_SHIPPING_RP_SORT_ORDER_PREPAY',//сортировка - 3

			45 => 'MODULE_SHIPPING_RP_COUNTRY_1',//коды стран "первого уровня" (Белоруссия, Узбекистан, Эстония)
			48 => 'MODULE_SHIPPING_RP_COUNTRY_2',//Коды остальных стран (* - любая страна) - *

			46 => 'MODULE_SHIPPING_RP_COUNTRY_PRICE_1',//цены для стран "первого уровня" (Белоруссия, Узбекистан, Эстония)
			49 => 'MODULE_SHIPPING_RP_COUNTRY_PRICE_2',//цены для остальных стран (* - любая страна) - *

			55 => 'MODULE_SHIPPING_RP_PARCEL_INSURANCE_PRICE',//оценочная стоимость: 0=стоимость заказа с доставкой;
			58 => 'MODULE_SHIPPING_RP_WRAPPER_INSURANCE_PRICE',//оценочная стоимость: 0=стоимость заказа с доставкой;

			73 => 'MODULE_SHIPPING_RP_INTER_REG',//цена за оформление международной посылки

			77 => 'MODULE_SHIPPING_RP_INTER_MAXWEIGHT',//максимальный вес международной посылки

			80 => 'MODULE_SHIPPING_RP_PARCEL_FREE',//сумма, при которой доставка ПОСЫЛКОЙ бесплатна - 0
			83 => 'MODULE_SHIPPING_RP_WRAPPER_FREE',//сумма, при которой доставка БАНДЕРОЛЬЮ бесплатна - 0
			87 => 'MODULE_SHIPPING_RP_INTER_FREE',//сумма, при которой международная доставка бесплатна

			95 => 'MODULE_SHIPPING_RUSSIANPOSTPREPAY_ALLOWED',//в какие страны разрешена доставка
			);

            //наложка
			$PFkeys = array(
			0 => 'MODULE_SHIPPING_RP_PARCEL_STATUS_PF',//вкл./выкл. наложку ПОСЫЛКИ - 1
			3 => 'MODULE_SHIPPING_RP_WRAPPER_STATUS_PF',//вкл./выкл. наложку БАНДЕРОЛИ - 1

			9 => 'MODULE_SHIPPING_RP_SORT_ORDER_PF',//сортировка - 3

			6 => 'MODULE_SHIPPING_RP_TAX_CLASS_PF',//налог

			80 => 'MODULE_SHIPPING_RP_PARCEL_COST',//процент или сумма за наложку (типа "расходы" магазина из-за "зависания денег") ПОСЫЛКИ - 0
			83 => 'MODULE_SHIPPING_RP_WRAPPER_COST',//процент или сумма за наложку (типа "расходы" магазина из-за "зависания денег") БАНДЕРОЛИ - 0

			86 => 'MODULE_SHIPPING_RP_PARCEL_LIMITATION_PF',//регионы, в которые нельзя отправлять ПОСЫЛКИ наложкой
			87 => 'MODULE_SHIPPING_RP_WRAPPER_LIMITATION_PF',//регионы, в которые нельзя отправлять БАНДЕРОЛИ наложкой

			95 => 'MODULE_SHIPPING_RUSSIANPOSTPF_ALLOWED',//в какие страны разрешена наложка
			);


			$ALLkeys = array(

			12 => 'MODULE_SHIPPING_RP_WRAPPER_SEPARATOR',//по какой строке искать бандероль - -
			15=> 'MODULE_SHIPPING_RP_WRAPPER_ISSET',//сигнальная часть модели (артикула) - band

			27 => 'MODULE_SHIPPING_RP_STATES_1',//Первая зона
			30 => 'MODULE_SHIPPING_RP_STATES_2',//Вторая зона
			34 => 'MODULE_SHIPPING_RP_STATES_3',//Третья зона
			37 => 'MODULE_SHIPPING_RP_STATES_4',//Четвертая зона
			40 => 'MODULE_SHIPPING_RP_STATES_5',//Пятая зона

			//стоимость бандероли
			28 => 'MODULE_SHIPPING_RP_STATES_PRICE_WRAPPER_1',//Первая цена
			31 => 'MODULE_SHIPPING_RP_STATES_PRICE_WRAPPER_2',//Вторая цена
			35 => 'MODULE_SHIPPING_RP_STATES_PRICE_WRAPPER_3',//Третья цена
			38 => 'MODULE_SHIPPING_RP_STATES_PRICE_WRAPPER_4',//Четвертая цена
			41 => 'MODULE_SHIPPING_RP_STATES_PRICE_WRAPPER_5',//Пятая цена

			//стоимость посылки
			29 => 'MODULE_SHIPPING_RP_STATES_PRICE_PARCEL_1',//Первая цена
			32 => 'MODULE_SHIPPING_RP_STATES_PRICE_PARCEL_2',//Вторая цена
			36 => 'MODULE_SHIPPING_RP_STATES_PRICE_PARCEL_3',//Третья цена
			39 => 'MODULE_SHIPPING_RP_STATES_PRICE_PARCEL_4',//Четвертая цена
			42 => 'MODULE_SHIPPING_RP_STATES_PRICE_PARCEL_5',//Пятая цена

			61 => 'MODULE_SHIPPING_RP_PARCEL_INSURANCE',//страховой процент взимаемый почтой за ПОСЫЛКУ - 3
			64 => 'MODULE_SHIPPING_RP_WRAPPER_INSURANCE',//страховой процент взимаемый почтой за БАНДЕРОЛЬ - 3

			67 => 'MODULE_SHIPPING_RP_PARCEL_REG',//цена за оформление ПОСЫЛКИ
			70 => 'MODULE_SHIPPING_RP_WRAPPER_REG',//цена за оформление БАНДЕРОЛИ

			75 => 'MODULE_SHIPPING_RP_WRAPPER_MAXWEIGHT',//макисмальный вес бандероли
			76 => 'MODULE_SHIPPING_RP_PARCEL_MAXWEIGHT',//макисмальный вес бандероли


			78 => 'MODULE_SHIPPING_RP_WRAPPERS_OR_PARCEL',//при перевесе использовать разбивку на несколько бандеролей или переходить в посылки
			);

			//наложка
			if($module!='prepay')$key = $PFkeys;

			//предоплата
			if($module=='prepay')$key = $Pkeys;

			//общее
			if($module=='all')$key = $ALLkeys;


			if($act == 'all')
			{
				//$key = array_merge($key , $ALLkeys);
				foreach($ALLkeys as $k=>$v)
				{
					$key[$k] = $v;
				}
			}

			ksort($key);
			foreach($key as $k=>$v)
			{
				$key2[] = $v;
			}

			return $key2;
		}

		//функция обработки числительных
		function om_number($number, $titles)
		{
		        $cases = array (2, 0, 1, 1, 1, 2);
		    return $number." ".$titles[ ($number%100>4 && $number%100<20)? 2 : $cases[min($number%10, 5)] ];
		}


		//стоимость доаставки
		//$cost_table - array('цена', 'вес','цена', 'вес');
		//$weight - вес
		//$need_parcel - необходимое кол-во посылок
		//$maxweight - максимальный вес посылки
		//$reg - стоимость сбора одной посылки
		function price($cost_table, $weight, $need_parcel, $maxweight, $reg)
		{
			//максимальный вес первой посылки
			$shipping = 0;
			if($need_parcel > 1)
			{
				$first = $maxweight;
	      		for ($i=0; $i<sizeof($cost_table); $i+=2)
	        	{
	         		if ($first <= $cost_table[$i])
	          		{
	         		 	$shipping = $cost_table[$i+1]+$reg;
	     		        break;
					}
				}

				$shipping = $shipping*($need_parcel-1);

				$final = $weight-($maxweight*($need_parcel-1));

			}
			else $final = $weight;

	  		for ($i=0; $i<sizeof($cost_table); $i+=2)
	    	{
	     		if ($final <= $cost_table[$i])
	       		{
	         		$shipping = $shipping + $cost_table[$i+1]+$reg;
	     		    break;
				}
			}

			return $shipping;
		}


		//подсчитываем сумму, которую придётся отдать почте за
		//оценочную стоимость.
		//$price - сумма
		//4rate - процент
		function insurance($price, $rate)
		{
			if($rate==0)return 0;

			$x = 100-$rate;
            $y = ($price/$x)*100;
			return $y-$price;
		}

	}


	class russianpostpf extends  russianpostt{
		var $code, $title, $description, $enabled;

		function russianpostpf()
		{
		      $this->code = 'russianpostpf';
		      $this->title = MODULE_SHIPPING_RP_TEXT_TITLE_PF;
		      $this->description = MODULE_SHIPPING_RP_TEXT_DESCRIPTION_PF;
		      $this->sort_order = MODULE_SHIPPING_RP_SORT_ORDER_PF;
		      $this->icon = '';
		      $this->tax_class = MODULE_SHIPPING_RP_TAX_CLASS_PF;
		      $this->enabled = ((MODULE_SHIPPING_RP_PARCEL_STATUS_PF == 'True' || MODULE_SHIPPING_RP_WRAPPER_STATUS_PF == 'True') ? true : false);


		}


		function check()
		{
			if (!isset($this->_check))
			{
				$check_query = vam_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_SHIPPING_RP_PARCEL_STATUS_PF' || configuration_key = 'MODULE_SHIPPING_RP_WRAPPER_STATUS_PF' LIMIT 1");
				$this->_check = vam_db_num_rows($check_query);
			}
			return $this->_check;
		}



		// class methods
    	function quote($method = '')
    	{
			global $order, $shipping_weight, $vamPrice;

   			$home = false;

			$dest_country = $order->delivery['country']['iso_code_2'];
			$dest_province = $order->delivery['state'];
			$dest_zone_id;

			$dest_zone = 0;
			$error = false;
			$err_msg;

			//Если страна Россия, то цену смотрим по региону
			//"домашняя" страна.
			if($dest_country == "RU")
			{
				$dest_zone_id = $dest_province;
				$home = true;
			}

			//Наложка идёт только по России
			else
			{
				$error = true;
				$err_msg = MODULE_SHIPPING_RP_INVALID_ZONE_PF;
			}



			//смотрим нужный регион
			for ($i=1; $i<=5; $i++)
			{
				$zones_table = constant('MODULE_SHIPPING_RP_STATES_' . $i);
				$zones = split("[,]", $zones_table);
				if (in_array($dest_zone_id, $zones))
				{
					$dest_zone = $i;
					break;
				}
			}


			//узнаем посылка или бандероль
			//вес заказа меньше максимального для бандероли
			$need_wr = (MODULE_SHIPPING_RP_WRAPPER_MAXWEIGHT < $shipping_weight) ? ((MODULE_SHIPPING_RP_WRAPPERS_OR_PARCEL == 'True') ? 1 : 0) : 1;
			//$wrapper = 0 - посылка
			//$wrapper = 1 - бандероль
#####			$wrapper = (MODULE_SHIPPING_RP_WRAPPER_STATUS_PF == 'True' && $need_wr) ? $this->is_wrapper($order->products)  : 0;
			$wrapper = (MODULE_SHIPPING_RP_WRAPPER_STATUS_PF == 'True' && $need_wr) ? $this->is_wrapper($_SESSION['cart']->get_products())  : 0;

			if($wrapper == 0 && MODULE_SHIPPING_RP_PARCEL_STATUS_PF != 'True')return false;

			$mode = ($wrapper == 1) ? 'WRAPPER' : 'PARCEL';


			//смотрим запрещённые регионы
			$zones_table = constant('MODULE_SHIPPING_RP_'.$mode.'_LIMITATION_PF');
			$zones = split("[,]", $zones_table);
			if (in_array($dest_zone_id, $zones))
			{
				return false;
				/*
					$error = true;
          			$err_msg = MODULE_SHIPPING_RP_UNDEFINED_RATE_PF;
     			*/
			}


			//высчитываем на сколько посылок/бандеролей нужно разбить заказ
			$need_parcel = 1;
			$maxweight = constant('MODULE_SHIPPING_RP_'.$mode.'_MAXWEIGHT');
			if($shipping_weight > $maxweight)
			{
				$need_parcel = ceil($shipping_weight/$maxweight);
			}


      		if ($dest_zone == 0)
	      	{
				$error = true;
				$err_msg = MODULE_SHIPPING_RP_INVALID_ZONE_PF;
			}

			else
			{
				$zones_cost = constant('MODULE_SHIPPING_RP_STATES_PRICE_'.$mode.'_' . $dest_zone);

				$cost_table = split("[:,]" , $zones_cost);

				$shipping = $this->price($cost_table, $shipping_weight, $need_parcel, $maxweight, constant('MODULE_SHIPPING_RP_'.$mode.'_REG'));

	   			$shipping_method = constant('MODULE_SHIPPING_RP_TEXT_WAY_'.$mode.'_PF').' <nobr>('.$order->delivery['state'].
	       		     							' - '.$shipping_weight.' '.MODULE_SHIPPING_RP_TEXT_UNITS_PF.'</nobr> <nobr>['.
	       		     							constant('MODULE_SHIPPING_RP_'.$mode.'_NEED_PF').
	       		     							$this->om_number($need_parcel, array(constant('MODULE_SHIPPING_RP_'.$mode.'_1_PF'),
	       		     																constant('MODULE_SHIPPING_RP_'.$mode.'_2_PF'),
	       		     																constant('MODULE_SHIPPING_RP_'.$mode.'_5_PF')
	       		     																)).
	       		     							']</nobr>)';

                if($shipping == 0)$shipping = -1;


				if ($shipping == -1)
				{
					$error = true;
          			$err_msg = MODULE_SHIPPING_RP_UNDEFINED_RATE_PF;
        		}

        		else
        		{

          			/**** Формула подсчёта цены ****/

	          		/*-- "Риски" магазина --*/



             		//РИСКИ МАГАЗИНА
             		$burden = 0;
					$burden_data = constant('MODULE_SHIPPING_RP_'.$mode.'_COST');

					if(!empty($burden_data) || $burden_data > 0)
					{

	            		$burden = (strpos($burden_data, '%') === false ) ?
	                    				$burden_data :
	                    				substr($burden_data, 0, strpos($burden_data, '%'));

	            		$burden_proc = (strpos($burden_data, '%') === false) ? false : true;

                    	//узнаем откуда высчитывать страховку
                    	$burden_method = 0;
                     	if($burden_proc)
                     	{
                     		$bm = substr($burden_data,0,1);
                     		if($bm == 'p' || $bm == 'P' || $bm == 'р' || $bm == 'Р')$burden_method = 'products';
                     		else if($bm == 'd' || $bm == 'D')$burden_method = 'delivery';
                     		else {$burden_method = 'all';}

###                     		$burden = substr(substr($burden_data, 0, strpos($burden_data, '%')), ((intval($bm) > 0)?0:1), strlen($burden_data)-1);
                     		$burden = substr(substr($burden_data, 0, strpos($burden_data, '%')), (($bm == '')?0:1), strlen($burden_data)-1);
                     	}

					}

					if($burden_method == 'delivery' && $burden_proc)
						$delivery = $shipping+(($shipping/100)*$burden);

					elseif($burden_method == 'products' && $burden_proc)
						$delivery = $shipping+(($vamPrice->RemoveCurr($_SESSION['cart']->show_total())/100)*$burden);

					elseif($burden_method == 'all'  && $burden_proc)
                         $delivery = $shipping+
                         			((($shipping+$_SESSION['cart']->show_total())/100)*$burden);

					else $delivery = $shipping;

					//прибавим страховую сумму магазина (НЕ процент)
					if(!$burden_proc)$delivery+= $burden;

					//доставка + сумма заказа
					$appraisal_price = $delivery + $_SESSION['cart']->show_total();

					//высчитываем страховую стоимость
					$insurance_price = $this->insurance($appraisal_price, intval(constant('MODULE_SHIPPING_RP_'.$mode.'_INSURANCE')));

	   	    		//итоговая стоимость доставки = доставка + плата за сбор посылки + страховой процент
					$shipping_cost = $delivery + $insurance_price;
        		}
      }


      $this->quotes = array('id' => $this->code,
                            'module' => MODULE_SHIPPING_RP_TEXT_TITLE_PF,
                            'methods' => array(
                            					array('id' => $this->code,
                                                     'title' => $shipping_method,
                                                     'cost' => ceil($shipping_cost)
                                                     )
                                         	)

                            );




      if ($this->tax_class > 0) {
        $this->quotes['tax'] = vam_get_tax_rate($this->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
      }

      if (vam_not_null($this->icon)) $this->quotes['icon'] = vam_image($this->icon, $this->title);

      if ($error == true) $this->quotes['error'] = $err_msg;

      return $this->quotes;
    }


    function install()
    {
    	$this->_install('pf');
    }

    function remove()
    {
    	$this->_remove('pf');
    }


    function keys()
    {
    	return $this->_keys('pf', 'all');
    }
  }
?>
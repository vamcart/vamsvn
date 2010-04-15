<?php
/* -----------------------------------------------------------------------------------------
   $Id: smscoin.php 2008-08-02 etles.ru $

   http://etles.ru

   Copyright (c) 2007 etles.ru
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cod.php,v 1.28 2003/02/14); www.oscommerce.com
   (c) 2003	 nextcommerce (cod.php,v 1.7 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (cod.php,v 1.7 2003/08/23); xt-commerce.com
   (c) 2007-04-29 21:07:20 VaM Shop (smscoin.php); http://vamshop.ru (http://vamshop.com)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  function ref_sign()
  {
  $params = func_get_args();
  $prehash = implode("::", $params);
  return md5($prehash);
  }

  class smscoin
  {
  var $code, $title, $description, $enabled;

  function smscoin() {
  global $order;

  $this->code = 'smscoin';
  $this->title = MODULE_PAYMENT_SMSCOIN_TEXT_TITLE;
  $this->description = MODULE_PAYMENT_SMSCOIN_TEXT_DESCRIPTION;
  $this->sort_order = MODULE_PAYMENT_SMSCOIN_SORT_ORDER;
  $this->enabled = ((MODULE_PAYMENT_SMSCOIN_STATUS == 'True') ? true : false);

  if ((int)MODULE_PAYMENT_SMSCOIN_ORDER_STATUS_ID > 0)
  {
  $this->order_status = MODULE_PAYMENT_SMSCOIN_ORDER_STATUS_ID;
  }

  if (is_object($order)) $this->update_status();

  $this->form_action_url = MODULE_PAYMENT_SMSCOIN_HTTP_ADDR;
  }

  function update_status()
  {
  global $order;

    if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_SMSCOIN_ZONE > 0) )
    {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_SMSCOIN_ZONE . "' and zone_country_id = '" . $order->billing['country']['id'] . "' order by zone_id");

        while ($check = vam_db_fetch_array($check_query))
        {
          if ($check['zone_id'] < 1)
          {
            $check_flag = true;
            break;
          }
          elseif ($check['zone_id'] == $order->billing['zone_id'])
          {
            $check_flag = true;
            break;
          }
        }

        if ($check_flag == false)
        {
          $this->enabled = false;
    	}
    }
  }

  function javascript_validation()
  {
  return false;
  }

  function selection()
  {
  return array('id'     => $this->code,
               'module' => $this->title);
  }

  function pre_confirmation_check()
  {
  return false;
  }

  function confirmation()
  {
  global $_POST;
  return array('title' => MODULE_PAYMENT_SMSCOIN_TEXT_DESCRIPTION);
  }

  function process_button()
  {
  global $order, $vamPrice;

  $products = '';
  foreach($order->products as $key => $product) {
      $products .= $product['name'];
          if (@$product['attributes'] !='') {
             foreach($product['attributes'] as $key => $attribut)
             {
               $products .= ' (' . $attribut['option'].': ' . $attribut['value'] . ')';
             }
          }
  }

  $order_query = vam_db_query("select MAX(orders_id) AS orders_id FROM " . TABLE_ORDERS_TOTAL);
  $order_id = vam_db_fetch_array($order_query);

  $currency = $_SESSION['currency'];
  $num = $order_id['orders_id'] + 1;
  $amount = round($vamPrice->CalculateCurrEx($order->info['total'] ,$currency), $vamPrice->get_decimal_places($currency));
  $clear_amount = '0';

  $crc = ref_sign(MODULE_PAYMENT_SMSCOIN_ID,$num,$amount,$clear_amount,$products,MODULE_PAYMENT_SMSCOIN_SECRET_KEY);

  $process_button_string = vam_draw_hidden_field('s_purse', MODULE_PAYMENT_SMSCOIN_ID) .
						   vam_draw_hidden_field('s_order_id', $num) .
						   vam_draw_hidden_field('s_amount', $amount) .
						   vam_draw_hidden_field('s_clear_amount', $clear_amount) .
						   vam_draw_hidden_field('s_description', $products) .
						   vam_draw_hidden_field('s_sign', $crc);

  return $process_button_string;
  }

  function before_process() {
  global $_POST;

  $purse        = $_POST["s_purse"];        // sms:bank id        идентификатор смс:банка
  $order_id     = $_POST["s_order_id"];     // operation id       идентификатор операции
  $amount       = $_POST["s_amount"];       // transaction sum    сумма транзакции
  $clear_amount = $_POST["s_clear_amount"]; // billing algorithm  алгоритм подсчета стоимости
  $s_status     = $_POST["s_status"];       // Статус платежа: 1 - прошел, 0 - не прошел.
  $s_sign       = $_POST["s_sign"];         // MD5-хэш строки, состоящей из соединенных через двойное
    									    // двоеточие ("::") параметров secret_code, s_purse, s_order_id,
    										// s_amount, s_clear_amount и s_status (в указанном порядке),
    										// где secret_code - секретный ключ Вашего смс:банка.

  // если проверка платежа неудачна - вернуться к выбору оплаты
  if ($s_sign != ref_sign(MODULE_PAYMENT_SMSCOIN_SECRET_KEY,$purse,$order_id,$amount,$clear_amount,$s_status))
  {vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . MODULE_PAYMENT_SMSCOIN_TEXT_ERROR_MESSAGE, 'SSL', true, false));}

  // проверка платежа удачна
  return false;
  }

  function after_process()
  {
  global $insert_id;
  if ($this->order_status) vam_db_query("UPDATE ". TABLE_ORDERS ." SET orders_status='".$this->order_status."' WHERE orders_id='".$insert_id."'");
  }

  function get_error()
  {
  return false;
  }

  function check()
  {
  if (!isset($this->_check))
  {
  	$check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_SMSCOIN_STATUS'");
    $this->_check = vam_db_num_rows($check_query);
  }
  return $this->_check;
  }

  // метод для инсталляции модуля оплаты в систему
  function install()
  {
  // включен или выключен данный модуль оплаты
  vam_db_query("insert into " . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_SMSCOIN_STATUS', 'True', '6', '0', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now());");

  // разрешённые страны, для которых будет доступен данный модуль оплаты
  vam_db_query("insert into " . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SMSCOIN_ALLOWED', '', '6', '1', now())");

  // идентификатор вашего смс:банка в системе
  vam_db_query("insert into " . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SMSCOIN_ID', '', '6', '2', now());");

  // секретный ключ вашего смс:банка
  vam_db_query("insert into " . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SMSCOIN_SECRET_KEY', '', '6', '3', now());");

  // зоны оплаты; данный модуль оплаты доступен только для выбранной зоны
  vam_db_query("insert into " . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_SMSCOIN_ZONE', '0',  '6', '4', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");

  // cтатус заказа, который будет установлен после оплаты
  vam_db_query("insert into " . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_SMSCOIN_ORDER_STATUS_ID', '0', '6', '5', 'vam_cfg_pull_down_order_statuses(', 'vam_get_order_status_name', now())");

  // порядок сортировки модуля оплаты (под каким номером в списке модулей оплаты будет доступен данный модуль)
  vam_db_query("insert into " . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SMSCOIN_SORT_ORDER', '0', '6', '6', now())");

  // порядок сортировки модуля оплаты (под каким номером в списке модулей оплаты будет доступен данный модуль)
  vam_db_query("insert into " . TABLE_CONFIGURATION . " ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SMSCOIN_HTTP_ADDR', 'http://XXXX.bank.smscoin.com/bank/', '6', '7', now())");


  }

  function remove()
  {
  vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
  }

  function keys()
  {
  return array('MODULE_PAYMENT_SMSCOIN_STATUS','MODULE_PAYMENT_SMSCOIN_ALLOWED', 'MODULE_PAYMENT_SMSCOIN_ZONE', 'MODULE_PAYMENT_SMSCOIN_ORDER_STATUS_ID', 'MODULE_PAYMENT_SMSCOIN_SORT_ORDER', 'MODULE_PAYMENT_SMSCOIN_ID', 'MODULE_PAYMENT_SMSCOIN_SECRET_KEY', 'MODULE_PAYMENT_SMSCOIN_HTTP_ADDR');
  }

  }
?>
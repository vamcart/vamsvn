<?php
/*
*/
class estonia_swed {
    var $code, $title, $description, $enabled;
	var $order_status;
	var $orderStatus;
	var $vk_version;
	var $vk_dest;
	var $vk_return;
	var $vk_snd_id;
	var $vk_bank_id;
	var $vk_acc;
	var $vk_name;
	var $vk_privkey;
	var $vk_pass;
	var $vk_pubkey;

	
	var $configRead = false;

// class constructor
    function estonia_swed() {
      global $order;
      $this->readConfig();


      if (is_object($order)) $this->update_status();

    }
    
	function readConfig() {
//		$this->d(vam_db_fetch_array(vam_db_query('select * from '.TABLE_CONFIGURATION)));
		if ($this->configRead) return;
		$this->signature = 'estonia_swed_008';
		$this->code = 'estonia_swed';
		$this->title = MODULE_PAYMENT_ESTONIA_SWED_TEXT_TITLE;
		$this->public_title = MODULE_PAYMENT_ESTONIA_SWED_TEXT_PUBLIC_TITLE;
		$this->description = MODULE_PAYMENT_ESTONIA_SWED_TEXT_DESCRIPTION;
		$this->sort_order = MODULE_PAYMENT_ESTONIA_SWED_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_ESTONIA_SWED_STATUS == 'True') ? true : false);
		if ((int)MODULE_PAYMENT_ESTONIA_SWED_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_ESTONIA_SWED_ORDER_STATUS_ID;
		}
		if ((int)MODULE_PAYMENT_ESTONIA_SWED_ORDER_STATUS > 0) {
			$this->orderStatus = MODULE_PAYMENT_ESTONIA_SWED_ORDER_STATUS;
		}
		$this->vk_version = MODULE_PAYMENT_ESTONIA_SWED_VK_VERSION;
		$this->vk_dest = MODULE_PAYMENT_ESTONIA_SWED_VK_DEST;
		$this->vk_return = MODULE_PAYMENT_ESTONIA_SWED_VK_RETURN;
		$this->vk_snd_id = MODULE_PAYMENT_ESTONIA_SWED_VK_SND_ID;
		$this->vk_bank_id = MODULE_PAYMENT_ESTONIA_SWED_VK_BANK_ID;
		$this->vk_privkey = MODULE_PAYMENT_ESTONIA_SWED_VK_PRIVKEY;
		$this->vk_pass = MODULE_PAYMENT_ESTONIA_SWED_VK_PASS;
		$this->vk_pubkey = MODULE_PAYMENT_ESTONIA_SWED_VK_PUBKEY;
		$this->configRead = true;
		return;
	}
    
    
    function update_status() {
      global $order;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_ESTONIA_SWED_ZONE > 0) ) {
        $check_flag = false;
        $check_query = vam_db_query("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . MODULE_PAYMENT_ESTONIA_SWED_ZONE . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
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

    function javascript_validation() {
      return false;
    }

    function selection() {
      return array('id' => $this->code,
                   'module' => $this->public_title);
    }

    function pre_confirmation_check() {
      return false;
    }
    function confirmation() {
      global $order;


      


      $confirmation = array('fields' => array(array('title' => 'global field title',
                                                    'field' => 
                                                    vam_draw_hidden_field('field_name', 'field value')
                                                    ),
                                                    ));

      return array('fields' => array());
    }

    function process_button() {
      return false;
    }

    function before_process() {
    	return false;
      
//          vam_redirect(vam_href_link(FILENAME_SHOPPING_CART, 'error_message=' . stripslashes($response_array['L_LONGMESSAGE0']), 'SSL'));
//        vam_redirect(vam_href_link(FILENAME_CHECKOUT_CONFIRMATION, 'error_message=' . MODULE_PAYMENT_PAYPAL_DIRECT_ERROR_ALL_FIELDS_REQUIRED, 'SSL'));
    }

    function after_process() {
      global $HTTP_POST_VARS, $order, $sendto, $insert_id;
      $result = $this->startPayment(($order->info['total_value']), $insert_id ,$order->info['currency']);
    	foreach ($result['params'] as $k => $v) {
    		$r .= "&".$k."=".urlencode($v);
    	}
    	$redirectUrl = $result['destination']."?".substr($r, 1);
    	header("Location: ".$redirectUrl);
    	exit();
/*
after success make this action:
  $cart->reset(true);

// unregister session variables used during checkout
  vam_session_unregister('sendto');
  vam_session_unregister('billto');
  vam_session_unregister('shipping');
  vam_session_unregister('payment');
  vam_session_unregister('comments');

  vam_redirect(vam_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL'));


*/
      return false;
    }

    function get_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $check_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_ESTONIA_SWED_STATUS'");
        $this->_check = vam_db_num_rows($check_query);
      }
      return $this->_check;
    }

    function install() {
//      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable PayPal Direct', 'MODULE_PAYMENT_PAYPAL_DIRECT_STATUS', 'False', 'Do you want to accept PayPal Direct payments?', '6', '1', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");
		

//      vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_IK_STATUS', 'True', '6', '1', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");

		vam_db_query("ALTER TABLE " . TABLE_CONFIGURATION . " CHANGE configuration_value configuration_value TEXT");

		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_STATUS', 'True', '6', '1', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now())");

		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_ALLOWED', '', '6', '0', now())");
		      
		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_VK_VERSION', '', '6', '0', now())");
		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_VK_DEST', '', '6', '0', now())");
		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_VK_RETURN', '', '6', '0', now())");
		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_VK_SND_ID', '', '6', '0', now())");
		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_VK_BANK_ID', '', '6', '0', now())");
		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_VK_PRIVKEY', '', '6', '0', 'vam_draw_textarea_field(\'configuration[MODULE_PAYMENT_ESTONIA_SWED_VK_PRIVKEY]\', false, 35, 5,', now());");

		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_VK_PASS', '', '6', '0', now())");

		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_VK_PUBKEY', '', '6', '0', 'vam_draw_textarea_field(\'configuration[MODULE_PAYMENT_ESTONIA_SWED_VK_PUBKEY]\', false, 35, 5,', now());");
      
		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_ZONE', '0', '6', '2', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_SORT_ORDER', '0', '6', '0', now())");
		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_ORDER_STATUS_ID', '0', '6', '0', 'vam_cfg_pull_down_order_statuses(', 'vam_get_order_status_name', now())");
		vam_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_ESTONIA_SWED_ORDER_STATUS', '0', '6', '0', 'vam_cfg_pull_down_order_statuses(', 'vam_get_order_status_name', now())");
   }

    function remove() {
      vam_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array(
      	'MODULE_PAYMENT_ESTONIA_SWED_STATUS',
      	'MODULE_PAYMENT_ESTONIA_SWED_ALLOWED',
      	'MODULE_PAYMENT_ESTONIA_SWED_VK_VERSION',
      	'MODULE_PAYMENT_ESTONIA_SWED_VK_DEST',
      	'MODULE_PAYMENT_ESTONIA_SWED_VK_RETURN',
      	'MODULE_PAYMENT_ESTONIA_SWED_VK_SND_ID',
      	'MODULE_PAYMENT_ESTONIA_SWED_VK_BANK_ID',
      	'MODULE_PAYMENT_ESTONIA_SWED_VK_PRIVKEY',
      	'MODULE_PAYMENT_ESTONIA_SWED_VK_PASS',
      	'MODULE_PAYMENT_ESTONIA_SWED_VK_PUBKEY',
      	'MODULE_PAYMENT_ESTONIA_SWED_ORDER_STATUS_ID',
      	'MODULE_PAYMENT_ESTONIA_SWED_ORDER_STATUS',
      	'MODULE_PAYMENT_ESTONIA_SWED_ZONE',
      	'MODULE_PAYMENT_ESTONIA_SWED_SORT_ORDER',
		);
    }


// format prices without currency formatting
    function format_raw($number, $currency_code = '', $currency_value = '') {
      global $currencies, $currency;

      if (empty($currency_code) || !$this->is_set($currency_code)) {
        $currency_code = $currency;
      }

      if (empty($currency_value) || !is_numeric($currency_value)) {
        $currency_value = $currencies->currencies[$currency_code]['value'];
      }

      return number_format(
      	round(
      		$number * $currency_value
      		, $currencies->currencies[$currency_code]['decimal_places'])
      		, $currencies->currencies[$currency_code]['decimal_places']
      		, '.', '');
    }
    
	/**
	 Return array('destination' => 'destination url',
	 'params' => array of params
	 )
	 so that it would be possible to construct the payment form
	 */
	function startPayment($totalSum, $orderNr, $currency) {
		$this->readConfig();
		$return = '';
		if ($this->vk_return == '') {
			$return = vam_href_link("validateSwedPayment.php"); 
		} else {
			$return = vam_href_link($this->vk_return); 
		}
		$macFields = Array(
                        'VK_SERVICE'    => '1002',
                        'VK_VERSION'    => $this->vk_version,
                        'VK_SND_ID'     => $this->vk_snd_id,
                        'VK_STAMP'      => $orderNr,
                        'VK_CURR'      => $currency,
                        'VK_AMOUNT'     => round($totalSum, 2),
                        'VK_REF'        => $this->generateRefNum($orderNr),
                        'VK_MSG'        => 'Tellimuse nr. '.$orderNr.' tasu',
                        'VK_RETURN'     => $return,
		);

		/**
		 * Genereerime tehingu väärtustest signatuuri
		 */
		$key = openssl_pkey_get_private ($this->vk_privkey, $this->vk_pass);
		$signature = "";
		$macString = $this->generateMACString($macFields);

		if (!openssl_sign ($macString, $signature, $key)) {
			die ("Unable to generate signature");
		}

		$macFields['VK_MAC'] = base64_encode ($signature);
		return array('destination' => $this->vk_dest, 'params' => $macFields, 'method' => 'post', 'description' => $this->public_title);
	}

	function validatePayment($params) {
		$this->readConfig();
		$orderId = $params['VK_STAMP'];
		$result = array('orderNr' => $orderId, 'payment' => 'failed', 'auto' => false);


		$vk_bank_id = $params['VK_SND_ID'];
		if ($vk_bank_id != $this->vk_bank_id) {
			return $result;
		}
		$vk_service = $params['VK_SERVICE'];
		$macFields = Array ();

		foreach ((array)$params as $f => $v) {
			if (substr ($f, 0, 3) == 'VK_') {
				$macFields[$f] = $v;
			}
		}

		/**
		 * Kontrollime väärtusi, mis pangast tulid.
		 * Selleks arvutame nende väärtuste põhjal signatuuri ning
		 * võrdleme seda selle signatuuriga, mis pank koos väärtustega meile saatis.
		 */
		$key = openssl_pkey_get_public($this->vk_pubkey);

		if (!openssl_verify ($this->generateMACString($macFields), base64_decode($macFields['VK_MAC']), $key)) {
			//invalid signature here
			return $result;
		} else {
			//if signature correct then
			if ($vk_service == '1101') {
				//if payd, update order
				$result['payment'] = 'success';
				$result['status'] = $this->orderStatus;
				if ($params['VK_AUTO'] == 'Y') {
					$result['auto'] = true;
				}
			} else if ($vk_service == '1901') {
				//if not payd leave order intact
				if ($params['VK_AUTO'] == 'Y') {
					$result['auto'] = true;
				}
				$result['payment'] = 'cancelled';
				$result['status'] = null;
			}
			return $result;
		}
	}

	/**
	 * Genereerib sisseantud massiivi väärtustest jada.
	 * Jadasse lisatakse iga väärtuse pikkus (kolmekohalise arvuna)
	 * ning selle järel väärtus ise.
	 */
	function generateMACString($macFields) {
		$VK_variableOrder = Array(
			1001 => Array(
				'VK_SERVICE','VK_VERSION','VK_SND_ID',
				'VK_STAMP','VK_AMOUNT','VK_CURR',
				'VK_ACC','VK_NAME','VK_REF','VK_MSG'
			),
			1002 => Array(
				'VK_SERVICE','VK_VERSION','VK_SND_ID',
				'VK_STAMP','VK_AMOUNT','VK_CURR',
				'VK_REF','VK_MSG'
			),

			1101 => Array(
				'VK_SERVICE','VK_VERSION','VK_SND_ID',
				'VK_REC_ID','VK_STAMP','VK_T_NO','VK_AMOUNT','VK_CURR',
				'VK_REC_ACC','VK_REC_NAME','VK_SND_ACC','VK_SND_NAME',
				'VK_REF','VK_MSG','VK_T_DATE'
			),
			1901 => Array(
				'VK_SERVICE','VK_VERSION','VK_SND_ID',
				'VK_REC_ID','VK_STAMP','VK_REF','VK_MSG'
			),
		);

		$requestNum = $macFields['VK_SERVICE'];

		$data = '';

		foreach ((array)$VK_variableOrder[$requestNum] as $kaey) {
			$v = $macFields[$kaey];
			$data .= str_pad (strlen ($v), 3, '0', STR_PAD_LEFT) . $v;
		}
		return $data;
	}
	
	function generateRefNum($stamp) {
		$chcs = array(7, 3, 1);
		$sum = 0;
		$pos = 0;
		for ($i = 0; $i < strlen($stamp); $i++) {
			$x = (int)(substr($stamp,strlen($stamp) - 1 - $i, 1));
			$sum = $sum + ($x * $chcs[$pos]);
			if ($pos == 2) {
				$pos = 0;
			} else {
				$pos = $pos + 1;
			}
		}
		$x = 10 - ($sum % 10);
		if ($x != 10) {
			$sum = $x;
		} else {
			$sum = 0;
		}
		return $stamp . $sum;
	}
    
	/**
	debug function, html formatted
	*/
	function d($var, $echo = true) {
		$r = '<pre>';
		$r .= htmlspecialchars(print_r($var, true));
		$r .= '</pre>';
		if ($echo) {
			 echo $r;
		}
		return $r;
	}

}
?>
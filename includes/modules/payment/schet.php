<?php
/* -----------------------------------------------------------------------------------------
   $Id: schet.php 998 2007-02-06 21:07:20 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ptebanktransfer.php,v 1.4.1 2003/09/25 19:57:14); www.oscommerce.com
   (c) 2004	 xt:Commerce (eustandardtransfer.php,v 1.7 2003/08/23); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class schet {
	var $code, $title, $description, $enabled;

	// class constructor
	function __construct() {
		$this->code = 'schet';
		$this->title = MODULE_PAYMENT_SCHET_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_SCHET_TEXT_DESCRIPTION;
		$this->icon = DIR_WS_ICONS . 'schet.png';
		$this->sort_order = MODULE_PAYMENT_SCHET_SORT_ORDER;
		$this->info = MODULE_PAYMENT_SCHET_TEXT_INFO;
		$this->enabled = ((MODULE_PAYMENT_SCHET_STATUS == 'True') ? true : false);

		if ((int) MODULE_PAYMENT_SCHET_ORDER_STATUS_ID > 0) {
			$this->order_status = MODULE_PAYMENT_SCHET_ORDER_STATUS_ID;
		}

	}
	
	function update_status() {
		global $order;

		if (($this->enabled == true) && ((int) MODULE_PAYMENT_SCHET_ZONE > 0)) {
			$check_flag = false;
			$check_query = vam_db_query("select zone_id from ".TABLE_ZONES_TO_GEO_ZONES." where geo_zone_id = '".MODULE_PAYMENT_SCHET_ZONE."' and zone_country_id = '".$order->billing['country']['id']."' order by zone_id");
			while ($check = vam_db_fetch_array($check_query)) {
				if ($check['zone_id'] < 1) {
					$check_flag = true;
					break;
				}
				elseif ($check['zone_id'] == $order->billing['zone_id']) {
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
	function javascript_validation() {
		return false;
	}

	function selection() {
      global $order;

		if (vam_not_null($this->icon)) $icon = vam_image($this->icon, $this->title);		
		
		$payment_query = vam_db_query("select * from ".TABLE_COMPANIES." where customers_id = '" . (int)$order->customer['id'] . "'");
		$payment_data = vam_db_fetch_array($payment_query);

      $selection = array('id' => $this->code,
                         'module' => $this->title,
                         'icon' => $icon,
                         'description'=>$this->info,
      	                 'fields' => array(array('title' => '<div id="schet">'.MODULE_PAYMENT_SCHET_J_NAME_TITLE,
      	                                         'field' => MODULE_PAYMENT_SCHET_J_NAME_DESC),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_NAME,
      	                                         'field' => vam_draw_input_field('s_name', $payment_data['name']) . MODULE_PAYMENT_SCHET_J_NAME_IP),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_INN,
      	                                         'field' => vam_draw_input_field('s_inn')),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_KPP,
//      	                                         'field' => vam_draw_input_field('s_kpp')),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_OGRN,
//      	                                         'field' => vam_draw_input_field('s_ogrn')),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_OKPO,
//      	                                         'field' => vam_draw_input_field('s_okpo')),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_RS,
//      	                                         'field' => vam_draw_input_field('s_rs')),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_BANK_NAME,
//      	                                         'field' => vam_draw_input_field('s_bank_name') . MODULE_PAYMENT_SCHET_J_BANK_NAME_HELP),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_BIK,
//      	                                         'field' => vam_draw_input_field('s_bik')),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_KS,
//      	                                         'field' => vam_draw_input_field('s_ks')),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_ADDRESS,
//      	                                         'field' => vam_draw_input_field('s_address') . MODULE_PAYMENT_SCHET_J_ADDRESS_HELP),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_YUR_ADDRESS,
//      	                                         'field' => vam_draw_input_field('s_yur_address')),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_FAKT_ADDRESS,
//      	                                         'field' => vam_draw_input_field('s_fakt_address')),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_TELEPHONE,
      	                                         'field' => vam_draw_input_field('s_telephone', $order->customer['telephone']).'</div>')
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_FAX,
//      	                                         'field' => vam_draw_input_field('s_fax')),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_EMAIL,
//      	                                         'field' => vam_draw_input_field('s_email')),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_DIRECTOR,
//      	                                         'field' => vam_draw_input_field('s_director', $order->customer['firstname'] . ' ' . $order->customer['lastname'])),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_ACCOUNTANT,
//      	                                         'field' => vam_draw_input_field('s_accountant'))
      	                                         
      	                                   ));

		return $selection;
      	                                   
	}

	function pre_confirmation_check() {

        $this->name = vam_db_prepare_input($_SESSION['s_name']);
        $this->inn = vam_db_prepare_input($_SESSION['s_inn']);
        $this->kpp = vam_db_prepare_input($_SESSION['s_kpp']);
        $this->ogrn = vam_db_prepare_input($_SESSION['s_ogrn']);
        $this->okpo = vam_db_prepare_input($_SESSION['s_okpo']);
        $this->rs = vam_db_prepare_input($_SESSION['s_rs']);
        $this->bank_name = vam_db_prepare_input($_SESSION['s_bank_name']);
        $this->bik = vam_db_prepare_input($_SESSION['s_bik']);
        $this->ks = vam_db_prepare_input($_SESSION['s_ks']);
        $this->address = vam_db_prepare_input($_SESSION['s_address']);
        $this->yur_address = vam_db_prepare_input($_SESSION['s_yur_address']);
        $this->fakt_address = vam_db_prepare_input($_SESSION['s_fakt_address']);
        $this->telephone = vam_db_prepare_input($_SESSION['s_telephone']);
        $this->fax = vam_db_prepare_input($_SESSION['s_fax']);
        $this->email = vam_db_prepare_input($_SESSION['s_email']);
        $this->director = vam_db_prepare_input($_SESSION['s_director']);
        $this->accountant = vam_db_prepare_input($_SESSION['s_accountant']);

	}

	// I take no credit for this, I just hunted down variables, the actual code was stolen from the 2checkout
	// module.  About 20 minutes of trouble shooting and poof, here it is. -- Thomas Keats
	function confirmation() {

		$confirmation = array ('title' => $this->title.': '.$this->check, 'fields' => array (array ('title' => MODULE_PAYMENT_SCHET_TEXT_DESCRIPTION)), 'description' => $this->info);

		return $confirmation;
	}

	function process_button() {

      $process_button_string = vam_draw_hidden_field('s_name', $this->name) .
                               vam_draw_hidden_field('s_inn', $this->inn).
                               vam_draw_hidden_field('s_kpp', $this->kpp).
                               vam_draw_hidden_field('s_ogrn', $this->ogrn).
                               vam_draw_hidden_field('s_okpo', $this->okpo).
                               vam_draw_hidden_field('s_rs', $this->rs).
                               vam_draw_hidden_field('s_bank_name', $this->bank_name).
                               vam_draw_hidden_field('s_bik', $this->bik).
                               vam_draw_hidden_field('s_ks', $this->ks).
                               vam_draw_hidden_field('s_address', $this->address).
                               vam_draw_hidden_field('s_yur_address', $this->yur_address).
                               vam_draw_hidden_field('s_fakt_address', $this->fakt_address) .
                               vam_draw_hidden_field('s_telephone', $this->telephone) .
                               vam_draw_hidden_field('s_fax', $this->fax) .
                               vam_draw_hidden_field('s_email', $this->email) .
                               vam_draw_hidden_field('s_director', $this->director) .
                               vam_draw_hidden_field('s_accountant', $this->accountant);

      return $process_button_string;

	}

	function before_process() {

    	 $this->pre_confirmation_check();
    	return false;

	}

	function after_process() {

      global $insert_id, $name, $inn, $kpp, $ogrn, $okpo, $rs, $bank_name, $bik, $ks, $address, $yur_address, $fakt_address, $telephone, $fax, $email, $director, $accountant, $checkout_form_action, $checkout_form_submit;
      vam_db_query("INSERT INTO ".TABLE_COMPANIES." (orders_id, customers_id, name, inn, kpp, ogrn, okpo, rs, bank_name, bik, ks, address, yur_address, fakt_address, telephone, fax, email, director, accountant) VALUES ('" . vam_db_prepare_input($insert_id) . "', '" . (int)$_SESSION['customer_id'] . "', '" . vam_db_prepare_input($_SESSION['s_name']) . "', '" . vam_db_prepare_input($_SESSION['s_inn']) . "', '" . vam_db_prepare_input($_SESSION['s_kpp']) . "', '" . vam_db_prepare_input($_SESSION['s_ogrn']) ."', '" . vam_db_prepare_input($_SESSION['s_okpo']) ."', '" . vam_db_prepare_input($_SESSION['s_rs']) ."', '" . vam_db_prepare_input($_SESSION['s_bank_name']) ."', '" . vam_db_prepare_input($_SESSION['s_bik']) ."', '" . vam_db_prepare_input($_SESSION['s_ks']) ."', '" . vam_db_prepare_input($_SESSION['s_address']) ."', '" . vam_db_prepare_input($_SESSION['s_yur_address']) ."', '" . vam_db_prepare_input($_SESSION['s_fakt_address']) ."', '" . vam_db_prepare_input($_SESSION['s_telephone']) ."', '" . vam_db_prepare_input($_SESSION['s_fax']) ."', '" . vam_db_prepare_input($_SESSION['s_email']) ."', '" . vam_db_prepare_input($_SESSION['s_director']) ."', '" . vam_db_prepare_input($_SESSION['s_accountant']) ."')");
      

		if ($this->order_status)
			vam_db_query("UPDATE ".TABLE_ORDERS." SET orders_status='".$this->order_status."' WHERE orders_id='".$insert_id."'");

	}

	function output_error() {
		return false;
	}

	function check() {
		if (!isset ($this->check)) {
			$check_query = vam_db_query("select configuration_value from ".TABLE_CONFIGURATION." where configuration_key = 'MODULE_PAYMENT_SCHET_STATUS'");
			$this->check = vam_db_num_rows($check_query);
		}
		return $this->check;
	}

	function install() {
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_ALLOWED', '', '6', '0', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_SCHET_STATUS', 'True', '6', '3', 'vam_cfg_select_option(array(\'True\', \'False\'), ', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_1', 'ООО \"Рога и копыта\"',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_2', 'Россия, 123456, г. Ставрополь, проспект Кулакова 8б, офис 130', '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_3', '(865)1234567',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_4', '(865)7654321',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_5', '1234567890',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_6', 'Росбанк',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_7', '0987654321',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_8', '123456',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_9', '87654321',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_10', '222222222',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_11', '11111111111111',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_12', '222222222222',  '6', '1', now());");
		vam_db_query("insert into ".TABLE_CONFIGURATION." (configuration_key, configuration_value,configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_SCHET_SORT_ORDER', '0',  '6', '0', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_SCHET_ZONE', '0',  '6', '2', 'vam_get_zone_class_title', 'vam_cfg_pull_down_zone_classes(', now())");
		vam_db_query("insert into ".TABLE_CONFIGURATION." ( configuration_key, configuration_value,  configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_SCHET_ORDER_STATUS_ID', '0', '6', '0', 'vam_cfg_pull_down_order_statuses(', 'vam_get_order_status_name', now())");

	}

	function remove() {
		vam_db_query("delete from ".TABLE_CONFIGURATION." where configuration_key in ('".implode("', '", $this->keys())."')");
	}

	function keys() {
		$keys = array ('MODULE_PAYMENT_SCHET_STATUS', 'MODULE_PAYMENT_SCHET_ALLOWED', 'MODULE_PAYMENT_SCHET_1', 'MODULE_PAYMENT_SCHET_2', 'MODULE_PAYMENT_SCHET_3', 'MODULE_PAYMENT_SCHET_4', 'MODULE_PAYMENT_SCHET_5', 'MODULE_PAYMENT_SCHET_6', 'MODULE_PAYMENT_SCHET_7', 'MODULE_PAYMENT_SCHET_8', 'MODULE_PAYMENT_SCHET_9', 'MODULE_PAYMENT_SCHET_10', 'MODULE_PAYMENT_SCHET_11', 'MODULE_PAYMENT_SCHET_12', 'MODULE_PAYMENT_SCHET_SORT_ORDER', 'MODULE_PAYMENT_SCHET_ZONE', 'MODULE_PAYMENT_SCHET_ORDER_STATUS_ID');

		return $keys;
	}
}
?>
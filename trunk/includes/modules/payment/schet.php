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
	function schet() {
		$this->code = 'schet';
		$this->title = MODULE_PAYMENT_SCHET_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_SCHET_TEXT_DESCRIPTION;
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

      $selection = array('id' => $this->code,
                         'module' => $this->title,
                         'description'=>$this->info,
      	                 'fields' => array(array('title' => MODULE_PAYMENT_SCHET_J_NAME_TITLE,
      	                                         'field' => MODULE_PAYMENT_SCHET_J_NAME_DESC),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_NAME,
      	                                         'field' => vam_draw_input_field('name') . MODULE_PAYMENT_SCHET_J_NAME_IP),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_INN,
      	                                         'field' => vam_draw_input_field('inn')),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_KPP,
      	                                         'field' => vam_draw_input_field('kpp')),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_OGRN,
      	                                         'field' => vam_draw_input_field('ogrn')),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_OKPO,
      	                                         'field' => vam_draw_input_field('okpo')),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_RS,
      	                                         'field' => vam_draw_input_field('rs')),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_BANK_NAME,
      	                                         'field' => vam_draw_input_field('bank_name') . MODULE_PAYMENT_SCHET_J_BANK_NAME_HELP),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_BIK,
      	                                         'field' => vam_draw_input_field('bik')),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_KS,
      	                                         'field' => vam_draw_input_field('ks')),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_ADDRESS,
      	                                         'field' => vam_draw_input_field('address') . MODULE_PAYMENT_SCHET_J_ADDRESS_HELP),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_YUR_ADDRESS,
//      	                                         'field' => vam_draw_input_field('yur_address')),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_FAKT_ADDRESS,
//      	                                         'field' => vam_draw_input_field('fakt_address')),
      	                                   array('title' => MODULE_PAYMENT_SCHET_J_TELEPHONE,
      	                                         'field' => vam_draw_input_field('telephone'))
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_FAX,
//      	                                         'field' => vam_draw_input_field('fax')),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_EMAIL,
//      	                                         'field' => vam_draw_input_field('email')),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_DIRECTOR,
//      	                                         'field' => vam_draw_input_field('director', $order->customer['firstname'] . ' ' . $order->customer['lastname'])),
//      	                                   array('title' => MODULE_PAYMENT_SCHET_J_ACCOUNTANT,
//      	                                         'field' => vam_draw_input_field('accountant'))
      	                                         
      	                                   ));

		return $selection;
      	                                   
	}

	function pre_confirmation_check() {

        $this->name = vam_db_prepare_input($_POST['name']);
        $this->inn = vam_db_prepare_input($_POST['inn']);
        $this->kpp = vam_db_prepare_input($_POST['kpp']);
        $this->ogrn = vam_db_prepare_input($_POST['ogrn']);
        $this->okpo = vam_db_prepare_input($_POST['okpo']);
        $this->rs = vam_db_prepare_input($_POST['rs']);
        $this->bank_name = vam_db_prepare_input($_POST['bank_name']);
        $this->bik = vam_db_prepare_input($_POST['bik']);
        $this->ks = vam_db_prepare_input($_POST['ks']);
        $this->address = vam_db_prepare_input($_POST['address']);
        $this->yur_address = vam_db_prepare_input($_POST['yur_address']);
        $this->fakt_address = vam_db_prepare_input($_POST['fakt_address']);
        $this->telephone = vam_db_prepare_input($_POST['telephone']);
        $this->fax = vam_db_prepare_input($_POST['fax']);
        $this->email = vam_db_prepare_input($_POST['email']);
        $this->director = vam_db_prepare_input($_POST['director']);
        $this->accountant = vam_db_prepare_input($_POST['accountant']);

	}

	// I take no credit for this, I just hunted down variables, the actual code was stolen from the 2checkout
	// module.  About 20 minutes of trouble shooting and poof, here it is. -- Thomas Keats
	function confirmation() {
		global $_POST;

		$confirmation = array ('title' => $this->title.': '.$this->check, 'fields' => array (array ('title' => MODULE_PAYMENT_SCHET_TEXT_DESCRIPTION)), 'description' => $this->info);

		return $confirmation;
	}

	function process_button() {

      $process_button_string = vam_draw_hidden_field('name', $this->name) .
                               vam_draw_hidden_field('inn', $this->inn).
                               vam_draw_hidden_field('kpp', $this->kpp).
                               vam_draw_hidden_field('ogrn', $this->ogrn).
                               vam_draw_hidden_field('okpo', $this->okpo).
                               vam_draw_hidden_field('rs', $this->rs).
                               vam_draw_hidden_field('bank_name', $this->bank_name).
                               vam_draw_hidden_field('bik', $this->bik).
                               vam_draw_hidden_field('ks', $this->ks).
                               vam_draw_hidden_field('address', $this->address).
                               vam_draw_hidden_field('yur_address', $this->yur_address).
                               vam_draw_hidden_field('fakt_address', $this->fakt_address) .
                               vam_draw_hidden_field('telephone', $this->telephone) .
                               vam_draw_hidden_field('fax', $this->fax) .
                               vam_draw_hidden_field('email', $this->email) .
                               vam_draw_hidden_field('director', $this->director) .
                               vam_draw_hidden_field('accountant', $this->accountant);

      return $process_button_string;

	}

	function before_process() {

    	 $this->pre_confirmation_check();
    	return false;

	}

	function after_process() {
      global $insert_id, $name, $inn, $kpp, $ogrn, $okpo, $rs, $bank_name, $bik, $ks, $address, $yur_address, $fakt_address, $telephone, $fax, $email, $director, $accountant, $checkout_form_action, $checkout_form_submit;
      vam_db_query("INSERT INTO ".TABLE_COMPANIES." (orders_id, name, inn, kpp, ogrn, okpo, rs, bank_name, bik, ks, address, yur_address, fakt_address, telephone, fax, email, director, accountant) VALUES ('" . $insert_id . "', '" . $this->name . "', '" . $this->inn . "', '" . $this->kpp . "', '" . $this->ogrn ."', '" . $this->okpo ."', '" . $this->rs ."', '" . $this->bank_name ."', '" . $this->bik ."', '" . $this->ks ."', '" . $this->address ."', '" . $this->yur_address ."', '" . $this->fakt_address ."', '" . $this->telephone ."', '" . $this->fax ."', '" . $this->email ."', '" . $this->director ."', '" . $this->accountant ."')");

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
<?php
/* -----------------------------------------------------------------------------------------
   $Id: sc_checkout_confirmation.php 1277 2012-11-11 19:20:03 oleg_vamsoft $

   VamShop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2012 VamShop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(address_book.php,v 1.57 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (address_book.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (address_book.php,v 1.14 2003/08/17); xt-commerce.com
   (c) 2012	 STRUB

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

//load languages files
require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . FILENAME_CHECKOUT);

// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC . 'vam_calculate_tax.inc.php');
require_once (DIR_FS_INC . 'vam_check_stock.inc.php');
require_once (DIR_FS_INC . 'vam_display_tax_value.inc.php');
require_once (DIR_FS_INC.'vam_encrypt_password.inc.php');
require_once (DIR_FS_INC.'vam_create_password.inc.php');

$hide_shipping_data = false;
$hide_payment_data = false;
$show_account_data = false; //account data will only be shown if in checkout.php the account heading is shown. This happens by free virtual products
$sc_payment_url = false; //used for redirection for url payment modules

if (vam_session_is_registered('hide_shipping_data')) {
	$hide_shipping_data = true; //used to hide shipping data
}

if (vam_session_is_registered('hide_payment_data')) {
	$hide_payment_data = true; //used to hide payment data
}

if (vam_session_is_registered('show_account_data')) {
	$show_account_data = true; //used to show account data
	$hide_shipping_data = true;
	$hide_payment_data = true;
}


// if the customer is not logged on, redirect them to the login page
  if ((!vam_session_is_registered('customer_id')) && (!vam_session_is_registered('noaccount'))) {
    vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    vam_redirect(vam_href_link(FILENAME_SHOPPING_CART));
  }

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($cart->cartID) && vam_session_is_registered('cartID')) {
    if ($cart->cartID != $cartID) {
      vam_redirect(vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    }
  }




############################# Validate start - NOT LOGGED ON #######################################

$process = false;
if ((vam_session_is_registered('create_account')) && (isset($_POST['action']) && ($_POST['action'] == 'process'))) {
    $process = true;
		
	$error = false;
}




if ($error == true) {
	//for testing
}





// if no shipping method has been selected, redirect the customer to the shipping method selection page
  if (!vam_session_is_registered('shipping')) {
    vam_redirect(vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  }

  if (!vam_session_is_registered('payment')) vam_session_register('payment');
  if (isset($_POST['payment'])) $payment = $_POST['payment'];

  if (!vam_session_is_registered('comments')) vam_session_register('comments');
  if (vam_not_null($_POST['comments'])) {
    $comments = vam_db_prepare_input($_POST['comments']);
  }

//-- TheMedia Begin check if display conditions on checkout page is true
if (isset ($_POST['cot_gv']))
	$_SESSION['cot_gv'] = true;
// if conditions are not accepted, redirect the customer to the payment method selection page

if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {

	if (isset($_POST['conditions'])) {
		$_SESSION['conditions'] = true;
	}

	if ($_SESSION['conditions'] == false) {
		$error = str_replace('\n', '<br />', ERROR_CONDITIONS_NOT_ACCEPTED);
		vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode($error), 'SSL', true, false));
	}
}

// load the selected payment module
  require(DIR_WS_CLASSES . 'payment.php');
if (isset ($_SESSION['credit_covers']))
	$_SESSION['payment'] = 'no_payment'; // GV Code Start/End ICW added for CREDIT CLASS  
  $payment_modules = new payment($payment);


// GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
  require (DIR_WS_CLASSES . 'order_total.php');
  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

  $payment_modules->update_status();

if (!vam_session_is_registered('free_payment')) { //hack for free payment
  if ( ($payment_modules->selected_module != $payment) || ( is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && !is_object($$payment) ) || (is_object($$payment) && ($$payment->enabled == false)) ) {
    vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
  }
}

// GV Code Start
$order_total_modules = new order_total();
$order_total_modules->collect_posts();
$order_total_modules->pre_confirmation_check();
// GV Code End

// GV Code line changed
//if ((is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && (!is_object($$_SESSION['payment'])) && (!isset ($_SESSION['credit_covers']))) || (is_object($$_SESSION['payment']) && ($$_SESSION['payment']->enabled == false))) {
	//vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
//}

  if (is_array($payment_modules->modules)) {
    $payment_modules->pre_confirmation_check();
  }

// load the selected shipping module
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping($shipping);

// Stock Check
  $any_out_of_stock = false;
  if (STOCK_CHECK == 'true') {
    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
      if (vam_check_stock($order->products[$i]['id'], $order->products[$i]['qty'])) {
        $any_out_of_stock = true;
      }
    }
    // Out of Stock
    if ( (STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock == true) ) {
      vam_redirect(vam_href_link(FILENAME_SHOPPING_CART));
    }
  }


///////////// START create account //////////////////////////////////////////////////
//if no errors
if ((vam_session_is_registered('create_account')) && (isset($_POST['action']) && ($_POST['action'] == 'process'))) {
    if ($error == false) {

      $sql_data_array = array('customers_firstname' => $_SESSION['sc_customers_firstname'],
                              'customers_secondname' => $_SESSION['sc_customers_secondname'],
                              'customers_lastname' => $_SESSION['sc_customers_lastname'],
                              'customers_status' => 2,
                              'customers_email_address' => $_SESSION['sc_customers_email_address'],
                              'customers_telephone' => $_SESSION['sc_customers_telephone'], 
                              'customers_fax' => $_SESSION['sc_customers_fax'],
                              'customers_newsletter' => $_SESSION['sc_customers_newsletter'], 
                              'customers_password' => vam_encrypt_password($_SESSION['sc_customers_password']));

      if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $_SESSION['sc_customers_gender'];
      if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = vam_date_raw($_SESSION['sc_customers_dob']);

      vam_db_perform(TABLE_CUSTOMERS, $sql_data_array);

      $customer_id = vam_db_insert_id();
      $customers_id = $customer_id;

   	  	$extra_fields_query = vam_db_query("select ce.fields_id from " . TABLE_EXTRA_FIELDS . " ce where ce.fields_status=1 ");
    	  while($extra_fields = vam_db_fetch_array($extra_fields_query))
				{
				  if(isset($_SESSION['fields_' . $extra_fields['fields_id']])){
            $sql_data_array = array('customers_id' => (int)$customers_id,
                              'fields_id' => $extra_fields['fields_id'],
                              'value' => $_SESSION['fields_' . $extra_fields['fields_id']]);
       		}
       		else
					{
					  $sql_data_array = array('customers_id' => (int)$customers_id,
                              'fields_id' => $extra_fields['fields_id'],
                              'value' => '');
						$is_add = false;
						for($i = 1; $i <= $_SESSION['fields_' . $extra_fields['fields_id'] . '_total']; $i++)
						{
							if(isset($_SESSION['fields_' . $extra_fields['fields_id'] . '_' . $i]))
							{
							  if($is_add)
							  {
                  $sql_data_array['value'] .= "\n";
								}
								else
								{
                  $is_add = true;
								}
              	$sql_data_array['value'] .= $_SESSION['fields_' . $extra_fields['fields_id'] . '_' . $i];
							}
						}
					}

					vam_db_perform(TABLE_CUSTOMERS_TO_EXTRA_FIELDS, $sql_data_array);
      	}
      	
      $sql_data_array = array('customers_id' => $customer_id,
                              'entry_firstname' => $_SESSION['sc_customers_firstname'], 
                              'entry_secondname' => $_SESSION['sc_customers_secondname'], 
                              'entry_lastname' => $_SESSION['sc_customers_lastname'], 
                              'entry_street_address' => $_SESSION['sc_customers_street_address'], 
                              'entry_postcode' => $_SESSION['sc_customers_postcode'], 
                              'entry_city' => $_SESSION['sc_customers_city'],
                              'entry_country_id' => $_SESSION['sc_customers_country']);

      if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $_SESSION['sc_customers_gender'];
      if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $_SESSION['sc_customers_company']; 
      if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $_SESSION['sc_customers_suburb']; 
      if (ACCOUNT_STATE == 'true') {
        if ($_SESSION['sc_customers_zone_id'] > 0) {
          $sql_data_array['entry_zone_id'] = $_SESSION['sc_customers_zone_id']; 
          $sql_data_array['entry_state'] = '';
        } else {
          $sql_data_array['entry_zone_id'] = '0';
          $sql_data_array['entry_state'] = $_SESSION['sc_customers_state']; 
        }
      }
	  

      vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

      $address_id = vam_db_insert_id();

      vam_db_query("update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . (int)$address_id . "' where customers_id = '" . (int)$customer_id . "'");

      vam_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customer_id . "', '0', now())");
	  
	  
	  //billto START
	  if ($_SESSION['sc_payment_address_selected'] != '1') { //is unchecked - so payment address is different or if virtual product
        $sql_data_array = array('customers_id' => $customer_id,
                                'entry_firstname' => $_SESSION['sc_payment_firstname'],
                                'entry_secondname' => $_SESSION['sc_payment_secondname'],
                                'entry_lastname' => $_SESSION['sc_payment_lastname'],
                                'entry_street_address' => $_SESSION['sc_payment_street_address'],
                                'entry_postcode' => $_SESSION['sc_payment_postcode'],
                                'entry_city' => $_SESSION['sc_payment_city'],
                                'entry_country_id' => $_SESSION['sc_payment_country']);

        if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $_SESSION['sc_payment_gender'];
        if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $_SESSION['sc_payment_company'];
        if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $_SESSION['sc_payment_suburb'];
        if (ACCOUNT_STATE == 'true') {
          if ($_SESSION['sc_customers_zone_id'] > 0) {
            $sql_data_array['entry_zone_id'] = $_SESSION['sc_payment_zone_id'];
            $sql_data_array['entry_state'] = '';
          } else {
            $sql_data_array['entry_zone_id'] = '0';
            $sql_data_array['entry_state'] = $_SESSION['sc_payment_state'];
          }
        }

        if (!vam_session_is_registered('billto')) vam_session_register('billto');

        vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

        $billto_payment = vam_db_insert_id();
      }
	  //billto END
	  
	  //register sessions
	  vam_session_register('customer_id');  
	  if (vam_session_is_registered('noaccount')) {vam_session_unregister('noaccount');} 
	  
	  //assign new default address and billing address
	  $customer_default_address_id = $address_id;
	  if ($_SESSION['sc_payment_address_selected'] == '1') { //is selected - payment address is same as shipping address
	  $billto = $customer_default_address_id; 
	  } else { //not selected - so a new address is being created
		  $billto = $billto_payment; 
	  }

	  
	  //do we need this???
	  //vam_session_register('sc_processed');
      vam_session_register('customer_first_name');
      vam_session_register('customer_default_address_id');
      vam_session_register('customer_country_id');
      vam_session_register('customer_zone_id');


	//START send create account mail
	//data needed: gender, firstname, lastname, email
		
	if (vam_session_is_registered('create_account')) {
		//load language file for email
	
		$name = $_SESSION['sc_customers_firstname'] . ' ' . $_SESSION['sc_customers_lastname'];
			
		      $vamTemplate->assign('EMAIL_ADDRESS', $_SESSION['sc_customers_email_address']);
		      $vamTemplate->assign('PASSWORD', $_SESSION['sc_customers_password']);
      
				$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.html');
				$vamTemplate->caching = 0;
				$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.txt');
		
				vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $_SESSION['sc_customers_email_address'], $name, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', EMAIL_SUPPORT_SUBJECT, $html_mail, $txt_mail);
							
	} 
	vam_session_unregister('create_account');
	//END send create account mail

	} //error end
}  
///////////// END create account //////////////////////////////////////////////////	  
	  

///////////// START Redirection for create account //////////////////////////////////////////////////	
if ((vam_session_is_registered('create_account')) && (isset($_POST['action']) && ($_POST['action'] == 'process'))) {  
// confirm order
	if ($error == false) {
		if (isset($$payment->form_action_url)) {
			$sc_payment_url = true;
			vam_session_unregister('sc_confirmation'); //to make sure if not returning back to checkout_success.php
			$form_action_url = $$payment->form_action_url;
		} else {
			$form_action_url = vam_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
			vam_redirect($form_action_url); //redirect
		}
	} //error end
}
///////////// END Redirection for create account //////////////////////////////////////////////////	

///////////// START Redirection for noaccount //////////////////////////////////////////////////	
if ((!vam_session_is_registered('create_account')) && (isset($_POST['action']) && ($_POST['action'] == 'process'))) {  
// confirm order
	if (isset($$payment->form_action_url)) {
		$sc_payment_url = true;
		vam_session_unregister('sc_confirmation'); //to make sure if not returning back to checkout_success.php
		$form_action_url = $$payment->form_action_url;
	} else {
		$form_action_url = vam_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
		vam_redirect($form_action_url); //redirect
	}
}
///////////// END Redirection for noaccount //////////////////////////////////////////////////	

###################### payment url redirection START ###################################
//if payment method such as paypal is choosen,  repost process_button data
  if ((isset($$payment->form_action_url)) && ($sc_payment_url == true)) {
		
	$form_action_url = $$payment->form_action_url;
	$payment_fields .= vam_draw_form('checkoutUrl', $form_action_url, 'post');
	   
  
  
    
	if (is_array($payment_modules->modules)) {
		$payment_modules->pre_confirmation_check();
	}
  
  
	if (is_array($payment_modules->modules)) {
		$payment_fields .= $payment_modules->process_button();
	}


	if (is_array($payment_modules->modules)) {
		if ($confirmation = $payment_modules->confirmation()) {

  $payment_fields .= HEADING_PAYMENT_INFORMATION;

		$payment_fields .= $confirmation['title'];

      for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) {

      $payment_fields .= $confirmation['fields'][$i]['title'];
      $payment_fields .= $confirmation['fields'][$i]['field'];

      }

    }
  }

$payment_fields .= SC_TEXT_REDIRECT;
$payment_fields .= '</form>';

$payment_fields .= '

<script type="text/javascript">
    document.checkoutUrl.submit();
</script>
<noscript><input type="submit" value="verify submit"></noscript>

';

$vamTemplate->assign('PAYMENT_FIELDS', $payment_fields);
   
}
//////////  END  redirection page for payment modules such as paypal if no confirmation page ////////////

$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION, vam_href_link(FILENAME_CHECKOUT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION);

if ($hide_shipping_data == 'true') {
$vamTemplate->assign('SHIPPING_ADDRESS', 'false');
}

if (SHOW_IP_LOG == 'true') {
	$vamTemplate->assign('IP_LOG', 'true');
	if ($_SERVER["HTTP_X_FORWARDED_FOR"]) {
		$customers_ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	} else {
		$customers_ip = $_SERVER["REMOTE_ADDR"];
	}
	$vamTemplate->assign('CUSTOMERS_IP', $customers_ip);
}
if ($show_account_data == true) {
$vamTemplate->assign('DELIVERY_LABEL', vam_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'));
}
//if ($_SESSION['credit_covers'] != '1') {
	$vamTemplate->assign('BILLING_LABEL', vam_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'));
//}
$vamTemplate->assign('PRODUCTS_EDIT', vam_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
$vamTemplate->assign('SHIPPING_ADDRESS_EDIT', vam_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL'));
$vamTemplate->assign('BILLING_ADDRESS_EDIT', vam_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL'));

if ($_SESSION['sendto'] != false) {

	if ($order->info['shipping_method']) {
		$vamTemplate->assign('SHIPPING_METHOD', $order->info['shipping_method']);
		$vamTemplate->assign('SHIPPING_EDIT', vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));

	}

}

if (sizeof($order->info['tax_groups']) > 1) {

	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {

	}

} else {

}
$data_products = '<table border="0" cellspacing="0" cellpadding="0">';
for ($i = 0, $n = sizeof($order->products); $i < $n; $i++) {

	$data_products .= '<tr>' . "\n" . '            <td class="main" align="left" valign="top">' . $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . '</td>' . "\n" . '                <td class="main" align="right" valign="top">' . $vamPrice->Format($order->products[$i]['final_price'], true) . '</td></tr>' . "\n";
	if (ACTIVATE_SHIPPING_STATUS == 'true') {

		$data_products .= '<tr>
							<td class="main" align="left" valign="top">
							<small>' . SHIPPING_TIME . $order->products[$i]['shipping_time'] . '
							</small></td>
							<td class="main" align="right" valign="top">&nbsp;</td></tr>';

	}
	if ((isset ($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0)) {
		for ($j = 0, $n2 = sizeof($order->products[$i]['attributes']); $j < $n2; $j++) {
			$data_products .= '<tr>
								<td class="main" align="left" valign="top">
								<small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '
								</i></small></td>
								<td class="main" align="right" valign="top">&nbsp;</td></tr>';
		}
	}

	$data_products .= '' . "\n";

	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		if (sizeof($order->info['tax_groups']) > 1)
			$data_products .= '            <td class="main" valign="top" align="right">' . vam_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n";
	}
	$data_products .= '</tr>' . "\n";
}
$data_products .= '</table>';
$vamTemplate->assign('PRODUCTS_BLOCK', $data_products);

if ($order->info['payment_method'] != 'no_payment' && $order->info['payment_method'] != '') {
	include (DIR_WS_LANGUAGES . '/' . $_SESSION['language'] . '/modules/payment/' . $order->info['payment_method'] . '.php');
	$vamTemplate->assign('PAYMENT_METHOD', constant(MODULE_PAYMENT_ . strtoupper($order->info['payment_method']) . _TEXT_TITLE));
}
$vamTemplate->assign('PAYMENT_EDIT', vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));

$total_block = '<table>';
if (MODULE_ORDER_TOTAL_INSTALLED) {
	$order_total_modules->process();
	$total_block .= $order_total_modules->output();
}
$total_block .= '</table>';
$vamTemplate->assign('TOTAL_BLOCK', $total_block);

if (is_array($payment_modules->modules)) {
	if ($confirmation = $payment_modules->confirmation()) {

		$payment_info = $confirmation['title'];
		for ($i = 0, $n = sizeof($confirmation['fields']); $i < $n; $i++) {

			$payment_info .= '<table>
								<tr>
						                <td>' . vam_draw_separator('pixel_trans.gif', '10', '1') . '</td>
						                <td class="main">' . $confirmation['fields'][$i]['title'] . '</td>
						                <td>' . vam_draw_separator('pixel_trans.gif', '10', '1') . '</td>
						                <td class="main">' . stripslashes($confirmation['fields'][$i]['field']) . '</td>
						              </tr></table>';

		}
		$vamTemplate->assign('PAYMENT_INFORMATION', $payment_info);

	}
}

if (vam_not_null($order->info['comments'])) {
	$vamTemplate->assign('ORDER_COMMENTS', nl2br(htmlspecialchars($order->info['comments'])) . vam_draw_hidden_field('comments', $order->info['comments']));

}

if (!$$_SESSION['payment']->form_action_url) $$_SESSION['payment']->form_action_url = $GLOBALS[$payment]->form_action_url;

if (isset ($$_SESSION['payment']->form_action_url) && !$$_SESSION['payment']->tmpOrders) {

	$form_action_url = $$_SESSION['payment']->form_action_url;

} else {
	$form_action_url = vam_href_link(FILENAME_SC_CHECKOUT_CONFIRMATION, '', 'SSL');
}
$vamTemplate->assign('CHECKOUT_FORM', vam_draw_form('checkout_confirmation', $form_action_url, 'post').vam_draw_hidden_field('action', 'process'));
$payment_button = '';
if (is_array($payment_modules->modules)) {
	$payment_button .= $payment_modules->process_button();
}
$vamTemplate->assign('MODULE_BUTTONS', $payment_button);
$vamTemplate->assign('CHECKOUT_BUTTON', vam_image_submit('submit.png', IMAGE_BUTTON_CONFIRM_ORDER) . '</form>' . "\n");

//check if display conditions on checkout page is true
if (DISPLAY_REVOCATION_ON_CHECKOUT == 'true') {

	if (GROUP_CHECK == 'true') {
		$group_check = "and group_ids LIKE '%c_" . $_SESSION['customers_status']['customers_status_id'] . "_group%'";
	}

	$shop_content_query = "SELECT
		                                                content_title,
		                                                content_heading,
		                                                content_text,
		                                                content_file
		                                                FROM " . TABLE_CONTENT_MANAGER . "
		                                                WHERE content_group='" . REVOCATION_ID . "' " . $group_check . "
		                                                AND languages_id='" . $_SESSION['languages_id'] . "'";

	$shop_content_query = vam_db_query($shop_content_query);
	$shop_content_data = vam_db_fetch_array($shop_content_query);

	if ($shop_content_data['content_file'] != '') {
		ob_start();
		if (strpos($shop_content_data['content_file'], '.txt'))
			echo '<pre>';
		include (DIR_FS_CATALOG . 'media/content/' . $shop_content_data['content_file']);
		if (strpos($shop_content_data['content_file'], '.txt'))
			echo '</pre>';
		$revocation = ob_get_contents();
		ob_end_clean();
	} else {
		$revocation = $shop_content_data['content_text'];
	}

	$vamTemplate->assign('REVOCATION', $revocation);
	$vamTemplate->assign('REVOCATION_TITLE', $shop_content_data['content_heading']);
	$vamTemplate->assign('REVOCATION_LINK', $main->getContentLink(REVOCATION_ID, MORE_INFO));
	
	$shop_content_query = "SELECT
		                                                content_title,
		                                                content_heading,
		                                                content_text,
		                                                content_file
		                                                FROM " . TABLE_CONTENT_MANAGER . "
		                                                WHERE content_group='3' " . $group_check . "
		                                                AND languages_id='" . $_SESSION['languages_id'] . "'";

	$shop_content_query = vam_db_query($shop_content_query);
	$shop_content_data = vam_db_fetch_array($shop_content_query);
	
	$vamTemplate->assign('AGB_TITLE', $shop_content_data['content_heading']);
	$vamTemplate->assign('AGB_LINK', $main->getContentLink(3, MORE_INFO));

}

require (DIR_WS_INCLUDES . 'header.php');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('PAYMENT_BLOCK', $payment_block);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE . '/module/sc_checkout_confirmation.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_SC_CHECKOUT_CONFIRMATION.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_SC_CHECKOUT_CONFIRMATION.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');

?>
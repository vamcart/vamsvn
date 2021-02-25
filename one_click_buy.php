<?php
/*
  $Id: one_click_buy.php,v 1.42 2003/06/11 17:35:01 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
  Credits: Marg Davison, Loпc Richard, FaNaTiC, C. Bouwmeester
  Anpassungen fьr XT:Commerce 3.0.4 SP1: 2005/2006 BSB Beratung+Software Bleicher
  ASK_A_QUESTION.GIF Grafikdesign (c) 2005/2005 BSB Beratung+Software Bleicher

*/
include ('includes/application_top.php');

// include needed functions
require_once(DIR_FS_INC.'vam_validate_email.inc.php');
require_once (DIR_FS_INC.'vam_image_button.inc.php');
require_once (DIR_FS_INC.'vam_random_charcode.inc.php');
require_once (DIR_FS_INC.'vam_render_vvcode.inc.php');

require_once(DIR_FS_INC . 'vam_encrypt_password.inc.php');
require_once(DIR_FS_INC . 'vam_create_password.inc.php');
require_once(DIR_FS_INC . 'vam_random_charcode.inc.php');
require_once(DIR_FS_INC . 'vam_calculate_tax.inc.php');
require_once(DIR_FS_INC . 'vam_address_label.inc.php');
require_once(DIR_FS_INC . 'changedatain.inc.php');

    require_once (DIR_FS_INC.'vam_check_stock.inc.php');


// create smarty elements
$vamTemplate = new vamTemplate;

$vamTemplate->assign('language', $_SESSION['language']);

		$spam_flag = false;

		if ( trim( $_POST['anti-bot-q'] ) != date('Y') ) { // answer is wrong - maybe spam
			$spam_flag = true;
			if ( empty( $_POST['anti-bot-q'] ) ) { // empty answer - maybe spam
				$antispam_error_message .= 'Error: empty answer. ['.$_POST['anti-bot-q'].']<br> ';
			} else {
				$antispam_error_message .= 'Error: answer is wrong. ['.$_POST['anti-bot-q'].']<br> ';
			}
		}
		if ( ! empty( $_POST['anti-bot-e-email-url'] ) ) { // field is not empty - maybe spam
			$spam_flag = true;
			$antispam_error_message .= 'Error: field should be empty. ['.$_POST['anti-bot-e-email-url'].']<br> ';
		}
		
if (isset ($_POST['action']) && ($_POST['action'] == 'process')  && $spam_flag == false) {

include ('includes/header.php');

$product_info_query = vam_db_query("select * FROM ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_status = '1' and p.products_id = '".(int)$_POST['products_id']."' and pd.products_id = p.products_id and pd.language_id = '".(int)$_SESSION['languages_id']."'");
$product_info = vam_db_fetch_array($product_info_query);

	$error = false;

	if (isset($_SESSION['customer_id'])) { 
		$firstname = $_SESSION['customer_first_name'];
		$lastname = $_SESSION['customer_last_name'];
		$telephone = $_SESSION['customer_telephone'];
		$email_address =$_SESSION['customer_email_address'];
		$message = vam_db_input($_POST['message_body']);
		$to_email_address = $email_address;
		$to_name = $firstname .' '. $lastname;
  } else {    
		$firstname = vam_db_input($_POST['firstname']);
		$lastname = vam_db_input($_POST['lastname']);
		$telephone = vam_db_input($_POST['telephone']);
		$email_address = vam_db_input($_POST['email_address']);
		$message = vam_db_input($_POST['message_body']);
		$to_email_address = $email_address;
		$to_name = $firstname .' '. $lastname;
	}
	
	//if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		//$error = true;
		//$messageStack->add('one_click_buy', ENTRY_FIRST_NAME_ERROR);
	//}

	if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
		$error = true;
		$messageStack->add('one_click_buy', ENTRY_TELEPHONE_NUMBER_ERROR);
	}

	//if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
		//$error = true;
		//$messageStack->add('one_click_buy', ENTRY_EMAIL_ADDRESS_ERROR);
	//}
	//elseif (vam_validate_email($email_address) == false) {
		//$error = true;
		//$messageStack->add('one_click_buy', ENTRY_EMAIL_ADDRESS_ERROR);
	//} 

	//if ($message == '') {
		//$error = true;
		//$messageStack->add('one_click_buy', TEXT_MESSAGE_ERROR);
	//}

	if ($messageStack->size('one_click_buy') > 0) {
$vamTemplate->assign('error', $messageStack->output('one_click_buy'));
	}

		if ($error == false) {
			
			
// Register customer		
if (!isset($_SESSION['customer_id'])) { 
        $newsletter = 1;	
        $random_pass = vam_RandomString(8);
        $password = vam_encrypt_password($random_pass);

        $sql_data_array = array('customers_firstname' => $firstname,
            'customers_status' => 2,
            'customers_secondname' => '',
            'customers_lastname' => '',
            'customers_email_address' => $email_address,
            'customers_telephone' => $telephone,
            'customers_fax' => '',
            'customers_date_added' => 'now()',
            'customers_last_modified' => 'now()',
            'customers_newsletter' => $newsletter,
            'customers_password' => $password);

        vam_db_perform(TABLE_CUSTOMERS, $sql_data_array);
        $customer_id = vam_db_insert_id();
        $customers_id = $customer_id;

        $sql_data_array = array('customers_id' => $customer_id,
            'entry_firstname' => $firstname,
            'entry_secondname' => '',
            'entry_lastname' => '',
            'entry_street_address' => '',
            'entry_postcode' => '',
            'entry_city' => '',
            'entry_country_id' => '');

        vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

        $address_id = vam_db_insert_id();

        vam_db_query("update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . (int)$address_id . "' where customers_id = '" . (int)$customer_id . "'");

        vam_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customer_id . "', '0', now())");

// Send Customer Email
        if (SC_EMAIL_LOGIN_DATA == 'true' && filter_var($email_address, FILTER_VALIDATE_EMAIL)) {

            $vamTemplate->assign('EMAIL_ADDRESS', $email_address);
            $vamTemplate->assign('PASSWORD', $random_pass);
            $module_content = array();
            $module_content = array('MAIL_REPLY_ADDRESS' => EMAIL_SUPPORT_REPLY_ADDRESS);
            $vamTemplate->assign('content', $module_content);

            if ($newsletter == 1) {
                $vlcode = vam_random_charcode(32);
                $link = vam_href_link(FILENAME_NEWSLETTER, 'action=activate&email=' . $email_address . '&key=' . $vlcode, 'NONSSL');
                $sql_data_array = array('customers_email_address' => vam_db_input($email_address), 'customers_id' => vam_db_input($customers_id), 'customers_status' => 2, 'customers_firstname' => vam_db_input($firstname), 'customers_lastname' => '', 'mail_status' => '1', 'mail_key' => vam_db_input($vlcode), 'date_added' => 'now()');
                vam_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);
                // assign vars
                $vamTemplate->assign('LINK', $link);
            } else {
                $vamTemplate->assign('LINK', false);
            }

            $html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE . '/mail/' . $_SESSION['language'] . '/create_account_mail.html');
            $vamTemplate->caching = 0;
            $txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE . '/mail/' . $_SESSION['language'] . '/create_account_mail.txt');
            vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $email_address, $firstname, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', EMAIL_SUPPORT_SUBJECT, $html_mail, $txt_mail);

        }			
}			
			

//Register Order
if ($_POST['products_id'] > 0) {
$payment = 'cod';
$shipping = array('id' => 'flat_flat', 'title' => ONE_CLICK_BUY_NAVBAR_TITLE, 'cost' => '0');
$product = new product($_POST['products_id']);
$products_price = $vamPrice->GetPrice($product->data['products_id'], $format = true, 1, $product->data['products_tax_class_id'], $product->data['products_price'], 1);


       $sql_data_array = array(
           'customers_id' => (isset($_SESSION['customer_id']) ? $_SESSION['customer_id'] : $customer_id),
           'customers_name' => $firstname,
           'customers_firstname' => $firstname,
           'customers_status' => 2,
           'customers_telephone' => $telephone,
           'customers_email_address' => $email_address,
           'customers_address_format_id' => 1,
           'delivery_name' => $firstname,
           'delivery_firstname' => $firstname,
           'delivery_address_format_id' => 1,
           'billing_name' => $firstname,
           'billing_firstname' => $firstname,
           'billing_address_format_id' => 1,
           'payment_method' => $payment,
           'payment_class' => $payment,
           'shipping_method' => ONE_CLICK_BUY_NAVBAR_TITLE,
           'shipping_class' => 'flat_flat',
           'date_purchased' => 'now()',
           'orders_status' => 1,
           'currency' => DEFAULT_CURRENCY,
           'currency_value' => 1,
           'language' => $_SESSION['language']);
                    			

        vam_db_perform(TABLE_ORDERS, $sql_data_array);
        $insert_id = vam_db_insert_id();

        // Update products_ordered (for bestsellers list)
        vam_db_query("update " . TABLE_PRODUCTS . " set products_ordered = products_ordered + 1, products_quantity = products_quantity - 1 where products_id = '" . vam_get_prid($product->data['products_id']) . "'");

        $sql_data_array = array('orders_id' => $insert_id, 'products_id' => vam_get_prid($product->data['products_id']), 'products_model' => $product->data['products_model'], 'products_name' => $product->data['products_name'], 'products_price' => $products_price['plain'], 'final_price' => $products_price['plain'], 'products_quantity' => 1, 'allow_tax' => $_SESSION['customers_status']['customers_status_show_price_tax']);

        vam_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);
        $order_products_id = vam_db_insert_id();

// Include Language Text
include_once(DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/order_total/ot_subtotal.php');
include_once(DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/order_total/ot_shipping.php');
include_once(DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/order_total/ot_total.php');

$total_format = $vamPrice->Format($products_price['plain'],true);
												
        // Subtotal
        $sql_data_array = array('orders_id' => $insert_id, 'title' => MODULE_ORDER_TOTAL_SUBTOTAL_TITLE, 'text' => $total_format, 'value' => $products_price['plain'], 'class' => 'ot_subtotal', 'sort_order' => 10);
        vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

        // Shipping
        $sql_data_array = array('orders_id' => $insert_id, 'title' => MODULE_ORDER_TOTAL_SHIPPING_TITLE, 'text' => 0, 'value' => 0, 'class' => 'ot_shipping', 'sort_order' => 30);
        vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

        // Total
        $sql_data_array = array('orders_id' => $insert_id, 'title' => MODULE_ORDER_TOTAL_TOTAL_TITLE, 'text' => '<b>'.$total_format.'</b>', 'value' => $products_price['plain'], 'class' => 'ot_total', 'sort_order' => 99);
        vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);

        $customer_notification = (SEND_EMAILS == 'true') ? '1' : '0';
        $sql_data_array = array('orders_id' => $insert_id, 'orders_status_id' => 1, 'date_added' => 'now()', 'customer_notified' => 1, 'comments' => ONE_CLICK_BUY_NAVBAR_TITLE);
        vam_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
}

			
		$vamTemplate->assign('PRODUCTS_NAME', $product_info['products_name']);
		$vamTemplate->assign('PRODUCTS_IMAGE', $product_info['products_image']);
      $products_price = $vamPrice->GetPrice($product_info['products_id'], $format = true, 1, $product_info['products_tax_class_id'], $product_info['products_price'], 1);
		$vamTemplate->assign('PRODUCTS_PRICE', $products_price['formated']);
		$vamTemplate->assign('PRODUCTS_MODEL', $product_info['products_model']);
		$vamTemplate->assign('TEXT_MESSAGE', $_POST['message_body']);
		$vamTemplate->assign('TEXT_FIRSTNAME', $firstname);
		$vamTemplate->assign('TEXT_LASTNAME', $lastname);
		$vamTemplate->assign('TEXT_TELEPHONE', $telephone);
		$vamTemplate->assign('TEXT_EMAIL', $email_address);
		$vamTemplate->assign('TEXT_EMAIL_SUCCESSFUL', sprintf(TEXT_EMAIL_SUCCESSFUL_SENT, $product_info['products_name']));
		$vamTemplate->assign('PRODUCT_LINK', vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($product_info['products_id'], $product_info['products_name'])));
		$vamTemplate->caching = 0;
		$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/one_click_buy.html');
		$vamTemplate->caching = 0;
		$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/one_click_buy.txt');
	// send mail to admin
	vam_php_mail(filter_var(EMAIL_SUPPORT_ADDRESS, FILTER_VALIDATE_EMAIL), EMAIL_SUPPORT_NAME, EMAIL_SUPPORT_ADDRESS, STORE_NAME, EMAIL_SUPPORT_FORWARDING_STRING, filter_var($to_email_address, FILTER_VALIDATE_EMAIL), $to_name, '', '', ONE_CLICK_BUY_NAVBAR_TITLE, $html_mail, $txt_mail);
	// send mail to customer
	//vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $to_email_address, $to_name, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', NAVBAR_TITLE_ASK, $html_mail, $txt_mail);


// Google Conversion tracking
	include (DIR_WS_CLASSES.'order.php');
	$order = new order($insert_id);

if ($insert_id && (GOOGLE_CONVERSION == 'true' or GOOGLE_TAG_MANAGER == 'true')) {

// ############## Google Analytics - start ###############

// Get order id
	$order_id = $order->info['id'];

// Get order info for Analytics "Transaction line" (affiliation, city, state, country, total, tax and shipping)

// Set value for  "affiliation"

	$analytics_affiliation = STORE_NAME;


// Get info for "city", "state", "country"
    $orders_query = vam_db_query("select customers_city, customers_state, customers_country from " . TABLE_ORDERS . " where orders_id = '" . $order_id . "' AND customers_id = '" . (int)$_SESSION['customer_id'] . "'");
    $orders = vam_db_fetch_array($orders_query);

    $totals_query = vam_db_query("select value, class from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' order by sort_order");
// Set values for "total", "tax" and "shipping"
    $analytics_total = '';
    $analytics_tax = '';
    $analytics_shipping = '';
    
     while ($totals = vam_db_fetch_array($totals_query)) {

        if ($totals['class'] == 'ot_total') {
            $analytics_total = $totals['value'];
            $total_flag = 'true';
        } else if ($totals['class'] == 'ot_tax') {
            $analytics_tax = $totals['value'];
            $tax_flag = 'true';
        } else if ($totals['class'] == 'ot_shipping') {
            $analytics_shipping = $totals['value'];
			{ if ($analytics_shipping === "0.0000") $analytics_shipping = ''; }
            $shipping_flag = 'true';
        }

     }


// Prepare the Analytics "Transaction line" string

	$transaction_string = '
	
  "transaction_id": "' . $order_id . '",
  "affiliation": "' . STORE_NAME . '",
  "value": ' . $analytics_total . ',
  "currency": "' . $order->info['currency'] . '",
  "tax": ' . (($analytics_tax > 0) ? $analytics_tax : 0) . ',
  "shipping": ' . (($analytics_shipping > 0) ? $analytics_shipping : 0) . ',
	
	';

// Get products info for Analytics "Item lines"

	$item_string = '';
    $items_query = vam_db_query("select products_id, products_model, products_name, final_price, products_quantity from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $order_id . "' order by products_name");
    while ($items = vam_db_fetch_array($items_query)) {
		$category_query = vam_db_query("select p2c.categories_id, cd.categories_name from " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where p2c.products_id = '" . $items['products_id'] . "' AND cd.categories_id = p2c.categories_id AND cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
		$category = vam_db_fetch_array($category_query);
		
	  $item_string .=  
	  
  '{'."\n".'
	  
      "id": "' . htmlspecialchars($items['products_model']) . '",
      "name": "' . htmlspecialchars($items['products_name']) . '",
      "category": "' . htmlspecialchars($category['categories_name']) . '",
      "quantity": ' . $items['products_quantity'] . ',
      "price": \'' . $items['final_price'] . '\'
	  
  },'."\n";


    }

// ############## Google Analytics - end ###############

$tracking_code .= '
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id='. GOOGLE_CONVERSION_ID .'"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());

  gtag(\'config\', \''. GOOGLE_CONVERSION_ID .'\');

  gtag(\'event\', \'purchase\', {
' . $transaction_string . '
  "items": [
' . $item_string . '
  ]

  });


</script>

		    ';

	$vamTemplate->assign('google_tracking', 'true');
	$vamTemplate->assign('tracking_code', $tracking_code);

}

if ($insert_id > 0 && YANDEX_METRIKA == 'true') {

	$order_id = $order->info['id'];

// Get order info for Analytics "Transaction line" (affiliation, city, state, country, total, tax and shipping)

// Set value for  "affiliation"

	$analytics_affiliation = STORE_NAME;


// Get info for "city", "state", "country"
    $orders_query = vam_db_query("select customers_city, customers_state, currency, customers_country from " . TABLE_ORDERS . " where orders_id = '" . $order_id . "' AND customers_id = '" . (int)$_SESSION['customer_id'] . "'");
    $orders = vam_db_fetch_array($orders_query);

    $totals_query = vam_db_query("select value, class from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' order by sort_order");
// Set values for "total", "tax" and "shipping"
    $analytics_total = '';
    $analytics_tax = '';
    $analytics_shipping = '';
    
     while ($totals = vam_db_fetch_array($totals_query)) {

        if ($totals['class'] == 'ot_total') {
            $analytics_total = $totals['value'];
            $total_flag = 'true';
        } else if ($totals['class'] == 'ot_tax') {
            $analytics_tax = $totals['value'];
            $tax_flag = 'true';
        } else if ($totals['class'] == 'ot_shipping') {
            $analytics_shipping = $totals['value'];
			{ if ($analytics_shipping === "0.0000") $analytics_shipping = ''; }
            $shipping_flag = 'true';
        }

     }

// Prepare the Analytics "Transaction line" string

	$transaction_string = 'order_id: "' . $order_id . '",'."\n".'order_price: ' . number_format($analytics_total,2,'.','') . ','."\n".'currency: "' . $orders['currency'] . '",'."\n".'exchange_rate: 1,';

// Get products info for Analytics "Item lines"

	$item_string = '';
    $items_query = vam_db_query("select products_id, products_model, products_name, products_price, final_price, products_quantity from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . $order_id . "' order by products_name");
    while ($items = vam_db_fetch_array($items_query)) {
		$category_query = vam_db_query("select p2c.categories_id, cd.categories_name from " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where p2c.products_id = '" . $items['products_id'] . "' AND cd.categories_id = p2c.categories_id AND cd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
		$category = vam_db_fetch_array($category_query);
		
	  $item_string .=  '{'."\n".'id: "' . htmlspecialchars($items['products_id']) . '",'."\n".'name: "' . htmlspecialchars($items['products_name']) . '",'."\n".'price: ' . number_format($items['products_price'],2,'.','') . ','."\n".'quantity: ' . number_format($items['products_quantity']) . ''."\n".'},'."\n";
    }

// ############## Yandex Metrika - end ###############


$tracking_code .= '
<script>
window.dataLayer = window.dataLayer || [];
</script>			
<script>
dataLayer.push({
    "ecommerce": {
        "purchase": {
            "actionField": {
                "id" : "'.$insert_id.'"
            },
            "products": [
                '.$item_string.'	
            ]
        }
    }
});
	
</script>
<!-- Yandex.Metrika counter -->
<script>
   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
   (window, document, "script", "https://cdn.jsdelivr.net/npm/yandex-metrica-watch/tag.js", "ym");

   ym('.YANDEX_METRIKA_ID.', "init", {
        id:'.YANDEX_METRIKA_ID.',
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true,
        trackHash:true,
        ecommerce:"dataLayer"
   });
</script>
<!-- /Yandex.Metrika counter -->
		    ';

	$vamTemplate->assign('google_tracking', 'true');
	$vamTemplate->assign('tracking_code', $tracking_code);

}

if (!CacheCheck()) {
	$vamTemplate->caching = 0;
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/one_click_buy_ok.html');
} else {
	$vamTemplate->caching = 1;
	$vamTemplate->cache_lifetime = CACHE_LIFETIME;
	$vamTemplate->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/one_click_buy_ok.html', $cache_id);
		}
	}else{
$vamTemplate->assign('PRODUCTS_NAME', $product_info['products_name']);
$vamTemplate->assign('PRODUCTS_MODEL', $product_info['products_model']);

$vamTemplate->assign('FORM_ACTION', vam_draw_form('one_click_buy', vam_href_link(FILENAME_ONE_CLICK_BUY, 'products_id='.$_GET['products_id'].'')).vam_draw_hidden_field('action', 'process').vam_draw_hidden_field('products_id', $_GET['products_id']));

        if (isset($_SESSION['customer_id'])) { 
		//-> registered user********************************************************
$vamTemplate->assign('INPUT_FIRSTNAME', $_SESSION['customer_first_name']);
$vamTemplate->assign('INPUT_LASTNAME', $_SESSION['customer_last_name']);
$vamTemplate->assign('INPUT_TELEPHONE', $_SESSION['customer_telephone']);
$vamTemplate->assign('INPUT_EMAIL', $_SESSION['customer_email_address']);
        }else{
		//-> guest *********************************************************  
$vamTemplate->assign('INPUT_FIRSTNAME', vam_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '' : ''))));
$vamTemplate->assign('INPUT_LASTNAME', vam_draw_input_fieldNote(array ('name' => 'lastname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement Requirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : ''))));
$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_fieldNote(array ('name' => 'email_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '' : ''))));
$vamTemplate->assign('INPUT_TELEPHONE', vam_draw_input_fieldNote(array ('name' => 'telephone', 'text' => '&nbsp;'. (vam_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement Requirement">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>' : ''))));
        }
$vamTemplate->assign('INPUT_TEXT', vam_draw_textarea_field('message_body', 'soft', 10, 3, stripslashes($_POST['message_body'])));
$vamTemplate->assign('FORM_END', '</form>');
$vamTemplate->assign('BUTTON_SUBMIT', vam_image_submit('submit.png',  IMAGE_BUTTON_CHECKOUT));
$vamTemplate->assign('BUTTON_CONTINUE', '<a class="button" href="javascript:window.close()">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');

// set cache ID
 if (!CacheCheck()) {
	$vamTemplate->caching = 0;
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/one_click_buy.html');
} else {
	$vamTemplate->caching = 1;
	$vamTemplate->cache_lifetime = CACHE_LIFETIME;
	$vamTemplate->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/one_click_buy.html', $cache_id);
	}
}
}else{

$product_info_query = vam_db_query("select * FROM ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_status = '1' and p.products_id = '".(int)$_GET['products_id']."' and pd.products_id = p.products_id and pd.language_id = '".(int)$_SESSION['languages_id']."'");
$product_info = vam_db_fetch_array($product_info_query);

include ('includes/header.php');

$breadcrumb->add(NAVBAR_TITLE_ASK, vam_href_link(FILENAME_ONE_CLICK_BUY, 'products_id='.$product->data['products_id'], 'SSL'));

$vamTemplate->assign('PRODUCTS_NAME', $product_info['products_name']);
$vamTemplate->assign('PRODUCTS_IMAGE', $product_info['products_image']);
$products_price = $vamPrice->GetPrice($product_info['products_id'], $format = true, 1, $product_info['products_tax_class_id'], $product_info['products_price'], 1);
$vamTemplate->assign('PRODUCTS_PRICE', $products_price['formated']);
$vamTemplate->assign('PRODUCTS_MODEL', $product_info['products_model']);
$vamTemplate->assign('PRODUCTS_MODEL', $product_info['products_model']);

$vamTemplate->assign('FORM_ACTION', vam_draw_form('one_click_buy', vam_href_link(FILENAME_ONE_CLICK_BUY, 'products_id='.$_GET['products_id'].'')).vam_draw_hidden_field('action', 'process').vam_draw_hidden_field('products_id', $_GET['products_id']));
        if (isset($_SESSION['customer_id'])) { 
		//-> registered user********************************************************
$vamTemplate->assign('INPUT_FIRSTNAME', $_SESSION['customer_first_name']);
$vamTemplate->assign('INPUT_LASTNAME', $_SESSION['customer_last_name']);
$vamTemplate->assign('INPUT_EMAIL', $_SESSION['customer_email_address']);
$vamTemplate->assign('INPUT_TELEPHONE', $_SESSION['customer_telephone']);
        }else{
		//-> guest *********************************************************  
$vamTemplate->assign('INPUT_FIRSTNAME', vam_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '' : ''))));
$vamTemplate->assign('INPUT_LASTNAME', vam_draw_input_fieldNote(array ('name' => 'lastname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement Requirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : ''))));
$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_fieldNote(array ('name' => 'email_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '' : ''))));
$vamTemplate->assign('INPUT_TELEPHONE', vam_draw_input_fieldNote(array ('name' => 'telephone', 'text' => '&nbsp;'. (vam_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement Requirement">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>' : ''))));
        }
$vamTemplate->assign('INPUT_TEXT', vam_draw_textarea_field('message_body', 'soft', 10, 3, stripslashes($_POST['message_body'])));
$vamTemplate->assign('FORM_END', '</form>');
$vamTemplate->assign('BUTTON_SUBMIT', vam_image_submit('submit.png',  IMAGE_BUTTON_CHECKOUT));
$vamTemplate->assign('BUTTON_CONTINUE', '<a class="button" href="javascript:window.close()">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');

	$vamTemplate->caching = 0;
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/one_click_buy.html');
}
include ('includes/application_bottom.php');
?>
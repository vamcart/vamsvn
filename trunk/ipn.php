<?php
/* -----------------------------------------------------------------------------------------
   $Id: paypal_ipn.php v1.0 998 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(paypal.php,v 1.39 2003/01/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (paypal.php,v 1.8 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (paypal.php,v 1.8 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require('includes/application_top.php');

$parameters = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
  	$parameters .= '&' . $key . '=' . urlencode(stripslashes($value));
}
  
if(MODULE_PAYMENT_PAYPAL_IPN_GATEWAY_SERVER == 'Live') {
	$server = 'www.paypal.com';
}else{
	$server = 'www.sandbox.paypal.com';
}

$fsocket = false;
$curl = false;
$result = false;

if ((PHP_VERSION >= 4.3) && ($fp = @fsockopen('ssl://' . $server, 443, $errno, $errstr, 30)))	{
  	$fsocket = true;
}
elseif (function_exists('curl_exec')) {
	$curl = true;
}
elseif ($fp = @fsockopen($server, 80, $errno, $errstr, 30)) {
    $fsocket = true;
}

if ($fsocket == true) {
    $header = 'POST /cgi-bin/webscr HTTP/1.0' . "\r\n" .
              'Host: ' . $server . "\r\n" .
              'Content-Type: application/x-www-form-urlencoded' . "\r\n" .
              'Content-Length: ' . strlen($parameters) . "\r\n" .
              'Connection: close' . "\r\n\r\n";

    @fputs($fp, $header . $parameters);

    $string = '';
    while (!@feof($fp)) {
      $res = @fgets($fp, 1024);
      $string .= $res;

      if (($res == 'VERIFIED') || ($res == 'INVALID')) {
        $result = $res;
        break;
      }
    }

    @fclose($fp);
}
elseif ($curl == true) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://' . $server . '/cgi-bin/webscr');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $result = curl_exec($ch);

    curl_close($ch);
}
  
if(isset($_POST['invoice']) && is_numeric($_POST['invoice']) && ($_POST['invoice'] > 0)) {
  	$order_query = vam_db_query("SELECT	currency, currency_value
  								 FROM " . TABLE_ORDERS . "
  								 WHERE orders_ident_key = '" . vam_db_prepare_input($_POST['invoice']) . "' 
								 AND customers_id = '" . (int)$_POST['custom'] . "'");
								 
	if(vam_db_num_rows($order_query) > 0) {
		$order = vam_db_fetch_array($order_query);
		$total_query = vam_db_query("SELECT value
									 FROM " . TABLE_ORDERS_TOTAL . " 
									 WHERE orders_ident_key = '" . vam_db_prepare_input($_POST['invoice']) . "' 
									 AND class = 'ot_total' limit 1");
		
		$total = vam_db_fetch_array($total_query);
		
		$comment_status = vam_db_prepare_input($_POST['payment_status']) . ' ' . vam_db_prepare_input($_POST['mc_gross']) . vam_db_prepare_input($_POST['mc_currency']) . '.';
		$comment_status .= ' ' . vam_db_prepare_input($_POST['first_name']) . ' ' . vam_db_prepare_input($_POST['last_name']) . ' ' . vam_db_prepare_input($_POST['payer_email']);
		
		if(isset($_POST['payer_status'])) {
			$comment_status .= ' is ' . vam_db_prepare_input($_POST['payer_status']);
		}
		
		$comment_status .= '.' . $crlf . $crlf . ' [';
		
		if(isset($_POST['test_ipn']) && is_numeric($_POST['test_ipn']) && ($_POST['test_ipn'] > 0)) {
			$debug = '(Sandbox-Test Mode) ';
		}
		
		$comment_status .= $crlf . 'Fee=' . vam_db_prepare_input($_POST['mc_fee']) . vam_db_prepare_input($_POST['mc_currency']);
		
		if(isset($_POST['pending_reason'])) {
			$comment_status .= $crlf . ' Pending Reason=' . vam_db_prepare_input($_POST['pending_reason']);
		}
		
		if(isset($_POST['reason_code'])) {
			$comment_status .= $crlf . ' Reason Code=' . vam_db_prepare_input($_POST['reason_code']);
		}
		
		$comment_status .= $crlf . ' Payment=' . vam_db_prepare_input($_POST['payment_type']);
		$comment_status .= $crlf . ' Date=' . vam_db_prepare_input($_POST['payment_date']);
		
		if(isset($_POST['parent_txn_id'])) {
			$comment_status .= $crlf . ' ParentID=' . vam_db_prepare_input($_POST['parent_txn_id']);
		}
		
		$comment_status .= $crlf . ' ID=' . vam_db_prepare_input($_POST['txn_id']);
		
		//Set status for default (Pending)
		$order_status_id = MODULE_PAYMENT_PAYPAL_IPN_PREPARE_ORDER_STATUS_ID;
		
		if($result == 'VERIFIED') {
			//Set status for Completed
			if(($_POST['payment_status'] == 'Completed') AND ($_POST['business'] == MODULE_PAYMENT_PAYPAL_IPN_ID) AND ($_POST['mc_gross'] == number_format($total['value'] * $order['currency_value'], $vamPrice->get_decimal_places($order['currency'])))) {
				if (MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID > 0) {
					$order_status_id = MODULE_PAYMENT_PAYPAL_IPN_ORDER_STATUS_ID;
				}
			}
			//Set status for Denied, Failed, Refunded or Reversed
			elseif(($_POST['payment_status'] == 'Denied') OR ($_POST['payment_status'] == 'Failed') OR ($_POST['payment_status'] == 'Refunded') OR ($_POST['payment_status'] == 'Reversed')) {
				$order_status_id = MODULE_PAYMENT_PAYPAL_IPN_DENIED_ORDER_STATUS_ID;
			} // if(($_POST['payment_status'] == 'Completed') AND ($_POST['business'] == MODULE_PAYMENT_PAYPAL_IPN_ID) AND ($_POST['mc_gross'] == number_format($total['value'] * $order['currency_value'], $currencies->get_decimal_places($order['currency'])))) elseif(($_POST['payment_status'] == 'Denied') OR ($_POST['payment_status'] == 'Failed') OR ($_POST['payment_status'] == 'Refunded') OR ($_POST['payment_status'] == 'Reversed'))
		}else{
			$debug .= '[INVALID VERIFIED FAILED] ';
			$order_status_id = MODULE_PAYMENT_PAYPAL_IPN_DENIED_ORDER_STATUS_ID;
			$error_reason = 'Received INVALID responce but invoice and Customer matched.' ;
		}
		
		$comment_status .= ']' ;
		
		vam_db_query("UPDATE " . TABLE_ORDERS . " 
					  SET orders_status = '" . $order_status_id . "', 
						  last_modified = now() 
					  WHERE orders_id = '" . vam_db_prepare_input($_POST['invoice']) . "'");
		
		$sql_data_array = array('orders_id' => vam_db_prepare_input($_POST['invoice']),
								'orders_status_id' => $order_status_id,
								'date_added' => 'now()',
								'customer_notified' => '0',
								'comments' => 'PayPal IPN ' . $debug . $comment_status . '');
		
		vam_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
	}else{
		$error_reason = 'No order found for invoice=' . vam_db_prepare_input($_POST['invoice']) . ' with customer=' . (int)$_POST['custom'] . '.' ;
	}
}else{
		$error_reason = 'No invoice id found on received data.' ;
}

if(vam_not_null(MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL) && strlen($error_reason)) {
	$email_body = $error_reason . "\n\n";
	$email_body .= $_SERVER["REQUEST_METHOD"] . " - " .$_SERVER["REMOTE_ADDR"] . " - " .$_SERVER["HTTP_REFERER"] . " - " .$_SERVER["HTTP_ACCEPT"] . "\n\n";
	$email_body .= '$_POST:' . "\n\n";

	foreach($_POST as $key => $value) {
		$email_body .= $key . '=' . $value . "\n";
	}
		
	$email_body .= "\n" . '$_GET:' . "\n\n";

	foreach ($_GET as $key => $value) {
		$email_body .= $key . '=' . $value . "\n";
	}

	vam_php_mail(
		EMAIL_BILLING_ADDRESS,
		EMAIL_BILLING_NAME,
		MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL,
		MODULE_PAYMENT_PAYPAL_IPN_DEBUG_EMAIL,
		'',
		EMAIL_BILLING_ADDRESS,
		EMAIL_BILLING_NAME,
		false,
		false,
		'PayPal IPN Invalid Process',
		$email_body,
		$email_body
	);
}
require('includes/application_bottom.php');
?>
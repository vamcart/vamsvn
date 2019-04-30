<?php
/*------------------------------------------------------------------------------
  $Id: webmoney.php 1310 2009-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
  -----------------------------------------------------------------------------
   based on:
   (c) 2005 Vetal (robox.php,v 1.48 2003/05/27); metashop.ru

  Released under the GNU General Public License
------------------------------------------------------------------------------*/

function get_var($name, $default = 'none') {
  return (isset($_GET[$name])) ? $_GET[$name] : ((isset($_POST[$name])) ? $_POST[$name] : $default);
}

require('includes/application_top.php');
require (DIR_WS_CLASSES.'order.php');
require_once (DIR_FS_INC.'vam_send_answer_template.inc.php');

// logging
//$fp = fopen('stripe.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_REQUEST as $vn=>$vv) {
//  $str.=$vn.'='.$vv.';';
//}

//fwrite($fp, $str."\n");
//fclose($fp);
// variables prepearing

$inv_id = $_POST['order_id'];

if ($_POST['order_id'] > 0) {
	
$order = new order($inv_id);

include_once(DIR_FS_CATALOG.'vendor/stripe/'.'init.php');

$stripe = array(
  'secret_key'      => MODULE_PAYMENT_STRIPE_SECRET_KEY,
  'publishable_key' => MODULE_PAYMENT_STRIPE_PUBLIC_KEY
);

		\Stripe\Stripe::setApiKey($stripe['secret_key']);

		  $token  = $_POST['stripeToken'];
		
		  $customer = \Stripe\Customer::create(array(
		      'email' => $order->customer['email_address'],
		      'card'  => $token
		  ));
		
		  $charge = \Stripe\Charge::create(array(
		      'customer' => $customer->id,
		      'amount'   => number_format($order->info['total'],0,'','')*100,
		      'currency' => $order->info['currency']
		  ));

		if (MODULE_PAYMENT_STRIPE_ORDER_STATUS_ID > 0) {

		  $sql_data_array = array('orders_status' => MODULE_PAYMENT_STRIPE_ORDER_STATUS_ID);
		  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");
		
		  $sql_data_arrax = array('orders_id' => $inv_id,
		                          'orders_status_id' => MODULE_PAYMENT_STRIPE_ORDER_STATUS_ID,
		                          'date_added' => 'now()',
		                          'customer_notified' => '0',
		                          'comments' => 'Stripe accepted this order payment');
		  vam_db_perform('orders_status_history', $sql_data_arrax);
		
		  //echo 'OK'.$inv_id;
  

		}

	vam_redirect(vam_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL'));

}

?>
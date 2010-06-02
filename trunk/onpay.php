<?php
/* -----------------------------------------------------------------------------------------
   $Id: onpay.php 998 2010/06/01 13:24:46 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2010 VaM Soft Ltd.
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(moneyorder.php,v 1.8 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (moneyorder.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (webmoney.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function get_var($name, $default = 'none') {
  return (isset($_GET[$name])) ? $_GET[$name] : ((isset($_POST[$name])) ? $_POST[$name] : $default);
}

require('includes/application_top.php');
require (DIR_WS_CLASSES.'order.php');

// logging
//$fp = fopen('1.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_REQUEST as $vn=>$vv) {
//  $str.=$vn.'='.$vv.';';
//}

//fwrite($fp, $str."\n");
//fclose($fp);

$order = new order($inv_id);


if (get_var('type') == 'check') {
   $md5 = strtoupper(md5('check'.';'.get_var('pay_for').';'.get_var('order_amount').';'.'RUR'.';'.'0'.';'.MODULE_PAYMENT_ONPAY_SECRET_KEY));
   $text = 'Payment Confirmed';
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<result>\n<code>0</code>\n<pay_for>".get_var('pay_for')."</pay_for>\n<comment>$text</comment>\n<md5>$md5</md5>\n</result>";
}

if (get_var('type') == 'pay') {

if (number_format(get_var('order_amount'),0) == number_format($order->info['total'],0)) {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_ONPAY_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".get_var('pay_for')."'");

  $sql_data_arrax = array('orders_id' => get_var('pay_for'),
                          'orders_status_id' => MODULE_PAYMENT_WEBMONEY_MERCHANT_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'OnPay.Ru accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);

}

   $md5 = strtoupper(md5('pay'.';'.get_var('pay_for').';'.';'.get_var('onpay_id').';'.';'.get_var('pay_for').';'.get_var('order_amount').';'.'RUR'.';'.'0'.';'.MODULE_PAYMENT_ONPAY_SECRET_KEY));
   $text = 'Payment Received';
	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<result>\n<code>0</code>\n <comment>$text</comment>\n<onpay_id>".get_var('onpay_id')."</onpay_id>\n <pay_for>".get_var('pay_for')."</pay_for>\n<order_id>".get_var('order_id')."</order_id>\n<md5>$md5</md5>\n</result>";

}

?>
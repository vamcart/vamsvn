<?php
/*------------------------------------------------------------------------------
  $Id: pay2pay.php 1400 2011-12-10 10:40:00 VaM $

   Pay2Pay - receiving payments on-line
   http://pay2pay.com

   Copyright (c) 2007 Pay2Pay
------------------------------------------------------------------------------*/

function get_var($name, $default = 'none') {
  return (isset($_GET[$name])) ? $_GET[$name] : ((isset($_POST[$name])) ? $_POST[$name] : $default);
}

require('includes/application_top.php');
require (DIR_WS_CLASSES.'order.php');
require_once (DIR_FS_INC.'vam_send_answer_template.inc.php');

// logging

//$fp = fopen('pay2pay.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_REQUEST as $vn=>$vv) {
//  $str.=$vn.'='.$vv.';';
//}

//fwrite($fp, $str."\n");
//fclose($fp);

// variables prepearing

$status = 'no';
$error = '';

$xml_decoded = base64_decode(str_replace(' ', '+', $_REQUEST['xml']));
$sign_decoded = base64_decode(str_replace(' ', '+', $_REQUEST['sign']));


$xml = simplexml_load_string($xml_decoded);

$hidden_key = ''; //TODO 
// checking and handling
if ($xml->order_id > 0)
{
  $order = new order($xml->order_id);
  $key = MODULE_PAYMENT_PAY2PAY_HIDDEN_KEY;
  $currency = $xml->currency;
  if ($currency == 'RUB')
    $currency = "RUR";
  if (md5($key.$xml_decoded.$key) != $sign_decoded) 
    $error = 'Security check failed';
  elseif (floatval($xml->amount) != floatval($order->info['total_value'])) 
    $error = "Incorrect amount";
  else if ($currency != $order->info['currency']) 
    $error = "Incorrect currency";
}
else
  $error = 'Invalid order ID';
  
if ($error == '')
{  
  $ret = false;
  if ($xml->status == 'success')
  { 
    $sql_data_array = array('orders_status' => MODULE_PAYMENT_PAY2PAY_ORDER_STATUS_ID);
    vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$xml->order_id."'");
  
    $sql_data_arrax = array('orders_id' => $xml->order_id,
                            'orders_status_id' => MODULE_PAYMENT_PAY2PAY_ORDER_STATUS_ID,
                            'date_added' => 'now()',
                            'customer_notified' => '0',
                            'comments' => 'Pay2Pay accepted this order payment');
    vam_db_perform('orders_status_history', $sql_data_arrax);
    $ret = true;
    
	//Send answer template
	vam_send_answer_template($xml->order_id,MODULE_PAYMENT_PAY2PAY_ORDER_STATUS_ID,'on','on');
    
  }
  if ($ret === true)
    $status = "yes";
  else
    $error = "Unknown error";
}

echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>".
     "<response>".
     "<status>".$status."</status>".
     "<err_msg>".$error."</err_msg>".
     "</response>";
?>
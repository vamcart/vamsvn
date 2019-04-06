<?php
/*------------------------------------------------------------------------------
   $Id: paymaster.php 998 2012/09/16 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2012 VamShop
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
//$fp = fopen('paymaster.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_REQUEST as $vn=>$vv) {
  //$str.=$vn.'='.$vv.';';
//}

//fwrite($fp, $str."\n");
//fclose($fp);

// variables prepearing
$crc = get_var('LMI_HASH');

$inv_id = get_var('LMI_PAYMENT_NO');
$order = new order($inv_id);
$order_sum = $order->info['total_value'];

$hash = base64_encode(hash('sha1', $_POST["LMI_MERCHANT_ID"] . ";" . $_POST["LMI_PAYMENT_NO"] . ";" . $_POST["LMI_SYS_PAYMENT_ID"] . ";" . $_POST["LMI_SYS_PAYMENT_DATE"] . ";" . $_POST["LMI_PAYMENT_AMOUNT"] . ";" . $_POST["LMI_CURRENCY"] . ";" . $_POST["LMI_PAID_AMOUNT"] . ";" . $_POST["LMI_PAID_CURRENCY"] . ";" . $_POST["LMI_PAYMENT_SYSTEM"] . ";" . $_POST["LMI_SIM_MODE"] . ";" . MODULE_PAYMENT_PAYMASTER_SECRET_KEY, TRUE));

// checking and handling

        //if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if ($_POST["LMI_PREREQUEST"] == "1" || $_POST["LMI_PREREQUEST"] == "2") {
                echo "YES";
                die;
            } else {

//if ($hash == $crc) {
if (number_format($_POST['LMI_PAYMENT_AMOUNT'],0) == number_format($order->info['total_value'],0)) {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_PAYMASTER_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

  $sql_data_arrax = array('orders_id' => $inv_id,
                          'orders_status_id' => MODULE_PAYMENT_PAYMASTER_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'PayMaster accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);

  echo 'OK'.$inv_id;
  
	//Send answer template
	vam_send_answer_template($inv_id,MODULE_PAYMENT_PAYMASTER_ORDER_STATUS_ID,'on','on');
  
}
//}

}
//}

?>
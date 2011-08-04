<?php
/*------------------------------------------------------------------------------
  $Id: aviso.php 1310 2009-02-06 19:20:03 VaM $

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

include_once DIR_WS_INCLUDES . 'external/avisosms/avisosmsmc.class.php';

$access_key     = MODULE_PAYMENT_AVISO_ACCESS_KEY;
$m_commerce = new AvisosmsMCommerce(NULL, $access_key, NULL);

if ($m_commerce->updateOrderStatus())
{
    // Данные получены, проверка access_key пройдена
    // Можно обрабатывать полученные данные
    $response = $m_commerce->response();
    var_dump($response);
    
    // logging
$fp = fopen('1.log', 'a+');
$str=date('Y-m-d H:i:s').' - ';
foreach ($_REQUEST as $vn=>$vv) {
  $str.=$vn.'='.$vv.';';
}

  $str.='test'.var_dump($response);
fwrite($fp, $str."\n");
fclose($fp);

}
else
{
    // Переданные данные не верны.
    echo 'Ошибка: '.$m_commerce->error_message();
}

// variables prepearing
$crc = get_var('LMI_HASH');

$inv_id = get_var('LMI_PAYMENT_NO');
$order = new order($inv_id);
$order_sum = $order->info['total'];

$hash = strtoupper(md5($_POST['LMI_PAYEE_PURSE'].$_POST['LMI_PAYMENT_AMOUNT'].$_POST['LMI_PAYMENT_NO'].$_POST['LMI_MODE']. 
$_POST['LMI_SYS_INVS_NO'].$_POST['LMI_SYS_TRANS_NO'].$_POST['LMI_SYS_TRANS_DATE'].MODULE_PAYMENT_AVISO_SECRET_KEY. 
$_POST['LMI_PAYER_PURSE'].$_POST['LMI_PAYER_WM'])); 

// checking and handling
if ($hash == $crc) {
if (number_format($_POST['LMI_PAYMENT_AMOUNT'],0) == number_format($order->info['total'],0)) {
  $sql_data_array = array('orders_status' => MODULE_PAYMENT_AVISO_ORDER_STATUS_ID);
  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

  $sql_data_arrax = array('orders_id' => $inv_id,
                          'orders_status_id' => MODULE_PAYMENT_AVISO_ORDER_STATUS_ID,
                          'date_added' => 'now()',
                          'customer_notified' => '0',
                          'comments' => 'WebMoney accepted this order payment');
  vam_db_perform('orders_status_history', $sql_data_arrax);

  echo 'OK'.$inv_id;
}
}

?>
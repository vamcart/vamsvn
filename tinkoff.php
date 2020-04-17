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
//$fp = fopen('webmoney.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_REQUEST as $vn=>$vv) {
//  $str.=$vn.'='.$vv.';';
//}

//fwrite($fp, $str."\n");
//fclose($fp);
// variables prepearing

        $flow = json_decode(file_get_contents("php://input"));
        $flow->Success = $flow->Success ? 'true' : 'false';
        foreach ($flow as $key => $item) {
            $request[$key] = $item;
        }

        $tinkoffSecretKey = MODULE_PAYMENT_TINKOFF_PASSWORD;

        $orderId = intval($request['OrderId']);
        $order = new order($orderId);
        $merchantSumm = $request['Amount'];
        $orderSumm = number_format($order->info['total'],0);

        if (!$order) {
            exit('NOTOK');
        }

        if (get_tinkoff_token($request, $tinkoffSecretKey) == $request['Token']) {
            $status = MODULE_PAYMENT_TINKOFF_ORDER_STATUS_ID;

            if ($request['Status'] == 'CONFIRMED') {
                $status = MODULE_PAYMENT_TINKOFF_ORDER_STATUS_ID;
            }

            if ($request['Status'] == 'REFUNDED') {
                $status = 4;
            }

            if ($request['Status'] == 'REJECTED') {
                $status = 3;
            }

				  $sql_data_array = array('orders_status' => $status);
				  vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$orderId."'");
				
				  $sql_data_arrax = array('orders_id' => $inv_id,
				                          'orders_status_id' => MODULE_PAYMENT_TINKOFF_ORDER_STATUS_ID,
				                          'date_added' => 'now()',
				                          'customer_notified' => '0',
				                          'comments' => 'Tinkoff accepted this order payment');
				  vam_db_perform('orders_status_history', $sql_data_arrax);

            exit('OK');
        } else {
            exit('NOTOK');
        }

    function get_tinkoff_token($request, $tinkoffSecretKey)
    {
        $request['Password'] = $tinkoffSecretKey;
        ksort($request);
        unset($request['Token']);
        $values = implode('', array_values($request));
        return hash('sha256', $values);
    }
?>
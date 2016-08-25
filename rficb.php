<?php
/*mainpay payment module
 *transaction result handler
 */
//if ($_SERVER["REQUEST_METHOD"] == "POST"){

    require('includes/application_top.php');
    require (DIR_WS_CLASSES.'order.php');

    $crc = $_POST['check'];
    //if($_POST['comment']) $inv_id = $_POST['comment'];
    //else 
    $inv_id = $_POST['order_id'];
    $order = new order($inv_id);
    $order_sum = $order->info['total'];
    $data = array(
        'tid' => $_POST['tid'],
        'name' => $_POST['name'],
        'comment' => $_POST['comment'],
        'partner_id' => $_POST['partner_id'],
        'service_id' => $_POST['service_id'],
        'order_id' => $_POST['order_id'],
        'type' => $_POST['type'],
        'partner_income' => $_POST['partner_income'],
        'system_income' => $_POST['system_income'],
        'test' => $_POST['test'],
    );

    $check = md5(join('', array_values($data)) . MODULE_PAYMENT_RFICB_SECRET_KEY);
    // checking and handling
    if ($check == $crc) {
        if ($_POST['system_income'] >= $order_sum) {
        echo 'ok';
            $sql_data_array = array('orders_status' => MODULE_PAYMENT_RFICB_ORDER_STATUS_ID);
            vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$inv_id."'");

            $sql_data_arrax = array('orders_id' => $inv_id,
                                  'orders_status_id' => MODULE_PAYMENT_RFICB_ORDER_STATUS_ID,
                                  'date_added' => 'now()',
                                  'customer_notified' => '0',
                                  'comments' => 'rficb accepted this order payment');
            vam_db_perform('orders_status_history', $sql_data_arrax);
        }
    }
//}
?>
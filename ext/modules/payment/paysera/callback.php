<?php

chdir('../../../../');
require_once 'includes/application_top.php';
require_once 'includes/modules/payment/paysera/WebToPay.php';

$ip_address = vam_get_ip_address();

try {
    $response = WebToPay::checkResponse($_REQUEST, array(
        'projectid'     => MODULE_PAYMENT_PAYSERA_PROJECT,
        'sign_password' => MODULE_PAYMENT_PAYSERA_SIGNATURE,
    ));

    if ($response['status'] == 1) {
        $order_query = vam_db_query('
                SELECT `orders_status`, `currency`, `currency_value`
                FROM ' . TABLE_ORDERS . '
                WHERE
                    `orders_id` = ' . intval($response['orderid'])
        );

        if (vam_db_num_rows($order_query) <= 0) {
            throw new WebToPayException('Order not found!');
        }

        $order = vam_db_fetch_array($order_query);

        if ($order['currency'] != $response['currency']) {
            throw new WebToPayException('Bad currency!');
        }

        $total_query = vam_db_query('
                    SELECT `value`
                    FROM ' . TABLE_ORDERS_TOTAL . '
                    WHERE
                        `orders_id` = ' . intval($response['orderid']) . '
                        AND `class` = "ot_total"
                        LIMIT 1'
        );

        $total = vam_db_fetch_array($total_query);


        if (intval(number_format($total['value'], 2, '', '')) > ($response['amount'])) {
            throw new WebToPayException('Bad amount!');
        }

        $sql_data_array                      = array();
        $sql_data_array['orders_id']         = $response['orderid'];
        $sql_data_array['date_added']        = 'now()';
        $sql_data_array['customer_notified'] = '0';
        $sql_data_array['comments']          = print_r($_REQUEST, true);

        $sql_data_array['orders_status_id'] = MODULE_PAYMENT_PAYSERA_ORDER_STATUS_ID;
        vam_db_query('
				UPDATE ' . TABLE_ORDERS . '
				SET
					`orders_status` = ' . intval(MODULE_PAYMENT_PAYSERA_ORDER_STATUS_ID) . ',
					`last_modified` = NOW()
				WHERE
					`orders_id` = ' . intval($response['orderid'])
        );

        vam_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);

        echo 'OK';

    }

} catch (Exception $e) {
    echo get_class($e) . ': ' . $e->getMessage();
}



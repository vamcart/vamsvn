<?php
/*
  $Id: reviews.php 1739 2007-12-20 00:52:16Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

//  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_REVIEWS);

//  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_REVIEWS));
?>
<?php
//require_once(DIR_WS_INCLUDES . 'modules/payment/estonia_seb.php');
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment('estonia_swed');

		$p = $GLOBALS['estonia_swed'];
		$result = $p->validatePayment($_REQUEST);


    	if ($result['payment'] == 'cancelled') {
    		//delete the order, redirect
    		$orderId = $result['orderNr'];
			vam_remove_order($orderId, 'on');
			vam_redirect(vam_href_link(FILENAME_CHECKOUT_CONFIRMATION, 'error_message=' . MODULE_PAYMENT_SWED_ERROR_ALL_FIELDS_REQUIRED, 'SSL'));
    	} else if ($result['payment'] == 'success') {
    		//mark the order payd
    		$orderId = $result['orderNr'];
            if ($orderId) {
            	if ($result['auto']) {
		    		if ($result['status'] > 0) {
						$myRes = vam_db_query("update " . TABLE_ORDERS . " set orders_status = '" . $result['status'] . "', last_modified = now() where orders_id = '" . (int)$orderId . "' and orders_status <> '" . $result['status'] . "'");
						if (mysqli_affected_rows() > 0) {
							//confirmation stuff
							$orders_statuses = array();
							$orders_status_array = array();
							$orders_status_query = vam_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . (int)$languages_id . "'");
							while ($orders_status = vam_db_fetch_array($orders_status_query)) {
								$orders_statuses[] = array('id' => $orders_status['orders_status_id'],
								'text' => $orders_status['orders_status_name']);
								$orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
							}
							$check_status_query = vam_db_query("select customers_name, customers_email_address, orders_status, date_purchased from " . TABLE_ORDERS . " where orders_id = '" . (int)$orderId . "'");
							$check_status = vam_db_fetch_array($check_status_query);
							$customer_notified = '0';
							$notify_comments = '';
							$notify_comments = sprintf(SWED_EMAIL_TEXT_COMMENTS_UPDATE, SWED_EMAIL_TEXT_PAYMENT_SUCCESS) . "\n\n";
				            $email = STORE_NAME . "\n" . SWED_EMAIL_SEPARATOR . "\n" . SWED_EMAIL_TEXT_ORDER_NUMBER . ' ' . $orderId . "\n" . SWED_EMAIL_TEXT_INVOICE_URL . ' ' . vam_href_link('account_history_info.php', 'order_id=' . $orderId, 'SSL') . "\n" . SWED_EMAIL_TEXT_DATE_ORDERED . ' ' . vam_date_long($check_status['date_purchased']) . "\n\n" . $notify_comments . sprintf(SWED_EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$result['status']]);

							vam_mail($check_status['customers_name'], $check_status['customers_email_address'], SWED_EMAIL_TEXT_SUBJECT, $email, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

							$customer_notified = '1';

							vam_db_query("insert into " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('" . (int)$orderId . "', '" . $result['status'] . "', now(), '" . 1 . "', '" . vam_db_input($notify_comments)  . "')");
						}
    				}
    				//set the notification
            	} else {
            		//do nothing
            		$cart->reset(true);
					// unregister session variables used during checkout
					vam_session_unregister('sendto');
					vam_session_unregister('billto');
					vam_session_unregister('shipping');
					vam_session_unregister('payment');
					vam_session_unregister('comments');
					vam_redirect(vam_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL'));
            	}
            }
    		//redirect
    	} else {
			//finally redirect to index
			vam_redirect(vam_href_link(FILENAME_DEFAULT, '', 'SSL'));
    	}


	/**
	debug function, html formatted
	*/
	function d($var, $echo = true) {
		$r = '<pre>';
		$r .= htmlspecialchars(print_r($var, true));
		$r .= '</pre>';
		if ($echo) {
			 echo $r;
		}
		return $r;
	}
  function vam_remove_order($order_id, $restock = false) {
    if ($restock == 'on') {
      $order_query = vam_db_query("select products_id, products_quantity from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$order_id . "'");
      while ($order = vam_db_fetch_array($order_query)) {
        vam_db_query("update " . TABLE_PRODUCTS . " set products_quantity = products_quantity + " . $order['products_quantity'] . ", products_ordered = products_ordered - " . $order['products_quantity'] . " where products_id = '" . (int)$order['products_id'] . "'");
      }
    }

    vam_db_query("delete from " . TABLE_ORDERS . " where orders_id = '" . (int)$order_id . "'");
    vam_db_query("delete from " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int)$order_id . "'");
    vam_db_query("delete from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . (int)$order_id . "'");
    vam_db_query("delete from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_id = '" . (int)$order_id . "'");
    vam_db_query("delete from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "'");
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

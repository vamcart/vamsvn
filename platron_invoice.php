<?php
/*
	Platron payment module
*/

require ('includes/application_top.php');
require_once(DIR_WS_CLASSES . 'order.php');
require_once('includes/modules/payment/platron/PG_Signature.php');

$arrRequest = array();
if(!empty($_POST)) 
	$arrRequest = $_POST;
else
	$arrRequest = $_GET;

$thisScriptName = PG_Signature::getOurScriptName();
if (empty($arrRequest['pg_sig']) || !PG_Signature::check($arrRequest['pg_sig'], $thisScriptName, $arrRequest, MODULE_PAYMENT_PLATRON_SECRET_KEY))
	die("Wrong signature");
	
$arrStatuses = vam_get_orders_status();
$order = new order($arrRequest['pg_order_id']);
$arrCheckStatuses = array(
	array_search(MODULE_PAYMENT_PLATRON_ORDER_STATUS_PENDING_ID, $arrStatuses)
);
$arrOkStatuses = array(
	array_search(MODULE_PAYMENT_PLATRON_ORDER_STATUS_PENDING_ID, $arrStatuses), 
	array_search(MODULE_PAYMENT_PLATRON_ORDER_STATUS_OK_ID, $arrStatuses)
);

$arrFailedStatuses = array(
	array_search(MODULE_PAYMENT_PLATRON_ORDER_STATUS_PENDING_ID, $arrStatuses), 
	array_search(MODULE_PAYMENT_PLATRON_ORDER_STATUS_FAILED_ID, $arrStatuses)
);

if(!isset($arrRequest['pg_result'])){
	$bCheckResult = 0;
	if(empty($order) || !in_array( $order->info['orders_status'], $arrCheckStatuses))
		$error_desc = "Товар не доступен. Либо заказа нет, либо его статус " . $order->info['orders_status'];	
	elseif($arrRequest['pg_amount'] != number_format($order->info['total_value'], 2, '.', ''))
		$error_desc = "Неверная сумма";
	else
		$bCheckResult = 1;
	
	$arrResponse['pg_salt']              = $arrRequest['pg_salt']; // в ответе необходимо указывать тот же pg_salt, что и в запросе
	$arrResponse['pg_status']            = $bCheckResult ? 'ok' : 'error';
	$arrResponse['pg_error_description'] = $bCheckResult ?  ""  : $error_desc;
	$arrResponse['pg_sig']				 = PG_Signature::make($thisScriptName, $arrResponse, MODULE_PAYMENT_PLATRON_SECRET_KEY);

	$objResponse = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><response/>');
	$objResponse->addChild('pg_salt', $arrResponse['pg_salt']);
	$objResponse->addChild('pg_status', $arrResponse['pg_status']);
	$objResponse->addChild('pg_error_description', $arrResponse['pg_error_description']);
	$objResponse->addChild('pg_sig', $arrResponse['pg_sig']);

}
else{
	$bResult = 0;
	if(empty($order) || ($arrRequest['pg_result'] == 1 && !in_array( $order->info['orders_status'], $arrOkStatuses)) || 
			($arrRequest['pg_result'] == 0 && !in_array( $order->info['orders_status'], $arrFailedStatuses)))
		$strResponseDescription = "Товар не доступен. Либо заказа нет, либо его статус " . $order->info['orders_status'];		
	elseif($arrRequest['pg_amount'] != number_format($order->info['total_value'], 2, '.', ''))
		$strResponseDescription = "Неверная сумма";
	else {
		$bResult = 1;
		$strResponseStatus = 'ok';
		$strResponseDescription = "Запрос принял";
		if ($arrRequest['pg_result'] == 1)
			$nStatusId = MODULE_PAYMENT_PLATRON_ORDER_STATUS_OK_ID;
		else
			$nStatusId = MODULE_PAYMENT_PLATRON_ORDER_STATUS_FAILED_ID;

		$sql_data_array = array('orders_status' => $nStatusId);
		vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".$arrRequest['pg_order_id']."'");
		$sql_data_array = array(
			'orders_id' => $arrRequest['pg_order_id'],
			'orders_status_id' => $nStatusId,
			'date_added' => 'now()',
			'customer_notified' => '0',
			'comments' => 'Platron set new status'
		);
		vam_db_perform(TABLE_ORDERS_STATUS_HISTORY, $sql_data_array);
	}
	if(!$bResult)
		if($arrRequest['pg_can_reject'] == 1)
			$strResponseStatus = 'rejected';
		else
			$strResponseStatus = 'error';
	
	$objResponse = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><response/>');
	$objResponse->addChild('pg_salt', $arrRequest['pg_salt']); // в ответе необходимо указывать тот же pg_salt, что и в запросе
	$objResponse->addChild('pg_status', $strResponseStatus);
	$objResponse->addChild('pg_description', $strResponseDescription);
	$objResponse->addChild('pg_sig', PG_Signature::makeXML($thisScriptName, $objResponse, MODULE_PAYMENT_PLATRON_SECRET_KEY));
}

header("Content-type: text/xml");
echo $objResponse->asXML();
die();


function vam_get_orders_status() {

	$orders_status_array = array ();
	$orders_status_query = vam_db_query("select orders_status_id, orders_status_name from ".TABLE_ORDERS_STATUS." where language_id = '".$_SESSION['languages_id']."' order by orders_status_id");
	while ($orders_status = vam_db_fetch_array($orders_status_query)) {
		$orders_status_array[$orders_status['orders_status_name']] = $orders_status['orders_status_id'];
	}

	return $orders_status_array;
}
?>

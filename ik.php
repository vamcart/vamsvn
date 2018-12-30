<?php
/*------------------------------------------------------------------------------
  $Id: ik.php 1310 2010-05-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2010 VaM Shop
  -----------------------------------------------------------------------------
   based on:
   (c) 2005 Vetal (robox.php,v 1.48 2003/05/27); metashop.ru

  Released under the GNU General Public License
------------------------------------------------------------------------------*/
$txt_mail = '';
function get_var($name, $default = 'none') {
  return (isset($_GET[$name])) ? $_GET[$name] : ((isset($_POST[$name])) ? $_POST[$name] : $default);
}

require('includes/application_top.php');
require (DIR_WS_CLASSES.'order.php');
require_once (DIR_FS_INC.'vam_send_answer_template.inc.php');

function ikGetSign($post)
{
	$aParams = array();
	foreach ($post as $key => $value)
	{
		if (!preg_match('/ik_/', $key))
			continue;
		$aParams[$key] = $value;
	}

	unset($aParams['ik_sign']);

		$key = MODULE_PAYMENT_IK_SECRET_KEY;

	ksort ($aParams, SORT_STRING);
	array_push($aParams, $key);
	$signString = implode(':', $aParams);
	$sign = base64_encode(md5($signString, true));
	return $sign;
}

// logging

$sign = ikGetSign($_POST);

extract($_POST);

// Проверка id магазина
if(MODULE_PAYMENT_IK_SHOP_ID !== $ik_co_id)
	die('error: ik_co_id');


$txt_mail .= '$sig = '.$ik_sign .'    $sign = '. $sign .'    $ik_inv_st = '. $ik_inv_st;


//$fp = fopen('ik.log', 'a+');
//$str=date('Y-m-d H:i:s').' - ';
//foreach ($_POST as $vn=>$vv) {
  //$str.=$vn.'='.$vv.';';
//}

// данные заказа
$order = new order((int)$ik_pm_no);
$ikCurrency = (MODULE_PAYMENT_IK_CURRENCY == 'RUB') ? 'RUR' : MODULE_PAYMENT_IK_CURRENCY;

global $vamPrice;
$orderTotal = number_format($order->info['total_value'], 2, '.', '');
$ik_am = number_format($ik_am, 2, '.', '');

//$str.= 'ot='.$orderTotal.' $order->info[total_value]='.$order->info['total_value'] .'; $ikCurrency'. $ikCurrency.' $ik_pm_no='.$ik_pm_no.' $orderTotal2='.$orderTotal2;


//fwrite($fp, $str."\n");
//fclose($fp);

if ($ik_sign === $sign && $ik_inv_st == 'success')
{
	
	// Проверяем стоимость
	//$txt_mail .= '$ik_am = '.$ik_am.' $orderTotal = '.$orderTotal;

	
	if($ik_am != $orderTotal OR $ik_am <= 0)
		die("error: ik_am");

	$sql_data_array = array
	(
		'orders_status' => MODULE_PAYMENT_IK_ORDER_STATUS_ID
	);
	vam_db_perform('orders', $sql_data_array, 'update', "orders_id='".(int)$ik_pm_no."'");

	$sql_data_arrax = array
	(
		'orders_id' => (int)$ik_pm_no,
		'orders_status_id' => MODULE_PAYMENT_IK_ORDER_STATUS_ID,
		'date_added' => 'now()',
		'customer_notified' => '0',
		'comments' => 'InterKassa accepted this order payment '.vam_db_prepare_input($ik_pw_via)
	);
	vam_db_perform('orders_status_history', $sql_data_arrax);

	echo 'OK'.$ik_pm_no;
	
	//Send answer template
	vam_send_answer_template($ik_pm_no,MODULE_PAYMENT_IK_ORDER_STATUS_ID,'on','on');
	
}
else{

	die('error: ik_sign or ik_inv_st');
	}
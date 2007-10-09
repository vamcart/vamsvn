<?php
/* -----------------------------------------------------------------------------------------
   $Id: print_packingslip.php 899 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (print_order.php,v 1.1 2003/08/19); www.nextcommerce.org
   (c) 2004	 xt:Commerce (print_packingslip.php,v 1.1 2003/08/19); xt-commerce.com
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  require('includes/application_top.php');
  // include needed functions
  require_once(DIR_FS_INC .'vam_get_order_data.inc.php');
  require_once(DIR_FS_INC .'vam_get_attributes_model.inc.php');
  require_once(DIR_FS_INC .'vam_not_null.inc.php');
  require_once(DIR_FS_INC .'vam_format_price_order.inc.php');
  
  $vamTemplate = new vamTemplate;

  $order_query_check = vam_db_query("SELECT
  					customers_id
  					FROM ".TABLE_ORDERS."
  					WHERE orders_id='".$_GET['oID']."'");
  					
  $order_check = vam_db_fetch_array($order_query_check);
 // if ($_SESSION['customer_id'] == $order_check['customers_id'])
  //	{
  	// get order data
 	
  	include(DIR_WS_CLASSES . 'order.php');
  	$order = new order($_GET['oID']);
  	$vamTemplate->assign('address_label_customer',vam_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'));
  	$vamTemplate->assign('address_label_shipping',vam_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br />'));
  	$vamTemplate->assign('address_label_payment',vam_address_format($order->billing['format_id'], $order->billing, 1, '', '<br />'));
  	$vamTemplate->assign('phone',$order->customer['telephone']);
  	$vamTemplate->assign('email',$order->customer['email_address']);
  	$vamTemplate->assign('csID',$order->customer['csID']);
  	// get products data
        $order_query=vam_db_query("SELECT
        				products_id,
        				orders_products_id,
        				products_model,
        				products_name,
        				final_price,
        				products_quantity
        				FROM ".TABLE_ORDERS_PRODUCTS."
        				WHERE orders_id='".$_GET['oID']."'");
        $order_data=array();
        while ($order_data_values = vam_db_fetch_array($order_query)) {
        	$attributes_query=vam_db_query("SELECT
        				products_options,
        				products_options_values,
        				price_prefix,
        				options_values_price
        				FROM ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES."
        				WHERE orders_products_id='".$order_data_values['orders_products_id']."'");
        	$attributes_data='';
        	$attributes_model='';
        	while ($attributes_data_values = vam_db_fetch_array($attributes_query)) {
        	$attributes_data .='<br />'.$attributes_data_values['products_options'].':'.$attributes_data_values['products_options_values'];	
        	$attributes_model .='<br />'.vam_get_attributes_model($order_data_values['products_id'],$attributes_data_values['products_options_values'],$attributes_data_values['products_options']);
        	}
        $order_data[]=array(
        		'PRODUCTS_MODEL' => $order_data_values['products_model'],
        		'PRODUCTS_NAME' => $order_data_values['products_name'],
        		'PRODUCTS_ATTRIBUTES' => $attributes_data,
        		'PRODUCTS_ATTRIBUTES_MODEL' => $attributes_model,
        		'PRODUCTS_PRICE' =>  vam_format_price_order($order_data_values['final_price'],1,$order->info['currency']),
        		'PRODUCTS_QTY' => $order_data_values['products_quantity']);
        }
  	// get order_total data
      $oder_total_query=vam_db_query("SELECT
                      title,
                      text,
                      class,
                      value,
                      sort_order
                      FROM ".TABLE_ORDERS_TOTAL."
                      WHERE orders_id='".$_GET['oID']."'
                      ORDER BY sort_order ASC");

      $order_total=array();
      while ($oder_total_values = vam_db_fetch_array($oder_total_query)) {

      $order_total[]=array(
              'TITLE' => $oder_total_values['title'],
              'CLASS'=> $oder_total_values['class'],
              'VALUE'=> $oder_total_values['value'],
              'TEXT' => $oder_total_values['text']);
    if ($oder_total_values['class']='ot_total') $total=$oder_total_values['value'];
      }

      // assign language to template for caching
      $vamTemplate->assign('language', $_SESSION['language']);
	 $vamTemplate->assign('charset', $_SESSION['language_charset']);
    $vamTemplate->assign('logo_path',HTTP_SERVER  . DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
    $vamTemplate->assign('oID',$_GET['oID']);
    if ($order->info['payment_method']!='' && $order->info['payment_method']!='no_payment') {
    include(DIR_FS_CATALOG.'lang/'.$_SESSION['language'].'/modules/payment/'.$order->info['payment_method'].'.php');
     $payment_method=constant(strtoupper('MODULE_PAYMENT_'.$order->info['payment_method'].'_TEXT_TITLE'));
      $vamTemplate->assign('PAYMENT_METHOD',$payment_method);
    }

if ($order->info['shipping_class'] != '') {
      $shipping_method_query = vam_db_query("select title from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_GET['oID'] . "' and class = 'ot_shipping'");
      $shipping_method = vam_db_fetch_array($shipping_method_query);

  $order_shipping_text = ((substr($shipping_method['title'], -1) == ':') ? substr(strip_tags($shipping_method['title']), 0, -1) : strip_tags($shipping_method['title']));

  	$vamTemplate->assign('SHIPPING_METHOD',$order_shipping_text);
}    

      $vamTemplate->assign('DATE',vam_date_long($order->info['date_purchased']));
      $vamTemplate->assign('order_data', $order_data);
      $vamTemplate->assign('order_total', $order_total);

  	// dont allow cache
  	$vamTemplate->caching = false;
  	
	$vamTemplate->template_dir=DIR_FS_CATALOG.'templates';
	$vamTemplate->compile_dir=DIR_FS_CATALOG.'templates_c';
	$vamTemplate->config_dir=DIR_FS_CATALOG.'lang';
	
  	$vamTemplate->display(CURRENT_TEMPLATE . '/admin/print_packingslip.html');	
//	} else {
  	
//  	$vamTemplate->display(CURRENT_TEMPLATE . '/error_message.html');
//	}

?>
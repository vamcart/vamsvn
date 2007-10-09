<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_order_data.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (vam_get_order_data.inc.php,v 1.1 2003/08/15); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_order_data.inc.php,v 1.1 2004/08/25); xt-commerce.com
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

function vam_get_order_data($order_id) {
$order_query = vam_db_query("SELECT
  customers_name,
  customers_company,
  customers_street_address,
  customers_suburb,
  customers_city,
  customers_postcode,
  customers_state,
  customers_country,
  customers_telephone,
  customers_email_address,
  customers_address_format_id,
  delivery_name,
  delivery_company,
  delivery_street_address,
  delivery_suburb,
  delivery_city,
  delivery_postcode,
  delivery_state,
  delivery_country,
  delivery_address_format_id,
  billing_name,
  billing_company,
  billing_street_address,
  billing_suburb,
  billing_city,
  billing_postcode,
  billing_state,
  billing_country,
  billing_address_format_id,
  payment_method,
  comments,
  date_purchased,
  orders_status,
  currency,
  currency_value
  					FROM ".TABLE_ORDERS."
  					WHERE orders_id='".$_GET['oID']."'");
  					
  $order_data= vam_db_fetch_array($order_query);
  // get order status name	
 $order_status_query=vam_db_query("SELECT
 				orders_status_name
 				FROM ".TABLE_ORDERS_STATUS."
 				WHERE orders_status_id='".$order_data['orders_status']."'
 				AND language_id='".$_SESSION['languages_id']."'");
 $order_status_data=vam_db_fetch_array($order_status_query); 			
 $order_data['orders_status']=$order_status_data['orders_status_name'];
 // get language name for payment method
 include(DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/payment/'.$order_data['payment_method'].'.php');
 $order_data['payment_method']=constant(strtoupper('MODULE_PAYMENT_'.$order_data['payment_method'].'_TEXT_TITLE'));	
  return $order_data; 
}


?>
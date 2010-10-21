<?php
/* --------------------------------------------------------------
   $Id: orders_edit.php,v 1.1 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders.php,v 1.27 2003/02/16); www.oscommerce.com
   (c) 2003	 nextcommerce (orders.php,v 1.7 2003/08/14); www.nextcommerce.org
   (c) 2004	 xt:Commerce (orders_edit.php,v 1.19 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 

   To do: Rabatte berГјcksichtigen
   --------------------------------------------------------------*/

// BenГ¶tigte Funktionen und Klassen Anfang:
require ('includes/application_top.php');

require (DIR_WS_CLASSES.'order.php');
if (!$_GET['oID'])
	$_GET['oID'] = $_POST['oID'];
$order = new order($_GET['oID']);

require (DIR_FS_CATALOG.DIR_WS_CLASSES.'vam_price.php');
$vamPrice = new vamPrice($order->info['currency'], $order->info['status'],$order->customer['ID']);

require_once (DIR_FS_INC.'vam_get_tax_class_id.inc.php');
require_once (DIR_FS_INC.'vam_get_tax_rate.inc.php');

require_once (DIR_FS_INC.'vam_oe_get_options_name.inc.php');
require_once (DIR_FS_INC.'vam_oe_get_options_values_name.inc.php');
require_once (DIR_FS_INC.'vam_oe_customer_infos.inc.php');
// BenпїЅtigte Funktionen und Klassen Ende

// Adressbearbeitung Anfang
if ($_GET['action'] == "address_edit") {

	$lang_query = vam_db_query("select languages_id from ".TABLE_LANGUAGES." where directory = '".$order->info['language']."'");
	$lang = vam_db_fetch_array($lang_query);

	$status_query = vam_db_query("select customers_status_name from ".TABLE_CUSTOMERS_STATUS." where customers_status_id = '".$_POST['customers_status']."' and language_id = '".$lang['languages_id']."' ");
	$status = vam_db_fetch_array($status_query);

	$sql_data_array = array ('customers_vat_id' => vam_db_prepare_input($_POST['customers_vat_id']), 'customers_status' => vam_db_prepare_input($_POST['customers_status']), 'customers_status_name' => vam_db_prepare_input($status['customers_status_name']), 'customers_company' => vam_db_prepare_input($_POST['customers_company']), 'customers_name' => vam_db_prepare_input($_POST['customers_name']), 'customers_street_address' => vam_db_prepare_input($_POST['customers_street_address']), 'customers_city' => vam_db_prepare_input($_POST['customers_city']), 'customers_state' => vam_db_prepare_input($_POST['customers_state']), 'customers_postcode' => vam_db_prepare_input($_POST['customers_postcode']), 'customers_country' => vam_db_prepare_input($_POST['customers_country']), 'customers_telephone' => vam_db_prepare_input($_POST['customers_telephone']), 'customers_email_address' => vam_db_prepare_input($_POST['customers_email_address']), 'delivery_company' => vam_db_prepare_input($_POST['delivery_company']), 'delivery_name' => vam_db_prepare_input($_POST['delivery_name']), 'delivery_street_address' => vam_db_prepare_input($_POST['delivery_street_address']), 'delivery_city' => vam_db_prepare_input($_POST['delivery_city']), 'delivery_state' => vam_db_prepare_input($_POST['delivery_state']), 'delivery_postcode' => vam_db_prepare_input($_POST['delivery_postcode']), 'delivery_country' => vam_db_prepare_input($_POST['delivery_country']), 'billing_company' => vam_db_prepare_input($_POST['billing_company']), 'billing_name' => vam_db_prepare_input($_POST['billing_name']), 'billing_street_address' => vam_db_prepare_input($_POST['billing_street_address']), 'billing_city' => vam_db_prepare_input($_POST['billing_city']), 'billing_state' => vam_db_prepare_input($_POST['billing_state']), 'billing_postcode' => vam_db_prepare_input($_POST['billing_postcode']), 'billing_country' => vam_db_prepare_input($_POST['billing_country']));

	$update_sql_data = array ('last_modified' => 'now()');
	$sql_data_array = vam_array_merge($sql_data_array, $update_sql_data);
	vam_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id = \''.vam_db_input($_POST['oID']).'\'');

	vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=address&oID='.$_POST['oID']));
}
// Adressbearbeitung Ende

// Artikeldaten einfГјgen / bearbeiten Anfang:

// Artikel bearbeiten Anfang:
if ($_GET['action'] == "product_edit") {
	$status_query = vam_db_query("select customers_status_show_price_tax from ".TABLE_CUSTOMERS_STATUS." where customers_status_id = '".$order->info['status']."'");
	$status = vam_db_fetch_array($status_query);

	$final_price = $_POST['products_price'] * $_POST['products_quantity'];

			$order_query = vam_db_query("
			SELECT products_id, products_quantity 
			FROM " . TABLE_ORDERS_PRODUCTS . " 
			WHERE orders_id = '" . $_POST['oID'] . "'
			AND orders_products_id = '" . $_POST['opID'] . "'");
			$orders_product_info = vam_db_fetch_array($order_query);
			
			$quantity_difference = ($_POST['products_quantity'] - $orders_product_info['products_quantity']);

    vam_db_query("UPDATE " . TABLE_PRODUCTS . " SET 
	products_quantity = products_quantity - " . $quantity_difference . ",
	products_ordered = products_ordered + " . $quantity_difference . " 
	WHERE products_id = '" . $_POST['products_id'] . "'");

	$sql_data_array = array ('orders_id' => vam_db_prepare_input($_POST['oID']), 'products_id' => vam_db_prepare_input($_POST['products_id']), 'products_name' => vam_db_prepare_input($_POST['products_name']), 'products_price' => vam_db_prepare_input($_POST['products_price']), 'products_discount_made' => '', 'final_price' => vam_db_prepare_input($final_price), 'products_tax' => vam_db_prepare_input($_POST['products_tax']), 'products_quantity' => vam_db_prepare_input($_POST['products_quantity']), 'allow_tax' => vam_db_prepare_input($status['customers_status_show_price_tax']));

	$update_sql_data = array ('products_model' => vam_db_prepare_input($_POST['products_model']));
	$sql_data_array = vam_array_merge($sql_data_array, $update_sql_data);
	vam_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id = \''.vam_db_input($_POST['opID']).'\'');

	vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=products&oID='.$_POST['oID']));
}
// Artikel bearbeiten Ende:

// Artikel einfГјgen Anfang

if ($_GET['action'] == "product_ins") {

if (0==round($_POST['products_quantity']))
	{
		$_POST['products_quantity'] = 1;
	}

	$status_query = vam_db_query("select customers_status_show_price_tax from ".TABLE_CUSTOMERS_STATUS." where customers_status_id = '".$order->info['status']."'");
	$status = vam_db_fetch_array($status_query);

	$product_query = vam_db_query("select p.products_model, p.products_tax_class_id, pd.products_name from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_id = '".vam_db_input($_POST['products_id'])."' and pd.products_id = p.products_id and pd.language_id = '".$_SESSION['languages_id']."'");
	$product = vam_db_fetch_array($product_query);

	$c_info = vam_oe_customer_infos($order->customer['ID']);
	$tax_rate = vam_get_tax_rate($product['products_tax_class_id'], $c_info['country_id'], $c_info['zone_id']);

	$price = $vamPrice->getPrice($_POST['products_id'], $format = false, $_POST['products_quantity'], $product['products_tax_class_id'], '', '', $order->customer['ID']);

	$final_price = $price * $_POST['products_quantity'];

			$order_query = vam_db_query("
			SELECT products_id, products_quantity 
			FROM " . TABLE_ORDERS_PRODUCTS . " 
			WHERE orders_id = '" . $_POST['oID'] . "'
			AND orders_products_id = '" . $_POST['opID'] . "'");
			$orders_product_info = vam_db_fetch_array($order_query);
			
			$quantity_difference = ($_POST['products_quantity'] - $orders_product_info['products_quantity']);

    vam_db_query("UPDATE " . TABLE_PRODUCTS . " SET 
	products_quantity = products_quantity - " . $quantity_difference . ",
	products_ordered = products_ordered + " . $quantity_difference . " 
	WHERE products_id = '" . $_POST['products_id'] . "'");

	$sql_data_array = array ('orders_id' => vam_db_prepare_input($_POST['oID']), 'products_id' => vam_db_prepare_input($_POST['products_id']), 'products_name' => vam_db_prepare_input($product['products_name']), 'products_price' => vam_db_prepare_input($price), 'products_discount_made' => '', 'final_price' => vam_db_prepare_input($final_price), 'products_tax' => vam_db_prepare_input($tax_rate), 'products_quantity' => vam_db_prepare_input($_POST['products_quantity']), 'allow_tax' => vam_db_prepare_input($status['customers_status_show_price_tax']));

	$insert_sql_data = array ('products_model' => vam_db_prepare_input($product['products_model']));
	$sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
	vam_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);

	vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=products&oID='.$_POST['oID']));
}
// Artikel einfГјgen Ende

// Produkt Optionen bearbeiten Anfang
if ($_GET['action'] == "product_option_edit") {

	$sql_data_array = array ('products_options' => vam_db_prepare_input($_POST['products_options']), 'products_options_values' => vam_db_prepare_input($_POST['products_options_values']), 'options_values_price' => vam_db_prepare_input($_POST['options_values_price']));

	$update_sql_data = array ('price_prefix' => vam_db_prepare_input($_POST['prefix']));
	$sql_data_array = vam_array_merge($sql_data_array, $update_sql_data);
	vam_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array, 'update', 'orders_products_attributes_id = \''.vam_db_input($_POST['opAID']).'\'');

	$products_query = vam_db_query("select op.products_id, op.products_quantity, p.products_tax_class_id from ".TABLE_ORDERS_PRODUCTS." op, ".TABLE_PRODUCTS." p where op.orders_products_id = '".$_POST['opID']."' and op.products_id = p.products_id");
	$products = vam_db_fetch_array($products_query);

	$products_a_query = vam_db_query("select options_values_price, price_prefix from ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES." where orders_products_id = '".$_POST['opID']."'");
	while ($products_a = vam_db_fetch_array($products_a_query)) {
		$ov_price += $products_a['price_prefix'].$products_a['options_values_price'];
	};

	$products_old_price = $vamPrice->GetPrice($products['products_id'], $format = false, $products['products_quantity'], '', '', '', $order->customer['ID']);

	$options_values_price = ($ov_price.$_POST['prefix'].$_POST['options_values_price']);
	$products_price = ($products_old_price + $options_values_price);

	$price = $vamPrice->GetPrice($products['products_id'], $format = false, $products['products_quantity'], $products['products_tax_class_id'], $products_price, '', $order->customer['ID']);

	$final_price = $price * $products['products_quantity'];

	$sql_data_array = array ('products_price' => vam_db_prepare_input($price));
	$update_sql_data = array ('final_price' => vam_db_prepare_input($final_price));
	$sql_data_array = vam_array_merge($sql_data_array, $update_sql_data);
	vam_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id = \''.vam_db_input($_POST['opID']).'\'');

	vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=options&oID='.$_POST['oID'].'&pID='.$products['products_id'].'&opID='.$_POST['opID']));
}
// Produkt Optionen bearbeiten Ende

// Produkt Optionen einfГјgen Anfang
if ($_GET['action'] == "product_option_ins") {

	$products_attributes_query = vam_db_query("select options_id, options_values_id, options_values_price, price_prefix from ".TABLE_PRODUCTS_ATTRIBUTES." where products_attributes_id = '".$_POST['aID']."'");
	$products_attributes = vam_db_fetch_array($products_attributes_query);

	$products_options_query = vam_db_query("select products_options_name from ".TABLE_PRODUCTS_OPTIONS." where products_options_id = '".$products_attributes['options_id']."' and language_id = '".$_SESSION['languages_id']."'");
	$products_options = vam_db_fetch_array($products_options_query);

	$products_options_values_query = vam_db_query("select products_options_values_name from ".TABLE_PRODUCTS_OPTIONS_VALUES." where products_options_values_id = '".$products_attributes['options_values_id']."' and language_id = '".$_SESSION['languages_id']."'");
	$products_options_values = vam_db_fetch_array($products_options_values_query);

	$sql_data_array = array ('orders_id' => vam_db_prepare_input($_POST['oID']), 'orders_products_id' => vam_db_prepare_input($_POST['opID']), 'products_options' => vam_db_prepare_input($products_options['products_options_name']), 'products_options_values' => vam_db_prepare_input($products_options_values['products_options_values_name']), 'options_values_price' => vam_db_prepare_input($products_attributes['options_values_price']));

	$insert_sql_data = array ('price_prefix' => vam_db_prepare_input($products_attributes['price_prefix']));
	$sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
	vam_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);

	$products_query = vam_db_query("select op.products_id, op.products_quantity, p.products_tax_class_id from ".TABLE_ORDERS_PRODUCTS." op, ".TABLE_PRODUCTS." p where op.orders_products_id = '".$_POST['opID']."' and op.products_id = p.products_id");
	$products = vam_db_fetch_array($products_query);

	$products_a_query = vam_db_query("select options_values_price, price_prefix from ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES." where orders_products_id = '".$_POST['opID']."'");
	while ($products_a = vam_db_fetch_array($products_a_query)) {
		$options_values_price += $products_a['price_prefix'].$products_a['options_values_price'];
	};

	if (DOWNLOAD_ENABLED == 'true') {
		$attributes_query = "select popt.products_options_name,
										                               poval.products_options_values_name,
										                               pa.options_values_price,
										                               pa.price_prefix,
										                               pad.products_attributes_maxdays,
										                               pad.products_attributes_maxcount,
										                               pad.products_attributes_filename
										                               from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_OPTIONS_VALUES." poval, ".TABLE_PRODUCTS_ATTRIBUTES." pa
										                               left join ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." pad
										                                on pa.products_attributes_id=pad.products_attributes_id
										                               where pa.products_id = '".$products['products_id']."'
										                                and pa.options_id = '".$products_attributes['options_id']."'
										                                and pa.options_id = popt.products_options_id
										                                and pa.options_values_id = '".$products_attributes['options_values_id']."'
										                                and pa.options_values_id = poval.products_options_values_id
										                                and popt.language_id = '".$_SESSION['languages_id']."'
										                                and poval.language_id = '".$_SESSION['languages_id']."'";
		$attributes = vam_db_query($attributes_query);

		$attributes_values = vam_db_fetch_array($attributes);

		if (isset ($attributes_values['products_attributes_filename']) && vam_not_null($attributes_values['products_attributes_filename'])) {
			$sql_data_array = array ('orders_id' => vam_db_prepare_input($_POST['oID']), 'orders_products_id' => vam_db_prepare_input($_POST['opID']), 'orders_products_filename' => $attributes_values['products_attributes_filename'], 'download_maxdays' => $attributes_values['products_attributes_maxdays'], 'download_count' => $attributes_values['products_attributes_maxcount']);

			vam_db_perform(TABLE_ORDERS_PRODUCTS_DOWNLOAD, $sql_data_array);
		}

	}

	$products_old_price = $vamPrice->GetPrice($products['products_id'], $format = false, $products['products_quantity'], '', '', '', $order->customer['ID']);

	$products_price = ($products_old_price + $options_values_price);

	$price = $vamPrice->GetPrice($products['products_id'], $format = false, $products['products_quantity'], $products['products_tax_class_id'], $products_price, '', $order->customer['ID']);

	$final_price = $price * $products['products_quantity'];

	$sql_data_array = array ('products_price' => vam_db_prepare_input($price));
	$update_sql_data = array ('final_price' => vam_db_prepare_input($final_price));
	$sql_data_array = vam_array_merge($sql_data_array, $update_sql_data);
	vam_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id = \''.vam_db_input($_POST['opID']).'\'');

	vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=options&oID='.$_POST['oID'].'&pID='.$products['products_id'].'&opID='.$_POST['opID']));
}

// Produkt Optionen einfГјgen Ende

// Artikeldaten einfГјgen / bearbeiten Ende:

// Zahlung Anfang
if ($_GET['action'] == "payment_edit") {

	$sql_data_array = array ('payment_method' => vam_db_prepare_input($_POST['payment']), 'payment_class' => vam_db_prepare_input($_POST['payment']),);
	vam_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id = \''.vam_db_input($_POST['oID']).'\'');

	vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID='.$_POST['oID']));
}
// Zahlung Ende

// Versandkosten Anfang
if ($_GET['action'] == "shipping_edit") {

	$module = $_POST['shipping'].'.php';
	require (DIR_FS_LANGUAGES.$order->info['language'].'/modules/shipping/'.$module);
	$shipping_text = constant(MODULE_SHIPPING_.strtoupper($_POST['shipping'])._TEXT_TITLE);
	$shipping_class = $_POST['shipping'].'_'.$_POST['shipping'];

	$text = $vamPrice->Format($_POST['value'], true);

	$sql_data_array = array ('orders_id' => vam_db_prepare_input($_POST['oID']), 'title' => vam_db_prepare_input($shipping_text), 'text' => vam_db_prepare_input($text), 'value' => vam_db_prepare_input($_POST['value']), 'class' => 'ot_shipping');

	$check_shipping_query = vam_db_query("select class from ".TABLE_ORDERS_TOTAL." where orders_id = '".$_POST['oID']."' and class = 'ot_shipping'");
	if (vam_db_num_rows($check_shipping_query)) {
		vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_id = \''.vam_db_input($_POST['oID']).'\' and class="ot_shipping"');
	} else {
		vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
	}

	$sql_data_array = array ('shipping_method' => vam_db_prepare_input($shipping_text), 'shipping_class' => vam_db_prepare_input($shipping_class),);
	vam_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id = \''.vam_db_input($_POST['oID']).'\'');

	vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID='.$_POST['oID']));
}
// Versandkosten Ende

// OT Module Anfang:
if ($_GET['action'] == "ot_edit") {

	$check_total_query = vam_db_query("select orders_total_id from ".TABLE_ORDERS_TOTAL." where orders_id = '".$_POST['oID']."' and class = '".$_POST['class']."'");
	if (vam_db_num_rows($check_total_query)) {

		$check_total = vam_db_fetch_array($check_total_query);

		$text = $vamPrice->Format($_POST['value'], true);

		$sql_data_array = array ('title' => vam_db_prepare_input($_POST['title']), 'text' => vam_db_prepare_input($text), 'value' => vam_db_prepare_input($_POST['value']),);
		vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_total_id = \''.vam_db_input($check_total['orders_total_id']).'\'');

	} else {

		$text = $vamPrice->Format($_POST['value'], true);

		$sql_data_array = array ('orders_id' => vam_db_prepare_input($_POST['oID']), 'title' => vam_db_prepare_input($_POST['title']), 'text' => vam_db_prepare_input($text), 'value' => vam_db_prepare_input($_POST['value']), 'class' => vam_db_prepare_input($_POST['class']), 'sort_order' => vam_db_prepare_input($_POST['sort_order']),);

		vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
	}

	vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID='.$_POST['oID']));
}
// OT Module Ende

// Sprachupdate Anfang

if ($_GET['action'] == "lang_edit") {

	// Daten fГјr Sprache wГ¤hlen
	$lang_query = vam_db_query("select languages_id, name, directory from ".TABLE_LANGUAGES." where languages_id = '".$_POST['lang']."'");
	$lang = vam_db_fetch_array($lang_query);
	// Daten fГјr Sprache wпїЅhlen Ende	

	// Produkte
	$order_products_query = vam_db_query("select orders_products_id , products_id from ".TABLE_ORDERS_PRODUCTS." where orders_id = '".$_POST['oID']."'");
	while ($order_products = vam_db_fetch_array($order_products_query)) {

		$products_query = vam_db_query("select products_name from ".TABLE_PRODUCTS_DESCRIPTION." where products_id = '".$order_products['products_id']."' and language_id = '".$_POST['lang']."' ");
		$products = vam_db_fetch_array($products_query);

		$sql_data_array = array ('products_name' => vam_db_prepare_input($products['products_name']));
		vam_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id  = \''.vam_db_input($order_products['orders_products_id']).'\'');
	};
	// Produkte Ende	

	// OT Module

	$order_total_query = vam_db_query("select orders_total_id, title, class from ".TABLE_ORDERS_TOTAL." where orders_id = '".$_POST['oID']."'");
	while ($order_total = vam_db_fetch_array($order_total_query)) {

		require (DIR_FS_LANGUAGES.$lang['directory'].'/modules/order_total/'.$order_total['class'].'.php');
		$name = str_replace('ot_', '', $order_total['class']);
		$text = constant(MODULE_ORDER_TOTAL_.strtoupper($name)._TITLE);

		$sql_data_array = array ('title' => vam_db_prepare_input($text));
		vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_total_id  = \''.vam_db_input($order_total['orders_total_id']).'\'');

	}

	// OT Module

	$sql_data_array = array ('language' => vam_db_prepare_input($lang['directory']));
	vam_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id  = \''.vam_db_input($_POST['oID']).'\'');

	vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID='.$_POST['oID']));
}

// Sprachupdate Ende

// WГ¤hrungswechsel Anfang

if ($_GET['action'] == "curr_edit") {

	$curr_query = vam_db_query("select currencies_id, title, code, value from ".TABLE_CURRENCIES." where currencies_id = '".$_POST['currencies_id']."' ");
	$curr = vam_db_fetch_array($curr_query);

	$old_curr_query = vam_db_query("select currencies_id, title, code, value from ".TABLE_CURRENCIES." where code = '".$_POST['old_currency']."' ");
	$old_curr = vam_db_fetch_array($old_curr_query);

	$sql_data_array = array ('currency' => vam_db_prepare_input($curr['code']),'currency_value'=>vam_db_prepare_input($curr['value']));
	vam_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id  = \''.vam_db_input($_POST['oID']).'\'');

	// Produkte
	$order_products_query = vam_db_query("select orders_products_id , products_id, products_price, final_price from ".TABLE_ORDERS_PRODUCTS." where orders_id = '".$_POST['oID']."'");
	while ($order_products = vam_db_fetch_array($order_products_query)) {

		if ($old_curr['code'] == DEFAULT_CURRENCY) {

			$vamPrice = new vamPrice($curr['code'], $order->info['status'], $order->customer['ID']);

			$products_price = $vamPrice->GetPrice($order_products['products_id'], $format = false, '', '', $order_products['products_price'], '', $order->customer['ID']);

			$final_price = $vamPrice->GetPrice($order_products['products_id'], $format = false, '', '', $order_products['final_price'], '', $order->customer['ID']);
		} else {

			$vamPrice = new vamPrice($old_curr['code'], $order->info['status'], $order->customer['ID']);

			$p_price = $vamPrice->RemoveCurr($order_products['products_price']);

			$f_price = $vamPrice->RemoveCurr($order_products['final_price']);

			$vamPrice = new vamPrice($curr['code'], $order->info['status'], $order->customer['ID']);

			$products_price = $vamPrice->GetPrice($order_products['products_id'], $format = false, '', '', $p_price, '', $order->customer['ID']);

			$final_price = $vamPrice->GetPrice($order_products['products_id'], $format = false, '', '', $f_price, '', $order->customer['ID']);
		}
		$sql_data_array = array ('products_price' => vam_db_prepare_input($products_price), 'final_price' => vam_db_prepare_input($final_price));

		vam_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id  = \''.vam_db_input($order_products['orders_products_id']).'\'');
	};
	// Produkte Ende		

	// OT
	$order_total_query = vam_db_query("select orders_total_id, value from ".TABLE_ORDERS_TOTAL." where orders_id = '".$_POST['oID']."'");
	while ($order_total = vam_db_fetch_array($order_total_query)) {

		if ($old_curr['code'] == DEFAULT_CURRENCY) {

			$vamPrice = new vamPrice($curr['code'], $order->info['status'], $order->customer['ID']);

			$value = $vamPrice->GetPrice('', $format = false, '', '', $order_total['value'], '', $order->customer['ID']);

		} else {

			$vamPrice = new vamPrice($old_curr['code'], $order->info['status'], $order->customer['ID']);

			$nvalue = $vamPrice->RemoveCurr($order_total['value']);

			$vamPrice = new vamPrice($curr['code'], $order->info['status'], $order->customer['ID']);

			$value = $vamPrice->GetPrice('', $format = false, '', '', $nvalue, '', $order->customer['ID']);
		}

		$text = $text = $vamPrice->Format($value, true);

		$sql_data_array = array ('text' => vam_db_prepare_input($text), 'value' => vam_db_prepare_input($value));

		vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array, 'update', 'orders_total_id  = \''.vam_db_input($order_total['orders_total_id']).'\'');
	};
	// OT Ende	

	vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID='.$_POST['oID']));
}

// WГ¤hrungswechsel Ende

// LГ¶schfunktionen Anfang:

// LГ¶schen eines Artikels aus der Bestellung Anfang:
if ($_GET['action'] == "product_delete") {

	vam_db_query("delete from ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES." where orders_products_id = '".vam_db_input($_POST['opID'])."'");
	vam_db_query("delete from ".TABLE_ORDERS_PRODUCTS." where orders_id = '".vam_db_input($_POST['oID'])."' and orders_products_id = '".vam_db_input($_POST['opID'])."'");

	vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=products&oID='.$_POST['oID']));
}
// LГ¶schen eines Artikels aus der Bestellung Ende:

// LГ¶schen einer Artikeloption aus der Bestellung Anfang:
if ($_GET['action'] == "product_option_delete") {
	
	vam_db_input($_POST['opAID']."'");

	$products_query = vam_db_query("select op.products_id, op.products_quantity, p.products_tax_class_id from ".TABLE_ORDERS_PRODUCTS." op, ".TABLE_PRODUCTS." p where op.orders_products_id = '".$_POST['opID']."' and op.products_id = p.products_id");
	$products = vam_db_fetch_array($products_query);

	$products_a_query = vam_db_query("select options_values_price, price_prefix from ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES." where orders_products_id = '".$_POST['opID']."'");
	while ($products_a = vam_db_fetch_array($products_a_query)) {
		$options_values_price += $products_a['price_prefix'].$products_a['options_values_price'];
	};

	vam_db_query("delete from ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES." where orders_products_id = '".$_POST['opID']."'");
	
	$products_old_price = $vamPrice->GetPrice($products['products_id'], $format = false, $products['products_quantity'], '', '', '', $order->customer['ID']);

	$products_price = ($products_old_price + $options_values_price);

	$price = $vamPrice->GetPrice($products['products_id'], $format = false, $products['products_quantity'], $products['products_tax_class_id'], $products_price, '', $order->customer['ID']);

	$final_price = $price * $products['products_quantity'] - $options_values_price;

	$sql_data_array = array ('products_price' => vam_db_prepare_input($price));
	$update_sql_data = array ('final_price' => vam_db_prepare_input($final_price));
	$sql_data_array = vam_array_merge($sql_data_array, $update_sql_data);
	vam_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array, 'update', 'orders_products_id = \''.vam_db_input($_POST['opID']).'\'');

	vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=options&oID='.$_POST['oID'].'&pID='.$products['products_id'].'&opID='.$_POST['opID']));
}
// LГ¶schen einer Artikeloptions aus der Bestellung Ende:   

// LГ¶schen eines OT Moduls aus der Bestellung Anfang:
if ($_GET['action'] == "ot_delete") {

	vam_db_query("delete from ".TABLE_ORDERS_TOTAL." where orders_total_id = '".vam_db_input($_POST['otID'])."'");

	vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID='.$_POST['oID']));
}
// LГ¶schen eines OT Moduls aus der Bestellung Ende:

// LГ¶schfunktionen Ende

// RГјckberechnung Anfang

if ($_GET['action'] == "save_order") {

	// Errechne neue Zwischensumme fГјr Artikel Anfang
	$products_query = vam_db_query("select SUM(final_price) as subtotal_final from ".TABLE_ORDERS_PRODUCTS." where orders_id = '".$_POST['oID']."' ");
	$products = vam_db_fetch_array($products_query);
	$subtotal_final = $products['subtotal_final'];
	$subtotal_text = $vamPrice->Format($subtotal_final, true);

	vam_db_query("update ".TABLE_ORDERS_TOTAL." set text = '".vam_db_input($subtotal_text)."', value = '".vam_db_input($subtotal_final)."' where orders_id = '".$_POST['oID']."' and class = 'ot_subtotal' ");
	// Errechne neue Zwischensumme fГјr Artikel Ende

	// Errechne neue Netto Zwischensumme fГјr Artikel Anfang

	$check_no_tax_value_query = vam_db_query("select count(*) as count from ".TABLE_ORDERS_TOTAL." where orders_id = '".$_POST['oID']."' and class = 'ot_subtotal_no_tax'");
	$check_no_tax_value = vam_db_fetch_array($check_no_tax_value_query);

	if ($check_no_tax_value_query['count'] != '0') {
		$subtotal_no_tax_value_query = vam_db_query("select SUM(value) as subtotal_no_tax_value from ".TABLE_ORDERS_TOTAL." where orders_id = '".$_POST['oID']."' and class != 'ot_tax' and class != 'ot_total' and class != 'ot_subtotal_no_tax' and class != 'ot_coupon' and class != 'ot_gv'");
		$subtotal_no_tax_value = vam_db_fetch_array($subtotal_no_tax_value_query);
		$subtotal_no_tax_final = $subtotal_no_tax_value['subtotal_no_tax_value'];
		$subtotal_no_tax_text = $vamPrice->Format($subtotal_no_tax_final, true);
		vam_db_query("update ".TABLE_ORDERS_TOTAL." set text = '".$subtotal_no_tax_text."', value = '".$subtotal_no_tax_final."' where orders_id = '".$_POST['oID']."' and class = 'ot_subtotal_no_tax' ");
	}

	// Errechne neue Netto Zwischensumme fГјr Artikel Anfang

	// Errechne neue Zwischensumme fГјr Artikel Anfang
	$subtotal_query = vam_db_query("select SUM(value) as value from ".TABLE_ORDERS_TOTAL." where orders_id = '".$_POST['oID']."' and class != 'ot_subtotal_no_tax' and class != 'ot_tax' and class != 'ot_total'");
	$subtotal = vam_db_fetch_array($subtotal_query);

	$subtotal_final = $subtotal['value'];
	$subtotal_text = $vamPrice->Format($subtotal_final, true);
	vam_db_query("update ".TABLE_ORDERS_TOTAL." set text = '".$subtotal_text."', value = '".$subtotal_final."' where orders_id = '".$_POST['oID']."' and class = 'ot_total'");
	// Errechne neue Zwischensumme fпїЅr Artikel Ende

	// Errechne neue MwSt. fГјr die Bestellung Anfang
	// Produkte
	$products_query = vam_db_query("select final_price, products_tax, allow_tax from ".TABLE_ORDERS_PRODUCTS." where orders_id = '".$_POST['oID']."' ");
	while ($products = vam_db_fetch_array($products_query)) {

		$tax_rate = $products['products_tax'];
		$multi = (($products['products_tax'] / 100) + 1);

		if ($products['allow_tax'] == '1') {
			$bprice = $products['final_price'];
			$nprice = $vamPrice->RemoveTax($bprice, $tax_rate);
			$tax = $vamPrice->calcTax($nprice, $tax_rate);
		} else {
			$nprice = $products['final_price'];
			$bprice = $vamPrice->AddTax($nprice, $tax_rate);
			$tax = $vamPrice->calcTax($nprice, $tax_rate);
		}

		$sql_data_array = array ('orders_id' => vam_db_prepare_input($_POST['oID']), 'n_price' => vam_db_prepare_input($nprice), 'b_price' => vam_db_prepare_input($bprice), 'tax' => vam_db_prepare_input($tax), 'tax_rate' => vam_db_prepare_input($products['products_tax']));

		$insert_sql_data = array ('class' => 'products');
		$sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
		vam_db_perform(TABLE_ORDERS_RECALCULATE, $sql_data_array);
	}
	// Produkte Ende

	// Module Anfang
	$module_query = vam_db_query("select value, class from ".TABLE_ORDERS_TOTAL." where orders_id = '".$_POST['oID']."' and class!='ot_total' and class!='ot_subtotal_no_tax' and class!='ot_tax' and class!='ot_subtotal'");
	while ($module_value = vam_db_fetch_array($module_query)) {
		;

		$module_name = str_replace('ot_', '', $module_value['class']);

		if ($module_name != 'discount') {
			if ($module_name != 'shipping') {
				$module_tax_class = constant(MODULE_ORDER_TOTAL_.strtoupper($module_name)._TAX_CLASS);
			} else {
				$module_tmp_name = preg_split('/_/', $order->info['shipping_class']);
				$module_tmp_name = $module_tmp_name[0];
				if ($module_tmp_name != 'selfpickup') {
					$module_tax_class = constant(MODULE_SHIPPING_.strtoupper($module_tmp_name)._TAX_CLASS);
				} else {
					$module_tax_class = '';
				}
			}
		} else {
			$module_tax_class = '0';
		}

		$cinfo = vam_oe_customer_infos($order->customer['ID']);
		$module_tax_rate = vam_get_tax_rate($module_tax_class, $cinfo['country_id'], $cinfo['zone_id']);

		$status_query = vam_db_query("select customers_status_show_price_tax from ".TABLE_CUSTOMERS_STATUS." where customers_status_id = '".$order->info['status']."'");
		$status = vam_db_fetch_array($status_query);

		if ($status['customers_status_show_price_tax'] == 1) {
			$module_b_price = $module_value['value'];
			if ($module_tax == '0') {
				$module_n_price = $module_value['value'];
			} else {
				$module_n_price = $vamPrice->RemoveTax($module_b_price, $module_tax_rate);
			}
			$module_tax = $vamPrice->calcTax($module_n_price, $module_tax_rate);
		} else {
			$module_n_price = $module_value['value'];
			$module_b_price = $vamPrice->AddTax($module_n_price, $module_tax_rate);
			$module_tax = $vamPrice->calcTax($module_n_price, $module_tax_rate);
		}

		$sql_data_array = array ('orders_id' => vam_db_prepare_input($_POST['oID']), 'n_price' => vam_db_prepare_input($module_n_price), 'b_price' => vam_db_prepare_input($module_b_price), 'tax' => vam_db_prepare_input($module_tax), 'tax_rate' => vam_db_prepare_input($module_tax_rate));

		$insert_sql_data = array ('class' => $module_value['class']);
		$sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
		vam_db_perform(TABLE_ORDERS_RECALCULATE, $sql_data_array);
	}
	// Module Ende  

	// Alte UST LГ¶schen ANFANG
	vam_db_query("delete from ".TABLE_ORDERS_TOTAL." where orders_id = '".vam_db_input($_POST['oID'])."' and class='ot_tax'");
	// Alte UST LГ¶schen ENDE

	// Neue Mwst. zusammenrechnen Anfang

	$ust_query = vam_db_query("select tax_rate, SUM(tax) as tax_value_new from ".TABLE_ORDERS_RECALCULATE." where orders_id = '".$_POST['oID']."' and tax !='0' GROUP by tax_rate ");
	while ($ust = vam_db_fetch_array($ust_query)) {

		$ust_desc_query = vam_db_query("select tax_description from ".TABLE_TAX_RATES." where tax_rate = '".$ust['tax_rate']."'");
		$ust_desc = vam_db_fetch_array($ust_desc_query);

		$title = $ust_desc['tax_description'];

		if ($ust['tax_value_new']) {
			$text = $vamPrice->Format($ust['tax_value_new'], true);

			$sql_data_array = array ('orders_id' => vam_db_prepare_input($_POST['oID']), 'title' => vam_db_prepare_input($title), 'text' => vam_db_prepare_input($text), 'value' => vam_db_prepare_input($ust['tax_value_new']), 'class' => 'ot_tax');

			$insert_sql_data = array ('sort_order' => MODULE_ORDER_TOTAL_TAX_SORT_ORDER);
			$sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
			vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
		}

	}

	// Neue Mwst. zusammenrechnen Ende

	// LГ¶schen des Zwischenspeichers Anfang
	vam_db_query("delete from ".TABLE_ORDERS_RECALCULATE." where orders_id = '".vam_db_input($_POST['oID'])."'");
	// LГ¶schen des Zwischenspeichers Ende

	vam_redirect(vam_href_link(FILENAME_ORDERS, 'action=edit&oID='.$_POST['oID']));
}
// RГјckberechnung Ende

//--------------------------------------------------------------------------------------------------------------------------------------
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'false') { ?>
    <td width="<?php echo BOX_WIDTH; ?>" align="left" valign="top">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </td>
<?php } ?>
<!-- body_text //-->
    <td class="boxCenter" valign="top">
    
    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr>
<td>
<!-- Anfang //-->
<br /><br />

<table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr>
<td class="main">
<b>
<?php


if ($_GET['text'] == 'address') {
	echo TEXT_EDIT_ADDRESS_SUCCESS;
}
?>
</b>
</td>
</tr>
</table>

<!-- Meldungen Ende //-->
<?php


if ($_GET['edit_action'] == 'address') {
	include ('orders_edit_address.php');
}
elseif ($_GET['edit_action'] == 'products') {
	include ('orders_edit_products.php');
}
elseif ($_GET['edit_action'] == 'other') {
	include ('orders_edit_other.php');
}
elseif ($_GET['edit_action'] == 'options') {
	include ('orders_edit_options.php');
}
?>

<!-- Bestellung Sichern Anfang //-->
<br /><br />
<table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr class="dataTableRow">
<td class="dataTableContent" align="right">
<?php


echo TEXT_SAVE_ORDER;
echo vam_draw_form('save_order', FILENAME_ORDERS_EDIT, 'action=save_order', 'post');
echo vam_draw_hidden_field('customers_status_id', $address[customers_status]);
echo vam_draw_hidden_field('oID', $_GET['oID']);
echo vam_draw_hidden_field('cID', $_GET[cID]);
echo '<span class="button"><button type="submit" value="'.BUTTON_SAVE.'">' . BUTTON_SAVE . '</button></span>';
?>
</form>
</td>
</tr>

</table>
<br /><br />
<!-- Bestellung Sichern Ende //-->


<!-- Ende //-->
</td>
<?php


$heading = array ();
$contents = array ();
switch ($_GET['action']) {

	default :
		if (is_object($order)) {
			$heading[] = array ('text' => '<b>'.TABLE_HEADING_ORDER.$_GET['oID'].'</b>');

			$contents[] = array ('align' => 'center', 'text' => '<br />'.TEXT_EDIT_ADDRESS.'<br /><a class="button" href="'.vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=address&oID='.$_GET['oID']).'"><span>'.BUTTON_EDIT.'</span></a><br /><br />');
			$contents[] = array ('align' => 'center', 'text' => '<br />'.TEXT_EDIT_PRODUCTS.'<br /><a class="button" href="'.vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=products&oID='.$_GET['oID']).'"><span>'.BUTTON_EDIT.'</span></a><br /><br />');
			$contents[] = array ('align' => 'center', 'text' => '<br />'.TEXT_EDIT_OTHER.'<br /><a class="button" href="'.vam_href_link(FILENAME_ORDERS_EDIT, 'edit_action=other&oID='.$_GET['oID']).'"><span>'.BUTTON_EDIT.'</span></a><br /><br />');

		}
		break;
}

if ((vam_not_null($heading)) && (vam_not_null($contents))) {
	echo '            <td width="20%" valign="top">'."\n";

	$box = new box;
	echo $box->infoBox($heading, $contents);

	echo '            </td>'."\n";
}
?>
  </tr>

<!-- body_text_eof //-->
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
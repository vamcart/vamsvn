<?php
/* -----------------------------------------------------------------------------------------
   $Id: order.php 1533 2007-02-06 20:23:03 VaM $ 

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(order.php,v 1.32 2003/02/26); www.oscommerce.com 
   (c) 2003	 nextcommerce (order.php,v 1.28 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (order.php,v 1.28 2003/08/18); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   credit card encryption functions for the catalog module
   BMC 2003 for the CC CVV Module


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  // include needed functions
  require_once(DIR_FS_INC . 'vam_date_long.inc.php');
  require_once(DIR_FS_INC . 'vam_address_format.inc.php');
  require_once(DIR_FS_INC . 'vam_get_country_name.inc.php');
  require_once(DIR_FS_INC . 'vam_get_zone_code.inc.php');
  require_once(DIR_FS_INC . 'vam_get_tax_description.inc.php');


  class order {
    var $info, $totals, $products, $customer, $delivery, $content_type;

    function __construct($order_id = '') {
    	global $vamPrice;
      $this->info = array();
      $this->totals = array();
      $this->products = array();
      $this->customer = array();
      $this->delivery = array();


		// SMART CHECKOUT BOF
			  if (vam_session_is_registered('noaccount')) {
			  	$this->cart_noaccount();
		      } elseif (vam_not_null($order_id)) {
		        $this->query($order_id);
		      } else {
		        $this->cart();
		      }
		    }
		// SMART CHECKOUT EOF
    
    function query($order_id) {

      $order_id = vam_db_prepare_input($order_id);

      $order_query = vam_db_query("SELECT
                                   *
                                   FROM " . TABLE_ORDERS . " WHERE
                                   orders_id = '" . vam_db_input($order_id) . "'");

      $order = vam_db_fetch_array($order_query);

      $totals_query = vam_db_query("SELECT * FROM " . TABLE_ORDERS_TOTAL . " where orders_id = '" . vam_db_input($order_id) . "' order by sort_order");
      while ($totals = vam_db_fetch_array($totals_query)) {
        $this->totals[] = array('title' => $totals['title'],
                                'text' =>$totals['text'],
                                'value'=>$totals['value']);
      }

      $order_total_query = vam_db_query("select text,value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' and class = 'ot_total'");
      $order_total = vam_db_fetch_array($order_total_query);

      $shipping_method_query = vam_db_query("select title from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$order_id . "' and class = 'ot_shipping'");
      $shipping_method = vam_db_fetch_array($shipping_method_query);

      $order_status_query = vam_db_query("select orders_status_name from " . TABLE_ORDERS_STATUS . " where orders_status_id = '" . (int)$order['orders_status'] . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");
      $order_status = vam_db_fetch_array($order_status_query);

      $this->info = array('id' => $order['orders_id'],
                          'currency' => $order['currency'],
                          'currency_value' => $order['currency_value'],
                          'payment_method' => $order['payment_method'],
                          'cc_type' => $order['cc_type'],
                          'cc_owner' => $order['cc_owner'],
                          'cc_number' => $order['cc_number'],
                          'cc_expires' => $order['cc_expires'],
// BMC CC Mod Start
                          'cc_start' => $order['cc_start'],
                          'cc_issue' => $order['cc_issue'],
                          'cc_cvv' => $order['cc_cvv'],
// BMC CC Mod End
                          'date_purchased' => $order['date_purchased'],
                          'orders_status' => $order_status['orders_status_name'],
                          'last_modified' => $order['last_modified'],
                          'total' => strip_tags($order_total['text']),
						  'total_value' => $order_total['value'],
                          'shipping_method' => ((substr($shipping_method['title'], -1) == ':') ? substr(strip_tags($shipping_method['title']), 0, -1) : strip_tags($shipping_method['title'])),
                          'comments' => $order['comments']
                          );

      $this->customer = array('id' => $order['customers_id'],
                              'name' => $order['customers_name'],
                              'firstname' => $order['customers_firstname'],
                              'secondname' => $order['customers_secondname'],
                              'lastname' => $order['customers_lastname'],                            
                              'csID' => $order['customers_cid'],
                              'company' => $order['customers_company'],
                              'street_address' => $order['customers_street_address'],
                              'suburb' => $order['customers_suburb'],
                              'city' => $order['customers_city'],
                              'postcode' => $order['customers_postcode'],
                              'state' => $order['customers_state'],
                              'country' => $order['customers_country'],
                              'format_id' => $order['customers_address_format_id'],
                              'telephone' => $order['customers_telephone'],
                              'email_address' => $order['customers_email_address']);

      $this->delivery = array('name' => $order['delivery_name'],
      							'firstname' => $order['delivery_firstname'],
      							'secondname' => $order['delivery_secondname'],
      							'lastname' => $order['delivery_lastname'],
                              'company' => $order['delivery_company'],
                              'street_address' => $order['delivery_street_address'],
                              'suburb' => $order['delivery_suburb'],
                              'city' => $order['delivery_city'],
                              'postcode' => $order['delivery_postcode'],
                              'state' => $order['delivery_state'],
                              'country' => $order['delivery_country'],
                              'format_id' => $order['delivery_address_format_id']);

      if (empty($this->delivery['name']) && empty($this->delivery['street_address'])) {
        $this->delivery = false;
      }

      $this->billing = array('name' => $order['billing_name'],
      							'firstname' => $order['billing_firstname'],
      							'secondname' => $order['billing_secondname'],
      							'lastname' => $order['billing_lastname'],
                             'company' => $order['billing_company'],
                             'street_address' => $order['billing_street_address'],
                             'suburb' => $order['billing_suburb'],
                             'city' => $order['billing_city'],
                             'postcode' => $order['billing_postcode'],
                             'state' => $order['billing_state'],
                             'country' => $order['billing_country'],
                             'format_id' => $order['billing_address_format_id']);

      $index = 0;
      $orders_products_query = vam_db_query("SELECT * FROM " . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . vam_db_input($order_id) . "'");
      while ($orders_products = vam_db_fetch_array($orders_products_query)) {
        $this->products[$index] = array('qty' => $orders_products['products_quantity'],
                                        'name' => $orders_products['products_name'],
                                        'id' => $orders_products['products_id'],
                                        'guid' => $orders_products['guid'],
                                        'opid' => $orders_products['orders_products_id'],                                        
                                        'model' => $orders_products['products_model'],
                                        'tax' => $orders_products['products_tax'],
                                        'price' => $orders_products['products_price'],
                                        'shipping_time'=>$orders_products['products_shipping_time'],
                                        'discount' => $orders_products['products_discount_made'],
                                        'final_price' => $orders_products['final_price'],
                                        'allow_tax' => $orders_products['allow_tax']);

        $subindex = 0;
        $attributes_query = vam_db_query("SELECT * FROM " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . vam_db_input($order_id) . "' and orders_products_id = '" . (int)$orders_products['orders_products_id'] . "'");
        if (vam_db_num_rows($attributes_query)) {
          while ($attributes = vam_db_fetch_array($attributes_query)) {
            $this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options'],
                                                                     'orders_products_id' => $attributes['orders_products_id'],
                                                                     'guid' => $attributes['guid'],
                                                                     'value' => $attributes['products_options_values'],
                                                                     'prefix' => $attributes['price_prefix'],
                                                                     'price' => $attributes['options_values_price']);

            $subindex++;
          }
        }

        $this->info['tax_groups']["{$this->products[$index]['tax']}"] = '1';

        $index++;
      }
    }
    
        function getOrderData($oID) {
    	global $vamPrice;
    	
    	require_once(DIR_FS_INC . 'vam_get_attributes_model.inc.php');
    	
    	$order_query = "SELECT
	        				products_id,
	        				guid,
	        				orders_products_id,
	        				products_model,
	        				products_name,
	        				final_price,
	        			  	products_shipping_time,
	        				products_quantity
	        				FROM ".TABLE_ORDERS_PRODUCTS."
	        				WHERE orders_id='".(int) $oID."'";
	$order_data = array ();
	$order_query = vam_db_query($order_query);
	while ($order_data_values = vam_db_fetch_array($order_query)) {
		$attributes_query = "SELECT
		        				products_options,
		        				guid,
		        				products_options_values,
		        				price_prefix,
		        				options_values_price
		        				FROM ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES."
		        				WHERE orders_products_id='".(int)$order_data_values['orders_products_id']."'";
		$attributes_data = '';
		$attributes_model = '';
		$attributes_query = vam_db_query($attributes_query);
		while ($attributes_data_values = vam_db_fetch_array($attributes_query)) {
			$attributes_data .= '<br />'.$attributes_data_values['products_options'].': '.$attributes_data_values['products_options_values'];
			$attributes_model .= '<br />'.vam_get_attributes_model($order_data_values['products_id'], $attributes_data_values['products_options_values'],$attributes_data_values['products_options']);

		}
      	$order_data[] = array (
      	'PRODUCTS_ID' => $order_data_values['products_id'], 
      	'PRODUCTS_LINK' => vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($order_data_values['products_id'], $order_data_values['products_name'])),
      	'PRODUCTS_MODEL' => $order_data_values['products_model'], 
      	'PRODUCTS_NAME' => $order_data_values['products_name'],
      	'PRODUCTS_SHIPPING_TIME' => $order_data_values['products_shipping_time'], 
      	'PRODUCTS_ATTRIBUTES' => $attributes_data, 
      	'PRODUCTS_ATTRIBUTES_MODEL' => $attributes_model, 
      	'PRODUCTS_PRICE' => $vamPrice->Format($order_data_values['final_price'], false),
      	'PRODUCTS_SINGLE_PRICE' => $vamPrice->Format($order_data_values['final_price']/$order_data_values['products_quantity'], false), 
      	'PRODUCTS_QTY' => $order_data_values['products_quantity']
      	);

	}
	
	return $order_data;
    	
    }
    
    function getTotalData($oID) {
    	global $vamPrice,$db;
    	
    		// get order_total data
	$oder_total_query = "SELECT
	  					title,
	  					text,
	                    class,
	                    value,
	  					sort_order
	  					FROM ".TABLE_ORDERS_TOTAL."
	  					WHERE orders_id='".(int) $oID."'
	  					ORDER BY sort_order ASC";

	$order_total = array ();
	$oder_total_query = vam_db_query($oder_total_query);
	while ($oder_total_values = vam_db_fetch_array($oder_total_query)) {


		$order_total[] = array (
		
		'TITLE' => $oder_total_values['title'], 
		'CLASS' => $oder_total_values['class'], 
		'VALUE' => $oder_total_values['value'], 
		'TEXT' => $oder_total_values['text']
		
		);

		if ($oder_total_values['class'] = 'ot_total')
			$total = $oder_total_values['value'];

	}
	
	return array(
	
	'data'=>$order_total,
	'total'=>$total
	
	);
	
    }

    function cart() {
      global $currencies,$vamPrice, $sendto, $customer_default_address_id;

      $this->content_type = $_SESSION['cart']->get_content_type();

      if ( ($this->content_type != 'virtual') && ($_SESSION['sendto'] == false) ) {
        $_SESSION['sendto'] = $customer_default_address_id;
      }

      $customer_address_query = vam_db_query("select c.payment_unallowed,c.customers_id,c.shipping_unallowed,c.customers_firstname,c.customers_secondname,c.customers_cid, c.customers_gender,c.customers_lastname, c.customers_telephone, c.customers_email_address, c.orig_reference, c.login_reference, c.customers_personal_discount, ab.entry_company, ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id, z.zone_name, co.countries_id, co.countries_name, co.countries_iso_code_2, co.countries_iso_code_3, co.address_format_id, ab.entry_state from " . TABLE_CUSTOMERS . " c, " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) left join " . TABLE_COUNTRIES . " co on (ab.entry_country_id = co.countries_id) where c.customers_id = '" . $_SESSION['customer_id'] . "' and ab.customers_id = '" . $_SESSION['customer_id'] . "' and c.customers_default_address_id = ab.address_book_id");
      $customer_address = vam_db_fetch_array($customer_address_query);

      $shipping_address_query = vam_db_query("select ab.entry_firstname, ab.entry_secondname, ab.entry_lastname, ab.entry_company, ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id, z.zone_name, ab.entry_country_id, c.countries_id, c.countries_name, c.countries_iso_code_2, c.countries_iso_code_3, c.address_format_id, ab.entry_state from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id) where ab.customers_id = '" . $_SESSION['customer_id'] . "' and ab.address_book_id = '" . $_SESSION['sendto'] . "'");
      $shipping_address = vam_db_fetch_array($shipping_address_query);
      
      $billing_address_query = vam_db_query("select ab.entry_firstname, ab.entry_secondname, ab.entry_lastname, ab.entry_company, ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city, ab.entry_zone_id, z.zone_name, ab.entry_country_id, c.countries_id, c.countries_name, c.countries_iso_code_2, c.countries_iso_code_3, c.address_format_id, ab.entry_state from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) left join " . TABLE_COUNTRIES . " c on (ab.entry_country_id = c.countries_id) where ab.customers_id = '" . $_SESSION['customer_id'] . "' and ab.address_book_id = '" . $_SESSION['billto'] . "'");
      $billing_address = vam_db_fetch_array($billing_address_query);

      $tax_address_query = vam_db_query("select ab.entry_country_id, ab.entry_zone_id from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) where ab.customers_id = '" . $_SESSION['customer_id'] . "' and ab.address_book_id = '" . ($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . "'");
      $tax_address = vam_db_fetch_array($tax_address_query);

      $this->info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,
                          'currency' => $_SESSION['currency'],
                          'currency_value' => $vamPrice->currencies[$_SESSION['currency']]['value'],
                          'payment_method' => $_SESSION['payment'],
                          'cc_type' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_type']) ? $_SESSION['ccard']['cc_type'] : ''),
                          'cc_owner'=>(isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_owner']) ? $_SESSION['ccard']['cc_owner'] : ''),
                          'cc_number' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_number']) ? $_SESSION['ccard']['cc_number'] : ''),
                          'cc_expires' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_expires']) ? $_SESSION['ccard']['cc_expires'] : ''),
                          'cc_start' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_start']) ? $_SESSION['ccard']['cc_start'] : ''),
                          'cc_issue' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_issue']) ? $_SESSION['ccard']['cc_issue'] : ''),
                          'cc_cvv' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_cvv']) ? $_SESSION['ccard']['cc_cvv'] : ''),
                          'shipping_method' => $_SESSION['shipping']['title'],
                          'shipping_cost' => $_SESSION['shipping']['cost'],
                          'comments' => $_SESSION['comments'],
                          'shipping_class'=>$_SESSION['shipping']['id'],
                          'payment_class' => $_SESSION['payment'],
                          );

      if (isset($_SESSION['payment']) && is_object($_SESSION['payment'])) {
        $this->info['payment_method'] = $_SESSION['payment']->title;
        $this->info['payment_class'] = $_SESSION['payment']->title;
        if ( isset($_SESSION['payment']->order_status) && is_numeric($_SESSION['payment']->order_status) && ($_SESSION['payment']->order_status > 0) ) {
          $this->info['order_status'] = $_SESSION['payment']->order_status;
        }
      }

      $this->customer = array('id' => $customer_address['customers_id'],
                              'firstname' => $customer_address['customers_firstname'],
                              'secondname' => $customer_address['customers_secondname'],
                              'lastname' => $customer_address['customers_lastname'],
                              'csID' => $customer_address['customers_cid'],
                              'gender' => $customer_address['customers_gender'],
                              'company' => $customer_address['entry_company'],
                              'street_address' => $customer_address['entry_street_address'],
                              'suburb' => $customer_address['entry_suburb'],
                              'city' => $customer_address['entry_city'],
                              'postcode' => $customer_address['entry_postcode'],
                              'state' => ((vam_not_null($customer_address['entry_state'])) ? $customer_address['entry_state'] : $customer_address['zone_name']),
                              'zone_id' => $customer_address['entry_zone_id'],
                              'country' => array('id' => $customer_address['countries_id'], 'title' => $customer_address['countries_name'], 'iso_code_2' => $customer_address['countries_iso_code_2'], 'iso_code_3' => $customer_address['countries_iso_code_3']),
                              'format_id' => $customer_address['address_format_id'],
                              'telephone' => $customer_address['customers_telephone'],
                              'payment_unallowed' => $customer_address['payment_unallowed'],
                              'shipping_unallowed' => $customer_address['shipping_unallowed'],
                              'email_address' => $customer_address['customers_email_address'],
                              'personal_discount' => $customer_address['customers_personal_discount'],
                              'orig_reference' => $customer_address['orig_reference'],     //********
                              'login_reference' => $customer_address['login_reference']);  //*******

      $this->delivery = array('firstname' => $shipping_address['entry_firstname'],
                              'secondname' => $shipping_address['entry_secondname'],
                              'lastname' => $shipping_address['entry_lastname'],
                              'company' => $shipping_address['entry_company'],
                              'street_address' => $shipping_address['entry_street_address'],
                              'suburb' => $shipping_address['entry_suburb'],
                              'city' => $shipping_address['entry_city'],
                              'postcode' => $shipping_address['entry_postcode'],
                              'state' => ((vam_not_null($shipping_address['entry_state'])) ? $shipping_address['entry_state'] : $shipping_address['zone_name']),
                              'zone_id' => $shipping_address['entry_zone_id'],
                              'country' => array('id' => $shipping_address['countries_id'], 'title' => $shipping_address['countries_name'], 'iso_code_2' => $shipping_address['countries_iso_code_2'], 'iso_code_3' => $shipping_address['countries_iso_code_3']),
                              'country_id' => $shipping_address['entry_country_id'],
                              'format_id' => $shipping_address['address_format_id']);

      $this->billing = array('firstname' => $billing_address['entry_firstname'],
                             'secondname' => $billing_address['entry_secondname'],
                             'lastname' => $billing_address['entry_lastname'],
                             'company' => $billing_address['entry_company'],
                             'street_address' => $billing_address['entry_street_address'],
                             'suburb' => $billing_address['entry_suburb'],
                             'city' => $billing_address['entry_city'],
                             'postcode' => $billing_address['entry_postcode'],
                             'state' => ((vam_not_null($billing_address['entry_state'])) ? $billing_address['entry_state'] : $billing_address['zone_name']),
                             'zone_id' => $billing_address['entry_zone_id'],
                             'country' => array('id' => $billing_address['countries_id'], 'title' => $billing_address['countries_name'], 'iso_code_2' => $billing_address['countries_iso_code_2'], 'iso_code_3' => $billing_address['countries_iso_code_3']),
                             'country_id' => $billing_address['entry_country_id'],
                             'format_id' => $billing_address['address_format_id']);

      $index = 0;
      $products = $_SESSION['cart']->get_products();
      for ($i=0, $n=sizeof($products); $i<$n; $i++) {

        $products_price=$vamPrice->GetPrice($products[$i]['id'],
                                        $format=false,
                                        $products[$i]['quantity'],
                                        $products[$i]['tax_class_id'],
                                        '')+$vamPrice->Format($_SESSION['cart']->attributes_price($products[$i]['id']),false);

        $this->products[$index] = array('qty' => $products[$i]['quantity'],
                                        'name' => $products[$i]['name'],
                                        'guid' => $products[$i]['guid'],
                                        'model' => $products[$i]['model'],
                                        'tax_class_id'=> $products[$i]['tax_class_id'],
                                        'tax' => vam_get_tax_rate($products[$i]['tax_class_id'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']),
                                        'tax_description' => vam_get_tax_description($products[$i]['tax_class_id'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']),
                                        'price' =>  $products_price ,
                            		    'final_price' => $products_price*$products[$i]['quantity'],
                            		    'shipping_time'=>$products[$i]['shipping_time'],
					                    'weight' => $products[$i]['weight'],
					                    'length' => $products[$i]['length'],
					                    'width' => $products[$i]['width'],
					                    'height' => $products[$i]['height'],
					                    'volume' => $products[$i]['volume'],
                                        'id' => $products[$i]['id']);

        if ($products[$i]['attributes']) {
          $subindex = 0;
          foreach ($products[$i]['attributes'] as $option => $value) {
            $attributes_query = vam_db_query("select popt.products_options_name, popt.products_options_type, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . (int)$products[$i]['id'] . "' and pa.options_id = '" . (int)$option . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . (int)$value . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . (int)$_SESSION['languages_id'] . "' and poval.language_id = '" . $_SESSION['languages_id'] . "'");
            $attributes = vam_db_fetch_array($attributes_query);

            if($attributes['products_options_type']=='2' || $attributes['products_options_type']=='3'){
              $attr_value = $products[$i]['attributes_values'][$option];
            } else {
              $attr_value = $attributes['products_options_values_name'];
            }

            $this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options_name'],
                                                                     'value' => $attr_value,
                                                                     'option_id' => $option,
                                                                     'value_id' => $value,
                                                                     'prefix' => $attributes['price_prefix'],
                                                                     'price' => $attributes['options_values_price']);

            $subindex++;
          }
        }

        $shown_price = $this->products[$index]['final_price'];
        $this->info['subtotal'] += $shown_price;
        if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1){
          $shown_price_tax = $shown_price-($shown_price/100 * $_SESSION['customers_status']['customers_status_ot_discount']);
        }

        $products_tax = $this->products[$index]['tax'];
        $products_tax_description = $this->products[$index]['tax_description'];
        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == '1') {
          if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
            $this->info['tax'] += $shown_price_tax - ($shown_price_tax / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
            $this->info['tax_groups'][TAX_ADD_TAX."$products_tax_description"] += (($shown_price_tax /(100+$products_tax)) * $products_tax);
          } else {
            $this->info['tax'] += $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
            $this->info['tax_groups'][TAX_ADD_TAX . "$products_tax_description"] += (($shown_price /(100+$products_tax)) * $products_tax);
          }
        } else {
          if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
            $this->info['tax'] += ($shown_price_tax/100) * ($products_tax);
            $this->info['tax_groups'][TAX_NO_TAX . "$products_tax_description"] += ($shown_price_tax/100) * ($products_tax);
          } else {
            $this->info['tax'] += ($shown_price/100) * ($products_tax);
            $this->info['tax_groups'][TAX_NO_TAX . "$products_tax_description"] += ($shown_price/100) * ($products_tax);
          }
        }
        $index++;
      }

 //$this->info['shipping_cost']=0;
      if ($_SESSION['customers_status']['customers_status_show_price_tax'] == '0') {
        $this->info['total'] = $this->info['subtotal']  + $vamPrice->Format($this->info['shipping_cost'], false,0,true);
        if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1') {
          $this->info['total'] -= ($this->info['subtotal'] /100 * $_SESSION['customers_status']['customers_status_ot_discount']);
        }
      } else {
		
        $this->info['total'] = $this->info['subtotal']  + $vamPrice->Format($this->info['shipping_cost'],false,0,true);
        if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1') {
          $this->info['total'] -= ($this->info['subtotal'] /100 * $_SESSION['customers_status']['customers_status_ot_discount']);
        }
      }
     }

// SMART CHECKOUT BOF
    function cart_noaccount() {
      global $customer_id, $sendto, $billto, $cart, $currency, $vamPrice, $shipping, $payment, $comments, $customer_default_address_id;

      $this->content_type = $cart->get_content_type();

      if ( ($this->content_type != 'virtual') && ($sendto == false) ) {
        $sendto = $customer_default_address_id;
      }


	//get always zone and country data from customers input fields for shipping and customers order data
	$sc_customers_zone_id = $_SESSION['sc_customers_zone_id'];	  
	$sc_customers_countries_id = $_SESSION['sc_customers_country']; 
	
	$sc_customers_zone_data_query = vam_db_query("select zone_name from " . TABLE_ZONES . " where zone_id = '" . (int)$sc_customers_zone_id . "'");
	$sc_customers_zone_data = vam_db_fetch_array($sc_customers_zone_data_query);
	
	$sc_customers_country_data_query = vam_db_query("select countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$sc_customers_countries_id . "'");
	$sc_customers_country_data = vam_db_fetch_array($sc_customers_country_data_query);



 	  
      $this->info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,
                          'currency' => $_SESSION['currency'],
                          'currency_value' => $vamPrice->currencies[$_SESSION['currency']]['value'],
                          'payment_method' => $_SESSION['payment'],
                          'cc_type' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_type']) ? $_SESSION['ccard']['cc_type'] : ''),
                          'cc_owner'=>(isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_owner']) ? $_SESSION['ccard']['cc_owner'] : ''),
                          'cc_number' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_number']) ? $_SESSION['ccard']['cc_number'] : ''),
                          'cc_expires' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_expires']) ? $_SESSION['ccard']['cc_expires'] : ''),
                          'cc_start' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_start']) ? $_SESSION['ccard']['cc_start'] : ''),
                          'cc_issue' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_issue']) ? $_SESSION['ccard']['cc_issue'] : ''),
                          'cc_cvv' => (isset($_SESSION['payment'])=='cc' && isset($_SESSION['ccard']['cc_cvv']) ? $_SESSION['ccard']['cc_cvv'] : ''),
                          'shipping_method' => $_SESSION['shipping']['title'],
                          'shipping_cost' => $_SESSION['shipping']['cost'],
                          'comments' => (vam_session_is_registered('comments') && !empty($comments) ? $comments : ''),
                          'shipping_class'=>$_SESSION['shipping']['id'],
                          'payment_class' => $_SESSION['payment'],
                          );

      if (isset($_SESSION['payment']) && is_object($_SESSION['payment'])) {
        $this->info['payment_method'] = $_SESSION['payment']->title;
        $this->info['payment_class'] = $_SESSION['payment']->title;
        if ( isset($_SESSION['payment']->order_status) && is_numeric($_SESSION['payment']->order_status) && ($_SESSION['payment']->order_status > 0) ) {
          $this->info['order_status'] = $_SESSION['payment']->order_status;
        }
      }
	  
	  
	  //customer data
	  //format_id = from country table, get data from table country
      $this->customer = array('firstname' => $_SESSION['sc_customers_firstname'], 
                              'secondname' => $_SESSION['sc_customers_secondname'], 
                              'lastname' => $_SESSION['sc_customers_lastname'], 
                              'company' => $_SESSION['sc_customers_company'],
                              'street_address' => $_SESSION['sc_customers_street_address'],
                              'suburb' => $_SESSION['sc_customers_suburb'],
                              'city' => $_SESSION['sc_customers_city'],
                              'postcode' => $_SESSION['sc_customers_postcode'],
                              'state' => ((vam_not_null($_SESSION['sc_customers_state'])) ? $_SESSION['sc_customers_state'] : $sc_customers_zone_data['zone_name']),
                              'zone_id' => $_SESSION['sc_customers_zone_id'],
                              'country' => array('id' => $sc_customers_country_data['countries_id'], 'title' => $sc_customers_country_data['countries_name'], 'iso_code_2' => $sc_customers_country_data['countries_iso_code_2'], 'iso_code_3' => $sc_customers_country_data['countries_iso_code_3']),
                              'format_id' => $sc_customers_country_data['address_format_id'], 
                              'telephone' => $_SESSION['sc_customers_telephone'],
                              'email_address' => $_SESSION['sc_customers_email_address']);



      $this->delivery = array('firstname' => $_SESSION['sc_customers_firstname'], 
                              'secondname' => $_SESSION['sc_customers_secondname'],
                              'lastname' => $_SESSION['sc_customers_lastname'],
                              'company' => $_SESSION['sc_customers_company'],
                              'street_address' => $_SESSION['sc_customers_street_address'],
                              'suburb' => $_SESSION['sc_customers_suburb'],
                              'city' => $_SESSION['sc_customers_city'],
                              'postcode' => $_SESSION['sc_customers_postcode'],
                              'state' => ((vam_not_null($_SESSION['sc_customers_state'])) ? $_SESSION['sc_customers_state'] : $sc_customers_zone_data['zone_name']),
                              'zone_id' => $_SESSION['sc_customers_zone_id'],
                              'country' => array('id' => $sc_customers_country_data['countries_id'], 'title' => $sc_customers_country_data['countries_name'], 'iso_code_2' => $sc_customers_country_data['countries_iso_code_2'], 'iso_code_3' => $sc_customers_country_data['countries_iso_code_3']),
                              'country_id' => $_SESSION['sc_customers_country'],
                              'format_id' => $sc_customers_country_data['address_format_id']);







if ($_SESSION['sc_payment_address_selected'] != '1') { //is unchecked - so payment address is different

	//get different zone and country data from customers input fields for billing order data
	$sc_customers_zone_id = $_SESSION['sc_payment_zone_id'];	  
	$sc_customers_countries_id = $_SESSION['sc_payment_country']; 
	
	$sc_customers_zone_data_query = vam_db_query("select zone_name from " . TABLE_ZONES . " where zone_id = '" . (int)$sc_customers_zone_id . "'");
	$sc_customers_zone_data = vam_db_fetch_array($sc_customers_zone_data_query);
	
	$sc_customers_country_data_query = vam_db_query("select countries_id, countries_name, countries_iso_code_2, countries_iso_code_3, address_format_id from " . TABLE_COUNTRIES . " where countries_id = '" . (int)$sc_customers_countries_id . "'");
	$sc_customers_country_data = vam_db_fetch_array($sc_customers_country_data_query);

	$sc_sess_firstname = $_SESSION['sc_payment_firstname'];
	$sc_sess_secondname = $_SESSION['sc_payment_secondname'];
	$sc_sess_lastname = $_SESSION['sc_payment_lastname'];
	$sc_sess_company = $_SESSION['sc_payment_company'];
	$sc_sess_street_address = $_SESSION['sc_payment_street_address'];
	$sc_sess_suburb = $_SESSION['sc_payment_suburb'];
	$sc_sess_city = $_SESSION['sc_payment_city'];
	$sc_sess_postcode = $_SESSION['sc_payment_postcode'];
	$sc_sess_state = $_SESSION['sc_payment_state'];
	$sc_sess_zone_id = $_SESSION['sc_payment_zone_id'];
	$sc_sess_country = $_SESSION['sc_payment_country'];
} else { //payment address is same as shipping address
	$sc_sess_firstname = $_SESSION['sc_customers_firstname'];
	$sc_sess_secondname = $_SESSION['sc_customers_secondname'];
	$sc_sess_lastname = $_SESSION['sc_customers_lastname'];
	$sc_sess_company = $_SESSION['sc_customers_company'];
	$sc_sess_street_address = $_SESSION['sc_customers_street_address'];
	$sc_sess_suburb = $_SESSION['sc_customers_suburb'];
	$sc_sess_city = $_SESSION['sc_customers_city'];
	$sc_sess_postcode = $_SESSION['sc_customers_postcode'];
	$sc_sess_state = $_SESSION['sc_customers_state'];
	$sc_sess_zone_id = $_SESSION['sc_customers_zone_id'];
	$sc_sess_country = $_SESSION['sc_customers_country'];
}




      $this->billing = array('firstname' => $sc_sess_firstname, //$billing_address['entry_firstname'],
                             'secondname' => $sc_sess_secondname,
                             'lastname' => $sc_sess_lastname,
                             'company' => $sc_sess_company,
                             'street_address' => $sc_sess_street_address,
                             'suburb' => $sc_sess_suburb,
                             'city' => $sc_sess_city,
                             'postcode' => $sc_sess_postcode,
                             'state' => ((vam_not_null($sc_sess_state)) ? $sc_sess_state : $sc_customers_zone_data['zone_name']), 
                             'zone_id' => $sc_sess_zone_id,
                             'country' => array('id' => $sc_customers_country_data['countries_id'], 'title' => $sc_customers_country_data['countries_name'], 'iso_code_2' => $sc_customers_country_data['countries_iso_code_2'], 'iso_code_3' => $sc_customers_country_data['countries_iso_code_3']), 
                             'country_id' => $sc_sess_country,
                             'format_id' => $sc_customers_country_data['address_format_id']); 



	  //get products
      $index = 0;
      $products = $_SESSION['cart']->get_products();
      for ($i=0, $n=sizeof($products); $i<$n; $i++) {

        $products_price=$vamPrice->GetPrice($products[$i]['id'],
                                        $format=false,
                                        $products[$i]['quantity'],
                                        $products[$i]['tax_class_id'],
                                        '')+$vamPrice->Format($_SESSION['cart']->attributes_price($products[$i]['id']),false);

        $this->products[$index] = array('qty' => $products[$i]['quantity'],
                                        'name' => $products[$i]['name'],
                                        'guid' => $products[$i]['guid'],
                                        'model' => $products[$i]['model'],
                                        'tax_class_id'=> $products[$i]['tax_class_id'],
                                        'tax' => vam_get_tax_rate($products[$i]['tax_class_id'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']),
                                        'tax_description' => vam_get_tax_description($products[$i]['tax_class_id'], $tax_address['entry_country_id'], $tax_address['entry_zone_id']),
                                        'price' =>  $products_price ,
                            		    'final_price' => $products_price*$products[$i]['quantity'],
                            		    'shipping_time'=>$products[$i]['shipping_time'],
					                    'weight' => $products[$i]['weight'],
					                    'length' => $products[$i]['length'],
					                    'width' => $products[$i]['width'],
					                    'height' => $products[$i]['height'],
					                    'volume' => $products[$i]['volume'],
                                        'id' => $products[$i]['id']);

        if ($products[$i]['attributes']) {
          $subindex = 0;
          foreach ($products[$i]['attributes'] as $option => $value) {
            $attributes_query = vam_db_query("select popt.products_options_name, popt.products_options_type, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_OPTIONS_VALUES . " poval, " . TABLE_PRODUCTS_ATTRIBUTES . " pa where pa.products_id = '" . (int)$products[$i]['id'] . "' and pa.options_id = '" . (int)$option . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . (int)$value . "' and pa.options_values_id = poval.products_options_values_id and popt.language_id = '" . (int)$_SESSION['languages_id'] . "' and poval.language_id = '" . (int)$_SESSION['languages_id'] . "'");
            $attributes = vam_db_fetch_array($attributes_query);

            if($attributes['products_options_type']=='2' || $attributes['products_options_type']=='3'){
              $attr_value = $products[$i]['attributes_values'][$option];
            } else {
              $attr_value = $attributes['products_options_values_name'];
            }

            $this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options_name'],
                                                                     'value' => $attr_value,
                                                                     'option_id' => $option,
                                                                     'value_id' => $value,
                                                                     'prefix' => $attributes['price_prefix'],
                                                                     'price' => $attributes['options_values_price']);

            $subindex++;
          }
        }

        $shown_price = $this->products[$index]['final_price'];
        $this->info['subtotal'] += $shown_price;
        if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1){
          $shown_price_tax = $shown_price-($shown_price/100 * $_SESSION['customers_status']['customers_status_ot_discount']);
        }

        $products_tax = $this->products[$index]['tax'];
        $products_tax_description = $this->products[$index]['tax_description'];
        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == '1') {
          if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
            $this->info['tax'] += $shown_price_tax - ($shown_price_tax / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
            $this->info['tax_groups'][TAX_ADD_TAX."$products_tax_description"] += (($shown_price_tax /(100+$products_tax)) * $products_tax);
          } else {
            $this->info['tax'] += $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
            $this->info['tax_groups'][TAX_ADD_TAX . "$products_tax_description"] += (($shown_price /(100+$products_tax)) * $products_tax);
          }
        } else {
          if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
            $this->info['tax'] += ($shown_price_tax/100) * ($products_tax);
            $this->info['tax_groups'][TAX_NO_TAX . "$products_tax_description"] += ($shown_price_tax/100) * ($products_tax);
          } else {
            $this->info['tax'] += ($shown_price/100) * ($products_tax);
            $this->info['tax_groups'][TAX_NO_TAX . "$products_tax_description"] += ($shown_price/100) * ($products_tax);
          }
        }
        $index++;
      }

 //$this->info['shipping_cost']=0;
      if ($_SESSION['customers_status']['customers_status_show_price_tax'] == '0') {
        $this->info['total'] = $this->info['subtotal']  + $vamPrice->Format($this->info['shipping_cost'], false,0,true);
        if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1') {
          $this->info['total'] -= ($this->info['subtotal'] /100 * $_SESSION['customers_status']['customers_status_ot_discount']);
        }
      } else {
		
        $this->info['total'] = $this->info['subtotal']  + $vamPrice->Format($this->info['shipping_cost'],false,0,true);
        if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1') {
          $this->info['total'] -= ($this->info['subtotal'] /100 * $_SESSION['customers_status']['customers_status_ot_discount']);
        }
      }
     }
	
  } //end class
// SMART CHECKOUT BOF  
?>
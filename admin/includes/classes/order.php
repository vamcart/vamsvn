<?php
/* --------------------------------------------------------------
   $Id: order.php 1037 2007-02-08 12:17:21Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(order.php,v 1.6 2003/02/06); www.oscommerce.com 
   (c) 2003	 nextcommerce (order.php,v 1.12 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (order.php,v 1.12 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------
   Third Party contribution:

   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   --------------------------------------------------------------*/
defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );
  class order {
    var $info, $totals, $products, $customer, $delivery;

    function __construct($order_id) {
      $this->info = array();
      $this->totals = array();
      $this->products = array();
      $this->customer = array();
      $this->delivery = array();

      $this->query($order_id);
    }

    function query($order_id) {
      $order_query = vam_db_query("select orders_id, customers_name,
                                   customers_firstname,
                                   customers_secondname,
                                   customers_lastname,      
                                   customers_cid,
                                   customers_id,
                                   customers_vat_id,
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
                                   payment_class,
				                  shipping_class,
				                  shipping_method,
				                  cc_type,
                                   cc_owner,
                                   cc_number,
                                   cc_expires,
                                   cc_cvv,
                                   comments,
                                   currency,
                                   currency_value,
                                   date_purchased,
                                   orders_status,
                                   last_modified,
                                   orig_reference, 
                                   login_reference,
                                   customers_status,
                                   customers_status_name,
                                   customers_status_image,
                                   customers_ip,
                                   language,
                                   customers_status_discount
                                   from " . TABLE_ORDERS . " where
                                   orders_id = '" . vam_db_input($order_id) . "'");

      $order = vam_db_fetch_array($order_query);

      $totals_query = vam_db_query("select title, text from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . vam_db_input($order_id) . "' order by sort_order");
      while ($totals = vam_db_fetch_array($totals_query)) {
        $this->totals[] = array('title' => $totals['title'],
                                'text' => $totals['text']);
      }

      $this->info = array('id' => $order['orders_id'],
                          'currency' => $order['currency'],
                          'currency_value' => $order['currency_value'],
                          'payment_method' => $order['payment_method'],
                          'payment_class' => $order['payment_class'],
                          'shipping_class' => $order['shipping_class'],
                          'shipping_method' => $order['shipping_method'],
                          'status' => $order['customers_status'],
                          'status_name' => $order['customers_status_name'],
                          'status_image' => $order['customers_status_image'],
                          'status_discount' => $order['customers_status_discount'],
                          'cc_type' => $order['cc_type'],
                          'cc_owner' => $order['cc_owner'],
                          'cc_number' => $order['cc_number'],
                          'cc_expires' => $order['cc_expires'],
                          'cc_cvv' => $order['cc_cvv'],
                          'comments' => $order['comments'],
                          'language' => $order['language'],
                          'date_purchased' => $order['date_purchased'],
                          'orders_status' => $order['orders_status'],
                          'last_modified' => $order['last_modified']);
                          
      $this->customer = array('name' => $order['customers_name'],
                              'firstname' => $order['customers_firstname'],
                              'secondname' => $order['customers_secondname'],
                              'lastname' => $order['customers_lastname'],
                              'company' => $order['customers_company'],
                              'csID' => $order['customers_cid'],
                              'vat_id' => $order['customers_vat_id'],                               
                              'shop_id' => $order['shop_id'], 
                              'ID' => $order['customers_id'],
                              'cIP' => $order['customers_ip'],
                              'street_address' => $order['customers_street_address'],
                              'suburb' => $order['customers_suburb'],
                              'city' => $order['customers_city'],
                              'postcode' => $order['customers_postcode'],
                              'state' => $order['customers_state'],
                              'country' => $order['customers_country'],
                              'format_id' => $order['customers_address_format_id'],
                              'telephone' => $order['customers_telephone'],
                              'email_address' => $order['customers_email_address'],
                              'orig_reference' => $order['orig_reference'],
                              'login_reference' => $order['login_reference']);

      $this->delivery = array('name' => $order['delivery_name'],
                              'company' => $order['delivery_company'],
                              'street_address' => $order['delivery_street_address'],
                              'suburb' => $order['delivery_suburb'],
                              'city' => $order['delivery_city'],
                              'postcode' => $order['delivery_postcode'],
                              'state' => $order['delivery_state'],
                              'country' => $order['delivery_country'],
                              'format_id' => $order['delivery_address_format_id']);

      $this->billing = array('name' => $order['billing_name'],
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
                                        'discount' => $orders_products['products_discount_made'],
                                        'final_price' => $orders_products['final_price'],
                                        'allow_tax' => $orders_products['allow_tax']);

        $subindex = 0;
        $attributes_query = vam_db_query("select orders_products_id, guid, products_options, products_options_values, options_values_price, price_prefix from " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " where orders_id = '" . vam_db_input($order_id) . "' and orders_products_id = '" . $orders_products['orders_products_id'] . "'");
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
		        				WHERE orders_products_id='".$order_data_values['orders_products_id']."'";
		$attributes_data = '';
		$attributes_model = '';
		$attributes_query = vam_db_query($attributes_query);
		while ($attributes_data_values = vam_db_fetch_array($attributes_query)) {
			$attributes_data .= '<br />'.$attributes_data_values['products_options'].': '.$attributes_data_values['products_options_values'];
			$attributes_model .= '<br />'.vam_get_attributes_model($order_data_values['products_id'], $attributes_data_values['products_options_values'],$attributes_data_values['products_options']);

		}
      	$order_data[] = array ('PRODUCTS_ID' => $order_data_values['products_id'], 'PRODUCTS_MODEL' => $order_data_values['products_model'], 'PRODUCTS_NAME' => $order_data_values['products_name'],'PRODUCTS_SHIPPING_TIME' => $order_data_values['products_shipping_time'], 'PRODUCTS_ATTRIBUTES' => $attributes_data, 'PRODUCTS_ATTRIBUTES_MODEL' => $attributes_model, 'PRODUCTS_PRICE' => $vamPrice->Format($order_data_values['final_price'], false),'PRODUCTS_SINGLE_PRICE' => $vamPrice->Format($order_data_values['final_price']/$order_data_values['products_quantity'], false), 'PRODUCTS_QTY' => $order_data_values['products_quantity']);

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
    
  }
?>
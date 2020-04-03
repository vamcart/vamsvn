<?php
/*
  $Id: edit_orders.php v5.0 08/05/2007 djmonkey1 Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License http://www.gnu.org/licenses/
  
    Order Editor is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
  
  For Order Editor support or to post bug reports, feature requests, etc, please visit the Order Editor support thread:
  http://forums.oscommerce.com/index.php?showtopic=54032
  
  The original Order Editor contribution was written by Jonathan Hilgeman of SiteCreative.com
  
  Much of Order Editor 5.0 is based on the order editing file found within the MOECTOE Suite Public Betas written by Josh DeChant
  
  Many, many people have contributed to Order Editor in many, many ways.  Thanks go to all- it is truly a community project.  
  
*/

  require('includes/application_top.php');

require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.phpmailer.php');
if (EMAIL_TRANSPORT == 'smtp')
require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.smtp.php');
require_once (DIR_FS_INC.'vam_php_mail.inc.php');
require_once (DIR_FS_INC.'vam_add_tax.inc.php');
require_once (DIR_FS_INC.'changedataout.inc.php');
require_once (DIR_FS_INC.'vam_validate_vatid_status.inc.php');
require_once (DIR_FS_INC.'vam_get_attributes_model.inc.php');

require_once (DIR_FS_INC.'vam_send_answer_template.inc.php');

  $PHP_SELF = (((strlen(ini_get('cgi.fix_pathinfo')) > 0) && ((bool)ini_get('cgi.fix_pathinfo') == false)) || !isset($_SERVER['SCRIPT_NAME'])) ? basename($_SERVER['PHP_SELF']) : basename($_SERVER['SCRIPT_NAME']);

	$vamTemplate = new vamTemplate;
	
//b2b
  $cus_id=intval($_GET['cID']);
  if(!$cus_id){$cus_id=intval($_POST['cID']);}

//b2b

require_once (DIR_FS_CATALOG.DIR_WS_CLASSES.'vam_price.php');

  // include the sppropriate functions & classes
  include('order_editor/functions.php');
  include('order_editor/cart.php');
  include('order_editor/order.php');
  include('order_editor/shipping.php');
  include('order_editor/http_client.php');

   
  // Include currencies class
  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

 
 //orders status
  $orders_statuses = array();
  $orders_status_array = array();
  $orders_status_query = vam_db_query("SELECT orders_status_id, orders_status_name 
                                       FROM " . TABLE_ORDERS_STATUS . " 
									   WHERE language_id = '" . (int)$_SESSION['languages_id'] . "'");
									   
  while ($orders_status = vam_db_fetch_array($orders_status_query)) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                               'text' => $orders_status['orders_status_name']);
    
	$orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
  }

  $action = (isset($_GET['action']) ? $_GET['action'] : 'edit');

  if (isset($action)) {
    switch ($action) {
    
    ////
    // Update Order
      case 'update_order':
        $oID = vam_db_prepare_input($_GET['oID']);
        $status = vam_db_prepare_input($_POST['status']);
        
        // Set this Session's variables
        if (isset($_POST['billing_same_as_customer'])) $_SESSION['billing_same_as_customer'] = $_POST['billing_same_as_customer'];
        if (isset($_POST['shipping_same_as_billing'])) $_SESSION['shipping_same_as_billing'] = $_POST['shipping_same_as_billing'];
		
        // Update Order Info  
		//figure out the new currency value
		$currency_value_query = vam_db_query("SELECT value 
		                                      FROM " . TABLE_CURRENCIES . " 
											  WHERE code = '" . $_POST['update_info_payment_currency'] . "'");
		$currency_value = vam_db_fetch_array($currency_value_query);

		//figure out the country, state
		$update_customer_state = vam_get_zone_name($_POST['update_customer_country_id'], $_POST['update_customer_zone_id'], $_POST['update_customer_state']);
        $update_customer_country = vam_get_country_name($_POST['update_customer_country_id']);
        $update_billing_state = vam_get_zone_name($_POST['update_billing_country_id'], $_POST['update_billing_zone_id'], $_POST['update_billing_state']);
        $update_billing_country = vam_get_country_name($_POST['update_billing_country_id']);
        $update_delivery_state = vam_get_zone_name($_POST['update_delivery_country_id'], $_POST['update_delivery_zone_id'], $_POST['update_delivery_state']);
        $update_delivery_country = vam_get_country_name($_POST['update_delivery_country_id']);
		
        $sql_data_array = array(
		'customers_name' => vam_db_input(vam_db_prepare_input($_POST['update_customer_name'])),
        'customers_company' => vam_db_input(vam_db_prepare_input($_POST['update_customer_company'])),
        'customers_street_address' => vam_db_input(vam_db_prepare_input($_POST['update_customer_street_address'])),
        'customers_suburb' => vam_db_input(vam_db_prepare_input($_POST['update_customer_suburb'])),
        'customers_city' => vam_db_input(vam_db_prepare_input($_POST['update_customer_city'])),
        'customers_state' => vam_db_input(vam_db_prepare_input($update_customer_state)),
        'customers_postcode' => vam_db_input(vam_db_prepare_input($_POST['update_customer_postcode'])),
        'customers_country' => vam_db_input(vam_db_prepare_input($update_customer_country)),
        'customers_telephone' => vam_db_input(vam_db_prepare_input($_POST['update_customer_telephone'])),
        'customers_email_address' => vam_db_input(vam_db_prepare_input($_POST['update_customer_email_address'])),
                                
		'billing_name' => vam_db_input(vam_db_prepare_input(((isset($_POST['billing_same_as_customer']) && $_POST['billing_same_as_customer'] == 'on') ? $_POST['update_customer_name'] : $_POST['update_billing_name']))),
        'billing_company' => vam_db_input(vam_db_prepare_input(((isset($_POST['billing_same_as_customer']) && $_POST['billing_same_as_customer'] == 'on') ? $_POST['update_customer_company'] : $_POST['update_billing_company']))),
        'billing_street_address' => vam_db_input(vam_db_prepare_input(((isset($_POST['billing_same_as_customer']) && $_POST['billing_same_as_customer'] == 'on') ? $_POST['update_customer_street_address'] : $_POST['update_billing_street_address']))),
        'billing_suburb' => vam_db_input(vam_db_prepare_input(((isset($_POST['billing_same_as_customer']) && $_POST['billing_same_as_customer'] == 'on') ? $_POST['update_customer_suburb'] : $_POST['update_billing_suburb']))),
        'billing_city' => vam_db_input(vam_db_prepare_input(((isset($_POST['billing_same_as_customer']) && $_POST['billing_same_as_customer'] == 'on') ? $_POST['update_customer_city'] : $_POST['update_billing_city']))),
        'billing_state' => vam_db_input(vam_db_prepare_input(((isset($_POST['billing_same_as_customer']) && $_POST['billing_same_as_customer'] == 'on') ? $update_customer_state : $update_billing_state))),
        'billing_postcode' => vam_db_input(vam_db_prepare_input(((isset($_POST['billing_same_as_customer']) && $_POST['billing_same_as_customer'] == 'on') ? $_POST['update_customer_postcode'] : $_POST['update_billing_postcode']))),
        'billing_country' => vam_db_input(vam_db_prepare_input(((isset($_POST['billing_same_as_customer']) && $_POST['billing_same_as_customer'] == 'on') ? $update_customer_country : $update_billing_country))),
								
								
	'delivery_name' => vam_db_input(vam_db_prepare_input(((isset($_POST['shipping_same_as_billing']) && $_POST['shipping_same_as_billing'] == 'on') ? (($_POST['billing_same_as_customer'] == 'on') ? $_POST['update_customer_name'] : $_POST['update_billing_name']) : $_POST['update_delivery_name']))),
    'delivery_company' => vam_db_input(vam_db_prepare_input(((isset($_POST['shipping_same_as_billing']) && $_POST['shipping_same_as_billing'] == 'on') ? (($_POST['billing_same_as_customer'] == 'on') ? $_POST['update_customer_company'] : $_POST['update_billing_company']) : $_POST['update_delivery_company']))),
    'delivery_street_address' => vam_db_input(vam_db_prepare_input(((isset($_POST['shipping_same_as_billing']) && $_POST['shipping_same_as_billing'] == 'on') ? (($_POST['billing_same_as_customer'] == 'on') ? $_POST['update_customer_street_address'] : $_POST['update_billing_street_address']) : $_POST['update_delivery_street_address']))),
    'delivery_suburb' => vam_db_input(vam_db_prepare_input(((isset($_POST['shipping_same_as_billing']) && $_POST['shipping_same_as_billing'] == 'on') ? (($_POST['billing_same_as_customer'] == 'on') ? $_POST['update_customer_suburb'] : $_POST['update_billing_suburb']) : $_POST['update_delivery_suburb']))),
    'delivery_city' => vam_db_input(vam_db_prepare_input(((isset($_POST['shipping_same_as_billing']) && $_POST['shipping_same_as_billing'] == 'on') ? (($_POST['billing_same_as_customer'] == 'on') ? $_POST['update_customer_city'] : $_POST['update_billing_city']) : $_POST['update_delivery_city']))),
    'delivery_state' => vam_db_input(vam_db_prepare_input(((isset($_POST['shipping_same_as_billing']) && $_POST['shipping_same_as_billing'] == 'on') ? (($_POST['billing_same_as_customer'] == 'on') ? $update_customer_state : $update_billing_state) : $update_delivery_state))),
    'delivery_postcode' => vam_db_input(vam_db_prepare_input(((isset($_POST['shipping_same_as_billing']) && $_POST['shipping_same_as_billing'] == 'on') ? (($_POST['billing_same_as_customer'] == 'on') ? $_POST['update_customer_postcode'] : $_POST['update_billing_postcode']) : $_POST['update_delivery_postcode']))),
    'delivery_country' => vam_db_input(vam_db_prepare_input(((isset($_POST['shipping_same_as_billing']) && $_POST['shipping_same_as_billing'] == 'on') ? (($_POST['billing_same_as_customer'] == 'on') ? $update_customer_country : $update_billing_country) : $update_delivery_country))),
                                
	'payment_class' => vam_db_input(vam_db_prepare_input($_POST['update_info_payment_method'])),
    'currency' => vam_db_input(vam_db_prepare_input($_POST['update_info_payment_currency'])),
    'currency_value' => vam_db_input(vam_db_prepare_input($currency_value['value'])),
    'cc_type' => vam_db_prepare_input($_POST['update_info_cc_type']),
    'cc_owner' => vam_db_prepare_input($_POST['update_info_cc_owner']),
	'cc_number' => vam_db_input(vam_db_prepare_input($_POST['update_info_cc_number'])),
    'cc_expires' => vam_db_prepare_input($_POST['update_info_cc_expires']),
    'last_modified' => 'now()');

        vam_db_perform(TABLE_ORDERS, $sql_data_array, 'update', 'orders_id = \'' . vam_db_input($oID) . '\'');
        $order_updated = true;
        
    
	// UPDATE STATUS HISTORY & SEND EMAIL TO CUSTOMER IF NECESSARY #####

    $check_status_query = vam_db_query("
	                      SELECT customers_name, customers_email_address, orders_status, date_purchased 
	                      FROM " . TABLE_ORDERS . " 
						  WHERE orders_id = '" . (int)$oID . "'");
						  
    $check_status = vam_db_fetch_array($check_status_query); 
	
  if (($check_status['orders_status'] != $_POST['status']) || (vam_not_null($_POST['comments']))) {

        vam_db_query("UPDATE " . TABLE_ORDERS . " SET 
					  orders_status = '" . vam_db_input($_POST['status']) . "', 
                      last_modified = now() 
                      WHERE orders_id = '" . (int)$oID . "'");
		
		 // Notify Customer ?
      $customer_notified = '0';
			if (isset($_POST['notify']) && ($_POST['notify'] == 'on')) {
			  $notify_comments = '';
			  if (isset($_POST['notify_comments']) && ($_POST['notify_comments'] == 'on')) {
			    $notify_comments = $_GET['comments'];
			  }

				// assign language to template for caching
				$vamTemplate->assign('language', $_SESSION['language']);
				$vamTemplate->caching = false;

				$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
				$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

				$vamTemplate->assign('NAME', $check_status['customers_name']);
				$vamTemplate->assign('ORDER_NR', $_GET['oID']);
				$vamTemplate->assign('ORDER_LINK', vam_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id='.$oID, 'SSL'));
				$vamTemplate->assign('ORDER_DATE', vam_date_long($check_status['date_purchased']));
				$vamTemplate->assign('NOTIFY_COMMENTS', ' '.$notify_comments);
				$vamTemplate->assign('ORDER_STATUS', $orders_status_array[$_GET['status']]);

				$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/change_order_mail.html');
				$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/change_order_mail.txt');

            // create subject
           $billing_subject = str_replace('{$nr}', $oID, EMAIL_BILLING_SUBJECT);

				vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $check_status['customers_email_address'], $check_status['customers_name'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $billing_subject, $html_mail, $txt_mail);

				if (defined('AVISOSMS_EMAIL') && AVISOSMS_EMAIL != '') {

				$html_mail_sms = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/change_order_mail_sms.html');
				$txt_mail_sms = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/change_order_mail_sms.txt');

				// sms to customer
				vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, AVISOSMS_EMAIL, $check_status['customers_name'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $check_status['customers_telephone'], $html_mail_sms, $txt_mail_sms);
				}
				
				//Send answer template 
				vam_send_answer_template($oID,$_GET['status'],'on','on');
							  
			  $customer_notified = '1';
			}			  
          		
			vam_db_query("INSERT into " . TABLE_ORDERS_STATUS_HISTORY . " 
			(orders_id, orders_status_id, date_added, customer_notified, comments) 
			values ('" . vam_db_input($_GET['oID']) . "', 
				'" . vam_db_input($_POST['status']) . "', 
				now(), 
				" . vam_db_input($customer_notified) . ", 
				'" . vam_db_input(vam_db_prepare_input($_POST['comments']))  . "')");
			}

        
        // Update Products
        if (is_array($_POST['update_products'])) {
          foreach($_POST['update_products'] as $orders_products_id => $products_details) {
		  
		  	//  Update Inventory Quantity
			$order_query = vam_db_query("
			SELECT products_id, products_quantity 
			FROM " . TABLE_ORDERS_PRODUCTS . " 
			WHERE orders_id = '" . (int)$oID . "'
			AND orders_products_id = '" . (int)$orders_products_id . "'");
			$order_products = vam_db_fetch_array($order_query);
			
			// First we do a stock check 
			
			if ($products_details['qty'] != $order_products['products_quantity']){
			$quantity_difference = ($products_details['qty'] - $order['products_quantity']);
				if (STOCK_LIMITED == 'true'){
				    vam_db_query("UPDATE " . TABLE_PRODUCTS . " SET 
					products_quantity = products_quantity - " . $quantity_difference . ",
					products_ordered = products_ordered + " . $quantity_difference . " 
					WHERE products_id = '" . (int)$order_products['products_id'] . "'");
					} else {
					vam_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_ordered = products_ordered + " . $quantity_difference . "
					WHERE products_id = '" . (int)$order_products['products_id'] . "'");
				}
			}

		 
		   if ( (isset($products_details['delete'])) && ($products_details['delete'] == 'on') ) {
		     //check first to see if product should be deleted
		   
		   			 //update quantities first
			       if (STOCK_LIMITED == 'true'){
				    vam_db_query("UPDATE " . TABLE_PRODUCTS . " SET 
					products_quantity = products_quantity + " . $products_details["qty"] . ",
					products_ordered = products_ordered - " . $products_details["qty"] . " 
					WHERE products_id = '" . (int)$order_products['products_id'] . "'");
					} else {
					vam_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_ordered = products_ordered - " . $products_details["qty"] . "
					WHERE products_id = '" . (int)$order_products['products_id'] . "'");
					}
		   
                    vam_db_query("DELETE FROM " . TABLE_ORDERS_PRODUCTS . "  
	                              WHERE orders_id = '" . (int)$oID . "'
					              AND orders_products_id = '" . (int)$orders_products_id . "'");
      
	                vam_db_query("DELETE FROM " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
	                              WHERE orders_id = '" . (int)$oID . "'
                                  AND orders_products_id = '" . (int)$orders_products_id . "'");
	                
					vam_db_query("DELETE FROM " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . "
	                              WHERE orders_id = '" . (int)$oID . "'
                                  AND orders_products_id = '" . (int)$orders_products_id . "'");
           
		   } else {
		     //not deleted=> updated
		   
            // Update orders_products Table
             	$Query = "UPDATE " . TABLE_ORDERS_PRODUCTS . " SET
					products_model = '" . $products_details["model"] . "',
					products_name = '" . oe_html_quotes($products_details["name"]) . "',
					products_price = '" . $products_details["price"] . "',
					final_price = '" . $products_details["price"]*$products_details["qty"] . "',
					products_tax = '" . $products_details["tax"] . "',
					products_quantity = '" . $products_details["qty"] . "',
					allow_tax = '0'
					WHERE orders_id = '" . (int)$oID . "'
					AND orders_products_id = '$orders_products_id';";
				vam_db_query($Query);
          
              // Update Any Attributes
				// Update Any Attributes
				if(isset($products_details['attributes'])) { 
				  foreach($products_details['attributes'] as $orders_products_attributes_id => $attributes_details) {
					$Query = "UPDATE " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " set
						products_options = '" . $attributes_details["option"] . "',
						products_options_values = '" . $attributes_details["value"] . "',
						options_values_price ='" . $attributes_details["price"] . "',
						price_prefix ='" . $attributes_details["prefix"] . "'
						where orders_products_attributes_id = '$orders_products_attributes_id';";
						vam_db_query($Query);
					}//end of foreach($products_details["attributes"]
				}// end of if(isset($products_details[attributes]))

            } //end if/else product details delete= on
          } //end foreach post update products
        }//end if is-array update products
		
	
	  //update any downloads that may exist
      if (is_array($_POST['update_downloads'])) {
	  foreach($_POST['update_downloads'] as $orders_products_download_id => $download_details) {
		$Query = "UPDATE " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " SET
					orders_products_filename = '" . $download_details["filename"] . "',
					download_maxdays = '" . $download_details["maxdays"] . "',
					download_count = '" . $download_details["maxcount"] . "'
					WHERE orders_id = '" . (int)$oID . "'
					AND orders_products_download_id = '$orders_products_download_id';";
					vam_db_query($Query);
			}
		}	//end downloads
		
						
				//delete or update comments
		      if (is_array($_POST['update_comments'])) {
	              foreach($_POST['update_comments'] as $orders_status_history_id => $comments_details) {
	  
	                  if (isset($comments_details['delete'])){
		
			             $Query = "DELETE FROM " . TABLE_ORDERS_STATUS_HISTORY . " 
			                              WHERE orders_id = '" . (int)$oID . "' 
			                              AND orders_status_history_id = '$orders_status_history_id';";
				                          vam_db_query($Query);
				
				        } else {

		                 $Query = "UPDATE " . TABLE_ORDERS_STATUS_HISTORY . " SET
					               comments = '" . $comments_details["comments"] . "'
					               WHERE orders_id = '" . (int)$oID . "'
					               AND orders_status_history_id = '$orders_status_history_id';";
					               vam_db_query($Query);
				        }
				    }	
				}//end comments update section

      $shipping = array();
      
      if (is_array($_POST['update_totals'])) {
        foreach($_POST['update_totals'] as $total_index => $total_details) {
          extract($total_details, EXTR_PREFIX_ALL, "ot");
          if ($ot_class == "ot_shipping") {
           
               $shipping['cost'] = $ot_value;
               $shipping['title'] = $ot_title;
               $shipping['id'] = $ot_id;
			
		  } // end if ($ot_class == "ot_shipping")
        } //end foreach
	  } //end if is_array

       if (vam_not_null($shipping['id'])) {
   vam_db_query("UPDATE " . TABLE_ORDERS . " SET shipping_method = '" . $shipping['title'] . "' , shipping_class ='".$shipping['id']."' WHERE orders_id = '" . (int)$oID . "'");
       }

        $order = new manualOrder($oID);
        
      $vamPrice = new vamPrice($order->info['currency'], $order->info['status'],$order->customer['ID']);
        
        $order->adjust_zones();

        $cart = new manualCart();
        $cart->restore_contents($oID);
        $total_count = $cart->count_contents();
        $total_weight = $cart->show_weight();

        // Get the shipping quotes- if we don't have shipping quotes shipping tax calculation can't happen
        $shipping_modules = new shipping;
        $shipping_quotes = $shipping_modules->quote();

		if (DISPLAY_PRICE_WITH_TAX == 'true') {//extract the base shipping cost or the ot_shipping module will add tax to it again
		   $module = substr($GLOBALS['shipping']['id'], 0, strpos($GLOBALS['shipping']['id'], '_'));
		   $tax = vam_get_tax_rate($GLOBALS[$module]->tax_class, $order->delivery['country']['id'], $order->delivery['zone_id']);
		   $order->info['total'] -= ( $order->info['shipping_cost'] - ($order->info['shipping_cost'] / (1 + ($tax /100))) );
           $order->info['shipping_cost'] = ($order->info['shipping_cost'] / (1 + ($tax /100)));
		   }

		//this is where we call the order total modules
		require( 'order_editor/order_total.php');
		$order_total_modules = new order_total();
        $order_totals = $order_total_modules->process();  

        $current_ot_totals_array = array();
		$current_ot_titles_array = array();
        $current_ot_totals_query = vam_db_query("select class, title from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$oID . "' order by sort_order");
        while ($current_ot_totals = vam_db_fetch_array($current_ot_totals_query)) {
          $current_ot_totals_array[] = $current_ot_totals['class'];
		  $current_ot_titles_array[] = strip_tags($current_ot_totals['title']);
        }

		vam_db_query("DELETE FROM " . TABLE_ORDERS_TOTAL . " WHERE orders_id = '" . (int)$oID . "'");

        $j=1; //giving something a sort order of 0 ain't my bag baby
		$new_order_totals = array();

	    if (is_array($_POST['update_totals'])) { //1
          foreach($_POST['update_totals'] as $total_index => $total_details) { //2
            extract($total_details, EXTR_PREFIX_ALL, "ot");
            if (!strstr($ot_class, 'ot_custom')) { //3
             for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) { //4

			  if ($order_totals[$i]['code'] == 'ot_tax') { //5
			  $new_ot_total = ((in_array(strip_tags($order_totals[$i]['title']), $current_ot_titles_array)) ? false : true);
			  } else { //within 5
			  $new_ot_total = ((in_array($order_totals[$i]['code'], $current_ot_totals_array)) ? false : true);
			  }  //end 5 if ($order_totals[$i]['code'] == 'ot_tax')
 
			  if ( ( ($order_totals[$i]['code'] == 'ot_tax') && ($order_totals[$i]['code'] == $ot_class) && ($order_totals[$i]['title'] == $ot_title) ) || ( ($order_totals[$i]['code'] != 'ot_tax') && ($order_totals[$i]['code'] == $ot_class) ) ) { //6
			  //only good for components that show up in the $order_totals array

				if ($ot_title != '') { //7
                  $new_order_totals[] = array('title' => strip_tags($ot_title),
                                              'text' => (($ot_class != 'ot_total') ? $order_totals[$i]['text'] : '<b>' . $order->info['total'] . '</b>'),
                                              'value' => (($order_totals[$i]['code'] != 'ot_total') ? $order_totals[$i]['value'] : $order->info['total']),
                                              'code' => $order_totals[$i]['code'],
                                              'sort_order' => $j);
                $written_ot_totals_array[] = $ot_class;
				$written_ot_titles_array[] = $ot_title;
				$j++;
                } else { //within 7

				  $order->info['total'] += ($ot_value*(-1)); 
				  $written_ot_totals_array[] = $ot_class;
				  $written_ot_titles_array[] = $ot_title; 

                } //end 7

			  } elseif ( ($new_ot_total) && (!in_array($order_totals[$i]['title'], $current_ot_titles_array)) ) { //within 6

                $new_order_totals[] = array('title' => strip_tags($order_totals[$i]['title']),
                                            'text' => $order_totals[$i]['text'],
                                            'value' => $order_totals[$i]['value'],
                                            'code' => $order_totals[$i]['code'],
                                            'sort_order' => $j);
                $current_ot_totals_array[] = $order_totals[$i]['code'];
				$current_ot_titles_array[] = strip_tags($order_totals[$i]['title']);
				$written_ot_totals_array[] = $ot_class;
				$written_ot_titles_array[] = $ot_title;
                $j++;
                //echo $order_totals[$i]['code'] . "<br>"; for debugging- use of this results in errors

			  } elseif ($new_ot_total) { //also within 6
                $order->info['total'] += ($order_totals[$i]['value']*(-1));
                $current_ot_totals_array[] = $order_totals[$i]['code'];
				$written_ot_totals_array[] = $ot_class;
				$written_ot_titles_array[] = $ot_title;
              }//end 6
           }//end 4
         } elseif ( (vam_not_null($ot_value)) && (vam_not_null($ot_title)) ) { // this modifies if (!strstr($ot_class, 'ot_custom')) { //3
            $new_order_totals[] = array('title' => strip_tags($ot_title),
                     'text' => $ot_value,
                                        'value' => $ot_value,
                                        'code' => 'ot_custom_' . $j,
                                        'sort_order' => $j);
            $order->info['total'] += $ot_value;
			$written_ot_totals_array[] = $ot_class;
		    $written_ot_titles_array[] = $ot_title;
            $j++;
          } //end 3
		  
		    //save ot_skippy from certain annihilation
			 if ( (!in_array($ot_class, $written_ot_totals_array)) && (!in_array($ot_title, $written_ot_titles_array)) && (vam_not_null($ot_value)) && (vam_not_null($ot_title)) && ($ot_class != 'ot_tax') && ($ot_class != 'ot_loworderfee') ) { //7
			//this is supposed to catch the oddball components that don't show up in $order_totals
				 
				    $new_order_totals[] = array(
					        'title' => strip_tags($ot_title),
                            'text' => $ot_value,
                            'value' => $ot_value,
                            'code' => $ot_class,
                            'sort_order' => $j);
               //$current_ot_totals_array[] = $order_totals[$i]['code'];
				//$current_ot_titles_array[] = $order_totals[$i]['title'];
				$written_ot_totals_array[] = $ot_class;
				$written_ot_titles_array[] = $ot_title;
                $j++;
				 
				 } //end 7
        } //end 2
	  } else {//within 1
	  // $_POST['update_totals'] is not an array => write in all order total components that have been generated by the sundry modules
	   for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) { //8
	                  $new_order_totals[] = array('title' => strip_tags($order_totals[$i]['title']),
                                            'text' => $order_totals[$i]['text'],
                                            'value' => $order_totals[$i]['value'],
                                            'code' => $order_totals[$i]['code'],
                                            'sort_order' => $j);
                $j++;
				
			} //end 8
				
		} //end if (is_array($_POST['update_totals'])) { //1
	  
		for ($i=0, $n=sizeof($new_order_totals); $i<$n; $i++) {
          $sql_data_array = array('orders_id' => $oID,
                                  'title' => strip_tags($new_order_totals[$i]['title']),
                                  'text' => ($new_order_totals[$i]['code'] == 'ot_shipping') ? $currencies->format($new_order_totals[$i]['value']/$currencies->get_value($order->info['currency']), false, $order->info['currency'], $order->info['currency_value']) : $currencies->format($new_order_totals[$i]['value'], false, $order->info['currency'], $order->info['currency_value']), 
                                  'value' => ($new_order_totals[$i]['code'] == 'ot_shipping') ? $new_order_totals[$i]['value']/$currencies->get_value($order->info['currency']) : $new_order_totals[$i]['value'], 
                                  'class' => $new_order_totals[$i]['code'], 
                                  'sort_order' => $new_order_totals[$i]['sort_order']);
          vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
        }
		
        
        if (isset($_POST['subaction'])) {
          switch($_POST['subaction']) {
            case 'add_product':
              vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, vam_get_all_get_params(array('action')) . 'action=edit#products'));
              break;
              
          }
        }
        
		// 1.5 SUCCESS MESSAGE #####
		
		
	// CHECK FOR NEW EMAIL CONFIRMATION

    if ( (isset($_POST['nC1'])) || (isset($_POST['nC2'])) || (isset($_POST['nC3'])) ) {
	//then the user selected the option of sending a new email
    
    vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, vam_get_all_get_params(array('action')) . 'action=email')); 
	//redirect to the email case
	 
  } else  { 
     //email? email?  We don't need no stinkin email!
	 
	 if ($order_updated)	{
			$messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
		}

        // denuz added accumulated discount

        $changed = false;
        
        $check_group_query = vam_db_query("select customers_status_id from " . TABLE_CUSTOMERS_STATUS_ORDERS_STATUS . " where orders_status_id = " . $status);
        if (vam_db_num_rows($check_group_query)) {
           while ($groups = vam_db_fetch_array($check_group_query)) {
              // calculating total customers purchase
              // building query
              $customer_query = vam_db_query("select c.* from customers as c, orders as o where o.customers_id = c.customers_id and o.orders_id = " . (int)$oID);
              $customer = vam_db_fetch_array($customer_query);
			     if ($customer['customers_status'] == '0') {
              $cus_id = 0;
              } else {
              $cus_id = $customer['customers_id'];
              }
             $statuses_groups_query = vam_db_query("select orders_status_id from " . TABLE_CUSTOMERS_STATUS_ORDERS_STATUS . " where customers_status_id = " . $groups['customers_status_id']);
              $purchase_query = "select sum(ot.value) as total from orders_total as ot, orders as o where ot.orders_id = o.orders_id and o.customers_id = " . $cus_id . " and ot.class = 'ot_total' and (";
              $statuses = vam_db_fetch_array($statuses_groups_query);
              $purchase_query .= " o.orders_status = " . $statuses['orders_status_id'];
              while ($statuses = vam_db_fetch_array($statuses_groups_query)) {
                  $purchase_query .= " or o.orders_status = " . $statuses['orders_status_id'];
              }
              $purchase_query .=");";
                   
              $total_purchase_query = vam_db_query($purchase_query);
              $total_purchase = vam_db_fetch_array($total_purchase_query);
              $customers_total = $total_purchase['total'];

              // looking for current accumulated limit & discount
              $acc_query = vam_db_query("select cg.customers_status_accumulated_limit, cg.customers_status_name, cg.customers_status_discount from " . TABLE_CUSTOMERS_STATUS . " as cg, " . TABLE_CUSTOMERS . " as c where cg.customers_status_id = c.customers_status and c.customers_id = " . $cus_id);
              $current_limit = @mysqli_result($acc_query, 0, "customers_status_accumulated_limit");
              $current_discount = @mysqli_result($acc_query, 0, "customers_status_discount");
              $current_group = @mysqli_result($acc_query, "customers_status_name");
                                                                                                                                                                                                 
			     if ($customer['customers_status'] > '0') {                                                                                                                                                                                                 
              // ok, looking for available group
              $groups_query = vam_db_query("select customers_status_discount, customers_status_id, customers_status_name, customers_status_accumulated_limit from " . TABLE_CUSTOMERS_STATUS . " where customers_status_accumulated_limit < " . $customers_total . " and customers_status_discount >= " . $current_discount . " and customers_status_accumulated_limit >= " . $current_limit . " and customers_status_id = " . $groups['customers_status_id'] . " order by customers_status_accumulated_limit DESC");

              if (vam_db_num_rows($groups_query)) {
                 // new group found
                 $customers_groups_id = @mysqli_result($groups_query, 0, "customers_status_id");
                 $customers_groups_name = @mysqli_result($groups_query, 0, "customers_status_name");
                 $limit = @mysqli_result($groups_query, 0, "customers_status_accumulated_limit");
                 $current_discount = @mysqli_result($groups_query, 0, "customers_status_discount");
    
                 // updating customers group
                 vam_db_query("update " . TABLE_CUSTOMERS . " set customers_status = " . $customers_groups_id . " where customers_id = " . $cus_id);
                 $changed = true;
                }
               }
             }
           $groups_query = vam_db_query("select cg.* from " . TABLE_CUSTOMERS_STATUS . " as cg, " . TABLE_CUSTOMERS . " as c where c.customers_status = cg.customers_status_id and c.customers_id = " . $cus_id);
           $customers_groups_id = @mysqli_result($groups_query, 0, "customers_status_id");
           $customers_groups_name = @mysqli_result($groups_query, 0, "customers_status_name");
           $limit = @mysqli_result($groups_query, 0, "customers_status_accumulated_limit");
           $current_discount = @mysqli_result($groups_query, 0, "customers_status_discount");

			if ($customer['customers_status'] != $customers_groups_id) {           

           if ($changed) {
             // send emails

				// assign language to template for caching

				$vamTemplate->assign('language', $_SESSION['language']);
				$vamTemplate->caching = false;

				// set dirs manual

				$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
				$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

				$vamTemplate->assign('CUSTOMERNAME', $check_status['customers_name']);
				$vamTemplate->assign('EMAIL', $check_status['customers_email_address']);
				$vamTemplate->assign('GROUPNAME', $customers_groups_name);
				$vamTemplate->assign('GROUPDISCOUNT', $current_discount);
				$vamTemplate->assign('ACCUMULATED_LIMIT', $currencies->display_price($limit, 0));
				

            //email to admin
            
				$html_mail_admin = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/accumulated_discount_admin.html');
				$txt_mail_admin = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/accumulated_discount_admin.txt');

				vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, STORE_OWNER_EMAIL_ADDRESS, STORE_OWNER, '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', EMAIL_ACC_SUBJECT, $html_mail_admin, $txt_mail_admin);

            //email to customer

				$html_mail_customer = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/accumulated_discount_customer.html');
				$txt_mail_customer = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/accumulated_discount_customer.txt');

				vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $check_status['customers_email_address'], $check_status['customers_name'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', EMAIL_ACC_SUBJECT, $html_mail_customer, $txt_mail_customer);
           }
          }
        }
        // eof denuz added accumulated discount

		vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, vam_get_all_get_params(array('action')) . 'action=edit'));
		
		}
		
	break;
		
	// 3. NEW ORDER EMAIL ###############################################################################################
	case 'email':
          
		$oID = vam_db_prepare_input($_GET['oID']);
		$order = new manualOrder($oID);
		
      $vamPrice = new vamPrice($order->info['currency'], $order->info['status'],$order->customer['ID']);
		
		    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
	  //loop all the products in the order
			 $products_ordered_attributes = '';
	  if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
	    for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
		$products_ordered_attributes .= "\n\t" . $order->products[$i]['attributes'][$j]['option'] . ' ' . $order->products[$i]['attributes'][$j]['value'];
      }
    }
	
	   $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . $products_model . ' = ' . $currencies->format(vam_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) . $products_ordered_attributes . "\n";
			 }
		   
	$vamTemplate->assign('address_label_customer', vam_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'));
	$vamTemplate->assign('address_label_shipping', vam_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br />'));
	if ($_SESSION['credit_covers'] != '1') {
		$vamTemplate->assign('address_label_payment', vam_address_format($order->billing['format_id'], $order->billing, 1, '', '<br />'));
	}
	$vamTemplate->assign('csID', $order->customer['csID']);

  $it=0;
	$semextrfields = vamDBquery("select * from " . TABLE_EXTRA_FIELDS . " where fields_required_email = '1'");
	while($dataexfes = vam_db_fetch_array($semextrfields,true)) {
	$cusextrfields = vamDBquery("select * from " . TABLE_CUSTOMERS_TO_EXTRA_FIELDS . " where customers_id = '" . (int)$order->customer['ID'] . "' and fields_id = '" . $dataexfes['fields_id'] . "'");
	$rescusextrfields = vam_db_fetch_array($cusextrfields,true);

	$extrfieldsinf = vamDBquery("select fields_name from " . TABLE_EXTRA_FIELDS_INFO . " where fields_id = '" . $dataexfes['fields_id'] . "' and languages_id = '" . $_SESSION['languages_id'] . "'");

	$extrfieldsres = vam_db_fetch_array($extrfieldsinf,true);
	$extra_fields .= $extrfieldsres['fields_name'] . ' : ' .
	$rescusextrfields['value'] . "\n";
	$vamTemplate->assign('customer_extra_fields', $extra_fields);
  }
	
	$order_total = $order->getTotalData($oID);
		$vamTemplate->assign('order_data', $order->getOrderData($oID));
		$vamTemplate->assign('order_total', $order_total['data']);

	// assign language to template for caching
	$vamTemplate->assign('language', $_SESSION['language']);
	$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
	$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
	$vamTemplate->assign('oID', $oID);
	if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
		include (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/payment/'.$order->info['payment_method'].'.php');
		$payment_method = constant(strtoupper('MODULE_PAYMENT_'.$order->info['payment_method'].'_TEXT_TITLE'));
	}
	$vamTemplate->assign('PAYMENT_METHOD', $payment_method);
	if ($order->info['shipping_method'] != '') {
		$shipping_method = $order->info['shipping_method'];
	}
	$vamTemplate->assign('SHIPPING_METHOD', $shipping_method);
	$vamTemplate->assign('DATE', vam_date_long($order->info['date_purchased']));

	$vamTemplate->assign('NAME', $order->customer['name']);
	$vamTemplate->assign('COMMENTS', $order->info['comments']);
	$vamTemplate->assign('EMAIL', $order->customer['email_address']);
	$vamTemplate->assign('PHONE',$order->customer['telephone']);

	$vamTemplate->assign('PAYMENT_INFO_HTML', constant(MODULE_PAYMENT_.strtoupper($order->info['payment_method'])._TEXT_DESCRIPTION));
	$vamTemplate->assign('PAYMENT_INFO_TXT', str_replace("<br />", "\n", constant(MODULE_PAYMENT_.strtoupper($order->info['payment_method'])._TEXT_DESCRIPTION)));

	// dont allow cache
	$vamTemplate->caching = false;

	$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/order_mail.html');
	$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/order_mail.txt');

	// create subject
	$order_subject = str_replace('{$nr}', $oID, EMAIL_BILLING_SUBJECT_ORDER);
	$order_subject = str_replace('{$date}', strftime(DATE_FORMAT_LONG), $order_subject);
	$order_subject = str_replace('{$lastname}', $order->customer['lastname'], $order_subject);
	$order_subject = str_replace('{$firstname}', $order->customer['firstname'], $order_subject);

	// send mail to admin
	vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, EMAIL_BILLING_ADDRESS, STORE_NAME, EMAIL_BILLING_FORWARDING_STRING, $order->customer['email_address'], $order->customer['firstname'], '', '', $order_subject, $html_mail, $txt_mail);

	// send mail to customer
	vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $order->customer['email_address'], $order->customer['firstname'].' '.$order->customer['lastname'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $order_subject, $html_mail, $txt_mail);
  
         //do the dirty
 		
		$messageStack->add_session(SUCCESS_EMAIL_SENT, 'success');
		
        vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT, vam_get_all_get_params(array('action')) . 'action=edit'));
		  
		 break;

        
    ////
    // Edit Order
      case 'edit':
        if (!isset($_GET['oID'])) {
		$messageStack->add(ERROR_NO_ORDER_SELECTED, 'error');
          break;
		  }
        $oID = vam_db_prepare_input($_GET['oID']);
        $orders_query = vam_db_query("select orders_id from " . TABLE_ORDERS . " where orders_id = '" . (int)$oID . "'");
        $order_exists = true;
        if (!vam_db_num_rows($orders_query)) {
        $order_exists = false;
          $messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
          break;
        }
        
        $order = new manualOrder($oID);
        
      $vamPrice = new vamPrice($order->info['currency'], $order->info['status'],$order->customer['ID']);
        
        $shippingKey = $order->adjust_totals($oID);
        $order->adjust_zones();
        
        $cart = new manualCart();
        $cart->restore_contents($oID);
        $total_count = $cart->count_contents();
        $total_weight = $cart->show_weight();

        // Get the shipping quotes
        $shipping_modules = new shipping;
        $shipping_quotes = $shipping_modules->quote();
 
     
        break;
    }
  }

  // currecies drop-down array
  $currency_query = vam_db_query("select distinct title, code from " . TABLE_CURRENCIES . " order by code ASC");  
  $currency_array = array();
  while($currency = vam_db_fetch_array($currency_query)) {
    $currency_array[] = array('id' => $currency['code'],
                              'text' => $currency['code'] . ' - ' . $currency['title']);
  }

?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<!--<meta name="viewport" content="initial-scale=1.0, width=device-width" />-->
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>

<?php if (ENABLE_TABS == 'true') { ?>
		<script type="text/javascript">
			$(function(){
				$('#tabs').tabs({ fx: { opacity: 'toggle', duration: 'fast' } });
			});
		</script>
<?php } ?>

  <?php include('order_editor/css.php');  
      //because if you haven't got your css, what have you got?
      ?>

  <?php include('order_editor/javascript.php');  
      //because if you haven't got your javascript, what have you got?
      ?>
 
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<div id="dhtmltooltip"></div>

<script type="text/javascript">

/***********************************************
* Cool DHTML tooltip script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

/***********************************************
* For Order Editor
* This has to stay here for the tooltips to work correctly
* I tried sticking it with the rest of the javascript, but it has to be inside the <body> tag
*
***********************************************/

var offsetxpoint=-60 //Customize x offset of tooltip
var offsetypoint=20 //Customize y offset of tooltip
var ie=document.all
var ns6=document.getElementById && !document.all
var enabletip=false
if (ie||ns6)
var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""

function ietruebody(){
return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function ddrivetip(thetext, thecolor, thewidth){
if (ns6||ie){
if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
tipobj.innerHTML=thetext
enabletip=true
return false
}
}

function positiontip(e){
if (enabletip){
var curX=(ns6)?e.pageX : event.clientX+ietruebody().scrollLeft;
var curY=(ns6)?e.pageY : event.clientY+ietruebody().scrollTop;
//Find out how close the mouse is to the corner of the window
var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20

var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000

//if the horizontal distance isn't enough to accomodate the width of the context menu
if (rightedge<tipobj.offsetWidth)
//move the horizontal position of the menu to the left by it's width
tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
else if (curX<leftedge)
tipobj.style.left="5px"
else
//position the horizontal position of the menu where the mouse is positioned
tipobj.style.left=curX+offsetxpoint+"px"

//same concept with the vertical position
if (bottomedge<tipobj.offsetHeight)
tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
else
tipobj.style.top=curY+offsetypoint+"px"
tipobj.style.visibility="visible"
}
}

function hideddrivetip(){
if (ns6||ie){
enabletip=false
tipobj.style.visibility="hidden"
tipobj.style.left="-1000px"
tipobj.style.backgroundColor='white'
tipobj.style.width='200'
}
}

document.onmousemove=positiontip

</script>

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
    <td width="100%" valign="top">

 <?php
   
   if (($action == 'edit') && ($order_exists == true)) {
     
	 echo vam_draw_form('edit_order', FILENAME_ORDERS_EDIT, vam_get_all_get_params(array('action')) . 'action=update_order');
    
 ?>
  
      <div id="header">
	  
		  <p id="headerTitle" class="pageHeading"><h1 class="contentBoxHeading"><?php echo sprintf(HEADING_TITLE, $oID, vam_datetime_short($order->info['date_purchased'])); ?></h1></p>
        
          <ul>
			  
			 <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>
			  <script language="JavaScript" type="text/javascript"><!--
			  //this button only works with javascript and is therefore only displayed on browsers with javascript enabled
              document.write("<li><a class=\"button\" href=\"javascript:newOrderEmail()\"><span><img src=\"images/icons/buttons/submit.png\" border=\"0\" alt=\"\" width=\"12\" height=\"12\">&nbsp;<?php echo BUTTON_SEND_EMAIL; ?></span></a></li>");
	           //--></script>
			   <?php } ?>
				  
		    <li><?php echo '<a class="button" href="' . vam_href_link(FILENAME_PRINT_ORDER, 'oID=' . $_GET['oID']) . '" TARGET="_blank"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/payment.png', '', '12', '12') . '&nbsp;' . BUTTON_INVOICE . '</span></a>'; ?></li>
		    <li><?php echo '<a class="button" href="' . vam_href_link(FILENAME_PRINT_PACKINGSLIP, 'oID=' . $_GET['oID']) . '" TARGET="_blank"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/shipping.png', '', '12', '12') . '&nbsp;' . BUTTON_PACKINGSLIP . '</span></a>'; ?></li>
		    <li><?php echo '<a class="button" href="' . vam_href_link(FILENAME_ORDERS, vam_get_all_get_params(array('oID', 'action')) . 'oID=' . $_GET['oID'] . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . BUTTON_BACK_TO_ORDER . '</span></a>'; ?></li>
		    <li><?php echo '<a class="button" href="' . vam_href_link(FILENAME_ORDERS, vam_get_all_get_params(array('action'))) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . BUTTON_BACK_TO_ORDERS_LIST . '</span></a> '; ?></li>
		  </ul>
      
	  </div>

  	    <div id="ordersMessageStack"></div>
	   
<div id="tabs">

			<ul>
				<li><a href="#customer"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/customer.png', '', '16', '16'); ?>&nbsp;<?php echo EDIT_ORDER_TAB_CUSTOMER; ?></a></li>
				<li><a href="#payment"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/payment.png', '', '16', '16'); ?>&nbsp;<?php echo EDIT_ORDER_TAB_PAYMENT; ?></a></li>
				<li><a href="#products"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/shipping.png', '', '16', '16'); ?>&nbsp;<?php echo EDIT_ORDER_TAB_PRODUCTS; ?></a></li>
				<li><a href="#other"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/comment.png', '', '16', '16'); ?>&nbsp;<?php echo EDIT_ORDER_TAB_COMMENTS; ?></a></li>
			</ul>

        <div id="customer">
   	   	   
	<?php if (ORDER_EDITOR_USE_AJAX != 'true') { ?>
	<!-- Begin Update Block, only for non-ajax use -->

           <div class="updateBlock">
              <div class="update1"><?php echo HINT_PRESS_UPDATE; ?></div>
              <div class="update2">&nbsp;</div>
              <div class="update3">&nbsp;</div>
              <div class="update4" align="center"><?php echo ENTRY_SEND_NEW_ORDER_CONFIRMATION; ?>&nbsp;<?php echo vam_draw_checkbox_field('nC1', '', false); ?></div>
              <div class="update5" align="center"><span class="button"><button type="submit" value="<?php echo BUTTON_UPDATE; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_UPDATE; ?></button></span></div>
          </div>
	
	  <br>
	  <br>
	  <!-- End of Update Block -->
	  <?php } ?>


    <!-- customer_info bof //-->
            
        <table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td valign="top">
            <!-- customer_info bof //-->
            <table width="100%" border="0" cellspacing="0" cellpadding="2" style="border: 1px solid #C9C9C9;">
              <tr class="dataTableHeadingRow"> 
                <td colspan="4" class="dataTableHeadingContent" valign="top"><?php echo ENTRY_CUSTOMER; ?></td>
              </tr>
              <tr class="dataTableRow"> 
                <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_NAME; ?></td>
                <td colspan="3" valign="top" class="dataTableContent"><input name="update_customer_name" size="34" value="<?php echo stripslashes($order->customer['name']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('customers_name', encodeURIComponent(this.value))"<?php } ?>></td>
              </tr>
<?php
  if (ACCOUNT_COMPANY == 'true') {
?>  
              <tr class="dataTableRow"> 
                <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_COMPANY; ?></td>
                <td colspan="3" valign="top" class="dataTableContent"><input name="update_customer_company" size="34" value="<?php echo stripslashes($order->customer['company']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('customers_company', encodeURIComponent(this.value))"<?php } ?>></td>
              </tr>
<?php } ?>
<?php
  if (ACCOUNT_STREET_ADDRESS == 'true') {
?>          
              <tr class="dataTableRow"> 
                <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_STREET_ADDRESS; ?></td>
                <td colspan="3" valign="top" class="dataTableContent" nowrap><input name="update_customer_street_address" size="34" value="<?php echo stripslashes($order->customer['street_address']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('customers_street_address', encodeURIComponent(this.value))"<?php } ?>></td>
              </tr>
<?php } ?>
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
              <tr class="dataTableRow"> 
                <td class="dataTableContent" valign="middle" align="right"><?php echo ENTRY_SUBURB; ?></td>
                <td colspan="3" valign="top" class="dataTableContent" nowrap><input name="update_customer_suburb" size="34" value="<?php echo stripslashes($order->customer['suburb']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('customers_suburb', encodeURIComponent(this.value))"<?php } ?>></td>
              </tr>
<?php } ?>
<?php
  if (ACCOUNT_POSTCODE == 'true') {
?>
              <tr class="dataTableRow"> 
                <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_POST_CODE; ?></td>
                <td colspan="3" class="dataTableContent" valign="top"><input name="update_customer_postcode" size="5" value="<?php echo $order->customer['postcode']; ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('customers_postcode', encodeURIComponent(this.value))"<?php } ?>></td>
              </tr>
<?php } ?>
<?php
	if (ACCOUNT_CITY == 'true') {
?>
              <tr class="dataTableRow"> 
                <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_CITY; ?></td>
                <td colspan="3" valign="top" class="dataTableContent" nowrap><input name="update_customer_city" size="15" value="<?php echo stripslashes($order->customer['city']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('customers_city', encodeURIComponent(this.value))"<?php } ?>></td>
              </tr>
<?php } ?>
<?php
  if (ACCOUNT_STATE == 'true') {
?>
              <tr class="dataTableRow"> 
                <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_STATE; ?></td>
                <td colspan="3" valign="top" class="dataTableContent" nowrap><span id="customerStateMenu">
				<?php if (ORDER_EDITOR_USE_AJAX == 'true') {
				echo vam_draw_pull_down_menu('update_customer_zone_id', vam_get_country_zones($order->customer['country_id']), $order->customer['zone_id'], 'style="width: 300px;" onChange="updateOrdersField(\'customers_state\', this.options[this.selectedIndex].text);"'); 
				} else {
				echo vam_draw_pull_down_menu('update_customer_zone_id', vam_get_country_zones($order->customer['country_id']), $order->customer['zone_id'], 'style="width: 300px;"');
				}?></span><span id="customerStateInput"><input name="update_customer_state" size="15" value="<?php echo stripslashes($order->customer['state']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('customers_state', encodeURIComponent(this.value))"<?php } ?>></span></td>
              </tr>
<?php } ?>
<?php
     if (ACCOUNT_COUNTRY == 'true') {
?>
              <tr class="dataTableRow"> 
                <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_COUNTRY; ?></td>
                <td colspan="3" class="dataTableContent" valign="top">
				<?php if (ORDER_EDITOR_USE_AJAX == 'true') {
				echo vam_draw_pull_down_menu('update_customer_country_id', vam_get_countries(), $order->customer['country_id'], 'style="width: 300px;" onChange="update_zone(\'update_customer_country_id\', \'update_customer_zone_id\', \'customerStateInput\', \'customerStateMenu\'); updateOrdersField(\'customers_country\', this.options[this.selectedIndex].text);"'); 
				} else {
				echo vam_draw_pull_down_menu('update_customer_country_id', vam_get_countries(), $order->customer['country_id'], 'style="width: 300px;" onChange="update_zone(\'update_customer_country_id\', \'update_customer_zone_id\', \'customerStateInput\', \'customerStateMenu\');"'); 
				} ?></td>
              </tr>
<?php } ?>
              <tr class="dataTableRow"> 
                <td colspan="4" style="border-top: 1px solid #C9C9C9;"><?php echo vam_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
              </tr>
<?php
	if (ACCOUNT_TELE == 'true') {
?>
              <tr class="dataTableRow"> 
                <td class="dataTableContent" valign="middle" align="right"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
                <td colspan="3" valign="top" class="dataTableContent"><input name="update_customer_telephone" size="15" value="<?php echo $order->customer['telephone']; ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('customers_telephone', encodeURIComponent(this.value))"<?php } ?>></td>
              </tr>
<?php } ?>
              <tr class="dataTableRow"> 
                <td class="dataTableContent" valign="middle" align="right"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
                <td colspan="3" valign="top" class="dataTableContent"><input name="update_customer_email_address" size="34" value="<?php echo $order->customer['email_address']; ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('customers_email_address', encodeURIComponent(this.value))"<?php } ?>></td>
              </tr>
            </table>
			   <td valign="top" width="10">&nbsp;</td>
            <td valign="top">

			<!-- customer_info_eof //-->
            <!-- shipping_address bof -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #C9C9C9;">
              <tr>
                <td class="dataTableContent">
                <table width="100%" cellspacing="0" cellpadding="2">
                  <tr class="dataTableHeadingRow"> 
				   <td class="dataTableHeadingContent" valign="top" onMouseover="ddrivetip('<?php echo oe_html_no_quote(HINT_SHIPPING_ADDRESS); ?>')"; onMouseout="hideddrivetip()"><?php echo ENTRY_SHIPPING_ADDRESS; ?> 
				   	<script language="JavaScript" type="text/javascript">
                   <!--
                    document.write("<img src=\"images/icon_info.gif\" border= \"0\" width=\"13\" height=\"13\">");
	               //-->
                  </script>
				  
				</td>
                  </tr>
				  
                  <?php if (ORDER_EDITOR_USE_AJAX != 'true') { ?>
				  <tr class="dataTableRow"> 
                    <td valign="middle" class="dataTableContent"><input type="checkbox" name="shipping_same_as_billing"> <?php echo TEXT_SHIPPING_SAME_AS_BILLING; ?></td>
                  </tr>
				  <?php } ?>
				  
                </table>
                </td>
              </tr>
              <tr id="shippingAddressEntry">
                <td class="dataTableContent">
                <table width="100%" cellspacing="0" cellpadding="2">
                  <tr class="dataTableRow"> 
                    <td colspan="4" style="border-top: 1px solid #C9C9C9;"><?php echo vam_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
                  </tr>
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right"><?php echo ENTRY_NAME; ?></td>
                    <td colspan="3" valign="top" class="dataTableContent"><input name="update_delivery_name" size="34" value="<?php echo stripslashes($order->delivery['name']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('delivery_name', encodeURIComponent(this.value))"<?php } ?>></td>
                  </tr>
<?php
  if (ACCOUNT_COMPANY == 'true') {
?>  
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right"><?php echo ENTRY_COMPANY; ?></td>
                    <td colspan="3" valign="top" class="dataTableContent"><input name="update_delivery_company" size="34" value="<?php echo stripslashes($order->delivery['company']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('delivery_company', encodeURIComponent(this.value))"<?php } ?>></td>
                  </tr>
<?php } ?>
<?php
  if (ACCOUNT_STREET_ADDRESS == 'true') {
?>          
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right"><?php echo ENTRY_STREET_ADDRESS; ?></td>
                    <td colspan="3" valign="top" class="dataTableContent"><input name="update_delivery_street_address" size="34" value="<?php echo stripslashes($order->delivery['street_address']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('delivery_street_address', encodeURIComponent(this.value))"<?php } ?>></td>
                  </tr>
<?php } ?>
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right"><?php echo ENTRY_SUBURB; ?></td>
                    <td colspan="3" valign="top" class="dataTableContent"><input name="update_delivery_suburb" size="34" value="<?php echo stripslashes($order->delivery['suburb']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('delivery_suburb', encodeURIComponent(this.value))"<?php } ?>></td>
                  </tr>
<?php } ?>
<?php
  if (ACCOUNT_POSTCODE == 'true') {
?>
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right"><?php echo ENTRY_POST_CODE; ?></td>
                    <td colspan="3" class="dataTableContent" valign="top"><input name="update_delivery_postcode" size="5" value="<?php echo $order->delivery['postcode']; ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateShippingZone('delivery_postcode', encodeURIComponent(this.value))"<?php } ?>></td>
                  </tr>       
<?php } ?>
<?php
	if (ACCOUNT_CITY == 'true') {
?>
                  <tr class="dataTableRow">
                    <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_CITY; ?></td>
                    <td colspan="3" valign="top" class="dataTableContent" nowrap><input name="update_delivery_city" size="15" value="<?php echo stripslashes($order->delivery['city']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('delivery_city', encodeURIComponent(this.value))"<?php } ?>></td>
                  </tr>
<?php } ?>
<?php
  if (ACCOUNT_STATE == 'true') {
?>
                  <tr class="dataTableRow">
                    <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_STATE; ?></td>
                    <td colspan="3" valign="top" class="dataTableContent"><span id="deliveryStateMenu">
					<?php if (ORDER_EDITOR_USE_AJAX == 'true') { 
				echo vam_draw_pull_down_menu('update_delivery_zone_id', vam_get_country_zones($order->delivery['country_id']), $order->delivery['zone_id'], 'style="width: 300px;" onChange="updateShippingZone(\'delivery_state\', this.options[this.selectedIndex].text);"'); 
					} else {
					echo vam_draw_pull_down_menu('update_delivery_zone_id', vam_get_country_zones($order->delivery['country_id']), $order->delivery['zone_id'], 'style="width: 300px;"'); 
					} ?>
					</span><span id="deliveryStateInput"><input name="update_delivery_state" size="15" value="<?php echo stripslashes($order->delivery['state']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateShippingZone('delivery_state', encodeURIComponent(this.value))"<?php } ?>></span></td>
                  </tr>
<?php } ?>
<?php
     if (ACCOUNT_COUNTRY == 'true') {
?>
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right"><?php echo ENTRY_COUNTRY; ?></td>
                    <td colspan="3" class="dataTableContent" valign="top">
					<?php if (ORDER_EDITOR_USE_AJAX == 'true') {
					echo vam_draw_pull_down_menu('update_delivery_country_id', vam_get_countries(), $order->delivery['country_id'], 'style="width: 300px;" onchange="update_zone(\'update_delivery_country_id\', \'update_delivery_zone_id\', \'deliveryStateInput\', \'deliveryStateMenu\'); updateShippingZone(\'delivery_country\', this.options[this.selectedIndex].text);"'); 
					} else {
					echo vam_draw_pull_down_menu('update_delivery_country_id', vam_get_countries(), $order->delivery['country_id'], 'style="width: 300px;" onchange="update_zone(\'update_delivery_country_id\', \'update_delivery_zone_id\', \'deliveryStateInput\', \'deliveryStateMenu\');"'); 
					}
					?></td>
                  </tr>       
<?php } ?>
                </table>
                </td>
              </tr>                  
            </table>
            <!-- shipping_address_eof //-->
            </td>
            <td valign="top" width="10">&nbsp;</td>
            <td valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border: 1px solid #C9C9C9;">
              <!-- billing_address bof //-->
              <tr>
                <td class="dataTableContent">
                <table width="100%" cellspacing="0" cellpadding="2">
                  <tr class="dataTableHeadingRow"> 
                    <td colspan="4" class="dataTableHeadingContent" valign="top"><?php echo ENTRY_BILLING_ADDRESS; ?></td>
                  </tr>
				  
				  <?php if (ORDER_EDITOR_USE_AJAX != 'true') { ?>
                  <tr class="dataTableRow"> 
                    <td colspan="4" valign="middle" class="dataTableContent"><input type="checkbox" name="billing_same_as_customer"> <?php echo TEXT_BILLING_SAME_AS_CUSTOMER; ?></td>
                  </tr>
				  <?php } ?>
				  
                </table>
                </td>
              </tr>
              <tr id="billingAddressEntry">
                <td class="dataTableContent">
                <table width="100%" cellspacing="0" cellpadding="2">               
                  <tr class="dataTableRow">
                    <td colspan="4" style="border-top: 1px solid #C9C9C9;"><?php echo vam_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
                  </tr>
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_NAME; ?></td>
                    <td colspan="3" valign="top" class="dataTableContent"><input name="update_billing_name" size="34" value="<?php echo stripslashes($order->billing['name']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('billing_name', encodeURIComponent(this.value))"<?php } ?>></td>
                  </tr>
<?php
  if (ACCOUNT_COMPANY == 'true') {
?>  
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_COMPANY; ?></td>
                    <td colspan="3" valign="top" class="dataTableContent"><input name="update_billing_company" size="34" value="<?php echo stripslashes($order->billing['company']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('billing_company', encodeURIComponent(this.value))"<?php } ?>></td>
                  </tr>
<?php } ?>                  
<?php
  if (ACCOUNT_STREET_ADDRESS == 'true') {
?>          
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_STREET_ADDRESS; ?></td>
                    <td colspan="3" valign="top" class="dataTableContent"><input name="update_billing_street_address" size="34" value="<?php echo stripslashes($order->billing['street_address']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('billing_street_address', encodeURIComponent(this.value))"<?php } ?>></td>
                  </tr>
<?php } ?>                  
<?php
  if (ACCOUNT_SUBURB == 'true') {
?>
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_SUBURB; ?></td>
                    <td colspan="3" valign="top" class="dataTableContent"><input name="update_billing_suburb" size="34" value="<?php echo stripslashes($order->billing['suburb']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('billing_suburb', encodeURIComponent(this.value))"<?php } ?>></td>
                  </tr>
<?php } ?>
<?php
  if (ACCOUNT_POSTCODE == 'true') {
?>
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_POST_CODE; ?></td>
                    <td colspan="3" class="dataTableContent" valign="top"><input name="update_billing_postcode" size="5" value="<?php echo $order->billing['postcode']; ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('billing_postcode', encodeURIComponent(this.value))"<?php } ?>></td>
                  </tr>
<?php } ?>
<?php
	if (ACCOUNT_CITY == 'true') {
?>
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_CITY; ?></td>
                    <td colspan="3" valign="top" class="dataTableContent" nowrap><input name="update_billing_city" size="15" value="<?php echo stripslashes($order->billing['city']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('billing_city', encodeURIComponent(this.value))"<?php } ?>></td>
                  </tr>
<?php } ?>
<?php
  if (ACCOUNT_STATE == 'true') {
?>
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_STATE; ?></td>
                    <td colspan="3" valign="top" class="dataTableContent"><span id="billingStateMenu">
					<?php if (ORDER_EDITOR_USE_AJAX == 'true') {
					echo vam_draw_pull_down_menu('update_billing_zone_id', vam_get_country_zones($order->billing['country_id']), $order->billing['zone_id'], 'style="width: 300px;" onChange="updateOrdersField(\'billing_state\', this.options[this.selectedIndex].text);"'); 
					} else {
					echo vam_draw_pull_down_menu('update_billing_zone_id', vam_get_country_zones($order->billing['country_id']), $order->billing['zone_id'], 'style="width: 300px;"');
					} ?>
					</span><span id="billingStateInput"><input name="update_billing_state" size="15" value="<?php echo stripslashes($order->billing['state']); ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('billing_state', encodeURIComponent(this.value))"<?php } ?>></span></td>
                  </tr>
<?php } ?>
<?php
     if (ACCOUNT_COUNTRY == 'true') {
?>
                  <tr class="dataTableRow"> 
                    <td class="dataTableContent" valign="middle" align="right" nowrap><?php echo ENTRY_COUNTRY; ?></td>
                    <td colspan="3" class="dataTableContent" valign="top">
					<?php if (ORDER_EDITOR_USE_AJAX == 'true') {
					echo vam_draw_pull_down_menu('update_billing_country_id', vam_get_countries(), $order->billing['country_id'], 'style="width: 300px;" onchange="update_zone(\'update_billing_country_id\', \'update_billing_zone_id\', \'billingStateInput\', \'billingStateMenu\'); updateOrdersField(\'billing_country\', this.options[this.selectedIndex].text);"'); 
					} else {
					echo vam_draw_pull_down_menu('update_billing_country_id', vam_get_countries(), $order->billing['country_id'], 'style="width: 300px;" onchange="update_zone(\'update_billing_country_id\', \'update_billing_zone_id\', \'billingStateInput\', \'billingStateMenu\'); updateOrdersField(\'billing_country\', this.options[this.selectedIndex].text);"'); 
					} ?></td>
                  </tr>
<?php } ?>
                </table>
                </td>
              </tr>
              <!-- billing_address_eof //-->
              
            </table></td>
          </tr>
        </table>

        </div>
        <div id="payment">

              <!-- payment_method bof //-->

      <table cellspacing="0" cellpadding="2" width="100%">
		
              <tr>
                <td class="dataTableContent">
             
      <table cellspacing="0" cellpadding="2" width="100%">
        <tr class="dataTableHeadingRow"> 
          <td colspan="2" class="dataTableHeadingContent" valign="bottom"><?php echo ENTRY_PAYMENT_METHOD; ?>
			
			</td>
	      
		     <td></td>
	         <td class="dataTableHeadingContent" valign="bottom" onMouseover="ddrivetip('<?php echo oe_html_no_quote(HINT_UPDATE_CURRENCY); ?>')" onMouseout="hideddrivetip()"><?php echo ENTRY_CURRENCY_TYPE; ?> 
		  
		  		  <script language="JavaScript" type="text/javascript">
                   <!--
                    document.write("<img src=\"images/icon_info.gif\" border= \"0\" width=\"13\" height=\"13\">");
	               //-->
                  </script>
				  
             </td>
	         <td></td>
	         <td class="dataTableHeadingContent"><?php echo ENTRY_CURRENCY_VALUE; ?></td>
         </tr>
                  
	     <tr class="dataTableRow"> 
	       <td colspan="2" class="main">
	       <?php 
	        //START for payment dropdown menu use this by quick_fixer
  		      if (ORDER_EDITOR_PAYMENT_DROPDOWN == 'true') { 
		
  $payments = preg_split('/;/', MODULE_PAYMENT_INSTALLED);
  for ($i=0; $i<count($payments); $i++){
  
  require(DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $payments[$i]);	
  
  $payment = substr($payments[$i], 0, strrpos($payments[$i], '.'));	
  $payment_text = constant(MODULE_PAYMENT_.strtoupper($payment)._TEXT_TITLE);
  
  $payment_array[] = array('id' => $payment,
                           'text' => $payment_text);
  }
  
  $order_payment = $order->info['payment_method'];
  
  require(DIR_FS_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $order_payment .'.php');	
  $order_payment_text = constant(MODULE_PAYMENT_.strtoupper($order_payment)._TEXT_TITLE); 

		    //draw the dropdown menu for payment methods and default to the order value
	  		  if (ORDER_EDITOR_USE_AJAX == 'true') {
			  echo vam_draw_pull_down_menu('update_info_payment_method', $payment_array, $order_payment, 'id="update_info_payment_method" onChange="init(); updateOrdersField(\'payment_method\', this.options[this.selectedIndex].value); updateOrdersField(\'payment_class\', this.options[this.selectedIndex].value)"'); 
			  } else {
			  echo vam_draw_pull_down_menu('update_info_payment_method', $payment_array, $order_payment, 'id="update_info_payment_method" onChange="init();"'); 
			  }
		    }  else { //draw the input field for payment methods and default to the order value  ?>
		  
		   <input name="update_info_payment_method" size="35" value="<?php echo $order->info['payment_method']; ?>" id="update_info_payment_method" onChange="init();<?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?> updateOrdersField('payment_method', encodeURIComponent(this.value));<?php } ?>">
		   
		   <?php } //END for payment dropdown menu use this by quick_fixer ?>
		   
		   </td>
	
	       <td width="20">
	       </td>
	
	        <td>
			 <?php
	         ///get the currency info
              reset($currencies->currencies);
              $currencies_array = array();
                foreach ($currencies->currencies as $key => $value) {
                      $currencies_array[] = array('id' => $key, 'text' => $value['title']);
                 }
	
               echo vam_draw_pull_down_menu('update_info_payment_currency', $currencies_array, $order->info['currency'], 'id="update_info_payment_currency" onChange="currency(this.value)"'); 

?>
          </td>

         <td width="10">
         </td>

	     <td>
		  <input name="update_info_payment_currency_value" size="15" readonly="readonly" id="update_info_payment_currency_value" value="<?php echo $order->info['currency_value']; ?>">
		 </td>
      </tr>

                  <!-- credit_card bof //-->
    <tr class="dataTableRow"> 
      <td colspan="6">
	  
	  <table id="optional"><!--  -->
	 <tr>
	    <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
	  </tr>
	  <tr>
	    <td class="main"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></td>
	<td class="main"><input name="update_info_cc_type" size="32" value="<?php echo $order->info['cc_type']; ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('cc_type', encodeURIComponent(this.value))"<?php } ?>></td>
	  </tr>
	  <tr>
	    <td class="main"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></td>
	    <td class="main"><input name="update_info_cc_owner" size="32" value="<?php echo $order->info['cc_owner']; ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('cc_owner', encodeURIComponent(this.value))<?php } ?>"></td>
	  </tr>
	  <tr>
	    <td class="main"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></td>
	    <td class="main"><input name="update_info_cc_number" size="32" value="<?php echo $order->info['cc_number']; ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('cc_number', encodeURIComponent(this.value))"<?php } ?>></td>
	  </tr>
	  <tr>
	    <td class="main"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></td>
	    <td class="main"><input name="update_info_cc_expires" size="4" value="<?php echo $order->info['cc_expires']; ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateOrdersField('cc_expires', encodeURIComponent(this.value))"<?php } ?>></td>
	  </tr>
	</table>
	  
   </td>
  </tr>
 </table>
				
				</td>
              </tr>    
              </table>		
		
              <!-- payment_method eof //-->
		
</div>
<div id="products">
		
		
	<div id="productsMessageStack"></div>

	
	<div width="100%" style="border: 1px solid #C9C9C9;"> 
	  <a name="products"></a>
		<!-- product_listing bof //-->
         
            <table border="0" width="100%" cellspacing="0" cellpadding="2" id="productsTable">
			   <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><div align="center"><?php echo TABLE_HEADING_DELETE; ?></div></td>
			    <td class="dataTableHeadingContent"><div align="center"><?php echo TABLE_HEADING_QUANTITY; ?></div></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TAX; ?></td>
	  <td class="dataTableHeadingContent" onMouseover="ddrivetip('<?php echo oe_html_no_quote(HINT_BASE_PRICE); ?>')"; onMouseout="hideddrivetip()"><?php  echo TABLE_HEADING_BASE_PRICE; ?> <script language="JavaScript" type="text/javascript">
                   <!--
                    document.write("<img src=\"images/icon_info.gif\" border= \"0\" width=\"13\" height=\"13\">");
	               //-->
                  </script></td>
	  <td class="dataTableHeadingContent" onMouseover="ddrivetip('<?php echo oe_html_no_quote(HINT_PRICE_EXCL); ?>')"; onMouseout="hideddrivetip()"><?php  echo TABLE_HEADING_UNIT_PRICE; ?> <script language="JavaScript" type="text/javascript">
                   <!--
                    document.write("<img src=\"images/icon_info.gif\" border= \"0\" width=\"13\" height=\"13\">");
	               //-->
                  </script></td>
	  <td class="dataTableHeadingContent" onMouseover="ddrivetip('<?php echo oe_html_no_quote(HINT_PRICE_INCL); ?>')"; onMouseout="hideddrivetip()"><?php  echo TABLE_HEADING_UNIT_PRICE_TAXED; ?> <script language="JavaScript" type="text/javascript">
                   <!--
                    document.write("<img src=\"images/icon_info.gif\" border= \"0\" width=\"13\" height=\"13\">");
	               //-->
                  </script></td>
	  <td class="dataTableHeadingContent" onMouseover="ddrivetip('<?php echo oe_html_no_quote(HINT_TOTAL_EXCL); ?>')"; onMouseout="hideddrivetip()"><?php  echo TABLE_HEADING_TOTAL_PRICE; ?> <script language="JavaScript" type="text/javascript">
                   <!--
                    document.write("<img src=\"images/icon_info.gif\" border= \"0\" width=\"13\" height=\"13\">");
	               //-->
                  </script></td>
      <td class="dataTableHeadingContent" onMouseover="ddrivetip('<?php echo oe_html_no_quote(HINT_TOTAL_INCL); ?>')"; onMouseout="hideddrivetip()"><?php  echo TABLE_HEADING_TOTAL_PRICE_TAXED; ?> <script language="JavaScript" type="text/javascript">
                   <!--
                    document.write("<img src=\"images/icon_info.gif\" border= \"0\" width=\"13\" height=\"13\">");
	               //-->
                  </script></td>
              </tr>
  <?php
  if (sizeof($order->products)) {
    for ($i=0; $i<sizeof($order->products); $i++) {
      $orders_products_id = $order->products[$i]['orders_products_id'];  ?>
			   
			   <tr class="dataTableRow">
                
				<td class="dataTableContent" valign="top"><div align="center"><input type="checkbox" name="<?php echo "update_products[" . $orders_products_id . "][delete]"; ?>" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onClick="updateProductsField('delete', '<?php echo $orders_products_id; ?>', 'delete', this.checked, this)"<?php } ?>></div></td>
                
				<td class="dataTableContent" valign="top"><div align="center"><input name="<?php echo "update_products[" . $orders_products_id . "][qty]"; ?>" size="2" onKeyUp="updatePrices('qty', '<?php echo $orders_products_id; ?>')" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateProductsField('reload1', '<?php echo $orders_products_id; ?>', 'products_quantity', encodeURIComponent(this.value))"<?php } ?> value="<?php echo $order->products[$i]['qty']; ?>" id="<?php echo "update_products[" . $orders_products_id . "][qty]"; ?>"></div></td>
                
				<td class="dataTableContent" valign="top"><input name="<?php echo "update_products[" . $orders_products_id . "][name]"; ?>" size="40" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateProductsField('update', '<?php echo $orders_products_id; ?>', 'products_name', encodeURIComponent(this.value))"<?php } ?> value='<?php echo oe_html_quotes($order->products[$i]['name']); ?>'>
    
	<?php
      // Has Attributes?
     if (isset($order->products[$i]['attributes']) && (sizeof($order->products[$i]['attributes']) > 0)) {
        for ($j=0; $j<sizeof($order->products[$i]['attributes']); $j++) {
          $orders_products_attributes_id = $order->products[$i]['attributes'][$j]['orders_products_attributes_id'];
				if (ORDER_EDITOR_USE_AJAX == 'true') {
				echo '<br><nobr><small>&nbsp;<i> - ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][option]' size='6' value='" . oe_html_quotes($order->products[$i]['attributes'][$j]['option']) . "' onChange=\"updateAttributesField('simple', 'products_options', '" . $orders_products_attributes_id . "', '" . $orders_products_id . "', encodeURIComponent(this.value))\">" . ': ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][value]' size='10' value='" . oe_html_quotes($order->products[$i]['attributes'][$j]['value']) . "' onChange=\"updateAttributesField('simple', 'products_options_values', '" . $orders_products_attributes_id . "', '" . $orders_products_id . "', encodeURIComponent(this.value))\">" . ': ' . "</i><input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][prefix]' size='1' id='p" . $orders_products_id . "_" . $orders_products_attributes_id . "_prefix' value='" . $order->products[$i]['attributes'][$j]['prefix'] . "' onKeyUp=\"updatePrices('att_price', '" . $orders_products_id . "')\" onChange=\"updateAttributesField('hard', 'price_prefix', '" . $orders_products_attributes_id . "', '" . $orders_products_id . "', encodeURIComponent(this.value))\">" . ': ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][price]' size='7' value='" . $order->products[$i]['attributes'][$j]['price'] . "' onKeyUp=\"updatePrices('att_price', '" . $orders_products_id . "')\" onChange=\"updateAttributesField('hard', 'options_values_price', '" . $orders_products_attributes_id . "', '" . $orders_products_id . "', encodeURIComponent(this.value))\" id='p". $orders_products_id . "a" . $orders_products_attributes_id . "'>";
				} else {
				echo '<br><nobr><small>&nbsp;<i> - ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][option]' size='6' value='" . oe_html_quotes($order->products[$i]['attributes'][$j]['option']) . "'>" . ': ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][value]' size='10' value='" . oe_html_quotes($order->products[$i]['attributes'][$j]['value']) . "'>" . ': ' . "</i><input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][prefix]' size='1' id='p" . $orders_products_id . "_" . $orders_products_attributes_id . "_prefix' value='" . $order->products[$i]['attributes'][$j]['prefix'] . "' onKeyUp=\"updatePrices('att_price', '" . $orders_products_id . "')\">" . ': ' . "<input name='update_products[$orders_products_id][attributes][$orders_products_attributes_id][price]' size='7' value='" . $order->products[$i]['attributes'][$j]['price'] . "' onKeyUp=\"updatePrices('att_price', '" . $orders_products_id . "')\" id='p". $orders_products_id . "a" . $orders_products_attributes_id . "'>";
				}
				echo '</small></nobr>';
			}  //end for ($j=0; $j<sizeof($order->products[$i]['attributes']); $j++) {
		
			 //Has downloads?
  
    if (DOWNLOAD_ENABLED == 'true') {
   $downloads_count = 1;
   $d_index = 0;
   $download_query_raw ="SELECT orders_products_download_id, orders_products_filename, download_maxdays, download_count
                         FROM " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . "                               
						 WHERE orders_products_id='" . $orders_products_id . "'
						 AND orders_id='" . (int)$oID . "'
						 ORDER BY orders_products_download_id";
  
		$download_query = vam_db_query($download_query_raw);
		
		//
		if (isset($downloads->products)) unset($downloads->products);
		//
		
		if (vam_db_num_rows($download_query) > 0) {
        while ($download = vam_db_fetch_array($download_query)) {
		
 		$downloads->products[$d_index] = array(
		            'id' => $download['orders_products_download_id'],
		            'filename' => $download['orders_products_filename'],
                    'maxdays' => $download['download_maxdays'],
                    'maxcount' => $download['download_count']);
		
		$d_index++; 
		
		} 
       } 
        
   if (isset($downloads->products) && (sizeof($downloads->products) > 0)) {
    for ($mm=0; $mm<sizeof($downloads->products); $mm++) {  
    $id =  $downloads->products[$mm]['id'];
    echo '<br><small>';
    echo '<nobr>' . ENTRY_DOWNLOAD_COUNT . $downloads_count . "";
    echo ' </nobr><br>' . "\n";
  
      if (ORDER_EDITOR_USE_AJAX == 'true') {
      echo '<nobr>&nbsp;- ' . ENTRY_DOWNLOAD_FILENAME . ": <input name='update_downloads[" . $id . "][filename]' size='12' value='" . $downloads->products[$mm]['filename'] . "' onChange=\"updateDownloads('orders_products_filename', '" . $id . "', '" . $orders_products_id . "', this.value)\">";
      echo ' </nobr><br>' . "\n";
      echo '<nobr>&nbsp;- ' . ENTRY_DOWNLOAD_MAXDAYS . ": <input name='update_downloads[" . $id . "][maxdays]' size='6' value='" . $downloads->products[$mm]['maxdays'] . "' onChange=\"updateDownloads('download_maxdays', '" . $id . "', '" . $orders_products_id . "', this.value)\">";
      echo ' </nobr><br>' . "\n";
      echo '<nobr>&nbsp;- ' . ENTRY_DOWNLOAD_MAXCOUNT . ": <input name='update_downloads[" . $id . "][maxcount]' size='6' value='" . $downloads->products[$mm]['maxcount'] . "' onChange=\"updateDownloads('download_count', '" . $id . "', '" . $orders_products_id . "', this.value)\">";
      } else {
      echo '<nobr>&nbsp;- ' . ENTRY_DOWNLOAD_FILENAME . ": <input name='update_downloads[" . $id . "][filename]' size='12' value='" . $downloads->products[$mm]['filename'] . "'>";
      echo ' </nobr><br>' . "\n";
      echo '<nobr>&nbsp;- ' . ENTRY_DOWNLOAD_MAXDAYS . ": <input name='update_downloads[" . $id . "][maxdays]' size='6' value='" . $downloads->products[$mm]['maxdays'] . "'>";
      echo ' </nobr><br>' . "\n";
      echo '<nobr>&nbsp;- ' . ENTRY_DOWNLOAD_MAXCOUNT . ": <input name='update_downloads[" . $id . "][maxcount]' size='6' value='" . $downloads->products[$mm]['maxcount'] . "'>";
     }
  
     echo ' </nobr>' . "\n";
     echo '<br></small>';
     $downloads_count++;
     } //end  for ($mm=0; $mm<sizeof($download_query); $mm++) {
    }
   } //end download
  } //end if (sizeof($order->products[$i]['attributes']) > 0) {
?>
                </td>
            
			<td class="dataTableContent" valign="top"><input name="<?php echo "update_products[" . $orders_products_id . "][model]"; ?>" size="10" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateProductsField('update', '<?php echo $orders_products_id; ?>', 'products_model', encodeURIComponent(this.value))"<?php } ?> value="<?php echo $order->products[$i]['model']; ?>"></td>
            
			<td class="dataTableContent" valign="top"><input name="<?php echo "update_products[" . $orders_products_id . "][tax]"; ?>" size="5" onKeyUp="updatePrices('tax', '<?php echo $orders_products_id; ?>')" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateProductsField('reload1', '<?php echo $orders_products_id; ?>', 'products_tax', encodeURIComponent(this.value))"<?php } ?> value="<?php echo vam_display_tax_value($order->products[$i]['tax']); ?>" id="<?php echo "update_products[" . $orders_products_id . "][tax]"; ?>">%</td>
		
		    <td class="dataTableContent" valign="top"><input name="<?php echo "update_products[" . $orders_products_id . "][price]"; ?>" size="5" onKeyUp="updatePrices('price', '<?php echo $orders_products_id; ?>')" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateProductsField('reload2', '<?php echo $orders_products_id; ?>')"<?php } ?> value="<?php echo number_format($order->products[$i]['price'], 4, '.', ''); ?>" id="<?php echo "update_products[" . $orders_products_id . "][price]"; ?>"></td>
            
			<td class="dataTableContent" valign="top"><input name="<?php echo "update_products[" . $orders_products_id . "][final_price]"; ?>" size="5" onKeyUp="updatePrices('final_price', '<?php echo $orders_products_id; ?>')" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateProductsField('reload2', '<?php echo $orders_products_id; ?>')"<?php } ?> value="<?php echo number_format($order->products[$i]['price'], 4, '.', ''); ?>" id="<?php echo "update_products[" . $orders_products_id . "][final_price]"; ?>"></td>
                
			<td class="dataTableContent" valign="top"><input name="<?php echo "update_products[" . $orders_products_id . "][price_incl]"; ?>" size="5" value="<?php echo number_format(($order->products[$i]['price'] * (($order->products[$i]['tax']/100) + 1)), 4, '.', ''); ?>" onKeyUp="updatePrices('price_incl', '<?php echo $orders_products_id; ?>')" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateProductsField('reload2', '<?php echo $orders_products_id; ?>')"<?php } ?> id="<?php echo "update_products[" . $orders_products_id . "][price_incl]"; ?>"></td>
				
			<td class="dataTableContent" valign="top"><input name="<?php echo "update_products[" . $orders_products_id . "][total_excl]"; ?>" size="5" value="<?php echo number_format($order->products[$i]['price'] * $order->products[$i]['qty'], 4, '.', ''); ?>" onKeyUp="updatePrices('total_excl', '<?php echo $orders_products_id; ?>')" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateProductsField('reload2', '<?php echo $orders_products_id; ?>')"<?php } ?> id="<?php echo "update_products[" . $orders_products_id . "][total_excl]"; ?>"></td>
				
			<td class="dataTableContent" valign="top"><input name="<?php echo "update_products[" . $orders_products_id . "][total_incl]"; ?>" size="5" value="<?php echo number_format((($order->products[$i]['price'] * (($order->products[$i]['tax']/100) + 1))) * $order->products[$i]['qty'], 4, '.', ''); ?>" onKeyUp="updatePrices('total_incl', '<?php echo $orders_products_id; ?>')" <?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?>onChange="updateProductsField('reload2', '<?php echo $orders_products_id; ?>')"<?php } ?> id="<?php echo "update_products[" . $orders_products_id . "][total_incl]"; ?>"></td>
				
              </tr>
             			  
<?php
    }
  } else {
    //the order has no products
?>
              <tr class="dataTableRow">
                <td colspan="10" class="dataTableContent" valign="middle" align="center" style="padding: 20px 0 20px 0;"><?php echo TEXT_NO_ORDER_PRODUCTS; ?></td>
              </tr>
              <tr class="dataTableRow"> 
                <td colspan="10" style="border-bottom: 1px solid #C9C9C9;"><?php echo vam_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
              </tr>
<?php
  }
?>
            </table><!-- product_listing_eof //-->

				  <br>
				    <div>
					  <a class="button" href="<?php echo vam_href_link(FILENAME_ORDERS_EDIT_ADD_PRODUCT, 'oID=' . $_GET['oID'] . '&cID=' . $_GET['cID'] . '&step=1'); ?>" target="addProducts" onClick="openWindow('<?php echo vam_href_link(FILENAME_ORDERS_EDIT_ADD_PRODUCT, 'oID=' . $_GET['oID'] . '&cID=' . $_GET['cID'] . '&step=1'); ?>','addProducts');return false"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_ADD_NEW_PRODUCT; ?></span></a><input type="hidden" name="subaction" value="">
				    </div>
				  <br>
				  			
		<div id="totalsBlock">
		<table width="100%">
		  <tr><td>
			 
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
			    <tr>
             

                <!-- shipping_quote bof //-->   
                <td width="99%" valign="bottom">
                
<?php 
  if (sizeof($shipping_quotes) > 0) {
?>

                <table width="99%" cellspacing="0" cellpadding="2">
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent" colspan="3"><?php echo TABLE_HEADING_SHIPPING_QUOTES; ?></td>
                  </tr>
				  
				  				  
<?php
    $r = 0;
    for ($i=0, $n=sizeof($shipping_quotes); $i<$n; $i++) {
      for ($j=0, $n2=sizeof($shipping_quotes[$i]['methods']); $j<$n2; $j++) {
        $r++;
		if (!isset($shipping_quotes[$i]['tax'])) $shipping_quotes[$i]['tax'] = 0;
        $rowClass = ((($r/2) == (floor($r/2))) ? 'dataRowOver' : 'dataRow');
        echo '                  <tr class="' . $rowClass . '" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this, \'' . $rowClass . '\')" onClick="selectRowEffect(this, ' . $r . '); setShipping(' . $r . ');">' .
             '                    <td class="dataTableContent" valign="top" align="left">
			 <script language="JavaScript" type="text/javascript">
                   <!--
                    document.write("<input type=\"radio\" name=\"shipping\" id=\"shipping_radio_' . $r . '\" value=\"' . $shipping_quotes[$i]['id'] . '_' . $shipping_quotes[$i]['methods'][$j]['id'].'\">");
	               //-->
                  </script>
			 <input type="hidden" id="update_shipping[' . $r . '][title]" name="update_shipping[' . $r . '][title]" value="'.$shipping_quotes[$i]['module'] . ' (' . $shipping_quotes[$i]['methods'][$j]['title'].'):">' . "\n" .
			 '      <input type="hidden" id="update_shipping[' . $r . '][value]" name="update_shipping[' . $r . '][value]" value="'.$currencies->format(vam_add_tax($shipping_quotes[$i]['methods'][$j]['cost'], $shipping_quotes[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']).'">' . "\n" .
			 '      <input type="hidden" id="update_shipping[' . $r . '][id]" name="update_shipping[' . $r . '][id]" value="' . $shipping_quotes[$i]['id'] . '_' . $shipping_quotes[$i]['methods'][$j]['id'] . '">' . "\n" .
             '      <td class="dataTableContent" valign="top">' . $shipping_quotes[$i]['module'] . ' (' . $shipping_quotes[$i]['methods'][$j]['title'] . '):</td>' . "\n" . 
             '      <td class="dataTableContent" align="right">' . $currencies->format(vam_add_tax($shipping_quotes[$i]['methods'][$j]['cost'], $shipping_quotes[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) . '</td>' . "\n" . 
             '                  </tr>';
      }
    }
?>
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent" colspan="3"><?php echo sprintf(TEXT_PACKAGE_WEIGHT_COUNT, $shipping_num_boxes . ' x ' . $shipping_weight, $total_count); ?></td>
                  </tr>
                </table>

<?php
  } else {
  echo AJAX_NO_QUOTES;
  }
?>                </td>

                <!-- shipping_quote_eof //-->
                
			  <!-- order_totals bof //-->
                <td align="right" valign="top" nowrap class="dataTableRow" style="border: 1px solid #C9C9C9;">
                  <table border="0" cellspacing="0" cellpadding="2">
                    <tr class="dataTableHeadingRow">
                      <td class="dataTableHeadingContent" align="center"  width="15" nowrap onMouseover="ddrivetip('<?php echo oe_html_no_quote(HINT_TOTALS); ?>')"; onMouseout="hideddrivetip()"> <script language="JavaScript" type="text/javascript">
                   <!--
                    document.write("<img src=\"images/icon_info.gif\" border= \"0\" width=\"13\" height=\"13\">");
	               //-->
                  </script></td>
                      <td class="dataTableHeadingContent" nowrap><?php echo TABLE_HEADING_OT_TOTALS; ?></td>
                      <td class="dataTableHeadingContent" colspan="2" nowrap><?php echo TABLE_HEADING_OT_VALUES; ?></td>
                    </tr>
<?php
  for ($i=0; $i<sizeof($order->totals); $i++) {
  
    $id = $order->totals[$i]['class'];
	
	if ($order->totals[$i]['class'] == 'ot_shipping') {
	   if (vam_not_null($order->info['shipping_id'])) {
	       $shipping_module_id = $order->info['shipping_id'];
		   } else {
		   //here we could create logic to attempt to determine the shipping module used if it's not in the database
		   $shipping_module_id = '';
		   }
	  } else {
	    $shipping_module_id = '';
	  } //end if ($order->totals[$i]['class'] == 'ot_shipping') {
	 
    $rowStyle = (($i % 2) ? 'dataTableRowOver' : 'dataTableRow');
    if ( ($order->totals[$i]['class'] == 'ot_total') || ($order->totals[$i]['class'] == 'ot_subtotal') || ($order->totals[$i]['class'] == 'ot_tax') || ($order->totals[$i]['class'] == 'ot_loworderfee') ) {
      echo '                  <tr class="' . $rowStyle . '">' . "\n";
      if ($order->totals[$i]['class'] != 'ot_total') {
        echo '                    <td class="dataTableContent" align="center" valign="middle" height="15">
		<script language="JavaScript" type="text/javascript">
		<!--
		document.write("<span id=\"update_totals['.$i.']\"><a href=\"javascript:setCustomOTVisibility(\'update_totals['.($i+1).']\', \'visible\', \'update_totals['.$i.']\');\"><img src=\"order_editor/images/plus.gif\" border=\"0\" alt=\"' . IMAGE_ADD_NEW_OT . '\" title=\"' . IMAGE_ADD_NEW_OT . '\"></a></span>");
		//-->
        </script></td>' . "\n";
      } else {
        echo '                    <td class="dataTableContent" align="center" valign="middle">&nbsp;</td>' . "\n";
      }
      
      echo '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][title]" value="' . strip_tags(trim($order->totals[$i]['title'])) . '" readonly="readonly"></td>' . "\n";
	  
      if ($order->info['currency'] != DEFAULT_CURRENCY) echo '                    <td class="dataTableContent">&nbsp;</td>' . "\n";
      echo '                    <td align="right" class="dataTableContent" nowrap>' . $order->totals[$i]['text'] . '<input name="update_totals['.$i.'][value]" type="hidden" value="' . number_format($order->totals[$i]['value'], 2, '.', '') . '"><input name="update_totals['.$i.'][class]" type="hidden" value="' . $order->totals[$i]['class'] . '"></td>' . "\n" .
           '                  </tr>' . "\n";
    } else {
      if ($i % 2) {
        echo '                  	    <script language="JavaScript" type="text/javascript">
		<!--
		document.write("<tr class=\"' . $rowStyle . '\" id=\"update_totals['.$i.']\" style=\"visibility: hidden; display: none;\"><td class=\"dataTableContent\" align=\"center\" valign=\"middle\" height=\"15\"><a href=\"javascript:setCustomOTVisibility(\'update_totals['.($i).']\', \'hidden\', \'update_totals['.($i-1).']\');\"><img src=\"order_editor/images/minus.gif\" border=\"0\" alt=\"' . IMAGE_REMOVE_NEW_OT . '\" title=\"' . IMAGE_REMOVE_NEW_OT . '\"></a></td>");
			 //-->
        </script>
			 
			 <noscript><tr class="' . $rowStyle . '" id="update_totals['.$i.']" >' . "\n" .
             '                    <td class="dataTableContent" valign="middle" height="15"></td></noscript>' . "\n";
      } else {
        echo '                  <tr class="' . $rowStyle . '">' . "\n" .
             '                    <td class="dataTableContent" align="center" valign="middle" height="15">
	    <script language="JavaScript" type="text/javascript">
		<!--
		document.write("<span id=\"update_totals['.$i.']\"><a href=\"javascript:setCustomOTVisibility(\'update_totals['.($i+1).']\', \'visible\', \'update_totals['.$i.']\');\"><img src=\"order_editor/images/plus.gif\" border=\"0\" alt=\"' . IMAGE_ADD_NEW_OT . '\" title=\"' . IMAGE_ADD_NEW_OT . '\"></a></span>");
		//-->
        </script></td>' . "\n";
      }

       if (ORDER_EDITOR_USE_AJAX == 'true') {
	  echo '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][title]" id="'.$id.'[title]" value="' . strip_tags(trim($order->totals[$i]['title'])) . '" onChange="obtainTotals()"></td>' . "\n" .
           '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][value]" id="'.$id.'[value]" value="' . number_format((double)$order->totals[$i]['value'], 2, '.', '') . '" size="6" onChange="obtainTotals()"><input name="update_totals['.$i.'][class]" type="hidden" value="' . $order->totals[$i]['class'] . '"><input name="update_totals['.$i.'][id]" type="hidden" value="' . $shipping_module_id . '" id="' . $id . '[id]"></td>' . "\n";
		   } else {
	  echo '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][title]" id="'.$id.'[title]" value="' . strip_tags(trim($order->totals[$i]['title'])) . '"></td>' . "\n" .
           '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][value]" id="'.$id.'[value]" value="' . number_format((double)$order->totals[$i]['value'], 2, '.', '') . '" size="6"><input name="update_totals['.$i.'][class]" type="hidden" value="' . $order->totals[$i]['class'] . '"><input name="update_totals['.$i.'][id]" type="hidden" value="' . $shipping_module_id . '" id="' . $id . '[id]"></td>' . "\n";
		   }
		   
      if ($order->info['currency'] != DEFAULT_CURRENCY) echo '                    <td align="right" class="dataTableContent" nowrap>' . $order->totals[$i]['text'] . '</td>' . "\n";
      echo '                  </tr>' . "\n";
    }
  }
?>
                </table>
			  </td>
                <!-- order_totals_eof //-->

              </tr> 
            </table>
		  
		  </td></tr>
		 </table> 
	  </div>
    </div> <!-- this is end of the master div for the whole totals/shipping area -->
		      
	<?php if (ORDER_EDITOR_USE_AJAX != 'true') { ?> 
    <!-- Begin Update Block, only for non-javascript browsers -->

	  <br>
            <div class="updateBlock">
              <div class="update1"><?php echo HINT_PRESS_UPDATE; ?></div>
              <div class="update2">&nbsp;</div>
              <div class="update3">&nbsp;</div>
              <div class="update4" align="center"><?php echo ENTRY_SEND_NEW_ORDER_CONFIRMATION; ?>&nbsp;<?php echo vam_draw_checkbox_field('nC1', '', false); ?></div>
              <div class="update5" align="center"><span class="button"><button type="submit" value="<?php echo BUTTON_UPDATE; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_UPDATE; ?></button></span></div>
           </div>
		  
	       <br>
            <div><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></div>
	 
	 <!-- End of Update Block -->  
	 <?php } ?>
		
</div>
<div id="other">
		
	  <div id="historyMessageStack"></div>

    <div id="commentsBlock">
	<table style="border: 1px solid #C9C9C9;" cellspacing="0" cellpadding="2" class="dataTableRow" id="commentsTable" width="100%">
     <tr class="dataTableHeadingRow">
      <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_DELETE; ?></td>
      <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_DATE_ADDED; ?></td>
      <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></td>
      <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_STATUS; ?></td>
      <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_COMMENTS; ?></td>
    </tr>
    <?php
      $orders_history_query = vam_db_query("SELECT orders_status_history_id, orders_status_id, date_added, customer_notified, comments 
                                            FROM " . TABLE_ORDERS_STATUS_HISTORY . " 
									        WHERE orders_id = '" . (int)$oID . "' 
									        ORDER BY date_added");
        if (vam_db_num_rows($orders_history_query)) {
          while ($orders_history = vam_db_fetch_array($orders_history_query)) {
          
		   $r++;
           $rowClass = ((($r/2) == (floor($r/2))) ? 'dataRowOver' : 'dataRow');
        
	      if (ORDER_EDITOR_USE_AJAX == 'true') { 
		   echo '  <tr class="' . $rowClass . '" id="commentRow' . $orders_history['orders_status_history_id'] . '" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this, \'' . $rowClass . '\')">' . "\n" .
         '	  <td class="smallText" align="center"><div id="do_not_delete"><input name="update_comments[' . $orders_history['orders_status_history_id'] . '][delete]" type="checkbox" onClick="updateCommentsField(\'delete\', \'' . $orders_history['orders_status_history_id'] . '\', this.checked, \'\', this)"></div></td>' . "\n" . 
         '    <td class="smallText" align="center">' . vam_datetime_short($orders_history['date_added']) . '</td>' . "\n" .
         '    <td class="smallText" align="center">';
		 } else {
		 echo '  <tr class="' . $rowClass . '" id="commentRow' . $orders_history['orders_status_history_id'] . '" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this, \'' . $rowClass . '\')">' . "\n" .
         '	  <td class="smallText" align="center"><div id="do_not_delete"><input name="update_comments[' . $orders_history['orders_status_history_id'] . '][delete]" type="checkbox"></div></td>' . "\n" . 
         '    <td class="smallText" align="center">' . vam_datetime_short($orders_history['date_added']) . '</td>' . "\n" .
         '    <td class="smallText" align="center">';
		 }
      
	   if ($orders_history['customer_notified'] == '1') {
        echo vam_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
         } else {
        echo vam_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
         }
       
	    echo '<td class="smallText" align="left">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . "\n";
        echo '<td class="smallText" align="left">';
  
        if (ORDER_EDITOR_USE_AJAX == 'true') { 
		echo vam_draw_textarea_field("update_comments[" . $orders_history['orders_status_history_id'] . "][comments]", "soft", "40", "5", 
  "" .	vam_db_output($orders_history['comments']) . "", "onChange=\"updateCommentsField('update', '" . $orders_history['orders_status_history_id'] . "', 'false', encodeURIComponent(this.value))\"") . '' . "\n" .
		 '    </td>' . "\n";
		 } else {
		 echo vam_draw_textarea_field("update_comments[" . $orders_history['orders_status_history_id'] . "][comments]", "soft", "40", "5", 
  "" .	vam_db_output($orders_history['comments']) . "") . '' . "\n" .
		 '    </td>' . "\n";
		 }
 
        echo '  </tr>' . "\n";
  
        }
       } else {
       echo '  <tr>' . "\n" .
            '    <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
            '  </tr>' . "\n";
       }

    ?>
  </table> 
  </div>
				  
      <div>
	  <?php echo vam_draw_separator('pixel_trans.gif', '1', '1'); ?>
	  </div>
	  <br>
	
<table style="border: 1px solid #C9C9C9;" cellspacing="0" cellpadding="2" class="dataTableRow">
  <tr class="dataTableHeadingRow">
    <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_NEW_STATUS; ?></td>
    <td class="main" width="10">&nbsp;</td>
    <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_COMMENTS; ?></td>
  </tr>
	<tr>
	  <td>
		  <table border="0" cellspacing="0" cellpadding="2">
		  
        <tr>
          <td class="main"><b><?php echo ENTRY_STATUS; ?></b></td>
          <td class="main" align="right"><?php echo vam_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status'], 'id="status"'); ?></td>
        </tr>
        <tr>
          <td class="main"><b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b></td>
          <td class="main" align="right"><?php echo oe_draw_checkbox_field('notify', '', false, '', 'id="notify"'); ?></td>
        </tr>
        <tr>
          <td class="main"><b><?php echo ENTRY_NOTIFY_COMMENTS; ?></b></td>
          <td class="main" align="right"><?php echo oe_draw_checkbox_field('notify_comments', '', false, '', 'id="notify_comments"'); ?></td>
        </tr>
     </table>
	  </td>
    <td class="main" width="10">&nbsp;</td>
    <td class="main">
    <?php echo vam_draw_textarea_field('comments', 'soft', '40', '5', '', 'id="comments"'); ?>
    </td>
  </tr>
    
	<?php if (ORDER_EDITOR_USE_AJAX == 'true') { ?> 
	<script language="JavaScript" type="text/javascript">
     <!--
	     document.write("<tr>");
         document.write("<td colspan=\"3\" align=\"right\">");
		 document.write("<span class=\"button\"><button type=\"button\" name=\"comments_button\" value=\"<?php echo oe_html_no_quote(AJAX_SUBMIT_COMMENT); ?>\" onClick=\"javascript:getNewComment();\"><img src=\"images/icons/buttons/add.png\" border=\"0\" alt=\"\" width=\"12\" height=\"12\">&nbsp;&nbsp;<?php echo oe_html_no_quote(AJAX_SUBMIT_COMMENT); ?></button></span>");
		 document.write("</td>");
		 document.write("</tr>");
	 //-->
    </script>
	<?php } ?>
				  
  </table>
  
    <div>
	  <?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?>
	</div>
    
	<!-- End of Status Block -->

	<?php if (ORDER_EDITOR_USE_AJAX != 'true') { ?> 
	<!-- Begin Update Block, only for non-javascript browsers -->
	       <div class="updateBlock">
              <div class="update1"><?php echo HINT_PRESS_UPDATE; ?></div>
              <div class="update2">&nbsp;</div>
              <div class="update3">&nbsp;</div>
              <div class="update4" align="center"><?php echo ENTRY_SEND_NEW_ORDER_CONFIRMATION; ?>&nbsp;<?php echo vam_draw_checkbox_field('nC1', '', false); ?></div>
              <div class="update5" align="center"><span class="button"><button type="submit" value="<?php echo BUTTON_UPDATE; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_UPDATE; ?></button></span></div>
          </div>
		  
	       <br>
            <div><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></div>
            
</div>    
</div>        
	
	<!-- End of Update Block -->
	<?php   }  //end if (ORDER_EDITOR_USE_AJAX != 'true') {
          echo '</form>';
        }
    ?>
  <!-- body_text_eof //-->
      </td>
    </tr>
  </table>
  <!-- body_eof //-->

  <!-- footer //-->
  <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
  <!-- footer_eof //-->
  <br>
  </body>
  </html>
  <?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
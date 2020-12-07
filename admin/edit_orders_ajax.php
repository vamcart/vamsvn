<?php
  /*
  $Id: edit_orders_ajax.php v5.0 07/19/2007 djmonkey1 Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
  
  For Order Editor support or to post bug reports, feature requests, etc, please visit the Order Editor support thread:
  http://forums.oscommerce.com/index.php?showtopic=54032
  
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
  
  require_once (DIR_FS_CATALOG.DIR_WS_CLASSES.'vam_price.php');

  // output a response header
  header('Content-type: text/html; charset='.$_SESSION['language_charset'].'');

  // include the appropriate functions & classes
  include('order_editor/functions.php');
  include('order_editor/cart.php');
  include('order_editor/order.php');
  include('order_editor/shipping.php');
  include('order_editor/http_client.php');
  include(DIR_WS_LANGUAGES . $_SESSION['language']. '/admin/' . FILENAME_ORDERS_EDIT);

   
  // Include currencies class
  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();
  
  //$action 
  if (sizeof($_GET) > 0) {
     $action = $_GET['action']; 
  } elseif (sizeof($_POST) > 0) {
	 $action = $_POST['action']; 
	 } 
   
  //1.  Update most the orders table
  if ($action == 'update_order_field') {
	  vam_db_query("UPDATE " . TABLE_ORDERS . " SET " . $_GET['field'] . " = '" . vam_db_input(vam_db_prepare_input($_GET['new_value'])) . "' WHERE orders_id = '" . $_GET['oID'] . "'");

      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$_GET['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => vam_db_input(vam_db_prepare_input($_GET['field'])),
                              'value' => vam_db_input(vam_db_prepare_input($_GET['new_value'])),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform(TABLE_ORDERS_LOG, $sql_data_array);
	  
	  //generate responseText
	  echo $_GET['field'];

  }
  
  //2.  Update the orders_products table for qty, tax, name, or model
if ($action == 'update_product_field') {
	  vam_db_query("UPDATE " . TABLE_ORDERS_PRODUCTS . " SET " . $_GET['field'] . " = '" . vam_db_input(vam_db_prepare_input($_GET['new_value'])) . "', allow_tax = '0'  WHERE orders_products_id = '" . $_GET['pid'] . "' AND orders_id = '" . $_GET['oID'] . "'");

	  //  Update Inventory Quantity
    $order_products_id_query = vam_db_query("
    SELECT products_id, products_quantity
    FROM " . TABLE_ORDERS_PRODUCTS . "
    WHERE orders_id = '" . (int)$_GET['oID'] . "'
    AND orders_products_id = '" . (int)$_GET['pid'] . "'");
    $order_products_id = vam_db_fetch_array($order_products_id_query);

      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$_GET['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => vam_db_input(vam_db_prepare_input($_GET['field'].'  '.vam_get_products_name($order_products_id['products_id']))),
                              'value' => vam_db_input(vam_db_prepare_input($_GET['new_value'])),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform(TABLE_ORDERS_LOG, $sql_data_array);
      	
	  //generate responseText
	  echo $_GET['field'];

  }
    
  //2.  Update the orders_products table for qty, tax, name, or model
  if ($action == 'update_product_field') {
			
		if ($_GET['field'] == 'products_quantity') {
			// Update Inventory Quantity
			$order_query = vam_db_query("
			SELECT products_id, products_quantity 
			FROM " . TABLE_ORDERS_PRODUCTS . " 
			WHERE orders_id = '" . $_GET['oID'] . "'
			AND orders_products_id = '" . $_GET['pid'] . "'");
			$orders_product_info = vam_db_fetch_array($order_query);
			
			// stock check 
			
			if ($_GET['new_value'] != $orders_product_info['products_quantity']){
			$quantity_difference = ($_GET['new_value'] - $orders_product_info['products_quantity']);
				if (STOCK_LIMITED == 'true'){
				    vam_db_query("UPDATE " . TABLE_PRODUCTS . " SET 
					products_quantity = products_quantity - " . $quantity_difference . ",
					products_ordered = products_ordered + " . $quantity_difference . " 
					WHERE products_id = '" . $orders_product_info['products_id'] . "'");
					} else {
					vam_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_ordered = products_ordered + " . $quantity_difference . "
					WHERE products_id = '" . $orders_product_info['products_id'] . "'");
				} //end if (STOCK_LIMITED == 'true'){
			} //end if ($_GET['new_value'] != $orders_product_info['products_quantity']){
		}//end if ($_GET['field'] = 'products_quantity'
		
	  vam_db_query("UPDATE " . TABLE_ORDERS_PRODUCTS . " SET " . $_GET['field'] . " = '" . vam_db_input(vam_db_prepare_input($_GET['new_value'])) . "', allow_tax = '0'  WHERE orders_products_id = '" . $_GET['pid'] . "' AND orders_id = '" . $_GET['oID'] . "'");
	

     //Update final_price
	  vam_db_query("UPDATE " . TABLE_ORDERS_PRODUCTS . " SET final_price = '" . vam_db_input(vam_db_prepare_input($_GET['final_price'])) . "', allow_tax = '0'  WHERE orders_products_id = '" . $_GET['pid'] . "' AND orders_id = '" . $_GET['oID'] . "'");

	  //  Update Inventory Quantity
    $order_products_id_query = vam_db_query("
    SELECT products_id, products_quantity
    FROM " . TABLE_ORDERS_PRODUCTS . "
    WHERE orders_id = '" . (int)$_GET['oID'] . "'
    AND orders_products_id = '" . (int)$_GET['pid'] . "'");
    $order_products_id = vam_db_fetch_array($order_products_id_query);

      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$_GET['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => vam_db_input(vam_db_prepare_input($_GET['field']. ', qty: '.$_GET['new_value'].'  '.vam_get_products_name($order_products_id['products_id']))),
                              'value' => vam_db_input(vam_db_prepare_input($_GET['final_price'])),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform(TABLE_ORDERS_LOG, $sql_data_array);
	
	  //generate responseText
	  echo $_GET['field'];

  }
  
  //3.  Update the orders_products table for price and final_price (interdependent values)
if ($action == 'update_product_value_field') {
	  vam_db_query("UPDATE " . TABLE_ORDERS_PRODUCTS . " SET products_price = '" . vam_db_input(vam_db_prepare_input($_GET['price'])) . "', final_price = '" . vam_db_input(vam_db_prepare_input($_GET['final_price'])) . "', allow_tax = '0' WHERE orders_products_id = '" . $_GET['pid'] . "' AND orders_id = '" . $_GET['oID'] . "'");

	  //  Update Inventory Quantity
    $order_products_id_query = vam_db_query("
    SELECT products_id, products_quantity
    FROM " . TABLE_ORDERS_PRODUCTS . "
    WHERE orders_id = '" . (int)$_GET['oID'] . "'
    AND orders_products_id = '" . (int)$_GET['pid'] . "'");
    $order_products_id = vam_db_fetch_array($order_products_id_query);
    
      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$_GET['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => vam_db_input(vam_db_prepare_input('price_change: '.vam_get_products_name($order_products_id['products_id']))),
                              'value' => vam_db_input(vam_db_prepare_input('price: '.number_format($_GET['price'],0,'.','').' total: '.number_format($_GET['final_price'],0,'.',''))),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform(TABLE_ORDERS_LOG, $sql_data_array);
	  
	  //generate responseText
	  echo TABLE_ORDERS_PRODUCTS;

  }
  
    //4.  Update the orders_products_attributes table 
if ($action == 'update_attributes_field') {
	  
	  vam_db_query("UPDATE " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " SET " . $_GET['field'] . " = '" . vam_db_input(vam_db_prepare_input($_GET['new_value'])) . "'  WHERE orders_products_attributes_id = '" . $_GET['aid'] . "' AND orders_products_id = '" . $_GET['pid'] . "' AND orders_id = '" . $_GET['oID'] . "'");

      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$_GET['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => vam_db_input(vam_db_prepare_input($_GET['field'])),
                              'value' => vam_db_input(vam_db_prepare_input($_GET['new_value'])),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform(TABLE_ORDERS_LOG, $sql_data_array);

	  if (isset($_GET['final_price'])) {
	    
		vam_db_query("UPDATE " . TABLE_ORDERS_PRODUCTS . " SET final_price = '" . vam_db_input(vam_db_prepare_input($_GET['final_price'])) . "', allow_tax = '0'  WHERE orders_products_id = '" . $_GET['pid'] . "' AND orders_id = '" . $_GET['oID'] . "'");

      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$_GET['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => vam_db_input(vam_db_prepare_input($_GET['field'])),
                              'value' => vam_db_input(vam_db_prepare_input($_GET['final_price'])),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform(TABLE_ORDERS_LOG, $sql_data_array);
	  
	  }
	  
	  //generate responseText
	  echo $_GET['field'];

  }
  
    //5.  Update the orders_products_download table 
if ($action == 'update_downloads') {
	  vam_db_query("UPDATE " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " SET " . $_GET['field'] . " = '" . vam_db_input(vam_db_prepare_input($_GET['new_value'])) . "' WHERE orders_products_download_id = '" . $_GET['did'] . "' AND orders_products_id = '" . $_GET['pid'] . "' AND orders_id = '" . $_GET['oID'] . "'");

      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$_GET['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => vam_db_input(vam_db_prepare_input($_GET['field'])),
                              'value' => vam_db_input(vam_db_prepare_input($_GET['new_value'])),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform(TABLE_ORDERS_LOG, $sql_data_array);
	  
	 //generate responseText
	  echo $_GET['field'];

  }
  
  //6. Update the currency of the order
  if ($action == 'update_currency') {
  	  vam_db_query("UPDATE " . TABLE_ORDERS . " SET currency = '" . vam_db_input(vam_db_prepare_input($_GET['currency'])) . "', currency_value = '" . vam_db_input(vam_db_prepare_input($_GET['currency_value'])) . "' WHERE orders_id = '" . $_GET['oID'] . "'");

      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$_GET['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => vam_db_input(vam_db_prepare_input($_GET['currency'])),
                              'value' => vam_db_input(vam_db_prepare_input($_GET['currency_value'])),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform(TABLE_ORDERS_LOG, $sql_data_array);
  
  	 //generate responseText
	  echo $_GET['currency'];
  
  }//end if ($action == 'update_currency') {
  
  
  //7.  Update most any field in the orders_products table
  if ($action == 'delete_product_field') {
  
  		  	       //  Update Inventory Quantity
			      $order_query = vam_db_query("
			      SELECT products_id, products_quantity 
			      FROM " . TABLE_ORDERS_PRODUCTS . " 
			      WHERE orders_id = '" . $_GET['oID'] . "'
			      AND orders_products_id = '" . $_GET['pid'] . "'");
			      $order = vam_db_fetch_array($order_query);

		   			 //update quantities first
			       if (STOCK_LIMITED == 'true'){
				    vam_db_query("UPDATE " . TABLE_PRODUCTS . " SET 
					products_quantity = products_quantity + " . $order['products_quantity'] . ",
					products_ordered = products_ordered - " . $order['products_quantity'] . " 
					WHERE products_id = '" . (int)$order['products_id'] . "'");
					} else {
					vam_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
					products_ordered = products_ordered - " . $order['products_quantity'] . "
					WHERE products_id = '" . (int)$order['products_id'] . "'");
					}
		   
                    vam_db_query("DELETE FROM " . TABLE_ORDERS_PRODUCTS . "  
	                              WHERE orders_id = '" . $_GET['oID'] . "'
					              AND orders_products_id = '" . $_GET['pid'] . "'");
      
	                vam_db_query("DELETE FROM " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
	                              WHERE orders_id = '" . $_GET['oID'] . "'
                                  AND orders_products_id = '" . $_GET['pid'] . "'");
	                
					vam_db_query("DELETE FROM " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . "
	                              WHERE orders_id = '" . $_GET['oID'] . "'
                                  AND orders_products_id = '" . $_GET['pid'] . "'");

      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$_GET['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => 'remove_product',
                              'value' => vam_get_products_name($order['products_id']) . ' ' . (int)$order['products_id'],
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform(TABLE_ORDERS_LOG, $sql_data_array);
								  
      //generate responseText
	  echo TABLE_ORDERS_PRODUCTS;

  }

  
  //8. Update the orders_status_history table
  if ($action == 'delete_comment') {
      
	  vam_db_query("DELETE FROM " . TABLE_ORDERS_STATUS_HISTORY . " WHERE orders_status_history_id = '" . $_GET['cID'] . "' AND orders_id = '" . $_GET['oID'] . "'");

      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$_GET['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => 'comment',
                              'value' => 'remove',
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform(TABLE_ORDERS_LOG, $sql_data_array);
	  
	  //generate responseText
	  echo TABLE_ORDERS_STATUS_HISTORY;
	  
	  }
	  

  //9. Update the orders_status_history table
  if ($action == 'update_comment') {
      
	  vam_db_query("UPDATE " . TABLE_ORDERS_STATUS_HISTORY . " SET comments = '" . vam_db_input(vam_db_prepare_input($_GET['comment'])) . "' WHERE orders_status_history_id = '" . $_GET['cID'] . "' AND orders_id = '" . $_GET['oID'] . "'");

      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$_GET['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => 'comment add',
                              'value' => vam_db_input(vam_db_prepare_input($_GET['comment'])),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform(TABLE_ORDERS_LOG, $sql_data_array);
	  
	  //generate responseText
	  echo TABLE_ORDERS_STATUS_HISTORY;
	  
	  }
	  

  //10. Reload the shipping and order totals block 
    if ($action == 'reload_totals') { 
         
	   $oID = $_POST['oID'];
	   $shipping = array();
	  
       if (is_array($_POST['update_totals'])) {
	    foreach($_POST['update_totals'] as $total_index => $total_details) {
          extract($total_details, EXTR_PREFIX_ALL, "ot");
        if ($ot_class == "ot_shipping") {

			    $shipping['cost'] = $ot_value;
          $shipping['title'] = $ot_title;
			    $shipping['id'] = $ot_id;

      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$_POST['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => 'shipping method change',
                              'value' => vam_db_input(vam_db_prepare_input($ot_title.' '.$ot_id . ' ' . $ot_value)),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform('orders_log', $sql_data_array);

        } // end if ($ot_class == "ot_shipping")
         } //end foreach
	   } //end if is_array
	
	  if (vam_not_null($shipping['id'])) {
    vam_db_query("UPDATE " . TABLE_ORDERS . " SET shipping_method = '" . $shipping['title'] . "' WHERE orders_id = '" . $_POST['oID'] . "'");
    vam_db_query("UPDATE " . TABLE_ORDERS . " SET shipping_class = '" . $shipping['id'] . "' WHERE orders_id = '" . $_POST['oID'] . "'");

	   }
	   
		$order = new manualOrder($oID);
		
      $vamPrice = new vamPrice($order->info['currency'], $order->info['status'],$order->customer['ID']);

		$order->adjust_zones();
				
		$cart = new manualCart();
        $cart->restore_contents($oID);
        $total_count = $cart->count_contents();
        $total_weight = $cart->show_weight();
		
		// Get the shipping quotes
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
		$written_ot_totals_array = array();
		$written_ot_titles_array = array();
		//how many weird arrays can I make today?
		
        $current_ot_totals_query = vam_db_query("select class, title from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$oID . "' order by sort_order");
        while ($current_ot_totals = vam_db_fetch_array($current_ot_totals_query)) {
          $current_ot_totals_array[] = $current_ot_totals['class'];
		  $current_ot_titles_array[] = strip_tags($current_ot_totals['title']);
        }


        vam_db_query("delete from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . (int)$oID . "'");
        
        $j=1; //giving something a sort order of 1 ain't my bag baby
		$new_order_totals = array();
		
	    if (is_array($_POST['update_totals'])) { //1
          foreach($_POST['update_totals'] as $total_index => $total_details) { //2
            extract($total_details, EXTR_PREFIX_ALL, "ot");
            if (!strstr($ot_class, 'ot_custom')) { //3
             for ($i=0, $n=sizeof($order_totals); $i<$n; $i++) { //4
              			  
			  if ($order_totals[$i]['code'] == 'ot_tax') { //5
			  $new_ot_total = ((in_array($order_totals[$i]['title'], $current_ot_titles_array)) ? false : true);
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
          
      // Log Order Data
/*      $sql_data_array = array('orders_id' => (int)$_GET['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => 'update_total '.$new_order_totals[$i]['class'],
                              'value' => vam_db_input(vam_db_prepare_input($new_order_totals[$i]['value'])),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform(TABLE_ORDERS_LOG, $sql_data_array);    */
          
          
        }


        $order = new manualOrder($oID);
        
      $vamPrice = new vamPrice($order->info['currency'], $order->info['status'],$order->customer['ID']);
        
        $shippingKey = $order->adjust_totals($oID);
        $order->adjust_zones();
        
        $cart = new manualCart();
        $cart->restore_contents($oID);
        $total_count = $cart->count_contents();
        $total_weight = $cart->show_weight();

		
  
  ?>

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
        echo '                  <tr class="' . $rowClass . '" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this, \'' . $rowClass . '\')" onclick="selectRowEffect(this, ' . $r . '); setShipping(' . $r . ');">' . "\n" .
             
    '      <td class="dataTableContent" valign="top" align="left" width="15px">' . "\n" .
	
	'      <input type="radio" name="shipping" id="shipping_radio_' . $r . '" value="' . $shipping_quotes[$i]['id'] . '_' . $shipping_quotes[$i]['methods'][$j]['id'].'">' . "\n" .
			 
	'      <input type="hidden" id="update_shipping['.$r.'][title]" name="update_shipping['.$r.'][title]" value="'.$shipping_quotes[$i]['module'] . ' (' . $shipping_quotes[$i]['methods'][$j]['title'].'):">' . "\n" .
			
    '      <input type="hidden" id="update_shipping['.$r.'][value]" name="update_shipping['.$r.'][value]" value="'.$currencies->format(vam_add_tax($shipping_quotes[$i]['methods'][$j]['cost'], $shipping_quotes[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']).'">' . "\n" .
	
	'      <input type="hidden" id="update_shipping[' . $r . '][id]" name="update_shipping[' . $r . '][id]" value="' . $shipping_quotes[$i]['id'] . '_' . $shipping_quotes[$i]['methods'][$j]['id'] . '">' . "\n" .
    
	'        <td class="dataTableContent" valign="top">' . $shipping_quotes[$i]['module'] . ' (' . $shipping_quotes[$i]['methods'][$j]['title'] . '):</td>' . "\n" . 
    
	'        <td class="dataTableContent" align="right">' . $currencies->format(vam_add_tax($shipping_quotes[$i]['methods'][$j]['cost'], $shipping_quotes[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) . '</td>' . "\n" . 
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
        <td class="dataTableHeadingContent" align="center" width="15" nowrap onMouseover="ddrivetip('<?php echo oe_html_no_quote(HINT_TOTALS); ?>')"; onMouseout="hideddrivetip()"><img src="images/icon_info.gif" border="0" width="13" height="13"></td>
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
    if ((!strstr($order->totals[$i]['class'], 'ot_custom')) && ($order->totals[$i]['class'] != 'ot_shipping')) {
      echo '                  <tr class="' . $rowStyle . '">' . "\n";
      if ($order->totals[$i]['class'] != 'ot_total') {
        echo '                    <td class="dataTableContent" align="center"  valign="middle" height="15"><span id="update_totals['.$i.']"><a href="javascript:setCustomOTVisibility(\'update_totals['.($i+1).']\', \'visible\', \'update_totals['.$i.']\');">' . vam_image('order_editor/images/plus.gif', IMAGE_ADD_NEW_OT) . '</a></span></td>' . "\n";
      } else {
        echo '                    <td class="dataTableContent" valign="middle">&nbsp;</td>' . "\n";
      }
      
      echo '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][title]" value="' . strip_tags(trim($order->totals[$i]['title'])) . '" readonly="readonly"></td>' . "\n";
	  
      if ($order->info['currency'] != DEFAULT_CURRENCY) echo '                    <td class="dataTableContent">&nbsp;</td>' . "\n";
      echo '                    <td align="right" class="dataTableContent" nowrap>' . $order->totals[$i]['text'] . '<input name="update_totals['.$i.'][value]" type="hidden" value="' . number_format($order->totals[$i]['value'], 2, '.', '') . '"><input name="update_totals['.$i.'][class]" type="hidden" value="' . $order->totals[$i]['class'] . '"></td>' . "\n" .
           '                  </tr>' . "\n";
    } else {
      if ($i % 2) {
        echo '                  <tr class="' . $rowStyle . '" id="update_totals['.$i.']" style="visibility: hidden; display: none;">' . "\n" .
             '                    <td class="dataTableContent" align="center" valign="middle" height="15"><a href="javascript:setCustomOTVisibility(\'update_totals['.($i).']\', \'hidden\', \'update_totals['.($i-1).']\');">' . vam_image('order_editor/images/minus.gif', IMAGE_REMOVE_NEW_OT) . '</a></td>' . "\n";
      } else {
        echo '                  <tr class="' . $rowStyle . '">' . "\n" .
             '                    <td class="dataTableContent" align="center" valign="middle" height="15"><span id="update_totals['.$i.']"><a href="javascript:setCustomOTVisibility(\'update_totals['.($i+1).']\', \'visible\', \'update_totals['.$i.']\');">' . vam_image('order_editor/images/plus.gif', IMAGE_ADD_NEW_OT) . '</a></span></td>' . "\n";
      }

      echo '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][title]" id="'.$id.'[title]" value="' . strip_tags(trim($order->totals[$i]['title'])) . '"  onChange="obtainTotals()"></td>' . "\n" .
           '                    <td align="right" class="dataTableContent">';
                 echo '<input name="update_totals['.$i.'][value]" id="'.$id.'[value]" value="' . number_format((double)$order->totals[$i]['value'], 2, '.', '') . '" size="6"  onChange="obtainTotals()">';
                 echo '<input name="update_totals['.$i.'][class]" type="hidden" value="' . $order->totals[$i]['class'] . '"><input name="update_totals['.$i.'][id]" type="hidden" value="' . $shipping_module_id . '" id="' . $id . '[id]"></td>' . "\n";
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
	   
  
<?php } //end if ($action == 'reload_shipping') {  

	
	//11. insert new comments
	 if ($action == 'insert_new_comment') {  
	 
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
			   
   // UPDATE STATUS HISTORY & SEND EMAIL TO CUSTOMER IF NECESSARY #####

    $check_status_query = vam_db_query("
	                      SELECT customers_name, customers_email_address, orders_status, date_purchased 
	                      FROM " . TABLE_ORDERS . " 
						  WHERE orders_id = '" . $_GET['oID'] . "'");
						  
    $check_status = vam_db_fetch_array($check_status_query); 
	
  if (($check_status['orders_status'] != $_GET['status']) || (vam_not_null($_GET['comments']))) {

        vam_db_query("UPDATE " . TABLE_ORDERS . " SET 
					  orders_status = '" . vam_db_input($_GET['status']) . "', 
                      last_modified = now() 
                      WHERE orders_id = '" . $_GET['oID'] . "'");
		
		 // Notify Customer ?
      $customer_notified = '0';
			if (isset($_GET['notify']) && ($_GET['notify'] == 'true')) {
			  $notify_comments = '';
			  if (isset($_GET['notify_comments']) && ($_GET['notify_comments'] == 'true')) {
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
           $billing_subject = str_replace('{$nr}', $_GET['oID'], EMAIL_BILLING_SUBJECT);

				vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $check_status['customers_email_address'], $check_status['customers_name'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $billing_subject, $html_mail, $txt_mail);

				if (defined('AVISOSMS_EMAIL') && AVISOSMS_EMAIL != '') {

				$html_mail_sms = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/change_order_mail_sms.html');
				$txt_mail_sms = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/change_order_mail_sms.txt');

				// sms to customer
				vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, AVISOSMS_EMAIL, $check_status['customers_name'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $check_status['customers_telephone'], $html_mail_sms, $txt_mail_sms);
				}
				
				//Send answer template 
				vam_send_answer_template($_GET['oID'],$_GET['status'],'on','on');
			  
			  $customer_notified = '1';
			  
        // denuz added accumulated discount

        $changed = false;
        
        $check_group_query = vam_db_query("select customers_status_id from " . TABLE_CUSTOMERS_STATUS_ORDERS_STATUS . " where orders_status_id = " . (int)$_GET['status']);
        if (vam_db_num_rows($check_group_query)) {
           while ($groups = vam_db_fetch_array($check_group_query)) {
              // calculating total customers purchase
              // building query
              $customer_query = vam_db_query("select c.* from customers as c, orders as o where o.customers_id = c.customers_id and o.orders_id = " . (int)$_GET['oID']);
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
			}			  
          		
			vam_db_query("INSERT into " . TABLE_ORDERS_STATUS_HISTORY . " 
			(orders_id, orders_status_id, date_added, customer_notified, comments) 
			values ('" . vam_db_input($_GET['oID']) . "', 
				'" . vam_db_input($_GET['status']) . "', 
				now(), 
				" . vam_db_input($customer_notified) . ", 
				'" . vam_db_input(vam_db_prepare_input($_GET['comments']))  . "')");
			}

?>
	<table style="border: 1px solid #C9C9C9;" cellspacing="0" cellpadding="2" class="dataTableRow" id="commentsTable" width="100%">
  <tr class="dataTableHeadingRow">
    <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_DELETE; ?></td>
    <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_DATE_ADDED; ?></td>
    <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></td>
    <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_STATUS; ?></td>
    <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_COMMENTS; ?></td>
   </tr>
<?php
$r = 0;
$orders_history_query = vam_db_query("SELECT orders_status_history_id, orders_status_id, date_added, customer_notified, comments 
                                    FROM " . TABLE_ORDERS_STATUS_HISTORY . " 
									WHERE orders_id = '" . vam_db_prepare_input($_GET['oID']) . "' 
									ORDER BY date_added");
if (vam_db_num_rows($orders_history_query)) {
  while ($orders_history = vam_db_fetch_array($orders_history_query)) {
          
		$r++;
        $rowClass = ((($r/2) == (floor($r/2))) ? 'dataRowOver' : 'dataRow');
        
	     echo '  <tr class="' . $rowClass . '" id="commentRow' . $orders_history['orders_status_history_id'] . '" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this, \'' . $rowClass . '\')">' . "\n" .
         '	  <td class="smallText" align="center"><div id="do_not_delete"><input name="update_comments[' . $orders_history['orders_status_history_id'] . '][delete]" type="checkbox" onClick="updateCommentsField(\'delete\', \'' . $orders_history['orders_status_history_id'] . '\', this.checked, \'\', this)"></div></td>' . "\n" . 
         '    <td class="smallText" align="center">' . vam_datetime_short($orders_history['date_added']) . '</td>' . "\n" .
         '    <td class="smallText" align="center">';
    if ($orders_history['customer_notified'] == '1') {
      echo vam_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
    } else {
      echo vam_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
    }
    echo '<td class="smallText" align="left">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . "\n";
    echo '<td class="smallText" align="left">' . 
  
  vam_draw_textarea_field("update_comments[" . $orders_history['orders_status_history_id'] . "][comments]", "soft", "40", "5", 
  "" .	vam_db_output($orders_history['comments']) . "", "onChange=\"updateCommentsField('update', '" . $orders_history['orders_status_history_id'] . "', 'false', encodeURIComponent(this.value))\"") . '' . "\n" .
		 
		 '    </td>' . "\n";
 
    echo '  </tr>' . "\n";
  
      }
    } else {
      echo '  <tr>' . "\n" .
       '    <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
       '  </tr>' . "\n";
      }
	
  ?>
  
  </table>
  
  <?php   }  // end if ($action == 'insert_new_comment') { 	 
     
	 //12. insert shipping method when one doesn't already exist
     if ($action == 'insert_shipping') {
	  
	  $order = new manualOrder($_GET['oID']);

      $vamPrice = new vamPrice($order->info['currency'], $order->info['status'],$order->customer['ID']);
	 
	  $Query = "INSERT INTO " . TABLE_ORDERS_TOTAL . " SET
	                orders_id = '" . $_GET['oID'] . "', 
					title = '" . $_GET['title'] . "', 
					text = '" . $_GET['value'] ."',
					value = '" . $_GET['value'] . "',
					class = 'ot_shipping',
					sort_order = '" . $_GET['sort_order'] . "'";
					vam_db_query($Query);
					
	  vam_db_query("UPDATE " . TABLE_ORDERS . " SET shipping_method = '" . $_GET['id'] . "' WHERE orders_id = '" . $_GET['oID'] . "'");
	
      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$_GET['oID'],
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => vam_db_input(vam_db_prepare_input('shipping_method_change')),
                              'value' => vam_db_input(vam_db_prepare_input($_GET['title'] . ' ' . $currencies->format($_GET['value'], true, $order->info['currency'], $order->info['currency_value']))),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform('orders_log', $sql_data_array);
	
	
	    $order = new manualOrder($_GET['oID']);
	    
      $vamPrice = new vamPrice($order->info['currency'], $order->info['status'],$order->customer['ID']);
	    
        $shippingKey = $order->adjust_totals($_GET['oID']);
        $order->adjust_zones();
        
        $cart = new manualCart();
        $cart->restore_contents($_GET['oID']);
        $total_count = $cart->count_contents();
        $total_weight = $cart->show_weight();
		
		// Get the shipping quotes
        $shipping_modules = new shipping;
        $shipping_quotes = $shipping_modules->quote();
  
  ?>
  
		<table width="100%">
		 <tr><td>
			 
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
			  <tr>
                <td valign="top" width="100%">
				 <br>
				   <div>
					<a href="javascript:openWindow('<?php echo vam_href_link(FILENAME_ORDERS_EDIT_ADD_PRODUCT, 'oID=' . $_GET['oID'] . '&cID=' . $_GET['cID'] . '&step=1'); ?>','addProducts');" class="button"><span><?php echo TEXT_ADD_NEW_PRODUCT; ?></span></a><input type="hidden" name="subaction" value="">
					</div>
					<br>
				</td>
               
             
			  <!-- order_totals bof //-->
                <td align="right" rowspan="2" valign="top" nowrap class="dataTableRow" style="border: 1px solid #C9C9C9;">
                <table border="0" cellspacing="0" cellpadding="2">
                  <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" width="15" nowrap onMouseover="ddrivetip('<?php echo oe_html_no_quote(HINT_TOTALS); ?>')"; onMouseout="hideddrivetip()"><img src="images/icon_info.gif" border="0" width="13" height="13" onLoad="reloadTotals()"></td>
                    <td class="dataTableHeadingContent" nowrap><?php echo TABLE_HEADING_OT_TOTALS; ?></td>
                    <td class="dataTableHeadingContent" colspan="2" nowrap><?php echo TABLE_HEADING_OT_VALUES; ?></td>
                  </tr>
<?php
  for ($i=0; $i<sizeof($order->totals); $i++) {
   
    $id = $order->totals[$i]['class'];
	
    if ($order->totals[$i]['class'] == 'ot_shipping') {
	    $shipping_module_id = $order->info['shipping_id'];
	  } else {
	    $shipping_module_id = '';
	  } //end if ($order->totals[$i]['class'] == 'ot_shipping') {
   
    $rowStyle = (($i % 2) ? 'dataTableRowOver' : 'dataTableRow');
    if ( ($order->totals[$i]['class'] == 'ot_total') || ($order->totals[$i]['class'] == 'ot_subtotal') || ($order->totals[$i]['class'] == 'ot_tax') || ($order->totals[$i]['class'] == 'ot_loworderfee') ) {
      echo '                  <tr class="' . $rowStyle . '">' . "\n";
      if ($order->totals[$i]['class'] != 'ot_total') {
        echo '                    <td class="dataTableContent" align="center" valign="middle" height="15"><span id="update_totals['.$i.']"><a href="javascript:setCustomOTVisibility(\'update_totals['.($i+1).']\', \'visible\', \'update_totals['.$i.']\');">' . vam_image('order_editor/images/plus.gif', IMAGE_ADD_NEW_OT) . '</a></span></td>' . "\n";
      } else {
        echo '                    <td class="dataTableContent" valign="middle">&nbsp;</td>' . "\n";
      }
      
      echo '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][title]" value="' . strip_tags(trim($order->totals[$i]['title'])) . '" readonly="readonly"></td>' . "\n";
	  
      if ($order->info['currency'] != DEFAULT_CURRENCY) echo '                    <td class="dataTableContent">&nbsp;</td>' . "\n";
      echo '                    <td align="right" class="dataTableContent" nowrap>' . $order->totals[$i]['text'] . '<input name="update_totals['.$i.'][value]" type="hidden" value="' . number_format($order->totals[$i]['value'], 2, '.', '') . '"><input name="update_totals['.$i.'][class]" type="hidden" value="' . $order->totals[$i]['class'] . '"></td>' . "\n" .
           '                  </tr>' . "\n";
    } else {
      if ($i % 2) {
        echo '                  <tr class="' . $rowStyle . '" id="update_totals['.$i.']" style="visibility: hidden; display: none;">' . "\n" .
             '                    <td class="dataTableContent" align="center" valign="middle" height="15"><a href="javascript:setCustomOTVisibility(\'update_totals['.($i).']\', \'hidden\', \'update_totals['.($i-1).']\');">' . vam_image('order_editor/images/minus.gif', IMAGE_REMOVE_NEW_OT) . '</a></td>' . "\n";
      } else {
        echo '                  <tr class="' . $rowStyle . '">' . "\n" .
             '                    <td class="dataTableContent" valign="middle" height="15"><span id="update_totals['.$i.']"><a href="javascript:setCustomOTVisibility(\'update_totals['.($i+1).']\', \'visible\', \'update_totals['.$i.']\');">' . vam_image('order_editor/images/plus.gif', IMAGE_ADD_NEW_OT) . '</a></span></td>' . "\n";
      }

      echo '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][title]" id="'.$id.'[title]" value="' . strip_tags(trim($order->totals[$i]['title'])) . '"  onChange="obtainTotals()"></td>' . "\n" .
           '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][value]" id="'.$id.'[value]" value="' . number_format($order->totals[$i]['value'], 2, '.', '') . '" size="6"  onChange="obtainTotals()"><input name="update_totals['.$i.'][class]" type="hidden" value="' . $order->totals[$i]['class'] . '"><input name="update_totals['.$i.'][id]" type="hidden" value="' . $shipping_module_id . '" id="' . $id . '[id]"></td>' . "\n";
      if ($order->info['currency'] != DEFAULT_CURRENCY) echo '                    <td align="right" class="dataTableContent" nowrap>' . $order->totals[$i]['text'] . '</td>' . "\n";
      echo '                  </tr>' . "\n";
    }
  }
?>
                </table></td>
                <!-- order_totals_eof //-->
              </tr>              
              <tr>
                <td valign="bottom">
                
<?php 
  if (sizeof($shipping_quotes) > 0) {
?>
                <!-- shipping_quote bof //-->
                <table border="0" width="550" cellspacing="0" cellpadding="2" style="border: 1px solid #C9C9C9;">
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent" colspan="3"><?php echo TABLE_HEADING_SHIPPING_QUOTES; ?></td>
                  </tr>
<?php
    $r = 0;
    for ($i=0, $n=sizeof($shipping_quotes); $i<$n; $i++) {
      for ($j=0, $n2=sizeof($shipping_quotes[$i]['methods']); $j<$n2; $j++) {
        $r++;
        if (!isset($shipping_quotes[$i]['tax'])) $shipping_quotes[$i]['tax'] = 0;
        $rowClass = ((($r/2) == (floor($r/2))) ? 'dataTableRowOver' : 'dataTableRow'); 
        echo '                  <tr class="' . $rowClass . '" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this, \'' . $rowClass . '\')" onclick="selectRowEffect(this, ' . $r . '); setShipping(' . $r . ');">' . "\n" .
                 
    '   <td class="dataTableContent" valign="top" align="left" width="15px">' . "\n" .
	
	'   <input type="radio" name="shipping" id="shipping_radio_' . $r . '" value="' . $shipping_quotes[$i]['id'] . '_' . $shipping_quotes[$i]['methods'][$j]['id'].'">' . "\n" .
			 
	'   <input type="hidden" id="update_shipping['.$r.'][title]" name="update_shipping['.$r.'][title]" value="'.$shipping_quotes[$i]['module'] . ' (' . $shipping_quotes[$i]['methods'][$j]['title'].'):">' . "\n" .
			
    '   <input type="hidden" id="update_shipping['.$r.'][value]" name="update_shipping['.$r.'][value]" value="'.$currencies->format(vam_add_tax($shipping_quotes[$i]['methods'][$j]['cost'], $shipping_quotes[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']).'">' . "\n" .
	
	'      <input type="hidden" id="update_shipping[' . $r . '][id]" name="update_shipping[' . $r . '][id]" value="' . $shipping_quotes[$i]['id'] . '_' . $shipping_quotes[$i]['methods'][$j]['id'] . '">' . "\n" .

			 '<td class="dataTableContent" valign="top">' . $shipping_quotes[$i]['module'] . ' (' . $shipping_quotes[$i]['methods'][$j]['title'] . '):</td>' . "\n" . 

			 '<td class="dataTableContent" align="right">' . vam_add_tax($shipping_quotes[$i]['methods'][$j]['cost'], $shipping_quotes[$i]['tax']) . '</td>' . "\n" . 
             '                  </tr>';
      }
    }
?>
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent" colspan="3"><?php echo sprintf(TEXT_PACKAGE_WEIGHT_COUNT, $shipping_num_boxes . ' x ' . $shipping_weight, $total_count); ?></td>
                  </tr>
                </table>
                <!-- shipping_quote_eof //-->
  
  <?php
     } else {
     echo AJAX_NO_QUOTES;
     }
   ?>
                </td>
              </tr> 
            </table>
			
		  
		  </td></tr>
		</table>
	 
   <?php	 } //end if ($action == 'insert_shipping') {  

  //13. new order email 
   
    if ($action == 'new_order_email')  {
	
		$order = new manualOrder($_GET['oID']);
		
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
		   
		   $oID = $_GET['oID'];
		   
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
    
  ?>
	
	<table>
	  <tr>
	    <td class="messageStackSuccess">
		  <?php echo vam_image(DIR_WS_ICONS . 'success.gif', ICON_SUCCESS) . '&nbsp;' . sprintf(AJAX_SUCCESS_EMAIL_SENT, $order->customer['email_address']); ?>
		</td>
	  </tr>
	</table>
	
	<?php } //end if ($action == 'new_order_email')  {  ?>
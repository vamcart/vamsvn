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
  
  // output a response header
  header('Content-type: text/html; charset=' . CHARSET . '');

  // include the appropriate functions & classes
  include('order_editor/functions.php');
  include('order_editor/cart.php');
  include('order_editor/order.php');
  include('order_editor/shipping.php');
  include('order_editor/http_client.php');
  include(DIR_WS_LANGUAGES . $language. '/' . FILENAME_ORDERS_EDIT);

   
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
		
	  vam_db_query("UPDATE " . TABLE_ORDERS_PRODUCTS . " SET " . $_GET['field'] . " = '" . vam_db_input(vam_db_prepare_input($_GET['new_value'])) . "' WHERE orders_products_id = '" . $_GET['pid'] . "' AND orders_id = '" . $_GET['oID'] . "'");
	
	
	
	  //generate responseText
	  echo $_GET['field'];

  }
  
  //2.  Update the orders_products table for qty, tax, name, or model
if ($action == 'update_product_field') {
	  vam_db_query("UPDATE " . TABLE_ORDERS_PRODUCTS . " SET " . $_GET['field'] . " = '" . vam_db_input(vam_db_prepare_input($_GET['new_value'])) . "' WHERE orders_products_id = '" . $_GET['pid'] . "' AND orders_id = '" . $_GET['oID'] . "'");
	
	  //generate responseText
	  echo $_GET['field'];

  }
  
  //3.  Update the orders_products table for price and final_price (interdependent values)
if ($action == 'update_product_value_field') {
	  vam_db_query("UPDATE " . TABLE_ORDERS_PRODUCTS . " SET products_price = '" . vam_db_input(vam_db_prepare_input($_GET['price'])) . "', final_price = '" . vam_db_input(vam_db_prepare_input($_GET['final_price'])) . "' WHERE orders_products_id = '" . $_GET['pid'] . "' AND orders_id = '" . $_GET['oID'] . "'");
	  
	  //generate responseText
	  echo TABLE_ORDERS_PRODUCTS;

  }
  
    //4.  Update the orders_products_attributes table 
if ($action == 'update_attributes_field') {
	  
	  vam_db_query("UPDATE " . TABLE_ORDERS_PRODUCTS_ATTRIBUTES . " SET " . $_GET['field'] . " = '" . vam_db_input(vam_db_prepare_input($_GET['new_value'])) . "' WHERE orders_products_attributes_id = '" . $_GET['aid'] . "' AND orders_products_id = '" . $_GET['pid'] . "' AND orders_id = '" . $_GET['oID'] . "'");
	  
	  if (isset($_GET['final_price'])) {
	    
		vam_db_query("UPDATE " . TABLE_ORDERS_PRODUCTS . " SET final_price = '" . vam_db_input(vam_db_prepare_input($_GET['final_price'])) . "' WHERE orders_products_id = '" . $_GET['pid'] . "' AND orders_id = '" . $_GET['oID'] . "'");
	  
	  }
	  
	  //generate responseText
	  echo $_GET['field'];

  }
  
    //5.  Update the orders_products_download table 
if ($action == 'update_downloads') {
	  vam_db_query("UPDATE " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " SET " . $_GET['field'] . " = '" . vam_db_input(vam_db_prepare_input($_GET['new_value'])) . "' WHERE orders_products_download_id = '" . $_GET['did'] . "' AND orders_products_id = '" . $_GET['pid'] . "' AND orders_id = '" . $_GET['oID'] . "'");
	  
	 //generate responseText
	  echo $_GET['field'];

  }
  
  //6. Update the currency of the order
  if ($action == 'update_currency') {
  	  vam_db_query("UPDATE " . TABLE_ORDERS . " SET currency = '" . vam_db_input(vam_db_prepare_input($_GET['currency'])) . "', currency_value = '" . vam_db_input(vam_db_prepare_input($_GET['currency_value'])) . "' WHERE orders_id = '" . $_GET['oID'] . "'");
  
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
								  
      //generate responseText
	  echo TABLE_ORDERS_PRODUCTS;

  }

  
  //8. Update the orders_status_history table
  if ($action == 'delete_comment') {
      
	  vam_db_query("DELETE FROM " . TABLE_ORDERS_STATUS_HISTORY . " WHERE orders_status_history_id = '" . $_GET['cID'] . "' AND orders_id = '" . $_GET['oID'] . "'");
	  
	  //generate responseText
	  echo TABLE_ORDERS_STATUS_HISTORY;
	  
	  }
	  

  //9. Update the orders_status_history table
  if ($action == 'update_comment') {
      
	  vam_db_query("UPDATE " . TABLE_ORDERS_STATUS_HISTORY . " SET comments = '" . vam_db_input(vam_db_prepare_input($_GET['comment'])) . "' WHERE orders_status_history_id = '" . $_GET['cID'] . "' AND orders_id = '" . $_GET['oID'] . "'");
	  
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

           } // end if ($ot_class == "ot_shipping")
         } //end foreach
	   } //end if is_array
	
	  if (vam_not_null($shipping['id'])) {
    vam_db_query("UPDATE " . TABLE_ORDERS . " SET shipping_module = '" . $shipping['id'] . "' WHERE orders_id = '" . $_POST['oID'] . "'");
	   }
	   
		$order = new manualOrder($oID);
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
		  $current_ot_titles_array[] = $current_ot_totals['title'];
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
                  $new_order_totals[] = array('title' => $ot_title,
                                              'text' => (($ot_class != 'ot_total') ? $order_totals[$i]['text'] : '<b>' . $currencies->format($order->info['total'], true, $order->info['currency'], $order->info['currency_value']) . '</b>'),
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
			   
                $new_order_totals[] = array('title' => $order_totals[$i]['title'],
                                            'text' => $order_totals[$i]['text'],
                                            'value' => $order_totals[$i]['value'],
                                            'code' => $order_totals[$i]['code'],
                                            'sort_order' => $j);
                $current_ot_totals_array[] = $order_totals[$i]['code'];
				$current_ot_titles_array[] = $order_totals[$i]['title'];
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
            $new_order_totals[] = array('title' => $ot_title,
                     'text' => $currencies->format($ot_value, true, $order->info['currency'], $order->info['currency_value']),
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
					        'title' => $ot_title,
                            'text' => $currencies->format($ot_value, true, $order->info['currency'], $order->info['currency_value']),
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
	                  $new_order_totals[] = array('title' => $order_totals[$i]['title'],
                                            'text' => $order_totals[$i]['text'],
                                            'value' => $order_totals[$i]['value'],
                                            'code' => $order_totals[$i]['code'],
                                            'sort_order' => $j);
                $j++;
				
			} //end 8
				
		} //end if (is_array($_POST['update_totals'])) { //1
	  
				 
        for ($i=0, $n=sizeof($new_order_totals); $i<$n; $i++) {
          $sql_data_array = array('orders_id' => $oID,
                                  'title' => $new_order_totals[$i]['title'],
                                  'text' => $new_order_totals[$i]['text'],
                                  'value' => $new_order_totals[$i]['value'], 
                                  'class' => $new_order_totals[$i]['code'], 
                                  'sort_order' => $new_order_totals[$i]['sort_order']);
          vam_db_perform(TABLE_ORDERS_TOTAL, $sql_data_array);
        }


        $order = new manualOrder($oID);
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
                <td valign="top" width="100%">
				 <br>
				   <div>
					<a href="javascript:openWindow('<?php echo vam_href_link(FILENAME_ORDERS_EDIT_ADD_PRODUCT, 'oID=' . $_POST['oID'] . '&cID=' . $_GET['cID'] . '&step=1'); ?>','addProducts');"><?php echo vam_image_button('button_new_product.gif', TEXT_ADD_NEW_PRODUCT); ?></a><input type="hidden" name="subaction" value="">
					</div>
					<br>
				</td>
               
             
			  <!-- order_totals bof //-->
                <td align="right" rowspan="2" valign="top" nowrap class="dataTableRow" style="border: 1px solid #C9C9C9;">
                <table border="0" cellspacing="0" cellpadding="2">
                  <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" width="15" nowrap onMouseover="ddrivetip('<?php echo oe_html_no_quote(HINT_TOTALS); ?>')"; onMouseout="hideddrivetip()"><img src="images/icon_info.gif" border="0" width="13" height="13"></td>
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
        echo '                    <td class="dataTableContent" valign="middle" height="15"><span id="update_totals['.$i.']"><a href="javascript:setCustomOTVisibility(\'update_totals['.($i+1).']\', \'visible\', \'update_totals['.$i.']\');">' . vam_image('order_editor/images/plus.gif', IMAGE_ADD_NEW_OT) . '</a></span></td>' . "\n";
      } else {
        echo '                    <td class="dataTableContent" valign="middle">&nbsp;</td>' . "\n";
      }
      
      echo '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][title]" value="' . trim($order->totals[$i]['title']) . '" readonly="readonly"></td>' . "\n";
	  
      if ($order->info['currency'] != DEFAULT_CURRENCY) echo '                    <td class="dataTableContent">&nbsp;</td>' . "\n";
      echo '                    <td align="right" class="dataTableContent" nowrap>' . $order->totals[$i]['text'] . '<input name="update_totals['.$i.'][value]" type="hidden" value="' . number_format($order->totals[$i]['value'], 2, '.', '') . '"><input name="update_totals['.$i.'][class]" type="hidden" value="' . $order->totals[$i]['class'] . '"></td>' . "\n" .
           '                  </tr>' . "\n";
    } else {
      if ($i % 2) {
        echo '                  <tr class="' . $rowStyle . '" id="update_totals['.$i.']" style="visibility: hidden; display: none;">' . "\n" .
             '                    <td class="dataTableContent" valign="middle" height="15"><a href="javascript:setCustomOTVisibility(\'update_totals['.($i).']\', \'hidden\', \'update_totals['.($i-1).']\');">' . vam_image('order_editor/images/minus.gif', IMAGE_REMOVE_NEW_OT) . '</a></td>' . "\n";
      } else {
        echo '                  <tr class="' . $rowStyle . '">' . "\n" .
             '                    <td class="dataTableContent" valign="middle" height="15"><span id="update_totals['.$i.']"><a href="javascript:setCustomOTVisibility(\'update_totals['.($i+1).']\', \'visible\', \'update_totals['.$i.']\');">' . vam_image('order_editor/images/plus.gif', IMAGE_ADD_NEW_OT) . '</a></span></td>' . "\n";
      }

      echo '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][title]" id="'.$id.'[title]" value="' . trim($order->totals[$i]['title']) . '"  onChange="obtainTotals()"></td>' . "\n" .
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
                <table border="0" width="450" cellspacing="0" cellpadding="2" style="border: 1px solid #C9C9C9;">
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
             
    '      <td class="dataTableContent" valign="top" align="left" width="15px">' . "\n" .
	
	'      <input type="radio" name="shipping" id="shipping_radio_' . $r . '" value="' . $shipping_quotes[$i]['id'] . '_' . $shipping_quotes[$i]['methods'][$j]['id'].'">' . "\n" .
			 
	'      <input type="hidden" id="update_shipping['.$r.'][title]" name="update_shipping['.$r.'][title]" value="'.$shipping_quotes[$i]['module'] . ' (' . $shipping_quotes[$i]['methods'][$j]['title'].'):">' . "\n" .
			
    '      <input type="hidden" id="update_shipping['.$r.'][value]" name="update_shipping['.$r.'][value]" value="'.vam_add_tax($shipping_quotes[$i]['methods'][$j]['cost'], $shipping_quotes[$i]['tax']).'">' . "\n" .
	
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
	   
  
<?php } //end if ($action == 'reload_shipping') {  

	
	//11. insert new comments
	 if ($action == 'insert_new_comment') {  
	 
	 	//orders status
         $orders_statuses = array();
         $orders_status_array = array();
         $orders_status_query = vam_db_query("SELECT orders_status_id, orders_status_name 
                                              FROM " . TABLE_ORDERS_STATUS . " 
									          WHERE language_id = '" . (int)$languages_id . "'");
									   
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
			    $notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $_GET['comments']) . "\n\n";
			  }
			  $email = STORE_NAME . "\n" .
			           EMAIL_SEPARATOR . "\n" . 
					   EMAIL_TEXT_ORDER_NUMBER . ' ' . $_GET['oID'] . "\n" . 
	EMAIL_TEXT_INVOICE_URL . ' ' . vam_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $_GET['oID'], 'SSL') . "\n" . 
					   EMAIL_TEXT_DATE_ORDERED . ' ' . vam_date_long($check_status['date_purchased']) . "\n\n" . 
					   sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$_GET['status']]) . $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE2);
			  
			  vam_mail($check_status['customers_name'], $check_status['customers_email_address'], EMAIL_TEXT_SUBJECT, $email, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
			  
			  $customer_notified = '1';
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
  <table style="border: 1px solid #C9C9C9;" cellspacing="0" cellpadding="2" class="dataTableRow" id="commentsTable">
  <tr class="dataTableHeadingRow">
    <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_DELETE; ?></td>
    <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>
    <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_DATE_ADDED; ?></td>
    <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>
    <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></td>
    <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>
    <td class="dataTableHeadingContent" align="left"><?php echo TABLE_HEADING_STATUS; ?></td>
   <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>
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
        $rowClass = ((($r/2) == (floor($r/2))) ? 'dataTableRowOver' : 'dataTableRow');
        
	     echo '  <tr class="' . $rowClass . '" id="commentRow' . $orders_history['orders_status_history_id'] . '" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this, \'' . $rowClass . '\')">' . "\n" .
         '	  <td class="smallText" align="center"><div id="do_not_delete"><input name="update_comments[' . $orders_history['orders_status_history_id'] . '][delete]" type="checkbox" onClick="updateCommentsField(\'delete\', \'' . $orders_history['orders_status_history_id'] . '\', this.checked, \'\', this)"></div></td>' . "\n" . 
		 '    <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>' . "\n" .
         '    <td class="smallText" align="center">' . vam_datetime_short($orders_history['date_added']) . '</td>' . "\n" .
         '    <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>' . "\n" .
         '    <td class="smallText" align="center">';
    if ($orders_history['customer_notified'] == '1') {
      echo vam_image(DIR_WS_ICONS . 'tick.gif', ICON_TICK) . "</td>\n";
    } else {
      echo vam_image(DIR_WS_ICONS . 'cross.gif', ICON_CROSS) . "</td>\n";
    }
    echo '    <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>' . "\n" .
         '    <td class="smallText" align="left">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . "\n";
    echo '    <td class="dataTableHeadingContent" align="left" width="10">&nbsp;</td>' . "\n" .
         '    <td class="smallText" align="left">' . 
  
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
	 
	  $Query = "INSERT INTO " . TABLE_ORDERS_TOTAL . " SET
	                orders_id = '" . $_GET['oID'] . "', 
					title = '" . $_GET['title'] . "', 
					text = '" . $currencies->format($_GET['value'], true, $order->info['currency'], $order->info['currency_value']) ."',
					value = '" . $_GET['value'] . "',
					class = 'ot_shipping',
					sort_order = '" . $_GET['sort_order'] . "'";
					vam_db_query($Query);
					
	  vam_db_query("UPDATE " . TABLE_ORDERS . " SET shipping_module = '" . $_GET['id'] . "' WHERE orders_id = '" . $_GET['oID'] . "'");
	
	    $order = new manualOrder($_GET['oID']);
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
					<a href="javascript:openWindow('<?php echo vam_href_link(FILENAME_ORDERS_EDIT_ADD_PRODUCT, 'oID=' . $_GET['oID'] . '&cID=' . $_GET['cID'] . '&step=1'); ?>','addProducts');"><?php echo vam_image_button('button_new_product.gif', TEXT_ADD_NEW_PRODUCT); ?></a><input type="hidden" name="subaction" value="">
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
        echo '                    <td class="dataTableContent" valign="middle" height="15"><span id="update_totals['.$i.']"><a href="javascript:setCustomOTVisibility(\'update_totals['.($i+1).']\', \'visible\', \'update_totals['.$i.']\');">' . vam_image('order_editor/images/plus.gif', IMAGE_ADD_NEW_OT) . '</a></span></td>' . "\n";
      } else {
        echo '                    <td class="dataTableContent" valign="middle">&nbsp;</td>' . "\n";
      }
      
      echo '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][title]" value="' . trim($order->totals[$i]['title']) . '" readonly="readonly"></td>' . "\n";
	  
      if ($order->info['currency'] != DEFAULT_CURRENCY) echo '                    <td class="dataTableContent">&nbsp;</td>' . "\n";
      echo '                    <td align="right" class="dataTableContent" nowrap>' . $order->totals[$i]['text'] . '<input name="update_totals['.$i.'][value]" type="hidden" value="' . number_format($order->totals[$i]['value'], 2, '.', '') . '"><input name="update_totals['.$i.'][class]" type="hidden" value="' . $order->totals[$i]['class'] . '"></td>' . "\n" .
           '                  </tr>' . "\n";
    } else {
      if ($i % 2) {
        echo '                  <tr class="' . $rowStyle . '" id="update_totals['.$i.']" style="visibility: hidden; display: none;">' . "\n" .
             '                    <td class="dataTableContent" valign="middle" height="15"><a href="javascript:setCustomOTVisibility(\'update_totals['.($i).']\', \'hidden\', \'update_totals['.($i-1).']\');">' . vam_image('order_editor/images/minus.gif', IMAGE_REMOVE_NEW_OT) . '</a></td>' . "\n";
      } else {
        echo '                  <tr class="' . $rowStyle . '">' . "\n" .
             '                    <td class="dataTableContent" valign="middle" height="15"><span id="update_totals['.$i.']"><a href="javascript:setCustomOTVisibility(\'update_totals['.($i+1).']\', \'visible\', \'update_totals['.$i.']\');">' . vam_image('order_editor/images/plus.gif', IMAGE_ADD_NEW_OT) . '</a></span></td>' . "\n";
      }

      echo '                    <td align="right" class="dataTableContent"><input name="update_totals['.$i.'][title]" id="'.$id.'[title]" value="' . trim($order->totals[$i]['title']) . '"  onChange="obtainTotals()"></td>' . "\n" .
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
			
    '   <input type="hidden" id="update_shipping['.$r.'][value]" name="update_shipping['.$r.'][value]" value="'.vam_add_tax($shipping_quotes[$i]['methods'][$j]['cost'], $shipping_quotes[$i]['tax']).'">' . "\n" .
	
	'      <input type="hidden" id="update_shipping[' . $r . '][id]" name="update_shipping[' . $r . '][id]" value="' . $shipping_quotes[$i]['id'] . '_' . $shipping_quotes[$i]['methods'][$j]['id'] . '">' . "\n" .

			 '<td class="dataTableContent" valign="top">' . $shipping_quotes[$i]['module'] . ' (' . $shipping_quotes[$i]['methods'][$j]['title'] . '):</td>' . "\n" . 

			 '<td class="dataTableContent" align="right">' . $currencies->format(vam_add_tax($shipping_quotes[$i]['methods'][$j]['cost'], $shipping_quotes[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) . '</td>' . "\n" . 
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
		
		    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
	  //loop all the products in the order
			 $products_ordered_attributes = '';
	  if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
	    for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
		$products_ordered_attributes .= "\n\t" . $order->products[$i]['attributes'][$j]['option'] . ' ' . $order->products[$i]['attributes'][$j]['value'];
      }
    }
	
	   $products_ordered .= $order->products[$i]['qty'] . ' x ' . $order->products[$i]['name'] . $products_model . ' = ' . $currencies->format(vam_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . $products_ordered_attributes . "\n";
			 }
		   
		//Build the email
	   	 $email_order = STORE_NAME . "\n" . 
                        EMAIL_SEPARATOR . "\n" . 
						EMAIL_TEXT_ORDER_NUMBER . ' ' . (int)$_GET['oID'] . "\n" .
                        EMAIL_TEXT_INVOICE_URL . ' ' . vam_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . (int)$_GET['oID'], 'SSL') . "\n" .
                	    EMAIL_TEXT_DATE_MODIFIED . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n";

	    $email_order .= EMAIL_TEXT_PRODUCTS . "\n" . 
    	                EMAIL_SEPARATOR . "\n" . 
        	            $products_ordered . 
            	        EMAIL_SEPARATOR . "\n";

	  for ($i=0, $n=sizeof($order->totals); $i<$n; $i++) {
        $email_order .= strip_tags($order->totals[$i]['title']) . ' ' . strip_tags($order->totals[$i]['text']) . "\n";
      }

	  if ($order->content_type != 'virtual') {
    	$email_order .= "\n" . EMAIL_TEXT_DELIVERY_ADDRESS . "\n" . 
        	            EMAIL_SEPARATOR . "\n" .
						$order->delivery['name'] . "\n";
						if ($order->delivery['company']) {
		                  $email_order .= $order->delivery['company'] . "\n";
	                    }
		$email_order .= $order->delivery['street_address'] . "\n";
		                if ($order->delivery['suburb']) {
		                  $email_order .= $order->delivery['suburb'] . "\n";
	                    }
		$email_order .= $order->customer['city'] . "\n";
		                if ($order->delivery['state']) {
		                  $email_order .= $order->delivery['state'] . "\n";
	                    }
		$email_order .= $order->customer['postcode'] . "\n" .
						$order->delivery['country'] . "\n";
	  }

    	$email_order .= "\n" . EMAIL_TEXT_BILLING_ADDRESS . "\n" .
        	            EMAIL_SEPARATOR . "\n" .
						$order->billing['name'] . "\n";
						if ($order->billing['company']) {
		                  $email_order .= $order->billing['company'] . "\n";
	                    }
		$email_order .= $order->billing['street_address'] . "\n";
		                if ($order->billing['suburb']) {
		                  $email_order .= $order->billing['suburb'] . "\n";
	                    }
		$email_order .= $order->customer['city'] . "\n";
		                if ($order->billing['state']) {
		                  $email_order .= $order->billing['state'] . "\n";
	                    }
		$email_order .= $order->customer['postcode'] . "\n" .
						$order->billing['country'] . "\n\n";

	    $email_order .= EMAIL_TEXT_PAYMENT_METHOD . "\n" . 
    	                EMAIL_SEPARATOR . "\n";
	    $email_order .= $order->info['payment_method'] . "\n\n";
		
		        
			//	if ( ($order->info['payment_method'] == ORDER_EDITOR_SEND_INFO_PAYMENT_METHOD) && (EMAIL_TEXT_PAYMENT_INFO) ) { 
		      //     $email_order .= EMAIL_TEXT_PAYMENT_INFO . "\n\n";
		       //   }
			 //I'm not entirely sure what the purpose of this is so it is being shelved for now

				if (EMAIL_TEXT_FOOTER) {
					$email_order .= EMAIL_TEXT_FOOTER . "\n\n";
				  }
      
	  //code for plain text emails which changes the ВЂ sign to EUR, otherwise the email will show ? instead of ВЂ
      $email_order = str_replace("ВЂ","EUR",$email_order);
	  $email_order = str_replace("&nbsp;"," ",$email_order);

	  //code which replaces the <br> tags within EMAIL_TEXT_PAYMENT_INFO and EMAIL_TEXT_FOOTER with the proper \n
	  $email_order = str_replace("<br>","\n",$email_order);

	  //send the email to the customer
	  vam_mail($order->customer['name'], $order->customer['email_address'], EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

   // send emails to other people as necessary
  if (SEND_EXTRA_ORDER_EMAILS_TO != '') {
    vam_mail('', SEND_EXTRA_ORDER_EMAILS_TO, EMAIL_TEXT_SUBJECT, $email_order, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
  }
  
  ?>
	
	<table>
	  <tr>
	    <td class="messageStackSuccess">
		  <?php echo vam_image(DIR_WS_ICONS . 'success.gif', ICON_SUCCESS) . '&nbsp;' . sprintf(AJAX_SUCCESS_EMAIL_SENT, $order->customer['email_address']); ?>
		</td>
	  </tr>
	</table>
	
	<?php } //end if ($action == 'new_order_email')  {  ?>
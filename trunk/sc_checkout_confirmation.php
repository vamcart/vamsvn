<?php
/* -----------------------------------------------------------------------------------------
   $Id: sc_checkout_confirmation.php 867 2012-11-11 19:20:03 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2012 VamShop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(address_book.php,v 1.57 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (address_book.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (address_book.php,v 1.14 2003/08/17); xt-commerce.com
   (c) 2012	 STRUB

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

/*session description
vam_session_is_registered('create_account') = is used for data processing only
vam_session_is_registered('only_account') = is used to hide shipping and payment data and show only account data
vam_session_is_registered('is_virtual_product') = 

 
vam_session_is_registered('no_pay_no_ship') = is used to hide all data (shipping, payment, account)
*/



  require('includes/application_top.php');

$hide_shipping_data = false;
$hide_payment_data = false;
$show_account_data = false; //account data will only be shown if in checkout.php the account heading is shown. This happens by free virtual products
$sc_payment_url = false; //used for redirection for url payment modules

if (vam_session_is_registered('hide_shipping_data')) {
	$hide_shipping_data = true; //used to hide shipping data
}

if (vam_session_is_registered('hide_payment_data')) {
	$hide_payment_data = true; //used to hide payment data
}

if (vam_session_is_registered('show_account_data')) {
	$show_account_data = true; //used to show account data
	$hide_shipping_data = true;
	$hide_payment_data = true;
}


// if the customer is not logged on, redirect them to the login page
  if ((!vam_session_is_registered('customer_id')) && (!vam_session_is_registered('noaccount'))) {
    $navigation->set_snapshot(array('mode' => 'SSL', 'page' => FILENAME_CHECKOUT_PAYMENT));
    vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));
  }

// if there is nothing in the customers cart, redirect them to the shopping cart page
  if ($cart->count_contents() < 1) {
    vam_redirect(vam_href_link(FILENAME_SHOPPING_CART));
  }

// avoid hack attempts during the checkout procedure by checking the internal cartID
  if (isset($cart->cartID) && vam_session_is_registered('cartID')) {
    if ($cart->cartID != $cartID) {
      vam_redirect(vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
    }
  }




############################# Validate start - NOT LOGGED ON #######################################

$process = false;
if ((vam_session_is_registered('create_account')) && (isset($_POST['action']) && ($_POST['action'] == 'process'))) {
    $process = true;
		
	$error = false;
}




if ($error == true) {
	//for testing
}





// if no shipping method has been selected, redirect the customer to the shipping method selection page
  if (!vam_session_is_registered('shipping')) {
    vam_redirect(vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  }

  if (!vam_session_is_registered('payment')) vam_session_register('payment');
  if (isset($_POST['payment'])) $payment = $_POST['payment'];

  if (!vam_session_is_registered('comments')) vam_session_register('comments');
  if (vam_not_null($_POST['comments'])) {
    $comments = vam_db_prepare_input($_POST['comments']);
  }

// load the selected payment module
  require(DIR_WS_CLASSES . 'payment.php');
  $payment_modules = new payment($payment);



  require(DIR_WS_CLASSES . 'order.php');
  $order = new order;

  $payment_modules->update_status();

if (!vam_session_is_registered('free_payment')) { //hack for free payment
  if ( ($payment_modules->selected_module != $payment) || ( is_array($payment_modules->modules) && (sizeof($payment_modules->modules) > 1) && !is_object($$payment) ) || (is_object($$payment) && ($$payment->enabled == false)) ) {
    vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message=' . urlencode(ERROR_NO_PAYMENT_MODULE_SELECTED), 'SSL'));
  }
}

  if (is_array($payment_modules->modules)) {
    $payment_modules->pre_confirmation_check();
  }

// load the selected shipping module
  require(DIR_WS_CLASSES . 'shipping.php');
  $shipping_modules = new shipping($shipping);

  require(DIR_WS_CLASSES . 'order_total.php');
  $order_total_modules = new order_total;
  $order_total_modules->process();

// Stock Check
  $any_out_of_stock = false;
  if (STOCK_CHECK == 'true') {
    for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
      if (vam_check_stock($order->products[$i]['id'], $order->products[$i]['qty'])) {
        $any_out_of_stock = true;
      }
    }
    // Out of Stock
    if ( (STOCK_ALLOW_CHECKOUT != 'true') && ($any_out_of_stock == true) ) {
      vam_redirect(vam_href_link(FILENAME_SHOPPING_CART));
    }
  }


///////////// START create account //////////////////////////////////////////////////
//if no errors
if ((vam_session_is_registered('create_account')) && (isset($_POST['action']) && ($_POST['action'] == 'process'))) {
    if ($error == false) {

      $sql_data_array = array('customers_firstname' => $_SESSION['sc_customers_firstname'],
                              'customers_lastname' => $_SESSION['sc_customers_lastname'],
                              'customers_email_address' => $_SESSION['sc_customers_email_address'],
                              'customers_telephone' => $_SESSION['sc_customers_telephone'], 
                              'customers_fax' => $_SESSION['sc_customers_fax'],
                              'customers_newsletter' => $_SESSION['sc_customers_newsletter'], 
                              'customers_password' => $_SESSION['sc_customers_password']);

      if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $_SESSION['sc_customers_gender'];
      if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = vam_date_raw($_SESSION['sc_customers_dob']);

      vam_db_perform(TABLE_CUSTOMERS, $sql_data_array);

      $customer_id = vam_db_insert_id();

      $sql_data_array = array('customers_id' => $customer_id,
                              'entry_firstname' => $_SESSION['sc_customers_firstname'], 
                              'entry_lastname' => $_SESSION['sc_customers_lastname'], 
                              'entry_street_address' => $_SESSION['sc_customers_street_address'], 
                              'entry_postcode' => $_SESSION['sc_customers_postcode'], 
                              'entry_city' => $_SESSION['sc_customers_city'],
                              'entry_country_id' => $_SESSION['sc_customers_country']);

      if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $_SESSION['sc_customers_gender'];
      if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $_SESSION['sc_customers_company']; 
      if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $_SESSION['sc_customers_suburb']; 
      if (ACCOUNT_STATE == 'true') {
        if ($zone_id > 0) {
          $sql_data_array['entry_zone_id'] = $_SESSION['sc_customers_zone_id']; 
          $sql_data_array['entry_state'] = '';
        } else {
          $sql_data_array['entry_zone_id'] = '0';
          $sql_data_array['entry_state'] = $_SESSION['sc_customers_state']; 
        }
      }
	  

      vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

      $address_id = vam_db_insert_id();

      vam_db_query("update " . TABLE_CUSTOMERS . " set customers_default_address_id = '" . (int)$address_id . "' where customers_id = '" . (int)$customer_id . "'");

      vam_db_query("insert into " . TABLE_CUSTOMERS_INFO . " (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('" . (int)$customer_id . "', '0', now())");
	  
	  
	  //billto START
	  if ($_SESSION['sc_payment_address_selected'] != '1') { //is unchecked - so payment address is different or if virtual product
        $sql_data_array = array('customers_id' => $customer_id,
                                'entry_firstname' => $_SESSION['sc_payment_firstname'],
                                'entry_lastname' => $_SESSION['sc_payment_lastname'],
                                'entry_street_address' => $_SESSION['sc_payment_street_address'],
                                'entry_postcode' => $_SESSION['sc_payment_postcode'],
                                'entry_city' => $_SESSION['sc_payment_city'],
                                'entry_country_id' => $_SESSION['sc_payment_country']);

        if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $_SESSION['sc_payment_gender'];
        if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $_SESSION['sc_payment_company'];
        if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $_SESSION['sc_payment_suburb'];
        if (ACCOUNT_STATE == 'true') {
          if ($zone_id > 0) {
            $sql_data_array['entry_zone_id'] = $_SESSION['sc_payment_zone_id'];
            $sql_data_array['entry_state'] = '';
          } else {
            $sql_data_array['entry_zone_id'] = '0';
            $sql_data_array['entry_state'] = $_SESSION['sc_payment_state'];
          }
        }

        if (!vam_session_is_registered('billto')) vam_session_register('billto');

        vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

        $billto_payment = vam_db_insert_id();
      }
	  //billto END
	  
	  //register sessions
	  vam_session_register('customer_id');  
	  if (vam_session_is_registered('noaccount')) {vam_session_unregister('noaccount');} 
	  
	  //assign new default address and billing address
	  $customer_default_address_id = $address_id;
	  if ($_SESSION['sc_payment_address_selected'] == '1') { //is selected - payment address is same as shipping address
	  $billto = $customer_default_address_id; 
	  } else { //not selected - so a new address is being created
		  $billto = $billto_payment; 
	  }

	  
	  //do we need this???
	  //vam_session_register('sc_processed');
      vam_session_register('customer_first_name');
      vam_session_register('customer_default_address_id');
      vam_session_register('customer_country_id');
      vam_session_register('customer_zone_id');


	//START send create account mail
	//data needed: gender, firstname, lastname, email
		
	if (vam_session_is_registered('create_account')) {
		//load language file for email
	
		$name = $_SESSION['sc_customers_firstname'] . ' ' . $_SESSION['sc_customers_lastname'];
			
		if (ACCOUNT_GENDER == 'true') {
			 if ($gender == 'm') {
				 $email_text = sprintf(EMAIL_GREET_MR, $_SESSION['sc_customers_lastname']);
			} else {
				$email_text = sprintf(EMAIL_GREET_MS, $_SESSION['sc_customers_lastname']);
			}
		} else {
			$email_text = sprintf(EMAIL_GREET_NONE, $_SESSION['sc_customers_firstname']);
		}
		
		if (SC_EMAIL_LOGIN_DATA == 'true') {
				  $email_text .= EMAIL_WELCOME . EMAIL_USERNAME . EMAIL_PASSWORD . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_WARNING;
		} else {
			  $email_text .= EMAIL_WELCOME . EMAIL_TEXT . EMAIL_CONTACT . EMAIL_WARNING;
		}
			  	
		vam_mail($name, $_SESSION['sc_customers_email_address'], EMAIL_SUBJECT, $email_text, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
			
	} 
	vam_session_unregister('create_account');
	//END send create account mail

	} //error end
}  
///////////// END create account //////////////////////////////////////////////////	  
	  

///////////// START Redirection for create account //////////////////////////////////////////////////	
if ((vam_session_is_registered('create_account')) && (isset($_POST['action']) && ($_POST['action'] == 'process'))) {  
// confirm order
	if ($error == false) {
		if (isset($$payment->form_action_url)) {
			$sc_payment_url = true;
			vam_session_unregister('sc_confirmation'); //to make sure if not returning back to checkout_success.php
			$form_action_url = $$payment->form_action_url;
		} else {
			$form_action_url = vam_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
			vam_redirect($form_action_url); //redirect
		}
	} //error end
}
///////////// END Redirection for create account //////////////////////////////////////////////////	

///////////// START Redirection for noaccount //////////////////////////////////////////////////	
if ((!vam_session_is_registered('create_account')) && (isset($_POST['action']) && ($_POST['action'] == 'process'))) {  
// confirm order
	if (isset($$payment->form_action_url)) {
		$sc_payment_url = true;
		vam_session_unregister('sc_confirmation'); //to make sure if not returning back to checkout_success.php
		$form_action_url = $$payment->form_action_url;
	} else {
		$form_action_url = vam_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL');
		vam_redirect($form_action_url); //redirect
	}
}
///////////// END Redirection for noaccount //////////////////////////////////////////////////	
	  
  



###################### payment url redirection START ###################################
//if payment method such as paypal is choosen,  repost process_button data
  if ((isset($$payment->form_action_url)) && ($sc_payment_url == true)) {
		
	$form_action_url = $$payment->form_action_url;
	echo vam_draw_form('checkoutUrl', $form_action_url, 'post');
	   
  
  
    
	if (is_array($payment_modules->modules)) {
		$payment_modules->pre_confirmation_check();
	}
  
  
	if (is_array($payment_modules->modules)) {
		echo $payment_modules->process_button();
	}


	if (is_array($payment_modules->modules)) {
		if ($confirmation = $payment_modules->confirmation()) {
	
	?>

    <h2><?php echo HEADING_PAYMENT_INFORMATION; ?></h2>

      <div class="contentText">
        <table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="4"><?php 
            
            
            echo $confirmation['title']; ?></td>
          </tr>
    
    <?php
          for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) {
          
    ?>
    
          <tr>
            <td><?php echo vam_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
            <td class="main"><?php echo $confirmation['fields'][$i]['title']; ?></td>
            <td><?php echo vam_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
            <td class="main"><?php echo $confirmation['fields'][$i]['field']; ?></td>
          </tr>
    
    <?php
          }
    ?>
    
        </table>
      </div>
    
    <?php
        }
      }
     
    ?>

	<p><?php echo SC_TEXT_REDIRECT; ?></p>



    </form>
    <?php 
    require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
    <script type="text/javascript">
        document.checkoutUrl.submit();
    </script>
    <noscript><input type="submit" value="verify submit"></noscript>

   
<?php 
}
//////////  END  redirection page for payment modules such as paypal if no confirmation page ////////////



  $breadcrumb->add(NAVBAR_TITLE_1, vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
  $breadcrumb->add(NAVBAR_TITLE_2);

 
?>

<script type="text/javascript">
/*$(hidePage);		
	function hidePage()	{
	$("#sc_content").css("display","none");
	;}*/
</script>  


<h1><?php echo HEADING_TITLE; ?></h1>

<?php
//show progress bar only if confirmation page is true
if (SC_CONFIRMATION_PAGE == 'true') { ?>
<div class="top_space">
    <ul id="myProgressBar">
        <li class="done">1. <?php echo SC_PROGRESS_CHECKOUT_PAGE; ?></li>
        <li class="current">2. <?php echo SC_PROGRESS_CONFIRMATION_PAGE; ?></li>
    </ul>
</div><!-- dive end myProgressBar -->
<?php } ?>


<?php




//draw form 
  //echo vam_draw_form('checkout_confirmation', $form_action_url, 'post');
$form_action_url = vam_href_link(FILENAME_SC_CHECKOUT_CONFIRMATION, '', 'SSL');
echo vam_draw_form('checkout_confirmation', $form_action_url, 'post');

  //echo vam_draw_form('checkout_confirmation', vam_href_link(FILENAME_SC_CHECKOUT_CONFIRMATION, 'action=process', 'SSL')); 

  echo vam_draw_hidden_field('action', 'process');

?> 
 


<div id="sc_content">


<div class="sc_box">

<?php
 /////////////  START Shipping address //////////////////////////// ?>
<div id="conf_shipping_box">
  <?php
	  if ($show_account_data == true) {
	  	echo '<h2>' . SC_HEADING_CREATE_ACCOUNT_INFORMATION . '</h2>'; 
		echo '<p>' . vam_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br /></p>'); 
	  } else {
	  	echo '<h2>' . HEADING_SHIPPING_INFORMATION . '</h2>';
	  }
  ?>

  


	<?php 
	if ($hide_shipping_data == true) {
		if  ($show_account_data != true) {
			echo '<p>' . SC_NO_SHIPMENT_INFORMATION . '</p>'; 
		}
	} else {
		echo '<h4>' . HEADING_DELIVERY_ADDRESS . '</h4>'; ?>
		<p><?php echo '' . vam_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'); 
	 ?></p>
    
		<?php
        if ($order->info['shipping_method']) {
        ?>
        
                <p>&nbsp;</p>
                <?php echo '<h4>' . HEADING_SHIPPING_METHOD . ' </h4>'; ?>
                
                <p><?php echo $order->info['shipping_method']; ?></p>
                
                
              
    <?php
        }
	} //end $hide_shipping_data
    ?>

      


</div><!-- Div end conf_shipping_box -->
<?php /////////////  END Shipping address //////////////////////////// ?>



<?php /////////////  START Payment address //////////////////////////// ?>
<?php if ($hide_payment_data == true) {
	//show nothing
} else { ?>
<div id="conf_payment_box">
  <h2><?php echo HEADING_BILLING_INFORMATION; ?></h2>

 	
    
         <?php echo '<h4>' . HEADING_BILLING_ADDRESS . '</h4>'; ?>
          <p><?php echo vam_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'); ?></p>
          
          <p>&nbsp;</p>
          <?php echo '<h4>' . HEADING_PAYMENT_METHOD . '</h4>'; ?>
         <p><?php echo $order->info['payment_method']; ?></p>



  

</div><!-- Div end Payment box -->        
<?php
  }
  /////////////  END Payment address //////////////////////////// ?>



</div><!-- Div end main box -->

<div class="line_space"></div>

<?php /////////////  START comments //////////////////////////// ?>
<div class="sc_box">
<?php
  if (vam_not_null($order->info['comments'])) {
?>

  <h2><?php echo HEADING_ORDER_COMMENTS; ?></h2>

  <div class="contentText">
    <?php echo nl2br(vam_output_string_protected($order->info['comments'])) . vam_draw_hidden_field('comments', $order->info['comments']); ?>
  </div>

<?php
  }
?>
</div><!-- Div end comments box -->
<?php ///////////// END comments //////////////////////////// ?>

<div class="line_space"></div>


<?php /////////////  START products //////////////////////////// ?>
<div class="sc_box"> 
<?php
  if (sizeof($order->info['tax_groups']) > 1) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="2"><?php echo '<h2>' . HEADING_PRODUCTS . '</h2>'; ?></td>
            <td align="right"><strong><?php echo HEADING_TAX; ?></strong></td>
            <td align="right"><strong><?php echo HEADING_TOTAL; ?></strong></td>
          </tr>
</table>
<?php
  } else {
?>

          
          <?php echo '<h2>' . HEADING_PRODUCTS . '</h2>'; ?>

<?php
  }
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php

  for ($i=0, $n=sizeof($order->products); $i<$n; $i++) {
    echo '          <tr>' . "\n" .
         '            <td align="right" valign="top" width="30">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
         '            <td valign="top">' . $order->products[$i]['name'];

    if (STOCK_CHECK == 'true') {
      echo vam_check_stock($order->products[$i]['id'], $order->products[$i]['qty']);
    }

    if ( (isset($order->products[$i]['attributes'])) && (sizeof($order->products[$i]['attributes']) > 0) ) {
      for ($j=0, $n2=sizeof($order->products[$i]['attributes']); $j<$n2; $j++) {
        echo '<br /><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'] . '</i></small></nobr>';
      }
    }

    echo '</td>' . "\n";

    if (sizeof($order->info['tax_groups']) > 1) echo '            <td valign="top" align="right">' . vam_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n";

    echo '            <td align="right" valign="top">' . $vamPrice->Format($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']) . '</td>' . "\n" .
         '          </tr>' . "\n";
  }
?>

        </table>

</div><!-- Div end Products box --> 
<?php ///////////// END products //////////////////////////// ?>

<div class="line_space"></div>

<?php ///////////// START Total //////////////////////////// ?>
<div style="float: right;">
    <table border="0" cellspacing="0" cellpadding="2">
    <?php
	  if (MODULE_ORDER_TOTAL_INSTALLED) {
		echo $order_total_modules->output();
	  }
	?>
	</table>
</div>
 <?php ///////////// END Total //////////////////////////// ?> 
 
 <div class="line_space"></div>
 
 <div class="contentText">
    <div style="float: right;">
<?php
  if (is_array($payment_modules->modules)) {
    echo $payment_modules->process_button();
  }

?>
<?php echo vam_draw_button(IMAGE_BUTTON_CONFIRM_ORDER, 'check', null, 'primary'); ?>
    </div>
  </div>

 
 
 
 
  
<div class="line_space"></div>  
  
<?php
  if (is_array($payment_modules->modules)) {
    if ($confirmation = $payment_modules->confirmation()) {
?>

  <h2><?php echo HEADING_PAYMENT_INFORMATION; ?></h2>

  <div class="contentText">
    <table border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td colspan="4"><?php echo $confirmation['title']; ?></td>
      </tr>

<?php
      for ($i=0, $n=sizeof($confirmation['fields']); $i<$n; $i++) {
?>

      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main"><?php echo $confirmation['fields'][$i]['title']; ?></td>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '10', '1'); ?></td>
        <td class="main"><?php echo $confirmation['fields'][$i]['field']; ?></td>
      </tr>

<?php
      }
?>

    </table>
  </div>

<?php
    }
  }  
 ?> 
  

</div>
<script type="text/javascript">
$('#coProgressBar').progressbar({
  value: 100
});
</script>

</form>

<?php
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>

<?php  if (SC_CONFIRMATION_PAGE == 'fffff') { ?>
  	<script type="text/javascript">
    document.checkout_confirmation.submit();
    </script>
	<noscript><input type="submit" value="verify submit"></noscript>
<?php  } ?>
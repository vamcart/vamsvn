<?php
/*
  $Id: edit_orders_add_product.php v5.0 07/19/2007 djmonkey1 Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License

  For Order Editor support or to post bug reports, feature requests, etc, please visit the Order Editor support thread:
  http://forums.oscommerce.com/index.php?showtopic=54032
  
*/

  require('includes/application_top.php');

//b2b
  $cus_id=intval($_GET['cID']);
  if(!$cus_id){$cus_id=intval($_POST['cID']);}

//b2b

require_once (DIR_FS_CATALOG.DIR_WS_CLASSES.'vam_price.php');

require (DIR_WS_CLASSES.'order.php');
if (!$_GET['oID'])
	$_GET['oID'] = $_POST['oID'];
$order = new order($_GET['oID']);

$vamPrice = new vamPrice($order->info['currency'], $order->info['status'],$order->customer['ID']);


  // include the appropriate functions & classes
  include('order_editor/functions.php');
  include('order_editor/cart.php');
  include('order_editor/order.php');
  include(DIR_WS_LANGUAGES . $_SESSION['language']. '/admin/' . FILENAME_ORDERS_EDIT);

  // Include currencies class
  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  $oID = vam_db_prepare_input((int)$_GET['oID']);
  $order = new manualOrder($oID);

  // Setup variables
  $step = ((isset($_POST['step'])) ? (int)$_POST['step'] : 1);
  $add_product_categories_id = ((isset($_POST['add_product_categories_id'])) ? (int)$_POST['add_product_categories_id'] : '');
  $add_product_products_id = ((isset($_POST['add_product_products_id'])) ? (int)$_POST['add_product_products_id'] : 0);

  // $_GET['action'] switch
  if (isset($_GET['action'])) {
    switch ($_GET['action']) {
    
    ////
    // Add a product to the virtual cart
      case 'add_product':
        if ($step != 5) break;
        
        $AddedOptionsPrice = 0;
        
        // Get Product Attribute Info
        if (isset($_POST['add_product_options'])) {
          foreach($_POST['add_product_options'] as $option_id => $option_value_id) {
            $result = vam_db_query("SELECT * FROM " . TABLE_PRODUCTS_ATTRIBUTES . " pa INNER JOIN " . TABLE_PRODUCTS_OPTIONS . " po ON (po.products_options_id = pa.options_id and po.language_id = '" . $_SESSION['languages_id'] . "') INNER JOIN " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov on (pov.products_options_values_id = pa.options_values_id and pov.language_id = '" . $_SESSION['languages_id'] . "') WHERE products_id = '" . $add_product_products_id . "' and options_id = '" . $option_id . "' and options_values_id = '" . $option_value_id . "'");
            $row = vam_db_fetch_array($result);
			if (is_array($row)) extract($row, EXTR_PREFIX_ALL, "opt");
					if ($opt_price_prefix == '-')
					{$AddedOptionsPrice -= $opt_options_values_price;}
					else //default to positive
					{$AddedOptionsPrice += $opt_options_values_price;}
            $option_value_details[$option_id][$option_value_id] = array (
					"options_values_price" => $opt_options_values_price,
					"price_prefix" => $opt_price_prefix);
            $option_names[$option_id] = $opt_products_options_name;
            $option_values_names[$option_value_id] = $opt_products_options_values_name;
			
					//add on for downloads
		if (DOWNLOAD_ENABLED == 'true') {
        $download_query_raw ="SELECT products_attributes_filename, products_attributes_maxdays, products_attributes_maxcount 
        FROM " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " 
        WHERE products_attributes_id='" . $opt_products_attributes_id . "'";
        
		$download_query = vam_db_query($download_query_raw);
        if (vam_db_num_rows($download_query) > 0) {
          $download = vam_db_fetch_array($download_query);
          $filename[$option_id] = $download['products_attributes_filename'];
          $maxdays[$option_id]  = $download['products_attributes_maxdays'];
          $maxcount[$option_id] = $download['products_attributes_maxcount'];
        } //end if (vam_db_num_rows($download_query) > 0) {
		} //end if (DOWNLOAD_ENABLED == 'true') {
		//end downloads 
		
          } //end foreach($_POST['add_product_options'] as $option_id => $option_value_id) {
        } //end if (isset($_POST['add_product_options'])) {
		
        
        // Get Product Info
        $product_query = vam_db_query("select p.products_model, p.products_price, pd.products_name, p.products_tax_class_id from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on pd.products_id = p.products_id where p.products_id = '" . (int)$add_product_products_id . "'");
        $product = vam_db_fetch_array($product_query);
        $country_id = oe_get_country_id($order->delivery["country"]);
        $zone_id = oe_get_zone_id($country_id, $order->delivery['state']);
        $products_tax = vam_get_tax_rate($product['products_tax_class_id'], $country_id, $zone_id);
		
		
			// 2.1.3  Pull specials price from db if there is an active offer
			$special_price = vam_db_query("
			SELECT specials_new_products_price 
			FROM " . TABLE_SPECIALS . " 
			WHERE products_id =". $add_product_products_id . " 
			AND status");
			$new_price = vam_db_fetch_array($special_price);
			
			if ($new_price) 
			{ $product['products_price'] = $new_price['specials_new_products_price']; }

// Спец. цена
//Modified 4 VAM           
            
//$product['products_price']=b2b_display_price($add_product_products_id,$product['products_price']);
            
$products_price = $vamPrice->GetPrice($add_product_products_id, $format = true, 1, $product['products_tax_class_id'], $product['products_price'], 1);
$product['products_price']=$products_price['plain'];

//End mod 4 VAM

// Спец. цена - скидка
//Modified 4 VAM           
//            if ($new_price = 
//vam_get_products_special_price($add_product_products_id)) 
//{$p_products_price=$new_price;} 
//
//$p_products_price=b2b_display_price($add_product_products_id,$p_products_price);
//End mod 4 VAM
			
	        //sppc patch
	        //Set to false by default, configurable in the Order Editor section of the admin panel
	        //thanks to whistlerxj for the original version of this patch
    
	        if (ORDER_EDITOR_USE_SPPC == 'true') {
	
	        // first find out the customer associated with this order ID..
            $c_id_result = vam_db_query('SELECT customers_id 
	        FROM orders 
	        WHERE orders_id="' . (int)$oID . '"');
	
            $cid = vam_db_fetch_array($c_id_result);
            if ($cid){
            $cust_id = $cid['customers_id'];
            // now find the customer's group.
            $c_g_id_result = vam_db_query('SELECT customers_group_id 
	        FROM customers 
        	WHERE customers_id="' . $cust_id . '"');
	
            $c_g_id = vam_db_fetch_array($c_g_id_result);
            if ($c_g_id){
            $cust_group_id = $c_g_id['customers_group_id'];
            // get the price of the product from the products_groups table.
            $price_result = vam_db_query('SELECT customers_group_price 
	        FROM products_groups 
         	WHERE products_id="' . $add_product_products_id . '" 
        	AND customers_group_id="' . $cust_group_id . '"');
	
            $price_array = vam_db_fetch_array($price_result);
            if ($price_array){
            // set the price of the new product to the group specific price.
            $product['products_price'] = $price_array['customers_group_price'];
               }
              }
             }
         	}
	        //end sppc patch   

        $sql_data_array = array('orders_id' => vam_db_prepare_input($oID),
                                'products_id' => vam_db_prepare_input($add_product_products_id),
                                'products_model' => vam_db_prepare_input($product['products_model']),
                                'products_name' => vam_db_prepare_input($product['products_name']),
                                'products_price' => vam_db_prepare_input($product['products_price']+$AddedOptionsPrice),
                                'final_price' => ($product['products_price']+$AddedOptionsPrice)*$_POST['add_product_quantity'],
                                'products_tax' => vam_db_prepare_input($products_tax),
                                'products_quantity' => vam_db_prepare_input($_POST['add_product_quantity']),
                                'allow_tax' => '0');
        vam_db_perform(TABLE_ORDERS_PRODUCTS, $sql_data_array);
        $new_product_id = vam_db_insert_id();

      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$oID,
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => vam_db_input(vam_db_prepare_input('add_product')),
                              'value' => vam_db_input(vam_db_prepare_input($product['products_name'] . ' ' . vam_db_prepare_input($product['products_price']*$_POST['add_product_quantity']) . ' qty:' . vam_db_prepare_input($_POST['add_product_quantity']))),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform(TABLE_ORDERS_LOG, $sql_data_array);    
        
        if (isset($_POST['add_product_options'])) {
          foreach($_POST['add_product_options'] as $option_id => $option_value_id) {
            $sql_data_array = array('orders_id' => vam_db_prepare_input($oID),
                                    'orders_products_id' => vam_db_prepare_input($new_product_id),
                                    'products_options' => vam_db_prepare_input($option_names[$option_id]),
                                    'products_options_values' => vam_db_prepare_input($option_values_names[$option_value_id]),
             'options_values_price' => vam_db_prepare_input($option_value_details[$option_id][$option_value_id]['options_values_price']),
             'price_prefix' => vam_db_prepare_input($option_value_details[$option_id][$option_value_id]['price_prefix']));
            vam_db_perform(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $sql_data_array);
            
      // Log Order Data
      $sql_data_array = array('orders_id' => (int)$oID,
                              'customers_id' => (int)$_SESSION['customer_id'],
                              'field' => vam_db_input(vam_db_prepare_input('add_product_attribute')),
                              'value' => vam_db_input(vam_db_prepare_input(vam_db_prepare_input($option_values_names[$option_value_id]))),
                              'date_added' => 'now()',
                              'last_modified' => 'now()');
      vam_db_perform('orders_log', $sql_data_array);                       
			
		//add on for downloads
		if (DOWNLOAD_ENABLED == 'true' && isset($filename[$option_id])) {
		
		$Query = "INSERT INTO " . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " SET
				orders_id = '" . vam_db_prepare_input($oID) . "',
				orders_products_id = '" . vam_db_prepare_input($new_product_id) . "',
				orders_products_filename = '" . vam_db_prepare_input($filename[$option_id]) . "',
				download_maxdays = '" . vam_db_prepare_input($maxdays[$option_id]) . "',
	            download_count = '" . vam_db_prepare_input($maxcount[$option_id]) . "'";
						
					vam_db_query($Query);
					
       	} //end if (DOWNLOAD_ENABLED == 'true') {
		//end downloads 
          }
        }
		
		// Update inventory Quantity
			// This is only done if store is set up to use stock
			if (STOCK_LIMITED == 'true'){
			vam_db_query("UPDATE " . TABLE_PRODUCTS . " SET
			products_quantity = products_quantity - " . $_POST['add_product_quantity'] . " 
			WHERE products_id = '" . $_POST['add_product_products_id'] . "'");
			}
			// Update products_ordered info
			vam_db_query ("UPDATE " . TABLE_PRODUCTS . " SET
			products_ordered = products_ordered + " . $_POST['add_product_quantity'] . "
			WHERE products_id = '" . $_POST['add_product_products_id'] . "'");
        
        // Unset selected product & category
        $add_product_categories_id = 0;
        $add_product_products_id = 0;
        
			 
		vam_redirect(vam_href_link(FILENAME_ORDERS_EDIT_ADD_PRODUCT, 'oID=' . $oID . '&cID='.$cus_id.'&step=1&submitForm=yes'));
        
		break;
    }
  }

 
////
// Generate product list based on chosen category or search keywords
  $not_found = true;
  if (isset($_POST['search'])) { 
    $search_array = explode(" ", $_POST['product_search']);
    $search_array = oe_clean_SQL_keywords($search_array);
    if (sizeof($search_array) <= 1) {
      $search_fields = array('p.products_id', 'p.products_price', 'p.products_model', 'pd.products_name');
      $product_search = oe_generate_search_SQL($search_array, $search_fields);
    } else {
      $search_fields = array('pd.products_name');
      $product_search = oe_generate_search_SQL($search_array, $search_fields, 'AND');
    }
  
    $products_query = vam_db_query("select p.products_id, p.products_price, p.products_model, pd.products_name from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on (p.products_id = pd.products_id) where pd.language_id = '" . $_SESSION['languages_id'] . "' and (" . $product_search . ") order by pd.products_name");
    $not_found = ((vam_db_num_rows($products_query)) ? false : true);
  } 
  
  if (!isset($_POST['search'])) { 
    $product_search = " where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . $_SESSION['languages_id'] . "' and p.products_id = p2c.products_id and p2c.categories_id = c.categories_id ";
    
    $_GET['inc_subcat'] = '1';
    if ($_GET['inc_subcat'] == '1') {
      $subcategories_array = array();
      oe_get_subcategories($subcategories_array, $add_product_categories_id);
      $product_search .= " and p2c.products_id = p.products_id and p2c.products_id = pd.products_id and (p2c.categories_id = '" . (int)$add_product_categories_id . "'";
      for ($i=0, $n=sizeof($subcategories_array); $i<$n; $i++ ) {
        $product_search .= " or p2c.categories_id = '" . $subcategories_array[$i] . "'";
      }
      $product_search .= ")";
    } else {
      $product_search .= " and p2c.products_id = p.products_id and p2c.products_id = pd.products_id and pd.language_id = '" . $_SESSION['languages_id'] . "' and p2c.categories_id = '" . (int)$add_product_categories_id . "'";
    }

    $products_query = vam_db_query("select distinct p.products_id, p.products_price, p.products_tax_class_id, p.products_model, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_CATEGORIES . " c, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c " . $product_search . " order by pd.products_name");
    $not_found = ((vam_db_num_rows($products_query)) ? false : true);
  }

  $category_array = array(array('id' => '', 'text' => TEXT_SELECT_CATEGORY),
                          array('id' => '0', 'text' => TEXT_ALL_CATEGORIES));
  
  if (($step > 1) && (!$not_found)) {
    $product_array = array(array('id' => 0, 'text' => TEXT_SELECT_PRODUCT));
    while($products = vam_db_fetch_array($products_query)) {

//$products['products_price']=b2b_display_price($products['products_id'],$products['products_price']);

$products_price = $vamPrice->GetPrice($products['products_id'], $format = true, 1, $products['products_tax_class_id'], $products['products_price'], 1);
$products['products_price']=$products_price['plain'];

      $product_array[] = array('id' => $products['products_id'],
                               'text' => $products['products_name'] . ' (' . $products['products_model'] . ')' . ':&nbsp;' . $currencies->format($products['products_price'], true, $order->info['currency'], $order->info['currency_value']));
    }
  }

  $has_attributes = false;
  $products_attributes_query = vam_db_query("select count(*) as total from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$add_product_products_id . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . $_SESSION['languages_id'] . "'");
  $products_attributes = vam_db_fetch_array($products_attributes_query);
  if ($products_attributes['total'] > 0) $has_attributes = true;   
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<!--<meta name="viewport" content="initial-scale=1.0, width=device-width" />-->
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
<?php if ( (isset($_GET['submitForm'])) && ($_GET['submitForm'] == 'yes') ) {
        echo '<script language="javascript" type="text/javascript"><!--' . "\n" .
             '  window.opener.document.edit_order.subaction.value = "add_product";' . "\n" . 
             '  window.opener.document.edit_order.submit();' . "\n" .
             '//--></script>';
			 }
	?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- body //-->
	 <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2" style="border: 1px solid #C9C9C9;" align="center">
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent" colspan="3" align="center"><?php echo sprintf(ADDING_TITLE, $oID); ?></td>
          </tr>
          <tr class="dataTableRow">
           <form action="<?php echo vam_href_link(FILENAME_ORDERS_EDIT_ADD_PRODUCT, 'oID=' . $_GET['oID']); ?>" method="POST">
            <td class="dataTableContent" align="right"><?php echo TEXT_STEP_1; ?></td>
            <td class="dataTableContent" valign="top"><?php echo vam_draw_pull_down_menu('add_product_categories_id', vam_get_category_tree('0', '', '0', $category_array), $add_product_categories_id,'style="width:300px;" onchange="this.form.submit();"'); ?></td>
            <td class="dataTableContent" align="center">
			  <noscript>
			    <span class="button"><button type="submit" value="<?php echo TEXT_BUTTON_SELECT_CATEGORY; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12');?> &nbsp;<?php echo TEXT_BUTTON_SELECT_CATEGORY; ?></button></span>
			  </noscript>
			    <input type="hidden" name="step" value="2">
<?php
		//b2b
         echo vam_draw_hidden_field('cID',$cus_id);
    	//b2b
?>
			 </td>
           </form>
          </tr>
          <tr class="dataTableRow">
            <td class="dataTableContent" colspan="3" align="center"><?php echo TEXT_PRODUCT_SEARCH; ?></td>
          </tr>
          <tr class="dataTableRow">
          <form action="<?php echo vam_href_link(FILENAME_ORDERS_EDIT_ADD_PRODUCT, 'oID=' . $_GET['oID']); ?>" method="POST">
            <td>&nbsp;</td>
            <td class="dataTableContent" valign="top">&nbsp;<input type="text" name="product_search" value="<?php if(isset($_POST['product_search'])) echo $_POST['product_search']; ?>" onchange="this.form.submit();">
			</td>
            <td class="dataTableContent" align="center"><noscript><span class="button"><button type="submit" value="Search for This Product"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;Search for This Product</button></span></noscript><input type="hidden" name="step" value="2"><input type="hidden" name="search" value="1"></td>
          </form>
          </tr>
        <?php if ($not_found) { ?>
          <tr class="dataTableRow">
            <td class="dataTableContent" colspan="3" align="center"><?php echo TEXT_PRODUCT_NOT_FOUND; ?></td>
          </tr>
        <?php } ?>
<?php
  if (($step > 1) && (!$not_found)) {
    echo '          <tr class="dataTableRow">' . "\n" .
         '            <td colspan="3" style="border-bottom: 1px solid #C9C9C9;">' . vam_draw_separator('pixel_trans.gif', '1', '1') . '</td>' . "\n" .
         '          </tr>' . "\n" .
         '          <tr class="dataTableRow">' . "\n" .
         '            <td colspan="3" style="background: #FFFFFF;">' . vam_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
         '          </tr>' . "\n";
?>
          <tr class="dataTableRow"> 
            <td colspan="3" style="border-top: 1px solid #C9C9C9;"><?php echo vam_draw_separator('pixel_trans.gif', '1', '1'); ?></td>
          </tr>
          <tr class="dataTableRow">
          <form action="<?php echo vam_href_link(FILENAME_ORDERS_EDIT_ADD_PRODUCT, 'oID=' . $_GET['oID']); ?>" method="POST">
<?php
		//b2b
         echo vam_draw_hidden_field('cID',$cus_id);
    	//b2b
?>
            <td class="dataTableContent" align="right"><?php echo TEXT_STEP_2; ?></td>
            <td class="dataTableContent" valign="top"><?php echo vam_draw_pull_down_menu('add_product_products_id', $product_array, $add_product_products_id, 'style="width:300px;" onchange="this.form.submit();"'); ?></td>
            <td class="dataTableContent" align="center"><noscript><span class="button"><button type="submit" value="<?php echo TEXT_BUTTON_SELECT_PRODUCT; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12');?> &nbsp;<?php echo TEXT_BUTTON_SELECT_PRODUCT; ?></button></span></noscript><input type="hidden" name="step" value="3">
            <input type="hidden" name="add_product_categories_id" value="<?php echo $add_product_categories_id; ?>">
          <?php if (isset($_POST['search'])) { ?>
            <input type="hidden" name="search" value="1">
            <input type="hidden" name="product_search" value="<?php echo $_POST['product_search']; ?>">
          <?php } ?>
            </td>
          </form>
          </tr>
<?php
  }

  if (($step > 2) && ($add_product_products_id > 0)) {
    echo '          <tr class="dataTableRow">' . "\n" .
         '            <td colspan="3" style="border-top: 1px solid #C9C9C9;">' . vam_draw_separator('pixel_trans.gif', '1', '1') . '</td>' . "\n" .
         '          </tr>' . "\n" .
         '          <tr class="dataTableRow">' . "\n";
    
    if ($has_attributes) echo '          <form action="' . vam_href_link(FILENAME_ORDERS_EDIT_ADD_PRODUCT, 'oID=' . $_GET['oID']) . '" method="post">' . "\n";

    echo '            <td class="dataTableContent" align="right">' . TEXT_STEP_3 . '</td>' . "\n";

		//b2b
         echo vam_draw_hidden_field('cID',$cus_id);
    	//b2b

    if ($has_attributes) {
      $i=1;
      $products_options_name_query = vam_db_query("select distinct popt.products_options_id, popt.products_options_name from " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib where patrib.products_id='" . (int)$add_product_products_id . "' and patrib.options_id = popt.products_options_id and popt.language_id = '" . $_SESSION['languages_id'] . "'");
      while ($products_options_name = vam_db_fetch_array($products_options_name_query)) {
        $selected = 0;
        $products_options_array = array();
        if ($i > 1) echo '            <td class="dataTableContent">&nbsp;</td>' . "\n";
        $products_options_query = vam_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov where pa.products_id = '" . (int)$add_product_products_id . "' and pa.options_id = '" . $products_options_name['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '" . $_SESSION['languages_id'] . "'");
        while ($products_options = vam_db_fetch_array($products_options_query)) {
          $products_options_array[] = array('id' => $products_options['products_options_values_id'], 'text' => $products_options_name['products_options_name'] . ' - ' . $products_options['products_options_values_name']);
          if ($products_options['options_values_price'] != '0') {
            $products_options_array[sizeof($products_options_array)-1]['text'] .= ' (' . $products_options['price_prefix'] . $currencies->format($products_options['options_values_price'], true, $order->info['currency'], $order->info['currency_value']) .')';
          }
        }
		
		if(isset($_POST['add_product_options'])) {
          $selected_attribute = $_POST['add_product_options'][$products_options_name['products_options_id']];
        } else {
          $selected_attribute = false;
        }
		
        echo   '            <td class="dataTableContent" valign="top">' . vam_draw_pull_down_menu('add_product_options[' . $products_options_name['products_options_id'] . ']', $products_options_array, $selected_attribute) . '</td>' . "\n" .
               '            <td class="dataTableContent">&nbsp;</td>' . "\n" .
               '          </tr>' . "\n" .
               '          <tr class="dataTableRow">' . "\n";  
        $i++;
      }
      echo '            <td class="dataTableContent">&nbsp;</td>' . "\n" .
           '            <td class="dataTableContent" colspan="2" align="left"><span class="button"><button type="submit" value="' . TEXT_BUTTON_SELECT_OPTIONS . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . TEXT_BUTTON_SELECT_OPTIONS . '</button></span><input type="hidden" name="step" value="4"><input type="hidden" name="add_product_categories_id" value="' . $add_product_categories_id . '"><input type="hidden" name="add_product_products_id" value="' . $add_product_products_id . '">' . ((isset($_POST['search'])) ? '<input type="hidden" name="search" value="1"><input type="hidden" name="product_search" value="' . $_POST['product_search'] . '">' : '') . '</td>' . "\n" .
           '          </tr>' . "\n" .
           '          </form>' . "\n";
    } else {
      $step = 4;
      echo '            <td class="dataTableContent" valign="top" colspan="2">' . TEXT_SKIP_NO_OPTIONS . '</td>' . "\n" .
           '          </tr>' . "\n";
    }
  }
  
  if ($step > 3) {
    echo '          <tr class="dataTableRow">' . "\n" .
         '            <td colspan="3" style="border-bottom: 1px solid #C9C9C9;">' . vam_draw_separator('pixel_trans.gif', '1', '1') . '</td>' . "\n" .
         '          </tr>' . "\n" .
         '          <tr class="dataTableRow">' . "\n" .
         '            <td colspan="3" style="background: #FFFFFF;">' . vam_draw_separator('pixel_trans.gif', '1', '10') . '</td>' . "\n" .
         '          </tr>' . "\n" .
         '          <tr class="dataTableRow">' . "\n" .
         '            <td colspan="3" style="border-top: 1px solid #C9C9C9;">' . vam_draw_separator('pixel_trans.gif', '1', '1') . '</td>' . "\n" .
         '          </tr>' . "\n" .
         '          <form action="' . vam_href_link(FILENAME_ORDERS_EDIT_ADD_PRODUCT, 'oID=' . $_GET['oID'] . '&action=add_product') . '" method="post">' . "\n" .
         '          <tr class="dataTableRow">' . "\n" .
         '            <td class="dataTableContent" align="right" valign="middle">' . TEXT_STEP_4 . '</td>' . "\n" .
         '            <td class="dataTableContent" align="left" valign="middle">' . TEXT_QUANTITY . '&nbsp;<input name="add_product_quantity" size="3" value="1"></td>' . "\n" .
         '            <td class="dataTableContent" align="center" valign="middle"></td>' . "\n" .
		 '          </tr>' . "\n" . 
		 '          <tr class="dataTableRow">' . "\n" .
		 '             <td></td>' . "\n" . 
		 '             <td colspan="2"><span class="button"><button type="submit" value="' . TEXT_BUTTON_ADD_PRODUCT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . TEXT_BUTTON_ADD_PRODUCT . '</button></span>' . "\n" .
		 '           ';
    if (isset($_POST['add_product_options'])) {
      foreach($_POST['add_product_options'] as $option_id => $option_value_id) {
        echo '<input type="hidden" name="add_product_options['.$option_id.']" value="' . $option_value_id . '">';
      }
    }

		//b2b
         echo vam_draw_hidden_field('cID',$cus_id);
    	//b2b

    echo '<input type="hidden" name="add_product_categories_id" value="' . $add_product_categories_id . '"><input type="hidden" name="add_product_products_id" value="' . $add_product_products_id . '"><input type="hidden" name="step" value="5"></td>' . "\n" .
         '          </tr>' . "\n" .
         '          </form>' . "\n";
  }
?>
        </table></td>
      </tr>
    </table>
    <!-- body_text_eof //-->
 
           <div align="center" class="dataTableContent">
                   
				   <script language="JavaScript" type="text/javascript">
                   <!--
                    document.write("<a href=\"javascript:self.close();\"><?php echo TEXT_CLOSE_POPUP; ?></a>");
	               //-->
                  </script>
				  
				  <noscript>
				   <strong>
				    <?php echo TEXT_ADD_PRODUCT_INSTRUCTIONS; ?>
                   </strong>
				  </noscript>
				  
		   </div>
      
	
<!-- body_eof //-->

</body>
</html>
<?php  //eof   ?>
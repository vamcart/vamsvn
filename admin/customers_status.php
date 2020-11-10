<?php
/* --------------------------------------------------------------
   $Id: customers_status.php 1064 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce( based on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35); www.oscommerce.com
   (c) 2003	 nextcommerce (customers_status.php,v 1.28 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (customers_status.php,v 1.28 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------
   based on Third Party contribution:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');
  
  switch ($_GET['action']) {
    case 'insert':
    case 'save':
      $customers_status_id = vam_db_prepare_input($_GET['cID']);

      $languages = vam_get_languages();
      for ($i=0; $i<sizeof($languages); $i++) {
        $customers_status_name_array = $_POST['customers_status_name'];
        $customers_status_public = $_POST['customers_status_public'];
        $customers_status_show_price = $_POST['customers_status_show_price'];
        $customers_status_show_price_tax = $_POST['customers_status_show_price_tax'];
        $customers_status_min_order = $_POST['customers_status_min_order'];
        $customers_status_max_order = $_POST['customers_status_max_order'];
        $customers_status_discount = $_POST['customers_status_discount'];
        $customers_status_ot_discount_flag = $_POST['customers_status_ot_discount_flag'];
        $customers_status_ot_discount = $_POST['customers_status_ot_discount'];
        $customers_status_graduated_prices = $_POST['customers_status_graduated_prices'];
        $customers_status_discount_attributes = $_POST['customers_status_discount_attributes'];
        $customers_status_discount_by_category = $_POST['customers_status_discount_by_category'];
        $customers_status_discount_by_brand = $_POST['customers_status_discount_by_brand'];
        $customers_status_add_tax_ot = $_POST['customers_status_add_tax_ot'];
        $customers_status_payment_unallowed = $_POST['customers_status_payment_unallowed'];
        $customers_status_shipping_unallowed = $_POST['customers_status_shipping_unallowed'];
        $customers_fsk18 = $_POST['customers_fsk18'];
        $customers_fsk18_display = $_POST['customers_fsk18_display'];
        $customers_status_write_reviews = $_POST['customers_status_write_reviews'];
        $customers_status_read_reviews = $_POST['customers_status_read_reviews'];
        $customers_status_accumulated_limit = $_POST['customers_status_accumulated_limit'];
        $customers_base_status = $_POST['customers_base_status'];        

        $language_id = $languages[$i]['id'];

        $sql_data_array = array(
          'customers_status_name' => vam_db_prepare_input($customers_status_name_array[$language_id]),
          'customers_status_public' => vam_db_prepare_input($customers_status_public),
          'customers_status_show_price' => vam_db_prepare_input($customers_status_show_price),
          'customers_status_show_price_tax' => vam_db_prepare_input($customers_status_show_price_tax),
          'customers_status_min_order' => vam_db_prepare_input($customers_status_min_order),
          'customers_status_max_order' => vam_db_prepare_input($customers_status_max_order),
          'customers_status_discount' => vam_db_prepare_input($customers_status_discount),
          'customers_status_ot_discount_flag' => vam_db_prepare_input($customers_status_ot_discount_flag),
          'customers_status_ot_discount' => vam_db_prepare_input($customers_status_ot_discount),
          'customers_status_graduated_prices' => vam_db_prepare_input($customers_status_graduated_prices),
          'customers_status_add_tax_ot' => vam_db_prepare_input($customers_status_add_tax_ot),
          'customers_status_payment_unallowed' => vam_db_prepare_input($customers_status_payment_unallowed),
          'customers_status_shipping_unallowed' => vam_db_prepare_input($customers_status_shipping_unallowed),
          'customers_fsk18' => vam_db_prepare_input($customers_fsk18),
          'customers_fsk18_display' => vam_db_prepare_input($customers_fsk18_display),
          'customers_status_write_reviews' => vam_db_prepare_input($customers_status_write_reviews),
          'customers_status_read_reviews' => vam_db_prepare_input($customers_status_read_reviews),
          'customers_status_accumulated_limit' => vam_db_prepare_input($customers_status_accumulated_limit),
          'customers_status_discount_attributes' => vam_db_prepare_input($customers_status_discount_attributes),
          'customers_status_discount_by_category' => vam_db_prepare_input($customers_status_discount_by_category),
          'customers_status_discount_by_brand' => vam_db_prepare_input($customers_status_discount_by_brand)
        );

      	  // BOF Categories Discounts
          if ($_POST['customers_status_discount_by_category'] == "1") {
          	
        if ($_GET['action'] == 'insert') {
            $next_id_query = vam_db_query("select max(customers_status_id) as customers_status_id from " . TABLE_CUSTOMERS_STATUS . "");
            $next_id = vam_db_fetch_array($next_id_query);
            $customers_status_id = $next_id['customers_status_id'] + 1;
        }          	
            $subcats = array();
            $subcatqty = array();
            vam_db_query("DELETE FROM " . TABLE_CUSTOMERS_STATUS_TO_CATEGORIES . " WHERE customers_status_id = '" . (int)$customers_status_id . "'");
            for ($i=0, $n=100; $i<$n; $i++) {
              if (isset($_POST['subcat_' . $i . '_qty']) && ((int)$_POST['subcat_' . $i . '_qty'] > 0)) {
                if (in_array($_POST['subcat_' . $i . '_id'], $subcats)) {
                  $subcatqty[$_POST['subcat_' . $i . '_id']] += (int)$_POST['subcat_' . $i . '_qty'];
                  vam_db_query('update ' . TABLE_CUSTOMERS_STATUS_TO_CATEGORIES . ' set discount = ' . (int)$subcatqty[$_POST['subcat_' . $i . '_qty']] . ' where customers_status_id = ' . (int)$customers_status_id . ' and discount_id = ' . (int)$_POST['subcat_' . $i . '_id']);
                } else {
                  $subcats[] = $_POST['subcat_' . $i . '_id'];
                  $subcatqty[$_POST['subcat_' . $i . '_id']] = (int)$_POST['subcat_' . $i . '_qty'];
                  vam_db_query("INSERT INTO " . TABLE_CUSTOMERS_STATUS_TO_CATEGORIES . " (customers_status_id, categories_id, discount) VALUES ('" . (int)$customers_status_id . "', '" . (int)$_POST['subcat_' . $i . '_id'] . "', '" . (int)$_POST['subcat_' . $i . '_qty'] . "')");
                }
       	      }
            }
            if (empty($subcats)) { 
              vam_db_query('update ' . TABLE_CUSTOMERS_STATUS . ' set customers_status_discount_by_category = "0" where customers_status_id = ' . (int)$customers_status_id);
            } else { 
            }
          }
          // EOF Categories Discounts
          
      	  // BOF Brand Discounts
          if ($_POST['customers_status_discount_by_brand'] == "1") {
          	
        if ($_GET['action'] == 'insert') {
            $next_id_query = vam_db_query("select max(customers_status_id) as customers_status_id from " . TABLE_CUSTOMERS_STATUS . "");
            $next_id = vam_db_fetch_array($next_id_query);
            $customers_status_id = $next_id['customers_status_id'] + 1;
        }          	
            $subcats = array();
            $subcatqty = array();
            vam_db_query("DELETE FROM " . TABLE_CUSTOMERS_STATUS_TO_MANUFACTURERS . " WHERE customers_status_id = '" . (int)$customers_status_id . "'");
            for ($i=0, $n=100; $i<$n; $i++) {
              if (isset($_POST['brand_' . $i . '_qty']) && ((int)$_POST['brand_' . $i . '_qty'] > 0)) {
                if (in_array($_POST['brand_' . $i . '_id'], $subcats)) {
                  $subcatqty[$_POST['brand_' . $i . '_id']] += (int)$_POST['brand_' . $i . '_qty'];
                  vam_db_query('update ' . TABLE_CUSTOMERS_STATUS_TO_MANUFACTURERS . ' set discount = ' . (int)$subcatqty[$_POST['subcat_' . $i . '_qty']] . ' where customers_status_id = ' . (int)$customers_status_id . ' and discount_id = ' . (int)$_POST['brand_' . $i . '_id']);
                } else {
                  $subcats[] = $_POST['brand_' . $i . '_id'];
                  $subcatqty[$_POST['brand_' . $i . '_id']] = (int)$_POST['brand_' . $i . '_qty'];
                  vam_db_query("INSERT INTO " . TABLE_CUSTOMERS_STATUS_TO_MANUFACTURERS . " (customers_status_id, manufacturers_id, discount) VALUES ('" . (int)$customers_status_id . "', '" . (int)$_POST['brand_' . $i . '_id'] . "', '" . (int)$_POST['brand_' . $i . '_qty'] . "')");
                }
       	      }
            }
            if (empty($subcats)) { 
              vam_db_query('update ' . TABLE_CUSTOMERS_STATUS . ' set customers_status_discount_by_brand = "0" where customers_status_id = ' . (int)$customers_status_id);
            } else { 
            }
          }
          // EOF Brand Discounts          
        
        if ($_GET['action'] == 'insert') {
          if (!vam_not_null($customers_status_id)) {
            $next_id_query = vam_db_query("select max(customers_status_id) as customers_status_id from " . TABLE_CUSTOMERS_STATUS . "");
            $next_id = vam_db_fetch_array($next_id_query);
            $customers_status_id = $next_id['customers_status_id'] + 1;
            // We want to create a personal offer table corresponding to each customers_status
            vam_db_query("create table ".TABLE_PERSONAL_OFFERS.$customers_status_id . " (price_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, products_id int NOT NULL, quantity int, personal_offer decimal(15,4)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci");
		   vam_db_query("ALTER TABLE  `products` ADD  `group_permission_" . $customers_status_id . "` TINYINT( 1 ) NOT NULL");
		   vam_db_query("ALTER TABLE  `categories` ADD  `group_permission_" . $customers_status_id . "` TINYINT( 1 ) NOT NULL");

        $products_query = vam_db_query("select price_id, products_id, quantity, personal_offer from ".TABLE_PERSONAL_OFFERS.$customers_base_status ."");
        while($products = vam_db_fetch_array($products_query)){  
        $product_data_array = array(
          'price_id' => vam_db_prepare_input($products['price_id']),
          'products_id' => vam_db_prepare_input($products['products_id']),
          'quantity' => vam_db_prepare_input($products['quantity']),
          'personal_offer' => vam_db_prepare_input($products['personal_offer'])
         );          
         vam_db_perform(TABLE_PERSONAL_OFFERS.$customers_status_id, $product_data_array);
         } 

          }

          $insert_sql_data = array('customers_status_id' => vam_db_prepare_input($customers_status_id), 'language_id' => vam_db_prepare_input($language_id));
          $sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
          vam_db_perform(TABLE_CUSTOMERS_STATUS, $sql_data_array);
 
        } elseif ($_GET['action'] == 'save') {
          vam_db_perform(TABLE_CUSTOMERS_STATUS, $sql_data_array, 'update', "customers_status_id = '" . vam_db_input($customers_status_id) . "' and language_id = '" . $language_id . "'");
        }
      }
       
      if ($customers_status_image = &vam_try_upload('customers_status_image', DIR_FS_CATALOG_IMAGES . 'icons/')) {
        vam_db_query("update " . TABLE_CUSTOMERS_STATUS . " set customers_status_image = '" . $customers_status_image->filename . "' where customers_status_id = '" . vam_db_input($customers_status_id) . "'");
      }

      if ($_POST['default'] == 'on') {
        vam_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . vam_db_input($customers_status_id) . "' where configuration_key = 'DEFAULT_CUSTOMERS_STATUS_ID'");
      }

        vam_db_query("delete from " . TABLE_CUSTOMERS_STATUS_ORDERS_STATUS . " where customers_status_id = " .  vam_db_input($customers_status_id));
        $orders_status_query = vam_db_query("select orders_status_id from " . TABLE_ORDERS_STATUS . " where language_id = " . $_SESSION['languages_id'] . " order by orders_status_id");
        while ($orders_status = vam_db_fetch_array($orders_status_query)) {
           if ($_POST['orders_status_' . $orders_status['orders_status_id']]) {
              vam_db_query("insert into " . TABLE_CUSTOMERS_STATUS_ORDERS_STATUS . " values (" .  vam_db_input($customers_status_id) . ", " . $orders_status['orders_status_id'] . ")");
           }
        }

      vam_redirect(vam_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $customers_status_id));
      break;

    case 'deleteconfirm':
      $cID = vam_db_prepare_input($_GET['cID']);

      $customers_status_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'DEFAULT_CUSTOMERS_STATUS_ID'");
      $customers_status = vam_db_fetch_array($customers_status_query);
      if ($customers_status['configuration_value'] == $cID) {
        vam_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '' where configuration_key = 'DEFAULT_CUSTOMERS_STATUS_ID'");
      }

      vam_db_query("delete from " . TABLE_CUSTOMERS_STATUS . " where customers_status_id = '" . vam_db_input($cID) . "'");

      vam_db_query("delete from " . TABLE_CUSTOMERS_STATUS_ORDERS_STATUS . " where customers_status_id = " .  vam_db_input($cID));

      vam_db_query("DELETE FROM " . TABLE_CUSTOMERS_STATUS_TO_CATEGORIES . " WHERE customers_status_id = '" . vam_db_input($cID) . "'");
      vam_db_query("DELETE FROM " . TABLE_CUSTOMERS_STATUS_TO_MANUFACTURERS . " WHERE customers_status_id = '" . vam_db_input($cID) . "'");            

      // We want to drop the existing corresponding personal_offers table
      vam_db_query("drop table IF EXISTS ".TABLE_PERSONAL_OFFERS.vam_db_input($cID) . "");
      vam_db_query("ALTER TABLE `products` DROP `group_permission_" . vam_db_input($cID) . "`");
      vam_db_query("ALTER TABLE `categories` DROP `group_permission_" . vam_db_input($cID) . "`");
      vam_redirect(vam_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page']));
      break;

    case 'delete':
      $cID = vam_db_prepare_input($_GET['cID']);

      $status_query = vam_db_query("select count(*) as count from " . TABLE_CUSTOMERS . " where customers_status = '" . vam_db_input($cID) . "'");
      $status = vam_db_fetch_array($status_query);

      $remove_status = true;
      if (($cID == DEFAULT_CUSTOMERS_STATUS_ID) || ($cID == DEFAULT_CUSTOMERS_STATUS_ID_GUEST) || ($cID == DEFAULT_CUSTOMERS_STATUS_ID_NEWSLETTER)) {
        $remove_status = false;
        $messageStack->add(ERROR_REMOVE_DEFAULT_CUSTOMERS_STATUS, 'error');
      } elseif ($status['count'] > 0) {
        $remove_status = false;
        $messageStack->add(ERROR_STATUS_USED_IN_CUSTOMERS, 'error');
      } else {
        $history_query = vam_db_query("select count(*) as count from " . TABLE_CUSTOMERS_STATUS_HISTORY . " where '" . vam_db_input($cID) . "' in (new_value, old_value)");
        $history = vam_db_fetch_array($history_query);
        if ($history['count'] > 0) {
          // delete from history
          vam_db_query("DELETE FROM " . TABLE_CUSTOMERS_STATUS_HISTORY . "
                        where '" . vam_db_input($cID) . "' in (new_value, old_value)");
          $remove_status = true;
          // $messageStack->add(ERROR_STATUS_USED_IN_HISTORY, 'error');
        }
      }
      break;
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
<?php 
$manufacturers_array = array (array ('id' => '', 'text' => TEXT_TOP));
$manufacturers_query = vam_db_query("select manufacturers_id, manufacturers_name from ".TABLE_MANUFACTURERS." order by manufacturers_name");
while ($manufacturers = vam_db_fetch_array($manufacturers_query)) {
        $manufacturers_array[] = array ('id' => $manufacturers['manufacturers_id'], 'text' => $manufacturers['manufacturers_name']);
}
?>
<script type="text/javascript"><!--
function clearCat(n) {
  var this_subcat_id = eval("document.status.subcat_" + n + "_id");
  var this_subcat_name = eval("document.status.subcat_" + n + "_name");
  var this_subcat_qty = eval("document.status.subcat_" + n + "_qty");
  var this_subcat_link = eval("document.getElementById('subcat_" + n + "_link')");
  this_subcat_id.remove();
  //this_subcat_name.style.display = "none";
  this_subcat_qty.remove();
  this_subcat_link.remove();
}

function addCat(){
  var n = parseInt(document.getElementById('categories_i').value);
  var HTML = document.getElementById('categories');
  currentElement = document.createElement("input");
  //currentElement.setAttribute("disabled","");
  //currentElement.setAttribute("size","30");
  //currentElement.setAttribute("type", "text");
  //currentElement.setAttribute("name", 'subcat_' + n + '_name');
  //currentElement.setAttribute("value", "");
  //HTML.appendChild(currentElement);
  currentElement = document.createElement("select");
  //currentElement.setAttribute("size","3");
  currentElement.setAttribute("class","form-control noselect2");
  //currentElement.setAttribute("type", "text");
  currentElement.setAttribute("placeholder", "<?php echo TEXT_SELECT_CATEGORY; ?>");
  currentElement.setAttribute("name", 'subcat_' + n + '_id');
  currentElement.setAttribute("id", 'subcat_' + n + '_id');

  var this_subcat_id = eval("document.status.subcat_" + n + "_id");
  var url = JSON.parse('<?php echo json_encode(vam_get_category_tree(), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICOD);?>');

    // empty select
    currentElement.options.length = 0;

    var ele = currentElement;
    for (var i = 0; i < url.length; i++) {
        // populate select element with json
        ele.innerHTML = ele.innerHTML +
            '<option value="' + url[i]['id'] + '">' + url[i]['text'] + '</option>';
    }  
    

  //currentElement.setAttribute("value", "");
  HTML.appendChild(currentElement);
  currentElement = document.createTextNode(' ');
  HTML.appendChild(currentElement);
  currentElement = document.createElement("input");
  //currentElement.setAttribute("size","3");
  currentElement.setAttribute("class","form-control noselect2");
  currentElement.setAttribute("type", "text");
  currentElement.setAttribute("placeholder", "<?php echo TEXT_SELECT_DISCOUNT; ?>");
  currentElement.setAttribute("name", 'subcat_' + n + '_qty');
  currentElement.setAttribute("value", "");
  HTML.appendChild(currentElement);
  //document.createTextNode('&nbsp;');
  HTML.appendChild(currentElement);
  var myLink = document.createElement('a');
  var href = document.createAttribute('href');
  myLink.setAttribute('id','subcat_' + n + '_link');
  myLink.setAttribute('href','javascript:');
  myLink.setAttribute('onclick', 'clearCat(' + n + ')');
  <?php echo "myLink.innerText = ' [x] " . TEXT_REMOVE_PRODUCT . "';\n"; ?>
  //currentElement = document.createElement("br");
  HTML.appendChild(currentElement);
  HTML.appendChild(myLink);
  document.getElementById('categories_i').value = n + 1;
}


function clearBrand(n) {
  var this_brand_id = eval("document.status.brand_" + n + "_id");
  var this_brand_name = eval("document.status.brand_" + n + "_name");
  var this_brand_qty = eval("document.status.brand_" + n + "_qty");
  var this_brand_link = eval("document.getElementById('brand_" + n + "_link')");
  this_brand_id.remove();
  //this_brand_name.style.display = "none";
  this_brand_qty.remove();
  this_brand_link.remove();
}

function addBrand(){
  var n = parseInt(document.getElementById('brands_i').value);
  var HTML = document.getElementById('brands');
  currentElement = document.createElement("input");
  //currentElement.setAttribute("disabled","");
  //currentElement.setAttribute("size","30");
  //currentElement.setAttribute("type", "text");
  //currentElement.setAttribute("name", 'brand_' + n + '_name');
  //currentElement.setAttribute("value", "");
  //HTML.appendChild(currentElement);
  currentElement = document.createElement("select");
  //currentElement.setAttribute("size","3");
  currentElement.setAttribute("class","form-control noselect2");
  //currentElement.setAttribute("type", "text");
  currentElement.setAttribute("placeholder", "<?php echo TEXT_SELECT_BRAND; ?>");
  currentElement.setAttribute("name", 'brand_' + n + '_id');
  currentElement.setAttribute("id", 'brand_' + n + '_id');

  var this_brand_id = eval("document.status.brand_" + n + "_id");
  var url = JSON.parse('<?php echo json_encode($manufacturers_array, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICOD);?>');

    // empty select
    currentElement.options.length = 0;

    var ele = currentElement;
    for (var i = 0; i < url.length; i++) {
        // populate select element with json
        ele.innerHTML = ele.innerHTML +
            '<option value="' + url[i]['id'] + '">' + url[i]['text'] + '</option>';
    }  
    

  //currentElement.setAttribute("value", "");
  HTML.appendChild(currentElement);
  currentElement = document.createTextNode(' ');
  HTML.appendChild(currentElement);
  currentElement = document.createElement("input");
  //currentElement.setAttribute("size","3");
  currentElement.setAttribute("class","form-control noselect2");
  currentElement.setAttribute("type", "text");
  currentElement.setAttribute("placeholder", "<?php echo TEXT_SELECT_DISCOUNT; ?>");
  currentElement.setAttribute("name", 'brand_' + n + '_qty');
  currentElement.setAttribute("value", "");
  HTML.appendChild(currentElement);
  //document.createTextNode('&nbsp;');
  HTML.appendChild(currentElement);
  var myLink = document.createElement('a');
  var href = document.createAttribute('href');
  myLink.setAttribute('id','brand_' + n + '_link');
  myLink.setAttribute('href','javascript:');
  myLink.setAttribute('onclick', 'clearBrand(' + n + ')');
  <?php echo "myLink.innerText = ' [x] " . TEXT_REMOVE_PRODUCT . "';\n"; ?>
  //currentElement = document.createElement("br");
  HTML.appendChild(currentElement);
  HTML.appendChild(myLink);
  document.getElementById('brands_i').value = n + 1;
}


            //--></script>
            
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
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
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" align="left" width=""><?php echo TABLE_HEADING_ICON; ?></td>
                <td class="dataTableHeadingContent" align="left" width=""><?php echo TABLE_HEADING_USERS; ?></td>
                <td class="dataTableHeadingContent" align="left" width=""><?php echo TABLE_HEADING_CUSTOMERS_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="center" width=""><?php echo TABLE_HEADING_TAX_PRICE; ?></td>
                <td class="dataTableHeadingContent" align="center" colspan="2"><?php echo TABLE_HEADING_DISCOUNT; ?></td>
                <td class="dataTableHeadingContent" width=""><?php echo TABLE_HEADING_CUSTOMERS_GRADUATED; ?></td>
<!--
                <td class="dataTableHeadingContent" width=""><?php echo TABLE_HEADING_CUSTOMERS_UNALLOW; ?></td>
                <td class="dataTableHeadingContent" width=""><?php echo TABLE_HEADING_CUSTOMERS_UNALLOW_SHIPPING; ?></td>
-->
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $customers_status_ot_discount_flag_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_graduated_prices_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_public_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_show_price_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_show_price_tax_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_discount_attributes_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_add_tax_ot_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_fsk18_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_fsk18_display_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_write_reviews_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_read_reviews_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));

  $customers_status_discount_by_category_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));
  $customers_status_discount_by_brand_array = array(array('id' => '0', 'text' => ENTRY_NO), array('id' => '1', 'text' => ENTRY_YES));

  $customers_status_query_raw = "select * from " . TABLE_CUSTOMERS_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "' order by customers_status_id";

  $customers_status_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $customers_status_query_raw, $customers_status_query_numrows);
  $customers_status_query = vam_db_query($customers_status_query_raw);
  while ($customers_status = vam_db_fetch_array($customers_status_query)) {
    if (((!$_GET['cID']) || ($_GET['cID'] == $customers_status['customers_status_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $cInfo = new objectInfo($customers_status);
    }
    
    if ( (is_object($cInfo)) && ($customers_status['customers_status_id'] == $cInfo->customers_status_id) ) {
      echo '<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $customers_status['customers_status_id']) . '\'">' . "\n";
    }

    echo '<td class="dataTableContent" align="left">';
     if ($customers_status['customers_status_image'] != '') {
       echo vam_image(DIR_WS_CATALOG_IMAGES . 'icons/' . $customers_status['customers_status_image'] , IMAGE_ICON_INFO);
     }
     echo '</td>';

     echo '<td class="dataTableContent" align="left">';
     echo vam_get_status_users($customers_status['customers_status_id']);
     echo '</td>';

    if ($customers_status['customers_status_id'] == DEFAULT_CUSTOMERS_STATUS_ID ) {
      echo '<td class="dataTableContent" align="left"><b>' . $customers_status['customers_status_name'];
      echo ' (' . TEXT_DEFAULT . ')';
    } else {
      echo '<td class="dataTableContent" align="left">' . $customers_status['customers_status_name'];
    }
    if ($customers_status['customers_status_public'] == '1') {
      echo TEXT_PUBLIC;
    }
    echo '</b></td>';

    if ($customers_status['customers_status_show_price'] == '1') {
      echo '<td nowrap class="dataTableContent" align="center">' . YES . ' / ';
      if ($customers_status['customers_status_show_price_tax'] == '1') {
        echo TAX_YES;
      } else {
        echo TAX_NO;
      }
    } else {
      echo '<td class="dataTableContent" align="left"> ';
    }
    echo '</td>';

    echo '<td nowrap class="dataTableContent" align="center">' . $customers_status['customers_status_discount'] . ' %</td>';
      
    echo '<td nowrap class="dataTableContent" align="center">';
    if ($customers_status['customers_status_ot_discount_flag'] == 0){
      echo '<font color="ff0000">'.$customers_status['customers_status_ot_discount'].' %</font>';
    } else {
      echo $customers_status['customers_status_ot_discount'].' %';
    }
    echo ' </td>';
  
    echo '<td class="dataTableContent" align="center">';
    if ($customers_status['customers_status_graduated_prices'] == 0) {
      echo NO;
    } else {
      echo YES;
    }
    echo '</td>';
    echo '<!--<td nowrap class="dataTableContent" align="center">' . $customers_status['customers_status_payment_unallowed'] . '&nbsp;</td>';
    echo '<td nowrap class="dataTableContent" align="center">' . $customers_status['customers_status_shipping_unallowed'] . '&nbsp;</td>-->';
    echo "\n";
?>
                <td class="dataTableContent" align="right"><?php if ( (is_object($cInfo)) && ($customers_status['customers_status_id'] == $cInfo->customers_status_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $customers_status['customers_status_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="10"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $customers_status_split->display_count($customers_status_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CUSTOMERS_STATUS); ?></td>
                    <td class="smallText" align="right"><?php echo $customers_status_split->display_links($customers_status_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (substr($_GET['action'], 0, 3) != 'new') {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?></td>
                  </tr>
<?php
  }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  
    // BOF Discount Categories
    $categories_array = array();
    if (is_object($cInfo) && $cInfo->customers_status_discount_by_category == "1") {
      $categories_query = vam_db_query("SELECT cs2c.categories_id, cs2c.discount, cd.categories_name FROM " . TABLE_CATEGORIES_DESCRIPTION . " cd INNER JOIN " . TABLE_CUSTOMERS_STATUS_TO_CATEGORIES . " cs2c ON cs2c.categories_id=cd.categories_id WHERE cs2c.customers_status_id = '" . (int)$_GET['cID'] . "'");
      while ($categories_contents = vam_db_fetch_array($categories_query)) {
        $categories_array[] = array('id' => $categories_contents['categories_id'],
                                'discount' => $categories_contents['discount'],
                                'name' => $categories_contents['categories_name']);
      }
    }
    $categories_count = count($categories_array);
    //echo var_dump($categories_array);
    //echo var_dump($categories_count);
    // EOF Discount Categories  

    // BOF Discount Brands
    $brands_array = array();
    if (is_object($cInfo) && $cInfo->customers_status_discount_by_brand == "1") {
      $brands_query = vam_db_query("SELECT cs2m.manufacturers_id, cs2m.discount, m.manufacturers_name FROM " . TABLE_MANUFACTURERS . " m INNER JOIN " . TABLE_CUSTOMERS_STATUS_TO_MANUFACTURERS . " cs2m ON cs2m.manufacturers_id=m.manufacturers_id WHERE cs2m.customers_status_id = '" . (int)$_GET['cID'] . "'");
      while ($brands_contents = vam_db_fetch_array($brands_query)) {
        $brands_array[] = array('id' => $brands_contents['manufacturers_id'],
                                'discount' => $brands_contents['discount'],
                                'name' => $brands_contents['manufacturers_name']);
      }
    }
    $brands_count = count($brands_array);
    //echo var_dump($brands_array);
    //echo var_dump($brands_count);
    // EOF Discount Brands  
  
  switch ($_GET['action']) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_CUSTOMERS_STATUS . '</b>');
      $contents = array('form' => vam_draw_form('status', FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
      $customers_status_inputs_string = '';
      $languages = vam_get_languages();
      for ($i=0; $i<sizeof($languages); $i++) {
        $customers_status_inputs_string .= '<br />' . vam_image(DIR_WS_CATALOG.'lang/'.$languages[$i]['directory'].'/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . vam_draw_input_field('customers_status_name[' . $languages[$i]['id'] . ']');
      }
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_NAME . $customers_status_inputs_string);
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_IMAGE . '<br />' . vam_draw_file_field('customers_status_image'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_PUBLIC_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_PUBLIC . ' ' . vam_draw_pull_down_menu('customers_status_public', $customers_status_public_array, $cInfo->customers_status_public ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_MIN_ORDER_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_MIN_ORDER . ' ' . vam_draw_input_field('customers_status_min_order', $cInfo->customers_status_min_order ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_MAX_ORDER_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_MAX_ORDER . ' ' . vam_draw_input_field('customers_status_max_order', $cInfo->customers_status_max_order ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_INTRO     . '<br />' . ENTRY_CUSTOMERS_STATUS_SHOW_PRICE . ' ' . vam_draw_pull_down_menu('customers_status_show_price', $customers_status_show_price_array, $cInfo->customers_status_show_price ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_TAX_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_SHOW_PRICE_TAX . ' ' . vam_draw_pull_down_menu('customers_status_show_price_tax', $customers_status_show_price_tax_array, $cInfo->customers_status_show_price_tax ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_ADD_TAX_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_ADD_TAX . ' ' . vam_draw_pull_down_menu('customers_status_add_tax_ot', $customers_status_add_tax_ot_array, $cInfo->customers_status_add_tax_ot));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE_INTRO . '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . '<br />' . vam_draw_input_field('customers_status_discount', $cInfo->customers_status_discount));

      $contents[] = array('text' => '<br />' . TEXT_ATTACH_TO_CATEGORIES . '<br />' . vam_draw_pull_down_menu('customers_status_discount_by_category', $customers_status_discount_by_category_array, $cInfo->customers_status_discount_by_category));

    for ($i=0, $n = $categories_count ? $categories_count+1 : 3; $i<$n; $i++) {
      //$fields .= '<input type="text" size="30" name="subcat_' . $i . '_name" value="' . (isset($categories_array[$i]['name']) ? vam_output_string($categories_array[$i]['name']) : '') . '">' . "\n";
      //$fields .= '<input class="form-control" type="text" placeholder="'.TEXT_SELECT_CATEGORY.'" name="subcat_' . $i . '_id" value="' . (isset($categories_array[$i]['id']) ? $categories_array[$i]['id'] : '') . '">' . "\n";
      $fields .= vam_draw_pull_down_menu('subcat_' . $i . '_id', vam_get_category_tree(), (isset($categories_array[$i]['id']) ? $categories_array[$i]['id'] : ''), 'class="noselect2" data-placeholder="'.TEXT_SELECT_CATEGORY.'"') . "\n";
      $fields .= '<input class="form-control" type="text" placeholder="'.TEXT_SELECT_DISCOUNT.'" name="subcat_' . $i . '_qty" value="' . (isset($categories_array[$i]['id']) ? $categories_array[$i]['discount'] : '') . '">' . "\n";
      $fields .= '<br />';
    }

      $contents[] = array('text' => $fields);

      $contents[] = array('text' => vam_draw_hidden_field('categories_i', $i,'id="categories_i"').'<div id="categories">');
      $contents[] = array('text' => '</div>');
                   
      $contents[] = array('text' => '<a href="javascript:" onclick="addCat()">' . TEXT_ADD_LINE . '</a><br />');

      $contents[] = array('text' => '<br />' . TEXT_ATTACH_TO_MANUFACTURERS . '<br />' . vam_draw_pull_down_menu('customers_status_discount_by_brand', $customers_status_discount_by_brand_array, $cInfo->customers_status_discount_by_brand));
     
    for ($i=0, $n = $brands_count ? $brands_count+1 : 3; $i<$n; $i++) {
      //$fields_brands .= '<input type="text" size="30" name="brand_' . $i . '_name" value="' . (isset($brands_array[$i]['name']) ? vam_output_string($brands_array[$i]['name']) : '') . '">' . "\n";
      //$fields_brands .= '<input class="form-control" type="text" placeholder="'.TEXT_SELECT_BRAND.'" name="brand_' . $i . '_id" value="' . (isset($brands_array[$i]['id']) ? $brands_array[$i]['id'] : '') . '">' . "\n";
      $fields_brands .= vam_draw_pull_down_menu('brand_' . $i . '_id', $manufacturers_array, (isset($brands_array[$i]['id']) ? $brands_array[$i]['id'] : ''), 'class="noselect2" data-placeholder="'.TEXT_SELECT_BRAND.'"') . "\n";
      $fields_brands .= '<input class="form-control" type="text" placeholder="'.TEXT_SELECT_DISCOUNT.'" name="brand_' . $i . '_qty" value="' . (isset($brands_array[$i]['id']) ? $brands_array[$i]['discount'] : '') . '">' . "\n";
      $fields_brands .= '<br />';
    }

      $contents[] = array('text' => $fields_brands);

      $contents[] = array('text' => vam_draw_hidden_field('brands_i', $i,'id="brands_i"').'<div id="brands">');
      $contents[] = array('text' => '</div>');
                   
      $contents[] = array('text' => '<a href="javascript:" onclick="addBrand()">' . TEXT_ADD_BRAND . '</a><br />');
      
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES_INTRO     . '<br />' . ENTRY_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES . ' ' . vam_draw_pull_down_menu('customers_status_discount_attributes', $customers_status_discount_attributes_array, $cInfo->customers_status_discount_attributes ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_OT_XMEMBER_INTRO . '<br /> ' . ENTRY_OT_XMEMBER . ' ' . vam_draw_pull_down_menu('customers_status_ot_discount_flag', $customers_status_ot_discount_flag_array, $cInfo->customers_status_ot_discount_flag ). '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . '<br />' . vam_draw_input_field('customers_status_ot_discount', $cInfo->customers_status_ot_discount));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_GRADUATED_PRICES_INTRO . '<br />' . ENTRY_GRADUATED_PRICES . ' ' . vam_draw_pull_down_menu('customers_status_graduated_prices', $customers_status_graduated_prices_array, $cInfo->customers_status_graduated_prices ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES . ' ' . vam_draw_pull_down_menu('customers_status_discount_attributes', $customers_status_discount_attributes_array, $cInfo->customers_status_discount_attributes ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_PAYMENT_UNALLOWED_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_PAYMENT_UNALLOWED . ' ' . vam_draw_input_field('customers_status_payment_unallowed', $cInfo->customers_status_payment_unallowed ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_SHIPPING_UNALLOWED_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_SHIPPING_UNALLOWED . ' ' . vam_draw_input_field('customers_status_shipping_unallowed', $cInfo->customers_status_shipping_unallowed ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_FSK18_INTRO . '<br />' . ENTRY_CUSTOMERS_FSK18 . ' ' . vam_draw_pull_down_menu('customers_fsk18', $customers_fsk18_array, $cInfo->customers_fsk18));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_FSK18_DISPLAY_INTRO . '<br />' . ENTRY_CUSTOMERS_FSK18_DISPLAY . ' ' . vam_draw_pull_down_menu('customers_fsk18_display', $customers_fsk18_display_array, $cInfo->customers_fsk18_display));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_WRITE_REVIEWS_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_WRITE_REVIEWS . ' ' . vam_draw_pull_down_menu('customers_status_write_reviews', $customers_status_write_reviews_array, $cInfo->customers_status_write_reviews));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_READ_REVIEWS_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_READ_REVIEWS_DISPLAY . ' ' . vam_draw_pull_down_menu('customers_status_read_reviews', $customers_status_read_reviews_array, $cInfo->customers_status_read_reviews));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_ACCUMULATED_LIMIT_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_ACCUMULATED_LIMIT_DISPLAY . ' ' . vam_draw_input_field('customers_status_accumulated_limit', $cInfo->customers_status_accumulated_limit));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_ORDERS_STATUS_INTRO . '<br />' . TEXT_INFO_CUSTOMERS_STATUS_ORDERS_STATUS_DISPLAY);

  $orders_status_query = vam_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = " . $_SESSION['languages_id'] . " order by orders_status_id");
  while ($orders_status = vam_db_fetch_array($orders_status_query)) {

      $contents[] = array('text' => '<input type="checkbox" name="orders_status_' . $orders_status['orders_status_id'] . '" value="1">' . $orders_status['orders_status_name'] . '<br />');

}
   
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_BASE . '<br />' . ENTRY_CUSTOMERS_STATUS_BASE . '<br />' . vam_draw_pull_down_menu('customers_base_status', vam_get_customers_statuses()));
      $contents[] = array('text' => '<br />' . vam_draw_checkbox_field('default','no',false) . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CUSTOMERS_STATUS . '</b>');
      $contents = array('form' => vam_draw_form('status', FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id  .'&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $customers_status_inputs_string = '';
      $languages = vam_get_languages();
      for ($i=0; $i<sizeof($languages); $i++) {
        $customers_status_inputs_string .= '<br />' . vam_image(DIR_WS_CATALOG.'lang/'.$languages[$i]['directory'].'/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . vam_draw_input_field('customers_status_name[' . $languages[$i]['id'] . ']', vam_get_customers_status_name($cInfo->customers_status_id, $languages[$i]['id']));
      }
	  
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_NAME . $customers_status_inputs_string);
      $contents[] = array('text' => '<br />' . vam_image(DIR_WS_CATALOG_IMAGES . 'icons/' . $cInfo->customers_status_image, $cInfo->customers_status_name) . '<br />' . DIR_WS_CATALOG_IMAGES . 'icons/' . '<br /><b>' . $cInfo->customers_status_image . '</b>');
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_IMAGE . '<br />' . vam_draw_file_field('customers_status_image', $cInfo->customers_status_image));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_PUBLIC_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_PUBLIC . ' ' . vam_draw_pull_down_menu('customers_status_public', $customers_status_public_array, $cInfo->customers_status_public ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_MIN_ORDER_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_MIN_ORDER . ' ' . vam_draw_input_field('customers_status_min_order', $cInfo->customers_status_min_order ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_MAX_ORDER_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_MAX_ORDER . ' ' . vam_draw_input_field('customers_status_max_order', $cInfo->customers_status_max_order )); 
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_INTRO     . '<br />' . ENTRY_CUSTOMERS_STATUS_SHOW_PRICE . ' ' . vam_draw_pull_down_menu('customers_status_show_price', $customers_status_show_price_array, $cInfo->customers_status_show_price ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_TAX_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_SHOW_PRICE_TAX . ' ' . vam_draw_pull_down_menu('customers_status_show_price_tax', $customers_status_show_price_tax_array, $cInfo->customers_status_show_price_tax ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_ADD_TAX_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_ADD_TAX . ' ' . vam_draw_pull_down_menu('customers_status_add_tax_ot', $customers_status_add_tax_ot_array, $cInfo->customers_status_add_tax_ot));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE_INTRO . '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . ' ' . vam_draw_input_field('customers_status_discount', $cInfo->customers_status_discount));

      $contents[] = array('text' => '<br />' . TEXT_ATTACH_TO_CATEGORIES . '<br />' . vam_draw_pull_down_menu('customers_status_discount_by_category', $customers_status_discount_by_category_array, $cInfo->customers_status_discount_by_category));

    for ($i=0, $n = $categories_count ? $categories_count+1 : 3; $i<$n; $i++) {
      //$fields .= '<input type="text" size="30" name="subcat_' . $i . '_name" value="' . (isset($categories_array[$i]['name']) ? vam_output_string($categories_array[$i]['name']) : '') . '">' . "\n";
      //$fields .= '<input class="form-control" type="text" placeholder="'.TEXT_SELECT_CATEGORY.'" name="subcat_' . $i . '_id" value="' . (isset($categories_array[$i]['id']) ? $categories_array[$i]['id'] : '') . '">' . "\n";
      $fields .= vam_draw_pull_down_menu('subcat_' . $i . '_id', vam_get_category_tree(), (isset($categories_array[$i]['id']) ? $categories_array[$i]['id'] : ''), 'class="noselect2" data-placeholder="'.TEXT_SELECT_CATEGORY.'"') . "\n";
      $fields .= '<input class="form-control" type="text" placeholder="'.TEXT_SELECT_DISCOUNT.'" name="subcat_' . $i . '_qty" value="' . (isset($categories_array[$i]['id']) ? $categories_array[$i]['discount'] : '') . '">' . "\n";
      $fields .= '<br />';
    }
    
      $contents[] = array('text' => $fields);

      $contents[] = array('text' => vam_draw_hidden_field('categories_i', $i,'id="categories_i"').'<div id="categories">');
      $contents[] = array('text' => '</div>');
                   
      $contents[] = array('text' => '<a href="javascript:" onclick="addCat()">' . TEXT_ADD_LINE . '</a><br />');

      $contents[] = array('text' => '<br />' . TEXT_ATTACH_TO_MANUFACTURERS . '<br />' . vam_draw_pull_down_menu('customers_status_discount_by_brand', $customers_status_discount_by_brand_array, $cInfo->customers_status_discount_by_brand));
      
    for ($i=0, $n = $brands_count ? $brands_count+1 : 3; $i<$n; $i++) {
      //$fields_brands .= '<input type="text" size="30" name="brand_' . $i . '_name" value="' . (isset($brands_array[$i]['name']) ? vam_output_string($brands_array[$i]['name']) : '') . '">' . "\n";
      //$fields_brands .= '<input class="form-control" type="text" placeholder="'.TEXT_SELECT_BRAND.'" name="brand_' . $i . '_id" value="' . (isset($brands_array[$i]['id']) ? $brands_array[$i]['id'] : '') . '">' . "\n";
      $fields_brands .= vam_draw_pull_down_menu('brand_' . $i . '_id', $manufacturers_array, (isset($brands_array[$i]['id']) ? $brands_array[$i]['id'] : ''), 'class="noselect2" data-placeholder="'.TEXT_SELECT_BRAND.'"') . "\n";
      $fields_brands .= '<input class="form-control" type="text" placeholder="'.TEXT_SELECT_DISCOUNT.'" name="brand_' . $i . '_qty" value="' . (isset($brands_array[$i]['id']) ? $brands_array[$i]['discount'] : '') . '">' . "\n";
      $fields_brands .= '<br />';
    }

      $contents[] = array('text' => $fields_brands);

      $contents[] = array('text' => vam_draw_hidden_field('brands_i', $i,'id="brands_i"').'<div id="brands">');
      $contents[] = array('text' => '</div>');
                   
      $contents[] = array('text' => '<a href="javascript:" onclick="addBrand()">' . TEXT_ADD_BRAND . '</a><br />');
      
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES . ' ' . vam_draw_pull_down_menu('customers_status_discount_attributes', $customers_status_discount_attributes_array, $cInfo->customers_status_discount_attributes ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_OT_XMEMBER_INTRO . '<br /> ' . ENTRY_OT_XMEMBER . ' ' . vam_draw_pull_down_menu('customers_status_ot_discount_flag', $customers_status_ot_discount_flag_array, $cInfo->customers_status_ot_discount_flag). '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . ' ' . vam_draw_input_field('customers_status_ot_discount', $cInfo->customers_status_ot_discount));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_GRADUATED_PRICES_INTRO . '<br />' . ENTRY_GRADUATED_PRICES . ' ' . vam_draw_pull_down_menu('customers_status_graduated_prices', $customers_status_graduated_prices_array, $cInfo->customers_status_graduated_prices));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_PAYMENT_UNALLOWED_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_PAYMENT_UNALLOWED . ' ' . vam_draw_input_field('customers_status_payment_unallowed', $cInfo->customers_status_payment_unallowed ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_SHIPPING_UNALLOWED_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_SHIPPING_UNALLOWED . ' ' . vam_draw_input_field('customers_status_shipping_unallowed', $cInfo->customers_status_shipping_unallowed ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_FSK18_INTRO . '<br />' . ENTRY_CUSTOMERS_FSK18 . ' ' . vam_draw_pull_down_menu('customers_fsk18', $customers_fsk18_array, $cInfo->customers_fsk18 ));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_FSK18_DISPLAY_INTRO . '<br />' . ENTRY_CUSTOMERS_FSK18_DISPLAY . ' ' . vam_draw_pull_down_menu('customers_fsk18_display', $customers_fsk18_display_array, $cInfo->customers_fsk18_display));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_WRITE_REVIEWS_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_WRITE_REVIEWS . ' ' . vam_draw_pull_down_menu('customers_status_write_reviews', $customers_status_write_reviews_array, $cInfo->customers_status_write_reviews));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_READ_REVIEWS_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_READ_REVIEWS . ' ' . vam_draw_pull_down_menu('customers_status_read_reviews', $customers_status_read_reviews_array, $cInfo->customers_status_read_reviews));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_ACCUMULATED_LIMIT_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_ACCUMULATED_LIMIT_DISPLAY . ' ' . vam_draw_input_field('customers_status_accumulated_limit', $cInfo->customers_status_accumulated_limit));

      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_ORDERS_STATUS_INTRO . '<br />' . TEXT_INFO_CUSTOMERS_STATUS_ORDERS_STATUS_DISPLAY);

  $orders_status_query = vam_db_query("select * from " . TABLE_ORDERS_STATUS . " where language_id = " . $_SESSION['languages_id'] . " order by orders_status_id");
  while ($orders_status = vam_db_fetch_array($orders_status_query)) {
    $check_status_query = vam_db_query("select orders_status_id from " . TABLE_CUSTOMERS_STATUS_ORDERS_STATUS . " where customers_status_id = " . $cInfo->customers_status_id . " and orders_status_id = " . $orders_status['orders_status_id']);
    if (vam_db_num_rows($check_status_query)) {
      $selected = 'checked';
    } else {
      $selected = '';
    }

      $contents[] = array('text' => '<input type="checkbox" name="orders_status_' . $orders_status['orders_status_id'] . '" value="1" ' . $selected . '>' . $orders_status['orders_status_name'] . '<br />');

}

      if (DEFAULT_CUSTOMERS_STATUS_ID != $cInfo->customers_status_id) $contents[] = array('text' => '<br />' . vam_draw_checkbox_field('default','no',false) . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CUSTOMERS_STATUS . '</b>');

      $contents = array('form' => vam_draw_form('status', FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id  . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $cInfo->customers_status_name . '</b>');

      if ($remove_status) $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    default:
      if (is_object($cInfo)) {
        $heading[] = array('text' => '<b>' . $cInfo->customers_status_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_CUSTOMERS_STATUS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');
        $customers_status_inputs_string = '';
        $languages = vam_get_languages();
        for ($i=0; $i<sizeof($languages); $i++) {
          $customers_status_inputs_string .= '<br />' . vam_image(DIR_WS_CATALOG.'lang/'. $languages[$i]['directory'] . '/admin/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . vam_get_customers_status_name($cInfo->customers_status_id, $languages[$i]['id']);
        }
        $contents[] = array('text' => $customers_status_inputs_string);
        $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE_INTRO . '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . ' ' . $cInfo->customers_status_discount . '%');
        $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_OT_XMEMBER_INTRO . '<br />' . ENTRY_OT_XMEMBER . ' ' . $customers_status_ot_discount_flag_array[$cInfo->customers_status_ot_discount_flag]['text'] . ' (' . $cInfo->customers_status_ot_discount_flag . ')' . ' - ' . $cInfo->customers_status_ot_discount . '%');
        $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_GRADUATED_PRICES_INTRO . '<br />' . ENTRY_GRADUATED_PRICES . ' ' . $customers_status_graduated_prices_array[$cInfo->customers_status_graduated_prices]['text'] . ' (' . $cInfo->customers_status_graduated_prices . ')' );
        $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_DISCOUNT_ATTRIBUTES . ' ' . $customers_status_discount_attributes_array[$cInfo->customers_status_discount_attributes]['text'] . ' (' . $cInfo->customers_status_discount_attributes . ')' );
        $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_BY_CATEGORY_INTRO . '<br />' . $customers_status_discount_by_category_array[$cInfo->customers_status_discount_by_category]['text'] );
        $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_BY_BRAND_INTRO . '<br />' . $customers_status_discount_by_brand_array[$cInfo->customers_status_discount_by_brand]['text'] );
        $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_PAYMENT_UNALLOWED_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_PAYMENT_UNALLOWED . ':<b> ' . $cInfo->customers_status_payment_unallowed.'</b>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_SHIPPING_UNALLOWED_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_SHIPPING_UNALLOWED . ':<b> ' . $cInfo->customers_status_shipping_unallowed.'</b>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_ACCUMULATED_LIMIT_INTRO . '<br />' . ENTRY_CUSTOMERS_STATUS_ACCUMULATED_LIMIT_DISPLAY . ':<b> ' . $cInfo->customers_status_accumulated_limit.'</b>');
      }
      break;
  }

  if ( (vam_not_null($heading)) && (vam_not_null($contents)) ) {
    echo '<td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '</td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
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
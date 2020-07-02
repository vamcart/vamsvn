<?php
/* --------------------------------------------------------------
   $Id: languages.php 1180 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(languages.php,v 1.33 2003/05/07); www.oscommerce.com 
   (c) 2003	 nextcommerce (languages.php,v 1.10 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (languages.php,v 1.10 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  switch ($_GET['action']) {
    case 'insert':
      $name = vam_db_prepare_input($_POST['name']);
      $code = vam_db_prepare_input($_POST['code']);
      $image = vam_db_prepare_input($_POST['image']);
      $directory = vam_db_prepare_input($_POST['directory']);
      $sort_order = vam_db_prepare_input($_POST['sort_order']);
      $charset = vam_db_prepare_input($_POST['charset']);

      vam_db_query("insert into " . TABLE_LANGUAGES . " (name, code, image, directory, sort_order,language_charset) values ('" . vam_db_input($name) . "', '" . vam_db_input($code) . "', '" . vam_db_input($image) . "', '" . vam_db_input($directory) . "', '" . vam_db_input($sort_order) . "', '" . vam_db_input($charset) . "')");
      $insert_id = vam_db_insert_id();

      // create additional categories_description records
      $categories_query = vam_db_query("select c.categories_id, cd.categories_name from " . TABLE_CATEGORIES . " c left join " . TABLE_CATEGORIES_DESCRIPTION . " cd on c.categories_id = cd.categories_id where cd.language_id = '" . $_SESSION['languages_id'] . "'");
      while ($categories = vam_db_fetch_array($categories_query)) {
        vam_db_query("insert into " . TABLE_CATEGORIES_DESCRIPTION . " (categories_id, language_id, categories_name) values ('" . $categories['categories_id'] . "', '" . $insert_id . "', '" . vam_db_input($categories['categories_name']) . "')");
      }

      // create additional products_description records
      $products_query = vam_db_query("select p.products_id, pd.products_name, pd.products_description, pd.products_url from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id where pd.language_id = '" . $_SESSION['languages_id'] . "'");
      while ($products = vam_db_fetch_array($products_query)) {
        vam_db_query("insert into " . TABLE_PRODUCTS_DESCRIPTION . " (products_id, language_id, products_name, products_description, products_url) values ('" . $products['products_id'] . "', '" . $insert_id . "', '" . vam_db_input($products['products_name']) . "', '" . vam_db_input($products['products_description']) . "', '" . vam_db_input($products['products_url']) . "')");
      }

      // create additional products_options records
      $products_options_query = vam_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . $_SESSION['languages_id'] . "'");
      while ($products_options = vam_db_fetch_array($products_options_query)) {
        vam_db_query("insert into " . TABLE_PRODUCTS_OPTIONS . " (products_options_id, language_id, products_options_name) values ('" . $products_options['products_options_id'] . "', '" . $insert_id . "', '" . vam_db_input($products_options['products_options_name']) . "')");
      }

      // create additional products_options_values records
      $products_options_values_query = vam_db_query("select products_options_values_id, products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where language_id = '" . $_SESSION['languages_id'] . "'");
      while ($products_options_values = vam_db_fetch_array($products_options_values_query)) {
        vam_db_query("insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name) values ('" . $products_options_values['products_options_values_id'] . "', '" . $insert_id . "', '" . vam_db_input($products_options_values['products_options_values_name']) . "')");
      }

      // create additional articles_description records
      $articles_query = vam_db_query("select a.articles_id, ad.articles_name from " . TABLE_ARTICLES . " a left join " . TABLE_ARTICLES_DESCRIPTION . " ad on a.articles_id = ad.articles_id where ad.language_id = '" . $_SESSION['languages_id'] . "'");
      while ($articles = vam_db_fetch_array($articles_query)) {
        vam_db_query("insert into " . TABLE_ARTICLES_DESCRIPTION . " (articles_id, language_id, articles_name) values ('" . $articles['articles_id'] . "', '" . $insert_id . "', '" . vam_db_input($articles['articles_name']) . "')");
      }

      // create additional topics_description records
      $topics_query = vam_db_query("select t.topics_id, td.topics_name from " . TABLE_TOPICS . " t left join " . TABLE_TOPICS_DESCRIPTION . " td on t.topics_id = td.topics_id where td.language_id = '" . $_SESSION['languages_id'] . "'");
      while ($topics = vam_db_fetch_array($topics_query)) {
        vam_db_query("insert into " . TABLE_TOPICS_DESCRIPTION . " (topics_id, language_id, topics_name) values ('" . $topics['topics_id'] . "', '" . $insert_id . "', '" . vam_db_input($topics['topics_name']) . "')");
      }

      // create additional manufacturers_info records
      $manufacturers_query = vam_db_query("select m.manufacturers_id, mi.manufacturers_url from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on m.manufacturers_id = mi.manufacturers_id where mi.languages_id = '" . $_SESSION['languages_id'] . "'");
      while ($manufacturers = vam_db_fetch_array($manufacturers_query)) {
        vam_db_query("insert into " . TABLE_MANUFACTURERS_INFO . " (manufacturers_id, languages_id, manufacturers_url) values ('" . $manufacturers['manufacturers_id'] . "', '" . $insert_id . "', '" . vam_db_input($manufacturers['manufacturers_url']) . "')");
      }

      // create additional orders_status records
      $orders_status_query = vam_db_query("select orders_status_id, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "'");
      while ($orders_status = vam_db_fetch_array($orders_status_query)) {
        vam_db_query("insert into " . TABLE_ORDERS_STATUS . " (orders_status_id, language_id, orders_status_name) values ('" . $orders_status['orders_status_id'] . "', '" . $insert_id . "', '" . vam_db_input($orders_status['orders_status_name']) . "')");
      }
      
      // create additional shipping_status records
      $shipping_status_query = vam_db_query("select shipping_status_id, shipping_status_name from " . TABLE_SHIPPING_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "'");
      while ($shipping_status = vam_db_fetch_array($shipping_status_query)) {
        vam_db_query("insert into " . TABLE_SHIPPING_STATUS . " (shipping_status_id, language_id, shipping_status_name) values ('" . $shipping_status['shipping_status_id'] . "', '" . $insert_id . "', '" . vam_db_input($shipping_status['shipping_status_name']) . "')");
      }
      
      // create additional orders_status records
      $xsell_grp_query = vam_db_query("select products_xsell_grp_name_id,xsell_sort_order, groupname from " . TABLE_PRODUCTS_XSELL_GROUPS . " where language_id = '" . $_SESSION['languages_id'] . "'");
      while ($xsell_grp = vam_db_fetch_array($xsell_grp_query)) {
        vam_db_query("insert into " . TABLE_PRODUCTS_XSELL_GROUPS . " (products_xsell_grp_name_id,xsell_sort_order, language_id, groupname) values ('" . $xsell_grp['products_xsell_grp_name_id'] . "','" . $xsell_grp['xsell_sort_order'] . "', '" . $insert_id . "', '" . vam_db_input($xsell_grp['groupname']) . "')");
      }
      
      // create additional customers status
            $customers_status_query=vam_db_query("SELECT DISTINCT customers_status_id 
      						FROM ".TABLE_CUSTOMERS_STATUS);
      while ($data=vam_db_fetch_array($customers_status_query)) {
 
      $customers_status_data_query=vam_db_query("SELECT * 
      						FROM ".TABLE_CUSTOMERS_STATUS."
      						WHERE customers_status_id='".$data['customers_status_id']."'"); 
      
      $group_data=vam_db_fetch_array($customers_status_data_query);
 	$c_data=array(
 		'customers_status_id'=>$data['customers_status_id'],
 		'language_id'=>$insert_id,
 		'customers_status_name'=>$group_data['customers_status_name'],
 		'customers_status_public'=>$group_data['customers_status_public'],
 		'customers_status_image'=>$group_data['customers_status_image'],
 		'customers_status_discount'=>$group_data['customers_status_discount'],
 		'customers_status_ot_discount_flag'=>$group_data['customers_status_ot_discount_flag'],
 		'customers_status_ot_discount'=>$group_data['customers_status_ot_discount'],
 		'customers_status_graduated_prices'=>$group_data['customers_status_graduated_prices'],
 		'customers_status_show_price'=>$group_data['customers_status_show_price'],
 		'customers_status_show_price_tax'=>$group_data['customers_status_show_price_tax'],
 		'customers_status_add_tax_ot'=>$group_data['customers_status_add_tax_ot'],
 		'customers_status_payment_unallowed'=>$group_data['customers_status_payment_unallowed'],
 		'customers_status_shipping_unallowed'=>$group_data['customers_status_shipping_unallowed'],
 		'customers_status_discount_attributes'=>$group_data['customers_status_discount_attributes']);  
 		
 	vam_db_perform(TABLE_CUSTOMERS_STATUS, $c_data);	    	
      	
	}

      if ($_POST['default'] == 'on') {
        vam_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . vam_db_input($code) . "' where configuration_key = 'DEFAULT_LANGUAGE'");
      }

      vam_redirect(vam_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $insert_id));
      break;

    case 'save':
      $lID = vam_db_prepare_input($_GET['lID']);
      $name = vam_db_prepare_input($_POST['name']);
      $code = vam_db_prepare_input($_POST['code']);
      $image = vam_db_prepare_input($_POST['image']);
      $directory = vam_db_prepare_input($_POST['directory']);
      $sort_order = vam_db_prepare_input($_POST['sort_order']);
     $charset = vam_db_prepare_input($_POST['charset']);
	  
      vam_db_query("update " . TABLE_LANGUAGES . " set name = '" . vam_db_input($name) . "', code = '" . vam_db_input($code) . "', image = '" . vam_db_input($image) . "', directory = '" . vam_db_input($directory) . "', sort_order = '" . vam_db_input($sort_order) . "', language_charset = '" . vam_db_input($charset) . "' where languages_id = '" . vam_db_input($lID) . "'");

      if ($_POST['default'] == 'on') {
        vam_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . vam_db_input($code) . "' where configuration_key = 'DEFAULT_LANGUAGE'");
      }

      vam_redirect(vam_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $_GET['lID']));
      break;

    case 'deleteconfirm':
      $lID = vam_db_prepare_input($_GET['lID']);

      $lng_query = vam_db_query("select languages_id from " . TABLE_LANGUAGES . " where code = '" . DEFAULT_CURRENCY . "'");
      $lng = vam_db_fetch_array($lng_query);
      if ($lng['languages_id'] == $lID) {
        vam_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '' where configuration_key = 'DEFAULT_CURRENCY'");
      }

      vam_db_query("delete from " . TABLE_CATEGORIES_DESCRIPTION . " where language_id = '" . vam_db_input($lID) . "'");
      vam_db_query("delete from " . TABLE_PRODUCTS_DESCRIPTION . " where language_id = '" . vam_db_input($lID) . "'");
      vam_db_query("delete from " . TABLE_PRODUCTS_OPTIONS . " where language_id = '" . vam_db_input($lID) . "'");
      vam_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where language_id = '" . vam_db_input($lID) . "'");
      vam_db_query("delete from " . TABLE_MANUFACTURERS_INFO . " where languages_id = '" . vam_db_input($lID) . "'");
      vam_db_query("delete from " . TABLE_ORDERS_STATUS . " where language_id = '" . vam_db_input($lID) . "'");
      vam_db_query("delete from " . TABLE_LANGUAGES . " where languages_id = '" . vam_db_input($lID) . "'");
      vam_db_query("delete from " . TABLE_CONTENT_MANAGER . " where languages_id = '" . vam_db_input($lID) . "'");
      vam_db_query("delete from " . TABLE_PRODUCTS_CONTENT . " where languages_id = '" . vam_db_input($lID) . "'");
      vam_db_query("delete from " . TABLE_CUSTOMERS_STATUS . " where language_id = '" . vam_db_input($lID) . "'");

      vam_redirect(vam_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page']));
      break;

    case 'delete':
      $lID = vam_db_prepare_input($_GET['lID']);

      $lng_query = vam_db_query("select code from " . TABLE_LANGUAGES . " where languages_id = '" . vam_db_input($lID) . "'");
      $lng = vam_db_fetch_array($lng_query);

      $remove_language = true;
      if ($lng['code'] == DEFAULT_LANGUAGE) {
        $remove_language = false;
        $messageStack->add(ERROR_REMOVE_DEFAULT_LANGUAGE, 'error');
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
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LANGUAGE_NAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LANGUAGE_CODE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $languages_query_raw = "select languages_id, name, code, image, directory, sort_order,language_charset from " . TABLE_LANGUAGES . " order by sort_order";
  $languages_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $languages_query_raw, $languages_query_numrows);
  $languages_query = vam_db_query($languages_query_raw);

  while ($languages = vam_db_fetch_array($languages_query)) {
    if (((!$_GET['lID']) || (@$_GET['lID'] == $languages['languages_id'])) && (!$lInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $lInfo = new objectInfo($languages);
    }

    if ( (is_object($lInfo)) && ($languages['languages_id'] == $lInfo->languages_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $languages['languages_id']) . '\'">' . "\n";
    }

    if (DEFAULT_LANGUAGE == $languages['code']) {
      echo '                <td class="dataTableContent"><b>' . $languages['name'] . ' (' . TEXT_DEFAULT . ')</b></td>' . "\n";
    } else {
      echo '                <td class="dataTableContent">' . $languages['name'] . '</td>' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $languages['code']; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($lInfo)) && ($languages['languages_id'] == $lInfo->languages_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . vam_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $languages['languages_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $languages_split->display_count($languages_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_LANGUAGES); ?></td>
                    <td class="smallText" align="right"><?php echo $languages_split->display_links($languages_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (!$_GET['action']) {
?>
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_LANGUAGE . '</span></a>'; ?></td>
                  </tr>
<?php
  }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $direction_options = array( array('id' => '', 'text' => TEXT_INFO_LANGUAGE_DIRECTION_DEFAULT),
                              array('id' => 'ltr', 'text' => TEXT_INFO_LANGUAGE_DIRECTION_LEFT_TO_RIGHT),
                              array('id' => 'rtl', 'text' => TEXT_INFO_LANGUAGE_DIRECTION_RIGHT_TO_LEFT));

  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_LANGUAGE . '</b>');

      $contents = array('form' => vam_draw_form('languages', FILENAME_LANGUAGES, 'action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_NAME . '<br />' . vam_draw_input_field('name'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_CODE . '<br />' . vam_draw_input_field('code'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_CHARSET . '<br />' . vam_draw_input_field('charset','utf-8'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_IMAGE . '<br />' . vam_draw_input_field('image', 'icon.gif'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_DIRECTORY . '<br />' . vam_draw_input_field('directory'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_SORT_ORDER . '<br />' . vam_draw_input_field('sort_order'));
      $contents[] = array('text' => '<br />' . vam_draw_checkbox_field('default','on',false) . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $_GET['lID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_LANGUAGE . '</b>');

      $contents = array('form' => vam_draw_form('languages', FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_NAME . '<br />' . vam_draw_input_field('name', $lInfo->name));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_CODE . '<br />' . vam_draw_input_field('code', $lInfo->code));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_CHARSET . '<br />' . vam_draw_input_field('charset', $lInfo->language_charset));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_IMAGE . '<br />' . vam_draw_input_field('image', $lInfo->image));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_DIRECTORY . '<br />' . vam_draw_input_field('directory', $lInfo->directory));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_SORT_ORDER . '<br />' . vam_draw_input_field('sort_order', $lInfo->sort_order));
      if (DEFAULT_LANGUAGE != $lInfo->code) $contents[] = array('text' => '<br />' . vam_draw_checkbox_field('default','on',false) . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_LANGUAGE . '</b>');

      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $lInfo->name . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br />' . (($remove_language) ? '<a class="button" href="' . vam_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=deleteconfirm') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>' : '') . ' <a class="button" href="' . vam_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    default:
      if (is_object($lInfo)) {
        $heading[] = array('text' => '<b>' . $lInfo->name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_LANGUAGES, 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_NAME . ' ' . $lInfo->name);
        $contents[] = array('text' => TEXT_INFO_LANGUAGE_CODE . ' ' . $lInfo->code);
        $contents[] = array('text' => TEXT_INFO_LANGUAGE_CHARSET_INFO . ' ' . $lInfo->language_charset);

        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_DIRECTORY . '<br />' . DIR_WS_LANGUAGES . '<b>' . $lInfo->directory . '</b>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_SORT_ORDER . ' ' . $lInfo->sort_order);
      }
      break;
  }

  if ( (vam_not_null($heading)) && (vam_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
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
<?php
/* --------------------------------------------------------------
   $Id: specials.php 1125 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(specials.php,v 1.38 2002/05/16); www.oscommerce.com
   (c) 2003         nextcommerce (specials.php,v 1.9 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (specials.php,v 1.9 2003/08/18); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  require(DIR_FS_CATALOG.DIR_WS_CLASSES . 'vam_price.php');
  $vamPrice = new vamPrice(DEFAULT_CURRENCY,$_SESSION['customers_status']['customers_status_id'],$_SESSION['customer_id']);

  require_once(DIR_FS_INC .'vam_get_tax_rate.inc.php');


  switch ($_GET['action']) {
    case 'setflag':
      vam_set_specials_status($_GET['id'], $_GET['flag']);
      vam_redirect(vam_href_link(FILENAME_SPECIALS, '', 'NONSSL'));
      break;
    case 'insert':
      // insert a product on special

     if (PRICE_IS_BRUTTO=='true' && substr($_POST['specials_price'], -1) != '%'){
        $sql="select tr.tax_rate from " . TABLE_TAX_RATES . " tr, " . TABLE_PRODUCTS . " p  where tr.tax_class_id = p. products_tax_class_id  and p.products_id = '". $_POST['products_up_id'] . "' ";
        $tax_query = vam_db_query($sql);
        $tax = vam_db_fetch_array($tax_query);
        $_POST['specials_price'] = ($_POST['specials_price']/($tax['tax_rate']+100)*100);
     }


     if (substr($_POST['specials_price'], -1) == '%')  {
             $new_special_insert_query = vam_db_query("select products_id,products_tax_class_id, products_price from " . TABLE_PRODUCTS . " where products_id = '" . (int)$_POST['products_id'] . "'");
        $new_special_insert = vam_db_fetch_array($new_special_insert_query);
        $_POST['products_price'] = $new_special_insert['products_price'];
      $_POST['specials_price'] = ($_POST['products_price'] - (($_POST['specials_price'] / 100) * $_POST['products_price']));
      }


      $expires_date = '';
      if ($_POST['expires-dd'] && $_POST['expires-mm'] && $_POST['expires']) {
        $expires_date = $_POST['expires'];
        $expires_date .= (strlen($_POST['expires-mm']) == 1) ? '0' . $_POST['expires-mm'] : $_POST['expires-mm'];
        $expires_date .= (strlen($_POST['expires-dd']) == 1) ? '0' . $_POST['expires-dd'] : $_POST['expires-dd'];
      }

      vam_db_query("insert into " . TABLE_SPECIALS . " (products_id, specials_quantity, specials_new_products_price, specials_date_added, expires_date, status) values ('" . $_POST['products_id'] . "', '" . $_POST['specials_quantity'] . "', '" . $_POST['specials_price'] . "', now(), '" . $expires_date . "', '1')");
      vam_redirect(vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page']));
      break;

    case 'update':
      // update a product on special
      if (PRICE_IS_BRUTTO=='true' && substr($_POST['specials_price'], -1) != '%'){
        $sql="select tr.tax_rate from " . TABLE_TAX_RATES . " tr, " . TABLE_PRODUCTS . " p  where tr.tax_class_id = p. products_tax_class_id  and p.products_id = '". $_POST['products_up_id'] . "' ";
        $tax_query = vam_db_query($sql);
        $tax = vam_db_fetch_array($tax_query);
        $_POST['specials_price'] = ($_POST['specials_price']/($tax[tax_rate]+100)*100);
     }

      if (substr($_POST['specials_price'], -1) == '%')  {
      $_POST['specials_price'] = ($_POST['products_price'] - (($_POST['specials_price'] / 100) * $_POST['products_price']));
      }
      $expires_date = '';
      if ($_POST['expires-dd'] && $_POST['expires-mm'] && $_POST['expires']) {
        $expires_date = $_POST['expires'];
        $expires_date .= (strlen($_POST['expires-mm']) == 1) ? '0' . $_POST['expires-mm'] : $_POST['expires-mm'];
        $expires_date .= (strlen($_POST['expires-dd']) == 1) ? '0' . $_POST['expires-dd'] : $_POST['expires-dd'];
      }

      vam_db_query("update " . TABLE_SPECIALS . " set specials_quantity = '" . $_POST['specials_quantity'] . "', specials_new_products_price = '" . $_POST['specials_price'] . "', specials_last_modified = now(), expires_date = '" . $expires_date . "' where specials_id = '" . $_POST['specials_id'] . "'");
      vam_redirect(vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $_POST['specials_id']));
      break;

    case 'deleteconfirm':
      $specials_id = vam_db_prepare_input($_GET['sID']);

      $product_query = vam_db_query("select products_id from " . TABLE_SPECIALS . " where specials_id = '" . (int)$specials_id . "'");
      $product = vam_db_fetch_array($product_query);

      vam_db_query("delete from " . TABLE_SPECIAL_PRODUCT . " where product_id = '" . (int)$product['products_id'] . "'");

      vam_db_query("delete from " . TABLE_SPECIALS . " where specials_id = '" . vam_db_input($specials_id) . "'");

      vam_redirect(vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page']));
      break;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="includes/general.js"></script>
<?php
  if ( ($_GET['action'] == 'new') || ($_GET['action'] == 'edit') ) {
?>
<link href="includes/javascript/date-picker/css/datepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/javascript/date-picker/js/datepicker.js"></script>
<?php
  }
?>
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

    <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php if ($_GET['action'] != 'edit') { ?><?php if ($_GET['action'] != 'new') { ?>
            <?php echo '<a class="button" href="' . vam_href_link(FILENAME_SELECT_SPECIAL, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/search.png', '', '12', '12') . '&nbsp;' . BUTTON_SEARCH . '</span></a>'; ?>&nbsp;<?php echo '<a class="button" href="' . vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/products.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_PRODUCTS . '</span></a>'; ?>&nbsp;<?php echo '<a class="button" href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/categories.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_CATEGORIES . '</span></a>&nbsp;';?><?php echo '<a class="button" href="' . vam_href_link(FILENAME_MANUFACTURER_SPECIALS, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/categories.png', '', '12', '12') . '&nbsp;' . NEW_MANUFACTURER_DISCOUNT . '</span></a>'; ?><?php } ?><?php } ?>
</td>
          </tr>
        </table>
           
   
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ( ($_GET['action'] == 'new') || ($_GET['action'] == 'edit') ) {
    $form_action = 'insert';
    if ( ($_GET['action'] == 'edit') && ($_GET['sID']) ) {
          $form_action = 'update';

      $product_query = vam_db_query("select p.products_tax_class_id,
                                            p.products_id,
                                            pd.products_name,
                                            p.products_price,
                                            s.specials_quantity,
                                            s.specials_new_products_price,
                                            s.expires_date from
                                            " . TABLE_PRODUCTS . " p,
                                            " . TABLE_PRODUCTS_DESCRIPTION . " pd,
                                            " . TABLE_SPECIALS . "
                                            s where p.products_id = pd.products_id
                                            and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                            and p.products_id = s.products_id
                                            and s.specials_id = '" . (int)$_GET['sID'] . "'");
      $product = vam_db_fetch_array($product_query);

      $sInfo = new objectInfo($product);
    } else {
      if ( ($_GET['action'] == 'new') && isset($_GET['prodID']) ) {
      	$product_query = vam_db_query("select p.products_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' and p.products_id = '". (int) $_GET['prodID']. "'");
      	$product = vam_db_fetch_array($product_query);
      	$fInfo = new objectInfo($product);
      }
      else {
      $sInfo = new objectInfo(array());

      // create an array of products on special, which will be excluded from the pull down menu of products
      // (when creating a new product on special)
      $specials_array = array();
      $specials_query = vam_db_query("select
                                      p.products_id from
                                      " . TABLE_PRODUCTS . " p,
                                      " . TABLE_SPECIALS . " s
                                      where s.products_id = p.products_id");

      while ($specials = vam_db_fetch_array($specials_query)) {
        $specials_array[] = $specials['products_id'];
      }
    }
  }
?>
      <tr><form name="new_special" <?php echo 'action="' . vam_href_link(FILENAME_SPECIALS, vam_get_all_get_params(array('action', 'info', 'sID')) . 'action=' . $form_action, 'NONSSL') . '"'; ?> method="post"><?php if ($form_action == 'update') echo vam_draw_hidden_field('specials_id', $_GET['sID']); ?>
        <td><br /><table border="0" cellspacing="0" cellpadding="2">

                <td class="main"><?php echo TEXT_SPECIALS_PRODUCT; echo ($sInfo->products_name) ? "" :  ''; ?>&nbsp;</td>
           <?php
                $price=$sInfo->products_price;
                $new_price=$sInfo->specials_new_products_price;
                if (PRICE_IS_BRUTTO=='true'){
                         $price_netto=vam_round($price,PRICE_PRECISION);
                        $new_price_netto=vam_round($new_price,PRICE_PRECISION);
            $price= ($price*(vam_get_tax_rate($sInfo->products_tax_class_id)+100)/100);
                        $new_price= ($new_price*(vam_get_tax_rate($sInfo->products_tax_class_id)+100)/100);
                }
                $price=vam_round($price,PRICE_PRECISION);
                $new_price=vam_round($new_price,PRICE_PRECISION);

                echo '<input type="hidden" name="products_up_id" value="' . $sInfo->products_id . '">';
           ?>
          <td class="main">
<?php
		if ( ($_GET['action'] == 'new') && isset($_GET['prodID']) ) {
        		echo vam_draw_hidden_field('products_id', $_GET['prodID']);
			echo $fInfo->products_name;
		}
        else
        	echo ($sInfo->products_name) ? $sInfo->products_name . ' <small>(' . $vamPrice->Format($price,true). ')</small>' : vam_draw_products_pull_down('products_id', 'style="font-size:10px"', $specials_array); echo vam_draw_hidden_field('products_price', $sInfo->products_price);

?>          
</td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_SPECIALS_SPECIAL_PRICE; ?>&nbsp;</td>
            <td class="main"><?php echo vam_draw_input_field('specials_price', $new_price);?> </td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_SPECIALS_SPECIAL_QUANTITY; ?>&nbsp;</td>
            <td class="main"><?php echo vam_draw_input_field('specials_quantity', $sInfo->specials_quantity);?> </td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_SPECIALS_EXPIRES_DATE; ?>&nbsp;</td>
            <td class="main"><?php echo vam_draw_input_field('expires-dd', substr($sInfo->expires_date, 8, 2), "size=\"2\" maxlength=\"2\" id=\"expires-dd\""); ?> / <?php echo vam_draw_input_field('expires-mm', substr($sInfo->expires_date, 5, 2), "size=\"2\" maxlength=\"2\" id=\"expires-mm\" class=\"\""); ?> / <?php echo vam_draw_input_field('expires', substr($sInfo->expires_date, 0, 4), "size=\"4\" maxlength=\"4\" id=\"expires\" class=\"format-d-m-y split-date\""); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><br /><?php echo TEXT_SPECIALS_PRICE_TIP; ?></td>
            <td class="main" align="right" valign="top"><br /><?php echo (($form_action == 'insert') ? '<span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>' : '<span class="button"><button type="submit" class="button" value="' . BUTTON_UPDATE . '">' .  vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_UPDATE . '</button></span>'). '&nbsp;&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $_GET['sID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?></td>
          </tr>
        </table></td>
      </form></tr>
<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_IMAGE; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_MODEL; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRODUCTS_PRICE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $specials_query_raw = "select p.products_id, p.products_model, p.products_image, pd.products_name,p.products_tax_class_id, p.products_price, s.specials_id, s.specials_new_products_price, s.specials_date_added, s.specials_last_modified, s.expires_date, s.date_status_change, s.status from " . TABLE_PRODUCTS . " p, " . TABLE_SPECIALS . " s, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and pd.language_id = '" . $_SESSION['languages_id'] . "' and p.products_id = s.products_id order by pd.products_name";
    $specials_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $specials_query_raw, $specials_query_numrows);
    $specials_query = vam_db_query($specials_query_raw);
    while ($specials = vam_db_fetch_array($specials_query)) {

                 $price=$specials['products_price'];
                $new_price=$specials['specials_new_products_price'];
                if (PRICE_IS_BRUTTO=='true'){
                         $price_netto=vam_round($price,PRICE_PRECISION);
                        $new_price_netto=vam_round($new_price,PRICE_PRECISION);
            $price= ($price*(vam_get_tax_rate($specials['products_tax_class_id'])+100)/100);
                        $new_price= ($new_price*(vam_get_tax_rate($specials['products_tax_class_id'])+100)/100);
                }
                $specials['products_price']=vam_round($price,PRICE_PRECISION);
                $specials['specials_new_products_price']=vam_round($new_price,PRICE_PRECISION);

      if ( ((!$_GET['sID']) || ($_GET['sID'] == $specials['specials_id'])) && (!$sInfo) ) {
        $products_query = vam_db_query("select products_image from " . TABLE_PRODUCTS . " where products_id = '" . $specials['products_id'] . "'");
        $products = vam_db_fetch_array($products_query);
        $sInfo_array = vam_array_merge($specials, $products);
        $sInfo = new objectInfo($sInfo_array);
        $sInfo->specials_new_products_price = $specials['specials_new_products_price'];
        $sInfo->products_price = $specials['products_price'];
      }

      if ( (is_object($sInfo)) && ($specials['specials_id'] == $sInfo->specials_id) ) {
        echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->specials_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $specials['specials_id']) . '\'">' . "\n";
      }
?>
                <td  class="dataTableContent"><?php echo vam_product_thumb_image($specials['products_image'], $specials['products_name'], 80, 100); ?></td>
                <td  class="dataTableContent"><?php echo $specials['products_model']; ?></td>
                <td  class="dataTableContent"><?php echo $specials['products_name']; ?></td>
                <td  class="dataTableContent" align="right"><span class="oldPrice">

                <?php




                 echo $vamPrice->Format($specials['products_price'],true); ?>
                </span> <span class="specialPrice">
                <?php echo $vamPrice->Format($specials['specials_new_products_price'],true); ?>
                </span></td>
                <td  class="dataTableContent" align="right">
<?php
      if ($specials['status'] == '1') {
        echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_SPECIALS, 'action=setflag&flag=0&id=' . $specials['specials_id'], 'NONSSL') . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link(FILENAME_SPECIALS, 'action=setflag&flag=1&id=' . $specials['specials_id'], 'NONSSL') . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($sInfo)) && ($specials['specials_id'] == $sInfo->specials_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $specials['specials_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
      </tr>
<?php
    }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellpadding="0"cellspacing="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $specials_split->display_count($specials_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_SPECIALS); ?></td>
                    <td class="smallText" align="right"><?php echo $specials_split->display_links($specials_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (!$_GET['action']) {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_SELECT_SPECIAL, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/search.png', '', '12', '12') . '&nbsp;' . BUTTON_SEARCH . '</span></a>'; ?>&nbsp;<?php echo '<a class="button" href="' . vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/products.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_PRODUCTS . '</span></a>'; ?>&nbsp;<?php echo '<a class="button" href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/categories.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_CATEGORIES . '</span></a>'; ?>&nbsp;<?php echo '<a class="button" href="' . vam_href_link(FILENAME_MANUFACTURER_SPECIALS, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/categories.png', '', '12', '12') . '&nbsp;' . NEW_MANUFACTURER_DISCOUNT . '</span></a>'; ?></td>
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
  switch ($_GET['action']) {
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_SPECIALS . '</b>');

      $contents = array('form' => vam_draw_form('specials', FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->specials_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $sInfo->products_name . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span>&nbsp;<a class="button" href="' . vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->specials_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    default:
      if (is_object($sInfo)) {
        $heading[] = array('text' => '<b>' . $sInfo->products_name . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->specials_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->specials_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_DATE_ADDED . ' ' . vam_date_short($sInfo->specials_date_added));
        $contents[] = array('text' => '' . TEXT_INFO_LAST_MODIFIED . ' ' . vam_date_short($sInfo->specials_last_modified));
        $contents[] = array('align' => 'center', 'text' => '<br />' . vam_product_thumb_image($sInfo->products_image, $sInfo->products_name, PRODUCT_IMAGE_THUMBNAIL_WIDTH, PRODUCT_IMAGE_THUMBNAIL_HEIGHT));
        $contents[] = array('text' => '<br />' . TEXT_INFO_ORIGINAL_PRICE . ' ' . $vamPrice->Format($sInfo->products_price,true));
        $contents[] = array('text' => '' . TEXT_INFO_NEW_PRICE . ' ' . $vamPrice->Format($sInfo->specials_new_products_price,true));
        $contents[] = array('text' => '' . TEXT_INFO_PERCENTAGE . ' ' . number_format(100 - (($sInfo->specials_new_products_price / $sInfo->products_price) * 100)) . '%');

        $contents[] = array('text' => '<br />' . TEXT_INFO_EXPIRES_DATE . ' <b>' . vam_date_short($sInfo->expires_date) . '</b>');
        $contents[] = array('text' => '' . TEXT_INFO_STATUS_CHANGE . ' ' . vam_date_short($sInfo->date_status_change));
      }
      break;
  }
  if ( (vam_not_null($heading)) && (vam_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
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
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
<?php
/* --------------------------------------------------------------
   $Id: featured.php 1125 2007-02-08 11:13:01Z VaM $   

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

  switch ($_GET['action']) {
    case 'setflag':
      vam_set_featured_status($_GET['id'], $_GET['flag']);
      vam_redirect(vam_href_link(FILENAME_FEATURED, '', 'NONSSL'));
      break;
    case 'insert':
      // insert a product on featured

      $expires_date = '';
      if ($_POST['expires-dd'] && $_POST['expires-mm'] && $_POST['expires']) {
        $expires_date = $_POST['expires'];
        $expires_date .= (strlen($_POST['expires-mm']) == 1) ? '0' . $_POST['expires-mm'] : $_POST['expires-mm'];
        $expires_date .= (strlen($_POST['expires-dd']) == 1) ? '0' . $_POST['expires-dd'] : $_POST['expires-dd'];
      }

      vam_db_query("insert into " . TABLE_FEATURED . " (products_id, featured_quantity, featured_date_added, expires_date, status) values ('" . $_POST['products_id'] . "', '" . $_POST['featured_quantity'] . "', now(), '" . $expires_date . "', '1')");
      vam_redirect(vam_href_link(FILENAME_FEATURED, 'page=' . $_GET['page']));
      break;

    case 'update':
      // update a product on featured
      $expires_date = '';
      if ($_POST['expires-dd'] && $_POST['expires-mm'] && $_POST['expires']) {
        $expires_date = $_POST['expires'];
        $expires_date .= (strlen($_POST['expires-mm']) == 1) ? '0' . $_POST['expires-mm'] : $_POST['expires-mm'];
        $expires_date .= (strlen($_POST['expires-dd']) == 1) ? '0' . $_POST['expires-dd'] : $_POST['expires-dd'];
      }

      vam_db_query("update " . TABLE_FEATURED . " set featured_quantity = '" . $_POST['featured_quantity'] . "', featured_last_modified = now(), expires_date = '" . $expires_date . "' where featured_id = '" . $_POST['featured_id'] . "'");
      vam_redirect(vam_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $featured_id));
      break;

    case 'deleteconfirm':
      $featured_id = vam_db_prepare_input($_GET['fID']);

      vam_db_query("delete from " . TABLE_FEATURED . " where featured_id = '" . vam_db_input($featured_id) . "'");

      vam_redirect(vam_href_link(FILENAME_FEATURED, 'page=' . $_GET['page']));
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
    
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php if ($_GET['action'] != 'edit') { ?>
<?php echo '<a class="button" href="' . vam_href_link(FILENAME_SELECT_FEATURED, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/search.png', '', '12', '12') . '&nbsp;' . BUTTON_SEARCH . '</span></a>'; ?>&nbsp;<?php echo '<a class="button" href="' . vam_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/products.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_PRODUCTS . '</span></a>'; ?><?php } ?>
</td>
          </tr>
        </table>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ( ($_GET['action'] == 'new') || ($_GET['action'] == 'edit') ) {
    $form_action = 'insert';
    if ( ($_GET['action'] == 'edit') && ($_GET['fID']) ) {
          $form_action = 'update';

      $product_query = vam_db_query("select p.products_tax_class_id,
                                            p.products_id,
                                            pd.products_name,
                                            p.products_price,
                                            f.featured_quantity,
                                            f.expires_date from
                                            " . TABLE_PRODUCTS . " p,
                                            " . TABLE_PRODUCTS_DESCRIPTION . " pd,
                                            " . TABLE_FEATURED . "
                                            f where p.products_id = pd.products_id
                                            and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
                                            and p.products_id = f.products_id
                                            and f.featured_id = '" . (int)$_GET['fID'] . "'");
      $product = vam_db_fetch_array($product_query);

      $fInfo = new objectInfo($product);
    } else {
      if ( ($_GET['action'] == 'new') && isset($_GET['prodID']) ) {
      	$product_query = vam_db_query("select p.products_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and pd.language_id = '" . (int)$_SESSION['languages_id'] . "' and p.products_id = '". (int) $_GET['prodID']. "'");
      	$product = vam_db_fetch_array($product_query);
      	$fInfo = new objectInfo($product);
      }
      else {
      	$fInfo = new objectInfo(array());

		// create an array of featured products, which will be excluded from the pull down menu of products
		// (when creating a new featured product)
      	$featured_array = array();
      	$featured_query = vam_db_query("select p.products_id from " . TABLE_PRODUCTS . " p, " . TABLE_FEATURED . " s where s.products_id = p.products_id");
      	while ($featured = vam_db_fetch_array($featured_query)) {
        	$featured_array[] = $featured['products_id'];
        }
      }
    }
?>
      <tr><form name="new_featured" <?php echo 'action="' . vam_href_link(FILENAME_FEATURED, vam_get_all_get_params(array('action', 'info', 'fID')) . 'action=' . $form_action, 'NONSSL') . '"'; ?> method="post"><?php if ($form_action == 'update') echo vam_draw_hidden_field('featured_id', $_GET['fID']); ?>
        <td><br /><table border="0" cellspacing="0" cellpadding="2">

                <td class="main"><?php echo TEXT_FEATURED_PRODUCT; ?>&nbsp;</td>
	    <td class="main">
<?php
		if ( ($_GET['action'] == 'new') && isset($_GET['prodID']) ) {
        		echo vam_draw_hidden_field('products_id', $_GET['prodID']);
			echo $fInfo->products_name;
		}
        else
        	echo (isset($fInfo->products_name)) ? $fInfo->products_name : vam_draw_products_pull_down('products_id', 'style="font-size:10px"', $featured_array);

?>
            </td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_FEATURED_QUANTITY; ?>&nbsp;</td>
            <td class="main"><?php echo vam_draw_input_field('featured_quantity', $fInfo->featured_quantity);?> </td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_FEATURED_EXPIRES_DATE; ?>&nbsp;</td>
            <td class="main"><?php echo vam_draw_input_field('expires-dd', substr($fInfo->expires_date, 8, 2), "size=\"2\" maxlength=\"2\" id=\"expires-dd\""); ?> / <?php echo vam_draw_input_field('expires-mm', substr($fInfo->expires_date, 5, 2), "size=\"2\" maxlength=\"2\" id=\"expires-mm\""); ?> / <?php echo vam_draw_input_field('expires', substr($fInfo->expires_date, 0, 4), "size=\"4\" maxlength=\"4\" id=\"expires\" class=\"format-d-m-y split-date\""); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" align="right" valign="top"><br /><?php echo (($form_action == 'insert') ? '<span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>' : '<span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>'). '&nbsp;&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $_GET['fID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?></td>
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $featured_query_raw = "select p.products_id, pd.products_name,p.products_tax_class_id, p.products_price, f.featured_id, f.featured_date_added, f.featured_last_modified, f.expires_date, f.date_status_change, f.status from " . TABLE_PRODUCTS . " p, " . TABLE_FEATURED . " f, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and pd.language_id = '" . $_SESSION['languages_id'] . "' and p.products_id = f.products_id order by pd.products_name";
    $featured_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $featured_query_raw, $featured_query_numrows);
    $featured_query = vam_db_query($featured_query_raw);
    while ($featured = vam_db_fetch_array($featured_query)) {

      if ( ((!$_GET['fID']) || ($_GET['fID'] == $featured['featured_id'])) && (!$fInfo) ) {
        $products_query = vam_db_query("select products_image from " . TABLE_PRODUCTS . " where products_id = '" . $featured['products_id'] . "'");
        $products = vam_db_fetch_array($products_query);
        $fInfo_array = vam_array_merge($featured, $products);
        $fInfo = new objectInfo($fInfo_array);
      }

      if ( (is_object($fInfo)) && ($featured['featured_id'] == $fInfo->featured_id) ) {
        echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $fInfo->featured_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $featured['featured_id']) . '\'">' . "\n";
      }
?>
                <td  class="dataTableContent"><?php echo $featured['products_name']; ?></td>
                <td  class="dataTableContent" align="right">
<?php
      if ($featured['status'] == '1') {
        echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_FEATURED, 'action=setflag&flag=0&id=' . $featured['featured_id'], 'NONSSL') . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link(FILENAME_FEATURED, 'action=setflag&flag=1&id=' . $featured['featured_id'], 'NONSSL') . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($fInfo)) && ($featured['featured_id'] == $fInfo->featured_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $featured['featured_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
      </tr>
<?php
    }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellpadding="0"cellspacing="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $featured_split->display_count($featured_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_FEATURED); ?></td>
                    <td class="smallText" align="right"><?php echo $featured_split->display_links($featured_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (!$_GET['action']) {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_SELECT_FEATURED, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/search.png', '', '12', '12') . '&nbsp;' . BUTTON_SEARCH . '</span></a>'; ?>&nbsp;<?php echo '<a class="button" href="' . vam_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/products.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_PRODUCTS . '</span></a>'; ?></td>
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
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_FEATURED . '</b>');

      $contents = array('form' => vam_draw_form('featured', FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $fInfo->featured_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $fInfo->products_name . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span>&nbsp;<a class="button" href="' . vam_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $fInfo->featured_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    default:
      if (is_object($fInfo)) {
        $heading[] = array('text' => '<b>' . $fInfo->products_name . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $fInfo->featured_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $fInfo->featured_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_DATE_ADDED . ' ' . vam_date_short($fInfo->featured_date_added));
        $contents[] = array('text' => '' . TEXT_INFO_LAST_MODIFIED . ' ' . vam_date_short($fInfo->featured_last_modified));
        $contents[] = array('align' => 'center', 'text' => '<br />' . vam_product_thumb_image($fInfo->products_image, $fInfo->products_name, PRODUCT_IMAGE_THUMBNAIL_WIDTH, PRODUCT_IMAGE_THUMBNAIL_HEIGHT));

        $contents[] = array('text' => '<br />' . TEXT_INFO_EXPIRES_DATE . ' <b>' . vam_date_short($fInfo->expires_date) . '</b>');
        $contents[] = array('text' => '' . TEXT_INFO_STATUS_CHANGE . ' ' . vam_date_short($fInfo->date_status_change));
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
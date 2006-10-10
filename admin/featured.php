<?php
/* --------------------------------------------------------------
   $Id: featured.php 1125 2005-07-28 09:59:44Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(specials.php,v 1.38 2002/05/16); www.oscommerce.com
   (c) 2003         nextcommerce (specials.php,v 1.9 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  switch ($_GET['action']) {
    case 'setflag':
      xtc_set_featured_status($_GET['id'], $_GET['flag']);
      xtc_redirect(xtc_href_link(FILENAME_FEATURED, '', 'NONSSL'));
      break;
    case 'insert':
      // insert a product on featured

      $expires_date = '';
      if ($_POST['expires-dd'] && $_POST['expires-mm'] && $_POST['expires']) {
        $expires_date = $_POST['expires'];
        $expires_date .= (strlen($_POST['expires-mm']) == 1) ? '0' . $_POST['expires-mm'] : $_POST['expires-mm'];
        $expires_date .= (strlen($_POST['expires-dd']) == 1) ? '0' . $_POST['expires-dd'] : $_POST['expires-dd'];
      }

      xtc_db_query("insert into " . TABLE_FEATURED . " (products_id, featured_quantity, featured_date_added, expires_date, status) values ('" . $_POST['products_id'] . "', '" . $_POST['featured_quantity'] . "', now(), '" . $expires_date . "', '1')");
      xtc_redirect(xtc_href_link(FILENAME_FEATURED, 'page=' . $_GET['page']));
      break;

    case 'update':
      // update a product on featured
      $expires_date = '';
      if ($_POST['expires-dd'] && $_POST['expires-mm'] && $_POST['expires']) {
        $expires_date = $_POST['expires'];
        $expires_date .= (strlen($_POST['expires-mm']) == 1) ? '0' . $_POST['expires-mm'] : $_POST['expires-mm'];
        $expires_date .= (strlen($_POST['expires-dd']) == 1) ? '0' . $_POST['expires-dd'] : $_POST['expires-dd'];
      }

      xtc_db_query("update " . TABLE_FEATURED . " set featured_quantity = '" . $_POST['featured_quantity'] . "', featured_last_modified = now(), expires_date = '" . $expires_date . "' where featured_id = '" . $_POST['featured_id'] . "'");
      xtc_redirect(xtc_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $featured_id));
      break;

    case 'deleteconfirm':
      $featured_id = xtc_db_prepare_input($_GET['fID']);

      xtc_db_query("delete from " . TABLE_FEATURED . " where featured_id = '" . xtc_db_input($featured_id) . "'");

      xtc_redirect(xtc_href_link(FILENAME_FEATURED, 'page=' . $_GET['page']));
      break;
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
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
<div id="popupcalendar" class="text"></div>
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td class="boxCenter" width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo xtc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  if ( ($_GET['action'] == 'new') || ($_GET['action'] == 'edit') ) {
    $form_action = 'insert';
    if ( ($_GET['action'] == 'edit') && ($_GET['fID']) ) {
          $form_action = 'update';

      $product_query = xtc_db_query("select p.products_tax_class_id,
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
      $product = xtc_db_fetch_array($product_query);

      $fInfo = new objectInfo($product);
    } else {
      $fInfo = new objectInfo(array());

      // create an array of products on featured, which will be excluded from the pull down menu of products
      // (when creating a new product on featured)
      $featured_array = array();
      $featured_query = xtc_db_query("select
                                      p.products_id from
                                      " . TABLE_PRODUCTS . " p,
                                      " . TABLE_FEATURED . " f
                                      where f.products_id = p.products_id");

      while ($featured = xtc_db_fetch_array($featured_query)) {
        $featured_array[] = $featured['products_id'];
      }
    }
?>
      <tr><form name="new_featured" <?php echo 'action="' . xtc_href_link(FILENAME_FEATURED, xtc_get_all_get_params(array('action', 'info', 'fID')) . 'action=' . $form_action, 'NONSSL') . '"'; ?> method="post"><?php if ($form_action == 'update') echo xtc_draw_hidden_field('featured_id', $_GET['fID']); ?>
        <td><br /><table border="0" cellspacing="0" cellpadding="2">

                <td class="main"><?php echo TEXT_FEATURED_PRODUCT; echo ($fInfo->products_name) ? "" :  ''; ?>&nbsp;</td>
           <?php
                echo '<input type="hidden" name="products_up_id" value="' . $fInfo->products_id . '">';
           ?>
          <td class="main"><?php echo ($fInfo->products_name) ? $fInfo->products_name : xtc_draw_products_pull_down('products_id', 'style="font-size:10px"', $featured_array); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_FEATURED_QUANTITY; ?>&nbsp;</td>
            <td class="main"><?php echo xtc_draw_input_field('featured_quantity', $fInfo->featured_quantity);?> </td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_FEATURED_EXPIRES_DATE; ?>&nbsp;</td>
            <td class="main"><?php echo xtc_draw_input_field('expires-dd', substr($fInfo->expires_date, 8, 2), "size=\"2\" maxlength=\"2\" id=\"expires-dd\""); ?> / <?php echo xtc_draw_input_field('expires-mm', substr($fInfo->expires_date, 5, 2), "size=\"2\" maxlength=\"2\" id=\"expires-mm\""); ?> / <?php echo xtc_draw_input_field('expires', substr($fInfo->expires_date, 0, 4), "size=\"4\" maxlength=\"4\" id=\"expires\" class=\"format-d-m-y split-date\""); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" align="right" valign="top"><br /><?php echo (($form_action == 'insert') ? '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_INSERT . '"/>' : '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_UPDATE . '"/>'). '&nbsp;&nbsp;&nbsp;<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $_GET['fID']) . '">' . BUTTON_CANCEL . '</a>'; ?></td>
          </tr>
        </table></td>
      </form></tr>
<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $featured_query_raw = "select p.products_id, pd.products_name,p.products_tax_class_id, p.products_price, f.featured_id, f.featured_date_added, f.featured_last_modified, f.expires_date, f.date_status_change, f.status from " . TABLE_PRODUCTS . " p, " . TABLE_FEATURED . " f, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id = pd.products_id and pd.language_id = '" . $_SESSION['languages_id'] . "' and p.products_id = f.products_id order by pd.products_name";
    $featured_split = new splitPageResults($_GET['page'], '20', $featured_query_raw, $featured_query_numrows);
    $featured_query = xtc_db_query($featured_query_raw);
    while ($featured = xtc_db_fetch_array($featured_query)) {

      if ( ((!$_GET['fID']) || ($_GET['fID'] == $featured['featured_id'])) && (!$fInfo) ) {
        $products_query = xtc_db_query("select products_image from " . TABLE_PRODUCTS . " where products_id = '" . $featured['products_id'] . "'");
        $products = xtc_db_fetch_array($products_query);
        $fInfo_array = xtc_array_merge($featured, $products);
        $fInfo = new objectInfo($fInfo_array);
      }

      if ( (is_object($fInfo)) && ($featured['featured_id'] == $fInfo->featured_id) ) {
        echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $fInfo->featured_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $featured['featured_id']) . '\'">' . "\n";
      }
?>
                <td  class="dataTableContent"><?php echo $featured['products_name']; ?></td>
                <td  class="dataTableContent" align="right">
<?php
      if ($featured['status'] == '1') {
        echo xtc_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . xtc_href_link(FILENAME_FEATURED, 'action=setflag&flag=0&id=' . $featured['featured_id'], 'NONSSL') . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . xtc_href_link(FILENAME_FEATURED, 'action=setflag&flag=1&id=' . $featured['featured_id'], 'NONSSL') . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . xtc_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($fInfo)) && ($featured['featured_id'] == $fInfo->featured_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . xtc_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $featured['featured_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
      </tr>
<?php
    }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellpadding="0"cellspacing="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $featured_split->display_count($featured_query_numrows, '20', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_FEATURED); ?></td>
                    <td class="smallText" align="right"><?php echo $featured_split->display_links($featured_query_numrows, '20', MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (!$_GET['action']) {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&action=new') . '">' . BUTTON_NEW_PRODUCTS . '</a>'; ?></td>
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

      $contents = array('form' => xtc_draw_form('featured', FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $fInfo->featured_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $fInfo->products_name . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_DELETE . '"/>&nbsp;<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $fInfo->featured_id) . '">' . BUTTON_CANCEL . '</a>');
      break;

    default:
      if (is_object($fInfo)) {
        $heading[] = array('text' => '<b>' . $fInfo->products_name . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $fInfo->featured_id . '&action=edit') . '">' . BUTTON_EDIT . '</a> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_FEATURED, 'page=' . $_GET['page'] . '&fID=' . $fInfo->featured_id . '&action=delete') . '">' . BUTTON_DELETE . '</a>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_DATE_ADDED . ' ' . xtc_date_short($fInfo->featured_date_added));
        $contents[] = array('text' => '' . TEXT_INFO_LAST_MODIFIED . ' ' . xtc_date_short($fInfo->featured_last_modified));
        $contents[] = array('align' => 'center', 'text' => '<br />' . xtc_product_thumb_image($fInfo->products_image, $fInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT));

        $contents[] = array('text' => '<br />' . TEXT_INFO_EXPIRES_DATE . ' <b>' . xtc_date_short($fInfo->expires_date) . '</b>');
        $contents[] = array('text' => '' . TEXT_INFO_STATUS_CHANGE . ' ' . xtc_date_short($fInfo->date_status_change));
      }
      break;
  }
  if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
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
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
   (c) 2002-2003 osCommerce(product_labels.php,v 1.33 2003/05/07); www.oscommerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once (DIR_FS_INC.'vam_image_submit.inc.php');

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'setflag': //set the status of an item.
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
          if ($_GET['id']) {
            vam_db_query("update " . TABLE_PRODUCT_LABELS . " set active = '" . $_GET['flag'] . "' where id = '" . $_GET['id'] . "'");
          }
        }

  //      vam_redirect(vam_href_link(FILENAME_PRODUCT_LABELS));
        break;

      case 'delete_product_labels_confirm': //user has confirmed deletion of an item.
        if ($_POST['id']) {
          $id = vam_db_prepare_input($_POST['id']);
          vam_db_query("delete from " . TABLE_PRODUCT_LABELS . " where id = '" . vam_db_input($id) . "'");
        }

   //     vam_redirect(vam_href_link(FILENAME_PRODUCT_LABELS));
        break;

      case 'insert_product_labels': //insert a new item.
        if ($_POST['name']) {

          $sql_data_array = array('name'   => vam_db_prepare_input($_POST['name']),
                                  'alias'    => vam_db_prepare_input($_POST['alias']),
                                  'html'    => vam_db_prepare_input($_POST['html']),
                                  'sort_order'   => vam_db_prepare_input($_POST['sort_order']),
                                  'active'     => vam_db_prepare_input($_POST['active']));
          vam_db_perform(TABLE_PRODUCT_LABELS, $sql_data_array);
          $id = vam_db_insert_id(); //not actually used ATM -- just there in case
        }
 //       vam_redirect(vam_href_link(FILENAME_PRODUCT_LABELS));
        break;

      case 'update_product_labels': //user wants to modify an item.
        if($_GET['id']) {
          $sql_data_array = array('name' => vam_db_prepare_input($_POST['name']),
                                  'alias'  => vam_db_prepare_input($_POST['alias']),
                                  'html'  => vam_db_prepare_input($_POST['html']),
                                  'sort_order'  => vam_db_prepare_input($_POST['sort_order']),
                                  'active'  => vam_db_prepare_input($_POST['active'])
                                  );
          vam_db_perform(TABLE_PRODUCT_LABELS, $sql_data_array, 'update', "id = '" . vam_db_prepare_input($_GET['id']) . "'");
        }
  //      vam_redirect(vam_href_link(FILENAME_PRODUCT_LABELS));
        break;
    }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
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
            <td class="pageHeading" align="right">
            <?php if ($_GET['action'] != 'new_product_labels') { echo '&nbsp;<a class="button" href="' . vam_href_link(FILENAME_PRODUCT_LABELS, 'action=new_product_labels') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; } ?></td>
          </tr>
        </table>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ($_GET['action'] == 'new_product_labels') { //insert or edit an item
    if ( isset($_GET['id']) ) { //editing exsiting item
      $product_labels_query = vam_db_query("select id, name, alias, html, sort_order from " . TABLE_PRODUCT_LABELS . " where id = '" . $_GET['id'] . "'");
      $product_labels = vam_db_fetch_array($product_labels_query);
    } else { //adding new item
      $product_labels = array();
    }
?>
      <tr><?php echo vam_draw_form('new_product_labels', FILENAME_PRODUCT_LABELS, isset($_GET['id']) ? vam_get_all_get_params(array('action')) . 'action=update_product_labels' : vam_get_all_get_params(array('action')) . 'action=insert_product_labels', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" cellspacing="0" cellpadding="2" width="100%">
          <tr>
            <td class="main"><?php echo TEXT_PRODUCT_LABELS_NAME; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('name', $product_labels['name'], 'size="60"', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCT_LABELS_ALIAS; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('alias', $product_labels['alias'], 'size="60"', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCT_LABELS_HTML; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_textarea_field('html', '', '100%', '25', stripslashes($product_labels['html'])); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCT_LABELS_SORT_ORDER; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('sort_order', $product_labels['sort_order'], 'size="10"', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_PRODUCT_LABELS_STATUS; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('active', (!$product_labels['active']) ? 1 : $product_labels['active'], 'size="10"', true); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right">
          <?php
            isset($_GET['id']) ? $cancel_button = '&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_PRODUCT_LABELS, 'id=' . $_GET['id']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>' : $cancel_button = '';
            echo '<span class="button"><button type="submit" value="' . BUTTON_INSERT .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' .BUTTON_INSERT . '</button></span>' . $cancel_button;
          ?>
        </td>
      </form></tr>
<?php

  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCT_LABELS_NAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCT_LABELS_ALIAS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_PRODUCT_LABELS_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRODUCT_LABELS_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $rows = 0;

    $product_labels_count = 0;
    $product_labels_query_raw = 'select id, name, alias, html, active, sort_order from ' . TABLE_PRODUCT_LABELS . ' order by sort_order asc';

	$product_labels_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $product_labels_query_raw, $product_labels_query_numrows);

    $product_labels_query = vam_db_query($product_labels_query_raw);
    
    while ($product_labels = vam_db_fetch_array($product_labels_query)) {
      $product_labels_count++;
      $rows++;
      
		if (((!$_GET['id']) || (@ $_GET['id'] == $product_labels['id'])) && (!$aInfo)) {
			$aInfo = new objectInfo($product_labels);
		}

		if ((is_object($aInfo)) && ($product_labels['id'] == $aInfo->id)) {
		
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_PRODUCT_LABELS, vam_get_all_get_params(array('id','action')) . 'id=' . $product_labels['id']) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_PRODUCT_LABELS, vam_get_all_get_params(array('id','action')) . 'id=' . $product_labels['id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '&nbsp;' . $product_labels['name']; ?></td>
                <td class="dataTableContent"><?php echo '&nbsp;' . $product_labels['alias']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($product_labels['active'] == '1') {
        echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_PRODUCT_LABELS, vam_get_all_get_params(array('id','action', 'flag')) . 'action=setflag&flag=0&id=' . $product_labels['id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link(FILENAME_PRODUCT_LABELS, vam_get_all_get_params(array('id','action', 'flag')) . 'action=setflag&flag=1&id=' . $product_labels['id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if ($product_labels['id'] == $_GET['id']) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_PRODUCT_LABELS, vam_get_all_get_params(array('id','action', 'flag')) . 'id=' . $product_labels['id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo '<br>' . TEXT_ITEMS . '&nbsp;' . $product_labels_count; ?></td>
                    <td align="right" class="smallText"><?php echo '&nbsp;<a class="button" href="' . vam_href_link(FILENAME_PRODUCT_LABELS, 'action=new_product_labels') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?>&nbsp;</td>
                  </tr>																																		  
                </table></td>
              </tr>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $product_labels_split->display_count($product_labels_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ITEMS); ?></td>
                    <td class="smallText" align="right"><?php echo $product_labels_split->display_links($product_labels_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], vam_get_all_get_params(array('page', 'action', 'x', 'y', 'id'))); ?></td>
                  </tr>              
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($_GET['action']) {
      case 'delete_product_labels': //generate box for confirming a item deletion
        $heading[] = array('text'   => '<b>' . TEXT_INFO_HEADING_DELETE_ITEM . '</b>');
        
        $contents = array('form'    => vam_draw_form('templates', FILENAME_PRODUCT_LABELS, vam_get_all_get_params(array('action')) . 'action=delete_product_labels_confirm') . vam_draw_hidden_field('id', $_GET['id']));
        $contents[] = array('text'  => TEXT_DELETE_ITEM_INTRO);
        $contents[] = array('text'  => '<br><b>' . $selected_item['name'] . '</b>');
        
        $contents[] = array('align' => 'center',
                            'text'  => '<br><span class="button"><button type="submit" value="' . BUTTON_DELETE .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span><a class="button" href="' . vam_href_link(FILENAME_PRODUCT_LABELS,  vam_get_all_get_params(array ('id', 'action')).'id=' . $selected_item['id']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;

      default:
        if ($rows > 0) {
          if (is_object($aInfo)) { //an item is selected, so make the side box
            $heading[] = array('text' => '<b>' . $aInfo->name . '</b>');

            $contents[] = array('align' => 'center', 
                                'text' => '<a class="button" href="' . vam_href_link(FILENAME_PRODUCT_LABELS,  vam_get_all_get_params(array ('id', 'action')).'id=' . $aInfo->id . '&action=new_product_labels') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_PRODUCT_LABELS,  vam_get_all_get_params(array ('id', 'action')).'id=' . $aInfo->id . '&action=delete_product_labels') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');

          }
        } else { // create category/product info
          $heading[] = array('text' => '<b>' . EMPTY_CATEGORY . '</b>');

          $contents[] = array('text' => sprintf(TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS, $parent_categories_name));
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
<?php
  }
?>
    </table></td>
<!-- body_text_eof //-->
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
<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_banners.php,v 1.2 2005/05/25 18:20:23 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_banners.php, v 1.6 2003/07/12);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

  require('includes/application_top.php');

  $affiliate_banner_extension = vam_banner_image_extension();

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'setaffiliate_flag':
        if ( ($_GET['affiliate_flag'] == '0') || ($_GET['affiliate_flag'] == '1') ) {
          vam_set_banner_status($_GET['abID'], $_GET['affiliate_flag']);
          $messageStack->add_session(SUCCESS_BANNER_STATUS_UPDATED, 'success');
        } else {
          $messageStack->add_session(ERROR_UNKNOWN_STATUS_FLAG, 'error');
        }

        vam_redirect(vam_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $_GET['abID']));
        break;
      case 'insert':
      case 'update':
        $affiliate_banners_id = vam_db_prepare_input($_POST['affiliate_banners_id']);
        $affiliate_banners_title = vam_db_prepare_input($_POST['affiliate_banners_title']);
        $affiliate_products_id  = vam_db_prepare_input($_POST['affiliate_products_id']);
        $new_affiliate_banners_group = vam_db_prepare_input($_POST['new_affiliate_banners_group']);
        $affiliate_banners_group = (empty($new_affiliate_banners_group)) ? vam_db_prepare_input($_POST['affiliate_banners_group']) : $new_affiliate_banners_group;
        $affiliate_banners_image_target = vam_db_prepare_input($_POST['affiliate_banners_image_target']);
        $affiliate_banners_image_local = vam_db_prepare_input($_POST['affiliate_banners_image_local']);
        $db_image_location = '';

        $affiliate_banner_error = false;
        if (empty($affiliate_banners_title)) {
          $messageStack->add(ERROR_BANNER_TITLE_REQUIRED, 'error');
          $affiliate_banner_error = true;
          $_GET['action'] = 'new';
        }
/*      if (empty($affiliate_banners_group)) {
          $messageStack->add(ERROR_BANNER_GROUP_REQUIRED, 'error');
          $affiliate_banner_error = true;
        }
*/
        //if (($_FILES['affiliate_banners_image']['name'] != '')) {
          if (!is_writeable(DIR_FS_CATALOG_IMAGES)) {
          	$messageStack->add(ERROR_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
            $affiliate_banner_error = true;
            $_GET['action'] = 'new';
          }
          else {
          	$image_location = DIR_FS_CATALOG_IMAGES . $_FILES['affiliate_banners_image']['name'];
          	move_uploaded_file($_FILES['affiliate_banners_image']['tmp_name'], $image_location);
          	@chmod($image_location, 0644);

				if (($_FILES['affiliate_banners_image']['name'] != '')) {
            $db_image_location = $_FILES['affiliate_banners_image']['name'];
	         } else {
            $db_image_location = $affiliate_banners_image_local;
   	      }
            
            if (!$affiliate_products_id) $affiliate_products_id="0";
            $sql_data_array = array('affiliate_banners_title' => $affiliate_banners_title,
                                    'affiliate_products_id' => $affiliate_products_id,
                                    'affiliate_banners_image' => $db_image_location,
                                    'affiliate_banners_group' => $affiliate_banners_group);
                                    
            if ($_GET['action'] == 'insert') {
            	$insert_sql_data = array('affiliate_date_added' => 'now()',
                                         'affiliate_status' => '1');
                $sql_data_array = array_merge($sql_data_array, $insert_sql_data);
                vam_db_perform(TABLE_AFFILIATE_BANNERS, $sql_data_array);
                $affiliate_banners_id = vam_db_insert_id();
                
                // Banner ID 1 is generic Product Banner
                if ($affiliate_banners_id==1) vam_db_query("update " . TABLE_AFFILIATE_BANNERS . " set affiliate_banners_id = affiliate_banners_id + 1");
                $messageStack->add_session(SUCCESS_BANNER_INSERTED, 'success');
            } elseif ($_GET['action'] == 'update') {
            	$insert_sql_data = array('affiliate_date_status_change' => 'now()');
            	$sql_data_array = array_merge($sql_data_array, $insert_sql_data);
            	vam_db_perform(TABLE_AFFILIATE_BANNERS, $sql_data_array, 'update', 'affiliate_banners_id = \'' . $affiliate_banners_id . '\'');
            	$messageStack->add_session(SUCCESS_BANNER_UPDATED, 'success');
            }
            vam_redirect(vam_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $affiliate_banners_id));
		  }
		//}
        break;
      case 'deleteconfirm':
        $affiliate_banners_id = vam_db_prepare_input($_GET['abID']);
        $delete_image = vam_db_prepare_input($_POST['delete_image']);

        if ($delete_image == 'on') {
          $affiliate_banner_query = vam_db_query("select affiliate_banners_image from " . TABLE_AFFILIATE_BANNERS . " where affiliate_banners_id = '" . vam_db_input($affiliate_banners_id) . "'");
          $affiliate_banner = vam_db_fetch_array($affiliate_banner_query);
          if (file_exists(DIR_FS_CATALOG_IMAGES . $affiliate_banner['affiliate_banners_image'])) {
            if (is_writeable(DIR_FS_CATALOG_IMAGES . $affiliate_banner['affiliate_banners_image'])) {
              unlink(DIR_FS_CATALOG_IMAGES . $affiliate_banner['affiliate_banners_image']);
            } else {
              $messageStack->add_session(ERROR_IMAGE_IS_NOT_WRITEABLE, 'error');
            }
          } else {
            $messageStack->add_session(ERROR_IMAGE_DOES_NOT_EXIST, 'error');
          }
        }

        vam_db_query("delete from " . TABLE_AFFILIATE_BANNERS . " where affiliate_banners_id = '" . vam_db_input($affiliate_banners_id) . "'");
        vam_db_query("delete from " . TABLE_AFFILIATE_BANNERS_HISTORY . " where affiliate_banners_id = '" . vam_db_input($affiliate_banners_id) . "'");

        $messageStack->add_session(SUCCESS_BANNER_REMOVED, 'success');

        vam_redirect(vam_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page']));
        break;
    }
  }
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset="<?php echo $_SESSION['language_charset']; ?>">
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
    <td class="boxCenter" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td class="main">

        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><a class="button" href="<?php echo MANUAL_LINK_AFFILIATE; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>
        
        </td>
      </tr>

  <tr>
<!-- body_text //-->
<?php
  if ($_GET['action'] == 'new') {
    $form_action = 'insert';
    if ($_GET['abID']) {
      $abID = vam_db_prepare_input($_GET['abID']);
      $form_action = 'update';

      $affiliate_banner_query = vam_db_query("select * from " . TABLE_AFFILIATE_BANNERS . " where affiliate_banners_id = '" . vam_db_input($abID) . "'");
      $affiliate_banner = vam_db_fetch_array($affiliate_banner_query);

      $abInfo = new objectInfo($affiliate_banner);
    } elseif ($_POST) {
      $abInfo = new objectInfo($_POST);
    } else {
      $abInfo = new objectInfo(array());
    }

    $groups_array = array();
    $groups_query = vam_db_query("select distinct affiliate_banners_group from " . TABLE_AFFILIATE_BANNERS . " order by affiliate_banners_group");
    while ($groups = vam_db_fetch_array($groups_query)) {
      $groups_array[] = array('id' => $groups['affiliate_banners_group'], 'text' => $groups['affiliate_banners_group']);
    }
?>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo vam_draw_form('new_banner', FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"'); if ($form_action == 'update') echo vam_draw_hidden_field('affiliate_banners_id', $abID); ?>
        <td><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_BANNERS_TITLE; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_banners_title', $abInfo->affiliate_banners_title, '', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_BANNERS_LINKED_PRODUCT; ?></td>
            <td class="main"><?php echo vam_draw_input_field('affiliate_products_id', $abInfo->affiliate_products_id, '', false); ?></td>
          </tr>
          <tr>
            <td class="main" colspan=2><?php echo TEXT_BANNERS_LINKED_PRODUCT_NOTE ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
<?php
/*
          <tr>
            <td class="main" valign="top"><?php echo TEXT_BANNERS_GROUP; ?></td>
            <td class="main"><?php echo vam_draw_pull_down_menu('affiliate_banners_group', $groups_array, $abInfo->affiliate_banners_group) . TEXT_BANNERS_NEW_GROUP . '<br>' . vam_draw_input_field('new_affiliate_banners_group', '', '', ((sizeof($groups_array) > 0) ? false : true)); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
*/
?>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_BANNERS_IMAGE; ?></td>
            <td class="main"><?php echo vam_draw_file_field('affiliate_banners_image') . ' ' . TEXT_BANNERS_IMAGE_LOCAL . '<br>' . DIR_FS_CATALOG_IMAGES . vam_draw_input_field('affiliate_banners_image_local', $abInfo->affiliate_banners_image); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
<td class="main" align="right" valign="top" nowrap><?php echo (($form_action == 'insert') ? '<span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>' : '<span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>'). '&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $_GET['abID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?></td>        </table></td>
      </form></tr>
<?php
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_BANNERS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRODUCT_ID; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATISTICS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $affiliate_banners_query_raw = "select * from " . TABLE_AFFILIATE_BANNERS . " order by affiliate_banners_title, affiliate_banners_group";
    $affiliate_banners_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $affiliate_banners_query_raw, $affiliate_banners_query_numrows);
    $affiliate_banners_query = vam_db_query($affiliate_banners_query_raw);
    while ($affiliate_banners = vam_db_fetch_array($affiliate_banners_query)) {
      $info_query = vam_db_query("select sum(affiliate_banners_shown) as affiliate_banners_shown, sum(affiliate_banners_clicks) as affiliate_banners_clicks from " . TABLE_AFFILIATE_BANNERS_HISTORY . " where affiliate_banners_id = '" . $affiliate_banners['affiliate_banners_id'] . "'");
      $info = vam_db_fetch_array($info_query);

      if (((!$_GET['abID']) || ($_GET['abID'] == $affiliate_banners['affiliate_banners_id'])) && (!$abInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
        $abInfo_array = array_merge($affiliate_banners, $info);
        $abInfo = new objectInfo($abInfo_array);
      }

      $affiliate_banners_shown = ($info['affiliate_banners_shown'] != '') ? $info['affiliate_banners_shown'] : '0';
      $affiliate_banners_clicked = ($info['affiliate_banners_clicks'] != '') ? $info['affiliate_banners_clicks'] : '0';

      if ( (is_object($abInfo)) && ($affiliate_banners['affiliate_banners_id'] == $abInfo->affiliate_banners_id) ) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_AFFILIATE_BANNERS,'abID=' . $abInfo->affiliate_banners_id . '&action=new')  . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_AFFILIATE_BANNERS, 'abID=' . $affiliate_banners['affiliate_banners_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="javascript:popupImageWindow(\'' . FILENAME_AFFILIATE_POPUP_IMAGE . '?banner=' . $affiliate_banners['affiliate_banners_id'] . '\')">' . vam_image(DIR_WS_IMAGES . 'icon_popup.gif', ICON_PREVIEW) . '</a>&nbsp;' . $affiliate_banners['affiliate_banners_title']; ?></td>
                <td class="dataTableContent" align="right"><?php if ($affiliate_banners['affiliate_products_id']>0) echo $affiliate_banners['affiliate_products_id']; else echo '&nbsp;'; ?></td>
                <td class="dataTableContent" align="right"><?php echo $affiliate_banners_shown . ' / ' . $affiliate_banners_clicked; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($abInfo)) && ($affiliate_banners['affiliate_banners_id'] == $abInfo->affiliate_banners_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $affiliate_banners['affiliate_banners_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $affiliate_banners_split->display_count($affiliate_banners_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_BANNERS); ?></td>
                    <td class="smallText" align="right"><?php echo $affiliate_banners_split->display_links($affiliate_banners_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'delete':
      $heading[] = array('text' => '<b>' . $abInfo->affiliate_banners_title . '</b>');

      $contents = array('form' => vam_draw_form('affiliate_banners', FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $abInfo->affiliate_banners_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br><b>' . $abInfo->affiliate_banners_title . '</b>');
      if ($abInfo->affiliate_banners_image) $contents[] = array('text' => '<br>' . vam_draw_checkbox_field('delete_image', 'on', true) . ' ' . TEXT_INFO_DELETE_IMAGE);
      $contents[] = array('align' => 'center', 'text' => '<br><span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span>&nbsp;<a class="button" href="' . vam_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $_GET['abID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;
    default:
      if (is_object($abInfo)) {
        $sql = "select products_name from " . TABLE_PRODUCTS_DESCRIPTION . " where products_id = '" . $abInfo->affiliate_products_id . "' and language_id = '" . $_SESSION['languages_id'] . "'";
        $product_description_query = vam_db_query($sql);
        $product_description = vam_db_fetch_array($product_description_query);
        $heading[] = array('text' => '<b>' . $abInfo->affiliate_banners_title . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $abInfo->affiliate_banners_id . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_AFFILIATE_BANNER_MANAGER, 'page=' . $_GET['page'] . '&abID=' . $abInfo->affiliate_banners_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');
        $contents[] = array('text' => $product_description['products_name']);
        $contents[] = array('text' => '<br>' . TEXT_BANNERS_DATE_ADDED . ' ' . vam_date_short($abInfo->affiliate_date_added));
        $contents[] = array('text' => '' . sprintf(TEXT_BANNERS_STATUS_CHANGE, vam_date_short($abInfo->affiliate_date_status_change)));
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

<?php
/*------------------------------------------------------------------------------
  $Id: blacklist.php 1023 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
  -----------------------------------------------------------------------------
  based on:
  $Id: blacklist.php,v 1.00 2003/04/10 BMC

  Copyright (c) 2003 BMC
  http://www.mainframes.co.uk

  Released under the GNU General Public License
------------------------------------------------------------------------------*/

  require('includes/application_top.php');


  switch ($_GET['action']) {
    case 'insert':
    case 'save':
      $blacklist_id = vam_db_prepare_input($_GET['bID']);
      $blacklist_card_number = vam_db_prepare_input($_POST['blacklist_card_number']);

      $sql_data_array = array('blacklist_card_number' => $blacklist_card_number);

      if ($_GET['action'] == 'insert') {
        $insert_sql_data = array('date_added' => 'now()');
        $sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
        vam_db_perform(TABLE_BLACKLIST, $sql_data_array);
        $blacklist_id = vam_db_insert_id();
      } elseif ($_GET['action'] == 'save') {
        $update_sql_data = array('last_modified' => 'now()');
        $sql_data_array = vam_array_merge($sql_data_array, $update_sql_data);
        vam_db_perform(TABLE_BLACKLIST, $sql_data_array, 'update', "blacklist_id = '" . vam_db_input($blacklist_id) . "'");
      }


      if (USE_CACHE == 'true') {
        vam_reset_cache_block('blacklist');
      }

      vam_redirect(vam_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $blacklist_id));
      break;
    case 'deleteconfirm':
      $blacklist_id = vam_db_prepare_input($_GET['bID']);


      vam_db_query("delete from " . TABLE_BLACKLIST . " where blacklist_id = '" . vam_db_input($blacklist_id) . "'");

      if (USE_CACHE == 'true') {
        vam_reset_cache_block('manufacturers');
      }

      vam_redirect(vam_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page']));
      break;
  }
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_BLACKLIST; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $blacklist_query_raw = "select blacklist_id, blacklist_card_number, date_added, last_modified from " . TABLE_BLACKLIST . " order by blacklist_id";
  $blacklist_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $blacklist_query_raw, $blacklist_query_numrows);
  $blacklist_query = vam_db_query($blacklist_query_raw);
  while ($blacklist = vam_db_fetch_array($blacklist_query)) {
    if (((!$_GET['bID']) || (@$_GET['bID'] == $blacklist['blacklist_id'])) && (!$bInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $blacklist_numbers_query = vam_db_query("select count(*) as blacklist_count from " . TABLE_BLACKLIST . " where blacklist_id = '" . $blacklist['blacklist_id'] . "'");
      $blacklist_numbers = vam_db_fetch_array($blacklist_numbers_query);

      $bInfo_array = vam_array_merge($blacklist, $blacklist_numbers);
      $bInfo = new objectInfo($bInfo_array);
    }

    if ( (is_object($bInfo)) && ($blacklist['blacklist_id'] == $bInfo->blacklist_id) ) {
      echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $blacklist['blacklist_id'] . '&action=edit') . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $blacklist['blacklist_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $blacklist['blacklist_card_number']; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($bInfo)) && ($blacklist['blacklist_id'] == $bInfo->blacklist_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . vam_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $blacklist['blacklist_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $blacklist_split->display_count($blacklist_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_BLACKLIST_CARDS); ?></td>
                    <td class="smallText" align="right"><?php echo $blacklist_split->display_links($blacklist_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
  if ($_GET['action'] != 'new') {
?>
              <tr>
                <td align="right" colspan="2" class="smallText"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $bInfo->blacklist_id . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?></td>
              </tr>
<?php
  }
?>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_BLACKLIST_CARD . '</b>');

      $contents = array('form' => vam_draw_form('blacklisted', FILENAME_BLACKLIST, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_NEW_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_BLACKLIST_CARD_NUMBER . '<br />' . vam_draw_input_field('blacklist_card_number'));

      $blacklist_inputs_string = '';

      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $_GET['bID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;
    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_BLACKLIST_CARD . '</b>');

      $contents = array('form' => vam_draw_form('blacklisted', FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $bInfo->blacklist_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_BLACKLIST_CARD_NUMBER . '<br />' . vam_draw_input_field('blacklist_card_number', $bInfo->blacklist_card_number));

      $blacklist_inputs_string = '';

      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $mInfo->blacklist_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_BLACKLIST_CARD . '</b>');

      $contents = array('form' => vam_draw_form('blacklisted', FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $bInfo->blacklist_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $bInfo->blacklist_card_number . '</b>');


      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $bInfo->blacklist_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;
    default:
      if (is_object($bInfo)) {
        $heading[] = array('text' => '<b>' . $bInfo->blacklist_card_number . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $bInfo->blacklist_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_BLACKLIST, 'page=' . $_GET['page'] . '&bID=' . $bInfo->blacklist_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');
        $contents[] = array('text' => '<br />' . TEXT_DATE_ADDED . ' ' . vam_date_short($bInfo->date_added));
        if (vam_not_null($bInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . vam_date_short($bInfo->last_modified));
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
<?php
// shaklov
/* --------------------------------------------------------------
   $Id: languages.php 1180 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(latest_news.php,v 1.33 2003/05/07); www.oscommerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once(DIR_FS_INC . 'vam_wysiwyg_tiny.inc.php');
  require_once (DIR_FS_INC.'vam_image_submit.inc.php');

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'setflag': //set the status of a news item.
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
          if ($_GET['id']) {
            vam_db_query("update " . TABLE_BLOCK . " set status = '" . $_GET['flag'] . "' where id = '" . $_GET['id'] . "'");
          }
        }

  //      vam_redirect(vam_href_link(FILENAME_BLOCK));
        break;

      case 'delete_block_confirm': //user has confirmed deletion of news article.
        if ($_POST['id']) {
          $id = vam_db_prepare_input($_POST['id']);
          vam_db_query("delete from " . TABLE_BLOCK . " where id = '" . vam_db_input($id) . "'");
        }

   //     vam_redirect(vam_href_link(FILENAME_BLOCK));
        break;

      case 'insert_block': //insert a new news article.
			$sql_data_array = array('url'   => vam_db_prepare_input($_POST['url']),
                               'date_added' => 'now()', //uses the inbuilt mysql function 'now'
                               'status'     => '1' 
							  );
			vam_db_perform(TABLE_BLOCK, $sql_data_array);
			$id = vam_db_insert_id(); //not actually used ATM -- just there in case
		  
 //       vam_redirect(vam_href_link(FILENAME_BLOCK));
	
 
        break;

      case 'update_block': //user wants to modify a news article.
        if($_GET['id']) {

		  
          $sql_data_array = array('url'  => vam_db_prepare_input($_POST['url']),
                                  'date_added'  => vam_db_prepare_input($_POST['date_added']),
                                  'last_modified'  => "now()"
                                  );
          vam_db_perform(TABLE_BLOCK, $sql_data_array, 'update', "id = '" . vam_db_prepare_input($_GET['id']) . "'");
        }
        vam_redirect(vam_href_link(FILENAME_BLOCK));
		
		//header("location: /admin/block.php?id=".$_GET['id']."&action=new_block");
		//echo "Обновлено";
        break;
    }
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
    
<?php 
$manual_link = 'add-news';
if ($_GET['action'] == 'new_block' and isset($_GET['id'])) {
$manual_link = 'edit-news';
}  
if ($_GET['action'] == 'delete_block') {
$manual_link = 'delete-news';
}  
?>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right">
            <?php if ($_GET['action'] != 'new_block') { echo '&nbsp;<a class="button" href="' . vam_href_link(FILENAME_BLOCK, 'action=new_block') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; } ?>&nbsp;<a class="button" href="<?php echo MANUAL_LINK_NEWS.'#'.$manual_link; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ($_GET['action'] == 'new_block') { //insert or edit a news item
    if ( isset($_GET['id']) ) { //editing exsiting news item
      $block_query = vam_db_query("select id, url, date_added from " . TABLE_BLOCK . " where id = '" . $_GET['id'] . "'");
      $block = vam_db_fetch_array($block_query);
    } else { //adding new news item
      $block = array();
    }
?>
      <tr><?php echo vam_draw_form('new_block', FILENAME_BLOCK, isset($_GET['id']) ? vam_get_all_get_params(array('action')) . 'action=update_block' : vam_get_all_get_params(array('action')) . 'action=insert_block', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" cellspacing="0" cellpadding="2" width="100%">
          <tr>
            <td class="main"><?php echo TEXT_BLOCK_CONTENT; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_textarea_field('url', '', '100%', '5', stripslashes($block['url'])); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<?php
if ( isset($_GET['id']) ) {
?>
          <tr>
            <td class="main"><?php echo TEXT_BLOCK_DATE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' .  vam_draw_input_field('date_added', $block['date_added'], '', true); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<?php
}
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right">
          <?php
            isset($_GET['id']) ? $cancel_button = '&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_BLOCK, 'id=' . $_GET['id']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>' : $cancel_button = '';
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_BLOCK_HEADLINE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_BLOCK_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_BLOCK_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $rows = 0;

    $block_count = 0;
    $block_query_raw = 'select id, url, status from ' . TABLE_BLOCK . ' order by date_added desc';

	$block_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $block_query_raw, $block_query_numrows);

    $block_query = vam_db_query($block_query_raw);
    
    while ($block = vam_db_fetch_array($block_query)) {
      $block_count++;
      $rows++;
      
		if (((!$_GET['id']) || (@ $_GET['id'] == $block['id'])) && (!$nInfo)) {
			$nInfo = new objectInfo($block);
		}

		if ((is_object($nInfo)) && ($block['id'] == $nInfo->id)) {
		
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_BLOCK, vam_get_all_get_params(array('id','action')) . 'id=' . $block['id']) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_BLOCK, vam_get_all_get_params(array('id','action')) . 'id=' . $block['id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '&nbsp;' . $block['url']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($block['status'] == '1') {
        echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_BLOCK, vam_get_all_get_params(array('id','action', 'flag')) . 'action=setflag&flag=0&id=' . $block['id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link(FILENAME_BLOCK, vam_get_all_get_params(array('id','action', 'flag')) . 'action=setflag&flag=1&id=' . $block['id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if ($block['id'] == $_GET['id']) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_BLOCK, vam_get_all_get_params(array('id','action', 'flag')) . 'id=' . $block['id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo '<br>' . TEXT_BLOCK_ITEMS . '&nbsp;' . $block_count; ?></td>
                    <td align="right" class="smallText"><?php echo '&nbsp;<a class="button" href="' . vam_href_link(FILENAME_BLOCK, 'action=new_block') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?>&nbsp;</td>
                  </tr>																																		  
                </table></td>
              </tr>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $block_split->display_count($block_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_BLOCKS); ?></td>
                    <td class="smallText" align="right"><?php echo $block_split->display_links($block_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], vam_get_all_get_params(array('page', 'action', 'x', 'y', 'id'))); ?></td>
                  </tr>              
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($_GET['action']) {
      case 'delete_block': //generate box for confirming a news article deletion
        $heading[] = array('text'   => '<b>' . TEXT_INFO_HEADING_DELETE_ITEM . '</b>');
        
        $contents = array('form'    => vam_draw_form('news', FILENAME_BLOCK, vam_get_all_get_params(array('action')) . 'action=delete_block_confirm') . vam_draw_hidden_field('id', $_GET['id']));
        $contents[] = array('text'  => TEXT_DELETE_ITEM_INTRO);
        $contents[] = array('text'  => '<br><b>' . $selected_item['headline'] . '</b>');
        
        $contents[] = array('align' => 'center',
                            'text'  => '<br><span class="button"><button type="submit" value="' . BUTTON_DELETE .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span><a class="button" href="' . vam_href_link(FILENAME_BLOCK,  vam_get_all_get_params(array ('id', 'action')).'id=' . $selected_item['id']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;

      default:
        if ($rows > 0) {
          if (is_object($nInfo)) { //an item is selected, so make the side box
            $heading[] = array('text' => '<b>' . $nInfo->url . '</b>');

            $contents[] = array('align' => 'center', 
                                'text' => '<a class="button" href="' . vam_href_link(FILENAME_BLOCK,  vam_get_all_get_params(array ('id', 'action')).'id=' . $nInfo->id . '&action=new_block') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_BLOCK,  vam_get_all_get_params(array ('id', 'action')).'id=' . $nInfo->id . '&action=delete_block') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');

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
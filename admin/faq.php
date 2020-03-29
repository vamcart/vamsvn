<?php
/* --------------------------------------------------------------
   $Id: faq.php 1180 2007-04-02 11:13:01Z VaM $   

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
      case 'setflag': //set the status of a faq item.
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
          if ($_GET['faq_id']) {
            vam_db_query("update " . TABLE_FAQ . " set status = '" . $_GET['flag'] . "' where faq_id = '" . $_GET['faq_id'] . "'");
          }
        }

  //      vam_redirect(vam_href_link(FILENAME_FAQ));
        break;

      case 'delete_faq_confirm': //user has confirmed deletion of faq.
        if ($_POST['faq_id']) {
          $faq_id = vam_db_prepare_input($_POST['faq_id']);
          vam_db_query("delete from " . TABLE_FAQ . " where faq_id = '" . vam_db_input($faq_id) . "'");
        }

   //     vam_redirect(vam_href_link(FILENAME_FAQ));
        break;

      case 'insert_faq': //insert a new faq.
        if ($_POST['question']) {

					if ($_POST['faq_page_url'] == '' && file_exists(DIR_FS_CATALOG . '.htaccess') && AUTOMATIC_SEO_URL == 'true') {
						$alias = $_POST['question'];
						
						$alias = make_alias($alias);
                  $faq_page_url = $alias;

					} else {
						
                $faq_page_url = $_POST['faq_page_url'];
					}
					
          $sql_data_array = array('question'   => vam_db_prepare_input($_POST['question']),
                                  'faq_page_url'    => vam_db_prepare_input($faq_page_url),
                                  'faq_head_title' => vam_db_prepare_input($_POST['faq_head_title']),
                                  'faq_head_desc' => vam_db_prepare_input($_POST['faq_head_desc']),
                                  'faq_head_keys' => vam_db_prepare_input($_POST['faq_head_keys']),
                                  'answer'    => vam_db_prepare_input($_POST['answer']),
                                  'date_added' => 'now()', //uses the inbuilt mysql function 'now'
                                  'language'   => vam_db_prepare_input($_POST['item_language']),
                                  'status'     => '1' );
          vam_db_perform(TABLE_FAQ, $sql_data_array);
          $faq_id = vam_db_insert_id(); //not actually used ATM -- just there in case
        }
 //       vam_redirect(vam_href_link(FILENAME_FAQ));
        break;

      case 'update_faq': //user wants to modify a faq.
        if($_GET['faq_id']) {
          $sql_data_array = array('question' => vam_db_prepare_input($_POST['question']),
                                  'faq_page_url'    => vam_db_prepare_input($_POST['faq_page_url']),
                                  'faq_head_title' => vam_db_prepare_input($_POST['faq_head_title']),
                                  'faq_head_desc' => vam_db_prepare_input($_POST['faq_head_desc']),
                                  'faq_head_keys' => vam_db_prepare_input($_POST['faq_head_keys']),
                                  'answer'  => vam_db_prepare_input($_POST['answer']),
                                  'date_added'  => vam_db_prepare_input($_POST['date_added']),
                                  'language'   => vam_db_prepare_input($_POST['item_language']),
                                  );
          vam_db_perform(TABLE_FAQ, $sql_data_array, 'update', "faq_id = '" . vam_db_prepare_input($_GET['faq_id']) . "'");
        }
  //      vam_redirect(vam_href_link(FILENAME_FAQ));
        break;
    }
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
<?php
 $query=vam_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".$_SESSION['languages_id']."'");
 $data=vam_db_fetch_array($query);
 if ($_GET['action']=='new_faq') echo vam_wysiwyg_tiny('faq',$data['code']);
?>
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
$manual_link = 'add-faq';
if ($_GET['action'] == 'new_faq' and isset($_GET['faq_id'])) {
$manual_link = 'edit-faq';
}  
if ($_GET['action'] == 'delete_faq') {
$manual_link = 'delete-faq';
}  
?>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php if ($_GET['action'] != 'new_faq') { echo '&nbsp;<a class="button" href="' . vam_href_link(FILENAME_FAQ, 'action=new_faq') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; } ?>&nbsp;<a class="button" href="<?php echo MANUAL_LINK_FAQ.'#'.$manual_link; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>
  
  </td>
  </tr>
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ($_GET['action'] == 'new_faq') { //insert or edit a faq
    if ( isset($_GET['faq_id']) ) { //editing exsiting faq
      $faq_query = vam_db_query("select faq_id, question, language, faq_page_url, faq_head_title, faq_head_desc, faq_head_keys, date_added, answer from " . TABLE_FAQ . " where faq_id = '" . $_GET['faq_id'] . "'");
      $faq = vam_db_fetch_array($faq_query);
    } else { //adding new faq
      $faq = array();
    }
?>
      <tr><?php echo vam_draw_form('new_faq', FILENAME_FAQ, isset($_GET['faq_id']) ? vam_get_all_get_params(array('action')) . 'action=update_faq' : vam_get_all_get_params(array('action')) . 'action=insert_faq', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" cellspacing="0" cellpadding="2" width="100%">
          <tr>
            <td class="main"><?php echo TEXT_FAQ_QUESTION; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('question', $faq['question'], 'size="60"', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_FAQ_ANSWER; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_textarea_field('answer', '', '100%', '25', stripslashes($faq['answer'])); ?><br /><a href="javascript:toggleHTMLEditor('answer');"><?php echo TEXT_TOGGLE_EDITOR; ?></a></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_FAQ_PAGE_URL; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('faq_page_url', $faq['faq_page_url'], 'size="60"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_FAQ_META_TITLE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('faq_head_title', $faq['faq_head_title'], 'size="60"', false); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_FAQ_META_DESCRIPTION; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_textarea_field('faq_head_desc', 'soft', '70', '5', $faq['faq_head_desc'], 'class="notinymce"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_FAQ_META_KEYWORDS; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_textarea_field('faq_head_keys', 'soft', '70', '5', $faq['faq_head_keys'], 'class="notinymce"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<?php
if ( isset($_GET['faq_id']) ) {
?>
          <tr>
            <td class="main"><?php echo TEXT_FAQ_DATE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' .  vam_draw_input_field('date_added', $faq['date_added'], '', true); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<?php
}
?>

          <tr>
            <td class="main"><?php echo TEXT_FAQ_LANGUAGE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;'; ?>

<?php

  $languages = vam_get_languages();
  $languages_array = array();

  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                        
  if ($languages[$i]['id']==$faq['language']) {
         $languages_selected=$languages[$i]['id'];
         $languages_id=$languages[$i]['id'];
        }               
    $languages_array[] = array('id' => $languages[$i]['id'],
               'text' => $languages[$i]['name']);

  } // for
  
echo vam_draw_pull_down_menu('item_language',$languages_array,$languages_selected); ?>

</td>
          </tr>


        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right">
          <?php
            isset($_GET['faq_id']) ? $cancel_button = '&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_FAQ, 'faq_id=' . $_GET['faq_id']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>' : $cancel_button = '';
            echo '<span class="button"><button type="submit" value="' . BUTTON_INSERT .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' .BUTTON_INSERT . '</button></span>' . $cancel_button;
          ?>
        </td>
      </form></tr>
<?php

  } else {
?>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FAQ_QUESTION; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_FAQ_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_FAQ_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $rows = 0;

    $faq_count = 0;
    $faq_query_raw = 'select faq_id, question, faq_page_url, faq_head_title, faq_head_desc, faq_head_keys, answer, status from ' . TABLE_FAQ . ' order by date_added desc';

	$faq_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $faq_query_raw, $faq_query_numrows);

    $faq_query = vam_db_query($faq_query_raw);
	    
    while ($faq = vam_db_fetch_array($faq_query)) {
      $faq_count++;
      $rows++;
      
		if (((!$_GET['faq_id']) || (@ $_GET['faq_id'] == $faq['faq_id'])) && (!$fInfo)) {
			$fInfo = new objectInfo($faq);
		}

		if ((is_object($fInfo)) && ($faq['faq_id'] == $fInfo->faq_id)) {
		
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_FAQ, vam_get_all_get_params(array('faq_id','action')) . 'faq_id=' . $faq['faq_id']) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_FAQ, vam_get_all_get_params(array('faq_id','action')) . 'faq_id=' . $faq['faq_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '&nbsp;' . $faq['question']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($faq['status'] == '1') {
        echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_FAQ, vam_get_all_get_params(array('faq_id','action', 'flag')) . 'action=setflag&flag=0&faq_id=' . $faq['faq_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link(FILENAME_FAQ, vam_get_all_get_params(array('faq_id','action', 'flag')) . 'action=setflag&flag=1&faq_id=' . $faq['faq_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if ($faq['faq_id'] == $_GET['faq_id']) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_FAQ, vam_get_all_get_params(array('faq_id','action', 'flag')) . 'faq_id=' . $faq['faq_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo '<br>' . TEXT_FAQ_ITEMS . '&nbsp;' . $faq_count; ?></td>
                    <td align="right" class="smallText"><?php echo '&nbsp;<a class="button" href="' . vam_href_link(FILENAME_FAQ, 'action=new_faq') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?>&nbsp;</td>
                  </tr>																																		  
                </table></td>
              </tr>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $faq_split->display_count($faq_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_FAQS); ?></td>
                    <td class="smallText" align="right"><?php echo $faq_split->display_links($faq_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], vam_get_all_get_params(array('page', 'action', 'x', 'y', 'faq_id'))); ?></td>
                  </tr>              
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($_GET['action']) {
      case 'delete_faq': //generate box for confirming a faqdeletion
        $heading[] = array('text'   => '<b>' . TEXT_INFO_HEADING_DELETE_ITEM . '</b>');
        
        $contents = array('form'    => vam_draw_form('faq', FILENAME_FAQ, vam_get_all_get_params(array('action')) . 'action=delete_faq_confirm') . vam_draw_hidden_field('faq_id', $_GET['faq_id']));
        $contents[] = array('text'  => TEXT_DELETE_ITEM_INTRO);
        $contents[] = array('text'  => '<br><b>' . $selected_item['question'] . '</b>');
        
        $contents[] = array('align' => 'center',
                            'text'  => '<br><span class="button"><button type="submit" value="' . BUTTON_DELETE .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span><a class="button" href="' . vam_href_link(FILENAME_FAQ,  vam_get_all_get_params(array ('faq_id', 'action')).'faq_id=' . $selected_item['faq_id']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;

      default:
        if ($rows > 0) {
          if (is_object($fInfo)) { //an item is selected, so make the side box
            $heading[] = array('text' => '<b>' . $fInfo->question . '</b>');

            $contents[] = array('align' => 'center', 
                                'text' => '<a class="button" href="' . vam_href_link(FILENAME_FAQ, vam_get_all_get_params(array ('faq_id', 'action')).'faq_id=' . $fInfo->faq_id . '&action=new_faq') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_FAQ,  vam_get_all_get_params(array ('faq_id', 'action')).'faq_id=' . $fInfo->faq_id . '&action=delete_faq') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');

            $contents[] = array('text' => '<br>' . $fInfo->answer);
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

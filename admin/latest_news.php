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
          if ($_GET['news_id']) {
            vam_db_query("update " . TABLE_LATEST_NEWS . " set status = '" . $_GET['flag'] . "' where news_id = '" . $_GET['news_id'] . "'");
          }
        }

  //      vam_redirect(vam_href_link(FILENAME_LATEST_NEWS));
        break;

      case 'delete_latest_news_confirm': //user has confirmed deletion of news article.
        if ($_POST['news_id']) {
          $news_id = vam_db_prepare_input($_POST['news_id']);
          vam_db_query("delete from " . TABLE_LATEST_NEWS . " where news_id = '" . vam_db_input($news_id) . "'");
        }

   //     vam_redirect(vam_href_link(FILENAME_LATEST_NEWS));
        break;

      case 'insert_latest_news': //insert a new news article.
        if ($_POST['headline']) {

					if ($_POST['news_page_url'] == '' && file_exists(DIR_FS_CATALOG . '.htaccess') && AUTOMATIC_SEO_URL == 'true') {
						$alias = $_POST['headline'];
						
						$alias = make_alias($alias);
                  $news_page_url = $alias;

					} else {
						
                $news_page_url = $_POST['news_page_url'];
					}

          $sql_data_array = array('headline'   => vam_db_prepare_input($_POST['headline']),
                                  'news_page_url'    => vam_db_prepare_input($news_page_url),
                                  'news_head_title' => vam_db_prepare_input($_POST['news_head_title']),
                                  'news_head_desc' => vam_db_prepare_input($_POST['news_head_desc']),
                                  'news_head_keys' => vam_db_prepare_input($_POST['news_head_keys']),
                                  'content'    => vam_db_prepare_input($_POST['content']),
                                  'date_added' => 'now()', //uses the inbuilt mysql function 'now'
                                  'language'   => vam_db_prepare_input($_POST['item_language']),
                                  'status'     => '1' );
          vam_db_perform(TABLE_LATEST_NEWS, $sql_data_array);
          $news_id = vam_db_insert_id(); //not actually used ATM -- just there in case
        }
 //       vam_redirect(vam_href_link(FILENAME_LATEST_NEWS));
        break;

      case 'update_latest_news': //user wants to modify a news article.
        if($_GET['news_id']) {
          $sql_data_array = array('headline' => vam_db_prepare_input($_POST['headline']),
                                  'news_page_url'    => vam_db_prepare_input($_POST['news_page_url']),
                                  'news_head_title' => vam_db_prepare_input($_POST['news_head_title']),
                                  'news_head_desc' => vam_db_prepare_input($_POST['news_head_desc']),
                                  'news_head_keys' => vam_db_prepare_input($_POST['news_head_keys']),
                                  'content'  => vam_db_prepare_input($_POST['content']),
                                  'date_added'  => vam_db_prepare_input($_POST['date_added']),
                                  'language'   => vam_db_prepare_input($_POST['item_language']),
                                  );
          vam_db_perform(TABLE_LATEST_NEWS, $sql_data_array, 'update', "news_id = '" . vam_db_prepare_input($_GET['news_id']) . "'");
        }
  //      vam_redirect(vam_href_link(FILENAME_LATEST_NEWS));
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
 if ($_GET['action']=='new_latest_news') echo vam_wysiwyg_tiny('latest_news',$data['code']); 
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
$manual_link = 'add-news';
if ($_GET['action'] == 'new_latest_news' and isset($_GET['news_id'])) {
$manual_link = 'edit-news';
}  
if ($_GET['action'] == 'delete_latest_news') {
$manual_link = 'delete-news';
}  
?>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right">
            <?php if ($_GET['action'] != 'new_latest_news') { echo '&nbsp;<a class="button" href="' . vam_href_link(FILENAME_LATEST_NEWS, 'action=new_latest_news') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; } ?>&nbsp;<a class="button" href="<?php echo MANUAL_LINK_NEWS.'#'.$manual_link; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ($_GET['action'] == 'new_latest_news') { //insert or edit a news item
    if ( isset($_GET['news_id']) ) { //editing exsiting news item
// shaklov
      $latest_news_query = vam_db_query("select news_id, headline, news_page_url, news_head_title, news_head_desc, news_head_keys, language, date_added, content from " . TABLE_LATEST_NEWS . " where news_id = '" . $_GET['news_id'] . "'");
      $latest_news = vam_db_fetch_array($latest_news_query);
    } else { //adding new news item
      $latest_news = array();
    }
?>
      <tr><?php echo vam_draw_form('new_latest_news', FILENAME_LATEST_NEWS, isset($_GET['news_id']) ? vam_get_all_get_params(array('action')) . 'action=update_latest_news' : vam_get_all_get_params(array('action')) . 'action=insert_latest_news', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" cellspacing="0" cellpadding="2" width="100%">
          <tr>
            <td class="main"><?php echo TEXT_LATEST_NEWS_HEADLINE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('headline', $latest_news['headline'], 'size="60"', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_NEWS_PAGE_URL; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('news_page_url', $latest_news['news_page_url'], 'size="60"', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
<!-- shaklov Тайтл и дескрипшн -->
          <tr>
            <td class="main"><?php echo TEXT_LATEST_NEWS_META_TITLE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('news_head_title', $latest_news['news_head_title'], 'size="60"', false); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_LATEST_NEWS_META_DESCRIPTION; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_textarea_field('news_head_desc', 'soft', '70', '5', $latest_news['news_head_desc'], 'class="notinymce"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_LATEST_NEWS_META_KEYWORDS; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_textarea_field('news_head_keys', 'soft', '70', '5', $latest_news['news_head_keys'], 'class="notinymce"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_LATEST_NEWS_CONTENT; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_textarea_field('content', '', '100%', '25', stripslashes($latest_news['content'])); ?><br /><a href="javascript:toggleHTMLEditor('content');"><?php echo TEXT_TOGGLE_EDITOR; ?></a></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<?php
if ( isset($_GET['news_id']) ) {
?>
          <tr>
            <td class="main"><?php echo TEXT_LATEST_NEWS_DATE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' .  vam_draw_input_field('date_added', $latest_news['date_added'], '', true); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<?php
}
?>

          <tr>
            <td class="main"><?php echo TEXT_LATEST_NEWS_LANGUAGE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;'; ?>

<?php

  $languages = vam_get_languages();
  $languages_array = array();

  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                        
  if ($languages[$i]['id']==$latest_news['language']) {
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
            isset($_GET['news_id']) ? $cancel_button = '&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_LATEST_NEWS, 'news_id=' . $_GET['news_id']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>' : $cancel_button = '';
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LATEST_NEWS_HEADLINE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_LATEST_NEWS_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_LATEST_NEWS_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $rows = 0;

    $latest_news_count = 0;
// shaklov
    $latest_news_query_raw = 'select news_id, headline, news_page_url, news_head_title, news_head_desc, news_head_keys, content, status from ' . TABLE_LATEST_NEWS . ' order by date_added desc';

	$latest_news_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $latest_news_query_raw, $latest_news_query_numrows);

    $latest_news_query = vam_db_query($latest_news_query_raw);
    
    while ($latest_news = vam_db_fetch_array($latest_news_query)) {
      $latest_news_count++;
      $rows++;
      
		if (((!$_GET['news_id']) || (@ $_GET['news_id'] == $latest_news['news_id'])) && (!$nInfo)) {
			$nInfo = new objectInfo($latest_news);
		}

		if ((is_object($nInfo)) && ($latest_news['news_id'] == $nInfo->news_id)) {
		
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_LATEST_NEWS, vam_get_all_get_params(array('news_id','action')) . 'news_id=' . $latest_news['news_id']) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_LATEST_NEWS, vam_get_all_get_params(array('news_id','action')) . 'news_id=' . $latest_news['news_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '&nbsp;' . $latest_news['headline']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($latest_news['status'] == '1') {
        echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_LATEST_NEWS, vam_get_all_get_params(array('news_id','action', 'flag')) . 'action=setflag&flag=0&news_id=' . $latest_news['news_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link(FILENAME_LATEST_NEWS, vam_get_all_get_params(array('news_id','action', 'flag')) . 'action=setflag&flag=1&news_id=' . $latest_news['news_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if ($latest_news['news_id'] == $_GET['news_id']) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_LATEST_NEWS, vam_get_all_get_params(array('news_id','action', 'flag')) . 'news_id=' . $latest_news['news_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo '<br>' . TEXT_NEWS_ITEMS . '&nbsp;' . $latest_news_count; ?></td>
                    <td align="right" class="smallText"><?php echo '&nbsp;<a class="button" href="' . vam_href_link(FILENAME_LATEST_NEWS, 'action=new_latest_news') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?>&nbsp;</td>
                  </tr>																																		  
                </table></td>
              </tr>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $latest_news_split->display_count($latest_news_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_NEWS); ?></td>
                    <td class="smallText" align="right"><?php echo $latest_news_split->display_links($latest_news_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], vam_get_all_get_params(array('page', 'action', 'x', 'y', 'news_id'))); ?></td>
                  </tr>              
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($_GET['action']) {
      case 'delete_latest_news': //generate box for confirming a news article deletion
        $heading[] = array('text'   => '<b>' . TEXT_INFO_HEADING_DELETE_ITEM . '</b>');
        
        $contents = array('form'    => vam_draw_form('news', FILENAME_LATEST_NEWS, vam_get_all_get_params(array('action')) . 'action=delete_latest_news_confirm') . vam_draw_hidden_field('news_id', $_GET['news_id']));
        $contents[] = array('text'  => TEXT_DELETE_ITEM_INTRO);
        $contents[] = array('text'  => '<br><b>' . $selected_item['headline'] . '</b>');
        
        $contents[] = array('align' => 'center',
                            'text'  => '<br><span class="button"><button type="submit" value="' . BUTTON_DELETE .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span><a class="button" href="' . vam_href_link(FILENAME_LATEST_NEWS,  vam_get_all_get_params(array ('news_id', 'action')).'news_id=' . $selected_item['news_id']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;

      default:
        if ($rows > 0) {
          if (is_object($nInfo)) { //an item is selected, so make the side box
            $heading[] = array('text' => '<b>' . $nInfo->headline . '</b>');

            $contents[] = array('align' => 'center', 
                                'text' => '<a class="button" href="' . vam_href_link(FILENAME_LATEST_NEWS,  vam_get_all_get_params(array ('news_id', 'action')).'news_id=' . $nInfo->news_id . '&action=new_latest_news') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_LATEST_NEWS,  vam_get_all_get_params(array ('news_id', 'action')).'news_id=' . $nInfo->news_id . '&action=delete_latest_news') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');

            $contents[] = array('text' => '<br>' . $nInfo->content);
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
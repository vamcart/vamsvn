<?php
  require('includes/application_top.php');
  require_once (DIR_FS_INC.'xtc_image_submit.inc.php');

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'setflag': //set the status of a news item.
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
          if ($_GET['latest_news_id']) {
            xtc_db_query("update " . TABLE_LATEST_NEWS . " set status = '" . $_GET['flag'] . "' where news_id = '" . $_GET['latest_news_id'] . "'");
          }
        }

  //      xtc_redirect(xtc_href_link(FILENAME_LATEST_NEWS));
        break;

      case 'delete_latest_news_confirm': //user has confirmed deletion of news article.
        if ($_POST['latest_news_id']) {
          $latest_news_id = xtc_db_prepare_input($_POST['latest_news_id']);
          xtc_db_query("delete from " . TABLE_LATEST_NEWS . " where news_id = '" . xtc_db_input($latest_news_id) . "'");
        }

   //     xtc_redirect(xtc_href_link(FILENAME_LATEST_NEWS));
        break;

      case 'insert_latest_news': //insert a new news article.
        if ($_POST['headline']) {
          $sql_data_array = array('headline'   => xtc_db_prepare_input($_POST['headline']),
                                  'content'    => xtc_db_prepare_input($_POST['content']),
                                  'date_added' => 'now()', //uses the inbuilt mysql function 'now'
                                  'language'   => xtc_db_prepare_input($_POST['item_language']),
                                  'status'     => '1' );
          xtc_db_perform(TABLE_LATEST_NEWS, $sql_data_array);
          $news_id = xtc_db_insert_id(); //not actually used ATM -- just there in case
        }
 //       xtc_redirect(xtc_href_link(FILENAME_LATEST_NEWS));
        break;

      case 'update_latest_news': //user wants to modify a news article.
        if($_GET['latest_news_id']) {
          $sql_data_array = array('headline' => xtc_db_prepare_input($_POST['headline']),
                                  'content'  => xtc_db_prepare_input($_POST['content']),
                                  'date_added'  => xtc_db_prepare_input($_POST['date_added']),
                                  'language'   => xtc_db_prepare_input($_POST['item_language']),
                                  );
          xtc_db_perform(TABLE_LATEST_NEWS, $sql_data_array, 'update', "news_id = '" . xtc_db_prepare_input($_GET['latest_news_id']) . "'");
        }
  //      xtc_redirect(xtc_href_link(FILENAME_LATEST_NEWS));
        break;
    }
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ($_GET['action'] == 'new_latest_news') { //insert or edit a news item
    if ( isset($_GET['latest_news_id']) ) { //editing exsiting news item
      $latest_news_query = xtc_db_query("select news_id, headline, language, date_added, content from " . TABLE_LATEST_NEWS . " where news_id = '" . $_GET['latest_news_id'] . "'");
      $latest_news = xtc_db_fetch_array($latest_news_query);
    } else { //adding new news item
      $latest_news = array();
    }
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE ?></td>
            <td class="pageHeading" align="right"><?php echo xtc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo xtc_draw_form('new_latest_news', FILENAME_LATEST_NEWS, isset($_GET['latest_news_id']) ? 'latest_news_id=' . $_GET['latest_news_id'] . '&action=update_latest_news' : 'action=insert_latest_news', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_LATEST_NEWS_HEADLINE; ?>:</td>
            <td class="main"><?php echo xtc_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . xtc_draw_input_field('headline', $latest_news['headline'], '', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_LATEST_NEWS_CONTENT; ?>:</td>
            <td class="main"><?php echo xtc_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . xtc_draw_textarea_field('content', 'soft', '70', '15', stripslashes($latest_news['content'])); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<?php
if ( isset($_GET['latest_news_id']) ) {
?>
          <tr>
            <td class="main"><?php echo TEXT_LATEST_NEWS_DATE; ?>:</td>
            <td class="main"><?php echo xtc_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' .  xtc_draw_input_field('date_added', $latest_news['date_added'], '', true); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<?php
}
?>

          <tr>
            <td class="main"><?php echo TEXT_LATEST_NEWS_LANGUAGE; ?>:</td>
            <td class="main"><?php echo xtc_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;'; ?>

<?php

  $languages = xtc_get_languages();
  $languages_array = array();

  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                        
  if ($languages[$i]['id']==$latest_news['language']) {
         $languages_selected=$languages[$i]['id'];
         $languages_id=$languages[$i]['id'];
        }               
    $languages_array[] = array('id' => $languages[$i]['id'],
               'text' => $languages[$i]['name']);

  } // for
  
echo xtc_draw_pull_down_menu('item_language',$languages_array,$languages_selected); ?>

</td>
          </tr>


        </table></td>
      </tr>
      <tr>
        <td><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right">
          <?php
            isset($_GET['latest_news_id']) ? $cancel_button = '&nbsp;&nbsp;<a class="button" href="' . xtc_href_link(FILENAME_LATEST_NEWS, 'latest_news_id=' . $_GET['latest_news_id']) . '">' . BUTTON_CANCEL . '</a>' : $cancel_button = '';
            echo '<input type="submit" class="button" value="' . BUTTON_INSERT .'">' . $cancel_button;
          ?>
        </td>
      </form></tr>
<?php

  } else {
?>
      <tr>
        <td>
          <table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr>
              <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
              <td class="pageHeading" align="right"><?php echo xtc_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            </tr>
          </table>
        </td>
      </tr>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LATEST_NEWS_HEADLINE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_LATEST_NEWS_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_LATEST_NEWS_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $rows = 0;

    $latest_news_count = 0;
    $latest_news_query = xtc_db_query('select news_id, headline, content, status from ' . TABLE_LATEST_NEWS . ' order by date_added desc');
    
    while ($latest_news = xtc_db_fetch_array($latest_news_query)) {
      $latest_news_count++;
      $rows++;
      
      if ( ((!$_GET['latest_news_id']) || (@$_GET['latest_news_id'] == $latest_news['news_id'])) && (!$selected_item) && (substr($_GET['action'], 0, 4) != 'new_') ) {
        $selected_item = $latest_news;
      }
      if ( (is_array($selected_item)) && ($latest_news['news_id'] == $selected_item['news_id']) ) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_LATEST_NEWS, 'latest_news_id=' . $latest_news['news_id']) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_LATEST_NEWS, 'latest_news_id=' . $latest_news['news_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '&nbsp;' . $latest_news['headline']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($latest_news['status'] == '1') {
        echo xtc_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . xtc_href_link(FILENAME_LATEST_NEWS, 'action=setflag&flag=0&latest_news_id=' . $latest_news['news_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . xtc_href_link(FILENAME_LATEST_NEWS, 'action=setflag&flag=1&latest_news_id=' . $latest_news['news_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . xtc_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if ($latest_news['news_id'] == $_GET['latest_news_id']) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . xtc_href_link(FILENAME_LATEST_NEWS, 'latest_news_id=' . $latest_news['news_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo '<br>' . TEXT_NEWS_ITEMS . '&nbsp;' . $latest_news_count; ?></td>
                    <td align="right" class="smallText"><?php echo '&nbsp;<a class="button" href="' . xtc_href_link(FILENAME_LATEST_NEWS, 'action=new_latest_news') . '">' . BUTTON_INSERT . '</a>'; ?>&nbsp;</td>
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
        
        $contents = array('form'    => xtc_draw_form('news', FILENAME_LATEST_NEWS, 'action=delete_latest_news_confirm') . xtc_draw_hidden_field('latest_news_id', $_GET['latest_news_id']));
        $contents[] = array('text'  => TEXT_DELETE_ITEM_INTRO);
        $contents[] = array('text'  => '<br><b>' . $selected_item['headline'] . '</b>');
        
        $contents[] = array('align' => 'center',
                            'text'  => '<br><input type="submit" class="button" value="' . BUTTON_DELETE .'"><a class="button" href="' . xtc_href_link(FILENAME_LATEST_NEWS, 'latest_news_id=' . $selected_item['news_id']) . '">' . BUTTON_CANCEL . '</a>');
        break;

      default:
        if ($rows > 0) {
          if (is_array($selected_item)) { //an item is selected, so make the side box
            $heading[] = array('text' => '<b>' . $selected_item['headline'] . '</b>');

            $contents[] = array('align' => 'center', 
                                'text' => '<a class="button" href="' . xtc_href_link(FILENAME_LATEST_NEWS, 'latest_news_id=' . $selected_item['news_id'] . '&action=new_latest_news') . '">' . BUTTON_EDIT . '</a> <a class="button" href="' . xtc_href_link(FILENAME_LATEST_NEWS, 'latest_news_id=' . $selected_item['news_id'] . '&action=delete_latest_news') . '">' . BUTTON_DELETE . '</a>');

            $contents[] = array('text' => '<br>' . $selected_item['content']);
          }
        } else { // create category/product info
          $heading[] = array('text' => '<b>' . EMPTY_CATEGORY . '</b>');

          $contents[] = array('text' => sprintf(TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS, $parent_categories_name));
        }
        break;
    }

    if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
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

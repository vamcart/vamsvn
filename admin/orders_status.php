<?php
/* --------------------------------------------------------------
   $Id: orders_status.php 1125 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders_status.php,v 1.19 2003/02/06); www.oscommerce.com 
   (c) 2003	 nextcommerce (orders_status.php,v 1.9 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (orders_status.php,v 1.9 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  switch ($_GET['action']) {
    case 'insert':
    case 'save':
      $orders_status_id = vam_db_prepare_input($_GET['oID']);

      $languages = vam_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $orders_status_name_array = $_POST['orders_status_name'];
        $answer_templates_id_array = $_POST['answer_templates_id'];
        $restock_array = $_POST['restock'];
        $language_id = $languages[$i]['id'];

        $sql_data_array = array(
        
        'orders_status_name' => vam_db_prepare_input($orders_status_name_array[$language_id]),
        'answer_templates_id' => vam_db_prepare_input($answer_templates_id_array[$language_id]),
        'restock' => vam_db_prepare_input($restock_array[$language_id]),
        
        );

        if ($_GET['action'] == 'insert') {
          if (!vam_not_null($orders_status_id)) {
            $next_id_query = vam_db_query("select max(orders_status_id) as orders_status_id from " . TABLE_ORDERS_STATUS . "");
            $next_id = vam_db_fetch_array($next_id_query);
            $orders_status_id = $next_id['orders_status_id'] + 1;
          }

          $insert_sql_data = array(
          
          'orders_status_id' => $orders_status_id,
          'language_id' => $language_id
                                   
                                   );
          $sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
          vam_db_perform(TABLE_ORDERS_STATUS, $sql_data_array);
        } elseif ($_GET['action'] == 'save') {
          vam_db_perform(TABLE_ORDERS_STATUS, $sql_data_array, 'update', "orders_status_id = '" . vam_db_input($orders_status_id) . "' and language_id = '" . $language_id . "'");
        }
      }

      if ($_POST['default'] == 'on') {
        vam_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . vam_db_input($orders_status_id) . "' where configuration_key = 'DEFAULT_ORDERS_STATUS_ID'");
      }

      vam_redirect(vam_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $orders_status_id));
      break;

    case 'deleteconfirm':
      $oID = vam_db_prepare_input($_GET['oID']);

      $orders_status_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'DEFAULT_ORDERS_STATUS_ID'");
      $orders_status = vam_db_fetch_array($orders_status_query);
      if ($orders_status['configuration_value'] == $oID) {
        vam_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '' where configuration_key = 'DEFAULT_ORDERS_STATUS_ID'");
      }

      vam_db_query("delete from " . TABLE_ORDERS_STATUS . " where orders_status_id = '" . vam_db_input($oID) . "'");

      vam_redirect(vam_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page']));
      break;

    case 'delete':
      $oID = vam_db_prepare_input($_GET['oID']);

      $status_query = vam_db_query("select count(*) as count from " . TABLE_ORDERS . " where orders_status = '" . vam_db_input($oID) . "'");
      $status = vam_db_fetch_array($status_query);

      $remove_status = true;
      if ($oID == DEFAULT_ORDERS_STATUS_ID) {
        $remove_status = false;
        $messageStack->add(ERROR_REMOVE_DEFAULT_ORDER_STATUS, 'error');
      } elseif ($status['count'] > 0) {
        $remove_status = false;
        $messageStack->add(ERROR_STATUS_USED_IN_ORDERS, 'error');
      } else {
        $history_query = vam_db_query("select count(*) as count from " . TABLE_ORDERS_STATUS_HISTORY . " where orders_status_id = '" . vam_db_input($oID) . "'");
        $history = vam_db_fetch_array($history_query);
        if ($history['count'] > 0) {
          $remove_status = false;
          $messageStack->add(ERROR_STATUS_USED_IN_HISTORY, 'error');
        }
      }
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
    
    <h1 class="contentBoxHeading"><?php echo BOX_ORDERS_STATUS; ?></h1>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ORDERS_STATUS; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ANSWER_TEMPLATE; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_RESTOCK; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $orders_status_query_raw = "select orders_status_id, answer_templates_id, restock, orders_status_name from " . TABLE_ORDERS_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "' order by orders_status_id";
  $orders_status_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $orders_status_query_raw, $orders_status_query_numrows);
  $orders_status_query = vam_db_query($orders_status_query_raw);
  while ($orders_status = vam_db_fetch_array($orders_status_query)) {
    if (((!$_GET['oID']) || ($_GET['oID'] == $orders_status['orders_status_id'])) && (!$oInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $oInfo = new objectInfo($orders_status);
    }

    if ( (is_object($oInfo)) && ($orders_status['orders_status_id'] == $oInfo->orders_status_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->orders_status_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $orders_status['orders_status_id']) . '\'">' . "\n";
    }

    if (DEFAULT_ORDERS_STATUS_ID == $orders_status['orders_status_id']) {
      echo '                <td class="dataTableContent"><b>' . $orders_status['orders_status_name'] . ' (' . TEXT_DEFAULT . ')</b></td>' . "\n";
    } else {
      echo '                <td class="dataTableContent">' . $orders_status['orders_status_name'] . '</td>' . "\n";
    }

      echo '                <td class="dataTableContent">' . vam_get_answer_templates_name($orders_status['answer_templates_id'],$_SESSION['languages_id']) . '</td>' . "\n";
      echo '                <td class="dataTableContent">' . vam_get_orders_status_restock_text($orders_status['orders_status_id'],$_SESSION['languages_id']) . '</td>' . "\n";

?>
                <td class="dataTableContent" align="right"><?php if ( (is_object($oInfo)) && ($orders_status['orders_status_id'] == $oInfo->orders_status_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $orders_status['orders_status_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $orders_status_split->display_count($orders_status_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS_STATUS); ?></td>
                    <td class="smallText" align="right"><?php echo $orders_status_split->display_links($orders_status_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (substr($_GET['action'], 0, 3) != 'new') {
?>
                  <tr>
                    <td colspan="4" align="right"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?></td>
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
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_ORDERS_STATUS . '</b>');

      $contents = array('form' => vam_draw_form('status', FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);

      $orders_status_inputs_string = '';
      $languages = vam_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $orders_status_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field('orders_status_name[' . $languages[$i]['id'] . ']');

$answer_templates_array = array (array ('id' => '', 'text' => TEXT_SELECT));
$answer_templates_query = vam_db_query("select id, name, content from ".TABLE_ANSWER_TEMPLATES." WHERE status = '1' and language='".$_SESSION['languages_id']."' order by id");
while ($answer_templates = vam_db_fetch_array($answer_templates_query)) {
        $answer_templates_array[] = array ('id' => vam_db_output($answer_templates['id']), 'text' => $answer_templates['name']);
}

$restock_array = array( 
array ('id' => '0', 'text' => ENTRY_RESTOCK_0),
array ('id' => '1', 'text' => ENTRY_RESTOCK_1)
);

      $orders_status_inputs_string .= '<br /><br />' . ENTRY_ANSWER_TEMPLATE . '<br />' . vam_draw_pull_down_menu('answer_templates_id[' . $languages[$i]['id'] . ']', $answer_templates_array, '', ''). '&nbsp;<a href="'.vam_href_link(FILENAME_ANSWER_TEMPLATES).'" target="_blank">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12').'</a><br />';

      $orders_status_inputs_string .= '<br />' . ENTRY_RESTOCK . '<br />' . vam_draw_pull_down_menu('restock[' . $languages[$i]['id'] . ']', $restock_array, '', '') . '<br />';

      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_ORDERS_STATUS_NAME . $orders_status_inputs_string);
      $contents[] = array('text' => '<br />' . vam_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_ORDERS_STATUS . '</b>');

      $contents = array('form' => vam_draw_form('status', FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->orders_status_id  . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);

      $orders_status_inputs_string = '';
      $languages = vam_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $orders_status_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field('orders_status_name[' . $languages[$i]['id'] . ']', vam_get_orders_status_name($oInfo->orders_status_id, $languages[$i]['id']));

$answer_templates_array = array (array ('id' => '', 'text' => TEXT_SELECT));
$answer_templates_query = vam_db_query("select id, name, content from ".TABLE_ANSWER_TEMPLATES." WHERE status = '1' and language='".$_SESSION['languages_id']."' order by id");
while ($answer_templates = vam_db_fetch_array($answer_templates_query)) {
        $answer_templates_array[] = array ('id' => vam_db_output($answer_templates['id']), 'text' => $answer_templates['name']);
}

$restock_array = array( 
array ('id' => '0', 'text' => ENTRY_RESTOCK_0),
array ('id' => '1', 'text' => ENTRY_RESTOCK_1)
);

      $orders_status_inputs_string .= '<br /><br />' . ENTRY_ANSWER_TEMPLATE . '<br />' . vam_draw_pull_down_menu('answer_templates_id[' . $languages[$i]['id'] . ']', $answer_templates_array, $oInfo->answer_templates_id, ''). '&nbsp;<a href="'.vam_href_link(FILENAME_ANSWER_TEMPLATES).'" target="_blank">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12').'</a><br />';

      $orders_status_inputs_string .= '<br />' . ENTRY_RESTOCK . '<br />' . vam_draw_pull_down_menu('restock[' . $languages[$i]['id'] . ']', $restock_array, $oInfo->restock, '') . '</a><br />';

      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_ORDERS_STATUS_NAME . $orders_status_inputs_string);
      if (DEFAULT_ORDERS_STATUS_ID != $oInfo->orders_status_id) $contents[] = array('text' => '<br />' . vam_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->orders_status_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ORDERS_STATUS . '</b>');

      $contents = array('form' => vam_draw_form('status', FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->orders_status_id  . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $oInfo->orders_status_name . '</b>');
      if ($remove_status) $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->orders_status_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    default:
      if (is_object($oInfo)) {
        $heading[] = array('text' => '<b>' . $oInfo->orders_status_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->orders_status_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_ORDERS_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->orders_status_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');

        $orders_status_inputs_string = '';
        $languages = vam_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $orders_status_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_get_orders_status_name($oInfo->orders_status_id, $languages[$i]['id']);
        }

        $contents[] = array('text' => $orders_status_inputs_string);
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
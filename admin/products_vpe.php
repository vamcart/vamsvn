<?php
/* --------------------------------------------------------------
   $Id: products_vpe.php 1125 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(order_status.php,v 1.19 2003/02/06); www.oscommerce.com 
   (c) 2003	 nextcommerce (order_status.php,v 1.9 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (products_vpe.php,v 1.9 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
   
   define('DEFAULT_PRODUCTS_VPE_ID','1');

  require('includes/application_top.php');

  switch ($_GET['action']) {
    case 'insert':
    case 'save':
      $products_vpe_id = vam_db_prepare_input($_GET['oID']);

      $languages = vam_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $products_vpe_name_array = $_POST['products_vpe_name'];
        $language_id = $languages[$i]['id'];

        $sql_data_array = array('products_vpe_name' => vam_db_prepare_input($products_vpe_name_array[$language_id]));

        if ($_GET['action'] == 'insert') {
          if (!vam_not_null($products_vpe_id)) {
            $next_id_query = vam_db_query("select max(products_vpe_id) as products_vpe_id from " . TABLE_PRODUCTS_VPE . "");
            $next_id = vam_db_fetch_array($next_id_query);
            $products_vpe_id = $next_id['products_vpe_id'] + 1;
          }

          $insert_sql_data = array('products_vpe_id' => $products_vpe_id,
                                   'language_id' => $language_id);
          $sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
          vam_db_perform(TABLE_PRODUCTS_VPE, $sql_data_array);
        } elseif ($_GET['action'] == 'save') {
          vam_db_perform(TABLE_PRODUCTS_VPE, $sql_data_array, 'update', "products_vpe_id = '" . vam_db_input($products_vpe_id) . "' and language_id = '" . $language_id . "'");
        }
      }

      if ($_POST['default'] == 'on') {
        vam_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . vam_db_input($products_vpe_id) . "' where configuration_key = 'DEFAULT_PRODUCTS_VPE_ID'");
      }

      vam_redirect(vam_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $products_vpe_id));
      break;

    case 'deleteconfirm':
      $oID = vam_db_prepare_input($_GET['oID']);

      $products_vpe_query = vam_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'DEFAULT_PRODUCTS_VPE_ID'");
      $products_vpe = vam_db_fetch_array($products_vpe_query);
      if ($products_vpe['configuration_value'] == $oID) {
        vam_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '' where configuration_key = 'DEFAULT_PRODUCTS_VPE_ID'");
      }

      vam_db_query("delete from " . TABLE_PRODUCTS_VPE . " where products_vpe_id = '" . vam_db_input($oID) . "'");

      vam_redirect(vam_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page']));
      break;

    case 'delete':
      $oID = vam_db_prepare_input($_GET['oID']);


      $remove_status = true;
      if ($oID == DEFAULT_PRODUCTS_VPE_ID) {
        $remove_status = false;
        $messageStack->add(ERROR_REMOVE_DEFAULT_PRODUCTS_VPE, 'error');
      } 
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
    
    <h1 class="contentBoxHeading"><?php echo BOX_PRODUCTS_VPE; ?></h1>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_VPE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $products_vpe_query_raw = "select products_vpe_id, products_vpe_name from " . TABLE_PRODUCTS_VPE . " where language_id = '" . $_SESSION['languages_id'] . "' order by products_vpe_id";
  $products_vpe_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $products_vpe_query_raw, $products_vpe_query_numrows);
  $products_vpe_query = vam_db_query($products_vpe_query_raw);
  while ($products_vpe = vam_db_fetch_array($products_vpe_query)) {
    if (((!$_GET['oID']) || ($_GET['oID'] == $products_vpe['products_vpe_id'])) && (!$oInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $oInfo = new objectInfo($products_vpe);
    }

    if ( (is_object($oInfo)) && ($products_vpe['products_vpe_id'] == $oInfo->products_vpe_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_vpe_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $products_vpe['products_vpe_id']) . '\'">' . "\n";
    }

    if (DEFAULT_PRODUCTS_VPE_ID == $products_vpe['products_vpe_id']) {
      echo '                <td class="dataTableContent"><b>' . $products_vpe['products_vpe_name'] . ' (' . TEXT_DEFAULT . ')</b></td>' . "\n";
    } else {
      echo '                <td class="dataTableContent">' . $products_vpe['products_vpe_name'] . '</td>' . "\n";
    }
?>
                <td class="dataTableContent" align="right"><?php if ( (is_object($oInfo)) && ($products_vpe['products_vpe_id'] == $oInfo->products_vpe_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $products_vpe['products_vpe_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $products_vpe_split->display_count($products_vpe_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS_VPE); ?></td>
                    <td class="smallText" align="right"><?php echo $products_vpe_split->display_links($products_vpe_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (substr($_GET['action'], 0, 3) != 'new') {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?></td>
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
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_PRODUCTS_VPE . '</b>');

      $contents = array('form' => vam_draw_form('status', FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);

      $products_vpe_inputs_string = '';
      $languages = vam_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $products_vpe_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field('products_vpe_name[' . $languages[$i]['id'] . ']');
      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_PRODUCTS_VPE_NAME . $products_vpe_inputs_string);
      $contents[] = array('text' => '<br />' . vam_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_PRODUCTS_VPE . '</b>');

      $contents = array('form' => vam_draw_form('status', FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_vpe_id  . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);

      $products_vpe_inputs_string = '';
      $languages = vam_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $products_vpe_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field('products_vpe_name[' . $languages[$i]['id'] . ']', vam_get_products_vpe_name($oInfo->products_vpe_id, $languages[$i]['id']));
      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_PRODUCTS_VPE_NAME . $products_vpe_inputs_string);
      if (DEFAULT_PRODUCTS_VPE_ID != $oInfo->products_vpe_id) $contents[] = array('text' => '<br />' . vam_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_vpe_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_PRODUCTS_VPE . '</b>');

      $contents = array('form' => vam_draw_form('status', FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_vpe_id  . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $oInfo->products_vpe_name . '</b>');
      if ($remove_status) $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_vpe_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    default:
      if (is_object($oInfo)) {

        $heading[] = array('text' => '<b>' . $oInfo->products_vpe_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_vpe_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_VPE, 'page=' . $_GET['page'] . '&oID=' . $oInfo->products_vpe_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');

        $products_vpe_inputs_string = '';
        $languages = vam_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $products_vpe_inputs_string .= '<br />' .$languages[$i]['name'] . ':&nbsp;' . vam_get_products_vpe_name($oInfo->products_vpe_id, $languages[$i]['id']);
        }

        $contents[] = array('text' => $products_vpe_inputs_string);
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
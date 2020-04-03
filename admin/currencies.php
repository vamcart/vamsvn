<?php
/* --------------------------------------------------------------
   $Id: currencies.php 1123 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(currencies.php,v 1.46 2003/05/02); www.oscommerce.com 
   (c) 2003	 nextcommerce (currencies.php,v 1.9 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (currencies.php,v 1.9 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
  require('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'insert':
      case 'save':
        $currency_id = vam_db_prepare_input($_GET['cID']);
        $title = vam_db_prepare_input($_POST['title']);
        $code = vam_db_prepare_input($_POST['code']);
        $symbol_left = vam_db_prepare_input($_POST['symbol_left']);
        $symbol_right = vam_db_prepare_input($_POST['symbol_right']);
        $decimal_point = vam_db_prepare_input($_POST['decimal_point']);
        $thousands_point = vam_db_prepare_input($_POST['thousands_point']);
        $decimal_places = vam_db_prepare_input($_POST['decimal_places']);
        $value = vam_db_prepare_input($_POST['value']);

        $sql_data_array = array('title' => $title,
                                'code' => $code,
                                'symbol_left' => $symbol_left,
                                'symbol_right' => $symbol_right,
                                'decimal_point' => $decimal_point,
                                'thousands_point' => $thousands_point,
                                'decimal_places' => $decimal_places,
                                'value' => $value);

        if ($_GET['action'] == 'insert') {
          vam_db_perform(TABLE_CURRENCIES, $sql_data_array);
          $currency_id = vam_db_insert_id();
        } elseif ($_GET['action'] == 'save') {
          vam_db_perform(TABLE_CURRENCIES, $sql_data_array, 'update', "currencies_id = '" . vam_db_input($currency_id) . "'");
        }

        if ($_POST['default'] == 'on') {
          vam_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . vam_db_input($code) . "' where configuration_key = 'DEFAULT_CURRENCY'");
        }
        vam_redirect(vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $currency_id));
        break;

      case 'deleteconfirm':
        $currencies_id = vam_db_prepare_input($_GET['cID']);

        $currency_query = vam_db_query("select currencies_id from " . TABLE_CURRENCIES . " where code = '" . DEFAULT_CURRENCY . "'");
        $currency = vam_db_fetch_array($currency_query);
        if ($currency['currencies_id'] == $currencies_id) {
          vam_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '' where configuration_key = 'DEFAULT_CURRENCY'");
        }

        vam_db_query("delete from " . TABLE_CURRENCIES . " where currencies_id = '" . vam_db_input($currencies_id) . "'");

        vam_redirect(vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page']));
        break;

      case 'update':
        $server_used = CURRENCY_SERVER_PRIMARY;
        $currency_query = vam_db_query("select currencies_id, code, title from " . TABLE_CURRENCIES);
        while ($currency = vam_db_fetch_array($currency_query)) {
          $quote_function = 'quote_' . CURRENCY_SERVER_PRIMARY . '_currency';
          $rate = $quote_function($currency['code']);
          if ( (!$rate) && (CURRENCY_SERVER_BACKUP != '') ) {
            $quote_function = 'quote_' . CURRENCY_SERVER_BACKUP . '_currency';
            $rate = $quote_function($currency['code']);
            $server_used = CURRENCY_SERVER_BACKUP;
          }
          if ($rate) {
            vam_db_query("update " . TABLE_CURRENCIES . " set value = '" . $rate . "', last_updated = now() where currencies_id = '" . $currency['currencies_id'] . "'");
            $messageStack->add_session(sprintf(TEXT_INFO_CURRENCY_UPDATED, $currency['title'], $currency['code'], $server_used), 'success');
          } else {
            $messageStack->add_session(sprintf(ERROR_CURRENCY_INVALID, $currency['title'], $currency['code'], $server_used), 'error');
          }
        }
        vam_redirect(vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $_GET['cID']));
        break;

      case 'delete':
        $currencies_id = vam_db_prepare_input($_GET['cID']);

        $currency_query = vam_db_query("select code from " . TABLE_CURRENCIES . " where currencies_id = '" . vam_db_input($currencies_id) . "'");
        $currency = vam_db_fetch_array($currency_query);

        $remove_currency = true;
        if ($currency['code'] == DEFAULT_CURRENCY) {
          $remove_currency = false;
          $messageStack->add(ERROR_REMOVE_DEFAULT_CURRENCY, 'error');
        }
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CURRENCY_NAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CURRENCY_CODES; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_CURRENCY_VALUE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $currency_query_raw = "select currencies_id, title, code, symbol_left, symbol_right, decimal_point, thousands_point, decimal_places, last_updated, value from " . TABLE_CURRENCIES . " order by title";
  $currency_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $currency_query_raw, $currency_query_numrows);
  $currency_query = vam_db_query($currency_query_raw);
  while ($currency = vam_db_fetch_array($currency_query)) {
    if (((!$_GET['cID']) || (@$_GET['cID'] == $currency['currencies_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $cInfo = new objectInfo($currency);
    }

    if ( (is_object($cInfo)) && ($currency['currencies_id'] == $cInfo->currencies_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $currency['currencies_id']) . '\'">' . "\n";
    }

    if (DEFAULT_CURRENCY == $currency['code']) {
      echo '                <td class="dataTableContent"><b>' . $currency['title'] . ' (' . TEXT_DEFAULT . ')</b></td>' . "\n";
    } else {
      echo '                <td class="dataTableContent">' . $currency['title'] . '</td>' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $currency['code']; ?></td>
                <td class="dataTableContent" align="right"><?php echo number_format($currency['value'], 8); ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($cInfo)) && ($currency['currencies_id'] == $cInfo->currencies_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $currency['currencies_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $currency_split->display_count($currency_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CURRENCIES); ?></td>
                    <td class="smallText" align="right"><?php echo $currency_split->display_links($currency_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (!$_GET['action']) {
?>
                  <tr>
                    <td><?php if (CURRENCY_SERVER_PRIMARY) { echo '<a class="button" href="' . vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=update') . '"><span>' . BUTTON_UPDATE . '</span></a>'; } ?></td>
                    <td align="right"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=new') . '"><span>' . BUTTON_NEW_CURRENCY . '</span></a>'; ?></td>
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
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_CURRENCY . '</b>');

      $contents = array('form' => vam_draw_form('currencies', FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_TITLE . '<br />' . vam_draw_input_field('title'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_CODE . '<br />' . vam_draw_input_field('code'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_SYMBOL_LEFT . '<br />' . vam_draw_input_field('symbol_left'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_SYMBOL_RIGHT . '<br />' . vam_draw_input_field('symbol_right'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_DECIMAL_POINT . '<br />' . vam_draw_input_field('decimal_point'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_THOUSANDS_POINT . '<br />' . vam_draw_input_field('thousands_point'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_DECIMAL_PLACES . '<br />' . vam_draw_input_field('decimal_places'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_VALUE . '<br />' . vam_draw_input_field('value'));
      $contents[] = array('text' => '<br />' . vam_draw_checkbox_field('default') . ' ' . TEXT_INFO_SET_AS_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $_GET['cID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CURRENCY . '</b>');

      $contents = array('form' => vam_draw_form('currencies', FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_TITLE . '<br />' . vam_draw_input_field('title', $cInfo->title));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_CODE . '<br />' . vam_draw_input_field('code', $cInfo->code));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_SYMBOL_LEFT . '<br />' . vam_draw_input_field('symbol_left', $cInfo->symbol_left));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_SYMBOL_RIGHT . '<br />' . vam_draw_input_field('symbol_right', $cInfo->symbol_right));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_DECIMAL_POINT . '<br />' . vam_draw_input_field('decimal_point', $cInfo->decimal_point));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_THOUSANDS_POINT . '<br />' . vam_draw_input_field('thousands_point', $cInfo->thousands_point));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_DECIMAL_PLACES . '<br />' . vam_draw_input_field('decimal_places', $cInfo->decimal_places));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_VALUE . '<br />' . vam_draw_input_field('value', $cInfo->value));
      if (DEFAULT_CURRENCY != $cInfo->code) $contents[] = array('text' => '<br />' . vam_draw_checkbox_field('default') . ' ' . TEXT_INFO_SET_AS_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CURRENCY . '</b>');

      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $cInfo->title . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br />' . (($remove_currency) ? '<a class="button" href="' . vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=deleteconfirm') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>' : '') . ' <a class="button" href="' . vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    default:
      if (is_object($cInfo)) {
        $heading[] = array('text' => '<b>' . $cInfo->title . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_CURRENCIES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->currencies_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_TITLE . ' ' . $cInfo->title);
        $contents[] = array('text' => TEXT_INFO_CURRENCY_CODE . ' ' . $cInfo->code);
        $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_SYMBOL_LEFT . ' ' . $cInfo->symbol_left);
        $contents[] = array('text' => TEXT_INFO_CURRENCY_SYMBOL_RIGHT . ' ' . $cInfo->symbol_right);
        $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_DECIMAL_POINT . ' ' . $cInfo->decimal_point);
        $contents[] = array('text' => TEXT_INFO_CURRENCY_THOUSANDS_POINT . ' ' . $cInfo->thousands_point);
        $contents[] = array('text' => TEXT_INFO_CURRENCY_DECIMAL_PLACES . ' ' . $cInfo->decimal_places);
        $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_LAST_UPDATED . ' ' . vam_date_short($cInfo->last_updated));
        $contents[] = array('text' => TEXT_INFO_CURRENCY_VALUE . ' ' . number_format($cInfo->value, 8));
        $contents[] = array('text' => '<br />' . TEXT_INFO_CURRENCY_EXAMPLE . '<br />' . $currencies->format('30', false, DEFAULT_CURRENCY) . ' = ' . $currencies->format('30', true, $cInfo->code));
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
<?php
/* --------------------------------------------------------------
   $Id: zones.php 1123 2005-07-27 09:00:31Z novalis $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(zones.php,v 1.21 2002/03/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (zones.php,v 1.8 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'insert':
        $zone_country_id = xtc_db_prepare_input($_POST['zone_country_id']);
        $zone_code = xtc_db_prepare_input($_POST['zone_code']);
        $zone_name = xtc_db_prepare_input($_POST['zone_name']);

        xtc_db_query("insert into " . TABLE_ZONES . " (zone_country_id, zone_code, zone_name) values ('" . xtc_db_input($zone_country_id) . "', '" . xtc_db_input($zone_code) . "', '" . xtc_db_input($zone_name) . "')");
        xtc_redirect(xtc_href_link(FILENAME_ZONES));
        break;
      case 'save':
        $zone_id = xtc_db_prepare_input($_GET['cID']);
        $zone_country_id = xtc_db_prepare_input($_POST['zone_country_id']);
        $zone_code = xtc_db_prepare_input($_POST['zone_code']);
        $zone_name = xtc_db_prepare_input($_POST['zone_name']);

        xtc_db_query("update " . TABLE_ZONES . " set zone_country_id = '" . xtc_db_input($zone_country_id) . "', zone_code = '" . xtc_db_input($zone_code) . "', zone_name = '" . xtc_db_input($zone_name) . "' where zone_id = '" . xtc_db_input($zone_id) . "'");
        xtc_redirect(xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $zone_id));
        break;
      case 'deleteconfirm':
        $zone_id = xtc_db_prepare_input($_GET['cID']);

        xtc_db_query("delete from " . TABLE_ZONES . " where zone_id = '" . xtc_db_input($zone_id) . "'");
        xtc_redirect(xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page']));
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
<script type="text/javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
        <td width="100%">

    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
  
  </td>
  </tr>
  <tr>
<!-- body_text //-->
    <td class="boxCenter" width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_COUNTRY_NAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ZONE_NAME; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ZONE_CODE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $zones_query_raw = "select z.zone_id, c.countries_id, c.countries_name, z.zone_name, z.zone_code, z.zone_country_id from " . TABLE_ZONES . " z, " . TABLE_COUNTRIES . " c where z.zone_country_id = c.countries_id order by c.countries_name, z.zone_name";
  $zones_split = new splitPageResults($_GET['page'], '20', $zones_query_raw, $zones_query_numrows);
  $zones_query = xtc_db_query($zones_query_raw);
  while ($zones = xtc_db_fetch_array($zones_query)) {
    if (((!$_GET['cID']) || (@$_GET['cID'] == $zones['zone_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $cInfo = new objectInfo($zones);
    }

    if ( (is_object($cInfo)) && ($zones['zone_id'] == $cInfo->zone_id) ) {
      echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $zones['zone_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $zones['countries_name']; ?></td>
                <td class="dataTableContent"><?php echo $zones['zone_name']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $zones['zone_code']; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($cInfo)) && ($zones['zone_id'] == $cInfo->zone_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $zones['zone_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $zones_split->display_count($zones_query_numrows, '20', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ZONES); ?></td>
                    <td class="smallText" align="right"><?php echo $zones_split->display_links($zones_query_numrows, '20', MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (!$_GET['action']) {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&action=new') . '">' . BUTTON_NEW_ZONE . '</a>'; ?></td>
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
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_ZONE . '</b>');

      $contents = array('form' => xtc_draw_form('zones', FILENAME_ZONES, 'page=' . $_GET['page'] . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_INFO_ZONES_NAME . '<br />' . xtc_draw_input_field('zone_name'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_ZONES_CODE . '<br />' . xtc_draw_input_field('zone_code'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_COUNTRY_NAME . '<br />' . xtc_draw_pull_down_menu('zone_country_id', xtc_get_countries()));
      $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_INSERT . '"/>&nbsp;<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page']) . '">' . BUTTON_CANCEL . '</a>');
      break;
    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_ZONE . '</b>');

      $contents = array('form' => xtc_draw_form('zones', FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_INFO_ZONES_NAME . '<br />' . xtc_draw_input_field('zone_name', $cInfo->zone_name));
      $contents[] = array('text' => '<br />' . TEXT_INFO_ZONES_CODE . '<br />' . xtc_draw_input_field('zone_code', $cInfo->zone_code));
      $contents[] = array('text' => '<br />' . TEXT_INFO_COUNTRY_NAME . '<br />' . xtc_draw_pull_down_menu('zone_country_id', xtc_get_countries(), $cInfo->countries_id));
      $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_UPDATE . '"/>&nbsp;<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id) . '">' . BUTTON_CANCEL . '</a>');
      break;
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ZONE . '</b>');

      $contents = array('form' => xtc_draw_form('zones', FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $cInfo->zone_name . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br /><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_DELETE . '"/>&nbsp;<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id) . '">' . BUTTON_CANCEL . '</a>');
      break;
    default:
      if (is_object($cInfo)) {
        $heading[] = array('text' => '<b>' . $cInfo->zone_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id . '&action=edit') . '">' . BUTTON_EDIT . '</a> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_ZONES, 'page=' . $_GET['page'] . '&cID=' . $cInfo->zone_id . '&action=delete') . '">' . BUTTON_DELETE . '</a>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_ZONES_NAME . '<br />' . $cInfo->zone_name . ' (' . $cInfo->zone_code . ')');
        $contents[] = array('text' => '<br />' . TEXT_INFO_COUNTRY_NAME . ' ' . $cInfo->countries_name);
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
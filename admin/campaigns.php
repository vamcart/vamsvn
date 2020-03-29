<?php
/* --------------------------------------------------------------
   $Id: campaigns.php 1117 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce coding standards; www.oscommerce.com
   (c) 2004	 xt:Commerce (campaigns.php,v 1.9 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

require ('includes/application_top.php');

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();

switch ($_GET['action']) {
	case 'insert' :
	case 'save' :
		$campaigns_id = vam_db_prepare_input($_GET['cID']);
		$campaigns_name = vam_db_prepare_input($_POST['campaigns_name']);
		$campaigns_refID = vam_db_prepare_input($_POST['campaigns_refID']);
		$sql_data_array = array ('campaigns_name' => $campaigns_name, 'campaigns_refID' => $campaigns_refID);

		if ($_GET['action'] == 'insert') {
			$insert_sql_data = array ('date_added' => 'now()');
			$sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
			vam_db_perform(TABLE_CAMPAIGNS, $sql_data_array);
			$campaigns_id = vam_db_insert_id();
		}
		elseif ($_GET['action'] == 'save') {
			$update_sql_data = array ('last_modified' => 'now()');
			$sql_data_array = vam_array_merge($sql_data_array, $update_sql_data);
			vam_db_perform(TABLE_CAMPAIGNS, $sql_data_array, 'update', "campaigns_id = '".vam_db_input($campaigns_id)."'");
		}

		vam_redirect(vam_href_link(FILENAME_CAMPAIGNS, 'page='.$_GET['page'].'&cID='.$campaigns_id));
		break;

	case 'deleteconfirm' :

		$campaigns_id = vam_db_prepare_input($_GET['cID']);

		vam_db_query("delete from ".TABLE_CAMPAIGNS." where campaigns_id = '".vam_db_input($campaigns_id)."'");
		vam_db_query("delete from ".TABLE_CAMPAIGNS_IP." where campaign = '".vam_db_input($campaigns_id)."'");

		if ($_POST['delete_refferers'] == 'on') {

			vam_db_query("update ".TABLE_ORDERS." set refferers_id = '' where refferers_id = '".vam_db_input($campaigns_id)."'");
			vam_db_query("update ".TABLE_CUSTOMERS." set refferers_id = '' where refferers_id = '".vam_db_input($campaigns_id)."'");
		}

		vam_redirect(vam_href_link(FILENAME_CAMPAIGNS, 'page='.$_GET['page']));
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CAMPAIGNS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php

$campaigns_query_raw = "select * from ".TABLE_CAMPAIGNS." order by campaigns_name";
$campaigns_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $campaigns_query_raw, $campaigns_query_numrows);
$campaigns_query = vam_db_query($campaigns_query_raw);
while ($campaigns = vam_db_fetch_array($campaigns_query)) {
	if (((!$_GET['cID']) || (@ $_GET['cID'] == $campaigns['campaigns_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
		$cInfo = new objectInfo($campaigns);
	}

	if ((is_object($cInfo)) && ($campaigns['campaigns_id'] == $cInfo->campaigns_id)) {
		echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\''.vam_href_link(FILENAME_CAMPAIGNS, 'page='.$_GET['page'].'&cID='.$campaigns['campaigns_id'].'&action=edit').'\'">'."\n";
	} else {
		echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\''.vam_href_link(FILENAME_CAMPAIGNS, 'page='.$_GET['page'].'&cID='.$campaigns['campaigns_id']).'\'">'."\n";
	}
?>
                <td class="dataTableContent"><?php echo $campaigns['campaigns_name']; ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($cInfo)) && ($campaigns['campaigns_id'] == $cInfo->campaigns_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . vam_href_link(FILENAME_CAMPAIGNS, 'page=' . $_GET['page'] . '&cID=' . $campaigns['campaigns_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php

}
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $campaigns_split->display_count($campaigns_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CAMPAIGNS); ?></td>
                    <td class="smallText" align="right"><?php echo $campaigns_split->display_links($campaigns_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php

if ($_GET['action'] != 'new') {
?>
              <tr>
                <td align="right" colspan="2" class="smallText">
                <?php echo '<a class="button" href="' . vam_href_link(FILENAME_CAMPAIGNS, 'page=' . $_GET['page'] . '&cID=' . $cInfo->campaigns_id . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?></td>
              </tr>
<?php

}
?>
            </table></td>
<?php

$heading = array ();
$contents = array ();
switch ($_GET['action']) {
	case 'new' :
		$heading[] = array ('text' => '<b>'.TEXT_HEADING_NEW_CAMPAIGN.'</b>');

		$contents = array ('form' => vam_draw_form('campaigns', FILENAME_CAMPAIGNS, 'action=insert', 'post', 'enctype="multipart/form-data"'));
		$contents[] = array ('text' => TEXT_NEW_INTRO);
		$contents[] = array ('text' => '<br />'.TEXT_CAMPAIGNS_NAME.'<br />'.vam_draw_input_field('campaigns_name'));
		$contents[] = array ('text' => '<br />'.TEXT_CAMPAIGNS_REFID.'<br />'.vam_draw_input_field('campaigns_refID'));
		$contents[] = array ('align' => 'center', 'text' => '<br />'.'<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>'.'&nbsp;'.'<a class="button" href="' . vam_href_link(FILENAME_CAMPAIGNS, 'page='.$_GET['page'].'&cID='.$_GET['cID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
		break;

	case 'edit' :
		$heading[] = array ('text' => '<b>'.TEXT_HEADING_EDIT_CAMPAIGN.'</b>');

		$contents = array ('form' => vam_draw_form('campaigns', FILENAME_CAMPAIGNS, 'page='.$_GET['page'].'&cID='.$cInfo->campaigns_id.'&action=save', 'post', 'enctype="multipart/form-data"'));
		$contents[] = array ('text' => TEXT_EDIT_INTRO);
		$contents[] = array ('text' => '<br />'.TEXT_CAMPAIGNS_NAME.'<br />'.vam_draw_input_field('campaigns_name', $cInfo->campaigns_name));
		$contents[] = array ('text' => '<br />'.TEXT_CAMPAIGNS_REFID.'<br />'.vam_draw_input_field('campaigns_refID', $cInfo->campaigns_refID));
		$contents[] = array ('align' => 'center', 'text' => '<br />'.'<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>'.'&nbsp;'.'<a class="button" href="' . vam_href_link(FILENAME_CAMPAIGNS, 'page='.$_GET['page'].'&cID='.$cInfo->campaigns_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
		break;

	case 'delete' :
		$heading[] = array ('text' => '<b>'.TEXT_HEADING_DELETE_CAMPAIGN.'</b>');

		$contents = array ('form' => vam_draw_form('campaigns', FILENAME_CAMPAIGNS, 'page='.$_GET['page'].'&cID='.$cInfo->campaigns_id.'&action=deleteconfirm'));
		$contents[] = array ('text' => TEXT_DELETE_INTRO);
		$contents[] = array ('text' => '<br /><b>'.$cInfo->campaigns_name.'</b>');

		if ($cInfo->refferers_count > 0) {
			$contents[] = array ('text' => '<br />'.vam_draw_checkbox_field('delete_refferers').' '.TEXT_DELETE_REFFERERS);
			$contents[] = array ('text' => '<br />'.sprintf(TEXT_DELETE_WARNING_REFFERERS, $cInfo->refferers_count));
		}

		$contents[] = array ('align' => 'center', 'text' => '<br />'.'<span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span>'.'&nbsp;'.'<a class="button" href="' . vam_href_link(FILENAME_CAMPAIGNS, 'page='.$_GET['page'].'&cID='.$cInfo->campaigns_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
		break;

	default :
		if (is_object($cInfo)) {
			$heading[] = array ('text' => '<b>'.$cInfo->campaigns_name.'</b>');

			$contents[] = array ('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_CAMPAIGNS, 'page='.$_GET['page'].'&cID='.$cInfo->campaigns_id.'&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a>'.'&nbsp;'.'<a class="button" href="' . vam_href_link(FILENAME_CAMPAIGNS, 'page='.$_GET['page'].'&cID='.$cInfo->campaigns_id.'&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');
			$contents[] = array ('text' => '<br />'.TEXT_DATE_ADDED.' '.vam_date_short($cInfo->date_added));
			if (vam_not_null($cInfo->last_modified))
				$contents[] = array ('text' => TEXT_LAST_MODIFIED.' '.vam_date_short($cInfo->last_modified));
			$contents[] = array ('text' => TEXT_REFERER.'?refID='.$cInfo->campaigns_refID);
		}
		break;
}

if ((vam_not_null($heading)) && (vam_not_null($contents))) {
	echo '            <td width="25%" valign="top">'."\n";

	$box = new box;
	echo $box->infoBox($heading, $contents);

	echo '            </td>'."\n";
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
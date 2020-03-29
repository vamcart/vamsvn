<?php
/*
  $Id: manufacturers.php, v1.2 2003/06/29 22:50:52 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (vam_not_null($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        if (isset($_GET['fID'])) $fields_id = vam_db_prepare_input($_GET['fID']);
        //$fields_name = vam_db_prepare_input($_POST['fields_name']);
        $fields_input_type = vam_db_prepare_input($_POST['fields_input_type']);
        $fields_input_value = vam_db_prepare_input($_POST['fields_input_value']);
        $fields_required_status =  vam_db_prepare_input($_POST['fields_required_status']);
        $fields_size = vam_db_prepare_input($_POST['fields_size']);
        $fields_required_email = vam_db_prepare_input($_POST['fields_required_email']);
        $sql_data_array = array('fields_status' => 1,
                                'fields_input_type' => $fields_input_type,
                                'fields_input_value' => $fields_input_value,
                                'fields_required_status' => $fields_required_status,
                                'fields_size' => $fields_size,
				'fields_required_email' => $fields_required_email);

        if ($action == 'insert') {
          vam_db_perform(TABLE_EXTRA_FIELDS, $sql_data_array);
          $fields_id = vam_db_insert_id();
        } elseif ($action == 'save') {
          vam_db_perform(TABLE_EXTRA_FIELDS, $sql_data_array, 'update', "fields_id = '" . (int)$fields_id . "'");
        }

        $languages = vam_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $fields_name_array = $_POST['fields_name'];
          $language_id = $languages[$i]['id'];

          $sql_data_array = array('fields_name' => vam_db_prepare_input($fields_name_array[$language_id]));

          if ($action == 'insert') {
            $insert_sql_data = array('fields_id' => $fields_id,
                                     'languages_id' => $language_id);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            vam_db_perform(TABLE_EXTRA_FIELDS_INFO, $sql_data_array);
          } elseif ($action == 'save') {
            vam_db_perform(TABLE_EXTRA_FIELDS_INFO, $sql_data_array, 'update', "fields_id = '" . (int)$fields_id . "' and languages_id = '" . (int)$language_id . "'");
          }
        }
        vam_redirect(vam_href_link(FILENAME_EXTRA_FIELDS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'fID=' . $fields_id));
        break;
      case 'deleteconfirm':
        $fields_id = vam_db_prepare_input($_GET['fID']);

        vam_db_query("delete from " . TABLE_EXTRA_FIELDS . " where fields_id = '" . (int)$fields_id . "'");
        vam_db_query("delete from " . TABLE_EXTRA_FIELDS_INFO . " where fields_id = '" . (int)$fields_id . "'");
	vam_db_query("delete from " . TABLE_CUSTOMERS_TO_EXTRA_FIELDS . " where fields_id = '" . (int)$fields_id . "'");

        vam_redirect(vam_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $_GET['page']));
        break;
      case 'setflag':
        $fields_id = vam_db_prepare_input($_GET['fID']);
        $flag = vam_db_prepare_input($_GET['flag']);

        $sql_data_array = array('fields_status' => $flag);
        vam_db_perform(TABLE_EXTRA_FIELDS, $sql_data_array, 'update', "fields_id = '" . (int)$fields_id . "'");

        vam_redirect(vam_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $_GET['page']));
        break;
    }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
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
        <td width="100%">

    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
  
  </td>
  </tr>
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FIELDS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $fields_query_raw = "select ce.fields_id, ce.fields_size, ce.fields_input_type, ce.fields_input_value, ce.fields_required_status, cei.fields_name, ce.fields_status, ce.fields_input_type, ce.fields_required_email from " . TABLE_EXTRA_FIELDS . " ce, " . TABLE_EXTRA_FIELDS_INFO . " cei where cei.fields_id=ce.fields_id and cei.languages_id =" . (int)$_SESSION['languages_id'];
  $fields_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $fields_query_raw, $manufacturers_query_numrows);
  $fields_query = vam_db_query($fields_query_raw);
  while ($fields = vam_db_fetch_array($fields_query)) {
  if ((!isset($_GET['fID']) || (isset($_GET['fID']) && ($_GET['fID'] == $fields['fields_id']))) && !isset($fInfo) && (substr($action, 0, 3) != 'new')) {
      $fInfo = new objectInfo($fields);
  }

    if (isset($fInfo) && is_object($fInfo) && ($fields['fields_id'] == $fInfo->fields_id)) {
      echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . vam_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $_GET['page'] . '&fID=' . $fields['fields_id'] . '&action=edit') . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . vam_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $_GET['page'] . '&fID=' . $fields['fields_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $fields['fields_name']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($fields['fields_status'] == '1') {
        echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_EXTRA_FIELDS, 'action=setflag&flag=0&fID=' . $fields['fields_id'] . '&page=' . $_GET['page']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link(FILENAME_EXTRA_FIELDS, 'action=setflag&flag=1&fID=' . $fields['fields_id'] . '&page=' . $_GET['page']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?>              </td>
                <td class="dataTableContent" align="right"><?php if (isset($fInfo) && is_object($fInfo) && ($fields['fields_id'] == $fInfo->fields_id)) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . vam_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $_GET['page'] . '&fID=' . $fields['fields_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $fields_split->display_count($manufacturers_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_FIELDS); ?></td>
                    <td class="smallText" align="right"><?php echo $fields_split->display_links($manufacturers_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
  if (empty($action)) {
?>
              <tr>
                <td align="right" colspan="3" class="smallText"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $_GET['page'] . '&fID=' . $fInfo->fields_id . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?></td>
              </tr>
<?php
  }
?>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_FIELD . '</b>');

      $contents = array('form' => vam_draw_form('fields', FILENAME_EXTRA_FIELDS, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_NEW_INTRO);
      $field_inputs_string = '';
      $languages = vam_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $field_inputs_string .= '<br>' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field('fields_name[' . $languages[$i]['id'] . ']');
      }
      $contents[] = array('text' => '<br>' . TEXT_FIELD_NAME . $field_inputs_string);      
	  	$contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . '<br>' . vam_draw_radio_field('fields_input_type', 0, ($fInfo->fields_input_type==0) ? true : false) . TEXT_INPUT_FIELD . '<br>' .
																																							vam_draw_radio_field('fields_input_type', 1, ($fInfo->fields_input_type==1) ? true : false) . TEXT_TEXTAREA_FIELD . '<br>' .
                                                                              vam_draw_radio_field('fields_input_type', 2, ($fInfo->fields_input_type==2) ? true : false) . TEXT_RADIO_FIELD . '<br>' .
                                                                              vam_draw_radio_field('fields_input_type', 3, ($fInfo->fields_input_type==3) ? true : false) . TEXT_CHECK_FIELD . '<br>' .
                                                                              vam_draw_radio_field('fields_input_type', 4, ($fInfo->fields_input_type==4) ? true : false) . TEXT_DOWN_FIELD);
      $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_VALUE . '<br>' . vam_draw_textarea_field('fields_input_value', 'nowrap', /*$width*/ 30, /*$height*/ 8, $fInfo->fields_input_value /*, $parameters = '', $reinsert_value = true*/));
			$contents[] = array('text' => '<br>' . TEXT_FIELD_REQUIRED_STATUS . '<br>' . vam_draw_radio_field('fields_required_status', 0, ($fInfo->fields_required_status==0) ? true : false) . 'false<br>' . vam_draw_radio_field('fields_required_status', 1, ($fInfo->fields_required_status==1) ? true : false) . 'true');
      $contents[] = array('text' =>  TEXT_FIELD_SIZE . '<br>' . vam_draw_input_field('fields_size',$fInfo->fields_size));
	  $contents[] = array('text' => '<br>' . TEXT_FIELD_STATUS_EMAIL . '<br>' . vam_draw_radio_field('fields_required_email', 0, ($fInfo->fields_required_email==0) ? true : false) . 'false<br>' . vam_draw_radio_field('fields_required_email', 1, ($fInfo->fields_required_email==1) ? true : false) . 'true');
      $contents[] = array('align' => 'center', 'text' => '<br><span class="button"><button type="submit" value="' . BUTTON_SAVE .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $_GET['page'] . '&fID=' . $_GET['fID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;
    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_FIELD . '</b>');

      $contents = array('form' => vam_draw_form('fields', FILENAME_EXTRA_FIELDS, 'page=' . $_GET['page'] . '&fID=' . $fInfo->fields_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);
      $field_inputs_string = '';
      $languages = vam_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $field_inputs_string .= '<br>' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_input_field('fields_name[' . $languages[$i]['id'] . ']',vam_get_customers_extra_fields_name($fInfo->fields_id, $languages[$i]['id']));
      }
      $contents[] = array('text' => '<br>' . TEXT_FIELD_NAME . $field_inputs_string);
      $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . '<br>' . vam_draw_radio_field('fields_input_type', 0, ($fInfo->fields_input_type==0) ? true : false) . TEXT_INPUT_FIELD . '<br>' .
																																							vam_draw_radio_field('fields_input_type', 1, ($fInfo->fields_input_type==1) ? true : false) . TEXT_TEXTAREA_FIELD . '<br>' .
                                                                              vam_draw_radio_field('fields_input_type', 2, ($fInfo->fields_input_type==2) ? true : false) . TEXT_RADIO_FIELD . '<br>' .
                                                                              vam_draw_radio_field('fields_input_type', 3, ($fInfo->fields_input_type==3) ? true : false) . TEXT_CHECK_FIELD . '<br>' .
                                                                              vam_draw_radio_field('fields_input_type', 4, ($fInfo->fields_input_type==4) ? true : false) . TEXT_DOWN_FIELD);
      $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_VALUE . '<br>' . vam_draw_textarea_field('fields_input_value', 'nowrap', /*$width*/ 30, /*$height*/ 8, $fInfo->fields_input_value /*, $parameters = '', $reinsert_value = true*/));
			$contents[] = array('text' => '<br>' . TEXT_FIELD_REQUIRED_STATUS . '<br>' . vam_draw_radio_field('fields_required_status', 0, ($fInfo->fields_required_status==0) ? true : false) . 'false<br>' . vam_draw_radio_field('fields_required_status', 1, ($fInfo->fields_required_status==1) ? true : false) . 'true');
      $contents[] = array('text' =>  TEXT_FIELD_SIZE . '<br>' . vam_draw_input_field('fields_size', $fInfo->fields_size));
	  $contents[] = array('text' => '<br>' . TEXT_FIELD_STATUS_EMAIL . '<br>' . vam_draw_radio_field('fields_required_email',0,($fInfo->fields_required_email==0)?true:false) . 'false<br>' . vam_draw_radio_field('fields_required_email',1,($fInfo->fields_required_email==1)?true:false) . 'true');
      $contents[] = array('align' => 'center', 'text' => '<br><span class="button"><button type="submit" value="' . BUTTON_SAVE .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $_GET['page'] . '&fID=' . $fInfo->fields_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_FIELD . '</b>');
      $contents = array('form' => vam_draw_form('manufacturers', FILENAME_EXTRA_FIELDS, 'page=' . $_GET['page'] . '&fID=' . $fInfo->fields_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br><b>' . $fInfo->fields_name . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br><span class="button"><button type="submit" value="' . BUTTON_DELETE .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $_GET['page'] . '&fID=' . $fInfo->fields_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;
    default:
      if (isset($fInfo) && is_object($fInfo)) {
        $heading[] = array('text' => '<b>' . $fInfo->fields_name . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $_GET['page'] . '&fID=' . $fInfo->fields_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_EXTRA_FIELDS, 'page=' . $_GET['page'] . '&fID=' . $fInfo->fields_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');
        $contents[] = array('text' => '<br>' . TEXT_FIELD_NAME .  $fInfo->fields_name);
				switch($fInfo->fields_input_type)
				{
				  case  0: $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . TEXT_INPUT_FIELD ); break;
				  case  1: $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . TEXT_TEXTAREA_FIELD ); break;
				  case  2: $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . TEXT_RADIO_FIELD ); break;
				  case  3: $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . TEXT_CHECK_FIELD ); break;
				  case  4: $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . TEXT_DOWN_FIELD ); break;
				  default: $contents[] = array('text' => '<br>' . TEXT_FIELD_INPUT_TYPE . TEXT_INPUT_FIELD );
				}
        $contents[] = array('text' => TEXT_FIELD_REQUIRED_STATUS . (($fInfo->fields_required_status==1) ? 'true' : 'false'));
        $contents[] = array('text' => TEXT_FIELD_SIZE .  $fInfo->fields_size);
		$contents[] = array('text' => TEXT_FIELD_REQUIRED_EMAIL . (($fInfo->fields_required_email==1) ? 'true' : 'false'));
        $contents[] = array('text' => '<br>');
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
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
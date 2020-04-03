<?php
/*
  $Id: product_extra_field.php,v 2.0 2004/11/09 22:50:52 ChBu Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
  * 
  * v2.0: added languages support
*/
require('includes/application_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
// Has "Remove" button been pressed?
if (isset($_POST['remove'])) $action='remove';

if (vam_not_null($action)) {
  switch ($action) {
    case 'setflag':
      $sql_data_array = array('products_extra_fields_status' => vam_db_prepare_input($_GET['flag']));
	  vam_db_perform(TABLE_PRODUCTS_EXTRA_FIELDS, $sql_data_array, 'update', 'products_extra_fields_id=' . $_GET['id']);
      vam_redirect(vam_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS));	
	  break;
    case 'add':
      $sql_data_array = array('products_extra_fields_name' => vam_db_prepare_input($_POST['field']['name']),
	                          'languages_id' => vam_db_prepare_input ($_POST['field']['language']),
							  'products_extra_fields_order' => vam_db_prepare_input($_POST['field']['order']));
			vam_db_perform(TABLE_PRODUCTS_EXTRA_FIELDS, $sql_data_array, 'insert');

      vam_redirect(vam_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS));
      break;
    case 'update':
      foreach ($_POST['field'] as $key=>$val) {
        $sql_data_array = array('products_extra_fields_name' => vam_db_prepare_input($val['name']),
		                        'languages_id' =>  vam_db_prepare_input($val['language']),
			   					'products_extra_fields_order' => vam_db_prepare_input($val['order']));
			  vam_db_perform(TABLE_PRODUCTS_EXTRA_FIELDS, $sql_data_array, 'update', 'products_extra_fields_id=' . $key);
      }
      vam_redirect(vam_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS));

      break;
    case 'remove':
      //print_r($_POST['mark']);
      if ($_POST['mark']) {
        foreach ($_POST['mark'] as $key=>$val) {
          vam_db_query("DELETE FROM " . TABLE_PRODUCTS_EXTRA_FIELDS . " WHERE products_extra_fields_id=" . vam_db_input($key));
          vam_db_query("DELETE FROM " . TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS . " WHERE products_extra_fields_id=" . vam_db_input($key));
        }
        vam_redirect(vam_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS));
      }

      break;
  }
}

// Put languages information into an array for drop-down boxes
  $languages=vam_get_languages();
  $values[0]=array ('id' =>'0', 'text' => TEXT_ALL_LANGUAGES);
  for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
	$values[$i+1]=array ('id' =>$languages[$i]['id'], 'text' =>$languages[$i]['name']);
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
  <td width="100%" valign="top">
   <table border="0" width="100%" cellspacing="0" cellpadding="2">
    <tr>
     <td width="100%">
      <table border="0" width="100%" cellspacing="0" cellpadding="0">
       <tr>
        <td class="main">
        
    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
        
        
        </td>
       </tr>
      </table>
     </td>
    </tr>

    <tr>
     <td width="100%">
      <!--
      <div style="font-family: verdana; font-weight: bold; font-size: 17px; margin-bottom: 8px; color: #727272;">
       <?php echo SUBHEADING_TITLE; ?>
      </div>
      -->
      <br />
      <?php echo vam_draw_form("add_field", FILENAME_PRODUCTS_EXTRA_FIELDS, 'action=add', 'post'); ?>
      <table border="0" width="400" cellspacing="2" cellpadding="0" class="contentListingTable">
       <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FIELDS; ?></td>
        <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ORDER; ?></td>
		<td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_LANGUAGE; ?></td>
       </tr>

       <tr>
        <td class="dataTableContent">
         <?php echo vam_draw_input_field('field[name]', $field['name'], 'size=30', false, 'text', true);?>
        </td>
		<td class="dataTableContent" align="center">
         <?php echo vam_draw_input_field('field[order]', $field['order'], 'size=5', false, 'text', true);?>
        </td>
		<td class="dataTableContent" align="center">
         <?php
		 echo vam_draw_pull_down_menu('field[language]', $values, '0', '');?>
        </td>		
        <td class="dataTableHeadingContent" align="right">
	<?php echo '<span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button>'; ?></span>
        </td>
       </tr>
       </form>
      </table>
      <hr />
      <br>
      <?php
       echo vam_draw_form('extra_fields', FILENAME_PRODUCTS_EXTRA_FIELDS,'action=update','post');
      ?>
      <?php echo $action_message; ?>
      <table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
       <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" width="20">&nbsp;</td>
        <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FIELDS; ?></td>
        <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_ORDER; ?></td>
		<td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_LANGUAGE; ?></td>
        <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
       </tr>
<?php
$products_extra_fields_query = vam_db_query("SELECT * FROM " . TABLE_PRODUCTS_EXTRA_FIELDS . " ORDER BY products_extra_fields_order");
while ($extra_fields = vam_db_fetch_array($products_extra_fields_query)) {
?>
       <tr>
        <td width="20">
         <?php echo vam_draw_checkbox_field('mark['.$extra_fields['products_extra_fields_id'].']', 1) ?>
        </td>
        <td class="dataTableContent">
         <?php echo vam_draw_input_field('field['.$extra_fields['products_extra_fields_id'].'][name]', $extra_fields['products_extra_fields_name'], 'size=30', false, 'text', true);?>
        </td>
		<td class="dataTableContent" align="center">
         <?php echo vam_draw_input_field('field['.$extra_fields['products_extra_fields_id'].'][order]', $extra_fields['products_extra_fields_order'], 'size=5', false, 'text', true);?>
        </td>
		<td class="dataTableContent" align="center">
		 <?php echo vam_draw_pull_down_menu('field['.$extra_fields['products_extra_fields_id'].'][language]', $values, $extra_fields['languages_id'], ''); ?>
        </td>	
				<td  class="dataTableContent" align="center">
         <?php
          if ($extra_fields['products_extra_fields_status'] == '1') {
            echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS, 'action=setflag&flag=0&id=' . $extra_fields['products_extra_fields_id'], 'NONSSL') . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
          }
          else {
            echo '<a href="' . vam_href_link(FILENAME_PRODUCTS_EXTRA_FIELDS, 'action=setflag&flag=1&id=' . $extra_fields['products_extra_fields_id'], 'NONSSL') . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
          }
         ?>
        </td>
       </tr>
<?php } ?>
       <tr>
        <td colspan="4">
         <?php echo '<span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>'; ?> 
         &nbsp;&nbsp;
	 <?php echo '<span class="button"><button type="submit" value="' . BUTTON_DELETE . '" name="remove">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span>'; ?>
        </td>
       </tr>
       </form>
      </table>
     </td>
    </tr>
   </table>
  </td>
 <!-- body_text_eof //-->
 </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
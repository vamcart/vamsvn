<?php
/*
  $Id: backup.php,v 1.60 2003/06/29 22:50:51 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  $action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : '');

  if (vam_not_null($action)) {
    switch ($action) {
    	case 'load':
    		$pid=(int)$_POST['products_id'];
    		$pin_unparsed=trim($_REQUEST['pinstext']);
    		$pins=preg_split("/[\s\,\;]+/",$pin_unparsed);
    		$pcount=0;
    		foreach ($pins as $p) {
    			vam_db_query("INSERT INTO ".TABLE_PRODUCTS_PINS." SET products_id='$pid', products_pin_code='".vam_db_prepare_input($p)."', products_pin_used=0");
    			$pcount++;

    		}
    		$messageStack->add($pcount.PINS_ADDED.vam_get_products_name($pid), 'success');

    		$query_str = "SELECT products_id, COUNT(products_id) AS pcount FROM ".TABLE_PRODUCTS_PINS." where products_pin_used = 0 GROUP BY products_id";
    		$pins_query=vam_db_query($query_str);
    		while($pin_res=vam_db_fetch_array($pins_query)) {
				vam_db_query("UPDATE products SET products_quantity='".$pin_res['pcount']."' WHERE products_id='".$pin_res['products_id']."'");
			}
			$messageStack->add(PINS_QUANTIY_UPDATED, 'success');
		break;

    	case 'edit':
    		$query_str = "select * from ".TABLE_PRODUCTS_PINS." where products_id = ".$_REQUEST['products_id']." and products_pin_used = 0";
    		$pins_query=vam_db_query($query_str);
    		$pin_stack = '';
    		while($pin_res = vam_db_fetch_array($pins_query)) {
    			$pin_stack .= $pin_res['products_pin_code'] . "\n";
			}
		break;
		
		case 'update':
			$pid=(int)$_POST['products_id'];
    		$pin_unparsed=trim($_REQUEST['pinstext']);
    		$pins=preg_split("/[\s\,\;]+/",$pin_unparsed);
    		$pcount=0;
    		
    		// deleting all unsued PINs of this product
    		vam_db_query("delete from ".TABLE_PRODUCTS_PINS." where products_id='".$pid."' and products_pin_used = 0 ");
    		
    		// inserting edited PINs
    		foreach ($pins as $p) {
    			vam_db_query("INSERT INTO ".TABLE_PRODUCTS_PINS." SET products_id='".$pid."', products_pin_code='".vam_db_prepare_input($p)."', products_pin_used=0");
    			$pcount++;
    		}
    		$messageStack->add($pcount.PINS_ADDED.vam_get_products_name($pid), 'success');

    		// updating products quantity
    		$query_str = "SELECT products_id, COUNT(products_id) AS pcount FROM ".TABLE_PRODUCTS_PINS." where products_pin_used = 0 GROUP BY products_id";
    		$pins_query=vam_db_query($query_str);
    		while($pin_res=vam_db_fetch_array($pins_query)) {
				vam_db_query("UPDATE products SET products_quantity='".$pin_res['pcount']."' WHERE products_id='".$pin_res['products_id']."'");
			}
			$messageStack->add(PINS_QUANTIY_UPDATED, 'success');
		break;
		
     default:
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
        <td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo vam_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table>
		</td>
      </tr>
      <tr>
        <td>
<?php
if($action=='upload') {
	echo vam_draw_form('pin',FILENAME_PIN_LOADER);
?>
	<table><tr><td><select name="products_id">
<?php
    $products = vam_db_query("select p.products_id, pd.products_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.language_id = '" . $_SESSION['languages_id'] . "' order by pd.products_name");
    while ($products_values = vam_db_fetch_array($products)) {
    	echo '<option name="' . $products_values['products_name'] . '" value="' . $products_values['products_id'] . '">' . $products_values['products_name'] . '</option>';
    }
?>
    </select></td></tr><tr><td>
    <?php echo vam_draw_hidden_field('action','load'); ?>
    </td></tr><tr><td>
    <?php echo vam_draw_textarea_field('pinstext','soft',50,15); ?>
    </td></tr><tr><td>
    <span class="button"><button type="submit" onClick="return confirm('<?php echo BUTTON_UPDATE; ?>')" value="<?php echo BUTTON_UPDATE; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_UPDATE; ?></button></span>
    </td></tr></table></form>
    <?php

} 
else if($action=='edit') {
	echo vam_draw_form('pin', FILENAME_PIN_LOADER);
?>
	<table>
		<tr>
			<td class="main"><?php echo PIN_ACTION_EDIT; ?> <b><?php echo vam_get_products_name($_REQUEST['products_id']);?></b></td>
		</tr>
		<tr>
			<td><?php echo vam_draw_hidden_field('action', 'update') . vam_draw_hidden_field('products_id', $_REQUEST['products_id']); ?>&nbsp;</td>
		</tr>
		<tr>
			<td><?php echo vam_draw_textarea_field('pinstext', 'soft', 50, 30, $pin_stack);?></td>
		</tr>
		<tr>
			<span class="button"><button type="submit" onClick="return confirm('<?php echo BUTTON_UPDATE; ?>')" value="<?php echo BUTTON_UPDATE; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_UPDATE; ?></button></span>
		</tr>
	</table>
    </form>
    <?php

}
else { // default action - show stats
	?>
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
			<table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent" width="40%"><?php echo PIN_HEADING_PRODUCT; ?></td>
                <td class="dataTableHeadingContent" width="40%"><?php echo PIN_HEADING_NUMBEROF; ?></td>
                <td class="dataTableHeadingContent" width="20%"><?php echo PIN_HEADING_ACTION; ?></td>
                </tr>
	<?php
	$query_str = "SELECT pp.products_id, p.products_quantity AS pcount, count(*) AS all_pin FROM ".TABLE_PRODUCTS_PINS." pp, " . TABLE_PRODUCTS . " p where pp.products_id = p.products_id GROUP BY pp.products_id";
	//echo($query_str);
	$pins_query=vam_db_query($query_str);

	$odd_even = 1;
	while($pin_res=vam_db_fetch_array($pins_query)) {
		$row_class = ( ($odd_even % 2) == 0 ) ? 'dataTableRowSelected' : 'dataTableRow';
		?>
		<tr class="<?php echo $row_class?>">
		<td class="dataTableContent">
		<?php echo vam_get_products_name($pin_res['products_id']);?></td>
		<td class="dataTableContent"><?php echo $pin_res['pcount'].' / ' . $pin_res['all_pin']?></td>
		<td class="dataTableContent"><a href="<?php echo vam_href_link(FILENAME_PIN_LOADER, 'action=edit&products_id='.$pin_res['products_id'], 'SSL');?>"><?php echo PIN_ACTION_EDIT?></a></td>
		</tr>
	<?php
	$odd_even++;
	}

	/*
	$pins_query=vam_db_query("SELECT products_id, COUNT(*) AS pcount FROM ".TABLE_PRODUCTS_PINS." GROUP BY products_id");
	while($pin_res=vam_db_fetch_array($pins_query)) {

		echo '<tr class="dataTableRow"><td class="dataTableContent">'.vam_get_products_name($pin_res['products_id']).'</td><td class="dataTableContent">'.$pin_res['pcount'].'</td></tr>';
	} */
	?>
	</table>
    <br><a class="button" href="<?php echo vam_href_link(FILENAME_PIN_LOADER,'action=upload','SSL')?>"><span><?php echo BUTTON_UPLOAD; ?></span></a>
	<?php
 }

?>




        </td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
</td>
</tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php');?>
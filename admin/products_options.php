<?php
/* --------------------------------------------------------------
   $Id: products_options.php 1155 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(products_attributes.php,v 1.48 2002/11/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (products_attributes.php,v 1.10 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (products_attributes.php,v 1.10 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php'); 
  $languages = vam_get_languages();

  $type_array = array();
  //$type_array[]=array('id'=>'0','text'=>TEXT_TYPE_SELECT);
  $type_array[]=array('id'=>'1','text'=>TEXT_TYPE_DROPDOWN);
  $type_array[]=array('id'=>'2','text'=>TEXT_TYPE_TEXT);
  $type_array[]=array('id'=>'3','text'=>TEXT_TYPE_TEXTAREA);
  $type_array[]=array('id'=>'4','text'=>TEXT_TYPE_RADIO);
  $type_array[]=array('id'=>'5','text'=>TEXT_TYPE_CHECKBOX);
  $type_array[]=array('id'=>'6','text'=>TEXT_TYPE_READ_ONLY);

  if ($_GET['action']) {
    $page_info = 'option_page=' . $_GET['option_page'] . '&value_page=' . $_GET['value_page'] . '&attribute_page=' . $_GET['attribute_page'];
    switch($_GET['action']) {
      case 'add_product_options':
        for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
          $option_name = $_POST['option_name'];
          $option_rows = (int)$_POST['option_rows'];
          $option_size = (int)$_POST['option_size'];
          $option_length = (int)$_POST['option_length'];
          $option_sort_order = (int)$_POST['option_sort_order'];
          $option_type = (int)$_POST['options_type'];      
          
          vam_db_query("insert into " . TABLE_PRODUCTS_OPTIONS . " (products_options_id,products_options_name, language_id,products_options_type,products_options_length,products_options_rows,products_options_size,sortorder) values ('" . $_POST['products_options_id'] . "', '" . $option_name[$languages[$i]['id']] . "', '" . $languages[$i]['id'] . "','".$option_type."','".$option_length."','".$option_rows."','".$option_size."','".$option_sort_order."')");
        }
        vam_redirect(vam_href_link(FILENAME_PRODUCTS_OPTIONS, $page_info)); 
        break;

      case 'add_product_attributes':
        vam_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES . " values ('', '" . $_POST['products_id'] . "', '" . $_POST['options_id'] . "', '" . $_POST['values_id'] . "', '" . $_POST['value_price'] . "', '" . $_POST['price_prefix'] . "')");
        $products_attributes_id = vam_db_insert_id();
        if ((DOWNLOAD_ENABLED == 'true') && $_POST['products_attributes_filename'] != '') {
          vam_db_query("insert into " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " values (" . $products_attributes_id . ", '" . $_POST['products_attributes_filename'] . "', '" . $_POST['products_attributes_maxdays'] . "', '" . $_POST['products_attributes_maxcount'] . "')");
        }
        vam_redirect(vam_href_link(FILENAME_PRODUCTS_OPTIONS, $page_info));
        break;
      case 'update_option_name':
        for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
          $option_name = $_POST['option_name'];
          $id = (int)$_POST['option_id'];
          $option_rows = (int)$_POST['option_rows'];
          $option_size = (int)$_POST['option_size'];
          $option_length = (int)$_POST['option_length'];
          $option_sort_order = (int)$_POST['option_sort_order'];
          $option_type = (int)$_POST['options_type']; 
          vam_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set products_options_name = '" . $option_name[$languages[$i]['id']] . "' where products_options_id = '" . $id . "' and language_id = '" . $languages[$i]['id'] . "'");
          // update fields
          vam_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set products_options_type = '" . $option_type . "' where products_options_id = '" . $id . "' and language_id = '" . $languages[$i]['id'] . "'");	
          vam_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set products_options_length = '" . $option_length . "' where products_options_id = '" . $id . "' and language_id = '" . $languages[$i]['id'] . "'");	
          vam_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set sortorder = '" . $option_sort_order . "' where products_options_id = '" . $id . "' and language_id = '" . $languages[$i]['id'] . "'");	
          vam_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set products_options_rows = '" . $option_rows . "' where products_options_id = '" . $id . "' and language_id = '" . $languages[$i]['id'] . "'");	
          vam_db_query("update " . TABLE_PRODUCTS_OPTIONS . " set products_options_size = '" . $option_size . "' where products_options_id = '" . $id . "' and language_id = '" . $languages[$i]['id'] . "'");	
        	 
        }

        
        
        vam_redirect(vam_href_link(FILENAME_PRODUCTS_OPTIONS, $page_info));
        break;
      case 'update_value':
       $value_name = $_POST['value_name'];
       $value_desc = $_POST['value_description'];
          
       for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
         vam_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_name = '" . $value_name[$languages[$i]['id']] . "',products_options_values_description = '".$value_desc[$languages[$i]['id']]."'  where products_options_values_id = '" . $_POST['value_id'] . "' and language_id = '" . $languages[$i]['id'] . "'");
       }
       
       
		
		//prepare products_image filename
		if ($image = vam_try_upload('value_image', DIR_FS_CATALOG_IMAGES.'product_options/', '777', '')) {
			$pname_arr = explode('.', $image->filename);
			$nsuffix = array_pop($pname_arr);
			$value_image_name = $_POST['value_id'].'_0.'.$nsuffix;

			rename(DIR_FS_CATALOG_IMAGES.'product_options/'.$image->filename, DIR_FS_CATALOG_IMAGES.'product_options/'.$value_image_name);
			$data=array();
			$data['products_options_values_id'] = vam_db_prepare_input($_POST['value_id']);
			$data['image_nr'] = '0';
			$data['image_name'] = vam_db_prepare_input($value_image_name);
			// image already exists ?
			$_imgQuery = vam_db_query("SELECT count(*) as count FROM ".TABLE_PRODUCTS_OPTIONS_IMAGES." WHERE image_nr='0' and products_options_values_id='".$data['products_options_values_id']."'");
			$_imgQuery = vam_db_fetch_array($_imgQuery);
			if ($_imgQuery['count']>0) {

			} else {		
				vam_db_perform(TABLE_PRODUCTS_OPTIONS_IMAGES,$data);
			}
		}
		
		for ($img = 0; $img < MO_PICS; $img ++) {
			if ($pIMG = & vam_try_upload('mo_pics_'.$img, DIR_FS_CATALOG_IMAGES.'product_options/', '777', '')) {
				$pname_arr = explode('.', $pIMG->filename);
				$nsuffix = array_pop($pname_arr);
				$value_image_name = $_POST['value_id'].'_'. ($img +1).'.'.$nsuffix;
				
				
				rename(DIR_FS_CATALOG_IMAGES.'product_options/'.$pIMG->filename, DIR_FS_CATALOG_IMAGES.'product_options/'.$value_image_name);
				//get data & write to table
				$mo_img = array ('products_options_values_id' => vam_db_prepare_input($_POST['value_id']), 'image_nr' => vam_db_prepare_input($img +1), 'image_name' => vam_db_prepare_input($value_image_name));
//				if ($action == 'insert') {
				
				$_imgQuery = vam_db_query("SELECT count(*) as count FROM ".TABLE_PRODUCTS_OPTIONS_IMAGES." WHERE image_nr='".($img +1)."' and products_options_values_id='". vam_db_prepare_input($_POST['value_id'])."'");
				$_imgQuery = vam_db_fetch_array($_imgQuery);
				if ($_imgQuery['count']>0) {

				} else {		
				vam_db_perform(TABLE_PRODUCTS_OPTIONS_IMAGES,$mo_img);
				}
		
			}
		}
		
		if ($_POST['del_mo_pic'] != '') {
			foreach ($_POST['del_mo_pic'] AS $dummy => $val) {

					@ vam_del_image_options_file($val);
				vam_db_query("DELETE FROM ".TABLE_PRODUCTS_OPTIONS_IMAGES."
									               WHERE products_options_values_id = '".vam_db_input($_POST['value_id'])."' AND image_name  = '".$val."'");

			}
		}
		
		//are we asked to delete some pics?
		if ($_POST['del_pic'] != '') {
			@vam_del_image_options_file($products_data['del_pic']);
//			vam_db_query("UPDATE ".TABLE_PRODUCTS_OPTIONS_IMAGES."
//								                 SET products_options_values_id = ''
//									               WHERE products_options_values_id    = '".vam_db_input($_POST['del_pic'])."'");
			vam_db_query("DELETE FROM ".TABLE_PRODUCTS_OPTIONS_IMAGES."
									               WHERE products_options_values_id = '".vam_db_input($_POST['value_id'])."' AND image_name  = '".$val."'");						             
		}
       
       
       vam_db_query("update " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " set products_options_id = '" . $_POST['option_id'] . "' where products_options_values_id = '" . $_POST['value_id'] . "'");
       vam_redirect(vam_href_link(FILENAME_PRODUCTS_OPTIONS, $page_info));
       break;
      case 'update_product_attribute':
        vam_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES . " set products_id = '" . $_POST['products_id'] . "', options_id = '" . $_POST['options_id'] . "', options_values_id = '" . $_POST['values_id'] . "', options_values_price = '" . $_POST['value_price'] . "', price_prefix = '" . $_POST['price_prefix'] . "' where products_attributes_id = '" . $_POST['attribute_id'] . "'");
        if ((DOWNLOAD_ENABLED == 'true') && $_POST['products_attributes_filename'] != '') {
          vam_db_query("update " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " 
                        set products_attributes_filename='" . $_POST['products_attributes_filename'] . "',
                            products_attributes_maxdays='" . $_POST['products_attributes_maxdays'] . "',
                            products_attributes_maxcount='" . $_POST['products_attributes_maxcount'] . "'
                        where products_attributes_id = '" . $_POST['attribute_id'] . "'");
        }
        vam_redirect(vam_href_link(FILENAME_PRODUCTS_OPTIONS, $page_info));
        break;
      case 'delete_option':
    
    $del_options = vam_db_query("select products_options_values_id from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . $_GET['option_id'] . "'");
    while($del_options_values = vam_db_fetch_array($del_options)){  
    	  vam_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . $_GET['option_id'] . "'");
       	 }
        vam_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . $_GET['option_id'] . "'");
        vam_db_query("delete from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . $_GET['option_id'] . "'");
 
        vam_redirect(vam_href_link(FILENAME_PRODUCTS_OPTIONS, $page_info));
        break;
      case 'delete_value':
        vam_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . $_GET['value_id'] . "'");
        vam_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . $_GET['value_id'] . "'");
        vam_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_values_id = '" . $_GET['value_id'] . "'");
        vam_redirect(vam_href_link(FILENAME_PRODUCTS_OPTIONS, $page_info));
        break;
      case 'delete_attribute':
        vam_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_attributes_id = '" . $_GET['attribute_id'] . "'");
// Added for DOWNLOAD_ENABLED. Always try to remove attributes, even if downloads are no longer enabled
        vam_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD . " where products_attributes_id = '" . $_GET['attribute_id'] . "'");
        vam_redirect(vam_href_link(FILENAME_PRODUCTS_OPTIONS, $page_info));
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
<script type="text/javascript"><!--
function go_option() {
  if (document.option_order_by.selected.options[document.option_order_by.selected.selectedIndex].value != "none") {
    location = "<?php echo vam_href_link(FILENAME_PRODUCTS_OPTIONS, 'option_page=' . ($_GET['option_page'] ? $_GET['option_page'] : 1)); ?>&option_order_by="+document.option_order_by.selected.options[document.option_order_by.selected.selectedIndex].value;
  }
}
//--></script>
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
    
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE_OPT . ' - ' . HEADING_TITLE_VAL; ?></td>
<?php 
$manual_link = 'add-attribute';
?>
            <td class="pageHeading" align="right"><a class="button" href="<?php echo MANUAL_LINK_ATTRIBUTE.'#'.$manual_link; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>
    
	<table border="0" align="right" cellpadding="2" cellspacing="0">
		<tr>
			<td class="main">
			<form name="search" action="<?php echo FILENAME_PRODUCTS_OPTIONS; ?>" method="GET">
			<?php echo TEXT_SEARCH; ?><input type="text" name="searchoption" size="20" value="<?php echo $_GET['searchoption']; ?>">
			</form>
			</td>
			<td class="main">
			<form name="option_order_by" action="<?php echo FILENAME_PRODUCTS_OPTIONS; ?>">
			<select name="selected" onChange="go_option()">
			<option value="products_options_id"<?php if ($option_order_by == 'products_options_id') { echo ' SELECTED'; } ?>>
			<?php echo TEXT_OPTION_ID; ?></option>
			<option value="products_options_name"<?php if ($option_order_by == 'products_options_name') { echo ' SELECTED'; } ?>>
			<?php echo TEXT_OPTION_NAME; ?></option>
			</select>
			</form>		
			</td>
		</tr>
	</table>	    
    <br />
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
<!-- options and values//-->
            <td valign="top" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="2">
<!-- options and values//-->
      <tr>
        <td width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" class="main" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="2">

<!-- options //-->
<?php
  if ($_GET['action'] == 'delete_product_option') { // delete product option
    $options = vam_db_query("select products_options_id, products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . $_GET['option_id'] . "' and language_id = '" . $_SESSION['languages_id'] . "'");
    $options_values = vam_db_fetch_array($options);
?>
              <tr>
                <td class="pageHeading">&nbsp;<?php echo $options_values['products_options_name']; ?>&nbsp;</td>
                <td>&nbsp;<?php echo vam_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '1', '53'); ?>&nbsp;</td>
              </tr>
              <tr>
                <td><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
                  <tr>
                    <td colspan="3"><?php echo vam_black_line(); ?></td>
                  </tr>
<?php
    $products = vam_db_query("select p.products_id, pd.products_name, pov.products_options_values_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov, " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pov.language_id = '" . $_SESSION['languages_id'] . "' and pd.language_id = '" . $_SESSION['languages_id'] . "' and pa.products_id = p.products_id and pa.options_id='" . $_GET['option_id'] . "' and pov.products_options_values_id = pa.options_values_id order by pd.products_name");
    if (vam_db_num_rows($products)) {
?>
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_ID; ?>&nbsp;</td>
                    <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT; ?>&nbsp;</td>
                    <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_VALUE; ?>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3"><?php echo vam_black_line(); ?></td>
                  </tr>
<?php
      while ($products_values = vam_db_fetch_array($products)) {
        $rows++;
?>
                  <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
                    <td align="center" class="smallText">&nbsp;<?php echo $products_values['products_id']; ?>&nbsp;</td>
                    <td class="smallText">&nbsp;<?php echo $products_values['products_name']; ?>&nbsp;</td>
                    <td class="smallText">&nbsp;<?php echo $products_values['products_options_values_name']; ?>&nbsp;</td>
                  </tr>
<?php
      }
?>
                  <tr>
                    <td colspan="3"><?php echo vam_black_line(); ?></td>
                  </tr>
                  <tr>
                    <td colspan="3" class="main"><br /><?php echo TEXT_WARNING_OF_DELETE; ?></td>
                  </tr>
                  <tr>
                    <td align="right" colspan="3" class="main"><br />
                    <?php echo '<a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, '&value_page=' . $_GET['value_page'] . '&attribute_page=' . $attribute_page, 'NONSSL') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?>&nbsp;</td>
                  </tr>
<?php
    } else {
?>
                  <tr>
                    <td class="main" colspan="3"><br /><?php echo TEXT_OK_TO_DELETE; ?></td>
                  </tr>
                  <tr>
                    <td class="main" align="right" colspan="3"><br /><?php echo '<a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, 'action=delete_option&option_id=' . $_GET['option_id'], 'NONSSL') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>'; ?>&nbsp;&nbsp;&nbsp;<?php echo '<a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, '&order_by=' . $order_by . '&page=' . $page, 'NONSSL') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?>
                    &nbsp;</td>
                  </tr>
<?php
    }
?>
                </table></td>
              </tr>
<?php
  } else {
    if ($_GET['option_order_by']) {
      $option_order_by = $_GET['option_order_by'];
    } else {
      $option_order_by = 'products_options_id';
    }
?>
              <tr>
                <td colspan="3" class="smallText">
<?php
	$option_page = (int)$_GET['option_page'];
    $per_page = 20;
    	if (isset ($_GET['searchoption'])) {
		$options = "select * from ".TABLE_PRODUCTS_OPTIONS." 
					where language_id = '".$_SESSION['languages_id']."' 
					and products_options_name LIKE '%".$_GET['searchoption']."%'
					order by ".$option_order_by;
	} else {
		$options = "select * from ".TABLE_PRODUCTS_OPTIONS." 
					where language_id = '".$_SESSION['languages_id']."' 
					order by ".$option_order_by;
	}
    if (!$option_page) {
      $option_page = 1;
    }
    $prev_option_page = $option_page - 1;
    $next_option_page = $option_page + 1;

    $option_query = vam_db_query($options);

    $option_page_start = ($per_page * $option_page) - $per_page;
    $num_rows = vam_db_num_rows($option_query);

    if ($num_rows <= $per_page) {
      $num_pages = 1;
    } else if (($num_rows % $per_page) == 0) {
      $num_pages = ($num_rows / $per_page);
    } else {
      $num_pages = ($num_rows / $per_page) + 1;
    }
    $num_pages = (int) $num_pages;

    $options = $options . " LIMIT $option_page_start, $per_page";

    // Previous
    if ($prev_option_page)  {
      echo '<a href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, 'option_page=' . $prev_option_page.'&searchoption='.$_GET['searchoption']) . '"> &lt;&lt; </a> | ';
    }

    for ($i = 1; $i <= $num_pages; $i++) {
      if ($i != $option_page) {
        echo '<a href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, 'option_page=' . $i.'&searchoption='.$_GET['searchoption']) . '">' . $i . '</a> | ';
      } else {
        echo '<b><font color="#ff0000">' . $i . '</font></b> | ';
      }
    }

    // Next
    if ($option_page != $num_pages) {
      echo '<a href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, 'option_page=' . $next_option_page.'&searchoption='.$_GET['searchoption']) . '"> &gt;&gt; </a>';
    }
?>
                </td>
              </tr>
              <tr>
                <td colspan="8"><?php echo vam_black_line(); ?></td>
              </tr>
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_ID; ?>&nbsp;</td>
                <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_NAME; ?>&nbsp;</td>
                <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_TYPE; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" width="20">&nbsp;<?php echo TEXT_ROWS; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" width="20">&nbsp;<?php echo TEXT_SIZE; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" width="20">&nbsp;<?php echo TEXT_MAX_LENGTH; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" width="20">&nbsp;<?php echo TABLE_TEXT_SORT_ORDER; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="8"><?php echo vam_black_line(); ?></td>
              </tr>
<?php
    $next_id = 1;
    $options = vam_db_query($options);
    while ($options_values = vam_db_fetch_array($options)) {
      $rows++;
?>
              <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
<?php
      if (($_GET['action'] == 'update_option') && ($_GET['option_id'] == $options_values['products_options_id'])) {
        echo '<form name="option" action="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, 'action=update_option_name&option_page='.$_GET['option_page'], 'NONSSL') . '" method="post">';
        $inputs = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
          $option_name = vam_db_query("select * from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . $options_values['products_options_id'] . "' and language_id = '" . $languages[$i]['id'] . "'");
          $option_name = vam_db_fetch_array($option_name);
          $type = $option_name['products_options_type'];
          $inputs .= $languages[$i]['name'] . ':&nbsp;<input type="text" name="option_name[' . $languages[$i]['id'] . ']" size="20" value="' . $option_name['products_options_name'] . '">&nbsp;<br />';
        }
?>
                <td align="center" class="smallText">&nbsp;<?php echo $options_values['products_options_id']; ?><input type="hidden" name="option_id" value="<?php echo $options_values['products_options_id']; ?>">&nbsp;</td>
                <td class="smallText"><?php echo $inputs; ?></td>
                 <td class="smallText"><?php echo vam_draw_pull_down_menu('options_type',$type_array,$type_array[$type-1]['id']); ?>
                 </td>
                 <td class="smallText">
                 <input type="text" name="option_rows" size="4" value="<?php echo $options_values['products_options_rows'];?>">
                 </td>
                 <td class="smallText">
                 <input type="text" name="option_size" size="4" value="<?php echo $options_values['products_options_size']; ?>">
                 </td>
                 <td class="smallText">
                 <input type="text" name="option_length" size="4" value="<?php echo $options_values['products_options_length']; ?>">
                 </td>
                 <td class="smallText">
                 <input type="text" name="option_sort_order" size="4" value="<?php echo $options_values['sortorder']; ?>">
                 </td>
                <td align="center" class="smallText">&nbsp;<?php echo '<span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/update.png', '', '12', '12') . '&nbsp;' . BUTTON_UPDATE . '</button></span>'; ?>&nbsp;<?php echo '<a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, '', 'NONSSL') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?>&nbsp;</td>
<?php
        echo '</form>' . "\n";
      } else {
?>
                <td align="center" class="smallText">&nbsp;<?php echo $options_values["products_options_id"]; ?>&nbsp;</td>
                <td class="smallText">&nbsp;<?php echo $options_values["products_options_name"]; ?>&nbsp;</td>
                <td class="smallText">&nbsp;<?php echo $type_array[$options_values['products_options_type']-1]['text']; ?>&nbsp;</td>
                <td class="smallText">&nbsp;<?php echo $options_values['products_options_rows']; ?>&nbsp;</td>
                <td class="smallText">&nbsp;<?php echo $options_values['products_options_size']; ?>&nbsp;</td>
                <td class="smallText">&nbsp;<?php echo $options_values['products_options_length']; ?>&nbsp;</td>
                <td class="smallText">&nbsp;<?php echo $options_values['sortorder']; ?>&nbsp;</td>
                <td align="center" class="smallText">&nbsp;
                <?php echo '<a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, 'action=update_option&option_id=' . $options_values['products_options_id'] . '&option_order_by=' . $option_order_by . '&option_page=' . $option_page, 'NONSSL') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a>'; ?>&nbsp;&nbsp;<?php echo '<a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, 'action=delete_product_option&option_id=' . $options_values['products_options_id'], 'NONSSL') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>'; ?>&nbsp;</td>
<?php
      }
?>
              </tr>
<?php
      $max_options_id_query = vam_db_query("select max(products_options_id) + 1 as next_id from " . TABLE_PRODUCTS_OPTIONS);
      $max_options_id_values = vam_db_fetch_array($max_options_id_query);
      $next_id = $max_options_id_values['next_id'];
    }
?>
              <tr>
                <td colspan="8"><hr size="4" noshade></td>
              </tr>
<?php
    if ($_GET['action'] != 'update_option') {

echo '<form name="options" action="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, 'action=add_product_options&option_page=' . $option_page, 'NONSSL') . '" method="post"><input type="hidden" name="products_options_id" value="' . $next_id . '">';
?> 
              <tr class="dataTableRowSelected">
<?php
       $inputs = '';
      for ($i = 0, $n = sizeof($languages); $i < $n; $i ++) {
        $inputs .= $languages[$i]['name']. ':&nbsp;<input type="text" name="option_name[' . $languages[$i]['id'] . ']" size="20">&nbsp;<br />';
      }
?>
                <td align="center" class="dataTableContent">&nbsp;<?php echo $next_id; ?>&nbsp;</td>
                <td class="dataTableContent"><?php echo $inputs; ?></td>
                <td class="dataTableContent"><?php echo vam_draw_pull_down_menu('options_type',$type_array); ?></td>
                <td align="center" class="dataTableContent" colspan="4">&nbsp;<?php echo '<span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>'; ?>&nbsp;</td>
                </tr>   
              <tr class="dataTableRowSelected">
                <td align="center" class="dataTableContent">&nbsp;</td>
                <td class="dataTableContent" colspan="6">
                <?php echo TEXT_ROWS; ?>: <input type="text" name="option_rows" size="4" value="1">
                <?php echo TEXT_SIZE; ?>: <input type="text" name="option_size" size="4" value="32">
                <?php echo TEXT_MAX_LENGTH; ?>: <input type="text" name="option_length" size="4" value="64">
                <?php echo TABLE_TEXT_SORT_ORDER; ?>: <input type="text" name="option_sort_order" size="4" value="1">
                <br /><br /><?php echo TEXT_NOTE; ?><br />
                </td>
              </tr>  
                
                
<?php
      echo '</form>';
?>
              
              <tr>
                <td colspan="8"><hr size="4" noshade></td>
              </tr>
<?php
    }
  }
?>
            </table></td>
<!-- options eof //-->
</tr><tr></tr>
            <td valign="top" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="2">
<!-- value //-->
<?php
  if ($_GET['action'] == 'delete_option_value') { // delete product option value
    $values = vam_db_query("select products_options_values_id, products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . $_GET['value_id'] . "' and language_id = '" . $_SESSION['languages_id'] . "'");
    $values_values = vam_db_fetch_array($values);
?>
              <tr>
                <td colspan="3" class="pageHeading">&nbsp;<?php echo $values_values['products_options_values_name']; ?>&nbsp;</td>
                <td>&nbsp;<?php echo vam_image(DIR_WS_IMAGES . 'pixel_trans.gif', '', '1', '53'); ?>&nbsp;</td>
              </tr>
              <tr>
                <td><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
                  <tr>
                    <td colspan="3"><?php echo vam_black_line(); ?></td>
                  </tr>
<?php
    $products = vam_db_query("select p.products_id, pd.products_name, po.products_options_name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS . " po, " . TABLE_PRODUCTS_DESCRIPTION . " pd where pd.products_id = p.products_id and pd.language_id = '" . $_SESSION['languages_id'] . "' and po.language_id = '" . $_SESSION['languages_id'] . "' and pa.products_id = p.products_id and pa.options_values_id='" . $_GET['value_id'] . "' and po.products_options_id = pa.options_id order by pd.products_name");
    if (vam_db_num_rows($products)) {
?>
                  <tr class="dataTableHeadingRow">
                    <td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_ID; ?>&nbsp;</td>
                    <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT; ?>&nbsp;</td>
                    <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_OPT_NAME; ?>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3"><?php echo vam_black_line(); ?></td>
                  </tr>
<?php
      while ($products_values = vam_db_fetch_array($products)) {
        $rows++;
?>
                  <tr class="<?php echo (floor($rows/2) == ($rows/2) ? 'attributes-even' : 'attributes-odd'); ?>">
                    <td align="center" class="smallText">&nbsp;<?php echo $products_values['products_id']; ?>&nbsp;</td>
                    <td class="smallText">&nbsp;<?php echo $products_values['products_name']; ?>&nbsp;</td>
                    <td class="smallText">&nbsp;<?php echo $products_values['products_options_name']; ?>&nbsp;</td>
                  </tr>
<?php
      }
?>
                  <tr>
                    <td colspan="3"><?php echo vam_black_line(); ?></td>
                  </tr>
                  <tr>
                    <td class="main" colspan="3"><br /><?php echo TEXT_WARNING_OF_DELETE; ?></td>
                  </tr>
                  <tr>
                    <td class="main" align="right" colspan="3"><br /><?php echo '<a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, '&value_page=' . $_GET['value_page'] . '&attribute_page=' . $attribute_page, 'NONSSL') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?>&nbsp;</td>
                  </tr>
<?php
    } else {
?>
                  <tr>
                    <td class="main" colspan="3"><br /><?php echo TEXT_OK_TO_DELETE; ?></td>
                  </tr>
                  <tr>
                    <td class="main" align="right" colspan="3"><br /><?php echo '<a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, 'action=delete_value&value_id=' . $_GET['value_id'], 'NONSSL') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>'; ?>&nbsp;&nbsp;&nbsp;<?php echo '<a class="button" href="' . vam_href_link(FILENAME_PRODUCTS_OPTIONS, '&option_page=' . $option_page . '&value_page=' . $_GET['value_page'] . '&attribute_page=' . $attribute_page, 'NONSSL') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?>&nbsp;</td>
                  </tr>
<?php
    }
?>
              	</table></td>
              </tr>
<?php
  }
?>
            </table></td>
          </tr>
        </table></td>
<!-- option value eof //-->
      </tr> 

 
    </table></td>
<!-- products_attributes_eof //-->
  </tr>
</table>
<!-- body_text_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
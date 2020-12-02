<?php
/* --------------------------------------------------------------
   $Id: manufacturers.php 901 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturers.php,v 1.52 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (manufacturers.php,v 1.9 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (manufacturers.php,v 1.9 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once ('includes/classes/'.FILENAME_IMAGEMANIPULATOR);
  require_once (DIR_FS_INC.'vam_wysiwyg_tiny.inc.php');

// BOF manufacturers meta tags	// Return the manufacturers meta title in the needed language	// TABLES: manufacturers_info
	  function vam_get_manufacturers_meta_title($manufacturer_id, $language_id) {
	    $manufacturer_query = vam_db_query("select manufacturers_meta_title from " . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . (int)$manufacturer_id . "' and languages_id = '" . (int)$language_id . "'");
	    $manufacturer = vam_db_fetch_array($manufacturer_query);
	    return $manufacturer['manufacturers_meta_title'];
	  }

	// Return the manufacturers meta keywords in the needed language	// TABLES: manufacturers_info
	  function vam_get_manufacturers_meta_keywords($manufacturer_id, $language_id) {
	    $manufacturer_query = vam_db_query("select manufacturers_meta_keywords from " . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . (int)$manufacturer_id . "' and languages_id = '" . (int)$language_id . "'");
	    $manufacturer = vam_db_fetch_array($manufacturer_query);
	    return $manufacturer['manufacturers_meta_keywords'];
	  }

	// Return the manufacturers meta description in the needed language	// TABLES: manufacturers_info
	  function vam_get_manufacturers_meta_description($manufacturer_id, $language_id) {
	    $manufacturer_query = vam_db_query("select manufacturers_meta_description from " . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . (int)$manufacturer_id . "' and languages_id = '" . (int)$language_id . "'");
	    $manufacturer = vam_db_fetch_array($manufacturer_query);
	    return $manufacturer['manufacturers_meta_description'];
	  }

	  function vam_get_manufacturers_description($manufacturer_id, $language_id) {
	    $manufacturer_query = vam_db_query("select manufacturers_description from " . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . (int)$manufacturer_id . "' and languages_id = '" . (int)$language_id . "'");
	    $manufacturer = vam_db_fetch_array($manufacturer_query);
	    return $manufacturer['manufacturers_description'];
	  }
	  
// EOF manufacturers meta tags
  switch ($_GET['action']) {
    case 'insert':
    case 'save':
      $manufacturers_id = vam_db_prepare_input($_GET['mID']);
      $manufacturers_name = vam_db_prepare_input($_POST['manufacturers_name']);

      $manufacturers_sort_order = vam_db_prepare_input($_POST['sort_order']);

      $manufacturers_page_url = vam_db_prepare_input($_POST['manufacturers_seo_url']);

      // Manufacturers SEO URL begin

               if ($manufacturers_page_url == '' && file_exists(DIR_FS_CATALOG . '.htaccess') && AUTOMATIC_SEO_URL == 'true') {
                   $alias = $manufacturers_name;
                  $alias = make_alias($alias);
                        $manufacturers_page_url = $alias;
               } else {
                        $manufacturers_page_url = vam_db_prepare_input($_POST['manufacturers_seo_url']);
               }
      // Manufacturers SEO URL end
      
      $sql_data_array = array(
      
      'manufacturers_name' => $manufacturers_name,
      'manufacturers_seo_url' => $manufacturers_page_url,
      'sort_order' => $manufacturers_sort_order
      
      );

      if ($_GET['action'] == 'insert') {
        $insert_sql_data = array('date_added' => 'now()');
        $sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
        vam_db_perform(TABLE_MANUFACTURERS, $sql_data_array);
        $manufacturers_id = vam_db_insert_id();
      } elseif ($_GET['action'] == 'save') {
        $update_sql_data = array('last_modified' => 'now()');
        $sql_data_array = vam_array_merge($sql_data_array, $update_sql_data);
        vam_db_perform(TABLE_MANUFACTURERS, $sql_data_array, 'update', "manufacturers_id = '" . vam_db_input($manufacturers_id) . "'");
      }

	$dir_manufacturers=DIR_FS_CATALOG_IMAGES."/manufacturers";
    if ($manufacturers_image = &vam_try_upload('manufacturers_image', $dir_manufacturers)) {

			$mname_arr = explode('.', $manufacturers_image->filename);
			$mnsuffix = array_pop($mname_arr);
			$manufacturers_image_name = strtolower($manufacturers_id.'.'.$mnsuffix);
			
			@ unlink(DIR_FS_CATALOG_IMAGES.'manufacturers/'.$manufacturers_image_name);
			rename(DIR_FS_CATALOG_IMAGES.'manufacturers/'.$manufacturers_image->filename, DIR_FS_CATALOG_IMAGES.'manufacturers/old_'.$manufacturers_image_name);
			require (DIR_WS_INCLUDES.'manufacturer_thumbnail_images.php');      
			@ unlink(DIR_FS_CATALOG_IMAGES.'manufacturers/old_'.$manufacturers_image_name);


        vam_db_query("update " . TABLE_MANUFACTURERS . " set
                                 manufacturers_image ='manufacturers/".$manufacturers_image_name . "'
                                 where manufacturers_id = '" . vam_db_input($manufacturers_id) . "'");
    }

      $languages = vam_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $manufacturers_url_array = $_POST['manufacturers_url'];

// BOF manufacturers descriptions + meta tags
					$manufacturers_meta_title_array = $_POST['manufacturers_meta_title'];
					$manufacturers_meta_keywords_array = $_POST['manufacturers_meta_keywords'];
					$manufacturers_meta_description_array = $_POST['manufacturers_meta_description'];
					$manufacturers_description_array = $_POST['manufacturers_description'];					

// EOF manufacturers descriptions + meta tags
        $language_id = $languages[$i]['id'];

        $sql_data_array = array('manufacturers_url' => vam_db_prepare_input($manufacturers_url_array[$language_id]));

// BOF manufacturers descriptions + meta tags

					$sql_data_array = array_merge($sql_data_array, array('manufacturers_meta_title' => vam_db_prepare_input($manufacturers_meta_title_array[$language_id]),'manufacturers_meta_keywords' => vam_db_prepare_input($manufacturers_meta_keywords_array[$language_id]),'manufacturers_meta_description' => vam_db_prepare_input($manufacturers_meta_description_array[$language_id]),'manufacturers_description' => vam_db_prepare_input($manufacturers_description_array[$language_id]),));

// EOF manufacturers descriptions + meta tags

        if ($_GET['action'] == 'insert') {
          $insert_sql_data = array('manufacturers_id' => $manufacturers_id,
                                   'languages_id' => $language_id);
          $sql_data_array = vam_array_merge($sql_data_array, $insert_sql_data);
          vam_db_perform(TABLE_MANUFACTURERS_INFO, $sql_data_array);
        } elseif ($_GET['action'] == 'save') {
          vam_db_perform(TABLE_MANUFACTURERS_INFO, $sql_data_array, 'update', "manufacturers_id = '" . vam_db_input($manufacturers_id) . "' and languages_id = '" . $language_id . "'");
        }
      }

      if (USE_CACHE == 'true') {
        vam_reset_cache_block('manufacturers');
      }

      vam_redirect(vam_href_link(FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $manufacturers_id));
      break;

    case 'deleteconfirm':
      $manufacturers_id = vam_db_prepare_input($_GET['mID']);

      if ($_POST['delete_image'] == 'on') {
        $manufacturer_query = vam_db_query("select manufacturers_image from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . vam_db_input($manufacturers_id) . "'");
        $manufacturer = vam_db_fetch_array($manufacturer_query);
        $image_location = DIR_FS_DOCUMENT_ROOT . DIR_WS_IMAGES . $manufacturer['manufacturers_image'];
        if (file_exists($image_location)) @unlink($image_location);
      }

      vam_db_query("delete from " . TABLE_MANUFACTURERS . " where manufacturers_id = '" . vam_db_input($manufacturers_id) . "'");
      vam_db_query("delete from " . TABLE_MANUFACTURERS_INFO . " where manufacturers_id = '" . vam_db_input($manufacturers_id) . "'");

      if ($_POST['delete_products'] == 'on') {
        $products_query = vam_db_query("select products_id from " . TABLE_PRODUCTS . " where manufacturers_id = '" . vam_db_input($manufacturers_id) . "'");
        while ($products = vam_db_fetch_array($products_query)) {
          vam_remove_product($products['products_id']);
        }
      } else {
        vam_db_query("update " . TABLE_PRODUCTS . " set manufacturers_id = '' where manufacturers_id = '" . vam_db_input($manufacturers_id) . "'");
      }

      if (USE_CACHE == 'true') {
        vam_reset_cache_block('manufacturers');
      }

      vam_redirect(vam_href_link(FILENAME_MANUFACTURERS, 'page=' . $_GET['page']));
      break;
      
      case 'setstatusflag' :
        if (($_GET['flag'] == '0') || ($_GET['flag'] == '1')) {
          if ($_GET['mID']) {
            vam_set_manufacturer_status($_GET['mID'], $_GET['flag']);
          }
         }
         
        vam_redirect(vam_href_link(FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $_GET['mID']));
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
<?php 
	$query = vam_db_query("SELECT code FROM ".TABLE_LANGUAGES." WHERE languages_id='".$_SESSION['languages_id']."'");
	$data = vam_db_fetch_array($query);
	// generate editor for categories EDIT
	$languages = vam_get_languages();

	// generate editor for products
	if ($_GET['action'] == 'edit' or $_GET['action'] == 'new') {
		//for ($i = 0; $i < sizeof($languages); $i ++) {
			echo vam_wysiwyg_tiny('manufacturers_description', $data['code'], $languages[$i]['id']);
		//}
	} 
?>
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
    
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
<?php 
$manual_link = 'add-manufacturer';
if ($_GET['action'] == 'edit') {
$manual_link = 'edit-manufacturer';
}  
if ($_GET['action'] == 'delete') {
$manual_link = 'delete-manufacturer';
}  
?>
            <td class="pageHeading" align="right">
<?php
  if ($_GET['action'] != 'new') {
?><?php echo '<a class="button" href="' . vam_href_link(FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $mInfo->manufacturers_id . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?>
<?php
  }
?>            
            <a class="button" href="<?php echo MANUAL_LINK_MANUFACTURERS.'#'.$manual_link; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>

    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
      
<?php
  if ($_GET['action'] != 'edit') {
  if ($_GET['action'] != 'new') {
?>
      
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_MANUFACTURERS; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_SORT_ORDER; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $manufacturers_query_raw = "select manufacturers_id, manufacturers_name, manufacturers_seo_url, manufacturers_status, sort_order, manufacturers_image, date_added, last_modified from " . TABLE_MANUFACTURERS . " order by manufacturers_name";
  $manufacturers_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $manufacturers_query_raw, $manufacturers_query_numrows);
  $manufacturers_query = vam_db_query($manufacturers_query_raw);
  while ($manufacturers = vam_db_fetch_array($manufacturers_query)) {
    if (((!$_GET['mID']) || (@$_GET['mID'] == $manufacturers['manufacturers_id'])) && (!$mInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $manufacturer_products_query = vam_db_query("select count(*) as products_count from " . TABLE_PRODUCTS . " where manufacturers_id = '" . $manufacturers['manufacturers_id'] . "'");
      $manufacturer_products = vam_db_fetch_array($manufacturer_products_query);

      $mInfo_array = vam_array_merge($manufacturers, $manufacturer_products);
      $mInfo = new objectInfo($mInfo_array);
    }

    if ( (is_object($mInfo)) && ($manufacturers['manufacturers_id'] == $mInfo->manufacturers_id) ) {
      echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $manufacturers['manufacturers_id'] . '&action=edit') . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $manufacturers['manufacturers_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $manufacturers['manufacturers_name']; ?></td>
                <td class="dataTableContent"><?php echo $manufacturers['sort_order']; ?></td>
                <td class="<?php echo $css_class; ?>">
                <?php
                //show status icons (green & red circle) with links
                if ($manufacturers['manufacturers_status'] == '1') {
                  echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_MANUFACTURERS, vam_get_all_get_params(array('action', 'mID', 'search')) . 'action=setstatusflag&flag=0&mID=' . $manufacturers['manufacturers_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
                } else {
                  echo '<a href="' . vam_href_link(FILENAME_MANUFACTURERS, vam_get_all_get_params(array('action', 'mID', 'search')) . 'action=setstatusflag&flag=1&mID=' . $manufacturers['manufacturers_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
                }
                ?>
                </td>                
                <td class="dataTableContent" align="right"><?php if ( (is_object($mInfo)) && ($manufacturers['manufacturers_id'] == $mInfo->manufacturers_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . vam_href_link(FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $manufacturers['manufacturers_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $manufacturers_split->display_count($manufacturers_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS); ?></td>
                    <td class="smallText" align="right"><?php echo $manufacturers_split->display_links($manufacturers_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
  if ($_GET['action'] != 'new') {
?>
              <tr>
                <td align="right" colspan="4" class="smallText"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $mInfo->manufacturers_id . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?></td>
              </tr>
<?php
  }
?>
            </table></td>
<?php

} else {
	
  $manufacturers_query_raw = "select manufacturers_id, manufacturers_name, manufacturers_status, manufacturers_image, date_added, last_modified from " . TABLE_MANUFACTURERS . " order by manufacturers_name";
  $manufacturers_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $manufacturers_query_raw, $manufacturers_query_numrows);
  $manufacturers_query = vam_db_query($manufacturers_query_raw);
  while ($manufacturers = vam_db_fetch_array($manufacturers_query)) {
    if (((!$_GET['mID']) || (@$_GET['mID'] == $manufacturers['manufacturers_id'])) && (!$mInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $manufacturer_products_query = vam_db_query("select count(*) as products_count from " . TABLE_PRODUCTS . " where manufacturers_id = '" . $manufacturers['manufacturers_id'] . "'");
      $manufacturer_products = vam_db_fetch_array($manufacturer_products_query);

      $mInfo_array = vam_array_merge($manufacturers, $manufacturer_products);
      $mInfo = new objectInfo($mInfo_array);
    }
    }
	
	
} 

} else {
	
	  $manufacturers_query_raw = "select manufacturers_id, manufacturers_name, manufacturers_status, manufacturers_image, date_added, last_modified from " . TABLE_MANUFACTURERS . " order by manufacturers_name";
  $manufacturers_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $manufacturers_query_raw, $manufacturers_query_numrows);
  $manufacturers_query = vam_db_query($manufacturers_query_raw);
  while ($manufacturers = vam_db_fetch_array($manufacturers_query)) {
    if (((!$_GET['mID']) || (@$_GET['mID'] == $manufacturers['manufacturers_id'])) && (!$mInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $manufacturer_products_query = vam_db_query("select count(*) as products_count from " . TABLE_PRODUCTS . " where manufacturers_id = '" . $manufacturers['manufacturers_id'] . "'");
      $manufacturer_products = vam_db_fetch_array($manufacturer_products_query);

      $mInfo_array = vam_array_merge($manufacturers, $manufacturer_products);
      $mInfo = new objectInfo($mInfo_array);
    }
    }

}

  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_NEW_MANUFACTURER . '</b>');

      $contents = array('form' => vam_draw_form('manufacturers', FILENAME_MANUFACTURERS, 'action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_NEW_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_NAME . '<br />' . vam_draw_input_field('manufacturers_name'));

// BOF manufacturers meta tags

      $manufacturer_inputs_string = '';
      $languages = vam_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $manufacturer_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_textarea_field('manufacturers_meta_title[' . $languages[$i]['id'] . ']', 'soft', '95', '15',vam_get_manufacturers_meta_title($mInfo->manufacturers_id, $languages[$i]['id']),'class="meta-title notinymce"');
      }
      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_META_TITLE . $manufacturer_inputs_string);

      $manufacturer_inputs_string = '';
      $languages = vam_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $manufacturer_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_textarea_field('manufacturers_meta_keywords[' . $languages[$i]['id'] . ']', 'soft', '95', '15',vam_get_manufacturers_meta_keywords($mInfo->manufacturers_id, $languages[$i]['id']),'class="meta-keywords notinymce"');
      }
      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_META_KEYWORDS . $manufacturer_inputs_string);

      $manufacturer_inputs_string = '';
      $languages = vam_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $manufacturer_inputs_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_textarea_field('manufacturers_meta_description[' . $languages[$i]['id'] . ']', 'soft', '95', '15',vam_get_manufacturers_meta_description($mInfo->manufacturers_id, $languages[$i]['id']),'class="meta-description notinymce"');

      }
      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_META_DESCRIPTION . $manufacturer_inputs_string);

// EOF manufacturers meta tags

      $manufacturer_inputs_string = '';
      $languages = vam_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $manufacturer_desc_string .= '<br />' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_textarea_field('manufacturers_description[' . $languages[$i]['id'] . ']', 'soft', '30', '5');
      }
      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_DESCRIPTION . $manufacturer_desc_string);

      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_IMAGE . '<br />' . vam_draw_file_field('manufacturers_image'));

      $manufacturer_inputs_string = '';
      $languages = vam_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $manufacturer_inputs_string .= '<br />' . $languages[$i]['name'] . '&nbsp;' . vam_draw_input_field('manufacturers_url[' . $languages[$i]['id'] . ']');
      }
      
      $mInfo->manufacturers_status = 1;

      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_PAGE_URL . '<br />' . vam_draw_input_field('manufacturers_seo_url'));
      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_STATUS . '<br />' . vam_draw_selection_field('manufacturers_status', 'checkbox', '1',$mInfo->manufacturers_status==1 ? true : false));
      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_SORT_ORDER . '<br />' . vam_draw_input_field('sort_order'));

      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_URL . $manufacturer_inputs_string);
      $contents[] = array('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>' . '&nbsp;' . '<a class="button" href="' . vam_href_link(FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $_GET['mID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_EDIT_MANUFACTURER . '</b>');

      $contents = array('form' => vam_draw_form('manufacturers', FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $mInfo->manufacturers_id . '&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_EDIT_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_NAME . '<br />' . vam_draw_input_field('manufacturers_name', $mInfo->manufacturers_name));

// BOF manufacturers meta tags

      $manufacturer_inputs_string = '';
      $languages = vam_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $manufacturer_inputs_string .= '<br>' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_textarea_field('manufacturers_meta_title[' . $languages[$i]['id'] . ']', 'soft', '95', '15',vam_get_manufacturers_meta_title($mInfo->manufacturers_id, $languages[$i]['id']),'class="meta-title notinymce"');
      }
      $contents[] = array('text' => '<br>' . TEXT_MANUFACTURERS_META_TITLE . $manufacturer_inputs_string);

      $manufacturer_inputs_string = '';
      $languages = vam_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $manufacturer_inputs_string .= '<br>' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_textarea_field('manufacturers_meta_keywords[' . $languages[$i]['id'] . ']', 'soft', '95', '15',vam_get_manufacturers_meta_keywords($mInfo->manufacturers_id, $languages[$i]['id']),'class="meta-keywords notinymce"');
      }
      $contents[] = array('text' => '<br>' . TEXT_MANUFACTURERS_META_KEYWORDS . $manufacturer_inputs_string);

      $manufacturer_inputs_string = '';
      $languages = vam_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
	        $manufacturer_inputs_string .= '<br>' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_textarea_field('manufacturers_meta_description[' . $languages[$i]['id'] . ']', 'soft', '95', '15',vam_get_manufacturers_meta_description($mInfo->manufacturers_id, $languages[$i]['id']),'class="meta-description notinymce"');
      }
      $contents[] = array('text' => '<br>' . TEXT_MANUFACTURERS_META_DESCRIPTION . $manufacturer_inputs_string);

// EOF manufacturers meta tags

      $manufacturer_inputs_string = '';
      $languages = vam_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        $manufacturer_desc_string .= '<br>' . $languages[$i]['name'] . ':&nbsp;' . vam_draw_textarea_field('manufacturers_description[' . $languages[$i]['id'] . ']', 'soft', '30', '5', vam_get_manufacturers_description($mInfo->manufacturers_id, $languages[$i]['id']));
      }
      $contents[] = array('text' => '<br>' . TEXT_MANUFACTURERS_DESCRIPTION . $manufacturer_desc_string);

      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_IMAGE . '<br />' . vam_draw_file_field('manufacturers_image') . '<br />' . $mInfo->manufacturers_image);

      $manufacturer_inputs_string = '';
      $languages = vam_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $manufacturer_inputs_string .= '<br />' . $languages[$i]['name'] . '&nbsp;' . vam_draw_input_field('manufacturers_url[' . $languages[$i]['id'] . ']', vam_get_manufacturer_url($mInfo->manufacturers_id, $languages[$i]['id']));
      }
      //if ($mInfo->manufacturers_status == NULL) $mInfo->manufacturers_status = 1;
      //echo $mInfo->manufacturers_status;

      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_PAGE_URL . '<br />' . vam_draw_input_field('manufacturers_seo_url', $mInfo->manufacturers_seo_url));
      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_STATUS . '<br />' . vam_draw_selection_field('manufacturers_status', 'checkbox', '1',$mInfo->manufacturers_status==1 ? true : false));
      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_SORT_ORDER . '<br />' . vam_draw_input_field('sort_order', $mInfo->sort_order));
      $contents[] = array('text' => '<br />' . TEXT_MANUFACTURERS_URL . $manufacturer_inputs_string);
      $contents[] = array('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>' . '&nbsp;' . '<a class="button" href="' . vam_href_link(FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $mInfo->manufacturers_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_MANUFACTURER . '</b>');

      $contents = array('form' => vam_draw_form('manufacturers', FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $mInfo->manufacturers_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $mInfo->manufacturers_name . '</b>');
      $contents[] = array('text' => '<br />' . vam_draw_checkbox_field('delete_image', '', true) . ' ' . TEXT_DELETE_IMAGE);

      if ($mInfo->products_count > 0) {
        $contents[] = array('text' => '<br />' . vam_draw_checkbox_field('delete_products') . ' ' . TEXT_DELETE_PRODUCTS);
        $contents[] = array('text' => '<br />' . sprintf(TEXT_DELETE_WARNING_PRODUCTS, $mInfo->products_count));
      }

      $contents[] = array('align' => 'center', 'text' => '<br />' . '<span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span>' . '&nbsp;' . '<a class="button" href="' . vam_href_link(FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $mInfo->manufacturers_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;

    default:
      if (is_object($mInfo)) {
        $heading[] = array('text' => '<b>' . $mInfo->manufacturers_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' .  vam_href_link(FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $mInfo->manufacturers_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a>' . '&nbsp;' . '<a class="button" href="' . vam_href_link(FILENAME_MANUFACTURERS, 'page=' . $_GET['page'] . '&mID=' . $mInfo->manufacturers_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');
        $contents[] = array('text' => '<br />' . TEXT_DATE_ADDED . ' ' . vam_date_short($mInfo->date_added));
        if (vam_not_null($mInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . vam_date_short($mInfo->last_modified));
        $contents[] = array('text' => '<br />' . vam_info_image($mInfo->manufacturers_image, $mInfo->manufacturers_name));
        $contents[] = array('text' => '<br />' . TEXT_PRODUCTS . ' ' . $mInfo->products_count);
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
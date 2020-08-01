<?php
/* --------------------------------------------------------------
   $Id: tags.php 1180 2007-04-02 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(latest_news.php,v 1.33 2003/05/07); www.oscommerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once(DIR_FS_INC . 'vam_wysiwyg_tiny.inc.php');
  require_once (DIR_FS_INC.'vam_image_submit.inc.php');
  require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');
  
  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'setflag': //set the status of a tags item.
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
          if ($_GET['tags_id']) {
            vam_db_query("update " . TABLE_TAGS . " set status = '" . $_GET['flag'] . "' where tags_id = '" . $_GET['tags_id'] . "'");
          }
        }

  //      vam_redirect(vam_href_link(FILENAME_TAGS));
        break;

      case 'setflagmainpage': //set the status of a tags item.
        if ( ($_GET['flagmainpage'] == '0') || ($_GET['flagmainpage'] == '1') ) {
          if ($_GET['tags_id']) {
            vam_db_query("update " . TABLE_TAGS . " set tags_mainpage = '" . $_GET['flagmainpage'] . "' where tags_id = '" . $_GET['tags_id'] . "'");
          }
        }

  //      vam_redirect(vam_href_link(FILENAME_TAGS));
        break;
        
      case 'delete_tags_confirm': //user has confirmed deletion of tags.
        if ($_POST['tags_id']) {
          $tags_id = vam_db_prepare_input($_POST['tags_id']);
          vam_db_query("delete from " . TABLE_TAGS . " where tags_id = '" . vam_db_input($tags_id) . "'");
        }

   //     vam_redirect(vam_href_link(FILENAME_TAGS));
        break;

      case 'insert_tags': //insert a new tag.
        if ($_POST['tags_name']) {

					if ($_POST['tags_page_url'] == '' && file_exists(DIR_FS_CATALOG . '.htaccess') && AUTOMATIC_SEO_URL == 'true') {
						$alias = $_POST['tags_name'];
						
						$alias = make_alias($alias);
                  $tags_page_url = $alias;

					} else {
						
                $tags_page_url = $_POST['tags_page_url'];
					}
					
          $sql_data_array = array('tags_name'   => vam_db_prepare_input($_POST['tags_name']),
                                  'tags_page_url'    => vam_db_prepare_input($tags_page_url),
                                  'tags_head_title' => vam_db_prepare_input($_POST['tags_head_title']),
                                  'tags_head_desc' => vam_db_prepare_input($_POST['tags_head_desc']),
                                  'tags_head_keys' => vam_db_prepare_input($_POST['tags_head_keys']),
                                  'tags_description'    => vam_db_prepare_input($_POST['tags_description']),
                                  'tags_title'    => vam_db_prepare_input($_POST['tags_title']),
                                  'tags_url'    => vam_db_prepare_input($_POST['tags_url']),
                                  'tags_mainpage'    => vam_db_prepare_input($_POST['tags_mainpage']),
                                  'sort_order'    => vam_db_prepare_input($_POST['sort_order']),
                                  'date_added' => 'now()', //uses the inbuilt mysql function 'now'
                                  'language'   => vam_db_prepare_input($_POST['item_language']),
                                  'status'     => vam_db_prepare_input($_POST['status']) 
                                  );
          vam_db_perform(TABLE_TAGS, $sql_data_array);
          $tags_id = vam_db_insert_id(); //not actually used ATM -- just there in case
        }
 //       vam_redirect(vam_href_link(FILENAME_TAGS));
 
      if (isset($_POST['tags_to_categories_id']) && $tags_id > 0) {
      foreach ($_POST['tags_to_categories_id'] as $key => $value) {
        if (!is_array($_POST[$key])) {
			vam_db_query("INSERT INTO ".TABLE_TAGS_TO_CATEGORIES."
								              SET tags_id   = '".$tags_id."',
								              categories_id = '".$value."'");
        }
      }
      }

      if (isset($_POST['tags_to_products_id']) && $tags_id > 0) {
      foreach ($_POST['tags_to_products_id'] as $key => $value) {
        if (!is_array($_POST[$key])) {
			vam_db_query("INSERT INTO ".TABLE_TAGS_TO_PRODUCTS."
								              SET tags_id   = '".$tags_id."',
								              products_id = '".$value."'");
        }
      }
      }
 
        break;

      case 'update_tags': //user wants to modify a tag.
        if($_GET['tags_id']) {
          $sql_data_array = array('tags_name' => vam_db_prepare_input($_POST['tags_name']),
                                  'tags_page_url'    => vam_db_prepare_input($_POST['tags_page_url']),
                                  'tags_head_title' => vam_db_prepare_input($_POST['tags_head_title']),
                                  'tags_head_desc' => vam_db_prepare_input($_POST['tags_head_desc']),
                                  'tags_head_keys' => vam_db_prepare_input($_POST['tags_head_keys']),
                                  'tags_description'    => vam_db_prepare_input($_POST['tags_description']),
                                  'tags_title'    => vam_db_prepare_input($_POST['tags_title']),
                                  'tags_url'    => vam_db_prepare_input($_POST['tags_url']),
                                  'tags_mainpage'    => vam_db_prepare_input($_POST['tags_mainpage']),
                                  'sort_order'    => vam_db_prepare_input($_POST['sort_order']),
                                  'date_added'  => vam_db_prepare_input($_POST['date_added']),
                                  'language'   => vam_db_prepare_input($_POST['item_language']),
                                  'status'     => vam_db_prepare_input($_POST['status']) 
                                  );
          vam_db_perform(TABLE_TAGS, $sql_data_array, 'update', "tags_id = '" . vam_db_prepare_input($_GET['tags_id']) . "'");
        }

		//$tags_to_categories_array = array();
		//if ($_GET['tags_id'] > 0) {
		//$tags_to_categories_query = vam_db_query("select f2c.categories_id from " . TABLE_TAGS_TO_CATEGORIES . " f2c where f2c.tags_id = ".$_GET['tags_id']."");
		//while ($tags_to_categories = vam_db_fetch_array($tags_to_categories_query))
		//{
			//$tags_to_categories_array[] = $tags_to_categories['categories_id'];
		//}
		//}

      //if (isset($_POST['tags_to_categories_id']) && $_GET['tags_id'] > 0) {
      vam_db_query("DELETE FROM " . TABLE_TAGS_TO_CATEGORIES . " WHERE tags_id = '" . (int)$_GET['tags_id'] . "'");
      foreach ($_POST['tags_to_categories_id'] as $key => $value) {
        if (!is_array($_POST[$key])) {
        //if (in_array_column($value, "categories_id", $tags_to_categories_array)) {        	
			vam_db_query("INSERT INTO ".TABLE_TAGS_TO_CATEGORIES."
								              SET tags_id   = '".$_GET['tags_id']."',
								              categories_id = '".$value."'");
        //}
        }
      }
      //}

      //if (isset($_POST['tags_to_products_id']) && $tags_id > 0) {
      vam_db_query("DELETE FROM " . TABLE_TAGS_TO_PRODUCTS . " WHERE tags_id = '" . (int)$_GET['tags_id'] . "'");
      foreach ($_POST['tags_to_products_id'] as $key => $value) {
        if (!is_array($_POST[$key])) {
			vam_db_query("INSERT INTO ".TABLE_TAGS_TO_PRODUCTS."
								              SET tags_id   = '".$_GET['tags_id']."',
								              products_id = '".$value."'");
        }
      }
      //}
              
  //      vam_redirect(vam_href_link(FILENAME_TAGS));
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
<?php
 $query=vam_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".$_SESSION['languages_id']."'");
 $data=vam_db_fetch_array($query);
 if ($_GET['action']=='new_tags') echo vam_wysiwyg_tiny('tags',$data['code']);
?>
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
    
<?php 
$manual_link = 'add-tag';
if ($_GET['action'] == 'new_tags' and isset($_GET['tags_id'])) {
$manual_link = 'edit-tags';
}  
if ($_GET['action'] == 'delete_tags') {
$manual_link = 'delete-tags';
}  
?>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php if ($_GET['action'] != 'new_tags') { echo '&nbsp;<a class="button" href="' . vam_href_link(FILENAME_TAGS, 'action=new_tags') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; } ?>&nbsp;<a class="button" href="<?php echo MANUAL_LINK_TAGS.'#'.$manual_link; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>
  
  </td>
  </tr>
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ($_GET['action'] == 'new_tags') { //insert or edit a tag
    if ( isset($_GET['tags_id']) ) { //editing exsiting tag
      $tags_query = vam_db_query("select * from " . TABLE_TAGS . " where tags_id = '" . $_GET['tags_id'] . "'");
      $tags = vam_db_fetch_array($tags_query);
    } else { //adding new tag
      $tags = array();
    }
    
if ($tags['status'] == '1') { $status_checked = true; } elseif ($tags['status'] == '0') { $status_checked = false; } else { $status_checked = true; }
if ($tags['tags_mainpage'] == '1'){ $startpage_checked = true; } elseif ($tags['tags_mainpage'] == '0') { $startpage_checked = false; } else { $startpage_checked = true; }
    
?>
      <tr><?php echo vam_draw_form('new_tags', FILENAME_TAGS, isset($_GET['tags_id']) ? vam_get_all_get_params(array('action')) . 'action=update_tags' : vam_get_all_get_params(array('action')) . 'action=insert_tags', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" cellspacing="0" cellpadding="2" width="100%">
          <tr>
            <td class="main"><?php echo TEXT_TAGS_NAME; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('tags_name', $tags['tags_name'], 'size="60"', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_TAGS_URL; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('tags_url', $tags['tags_url'], 'size="60"', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_TAGS_TITLE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('tags_title', $tags['tags_title'], 'size="60"', false); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_TAGS_MAINPAGE; ?>:</td>
            <td class="main"><?php echo '&nbsp;<label>'.vam_draw_radio_field('tags_mainpage', '1', $startpage_checked) . '&nbsp;' . YES . '</label>&nbsp;<label>' . vam_draw_radio_field('tags_mainpage', '0', !$startpage_checked) . '&nbsp;' . NO . '</label>'; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_TAGS_STATUS; ?>:</td>
            <td class="main"><?php echo '&nbsp;<label>'.vam_draw_radio_field('status', '1', $status_checked) . '&nbsp;' . TEXT_TAGS_STATUS_ACTIVE . '</label>&nbsp;<label>' . vam_draw_radio_field('status', '0', !$status_checked) . '&nbsp;' . TEXT_TAGS_STATUS_INACTIVE . '</label>'; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_TAGS_SORT_ORDER; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('sort_order', $tags['sort_order'], 'size="5"', false); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <!--
          <tr>
            <td class="main"><?php echo TEXT_TAGS_DESCRIPTION; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_textarea_field('tags_description', '', '100%', '25', stripslashes($tags['tags_description'])); ?><br /><a href="javascript:toggleHTMLEditor('tags_description');"><?php echo TEXT_TOGGLE_EDITOR; ?></a></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_TAGS_PAGE_URL; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('tags_page_url', $tags['tags_page_url'], 'size="60"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_TAGS_META_TITLE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('tags_head_title', $tags['tags_head_title'], 'size="60"', false); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_TAGS_META_DESCRIPTION; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_textarea_field('tags_head_desc', 'soft', '70', '5', $tags['tags_head_desc'], 'class="notinymce"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_TAGS_META_KEYWORDS; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_textarea_field('tags_head_keys', 'soft', '70', '5', $tags['tags_head_keys'], 'class="notinymce"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          -->
<?php 

		// create an array of products on special, which will be excluded from the pull down menu of products
		// (when creating a new product on special)
		$tags_to_categories_array = array();
		if ($_GET['tags_id'] > 0) {
		$tags_to_categories_query = vam_db_query("select f2c.categories_id from " . TABLE_TAGS_TO_CATEGORIES . " f2c where f2c.tags_id = ".$_GET['tags_id']."");
		while ($tags_to_categories = vam_db_fetch_array($tags_to_categories_query))
		{
			$tags_to_categories_array[] = $tags_to_categories['categories_id'];
		}
		}
?>          
          <tr>
            <td class="main"><?php echo TEXT_TAGS_ATTACH_TO_CATEGORIES; ?>:</td>
            <td class="main"><?php echo vam_draw_multi_pull_down_menu('tags_to_categories_id[]', vam_get_category_tree(), $tags_to_categories_array, 'multiple="multiple" data-placeholder="'.TEXT_TAGS_SELECT_CATEGORIES.'"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
<?php 

      // create an array of products on special, which will be excluded from the pull down menu of products
      // (when creating a new product on special)
      $tags_to_products_array = array();
		if ($_GET['tags_id'] > 0) {
		$tags_to_products_query = vam_db_query("select f2p.products_id from " . TABLE_TAGS_TO_PRODUCTS . " f2p where f2p.tags_id = ".$_GET['tags_id']."");
      while ($tags_to_products = vam_db_fetch_array($tags_to_products_query)) {
        $tags_to_products_array[] = $tags_to_products['products_id'];
      }
      }
?>          
          <tr>
            <td class="main"><?php echo TEXT_TAGS_ATTACH_TO_PRODUCTS; ?>:</td>
            <td class="main"><?php echo vam_draw_products_multi_pull_down_menu('tags_to_products_id[]', '', $tags_to_products_array, 'multiple="multiple" data-placeholder="'.TEXT_TAGS_SELECT_PRODUCTS.'"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<?php
if ( isset($_GET['tags_id']) ) {
?>
          <tr>
            <td class="main"><?php echo TEXT_TAGS_DATE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' .  vam_draw_input_field('date_added', $tags['date_added'], '', true); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<?php
}
?>

          <tr>
            <td class="main"><?php echo TEXT_TAGS_LANGUAGE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;'; ?>

<?php

  $languages = vam_get_languages();
  $languages_array = array();

  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                        
  if ($languages[$i]['id']==$tags['language']) {
         $languages_selected=$languages[$i]['id'];
         $languages_id=$languages[$i]['id'];
        }               
    $languages_array[] = array('id' => $languages[$i]['id'],
               'text' => $languages[$i]['name']);

  } // for
  
echo vam_draw_pull_down_menu('item_language',$languages_array,$languages_selected); ?>

</td>
          </tr>


        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right">
          <?php
            isset($_GET['tags_id']) ? $cancel_button = '&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_TAGS, 'tags_id=' . $_GET['tags_id']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>' : $cancel_button = '';
            echo '<span class="button"><button type="submit" value="' . BUTTON_INSERT .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' .BUTTON_INSERT . '</button></span>' . $cancel_button;
          ?>
        </td>
      </form></tr>
<?php

  } else {
?>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TAGS_NAME; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TAGS_TITLE; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TAGS_URL; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_TAGS_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_TAGS_MAIN_PAGE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_TAGS_SORT_ORDER; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TAGS_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $rows = 0;

    $tags_count = 0;
    $tags_query_raw = 'select * from ' . TABLE_TAGS . ' order by sort_order ASC, date_added desc';

	$tags_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $tags_query_raw, $tags_query_numrows);

    $tags_query = vam_db_query($tags_query_raw);
	    
    while ($tags = vam_db_fetch_array($tags_query)) {
      $tags_count++;
      $rows++;
      
		if (((!$_GET['tags_id']) || (@ $_GET['tags_id'] == $tags['tags_id'])) && (!$tInfo)) {
			$tInfo = new objectInfo($tags);
		}

		if ((is_object($tInfo)) && ($tags['tags_id'] == $tInfo->tags_id)) {
		
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_TAGS, vam_get_all_get_params(array('tags_id','action')) . 'tags_id=' . $tags['tags_id']) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_TAGS, vam_get_all_get_params(array('tags_id','action')) . 'tags_id=' . $tags['tags_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '&nbsp;' . $tags['tags_name']; ?></td>
                <td class="dataTableContent"><?php echo '&nbsp;' . substr($tags['tags_title'], 0, 100); ?></td>
                <td class="dataTableContent"><?php echo '<a href="' . $tags['tags_url'] . '">' . substr($tags['tags_url'], 0, 50) . '</a>'; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($tags['status'] == '1') {
        echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_TAGS, vam_get_all_get_params(array('tags_id','action', 'flag')) . 'action=setflag&flag=0&tags_id=' . $tags['tags_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link(FILENAME_TAGS, vam_get_all_get_params(array('tags_id','action', 'flag')) . 'action=setflag&flag=1&tags_id=' . $tags['tags_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($tags['tags_mainpage'] == '1') {
        echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_TAGS, vam_get_all_get_params(array('tags_id','action', 'flagmainpage')) . 'action=setflagmainpage&flagmainpage=0&tags_id=' . $tags['tags_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link(FILENAME_TAGS, vam_get_all_get_params(array('tags_id','action', 'flagmainpage')) . 'action=setflagmainpage&flagmainpage=1&tags_id=' . $tags['tags_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent"><?php echo $tags['sort_order']; ?></td>
                <td class="dataTableContent" align="right"><?php if ($tags['tags_id'] == $_GET['tags_id']) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_TAGS, vam_get_all_get_params(array('tags_id','action', 'flag')) . 'tags_id=' . $tags['tags_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

?>
              <tr>
                <td colspan="7"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo '<br>' . TEXT_TAGS_ITEMS . '&nbsp;' . $tags_count; ?></td>
                    <td align="right" class="smallText"><?php echo '&nbsp;<a class="button" href="' . vam_href_link(FILENAME_TAGS, 'action=new_tags') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?>&nbsp;</td>
                  </tr>																																		  
                </table></td>
              </tr>
              <tr>
                <td colspan="7"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $tags_split->display_count($tags_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_TAGS); ?></td>
                    <td class="smallText" align="right"><?php echo $tags_split->display_links($tags_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], vam_get_all_get_params(array('page', 'action', 'x', 'y', 'tags_id'))); ?></td>
                  </tr>              
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($_GET['action']) {
      case 'delete_tags': //generate box for confirming a tagsdeletion
        $heading[] = array('text'   => '<b>' . TEXT_INFO_HEADING_DELETE_ITEM . '</b>');
        
        $contents = array('form'    => vam_draw_form('tags', FILENAME_TAGS, vam_get_all_get_params(array('action')) . 'action=delete_tags_confirm') . vam_draw_hidden_field('tags_id', $_GET['tags_id']));
        $contents[] = array('text'  => TEXT_DELETE_ITEM_INTRO);
        $contents[] = array('text'  => '<br><b>' . $selected_item['tags_name'] . '</b>');
        
        $contents[] = array('align' => 'center',
                            'text'  => '<br><span class="button"><button type="submit" value="' . BUTTON_DELETE .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span><a class="button" href="' . vam_href_link(FILENAME_TAGS,  vam_get_all_get_params(array ('tags_id', 'action')).'tags_id=' . $selected_item['tags_id']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;

      default:
        if ($rows > 0) {
          if (is_object($tInfo)) { //an item is selected, so make the side box
            $heading[] = array('text' => '<b>' . $tInfo->tags_name . '</b>');

            $contents[] = array('align' => 'center', 
                                'text' => '<a class="button" href="' . vam_href_link(FILENAME_TAGS, vam_get_all_get_params(array ('tags_id', 'action')).'tags_id=' . $tInfo->tags_id . '&action=new_tags') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_TAGS,  vam_get_all_get_params(array ('tags_id', 'action')).'tags_id=' . $tInfo->tags_id . '&action=delete_tags') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');

            $contents[] = array('text' => '<br>' . vam_break_string(strip_tags($tInfo->tags_description), 128, '...'));
          }
        } else { // create category/product info
          $heading[] = array('text' => '<b>' . EMPTY_CATEGORY . '</b>');

          $contents[] = array('text' => sprintf(TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS, $parent_categories_name));
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
<?php
  }
?>
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

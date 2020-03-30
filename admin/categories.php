<?php
/* --------------------------------------------------------------
   $Id: categories.php 1249 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com
   (c) 2003  nextcommerce (categories.php,v 1.37 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (categories.php,v 1.37 2003/08/18); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contribution:
   Enable_Disable_Categories 1.3               Autor: Mikel Williams | mikel@ladykatcostumes.com
   New Attribute Manager v4b                   Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
   Category Descriptions (Version: 1.5 MS2)    Original Author:   Brian Lowe <blowe@wpcusrgrp.org> | Editor: Lord Illicious <shaolin-venoms@illicious.net>
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/

require_once ('includes/application_top.php');
require_once ('includes/classes/'.FILENAME_IMAGEMANIPULATOR);
require_once ('includes/classes/categories.php');
require_once (DIR_FS_INC.'vam_get_tax_rate.inc.php');
require_once (DIR_FS_INC.'vam_get_products_mo_images.inc.php');
require_once (DIR_WS_CLASSES.'currencies.php');
require_once (DIR_FS_INC.'vam_wysiwyg_tiny.inc.php');

$currencies = new currencies();
$catfunc = new categories();

// Start Products Specifications
  require_once (DIR_WS_CLASSES . 'boxes.php');
  require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');
// End Products Specifications

//this is used only by group_prices
if ($_GET['function']) {
	switch ($_GET['function']) {
		case 'delete' :
			vam_db_query("DELETE FROM ".TABLE_PERSONAL_OFFERS.(int) $_GET['statusID']."
						                     WHERE products_id = '".(int) $_GET['pID']."'
						                     AND quantity    = '".(int) $_GET['quantity']."'");
			break;
	}
	vam_redirect(vam_href_link(FILENAME_CATEGORIES, 'cPath='.$_GET['cPath'].'&action=new_product&pID='.(int) $_GET['pID']));
}

// Multi-Status Change, separated from $_GET['action']
// --- MULTI STATUS ---
if (isset ($_POST['multi_status_on'])) {
	//set multi_categories status=on
	if (is_array($_POST['multi_categories'])) {
		foreach ($_POST['multi_categories'] AS $category_id) {
			$catfunc->set_category_recursive($category_id, '1');
		}
	}
	//set multi_products status=on
	if (is_array($_POST['multi_products'])) {
		foreach ($_POST['multi_products'] AS $product_id) {
			$catfunc->set_product_status($product_id, '1');
		}
	}
	vam_redirect(vam_href_link(FILENAME_CATEGORIES, 'cPath='.$_GET['cPath'].'&'.vam_get_all_get_params(array ('cPath', 'action', 'pID', 'cID'))));
}

if (isset ($_POST['multi_status_off'])) {
	//set multi_categories status=off
	if (is_array($_POST['multi_categories'])) {
		foreach ($_POST['multi_categories'] AS $category_id) {
			$catfunc->set_category_recursive($category_id, "0");
		}
	}
	//set multi_products status=off
	if (is_array($_POST['multi_products'])) {
		foreach ($_POST['multi_products'] AS $product_id) {
			$catfunc->set_product_status($product_id, "0");
		}
	}
	vam_redirect(vam_href_link(FILENAME_CATEGORIES, 'cPath='.$_GET['cPath'].'&'.vam_get_all_get_params(array ('cPath', 'action', 'pID', 'cID'))));
}
// --- MULTI STATUS ENDS ---

//regular actions
if ($_GET['action']) {
	switch ($_GET['action']) {

		case 'setcflag' :
			if (($_GET['flag'] == '0') || ($_GET['flag'] == '1')) {
				if ($_GET['cID']) {
					$catfunc->set_category_recursive($_GET['cID'], $_GET['flag']);
				}
			}
			vam_redirect(vam_href_link(FILENAME_CATEGORIES, 'cPath='.$_GET['cPath'].'&cID='.$_GET['cID']));
			break;
			//EOB setcflag

		case 'setpflag' :
			if (($_GET['flag'] == '0') || ($_GET['flag'] == '1')) {
				if ($_GET['pID']) {
					$catfunc->set_product_status($_GET['pID'], $_GET['flag']);
				}
			}
			if (!isset($_GET['page'])) $_GET['page'] = 0;
			if ($_GET['pID']) {
				vam_redirect(vam_href_link(FILENAME_CATEGORIES, 'cPath='.$_GET['cPath'].'&page='.$_GET['page'].'&pID='.$_GET['pID']));
			} else {
				vam_redirect(vam_href_link(FILENAME_CATEGORIES, 'cPath='.$_GET['cPath'].'&page='.$_GET['page'].'&cID='.$_GET['cID']));
			}
			break;
			//EOB setpflag

      case 'setxml' :
        if (($_GET['flagxml'] == '0') || ($_GET['flagxml'] == '1')) {
          if ($_GET['pID']) {
            vam_set_product_xml($_GET['pID'], $_GET['flagxml']);
          }
         }
			if (!isset($_GET['page'])) $_GET['page'] = 0;
         
        vam_redirect(vam_href_link(FILENAME_CATEGORIES, 'cPath=' . $_GET['cPath'] . '&page=' . $_GET['page'] . '&pID=' . $_GET['pID']));
        break;

		case 'setcxml' :
			if (($_GET['flag'] == '0') || ($_GET['flag'] == '1')) {
				if ($_GET['cID']) {
					$catfunc->set_category_xml_recursive($_GET['cID'], $_GET['flag']);
				}
			}
			vam_redirect(vam_href_link(FILENAME_CATEGORIES, 'cPath='.$_GET['cPath'].'&cID='.$_GET['cID']));
			break;
			
		case 'setsflag' :
			if (($_GET['flag'] == '0') || ($_GET['flag'] == '1')) {
				if ($_GET['pID']) {
					$catfunc->set_product_startpage($_GET['pID'], $_GET['flag']);
//					if ($_GET['flag'] == '1') $catfunc->link_product($_GET['pID'], 0);
				}
			}
			if (!isset($_GET['page'])) $_GET['page'] = 0;
			if ($_GET['pID']) {
				vam_redirect(vam_href_link(FILENAME_CATEGORIES, 'cPath='.$_GET['cPath'].'&page='.$_GET['page'].'&pID='.$_GET['pID']));
			} else {
				vam_redirect(vam_href_link(FILENAME_CATEGORIES, 'cPath='.$_GET['cPath'].'&page='.$_GET['page'].'&cID='.$_GET['pID']));
			}
			break;
			//EOB setsflag

		case 'update_category' :
			$catfunc->insert_category($_POST, '', 'update');
			break;

		case 'insert_category' :
			$catfunc->insert_category($_POST, $current_category_id);
			break;

		case 'update_product' :
			$catfunc->insert_product($_POST, $current_category_id, 'update');
			break;

		case 'insert_product' :
			$catfunc->insert_product($_POST, $current_category_id);
			break;

		case 'edit_crossselling' :
			$catfunc->edit_cross_sell($_GET);
			break;

		case 'multi_action_confirm' :

			// --- MULTI DELETE ---
			if (isset ($_POST['multi_delete_confirm'])) {
				//delete multi_categories
				if (is_array($_POST['multi_categories'])) {
					foreach ($_POST['multi_categories'] AS $category_id) {
						$catfunc->remove_categories($category_id);
					}
				}
				//delete multi_products
				if (is_array($_POST['multi_products']) && is_array($_POST['multi_products_categories'])) {
					foreach ($_POST['multi_products'] AS $product_id) {
						$catfunc->delete_product($product_id, $_POST['multi_products_categories'][$product_id]);
					}

				}
			}
			// --- MULTI DELETE ENDS ---

			// --- MULTI MOVE ---
			if (isset ($_POST['multi_move_confirm'])) {
				//move multi_categories
				if (is_array($_POST['multi_categories']) && vam_not_null($_POST['move_to_category_id'])) {
					foreach ($_POST['multi_categories'] AS $category_id) {
						$dest_category_id = vam_db_prepare_input($_POST['move_to_category_id']);
						if ($category_id != $dest_category_id) {
							$catfunc->move_category($category_id, $dest_category_id);
						}
					}
				}
				//move multi_products
				if (is_array($_POST['multi_products']) && vam_not_null($_POST['move_to_category_id']) && vam_not_null($_POST['src_category_id'])) {
					foreach ($_POST['multi_products'] AS $product_id) {
						$product_id = vam_db_prepare_input($product_id);
						$src_category_id = vam_db_prepare_input($_POST['src_category_id']);
						$dest_category_id = vam_db_prepare_input($_POST['move_to_category_id']);
						$catfunc->move_product($product_id, $src_category_id, $dest_category_id);
					}
				}
				vam_redirect(vam_href_link(FILENAME_CATEGORIES, 'cPath='.$dest_category_id.'&'.vam_get_all_get_params(array ('cPath', 'action', 'pID', 'cID'))));
			}
			// --- MULTI MOVE ENDS ---	

			// --- MULTI COPY ---
			if (isset ($_POST['multi_copy_confirm'])) {
				//copy multi_categories
				if (is_array($_POST['multi_categories']) && (is_array($_POST['dest_cat_ids']) || vam_not_null($_POST['dest_category_id']))) {
					$_SESSION['copied'] = array ();
					foreach ($_POST['multi_categories'] AS $category_id) {
						if (is_array($_POST['dest_cat_ids'])) {
							foreach ($_POST['dest_cat_ids'] AS $dest_category_id) {
								if ($_POST['copy_as'] == 'link') {
									$catfunc->copy_category($category_id, $dest_category_id, 'link');
								}
								elseif ($_POST['copy_as'] == 'duplicate') {
									$catfunc->copy_category($category_id, $dest_category_id, 'duplicate');
								} else {
									$messageStack->add_session('Copy type not specified.', 'error');
								}
							}
						}
						elseif (vam_not_null($_POST['dest_category_id'])) {
							if ($_POST['copy_as'] == 'link') {
								$catfunc->copy_category($category_id, $dest_category_id, 'link');
							}
							elseif ($_POST['copy_as'] == 'duplicate') {
								$catfunc->copy_category($category_id, $dest_category_id, 'duplicate');
							} else {
								$messageStack->add_session('Copy type not specified.', 'error');
							}
						}
					}
					unset ($_SESSION['copied']);
				}
				//copy multi_products
				if (is_array($_POST['multi_products']) && (is_array($_POST['dest_cat_ids']) || vam_not_null($_POST['dest_category_id']))) {
					foreach ($_POST['multi_products'] AS $product_id) {
						$product_id = vam_db_prepare_input($product_id);
						if (is_array($_POST['dest_cat_ids'])) {
							foreach ($_POST['dest_cat_ids'] AS $dest_category_id) {
								$dest_category_id = vam_db_prepare_input($dest_category_id);
								if ($_POST['copy_as'] == 'link') {
									$catfunc->link_product($product_id, $dest_category_id);
								}
								elseif ($_POST['copy_as'] == 'duplicate') {
									$catfunc->duplicate_product($product_id, $dest_category_id);
								} else {
									$messageStack->add_session('Copy type not specified.', 'error');
								}
							}
						}
						elseif (vam_not_null($_POST['dest_category_id'])) {
							$dest_category_id = vam_db_prepare_input($_POST['dest_category_id']);
							if ($_POST['copy_as'] == 'link') {
								$catfunc->link_product($product_id, $dest_category_id);
							}
							elseif ($_POST['copy_as'] == 'duplicate') {
								$catfunc->duplicate_product($product_id, $dest_category_id);
							} else {
								$messageStack->add_session('Copy type not specified.', 'error');
							}
						}
					}
				}
				vam_redirect(vam_href_link(FILENAME_CATEGORIES, 'cPath='.$dest_category_id.'&'.vam_get_all_get_params(array ('cPath', 'action', 'pID', 'cID'))));
			}
			// --- MULTI COPY ENDS ---					

			vam_redirect(vam_href_link(FILENAME_CATEGORIES, 'cPath='.$_GET['cPath'].'&'.vam_get_all_get_params(array ('cPath', 'action', 'pID', 'cID'))));
			break;
			#EOB multi_action_confirm			

	} //EOB switch action
} //EOB if action

// check if the catalog image directory exists
if (is_dir(DIR_FS_CATALOG_IMAGES)) {
	if (!is_writeable(DIR_FS_CATALOG_IMAGES))
		$messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
} else {
	$messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
}

// end of pre-checks and actions, HTML output follows


// Generate category reverse path in title - START

$title_category_path_string = '';

if ( isset( $_GET[ 'pID' ] ) )
{
    $title_category_path_string = vam_get_products_name( (int)$_GET[ 'pID' ] ).' - ';
};


$title_category_path_current_id = $current_category_id;

while ( $title_category_path_current_id )
{
    $title_category_path_query = vam_db_query( "select categories_name from  " . TABLE_CATEGORIES_DESCRIPTION . " where language_id = '" . $_SESSION['languages_id'] . "' and categories_id = '" . $title_category_path_current_id . "'" );
    $title_category_path_result = vam_db_fetch_array( $title_category_path_query );
    $title_category_path_string .= $title_category_path_result[ 'categories_name' ];

    $title_category_path_query = vam_db_query( "select parent_id from  " . TABLE_CATEGORIES . " where categories_id = '" . $title_category_path_current_id . "'" );
    $title_category_path_result = vam_db_fetch_array( $title_category_path_query );
    $title_category_path_current_id = $title_category_path_result[ 'parent_id' ];
    if ( $title_category_path_current_id != 0 ) $title_category_path_string .= '-';

};  // while ( $title_category_path_current_id )

if ( !$title_category_path_string ) $title_category_path_string = TITLE;

// Generate category reverse path in title - END




?>

<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset="<?php echo $_SESSION['language_charset']; ?>">
		<title><?php echo $title_category_path_string; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
		<script type="text/javascript" src="includes/javascript/categories.js"></script>
		<!-- AJAX Attribute Manager -->
		<?php require_once( 'attributeManager/includes/attributeManagerHeader.inc.php' )?>
		<!-- AJAX Attribute Manager end -->
		<script type="text/javascript" src="includes/general.js"></script>
<?php 
	$query = vam_db_query("SELECT code FROM ".TABLE_LANGUAGES." WHERE languages_id='".$_SESSION['languages_id']."'");
	$data = vam_db_fetch_array($query);
	// generate editor for categories EDIT
	$languages = vam_get_languages();

	// generate editor for categories
	if ($_GET['action'] == 'new_category' || $_GET['action'] == 'edit_category') {
		//for ($i = 0; $i < sizeof($languages); $i ++) {
			echo vam_wysiwyg_tiny('categories_description', $data['code'], $languages[$i]['id']);
		//}
	}

	// generate editor for products
	if ($_GET['action'] == 'new_product') {
		//for ($i = 0; $i < sizeof($languages); $i ++) {
			echo vam_wysiwyg_tiny('products_description', $data['code'], $languages[$i]['id']);
		//}
	} 
?>
</head>
<!-- AJAX Attribute Manager -->
<body onload="goOnLoad();" marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- AJAX Attribute Manager end -->

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
    
        <table border="0" width="100%" cellspacing="0" cellpadding="0" class="pageHead">
        <tr>
         <td class="pageHeading" align="left">
         <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>   
         </td>
         <td>
                <?php 
                    echo vam_draw_form('goto', FILENAME_CATEGORIES, '', 'get', 'class="form-inline"');
                    echo HEADING_TITLE_GOTO . ' ' . vam_draw_pull_down_menu('cPath', vam_get_category_tree(), $current_category_id, 'onChange="this.form.submit();"').vam_draw_hidden_field(vam_session_name(), vam_session_id()); 
                ?>
                </form>
         </td>
         <td align="right">
                <?php 
                    echo vam_draw_form('search', FILENAME_CATEGORIES, '', 'get'); 
                    echo HEADING_TITLE_SEARCH . ' ' . vam_draw_input_field('search').vam_draw_hidden_field(vam_session_name(), vam_session_id()); 
                ?>
                </form>
         </td>
       </tr>
       </table>

    
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">

                    <?php

//----- new_category / edit_category (when ALLOW_CATEGORY_DESCRIPTIONS is 'true') -----
if ($_GET['action'] == 'new_category' || $_GET['action'] == 'edit_category') {
	include (DIR_WS_MODULES.'new_category.php');
}
elseif ($_GET['action'] == 'new_product') {
	include (DIR_WS_MODULES.'new_product.php');
}
elseif ($_GET['action'] == 'edit_crossselling') {
	include (DIR_WS_MODULES.'cross_selling.php');
} else {
	//set $cPath to 0 if not set - FireFox workaround, didn't work when de/activating categories and $cPath wasn't set
	if (!$cPath) { $cPath = '0'; }
	include (DIR_WS_MODULES.'categories_view.php');
}
?>
                <!-- close tables from above modules //-->
				</table></td>
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
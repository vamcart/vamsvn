<?php
/* --------------------------------------------------------------
   $Id: yml_import.php,v 1.1 2010-08-06 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2010 VaMSoft Ltd.
   --------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------*/
   
function unhtmlentities($string) {
  $trans_tbl = get_html_translation_table(HTML_ENTITIES);
  $trans_tbl = array_flip ($trans_tbl);
  return strtr ($string, $trans_tbl);
}

require('includes/application_top.php');

if ($_POST['action']=='import') {
  if (is_uploaded_file($_FILES['xml_file']['tmp_name'])) {


$xml = simplexml_load_file($_FILES['xml_file']['tmp_name']);

    $count=0;
    $count_upd=0;
    $count_add=0;
    $count_cat_upd=0;
    $count_cat_add=0;
    
    // Categories import
    
    foreach ($xml->shop->categories->category as $category) {

      $categories_id = $category['id'];
      $parent_id = ((!isset($category['parentId'])) ? 0 : $category['parentId']);
      $categories_name = unhtmlentities($category);
      $categories_description = '';

      $categories_query = vam_db_query("select categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . $categories_id . "' and language_id = '".$_SESSION['languages_id']."' limit 1");
      if (vam_db_num_rows($categories_query)) {
        $row=vam_db_fetch_array($categories_query);
        if ($row['categories_name']!=$categories_name) {
          vam_db_perform(TABLE_CATEGORIES, array('last_modified' => 'now()', 'parent_id' => $parent_id, 'categories_status' => 1, 'group_permission_0' => 1, 'group_permission_1' => 1, 'group_permission_2' => 1, 'group_permission_3' => 1, 'date_added' => 'now()'), 'update', 'categories_id=\''.$categories_id.'\'');
          vam_db_perform(TABLE_CATEGORIES_DESCRIPTION, array('categories_name' => $categories_name, 'categories_description' => $categories_description), 'update', 'categories_id=\''.$categories_id.'\' and language_id=\''.$_SESSION['languages_id'].'\'');
          $count_cat_upd++;
        }
      } else {
          vam_db_perform(TABLE_CATEGORIES, array('categories_id' => $categories_id, 'last_modified' => 'now()', 'parent_id' => $parent_id, 'categories_status' => 1, 'group_permission_0' => 1, 'group_permission_1' => 1, 'group_permission_2' => 1, 'group_permission_3' => 1, 'date_added' => 'now()'));
          vam_db_perform(TABLE_CATEGORIES_DESCRIPTION, array('categories_id' => $categories_id, 'categories_name' => $categories_name, 'categories_description' => $categories_description));
        $count_cat_add++;
      }
      
    }
        
    // Products import

    foreach ($xml->shop->offers->offer as $product) {
    	
      $products_id = $product['id'];
      $products_stock = (($product['available']) ? 0 : 10000);
      
      foreach ($product->param as $params) {
      if ($params['name'] == "Артикул") {
    	  $products_model = (($params['name'] == "Артикул") ? $params : $products_id);
      }
      if ($params['name'] == "Цена РРЦ") {
    	  $products_price = (($params['name'] == "Цена РРЦ") ? $params : $product->price);
      }
      if ($params['name'] == "Количество") {
    	  $products_quantity = (($params['name'] == "Количество") ? $params : $products_stock);
      }
      }
      
      $categoryId = $product->categoryId;
      $products_image = substr(strrchr($product->picture, "/"), 1);
      $products_name = unhtmlentities($product->name);
      $products_description = unhtmlentities($product->description);
      $products_status = 1;

      $products_query = vam_db_query("select products_id, products_price from " . TABLE_PRODUCTS . " where products_id = '" . $products_id . "' limit 1");
      if (vam_db_num_rows($products_query)) {
        $row=vam_db_fetch_array($products_query);
        if ($row['products_price']!=$products_price) {
          vam_db_perform(TABLE_PRODUCTS, array(
          'products_last_modified' => 'now()', 
          'products_price' => $products_price, 
          'products_image' => $products_image, 
          'group_permission_0' => 1, 
          'group_permission_1' => 1, 
          'group_permission_2' => 1, 
          'group_permission_3' => 1, 
          'products_startpage' => 1, 
          'products_status' => $products_status, 
          'products_quantity' => $products_quantity, 
          'products_model' => $products_model, 
          'products_date_available' => 'now()'), 
          'update', 'products_id=\''.$products_id.'\'');
          vam_db_perform(TABLE_PRODUCTS_DESCRIPTION, array(
          'products_name' => $products_name, 
          'products_description' => $products_description), 
          'update', 'products_id=\''.$products_id.'\' and language_id=\''.$_SESSION['languages_id'].'\'');
          $count_upd++;
        }
      } else {
        vam_db_perform(TABLE_PRODUCTS, array(
        'products_id' => $products_id, 
        'products_last_modified' => 'now()', 
        'products_price' => $products_price, 
        'products_image' => $products_image, 
        'group_permission_0' => 1, 
        'group_permission_1' => 1, 
        'group_permission_2' => 1, 
        'group_permission_3' => 1, 
        'products_startpage' => 1, 
        'products_status' => $products_status, 
        'products_quantity' => $products_quantity, 
        'products_model' => $products_model, 
        'products_date_available' => 'now()')
        );
        vam_db_perform(TABLE_PRODUCTS_DESCRIPTION, array(
        'products_id' => $products_id, 
        'products_name' => $products_name, 
        'products_description' => $products_description, 
        'language_id' => $_SESSION['languages_id'])
        );
        vam_db_perform(TABLE_PRODUCTS_TO_CATEGORIES, array(
        'products_id' => $products_id, 
        'categories_id' => $categoryId)
        );
        
		//MO_PICS
		$img = 0;
		$products_image_name = '';
		foreach ($product->picture as $image) {
			
			$products_image_name = substr(strrchr($image, "/"), 1);
			
			//echo var_dump($image);
			if ($products_image != $products_image_name) {			
			create_MO_PICS ($products_image_name, $img, 'insert', $products_id, $products_data);
			}
			$img++;
		}
        
        $count_add++;
      }
      $count++;
    }

    $messageStack->add_session(TEXT_YML_UPDATED.$count_upd, 'success');
    $messageStack->add_session(TEXT_YML_CHANGED.($count-$count_upd), 'success');
    $messageStack->add_session(TEXT_YML_ADDED.$count_add, 'success');
    $messageStack->add_session(TEXT_YML_CAT_ADDED.$count_cat_add, 'success');
    $messageStack->add_session(TEXT_YML_CAT_UPDATED.$count_cat_upd, 'success');
  } else {
    $messageStack->add_session(TEXT_YML_ERROR, 'error');
  }

  vam_redirect(vam_href_link(FILENAME_YML_IMPORT));
}

//BOF Added by Andreaz. Support-Functions for images.
function create_MO_PICS ($mo_products_image_name, $mo_image_number, $performed_action, $products_id, &$products_data){
	$absolute_image_number = $mo_image_number+1;
	$mo_img = array ('products_id' => vam_db_prepare_input($products_id), 
			'image_nr' => vam_db_prepare_input($absolute_image_number), 
			'image_name' => vam_db_prepare_input($mo_products_image_name),
			'image_description' => vam_db_prepare_input($products_data['mo_pics_descr_'.$mo_image_number]) );
	$previous_image_name = $products_data['products_previous_image_'.$absolute_image_number];

	
	if ($performed_action == 'insert') {
		//New product add. Insert new additional image record into DB
		vam_db_perform(TABLE_PRODUCTS_IMAGES, $mo_img);
	} elseif ($performed_action == 'update' && $previous_image_name) {
		//We update existing product and previous image exists.
		if ($products_data['del_mo_pic']) {
			foreach ($products_data['del_mo_pic'] AS $dummy => $val) {
				//MO_PICS records were deleted - insert if necessary
				if ($val == $previous_image_name){
					vam_db_perform(TABLE_PRODUCTS_IMAGES, $mo_img);
				}
				break;
			}
		}
		//Update DB with new existing image
		vam_db_perform(TABLE_PRODUCTS_IMAGES, $mo_img, 'update', 'image_name = \''.vam_db_input($previous_image_name).'\'');
	} elseif (!$previous_image_name){
		//additional picture was not exists before. Insert it into DB
		vam_db_perform(TABLE_PRODUCTS_IMAGES, $mo_img);
	}

	//assign products_image_name right value to correctly create thumbnail, info and popup images
	$products_image_name = $mo_products_image_name;
	
	//require (DIR_WS_INCLUDES.'product_thumbnail_images.php');
	//require (DIR_WS_INCLUDES.'product_info_images.php');
	//require (DIR_WS_INCLUDES.'product_popup_images.php');
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
    <td class="boxCenter" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td class="main">
        
    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
            
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
         
          <tr>
        <td class="main">
          <?php echo vam_draw_form('xml_import', FILENAME_YML_IMPORT, '', 'post', 'enctype="multipart/form-data"') ."\n". vam_draw_file_field('xml_file') ."\n"; ?>
          <input type="hidden" name="action" value="import">
          <br>
          <?php echo TEXT_YML_MAX_SIZE; ?> <b><?php echo ini_get('upload_max_filesize'); ?></b><br />
          <span class="button"><button type="submit" value="<?php echo TEXT_YML_IMPORT; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/import.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_YML_IMPORT; ?></button>
          </form>
        </td>
        <td class="main" width="50%" valign="bottom">
          <a class="button" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG.'market.php'; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/export.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_YML_EXPORT; ?></span></a>
        </td>
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
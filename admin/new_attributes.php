<?php
/* --------------------------------------------------------------
   $Id: new_attributes.php 1313 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_attributes); www.oscommerce.com
   (c) 2003         nextcommerce (new_attributes.php,v 1.13 2003/08/21); www.nextcommerce.org
   (c) 2004	 xt:Commerce (new_attributes.php,v 1.13 2003/08/21); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contributions:
   New Attribute Manager v4b                                Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
   copy attributes                          Autor: Hubi | http://www.netz-designer.de

   Released under the GNU General Public License
   --------------------------------------------------------------*/


  require('includes/application_top.php');
  require(DIR_WS_MODULES.'new_attributes_config.php');
  require(DIR_FS_INC .'vam_findTitle.inc.php');
  require_once(DIR_FS_INC . 'vam_format_filesize.inc.php');

  if ($_POST['cpath']!='' && $_POST['action'] == 'change') {
    include(DIR_WS_MODULES.'new_attributes_change.php');

    vam_redirect( './' . FILENAME_CATEGORIES . '?cPath=' . $_POST['cpath'] . '&pID=' . $_POST['current_product_id'] );
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
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php
  require(DIR_WS_INCLUDES . 'header.php');
?>
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

  if (empty($_POST['action']))
      foreach (array('action', 'current_product_id', 'cpath') as $k)
          if (empty($_POST[$k]) && !empty($_GET[$k]))
              $_POST[$k] = $_GET[$k];

  switch($_POST['action']) {
    case 'edit':
      if ($_POST['copy_product_id'] != 0) {
          $attrib_query = vam_db_query("SELECT products_id, options_id, options_values_id, options_values_price, price_prefix, attributes_model, attributes_stock, options_values_weight, weight_prefix, sortorder FROM ".TABLE_PRODUCTS_ATTRIBUTES." WHERE products_id = " . $_POST['copy_product_id']);
          while ($attrib_res = vam_db_fetch_array($attrib_query)) {
              vam_db_query("INSERT into ".TABLE_PRODUCTS_ATTRIBUTES." (products_id, options_id, options_values_id, options_values_price, price_prefix, attributes_model, attributes_stock, options_values_weight, weight_prefix, sortorder) VALUES ('" . $_POST['current_product_id'] . "', '" . $attrib_res['options_id'] . "', '" . $attrib_res['options_values_id'] . "', '" . $attrib_res['options_values_price'] . "', '" . $attrib_res['price_prefix'] . "', '" . $attrib_res['attributes_model'] . "', '" . $attrib_res['attributes_stock'] . "', '" . $attrib_res['options_values_weight'] . "', '" . $attrib_res['weight_prefix'] . "', '" . $attrib_res['sortorder'] . "')");
          }
      }
      $pageTitle = TITLE_EDIT.': ' . vam_findTitle($_POST['current_product_id'], $languageFilter);
      include(DIR_WS_MODULES.'new_attributes_include.php');
      break;

    case 'change':
      $pageTitle = TITLE_UPDATED;
      include(DIR_WS_MODULES.'new_attributes_change.php');
      include(DIR_WS_MODULES.'new_attributes_select.php');
      break;

    default:
      $pageTitle = TITLE_EDIT;
      include(DIR_WS_MODULES.'new_attributes_select.php');
      break;
  }
?>

    </td>
  </tr>
<!-- body_eof //-->
  <tr>
  <td>
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</td>
</tr>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
<?php
/* --------------------------------------------------------------
   $Id: stats_stock_warning.php 899 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(stats_products_viewed.php,v 1.27 2003/01/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (stats_stock_warning.php,v 1.9 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (stats_stock_warning.php,v 1.9 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');
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
    <td class="boxCenter" valign="top">
    
    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
             <td><table width="100%">
<?php
  $products_query = vam_db_query("SELECT p.products_id, p.products_quantity, pd.products_name FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd WHERE pd.language_id = '" . $_SESSION['languages_id'] . "' AND pd.products_id = p.products_id ORDER BY products_quantity");
  while ($products_values = vam_db_fetch_array($products_query)) {
    echo '<tr><td width="50%" class="dataTableContent"><a href="' . vam_href_link(FILENAME_CATEGORIES, 'pID=' . $products_values['products_id'] . '&action=new_product') . '"><b>' . $products_values['products_name'] . '</b></a></td><td width="50%" class="dataTableContent">';
    if ($products_values['products_quantity'] <='0') {
      echo '<font color="ff0000"><b>'.$products_values['products_quantity'].'</b></font>';
    } else {
      echo $products_values['products_quantity'];
    }
    echo '</td></tr>';

    $products_attributes_query = vam_db_query("SELECT
                                                   pov.products_options_values_name,
                                                   pa.attributes_stock
                                               FROM
                                                   " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov
                                               WHERE
                                                   pa.products_id = '".$products_values['products_id'] . "' AND pov.products_options_values_id = pa.options_values_id AND pov.language_id = '" . $_SESSION['languages_id'] . "' ORDER BY pa.attributes_stock");
								
    while ($products_attributes_values = vam_db_fetch_array($products_attributes_query)) {
      echo '<tr><td width="50%" class="dataTableContent">&nbsp;&nbsp;&nbsp;&nbsp;-' . $products_attributes_values['products_options_values_name'] . '</td><td width="50%" class="dataTableContent">';
      if ($products_attributes_values['attributes_stock'] <= '0') {
        echo '<font color="ff0000"><b>' . $products_attributes_values['attributes_stock'] . '</b></font>';
      } else {
        echo $products_attributes_values['attributes_stock'];
      }
      echo '</td></tr>';
    }
  }
?>  
	        </table></td>
              </tr>
            </table></td>
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
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
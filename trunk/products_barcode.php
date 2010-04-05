<?php
/* -----------------------------------------------------------------------------------------
   $Id: products_barcode.php 1 27.03.2010 16:35:19 AndrewBerezin $
 
   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com
 
   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_info.php,v 1.94 2003/05/04); www.oscommerce.com
   (c) 2003      nextcommerce (product_info.php,v 1.46 2003/08/25); www.nextcommerce.org
   (c) 2004      xt:Commerce (product_info.php,v 1.46 2003/08/25); xt-commerce.com
 
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
 
define('BARCODE_HEIGHT', '50');
define('BARCODE_SCALE', '1.25');
 
if (isset($_GET['products_id']) && (int)$_GET['products_id'] > 0) {
  include ('includes/application_top.php');
  $ean_query = vam_db_query("SELECT products_ean FROM " . TABLE_PRODUCTS . " WHERE products_id='" . (int)$_GET['products_id'] . "'");
  if (($eanData = vam_db_fetch_array($ean_query)) && $eanData['products_ean'] != '') {
    require_once(DIR_WS_CLASSES . 'barcode.inc.php');
    $barcode = new barcode;
    $barcode->setHeight(BARCODE_HEIGHT);
    $barcode->setScale(BARCODE_SCALE);
    $barcode->setFont(DIR_WS_INCLUDES . 'fonts/arialbd.ttf');
    $barcode->setFormat('gif');
    if ($barcode->genBarCode($eanData['products_ean']) == false) {
      $barcode->error(true);
    }
  }
  include ('includes/application_bottom.php');
}

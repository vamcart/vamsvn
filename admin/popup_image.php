<?php
/* --------------------------------------------------------------
   $Id: popup_image.php 899 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(popup_image.php,v 1.6 2002/05/20); www.oscommerce.com 
   (c) 2003	 nextcommerce (popup_image.php,v 1.7 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (popup_image.php,v 1.7 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  foreach (array_keys($_GET) as $key) {
    switch ($key) {
      case 'banner':
        $banners_id = vam_db_prepare_input($_GET['banner']);

        $banner_query = vam_db_query("select banners_title, banners_image, banners_html_text from " . TABLE_BANNERS . " where banners_id = '" . vam_db_input($banners_id) . "'");
        $banner = vam_db_fetch_array($banner_query);

        $page_title = $banner['banners_title'];

        if ($banner['banners_html_text']) {
          $image_source = $banner['banners_html_text'];
        } elseif ($banner['banners_image']) {
          $image_source = vam_image(HTTP_CATALOG_SERVER . DIR_WS_CATALOG_IMAGES . 'banner/' . $banner['banners_image'], $page_title);
        }
        break;
    }
  }
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<!--<meta name="viewport" content="initial-scale=1.0, width=device-width" />-->
<title><?php echo $page_title; ?></title>
<script type="text/javascript"><!--
var i=0;

function resize() {
  if (navigator.appName == 'Netscape') i = 40;
  window.resizeTo(document.images[0].width + 30, document.images[0].height + 60 - i);
}
//--></script>
</head>
<body onload="resize();">
<?php echo $image_source; ?>
</body>
</html>
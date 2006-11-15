<?php

/* -----------------------------------------------------------------------------------------
   $Id: popup_image.php 859 2005-04-14 18:15:06Z novalis $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2004 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(popup_image.php,v 1.12 2001/12/12); www.oscommerce.com 

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Modified by BIA Solutions (www.biasolutions.com) to create a bordered look to the image

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require ('includes/application_top.php');
require_once (DIR_FS_INC.'xtc_get_products_mo_images.inc.php');

if ((int) $_GET['imgID'] == 0) {
	$products_query = xtc_db_query("select pd.products_name, p.products_image from ".TABLE_PRODUCTS." p left join ".TABLE_PRODUCTS_DESCRIPTION." pd on p.products_id = pd.products_id where p.products_status = '1' and p.products_id = '".(int) $_GET['pID']."' and pd.language_id = '".(int) $_SESSION['languages_id']."'");
	$products_values = xtc_db_fetch_array($products_query);
} else {
	$products_query = xtc_db_query("select pd.products_name, p.products_image, pi.image_name from ".TABLE_PRODUCTS_IMAGES." pi, ".TABLE_PRODUCTS." p left join ".TABLE_PRODUCTS_DESCRIPTION." pd on p.products_id = pd.products_id where p.products_status = '1' and p.products_id = '".(int) $_GET['pID']."' and pi.products_id = '".(int) $_GET['pID']."' and pi.image_nr = '".(int) $_GET['imgID']."' and pd.language_id = '".(int) $_SESSION['languages_id']."'");
	$products_values = xtc_db_fetch_array($products_query);
	$products_values['products_image'] = $products_values['image_name'];
}

// get x and y of the image
$img = DIR_WS_POPUP_IMAGES.$products_values['products_image'];
$size = GetImageSize("$img");

//get data for mo_images
$mo_images = xtc_get_products_mo_images((int) $_GET['pID']);
$img = DIR_WS_THUMBNAIL_IMAGES.$products_values['products_image'];
$osize = GetImageSize("$img");
if ($mo_images != false) {
	//$bwidth = $osize[0];
	$bheight = $osize[1];
	foreach ($mo_images as $mo_img) {
		$img = DIR_WS_THUMBNAIL_IMAGES.$mo_img['image_name'];
		$mo_size = GetImageSize("$img");
		// if ($mo_size[0] > $bwidth)  $bwidth  = $mo_size[0];
		if ($mo_size[1] > $bheight)
			$bheight = $mo_size[1];
	}
	$bheight += 50;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>" /> 
<meta http-equiv="Content-Style-Type" content="text/css" />
<title><?php echo $products_values['products_name']; ?></title>
<base href="<?php echo (getenv('HTTPS') == 'on' ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo 'templates/'.CURRENT_TEMPLATE.'/stylesheet.css'; ?>" />
<script type="text/javascript"><!--
var i=0;
function resize() {
  if (navigator.appName == 'Netscape') i=40;
  window.resizeTo(<? echo $size[0] ?> +105, <? echo $size[1] + $bheight ?>+150+i);
  self.focus();
}
//--></script>
</head>
<body onload="resize();">

<!-- xtc_image($src, $alt = '', $width = '', $height = '', $params = '') /-->
    
<!-- big image -->
<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="pagecontent">
<p class="center">
<span class="bold"><?php echo $products_values['products_name']; ?></span>
</p>
<p class="center">
<?php echo xtc_image(DIR_WS_POPUP_IMAGES . $products_values['products_image'], $products_values['products_name'], $size[0], $size[1]); ?>
</p>

<!-- thumbs -->
<p class="center">
<?php

if ($mo_images != false) {
?>
<iframe src="<?php echo 'show_product_thumbs.php?pID='.(int)$_GET['pID'].'&imgID='.(int)$_GET['imgID']; ?>" width="<?php echo $size[0]+40; ?>" height="<?php echo $bheight+5; ?>" border="0" frameborder="0">
    <a href="<?php echo 'show_product_thumbs.php?pID='.(int)$_GET['pID'].'&imgID='.(int)$_GET['imgID']; ?>">More Images</a>
</iframe><br />
<?php

}
?>
</p>
</div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
<div class="pagecontentfooter">
<a href="javascript:window.close()"><?php echo TEXT_CLOSE_WINDOW; ?></a>
</div>
</div>

</body>
</html>
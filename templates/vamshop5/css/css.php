<meta name="theme-color" content="#fff">
<link rel="preload" as="font" type="font/woff2" crossorigin href="templates/<?php echo CURRENT_TEMPLATE; ?>/webfonts/fa-solid-900.woff2"/>
<link rel="preload" as="font" type="font/woff2" crossorigin href="templates/<?php echo CURRENT_TEMPLATE; ?>/webfonts/fa-regular-400.woff2"/>
<link rel="preload" as="font" type="font/woff2" crossorigin href="templates/<?php echo CURRENT_TEMPLATE; ?>/webfonts/fa-brands-400.woff2"/>
<!-- Vendor Styles including: Font Icons, Plugins, etc.-->
<link rel="stylesheet" media="screen" href="templates/<?php echo CURRENT_TEMPLATE; ?>/css/font-awesome.css"/>
<link rel="stylesheet" media="screen" href="templates/<?php echo CURRENT_TEMPLATE; ?>/dist/vendor/simplebar/dist/simplebar.min.css"/>
<link rel="stylesheet" media="screen" href="templates/<?php echo CURRENT_TEMPLATE; ?>/dist/vendor/tiny-slider/dist/tiny-slider.css"/>
<link rel="stylesheet" media="screen" href="templates/<?php echo CURRENT_TEMPLATE; ?>/dist/vendor/nouislider/distribute/nouislider.min.css"/>
<link rel="stylesheet" media="screen" href="templates/<?php echo CURRENT_TEMPLATE; ?>/dist/vendor/drift-zoom/dist/drift-basic.min.css"/>
<link rel="stylesheet" media="screen" href="templates/<?php echo CURRENT_TEMPLATE; ?>/dist/vendor/lightgallery.js/dist/css/lightgallery.min.css"/>
<!-- Main Theme Styles + Bootstrap-->
<link rel="stylesheet" media="screen" href="templates/<?php echo CURRENT_TEMPLATE; ?>/dist/css/theme.min.css">
<link rel="stylesheet" media="screen" href="templates/<?php echo CURRENT_TEMPLATE; ?>/css/vamshop5.css">
<?php
if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO) or strstr($PHP_SELF, FILENAME_PRODUCT_REVIEWS_INFO) or strstr($PHP_SELF, FILENAME_PRODUCT_REVIEWS) or strstr($PHP_SELF, FILENAME_REVIEWS)) {
?>
<link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/colorbox/colorbox.css" media="screen" />
<?php
}
?>
<?php
if ( strstr($PHP_SELF, FILENAME_ADDRESS_BOOK)
	or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT)
	or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT_ADDRESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING_ADDRESS)
	or strstr($PHP_SELF, FILENAME_CREATE_ACCOUNT) ) {
?>
<link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/select2/select2.css" media="screen" />
<link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/select2/select2-bootstrap.css" media="screen" />
<link rel="stylesheet" type="text/css" href="templates/<?php echo CURRENT_TEMPLATE; ?>/css/suggestions.css" media="all" />
<?php
}
?>
<?php
if (file_exists(dirname(__FILE__) . '/local.css.php')) include('local.css.php');
?>
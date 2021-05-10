<meta name="theme-color" content="#fff">
<link rel="preload" as="font" type="font/woff2" crossorigin href="templates/<?php echo CURRENT_TEMPLATE; ?>/webfonts/fa-solid-900.woff2"/>
<link rel="preload" as="font" type="font/woff2" crossorigin href="templates/<?php echo CURRENT_TEMPLATE; ?>/webfonts/fa-regular-400.woff2"/>
<link rel="preload" as="font" type="font/woff2" crossorigin href="templates/<?php echo CURRENT_TEMPLATE; ?>/webfonts/fa-brands-400.woff2"/>

<?php
require_once(DIR_FS_CATALOG."vendor/Bender/Bender.class.php");
$bender = new Bender();
$bender->enqueue("templates/".CURRENT_TEMPLATE."/css/font-rubik.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/css/font-awesome.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/dist/vendor/simplebar/dist/simplebar.min.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/dist/vendor/tiny-slider/dist/tiny-slider.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/dist/vendor/nouislider/distribute/nouislider.min.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/dist/vendor/drift-zoom/dist/drift-basic.min.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/dist/css/theme.min.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/css/vamshop5.css");
?>
<?php
echo $bender->output("templates/".CURRENT_TEMPLATE."/cache/".CURRENT_TEMPLATE."-packed.css");
?>
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
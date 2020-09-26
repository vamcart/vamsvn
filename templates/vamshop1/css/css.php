<link rel="preload" as="font" type="font/woff2" crossorigin href="templates/<?php echo CURRENT_TEMPLATE; ?>/webfonts/fa-solid-900.woff2"/>
<link rel="preload" as="font" type="font/woff2" crossorigin href="templates/<?php echo CURRENT_TEMPLATE; ?>/webfonts/fa-regular-400.woff2"/>
<link rel="preload" as="font" type="font/woff2" crossorigin href="templates/<?php echo CURRENT_TEMPLATE; ?>/webfonts/fa-brands-400.woff2"/>
<?php
require_once(DIR_FS_CATALOG."vendor/Bender/Bender.class.php");
$bender = new Bender();
$bender->enqueue("templates/".CURRENT_TEMPLATE."/bootstrap/bootstrap.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/font-awesome.css");
//$bender->enqueue("jscript/jquery/plugins/slick/slick.css");
//$bender->enqueue("jscript/jquery/plugins/slick/slick-theme.css");
//$bender->enqueue("jscript/jquery/plugins/read-more/jquery.expandable.css");
$bender->enqueue("jscript/jquery/plugins/owl/assets/owl.carousel.min.css");
$bender->enqueue("jscript/jquery/plugins/owl/assets/owl.theme.default.min.css");
$bender->enqueue("jscript/jquery/plugins/select2/select2.css");
$bender->enqueue("jscript/jquery/plugins/select2/select2-bootstrap.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/sequencejs.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/jpushmenu.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/stylesheet.css");
?>
<?php
echo $bender->output("templates/".CURRENT_TEMPLATE."/cache/".CURRENT_TEMPLATE."-packed.css");
?>
<?php
if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO)) {
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
<link rel="stylesheet" type="text/css" href="templates/<?php echo CURRENT_TEMPLATE; ?>/suggestions.css" media="all" />
<?php
}
?>
<?php
if (file_exists(dirname(__FILE__) . '/local.css.php')) include('local.css.php');
?>
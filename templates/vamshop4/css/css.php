<?php
require_once(DIR_FS_CATALOG."vendor/Bender/Bender.class.php");
$bender = new Bender();
$bender->enqueue("templates/".CURRENT_TEMPLATE."/css/mplusrounded1c.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/css/bootstrap.min.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/bootstrap-ecommerce/ui.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/bootstrap-ecommerce/responsive.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/css/font-awesome.css");
$bender->enqueue("jscript/jquery/plugins/owl/assets/owl.carousel.min.css");
$bender->enqueue("jscript/jquery/plugins/owl/assets/owl.theme.default.min.css");
$bender->enqueue("jscript/jquery/plugins/ui/css/smoothness/jquery-ui.css");
$bender->enqueue("jscript/jquery/plugins/select2/select2.css");
$bender->enqueue("jscript/jquery/plugins/select2/select2-bootstrap.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/css/vamshop.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/css/vamshop4.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/webslidemenu/dropdown-effects/fade-down.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/webslidemenu/webslidemenu.css");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/webslidemenu/color-skins/white-blue.css");
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
<link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/select2/select2.css" media="screen" />
<link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/select2/select2-bootstrap.css" media="screen" />
<link rel="stylesheet" type="text/css" href="templates/<?php echo CURRENT_TEMPLATE; ?>/css/suggestions.css" media="all" />
<?php
}
?>
<?php
if (file_exists(dirname(__FILE__) . '/local.css.php')) include('local.css.php');
?>
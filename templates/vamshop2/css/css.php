<link rel="stylesheet" type="text/css" href="<?php echo 'templates/'.CURRENT_TEMPLATE.'/stylesheet.css'; ?>" />
<?php
if (strstr($PHP_SELF, FILENAME_CHECKOUT)) {
?>
<link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/select2/select2.css" media="screen" />
<link rel="stylesheet" type="text/css" href="jscript/jquery/plugins/select2/select2-bootstrap.css" media="screen" />
<?php 
} 
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
<link rel="stylesheet" type="text/css" href="templates/<?php echo CURRENT_TEMPLATE; ?>/suggestions.css" media="all" />
<?php
}
?>
<?php
if ( strstr($PHP_SELF, FILENAME_ADDRESS_BOOK)
	or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT)
	or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT_ADDRESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING_ADDRESS)
	or strstr($PHP_SELF, FILENAME_CREATE_ACCOUNT) ) {
?>
<script src="jscript/jquery/plugins/chosen/chosen.jquery.min.js"></script>
<script type="text/javascript">
$(function($){

<?php if (ACCOUNT_STATE == 'true') { ?>
	  $("#state").chosen({
	      no_results_text:"<?php echo TEXT_NOT_FOUND; ?>",
	      search_contains:true,
	      placeholder_text_single:"<?php echo PULL_DOWN_DEFAULT; ?>"
	  }); 
<?php } ?>

<?php if (ACCOUNT_COUNTRY == 'true') { ?>
	  $("#country").chosen({
	      no_results_text:"<?php echo TEXT_NOT_FOUND; ?>",
	      search_contains:true,
	      placeholder_text_single:"<?php echo PULL_DOWN_DEFAULT; ?>"
	  }); 
<?php } ?>

});
</script>
<?php } ?>
<?php
if (file_exists(dirname(__FILE__) . '/local_footer.js.php')) include('local_footer.js.php');
?>
<?php
require_once(DIR_FS_CATALOG."vendor/Bender/Bender.class.php");
$bender = new Bender();
$bender->enqueue("jscript/bootstrap/bootstrap.min.js");
$bender->enqueue("jscript/jquery/plugins/easing/jquery.easing.1.3.js");
$bender->enqueue("jscript/jquery/plugins/jpushmenu/v2p.js");
$bender->enqueue("jscript/jquery/plugins/jpushmenu/jpushmenu.js");
$bender->enqueue("jscript/jquery/plugins/scrollup/jquery.scrollup.min.js");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/javascript/vamshop.js");
if (AJAX_CART == 'true') $bender->enqueue("templates/".CURRENT_TEMPLATE."/javascript/jscript_ajax_cart.js"); 
?>
<?php
echo $bender->output("templates/".CURRENT_TEMPLATE."/cache/".CURRENT_TEMPLATE."-packed.js");
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
if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO)) {
?>
<script src="jscript/jquery/plugins/colorbox/jquery.colorbox-min.js"></script>
<?php
if (file_exists(DIR_FS_CATALOG.'jscript/jquery/plugins/colorbox/i18n/jquery.colorbox-'.$_SESSION['language_code'].'.js')) {
?>
<script src="jscript/jquery/plugins/colorbox/i18n/jquery.colorbox-ru.js"></script>
<?php } ?>
<script>
// Make ColorBox responsive
	jQuery.colorbox.settings.maxWidth  = '95%';
	jQuery.colorbox.settings.maxHeight = '95%';

	// ColorBox resize function
	var resizeTimer;
	function resizeColorBox()
	{
		if (resizeTimer) clearTimeout(resizeTimer);
		resizeTimer = setTimeout(function() {
				if (jQuery('#cboxOverlay').is(':visible')) {
						jQuery.colorbox.load(true);
				}
		}, 300);
	}

	// Resize ColorBox when resizing window or changing mobile device orientation
	jQuery(window).resize(resizeColorBox);
	
$(document).ready(function(){
  $(".lightbox").colorbox({rel:"lightbox", title: false});
  $(".iframe").colorbox({iframe:true, width:"70%", height:"80%"});
});
</script>
<?php
 }
?>
<?php
if (file_exists(dirname(__FILE__) . '/local_footer.js.php')) include('local_footer.js.php');
?>
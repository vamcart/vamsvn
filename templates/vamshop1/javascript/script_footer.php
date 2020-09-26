<?php
require_once(DIR_FS_CATALOG."vendor/Bender/Bender.class.php");
$bender = new Bender();
$bender->enqueue("jscript/bootstrap/bootstrap.min.js");
$bender->enqueue("jscript/jquery/plugins/easing/jquery.easing.1.3.js");
$bender->enqueue("jscript/jquery/plugins/jpushmenu/v2p.js");
$bender->enqueue("jscript/jquery/plugins/jpushmenu/jpushmenu.js");
$bender->enqueue("jscript/jquery/plugins/cookie/jquery.cookie.js");
//$bender->enqueue("jscript/jquery/plugins/read-more/jquery.expandable.js");
$bender->enqueue("jscript/jquery/plugins/lazyload/lazyload.min.js");
//$bender->enqueue("jscript/jquery/plugins/slick/slick.js");
$bender->enqueue("jscript/jquery/plugins/owl/owl.carousel.min.js");
$bender->enqueue("jscript/jquery/plugins/select2/select2.js");
$bender->enqueue("jscript/jquery/plugins/select2/i18n/" . $_SESSION['language_code'] . ".js");
$bender->enqueue("jscript/jquery/plugins/scrollup/jquery.scrollup.min.js");
$bender->enqueue("jscript/jquery/plugins/zoom/jquery.zoom.js");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/javascript/vamshop.js");
if (AJAX_WISHLIST == 'true') $bender->enqueue("templates/".CURRENT_TEMPLATE."/javascript/jscript_ajax_wishlist.js"); 
if (AJAX_CART == 'true') $bender->enqueue("templates/".CURRENT_TEMPLATE."/javascript/jscript_ajax_cart.js"); 
?>
<?php
echo $bender->output("templates/".CURRENT_TEMPLATE."/cache/".CURRENT_TEMPLATE."-packed.js");
?>
<?php if (ENABLE_SERVICE_WORKER == 'true') { ?>
<script>
// Register service worker to control making site work offline

$(function(){
	
if('serviceWorker' in navigator) {
  navigator.serviceWorker
           .register('/sw.js')
           .then(function() { console.log('Service Worker Registered'); });
}

});
</script>
<?php } ?>
<?php
if ( strstr($PHP_SELF, FILENAME_ADDRESS_BOOK)
	or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT)
	or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT_ADDRESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING_ADDRESS)
	or strstr($PHP_SELF, FILENAME_CREATE_ACCOUNT) ) {
?>
<script type="text/javascript">
function initialise(){
<?php if (ACCOUNT_STATE == 'true') { ?>
	  $("#state").select2({
            theme: "bootstrap",
            language: "<?php echo $_SESSION['language_code']; ?>"
     });     
<?php } ?>
<?php if (ACCOUNT_COUNTRY == 'true') { ?>
	  $("#country").select2({
            theme: "bootstrap",
            language: "<?php echo $_SESSION['language_code']; ?>"
     });     
<?php } ?>
};
$(document).ready(function(){
    initialise();
});
$(document).ajaxComplete(function () {
    initialise();
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
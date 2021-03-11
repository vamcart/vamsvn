<?php if (AJAX_CART == 'true') { ?>
<script src="<?php echo 'templates/'.CURRENT_TEMPLATE.'/javascript/jscript_ajax_cart.js'; ?>"></script>
<script>
function cartPopupOn(){ 
$('body').append('<div id="load_status_bg"></div><div class="cart_popup"><div class="cart_popuptext"><?php echo TEXT_POPUP_CART_ADD; ?></div><div class="cart_popuplink"><a href="shopping_cart.php" class="button"><span><img src="<?php echo DIR_WS_CATALOG; ?>images/icons/buttons/buy.png" alt="" title="" width="12" height="12" />&nbsp;<?php echo TEXT_POPUP_CART_CART; ?></span></a><br /><br /><a href="javascript:cartPopupOff()" class="button"><span><img src="<?php echo DIR_WS_CATALOG; ?>images/icons/buttons/back.png" alt="" title="" width="12" height="12" />&nbsp;<?php echo TEXT_POPUP_CART_CONTINUE; ?></span></a></div></div>'); 
$('#load_status_bg').show().css({'filter' : 'alpha(opacity=80)'}); 
$('.cart_popup').show(); 
$(document).click(function (){
cartPopupOff();
});
};

function cartPopupOff(){ 
$('.cart_popup').hide(); 
$('#load_status_bg').remove('#load_status_bg'); 
};
</script>
<?php } ?>
<?php
if ( strstr($PHP_SELF, FILENAME_ADDRESS_BOOK)
	or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT)
	or strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT_ADDRESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING_ADDRESS)
	or strstr($PHP_SELF, FILENAME_CREATE_ACCOUNT) ) {
?>
<script src="jscript/jquery/plugins/select2/select2.js"></script>
<script src="jscript/jquery/plugins/select2/i18n/<?php echo $_SESSION['language_code']; ?>.js"></script>
<script type="text/javascript">
function initialise(){
<?php if (MODULE_SHIPPING_SDEKPVZ_STATUS == 'True') { ?>
	  $("select#pvz_sdek").select2({
            theme: "bootstrap",
            language: "<?php echo $_SESSION['language_code']; ?>"
     });     
<?php } ?>
<?php if (MODULE_SHIPPING_BOXBERRYPVZ_STATUS == 'True') { ?>
	  //$("select#pvz_boxberry").select2({
            //theme: "bootstrap",
            //language: "<?php echo $_SESSION['language_code']; ?>"
     //});     
<?php } ?>
<?php if (MODULE_SHIPPING_NEWPOST_STATUS == 'True') { ?>
	  //$("select#pvz_newpost").select2({
            //theme: "bootstrap",
            //language: "<?php echo $_SESSION['language_code']; ?>"
     //});     
<?php } ?>
<?php if (ACCOUNT_STATE == 'true' or ACCOUNT_STATE == 'optional') { ?>
	  $("#state").select2({
            theme: "bootstrap",
            language: "<?php echo $_SESSION['language_code']; ?>"
     });     
<?php } ?>
<?php if (ACCOUNT_COUNTRY == 'true' or ACCOUNT_COUNTRY == 'optional') { ?>
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
if (ENABLE_SERVICE_WORKER == 'true') {
?>
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
<?php
 }
?>
<?php
if (file_exists(dirname(__FILE__) . '/local_footer.js.php')) include('local_footer.js.php');
?>
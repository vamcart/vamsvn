<?php
require_once(DIR_FS_CATALOG."vendor/Bender/Bender.class.php");
$bender = new Bender();
$bender->enqueue("jscript/jquery/jquery-3.4.1.min.js");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/javascript/popper.min.js");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/javascript/bootstrap.min.js");
$bender->enqueue("jscript/jquery/plugins/jquery-ui/jquery-ui-min.js");
$bender->enqueue("jscript/jquery/plugins/cookie/jquery.cookie.js");
$bender->enqueue("jscript/jquery/plugins/read-more/jquery.expandable.js");
$bender->enqueue("jscript/jquery/plugins/lazyload/lazyload.min.js");
$bender->enqueue("jscript/jquery/plugins/slick/slick.js");
$bender->enqueue("jscript/jquery/plugins/owl/owl.carousel.min.js");
$bender->enqueue("jscript/jquery/plugins/select2/select2.js");
$bender->enqueue("jscript/jquery/plugins/select2/i18n/" . $_SESSION['language_code'] . ".js");
$bender->enqueue("jscript/jquery/plugins/scrollup/jquery.scrollup.min.js");
$bender->enqueue("jscript/jquery/plugins/zoom/jquery.zoom.js");
//$bender->enqueue("jscript/jquery/plugins/equalheight/jquery.sameheight.js");
$bender->enqueue("jscript/jquery/plugins/equalheight/jquery.matchheight.js");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/javascript/vamshop4.js");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/webslidemenu/webslidemenu.js");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/javascript/jscript_ajax_wishlist.js"); 
if (AJAX_CART == 'true') $bender->enqueue("templates/".CURRENT_TEMPLATE."/javascript/jscript_ajax_cart.js"); 
?>
<?php
echo $bender->output("templates/".CURRENT_TEMPLATE."/cache/".CURRENT_TEMPLATE."-packed.js");
?>
<?php if (AJAX_CART == 'true') { ?>
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
if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO) or strstr($PHP_SELF, FILENAME_PRODUCT_REVIEWS_INFO) or strstr($PHP_SELF, FILENAME_PRODUCT_REVIEWS) or strstr($PHP_SELF, FILENAME_REVIEWS)) {
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
  $(".popup-form").colorbox({iframe:false,scrolling:true});
});
</script>
<?php
 }
?>
<?php
if (strstr($PHP_SELF, FILENAME_PRODUCT_REVIEWS_WRITE) or strstr($PHP_SELF, FILENAME_PRODUCT_REVIEWS_WRITE_POPUP)) {
?>
<script src="jscript/jquery/plugins/uploadfile/jquery.uploadfile.js"></script>
<?php } ?>
<script>(function($,d){$.each(readyQ,function(i,f){$(f)});$.each(bindReadyQ,function(i,f){$(d).on("ready",f)})})(jQuery,document)</script>
<?php
if (file_exists(dirname(__FILE__) . '/local_footer.js.php')) include('local_footer.js.php');
?>
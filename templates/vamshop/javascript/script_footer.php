<?php if (AJAX_CART == 'true') { ?>
<script src="<?php echo 'templates/'.CURRENT_TEMPLATE.'/javascript/jscript_ajax_cart.js'; ?>"></script>
<script>
function cartPopupOn(){ 
$('body').append('<div id="load_status_bg"></div><div class="cart_popup"><div class="cart_popuptext"><?php echo TEXT_POPUP_CART_ADD; ?></div><div class="cart_popuplink"><a href="checkout.php" class="button"><span><img src="<?php echo DIR_WS_CATALOG; ?>images/icons/buttons/buy.png" alt="" title="" width="12" height="12" />&nbsp;<?php echo TEXT_POPUP_CART_CHECKOUT; ?></span></a><br /><br /><a href="javascript:cartPopupOff()" class="button"><span><img src="<?php echo DIR_WS_CATALOG; ?>images/icons/buttons/back.png" alt="" title="" width="12" height="12" />&nbsp;<?php echo TEXT_POPUP_CART_CONTINUE; ?></span></a></div></div>'); 
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

// Code to handle install prompt on desktop

addBtn = document.querySelector('.a2hs-button');
if (addBtn != null) {
addBtn.style.display = 'none';

window.addEventListener('beforeinstallprompt', (e) => {
  // Prevent Chrome 67 and earlier from automatically showing the prompt
  e.preventDefault();
  // Stash the event so it can be triggered later.
  deferredPrompt = e;
  // Update UI to notify the user they can add to home screen
  addBtn.style.display = 'block';

  addBtn.addEventListener('click', (e) => {
    // hide our user interface that shows our A2HS button
    addBtn.style.display = 'none';
    // Show the prompt
    deferredPrompt.prompt();
    // Wait for the user to respond to the prompt
    deferredPrompt.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
          console.log('User accepted the A2HS prompt');
        } else {
          console.log('User dismissed the A2HS prompt');
        }
        deferredPrompt = null;
      });
  });
});
}
});
</script>
<?php
 }
?>
<?php
if (file_exists(dirname(__FILE__) . '/local_footer.js.php')) include('local_footer.js.php');
?>
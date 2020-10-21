<?php
require_once(DIR_FS_CATALOG."vendor/Bender/Bender.class.php");
$bender = new Bender();
$bender->enqueue("jscript/jquery/jquery-3.4.1.min.js");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/javascript/popper.min.js");
$bender->enqueue("templates/".CURRENT_TEMPLATE."/javascript/bootstrap.min.js");
//$bender->enqueue("jscript/jquery/plugins/jquery-ui/jquery-ui-min.js");
$bender->enqueue("jscript/jquery/plugins/cookie/jquery.cookie.js");
//$bender->enqueue("jscript/jquery/plugins/read-more/jquery.expandable.js");
$bender->enqueue("jscript/jquery/plugins/lazyload/lazyload.min.js");
//$bender->enqueue("jscript/jquery/plugins/slick/slick.js");
$bender->enqueue("jscript/jquery/plugins/owl/owl.carousel.min.js");
//$bender->enqueue("jscript/jquery/plugins/tiny-slider/tiny-slider.js");
//$bender->enqueue("jscript/jquery/plugins/select2/select2.js");
//$bender->enqueue("jscript/jquery/plugins/select2/i18n/" . $_SESSION['language_code'] . ".js");
$bender->enqueue("jscript/jquery/plugins/scrollup/jquery.scrollup.min.js");
//$bender->enqueue("jscript/jquery/plugins/zoom/jquery.zoom.js");
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
<?php
if ( strstr($PHP_SELF, FILENAME_ADDRESS_BOOK)
	or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT)
	or strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT_ADDRESS)
	or strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING_ADDRESS)
	or strstr($PHP_SELF, FILENAME_CREATE_ACCOUNT) ) {
?>
<?php
if (DADATA_API_KEY != "" and $_SESSION['language'] == "russian") {
?>
<!--[if lt IE 10]>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>
<![endif]-->
<script src="https://cdn.jsdelivr.net/jquery.suggestions/16.5.2/js/jquery.suggestions.min.js"></script>
<script>
$(function () {

var token = "<?php echo DADATA_API_KEY; ?>";

$("#firstname").suggestions({
  serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
  partner: "VAMSHOP",
  token: token,
  scrollOnFocus: false,
  type: "NAME",
  params: {
    parts: ["NAME"]
  }
});

$("#lastname").suggestions({
  serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
  partner: "VAMSHOP",
  token: token,
  scrollOnFocus: false,
  type: "NAME",
  params: {
    parts: ["SURNAME"]
  }
});

$("#email_address").suggestions({
  serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
  partner: "VAMSHOP",
  token: token,
  scrollOnFocus: false,
  type: "EMAIL",
  params: {
    parts: ["SURNAME"]
  }
});
      
$("#street_address").suggestions({
  serviceUrl: "https://suggestions.dadata.ru/suggestions/api/4_1/rs",
  partner: "VAMSHOP",
  token: token,
  scrollOnFocus: false,
  type: "ADDRESS",
  geoLocation: true,
  onSelect: showSelected
});

function join(arr /*, separator */) {
  var separator = arguments.length > 1 ? arguments[1] : " ";
  return arr.filter(function(n){return n}).join(separator);
}

function showSelected(suggestion) {
  var address = suggestion.data;
  $("#postcode").val(address.postal_code);
  if (address.region == "Москва" || address.region == "Санкт-Петербург" || address.region == "Севастополь") {
  $("#state").val(address.region);
  } else {
  $("#state").val(join([
    join([address.region, address.region_type_full], " ")
    //join([address.region, address.region_type], " "),
    //join([address.area_type, address.area], " ")
  ]));
  }
  $("#city").val(join([
    //join([address.city_type, address.city], " "),
    join([address.city], " "),
    join([address.settlement_type, address.settlement], " ")
  ]));
  //$("#street_address").val(
    //join([address.street_type, address.street], " "),
    //join([address.house_type, address.house], " "),
    //join([address.block_type, address.block], " "),
    //join([address.flat_type, address.flat], " ")
  //);
}
  
});
</script>
<?php
}
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
<script src="jscript/jquery/plugins/select2/select2.js"></script>
<?php
if (file_exists(DIR_FS_CATALOG.'jscript/jquery/plugins/select2/i18n/' . $_SESSION['language_code'] . '.js')) {
?>
<script src="jscript/jquery/plugins/select2/i18n/<?php echo $_SESSION['language_code'] . ".js"; ?>"></script>
<?php } ?>

<script type="text/javascript">
function initialise(){
<?php if (MODULE_SHIPPING_SDEKPVZ_STATUS == 'True') { ?>
	  $("select#pvz_sdek").select2({
            theme: "bootstrap",
            language: "<?php echo $_SESSION['language_code']; ?>"
     });     
<?php } ?>
<?php if (MODULE_SHIPPING_NEWPOST_STATUS == 'True') { ?>
	  $("select#pvz_newpost").select2({
            theme: "bootstrap",
            language: "<?php echo $_SESSION['language_code']; ?>"
     });     
<?php } ?>
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
<script src="jscript/jquery/plugins/zoom/jquery.zoom.js"></script>
<script>
// Product Images Zoom

$(document).ready(function(){
$(".image-zoom").each(function(arg, el){
    var image = $(el).find("img");
    //$(el).wrap('<span style="display:inline-block"></span>')
    $(el).wrap('<span></span>')
    $(el).css('display', 'block')
    $(el).parent()    
    $(el).zoom({
        on: 'mouseover',
        url: image.attr("src").replace("info_images", "popup_images")
    });
});
});
</script>
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
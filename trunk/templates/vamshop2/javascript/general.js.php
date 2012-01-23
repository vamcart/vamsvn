<?php
/* -----------------------------------------------------------------------------------------
   $Id: general.js 899 2007-02-06 20:14:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2004 xt:Commerce (general.js,v 1.1 2004/03/17); xt-commerce.com 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


   // this javascriptfile get includes at every template page in shop, you can add your template specific
   // js scripts here
?>
<?php
if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO) && AJAX_CART == 'true') {
?>
<script type="text/javascript">
(function($) {$(document).ready(function(){

	var cartbox = $('#divShoppingCart'), addtocart = $('#add_to_cart'), prodimag = $('#img'), prodimag_idle = true;
	if (addtocart.length > 0 && prodimag.length > 0) {
		addtocart.click(function() {
			if (!prodimag_idle) { return false; }
			prodimag_idle = false;
			var p = prodimag.offset();
			$('body').append('<img src="'+prodimag.attr('src')+'" style="left:'+p.left+'px;top:'+p.top+'px;" id="flyimgcart" />');
			p = cartbox.find('.boxcontent').offset();
			p.left += 94;
			p.top += Math.round(cartbox.find('.boxcontent').outerHeight()/2);
			$('body > #flyimgcart:first').animate(
				{'width':'0px','opacity':'0','left':p.left+'px','top':p.top+'px'}, 
				1000, 
				function() {
					$(this).remove();
					prodimag_idle = true;
				});
		});
	}
		
});})($)
</script>
<?php
}
?>
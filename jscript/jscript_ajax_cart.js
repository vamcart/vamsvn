/* -----------------------------------------------------------------------------------------
   $Id: jscript_ajax_cart.js 899 2007-06-30 20:14:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 Andrew Weretennikoff (ajax_sc.js,v 1.1 2007/03/17); medreces@yandex.ru 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function doBuyNow( id, quantity ) {

jQuery.noConflict();

// prepare the form when the DOM is ready
jQuery(document).ready(function() {

  // Setup the ajax indicator
  jQuery('body').append('<div id="ajaxLoading"><img src="images/loading.gif"></div>');


  jQuery('#ajaxLoading').css({
    display:"none",
    margin:"0px auto",
    paddingLeft:"0px",
    paddingRight:"0px",
    paddingTop:"0px",
    paddingBottom:"0px",
    position:"absolute",
    right:"50%",
    top:"50%",
    width:"30px"
  });

});

// Ajax activity indicator bound to ajax start/success/stop document events
jQuery(document).ajaxSend(function(){
  jQuery('#ajaxLoading').show();
});

jQuery(document).ajaxSuccess(function(){
  jQuery('#ajaxLoading').hide();
});

jQuery(document).ajaxStop(function(){
  jQuery('#ajaxLoading').remove();
});

      jQuery.ajax({
                     url: "index_ajax.php",             
                     dataType : "html",                       
                     data: "q=includes/modules/ajax/ajaxCart.php&products_qty=1&action=add_product&products_id="+id,
                     type: "GET",   
    	               success: function(msg){ 
    	               
    	               jQuery("#divShoppingCart").html(msg);
    	               
    	               }       

                   });                     
                       
                           

}

function doAddProduct() {
		jQuery.noConflict();
		var forma = jQuery('#cart_quantity input,select');
		var data = 'q=includes/modules/ajax/ajaxCart.php&';
		forma.each(function(n,element){
			if (element.type == "radio" || element.type == "checkbox") {
				if (element.checked)
					tmp = element.name + "=" + element.value + "&";
			} else {
				tmp = element.name + "=" + element.value + "&";
			}
			if (tmp.length > 3) data = data + tmp;
		});
		data = data + "action=add_product";
		
		jQuery.ajax({
					url : "index_ajax.php",
					dataType : "html",
					data : data,
					type : "GET",
					success : function(msg) {
						jQuery("#divShoppingCart").html(msg);
					}
		});
	}

function doDelProduct() {
		jQuery.noConflict();
		var forma = jQuery('#update_cart input,select');
		var data = 'q=includes/modules/ajax/ajaxCart.php&';
		forma.each(function(n,element){
			if (element.type == "radio" || element.type == "checkbox") {
				if (element.checked)
					tmp = element.name + "=" + element.value + "&";
			} else {
				tmp = element.name + "=" + element.value + "&";
			}
			if (tmp.length > 3) data = data + tmp;
		});
		data = data + "action=update_product";
		
		jQuery.ajax({
					url : "index_ajax.php",
					dataType : "html",
					data : data,
					type : "GET",
					success : function(msg) {
						jQuery("#divShoppingCart").html(msg);
					}
		});
	}
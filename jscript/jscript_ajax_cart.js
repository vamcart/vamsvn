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

  // Setup the ajax indicator
 jQuery('body').append('<div id="ajaxLoading"><img src="images/loading.gif"></div>');

jQuery(document).click(function(e) {

jQuery('#ajaxLoading').css('top', function() {
  return e.pageY-30+"px";
});      

jQuery('#ajaxLoading').css('left', function() {
  return e.pageX-10+"px";
});      

  jQuery('#ajaxLoading').css({
    margin:"0px auto",
    paddingLeft:"0px",
    paddingRight:"0px",
    paddingTop:"0px",
    paddingBottom:"0px",
    position:"absolute",
    width:"30px"
  });

      
})

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
                     data: {q : 'includes/modules/ajax/ajaxCart.php', action : 'cust_order', products_qty : 1, pid : id},
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

function doDelProduct(id) {
		jQuery.noConflict();
		var test1 = "#update_cart"+id+" input";
		var forma = jQuery(test1);
		
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
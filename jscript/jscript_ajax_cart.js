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

      jQuery.ajax({
                     url: "index_ajax.php",             
                     dataType : "html",                       
                     data: "q=includes/modules/ajax/ajaxCart.php&products_qty=1&action=add_product&products_id="+id,
                     type: "GET",   
    	               success: function(msg){ jQuery("#divShoppingCart").html(msg);}       

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
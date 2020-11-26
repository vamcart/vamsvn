/* -----------------------------------------------------------------------------------------
   $Id: jscript_ajax_cart.js 899 2007-06-30 20:14:56 VaM $   

   VamShop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 Andrew Weretennikoff (ajax_sc.js,v 1.1 2007/03/17); medreces@yandex.ru 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function doBuyNow( id, quantity, update, get_cart, attributes, popup ) {

		if ($(location).attr('pathname') == '/shopping_cart.php') {
			get_cart = 1;
		} 
		
      $.ajax({
			url: "index_ajax.php",             
			dataType : "html",                       
			data: {q : 'includes/modules/ajax/ajaxCart.php', action : 'cust_order', products_qty : quantity, pid : id, get_cart : get_cart, update : update, attributes : attributes},
			type: "GET",
			success: function(msg){
			if ($(location).attr('pathname') == '/shopping_cart.php') {
				$("#ajax_cart").empty().html(msg);
			} else {
		      $("#divShoppingCartHeader").html(msg);
		      $("#divShoppingCart").html(msg);
			}

			$(".cart-link-"+parseInt(id)).addClass('active');
			$(".cart-icon-"+parseInt(id)).replaceWith('<i class="text-danger fas fa-cart-plus cart-icon-'+parseInt(id)+'""></i>');
			$('[data-toggle="tooltip"]').tooltip('hide');
	 
			}   
			});
			img_loader();                     
}

function doAddProduct(id) {

		var forma = $('#cart_quantity' + id + ' :input');
		var data = 'q=includes/modules/ajax/ajaxCart.php&';
		var tmp = false;

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
        if ($("div").is("#ajax_cart")) data = data + "&get_cart=1"; 		
		$.ajax({
					url : "index_ajax.php",
					dataType : "html",
					data : data,
					type : "GET",
					success : function(msg) {
					 $("#divShoppingCartHeader").html(msg);
					 $("#divShoppingCart").html(msg);
					 if ($("div").is("#ajax_cart")) {
					   $("#ajax_cart").empty().html(msg);
					 }
					 
					 
			$(".cart-link-"+parseInt(id)).addClass('active');
			$(".cart-icon-"+parseInt(id)).replaceWith('<i class="text-danger fas fa-cart-plus cart-icon-'+parseInt(id)+'""></i>');
			$('[data-toggle="tooltip"]').tooltip('hide');

    	               }
		});
      img_loader();
	}

function doDelProduct(id, prod_id) {
	
		var data = 'q=includes/modules/ajax/ajaxCart.php&';
		if (id) {
			var test1 = "#update_cart"+id+" input";
			var forma = $(test1);
			forma.each(function(n,element){
				if (element.type == "radio" || element.type == "checkbox") {
					if (element.checked)
						tmp = element.name + "=" + element.value + "&";
				} else {
					tmp = element.name + "=" + element.value + "&";
				}
				if (tmp.length > 3) data = data + tmp;
			});
		} else {
			data = data + 'cart_quantity[]=&products_id[]='+prod_id+'&old_qty[]=&cart_delete[]='+prod_id+'&';
		}
		data = data + "action=update_product";
		if ($("div").is("#ajax_cart")) data = data + "&get_cart=1";
		$.ajax({
					url : "index_ajax.php",
					dataType : "html",
					data : data,
					type : "GET",
					success : function(msg) {
					 $("#divShoppingCartHeader").html(msg);
					 $("#divShoppingCart").html(msg);
					 if ($("div").is("#ajax_cart")) {
					   $("#ajax_cart").empty().html(msg);
					 }
					 if (data.total=="0")
  {
  } else {    	             
					 $("#divShoppingCartHeader").html(msg);
					 $("#divShoppingCart").html(msg);
	
    	              }
    	              
				//if (data.qty!="0" && $(location).attr('pathname') != '/shopping_cart.php')
				if ($(location).attr('pathname') != '/shopping_cart.php')
				{

            }					
					
					}
		});
		img_loader();
	}

$(document).ready(function(){

	$('body').on('click', '.cart_delete', function(){
       doDelProduct('',$(this).val());
       img_loader();
       
		$(".cart-link-"+parseInt($(this).val())).removeClass('active');
		$(".cart-icon-"+parseInt($(this).val())).replaceWith('<i class="fas fa-shopping-cart cart-icon-'+parseInt($(this).val())+'""></i>');
		$('[data-toggle="tooltip"]').tooltip('hide');					 
       
   });

   $('body').on('click', '.cart_change', function(){
       field = $(this).parent().parent().find('input[type=text]');
       id = $(this).parent().parent().find('input.ajax_qty').val();
       perem = $(this).parent().parent().find('input.ajax_qty').val();

       //console.log(id);

       attributes = [];
       
       $("form#cart_quantity input[name^='id["+id+"']").each(function(){
           attributes.push($(this).attr("name")+":"+$(this).val()+"");
       });
       
       //console.log(attributes);
       
       //jQuery.each(attributes, function( index, value ) {
           //console.log( "index", index, "value", value );
       //});

       qty = field.val();
       field.val(parseInt(qty)+parseInt($(this).val()));
       doBuyNow(id,$(this).val(),'',1,attributes,0);
       img_loader();
   });

   $('body').on('change', 'form#cart_quantity .item-quantity', function(){
       field = $(this).val();
       id = $(this).parent().find('input.ajax_qty').val();
       perem = $(this).parent().find('input.ajax_qty').val();

       //console.log(id);

       attributes = [];
       
       $("form#cart_quantity input[name^='id["+id+"']").each(function(){
           attributes.push($(this).attr("name")+":"+$(this).val()+"");
       });
       
       //console.log(attributes);
       
       //jQuery.each(attributes, function( index, value ) {
           //console.log( "index", index, "value", value );
       //});
       
       //console.log($("input[name^='old_qty[]'").val());
       
       doBuyNow(id,$(this).val(),'1',1,attributes,0);
       img_loader();
   });
   
   //$('body').on('focusout', '.input-small', function(){
       //id = $(this).parent().find('input.ajax_qty').val();
       //qty = $(this).val();
       //doBuyNow(id,$(this).val(),true);
   //});

});

function img_loader(){

// Setup the ajax indicator
$('body').append('<div class="ajax-preloader"><span class="ajax-preloader__icon ajax-preloader__icon__in-btn"></span></div>');

// Ajax activity indicator bound to ajax start/success/stop document events
$(document).ajaxSend(function(){
  $('.ajax-preloader').show();
});

$(document).ajaxSuccess(function(){
  $('.ajax-preloader').hide();
});

$(document).ajaxStop(function(){
  $('.ajax-preloader').remove();
});

}
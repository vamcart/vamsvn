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

function doBuyNow( id, quantity, update, get_cart, attributes ) {

      $.ajax({
                     url: "index_ajax.php",             
                     dataType : "html",                       
                     data: {q : 'includes/modules/ajax/ajaxCart.php', action : 'cust_order', products_qty : quantity, pid : id, get_cart : get_cart, update : update, attributes : attributes},
                     type: "GET",
    	               success: function(msg){
					      $("#divShoppingCart").html(msg);
                     if ($("div").is("#ajax_cart")) {
					      $("#ajax_cart").empty().html(msg);
					 }

				//if (data.qty!="0" && $(location).attr('pathname') != '/shopping_cart.php')
				if ($(location).attr('pathname') != '/shopping_cart.php')
				{
					cartPopupOn();
				}
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
					 $("#divShoppingCart").html(msg);
					 if ($("div").is("#ajax_cart")) {
					   $("#ajax_cart").empty().html(msg);
					 }


				//if (data.qty!="0" && $(location).attr('pathname') != '/shopping_cart.php')
				if ($(location).attr('pathname') != '/shopping_cart.php')
				{
					cartPopupOn();
				}

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
			data = data + 'cart_quantity[]=&products_id[]='+prod_id+'&old_qty[]=1&cart_delete[]='+prod_id+'&';
		}
		data = data + "action=update_product";
		if ($("div").is("#ajax_cart")) data = data + "&get_cart=1";
		$.ajax({
					url : "index_ajax.php",
					dataType : "html",
					data : data,
					type : "GET",
					success : function(msg) {
					 $("#divShoppingCart").html(msg);
					 if ($("div").is("#ajax_cart")) {
					   $("#ajax_cart").empty().html(msg);
					 }
					 if (data.total=="0")
  {
  } else {    	             
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
       doBuyNow(id,$(this).val(),'',1,attributes);
       img_loader();
   });

   //$('body').on('focusout', '.input-small', function(){
       //id = $(this).parent().find('input.ajax_qty').val();
       //qty = $(this).val();
       //doBuyNow(id,$(this).val(),true);
   //});

});

function cartPopupOn(){ 
$('body').append('<div id="load_status_bg"></div><div class="cart_popup"><div class="cart_popuptext">Товар добавлен в корзину!</div><div class="cart_popuplink"><a href="checkout.php" class="button"><span><img src="/images/icons/buttons/buy.png" alt="" title="" width="12" height="12" />&nbsp;Оформить заказ</span></a><br /><br /><a href="javascript:cartPopupOff()" class="button"><span><img src="/images/icons/buttons/back.png" alt="" title="" width="12" height="12" />&nbsp;Продолжить покупки</span></a></div></div>'); 
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

function img_loader(){

// Setup the ajax indicator
$('body').append('<div id="load_status_bg"><div class="load_status_image"></div></div>');

// Ajax activity indicator bound to ajax start/success/stop document events
$(document).ajaxSend(function(){
  $('#load_status_bg').show();
});

$(document).ajaxSuccess(function(){
  $('#load_status_bg').hide();
});

$(document).ajaxStop(function(){
  $('#load_status_bg').remove();
});

}
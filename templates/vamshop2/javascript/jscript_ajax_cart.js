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

  // Setup the ajax indicator
 $('body').append('<div id="ajaxLoading"><img src="images/loading.gif"></div>');

$(document).click(function(e) {

$('#ajaxLoading').css('top', function() {
  return e.pageY-30+"px";
});      

$('#ajaxLoading').css('left', function() {
  return e.pageX-10+"px";
});      

  $('#ajaxLoading').css({
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
$(document).ajaxSend(function(){
  $('#ajaxLoading').show();
});

$(document).ajaxSuccess(function(){
  $('#ajaxLoading').hide();
});

$(document).ajaxStop(function(){
  $('#ajaxLoading').remove();
});

      $.ajax({
                     url: "index_ajax.php",             
                     dataType : "html",                       
                     data: {q : 'includes/modules/ajax/ajaxCart.php', action : 'cust_order', products_qty : 1, pid : id},
                     type: "GET",   
    	               success: function(msg){ 
    	               $("#divShoppingCart").html(msg);
    	               //$('html, body').animate({ scrollTop: 0 }, 'slow');	
    	               //$(".shopping-cart-widget").addClass( "ajax-cart-hightlight" );
      //$("#navigation .btn.btn-navbar").click();
      //$("#navigation .btn.btn-navbar").focus();    	               
      //$("#navigation .dropdown-toggle.cart").dropdown("toggle");
    	               }       
                   });                     

}

function doAddProduct() {
		
		var forma = $('#cart_quantity input,select,textarea');
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
		
		$.ajax({
					url : "index_ajax.php",
					dataType : "html",
					data : data,
					type : "GET",
					success : function(msg) {
						$("#divShoppingCart").html(msg);
						//$('html, body').animate({ scrollTop: 0 }, 'slow');	
						//$(".shopping-cart-widget").addClass( "ajax-cart-hightlight" );
      //$("#navigation .btn.btn-navbar").click();
      //$("#navigation .btn.btn-navbar").focus();						
      //$("#navigation .dropdown-toggle.cart").dropdown("toggle");
					}
		});
	}

function doDelProduct(id) {
		var test1 = "#update_cart"+id+" input";
		var forma = $(test1);
		
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
		
		$.ajax({
					url : "index_ajax.php",
					dataType : "html",
					data : data,
					type : "GET",
					success : function(msg) {
						$("#divShoppingCart").html(msg);
						$(".shopping-cart-widget").html(msg);
					}
		});
	}
/* -----------------------------------------------------------------------------------------
   $Id: jscript_ajax_wishlist.js 899 2007-06-30 20:14:56 VaM $   

   VamShop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 Andrew Weretennikoff (ajax_sc.js,v 1.1 2007/03/17); medreces@yandex.ru 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

function doWishlistNow( id, quantity, update, get_wishlist, attributes, popup ) {

		if ($(location).attr('pathname') == '/wishlist.php') {
			get_wishlist = 1;
		} 
		
      $.ajax({
			url: "index_ajax.php",             
			dataType : "html",                       
			data: {q : 'includes/modules/ajax/ajaxWishlist.php', action : 'cust_wishlist', products_qty : quantity, pid : id, get_wishlist : get_wishlist, update : update, attributes : attributes},
			type: "GET",
			success: function(msg){
			if ($(location).attr('pathname') == '/wishlist.php') {
				$("#ajax_wishlist").empty().html(msg);
			} else {
		      $("#divWishlistHeader").html(msg);
		      $("#divWishlist").html(msg);
			}
	 
			$(".wishlist-icon-"+id).replaceWith('<i class="text-danger fas fa-heart wishlist-icon-'+id+'"></i>');
			$('[data-toggle="tooltip"]').tooltip('hide');

		
			}   
			});
			img_loader();                     
}

function doAddWishlist(id) {

		var forma = $('#wishlist_quantity' + id + ' :input');
		var data = 'q=includes/modules/ajax/ajaxWishlist.php&';
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
		data = data + "action=add_wishlist";
        if ($("div").is("#ajax_wishlist")) data = data + "&get_wishlist=1"; 		
		$.ajax({
					url : "index_ajax.php",
					dataType : "html",
					data : data,
					type : "GET",
					success : function(msg) {
					 $("#divWishlistHeader").html(msg);
					 $("#divWishlist").html(msg);
					 if ($("div").is("#ajax_wishlist")) {
					   $("#ajax_wishlist").empty().html(msg);
					 }


			$(".wishlist-icon-"+parseInt(id)).replaceWith('<i class="fas fa-heart wishlist-icon-'+parseInt(id)+'""></i>');
			$('[data-toggle="tooltip"]').tooltip('hide');

    	               }
		});
      img_loader();
	}

function doDelWishlist(id, prod_id) {


	
		var data = 'q=includes/modules/ajax/ajaxWishlist.php&';
		if (id) {
			var test1 = "#update_wishlist"+parseInt(id)+" input";
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
			data = data + 'wishlist_quantity[]=&products_id[]='+prod_id+'&old_qty[]=&wishlist_delete[]='+prod_id+'&';
		}
		data = data + "action=update_wishlist";
		if ($("div").is("#ajax_wishlist")) data = data + "&get_wishlist=1";
		$.ajax({
					url : "index_ajax.php",
					dataType : "html",
					data : data,
					type : "GET",
					success : function(msg) {
					 $("#divWishlistHeader").html(msg);
					 $("#divWishlist").html(msg);
					 if ($("div").is("#ajax_wishlist")) {
					   $("#ajax_wishlist").empty().html(msg);
					 }
					 if (data.total=="0")
  {
  } else {    	             
					 $("#divWishlistHeader").html(msg);
					 $("#divWishlist").html(msg);
	
    	              }
    	              
				//if (data.qty!="0" && $(location).attr('pathname') != '/wishlist.php')
				if ($(location).attr('pathname') != '/wishlist.php')
				{

            }					
					
					}
		});
		img_loader();
	}

$(document).ready(function(){

	$('body').on('click', '.wishlist_delete', function(){
       doDelWishlist('',$(this).val());
       img_loader();
       
		$(".wishlist-icon-"+parseInt($(this).val())).replaceWith('<i class="far fa-heart wishlist-icon-'+parseInt($(this).val())+'""></i>');
		$('[data-toggle="tooltip"]').tooltip('hide');					 
					       
   });

   $('body').on('click', '.wishlist_change', function(){
       field = $(this).parent().parent().find('input[type=text]');
       id = $(this).parent().parent().find('input.ajax_qty').val();
       perem = $(this).parent().parent().find('input.ajax_qty').val();

       //console.log(id);

       attributes = [];
       
       $("form#wishlist_quantity input[name^='id["+id+"']").each(function(){
           attributes.push($(this).attr("name")+":"+$(this).val()+"");
       });
       
       //console.log(attributes);
       
       //jQuery.each(attributes, function( index, value ) {
           //console.log( "index", index, "value", value );
       //});

       qty = field.val();
       field.val(parseInt(qty)+parseInt($(this).val()));
       doWishlistNow(id,$(this).val(),'',1,attributes,0);
       img_loader();
   });

   $('body').on('change', 'form#wishlist_quantity .item-quantity', function(){
       field = $(this).val();
       id = $(this).parent().find('input.ajax_qty').val();
       perem = $(this).parent().find('input.ajax_qty').val();

       //console.log(id);

       attributes = [];
       
       $("form#wishlist_quantity input[name^='id["+id+"']").each(function(){
           attributes.push($(this).attr("name")+":"+$(this).val()+"");
       });
       
       //console.log(attributes);
       
       //jQuery.each(attributes, function( index, value ) {
           //console.log( "index", index, "value", value );
       //});
       
       //console.log($("input[name^='old_qty[]'").val());
       
       doWishlistNow(id,$(this).val(),'1',1,attributes,0);
       img_loader();
   });
   
   //$('body').on('focusout', '.input-small', function(){
       //id = $(this).parent().find('input.ajax_qty').val();
       //qty = $(this).val();
       //doWishlistNow(id,$(this).val(),true);
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
<?php
/* -----------------------------------------------------------------------------------------
   $Id: checkout.js.php 1296 2007-02-06 20:14:56 VaM $   

   VamShop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2012 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(form_check.js.php,v 1.9 2003/05/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (form_check.js.php,v 1.3 2003/08/13); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (form_check.js.php,v 1.3 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/


?>
<script type="text/javascript">
    function set_first_shipping()	{
        if(!$('input[name=shipping]:checked').length){
        $('input[name=shipping]:first').prop('checked','checked').change();
        }
    }
</script>
<?php
// if the customer is logged on - show this javascript
if (vam_session_is_registered('customer_id')) { ?>
<script>
$(document).ready(function() {
$(init);
set_first_shipping();
function init()
	{

	function point(){
		var adrr = $('#to_pickpoint_address').val();
		var vall = $('#to_pickpoint_id').val();
		$('#pickpoint_address_text').html(adrr);
		$('#shipping_options').find('#pickpoint_id').remove();
		$('#shipping_options').find('#pickpoint_address').remove();
		$('#pickpoint_address_text').before('<input type="hidden" name="pickpoint_id" id="pickpoint_id" value="'+vall+'">');
		$('#pickpoint_address_text').before('<input type="hidden" name="pickpoint_address" id="pickpoint_address" value="'+adrr+'">');
	}

	function boxberry(){
		var adrr = $('#to_boxberry_address').val();
		var vall = $('#to_boxberry_id').val();
		$('#boxberry_address_text').html(adrr);
		$('#shipping_options').find('#boxberry_id').remove();
		$('#shipping_options').find('#boxberry_address').remove();
		$('#boxberry_address_text').before('<input type="hidden" name="boxberry_id" id="boxberry_id" value="'+vall+'">');
		$('#boxberry_address_text').before('<input type="hidden" name="boxberry_address" id="boxberry_address" value="'+adrr+'">');
	}
	
var url='checkout.php';          


function img_loader(){

// Setup the ajax indicator
$('body').append('<div class="ajax-preloader"><span class="ajax-preloader__icon ajax-preloader__icon__in-btn"></span></div>');

// Ajax activity indicator bound to ajax start/success/stop document events
$(document).ajaxSend(function(){
  $('.ajax-preloader').show();
});

$(document).ajaxSuccess(function(){
  //$('.ajax-preloader').hide();
});

$(document).ajaxStop(function(){
  $('.ajax-preloader').hide();
  $('.ajax-preloader').remove();
});

}
	
$('#box')

.on('refresh', '#shipping_modules_box', 
	function(){
		$('#order_total_modules').load(
			url +' #order_total_modules > *', {
				'shipping': $('input[name=shipping]:checked').val(),
				'payment': $('input[name=payment]:checked').val(),
				'pvz_boxberry': $('select[name=pvz_boxberry]').val(), 
				'pvz_grastin': $('select[name=pvz_grastin]').val(), 
				'pvz_sdek': $('select[name=pvz_sdek]').val(), 
				'pvz_newpost': $('select[name=pvz_newpost]').val() 
			}
		)
	}
)	

.on('refresh', '#shipping_modules_box', 
	function(){
		$('#payment_options').load(
			url +' #payment_options > *', {
				'shipping': $('input[name=shipping]:checked').val(),
				'pvz_boxberry': $('select[name=pvz_boxberry]').val(), 
				'pvz_grastin': $('select[name=pvz_grastin]').val(), 
				'pvz_sdek': $('select[name=pvz_sdek]').val(), 
				'pvz_newpost': $('select[name=pvz_newpost]').val() 
			}
		)
	}
)		

.on('change', 'input[name=shipping],input[name=payment],select[name=pvz_boxberry],select[name=pvz_grastin],select[name=pvz_sdek],select[name=pvz_newpost]', 
	function(){
		$('#shipping_options').load(
			url +' #shipping_options > *', {
				'shipping': $('input[name=shipping]:checked').val(),
				'payment': $('input[name=payment]:checked').val(),
				'pvz_boxberry': $('select[name=pvz_boxberry]').val(), 
				'pvz_grastin': $('select[name=pvz_grastin]').val(), 
				'pvz_sdek': $('select[name=pvz_sdek]').val(), 
				'pvz_newpost': $('select[name=pvz_newpost]').val(), 
			}, 
			function(){
				$('#shipping_modules_box').trigger('refresh');
			}
		)
		img_loader();
	}
)

;}

});

</script>  
   
<?php } else { //not logged in javascript ?>

<script>
$(document).ready(function() {
$(hidePay);		
	function hidePay()	{
	if ($("#pay_show").is(":checked") == '1')
		{
	$("#pay_show").attr('checked', true);
	$("#payment_address").css("display","none");
	}
	else
	{
	$("#pay_show").attr('checked', false);
	}
	

	$("#pay_show").click(function(){
// If checked
        if ($("#pay_show").is(":checked"))
		{
            //show the hidden div
            $("#payment_address").hide("fast");
        }
		else
		{
		$("#payment_address").show("fast");
		}
	});
	;}

$(init);
set_first_shipping();
function init()
	{

	function point(){
		var adrr = $('#to_pickpoint_address').val();
		var vall = $('#to_pickpoint_id').val();
		$('#pickpoint_address_text').html(adrr);
		$('#shipping_options').find('#pickpoint_id').remove();
		$('#shipping_options').find('#pickpoint_address').remove();
		$('#pickpoint_address_text').before('<input type="hidden" name="pickpoint_id" id="pickpoint_id" value="'+vall+'">');
		$('#pickpoint_address_text').before('<input type="hidden" name="pickpoint_address" id="pickpoint_address" value="'+adrr+'">');
	}

	function boxberry(){
		var adrr = $('#to_boxberry_address').val();
		var vall = $('#to_boxberry_id').val();
		$('#boxberry_address_text').html(adrr);
		$('#shipping_options').find('#boxberry_id').remove();
		$('#shipping_options').find('#boxberry_address').remove();
		$('#boxberry_address_text').before('<input type="hidden" name="boxberry_id" id="boxberry_id" value="'+vall+'">');
		$('#boxberry_address_text').before('<input type="hidden" name="boxberry_address" id="boxberry_address" value="'+adrr+'">');
	}
	
var url='checkout.php';          


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


$('#box')
.on('refresh', '#shipping_modules_box', 
	function(){
	$('#shipping_options').load(
		url +' #shipping_options > *', {
			'country': $('select[name=country]').val(),
			'state': $('select[name=state]').val(),
			'postcode': $('input[name=postcode]').val(),
			'telephone': $('input[name=telephone]').val(),
			'city': $('input[name=city]').val(),
			'pvz_boxberry': $('select[name=pvz_boxberry]').val(), 
			'pvz_grastin': $('select[name=pvz_grastin]').val(), 
			'pvz_sdek': $('select[name=pvz_sdek]').val(), 
			'pvz_newpost': $('select[name=pvz_newpost]').val(), 
		}
	),
	point();
	boxberry();
	}
)

.on('refresh', '#shipping_modules_box', 
	function(){
		$('#payment_options').load(
			url +' #payment_options > *', {
				'country': $('select[name=country]').val(),
				'state': $('select[name=state]').val(),
				'postcode': $('input[name=postcode]').val(),
				'telephone': $('input[name=telephone]').val(),
				'city': $('input[name=city]').val(),
				'pvz_boxberry': $('select[name=pvz_boxberry]').val(), 
				'pvz_grastin': $('select[name=pvz_grastin]').val(), 
				'pvz_sdek': $('select[name=pvz_sdek]').val(), 
				'pvz_newpost': $('select[name=pvz_newpost]').val() 
			}
		),
	point();
	boxberry();
	}
)

.on('refresh', '#shipping_modules_box', 
	function(){
		$('#order_total_modules').load(
			url +' #order_total_modules > *', {
				'shipping': $('input[name=shipping]:checked').val(),
				'payment': $('input[name=payment]:checked').val(),
				'pvz_boxberry': $('select[name=pvz_boxberry]').val(), 
				'pvz_sdek': $('select[name=pvz_sdek]').val(), 
				'pvz_newpost': $('select[name=pvz_newpost]').val() 
				}
		),
	point();
	boxberry();
	}
)


//.on('refresh', '#shipping_modules_box', function(('input[name=checkout_possible]').val());})	
//.on$('input[name=checkout_possible]').val()

.on('change', 'input[name=shipping], input[name=payment], select[name=country], select[name=state],select[name=pvz_boxberry],select[name=pvz_grastin],select[name=pvz_sdek],select[name=pvz_newpost],input[name=postcode], input[name=telephone], input[name=city]', 
	function(){
	$('#shipping_country_box').load(
		url +' #shipping_country', {
			'shipping': $('input[name=shipping]:checked').val(), 
			'payment': $('input[name=payment]:checked').val(),
			'country': $('select[name=country]').val(),
			'state': $('select[name=state]').val(),
			'city': $('input[name=city]').val(),
			'pvz_boxberry': $('select[name=pvz_boxberry]').val(), 
			'pvz_grastin': $('select[name=pvz_grastin]').val(), 
			'pvz_sdek': $('select[name=pvz_sdek]').val(), 
			'pvz_newpost': $('select[name=pvz_newpost]').val(), 
			'telephone': $('input[name=telephone]').val(),
			'postcode': $('input[name=postcode]').val()
		}, 
		function(){
			$('#shipping_modules_box').trigger('refresh')
		}
	);
	img_loader();
	point();
	boxberry();
	}
)
//.on('change', 'input[name=shipping], select[name=state]', function(){$('#shipping_state_box').load(url +' #shipping_state', {'shipping': $('input[name=shipping]:checked').val(), 'state': $('select[name=state]').val()}, function(){$('#shipping_state_box').trigger('refresh');});})

.on('change', '#country', function(){

      var searchString = $("select[name=country]").val();
      $.ajax({
                     url: "index_ajax.php",             
                     dataType : "html",                       
                     data: "q=includes/modules/ajax/loadStateXML.php&country_id="+searchString,
                     type: "POST",   
                     success: function(msg){$("#stateXML").html(msg);}            
                   });

point();  
boxberry();                   

})



.on('change', '#country_payment', function(){

      var searchString = $("select[name=country_payment]").val();
      $.ajax({
                     url: "index_ajax.php",             
                     dataType : "html",                       
                     data: "q=includes/modules/ajax/loadStateXMLPayment.php&country_id="+searchString,
                     type: "POST",   
                     success: function(msg){$("#stateXMLPayment").html(msg);}            
                   });  

point();
boxberry();

})

;}
});

</script>

<?php if ((SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true') && (($sc_is_virtual_product != true) || ($sc_is_mixed_product != true))) { ?>  
<script>
$(document).ready(function() {
$(hidePw);		
	function hidePw()	{
	if ($("#pw_show").is(":checked") == '1')
		{
	$("#pw_show").attr('checked', true);
	$("#password_fields").css("display","none");
	}
	else
	{
	$("#pw_show").attr('checked', false);
	}
	

	$("#pw_show").click(function(){
// If checked
        if ($("#pw_show").is(":checked"))
		{
            //show the hidden div
            $("#password_fields").hide("fast");
        }
		else
		{
		$("#password_fields").show("fast");
		}
	});
	;}
});
	
</script>    
<?php 
	} // END password optional
} //END not logged in javascript ?>
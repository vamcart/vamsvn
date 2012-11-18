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
<?php
// if the customer is logged on - show this javascript
if (vam_session_is_registered('customer_id')) { ?>
<script type="text/javascript">

$(init);
function init()
	{

var url='checkout.php';          

	
$('#box')

.on('refresh', '#shipping_modules_box', function(){$('#order_total_modules').load(url +' #order_total_modules > *', {'shipping': $('input[name=shipping]:checked').val()});})	



.on('change', 'input[name=shipping]', function(){$('#shipping_options').load(url +' #shipping_options > *', {'shipping': $('input[name=shipping]:checked').val()}, function(){$('#shipping_modules_box').trigger('refresh');});})

;}
</script>  
   
<?php } else { //not logged in javascript ?>



<script type="text/javascript">

//not yet finished
/*$(hideFirm);		
	function hideFirm()	{
		
		//Hide div w/id extra
	$("#extra").css("display","none");
	$("#checkme1").click(function(){

// If checked
        
        if ($("#checkme1").is(":checked"))
		{
            //show the hidden div
            $("#extra").show("fast");
        }
	});
	

		// Add onclick handler to checkbox w/id checkme
	   $("#checkme").click(function(){

// If checked
        if ($("#checkme").is(":checked"))
        {
            //show the hidden div
            $("#extra").hide("fast");
        }
		        
	});
	
	$("#checkme2").click(function(){

// If checked
        if ($("#checkme2").is(":checked"))
        {
            //show the hidden div
            $("#extra").hide("fast");
        }
		        
	});
;}*/






/*$(document).ready(function(){
window.alert($('input[name=checkout_possible]').val());

//$('#order_total_modules').load(url +' #order_total_modules > *', {'shipping': $('input[name=shipping]:checked').val() });

});*/

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

$(document).ready(function() {
  $("#country").change(function(){
      var searchString = $(this).val();
      $.ajax({
                     url: "index_ajax.php",             
                     dataType : "html",                       
                     data: "q=includes/modules/ajax/loadStateXML.php&country_id="+searchString,
                     type: "POST",   
                     success: function(msg){$("#stateXML").html(msg);}            
                   });                     
                           
                           
   });
});

$(init);
function init()
	{

var url='checkout.php';          

	
$('#box')
.on('refresh', '#shipping_modules_box', function(){$('#shipping_options').load(url +' #shipping_options > *', {'country': $('select[name=country]').val(),'state': $('select[name=state]').val(),'postcode': $('input[name=postcode]').val(),'city': $('input[name=city]').val()});})	
.on('refresh', '#shipping_modules_box', function(){$('#payment_options').load(url +' #payment_options > *', {'country': $('select[name=country]').val(),'state': $('select[name=state]').val(),'postcode': $('input[name=postcode]').val(),'city': $('input[name=city]').val()});})	
.on('refresh', '#shipping_modules_box', function(){$('#order_total_modules').load(url +' #order_total_modules > *', {'shipping': $('input[name=shipping]:checked').val()});})	


//.on('refresh', '#shipping_modules_box', function(('input[name=checkout_possible]').val());})	
//.on$('input[name=checkout_possible]').val()

.on('change', 'input[name=shipping], select[name=country]', function(){$('#shipping_country_box').load(url +' #shipping_country', {'shipping': $('input[name=shipping]:checked').val(), 'country': $('select[name=country]').val(),'state': $('select[name=state]').val(),'city': $('input[name=city]').val(),'postcode': $('input[name=postcode]').val()}, function(){$('#shipping_modules_box').trigger('refresh');});})
//.on('change', 'input[name=shipping], select[name=state]', function(){$('#shipping_state_box').load(url +' #shipping_state', {'shipping': $('input[name=shipping]:checked').val(), 'state': $('select[name=state]').val()}, function(){$('#shipping_state_box').trigger('refresh');});})
;}

</script>

<?php if ((SC_CREATE_ACCOUNT_CHECKOUT_PAGE == 'true') && (($sc_is_virtual_product != true) || ($sc_is_mixed_product != true))) { ?>  
<script type="text/javascript">
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
</script>    
<?php 
	} // END password optional
} //END not logged in javascript ?>
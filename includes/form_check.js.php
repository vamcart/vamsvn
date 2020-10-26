<?php
/* -----------------------------------------------------------------------------------------
   $Id: form_check.js.php 1296 2007-02-06 20:14:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
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

$form_id = '';

if (strstr($PHP_SELF, FILENAME_CREATE_ACCOUNT)) {
$form_id = 'create_account';
}

if (strstr($PHP_SELF, FILENAME_CHECKOUT)) {
$form_id = 'smart_checkout';
}

if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT)) {
$form_id = 'checkout_payment';
}

if (strstr($PHP_SELF, FILENAME_CREATE_GUEST_ACCOUNT )) {
$form_id = 'create_account';
}
if (strstr($PHP_SELF, FILENAME_ACCOUNT_PASSWORD )) {
$form_id = 'account_password';
}
if (strstr($PHP_SELF, FILENAME_ACCOUNT_EDIT )) {
$form_id = 'account_edit';
}
if (strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS )) {
$form_id = 'addressbook';
}
if (strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING_ADDRESS )or strstr($PHP_SELF,FILENAME_CHECKOUT_PAYMENT_ADDRESS)) {
$form_id = 'checkout_address';
}

$prefix = false;
$country_info = vam_get_countries_with_iso_codes(STORE_COUNTRY);
$country_code = strtolower($country_info['countries_iso_code_2']);
if (STORE_COUNTRY == 176) {
$prefix = "+7";
}
if (STORE_COUNTRY == 220) {
$prefix = "+38";
}

?>
<script src="jscript/jquery/plugins/validate/jquery.validate.pack.js"></script>
<script src="jscript/jquery/plugins/cleave/cleave.min.js"></script>
<script src="jscript/jquery/plugins/cleave/addons/cleave-phone.<?php echo $country_code; ?>.js"></script>
<script src="jscript/modified.js"></script>
<script><!--

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

<?php if(PHONE_MASK != '') { ?>
<?php if (!vam_session_is_registered('customer_id')) { 
?>
$(function () {
new Cleave("#telephone", {
  <?php if ($prefix) { ?>prefix: "<?php echo $prefix; ?>", <?php } ?>
  numericOnly: true,
  phone: true,
  phoneRegionCode: "<?php echo $country_code; ?>"
});
});
<?php } ?>
<?php } ?>
   	
	// validate signup form on keyup and submit
	$("#<?php echo $form_id; ?>").validate({
		rules: {
<?php if(ACCOUNT_GENDER == 'true') { ?>
			gender: "required",
<?php } ?>
			firstname: {
				required: true,
				minlength: <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>
			},
<?php if(ACCOUNT_LAST_NAME == 'true') { ?>
			lastname: {
				required: true,
				minlength: <?php echo ENTRY_LAST_NAME_MIN_LENGTH; ?>
			},
<?php } ?>
<?php if(ACCOUNT_DOB == 'true') { ?>
			dob: {
				required: true,
				minlength: <?php echo ENTRY_DOB_MIN_LENGTH; ?>
			},
<?php } ?>
<?php if(ACCOUNT_EMAIL == 'true') { ?>
			email_address: {
				required: true,
				minlength: <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>,
				email: true
			},
<?php } ?>
<?php if(ACCOUNT_STREET_ADDRESS == 'true') { ?>
			street_address: {
				required: true,
				minlength: <?php echo ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>
			},
<?php } ?>
<?php if(ACCOUNT_POSTCODE == 'true') { ?>
			postcode: {
				required: true,
				minlength: <?php echo ENTRY_POSTCODE_MIN_LENGTH; ?>
			},
<?php } ?>
<?php if(ACCOUNT_CITY == 'true') { ?>
			city: {
				required: true,
				minlength: <?php echo ENTRY_CITY_MIN_LENGTH; ?>
			},
<?php } ?>
			//state: {
				//required: true,
				//minlength: <?php echo ENTRY_STATE_MIN_LENGTH; ?>
			//},
			//country: {
				//required: true,
				//minlength: <?php echo ENTRY_STATE_MIN_LENGTH; ?>
			//},
<?php if(ACCOUNT_TELE == 'true') { ?>
			telephone: {
				required: true,
				minlength: <?php echo ENTRY_TELEPHONE_MIN_LENGTH; ?>
			},
<?php } ?>
			password: {
				required: true,
				minlength: <?php echo ENTRY_PASSWORD_MIN_LENGTH; ?>
			},
			confirmation: {
				required: true,
				minlength: <?php echo ENTRY_PASSWORD_MIN_LENGTH; ?>,
				equalTo: "#pass"
			},
		},
		messages: {
<?php if(ACCOUNT_GENDER == 'true') { ?>
			gender: "<?php echo ENTRY_GENDER_ERROR; ?>",
<?php } ?>
			firstname: {
				required: "<?php echo ENTRY_FIRST_NAME_ERROR; ?>",
				minlength: "<?php echo ENTRY_FIRST_NAME_ERROR; ?>"
			},
<?php if(ACCOUNT_LAST_NAME == 'true') { ?>
			lastname: {
				required: "<?php echo ENTRY_LAST_NAME_ERROR; ?>",
				minlength: "<?php echo ENTRY_LAST_NAME_ERROR; ?>"
			},
<?php } ?>
<?php if(ACCOUNT_DOB == 'true') { ?>
			dob: {
				required: "<?php echo ENTRY_DATE_OF_BIRTH_ERROR; ?>",
				minlength: "<?php echo ENTRY_DATE_OF_BIRTH_ERROR; ?>"
			},
<?php } ?>
<?php if(ACCOUNT_EMAIL == 'true') { ?>
			email_address: "<?php echo ENTRY_EMAIL_ADDRESS_ERROR; ?>",
<?php } ?>
<?php if(ACCOUNT_STREET_ADDRESS == 'true') { ?>
			street_address: {
				required: "<?php echo ENTRY_STREET_ADDRESS_ERROR; ?>",
				minlength: "<?php echo ENTRY_STREET_ADDRESS_ERROR; ?>"
			},
<?php } ?>
<?php if(ACCOUNT_POSTCODE == 'true') { ?>
			postcode: {
				required: "<?php echo ENTRY_POST_CODE_ERROR; ?>",
				minlength: "<?php echo ENTRY_POST_CODE_ERROR; ?>"
			},
<?php } ?>
<?php if(ACCOUNT_CITY == 'true') { ?>
			city: {
				required: "<?php echo ENTRY_CITY_ERROR; ?>",
				minlength: "<?php echo ENTRY_CITY_ERROR; ?>"
			},
<?php } ?>
			//state: {
				//required: "<?php echo ENTRY_STATE_ERROR_SELECT; ?>",
				//minlength: "<?php echo ENTRY_STATE_ERROR_SELECT; ?>"
			//},
			//country: {
				//required: "<?php echo ENTRY_COUNTRY_ERROR; ?>",
				//minlength: "<?php echo ENTRY_COUNTRY_ERROR; ?>"
			//},
<?php if(ACCOUNT_TELE == 'true') { ?>
			telephone: {
				required: "<?php echo ENTRY_TELEPHONE_NUMBER_ERROR; ?>",
				minlength: "<?php echo ENTRY_TELEPHONE_NUMBER_ERROR; ?>"
			},
<?php } ?>
			password: {
				required: "<?php echo ENTRY_PASSWORD_ERROR; ?>",
				minlength: "<?php echo ENTRY_PASSWORD_CURRENT_ERROR; ?>"
			},
			confirmation: {
				required: "<?php echo ENTRY_PASSWORD_ERROR_NOT_MATCHING; ?>",
				minlength: "<?php echo ENTRY_PASSWORD_CURRENT_ERROR; ?>",
				equalTo: "<?php echo ENTRY_PASSWORD_ERROR_NOT_MATCHING; ?>"
			}
		}
	});
	
});

//--></script>
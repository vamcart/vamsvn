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

?>
<script src="jscript/jquery/plugins/validate/jquery.validate.pack.js"></script>
<script src="jscript/jquery/plugins/maskedinput/jquery.maskedinput.min.js"></script>
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
$("#telephone").mask("<?php echo PHONE_MASK; ?>");
<?php } ?>
$("#qiwi_telephone").mask("79999999999");
   	
	// validate signup form on keyup and submit
	$("#<?php echo $form_id; ?>").validate({
		rules: {
			gender: "required",
			firstname: {
				required: true,
				minlength: <?php echo ENTRY_FIRST_NAME_MIN_LENGTH; ?>
			},
			lastname: {
				required: true,
				minlength: <?php echo ENTRY_LAST_NAME_MIN_LENGTH; ?>
			},
			dob: {
				required: true,
				minlength: <?php echo ENTRY_DOB_MIN_LENGTH; ?>
			},
			email_address: {
				required: true,
				minlength: <?php echo ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>,
				email: true
			},
			street_address: {
				required: true,
				minlength: <?php echo ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>
			},
			postcode: {
				required: true,
				minlength: <?php echo ENTRY_POSTCODE_MIN_LENGTH; ?>
			},
			city: {
				required: true,
				minlength: <?php echo ENTRY_CITY_MIN_LENGTH; ?>
			},
			//state: {
				//required: true,
				//minlength: <?php echo ENTRY_STATE_MIN_LENGTH; ?>
			//},
			//country: {
				//required: true,
				//minlength: <?php echo ENTRY_STATE_MIN_LENGTH; ?>
			//},
			telephone: {
				required: true,
				minlength: <?php echo ENTRY_TELEPHONE_MIN_LENGTH; ?>
			},
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
			gender: "<?php echo ENTRY_GENDER_ERROR; ?>",
			firstname: {
				required: "<?php echo ENTRY_FIRST_NAME_ERROR; ?>",
				minlength: "<?php echo ENTRY_FIRST_NAME_ERROR; ?>"
			},
			lastname: {
				required: "<?php echo ENTRY_LAST_NAME_ERROR; ?>",
				minlength: "<?php echo ENTRY_LAST_NAME_ERROR; ?>"
			},
			dob: {
				required: "<?php echo ENTRY_DATE_OF_BIRTH_ERROR; ?>",
				minlength: "<?php echo ENTRY_DATE_OF_BIRTH_ERROR; ?>"
			},
			email_address: "<?php echo ENTRY_EMAIL_ADDRESS_ERROR; ?>",
			street_address: {
				required: "<?php echo ENTRY_STREET_ADDRESS_ERROR; ?>",
				minlength: "<?php echo ENTRY_STREET_ADDRESS_ERROR; ?>"
			},
			postcode: {
				required: "<?php echo ENTRY_POST_CODE_ERROR; ?>",
				minlength: "<?php echo ENTRY_POST_CODE_ERROR; ?>"
			},
			city: {
				required: "<?php echo ENTRY_CITY_ERROR; ?>",
				minlength: "<?php echo ENTRY_CITY_ERROR; ?>"
			},
			//state: {
				//required: "<?php echo ENTRY_STATE_ERROR_SELECT; ?>",
				//minlength: "<?php echo ENTRY_STATE_ERROR_SELECT; ?>"
			//},
			//country: {
				//required: "<?php echo ENTRY_COUNTRY_ERROR; ?>",
				//minlength: "<?php echo ENTRY_COUNTRY_ERROR; ?>"
			//},
			telephone: {
				required: "<?php echo ENTRY_TELEPHONE_NUMBER_ERROR; ?>",
				minlength: "<?php echo ENTRY_TELEPHONE_NUMBER_ERROR; ?>"
			},
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
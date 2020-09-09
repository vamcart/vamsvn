<?php
/* -----------------------------------------------------------------------------------------
   $Id: footer.php 1239 2007-10-19 20:14:56 VaM $   

   VamShop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2019 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(application_bottom.php,v 1.14 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (application_bottom.php,v 1.6 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (application_bottom.php,v 1.6 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

?>
<?php
// require theme based javascript
require('templates/'.CURRENT_TEMPLATE.'/javascript/general.js.php');

if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT)) {
 echo $payment_modules->javascript_validation();
}

if (strstr($PHP_SELF, FILENAME_CREATE_ACCOUNT)) {
require(DIR_WS_INCLUDES.'form_check.js.php');
}

if (strstr($PHP_SELF, FILENAME_CHECKOUT)) {
require(DIR_WS_INCLUDES.'form_check.js.php');
require(DIR_WS_INCLUDES.'checkout.js.php');
}

if (strstr($PHP_SELF, FILENAME_CREATE_GUEST_ACCOUNT )) {
require(DIR_WS_INCLUDES.'form_check.js.php');
}
if (strstr($PHP_SELF, FILENAME_ACCOUNT_PASSWORD )) {
require(DIR_WS_INCLUDES.'form_check.js.php');
}
if (strstr($PHP_SELF, FILENAME_ACCOUNT_EDIT )) {
require(DIR_WS_INCLUDES.'form_check.js.php');
}
if (strstr($PHP_SELF, FILENAME_ADDRESS_BOOK_PROCESS )) {
  if (isset($_GET['delete']) == false) {
    include(DIR_WS_INCLUDES.'form_check.js.php');
  }
  }
  if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT)) {
require(DIR_WS_INCLUDES.'form_check.js.php');
}
if (strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING_ADDRESS )or strstr($PHP_SELF,FILENAME_CHECKOUT_PAYMENT_ADDRESS)) {
require(DIR_WS_INCLUDES.'form_check.js.php');
?>
<script><!--
function check_form_optional(form_name) {
  var form = form_name;

  var firstname = form.elements['firstname'].value;
  var lastname = form.elements['lastname'].value;
  var street_address = form.elements['street_address'].value;

  if (firstname == '' && lastname == '' && street_address == '') {
    return true;
  } else {
    return check_form(form_name);
  }
}
//--></script>
<?php
}

if (strstr($PHP_SELF, FILENAME_ADVANCED_SEARCH )) {
?>
<script src="includes/general.js"></script>
<script><!--
function check_form() {
  var error_message = unescape("<?php echo vam_js_lang(JS_ERROR); ?>");
  var error_found = false;
  var error_field;
  var keywords = document.getElementById("advanced_search").keywords.value;
  var pfrom = document.getElementById("advanced_search").pfrom.value;
  var pto = document.getElementById("advanced_search").pto.value;
  var pfrom_float;
  var pto_float;

  if ( (keywords == '' || keywords.length < 1) && (pfrom == '' || pfrom.length < 1) && (pto == '' || pto.length < 1) ) {
    error_message = error_message + unescape("<?php echo vam_js_lang(JS_AT_LEAST_ONE_INPUT); ?>");
    error_field = document.getElementById("advanced_search").keywords;
    error_found = true;
  }

  if (pfrom.length > 0) {
    pfrom_float = parseFloat(pfrom);
    if (isNaN(pfrom_float)) {
      error_message = error_message + unescape("<?php echo vam_js_lang(JS_PRICE_FROM_MUST_BE_NUM); ?>");
      error_field = document.getElementById("advanced_search").pfrom;
      error_found = true;
    }
  } else {
    pfrom_float = 0;
  }

  if (pto.length > 0) {
    pto_float = parseFloat(pto);
    if (isNaN(pto_float)) {
      error_message = error_message + unescape("<?php echo vam_js_lang(JS_PRICE_TO_MUST_BE_NUM); ?>");
      error_field = document.getElementById("advanced_search").pto;
      error_found = true;
    }
  } else {
    pto_float = 0;
  }

  if ( (pfrom.length > 0) && (pto.length > 0) ) {
    if ( (!isNaN(pfrom_float)) && (!isNaN(pto_float)) && (pto_float < pfrom_float) ) {
      error_message = error_message + unescape("<?php echo vam_js_lang(JS_PRICE_TO_LESS_THAN_PRICE_FROM); ?>");
      error_field = document.getElementById("advanced_search").pto;
      error_found = true;
    }
  }

  if (error_found == true) {
    alert(error_message);
    error_field.focus();
    return false;
  }
}

function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=280,screenX=150,screenY=150,top=150,left=150')
}
//--></script>
<?php
}
if (strstr($PHP_SELF, FILENAME_PRODUCT_REVIEWS_WRITE )) {
?>
<script src="jscript/jquery/plugins/validate/jquery.validate.pack.js"></script>
<script src="jscript/modified.js"></script>
<script><!--

$(document).ready(function() {

	// validate form on keyup and submit
	$("#product_reviews_write").validate({

			errorElement: "div",
			errorContainer: $(".error"),
			errorPlacement: function(error, element) {
				error.appendTo(element.parent());
			},

		rules: {
			rating: "required",
			review: {
				required: true,
				minlength: <?php echo REVIEW_TEXT_MIN_LENGTH; ?>
			},
			captcha: {
				required: true
			}
		},
		messages: {
			rating: "<?php echo JS_REVIEW_RATING; ?>",
			review: {
				required: "<?php echo JS_REVIEW_TEXT; ?>",
				minlength: "<?php echo JS_REVIEW_TEXT; ?>"
			},
			captcha: {
				required: "<?php echo JS_REVIEW_CAPTCHA; ?>",
				minlength: "<?php echo JS_REVIEW_CAPTCHA; ?>"
			}
		}
	});
	
});

//--></script>
<?php
}
?>
<?php
if (!strstr($PHP_SELF, FILENAME_CHECKOUT_SUCCESS)) {
require(DIR_WS_INCLUDES.'google_conversiontracking.js.php');
}
?>
</body>
</html>
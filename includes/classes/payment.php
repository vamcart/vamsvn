<?php
/* -----------------------------------------------------------------------------------------
   $Id: payment.php 1136 2007-02-06 20:23:03 VaM $ 

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(payment.php,v 1.36 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (payment.php,v 1.11 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (payment.php,v 1.11 2003/08/17); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  // include needed functions
  require_once(DIR_FS_INC . 'vam_count_payment_modules.inc.php');
  require_once(DIR_FS_INC . 'vam_in_array.inc.php');

  class payment {
    var $modules, $selected_module;

    // class constructor
    function __construct($module = '') {
      global $PHP_SELF,$order;

      if (defined('MODULE_PAYMENT_INSTALLED') && vam_not_null(MODULE_PAYMENT_INSTALLED)) {

        require_once(DIR_WS_FUNCTIONS . 'ship2pay.php');
//      $this->modules = explode(';', MODULE_PAYMENT_INSTALLED);
        $this->modules = ship2pay();
			
        $include_modules = array();

        if ( (vam_not_null($module)) && (in_array($module . '.' . substr($PHP_SELF, (strrpos($PHP_SELF, '.')+1)), $this->modules)) ) {
          $this->selected_module = $module;

          $include_modules[] = array('class' => $module, 'file' => $module . '.php');
        } else {
          reset($this->modules);
          while (list(, $value) = each($this->modules)) {
            $class = substr($value, 0, strrpos($value, '.'));
            $include_modules[] = array('class' => $class, 'file' => $value);
          }
        }
	// load unallowed modules into array
	$unallowed_modules = explode(',', $_SESSION['customers_status']['customers_status_payment_unallowed'].','.$order->customer['payment_unallowed']);
    // add unallowed modules/Download
    if ($order->content_type == 'virtual' || ($order->content_type == 'virtual_weight')) {
     $unallowed_modules = array_merge($unallowed_modules,explode(',',DOWNLOAD_UNALLOWED_PAYMENT));
    }

        //print_r($include_modules);
        for ($i = 0, $n = sizeof($include_modules); $i < $n; $i++) {
          if (!in_array($include_modules[$i]['class'], $unallowed_modules)) {
            // check if zone is alowed to see module
            if (constant(MODULE_PAYMENT_ . strtoupper(str_replace('.php', '', $include_modules[$i]['file'])) . _ALLOWED) != '') {
              $unallowed_zones = explode(',', constant(MODULE_PAYMENT_ . strtoupper(str_replace('.php', '', $include_modules[$i]['file'])) . _ALLOWED));
            } else {
              $unallowed_zones = array();
            }
            if (in_array($_SESSION['delivery_zone'], $unallowed_zones) == true || count($unallowed_zones) == 0) {
              if ($include_modules[$i]['file']!='' && $include_modules[$i]['file']!='no_payment') {

              include(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/payment/' . $include_modules[$i]['file']);
              include(DIR_WS_MODULES . 'payment/' . $include_modules[$i]['file']);

              }
              $GLOBALS[$include_modules[$i]['class']] = new $include_modules[$i]['class'];
            }
          }
        }
        // if there is only one payment method, select it as default because in
        // checkout_confirmation.php the $payment variable is being assigned the
        // $HTTP_POST_VARS['payment'] value which will be empty (no radio button selection possible)
        if ( (vam_count_payment_modules() == 1) && (!is_object($_SESSION['payment'])) ) {
          $_SESSION['payment'] = $include_modules[0]['class'];
        }

        if ( (vam_not_null($module)) && (in_array($module, $this->modules)) && (isset($GLOBALS[$module]->form_action_url)) ) {
          $this->form_action_url = $GLOBALS[$module]->form_action_url;
        }
      }
    }

    // class methods
    /* The following method is needed in the checkout_confirmation.php page
       due to a chicken and egg problem with the payment class and order class.
       The payment modules needs the order destination data for the dynamic status
       feature, and the order class needs the payment module title.
       The following method is a work-around to implementing the method in all
       payment modules available which would break the modules in the contributions
       section. This should be looked into again post 2.2.
     */   
    function update_status() {
      if (is_array($this->modules)) {
        if (is_object($GLOBALS[$this->selected_module])) {
          if (function_exists('method_exists')) {
            if (method_exists($GLOBALS[$this->selected_module], 'update_status')) {
              $GLOBALS[$this->selected_module]->update_status();
            }
          } else { // PHP3 compatibility
            @call_user_func('update_status', $GLOBALS[$this->selected_module]);
          }
        }
      }
    }

    function javascript_validation() {
      $js = '';
      if (is_array($this->modules)) {
        $js = '<script type="text/javascript"><!-- ' . "\n" .
              'function check_form() {' . "\n" .
              '  var error = 0;' . "\n" .
              '  var error_message = unescape("' . vam_js_lang(JS_ERROR) . '");' . "\n" .
              '  var payment_value = null;' . "\n" .
              '  if (document.getElementById("checkout_payment").payment.length) {' . "\n" .
              '    for (var i=0; i<document.getElementById("checkout_payment").payment.length; i++) {' . "\n" .
              '      if (document.getElementById("checkout_payment").payment[i].checked) {' . "\n" .
              '        payment_value = document.getElementById("checkout_payment").payment[i].value;' . "\n" .
              '      }' . "\n" .
              '    }' . "\n" .
              '  } else if (document.getElementById("checkout_payment").payment.checked) {' . "\n" .
              '    payment_value = document.getElementById("checkout_payment").payment.value;' . "\n" .
              '  } else if (document.getElementById("checkout_payment").payment.value) {' . "\n" .
              '    payment_value = document.getElementById("checkout_payment").payment.value;' . "\n" .
              '  }' . "\n\n";

        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          if ($GLOBALS[$class]->enabled) {
            $js .= $GLOBALS[$class]->javascript_validation();
          }
        }
        if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {
        $js .= "\n" . '  if (!document.getElementById("checkout_payment").conditions.checked) {' . "\n" .
               '    error_message = error_message + unescape("' . vam_js_lang(ERROR_CONDITIONS_NOT_ACCEPTED) . '");' . "\n" .
               '    error = 1;' . "\n" .
               '  }' . "\n\n";
        }
        $js .= "\n" . '  if (payment_value == null) {' . "\n" .
               '    error_message = error_message + unescape("' . vam_js_lang(JS_ERROR_NO_PAYMENT_MODULE_SELECTED) . '");' . "\n" .
               '    error = 1;' . "\n" .
               '  }' . "\n\n" .
               '  if (error == 1 && submitter != 1) {' . "\n" . // GV Code Start/End
               '    alert(error_message);' . "\n" .
               '    return false;' . "\n" .
               '  } else {' . "\n" .
               '    return true;' . "\n" .
               '  }' . "\n" .
               '}' . "\n" .
               '//--></script>' . "\n";
      }

      return $js;
    }

    function selection() {
      $selection_array = array();

      if (is_array($this->modules)) {
        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          if ($GLOBALS[$class]->enabled) {
            $selection = $GLOBALS[$class]->selection();
            if (is_array($selection)) $selection_array[] = $selection;
          }
        }
      }

      return $selection_array;
    }

    //GV Code Start
    //ICW CREDIT CLASS Gift Voucher System
    // check credit covers was setup to test whether credit covers is set in other parts of the code
    function check_credit_covers() {
       global $credit_covers;

    return $credit_covers;
            }
    // GV Code End

    function pre_confirmation_check() {
    global $credit_covers, $payment_modules; // GV Code ICW CREDIT CLASS Gift Voucher System
      if (is_array($this->modules)) {
        if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {

                  if ($credit_covers) { // GV Code ICW CREDIT CLASS Gift Voucher System
                    $GLOBALS[$this->selected_module]->enabled = false; // GV Code ICW CREDIT CLASS Gift Voucher System
                    $GLOBALS[$this->selected_module] = NULL; // GV Code ICW CREDIT CLASS Gift Voucher System
                    $payment_modules = ''; // GV Code ICW CREDIT CLASS Gift Voucher System
                  } else { // GV Code ICW CREDIT CLASS Gift Voucher System
                    $GLOBALS[$this->selected_module]->pre_confirmation_check();
                  }
            }
      }
    }

    function confirmation() {
      if (is_array($this->modules)) {
        if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {
          return $GLOBALS[$this->selected_module]->confirmation();
        }
      }
    }

    function process_button() {
      if (is_array($this->modules)) {
        if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {
          return $GLOBALS[$this->selected_module]->process_button();
        }
      }
    }

    function before_process() {
      if (is_array($this->modules)) {
        if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {
          return $GLOBALS[$this->selected_module]->before_process();
        }
      }
    }
    
    function payment_action() {
      if (is_array($this->modules)) {
        if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {
          return $GLOBALS[$this->selected_module]->payment_action();
        }
      }
    }

    function after_process() {
      if (is_array($this->modules)) {
        if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {
          return $GLOBALS[$this->selected_module]->after_process();
        }
      }
    }

    function get_error() {
      if (is_array($this->modules)) {
        if (is_object($GLOBALS[$this->selected_module]) && ($GLOBALS[$this->selected_module]->enabled) ) {
          return $GLOBALS[$this->selected_module]->get_error();
        }
      }
    }
  }
?>
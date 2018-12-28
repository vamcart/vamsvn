<?php
/*
  $Id: ot_surcharge.php,v 1.0 2003/6/19 23:09:49 wib Exp $
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com
  Copyright (c) 2008 osCommerce
  Released under the GNU General Public License
*/

  define('MODULE_PAYMENT_TITLE', 'Payment Type Surcharge');
  define('MODULE_PAYMENT_DESCRIPTION', 'Payment Type Fee');
  define('SHIPPING_NOT_INCLUDED', ' [Shipping not included]');
  define('TAX_NOT_INCLUDED', ' [Tax not included]');

  define('MODULE_PAYMENT_STATUS_TITLE','Display Total');
  define('MODULE_PAYMENT_STATUS_DESC','Do you want to enable the Order Payment Fee?');
  define('MODULE_PAYMENT_SORT_ORDER_TITLE','Sort Order');
  define('MODULE_PAYMENT_SORT_ORDER_DESC','Sort order of display.');
  define('MODULE_PAYMENT_INC_SHIPPING_TITLE','Include Shipping');
  define('MODULE_PAYMENT_INC_SHIPPING_DESC','Include Shipping in calculation');
  define('MODULE_PAYMENT_INC_TAX_TITLE','Include Tax');
  define('MODULE_PAYMENT_INC_TAX_DESC','Include Tax in calculation.');
  define('MODULE_PAYMENT_PERCENTAGE_TITLE','Surcharge Percentage');
  define('MODULE_PAYMENT_PERCENTAGE_DESC','Amount of Surcharge(percentage).');
  define('MODULE_PAYMENT_CALC_TAX_TITLE','Calculate Tax');
  define('MODULE_PAYMENT_CALC_TAX_DESC','Re-calculate Tax on surcharged amount.');
  define('MODULE_PAYMENT_MINIMUM_TITLE','Minimum Amount');
  define('MODULE_PAYMENT_MINIMUM_DESC','Minimum order before fee');
  define('MODULE_PAYMENT_TYPE_TITLE','Payment Type');
  define('MODULE_PAYMENT_TYPE_DESC','Payment Type to pay surcharge');
  
?>
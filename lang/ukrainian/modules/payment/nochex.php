<?php
/* -----------------------------------------------------------------------------------------
   $Id: nochex.php 998 2007/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(nochex.php,v 1.3 2002/11/01); www.oscommerce.com 
   (c) 2003	 nextcommerce (nochex.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (nochex.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_NOCHEX_TEXT_TITLE', 'NOCHEX');
  define('MODULE_PAYMENT_NOCHEX_TEXT_DESCRIPTION', 'NOCHEX<br>Requires the GBP currency.');
define('MODULE_PAYMENT_NOCHEX_TEXT_INFO','');
  define('MODULE_PAYMENT_NOCHEX_STATUS_TITLE' , 'Enable NOCHEX Module');
define('MODULE_PAYMENT_NOCHEX_STATUS_DESC' , 'Do you want to accept NOCHEX payments?');
define('MODULE_PAYMENT_NOCHEX_ALLOWED_TITLE' , 'Allowed Zones');
define('MODULE_PAYMENT_NOCHEX_ALLOWED_DESC' , 'Please enter the zones <b>separately</b> which should be allowed to use this modul (e. g. AT,DE (leave empty if you want to allow all zones))');
define('MODULE_PAYMENT_NOCHEX_ID_TITLE' , 'eMail Address');
define('MODULE_PAYMENT_NOCHEX_ID_DESC' , 'The eMail address to use for the NOCHEX service');
define('MODULE_PAYMENT_NOCHEX_SORT_ORDER_TITLE' , 'Sort order of display.');
define('MODULE_PAYMENT_NOCHEX_SORT_ORDER_DESC' , 'Sort order of display. Lowest is displayed first.');
define('MODULE_PAYMENT_NOCHEX_ZONE_TITLE' , 'Payment Zone');
define('MODULE_PAYMENT_NOCHEX_ZONE_DESC' , 'If a zone is selected, only enable this payment method for that zone.');
define('MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID_TITLE' , 'Set Order Status');
define('MODULE_PAYMENT_NOCHEX_ORDER_STATUS_ID_DESC' , 'Set the status of orders made with this payment module to this value');
?>
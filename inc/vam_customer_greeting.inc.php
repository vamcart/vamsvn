<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_customer_greeting.inc.php 1009 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_customer_greeting.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 
   (c) 2004 xt:Commerce (vam_customer_greeting.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// Return a customer greeting
  function vam_customer_greeting() {

    if (isset($_SESSION['customer_last_name']) && isset($_SESSION['customer_id'])) {
      if (!isset($_SESSION['customer_gender'])) {
      $check_customer_query = "select customers_gender FROM  " . TABLE_CUSTOMERS . " where customers_id = '" . $_SESSION['customer_id'] . "'";
      $check_customer_query = vamDBquery($check_customer_query);
      $check_customer_data  = vam_db_fetch_array($check_customer_query,true);
      $_SESSION['customer_gender'] = $check_customer_data['customers_gender'];
      }
      if($_SESSION['customer_gender']=='f'){
      $greeting_string = sprintf(TEXT_GREETING_PERSONAL, FEMALE . '&nbsp;'. $_SESSION['customer_first_name'] . '&nbsp;'. $_SESSION['customer_last_name'], vam_href_link(FILENAME_PRODUCTS_NEW));
      }else{
      $greeting_string = sprintf(TEXT_GREETING_PERSONAL, MALE . '&nbsp;'. $_SESSION['customer_first_name'] . '&nbsp;' . $_SESSION['customer_last_name'], vam_href_link(FILENAME_PRODUCTS_NEW));
      }

    } else {
      $greeting_string = sprintf(TEXT_GREETING_GUEST, vam_href_link(FILENAME_LOGIN, '', 'SSL'), vam_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));
    }

    return $greeting_string;
  }
 ?>
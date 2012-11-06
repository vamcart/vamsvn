<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_address_label_noaccount.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_address_label.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_address_label.inc.php,v 1.5 2003/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   // include needed functions
   require_once(DIR_FS_INC . 'vam_get_address_format_id.inc.php');
   require_once(DIR_FS_INC . 'vam_address_format.inc.php');

// SMART CHECKOUT BOF 
  // Return a formatted address for noaccount
  function vam_address_label_noaccount($sc_ship_case, $html = false, $boln = '', $eoln = "\n") {
  	if ($sc_ship_case == 0) {
		$address = array('company' => $_SESSION['sc_customers_company'],
						 'firstname' => $_SESSION['sc_customers_firstname'],
						 'lastname' => $_SESSION['sc_customers_lastname'],
						 'street_address' => $_SESSION['sc_customers_street_address'],
						 'suburb' => $_SESSION['sc_customers_suburb'],
						 'city' => $_SESSION['sc_customers_city'],
						 'state' => $_SESSION['sc_customers_state'],
						 'country_id' => $_SESSION['sc_customers_country'],
						 'zone_id' => $_SESSION['sc_customers_zone_id'],
						 'postcode' => $_SESSION['sc_customers_postcode']);
					 
	} elseif ($sc_ship_case == 1) { //payment address id different form shipping
		$address = array('company' => $_SESSION['sc_payment_company'],
						 'firstname' => $_SESSION['sc_payment_firstname'],
						 'lastname' => $_SESSION['sc_payment_lastname'],
						 'street_address' => $_SESSION['sc_payment_street_address'],
						 'suburb' => $_SESSION['sc_payment_suburb'],
						 'city' => $_SESSION['sc_payment_city'],
						 'state' => $_SESSION['sc_payment_state'],
						 'country_id' => $_SESSION['sc_payment_country'],
						 'zone_id' => $_SESSION['sc_payment_zone_id'],
						 'postcode' => $_SESSION['sc_payment_postcode']);
	}			 
					 

    $format_id = vam_get_address_format_id($address['country_id']);

    return vam_address_format($format_id, $address, $html, $boln, $eoln);
  }
// SMART CHECKOUT EOF 

 ?>

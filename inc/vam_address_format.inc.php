<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_address_format.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_address_format.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_address_format.inc.php,v 1.5 2003/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
   require_once(DIR_FS_INC . 'vam_get_zone_name.inc.php');
   require_once(DIR_FS_INC . 'vam_get_country_name.inc.php');
   
function vam_address_format($address_format_id, $address, $html, $boln, $eoln) {
    $address_format_query = vam_db_query("select address_format as format from " . TABLE_ADDRESS_FORMAT . " where address_format_id = '" . $address_format_id . "'");
    $address_format = vam_db_fetch_array($address_format_query);

    $company = addslashes($address['company']);
    $firstname = addslashes($address['firstname']);
    $secondname = addslashes($address['secondname']);
    $lastname = addslashes($address['lastname']);
    $street = addslashes($address['street_address']);
    $suburb = addslashes($address['suburb']);
    $city = addslashes($address['city']);
    $state = addslashes($address['state']);
    $country_id = $address['country_id'];
    $zone_id = $address['zone_id'];
    $postcode = addslashes($address['postcode']);
    $zip = $postcode;
    $country = vam_get_country_name($country_id);
    $state = vam_get_zone_name($country_id, $zone_id, $state);

    if ($html) {
// HTML Mode
      $HR = '<hr />';
      $hr = '<hr />';
      if ( ($boln == '') && ($eoln == "\n") ) { // Values not specified, use rational defaults
        $CR = '<br />';
        $cr = '<br />';
        $eoln = $cr;
      } else { // Use values supplied
        $CR = $eoln . $boln;
        $cr = $CR;
      }
    } else {
// Text Mode
      $CR = $eoln;
      $cr = $CR;
      $HR = '----------------------------------------';
      $hr = '----------------------------------------';
    }

    $statecomma = '';
    $streets = $street;
    if ($suburb != '') $streets = $street . $cr . $suburb;
    if ($firstname == '') $firstname = addslashes($address['name']);
    if ($country == '') $country = addslashes((string)$address['country']);
    if ($state != '') $statecomma = $state . ', ';

    $fmt = $address_format['format'];
    eval("\$address = \"$fmt\";");

    if ( (ACCOUNT_COMPANY == 'true') && (vam_not_null($company)) ) {
      $address = $company . $cr . $address;
    }

    $address = stripslashes($address);

    return $address;
  }
 ?>

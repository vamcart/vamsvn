<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_format_price.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (vam_format_price.inc.php,v 1.7 2003/08/19); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_format_price.inc.php,v 1.7 2004/08/25); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
// include needed functions
require_once(DIR_FS_INC . 'vam_precision.inc.php');
function vam_format_price ($price_string,$price_special,$calculate_currencies,$show_currencies=1)
{
// calculate currencies

$currencies_query = vam_db_query("SELECT symbol_left,
          symbol_right,
          decimal_places,
          value
          FROM ". TABLE_CURRENCIES ." WHERE
          code = '".$_SESSION['currency'] ."'");
$currencies_value=vam_db_fetch_array($currencies_query);
$currencies_data=array();
$currencies_data=array(
      'SYMBOL_LEFT'=>$currencies_value['symbol_left'] ,
      'SYMBOL_RIGHT'=>$currencies_value['symbol_right'] ,
      'DECIMAL_PLACES'=>$currencies_value['decimal_places'] ,
      'VALUE'=> $currencies_value['value']);
if ($calculate_currencies=='true') {
$price_string=$price_string * $currencies_data['VALUE'];
}
// round price
$price_string=vam_precision($price_string,$currencies_data['DECIMAL_PLACES']);


if ($price_special=='1') {
$currencies_query = vam_db_query("SELECT symbol_left,
          decimal_point,
          thousands_point,
          value
          FROM ". TABLE_CURRENCIES ." WHERE
          code = '".$_SESSION['currency'] ."'");
$currencies_value=vam_db_fetch_array($currencies_query);
$price_string=number_format($price_string,$currencies_data['DECIMAL_PLACES'], $currencies_value['decimal_point'], $currencies_value['thousands_point']);
  if ($show_currencies == 1) {
    $price_string = $currencies_data['SYMBOL_LEFT']. ' '.$price_string.' '.$currencies_data['SYMBOL_RIGHT'];
  }
}
return $price_string;
}
?>

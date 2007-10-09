<?php
/* --------------------------------------------------------------
   $Id: localization.php 950 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(localization.php,v 1.12 2003/06/25); www.oscommerce.com
   (c) 2003	 nextcommerce (localization.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2004 xt:Commerce (localization.php,v 1.4 2003/08/14); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/
defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );
  function quote_oanda_currency($code, $base = DEFAULT_CURRENCY) {
    $page = file('http://www.oanda.com/convert/fxdaily?value=1&redirected=1&exch=' . $code .  '&format=CSV&dest=Get+Table&sel_list=' . $base);

    $match = array();

    preg_match('/(.+),(\w{3}),([0-9.]+),([0-9.]+)/i', implode('', $page), $match);

    if (sizeof($match) > 0) {
      return $match[3];
    } else {
      return false;
    }
  }

  function quote_xe_currency($to, $from = DEFAULT_CURRENCY) {
    $page = file('http://www.xe.net/ucc/convert.cgi?Amount=1&From=' . $from . '&To=' . $to);

    $match = array();

    preg_match('/[0-9.]+\s*' . $from . '\s*=\s*([0-9.]+)\s*' . $to . '/', implode('', $page), $match);

    if (sizeof($match) > 0) {
      return $match[1];
    } else {
      return false;
    }
  }
  
// Синхронизация курса валют с текущим курсом Центрального банка России  
function quote_cbr_currency($code, $base = DEFAULT_CURRENCY) { 
    global $quote_cbr_cashed; 
    if (sizeof($quote_cbr_cash)==0){ 
      $quote_cbr_cash = array(); 
      $quote_cbr_cash['RUB'] = 1.00; 
      $quote_cbr_cash['RUR'] = 1.00; 
      $page = file('http://www.cbr.ru/scripts/XML_daily.asp'); 
      if (!is_array($page)){ // Что-то не так у нас с ЦБР 
        return false; 
      } 
      $page = implode('', $page); 
      preg_match_all("|<CharCode>(.*?)</CharCode>|is", $page, $m); 
      preg_match_all("|<Value>(.*?)</Value>|is", $page, $c); 
      foreach ($m[1] as $kv => $mv){ 
        $quote_cbr_cash[$mv]=ereg_replace(',', '.', $c[1][$kv]); 
      } 
    } 
    if (isset($quote_cbr_cash[$code]) && isset($quote_cbr_cash[$base])) { 
      $retval = round($quote_cbr_cash[$base]/$quote_cbr_cash[$code],4); 
      settype($retval,"string"); 
      return $retval; 
    } else { 
      return false; 
    } 
  }  
  
?>
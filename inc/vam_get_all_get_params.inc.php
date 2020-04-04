<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_all_get_params.inc.php 1310 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_get_all_get_params.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_all_get_params.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
  function vam_get_all_get_params($exclude_array = '') {
  	global $InputFilter;

    if (!is_array($exclude_array))
      $exclude_array = array ();
    $get_url = '';

    if (is_array($_GET) && (sizeof($_GET) > 0)) {
      reset($_GET);

      foreach ($_GET as $key => $value) {
        if (is_array($value)) {
          foreach ($value as $new_key => $new_value) {
            if (!in_array($key, $exclude_array)) {
              $get_url .= $key . '[' . $new_key . ']' . '=' . rawurlencode(stripslashes((string)$new_value)) . '&';
            }
          }
        }
        elseif ((strlen($value) > 0) && ($key != vam_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array)) && ($key != 'x') && ($key != 'y')) {
          $get_url .= $key . '=' . rawurlencode(stripslashes($value)) . '&';
        }
      }
    }

    return $get_url;
  }
  
  
function vam_get_all_get_params_filters_breadhumps($exclude_array = '', $dbg=false) {
  global $InputFilter;

  if (!is_array($exclude_array))
    $exclude_array = array ();
  $get_url = '';

  //if($dbg) var_dump($exclude_array);

  if (is_array($_GET) && (sizeof($_GET) > 0)) {
    reset($_GET);

    foreach ($_GET as $key => $value) {


      if($dbg) echo $key."\r\n";

      if (is_array($value)) {

              foreach ($value as $new_key => $new_value) {


                //if($dbg && is_array($value)) echo ($key).' '.var_dump($exclude_array)."\r\n";

                if (!in_array($key. '[' . $new_key . ']', $exclude_array)) {
                  $get_url .= $key . '[' . $new_key . ']' . '=' . rawurlencode(stripslashes((string)$new_value)) . '&';

                //if($dbg && is_array($value)) echo $get_url."\r\n";


                }

                //if($dbg && is_array($value)) echo ($key).' '.var_dump($exclude_array)."\r\n";

                //if($dbg && is_array($value)) echo $new_value."\r\n";

              }

        //if($dbg && is_array($value)) echo $get_url."\r\n";

      }elseif ((strlen($value) > 0) && ($key != vam_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array)) && ($key != 'x') && ($key != 'y')) {

        $get_url .= $key . '=' . rawurlencode(stripslashes($value)) . '&';

      }

    }
  }

  if($dbg) echo $get_url."\r\n";

  return $get_url;
}
  
  
 ?>
<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_get_top_level_domain.inc.php 1528 2006-08-06 11:50:57Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (xtc_get_top_level_domain.inc.php,v 1.3 2003/08/13); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
function xtc_get_top_level_domain($url) {
    if (strpos($url, '://')) {
      $url = parse_url($url);
      $url = $url['host'];
    }

    $domain_array = explode('.', $url);
    $domain_size = sizeof($domain_array);

   if ($domain_size > 1) { 
     $domain = ''; 
     for ($i = 1; $i <= $domain_size; $i++) { 
       $domain .= '.' . $domain_array[$i]; 
     } 

     if (is_numeric($domain)) { 
       return false; 
     } else { 
       return $domain; 
     } 
   } else { 
     return false; 
   } 
  }
 ?>
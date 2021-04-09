<?php
/* -----------------------------------------------------------------------------------------
   $Id: currencies.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(currencies.php,v 1.16 2003/02/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (currencies.php,v 1.11 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (currencies.php,v 1.11 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  // include functions
  require_once(DIR_FS_INC . 'vam_hide_session_id.inc.php');
  if (isset($vamPrice) && is_object($vamPrice)) {

  $currencies_string = '';
  $count_cur='';
  foreach ($vamPrice->currencies as $key => $value) {
  $count_cur++;
    //$currencies_string .= '<option value="'.$key.'"'.($_SESSION['currency'] == $key ? ' selected' : null).'>'.$value['title'].'</option>';
    $currencies_string .= '<option value="'.$key.'">'.$value['title'].'</option>';
  }

    $hidden_get_variables = '';
    foreach ($_GET as $key => $value) {
      if ( ($key != 'currency') && ($key != vam_session_name()) && ($key != 'x') && ($key != 'y') ) {
        $hidden_get_variables .= vam_draw_hidden_field($key, $value);
      }
    }


  }


  // dont show box if there's only 1 currency
  if ($count_cur > 1 ) {

  $box->assign('BOX_CONTENT', $currencies_string . $hidden_get_variables);
  $box->assign('language', $_SESSION['language']);
    	  // set cache ID
   if (!CacheCheck()) {
  $box->caching = 0;
  $box_currencies= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_currencies.html');
  } else {
  $box->caching = 1;	
  $box->cache_lifetime=CACHE_LIFETIME;
  $box->cache_modified_check=CACHE_CHECK;
  $cache_id = $_SESSION['language'].$_SESSION['currency'];
  $box_currencies= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_currencies.html',$cache_id);
  }

  $vamTemplate->assign('box_CURRENCIES',$box_currencies);

  }
 ?>
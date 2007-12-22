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

    $count_cur='';
    reset($vamPrice->currencies);
    $currencies_array = array();
    while (list($key, $value) = each($vamPrice->currencies)) {
    $count_cur++;
      $currencies_array[] = array('id' => $key, 'text' => $value['title']);
    }

    $hidden_get_variables = '';
    reset($_GET);
    while (list($key, $value) = each($_GET)) {
      if ( ($key != 'currency') && ($key != vam_session_name()) && ($key != 'x') && ($key != 'y') ) {
        $hidden_get_variables .= vam_draw_hidden_field($key, $value);
      }
    }


  }


  // dont show box if there's only 1 currency
  if ($count_cur > 1 ) {

  // reset var
  $box = new vamTemplate;
  $box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
  $box_content='';
  $box_content=vam_draw_form('currencies', vam_href_link(basename($_SERVER['SCRIPT_NAME']), '', $request_type, false), 'get').vam_draw_pull_down_menu('currency', $currencies_array, $_SESSION['currency'], 'onchange="this.form.submit();"') . $hidden_get_variables . vam_hide_session_id().'</form>';


  $box->assign('BOX_CONTENT', $box_content);
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
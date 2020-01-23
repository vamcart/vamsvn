<?php
/* -----------------------------------------------------------------------------------------
   $Id: infobox.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com 
   (c) 2003	 nextcommerce (infobox.php,v 1.7 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (infobox.php,v 1.7 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Loginbox V1.0        	Aubrey Kilian <aubrey@mycon.co.za>

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
$box = new vamTemplate;
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
$box_content='';


  if ($_SESSION['customers_status']['customers_status_image']!='') {
    $loginboxcontent = vam_image('images/icons/' . $_SESSION['customers_status']['customers_status_image']) . '<br />';
  }
  $loginboxcontent .= BOX_LOGINBOX_STATUS . '&nbsp;<span>' . $_SESSION['customers_status']['customers_status_name'] . '</span><br />';
  if ($_SESSION['customers_status']['customers_status_show_price'] == 0) {
    $loginboxcontent .= NOT_ALLOWED_TO_SEE_PRICES_TEXT;
  } else  {
    if ($_SESSION['customers_status']['customers_status_discount'] != '0.00') {
      $loginboxcontent.=BOX_LOGINBOX_DISCOUNT . ' ' . $_SESSION['customers_status']['customers_status_discount'] . '%<br />';
    }
    if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1  && $_SESSION['customers_status']['customers_status_ot_discount'] != '0.00') {
      $loginboxcontent .= BOX_LOGINBOX_DISCOUNT_TEXT . ' '  . $_SESSION['customers_status']['customers_status_ot_discount'] . ' % ' . BOX_LOGINBOX_DISCOUNT_OT . '<br />';
    }
  }



    $box->assign('BOX_CONTENT', $loginboxcontent);
	$box->assign('language', $_SESSION['language']);
       	  // set cache ID
  if (!CacheCheck()) {
  $box->caching = 0;
  $box_infobox= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_infobox.html');
  } else {
  $box->caching = 1;
  $box->cache_lifetime=CACHE_LIFETIME;
  $box->cache_modified_check=CACHE_CHECK;
  $cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'];
  $box_infobox= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_infobox.html',$cache_id);
  }
    
    $vamTemplate->assign('box_INFOBOX',$box_infobox);

    ?>
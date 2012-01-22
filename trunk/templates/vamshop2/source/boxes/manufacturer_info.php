<?php
/* -----------------------------------------------------------------------------------------
   $Id: manufacturer_info.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturer_info.php,v 1.10 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (manufacturer_info.php,v 1.6 2003/08/13); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (manufacturer_info.php,v 1.6 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
$box = new vamTemplate;
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
$box_content='';


    $manufacturer_query = vamDBquery("select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on (m.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$_SESSION['languages_id'] . "'), " . TABLE_PRODUCTS . " p  where p.products_id = '" . $product->data['products_id'] . "' and p.manufacturers_id = m.manufacturers_id");
    if (vam_db_num_rows($manufacturer_query,true)) {
      $manufacturer = vam_db_fetch_array($manufacturer_query,true);

      $image='';
      if (vam_not_null($manufacturer['manufacturers_image'])) $image=DIR_WS_IMAGES . $manufacturer['manufacturers_image'];
      $box->assign('IMAGE',$image);
      $box->assign('NAME',$manufacturer['manufacturers_name']);
      
        if ($manufacturer['manufacturers_url']!='')$box->assign('URL','<a href="' . vam_href_link(FILENAME_REDIRECT, 'action=manufacturer&'.vam_manufacturer_link($manufacturer['manufacturers_id'],$manufacturer['manufacturers_name'])) . '" onclick="window.open(this.href); return false;">' . sprintf(BOX_MANUFACTURER_INFO_HOMEPAGE, $manufacturer['manufacturers_name']) . '</a>');
        $box->assign('LINK_MORE','<a href="' .vam_href_link(FILENAME_DEFAULT, 'manufacturers_id='.$manufacturer['manufacturers_id']) . '">' . BOX_MANUFACTURER_INFO_OTHER_PRODUCTS . '</a>');

    }
  



 	$box->assign('language', $_SESSION['language']);
    	  // set cache ID
   if (!CacheCheck()) {
  $box->caching = 0;
  $box_manufacturers_info= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_manufacturers_info.html');
  } else {
  $box->caching = 1;	
  $box->cache_lifetime=CACHE_LIFETIME;
  $box->cache_modified_check=CACHE_CHECK;
  $cache_id = $_SESSION['language'].$product->data['products_id'];
  $box_manufacturers_info= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_manufacturers_info.html',$cache_id);
  }
    if ($manufacturer['manufacturers_name']!='')  $vamTemplate->assign('box_MANUFACTURERS_INFO',$box_manufacturers_info);
    
?>
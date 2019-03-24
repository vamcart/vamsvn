<?php
/* -----------------------------------------------------------------------------------------
   $Id: whats_new.php 1292 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(whats_new.php,v 1.31 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (whats_new.php,v 1.12 2003/08/21); www.nextcommerce.org
   (c) 2004	 xt:Commerce (whats_new.php,v 1.12 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
$box = new vamTemplate;
$box->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$box_content = '';
// include needed functions
require_once (DIR_FS_INC.'vam_random_select.inc.php');
require_once (DIR_FS_INC.'vam_rand.inc.php');
require_once (DIR_FS_INC.'vam_get_products_name.inc.php');

//fsk18 lock
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}
if ($random_product = vam_random_select("select distinct
                                           p.products_id,
                                           pd.products_name,
                                           p.products_image,
                                           p.products_tax_class_id,
                                           p.products_vpe,
				                           p.products_vpe_status,
				                           p.products_vpe_value,
                                           p.products_price
                                           from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_CATEGORIES." c
                                           where p.products_status=1
                                           and p.products_id = p2c.products_id
                                           and pd.products_id = p.products_id
                                           and p.products_id !='".(int) $_GET['products_id']."'
                                           and pd.language_id = '".$_SESSION['languages_id']."'
                                           and c.categories_id = p2c.categories_id
                                           ".$group_check."
                                           ".$fsk_lock."
                                           and c.categories_status=1 order by
                                           p.products_id desc limit ".MAX_RANDOM_SELECT_NEW)) {

	$whats_new_price = $vamPrice->GetPrice($random_product['products_id'], $format = true, 1, $random_product['products_tax_class_id'], $random_product['products_price']);
}

if ($random_product['products_name'] != '') {

	$box->assign('box_content',$product->buildDataArray($random_product));
	$box->assign('LINK_NEW_PRODUCTS',vam_href_link(FILENAME_PRODUCTS_NEW));
	$box->assign('language', $_SESSION['language']);
	// set cache ID
	 if (!CacheCheck()) {
		$box->caching = 0;
		$box_whats_new = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_whatsnew.html');
	} else {
		$box->caching = 1;
		$box->cache_lifetime = CACHE_LIFETIME;
		$box->cache_modified_check = CACHE_CHECK;
		$cache_id = $_SESSION['language'].$random_product['products_id'].$_SESSION['customers_status']['customers_status_name'];
		$box_whats_new = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_whatsnew.html', $cache_id);
	}

	$vamTemplate->assign('box_WHATSNEW', $box_whats_new);
}
?>
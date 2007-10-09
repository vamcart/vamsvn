<?php
/* -----------------------------------------------------------------------------------------
   $Id: specials.php 1292 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(specials.php,v 1.30 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (specials.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (specials.php,v 1.10 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
$box = new vamTemplate;
$box->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$box_content = '';
// include needed functions
require_once (DIR_FS_INC.'vam_random_select.inc.php');

//fsk18 lock
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}
if ($random_product = vam_random_select("select
                                           p.products_id,
                                           pd.products_name,
                                           p.products_price,
                                           p.products_tax_class_id,
                                           p.products_image,
                                           s.expires_date,
                                           p.products_vpe,
				                           p.products_vpe_status,
				                           p.products_vpe_value,
                                           s.specials_new_products_price
                                           from ".TABLE_PRODUCTS." p,
                                           ".TABLE_PRODUCTS_DESCRIPTION." pd,
                                           ".TABLE_SPECIALS." s where p.products_status = '1'
                                           and p.products_id = s.products_id
                                           and pd.products_id = s.products_id
                                           and pd.language_id = '".$_SESSION['languages_id']."'
                                           and s.status = '1'
                                           ".$group_check."
                                           ".$fsk_lock."                                             
                                           order by s.specials_date_added
                                           desc limit ".MAX_RANDOM_SELECT_SPECIALS)) {


$box->assign('box_content',$product->buildDataArray($random_product));
$box->assign('SPECIALS_LINK', vam_href_link(FILENAME_SPECIALS));

$box->assign('language', $_SESSION['language']);
if ($random_product["products_id"] != '') {
	// set cache ID
	 if (!CacheCheck()) {
		$box->caching = 0;
		$box_specials = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_specials.html');
	} else {
		$box->caching = 1;
		$box->cache_lifetime = CACHE_LIFETIME;
		$box->cache_modified_check = CACHE_CHECK;
		$cache_id = $_SESSION['language'].$random_product["products_id"].$_SESSION['customers_status']['customers_status_name'];
		$box_specials = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_specials.html', $cache_id);
	}
	$vamTemplate->assign('box_SPECIALS', $box_specials);
}
}
?>
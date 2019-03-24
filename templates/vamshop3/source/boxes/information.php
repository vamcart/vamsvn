<?php
/* -----------------------------------------------------------------------------------------
   $Id: information.php 1302 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(information.php,v 1.6 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (information.php,v 1.8 2003/08/21); www.nextcommerce.org
   (c) 2004	 xt:Commerce (information.php,v 1.8 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
$box = new vamTemplate;
$content_string = '';

$box->assign('language', $_SESSION['language']);
// set cache ID
if (!CacheCheck()) {
	$cache=false;
	$box->caching = 0;
} else {
	$cache=true;
	$box->caching = 1;
	$box->cache_lifetime = CACHE_LIFETIME;
	$box->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'];
}

if (!$box->isCached(CURRENT_TEMPLATE.'/boxes/box_information.html', $cache_id) || !$cache) {
	$box->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

	if (GROUP_CHECK == 'true') {
		$group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
	}

	$content_query = "SELECT
	 					content_id,
	 					categories_id,
	 					parent_id,
	 					content_title,
	 					content_url,
	 					content_group
	 					FROM ".TABLE_CONTENT_MANAGER."
	 					WHERE languages_id='".(int) $_SESSION['languages_id']."'
	 					and file_flag=0 ".$group_check." and content_status=1 order by sort_order";

	$content_query = vamDBquery($content_query);

	while ($content_data = vam_db_fetch_array($content_query, true)) {
		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&product='.vam_cleanName($content_data['content_title']);

if ($content_data['content_url'] != '') {
	$link = '<li><a href="'.$content_data['content_url'].'" target="_blank">';
} else {
	$link = '<li><a href="'.vam_href_link(FILENAME_CONTENT, 'coID='.$content_data['content_group'].$SEF_parameter).'">';
}

		$content_string .= $link.$content_data['content_title'].'</a></li>' . "\n";
	}

		$content_string .= '<li><a href="'.vam_href_link(FILENAME_SITE_REVIEWS).'">'.NAVBAR_TITLE_SITE_REVIEWS.'</a></li>' . "\n";

	if ($content_string != '')
		$box->assign('BOX_CONTENT', $content_string);

}

if (!$cache) {
	$box_information = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_information.html');
} else {
	$box_information = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_information.html', $cache_id);
}

$vamTemplate->assign('box_INFORMATION', $box_information);
?>
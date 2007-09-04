<?php
/* -----------------------------------------------------------------------------------------
   $Id: content.php 1302 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(information.php,v 1.6 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (content.php,v 1.2 2003/08/21); www.nextcommerce.org
   (c) 2004	 xt:Commerce (content.php,v 1.2 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
$box_smarty = new vamTemplate;
$content_string = '';

$box_smarty->assign('language', $_SESSION['language']);
// set cache ID
if (!CacheCheck()) {
	$cache=false;
	$box_smarty->caching = 0;
} else {
	$cache=true;
	$box_smarty->caching = 1;
	$box_smarty->cache_lifetime = CACHE_LIFETIME;
	$box_smarty->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'];
}

if (!$box_smarty->is_cached(CURRENT_TEMPLATE.'/boxes/box_content.html', $cache_id) || !$cache) {

	$box_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

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
	 					and file_flag=1 ".$group_check." and content_status=1 order by sort_order";

	$content_query = vamDBquery($content_query);

	while ($content_data = vam_db_fetch_array($content_query, true)) {
		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&content='.vam_cleanName($content_data['content_title']);

if ($content_data['content_url'] != '') {
	$link = '<img src="templates/'.CURRENT_TEMPLATE.'/img/icon_arrow2.jpg" alt="" /> <a href="'.$content_data['content_url'].'" target="_blank">';
} else {
	$link = '<img src="templates/'.CURRENT_TEMPLATE.'/img/icon_arrow2.jpg" alt="" /> <a href="'.vam_href_link(FILENAME_CONTENT, 'coID='.$content_data['content_group'].$SEF_parameter).'">';
}

		$content_string .= $link.$content_data['content_title'].'</a><br />' . "\n";
	}

	if ($content_string != '')
		$box_smarty->assign('BOX_CONTENT', $content_string);

}

if (!$cache) {
	$box_content = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_content.html');
} else {
	$box_content = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_content.html', $cache_id);
}

$smarty->assign('box_CONTENT', $box_content);
?>
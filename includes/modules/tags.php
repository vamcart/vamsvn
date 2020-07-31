<?php
/* -----------------------------------------------------------------------------------------
   $Id: news.php 1292 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_products.php,v 1.33 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (new_products.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (new_products.php,v 1.9 2003/08/17); www.xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

global $tags_category_id;

$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

if ((!isset ($tags_category_id)) || ($tags_category_id == '0')) {
	
$sql_tags = "
    SELECT
        *
    FROM " . TABLE_TAGS . "
    WHERE
         status = '1' 
         and tags_mainpage = '1' 
         and language = '" . (int)$_SESSION['languages_id'] . "'
    ORDER BY sort_order ASC, date_added DESC
    LIMIT " . MAX_DISPLAY_TAGS . "
    ";

} else {

$sql_tags = "
    SELECT
        f.*
    FROM " . TABLE_TAGS . " f , " . TABLE_TAGS_TO_CATEGORIES . " f2c
    WHERE
         f2c.categories_id = '" . (int)$tags_category_id . "'
         and f.tags_id = f2c.tags_id 
         and f.status = '1'
         and f.language = '" . (int)$_SESSION['languages_id'] . "'
    ORDER BY f.sort_order ASC, f.date_added DESC
    LIMIT " . MAX_DISPLAY_TAGS . "
    ";
    
}

$row = 0;
$module_content_tags = array ();

$query_tags = vamDBquery($sql_tags);
while ($one_tag = vam_db_fetch_array($query_tags,true)) {

$tagsI=0; $tagsIcon='';
//echo strpos($one_tag['answer'],'src="')." ";
if ($tagsI=strpos($one_tag['description'],'src="')) {
	$tagsI=$tagsI+5;
	$tagsIcon=substr ($one_tag['description'] , $tagsI);
	$tagsI=strpos($tagsIcon,'"');
	$tagsIcon= substr($tagsIcon, 0, $tagsI);
//echo "<pre>".$qIcon."</pre>";
}

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&name='.vam_cleanName($one_tag['name']);

    $module_content_tags[]=array(
              'TAGS_ICON' => $tagsIcon,
              'TAGS_NAME' => $one_tag['tags_name'],
              'TAGS_TITLE' => $one_tag['tags_title'],
              'TAGS_DESCRIPTION' => $one_tag['tags_description'],
              'TAGS_ID'      => $one_tag['tags_id'],
              'TAGS_URL'      => $one_tag['tags_url'],
              'TAGS_DATE'    => vam_date_short($one_tag['date_added']),
              'TAGS_LINK_MORE'    => vam_href_link(FILENAME_TAGS, 'tags_id='.$one_tag['tags_id'] . $SEF_parameter, 'NONSSL'),
        );

}
if (sizeof($module_content_tags) > 0) {
    $module->assign('TAGS_LINK', vam_href_link(FILENAME_TAGS));
    $module->assign('language', $_SESSION['language']);
    $module->assign('module_content',$module_content_tags);
	
	// set cache ID
	 if (!CacheCheck()) {
		$module->caching = 0;
      $module= $module->fetch(CURRENT_TEMPLATE.'/module/tags_default.html');
	} else {
        $module->caching = 1;
        $module->cache_lifetime=CACHE_LIFETIME;
        $module->cache_modified_check=CACHE_CHECK;
        $module = $module->fetch(CURRENT_TEMPLATE.'/module/tags_default.html',$cache_id);
	}
	$default->assign('MODULE_tags', $module);
}
?>
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

global $news_category_id;

$module_listing = new vamTemplate;
$module_listing->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

if ((!isset ($news_category_id)) || ($news_category_id == '0')) {
	
$sql_news = "
    SELECT
        news_id,
        headline,
        content,
        date_added
    FROM " . TABLE_LATEST_NEWS . "
    WHERE
         status = '1'
         and language = '" . (int)$_SESSION['languages_id'] . "'
    ORDER BY date_added DESC
    LIMIT " . MAX_DISPLAY_LATEST_NEWS . "
    ";

} else {

$sql_news = "
    SELECT
        n.news_id,
        n.headline,
        n.content,
        n.date_added
    FROM " . TABLE_LATEST_NEWS . " n , " . TABLE_LATEST_NEWS_TO_CATEGORIES . " n2c
    WHERE
         n2c.categories_id = '" . (int)$news_category_id . "'
         and n.news_id = n2c.news_id 
         and n.status = '1'
         and n.language = '" . (int)$_SESSION['languages_id'] . "'
    ORDER BY n.date_added DESC
    LIMIT " . MAX_DISPLAY_LATEST_NEWS . "
    ";

}

$row = 0;
$module_listing_content_news = array ();

$query_news = vamDBquery($sql_news);
while ($one_news = vam_db_fetch_array($query_news,true)) {

$qI=0; $qIcon='';
//echo strpos($one_news['content'],'src="')." ";
if ($qI=strpos($one_news['content'],'src="')) {
	$qI=$qI+5;
	$qIcon=substr ($one_news['content'] , $qI);
	$qI=strpos($qIcon,'"');
	$qIcon= substr($qIcon, 0, $qI);
//echo "<pre>".$qIcon."</pre>";
}

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&headline='.vam_cleanName($one_news['headline']);

    $module_listing_content_news[]=array(
        'NEWS_ICON' => $qIcon,
        'NEWS_HEADING' => $one_news['headline'],
        'NEWS_CONTENT' => $one_news['content'],
        'NEWS_ID'      => $one_news['news_id'],
        'NEWS_DATA'    => vam_date_short($one_news['date_added']),
        'NEWS_LINK_MORE'    => vam_href_link(FILENAME_NEWS, 'news_id='.$one_news['news_id'] . $SEF_parameter, 'NONSSL'),
        );

}
if (sizeof($module_listing_content_news) > 0) {
    $module_listing->assign('NEWS_LINK', vam_href_link(FILENAME_NEWS));
    $module_listing->assign('language', $_SESSION['language']);
    $module_listing->assign('module_content',$module_listing_content_news);
	
	// set cache ID
	 if (!CacheCheck()) {
		$module_listing->caching = 0;
      $module_listing= $module_listing->fetch(CURRENT_TEMPLATE.'/module/latest_news_default.html');
	} else {
        $module_listing->caching = 1;
        $module_listing->cache_lifetime=CACHE_LIFETIME;
        $module_listing->cache_modified_check=CACHE_CHECK;
        $module_listing = $module_listing->fetch(CURRENT_TEMPLATE.'/module/latest_news_default.html',$cache_id);
	}
	$module->assign('MODULE_latest_news', $module_listing);
}
?>
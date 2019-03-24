<?php
/* -----------------------------------------------------------------------------------------
   $Id: news.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$box = new vamTemplate;
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

$sql = "
    SELECT
        news_id,
        headline,
        content,
        date_added
    FROM " . TABLE_LATEST_NEWS . "
    WHERE
         status = '1'
         and language = '" . (int)$_SESSION['languages_id'] . "'
    ORDER BY news_id DESC
    LIMIT " . MAX_DISPLAY_LATEST_NEWS . "
    ";

$module_content = array();
$query = vamDBquery($sql);
while ($one = vam_db_fetch_array($query,true)) {

$qI=0; $qIcon='';
//echo strpos($one['content'],'src="')." ";
if ($qI=strpos($one['content'],'src="')) {
	$qI=$qI+5;
	$qIcon=substr ($one['content'] , $qI);
	$qI=strpos($qIcon,'"');
	$qIcon='<img width="80" src="'.substr ($qIcon, 0, $qI).'" />';
//echo "<pre>".$qIcon."</pre>";
}

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&headline='.vam_cleanName($one['headline']);

    $module_content[]=array(
        'NEWS_ICON' => $qIcon,
        'NEWS_HEADING' => $one['headline'],
        'NEWS_CONTENT' => $one['content'],
        'NEWS_ID'      => $one['news_id'],
        'NEWS_DATA'    => vam_date_short($one['date_added']),
        'NEWS_LINK_MORE'    => vam_href_link(FILENAME_NEWS, 'news_id='.$one['news_id'] . $SEF_parameter, 'NONSSL'),
        );
}

if (sizeof($module_content) > 0) {
    $box->assign('NEWS_LINK', vam_href_link(FILENAME_NEWS));
    $box->assign('language', $_SESSION['language']);
    $box->assign('module_content',$module_content);
    // set cache ID
    if (USE_CACHE=='false') {
        $box->caching = 0;
        $module= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_latest_news.html');
    } else {
        $box->caching = 1;
        $box->cache_lifetime=CACHE_LIFETIME;
        $box->cache_modified_check=CACHE_CHECK;
        $module = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_latest_news.html',$cache_id);
    }
    $vamTemplate->assign('box_LATESTNEWS',$module);
}
?>
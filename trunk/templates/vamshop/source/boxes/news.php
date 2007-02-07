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

$box_smarty = new smarty;
$box_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

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
    ORDER BY date_added DESC
    LIMIT " . MAX_DISPLAY_LATEST_NEWS . "
    ";

$module_content = array();
$query = xtDBquery($sql);
while ($one = xtc_db_fetch_array($query,true)) {
    $module_content[]=array(
        'NEWS_HEADING' => $one['headline'],
        'NEWS_CONTENT' => $one['content'],
        'NEWS_ID'      => $one['news_id'],
        'NEWS_DATA'    => xtc_date_short($one['date_added']),
        'NEWS_LINK_MORE'    => xtc_href_link(FILENAME_NEWS, 'news_id='.$one['news_id'], 'NONSSL'),
        );
}

if (sizeof($module_content) > 0) {
    $box_smarty->assign('NEWS_LINK', xtc_href_link(FILENAME_NEWS));
    $box_smarty->assign('language', $_SESSION['language']);
    $box_smarty->assign('module_content',$module_content);
    // set cache ID
    if (USE_CACHE=='false') {
        $box_smarty->caching = 0;
        $module= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_latest_news.html');
    } else {
        $box_smarty->caching = 1;
        $box_smarty->cache_lifetime=CACHE_LIFETIME;
        $box_smarty->cache_modified_check=CACHE_CHECK;
        $module = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_latest_news.html',$cache_id);
    }
    $smarty->assign('box_LATESTNEWS',$module);
}
?>
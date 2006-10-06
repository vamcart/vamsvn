<?php

/* -----------------------------------------------------------------------------------------
   $Id: news.php 1292 2006-10-06 22:06:55 VaM $

   VaM Shop - open source ecommerce solution
   http://oscommerce.su

   Copyright (c) 2006 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_products.php,v 1.33 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (new_products.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2005	 xt:Commerce (new_products.php,v 1.9 2003/08/17); www.xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

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

$row = 0;
$module_content = array ();

$query = xtDBquery($sql);
while ($one = xtc_db_fetch_array($query,true)) {
    $module_content[]=array(
        'NEWS_HEADING' => $one['headline'],
        'NEWS_CONTENT' => $one['content'],
        'NEWS_ID'      => $one['news_id'],
        'NEWS_DATA'    => $one['date_added'],
        );

}
if (sizeof($module_content) > 0) {
    $module_smarty->assign('NEWS_LINK', xtc_href_link(FILENAME_NEWS));
    $module_smarty->assign('language', $_SESSION['language']);
    $module_smarty->assign('module_content',$module_content);
	
	// set cache ID
	 if (!CacheCheck()) {
		$module_smarty->caching = 0;
      $module= $module_smarty->fetch(CURRENT_TEMPLATE.'/module/latest_news_default.html');
	} else {
        $module_smarty->caching = 1;
        $module_smarty->cache_lifetime=CACHE_LIFETIME;
        $module_smarty->cache_modified_check=CACHE_CHECK;
        $module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/latest_news_default.html',$cache_id);
	}
	$default_smarty->assign('MODULE_latest_news', $module);
}
?>
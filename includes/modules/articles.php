 <?php

$module = new vamTemplate;

$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

$sql = "select a.articles_id, ad.articles_name, ad.articles_description from " . TABLE_ARTICLES . " a left join " . TABLE_ARTICLES_DESCRIPTION . " ad on ad.articles_id = a.articles_id where a.articles_status = '1' and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' ORDER BY articles_date_added DESC LIMIT " . MAX_NEW_ARTICLES_PER_PAGE . "";

$row = 0;

$module_content = array ();

$query = vamDBquery($sql,true);

while ($one = vam_db_fetch_array($query,true)) {

$SEF_parameter = '';

if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')

$SEF_parameter = '&headline='.vam_cleanName($one['articles_name']);

$module_content[]=array(

'ARTICLES_NAME' => $one['articles_name'],

'ARTICLES_DESCRIPTOIN' => $one['articles_description'],

'ARTICLES_URL' => vam_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $one['articles_id'] . $SEF_parameter)

);

}

if (sizeof($module_content) > 0) {

$module->assign('language', $_SESSION['language']);

$module->assign('module_content',$module_content);

// set cache ID

if (!CacheCheck()) {

$module->caching = 0;

$module= $module->fetch(CURRENT_TEMPLATE.'/module/articles_default.html');

} else {

$module->caching = 1;

$module->cache_lifetime=CACHE_LIFETIME;

$module->cache_modified_check=CACHE_CHECK;

$module = $module->fetch(CURRENT_TEMPLATE.'/module/articles_default.html',$cache_id);

}

$default->assign('MODULE_articles', $module);

}

?>
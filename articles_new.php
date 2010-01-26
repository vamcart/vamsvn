<?php
/* -----------------------------------------------------------------------------------------
   $Id: articles_new.php 1292 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(products_new.php,v 1.25 2003/05/27); www.oscommerce.com 
   (c) 2003	 nextcommerce (products_new.php,v 1.16 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (products_new.php,v 1.16 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed function
require_once (DIR_FS_INC.'vam_date_long.inc.php');

$breadcrumb->add(BOX_NEW_ARTICLES, vam_href_link(FILENAME_ARTICLES_NEW));

require (DIR_WS_INCLUDES.'header.php');

  $articles_new_array = array();
  $articles_new_query_raw = "select a.articles_id, a.sort_order, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, au.authors_id, au.authors_name, td.topics_id, td.topics_name from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int) $_SESSION['languages_id'] . "' and td.language_id = '" . (int) $_SESSION['languages_id'] . "' and a.articles_date_added > SUBDATE(now( ), INTERVAL '" . NEW_ARTICLES_DAYS_DISPLAY . "' DAY) order by a.articles_date_added";

$articles_new_split = new splitPageResults($articles_new_query_raw, $_GET['page'], MAX_NEW_ARTICLES_PER_PAGE);

if (($articles_new_split->number_of_rows > 0)) {
	$vamTemplate->assign('NAVIGATION_BAR', TEXT_RESULT_PAGE.' '.$articles_new_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$vamTemplate->assign('NAVIGATION_BAR_PAGES', $articles_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES_NEW));

}

$module_content = '';
if ($articles_new_split->number_of_rows > 0) {

	$vamTemplate->assign('no_new_articles', 'false');

	$articles_new_query = vam_db_query($articles_new_split->sql_query);
	while ($articles_new = vam_db_fetch_array($articles_new_query)) {

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&article='.vam_cleanName($articles_new['articles_name']);

		$SEF_parameter_author = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_author = '&author='.vam_cleanName($articles_new['authors_name']);

		$SEF_parameter_category = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_category = '&category='.vam_cleanName($articles_new['topics_name']);

		$module_content[] = array (
		
		'ARTICLE_NAME' => $articles_new['articles_name'],
		'ARTICLE_SHORT_DESCRIPTION' => $articles_new['articles_head_desc_tag'], 
		'ARTICLE_DATE' => vam_date_long($articles_new['articles_date_added']), 
		'ARTICLE_LINK' => vam_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $articles_new['articles_id'] . $SEF_parameter), 
		'AUTHOR_NAME' => $articles_new['authors_name'], 
		'AUTHOR_LINK' =>  vam_href_link(FILENAME_ARTICLES, 'authors_id=' . $articles_new['authors_id'] . $SEF_parameter_author), 
		'ARTICLE_CATEGORY_NAME' => $articles_new['topics_name'],
		'ARTICLE_CATEGORY_LINK' => vam_href_link(FILENAME_ARTICLES, 'tPath=' . $articles_new['topics_id'] . $SEF_parameter_category)
		
		);

	}
} else {

	$vamTemplate->assign('no_new_articles', 'true');

}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$vamTemplate->assign('module_content', $module_content);
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/articles_new.html');
$vamTemplate->assign('main_content', $main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_ARTICLES_NEW.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_ARTICLES_NEW.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>
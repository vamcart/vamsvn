<?php
/* -----------------------------------------------------------------------------------------
   $Id: articles.php 1292 2007-02-06 19:20:03 VaM $

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
// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed function
require_once (DIR_FS_INC.'xtc_date_long.inc.php');

// the following tPath references come from application_top.php
  $topic_depth = 'top';

  if (isset($tPath) && xtc_not_null($tPath)) {
    $topics_articles_query = "select count(*) as total from " . TABLE_ARTICLES_TO_TOPICS . " where topics_id = '" . (int)$current_topic_id . "'";
    $topics_articles_query = xtDBquery($topics_articles_query);
    $topics_articles = xtc_db_fetch_array($topics_articles_query);
    if ($topics_articles['total'] > 0) {
      $topic_depth = 'articles'; // display articles
    } else {
      $topic_parent_query = "select count(*) as total from " . TABLE_TOPICS . " where parent_id = '" . (int)$current_topic_id . "'";
      $topic_parent_query = xtDBquery($topic_parent_query);
      $topic_parent = xtc_db_fetch_array($topic_parent_query);
      if ($topic_parent['total'] > 0) {
        $topic_depth = 'nested'; // navigate through the topics
      } else {
        $topic_depth = 'articles'; // topic has no articles, but display the 'no articles' message
      }
    }
  }

  if ($topic_depth == 'top' && !isset($_GET['authors_id'])) {
    $breadcrumb->add(NAVBAR_TITLE_DEFAULT, xtc_href_link(FILENAME_ARTICLES));
  }

    $topic_query = xtc_db_query("select td.topics_name, td.topics_heading_title, td.topics_description from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.topics_id = '" . (int)$current_topic_id . "' and td.topics_id = '" . (int)$current_topic_id . "' and td.language_id = '" . (int)$languages_id . "'");
    $topic = xtc_db_fetch_array($topic_query);

    if (xtc_not_null($topic['topics_name'])) {
        $topic_name = $topic['topics_name'];
      } else {
        $topic_name = NAVBAR_TITLE_DEFAULT;
      }

	$smarty->assign('HEADER_TEXT', $topic_name);

    if (xtc_not_null($topic['topics_heading_title'])) {
	$smarty->assign('TOPICS_HEADING_TITLE', $topic['topics_heading_title']);
   }    
             
    if (xtc_not_null($topic['topics_description'])) {
	$smarty->assign('TOPICS_DESCRIPTION', $topic['topics_description']);
   }    
             
require (DIR_WS_INCLUDES.'header.php');

  if ($topic_depth == 'articles' || isset($_GET['authors_id'])) {

// show the articles of a specified author
    if (isset($_GET['authors_id'])) {
    
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and au.authors_id = '" . (int)$_GET['authors_id'] . "' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by a.articles_date_added desc, ad.articles_name";
    } else {
    
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and a2t.topics_id = '" . (int)$current_topic_id . "' order by a.articles_date_added desc, ad.articles_name";
    }

  } else {
 
  $listing_sql = "select a.articles_id, a.articles_date_added, a.articles_date_available, ad.articles_name, ad.articles_head_desc_tag, ad.articles_viewed, au.authors_id, au.authors_name, td.topics_id, td.topics_name from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' ORDER BY IF (`a`.`articles_date_available`,`a`.`articles_date_available`, `a`.`articles_date_added`) DESC";
}

$articles_split = new splitPageResults($listing_sql, $_GET['page'], MAX_ARTICLES_PER_PAGE);

if (($articles_split->number_of_rows > 0)) {
	$smarty->assign('NAVIGATION_BAR', '<span class="right">'.TEXT_RESULT_PAGE.' '.$articles_split->display_links(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array ('page', 'info', 'x', 'y'))) . '</span>' . $articles_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES));

}

$module_content = '';
if ($articles_split->number_of_rows > 0) {

	$smarty->assign('no_articles', 'false');

	$articles_query = xtc_db_query($articles_split->sql_query);
	while ($articles = xtc_db_fetch_array($articles_query)) {

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&article='.xtc_cleanName($articles['articles_name']);

		$SEF_parameter_author = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_author = '&author='.xtc_cleanName($articles['authors_name']);

		$SEF_parameter_category = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_category = '&category='.xtc_cleanName($articles['topics_name']);

		$module_content[] = array (
		
		'ARTICLE_NAME' => $articles['articles_name'],
		'ARTICLE_SHORT_DESCRIPTION' => $articles['articles_head_desc_tag'], 
		'ARTICLE_DATE' => xtc_date_long($articles['articles_date_added']), 
		'ARTICLE_LINK' => xtc_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $articles['articles_id'] . $SEF_parameter), 
		'AUTHOR_NAME' => $articles['authors_name'], 
		'AUTHOR_LINK' =>  xtc_href_link(FILENAME_ARTICLES, 'authors_id=' . $articles['authors_id'] . $SEF_parameter_author), 
		'ARTICLE_CATEGORY_NAME' => $articles['topics_name'],
		'ARTICLE_CATEGORY_LINK' => xtc_href_link(FILENAME_ARTICLES, 'tPath=' . $articles['topics_id'] . $SEF_parameter_category)
		
		);

	}
} else {

	$smarty->assign('no_articles', 'true');

}

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
$smarty->assign('module_content', $module_content);
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/articles.html');
$smarty->assign('main_content', $main_content);

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
if (!defined(RM))
$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>
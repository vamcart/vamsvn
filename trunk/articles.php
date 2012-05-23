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
// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed function
require_once (DIR_FS_INC.'vam_date_long.inc.php');

// the following tPath references come from application_top.php
  $topic_depth = 'top';

  if (isset($tPath) && vam_not_null($tPath)) {
    $topics_articles_query = "select count(*) as total from " . TABLE_ARTICLES_TO_TOPICS . " where topics_id = '" . (int)$current_topic_id . "'";
    $topics_articles_query = vamDBquery($topics_articles_query);
    $topics_articles = vam_db_fetch_array($topics_articles_query);
    if ($topics_articles['total'] > 0) {
      $topic_depth = 'articles'; // display articles
    } else {
      $topic_parent_query = "select count(*) as total from " . TABLE_TOPICS . " where parent_id = '" . (int)$current_topic_id . "'";
      $topic_parent_query = vamDBquery($topic_parent_query);
      $topic_parent = vam_db_fetch_array($topic_parent_query);
      if ($topic_parent['total'] > 0) {
        $topic_depth = 'nested'; // navigate through the topics
      } else {
        $topic_depth = 'articles'; // topic has no articles, but display the 'no articles' message
      }
    }
  }

  if ($topic_depth == 'top' && !isset($_GET['authors_id'])) {
    $breadcrumb->add(NAVBAR_TITLE_DEFAULT, vam_href_link(FILENAME_ARTICLES));
  }

    $topic_query = vam_db_query("select td.topics_name, td.topics_heading_title, td.topics_description from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.topics_id = '" . (int)$current_topic_id . "' and td.topics_id = '" . (int)$current_topic_id . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "'");
    $topic = vam_db_fetch_array($topic_query);

    if (vam_not_null($topic['topics_name'])) {
        $topic_name = $topic['topics_name'];
      } else {
        $topic_name = NAVBAR_TITLE_DEFAULT;
      }

	$vamTemplate->assign('HEADER_TEXT', $topic_name);

    if (vam_not_null($topic['topics_heading_title'])) {
	$vamTemplate->assign('TOPICS_HEADING_TITLE', $topic['topics_heading_title']);
   }    
             
    if (vam_not_null($topic['topics_description'])) {
	$vamTemplate->assign('TOPICS_DESCRIPTION', $topic['topics_description']);
   }    
             
require (DIR_WS_INCLUDES.'header.php');

  if ($topic_depth == 'articles' || isset($_GET['authors_id'])) {

// show the articles of a specified author
    if (isset($_GET['authors_id'])) {
    
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and au.authors_id = '" . (int)$_GET['authors_id'] . "' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by a.sort_order, ad.articles_name";
    } else {
    
        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and a2t.topics_id = '" . (int)$current_topic_id . "' order by a.sort_order, ad.articles_name";
    }

  } else {

        $listing_sql = "select a.articles_id, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_head_desc_tag, au.authors_name, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and a2t.topics_id = '" . (int)$current_topic_id . "' order by a.sort_order, ad.articles_name";
}

  if ($_GET['akeywords'] != ""){
  
  $_GET['akeywords'] = urldecode($_GET['akeywords']);
  
  if (isset($_GET['description'])) {
    $listing_sql = "select ad.articles_name, a.articles_date_added, a.articles_date_available, a.articles_id, ad.articles_description from " . TABLE_ARTICLES_DESCRIPTION . " ad inner join " . TABLE_ARTICLES . " a on ad.articles_id = a.articles_id where a.articles_status = '1' and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and (ad.articles_name like '%" . $_GET['akeywords'] . "%' or ad.articles_description like '%" . $_GET['akeywords'] . "%' or ad.articles_head_desc_tag like '%" . $_GET['akeywords'] . "%' or ad.articles_head_keywords_tag like '%" . $_GET['akeywords'] . "%' or ad.articles_head_title_tag like '%" . $_GET['akeywords'] . "%') order by ad.articles_name ASC";
  }  else {
    $listing_sql = "select ad.articles_name, a.articles_date_added, a.articles_date_available, a.articles_id, ad.articles_description from " . TABLE_ARTICLES_DESCRIPTION . " ad inner join " . TABLE_ARTICLES . " a on ad.articles_id = a.articles_id where a.articles_status='1' and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and (ad.articles_name like '%" . $_GET['akeywords'] . "%' or ad.articles_head_desc_tag like '%" . $_GET['akeywords'] . "%' or ad.articles_head_keywords_tag like '%" . $_GET['akeywords'] . "%' or ad.articles_head_title_tag like '%" . $_GET['akeywords'] . "%') order by a.sort_order, ad.articles_name ASC";
  }    
 }
 
  if ($topic_depth == 'top' || !isset($_GET['tPath'])) {
  	
  	  $listing_sql = "select a.articles_id, a.articles_date_added, a.articles_date_available, ad.articles_name, ad.articles_head_desc_tag, ad.articles_viewed, au.authors_id, au.authors_name, td.topics_id, td.topics_name from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' ORDER BY IF (`a`.`articles_date_available`,`a`.`articles_date_available`, `a`.`articles_date_added`) DESC";
  	  
  	}
 
$articles_split = new splitPageResults($listing_sql, $_GET['page'], MAX_ARTICLES_PER_PAGE);

if (($articles_split->number_of_rows > 0)) {
	$vamTemplate->assign('NAVIGATION_BAR', TEXT_RESULT_PAGE.' '.$articles_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$vamTemplate->assign('NAVIGATION_BAR_PAGES', $articles_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES));

}

$module_content = '';
if ($articles_split->number_of_rows > 0) {

	$vamTemplate->assign('no_articles', 'false');

	$articles_query = vam_db_query($articles_split->sql_query);
	while ($articles = vam_db_fetch_array($articles_query)) {

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&article='.vam_cleanName($articles['articles_name']);

		$SEF_parameter_author = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_author = '&author='.vam_cleanName($articles['authors_name']);

		$SEF_parameter_category = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_category = '&category='.vam_cleanName($articles['topics_name']);

		$module_content[] = array (
		
		'ARTICLE_NAME' => $articles['articles_name'],
		'ARTICLE_SHORT_DESCRIPTION' => $articles['articles_head_desc_tag'], 
		'ARTICLE_DATE' => vam_date_long($articles['articles_date_added']), 
		'ARTICLE_LINK' => vam_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $articles['articles_id'] . $SEF_parameter), 
		'AUTHOR_NAME' => $articles['authors_name'], 
		'AUTHOR_LINK' =>  vam_href_link(FILENAME_ARTICLES, 'authors_id=' . $articles['authors_id'] . $SEF_parameter_author), 
		'ARTICLE_CATEGORY_NAME' => $articles['topics_name'],
		'ARTICLE_CATEGORY_LINK' => vam_href_link(FILENAME_ARTICLES, 'tPath=' . $articles['topics_id'] . $SEF_parameter_category)
		
		);

	}
} else {

	$vamTemplate->assign('no_articles', 'true');

}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$vamTemplate->assign('module_content', $module_content);
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/articles.html');
$vamTemplate->assign('main_content', $main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_ARTICLES.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_ARTICLES.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>
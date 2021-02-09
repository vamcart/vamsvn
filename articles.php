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
require_once (DIR_FS_INC.'vam_date_short.inc.php');

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
    $breadcrumb->add(NAVBAR_TITLE_DEFAULT);
    //$breadcrumb->add(NAVBAR_TITLE_DEFAULT, vam_href_link(FILENAME_ARTICLES));
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
             
  if ($topic_depth == 'articles' || isset($_GET['authors_id'])) {

// show the articles of a specified author
    if (isset($_GET['authors_id'])) {
    
        $listing_sql = "select a.articles_id, a.articles_image, a.articles_keywords, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_viewed, ad.articles_head_desc_tag, ad.articles_description, au.authors_name, au.authors_image, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and au.authors_id = '" . (int)$_GET['authors_id'] . "' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by a.sort_order ASC, a.articles_date_added DESC";
    } else {
    
        $listing_sql = "select a.articles_id, a.articles_image, a.articles_keywords, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_viewed, ad.articles_head_desc_tag, ad.articles_description, au.authors_name, au.authors_image, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and a2t.topics_id = '" . (int)$current_topic_id . "' order by a.sort_order ASC, a.articles_date_added DESC";
    }

  } else {

  if (isset($_GET['authors_id'])) {

        $listing_sql = "select a.articles_id, a.articles_image, a.articles_keywords, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_viewed, ad.articles_head_desc_tag, ad.articles_description, au.authors_name, au.authors_image, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and au.authors_id = '" . (int)$_GET['authors_id'] . "' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by a.sort_order ASC, a.articles_date_added DESC";

} else {
        $listing_sql = "select a.articles_id, a.articles_image, a.articles_keywords, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_viewed, ad.articles_head_desc_tag, ad.articles_description, au.authors_name, au.authors_image, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and a2t.topics_id = '" . (int)$current_topic_id . "' order by a.sort_order ASC, a.articles_date_added DESC";

}

}

  if ($_GET['akeywords'] != ""){
  
  $_GET['akeywords'] = urldecode(vam_db_input($_GET['akeywords']));
  
  if (isset($_GET['description'])) {
    $listing_sql = "select ad.articles_name, a.articles_date_added, a.articles_image, a.articles_keywords, a.articles_date_available, a.articles_id, ad.articles_viewed, ad.articles_description from " . TABLE_ARTICLES_DESCRIPTION . " ad inner join " . TABLE_ARTICLES . " a on ad.articles_id = a.articles_id where a.articles_status = '1' and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and (ad.articles_name like '%" . $_GET['akeywords'] . "%' or ad.articles_description like '%" . $_GET['akeywords'] . "%' or ad.articles_head_desc_tag like '%" . $_GET['akeywords'] . "%' or ad.articles_head_keywords_tag like '%" . $_GET['akeywords'] . "%' or ad.articles_head_title_tag like '%" . $_GET['akeywords'] . "%' or a.articles_keywords like '%" . $_GET['akeywords'] . "%') order by a.sort_order ASC, a.articles_date_added DESC";
  }  else {
    $listing_sql = "select ad.articles_name, a.articles_date_added, a.articles_image, a.articles_keywords, a.articles_date_available, a.articles_id, ad.articles_viewed, ad.articles_description from " . TABLE_ARTICLES_DESCRIPTION . " ad inner join " . TABLE_ARTICLES . " a on ad.articles_id = a.articles_id where a.articles_status='1' and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and (ad.articles_name like '%" . $_GET['akeywords'] . "%' or ad.articles_head_desc_tag like '%" . $_GET['akeywords'] . "%' or ad.articles_head_keywords_tag like '%" . $_GET['akeywords'] . "%' or ad.articles_head_title_tag like '%" . $_GET['akeywords'] . "%' or a.articles_keywords like '%" . $_GET['akeywords'] . "%') order by a.sort_order ASC, a.articles_date_added DESC";
  }    
 } else {
 
  if ($topic_depth == 'top' || !isset($_GET['tPath'])) {
  	
  if (isset($_GET['authors_id'])) {

        $listing_sql = "select a.articles_id, a.articles_image, a.articles_keywords, a.authors_id, a.articles_date_added, ad.articles_name, ad.articles_viewed, ad.articles_head_desc_tag, ad.articles_description, au.authors_name, au.authors_image, td.topics_name, a2t.topics_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_status = '1' and au.authors_id = '" . (int)$_GET['authors_id'] . "' and a.articles_id = a2t.articles_id and ad.articles_id = a2t.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by a.sort_order ASC, a.articles_date_added DESC";

} else {  	
  	  $listing_sql = "select a.articles_id, a.articles_image, a.articles_keywords, a.articles_date_added, a.articles_date_available, ad.articles_name, ad.articles_head_desc_tag, ad.articles_description, ad.articles_viewed, au.authors_id, au.authors_image, au.authors_name, au.authors_image, td.topics_id, td.topics_name from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by a.sort_order ASC, a.articles_date_added DESC";

}
  	  
  	}
 }
$articles_split = new splitPageResults($listing_sql, $_GET['page'], MAX_ARTICLES_PER_PAGE);

if (($articles_split->number_of_rows > 0)) {
	$vamTemplate->assign('NAVIGATION_BAR', $articles_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$vamTemplate->assign('NAVIGATION_BAR_PAGES', $articles_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES));

}

if (($current_topic_id > 0)) {
  $tags_list_sql = "select a.articles_keywords, a.articles_id from ".TABLE_ARTICLES." as a, ".TABLE_ARTICLES_TO_TOPICS." as a2t where a2t.articles_id = a.articles_id and a2t.topics_id = ".$current_topic_id."";
} else {
  $tags_list_sql = "select a.articles_keywords, a.articles_id from ".TABLE_ARTICLES." as a, ".TABLE_ARTICLES_TO_TOPICS." as a2t where a2t.articles_id = a.articles_id";
}

  $tags_list_query = vamDBquery($tags_list_sql, true);
  if (vam_db_num_rows($tags_list_query, true) >= 1) {

    while ($tags_list = vam_db_fetch_array($tags_list_query, true)) {

    $manufacturer_sort .= ($tags_list['articles_keywords'] != '' ? $tags_list['articles_keywords'].',' : null);

    }

    $blacklist = array();
    $blacklist = explode(",",TAGS_BLACKLIST);
    
    $manufacturer_sort = str_replace(", ", ",", $manufacturer_sort);
    
    $manufacturer_sort = explode(",",$manufacturer_sort);
    
//echo var_dump($blacklist);    
  
//echo var_dump($manufacturer_sort);  

    foreach ($blacklist as $key => $value) {  
$keys = array_keys($manufacturer_sort,$value);
foreach($keys as $k) {
    unset($manufacturer_sort[$k]);
}
} 
    
    //foreach ($blacklist as $key => $value) {
//if (($key = array_search($value, $manufacturer_sort)) !== false) {
    //unset($manufacturer_sort[$key]);
//}
//} 

    $manufacturer_sort = array_unique($manufacturer_sort);

    //echo var_dump($manufacturer_sort);
    
  }

		$all_tags = $manufacturer_sort;
		$all_tags_data = array();
		$i = 0;

          	foreach ($all_tags as $tags_all) {
                $all_tags_data[] = array(
                'NAME' => trim($tags_all),
                'LINK' => vam_href_link(FILENAME_ARTICLES, 'akeywords='.rawurlencode(trim($tags_all))));
            $i++;
            }

//echo var_dump($all_tags_data);

	$vamTemplate->assign('ARTICLE_KEYWORDS', $articles['articles_keywords']);
	$vamTemplate->assign('ARTICLE_KEYWORDS_NUM', $i);
	$vamTemplate->assign('ARTICLE_KEYWORDS_ARRAY_TAGS', $all_tags_data);

if ($_GET['authors_id'] && $_GET['authors_id'] > 0) {

  $authors_image_sql = "select authors_name, authors_image from ".TABLE_AUTHORS." where authors_id = '".(int)$_GET['authors_id']."'";

  $authors_image_query = vamDBquery($authors_image_sql);
  $author_images = vam_db_fetch_array($authors_image_query,true);
	$vamTemplate->assign('AUTHOR_IMAGE', $author_images['authors_image']);
	$vamTemplate->assign('AUTHOR_NAME', $author_images['authors_name']);
}

$module_content = array();
if ($articles_split->number_of_rows > 0) {

	$vamTemplate->assign('no_articles', 'false');

	$articles_query = vam_db_query($articles_split->sql_query);

		$tags_data = array();

	while ($articles = vam_db_fetch_array($articles_query)) {

		$article_reviews_query = vamDBquery("select count(*) as total from ".TABLE_ARTICLE_REVIEWS." ar where ar.articles_id='".$articles['articles_id']."'");
		$article_reviews = vam_db_fetch_array($article_reviews_query, true);

		$author_reviews_query = vamDBquery("select count(*) as total from ".TABLE_AUTHOR_REVIEWS." au where au.authors_id='".$articles['authors_id']."'");
		$author_reviews = vam_db_fetch_array($author_reviews_query, true);

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&article='.vam_cleanName($articles['articles_name']);

		$SEF_parameter_author = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_author = '&author='.vam_cleanName($articles['authors_name']);

		$SEF_parameter_category = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_category = '&category='.vam_cleanName($articles['topics_name']);


$products_tags = explode (",", $articles['articles_keywords']);

    $blacklist = array();
    $blacklist = explode(",",TAGS_BLACKLIST);

    foreach ($blacklist as $key => $value) {  
$articles['articles_keywords'] = str_replace($value.",","",$articles['articles_keywords']);
} 

		$products_tags = explode (",", $articles['articles_keywords']);
		$tags_data = array();

          	foreach ($products_tags as $tags) {
                $tags_data[] = array(
                'NAME' => trim($tags),
                'LINK' => vam_href_link(FILENAME_ARTICLES, 'akeywords='.rawurlencode(trim($tags))));
        //$info->assign('tags_data', $tags_data);
            }

//echo var_dump($tags_data);


   $article_rating = null;
	$reviews_rating_query = vam_db_query("select count(*) as total, TRUNCATE(SUM(reviews_rating),2) as rating from ".TABLE_ARTICLE_REVIEWS." r, ".TABLE_ARTICLE_REVIEWS_DESCRIPTION." rd where r.articles_id = '".(int)$articles['articles_id']."' and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."' and rd.reviews_text !=''");
	$reviews_rating = vam_db_fetch_array($reviews_rating_query);
	if ($reviews_rating['total'] > 0 && $reviews_rating['rating'] > 0) {
	$article_rating = $reviews_rating['rating']/$reviews_rating['total'];
	}	

   $author_rating = null;
	$author_rating_query = vam_db_query("select count(*) as total, TRUNCATE(SUM(reviews_rating),2) as rating from ".TABLE_AUTHOR_REVIEWS." r, ".TABLE_AUTHOR_REVIEWS_DESCRIPTION." rd where r.authors_id = '".(int)$articles['authors_id']."' and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."' and rd.reviews_text !=''");
	$author_rating = vam_db_fetch_array($author_rating_query);
	if ($author_rating['total'] > 0 && $author_rating['rating'] > 0) {
	$author_rating = $author_rating['rating']/$author_rating['total'];
	}	

		$module_content[] = array (
		
		'ARTICLE_NAME' => $articles['articles_name'],
		'ARTICLE_ID' => $articles['articles_id'],
		'ARTICLE_REVIEWS' => $article_reviews['total'],
		'ARTICLE_VIEWS' => $articles['articles_viewed'],
		'ARTICLE_RATING' => number_format($article_rating),
		'ARTICLE_STAR_RATING' => vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.intval($article_rating).'.png', sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, intval($article_rating))),
		'ARTICLE_NAME' => $articles['articles_name'],
		'ARTICLE_IMAGE' => $articles['articles_image'],
		'ARTICLE_KEYWORDS' => $articles['articles_keywords'],
		'ARTICLE_KEYWORDS_ARRAY_TAGS' => $tags_data,
		'ARTICLE_KEYWORDS_ARRAY' => array($articles['articles_keywords']),
//		'ARTICLE_KEYWORDS_ARRAY' => explode(",", $articles['articles_keywords']),
		'ARTICLE_SHORT_DESCRIPTION' => $articles['articles_head_desc_tag'], 
		'ARTICLE_DESCRIPTION' => $articles['articles_description'], 
		'ARTICLE_DATE' => vam_date_short($articles['articles_date_added']), 
		'ARTICLE_LINK' => vam_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $articles['articles_id'] . $SEF_parameter), 
		'AUTHOR_NAME' => $articles['authors_name'], 
		'AUTHOR_IMAGE' => $articles['authors_image'], 
		'AUTHOR_ID' => $articles['authors_id'], 
		'AUTHOR_REVIEWS' => $author_reviews['total'],
		'AUTHOR_RATING' => intval($article_rating),
		'AUTHOR_STAR_RATING' => vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.intval($article_rating).'.png', sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, intval($article_rating))),
		'AUTHOR_LINK' =>  vam_href_link(FILENAME_ARTICLES, 'authors_id=' . $articles['authors_id'] . $SEF_parameter_author), 
		'ARTICLE_CATEGORY_NAME' => $articles['topics_name'],
		'ARTICLE_CATEGORY_LINK' => vam_href_link(FILENAME_ARTICLES, 'tPath=' . $articles['topics_id'] . $SEF_parameter_category)
		
		);

	}
} else {

	$vamTemplate->assign('no_articles', 'true');

   header("HTTP/1.1 404 Not Found");

}

include_once(DIR_WS_BOXES . 'articles.php');

$vamTemplate->assign('TOPICS', $box_content_articles);

require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$vamTemplate->assign('module_content', $module_content);
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/articles.html');
$vamTemplate->assign('main_content', $main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_ARTICLES.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_ARTICLES.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>
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
require_once (DIR_FS_INC.'vam_date_short.inc.php');

$breadcrumb->add(BOX_NEW_ARTICLES, vam_href_link(FILENAME_ARTICLES_NEW));

  $articles_new_array = array();
  $articles_new_query_raw = "select a.articles_id, a.articles_image, a.articles_keywords, a.sort_order, a.articles_date_added, ad.articles_name, ad.articles_viewed, ad.articles_head_desc_tag, au.authors_id, au.authors_image, au.authors_name, td.topics_id, td.topics_name from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int) $_SESSION['languages_id'] . "' and td.language_id = '" . (int) $_SESSION['languages_id'] . "' and a.articles_date_added > SUBDATE(now( ), INTERVAL '" . NEW_ARTICLES_DAYS_DISPLAY . "' DAY) order by a.articles_date_added";

$articles_new_split = new splitPageResults($articles_new_query_raw, $_GET['page'], MAX_NEW_ARTICLES_PER_PAGE);

if (($articles_new_split->number_of_rows > 0)) {
	$vamTemplate->assign('NAVIGATION_BAR', TEXT_RESULT_PAGE.' '.$articles_new_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$vamTemplate->assign('NAVIGATION_BAR_PAGES', $articles_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES_NEW));

}

  $tags_list_sql = "select articles_keywords, articles_id from ".TABLE_ARTICLES."";

  $tags_list_query = vamDBquery($tags_list_sql);
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

          	foreach ($all_tags as $tags_all) {
                $all_tags_data[] = array(
                'NAME' => trim($tags_all),
                'LINK' => vam_href_link(FILENAME_ARTICLES, 'akeywords='.trim($tags_all)));
            }

	$vamTemplate->assign('ARTICLE_KEYWORDS', $articles['articles_keywords']);
	$vamTemplate->assign('ARTICLE_KEYWORDS_ARRAY_TAGS', $all_tags_data);

if ($_GET['authors_id'] && $_GET['authors_id'] > 0) {

  $authors_image_sql = "select authors_name, authors_image from ".TABLE_AUTHORS." where authors_id = '".(int)$_GET['authors_id']."'";

  $authors_image_query = vamDBquery($authors_image_sql);
  $author_images = vam_db_fetch_array($authors_image_query,true);
	$vamTemplate->assign('AUTHOR_IMAGE', $author_images['authors_image']);
	$vamTemplate->assign('AUTHOR_NAME', $author_images['authors_name']);
}

$module_content = array();
if ($articles_new_split->number_of_rows > 0) {

	$vamTemplate->assign('no_new_articles', 'false');

	$articles_new_query = vam_db_query($articles_new_split->sql_query);

		$tags_data = array();
		
	while ($articles_new = vam_db_fetch_array($articles_new_query)) {

		$article_reviews_query = vamDBquery("select count(*) as total from ".TABLE_ARTICLE_REVIEWS." ar where ar.articles_id='".$articles_new['articles_id']."'");
		$article_reviews = vam_db_fetch_array($article_reviews_query, true);

		$author_reviews_query = vamDBquery("select count(*) as total from ".TABLE_AUTHOR_REVIEWS." au where au.authors_id='".$articles_new['authors_id']."'");
		$author_reviews = vam_db_fetch_array($author_reviews_query, true);

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&article='.vam_cleanName($articles_new['articles_name']);

		$SEF_parameter_author = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_author = '&author='.vam_cleanName($articles_new['authors_name']);

		$SEF_parameter_category = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_category = '&category='.vam_cleanName($articles_new['topics_name']);

$products_tags = explode (",", $articles_new['articles_keywords']);

    $blacklist = array();
    $blacklist = explode(",",TAGS_BLACKLIST);

    foreach ($blacklist as $key => $value) {  
$articles_new['articles_keywords'] = str_replace($value.",","",$articles_new['articles_keywords']);
} 

		$products_tags = explode (",", $articles_new['articles_keywords']);
		$tags_data = array();
		
          	foreach ($products_tags as $tags) {
                $tags_data[] = array(
                'NAME' => trim($tags),
                'LINK' => vam_href_link(FILENAME_ARTICLES, 'akeywords='.trim($tags)));
        //$info->assign('tags_data', $tags_data);
            }

//echo var_dump($tags_data);


   $article_rating = null;
	$reviews_rating_query = vam_db_query("select count(*) as total, TRUNCATE(SUM(reviews_rating),2) as rating from ".TABLE_ARTICLE_REVIEWS." r, ".TABLE_ARTICLE_REVIEWS_DESCRIPTION." rd where r.articles_id = '".(int)$articles_new['articles_id']."' and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."' and rd.reviews_text !=''");
	$reviews_rating = vam_db_fetch_array($reviews_rating_query);
	if ($reviews_rating['total'] > 0 && $reviews_rating['rating'] > 0) {
	$article_rating = $reviews_rating['rating']/$reviews_rating['total'];
	}	

   $author_rating = null;
	$author_rating_query = vam_db_query("select count(*) as total, TRUNCATE(SUM(reviews_rating),2) as rating from ".TABLE_AUTHOR_REVIEWS." r, ".TABLE_AUTHOR_REVIEWS_DESCRIPTION." rd where r.authors_id = '".(int)$articles_new['authors_id']."' and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."' and rd.reviews_text !=''");
	$author_rating = vam_db_fetch_array($author_rating_query);
	if ($author_rating['total'] > 0 && $author_rating['rating'] > 0) {
	$author_rating = $author_rating['rating']/$author_rating['total'];
	}	

		$module_content[] = array (
		
		'ARTICLE_NAME' => $articles_new['articles_name'],
		'ARTICLE_ID' => $articles_new['articles_id'],
		'ARTICLE_REVIEWS' => $article_reviews['total'],
		'ARTICLE_RATING' => $article_reviews['total'],
		'ARTICLE_VIEWS' => $articles_new['articles_viewed'],
		'ARTICLE_RATING' => intval($article_rating),
		'ARTICLE_STAR_RATING' => vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.intval($article_rating).'.gif', sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, intval($article_rating))),
		'ARTICLE_NAME' => $articles_new['articles_name'],
		'ARTICLE_NAME' => $articles_new['articles_name'],
		'ARTICLE_IMAGE' => $articles_new['articles_image'],
		'ARTICLE_KEYWORDS' => $articles_new['articles_keywords'],
		'ARTICLE_KEYWORDS_ARRAY_TAGS' => $tags_data,
		'ARTICLE_KEYWORDS_ARRAY' => array($articles_new['articles_keywords']),
//		'ARTICLE_KEYWORDS_ARRAY' => explode(",", $articles_new['articles_keywords']),
		'ARTICLE_SHORT_DESCRIPTION' => $articles_new['articles_head_desc_tag'], 
		'ARTICLE_DATE' => vam_date_short($articles_new['articles_date_added']), 
		'ARTICLE_LINK' => vam_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $articles_new['articles_id'] . $SEF_parameter), 
		'AUTHOR_NAME' => $articles_new['authors_name'], 
		'AUTHOR_IMAGE' => $articles_new['authors_image'], 
		'AUTHOR_ID' => $articles_new['authors_id'], 
		'AUTHOR_REVIEWS' => $author_reviews['total'],
		'AUTHOR_RATING' => intval($article_rating),
		'AUTHOR_STAR_RATING' => vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.intval($article_rating).'.gif', sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, intval($article_rating))),
		'AUTHOR_LINK' =>  vam_href_link(FILENAME_ARTICLES, 'authors_id=' . $articles_new['authors_id'] . $SEF_parameter_author), 
		'ARTICLE_CATEGORY_NAME' => $articles_new['topics_name'],
		'ARTICLE_CATEGORY_LINK' => vam_href_link(FILENAME_ARTICLES, 'tPath=' . $articles_new['topics_id'] . $SEF_parameter_category)
		
		);

	}
} else {

	$vamTemplate->assign('no_new_articles', 'true');

   header("HTTP/1.1 404 Not Found");

}

include_once(DIR_WS_BOXES . 'articles.php');

require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$vamTemplate->assign('module_content', $module_content);
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/articles_new.html');
$vamTemplate->assign('main_content', $main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_ARTICLES_NEW.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_ARTICLES_NEW.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>
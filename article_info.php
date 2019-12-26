<?php
/* -----------------------------------------------------------------------------------------
   $Id: article_info.php 1292 2007-02-06 19:20:03 VaM $

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

  $article_check_query = "select count(*) as total from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_status = '1' and a.articles_id = '" . (int)$_GET['articles_id'] . "' and ad.articles_id = a.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "'";
  $article_check_query = vamDBquery($article_check_query);
  $article_check = vam_db_fetch_array($article_check_query, true);

    $article_info_query = "select a.articles_id, a.articles_image, a.articles_keywords, a.articles_image, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, ad.articles_viewed, au.authors_name, au.authors_image from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_status = '1' and a.articles_id = '" . (int)$_GET['articles_id'] . "' and ad.articles_id = a.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "'";
    $article_info_query = vamDBquery($article_info_query);
    $article_info = vam_db_fetch_array($article_info_query, true);

    vam_db_query("update " . TABLE_ARTICLES_DESCRIPTION . " set articles_viewed = articles_viewed+1 where articles_id = '" . (int)$_GET['articles_id'] . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");

if ($article_check['total'] > 0) {

    $topics_query = vamDBquery("select t.topics_id, td.topics_name, t.parent_id from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.parent_id = '0' and t.topics_id = td.topics_id and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and t.topics_id = '" .$current_topic_id. "' order by sort_order, td.topics_name");
    $topics_name = vam_db_fetch_array($topics_query, true);

	$vamTemplate->assign('no_article', 'false');

		$SEF_parameter_author = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_author = '&author='.vam_cleanName($article_info['authors_name']);

$products_tags = explode (",", $article_info['articles_keywords']);

    $blacklist = array();
    $blacklist = explode(",",TAGS_BLACKLIST);

    foreach ($blacklist as $key => $value) {  
$article_info['articles_keywords'] = str_replace($value.",","",$article_info['articles_keywords']);
} 

//$products_tags = explode (",", $article_info['articles_keywords']);

		$tags_data = array();
		$i = 0;

          	foreach ($products_tags as $tags) {
                $tags_data[] = array(
                'NAME' => trim($tags),
                'LINK' => vam_href_link(FILENAME_ARTICLES, 'akeywords='.trim($tags)));
        //$info->assign('tags_data', $tags_data);
            $i++;
            }

//echo var_dump($tags_data);

		$article_reviews_query = vamDBquery("select count(*) as total from ".TABLE_ARTICLE_REVIEWS." ar where ar.articles_id='".$article_info['articles_id']."'");
		$article_reviews = vam_db_fetch_array($article_reviews_query, true);

		$author_reviews_query = vamDBquery("select count(*) as total from ".TABLE_AUTHOR_REVIEWS." au where au.authors_id='".$article_info['authors_id']."'");
		$author_reviews = vam_db_fetch_array($author_reviews_query, true);

		$SEF_parameter_cat = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_cat = '&category='.vam_cleanName($topics_name['topics_name']);

    $topics_link = vam_href_link(FILENAME_ARTICLES, 'tPath=' . $topics_name['topics_id'] . $SEF_parameter_cat);

	$vamTemplate->assign('ARTICLE_NAME', $article_info['articles_name']);
	$vamTemplate->assign('TOPICS_NAME', $topics_name['topics_name']);
	$vamTemplate->assign('TOPICS_LINK', $topics_link);
	$vamTemplate->assign('ARTICLE_ID', $article_info['articles_id']);
	$vamTemplate->assign('ARTICLE_REVIEWS', $article_reviews['total']);

	$reviews_rating_query = vam_db_query("select count(*) as total, TRUNCATE(SUM(reviews_rating),2) as rating from ".TABLE_ARTICLE_REVIEWS." r, ".TABLE_ARTICLE_REVIEWS_DESCRIPTION." rd where r.articles_id = '".(int)$article_info['articles_id']."' and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."' and rd.reviews_text !=''");
	$reviews_rating = vam_db_fetch_array($reviews_rating_query);
	if ($reviews_rating['total'] > 0 && $reviews_rating['rating'] > 0) {
	$article_rating = $reviews_rating['rating']/$reviews_rating['total'];
		
	$vamTemplate->assign('ARTICLE_RATING', number_format($article_rating,1));
	$vamTemplate->assign('ARTICLE_STAR_RATING', vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.intval($article_rating).'.gif', sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, intval($article_rating))));
	}

	$vamTemplate->assign('ARTICLE_LINK', vam_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $article_info['articles_id'] . $SEF_parameter));
	$vamTemplate->assign('ARTICLE_IMAGE', $article_info['articles_image']);
	$vamTemplate->assign('ARTICLE_KEYWORDS', $article_info['articles_keywords']);
	$vamTemplate->assign('ARTICLE_KEYWORDS_NUM', $i);
	$vamTemplate->assign('ARTICLE_KEYWORDS_ARRAY_TAGS', $tags_data);
	$vamTemplate->assign('ARTICLE_KEYWORDS_ARRAY', array($article_info['articles_keywords']));
	//$vamTemplate->assign('ARTICLE_KEYWORDS_ARRAY', explode(",", $article_info['articles_keywords']));
	$vamTemplate->assign('ARTICLE_DESCRIPTION', $article_info['articles_description']);
	$vamTemplate->assign('ARTICLE_VIEWED', $article_info['articles_viewed']);
	$vamTemplate->assign('ARTICLE_DATE', vam_date_short($article_info['articles_date_added']));
	$vamTemplate->assign('ARTICLE_URL', $article_info['articles_url']);
	$vamTemplate->assign('AUTHOR_NAME', $article_info['authors_name']);
	$vamTemplate->assign('AUTHOR_IMAGE', $article_info['authors_image']);
	$vamTemplate->assign('AUTHOR_ID', $article_info['authors_id']);
	$vamTemplate->assign('AUTHOR_REVIEWS', $author_reviews['total']);

	$vamTemplate->assign('ARTICLE_CATEGORY_NAME', $topics_name['topics_name']);
	$vamTemplate->assign('ARTICLE_CATEGORY_LINK', $topics_link);

	$author_rating_query = vam_db_query("select count(*) as total, TRUNCATE(SUM(reviews_rating),2) as rating from ".TABLE_AUTHOR_REVIEWS." r, ".TABLE_AUTHOR_REVIEWS_DESCRIPTION." rd where r.authors_id = '".(int)$article_info['authors_id']."' and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."' and rd.reviews_text !=''");
	$author_rating = vam_db_fetch_array($author_rating_query);
	if ($author_rating['total'] > 0 && $author_rating['rating'] > 0) {
	$author_rating = $author_rating['rating']/$author_rating['total'];
		
	$vamTemplate->assign('AUTHOR_RATING', number_format($author_rating,1));
	$vamTemplate->assign('AUTHOR_STAR_RATING', vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.intval($author_rating).'.gif', sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, intval($author_rating))));
	}

	$vamTemplate->assign('AUTHOR_LINK' , vam_href_link(FILENAME_ARTICLES, 'authors_id=' . $article_info['authors_id'] . $SEF_parameter_author));

include (DIR_WS_MODULES.FILENAME_ARTICLES_XSELL);


} else {

	$vamTemplate->assign('no_article', 'true');

   header("HTTP/1.1 404 Not Found");

}

require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$vamTemplate->assign('module_content', $module_content);
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/article_info.html');
$vamTemplate->assign('main_content', $main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_ARTICLE_INFO.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_ARTICLE_INFO.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>
 <?php
global $articles_category_id;

$module_listing = new vamTemplate;

$module_listing->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

if ((!isset ($articles_category_id)) || ($articles_category_id == '0')) {

$sql = "

select a.articles_id, a.articles_image, a.articles_keywords, a.sort_order, a.articles_date_added, 
ad.articles_name, ad.articles_description, ad.articles_viewed, ad.articles_head_desc_tag, 
au.authors_id, au.authors_image, au.authors_name, 
td.topics_id, td.topics_name 
from " . TABLE_ARTICLES . " a 
left join " . TABLE_AUTHORS . " au 
on a.authors_id = au.authors_id, " . TABLE_ARTICLES_TO_TOPICS . " a2t 
left join " . TABLE_TOPICS_DESCRIPTION . " td 
on a2t.topics_id = td.topics_id, " . TABLE_ARTICLES_DESCRIPTION . " ad 
where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) 
and a.articles_id = a2t.articles_id 
and a.articles_status = '1' 
and a.articles_id = ad.articles_id 
and ad.language_id = '" . (int) $_SESSION['languages_id'] . "' 
and td.language_id = '" . (int) $_SESSION['languages_id'] . "' 
ORDER BY articles_date_added DESC LIMIT " . MAX_NEW_ARTICLES_PER_PAGE . "

";

} else {

$sql = "

select a.articles_id, a.articles_image, a.articles_keywords, a.sort_order, a.articles_date_added, 
ad.articles_name, ad.articles_description, ad.articles_viewed, ad.articles_head_desc_tag 
from 
" . TABLE_ARTICLES . " a, 
" . TABLE_ARTICLES_DESCRIPTION . " ad,
" . TABLE_ARTICLES_TO_CATEGORIES . " a2c   
where a2c.categories_id = '" . $articles_category_id . "' 
and a2c.articles_id = a.articles_id 
and a.articles_id = ad.articles_id 
and ad.language_id = '" . (int) $_SESSION['languages_id'] . "' 
ORDER BY articles_date_added DESC LIMIT " . MAX_NEW_ARTICLES_PER_PAGE . "

";

}

$row = 0;

$module_listing_content = array ();

$query = vamDBquery($sql,true);

while ($articles_default = vam_db_fetch_array($query,true)) {

		$article_reviews_query = vamDBquery("select count(*) as total from ".TABLE_ARTICLE_REVIEWS." ar where ar.articles_id='".$articles_default['articles_id']."'");
		$article_reviews = vam_db_fetch_array($article_reviews_query, true);

		$author_reviews_query = vamDBquery("select count(*) as total from ".TABLE_AUTHOR_REVIEWS." au where au.authors_id='".$articles_default['authors_id']."'");
		$author_reviews = vam_db_fetch_array($author_reviews_query, true);

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&article='.vam_cleanName($articles_default['articles_name']);

		$SEF_parameter_author = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_author = '&author='.vam_cleanName($articles_default['authors_name']);

		$SEF_parameter_category = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_category = '&category='.vam_cleanName($articles_default['topics_name']);

$products_tags = explode (",", $articles_default['articles_keywords']);

    $blacklist = array();
    $blacklist = explode(",",TAGS_BLACKLIST);

    foreach ($blacklist as $key => $value) {  
$articles_default['articles_keywords'] = str_replace($value.",","",$articles_default['articles_keywords']);
} 

		$products_tags = explode (",", $articles_default['articles_keywords']);
		$tags_data = array();
		
          	foreach ($products_tags as $tags) {
                $tags_data[] = array(
                'NAME' => trim($tags),
                'LINK' => vam_href_link(FILENAME_ARTICLES, 'akeywords='.rawurlencode(trim($tags))));
        //$info->assign('tags_data', $tags_data);
            }

//echo var_dump($tags_data);


   $article_rating = null;
	$reviews_rating_query = vam_db_query("select count(*) as total, TRUNCATE(SUM(reviews_rating),2) as rating from ".TABLE_ARTICLE_REVIEWS." r, ".TABLE_ARTICLE_REVIEWS_DESCRIPTION." rd where r.articles_id = '".(int)$articles_default['articles_id']."' and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."' and rd.reviews_text !=''");
	$reviews_rating = vam_db_fetch_array($reviews_rating_query);
	if ($reviews_rating['total'] > 0 && $reviews_rating['rating'] > 0) {
	$article_rating = $reviews_rating['rating']/$reviews_rating['total'];
	}	

   $author_rating = null;
	$author_rating_query = vam_db_query("select count(*) as total, TRUNCATE(SUM(reviews_rating),2) as rating from ".TABLE_AUTHOR_REVIEWS." r, ".TABLE_AUTHOR_REVIEWS_DESCRIPTION." rd where r.authors_id = '".(int)$articles_default['authors_id']."' and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."' and rd.reviews_text !=''");
	$author_rating = vam_db_fetch_array($author_rating_query);
	if ($author_rating['total'] > 0 && $author_rating['rating'] > 0) {
	$author_rating = $author_rating['rating']/$author_rating['total'];
	}	

		$module_listing_content[] = array (
		
		'ARTICLE_NAME' => $articles_default['articles_name'],
		'ARTICLE_ID' => $articles_default['articles_id'],
		'ARTICLE_REVIEWS' => $article_reviews['total'],
		'ARTICLE_RATING' => $article_reviews['total'],
		'ARTICLE_VIEWS' => $articles_default['articles_viewed'],
		'ARTICLE_RATING' => intval($article_rating),
		'ARTICLE_STAR_RATING' => vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.intval($article_rating).'.gif', sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, intval($article_rating))),
		'ARTICLE_NAME' => $articles_default['articles_name'],
		'ARTICLE_NAME' => $articles_default['articles_name'],
		'ARTICLE_IMAGE' => $articles_default['articles_image'],
		'ARTICLE_KEYWORDS' => $articles_default['articles_keywords'],
		'ARTICLE_KEYWORDS_ARRAY_TAGS' => $tags_data,
		'ARTICLE_KEYWORDS_ARRAY' => array($articles_default['articles_keywords']),
//		'ARTICLE_KEYWORDS_ARRAY' => explode(",", $articles_default['articles_keywords']),
		'ARTICLE_SHORT_DESCRIPTION' => $articles_default['articles_head_desc_tag'], 
		'ARTICLE_DESCRIPTION' => $articles_default['articles_description'], 
		'ARTICLE_DATE' => vam_date_short($articles_default['articles_date_added']), 
		'ARTICLE_LINK' => vam_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $articles_default['articles_id'] . $SEF_parameter), 
		'AUTHOR_NAME' => $articles_default['authors_name'], 
		'AUTHOR_IMAGE' => $articles_default['authors_image'], 
		'AUTHOR_ID' => $articles_default['authors_id'], 
		'AUTHOR_REVIEWS' => $author_reviews['total'],
		'AUTHOR_RATING' => intval($article_rating),
		'AUTHOR_STAR_RATING' => vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.intval($article_rating).'.gif', sprintf(BOX_REVIEWS_TEXT_OF_5_STARS, intval($article_rating))),
		'AUTHOR_LINK' =>  vam_href_link(FILENAME_ARTICLES, 'authors_id=' . $articles_default['authors_id'] . $SEF_parameter_author), 
		'ARTICLE_CATEGORY_NAME' => $articles_default['topics_name'],
		'ARTICLE_CATEGORY_LINK' => vam_href_link(FILENAME_ARTICLES, 'tPath=' . $articles_default['topics_id'] . $SEF_parameter_category)
		
		);

}

if (sizeof($module_listing_content) > 0) {

$module_listing->assign('language', $_SESSION['language']);

//echo var_dump($module_listing_content);

$module_listing->assign('module_content',$module_listing_content);

// set cache ID

if (!CacheCheck()) {

$module_listing->caching = 0;

$module_listing= $module_listing->fetch(CURRENT_TEMPLATE.'/module/articles_product_listing.html');

} else {

$module_listing->caching = 1;

$module_listing->cache_lifetime=CACHE_LIFETIME;

$module_listing->cache_modified_check=CACHE_CHECK;

$module_listing = $module_listing->fetch(CURRENT_TEMPLATE.'/module/articles_product_listing.html',$cache_id);

}

$module->assign('MODULE_articles', $module_listing);

}

?>
<?php
/* -----------------------------------------------------------------------------------------
   $Id: reviews.php 1238 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(reviews.php,v 1.48 2003/05/27); www.oscommerce.com
   (c) 2003	 nextcommerce (reviews.php,v 1.12 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (reviews.php,v 1.12 2003/08/17); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'vam_word_count.inc.php');
require_once (DIR_FS_INC.'vam_date_long.inc.php');

$breadcrumb->add(NAVBAR_TITLE_SITE_REVIEWS, vam_href_link(FILENAME_SITE_REVIEWS));

require (DIR_WS_INCLUDES.'header.php');

if ($_SESSION['customers_status']['customers_status_read_reviews'] == 0) {
             vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));
}

$reviews_query_raw = "select r.*, rd.* from ".TABLE_SITE_REVIEWS." r, ".TABLE_SITE_REVIEWS_DESCRIPTION." rd where r.reviews_id = rd.reviews_id and rd.languages_id = '".(int) $_SESSION['languages_id']."' order by r.reviews_id DESC";
$reviews_split = new splitPageResults($reviews_query_raw, $_GET['page'], MAX_DISPLAY_NEW_REVIEWS);

if ($reviews_split->number_of_rows > 0) {

	$vamTemplate->assign('NAVBAR', $reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$vamTemplate->assign('NAVBAR_PAGES', $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS));

}

$module_data = array ();
if ($reviews_split->number_of_rows > 0) {
	$reviews_query = vam_db_query($reviews_split->sql_query);
	$star_rating = '';
	while ($reviews = vam_db_fetch_array($reviews_query)) {

		$star_rating = '';
		for($i=0;$i<number_format($reviews['reviews_rating']);$i++)	{
		$star_rating .= '<span class="rating"><i class="fa fa-star"></i></span> ';
		}
		
	   $avatar = DIR_WS_IMAGES.'avatars/'.$reviews['customers_avatar'];
if (!is_file($avatar)) $avatar = false;
		$module_data[] = array (
		
		'LINK' => vam_href_link(FILENAME_SITE_REVIEWS_INFO, 'reviews_id='.$reviews['reviews_id']), 
		'ID' => $reviews['reviews_id'], 
		'AUTHOR' => $reviews['customers_name'], 
		'AVATAR' => $avatar, 
		'DATE' => vam_date_short($reviews['date_added']), 
		'TEXT' => $reviews['reviews_text'], 
		'ANSWER' => $reviews['reviews_answer'], 
		'RATING' => $reviews['reviews_rating'],
		'STAR_RATING' => $star_rating,
		'RATING_IMG' => vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.$reviews['reviews_rating'].'.png', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating']))
		);

	}
	$vamTemplate->assign('module_content', $module_data);

}

	$vamTemplate->assign('ADD_REVIEW', '<a class="button btn btn-block" href="'.vam_href_link(FILENAME_SITE_REVIEWS_WRITE, $get_params).'">'.vam_image_button('add.png', IMAGE_BUTTON_WRITE_REVIEW).'</a>');

	if ($reviews_split->number_of_rows > 0) {

	$vamTemplate->assign('REVIEWS_TOTAL', $reviews_split->number_of_rows);

	$reviews_stat_query = vam_db_query("select count(*) as total, TRUNCATE(SUM(reviews_rating),2) as rating from ".TABLE_SITE_REVIEWS." r, ".TABLE_SITE_REVIEWS_DESCRIPTION." rd where r.products_id = '".(int)$products_id."' and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
	$reviews_stat = vam_db_fetch_array($reviews_stat_query);
	if (['total'] > 0 && $reviews_stat['rating'] > 0) {
	$total_rating = $reviews_stat['rating']/$reviews_stat['total'];
	}
		
	$vamTemplate->assign('REVIEWS_TOTAL_RATING', $total_rating);

	$stat_star_rating = '';
	for($i=0;$i<number_format($total_rating);$i++)	{
	$stat_star_rating .= '<span class="rating"><i class="fa fa-star"></i></span> ';
	}

	$vamTemplate->assign('REVIEWS_STAR_RATING', $stat_star_rating);
	
	$rating_count = $reviews_split->number_of_rows;
	
	$one_star_query = vamDBquery("select count(*) as total from ".TABLE_SITE_REVIEWS." r, ".TABLE_SITE_REVIEWS_DESCRIPTION." rd where r.reviews_rating = 1 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
	$one_star = vam_db_fetch_array($one_star_query,true);
	$one_star_count = $one_star['total'];
	
	$vamTemplate->assign('RATING_ONE', $one_star_count);
	$vamTemplate->assign('RATING_ONE_PERCENT', number_format(($one_star_count*100)/$rating_count));
	
	$two_star_query = vamDBquery("select count(*) as total from ".TABLE_SITE_REVIEWS." r, ".TABLE_SITE_REVIEWS_DESCRIPTION." rd where r.reviews_rating = 2 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
	$two_star = vam_db_fetch_array($two_star_query,true);
	$two_star_count = $two_star['total'];
	
	$vamTemplate->assign('RATING_TWO', $two_star_count);
	$vamTemplate->assign('RATING_TWO_PERCENT', number_format(($two_star_count*100)/$rating_count));
	
	$three_star_query = vamDBquery("select count(*) as total from ".TABLE_SITE_REVIEWS." r, ".TABLE_SITE_REVIEWS_DESCRIPTION." rd where r.reviews_rating = 3 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
	$three_star = vam_db_fetch_array($three_star_query,true);
	$three_star_count = $three_star['total'];
	
	$vamTemplate->assign('RATING_THREE', $three_star_count);
	$vamTemplate->assign('RATING_THREE_PERCENT', number_format(($three_star_count*100)/$rating_count));
	
	$four_star_query = vamDBquery("select count(*) as total from ".TABLE_SITE_REVIEWS." r, ".TABLE_SITE_REVIEWS_DESCRIPTION." rd where r.reviews_rating = 4 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
	$four_star = vam_db_fetch_array($four_star_query,true);
	$four_star_count = $four_star['total'];
	
	$vamTemplate->assign('RATING_FOUR', $four_star_count);
	$vamTemplate->assign('RATING_FOUR_PERCENT', number_format(($four_star_count*100)/$rating_count));
	
	$five_star_query = vamDBquery("select count(*) as total from ".TABLE_SITE_REVIEWS." r, ".TABLE_SITE_REVIEWS_DESCRIPTION." rd where r.reviews_rating = 5 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
	$five_star = vam_db_fetch_array($five_star_query,true);
	$five_star_count = $five_star['total'];
			
	$vamTemplate->assign('RATING_FIVE', $five_star_count);
	$vamTemplate->assign('RATING_FIVE_PERCENT', number_format(($five_star_count*100)/$rating_count));
	
	}

$vamTemplate->assign('language', $_SESSION['language']);

// set cache ID
 if (!CacheCheck()) {
	$vamTemplate->caching = 0;
	$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/site_reviews.html');
} else {
	$vamTemplate->caching = 1;
	$vamTemplate->cache_lifetime = CACHE_LIFETIME;
	$vamTemplate->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'].'_'.$_GET['page'];
	$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/site_reviews.html', $cache_id);
}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_SITE_REVIEWS.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_SITE_REVIEWS.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>
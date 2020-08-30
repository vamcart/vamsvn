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

$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

// include needed functions
require_once (DIR_FS_INC.'vam_word_count.inc.php');
require_once (DIR_FS_INC.'vam_date_long.inc.php');

if ($_SESSION['customers_status']['customers_status_read_reviews'] == 0) {
             return;
}

$reviews_query_raw = "select r.*, rd.* from ".TABLE_SITE_REVIEWS." r, ".TABLE_SITE_REVIEWS_DESCRIPTION." rd where r.reviews_id = rd.reviews_id and rd.languages_id = '".(int) $_SESSION['languages_id']."' order by r.reviews_id DESC";
$reviews_split = new splitPageResults($reviews_query_raw, $_GET['page'], MAX_DISPLAY_NEW_REVIEWS);

if ($reviews_split->number_of_rows > 0) {

	$module->assign('NAVBAR', TEXT_RESULT_PAGE.' '.$reviews_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
	$module->assign('NAVBAR_PAGES', $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS));

}

$module_content = array ();
if ($reviews_split->number_of_rows > 0) {
	$reviews_query = vam_db_query($reviews_split->sql_query);
	$num = 0;
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


   //echo var_dump($module_content);

	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $module_data);

   $module->assign('REVIEWS_ALL_LINK', vam_href_link(FILENAME_SITE_REVIEWS));
   $module->assign('REVIEWS_TOTAL', vam_db_num_rows(vamDBquery($reviews_query_raw,true)));
	
	// set cache ID
	 if (!CacheCheck()) {
		$module->caching = 0;
			$module = $module->fetch(CURRENT_TEMPLATE.'/module/site_reviews_all.html');
	} else {
		$module->caching = 1;
		$module->cache_lifetime = CACHE_LIFETIME;
		$module->cache_modified_check = CACHE_CHECK;
		$cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_name'].$_SESSION['currency'];
		$module = $module->fetch(CURRENT_TEMPLATE.'/module/site_reviews_all.html', $cache_id);
	}
		
	$default->assign('MODULE_site_reviews_all', $module);	
}

?>
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
require_once (DIR_FS_INC.'vam_date_long.inc.php');

  $article_check_query = "select count(*) as total from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_status = '1' and a.articles_id = '" . (int)$_GET['articles_id'] . "' and ad.articles_id = a.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "'";
  $article_check_query = vamDBquery($article_check_query);
  $article_check = vam_db_fetch_array($article_check_query, true);

    $article_info_query = "select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, ad.articles_viewed, au.authors_name from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_status = '1' and a.articles_id = '" . (int)$_GET['articles_id'] . "' and ad.articles_id = a.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "'";
    $article_info_query = vamDBquery($article_info_query);
    $article_info = vam_db_fetch_array($article_info_query, true);

    vam_db_query("update " . TABLE_ARTICLES_DESCRIPTION . " set articles_viewed = articles_viewed+1 where articles_id = '" . (int)$_GET['articles_id'] . "' and language_id = '" . (int)$_SESSION['languages_id'] . "'");

if ($article_check['total'] > 0) {

	$vamTemplate->assign('no_article', 'false');

		$SEF_parameter_author = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_author = '&author='.vam_cleanName($article_info['authors_name']);

	$vamTemplate->assign('ARTICLE_NAME', $article_info['articles_name']);
	$vamTemplate->assign('ARTICLE_DESCRIPTION', $article_info['articles_description']);
	$vamTemplate->assign('ARTICLE_VIEWED', $article_info['articles_viewed']);
	$vamTemplate->assign('ARTICLE_DATE', vam_date_long($article_info['articles_date_added']));
	$vamTemplate->assign('ARTICLE_URL', $article_info['articles_url']);
	$vamTemplate->assign('AUTHOR_NAME', $article_info['authors_name']);
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
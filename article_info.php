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
// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed function
require_once (DIR_FS_INC.'xtc_date_long.inc.php');

require (DIR_WS_INCLUDES.'header.php');

  $article_check_query = xtc_db_query("select count(*) as total from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_status = '1' and a.articles_id = '" . (int)$_GET['articles_id'] . "' and ad.articles_id = a.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "'");
  $article_check = xtc_db_fetch_array($article_check_query);

    $article_info_query = xtc_db_query("select a.articles_id, a.articles_date_added, a.articles_date_available, a.authors_id, ad.articles_name, ad.articles_description, ad.articles_url, au.authors_name from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_status = '1' and a.articles_id = '" . (int)$_GET['articles_id'] . "' and ad.articles_id = a.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "'");
    $article_info = xtc_db_fetch_array($article_info_query);

if ($article_check['total'] > 0) {

	$smarty->assign('no_article', 'false');

	$smarty->assign('ARTICLE_NAME', $article_info['articles_name']);
	$smarty->assign('ARTICLE_DESCRIPTION', $article_info['articles_description']);
	$smarty->assign('ARTICLE_DATE', xtc_date_long($article_info['articles_date_added']));
	$smarty->assign('ARTICLE_URL', xtc_href_link(FILENAME_REDIRECT, 'action=url&goto='.$article_info['articles_url'], 'NONSSL', true, false));
	$smarty->assign('AUTHOR_NAME', $article_info['authors_name']);
	$smarty->assign('AUTHOR_LINK' , xtc_href_link(FILENAME_ARTICLES, 'authors_id=' . $article_info['authors_id']));


} else {

	$smarty->assign('no_article', 'true');

}

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
$smarty->assign('module_content', $module_content);
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/article_info.html');
$smarty->assign('main_content', $main_content);

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
if (!defined(RM))
$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>
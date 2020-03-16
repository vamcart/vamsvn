<?php
/* -----------------------------------------------------------------------------------------
   $Id: news.php 831 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 osCommerce (privacy.php,v 1.2 2003/08/25); oscommerce.com
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  include( 'includes/application_top.php');

  // create template elements
  $vamTemplate = new vamTemplate;

  $_GET['news_id'] = (int)$_GET['news_id']; if ($_GET['news_id']<1) $_GET['news_id'] = 0;

  $all_sql = "
      SELECT
          news_id,
          headline,
          content,
          date_added
      FROM " . TABLE_LATEST_NEWS . "
      WHERE
          status = '1'
          and language = '" . (int)$_SESSION['languages_id'] . "'
      ORDER BY date_added DESC
      ";
  $one_sql = "
      SELECT
          news_id,
          headline,
          content,
          date_added
      FROM " . TABLE_LATEST_NEWS . "
      WHERE
          status = '1'
          and language = '" . (int)$_SESSION['languages_id'] . "'
          and news_id = " . $_GET['news_id'] . "
      ORDER BY date_added DESC
      LIMIT 1
      ";

  $module_content = array();
  if (!empty($_GET['news_id'])) {
      $query = vam_db_query($one_sql);
      if (vam_db_num_rows($query) == 0) { 
      $_GET['news_id'] = 0;
      header("HTTP/1.1 404 Not Found");
      }
  }
  if (empty($_GET['news_id'])) {
      $split = new splitPageResults($all_sql, $_GET['page'], MAX_DISPLAY_LATEST_NEWS_PAGE, 'news_id');
      $query = vam_db_query($split->sql_query);
      if (($split->number_of_rows > 0)) {
          $vamTemplate->assign('NAVIGATION_BAR', TEXT_RESULT_PAGE.' '.$split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))));
          $vamTemplate->assign('NAVIGATION_BAR_PAGES', $split->display_count(TEXT_DISPLAY_NUMBER_OF_LATEST_NEWS));
      }
      $vamTemplate->assign('ONE', false);
  } else {
      $vamTemplate->assign('ONE', true);
  }

  if (vam_db_num_rows($query) > 0) {
      while ($one = vam_db_fetch_array($query)) {

$qI=0; $qIcon='';
//echo strpos($one['content'],'src="')." ";
if ($qI=strpos($one['content'],'src="')) {
	$qI=$qI+5;
	$qIcon=substr ($one['content'] , $qI);
	$qI=strpos($qIcon,'"');
	$qIcon='<img width="80" src="'.substr ($qIcon, 0, $qI).'" />';
//echo "<pre>".$qIcon."</pre>";
}

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&headline='.vam_cleanName($one['headline']);

    $module_content[]=array(
              'NEWS_ICON' => $qIcon,
              'NEWS_HEADING' => $one['headline'],
              'NEWS_CONTENT' => $one['content'],
              'NEWS_ID'      => $one['news_id'],
              'NEWS_DATA'    => vam_date_short($one['date_added']),
              'NEWS_LINK_MORE'    => vam_href_link(FILENAME_NEWS, 'news_id='.$one['news_id'] . $SEF_parameter, 'NONSSL'),
              );
      }
  } else {
      $vamTemplate->assign('NAVIGATION_BAR', TEXT_NO_NEWS);
  }

  // include boxes
  require(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes.php'); 
  require(DIR_WS_INCLUDES . 'header.php');

  $vamTemplate->assign('NEWS_LINK', vam_href_link(FILENAME_NEWS));
  $vamTemplate->assign('language', $_SESSION['language']);
  $vamTemplate->caching = 0;
  $vamTemplate->assign('module_content',$module_content);
  $main_content=$vamTemplate->fetch(CURRENT_TEMPLATE . '/module/latest_news.html');

  $vamTemplate->assign('main_content',$main_content);
  $vamTemplate->assign('language', $_SESSION['language']);
  $vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_NEWS.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_NEWS.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
  include ('includes/application_bottom.php');
?>
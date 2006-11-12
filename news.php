<?php

  include( 'includes/application_top.php');

  // create smarty elements
  $smarty = new Smarty;

  // include boxes
  require(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes.php');

  $breadcrumb->add(NAVBAR_TITLE_NEWS, xtc_href_link(FILENAME_NEWS));

  require(DIR_WS_INCLUDES . 'header.php');

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
      $query = xtDBquery($one_sql);
      if (xtc_db_num_rows($query) == 0) $_GET['news_id'] = 0;
  }
  if (empty($_GET['news_id'])) {
      $split = new splitPageResults($all_sql, $_GET['page'], MAX_DISPLAY_LATEST_NEWS_PAGE, 'news_id');
      $query = xtc_db_query($split->sql_query);
      if (($split->number_of_rows > 0)) {
          $smarty->assign('NAVIGATION_BAR', '<span class="right">'.TEXT_RESULT_PAGE.' '.$split->display_links(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array ('page', 'info', 'x', 'y'))) . '</span>' .$split->display_count(TEXT_DISPLAY_NUMBER_OF_LATEST_NEWS));
      }
      $smarty->assign('ONE', false);
  } else {
      $smarty->assign('ONE', true);
  }

  if (xtc_db_num_rows($query) > 0) {
      while ($one = xtc_db_fetch_array($query)) {
          $module_content[]=array(
              'NEWS_HEADING' => $one['headline'],
              'NEWS_CONTENT' => $one['content'],
              'NEWS_ID'      => $one['news_id'],
              'NEWS_DATA'    => xtc_date_short($one['date_added']),
              'NEWS_LINK_MORE'    => xtc_href_link(FILENAME_NEWS, 'news_id='.$one['news_id'], 'NONSSL'),
              );
      }
  } else {
      $smarty->assign('NAVIGATION_BAR', TEXT_NO_NEWS);
  }

  $smarty->assign('NEWS_LINK', xtc_href_link(FILENAME_NEWS));
  $smarty->assign('language', $_SESSION['language']);
  $smarty->caching = 0;
  $smarty->assign('module_content',$module_content);
  $main_content=$smarty->fetch(CURRENT_TEMPLATE . '/module/latest_news.html');

  $smarty->assign('main_content',$main_content);
  $smarty->assign('language', $_SESSION['language']);
  $smarty->caching = 0;
  if (!defined(RM))
      $smarty->load_filter('output', 'note');
  $smarty->display(CURRENT_TEMPLATE . '/index.html');
?>
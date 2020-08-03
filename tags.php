<?php
/* -----------------------------------------------------------------------------------------
   $Id: tags.php 831 2007-04-02 19:20:03 VaM $

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

  // create smarty elements
  $vamTemplate = new vamTemplate;

  // include boxes
  require(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes.php');

  $breadcrumb->add(NAVBAR_TITLE_TAGS);

  $_GET['tags_id'] = (int)$_GET['tags_id']; if ($_GET['tags_id']<1) $_GET['tags_id'] = 0;

  $all_sql = "
      SELECT
          *
      FROM " . TABLE_TAGS . "
      WHERE
          status = '1'
          and language = '" . (int)$_SESSION['languages_id'] . "'
      ORDER BY sort_order ASC, date_added DESC
      ";
      
  if ($_GET['akeywords'] != ""){
  
  $_GET['akeywords'] = urldecode($_GET['akeywords']);
  
    $all_sql = "SELECT
          *
      FROM " . TABLE_TAGS . "
      WHERE status = '1' and language = '" . (int)$_SESSION['languages_id'] . "' and (tags_name like '%" . vam_db_input($_GET['akeywords']) . "%' or tags_title like '%" . vam_db_input($_GET['akeywords']) . "%') order by sort_order ASC, date_added DESC";

 }      
      
  $one_sql = "
      SELECT
          *
      FROM " . TABLE_TAGS . "
      WHERE
          status = '1'
          and language = '" . (int)$_SESSION['languages_id'] . "'
          and tags_id = " . $_GET['tags_id'] . "
      ORDER BY sort_order ASC, date_added DESC
      LIMIT 1
      ";

  $module_content = array();
  if (!empty($_GET['tags_id'])) {
      $query = vam_db_query($one_sql);
      if (vam_db_num_rows($query) == 0) { 
      $_GET['tags_id'] = 0;
      header("HTTP/1.1 404 Not Found");
      }      
  }
  if (empty($_GET['tags_id'])) {
      $split = new splitPageResults($all_sql, $_GET['page'], MAX_DISPLAY_TAGS_PAGE, 'tags_id');
      $query = vam_db_query($split->sql_query);
      if (($split->number_of_rows > 0)) {
          $vamTemplate->assign('NAVIGATION_BAR', '<span class="right">'.TEXT_RESULT_PAGE.' '.$split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))) . '</span>' .$split->display_count(TEXT_DISPLAY_NUMBER_OF_TAGS));
      } else {
   header("HTTP/1.1 404 Not Found");
}
      $vamTemplate->assign('ONE', false);
  } else {
      $vamTemplate->assign('ONE', true);
  }

  if (vam_db_num_rows($query) > 0) {
      while ($one = vam_db_fetch_array($query)) {

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&name='.vam_cleanName($one['name']);

          $module_content[]=array(
              'TAGS_NAME' => $one['tags_name'],
              'TAGS_TITLE' => $one['tags_title'],
              'TAGS_DESCRIPTION' => $one['tags_description'],
              'TAGS_ID'      => $one['tags_id'],
              'TAGS_URL'      => $one['tags_url'],
              'TAGS_DATE'    => vam_date_short($one['date_added']),
              'TAGS_LINK_MORE'    => vam_href_link(FILENAME_TAGS, 'tags_id='.$one['tags_id'] . $SEF_parameter, 'NONSSL'),
              );
      }
  } else {
      $vamTemplate->assign('NAVIGATION_BAR', TEXT_NO_TAGS);
  }

  require(DIR_WS_INCLUDES . 'header.php');

  $vamTemplate->assign('TAGS_LINK', vam_href_link(FILENAME_TAGS));
  $vamTemplate->assign('language', $_SESSION['language']);
  $vamTemplate->caching = 0;
  $vamTemplate->assign('module_content',$module_content);
  $main_content=$vamTemplate->fetch(CURRENT_TEMPLATE . '/module/tags.html');

  $vamTemplate->assign('main_content',$main_content);
  $vamTemplate->assign('language', $_SESSION['language']);
  $vamTemplate->caching = 0;
  if (!defined(RM))
      $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_TAGS.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_TAGS.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
  include ('includes/application_bottom.php');
?>
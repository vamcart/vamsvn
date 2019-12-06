<?php
/* -----------------------------------------------------------------------------------------
   $Id: faq.php 831 2007-04-02 19:20:03 VaM $

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

  $breadcrumb->add(NAVBAR_TITLE_FAQ, vam_href_link(FILENAME_FAQ));

  require(DIR_WS_INCLUDES . 'header.php');

  $_GET['faq_id'] = (int)$_GET['faq_id']; if ($_GET['faq_id']<1) $_GET['faq_id'] = 0;

  $all_sql = "
      SELECT
          faq_id,
          question,
          answer,
          date_added
      FROM " . TABLE_FAQ . "
      WHERE
          status = '1'
          and language = '" . (int)$_SESSION['languages_id'] . "'
      ORDER BY date_added DESC
      ";
      
  if ($_GET['akeywords'] != ""){
  
  $_GET['akeywords'] = urldecode($_GET['akeywords']);
  
    $all_sql = "SELECT
          faq_id,
          question,
          answer,
          date_added
      FROM " . TABLE_FAQ . "
      WHERE status = '1' and language = '" . (int)$_SESSION['languages_id'] . "' and (question like '%" . vam_db_input($_GET['akeywords']) . "%' or answer like '%" . vam_db_input($_GET['akeywords']) . "%') order by date_added DESC";

 }      
      
  $one_sql = "
      SELECT
          faq_id,
          question,
          answer,
          date_added
      FROM " . TABLE_FAQ . "
      WHERE
          status = '1'
          and language = '" . (int)$_SESSION['languages_id'] . "'
          and faq_id = " . $_GET['faq_id'] . "
      ORDER BY date_added DESC
      LIMIT 1
      ";

  $module_content = array();
  if (!empty($_GET['faq_id'])) {
      $query = vam_db_query($one_sql);
      if (vam_db_num_rows($query) == 0) { 
      $_GET['faq_id'] = 0;
      header("HTTP/1.1 404 Not Found");
      }      
  }
  if (empty($_GET['faq_id'])) {
      $split = new splitPageResults($all_sql, $_GET['page'], MAX_DISPLAY_FAQ_PAGE, 'faq_id');
      $query = vam_db_query($split->sql_query);
      if (($split->number_of_rows > 0)) {
          $vamTemplate->assign('NAVIGATION_BAR', '<span class="right">'.TEXT_RESULT_PAGE.' '.$split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y'))) . '</span>' .$split->display_count(TEXT_DISPLAY_NUMBER_OF_FAQ));
      }
      $vamTemplate->assign('ONE', false);
  } else {
      $vamTemplate->assign('ONE', true);
  }

  if (vam_db_num_rows($query) > 0) {
      while ($one = vam_db_fetch_array($query)) {

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&question='.vam_cleanName($one['question']);

          $module_content[]=array(
              'FAQ_QUESTION' => $one['question'],
              'FAQ_ANSWER' => $one['answer'],
              'FAQ_ID'      => $one['faq_id'],
              'FAQ_DATA'    => vam_date_short($one['date_added']),
              'FAQ_LINK_MORE'    => vam_href_link(FILENAME_FAQ, 'faq_id='.$one['faq_id'] . $SEF_parameter, 'NONSSL'),
              );
      }
  } else {
      $vamTemplate->assign('NAVIGATION_BAR', TEXT_NO_FAQ);
  }

  $vamTemplate->assign('FAQ_LINK', vam_href_link(FILENAME_FAQ));
  $vamTemplate->assign('language', $_SESSION['language']);
  $vamTemplate->caching = 0;
  $vamTemplate->assign('module_content',$module_content);
  $main_content=$vamTemplate->fetch(CURRENT_TEMPLATE . '/module/faq.html');

  $vamTemplate->assign('main_content',$main_content);
  $vamTemplate->assign('language', $_SESSION['language']);
  $vamTemplate->caching = 0;
  if (!defined(RM))
      $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_FAQ.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_FAQ.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
  include ('includes/application_bottom.php');
?>
<?php
/* -----------------------------------------------------------------------------------------
   $Id: admin.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com 
   (c) 2003	 nextcommerce (admin.php,v 1.12 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (admin.php,v 1.12 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  require_once (DIR_FS_INC.'vam_hide_session_id.inc.php');

$box = new vamTemplate;
$box_content='';
$flag='';

$box->assign('language', $_SESSION['language']);
// set cache ID
if (!CacheCheck()) {
	$cache=false;
	$box->caching = 0;
} else {
	$cache=true;
	$box->caching = 1;
	$box->cache_lifetime = CACHE_LIFETIME;
	$box->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'];
}

  $authors_query = "select authors_id, authors_name from " . TABLE_AUTHORS . " order by authors_name";
  $authors_query = vamDBquery($authors_query);
  $number_of_author_rows = vam_db_num_rows($authors_query,true);

if (!$box->isCached(CURRENT_TEMPLATE.'/boxes/box_authors.html', $cache_id) || !$cache) {

	$box->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

  if (vam_db_num_rows($authors_query,true) > 0) {
?>
<?php
    if ($number_of_author_rows <= MAX_DISPLAY_AUTHORS_IN_A_LIST) {
// Display a list
      $authors_list = '';
      while ($authors = vam_db_fetch_array($authors_query,true)) {

		$SEF_parameter_author = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_author = '&author='.vam_cleanName($authors['authors_name']);

        $authors_name = ((utf8_strlen($authors['authors_name']) > MAX_DISPLAY_AUTHOR_NAME_LEN) ? utf8_substr($authors['authors_name'], 0, MAX_DISPLAY_AUTHOR_NAME_LEN) . '..' : $authors['authors_name']);
        if (isset($_GET['authors_id']) && ($_GET['authors_id'] == $authors['authors_id'])) $authors_name = '<b>' . $authors_name .'</b>';
        $authors_list .= '<a href="' . vam_href_link(FILENAME_ARTICLES, 'authors_id=' . $authors['authors_id'] . $SEF_parameter_author) . '">' . $authors_name . '</a><br>';
      }

      $authors_list = utf8_substr($authors_list, 0, -4);

      $content_string .= $authors_list;
    } else {
// Display a drop-down
      $authors_array = array();
      if (MAX_AUTHORS_LIST < 2) {
        $authors_array[] = array('id' => '0', 'text' => PULL_DOWN_DEFAULT);
      }

      while ($authors = vam_db_fetch_array($authors_query,true)) {
        $authors_name = ((utf8_strlen($authors['authors_name']) > MAX_DISPLAY_AUTHOR_NAME_LEN) ? utf8_substr($authors['authors_name'], 0, MAX_DISPLAY_AUTHOR_NAME_LEN) . '..' : $authors['authors_name']);
        $authors_array[] = array('id' => $authors['authors_id'],
                                       'text' => $authors_name);
      }

      $content_string .= vam_draw_form('authors', vam_href_link(FILENAME_ARTICLES, '', 'NONSSL', false), 'get') . vam_draw_pull_down_menu('authors_id', $authors_array, (isset($_GET['authors_id']) ? $_GET['authors_id'] : ''), 'onchange="this.form.submit();" size="' . MAX_AUTHORS_LIST . '" style="width: 100%"') . vam_hide_session_id().'</form>';
}

?>
<?php
}

  
    $box->assign('BOX_CONTENT', $content_string);

}

if (!$cache) {
	$box_authors = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_authors.html');
} else {
	$box_authors = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_authors.html', $cache_id);
}

if (vam_db_num_rows($authors_query,true) > 0) {
   $vamTemplate->assign('box_AUTHORS',$box_authors);
}

?>
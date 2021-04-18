<?php
/* -----------------------------------------------------------------------------------------
   $Id: search.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(search.php,v 1.22 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (search.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (search.php,v 1.9 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
$box = new vamTemplate;
$box->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$box_content = '';

require_once (DIR_FS_INC.'vam_image_submit.inc.php');
require_once (DIR_FS_INC.'vam_hide_session_id.inc.php');

$box->assign('FORM_ACTION', vam_draw_form('search', vam_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get', 'class="w-100 d-none d-lg-flex autocomplete="off"').vam_hide_session_id());
$box->assign('INPUT_SEARCH', vam_draw_input_field('keywords', '', 'class="form-control" id="quick_find_keyword"'));
$box->assign('BUTTON_SUBMIT', vam_image_submit('search.png', IMAGE_BUTTON_SEARCH));
$box->assign('FORM_END', '</form>');
$box->assign('LINK_ADVANCED', vam_href_link(FILENAME_ADVANCED_SEARCH));
$box->assign('BOX_CONTENT', $box_content);

$box->assign('language', $_SESSION['language']);
// set cache ID
 if (!CacheCheck()) {
	$box->caching = 0;
	$box_search = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_search.html');
} else {
	$box->caching = 1;
	$box->cache_lifetime = CACHE_LIFETIME;
	$box->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$box_search = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_search.html', $cache_id);
}

$vamTemplate->assign('box_SEARCH', $box_search);
?>
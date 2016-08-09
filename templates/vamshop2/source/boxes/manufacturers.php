<?php
/* -----------------------------------------------------------------------------------------
   $Id: manufacturers.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturers.php,v 1.18 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (manufacturers.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (manufacturers.php,v 1.9 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
$box = new vamTemplate;
$box_content = '';

$box->assign('language', $_SESSION['language']);
// set cache ID
if (!CacheCheck()) {
	$cache = false;
	$box->caching = 0;
} else {
	$cache = true;
	$box->caching = 1;
	$box->cache_lifetime = CACHE_LIFETIME;
	$box->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'].(int) $_GET['manufacturers_id'];
}

	$manufacturers_query = "select distinct m.manufacturers_id, m.manufacturers_name from ".TABLE_MANUFACTURERS." as m, ".TABLE_PRODUCTS." as p where p.products_status='1' AND m.manufacturers_id=p.manufacturers_id order by m.manufacturers_name";

	$manufacturers_query = vamDBquery($manufacturers_query);

if (!$box->isCached(CURRENT_TEMPLATE.'/boxes/box_manufacturers.html', $cache_id) || !$cache) {
	$box->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

	// include needed funtions
	require_once (DIR_FS_INC.'vam_hide_session_id.inc.php');
	require_once (DIR_FS_INC.'vam_draw_form.inc.php');
	require_once (DIR_FS_INC.'vam_draw_pull_down_menu.inc.php');

	if (vam_db_num_rows($manufacturers_query, true) <= MAX_DISPLAY_MANUFACTURERS_IN_A_LIST) {
		// Display a list
		$manufacturers_list = '';
		while ($manufacturers = vam_db_fetch_array($manufacturers_query, true)) {
			$manufacturers_name = ((utf8_strlen($manufacturers['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? utf8_substr($manufacturers['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN).'..' : $manufacturers['manufacturers_name']);
			if (isset ($_GET['manufacturers_id']) && ($_GET['manufacturers_id'] == $manufacturers['manufacturers_id']))
				$manufacturers_name = '<b>'.$manufacturers_name.'</b>';
			$manufacturers_list .= '<a href="'.vam_href_link(FILENAME_DEFAULT, 'manufacturers_id='.$manufacturers['manufacturers_id']).'">'.$manufacturers_name.'</a><br />';
		}
		$box_content = $manufacturers_list;
	} else {
		// Display a drop-down
		$manufacturers_array = array ();
		if (MAX_MANUFACTURERS_LIST < 2) {
			$manufacturers_array[] = array ('id' => '', 'text' => PULL_DOWN_DEFAULT);
		}

		while ($manufacturers = vam_db_fetch_array($manufacturers_query, true)) {
			$manufacturers_name = ((utf8_strlen($manufacturers['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? utf8_substr($manufacturers['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN).'..' : $manufacturers['manufacturers_name']);
			$manufacturers_array[] = array ('id' => $manufacturers['manufacturers_id'], 'text' => $manufacturers_name);
		}

		$box_content = vam_draw_form('manufacturers', vam_href_link(FILENAME_DEFAULT, '', 'NONSSL', false), 'get').vam_draw_pull_down_menu('manufacturers_id', $manufacturers_array, $_GET['manufacturers_id'], 'onchange="this.form.submit();" size="'.MAX_MANUFACTURERS_LIST.'"').vam_hide_session_id().'</form>';

	}

	if ($box_content != '')
		$box->assign('BOX_CONTENT', $box_content);

}
// set cache ID
if (!$cache) {
	$box_manufacturers = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_manufacturers.html');
} else {
	$box_manufacturers = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_manufacturers.html', $cache_id);
}

if (vam_db_num_rows($manufacturers_query, true) > 0) {
$vamTemplate->assign('box_MANUFACTURERS', $box_manufacturers);
}

?>
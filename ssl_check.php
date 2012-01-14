<?php
/* -----------------------------------------------------------------------------------------
   $Id: ssl_check.php 1238 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ssl_check.php,v 1.1 2003/03/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (ssl_check.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (ssl_check.php,v 1.9 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');


$breadcrumb->add(NAVBAR_TITLE_SSL_CHECK, vam_href_link(FILENAME_SSL_CHECK));

require (DIR_WS_INCLUDES.'header.php');
$vamTemplate->assign('BUTTON_CONTINUE', '<a class="button" href="'.vam_href_link(FILENAME_DEFAULT).'">'.vam_image_button('submit.png', IMAGE_BUTTON_CONTINUE).'</a>');
$vamTemplate->assign('language', $_SESSION['language']);

// set cache ID
 if (!CacheCheck()) {
	$vamTemplate->caching = 0;
	$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/ssl_check.html');
} else {
	$vamTemplate->caching = 1;
	$vamTemplate->cache_lifetime = CACHE_LIFETIME;
	$vamTemplate->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/ssl_check.html', $cache_id);
}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_SSL_CHECK.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_SSL_CHECK.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>
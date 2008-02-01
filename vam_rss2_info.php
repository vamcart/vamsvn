<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_rss2_info.php 1238 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

// create template elements
$vamTemplate = new vamTemplate;

// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

$breadcrumb->add(NAVBAR_TITLE_RSS2_INFO);

require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('RSS2_INFO', TEXT_RSS2_INFO);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/vam_rss2_info.html');
$vamTemplate->assign('main_content', $main_content);
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_RSS2_INFO.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_RSS2_INFO.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);

include ('includes/application_bottom.php');
?>
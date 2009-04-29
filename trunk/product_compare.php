<?php
/* -----------------------------------------------------------------------------------------
   $Id: product_compare.php 1124 2009-04-29 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   for VaM Shop by Darth AleX
   
   input: GET,  products=ID,ID,ID - max 5 int

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create smarty elements
$vamTemplate = new vamTemplate;

require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC.'vam_get_download.inc.php');
require_once (DIR_FS_INC.'vam_delete_file.inc.php');
require_once (DIR_FS_INC.'vam_get_all_get_params.inc.php');
require_once (DIR_FS_INC.'vam_date_long.inc.php');
require_once (DIR_FS_INC.'vam_draw_hidden_field.inc.php');
require_once (DIR_FS_INC.'vam_image_button.inc.php');
require_once (DIR_FS_INC.'vam_draw_form.inc.php');
require_once (DIR_FS_INC.'vam_draw_input_field.inc.php');
require_once (DIR_FS_INC.'vam_image_submit.inc.php');

include (DIR_WS_MODULES.'product_compare.php');

require (DIR_WS_INCLUDES.'header.php');
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_PRODUCT_COMPARE.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_PRODUCT_COMPARE.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>
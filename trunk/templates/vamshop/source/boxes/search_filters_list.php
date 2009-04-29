<?php
/* -----------------------------------------------------------------------------------------
   $Id: search_filters_list.php 1262 2009-04-29 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// reset var
$box = new vamTemplate;
$box_content='';
$flag='';
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

$box_content = MY_BOX_CONTENT;

$box->assign('categories_id', intval($_GET['cat']));
$box->assign('module_content', $params_list);
$box->assign('price_min', $_GET['price_min']);
$box->assign('price_max', $_GET['price_max']);
$box->assign('current_filters', $current_filters);

if ($flag==true) define('SEARCH_ENGINE_FRIENDLY_URLS',true);

$box->caching = 0;
$box->assign('language', $_SESSION['language']);
$box_admin= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_search_filters_list.html');
$vamTemplate->assign('box_SEARCH_FILTERS_LIST',$box_admin);

?>
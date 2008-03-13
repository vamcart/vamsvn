<?php
/* -----------------------------------------------------------------------------------------
   $Id: articles_xsell.php 1243 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(also_purchased_products.php,v 1.21 2003/02/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (also_purchased_products.php,v 1.9 2003/08/17); www.nextcommerce.org 
   (c) 2004 xt:Commerce (also_purchased_products.php,v 1.9 2005/10/25); xt-commerce.com 
   ---------------------------------------------------------------------------------------*/

if ($_GET['articles_id']) {

$xsell_query = vamDBquery("select distinct a.products_id, a.products_fsk18, ad.products_name, ad.products_short_description, a.products_image, a.products_price, a.products_vpe, a.products_quantity, a.products_vpe_status, a.products_vpe_value, a.products_tax_class_id, a.products_date_added from " . TABLE_ARTICLES_XSELL . " ax, " . TABLE_PRODUCTS . " a, " . TABLE_PRODUCTS_DESCRIPTION . " ad where ax.articles_id = '" . $_GET['articles_id'] . "' and ax.xsell_id = a.products_id and a.products_id = ad.products_id and ad.language_id = '" . $_SESSION['languages_id'] . "' and a.products_status = '1' order by ax.sort_order asc limit " . MAX_DISPLAY_ALSO_PURCHASED);
$num_products_xsell = vam_db_num_rows($xsell_query, true); 
if ($num_products_xsell >= MIN_DISPLAY_ALSO_PURCHASED) {

$module_content = array ();

      while ($xsell = vam_db_fetch_array($xsell_query,true)) {
			$module_content[] = $product->buildDataArray($xsell);
      }

$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
//выводит Также рекомендуем следующие товары:
if (sizeof($module_content) > 0) { 
    $module->assign('language', $_SESSION['language']);
    $module->assign('module_content', $module_content);
    // set cache ID
    $module->caching = 0;
    $module = $module->fetch(CURRENT_TEMPLATE.'/module/articles_xsell.html');
    $vamTemplate->assign('MODULE_articles_xsell', $module);
  }
 }
}

?>
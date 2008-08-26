<?php
/* -----------------------------------------------------------------------------------------
   $Id: categories.php 1302 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (categories.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (categories.php,v 1.10 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------
	BITTE BEACHTEN SIE: 

	1) Der Einsatz dieser Kategorien-Navi geschieht auf eigene Gefahr! 
	2) Jegliche Haftung fьr Schдden an Ihrem System oder Verdienst-
	Ausfдlle wird abgelehnt 
	3) Ich empfehle dringend, diese Erweiterung VOR einem produktiven
	Einsatz zunдchst an einem Test-System auszuprobieren!
  ---------------------------------------------------------------------------------------
	IN EIGENER SACHE:
	
	Diese Funktionen wurden kostenlos und ohne Anspruch auf Gegen-
	leistung zur Verfьgung gestellt. Ich bitte allerdings darum, den 
	Autoren-Hinweis intakt zu lassen bzw. bei Bearbeitungen mit zu 
	ьbernehmen. 
	
	Ein Backlink zu meiner Website http://www.gunnart.de wьrde mich 
	natьrlich auch freuen.
	
	Vielen Dank
	
	Gunnar Tillmann 
  ---------------------------------------------------------------------------------------
	Feedback is Welcome: http://www.gunnart.de?p=311
  ---------------------------------------------------------------------------------------
*/	

// reset var
$box = new vamTemplate;
$box_content = '';
$id = '';
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

// include needed functions
require_once(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/inc/vam_show_category.inc.php');
require_once(DIR_FS_INC . 'vam_has_category_subcategories.inc.php');
require_once(DIR_FS_INC . 'vam_count_products_in_category.inc.php');


$categories_string = '';
if (GROUP_CHECK == 'true') {
	$group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 "; 
 } else { $group_check=''; }

$categories_query = vamDBquery(	"select c.categories_id,
									cd.categories_name,
									c.parent_id from " .
									TABLE_CATEGORIES . " c, " .
									TABLE_CATEGORIES_DESCRIPTION . " cd
									where c.categories_status = '1'
									".$group_check."
									and c.categories_id = cd.categories_id
									and cd.language_id='" . (int)$_SESSION['languages_id'] ."'
									order by sort_order, cd.categories_name");

      if (vam_db_num_rows($categories_query,true)) {

while ($categories = vam_db_fetch_array($categories_query,true))  {
	$foo[$categories['categories_id']] = array(	'name' => $categories['categories_name'],
												'parent' => $categories['parent_id']);
}
 
vam_show_category(0, 0, $foo, '');

// NaviListe bekommt die ID "CatNavi"
$CatNaviStart = "\n<ul id=\"CatNavi\">\n";

// Hдtte man auch einfacher machen kцnnen, aber mit Tabulatoren ist schicker.
// AuЯerdem kann man so leichter nachprьfen, ob auch wirklich alles korrekt lдuft.
for ($counter = 1; $counter < $old_level+1; $counter++) {
	$CatNaviEnd .= "</li>\n".str_repeat("\t", $old_level - $counter)."</ul>\n";
	if ($old_level - $counter > 0)
		$CatNaviEnd .= str_repeat("\t", ($old_level - $counter)-1);
}

      }

// Fertige Liste zusammensetzen
$box->assign('BOX_CONTENT', $CatNaviStart.$categories_string.$CatNaviEnd);
$box->assign('language', $_SESSION['language']);
// Jibbie - darauf einen Dujardin

// Viele, viele bunte Smarties
if (USE_CACHE=='false') {
	$box->caching = 0;
	$box_categories= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_categories.html');
} else {
	$box->caching = 1;
	$box->cache_lifetime=CACHE_LIFETIME;
	$box->cache_modified_check=CACHE_CHECK;
	$cache_id = $_SESSION['language'].$_GET['cPath'];
	$box_categories= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_categories.html',$cache_id);
}
$vamTemplate->assign('box_CATEGORIES',$box_categories);
?>
<?php
/* -----------------------------------------------------------------------------------------
   $Id: news.php 1292 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_products.php,v 1.33 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (new_products.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (new_products.php,v 1.9 2003/08/17); www.xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

$sql = "
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
    LIMIT " . MAX_DISPLAY_FAQ . "
    ";

$row = 0;
$module_content = array ();

$query = vamDBquery($sql);
while ($one = vam_db_fetch_array($query,true)) {

$qI=0; $qIcon='';
//echo strpos($one['content'],'src="')." ";
if ($qI=strpos($one['content'],'src="')) {
	$qI=$qI+5;
	$qIcon=substr ($one['content'] , $qI);
	$qI=strpos($qIcon,'"');
	$qIcon= substr($qIcon, 0, $qI);
//echo "<pre>".$qIcon."</pre>";
}

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&headline='.vam_cleanName($one['headline']);

    $module_content[]=array(
        'FAQ_ICON' => $qIcon,
        'FAQ_QUESTION' => $one['question'],
        'FAQ_ANSWER' => $one['answer'],
        'FAQ_ID'      => $one['faq_id'],
        'FAQ_DATA'    => vam_date_short($one['date_added']),
        'FAQ_LINK_MORE'    => vam_href_link(FILENAME_FAQ, 'faq_id='.$one['faq_id'] . $SEF_parameter, 'NONSSL'),
        );

}
if (sizeof($module_content) > 0) {
    $module->assign('FAQ_LINK', vam_href_link(FILENAME_FAQ));
    $module->assign('language', $_SESSION['language']);
    $module->assign('module_content',$module_content);
	
	// set cache ID
	 if (!CacheCheck()) {
		$module->caching = 0;
      $module= $module->fetch(CURRENT_TEMPLATE.'/module/faq_default.html');
	} else {
        $module->caching = 1;
        $module->cache_lifetime=CACHE_LIFETIME;
        $module->cache_modified_check=CACHE_CHECK;
        $module = $module->fetch(CURRENT_TEMPLATE.'/module/faq_default.html',$cache_id);
	}
	$default->assign('MODULE_faq', $module);
}
?>
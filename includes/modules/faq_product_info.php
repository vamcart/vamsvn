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

global $faq_category_id;

$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

if ((!isset ($faq_category_id)) || ($faq_category_id == '0')) {
	
$sql_faq = "
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

} else {

$sql_faq = "
    SELECT
        f.faq_id,
        f.question,
        f.answer,
        f.date_added
    FROM " . TABLE_FAQ . " f , " . TABLE_FAQ_TO_PRODUCTS . " f2c
    WHERE
         f2c.products_id = '" . (int)$faq_category_id . "'
         and f.faq_id = f2c.faq_id 
         and f.status = '1'
         and f.language = '" . (int)$_SESSION['languages_id'] . "'
    ORDER BY f.date_added DESC
    LIMIT " . MAX_DISPLAY_FAQ . "
    ";
    
}

$row = 0;
$module_content_faq = array ();

$query_faq = vamDBquery($sql_faq);
while ($one_faq = vam_db_fetch_array($query_faq,true)) {

$faqI=0; $faqIcon='';
//echo strpos($one_faq['answer'],'src="')." ";
if ($faqI=strpos($one_faq['answer'],'src="')) {
	$faqI=$faqI+5;
	$faqIcon=substr ($one_faq['answer'] , $faqI);
	$faqI=strpos($faqIcon,'"');
	$faqIcon= substr($faqIcon, 0, $faqI);
//echo "<pre>".$qIcon."</pre>";
}

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&headline='.vam_cleanName($one_faq['question']);

    $module_content_faq[]=array(
        'FAQ_ICON' => $faqIcon,
        'FAQ_QUESTION' => $one_faq['question'],
        'FAQ_ANSWER' => $one_faq['answer'],
        'FAQ_ID'      => $one_faq['faq_id'],
        'FAQ_DATA'    => vam_date_short($one_faq['date_added']),
        'FAQ_LINK_MORE'    => vam_href_link(FILENAME_FAQ, 'faq_id='.$one_faq['faq_id'] . $SEF_parameter, 'NONSSL'),
        );

}
if (sizeof($module_content_faq) > 0) {
    $module->assign('FAQ_LINK', vam_href_link(FILENAME_FAQ));
    $module->assign('language', $_SESSION['language']);
    $module->assign('module_content',$module_content_faq);
	
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
	$info->assign('MODULE_faq', $module);
}
?>
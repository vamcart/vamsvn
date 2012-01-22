<?php
/* -----------------------------------------------------------------------------------------
   $Id: faq.php 1262 2007-04-02 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$box = new vamTemplate;
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

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

$module_content = array();
$query = vamDBquery($sql);
while ($one = vam_db_fetch_array($query,true)) {

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&question='.vam_cleanName($one['question']);

    $module_content[]=array(
        'FAQ_QUESTION' => $one['question'],
        'FAQ_ANSWER' => $one['answer'],
        'FAQ_ID'      => $one['faq_id'],
        'FAQ_DATA'    => vam_date_short($one['date_added']),
        'FAQ_LINK_MORE'    => vam_href_link(FILENAME_FAQ, 'faq_id='.$one['faq_id'] . $SEF_parameter, 'NONSSL'),
        );
}

if (sizeof($module_content) > 0) {
    $box->assign('FAQ_LINK', vam_href_link(FILENAME_FAQ));
    $box->assign('language', $_SESSION['language']);
    $box->assign('module_content',$module_content);
    // set cache ID
    if (USE_CACHE=='false') {
        $box->caching = 0;
        $module= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_faq.html');
    } else {
        $box->caching = 1;
        $box->cache_lifetime=CACHE_LIFETIME;
        $box->cache_modified_check=CACHE_CHECK;
        $module = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_faq.html',$cache_id);
    }
    $vamTemplate->assign('box_FAQ',$module);
}
?>
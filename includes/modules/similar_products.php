<?php
$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
// include needed files

if (SIMILAR_PRODUCTS == 'true') {
$data = $product->getSimilarProducts();
 
if (count($data) >= 1) {
    //print_r(array($data[0]));
	$module->assign('language', $_SESSION['language']);
	$module->assign('similar_products', $data);
	// set cache ID

	$module->caching = 0;
	$module = $module->fetch(CURRENT_TEMPLATE.'/module/similar_products.html');

	$info->assign('MODULE_similar_products', $module);

}
}
?>
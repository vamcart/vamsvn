<?php
$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
// include needed files

if (POHOZHIE_TOVARY == 'true') {
$data = $product->getPohozhieTovary();
 
if (count($data) >= 1) {
    //print_r(array($data[0]));
	$module->assign('language', $_SESSION['language']);
	$module->assign('pohozhie_tovary', $data);
	// set cache ID

	$module->caching = 0;
	$module = $module->fetch(CURRENT_TEMPLATE.'/module/pohozhie_tovary.html');

	$info->assign('MODULE_pohozhie_tovary', $module);

}
}
?>
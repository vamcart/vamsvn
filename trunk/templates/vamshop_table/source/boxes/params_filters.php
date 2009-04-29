<?php
/* -----------------------------------------------------------------------------------------
   $Id: params_filters.php 1262 2009-04-29 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require_once(DIR_WS_FUNCTIONS."params_filters.php");

$categories_id = intval($_GET['cat']);
$parametersNames = getAllParameters($categories_id);
$selected = get_selected();
$selectedGroups = get_selected_groups( $selected );
//$items = get_products($categories_id, $selectedGroups);
$filterParams = get_parameters_by_categories($categories_id);

$query = $_GET['q'];
if(empty($query))
{ $blocks = array(); }
else { $blocks = split('-', $query );}
//print "<pre>";
//print_r($filterParams);
//*

$selectedParamsFilters = array();
$j = 0;
foreach($selected as $block => $blockItems)
{
	for($i = 0; $i < count($blockItems); $i++)
	{		
		if(in_array( $blockItems[$i]["products_parameters_values_id"], $blocks) ){
			$set_query = str_replace("-".$blockItems[$i]["products_parameters_values_id"]."-", "-", "-".$query."-");
			$set_query = str_replace("--", "-", $set_query);
			$set_query = trim($set_query, "-");
		}else{
			$set_query = $query;
		}	
		$blockItems[$i]['set_query'] = $set_query;
	}
	$selectedParamsFilters[$j]["name"] = $parametersNames[$block];
	$selectedParamsFilters[$j]["list"] = $blockItems;
	$j++;
}


$mainParamsFilters = array();
for($i = 0; $i < count($filterParams); $i++)
{
	$values = get_parameters_block( $filterParams[$i]["products_parameters_id"] , $selectedGroups);
	if( count($values) == 0 )
	{
		continue;
	}
	for($j = 0; $j < count($values); $j++)
	{
		if(!in_array( $values[$j]["products_parameters_values_id"], $blocks) ){
			$set_query = $query.'-'.$values[$j]["products_parameters_values_id"];
			$set_query = str_replace("--", "-", $set_query);
			$set_query = trim($set_query, "-");
		}else{
			$set_query = $query;
		}
		$znak = ( array_key_exists( $filterParams[$i]["products_parameters_id"], $selectedGroups)) ? "+" : "" ;
		$values[$j]['znak'] = $znak;
		$values[$j]['set_query'] = $set_query;
	}
	$mainParamsFilters[$i] = $filterParams[$i];
	$mainParamsFilters[$i]['blockValues'] = $values;
}
//print_r($filterParams);
//*/
//print "</pre>";

// reset var
$box = new vamTemplate;
$box_content='';
$flag='';
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
$is_params_selected = ( count($selectedParamsFilters) > 0) ? true : false;
$box->assign('categories_id', $categories_id);
$box->assign('is_params_selected', $is_params_selected);
$box->assign('filterParams', $mainParamsFilters);
$box->assign('selectedParamsFilters', $selectedParamsFilters);

$box->caching = 0;
$box->assign('language', $_SESSION['language']);
$box_admin= $box->fetch(CURRENT_TEMPLATE.'/boxes/params_filters.html');
$vamTemplate->assign('box_PARAMS_FILTERS',$box_admin);

?>
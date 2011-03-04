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
 
//$categories_id = intval($_GET['cat']);
$categories_id = intval($current_category_id);
$parametersNames = getAllParameters($categories_id);

$selected = get_selected();
//var_dump($selected);
$selectedGroups = get_selected_groups( $selected );

//$items = get_products($categories_id, $selectedGroups);
$filterParams = get_parameters_by_categories($categories_id);

$query = $_GET['q'];
$query1 = $_GET['p'];
if(empty($query))
{ $blocks = array(); }
else { $blocks = preg_split('/-/', $query );}  
if(empty($query1))
{ $blocks1 = array(); }
else { $blocks1 = preg_split('/-/', $query1 );}
//print "<pre>";
//print_r($filterParams);
//*
$price_query = "";
if(isset($_GET['price_min']) && intval($_GET['price_min']) != 0 )
{
    $price_query .= "&price_min=".intval($_GET['price_min']);
}
if(isset($_GET['price_max']) && intval($_GET['price_max']) != 0 )
{
    $price_query .= "&price_max=".intval($_GET['price_max']);
}

$selectedParamsFilters = array();
$j = 0;
$title_line = ""; 
if( (count($blocks) > 0) and ((count($blocks1) > 0)) ){ 
foreach($selected as $block => $blockItems)
{
    $title_block = array();
    for($i = 0; $i < count($blockItems); $i++)
    {   
     if(in_array( $blockItems[$i]["products_parameters_id"], $blocks1) ){
            $set_query1 = str_replace("-".$blockItems[$i]["products_parameters_id"]."-", "-", "-".$query1."-");
            $set_query1 = str_replace("--", "-", $set_query1);
            $set_query1 = trim($set_query1, "-");
            $poz = array_search($blockItems[$i]["products_parameters_id"], $blocks1);
        }else{
           // $set_query1 = $query1;
        }     
            $set_query=$blocks;
            $set_query[$poz] = "";
            $set_query = implode("-",$set_query);
            $set_query = str_replace("--", "-", $set_query);
            $set_query = str_replace("--", "-", $set_query);
            $set_query = trim($set_query, "-");
 
     
        $blockItems[$i]['set_query'] = $set_query.$price_query;
        $blockItems[$i]['url'] = vam_href_link(FILENAME_DEFAULT, vam_category_link($categories_id, $categories['categories_name']) .'&q='.$set_query.$price_query.'&p='.$set_query1.$price_query);
        $title_block[] = $blockItems[$i]["parameters_value"];
    }
    $selectedParamsFilters[$j]["name"] = $parametersNames[$block];
    $selectedParamsFilters[$j]["list"] = $blockItems;
    $title_line = $parametersNames[$block] . " " . join(', ', $title_block);
    $j++;
}
}
//var_dump($filterParams);

$mainParamsFilters = array(); 
foreach ($filterParams as $key => $value) {

for($i = 0; $i < count($filterParams[$key]); $i++) 
{
    $count_opened = $filterParams[$key][$i]["products_parameters_maxopened"];
    $values = get_parameters_block( $filterParams[$key][$i]["products_parameters_id"] , $selectedGroups); 
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
            $set_query = $query.'-'.$values[$j]["products_parameters_values_id"];
            $set_query = str_replace("--", "-", $set_query);
            $set_query = trim($set_query, "-");
        }
         if(!in_array( $values[$j]["products_parameters_id"], $blocks1) ){
            $set_query1 = $query1.'-'.$values[$j]["products_parameters_id"];
            $set_query1 = str_replace("--", "-", $set_query1);
            $set_query1 = trim($set_query1, "-");
        }else{
             $set_query1 = $query.'-'.$values[$j]["products_parameters_id"];
            $set_query1 = str_replace("--", "-", $set_query1);
            $set_query1 = trim($set_query1, "-");
        }
       // var_dump($set_query1);
        
        $znak = (array_key_exists( $filterParams[$key][$i]["products_parameters_id"], $selectedGroups)) ? "+" : "" ;
        $values[$j]['znak'] = $znak;
        $values[$j]['set_query'] = $set_query.$price_query ;
        if (!(array_key_exists( $filterParams[$key][$i]["products_parameters_id"], $selectedGroups)))
        $values[$j]['url'] = vam_href_link(FILENAME_DEFAULT, vam_category_link($categories_id, $categories['categories_name']) .'&q='.$set_query.$price_query.'&p='.$set_query1.$price_query);
        else
        $values[$j]['url'] = "";
        $values[$j]['opened'] = ($count_opened == $j && $count_opened != 0) ? true : false ;
    }
    $mainParamsFilters[$key][$i] = $filterParams[$key][$i];
    $mainParamsFilters[$key][$i]['blockValues'] = $values;
    $mainParamsFilters[$key][$i]['opened'] = ($count_opened != 0 && $count_opened < count($values)) ? true : false ;
}
}

//print "</pre>";
//print_r($mainParamsFilters);
//*/


// reset var
$box = new vamTemplate;
$box_content='';
$flag='';
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
$is_params_selected = ( count($selectedParamsFilters) > 0) ? true : false;
$box->assign('categories_id', $categories_id);
$box->assign('all_query', $query);
$box->assign('all_query1', $query1);
$box->assign('price_min', $_GET['price_min']);
$box->assign('price_max', $_GET['price_max']);
$box->assign('is_params_selected', $is_params_selected);
$box->assign('filterParams', $mainParamsFilters);
$box->assign('selectedParamsFilters', $selectedParamsFilters);
$box->assign('priceForm', vam_href_link(FILENAME_DEFAULT, vam_category_link($categories_id, $categories_name) .'&q='.$query. '&p='.$query1));
$box->assign('cansel_sel', vam_href_link(FILENAME_DEFAULT, vam_category_link($categories_id, $categories_name)));
$box->assign('BUTTON_FILTER', vam_image_submit('button_filter.gif', TEXT_PRODUCT_FILTER));
$box->caching = 0;
$box->assign('language', $_SESSION['language']);
$box_admin= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_filters.html');
$vamTemplate->assign('box_FILTERS',$box_admin);

?>
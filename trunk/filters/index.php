<?php 
/* --------------------------------------------------------------
   $Id: index.php 1167 2009-04-29 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2009 VaM Shop
   --------------------------------------------------------------
   Released under the GNU General Public License 
   --------------------------------------------------------------*/

	header('Content-Type: text/html; charset="UTF-8"');

	include("config.php");
	require_once("function.php");

	$categories_id = '1';
	$parametersNames = getAllParameters($categories_id);
	$selected = get_selected();
	$selectedGroups = get_selected_groups($selected );
	$items = get_products($categories_id, $selectedGroups);
	$params = get_parameters_by_categories($categories_id);
	//$params_values = get_values_by_params($params);
	
//	phpinfo();
	
//exit;
	print "<table><tr><td valign='top' width='300px'> ";
	$query = $_GET['q'];
	if(empty($query))
	{ $blocks = array(); }
	else { $blocks = preg_split('/-/', $query );}
	
	foreach($selected as $block => $blockItems)
	{
		print "[".$parametersNames[$block]."]<br />";
		foreach($blockItems as $selectItem){
			
			if(in_array( $selectItem["products_parameters_values_id"], $blocks) ){
				$set_query = str_replace("-".$selectItem["products_parameters_values_id"]."-", "-", "-".$query."-");
				$set_query = str_replace("--", "-", $set_query);
				$set_query = trim($set_query, "-");
			}else{
				$set_query = $query;
			}			
			print "&nbsp;&nbsp;<a href='?q=".$set_query."'>".$selectItem["parameters_value"]."</a><br />";
		}
	}
	
	print "<hr />";
	foreach($params as $param)
	{
		$values = get_parameters_block( $param["products_parameters_id"] , $selectedGroups);
		if( count($values) > 0 )
		{
			print "[".$param["products_parameters_id"]."-".$param["products_parameters_title"]."]<br />";
		}
		foreach($values as $value)
		{
			if(!in_array( $value["products_parameters_values_id"], $blocks) ){
				//array_push($blocks, $value["products_parameters_values_id"]);
				$set_query = $query.'-'.$value["products_parameters_values_id"];
				$set_query = str_replace("--", "-", $set_query);
				$set_query = trim($set_query, "-");
			}else{
				$set_query = $query;
			}
			$znak = ( array_key_exists( $param["products_parameters_id"], $selectedGroups)) ? "+" : "" ;

			print "  <a href='?q=".$set_query."'>".$value["parameters_value"]." (".$znak."".$value["count"].")</a><br />";
		}
		if( count($values) > 0 ) print "<br />";
	}
	print "</td><td valign='top'>";
	foreach($items as $item)
	{
		//print "[".$item["categories_id"].'-'.$item["categories_name"]."]-";
		print $item["products_name"];
		//print "<hr />";
		print "<hr />";
	}
	
	print "</td></tr></table>";
?>
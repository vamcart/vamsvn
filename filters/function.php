<?php
/* --------------------------------------------------------------
   $Id: function.php 1167 2009-04-29 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2009 VaM Shop
   --------------------------------------------------------------
   Released under the GNU General Public License 
   --------------------------------------------------------------*/

	

	function get_products($categories_id,  $selected_blocks)
	{
	
		$sql  = "select p.products_id, pd.products_name ";
		$sql .= " from products p";
		$sql .= " left join products_description pd on pd.products_id = p.products_id ";
		
		$tables = 0;
		$wheres = array();
		foreach( $selected_blocks as $index => $group_blocks)
		{
			if($index !=  $products_parameters_id){
				$tables++;
				$sql .= " LEFT JOIN products_parameters2products p".$tables." ON p.products_id = p".$tables.".products_id AND p".$tables.".products_parameters_values_id IN ( '".join("', '", $group_blocks)."' ) ";
				$wheres[] = " p".$tables.".products_id IS NOT NULL ";
			}
		}
		if(count($wheres) > 0){
			$sql .= " WHERE ".join(" AND ", $wheres);
		}
		$sql .= " limit 50";
		//print $sql."<hr />";
		//return array();
	
		$rs = mysql_query($sql);
		print mysql_error();
		$data = array();
		while($r = mysql_fetch_array($rs))
		{
			$data[] = $r;
		}
		
		return $data;
	}
	
	function get_parameters_by_categories($categories_id)
	{
		$sql = "select pp.* from products_parameters pp";
		$sql .= " where pp.categories_id = '".$categories_id."'";
		$sql .= " and pp.products_parameters_useinsearch = '1' ";
		$sql .= " order by pp.products_parameters_order ";

//		print $sql."<hr />";
		//return array();
		$rs = mysql_query($sql);
		print mysql_error();
		$data = array();
		while($r = mysql_fetch_array($rs))
		{
			$data[] = $r;
		}
		return $data;
	}
	
	function get_parameters_block( $products_parameters_id , $selected_blocks)
	{
		$query = $_GET['q'];
		if(!empty($query)){
			$blocks = preg_split("/-/", $query);
		}else{ $blocks = array(); }
		if( array_key_exists( $products_parameters_id, $selected_blocks))
		{
			$group_blocks = array_diff($blocks, $selected_blocks[$products_parameters_id]);
		
		}else{
			$group_blocks = $blocks;
		}
//		print_r($blocks); 
//		print_r($group_block); 
		//print count($blocks);

		if(count($blocks) > 0){
			$sql = "SELECT p.*, p.products_parameters2products_value as parameters_value , count( p.products_id ) count";
			$sql .= " FROM products_parameters2products p";
			$tables = 0;
			$wheres = array();
			foreach( $selected_blocks as $index => $group_blocks)
			{
				if($index !=  $products_parameters_id){
					$tables++;
					$sql .= " LEFT JOIN products_parameters2products p".$tables." ON p.products_id = p".$tables.".products_id AND p".$tables.".products_parameters_values_id IN ( '".join("', '", $group_blocks)."' ) ";
					$wheres[] = " p".$tables.".products_id IS NOT NULL ";
				}
			}
			$wheres[] = " p.products_parameters_values_id NOT IN ( '".join("', '", $blocks)."') ";
			$wheres[] = " p.products_parameters_id = '".$products_parameters_id."' ";
			$sql .= " WHERE ".join(" AND ", $wheres);
			$sql .= " GROUP BY p.products_parameters_values_id ";
			$sql .= " ORDER BY p.products_parameters2products_value";
		
		} else {
			$sql = "SELECT p1.*, p1.products_parameters2products_value as parameters_value , count( p1.products_id ) count";
			$sql .= " FROM products_parameters2products p1";
			$sql .= " WHERE p1.products_parameters_id = '".$products_parameters_id."'";
			$sql .= " GROUP BY p1.products_parameters_values_id";
			$sql .= " ORDER BY p1.products_parameters2products_value";
		}
		//print $sql;
		$rs = mysql_query($sql);
		print mysql_error();
		$data = array();
		while($r = mysql_fetch_array($rs))
		{
			$data[] = $r;
		}
		return $data;
	}
	
	function get_values_by_params($params_data)
	{
		$query = $_GET['q'];
		if(!empty($query)){
			$blocks = preg_split("/-/", $query);
		}else{ $blocks = array(); }
		
		$params_ids = array();
		foreach($params_data as $param){
			$params_ids[] = $param['products_parameters_id'];
		}
		/*
		$sql = "select *, products_parameters2products_value as parameters_value, count(products_id) count from products_parameters2products";
		$sql .= " where products_parameters_id in ('".join("', '", $params_ids)."')";
		$sql .= " and products_parameters_values_id not in ( '".join("', '", $blocks)."') ";
		$sql .= " group by products_parameters_values_id ";
		$sql .= " order by products_parameters2products_value, products_parameters2products_order  ";
*/
	$sql = "SELECT p1.*, p1.products_parameters2products_value as parameters_value , count( p1.products_id ) count";
	$sql .= " FROM products_parameters2products p1";
	$sql .= " LEFT JOIN products_parameters2products p2 ON p1.products_id = p2.products_id";
	if(count($blocks) > 0) $sql .= " AND p2.products_parameters_values_id IN ( '".join("', '", $blocks)."')";
	$sql .= " WHERE p2.products_id IS NOT NULL";
	if(count($blocks) > 0) $sql .= " AND p1.products_parameters_values_id NOT IN ( '".join("', '", $blocks)."')";
	$sql .= " GROUP BY p1.products_parameters_values_id";
	$sql .= " ORDER BY p1.products_parameters2products_value, p1.products_parameters2products_order";
		//print $sql;
		$rs = mysql_query($sql);
		print mysql_error();
		$data = array();
		while($r = mysql_fetch_array($rs))
		{
			$data[ $r['products_parameters_id'] ][] = $r;
		}
		return $data;
	}

	function get_selected()
	{
		$query = $_GET['q'];
		if(!empty($query)){
			$blocks = preg_split("/-/", $query);
		}else{ $blocks = array(); }
		$paramNames = array();
		if( count($blocks) > 0){
			
			$sql = "select ppv.* from products_parameters_values ppv";
			$sql .= " where ppv.products_parameters_values_id in ( '".join("', '", $blocks)."')";
			$sql .= "  ";
	//	print $sql."<hr />";
	//	return array();
			$rs = mysql_query($sql);
			print mysql_error();
			$data = array();
			while($r = mysql_fetch_array($rs))
			{
				$paramId = $r['products_parameters_id'];
				//$paramName = paramName($paramId, $paramNames);
				//$paramNames[$paramId] = $paramName;
				$data[$paramId][] = $r;
			}
		}else{ $data = array(); }
		return $data;
	}
	
	function get_selected_groups($selected)
	{
		$data = array();
		foreach($selected as $block => $blockItems)
		{
			$data[$block] = array();
			foreach($blockItems as $selectItem){
				$data[$block][] = $selectItem['products_parameters_values_id'];
			}
		}
		return $data;
	}
	
	function paramName($paramId, $paramNames)
	{
		if( in_array($paramId, $paramNames) )
		{
			return $paramNames[$paramId];
		}else{
			$sql = "select products_parameters_title from products_parameters where products_parameters_id = '".$paramId."'";
			list($name) = mysql_fetch_array(mysql_query($sql));
			return $name;
		}
	}
	
	function getAllParameters($categories_id)
	{
		$sql = "select products_parameters_id, products_parameters_title from products_parameters where categories_id = '".$categories_id."'";
		$data = array();
		$rs = mysql_query($sql);
		while($r = mysql_fetch_array($rs))
		{
			$data[ $r['products_parameters_id'] ] = $r['products_parameters_title'];
		}
		return $data;
	}
?>
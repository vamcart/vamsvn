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
	
		$rs = vamDBquery($sql,true);
		print mysql_error();
		$data = array();
		while($r = vam_db_fetch_array($rs,true))
		{
			$data[] = $r;
		}
		
		return $data;
	}
	function get_params_listing_sql($listing_sql, $categories_id,  $selected_blocks)
	{
		if( count($selected_blocks) == 0) return $listing_sql; 
		// p.products_statuses_id, 

		$sql = "select p.products_fsk18, 
					p.products_shippingtime, 
					p.products_model, 
					p.products_ean, 
					p.products_status, 
					pd.products_name, 
					m.manufacturers_name, 
					p.products_quantity, 
					p.products_image, 
					p.products_weight, 
					pd.products_short_description, 
					pd.products_description, 
					p.products_id, 
					p.manufacturers_id, 
					p.products_price, 
					p.products_vpe, 
					p.products_vpe_status, 
					p.products_vpe_value, 
					p.products_discount_allowed, 
					p.products_tax_class_id 
				from products p 
				left join products_description pd on pd.products_id = p.products_id
				left join products_to_categories p2c on p2c.products_id = p.products_id
				left join manufacturers m on p.manufacturers_id = m.manufacturers_id ";
		$tables = 0;
		$wheres = array();
		
		$price_min = -1;
		if(isset($_GET['price_min']) && intval($_GET['price_min']) != 0 )
		{
			$wheres[] = " p.products_price >= '".intval($_GET['price_min'])."' ";;
		}
		$price_max = -1;
		if(isset($_GET['price_max']) && intval($_GET['price_max']) != 0 )
		{
			$wheres[] = " p.products_price <= '".intval($_GET['price_max'])."' ";;
		}
		
		$wheres[] = "  p.products_status = '1' and p2c.categories_id = '".(int)$categories_id."' ";
		$wheres[] = " pd.language_id = '1' ";
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
			$sql .= " ORDER BY pd.products_name ASC";
//			print $sql;
			return $sql;
	}

	function get_parameters_by_categories($categories_id)
	{
		$sql = "select pp.* from products_parameters pp";
		$sql .= " where pp.categories_id = '".$categories_id."'";
		$sql .= " and pp.products_parameters_useinsearch = '1' ";
		$sql .= " order by pp.products_parameters_order ";

//		print $sql."<hr />";
		//return array();
		$rs = vamDBquery($sql);
		print mysql_error();
		$data = array();
		while($r = vam_db_fetch_array($rs,true))
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
		$price_min = -1;
		if(isset($_GET['price_min']) && intval($_GET['price_min']) != 0 )
		{
			$price_min = intval($_GET['price_min']);
		}
		$price_max = -1;
		if(isset($_GET['price_max']) && intval($_GET['price_max']) != 0 )
		{
			$price_max = intval($_GET['price_max']);
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
			if($price_max != -1 || $price_min != -1){
				$sql .= " JOIN products p0 ON  p0.products_id = p.products_id ";
				if($price_min != -1 ) $sql .= " AND p0.products_price >= '$price_min' ";
				if($price_max != -1 ) $sql .= " AND p0.products_price <= '$price_max' ";
			}

        $sql .= " LEFT JOIN products prd ON prd.products_id = p.products_id ";

			$sql .= " WHERE ".join(" AND ", $wheres);
         $sql .= " and prd.products_status = 1 ";
			$sql .= " GROUP BY p.products_parameters_values_id ";
			$sql .= " ORDER BY p.products_parameters2products_value";
		
		} else {
			$sql = "SELECT p1.*, p1.products_parameters2products_value as parameters_value , count( p1.products_id ) count";
			$sql .= " FROM products_parameters2products p1";
			if($price_max != -1 || $price_min != -1){
				$sql .= " JOIN products p0 ON  p0.products_id = p1.products_id ";
				if($price_min != -1 ) $sql .= " AND p0.products_price >= '$price_min' ";
				if($price_max != -1 ) $sql .= " AND p0.products_price <= '$price_max' ";
			}

        $sql .= " LEFT JOIN products prd ON prd.products_id = p1.products_id ";

			$sql .= " WHERE p1.products_parameters_id = '".$products_parameters_id."'";
         $sql .= " and prd.products_status = 1 ";
			$sql .= " GROUP BY p1.products_parameters_values_id";
			$sql .= " ORDER BY p1.products_parameters2products_value";
		}
		//print $sql;
		$rs = vamDBquery($sql,true);
		print mysql_error();
		$data = array();
		while($r = vam_db_fetch_array($rs,true))
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

		$sql = "SELECT p1.*, p1.products_parameters2products_value as parameters_value , count( p1.products_id ) count";
		$sql .= " FROM products_parameters2products p1";
		$sql .= " LEFT JOIN products_parameters2products p2 ON p1.products_id = p2.products_id";
		if(count($blocks) > 0) $sql .= " AND p2.products_parameters_values_id IN ( '".join("', '", $blocks)."')";
		$sql .= " WHERE p2.products_id IS NOT NULL";
		if(count($blocks) > 0) $sql .= " AND p1.products_parameters_values_id NOT IN ( '".join("', '", $blocks)."')";
		$sql .= " GROUP BY p1.products_parameters_values_id";
		$sql .= " ORDER BY p1.products_parameters2products_value, p1.products_parameters2products_order";
		//print $sql;
		$rs = vamDBquery($sql,true);
		print mysql_error();
		$data = array();
		while($r = vam_db_fetch_array($rs,true))
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
		
		$price_min = -1;
		if(isset($_GET['price_min']) && intval($_GET['price_min']) != 0 )
		{
			$price_min = intval($_GET['price_min']);
		}
		$price_max = -1;
		if(isset($_GET['price_max']) && intval($_GET['price_max']) != 0 )
		{
			$price_max = intval($_GET['price_max']);
		}

		$paramNames = array();
		if( count($blocks) > 0){
			
			$sql = "select ppv.* from products_parameters_values ppv";
			if($price_max != -1 || $price_min != -1){
				$sql .= " JOIN products_parameters2products p1 ON  p1.products_parameters_values_id = ppv.products_parameters_values_id ";
				$sql .= " JOIN products p0 ON  p0.products_id = p1.products_id ";
				if($price_min != -1 ) $sql .= " AND p0.products_price >= '$price_min' ";
				if($price_max != -1 ) $sql .= " AND p0.products_price <= '$price_max' ";
			}
			$sql .= " where ppv.products_parameters_values_id in ( '".join("', '", $blocks)."')";
			if($price_max != -1 || $price_min != -1){
				$sql .= " GROUP BY p1.products_parameters_values_id";
			}			
			//print $sql;exit;
			$rs = vamDBquery($sql,true);
			print mysql_error();
			$data = array();
			while($r = vam_db_fetch_array($rs,true))
			{
				$paramId = $r['products_parameters_id'];
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
			$sql = vamDBquery("select products_parameters_title from products_parameters where products_parameters_id = '".$paramId."'");
			list($name) = vam_db_fetch_array($sql,true);
			return $name;
		}
	}
	
	function getAllParameters($categories_id)
	{
		$sql = "select products_parameters_id, products_parameters_title from products_parameters where categories_id = '".$categories_id."'";
		$data = array();
		$rs = vamDBquery($sql,true);
		while($r = vam_db_fetch_array($rs,true))
		{
			$data[ $r['products_parameters_id'] ] = $r['products_parameters_title'];
		}
		return $data;
	}
?>
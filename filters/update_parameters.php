<?php 
/* --------------------------------------------------------------
   $Id: update_parameters.php 1167 2009-04-29 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2009 VaM Shop
   --------------------------------------------------------------
   Released under the GNU General Public License 
   --------------------------------------------------------------*/

	header('Content-Type: text/html; charset="UTF-8"');
	
	include("config.php");
		
	if($_GET['clear'] == '1'){
		mysql_query("update products_parameters2products pp2p set products_parameters_values_id = '0'");//
	}
	
	$rs = mysql_query("select * from products_parameters2products pp2p where products_parameters_values_id = '0'");//
	print mysql_num_rows($rs ).'-';
	print mysql_error();
	$counter = 0;
	while($r = mysql_fetch_array($rs))
	{
		$value = $r["products_parameters2products_value"];
		$sql = "select * from products_parameters_values where parameters_value = '".$value."'";
		$rs_row = mysql_query($sql);
		if(mysql_error())
		{
			print  mysql_error()."<br>";
			print 'sql - '.$sql.'<hr />';
		}
		
		if(mysql_num_rows($rs_row) == 0)
		{
			$insert = "insert into products_parameters_values(products_parameters_id, parameters_value) ";
			$insert .= " values('".$r["products_parameters_id"]."', '" . mysql_real_escape_string($value) . "') ";
			mysql_query($insert);
			if(mysql_error())
			{
				print  mysql_error()."<br>";
				print 'insert - '.$insert.'<hr />';
			}
			$id = mysql_insert_id();
		}else{
			$row = mysql_fetch_array($rs_row);
			$id = $row["products_parameters_values_id"];
		}
		
		$update = "update products_parameters2products set products_parameters_values_id = '".$id."' ";
		$update .= " where products_parameters_id = '".$r["products_parameters_id"]."' and products_id = '".$r["products_id"]."'";
		mysql_query($update);
			if(mysql_error())
			{
				print  mysql_error()."<br>";
				print 'update - '.$update.'<hr />';
			}
		$counter++;
	}
	
	print $counter;
	
	
?>
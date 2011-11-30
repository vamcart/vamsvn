<?php

//		"NOselect configuration_key as cfgKey, configuration_value as cfgValue from configuration",

	$asis=array(
		'a0' => "SELECT * FROM currencies",
		'a1' => "SELECT tax_class_id as class FROM tax_class",
		'a2' => "select authors_id, authors_name from authors order by authors_name",
		'a3' => "select languages_id, name, code, image, directory,language_charset from languages order by sort_order",
		
	);

	$typical=array(
		array(
			"@select categories_id from categories where parent_id = '([0-9]+)'@",
			"select parent_id, categories_id from categories",
			"2fields",
			array('parent_id', 'categories_id'),
		    ),
		array(
			"@select parent_id from categories where categories_id = '([0-9]+)'@",
			"select parent_id, categories_id from categories",
			"2fields",
			array('categories_id', 'parent_id'),
		    ),
		array(
			"@select categories_url from categories where categories_id=\"([0-9]+)\"@",
			"select categories_id, categories_url from categories",
			"2fields",
			array('categories_id', 'categories_url'),
		    ),
		array(
			"@select categories_image from categories where categories_id = '([0-9]+)'@",
			"select categories_id, categories_image from categories",
			"2fields",
			array('categories_id', 'categories_image'),
		    ),
		'24' => array(
			"@SELECT parent_id\, categories_status FROM categories WHERE categories_id = '([0-9]+)'@",
			"select categories_id, parent_id, categories_status from categories",
			"fields",
			array('categories_id', 'parent_id', 'categories_status'),
		    ),
		'25' => array(
			"@SELECT products_sorting\, products_sorting2 FROM categories where categories_id='([0-9]+)'@",
			"select categories_id, products_sorting, products_sorting2 from categories",
			"fields",
			array('categories_id', 'products_sorting', 'products_sorting2'),
		    ),



		'29' => array(
			"@select count\(\*\) as count from categories where parent_id = '([0-9]+)'@",
			"select parent_id, count(*) as count  from categories group by parent_id",
			"2fields",
			array('parent_id', 'count'),
		    ),

		'229' => array(
			"@select count(*) as total from categories where parent_id = '([0-9]+)'@",
			"select parent_id, count(*) as total  from categories group by parent_id",
			"2fields",
			array('parent_id', 'total'),
		    ),



		'30' => array(
			"@select content_page_url from content_manager where content_id=\"([0-9]+)\"@",
			"select content_id, content_page_url from content_manager",
			"2fields",
			array('content_id', 'content_page_url'),
		    ),

		'40' => array(
			"@select topics_page_url from topics where topics_id=\"([0-9\-]*)\"@",
			"select topics_id, topics_page_url from topics",
			"2fields",
			array('topics_id', 'topics_page_url'),
		    ),
		'41' => array(
			"@select topics_id from topics where parent_id='([0-9\-]*)'@",
			"select parent_id, topics_id from topics",
			"2fields",
			array('parent_id', 'topics_id'),
		    ),
		't5' => array(
			"@select topics_id from topics where parent_id = '([0-9\-]*)'@",
			"select parent_id, topics_id from topics",
			"2fields",
			array('parent_id', 'topics_id'),
		    ),
		'42' => array(
			"@select count(*) as count from topics where parent_id = '([0-9\-]*)'@",
			"select parent_id, count(*) as count  from topics group by parent_id",
			"2fields",
			array('parent_id', 'count'),
		    ),

		'pp' => array(
			"@select products_parameters_id, products_parameters_title from products_parameters where categories_id = '([0-9\-]*)'@",
			"select categories_id, products_parameters_id, products_parameters_title from products_parameters ",
			"fields",
			array('categories_id', 'products_parameters_id', 'products_parameters_title'),
		    ),





		'60' => array(
			"@select count\(\*\) as total from products p, products_to_categories p2c where p.products_id = p2c.products_id and p.products_status = '1' and p2c.categories_id = '([0-9]+)'@",
			"select p2c.categories_id, count(*) as total from products p, products_to_categories p2c where p.products_id = p2c.products_id and p.products_status = '1' group by p2c.categories_id",
			"2fields",
			array('p2c.categories_id', 'total'),
		    ),

	);

//	$typical=array(	);
	

	global $expdate;

	$query=trim($query);
	$query=preg_replace("@\s+@", ' ', $query);


	global $cache_array;

	if( is_array($asis))foreach ($asis as $k => $v) {

		if($v==$query){

			if(!is_array($cache_array[$k])){

				$fn='cache/'.DB_DATABASE.'_opt_asis_'.$k.'.c';
				if(!is_file($fn) || date('Y-m-d-H-i-s',filemtime ($fn))<=$expdate ){

					require_once DIR_WS_MODULES.'optimizer/func_seria.php';
					seria_query($fn, $v, 'asis');
				}

				if(is_file($fn)){

					require_once DIR_WS_MODULES.'optimizer/func_seria.php';
					$cache_array[$k]=unseria($fn);
				}
			}
			

			if(is_array($cache_array[$k])){
				//if(is_array($cache_array[$k][$mt[1]])){
				if(true){
//					return $cache_array[$k][$mt[1]];
					return $cache_array[$k];
				}else 
					return array();
			}
		}
	}





	if( is_array($typical))foreach ($typical as $k => $v) {

		$v[0]=str_replace("count(*)", "count\(\*\)", $v[0]);
		
		if(preg_match($v[0], $query, $mt)){

			if(!is_array($cache_array[$k])){

				$fn='cache/'.DB_DATABASE.'_opt_typ_'.$k.'.c';
				if(!is_file($fn) || date('Y-m-d-H-i-s',filemtime ($fn))<=$expdate ){

					require_once DIR_WS_MODULES.'optimizer/func_seria.php';
					seria_query($fn, $v[1], $v[2], $v[3]);
				}
				if(is_file($fn)){

					require_once DIR_WS_MODULES.'optimizer/func_seria.php';
					$cache_array[$k]=unseria($fn);
				}
			}
			
			if(is_array($cache_array[$k])){
				if(is_array($cache_array[$k][$mt[1]])){
					return $cache_array[$k][$mt[1]];
				}else 
					return array();
			}
		}
	}

return false;

?>
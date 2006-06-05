<?PHP


/* --------------------------------------------------------------
   $Id: categories.php 1318 2005-10-21 19:40:59Z mz $
  
   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com
   (c) 2003  nextcommerce (categories.php,v 1.37 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contribution:
   Enable_Disable_Categories 1.3               Autor: Mikel Williams | mikel@ladykatcostumes.com
   New Attribute Manager v4b                   Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com
   Category Descriptions (Version: 1.5 MS2)    Original Author:   Brian Lowe <blowe@wpcusrgrp.org> | Editor: Lord Illicious <shaolin-venoms@illicious.net>
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/

// ----------------------------------------------------------------------------------------------------- // 

// holds functions for manipulating products & categories
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
class categories {

	// ----------------------------------------------------------------------------------------------------- //     

	// deletes an array of categories, with products
	// makes use of remove_category, remove_product

	function remove_categories($category_id) {

		$categories = xtc_get_category_tree($category_id, '', '0', '', true);
		$products = array ();
		$products_delete = array ();

		for ($i = 0, $n = sizeof($categories); $i < $n; $i ++) {
			$product_ids_query = xtc_db_query("SELECT products_id
						    	                                   FROM ".TABLE_PRODUCTS_TO_CATEGORIES."
						    	                                   WHERE categories_id = '".$categories[$i]['id']."'");
			while ($product_ids = xtc_db_fetch_array($product_ids_query)) {
				$products[$product_ids['products_id']]['categories'][] = $categories[$i]['id'];
			}
		}

		reset($products);
		while (list ($key, $value) = each($products)) {
			$category_ids = '';
			for ($i = 0, $n = sizeof($value['categories']); $i < $n; $i ++) {
				$category_ids .= '\''.$value['categories'][$i].'\', ';
			}
			$category_ids = substr($category_ids, 0, -2);

			$check_query = xtc_db_query("SELECT COUNT(*) AS total
						    	                               FROM ".TABLE_PRODUCTS_TO_CATEGORIES."
						    	                               WHERE products_id = '".$key."'
						    	                               AND categories_id NOT IN (".$category_ids.")");
			$check = xtc_db_fetch_array($check_query);
			if ($check['total'] < '1') {
				$products_delete[$key] = $key;
			}
		}

		// Removing categories can be a lengthy process
		@ xtc_set_time_limit(0);
		for ($i = 0, $n = sizeof($categories); $i < $n; $i ++) {
			$this->remove_category($categories[$i]['id']);
		}

		reset($products_delete);
		while (list ($key) = each($products_delete)) {
			$this->remove_product($key);
		}

	} // remove_categories ends 

	// ----------------------------------------------------------------------------------------------------- //     

	// deletes a single category, without products

	function remove_category($category_id) {
		$category_image_query = xtc_db_query("SELECT categories_image FROM ".TABLE_CATEGORIES." WHERE categories_id = '".xtc_db_input($category_id)."'");
		$category_image = xtc_db_fetch_array($category_image_query);

		$duplicate_image_query = xtc_db_query("SELECT count(*) AS total FROM ".TABLE_CATEGORIES." WHERE categories_image = '".xtc_db_input($category_image['categories_image'])."'");
		$duplicate_image = xtc_db_fetch_array($duplicate_image_query);

		if ($duplicate_image['total'] < 2) {
			if (file_exists(DIR_FS_CATALOG_IMAGES.'categories/'.$category_image['categories_image'])) {
				@ unlink(DIR_FS_CATALOG_IMAGES.'categories/'.$category_image['categories_image']);
			}
		}

		xtc_db_query("DELETE FROM ".TABLE_CATEGORIES." WHERE categories_id = '".xtc_db_input($category_id)."'");
		xtc_db_query("DELETE FROM ".TABLE_CATEGORIES_DESCRIPTION." WHERE categories_id = '".xtc_db_input($category_id)."'");
		xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_TO_CATEGORIES." WHERE categories_id = '".xtc_db_input($category_id)."'");

		if (USE_CACHE == 'true') {
			xtc_reset_cache_block('categories');
			xtc_reset_cache_block('also_purchased');
		}

	} // remove_category ends   

	// ----------------------------------------------------------------------------------------------------- //

	// inserts / updates a category from given $categories_data array
	// Needed fields: id, sort_order, status, array(groups), products_sorting, products_sorting2, category_template,
	// listing_template, previous_image, array[name][lang_id], array[heading_title][lang_id], array[description][lang_id], 
	// array[meta_title][lang_id], array[meta_description][lang_id], array[meta_keywords][lang_id]

	function insert_category($categories_data, $dest_category_id, $action = 'insert') {

		$categories_id = xtc_db_prepare_input($categories_data['categories_id']);

		$sort_order = xtc_db_prepare_input($categories_data['sort_order']);
		$categories_status = xtc_db_prepare_input($categories_data['status']);





		$customers_statuses_array = xtc_get_customers_statuses();

		$permission = array ();
		for ($i = 0; $n = sizeof($customers_statuses_array), $i < $n; $i ++) {
			if (isset($customers_statuses_array[$i]['id']))
				$permission[$customers_statuses_array[$i]['id']] = 0;
		}
		if (isset ($categories_data['groups']))
			foreach ($categories_data['groups'] AS $dummy => $b) {
				$permission[$b] = 1;
			}
		// build array
		if ($permission['all']==1) {
			$permission = array ();
			end($customers_statuses_array);
			for ($i = 0; $n = key($customers_statuses_array), $i < $n+1; $i ++) {
				if (isset($customers_statuses_array[$i]['id']))
					$permission[$customers_statuses_array[$i]['id']] = 1;
			}
		}
		

		$permission_array = array ();
		
		
		// set pointer to last key
		end($customers_statuses_array);		
		for ($i = 0; $n = key($customers_statuses_array), $i < $n+1; $i ++) {
			if (isset($customers_statuses_array[$i]['id'])) {
				$permission_array = array_merge($permission_array, array ('group_permission_'.$customers_statuses_array[$i]['id'] => $permission[$customers_statuses_array[$i]['id']]));
			}
		}


		$sql_data_array = array ('sort_order' => $sort_order, 'categories_status' => $categories_status, 'products_sorting' => xtc_db_prepare_input($categories_data['products_sorting']), 'products_sorting2' => xtc_db_prepare_input($categories_data['products_sorting2']), 'categories_template' => xtc_db_prepare_input($categories_data['categories_template']), 'listing_template' => xtc_db_prepare_input($categories_data['listing_template']));
		$sql_data_array = array_merge($sql_data_array,$permission_array);
		if ($action == 'insert') {
			$insert_sql_data = array ('parent_id' => $dest_category_id, 'date_added' => 'now()');
			$sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
			xtc_db_perform(TABLE_CATEGORIES, $sql_data_array);
			$categories_id = xtc_db_insert_id();
		}
		elseif ($action == 'update') {
			$update_sql_data = array ('last_modified' => 'now()');
			$sql_data_array = xtc_array_merge($sql_data_array, $update_sql_data);
			xtc_db_perform(TABLE_CATEGORIES, $sql_data_array, 'update', 'categories_id = \''.$categories_id.'\'');
		}
		xtc_set_groups($categories_id, $permission_array);
		$languages = xtc_get_languages();
		foreach ($languages AS $lang) {
			$categories_name_array = $categories_data['name'];
			$sql_data_array = array ('categories_name' => xtc_db_prepare_input($categories_data['categories_name'][$lang['id']]), 'categories_heading_title' => xtc_db_prepare_input($categories_data['categories_heading_title'][$lang['id']]), 'categories_description' => xtc_db_prepare_input($categories_data['categories_description'][$lang['id']]), 'categories_meta_title' => xtc_db_prepare_input($categories_data['categories_meta_title'][$lang['id']]), 'categories_meta_description' => xtc_db_prepare_input($categories_data['categories_meta_description'][$lang['id']]), 'categories_meta_keywords' => xtc_db_prepare_input($categories_data['categories_meta_keywords'][$lang['id']]));


			if ($action == 'insert') {
				$insert_sql_data = array ('categories_id' => $categories_id, 'language_id' => $lang['id']);
				$sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
				xtc_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array);
			}
			elseif ($action == 'update') {
				xtc_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array, 'update', 'categories_id = \''.$categories_id.'\' and language_id = \''.$lang['id'].'\'');
			}
		}

		if ($categories_image = & xtc_try_upload('categories_image', DIR_FS_CATALOG_IMAGES.'categories/')) {
			$cname_arr = explode('.', $categories_image->filename);
			$cnsuffix = array_pop($cname_arr);
			$categories_image_name = $categories_id.'.'.$cnsuffix;
			@ unlink(DIR_FS_CATALOG_IMAGES.'categories/'.$categories_image_name);
			rename(DIR_FS_CATALOG_IMAGES.'categories/'.$categories_image->filename, DIR_FS_CATALOG_IMAGES.'categories/'.$categories_image_name);
			xtc_db_query("UPDATE ".TABLE_CATEGORIES."
						    		                 SET categories_image = '".xtc_db_input($categories_image_name)."'
						    		               WHERE categories_id = '".(int) $categories_id."'");
		}

		if ($categories_data['del_cat_pic'] == 'yes') {
			@ unlink(DIR_FS_CATALOG_IMAGES.'categories/'.$categories_data['categories_previous_image']);
			xtc_db_query("UPDATE ".TABLE_CATEGORIES."
						    		                 SET categories_image = ''
						    		               WHERE categories_id    = '".(int) $categories_id."'");
		}

	} // insert_category ends

	// ----------------------------------------------------------------------------------------------------- //

	function set_category_recursive($categories_id, $status = "0") {

			// get products in category
	/* // don't set products status at the moment
	$products_query=xtc_db_query("SELECT products_id FROM ".TABLE_PRODUCTS_TO_CATEGORIES." where categories_id='".$categories_id."'");
	while ($products=xtc_db_fetch_array($products_query)) {
	    xtc_db_query("UPDATE ".TABLE_PRODUCTS." SET products_status='".$status."' where products_id='".$products['products_id']."'");
	}
	*/
			// set status of category
	xtc_db_query("UPDATE ".TABLE_CATEGORIES." SET categories_status = '".$status."' WHERE categories_id = '".$categories_id."'");
		// look for deeper categories and go rekursiv
		$categories_query = xtc_db_query("SELECT categories_id FROM ".TABLE_CATEGORIES." WHERE parent_id='".$categories_id."'");
		while ($categories = xtc_db_fetch_array($categories_query)) {
			$this->set_category_recursive($categories['categories_id'], $status);
		}

	}

	// ----------------------------------------------------------------------------------------------------- //

	// moves a category to new parent category

	function move_category($src_category_id, $dest_category_id) {
		$src_category_id = xtc_db_prepare_input($src_category_id);
		$dest_category_id = xtc_db_prepare_input($dest_category_id);
		xtc_db_query("UPDATE ".TABLE_CATEGORIES."
				    	                 SET parent_id     = '".xtc_db_input($dest_category_id)."', last_modified = now() 
				    	               WHERE categories_id = '".xtc_db_input($src_category_id)."'");
	}

	// ----------------------------------------------------------------------------------------------------- //  

	// copies a category to new parent category, takes argument to link or duplicate its products
	// arguments are "link" or "duplicate"
	// $copied is an array of ID's that were already newly created, and is used to prevent them from being
	// copied recursively again

	function copy_category($src_category_id, $dest_category_id, $ctype = "link") {

			//skip category if it is already a copied one
	if (!(in_array($src_category_id, $_SESSION['copied']))) {

			$src_category_id = xtc_db_prepare_input($src_category_id);
			$dest_category_id = xtc_db_prepare_input($dest_category_id);

			//get data
			$ccopy_query = xtDBquery("SELECT * FROM ".TABLE_CATEGORIES." WHERE categories_id = '".$src_category_id."'");
			$ccopy_values = xtc_db_fetch_array($ccopy_query);

			//get descriptions
			$cdcopy_query = xtDBquery("SELECT * FROM ".TABLE_CATEGORIES_DESCRIPTION." WHERE categories_id = '".$src_category_id."'");

			//copy data
			
			$sql_data_array = array ('parent_id'=>xtc_db_input($dest_category_id),
									'date_added'=>'NOW()',
									'last_modified'=>'NOW()',
									'categories_image'=>$ccopy_values['categories_image'],
									'categories_status'=>$ccopy_values['categories_status'],
									'categories_template'=>$ccopy_values['categories_template'],
									'listing_template'=>$ccopy_values['listing_template'],
									'sort_order'=>$ccopy_values['sort_order'],
									'products_sorting'=>$ccopy_values['products_sorting'],
									'products_sorting2'=>$ccopy_values['products_sorting2']);	
			
			
					$customers_statuses_array = xtc_get_customers_statuses();

		for ($i = 0; $n = sizeof($customers_statuses_array), $i < $n; $i ++) {
			if (isset($customers_statuses_array[$i]['id']))
				$sql_data_array = array_merge($sql_data_array, array ('group_permission_'.$customers_statuses_array[$i]['id'] => $product['group_permission_'.$customers_statuses_array[$i]['id']]));
		}
			
			xtc_db_perform(TABLE_CATEGORIES, $sql_data_array);

			$new_cat_id = xtc_db_insert_id();

			//store copied ids, because we don't want to go into an endless loop later
			$_SESSION['copied'][] = $new_cat_id;

			//copy / link products
			$get_prod_query = xtDBquery("SELECT products_id FROM ".TABLE_PRODUCTS_TO_CATEGORIES." WHERE categories_id = '".$src_category_id."'");
			while ($product = xtc_db_fetch_array($get_prod_query)) {
				if ($ctype == 'link') {
					$this->link_product($product['products_id'], $new_cat_id);
				}
				elseif ($ctype == 'duplicate') {
					$this->duplicate_product($product['products_id'], $new_cat_id);
				} else {
					die('Undefined copy type!');
				}
			}

			//copy+rename image
			$src_pic = DIR_FS_CATALOG_IMAGES.'categories/'.$ccopy_values['categories_image'];
			if (is_file($src_pic)) {
				$get_suffix = explode('.', $ccopy_values['categories_image']);
				$suffix = array_pop($get_suffix);
				$dest_pic = $new_cat_id.'.'.$suffix;
				@ copy($src_pic, DIR_FS_CATALOG_IMAGES.'categories/'.$dest_pic);
				xtDBquery("UPDATE categories SET categories_image = '".$dest_pic."' WHERE categories_id = '".$new_cat_id."'");
			}

			//copy descriptions
			while ($cdcopy_values = xtc_db_fetch_array($cdcopy_query)) {
				xtDBquery("INSERT INTO ".TABLE_CATEGORIES_DESCRIPTION." (categories_id, language_id, categories_name, categories_heading_title, categories_description, categories_meta_title, categories_meta_description, categories_meta_keywords) VALUES ('".$new_cat_id."' , '".$cdcopy_values['language_id']."' , '".addslashes($cdcopy_values['categories_name'])."' , '".addslashes($cdcopy_values['categories_heading_title'])."' , '".addslashes($cdcopy_values['categories_description'])."' , '".addslashes($cdcopy_values['categories_meta_title'])."' , '".addslashes($cdcopy_values['categories_meta_description'])."' , '".addslashes($cdcopy_values['categories_meta_keywords'])."')");
			}

			//get child categories of current category
			$crcopy_query = xtDBquery("SELECT categories_id FROM ".TABLE_CATEGORIES." WHERE parent_id = '".$src_category_id."'");

			//and go recursive
			while ($crcopy_values = xtc_db_fetch_array($crcopy_query)) {
				$this->copy_category($crcopy_values['categories_id'], $new_cat_id, $ctype);
			}

		}
	}

	// ----------------------------------------------------------------------------------------------------- //  

	// removes a product + images + more images + content

	function remove_product($product_id) {

		// get content of product
		$product_content_query = xtc_db_query("SELECT content_file FROM ".TABLE_PRODUCTS_CONTENT." WHERE products_id = '".xtc_db_input($product_id)."'");
		// check if used elsewhere, delete db-entry + file if not
		while ($product_content = xtc_db_fetch_array($product_content_query)) {   
		   		
   		$duplicate_content_query = xtc_db_query("SELECT count(*) AS total FROM ".TABLE_PRODUCTS_CONTENT." WHERE content_file = '".xtc_db_input($product_content['content_file'])."' AND products_id != '".xtc_db_input($product_id)."'");

   		$duplicate_content = xtc_db_fetch_array($duplicate_content_query);

   		if ($duplicate_content['total'] == 0) {
   			@unlink(DIR_FS_DOCUMENT_ROOT.'media/products/'.$product_content['content_file']);
   		}
         
   		//delete DB-Entry   		
   		xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_CONTENT." WHERE products_id = '".xtc_db_input($product_id)."' AND (content_file = '".$product_content['content_file']."' OR content_file = '')");
   		
		}
	   
		$product_image_query = xtc_db_query("SELECT products_image FROM ".TABLE_PRODUCTS." WHERE products_id = '".xtc_db_input($product_id)."'");
		$product_image = xtc_db_fetch_array($product_image_query);

		$duplicate_image_query = xtc_db_query("SELECT count(*) AS total FROM ".TABLE_PRODUCTS." WHERE products_image = '".xtc_db_input($product_image['products_image'])."'");
		$duplicate_image = xtc_db_fetch_array($duplicate_image_query);

		if ($duplicate_image['total'] < 2) {
			xtc_del_image_file($product_image['products_image']);
		}

		//delete more images
		$mo_images_query = xtc_db_query("SELECT image_name FROM ".TABLE_PRODUCTS_IMAGES." WHERE products_id = '".xtc_db_input($product_id)."'");
		while ($mo_images_values = xtc_db_fetch_array($mo_images_query)) {
			$duplicate_more_image_query = xtc_db_query("SELECT count(*) AS total FROM ".TABLE_PRODUCTS_IMAGES." WHERE image_name = '".$mo_images_values['image_name']."'");
			$duplicate_more_image = xtc_db_fetch_array($duplicate_more_image_query);
			if ($duplicate_more_image['total'] < 2) {
				xtc_del_image_file($mo_images_values['image_name']);
			}
		}


		
		xtc_db_query("DELETE FROM ".TABLE_SPECIALS." WHERE products_id = '".xtc_db_input($product_id)."'");
		xtc_db_query("DELETE FROM ".TABLE_PRODUCTS." WHERE products_id = '".xtc_db_input($product_id)."'");
		xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_IMAGES." WHERE products_id = '".xtc_db_input($product_id)."'");
		xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_TO_CATEGORIES." WHERE products_id = '".xtc_db_input($product_id)."'");
		xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_DESCRIPTION." WHERE products_id = '".xtc_db_input($product_id)."'");
		xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_ATTRIBUTES." WHERE products_id = '".xtc_db_input($product_id)."'");
		xtc_db_query("DELETE FROM ".TABLE_CUSTOMERS_BASKET." WHERE products_id = '".xtc_db_input($product_id)."'");
		xtc_db_query("DELETE FROM ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." WHERE products_id = '".xtc_db_input($product_id)."'");

		$customers_status_array = xtc_get_customers_statuses();
		for ($i = 0, $n = sizeof($customers_status_array); $i < $n; $i ++) {
			if (isset($customers_statuses_array[$i]['id']))
				xtc_db_query("delete from personal_offers_by_customers_status_".$customers_statuses_array[$i]['id']." where products_id = '".xtc_db_input($product_id)."'");
		}

		$product_reviews_query = xtc_db_query("select reviews_id from ".TABLE_REVIEWS." where products_id = '".xtc_db_input($product_id)."'");
		while ($product_reviews = xtc_db_fetch_array($product_reviews_query)) {
			xtc_db_query("delete from ".TABLE_REVIEWS_DESCRIPTION." where reviews_id = '".$product_reviews['reviews_id']."'");
		}

		xtc_db_query("delete from ".TABLE_REVIEWS." where products_id = '".xtc_db_input($product_id)."'");

		if (USE_CACHE == 'true') {
			xtc_reset_cache_block('categories');
			xtc_reset_cache_block('also_purchased');
		}

	} // remove_product ends

	// ----------------------------------------------------------------------------------------------------- //  

	// deletes given product from categories, removes it completely if no category is left

	function delete_product($product_id, $product_categories) {

		for ($i = 0, $n = sizeof($product_categories); $i < $n; $i ++) {

			xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_TO_CATEGORIES."
											              WHERE products_id   = '".xtc_db_input($product_id)."'
											              AND categories_id = '".xtc_db_input($product_categories[$i])."'");
		if (($product_categories[$i]) == 0) {
			$this->set_product_startpage($product_id, 0);
										  }
										}
 
		$product_categories_query = xtc_db_query("SELECT COUNT(*) AS total
								                                            FROM ".TABLE_PRODUCTS_TO_CATEGORIES."
								                                           WHERE products_id = '".xtc_db_input($product_id)."'");

		$product_categories = xtc_db_fetch_array($product_categories_query);

		if ($product_categories['total'] == '0') {
			$this->remove_product($product_id);
		}

	} // delete_product ends

	// ----------------------------------------------------------------------------------------------------- //				   

	// inserts / updates a product from given data

	function insert_product($products_data, $dest_category_id, $action = 'insert') {

		$products_id = xtc_db_prepare_input($products_data['products_id']);
		$products_date_available = xtc_db_prepare_input($products_data['products_date_available']);

		$products_date_available = (date('Y-m-d') < $products_date_available) ? $products_date_available : 'null';
 
         if ($products_data['products_startpage'] == 1 ) {
         	$this->link_product($products_data['products_id'], 0);
         	$products_status = 1;
         } else {
         	$products_status = xtc_db_prepare_input($products_data['products_status']);
         	}
         	
         if ($products_data['products_startpage'] == 0 ) {
 			$products_status = xtc_db_prepare_input($products_data['products_status']);
         }
         
		if (PRICE_IS_BRUTTO == 'true' && $products_data['products_price']) {
			$products_data['products_price'] = round(($products_data['products_price'] / (xtc_get_tax_rate($products_data['products_tax_class_id']) + 100) * 100), PRICE_PRECISION);
		}


		
		//
		$customers_statuses_array = xtc_get_customers_statuses();

		$permission = array ();
		for ($i = 0; $n = sizeof($customers_statuses_array), $i < $n; $i ++) {
			if (isset($customers_statuses_array[$i]['id']))
				$permission[$customers_statuses_array[$i]['id']] = 0;
		}
		if (isset ($products_data['groups']))
			foreach ($products_data['groups'] AS $dummy => $b) {
				$permission[$b] = 1;
			}
		// build array
		if ($permission['all']==1) {
			$permission = array ();
			end($customers_statuses_array);
			for ($i = 0; $n = key($customers_statuses_array), $i < $n+1; $i ++) {
				if (isset($customers_statuses_array[$i]['id']))
					$permission[$customers_statuses_array[$i]['id']] = 1;
			}
		}
		

		$permission_array = array ();
		
		
		// set pointer to last key
		end($customers_statuses_array);		
		for ($i = 0; $n = key($customers_statuses_array), $i < $n+1; $i ++) {
			if (isset($customers_statuses_array[$i]['id'])) {
				$permission_array = array_merge($permission_array, array ('group_permission_'.$customers_statuses_array[$i]['id'] => $permission[$customers_statuses_array[$i]['id']]));
			}
		}
		//
		$sql_data_array = array ('products_quantity' => xtc_db_prepare_input($products_data['products_quantity']), 'products_model' => xtc_db_prepare_input($products_data['products_model']), 'products_ean' => xtc_db_prepare_input($products_data['products_ean']), 'products_price' => xtc_db_prepare_input($products_data['products_price']), 'products_sort' => xtc_db_prepare_input($products_data['products_sort']), 'products_shippingtime' => xtc_db_prepare_input($products_data['shipping_status']), 'products_discount_allowed' => xtc_db_prepare_input($products_data['products_discount_allowed']), 'products_date_available' => $products_date_available, 'products_weight' => xtc_db_prepare_input($products_data['products_weight']), 'products_status' => $products_status, 'products_startpage' => xtc_db_prepare_input($products_data['products_startpage']), 'products_startpage_sort' => xtc_db_prepare_input($products_data['products_startpage_sort']), 'products_tax_class_id' => xtc_db_prepare_input($products_data['products_tax_class_id']), 'product_template' => xtc_db_prepare_input($products_data['info_template']), 'options_template' => xtc_db_prepare_input($products_data['options_template']), 'manufacturers_id' => xtc_db_prepare_input($products_data['manufacturers_id']), 'products_fsk18' => xtc_db_prepare_input($products_data['fsk18']), 'products_vpe_value' => xtc_db_prepare_input($products_data['products_vpe_value']), 'products_vpe_status' => xtc_db_prepare_input($products_data['products_vpe_status']), 'products_vpe' => xtc_db_prepare_input($products_data['products_vpe']));
		$sql_data_array = array_merge($sql_data_array, $permission_array);
		//get the next ai-value from table products if no products_id is set
		if (!$products_id || $products_id == '') {
			$new_pid_query = xtc_db_query("SHOW TABLE STATUS LIKE '".TABLE_PRODUCTS."'");
			$new_pid_query_values = xtc_db_fetch_array($new_pid_query);
			$products_id = $new_pid_query_values['Auto_increment'];
		}

		//prepare products_image filename
		if ($products_image = xtc_try_upload('products_image', DIR_FS_CATALOG_ORIGINAL_IMAGES, '777', '')) {
			$pname_arr = explode('.', $products_image->filename);
			$nsuffix = array_pop($pname_arr);
			$products_image_name = $products_id.'_0.'.$nsuffix;
			$dup_check_query = xtDBquery("SELECT COUNT(*) AS total
								                                FROM ".TABLE_PRODUCTS."
								                               WHERE products_image = '".$products_data['products_previous_image_0']."'");
			$dup_check = xtc_db_fetch_array($dup_check_query);
			if ($dup_check['total'] < 2) {
				@ xtc_del_image_file($products_data['products_previous_image_0']);
			}
			//workaround if there are v2 images mixed with v3
			$dup_check_query = xtDBquery("SELECT COUNT(*) AS total
								                                FROM ".TABLE_PRODUCTS."
								                               WHERE products_image = '".$products_image->filename."'");
			$dup_check = xtc_db_fetch_array($dup_check_query);
			if ($dup_check['total'] == 0) {
				rename(DIR_FS_CATALOG_ORIGINAL_IMAGES.$products_image->filename, DIR_FS_CATALOG_ORIGINAL_IMAGES.$products_image_name);
			} else {
				copy(DIR_FS_CATALOG_ORIGINAL_IMAGES.$products_image->filename, DIR_FS_CATALOG_ORIGINAL_IMAGES.$products_image_name);
			}
			$sql_data_array['products_image'] = xtc_db_prepare_input($products_image_name);

			require (DIR_WS_INCLUDES.'product_thumbnail_images.php');
			require (DIR_WS_INCLUDES.'product_info_images.php');
			require (DIR_WS_INCLUDES.'product_popup_images.php');

		} else {
			$products_image_name = $products_data['products_previous_image_0'];
		}

		//are we asked to delete some pics?
		if ($products_data['del_pic'] != '') {
			$dup_check_query = xtDBquery("SELECT COUNT(*) AS total
								                                FROM ".TABLE_PRODUCTS."
								                               WHERE products_image = '".$products_data['del_pic']."'");
			$dup_check = xtc_db_fetch_array($dup_check_query);
			if ($dup_check['total'] < 2)
				@ xtc_del_image_file($products_data['del_pic']);
			xtc_db_query("UPDATE ".TABLE_PRODUCTS."
								                 SET products_image = ''
								               WHERE products_id    = '".xtc_db_input($products_id)."'");
		}

		if ($products_data['del_mo_pic'] != '') {
			foreach ($products_data['del_mo_pic'] AS $dummy => $val) {
				$dup_check_query = xtDBquery("SELECT COUNT(*) AS total
											                                FROM ".TABLE_PRODUCTS_IMAGES."
											                               WHERE image_name = '".$val."'");
				$dup_check = xtc_db_fetch_array($dup_check_query);
				if ($dup_check['total'] < 2)
					@ xtc_del_image_file($val);
				xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_IMAGES."
											               WHERE products_id = '".xtc_db_input($products_id)."'
											                 AND image_name  = '".$val."'");
			}
		}

		//MO_PICS
		for ($img = 0; $img < MO_PICS; $img ++) {
			if ($pIMG = & xtc_try_upload('mo_pics_'.$img, DIR_FS_CATALOG_ORIGINAL_IMAGES, '777', '')) {
				$pname_arr = explode('.', $pIMG->filename);
				$nsuffix = array_pop($pname_arr);
				$products_image_name = $products_id.'_'. ($img +1).'.'.$nsuffix;
				$dup_check_query = xtDBquery("SELECT COUNT(*) AS total
											                                FROM ".TABLE_PRODUCTS_IMAGES."
											                               WHERE image_name = '".$products_data['products_previous_image_'. ($img +1)]."'");
				$dup_check = xtc_db_fetch_array($dup_check_query);
				if ($dup_check['total'] < 2)
					@ xtc_del_image_file($products_data['products_previous_image_'. ($img +1)]);
				@ xtc_del_image_file($products_image_name);
				rename(DIR_FS_CATALOG_ORIGINAL_IMAGES.'/'.$pIMG->filename, DIR_FS_CATALOG_ORIGINAL_IMAGES.'/'.$products_image_name);
				//get data & write to table
				$mo_img = array ('products_id' => xtc_db_prepare_input($products_id), 'image_nr' => xtc_db_prepare_input($img +1), 'image_name' => xtc_db_prepare_input($products_image_name));
				if ($action == 'insert') {
					xtc_db_perform(TABLE_PRODUCTS_IMAGES, $mo_img);
				}
				elseif ($action == 'update' && $products_data['products_previous_image_'. ($img +1)]) {
					if ($products_data['del_mo_pic']) {
						foreach ($products_data['del_mo_pic'] AS $dummy => $val) {
							if ($val == $products_data['products_previous_image_'. ($img +1)])
								xtc_db_perform(TABLE_PRODUCTS_IMAGES, $mo_img);
							break;
						}
					}
					xtc_db_perform(TABLE_PRODUCTS_IMAGES, $mo_img, 'update', 'image_name = \''.xtc_db_input($products_data['products_previous_image_'. ($img +1)]).'\'');
				}
				elseif (!$products_data['products_previous_image_'. ($img +1)]) {
					xtc_db_perform(TABLE_PRODUCTS_IMAGES, $mo_img);
				}
				//image processing
				require (DIR_WS_INCLUDES.'product_thumbnail_images.php');
				require (DIR_WS_INCLUDES.'product_info_images.php');
				require (DIR_WS_INCLUDES.'product_popup_images.php');

			}
		}

		if (isset ($products_data['products_image']) && xtc_not_null($products_data['products_image']) && ($products_data['products_image'] != 'none')) {
			$sql_data_array['products_image'] = xtc_db_prepare_input($products_data['products_image']);
		}

		if ($action == 'insert') {
			$insert_sql_data = array ('products_date_added' => 'now()');
			$sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
			xtc_db_perform(TABLE_PRODUCTS, $sql_data_array);
			$products_id = xtc_db_insert_id();
			xtc_db_query("INSERT INTO ".TABLE_PRODUCTS_TO_CATEGORIES."
								              SET products_id   = '".$products_id."',
								              categories_id = '".$dest_category_id."'");
		}
		elseif ($action == 'update') {
			$update_sql_data = array ('products_last_modified' => 'now()');
			$sql_data_array = xtc_array_merge($sql_data_array, $update_sql_data);
			xtc_db_perform(TABLE_PRODUCTS, $sql_data_array, 'update', 'products_id = \''.xtc_db_input($products_id).'\'');
		}

		$languages = xtc_get_languages();
		// Here we go, lets write Group prices into db
		// start
		$i = 0;
		$group_query = xtc_db_query("SELECT customers_status_id
					                               FROM ".TABLE_CUSTOMERS_STATUS."
					                              WHERE language_id = '".(int) $_SESSION['languages_id']."'
					                                AND customers_status_id != '0'");
		while ($group_values = xtc_db_fetch_array($group_query)) {
			// load data into array
			$i ++;
			$group_data[$i] = array ('STATUS_ID' => $group_values['customers_status_id']);
		}
		for ($col = 0, $n = sizeof($group_data); $col < $n +1; $col ++) {
			if ($group_data[$col]['STATUS_ID'] != '') {
				$personal_price = xtc_db_prepare_input($products_data['products_price_'.$group_data[$col]['STATUS_ID']]);
				if ($personal_price == '' || $personal_price == '0.0000') {
					$personal_price = '0.00';
				} else {
					if (PRICE_IS_BRUTTO == 'true') {
						$personal_price = ($personal_price / (xtc_get_tax_rate($products_data['products_tax_class_id']) + 100) * 100);
					}
					$personal_price = xtc_round($personal_price, PRICE_PRECISION);
				}

				if ($action == 'insert') {

					xtc_db_query("DELETE FROM personal_offers_by_customers_status_".$group_data[$col]['STATUS_ID']." WHERE products_id = '".$products_id."'
												                 AND quantity    = '1'");

					$insert_array = array ();
					$insert_array = array ('personal_offer' => $personal_price, 'quantity' => '1', 'products_id' => $products_id);
					xtc_db_perform("personal_offers_by_customers_status_".$group_data[$col]['STATUS_ID'], $insert_array);

				} else {

					xtc_db_query("UPDATE personal_offers_by_customers_status_".$group_data[$col]['STATUS_ID']."
												                 SET personal_offer = '".$personal_price."'
												               WHERE products_id = '".$products_id."'
												                 AND quantity    = '1'");

				}
			}
		}
		// end
		// ok, lets check write new staffelpreis into db (if there is one)
		$i = 0;
		$group_query = xtc_db_query("SELECT customers_status_id
					                               FROM ".TABLE_CUSTOMERS_STATUS."
					                              WHERE language_id = '".(int) $_SESSION['languages_id']."'
					                                AND customers_status_id != '0'");
		while ($group_values = xtc_db_fetch_array($group_query)) {
			// load data into array
			$i ++;
			$group_data[$i] = array ('STATUS_ID' => $group_values['customers_status_id']);
		}
		for ($col = 0, $n = sizeof($group_data); $col < $n +1; $col ++) {
			if ($group_data[$col]['STATUS_ID'] != '') {
				$quantity = xtc_db_prepare_input($products_data['products_quantity_staffel_'.$group_data[$col]['STATUS_ID']]);
				$staffelpreis = xtc_db_prepare_input($products_data['products_price_staffel_'.$group_data[$col]['STATUS_ID']]);
				if (PRICE_IS_BRUTTO == 'true') {
					$staffelpreis = ($staffelpreis / (xtc_get_tax_rate($products_data['products_tax_class_id']) + 100) * 100);
				}
				$staffelpreis = xtc_round($staffelpreis, PRICE_PRECISION);

				if ($staffelpreis != '' && $quantity != '') {
					// ok, lets check entered data to get rid of user faults
					if ($quantity <= 1)
						$quantity = 2;
					$check_query = xtc_db_query("SELECT quantity
														                               FROM personal_offers_by_customers_status_".$group_data[$col]['STATUS_ID']."
														                              WHERE products_id = '".$products_id."'
														                                AND quantity    = '".$quantity."'");
					// dont insert if same qty!
					if (xtc_db_num_rows($check_query) < 1) {
						xtc_db_query("INSERT INTO personal_offers_by_customers_status_".$group_data[$col]['STATUS_ID']."
																	                 SET price_id       = '',
																	                     products_id    = '".$products_id."',
																	                     quantity       = '".$quantity."',
																	                     personal_offer = '".$staffelpreis."'");
					}
				}
			}
		}
		foreach ($languages AS $lang) {
			$language_id = $lang['id'];
			$sql_data_array = array ('products_name' => xtc_db_prepare_input($products_data['products_name'][$language_id]), 'products_description' => xtc_db_prepare_input($products_data['products_description_'.$language_id]), 'products_short_description' => xtc_db_prepare_input($products_data['products_short_description_'.$language_id]), 'products_keywords' => xtc_db_prepare_input($products_data['products_keywords'][$language_id]), 'products_url' => xtc_db_prepare_input($products_data['products_url'][$language_id]), 'products_meta_title' => xtc_db_prepare_input($products_data['products_meta_title'][$language_id]), 'products_meta_description' => xtc_db_prepare_input($products_data['products_meta_description'][$language_id]), 'products_meta_keywords' => xtc_db_prepare_input($products_data['products_meta_keywords'][$language_id]));

			if ($action == 'insert') {
				$insert_sql_data = array ('products_id' => $products_id, 'language_id' => $language_id);
				$sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
				xtc_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);
			}
			elseif ($action == 'update') {
				xtc_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', 'products_id = \''.xtc_db_input($products_id).'\' and language_id = \''.$language_id.'\'');
			}
		}
	} // insert_product ends

	// ----------------------------------------------------------------------------------------------------- //   

	// duplicates a product by id into specified category by id

	function duplicate_product($src_products_id, $dest_categories_id) {

		$product_query = xtDBquery("SELECT *
				    	                                 FROM ".TABLE_PRODUCTS."
				    	                                WHERE products_id = '".xtc_db_input($src_products_id)."'");

		$product = xtc_db_fetch_array($product_query);
		if ($dest_categories_id == 0) { $startpage = 1; $products_status = 1; } else { $startpage= 0; $products_status = $product['products_status'];}
		
		$sql_data_array=array('products_quantity'=>$product['products_quantity'],
						'products_model'=>$product['products_model'],
						'products_ean'=>$product['products_ean'],
						'products_shippingtime'=>$product['products_shippingtime'],
						'products_sort'=>$product['products_sort'],
						'products_startpage'=>$startpage,
						'products_sort'=>$product['products_sort'],
						'products_price'=>$product['products_price'],
						'products_discount_allowed'=>$product['products_discount_allowed'],
						'products_date_added'=>'NOW()',
						'products_date_available'=>$product['products_date_available'],
						'products_weight'=>$product['products_weight'],
						'products_status'=>$products_status,
						'products_tax_class_id'=>$product['products_tax_class_id'],
						'manufacturers_id'=>$product['manufacturers_id'],
						'product_template'=>$product['product_template'],
						'options_template'=>$product['options_template'],
						'products_fsk18'=>$product['products_fsk18'],
						);		
						
		$customers_statuses_array = xtc_get_customers_statuses();

		for ($i = 0; $n = sizeof($customers_statuses_array), $i < $n; $i ++) {
			if (isset($customers_statuses_array[$i]['id']))
				$sql_data_array = array_merge($sql_data_array, array ('group_permission_'.$customers_statuses_array[$i]['id'] => $product['group_permission_'.$customers_statuses_array[$i]['id']]));

		}
		
		xtc_db_perform(TABLE_PRODUCTS, $sql_data_array);

		//get duplicate id
		$dup_products_id = xtc_db_insert_id();
		
		//duplicate image if there is one
		if ($product['products_image'] != '') {

			//build new image_name for duplicate
			$pname_arr = explode('.', $product['products_image']);
			$nsuffix = array_pop($pname_arr);
			$dup_products_image_name = $dup_products_id.'_0'.'.'.$nsuffix;

			//write to DB
			xtDBquery("UPDATE ".TABLE_PRODUCTS." SET products_image = '".$dup_products_image_name."' WHERE products_id = '".$dup_products_id."'");

			@ copy(DIR_FS_CATALOG_ORIGINAL_IMAGES.'/'.$product['products_image'], DIR_FS_CATALOG_ORIGINAL_IMAGES.'/'.$dup_products_image_name);
			@ copy(DIR_FS_CATALOG_INFO_IMAGES.'/'.$product['products_image'], DIR_FS_CATALOG_INFO_IMAGES.'/'.$dup_products_image_name);
			@ copy(DIR_FS_CATALOG_THUMBNAIL_IMAGES.'/'.$product['products_image'], DIR_FS_CATALOG_THUMBNAIL_IMAGES.'/'.$dup_products_image_name);
			@ copy(DIR_FS_CATALOG_POPUP_IMAGES.'/'.$product['products_image'], DIR_FS_CATALOG_POPUP_IMAGES.'/'.$dup_products_image_name);

		} else {
			unset ($dup_products_image_name);
		}

		$description_query = xtc_db_query("SELECT *
				    	                                     FROM ".TABLE_PRODUCTS_DESCRIPTION."
				    	                                    WHERE products_id = '".xtc_db_input($src_products_id)."'");

		$old_products_id = xtc_db_input($src_products_id);
		while ($description = xtc_db_fetch_array($description_query)) {
			xtc_db_query("INSERT INTO ".TABLE_PRODUCTS_DESCRIPTION."
						    		                 SET products_id                = '".$dup_products_id."',                                      
						    		                     language_id                = '".$description['language_id']."',                           
						    		                     products_name              = '".addslashes($description['products_name'])."',             
						    		                     products_description       = '".addslashes($description['products_description'])."',      
						    		                     products_keywords          = '".addslashes($description['products_keywords'])."',
						    		                     products_short_description = '".addslashes($description['products_short_description'])."',
						    		                     products_meta_title        = '".addslashes($description['products_meta_title'])."',       
						    		                     products_meta_description  = '".addslashes($description['products_meta_description'])."', 
						    		                     products_meta_keywords     = '".addslashes($description['products_meta_keywords'])."',    
						    		                     products_url               = '".$description['products_url']."',                          
						    		                     products_viewed            = '0'");
		}

		xtc_db_query("INSERT INTO ".TABLE_PRODUCTS_TO_CATEGORIES."
				    	                 SET products_id   = '".$dup_products_id."',
				    	                     categories_id = '".xtc_db_input($dest_categories_id)."'");

		//mo_images by Novalis@eXanto.de
		$mo_images = xtc_get_products_mo_images($src_products_id);
		if (is_array($mo_images)) {
			foreach ($mo_images AS $dummy => $mo_img) {

				//build new image_name for duplicate
				$pname_arr = explode('.', $mo_img['image_name']);
				$nsuffix = array_pop($pname_arr);
				$dup_products_image_name = $dup_products_id.'_'.$mo_img['image_nr'].'.'.$nsuffix;

				//copy org images to duplicate
				@ copy(DIR_FS_CATALOG_ORIGINAL_IMAGES.'/'.$mo_img['image_name'], DIR_FS_CATALOG_ORIGINAL_IMAGES.'/'.$dup_products_image_name);
				@ copy(DIR_FS_CATALOG_INFO_IMAGES.'/'.$mo_img['image_name'], DIR_FS_CATALOG_INFO_IMAGES.'/'.$dup_products_image_name);
				@ copy(DIR_FS_CATALOG_THUMBNAIL_IMAGES.'/'.$mo_img['image_name'], DIR_FS_CATALOG_THUMBNAIL_IMAGES.'/'.$dup_products_image_name);
				@ copy(DIR_FS_CATALOG_POPUP_IMAGES.'/'.$mo_img['image_name'], DIR_FS_CATALOG_POPUP_IMAGES.'/'.$dup_products_image_name);

				xtc_db_query("INSERT INTO ".TABLE_PRODUCTS_IMAGES."
								    			                 SET products_id = '".$dup_products_id."',
								    			                     image_nr    = '".$mo_img['image_nr']."',
								    			                     image_name  = '".$dup_products_image_name."'");
			}
		}
		//mo_images EOF

		$products_id = $dup_products_id;

		$i = 0;
		$group_query = xtc_db_query("SELECT customers_status_id
				    	                               FROM ".TABLE_CUSTOMERS_STATUS."
				    	                              WHERE language_id = '".(int) $_SESSION['languages_id']."'
				    	                                AND customers_status_id != '0'");

		while ($group_values = xtc_db_fetch_array($group_query)) {
			// load data into array
			$i ++;
			$group_data[$i] = array ('STATUS_ID' => $group_values['customers_status_id']);
		}

		for ($col = 0, $n = sizeof($group_data); $col < $n +1; $col ++) {
			if ($group_data[$col]['STATUS_ID'] != '') {

				$copy_query = xtc_db_query("SELECT quantity,
								    			                                   personal_offer
								    			                              FROM personal_offers_by_customers_status_".$group_data[$col]['STATUS_ID']."
								    			                             WHERE products_id = '".$old_products_id."'");

				while ($copy_data = xtc_db_fetch_array($copy_query)) {
					xtc_db_query("INSERT INTO personal_offers_by_customers_status_".$group_data[$col]['STATUS_ID']."
										    				                 SET price_id       = '',
										    				                     products_id    = '".$products_id."',
										    				                     quantity       = '".$copy_data['quantity']."',
										    				                     personal_offer = '".$copy_data['personal_offer']."'");
				}
			}

		}
	} //duplicate_product ends

	// ----------------------------------------------------------------------------------------------------- //   

	// links a product into specified category by id

	function link_product($src_products_id, $dest_categories_id) {
		global $messageStack;
		$check_query = xtc_db_query("SELECT COUNT(*) AS total
				                                     FROM ".TABLE_PRODUCTS_TO_CATEGORIES."
				                                     WHERE products_id   = '".xtc_db_input($src_products_id)."'
				                                     AND   categories_id = '".xtc_db_input($dest_categories_id)."'");
		$check = xtc_db_fetch_array($check_query);

		if ($check['total'] < '1') {
			xtc_db_query("INSERT INTO ".TABLE_PRODUCTS_TO_CATEGORIES."
						                          SET products_id   = '".xtc_db_input($src_products_id)."',
						                          categories_id = '".xtc_db_input($dest_categories_id)."'");
						                   
	    if ($dest_categories_id == 0) {
			$this->set_product_status($src_products_id, $products_status);
			$this->set_product_startpage($src_products_id, 1);
	    							   }
		} else {
			$messageStack->add_session(ERROR_CANNOT_LINK_TO_SAME_CATEGORY, 'error');
		}
	} // link_product ends

	// ----------------------------------------------------------------------------------------------------- //

	// moves a product from category into specified category

	function move_product($src_products_id, $src_category_id, $dest_category_id) {
		$duplicate_check_query = xtc_db_query("SELECT COUNT(*) AS total
				    	                                         FROM ".TABLE_PRODUCTS_TO_CATEGORIES."
				    	                                        WHERE products_id   = '".xtc_db_input($src_products_id)."'
				    	                                          AND categories_id = '".xtc_db_input($dest_category_id)."'");
		$duplicate_check = xtc_db_fetch_array($duplicate_check_query);

		if ($duplicate_check['total'] < 1) {
			xtc_db_query("UPDATE ".TABLE_PRODUCTS_TO_CATEGORIES."
						    		                 SET categories_id = '".xtc_db_input($dest_category_id)."'
						    		                 WHERE products_id   = '".xtc_db_input($src_products_id)."'
						    		                 AND categories_id = '".$src_category_id."'");
						    		           
		if ($dest_category_id == 0) {			
			$this->set_product_status($src_products_id, 1);
			$this->set_product_startpage($src_products_id, 1);
	    							   } 

		if ($src_category_id == 0) {
			 $this->set_product_status($src_products_id, $products_status);
			 $this->set_product_startpage($src_products_id, 0);
	    							   }				    		                 
		}
	}

	// ----------------------------------------------------------------------------------------------------- // 

	// Sets the status of a product
	function set_product_status($products_id, $status) {
		if ($status == '1') {
			return xtc_db_query("update ".TABLE_PRODUCTS." set products_status = '1', products_last_modified = now() where products_id = '".$products_id."'");
		}
		elseif ($status == '0') {
			return xtc_db_query("update ".TABLE_PRODUCTS." set products_status = '0', products_last_modified = now() where products_id = '".$products_id."'");
		} else {
			return -1;
		}
	}
	
	// ----------------------------------------------------------------------------------------------------- // 

	// Sets a product active on startpage
	function set_product_startpage($products_id, $status) {
		if ($status == '1') {
			return xtc_db_query("update ".TABLE_PRODUCTS." set products_startpage = '1', products_last_modified = now() where products_id = '".$products_id."'");
		}
		elseif ($status == '0') {
			return xtc_db_query("update ".TABLE_PRODUCTS." set products_startpage = '0', products_last_modified = now() where products_id = '".$products_id."'");
		} else {
			return -1;
		}
	}

	// ----------------------------------------------------------------------------------------------------- //  

	// Counts how many products exist in a category
	function count_category_products($category_id, $include_deactivated = false) {
		$products_count = 0;
		if ($include_deactivated) {
			$products_query = xtc_db_query("select count(*) as total from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c where p.products_id = p2c.products_id and p2c.categories_id = '".$category_id."'");
		} else {
			$products_query = xtc_db_query("select count(*) as total from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c where p.products_id = p2c.products_id and p.products_status = '1' and p2c.categories_id = '".$category_id."'");
		}

		$products = xtc_db_fetch_array($products_query);

		$products_count += $products['total'];

		$childs_query = xtc_db_query("select categories_id from ".TABLE_CATEGORIES." where parent_id = '".$category_id."'");
		if (xtc_db_num_rows($childs_query)) {
			while ($childs = xtc_db_fetch_array($childs_query)) {
				$products_count += $this->count_category_products($childs['categories_id'], $include_deactivated);
			}
		}
		return $products_count;
	}

	// ----------------------------------------------------------------------------------------------------- //  

	// Counts how many subcategories exist in a category
	function count_category_childs($category_id) {
		$categories_count = 0;
		$categories_query = xtc_db_query("select categories_id from ".TABLE_CATEGORIES." where parent_id = '".$category_id."'");
		while ($categories = xtc_db_fetch_array($categories_query)) {
			$categories_count ++;
			$categories_count += $this->count_category_childs($categories['categories_id']);
		}
		return $categories_count;
	}
	
	
	function edit_cross_sell($cross_data) {
		
		if ($cross_data['special'] == 'add_entries') {

				if (isset ($cross_data['ids'])) {
					foreach ($cross_data['ids'] AS $pID) {

						$sql_data_array = array ('products_id' => $cross_data['current_product_id'], 'xsell_id' => $pID,'products_xsell_grp_name_id'=>$cross_data['group_name'][$pID]);
						
						// check if product is already linked
						$check_query = xtc_db_query("SELECT * FROM ".TABLE_PRODUCTS_XSELL." WHERE products_id='".$cross_data['current_product_id']."' and xsell_id='".$pID."'");
						if (!xtc_db_num_rows($check_query)) xtc_db_perform(TABLE_PRODUCTS_XSELL, $sql_data_array);
					}
				}

			}
			if ($cross_data['special'] == 'edit') {

				if (isset ($cross_data['ids'])) {
					// delete
					foreach ($cross_data['ids'] AS $pID) {
						xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_XSELL." WHERE ID='".$pID."'");
					}
				}
				if (isset ($cross_data['sort'])) {
					// edit sorting
					foreach ($cross_data['sort'] AS $ID => $sort) {
						xtc_db_query("UPDATE ".TABLE_PRODUCTS_XSELL." SET sort_order='".$sort."',products_xsell_grp_name_id='".$cross_data['group_name'][$ID]."' WHERE ID='".$ID."'");
					}
				}
			}
	 
		
	}

	// ----------------------------------------------------------------------------------------------------- //  

} // class categories ENDS
?>

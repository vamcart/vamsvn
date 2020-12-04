<?php
/* -----------------------------------------------------------------------------------------
   $Id: ajaxBundleFind.php 1243 2009-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 Andrew Berezin (ajaxBundleFind.php,v 1.9 2003/08/17); zen-cart.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

	define("AJAX_QUICKSEARCH_RESULT", 'text'); // dropdown or text
	define("AJAX_QUICKSEARCH_DROPDOWN_SIZE", 5);
	define("AJAX_QUICKSEARCH_LIMIT", 1000);

	$q = addslashes(preg_replace("%[^0-9a-zA-Zа-яА-Я\s]%iu", "", $_REQUEST['keywords']) );

	$out = "";
	if(isset($q) && vam_not_null($q)) {

		$searchwords = explode(" ",$q);
		$nosearchwords = sizeof($searchwords);
		foreach($searchwords as $key => $value) {
			if ($value == '')
				unset($searchwords[$key]);
		}
		$searchwords = array_values($searchwords);
		$nosearchwords = sizeof($searchwords);
		foreach($searchwords as $key => $value) {
			$booltje = '+' . $searchwords[$key] . '*';
			$searchwords[$key] = $booltje;
		}
		$q = implode(" ",$searchwords);

		$products_query = vam_db_query("select distinct pd.products_id, pd.products_name, pd.products_keywords, p.products_model
							from " . TABLE_PRODUCTS_DESCRIPTION . " pd
							inner join " . TABLE_PRODUCTS . " p
							on (p.products_id = pd.products_id) LEFT JOIN products_to_categories as p2c2 ON (p2c2.products_id=p.products_id) LEFT JOIN categories as c ON (c.categories_id=p2c2.categories_id) 
							where (match (pd.products_name) against ('" . $q . "' in boolean mode)
							or match (p.products_model) against ('" . $q . "' in boolean mode) or match (pd.products_keywords) against ('" . $q . "' in boolean mode)" .
							($_REQUEST['search_in_description'] == '1' ? "or match (pd.products_description) against ('" . $q . "' in boolean mode)" : "") . ")
							and p.products_status = '1'
							and c.categories_status = '1'
							and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
							order by pd.products_name asc
							limit " . AJAX_QUICKSEARCH_LIMIT);

		if(vam_db_num_rows($products_query)) {
			$out .= sprintf(TEXT_AJAX_QUICKSEARCH_TOP, AJAX_QUICKSEARCH_LIMIT) . '<br />';
			$dropdown = array();
			echo '<option name="null" value="" SELECTED></option>';
			while($products = vam_db_fetch_array($products_query)) {
				$out .= '<option name="' . $products['products_id'] . '" value="' . $products['products_id'] . '">'.$products['products_name'].'</option>';
				$dropdown[] = array('id' => $products['products_id'],
														'text' => $products['products_name']);
			}
//			$out .= '
//					   <script>
//					   $(document).ready(function() {
//							$("#ajaxBundleFind").show();
//						$(document).click(function (){
//							$("#ajaxBundleFind").hide();
//						});		
//						});		
//						</script>	
//			';
			if(AJAX_QUICKSEARCH_RESULT == 'dropdown') {
				$out .= vam_draw_pull_down_menu('AJAX_QUICKSEARCH_pid', $dropdown, '', 'onChange="this.form.submit();" size="' . AJAX_QUICKSEARCH_DROPDOWN_SIZE . '" class="ajaxBundleFind"') . vam_hide_session_id();
			}
		}
	}
	echo $out;
?>
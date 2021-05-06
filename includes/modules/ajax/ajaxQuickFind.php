<?php
/* -----------------------------------------------------------------------------------------
   $Id: ajaxQuickFind.php 1243 2009-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 Andrew Berezin (ajaxQuickFind.php,v 1.9 2003/08/17); zen-cart.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

	define("AJAX_QUICKSEARCH_RESULT", 'text'); // dropdown or text
	define("AJAX_QUICKSEARCH_DROPDOWN_SIZE", 5);
	define("AJAX_QUICKSEARCH_LIMIT", 10);

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

//fsk18 lock
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}

		$products_query = vam_db_query("select distinct pd.products_id, pd.products_name, pd.products_keywords, p.products_image, p.products_tax_class_id, p.products_model
							from " . TABLE_PRODUCTS_DESCRIPTION . " pd
							inner join " . TABLE_PRODUCTS . " p
							on (p.products_id = pd.products_id) LEFT JOIN products_to_categories as p2c2 ON (p2c2.products_id=p.products_id) LEFT JOIN categories as c ON (c.categories_id=p2c2.categories_id) 
							where (match (pd.products_name) against ('" . $q . "' in boolean mode)
							or match (p.products_model) against ('" . $q . "' in boolean mode) or match (pd.products_keywords) against ('" . $q . "' in boolean mode)" .
							($_REQUEST['search_in_description'] == '1' ? "or match (pd.products_description) against ('" . $q . "' in boolean mode)" : "") . ")
							and p.products_status = '1'
							".$group_check."
							".$fsk_lock."
							and c.categories_status = '1'
							and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
							order by pd.products_name asc
							limit " . AJAX_QUICKSEARCH_LIMIT);

		if(vam_db_num_rows($products_query)) {
			$dropdown = array();
			$out .= '
<div id="searchPreview">
<table class="table table-sm table-striped table-hover">
  <thead>
	<tr>
		<th colspan="3">'.sprintf(TEXT_AJAX_QUICKSEARCH_TOP, AJAX_QUICKSEARCH_LIMIT).'</th>
	</tr>
	</thead>
  <tbody>			
			
			';
			while($products = vam_db_fetch_array($products_query)) {

		$quick_find_products_price = $vamPrice->GetPrice($products['products_id'], $format = true, 1, $products['product_tax_class_id'], $products['products_price'], 1);
		$quick_find_price = $quick_find_products_price['formated'];

		if ($products['products_image'] != '')
			$image = DIR_WS_INFO_IMAGES.$products['products_image'];
	   
	   if (!file_exists($image)) $image = DIR_WS_IMAGES.'product_images/noimage.png';

				$out .= '
				
	<tr>
		<td class="text-center"><img class="media-object" src="'.$image.'" alt="'.$products['products_name'].'" width="40" height="40" /></td>
		<td><a href="' . vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($products['products_id'], $products['products_name']), 'NONSSL', false) . '">' . $products['products_name'] . '</a></td>
		<td>'.$quick_find_price.'</td>
	</tr>
				
				
				' . "\n";
				$dropdown[] = array('id' => $products['products_id'],
														'text' => $products['products_name']);
			}
			$out .= '
			
	<tr>
      <td colspan="3" class="text-center"><a href="'.DIR_WS_CATALOG.FILENAME_ADVANCED_SEARCH_RESULT.'?keywords='.htmlspecialchars(vam_db_input($_REQUEST['keywords'])).'">'.TEXT_SHOW_ALL.'</a></td>
	</tr>
  </tbody>
</table>			
</div>			
			' . "\n";
			$out .= '
					   <script>
					   $(document).ready(function() {
							$("#ajaxQuickFind").show();
						$(document).click(function (){
							$("#ajaxQuickFind").hide();
						});		
						});		
						</script>	
			';
			if(AJAX_QUICKSEARCH_RESULT == 'dropdown') {
				$out .= vam_draw_pull_down_menu('AJAX_QUICKSEARCH_pid', $dropdown, '', 'onChange="this.form.submit();" size="' . AJAX_QUICKSEARCH_DROPDOWN_SIZE . '" class="ajaxQuickFind"') . vam_hide_session_id();
			}
		}
	}
	echo $out;
?>
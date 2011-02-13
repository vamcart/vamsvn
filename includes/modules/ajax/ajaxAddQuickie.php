<?php
/* -----------------------------------------------------------------------------------------
   $Id: ajaxAddQuickie.php 1243 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 Andrew Berezin (ajaxAddQuickie.php,v 1.9 2003/08/17); zen-cart.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

//var_dump($_POST);echo '<br>';
	define("AJAX_ADDQUICK_RESULT", 'text'); // dropdown or text
	define("AJAX_ADDQUICK_DROPDOWN_SIZE", 5);
	define("AJAX_ADDQUICK_LIMIT", 15);

	$q = addslashes(preg_replace("%[^0-9a-zA-Zа-яА-Я\s]%iu", "", $_REQUEST['quickie']) );

	$out = "";
	if(isset($q) && vam_not_null($q)) {

		$model_query = vam_db_query("select pd.products_id, pd.products_name, p.products_model
							from " . TABLE_PRODUCTS_DESCRIPTION . " pd
							inner join " . TABLE_PRODUCTS . " p
							on (p.products_id = pd.products_id)
							where p.products_model like '%" . $q . "%' 
							and p.products_status = '1'
							and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
							order by pd.products_name asc
							limit " . AJAX_ADDQUICK_LIMIT);

		if(vam_db_num_rows($model_query)) {
			$out .= sprintf(TEXT_AJAX_ADDQUICKIE_SEARCH_TOP, AJAX_ADDQUICK_LIMIT) . '<br />';
			$dropdown = array();
			$out .= '<ul class="ajaxAddQuickie">';
			while($model = vam_db_fetch_array($model_query)) {
				$out .= '<li class="ajaxAddQuickie"><a href="' . vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($model['products_id'], $model['products_name']), 'NONSSL', false) . '">' . $model['products_name'] . '</a></li>' . "\n";
				$dropdown[] = array('id' => $model['products_id'],
														'text' => $model['products_name']);
			}
			$out .= '</ul>' . "\n";
			if(AJAX_ADDQUICK_RESULT == 'dropdown') {
				$out .= vam_draw_pull_down_menu('AJAX_ADDQUICK_pid', $dropdown, '', 'onChange="this.form.submit();" size="' . AJAX_ADDQUICK_DROPDOWN_SIZE . '" class="ajaxAddQuickie"') . vam_hide_session_id();
			}
		}
	}
	echo $out;
?>
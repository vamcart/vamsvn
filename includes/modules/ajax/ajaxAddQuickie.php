<?php

//var_dump($_POST);echo '<br>';
	define("AJAX_ADDQUICK_RESULT", 'text'); // dropdown or text
	define("AJAX_ADDQUICK_DROPDOWN_SIZE", 5);
	define("AJAX_ADDQUICK_LIMIT", 15);

	$q = addslashes(preg_replace("%[^0-9a-zA-Zà-ÿÀ-ß]%", "", $_REQUEST['quickie']) );

	$out = "";
	if(isset($q) && xtc_not_null($q)) {

		$model_query = xtc_db_query("select pd.products_id, pd.products_name, p.products_model
							from " . TABLE_PRODUCTS_DESCRIPTION . " pd
							inner join " . TABLE_PRODUCTS . " p
							on (p.products_id = pd.products_id)
							where p.products_model like '%" . $q . "%' 
							and p.products_status = '1'
							and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'
							order by pd.products_name asc
							limit " . AJAX_ADDQUICK_LIMIT);

		if($model = xtc_db_fetch_array($model_query)) {
			$out .= sprintf(TEXT_AJAX_ADDQUICKIE_SEARCH_TOP, AJAX_ADDQUICK_LIMIT) . '<br />';
			$dropdown = array();
			$out .= '<ul class="ajaxAddQuickie">';
			while($model = xtc_db_fetch_array($model_query)) {
				$out .= "<li class=\"ajaxAddQuickie\"><a href=\"\" onclick=\"javascript:document.getElementById('quick_add_quickie').value='". $model['products_model'] . "';return false;\">" . $model['products_model'] . "</a></li>" . "\n";
				$dropdown[] = array('id' => $model['products_id'],
														'text' => $model['products_name']);
			}
			$out .= '</ul>' . "\n";
			if(AJAX_ADDQUICK_RESULT == 'dropdown') {
				$out .= xtc_draw_pull_down_menu('AJAX_ADDQUICK_pid', $dropdown, '', 'onChange="this.form.submit();" size="' . AJAX_ADDQUICK_DROPDOWN_SIZE . '" class="ajaxAddQuickie"') . xtc_hide_session_id();
			}
		}
	}
	$_RESULT['ajaxAddQuickie'] = $out;
?>
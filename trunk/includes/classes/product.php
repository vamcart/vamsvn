<?php

/* -----------------------------------------------------------------------------------------
   $Id: product.php 1316 2005-10-21 15:30:58Z mz $ 

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2005 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(Coding Standards); www.oscommerce.com 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class product {

	/**
	 * 
	 * Constructor
	 * 
	 */
	function product($pID = 0) {
		$this->pID = $pID;
		if ($pID = 0) {
			$this->isProduct = false;
			return;
		}
		// query for Product
		$group_check = "";
		if (GROUP_CHECK == 'true') {
			$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
		}

		$fsk_lock = "";
		if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
			$fsk_lock = ' and p.products_fsk18!=1';
		}

		$product_query = "select * FROM ".TABLE_PRODUCTS." p,
										                                      ".TABLE_PRODUCTS_DESCRIPTION." pd
										                                      where p.products_status = '1'
										                                      and p.products_id = '".$this->pID."'
										                                      and pd.products_id = p.products_id
										                                      ".$group_check.$fsk_lock."
										                                      and pd.language_id = '".(int) $_SESSION['languages_id']."'";

		$product_query = xtDBquery($product_query);

		if (!xtc_db_num_rows($product_query, true)) {
			$this->isProduct = false;
		} else {
			$this->isProduct = true;
			$this->data = xtc_db_fetch_array($product_query, true);
		}

	}

	/**
	 * 
	 *  Query for attributes count
	 * 
	 */

	function getAttributesCount() {

		$products_attributes_query = xtDBquery("select count(*) as total from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".$this->pID."' and patrib.options_id = popt.products_options_id and popt.language_id = '".(int) $_SESSION['languages_id']."'");
		$products_attributes = xtc_db_fetch_array($products_attributes_query, true);
		return $products_attributes['total'];

	}

	/**
	 * 
	 * Query for reviews count
	 * 
	 */

	function getReviewsCount() {
		$reviews_query = xtDBquery("select count(*) as total from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".$this->pID."' and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."' and rd.reviews_text !=''");
		$reviews = xtc_db_fetch_array($reviews_query, true);
		return $reviews['total'];
	}

	/**
	 * 
	 * select reviews
	 * 
	 */

	function getReviews() {

		$data_reviews = array ();
		$reviews_query = xtDBquery("select
									                                 r.reviews_rating,
									                                 r.reviews_id,
									                                 r.customers_name,
									                                 r.date_added,
									                                 r.last_modified,
									                                 r.reviews_read,
									                                 rd.reviews_text
									                                 from ".TABLE_REVIEWS." r,
									                                 ".TABLE_REVIEWS_DESCRIPTION." rd
									                                 where r.products_id = '".$this->pID."'
									                                 and  r.reviews_id=rd.reviews_id
									                                 and rd.languages_id = '".$_SESSION['languages_id']."'
									                                 order by reviews_id DESC");
		if (xtc_db_num_rows($reviews_query, true)) {
			$row = 0;
			$data_reviews = array ();
			while ($reviews = xtc_db_fetch_array($reviews_query, true)) {
				$row ++;
				$data_reviews[] = array ('AUTHOR' => $reviews['customers_name'], 'DATE' => xtc_date_short($reviews['date_added']), 'RATING' => xtc_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.$reviews['reviews_rating'].'.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating'])), 'TEXT' => $reviews['reviews_text']);
				if ($row == PRODUCT_REVIEWS_VIEW)
					break;
			}
		}
		return $data_reviews;

	}

	/**
	 * 
	 * return model if set, else return name
	 * 
	 */

	function getBreadcrumbModel() {

		if ($this->data['products_model'] != "")
			return $this->data['products_model'];
		return $this->data['products_name'];

	}

	/**
	 * 
	 * get also purchased products related to current
	 * 
	 */

	function getAlsoPurchased() {
		global $xtPrice;

		$module_content = array ();

		$fsk_lock = "";
		if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
			$fsk_lock = ' and p.products_fsk18!=1';
		}
		$group_check = "";
		if (GROUP_CHECK == 'true') {
			$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
		}

		$orders_query = xtDBquery("select
						                                  p.products_fsk18,
						                                  p.products_id,
						                                  p.products_price,
						                                  p.products_tax_class_id,
						                                  p.products_image,
						                                  pd.products_name,
						                                  pd.products_short_description FROM ".TABLE_ORDERS_PRODUCTS." opa, ".TABLE_ORDERS_PRODUCTS." opb, ".TABLE_ORDERS." o, ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
						                                  where opa.products_id = '".$this->pID."'
						                                  and opa.orders_id = opb.orders_id
						                                  and opb.products_id != '".$this->pID."'
						                                  and opb.products_id = p.products_id
						                                  and opb.orders_id = o.orders_id ".$shop."
						                                  and p.products_status = '1'
						                                  and pd.language_id = '".(int) $_SESSION['languages_id']."'
						                                  and opb.products_id = pd.products_id
						                                  ".$group_check."
						                                  ".$fsk_lock."
						                                  group by p.products_id order by o.date_purchased desc limit ".MAX_DISPLAY_ALSO_PURCHASED);

		while ($orders = xtc_db_fetch_array($orders_query, true)) {

			$image = '';
			if ($orders['products_image'] != '')
				$image = DIR_WS_THUMBNAIL_IMAGES.$orders['products_image'];

			if ($_SESSION['customers_status']['customers_status_show_price'] != '0') {
				$buy_now = '';
				if ($_SESSION['customers_status']['customers_fsk18'] == '1') {
					if ($orders['products_fsk18'] == '0')
						$buy_now = '<a href="'.xtc_href_link(FILENAME_PRODUCT_INFO, xtc_get_all_get_params(array ('action')).'action=buy_now&amp;BUYproducts_id='.$orders['products_id'], 'NONSSL').'">'.xtc_image_button('button_buy_now.gif', TEXT_BUY.$orders['products_name'].TEXT_NOW).'</a>';
				} else {
					$buy_now = '<a href="'.xtc_href_link(FILENAME_PRODUCT_INFO, xtc_get_all_get_params(array ('action')).'action=buy_now&amp;BUYproducts_id='.$orders['products_id'], 'NONSSL').'">'.xtc_image_button('button_buy_now.gif', TEXT_BUY.$orders['products_name'].TEXT_NOW).'</a>';
				}

				$module_content[] = array ('PRODUCTS_NAME' => $orders['products_name'], 'PRODUCTS_DESCRIPTION' => $orders['products_short_description'], 'PRODUCTS_PRICE' => $xtPrice->xtcGetPrice($orders['products_id'], $format = true, 1, $orders['products_tax_class_id'], $orders['products_price']), 'PRODUCTS_LINK' => xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($orders['products_id'], $orders['products_name'])), 'PRODUCTS_IMAGE' => $image, 'BUTTON_BUY_NOW' => $buy_now);
			} else {
				$module_content[] = array ('PRODUCTS_NAME' => $orders['products_name'], 'PRODUCTS_DESCRIPTION' => $orders['products_short_description'], 'PRODUCTS_PRICE' => $xtPrice->xtcGetPrice($orders['products_id'], $format = true, 1, $orders['products_tax_class_id'], $orders['products_price']), 'PRODUCTS_LINK' => xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($orders['products_id'], $orders['products_name'])), 'PRODUCTS_FSK18' => 'true', 'PRODUCTS_IMAGE' => $image);

			}

		}

		return $module_content;

	}

	/**
	 * 
	 * 
	 *  Get Cross sells 
	 * 
	 * 
	 */
	function getCrossSells() {
		global $xtPrice;

		$cs_groups = "SELECT products_xsell_grp_name_id FROM ".TABLE_PRODUCTS_XSELL." WHERE products_id = '".$this->pID."' GROUP BY products_xsell_grp_name_id";
		$cs_groups = xtDBquery($cs_groups);
		$cross_sell_data = array ();
		if (xtc_db_num_rows($cs_groups, true)>0) {
		while ($cross_sells = xtc_db_fetch_array($cs_groups, true)) {

			$fsk_lock = '';
			if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
				$fsk_lock = ' and p.products_fsk18!=1';
			}
			$group_check = "";
			if (GROUP_CHECK == 'true') {
				$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
			}

			$cross_query = xtDBquery("select p.products_fsk18,
														 p.products_tax_class_id,
								                                                 p.products_id,
								                                                 p.products_image,
								                                                 pd.products_name,
														 						pd.products_short_description,
								                                                 p.products_fsk18,
								                                                 xp.sort_order from ".TABLE_PRODUCTS_XSELL." xp, ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
								                                            where xp.products_id = '".$this->pID."' and xp.xsell_id = p.products_id ".$fsk_lock.$group_check."
								                                            and p.products_id = pd.products_id and xp.products_xsell_grp_name_id='".$cross_sells['products_xsell_grp_name_id']."'
								                                            and pd.language_id = '".$_SESSION['languages_id']."'
								                                            and p.products_status = '1'
								                                            order by xp.sort_order asc");

			if (xtc_db_num_rows($cross_query, true) > 0)
				$cross_sell_data[$cross_sells['products_xsell_grp_name_id']] = array ('GROUP' => xtc_get_cross_sell_name($cross_sells['products_xsell_grp_name_id']), 'PRODUCTS' => array ());

			while ($xsell = xtc_db_fetch_array($cross_query, true)) {

				if (($xsell['products_fsk18'] == '1') AND ($_SESSION['customers_status']['customers_fsk18'] == '1')) {
					$xsell_buy_now = '<img src = templates/'.CURRENT_TEMPLATE.'/'.'img/fsk18.gif>';
				} else {
					$xsell_buy_now = '<a href="'.xtc_href_link(FILENAME_PRODUCT_INFO, xtc_get_all_get_params(array ('action')).'action=buy_now&BUYproducts_id='.$xsell['products_id'], 'NONSSL').'">'.xtc_image_button('button_buy_now.gif', TEXT_BUY.$xsell['products_name'].TEXT_NOW).'</a>';
				}
				$xsell_image = '';
				if ($xsell['products_image'] != '') {
					$xsell_image = DIR_WS_THUMBNAIL_IMAGES.$xsell['products_image'];
				}

				$cross_sell_data[$cross_sells['products_xsell_grp_name_id']]['PRODUCTS'][] = array ('PRODUCTS_NAME' => $xsell['products_name'], 'PRODUCTS_IMAGE' => $xsell_image, 'PRODUCTS_LINK' => xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($xsell['products_id'], $xsell['products_name'])), 'PRODUCTS_PRICE' => $xtPrice->xtcGetPrice($xsell['products_id'], $format = true, 1, $xsell['products_tax_class_id'], $xsell['products_price']), 'BUTTON_BUY_NOW' => $xsell_buy_now, 'PRODUCTS_DESCRIPTION' => $xsell['products_short_description'], 'PRODUCTS_FSK18' => $xsell['products_fsk18']);
			}

		}

		return $cross_sell_data;
		}
	}
	
	
	/**
	 * 
	 * get reverse cross sells
	 * 
	 */
	 
	 function getReverseCrossSells() {
	 			global $xtPrice;


			$fsk_lock = '';
			if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
				$fsk_lock = ' and p.products_fsk18!=1';
			}
			$group_check = "";
			if (GROUP_CHECK == 'true') {
				$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
			}

			$cross_query = xtDBquery("select p.products_fsk18,
														 p.products_tax_class_id,
								                                                 p.products_id,
								                                                 p.products_image,
								                                                 pd.products_name,
														 						pd.products_short_description,
								                                                 p.products_fsk18,
								                                                 xp.sort_order from ".TABLE_PRODUCTS_XSELL." xp, ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
								                                            where xp.xsell_id = '".$this->pID."' and xp.products_id = p.products_id ".$fsk_lock.$group_check."
								                                            and p.products_id = pd.products_id
								                                            and pd.language_id = '".$_SESSION['languages_id']."'
								                                            and p.products_status = '1'
								                                            order by xp.sort_order asc");

			if (xtc_db_num_rows($cross_query, true) > 0)
				$cross_sell_data[$cross_sells['products_xsell_grp_name_id']] = array ('GROUP' => xtc_get_cross_sell_name($cross_sells['products_xsell_grp_name_id']), 'PRODUCTS' => array ());

			while ($xsell = xtc_db_fetch_array($cross_query, true)) {

				if (($xsell['products_fsk18'] == '1') AND ($_SESSION['customers_status']['customers_fsk18'] == '1')) {
					$xsell_buy_now = '<img src = templates/'.CURRENT_TEMPLATE.'/'.'img/fsk18.gif>';
				} else {
					$xsell_buy_now = '<a href="'.xtc_href_link(FILENAME_PRODUCT_INFO, xtc_get_all_get_params(array ('action')).'action=buy_now&BUYproducts_id='.$xsell['products_id'], 'NONSSL').'">'.xtc_image_button('button_buy_now.gif', TEXT_BUY.$xsell['products_name'].TEXT_NOW).'</a>';
				}
				$xsell_image = '';
				if ($xsell['products_image'] != '') {
					$xsell_image = DIR_WS_THUMBNAIL_IMAGES.$xsell['products_image'];
				}

				$cross_sell_data[] = array ('PRODUCTS_NAME' => $xsell['products_name'], 'PRODUCTS_IMAGE' => $xsell_image, 'PRODUCTS_LINK' => xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($xsell['products_id'], $xsell['products_name'])), 'PRODUCTS_PRICE' => $xtPrice->xtcGetPrice($xsell['products_id'], $format = true, 1, $xsell['products_tax_class_id'], $xsell['products_price']), 'BUTTON_BUY_NOW' => $xsell_buy_now, 'PRODUCTS_DESCRIPTION' => $xsell['products_short_description'], 'PRODUCTS_FSK18' => $xsell['products_fsk18']);
			}


		return $cross_sell_data;
	 	
	 	
	 	
	 }
	

	function getGraduated() {
		global $xtPrice;

		$staffel_query = xtDBquery("SELECT
				                                     quantity,
				                                     personal_offer
				                                     FROM
				                                     ".TABLE_PERSONAL_OFFERS_BY.(int) $_SESSION['customers_status']['customers_status_id']."
				                                     WHERE
				                                     products_id = '".$this->pID."'
				                                     ORDER BY quantity ASC");

		$staffel = array ();
		while ($staffel_values = xtc_db_fetch_array($staffel_query, true)) {
			$staffel[] = array ('stk' => $staffel_values['quantity'], 'price' => $staffel_values['personal_offer']);
		}
		$staffel_data = array ();
		for ($i = 0, $n = sizeof($staffel); $i < $n; $i ++) {
			if ($staffel[$i]['stk'] == 1) {
				$quantity = $staffel[$i]['stk'];
				if ($staffel[$i +1]['stk'] != '')
					$quantity = $staffel[$i]['stk'].'-'. ($staffel[$i +1]['stk'] - 1);
			} else {
				$quantity = ' > '.$staffel[$i]['stk'];
				if ($staffel[$i +1]['stk'] != '')
					$quantity = $staffel[$i]['stk'].'-'. ($staffel[$i +1]['stk'] - 1);
			}
			$vpe = '';
			if ($product_info['products_vpe_status'] == 1 && $product_info['products_vpe_value'] != 0.0 && $staffel[$i]['price'] > 0) {
				$vpe = $staffel[$i]['price'] - $staffel[$i]['price'] / 100 * $discount;
				$vpe = $vpe * (1 / $product_info['products_vpe_value']);
				$vpe = $xtPrice->xtcFormat($vpe, true, $product_info['products_tax_class_id']).TXT_PER.xtc_get_vpe_name($product_info['products_vpe']);
			}
			$staffel_data[$i] = array ('QUANTITY' => $quantity, 'VPE' => $vpe, 'PRICE' => $xtPrice->xtcFormat($staffel[$i]['price'] - $staffel[$i]['price'] / 100 * $discount, true, $this->data['products_tax_class_id']));
		}

		return $staffel_data;

	}
	/**
	 * 
	 * valid flag
	 * 
	 */

	function isProduct() {
		return $this->isProduct;
	}

}
?>
<?php
/* -----------------------------------------------------------------------------------------
   $Id: product.php 1316 2007-02-06 20:23:03 VaM $ 

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(Coding Standards); www.oscommerce.com 
   (c) 2004 xt:Commerce (product.php); xt-commerce.com 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class product {

	/**
	 * 
	 * Constructor
	 * 
	 */
	function __construct($pID = 0) {
		$this->pID = $pID;
		$this->useStandardImage=true;
		$this->standardImage='../noimage.gif';
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

		$product_query = vamDBquery($product_query);

		if (!vam_db_num_rows($product_query, true)) {
			$this->isProduct = false;
		} else {
			$this->isProduct = true;
			$this->data = vam_db_fetch_array($product_query, true);
		}

	}

	/**
	 * 
	 *  Query for attributes count
	 * 
	 */

	function getAttributesCount() {

		$products_attributes_query = vamDBquery("select count(*) as total from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".$this->pID."' and patrib.options_id = popt.products_options_id and popt.language_id = '".(int) $_SESSION['languages_id']."'");
		$products_attributes = vam_db_fetch_array($products_attributes_query, true);
		return $products_attributes['total'];

	}

	/**
	 * 
	 * Query for reviews rating
	 * 
	 */

	function getReviewsRating($products_id = 0) {

	  if ($products_id == 0) $products_id = $this->pID;

		$reviews_query = vam_db_query("select count(*) as total, TRUNCATE(SUM(reviews_rating),2) as rating from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".(int)$products_id."' and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
		$reviews = vam_db_fetch_array($reviews_query);
		if ($reviews['total'] > 0 && $reviews['rating'] > 0) {
		return $reviews['rating']/$reviews['total'];
		}
	}

	/**
	 * 
	 * Query for reviews count
	 * 
	 */

	function getReviewsCount($products_id = 0) {
	  
	  if ($products_id == 0) $products_id = $this->pID;
	  
		$reviews_query = vam_db_query("select count(*) as total from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".(int)$products_id."' and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
		$reviews = vam_db_fetch_array($reviews_query);
		return $reviews['total'];
	}


	/**
	 * 
	 * Query for reviews count
	 * 
	 */

	function getReviewsCustomer($products_id = 0, $customer_id = 0) {

	  if ($products_id == 0) $products_id = $this->pID;
	  $reviews_customer = false;
	  
	  if ($customer_id > 0) {

		$reviews_query = vamDBquery("select o.customers_id
						 from  ".TABLE_ORDERS." o left join ".TABLE_ORDERS_PRODUCTS." op on op.orders_id = o.orders_id
						 where 
						 o.customers_id = ".(int)$customer_id."
						 and op.products_id = ".(int)$products_id."
						 limit 1");
		if (vam_db_num_rows($reviews_query)) {
		$reviews_customer = true;
		}
	  }
	   return $reviews_customer;
	}
	
	/**
	 * 
	 * select reviews
	 * 
	 */

	function getReviews() {

		$data_reviews = array ();
		$reviews_query = vam_db_query("select
									                                 r.reviews_rating,
									                                 r.reviews_id,
									                                 r.customers_name,
									                                 r.customers_id,
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
		if (vam_db_num_rows($reviews_query)) {
			$row = 0;
			$data_reviews = array ();
			$star_rating = '';
			while ($reviews = vam_db_fetch_array($reviews_query)) {
				$row ++;

				$star_rating = '';
				for($i=0;$i<number_format($reviews['reviews_rating']);$i++)	{
				$star_rating .= '<span class="rating"><i class="fa fa-star"></i></span> ';
				}
		
				$data_reviews[] = array (
				
				'PRODUCTS_LINK' => vam_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$reviews['products_id']), 
				'REVIEWS_LINK' => vam_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id='.$reviews['products_id'].'&reviews_id='.$reviews['reviews_id']), 
				'REVIEWS_ALL_LINK' => vam_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id='.$reviews['products_id']), 
				'AUTHOR' => $reviews['customers_name'], 
				'CUSTOMER' => $this->getReviewsCustomer((int)$reviews['products_id'],(int)$reviews['customers_id']), 
				'ID' => $reviews['reviews_id'], 
				'URL' => vam_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id='.$reviews['products_id'].'&reviews_id='.$reviews['reviews_id']), 
				'DATE' => vam_date_short($reviews['date_added']), 
				//'TEXT_COUNT' => '('.sprintf(TEXT_REVIEW_WORD_COUNT, vam_word_count($reviews['reviews_text'], ' ')).')<br />'.vam_break_string(htmlspecialchars($reviews['reviews_text']), 60, '-<br />').'..', 
				'TEXT' => $reviews['reviews_text'], 
				'RATING' => $reviews['reviews_rating'],
				'STAR_RATING' => $star_rating,
				'RATING_IMG' => vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.$reviews['reviews_rating'].'.gif', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating']))

				
				);
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
	 * return name
	 * 
	 */

	function getBreadcrumbName() {

		return $this->data['products_name'];

	}

	/**
	 * 
	 * get bundle products
	 * 
	 */

	function getBundleProducts() {
		global $vamPrice;

		$module_content = array ();

		$fsk_lock = "";
		if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
			$fsk_lock = ' and p.products_fsk18!=1';
		}
		$group_check = "";
		if (GROUP_CHECK == 'true') {
			$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
		}

                  $bundle_sum = 0;
		              //echo TEXT_PRODUCTS_BY_BUNDLE . "</strong></td></tr>\n";
		              $bundle_query = vamDBquery(" SELECT p.*, pd.*, pb.* FROM " . TABLE_PRODUCTS . " p INNER JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON pd.products_id=p.products_id INNER JOIN " . TABLE_PRODUCTS_BUNDLES . " pb ON pb.subproduct_id=pd.products_id WHERE pb.bundle_id = " . (int)$this->pID . " and pd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
		              while ($bundle_data = vam_db_fetch_array($bundle_query,true)) {
	                  
		              $module_content[] = $this->buildDataArray($bundle_data);	                  
	                  
	                  //echo '<tr><td class="main" valign="top">' ;
	                  //echo '<a href="' . vam_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $bundle_data['products_id']) . '" target="_blank">' . tep_image(DIR_WS_IMAGES . $bundle_data['products_image'], $bundle_data['products_name'], intval(SMALL_IMAGE_WIDTH / 2), intval(SMALL_IMAGE_HEIGHT / 2), 'hspace="1" vspace="1"') . '</a></td>';

	                  //echo '<td class="main" align="right"><strong>' . $bundle_data['subproduct_qty'] . "&nbsp;x&nbsp;</strong></td>";
	                  //echo  '<td class="main"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, ($cPath ? 'cPath=' . $cPath . '&' : '') . 'products_id=' . $bundle_data['products_id']) . '" target="_blank"><strong>&nbsp;(' . $bundle_data['products_model'] . ') '  . $bundle_data['products_name'] . '</strong></a>';
	                  //if ($bundle_data['products_bundle'] == "yes") display_bundle($bundle_data['subproduct_id'], $bundle_data['products_price']);
	                  //echo '</td>';
	                  //echo '<td align="right" class="main"><strong>&nbsp;' .  $currencies->display_price($bundle_data['products_price'], tep_get_tax_rate($product_info['products_tax_class_id'])) . "</strong></td></tr>\n";
	                  $bundle_sum += $bundle_data['products_price']*$bundle_data['subproduct_qty'];
		              }
		              //$bundle_saving = $bundle_sum - $bundle_price;
		              //$bundle_sum = $currencies->display_price($bundle_sum, tep_get_tax_rate($product_info['products_tax_class_id']));
		              //$bundle_saving =  $currencies->display_price($bundle_saving, tep_get_tax_rate($product_info['products_tax_class_id']));
		              // comment out the following line to hide the "saving" text
		              //echo '<tr><td colspan="5" class="main"><p><strong>' . TEXT_RATE_COSTS . '&nbsp;' . $bundle_sum . '</strong></td></tr><tr><td class="main" colspan="5" style="color:red"><strong>' . TEXT_IT_SAVE . '&nbsp;' . $bundle_saving . "</strong></td></tr>\n";
		           

		return $module_content;
		
	}

	/**
	 * 
	 * get also purchased products related to current
	 * 
	 */

	function getAlsoPurchased() {
		global $vamPrice;

		$module_content = array ();

		$fsk_lock = "";
		if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
			$fsk_lock = ' and p.products_fsk18!=1';
		}
		$group_check = "";
		if (GROUP_CHECK == 'true') {
			$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
		}

$orders_id_query = vamDBquery("select orders_id from orders_products where products_id = '".$this->pID."' order by orders_products_id desc limit ".MAX_DISPLAY_ALSO_PURCHASED*3);

$orders_id_array = array();
while ($item = vam_db_fetch_array($orders_id_query, true)) {
    $orders_id_array[] = $item['orders_id'];
}
$orders_id = '"'.join('","',$orders_id_array).'"';

$products_id_query = vamDBquery("select
                               products_id
                               from ".TABLE_ORDERS_PRODUCTS."
                               where orders_id in (".$orders_id.")
                               and products_id <> '".$this->pID."'
                               GROUP BY products_id
                               order by orders_products_id Desc limit ".MAX_DISPLAY_ALSO_PURCHASED) ;

$products_id_array = array();
while ($item = vam_db_fetch_array($products_id_query, true)) {
    $products_id_array[] = $item['products_id'];
}

$products_id = '"'.join('","',$products_id_array).'"';

$orders_query = "select
                      p.products_fsk18,
                      p.products_id,
                      p.label_id,
                      p.products_price,
                      p.products_quantity,
                      p.products_tax_class_id,
                      p.products_image,
                      pd.products_name,
                      p.products_vpe,
                      p.products_vpe_status,
                      p.products_vpe_value,
                      pd.products_short_description
                    from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd 
                    where p.products_id = pd.products_id
                    and p.products_id in (".$products_id.")
                    and p.products_status = '1' 
                    and pd.language_id = '".(int) $_SESSION['languages_id']."'
                    and p.products_quantity > '0' 
                    ".$group_check."
                    ".$fsk_lock."
                    ORDER BY FIELD(p.products_id,".$products_id.") limit ".MAX_DISPLAY_ALSO_PURCHASED;
                    
		$orders_query = vamDBquery($orders_query);
		while ($orders = vam_db_fetch_array($orders_query, true)) {

			$module_content[] = $this->buildDataArray($orders);

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
		global $vamPrice;

		$cs_groups = "SELECT products_xsell_grp_name_id FROM ".TABLE_PRODUCTS_XSELL." WHERE products_id = '".$this->pID."' GROUP BY products_xsell_grp_name_id";
		$cs_groups = vamDBquery($cs_groups);
		$cross_sell_data = array ();
		if (vam_db_num_rows($cs_groups, true)>0) {
		while ($cross_sells = vam_db_fetch_array($cs_groups, true)) {

			$fsk_lock = '';
			if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
				$fsk_lock = ' and p.products_fsk18!=1';
			}
			$group_check = "";
			if (GROUP_CHECK == 'true') {
				$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
			}

				$cross_query = "select p.products_fsk18,
																														 p.products_tax_class_id,
																								                                                 p.products_id,
																								                                                 p.label_id,
																								                                                 p.products_image,
																								                                                 p.products_quantity,
																								                                                 pd.products_name,
																														 						pd.products_short_description,
																								                                                 p.products_fsk18,p.products_price,p.products_vpe,
						                           																									p.products_vpe_status,
						                           																									p.products_vpe_value,
																								                                                 xp.sort_order from ".TABLE_PRODUCTS_XSELL." xp, ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
																								                                            where xp.products_id = '".$this->pID."' and xp.xsell_id = p.products_id ".$fsk_lock.$group_check."
																								                                            and p.products_id = pd.products_id and xp.products_xsell_grp_name_id='".$cross_sells['products_xsell_grp_name_id']."'
																								                                            and pd.language_id = '".$_SESSION['languages_id']."'
																								                                            and p.products_status = '1'
																								                                            order by xp.sort_order asc";

			$cross_query = vamDBquery($cross_query);
			if (vam_db_num_rows($cross_query, true) > 0)
				$cross_sell_data[$cross_sells['products_xsell_grp_name_id']] = array ('GROUP' => vam_get_cross_sell_name($cross_sells['products_xsell_grp_name_id']), 'PRODUCTS' => array ());

			while ($xsell = vam_db_fetch_array($cross_query, true)) {

				$cross_sell_data[$cross_sells['products_xsell_grp_name_id']]['PRODUCTS'][] = $this->buildDataArray($xsell);
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
	 			global $vamPrice;


			$fsk_lock = '';
			if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
				$fsk_lock = ' and p.products_fsk18!=1';
			}
			$group_check = "";
			if (GROUP_CHECK == 'true') {
				$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
			}

			$cross_query = vamDBquery("select p.products_fsk18,
																						 p.products_tax_class_id,
																                                                 p.products_id,
																                                                 p.label_id,
																                                                 p.products_image,
																                                                 p.products_quantity,
																                                                 pd.products_name,
																						 						pd.products_short_description,
																                                                 p.products_fsk18,p.products_price,p.products_vpe,
						                           																p.products_vpe_status,
						                           																p.products_vpe_value,  
																                                                 xp.sort_order from ".TABLE_PRODUCTS_XSELL." xp, ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
																                                            where xp.xsell_id = '".$this->pID."' and xp.products_id = p.products_id ".$fsk_lock.$group_check."
																                                            and p.products_id = pd.products_id
																                                            and pd.language_id = '".$_SESSION['languages_id']."'
																                                            and p.products_status = '1'
																                                            order by xp.sort_order asc");


			while ($xsell = vam_db_fetch_array($cross_query, true)) {

				$cross_sell_data[] = $this->buildDataArray($xsell);
			}


		return $cross_sell_data;
	 	
	 	
	 	
	 }
	

	/**
	 * 
	 * 
	 *  Get Cross sells Cart
	 * 
	 * 
	 */
	function getCrossSellsCart() {
		global $vamPrice;
		
		$products = $_SESSION['cart']->get_products();

  foreach ($products AS $product_id_in_cart) {

		$cs_groups = "SELECT products_xsell_grp_name_id FROM ".TABLE_PRODUCTS_XSELL." WHERE products_id = '".intval($product_id_in_cart['id'])."' GROUP BY products_xsell_grp_name_id";
		$cs_groups = vamDBquery($cs_groups);
		$cross_sell_data = array ();
		if (vam_db_num_rows($cs_groups, true)>0) {
		while ($cross_sells = vam_db_fetch_array($cs_groups, true)) {

			$fsk_lock = '';
			if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
				$fsk_lock = ' and p.products_fsk18!=1';
			}
			$group_check = "";
			if (GROUP_CHECK == 'true') {
				$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
			}

				$cross_query = "select p.products_fsk18,
																														 p.products_tax_class_id,
																								                                                 p.products_id,
																								                                                 p.label_id,
																								                                                 p.products_image,
																								                                                 p.products_quantity,
																								                                                 pd.products_name,
																														 						pd.products_short_description,
																								                                                 p.products_fsk18,p.products_price,p.products_vpe,
						                           																									p.products_vpe_status,
						                           																									p.products_vpe_value,
																								                                                 xp.sort_order from ".TABLE_PRODUCTS_XSELL." xp, ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
																								                                            where xp.products_id = '".intval($product_id_in_cart['id'])."' and xp.xsell_id = p.products_id ".$fsk_lock.$group_check."
																								                                            and p.products_id = pd.products_id and xp.products_xsell_grp_name_id='".$cross_sells['products_xsell_grp_name_id']."'
																								                                            and pd.language_id = '".$_SESSION['languages_id']."'
																								                                            and p.products_status = '1'
																								                                            order by xp.sort_order asc";

			$cross_query = vamDBquery($cross_query);
			if (vam_db_num_rows($cross_query, true) > 0)
				$cross_sell_data[$cross_sells['products_xsell_grp_name_id']] = array ('GROUP' => vam_get_cross_sell_name($cross_sells['products_xsell_grp_name_id']), 'PRODUCTS' => array ());

			while ($xsell = vam_db_fetch_array($cross_query, true)) {

				$cross_sell_data[$cross_sells['products_xsell_grp_name_id']]['PRODUCTS'][] = $this->buildDataArray($xsell);
			}

		}
		}
		return $cross_sell_data;
		}
	}
	
	function getGraduated() {
		global $vamPrice;

		$staffel_query = vamDBquery("SELECT
				                                     quantity,
				                                     personal_offer
				                                     FROM
				                                     ".TABLE_PERSONAL_OFFERS_BY.(int) $_SESSION['customers_status']['customers_status_id']."
				                                     WHERE
				                                     products_id = '".$this->pID."'
				                                     ORDER BY quantity ASC");

		$staffel = array ();
		while ($staffel_values = vam_db_fetch_array($staffel_query, true)) {
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
				$vpe = $vamPrice->Format($vpe, true, $product_info['products_tax_class_id']).TXT_PER.vam_get_vpe_name($product_info['products_vpe']);
			}
			$staffel_data[$i] = array ('QUANTITY' => $quantity, 'VPE' => $vpe, 'PRICE' => $vamPrice->Format($staffel[$i]['price'] - $staffel[$i]['price'] / 100 * $discount, true, $this->data['products_tax_class_id'],true));
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
	
	// beta
	function getBuyNowButton($id, $name) {
		global $PHP_SELF;
		$vam_get_all_get_params_return = (basename($PHP_SELF) == 'product_info.php') ? preg_replace('/products_id=\d+&/', '', vam_get_all_get_params(array ('action'))) : vam_get_all_get_params(array ('action'));
		if (AJAX_CART == 'true' && !vam_has_product_attributes($id)) {
		$link = '<a class="button" href="'.vam_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='.$id.'&'.$vam_get_all_get_params_return, 'NONSSL').'" onclick="doBuyNow(\''.$id.'\',\'1\'); return false;">'.vam_image_button('buy.png', IMAGE_BUTTON_IN_CART).'</a>';
		} else {
		$link = '<a class="button" href="'.vam_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='.$id.'&'.$vam_get_all_get_params_return, 'NONSSL').'">'.vam_image_button('buy.png', TEXT_SELECT_OPTIONS).'</a>';
		}
		
		return $link;
	}

	// beta
	function getBuyNowButtonNew($id, $name) {
		global $PHP_SELF;
		$vam_get_all_get_params_return = (basename($PHP_SELF) == 'product_info.php') ? preg_replace('/products_id=\d+&/', '', vam_get_all_get_params(array ('action'))) : vam_get_all_get_params(array ('action'));
		if (AJAX_CART == 'true' && !vam_has_product_attributes($id)) {
		$link = '<a class="btn btn-add-to-cart btn-block" href="'.vam_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='.$id.'&'.$vam_get_all_get_params_return, 'NONSSL').'" onclick="doBuyNow(\''.$id.'\',\'1\'); return false;"><i class="fa fa-shopping-cart"></i> '.IMAGE_BUTTON_IN_CART.'</a>';
		} else {
		$link = '<a class="btn btn-add-to-cart btn-block" href="'.vam_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='.$id.'&'.$vam_get_all_get_params_return, 'NONSSL').'"><i class="fa fa-shopping-cart"></i> '.TEXT_SELECT_OPTIONS.'</a>';
		}
		
		return $link;
	}


	function getVPEtext($product, $price) {
		global $vamPrice;

		require_once (DIR_FS_INC.'vam_get_vpe_name.inc.php');

		if (!is_array($product))
			$product = $this->data;

		if ($product['products_vpe_status'] == 1 && $product['products_vpe_value'] != 0.0 && $price > 0) {
			return $vamPrice->Format($price * (1 / $product['products_vpe_value']), true).TXT_PER.vam_get_vpe_name($product['products_vpe']);
		}

		return;

	}

	function getLabelText($product, $label_id) {

		require_once (DIR_FS_INC.'vam_get_label_name.inc.php');

		if (!is_array($product))
			$product = $this->data;

		if ($product['label_id'] > 0) {
			return vam_get_label_name($label_id);
		}

		return;

	}
	
	function buildDataArray(&$array,$image='thumbnail') {
		global $vamPrice,$main;

if (is_array($array)) {

			$tax_rate = $vamPrice->TAX[$array['products_tax_class_id']];

			$products_price = $vamPrice->GetPrice($array['products_id'], $format = true, 1, $array['products_tax_class_id'], $array['products_price'], 1);

			if ($_SESSION['customers_status']['customers_status_show_price'] != '0') {
			if ($_SESSION['customers_status']['customers_fsk18'] == '1') {
				if ($array['products_fsk18'] == '0') { 
					$buy_now = $this->getBuyNowButton($array['products_id'], $array['products_name']);
					$buy_now_new = $this->getBuyNowButtonNew($array['products_id'], $array['products_name']); 
			 } 
			} else {
				$buy_now = $this->getBuyNowButton($array['products_id'], $array['products_name']);
				$buy_now_new = $this->getBuyNowButtonNew($array['products_id'], $array['products_name']);
			}
   	 }

		
			$shipping_status_name = $main->getShippingStatusName($array['products_shippingtime']);
			$shipping_status_image = $main->getShippingStatusImage($array['products_shippingtime']);
		
                      $extra_fields_query = vamDBquery("
                      SELECT pef.products_extra_fields_status as status, pef.products_extra_fields_name as name, ptf.products_extra_fields_value as value
                      FROM ". TABLE_PRODUCTS_EXTRA_FIELDS ." pef
             LEFT JOIN  ". TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS ." ptf
            ON ptf.products_extra_fields_id=pef.products_extra_fields_id
            WHERE ptf.products_id=". (int)$array['products_id'] ." and ptf.products_extra_fields_value<>'' and (pef.languages_id='0' or pef.languages_id='".$_SESSION['languages_id']."')
            ORDER BY products_extra_fields_order");

  while ($extra_fields = vam_db_fetch_array($extra_fields_query,true)) {
        if (! $extra_fields['status'])  // show only enabled extra field
           continue;
  
  $extra_fields_data[] = array (
  'NAME' => $extra_fields['name'], 
  'VALUE' => $extra_fields['value']
  );
  
  }


// Specs Start

global $current_category_id;

  $categories_query_raw = "select  sg.specification_group_id, 
                                   sg.specification_group_name, 
                                   sg.show_products
                             from " . TABLE_SPECIFICATION_GROUPS . " sg,
                                  " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
                             where sg.show_products = 'True'
                               and sg.specification_group_id = sg2c.specification_group_id
                               and sg2c.categories_id = '" . (int) $current_category_id . "' ORDER BY sg.specification_group_name
                            ";
  $categories_query = vamDBquery ($categories_query_raw);
  $count_categories = vam_db_num_rows ($categories_query, true);

  if ($count_categories > 0) {
  //print $count_categories . "<br>\n";
  
    
  $row = 0;
  $col = 0;    

  $specifications_data = array();
    
  while ($categories_data = vam_db_fetch_array ($categories_query, true) ) {    
    

 // print $categories_data['specification_group_id'] . "<br>\n";
 //   print $categories_data['specification_group_name'] . "<br>\n";
 //   print $categories_data['show_products'] . "<br>\n";
  
   
  $specifications_query_raw = "select ps.specification, 
                                      s.filter_display,
                                      s.enter_values,
                                      sd.specification_name, 
                                      sd.specification_prefix, 
                                      sd.specification_suffix,
                                      s.specification_group_id,
                                      sg.specification_group_name                                      
                               from " . TABLE_PRODUCTS_SPECIFICATIONS . " ps, 
                                    " . TABLE_SPECIFICATION . " s, 
                                    " . TABLE_SPECIFICATION_DESCRIPTION . " sd, 
                                    " . TABLE_SPECIFICATION_GROUPS . " sg,
                                    " . TABLE_SPECIFICATIONS_TO_CATEGORIES . " sg2c
                               where sg.show_products = 'True'
                                 and s.show_products = 'True'
                                 and s.specification_group_id = sg.specification_group_id 
                                 and sg.specification_group_id = sg2c.specification_group_id
                                 and sg.specification_group_id = '" . (int) $categories_data['specification_group_id'] . "' 
                                 and sd.specifications_id = s.specifications_id
                                 and ps.specifications_id = sd.specifications_id
                                 and sg2c.categories_id = '" . (int) $current_category_id . "' 
                                 and ps.products_id = '" . (int) $array['products_id'] . "' 
                                 and sd.language_id = '" . (int) $_SESSION['languages_id'] . "' 
                                 and ps.language_id = '" . (int) $_SESSION['languages_id'] . "' 
                               order by s.specification_sort_order, 
                                        sd.specification_name
                             ";
   
  $specifications_query = vamDBquery ($specifications_query_raw);
    //   print $specifications_query_raw . "<br>\n"; 

  
  $count_specificatons = vam_db_num_rows ($specifications_query,true);

  //print $count_specificatons . "<br>\n";
   if ($count_specificatons > 0) {

		$specifications_data[$row] = array (
		
			'GROUP_NAME' => $categories_data['specification_group_name'],
			//'DATA' => ''
		
		);
		
$col = 0;		
		
    while ($specifications = vam_db_fetch_array ($specifications_query, true) ) {
      if ($specifications['specification'] != '') {
      
        if (SPECIFICATIONS_SHOW_NAME_PRODUCTS == 'True') {
          $specification_text .= $specifications['specification_name'];
        }
      
        $specification_text .= $specifications['specification_prefix'];
                      
        if ($specifications['display'] == 'image' || $specifications['display'] == 'multiimage' || $specifications['enter'] == 'image' || $specifications['enter'] == 'multiimage') { 
          vam_image (DIR_WS_IMAGES . $specifications['specification'], $specifications['specification_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);
        } else {
          $specification_text .= $specifications['specification'] . ' ';
        }

        $specification_text .= $specifications['specification_suffix'];

        
      } // if ($specifications['specification']


				$specifications_data[$row]['DATA'][$col] = array (
				
					'NAME' => $specifications['specification_name'], 
					'VALUE' => (!empty($specifications['specification_prefix']) ? $specifications['specification_prefix'].' ' : '').$specifications['specification'].(!empty($specifications['specification_suffix']) ? ' '.$specifications['specification_suffix'] : '')
			
				);
				
			
			$col ++;
      

    } // while ($specifications

			$row ++;

    }
   }
  }
//echo var_dump($specifications_data);

// Specs End

$products_special = null;

if ($vamPrice->CheckSpecial($array['products_id']) > 0) {
$products_special = 100-($vamPrice->CheckSpecial($array['products_id'])*100/$vamPrice->GetPprice($array['products_id']));
}

		$star_rating = '';
		for($i=0;$i<number_format($this->getReviewsRating($array['products_id']));$i++)	{
		$star_rating .= '<span class="rating"><i class="fa fa-star"></i></span> ';
		}

		return array ('PRODUCTS_NAME' => vam_parse_input_field_data($array['products_name'], array('"' => '&quot;')), 
		    'PRODUCTS_MODEL'=>$array['products_model'],
		    'PRODUCTS_WEIGHT'=>$array['products_weight'],
		    'PRODUCTS_LENGTH'=>$array['products_length'],
		    'PRODUCTS_WIDTH'=>$array['products_width'],
		    'PRODUCTS_HEIGHT'=>$array['products_height'],
		    'PRODUCTS_VOLUME'=>$array['products_volume'],
		    'PRODUCTS_EAN'=>$array['products_ean'],
		    'PRODUCTS_QUANTITY'=>$array['products_quantity'],
		    'LIKES'=>$array['likes'],
		    'DISLIKES'=>$array['dislikes'],
		    'REVIEWS_TOTAL'=> $this->getReviewsCount($array['products_id']), 
		    'REVIEWS_TOTAL_RATING'=> $this->getReviewsRating($array['products_id']), 
		    'REVIEWS_STAR_RATING'=> $star_rating, 
				'COUNT'=>$array['ID'],
				'EXTRA_FIELDS'=>$extra_fields_data,
				'SPECS'=>$specifications_data,
				'PRODUCTS_ID'=>$array['products_id'],
				'PRODUCTS_VPE' => $this->getVPEtext($array, $products_price['plain']), 
				'PRODUCTS_LABEL' => $this->getLabelText($array, $array['label_id']), 
				'PRODUCTS_IMAGE' => $this->productImage($array['products_image'], $image), 
				'PRODUCTS_IMAGE_INFO' => $this->productImage($array['products_image'], 'info'), 
				'PRODUCTS_IMAGE_POPUP' => $this->productImage($array['products_image'], 'popup'), 
				'PRODUCTS_IMAGE_ORIGINAL' => $this->productImage($array['products_image'], 'original'), 
				'PRODUCTS_LINK' => vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($array['products_id'], $array['products_name'])), 
				'PRODUCTS_PRICE' => $products_price['formated'], 
				'PRODUCTS_SPECIAL' => $products_special, 
				'PRODUCTS_PRICE_PLAIN' => $products_price['plain'], 
				'PRODUCTS_TAX_INFO' => $main->getTaxInfo($tax_rate), 
				'MANUFACTURER' => vam_get_manufacturers_name($array['manufacturers_id']), 
				'PRODUCTS_SHIPPING_LINK' => $main->getShippingLink(), 
				'PRODUCTS_BUTTON_BUY_NOW' => $buy_now,
				'PRODUCTS_BUTTON_BUY_NOW_NEW' => $buy_now_new,
				'PRODUCTS_SHIPPING_NAME'=>$shipping_status_name,
				'PRODUCTS_SHIPPING_IMAGE'=>$shipping_status_image, 
				'PRODUCTS_DESCRIPTION' => $array['products_description'],
				'PRODUCTS_EXPIRES' => $array['expires_date'],
				'PRODUCTS_DATE_AVAILABLE' => vam_date_short($array['products_date_available']),
				'PRODUCTS_CATEGORY_URL'=>$array['cat_url'],
				'PRODUCTS_SHORT_DESCRIPTION' => $array['products_short_description'], 
				'PRODUCTS_FSK18' => $array['products_fsk18']);		
				

	}
	
	}

	function productImage($name, $type) {

		switch ($type) {
			case 'info' :
				$path = DIR_WS_INFO_IMAGES;
				break;
			case 'thumbnail' :
				$path = DIR_WS_THUMBNAIL_IMAGES;
				break;
			case 'popup' :
				$path = DIR_WS_POPUP_IMAGES;
				break;
			case 'original' :
				$path = DIR_WS_ORIGINAL_IMAGES;
				break;
		}

		if ($name == '') {
			if ($this->useStandardImage == 'true' && $this->standardImage != '')
				return $path.$this->standardImage;
		} else {
			// check if image exists
			if (!file_exists($path.$name)) {
				if ($this->useStandardImage == 'true' && $this->standardImage != '')
					$name = $this->standardImage;
			}
			return $path.$name;
		}
	}
}
?>
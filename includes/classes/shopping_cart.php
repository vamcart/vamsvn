<?php
/* -----------------------------------------------------------------------------------------
   $Id: shopping_cart.php 1534 2007-02-06 20:23:03 VaM $ 

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(shopping_cart.php,v 1.32 2003/02/11); www.oscommerce.com
   (c) 2003	 nextcommerce (shopping_cart.php,v 1.21 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (shopping_cart.php,v 1.21 2003/08/17); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:

   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once (DIR_FS_INC.'vam_create_random_value.inc.php');
require_once (DIR_FS_INC.'vam_get_prid.inc.php');
require_once (DIR_FS_INC.'vam_rus_chars.inc.php');
require_once (DIR_FS_INC.'vam_draw_form.inc.php');
require_once (DIR_FS_INC.'vam_draw_input_field.inc.php');
require_once (DIR_FS_INC.'vam_image_submit.inc.php');
require_once (DIR_FS_INC.'vam_get_tax_description.inc.php');

class shoppingCart {
	var $contents, $total, $weight, $cartID, $content_type;

	function __construct() {
		$this->reset();

	}

	function restore_contents() {

		if (!isset ($_SESSION['customer_id']))
			return false;

		// insert current cart contents in database
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				$qty = $this->contents[$products_id]['qty'];
				$product_query = vam_db_query("select products_id from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$products_id."'");
				if (!vam_db_num_rows($product_query)) {
					vam_db_query("insert into ".TABLE_CUSTOMERS_BASKET." (customers_id, products_id, customers_basket_quantity, customers_basket_date_added) values ('".$_SESSION['customer_id']."', '".$products_id."', '".$qty."', '".date('Ymd')."')");
					if (isset ($this->contents[$products_id]['attributes'])) {
						reset($this->contents[$products_id]['attributes']);
						while (list ($option, $value) = each($this->contents[$products_id]['attributes'])) {
						           $attr_value = $this->contents[$products_id]['attributes_values'][$option];

							vam_db_query("insert into ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." (customers_id, products_id, products_options_id, products_options_value_id, products_options_value_text) values ('".$_SESSION['customer_id']."', '".$products_id."', '".$option."', '".$value."', '" . vam_db_input($attr_value) . "')");
						}
					}
				} else {
					vam_db_query("update ".TABLE_CUSTOMERS_BASKET." set customers_basket_quantity = customers_basket_quantity+'".$qty."' where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$products_id."'");
				}
			}
		}

		// reset per-session cart contents, but not the database contents
		$this->reset(false);

		$products_query = vam_db_query("select products_id, customers_basket_quantity from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."'");
		while ($products = vam_db_fetch_array($products_query)) {
			$this->contents[$products['products_id']] = array ('qty' => $products['customers_basket_quantity']);
			// attributes
			$attributes_query = vam_db_query("select products_options_id, products_options_value_id, products_options_value_text from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$products['products_id']."'");
			while ($attributes = vam_db_fetch_array($attributes_query)) {
				$this->contents[$products['products_id']]['attributes'][$attributes['products_options_id']] = $attributes['products_options_value_id'];
				if ($attributes['products_options_value_text']!='') {
                                                $this->contents[$products['products_id']]['attributes_values'][$attributes['products_options_id']] = $attributes['products_options_value_text'];
                                            }
			}
		}

		$this->cleanup();
	}

	function reset($reset_database = false) {

		$this->contents = array ();
		$this->total = 0;
		$this->weight = 0;
		$this->content_type = false;

		if (isset ($_SESSION['customer_id']) && ($reset_database == true)) {
			vam_db_query("delete from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where customers_id = '".$_SESSION['customer_id']."'");
		}

		unset ($this->cartID);
		if (isset ($_SESSION['cartID']))
			unset ($_SESSION['cartID']);
	}

	function add_cart($products_id, $qty = '1', $attributes = '', $notify = true) {
		global $new_products_id_in_cart;

		$products_id = vam_get_uprid($products_id, $attributes);
		if ($notify == true) {
			$_SESSION['new_products_id_in_cart'] = $products_id;
		}

		if ($this->in_cart($products_id)) {
			$this->update_quantity($products_id, $qty, $attributes);
		} else {
			$this->contents[] = array ($products_id);
			$this->contents[$products_id] = array ('qty' => $qty);
			// insert into database
			if (isset ($_SESSION['customer_id']))
				vam_db_query("insert into ".TABLE_CUSTOMERS_BASKET." (customers_id, products_id, customers_basket_quantity, customers_basket_date_added) values ('".$_SESSION['customer_id']."', '".$products_id."', '".$qty."', '".date('Ymd')."')");

			if (is_array($attributes)) {
				reset($attributes);
				while (list ($option, $value) = each($attributes)) {

             $attr_value = NULL;
            $blank_value = FALSE;
            if (strstr($option, 'txt_')) {
              if (trim($value) == NULL)
              {
                $blank_value = TRUE;
              } else {
                $option_1 = substr($option, strlen('txt_'));
                $option_2 = preg_split('/_/', $option_1);
                $option = $option_2[0];
                $attr_value = htmlspecialchars(stripslashes($value), ENT_QUOTES);
                $value = $option_2[1];
                $this->contents[$products_id]['attributes_values'][$option] = $attr_value;
              }
            }

			if (!$blank_value)
            {
					$this->contents[$products_id]['attributes'][$option] = $value;
					// insert into database
					if (isset ($_SESSION['customer_id']))
						vam_db_query("insert into ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." (customers_id, products_id, products_options_id, products_options_value_id, products_options_value_text) values ('".$_SESSION['customer_id']."', '".$products_id."', '".$option."', '".$value."', '" . vam_db_input($attr_value) . "')");
				}
				}
			}
		}
		$this->cleanup();

		// assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
		$this->cartID = $this->generate_cart_id();
	}

	function update_quantity($products_id, $quantity = '', $attributes = '') {

		if (empty ($quantity))
			return true; // nothing needs to be updated if theres no quantity, so we return true..

		$this->contents[$products_id] = array ('qty' => $quantity);
		// update database
		if (isset ($_SESSION['customer_id']))
			vam_db_query("update ".TABLE_CUSTOMERS_BASKET." set customers_basket_quantity = '".$quantity."' where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$products_id."'");

		if (is_array($attributes)) {
			reset($attributes);
			while (list ($option, $value) = each($attributes)) {

			// txt attributes
             $attr_value = NULL;
            $blank_value = FALSE;
            if (strstr($option, 'txt_')) {
              if (trim($value) == NULL)
              {
                $blank_value = TRUE;
              } else {
                $option_1 = substr($option, strlen('txt_'));
                $option_2 = preg_split('/_/', $option_1);
                $option = $option_2[0];
                $attr_value = htmlspecialchars(stripslashes($value), ENT_QUOTES);
                $value = $option_2[1];
                $this->contents[$products_id]['attributes_values'][$option] = String_RusCharsDeCode($attr_value);
              }
            }

			if (!$blank_value)
                                    {
				$this->contents[$products_id]['attributes'][$option] = $value;
				// update database
				if (isset ($_SESSION['customer_id']))
					vam_db_query("update ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." set products_options_value_id = '".$value."' where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$products_id."' and products_options_id = '".$option."'");
			}
			}
		}
	}

	function cleanup() {

		reset($this->contents);
		while (list ($key,) = each($this->contents)) {
			if ($this->contents[$key]['qty'] < 1) {
				unset ($this->contents[$key]);
				// remove from database
				if (vam_session_is_registered('customer_id')) {
					vam_db_query("delete from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$key."'");
					vam_db_query("delete from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$key."'");
				}
			}
		}
	}

	function count_contents() { // get total number of items in cart
		$total_items = 0;
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				$total_items += $this->get_quantity($products_id);
			}
		}

		return $total_items;
	}

	function get_quantity($products_id) {
		if (isset ($this->contents[$products_id])) {
			return $this->contents[$products_id]['qty'];
		} else {
			return 0;
		}
	}

	function in_cart($products_id) {
		if (isset ($this->contents[$products_id])) {
			return true;
		} else {
			return false;
		}
	}

	function remove($products_id) {

		$this->contents[$products_id]= NULL;
		// remove from database
		if (vam_session_is_registered('customer_id')) {
			vam_db_query("delete from ".TABLE_CUSTOMERS_BASKET." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$products_id."'");
			vam_db_query("delete from ".TABLE_CUSTOMERS_BASKET_ATTRIBUTES." where customers_id = '".$_SESSION['customer_id']."' and products_id = '".$products_id."'");
		}

		// assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
		$this->cartID = $this->generate_cart_id();
	}

	function remove_all() {
		$this->reset();
	}

	function get_product_id_list() {
		$product_id_list = '';
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				$product_id_list .= ', '.$products_id;
			}
		}

		return substr($product_id_list, 2);
	}

	function calculate() {
		global $vamPrice;
		$this->total = 0;
		$this->qty = 0;
		$this->weight = 0;
		$this->tax = array ();
		if (!is_array($this->contents))
			return 0;

		reset($this->contents);
		while (list ($products_id,) = each($this->contents)) {
			$qty = $this->contents[$products_id]['qty'];

			// products price
			$product_query = vam_db_query("select products_id, products_price, products_discount_allowed, products_tax_class_id, products_weight from ".TABLE_PRODUCTS." where products_id='".vam_get_prid($products_id)."'");
			if ($product = vam_db_fetch_array($product_query)) {

				$products_price = $vamPrice->GetPrice($product['products_id'], $format = false, $qty, $product['products_tax_class_id'], $product['products_price']);
				$this->total += $products_price * $qty;
				$this->qty += $qty;
				$this->weight += ($qty * $product['products_weight']);


							// attributes price
				$attribute_price = 0;
			if (isset ($this->contents[$products_id]['attributes'])) {
				reset($this->contents[$products_id]['attributes']);
				while (list ($option, $value) = each($this->contents[$products_id]['attributes'])) {

					$values = $vamPrice->GetOptionPrice($product['products_id'], $option, $value);
					$this->weight += $values['weight'] * $qty;
					$this->total += $values['price'] * $qty;
					$this->qty += $qty;
					$attribute_price+=$values['price'];
				}
			}


				if ($product['products_tax_class_id'] != 0) {

					if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
						$products_price_tax = $products_price - ($products_price / 100 * $_SESSION['customers_status']['customers_status_ot_discount']);
						$attribute_price_tax = $attribute_price - ($attribute_price / 100 * $_SESSION['customers_status']['customers_status_ot_discount']);
					}


					$products_tax = $vamPrice->TAX[$product['products_tax_class_id']];

					$products_tax_description = vam_get_tax_description($product['products_tax_class_id']);


					// price incl tax
					if ($_SESSION['customers_status']['customers_status_show_price_tax'] == '1') {
						if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
							$this->tax[$product['products_tax_class_id']]['value'] += ((($products_price_tax+$attribute_price_tax) / (100 + $products_tax)) * $products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = TAX_ADD_TAX."$products_tax_description";
						} else {
							$this->tax[$product['products_tax_class_id']]['value'] += ((($products_price+$attribute_price) / (100 + $products_tax)) * $products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = TAX_ADD_TAX."$products_tax_description";
						}

					}
					// excl tax + tax at checkout
					if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
						if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1) {
							$this->tax[$product['products_tax_class_id']]['value'] += (($products_price_tax+$attribute_price_tax) / 100) * ($products_tax)*$qty;
							$this->total+=(($products_price_tax+$attribute_price_tax) / 100) * ($products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = TAX_NO_TAX."$products_tax_description";
						} else {
							$this->tax[$product['products_tax_class_id']]['value'] += (($products_price+$attribute_price) / 100) * ($products_tax)*$qty;
							$this->total+= (($products_price+$attribute_price) / 100) * ($products_tax)*$qty;
							$this->tax[$product['products_tax_class_id']]['desc'] = TAX_NO_TAX."$products_tax_description";
						}
					}
				}
			}

		}
//		echo 'total_VOR'.$this->total;
		if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] != 0) {
//			$this->total -= $this->total / 100 * $_SESSION['customers_status']['customers_status_ot_discount'];
		}
//		echo 'total_NACH'.$this->total;

	}

	function attributes_price($products_id) {
		global $vamPrice;
		if (isset ($this->contents[$products_id]['attributes'])) {
			reset($this->contents[$products_id]['attributes']);
			while (list ($option, $value) = each($this->contents[$products_id]['attributes'])) {

				$values = $vamPrice->GetOptionPrice($products_id, $option, $value);
				$attributes_price += $values['price'];

			}
		}
		return $attributes_price;
	}

	function get_products() {
		global $vamPrice,$main;
		if (!is_array($this->contents))
			return false;

		$products_array = array ();
		reset($this->contents);
		while (list ($products_id,) = each($this->contents)) {
			if($this->contents[$products_id]['qty'] != 0 || $this->contents[$products_id]['qty'] !=''){
			$products_query = vam_db_query("select p.products_id, pd.products_name,p.products_shippingtime, p.products_image, p.products_model, p.products_price, p.products_discount_allowed, p.products_weight, p.products_tax_class_id from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_id='".vam_get_prid($products_id)."' and pd.products_id = p.products_id and pd.language_id = '".$_SESSION['languages_id']."'");
			if ($products = vam_db_fetch_array($products_query)) {
				$prid = $products['products_id'];

				$products_price = $vamPrice->GetPrice($products['products_id'], $format = false, $this->contents[$products_id]['qty'], $products['products_tax_class_id'], $products['products_price']);

				$products_array[] = array (
				
				'id' => $products_id, 
				'name' => $products['products_name'], 
				'model' => $products['products_model'], 
				'image' => $products['products_image'], 
				'price' => $products_price + $this->attributes_price($products_id), 
				'quantity' => $this->contents[$products_id]['qty'], 
				'weight' => $products['products_weight'],
				'shipping_time' => $main->getShippingStatusName($products['products_shippingtime']), 
				'final_price' => ($products_price + $this->attributes_price($products_id)), 
				'tax_class_id' => $products['products_tax_class_id'], 
				'attributes' => $this->contents[$products_id]['attributes'], 
				'attributes_values' => (isset($this->contents[$products_id]['attributes_values']) ? $this->contents[$products_id]['attributes_values'] : '')
				
				);
			}
			}
		}

		return $products_array;
	}

	function show_total() {
		$this->calculate();

		return $this->total;
	}

	function show_weight() {
		$this->calculate();

		return $this->weight;
	}

	function show_quantity() {
		$this->calculate();

		return $this->qty;
	}

	function show_tax($format = true) {
		global $vamPrice;
		$this->calculate();
		$output = "";
		$val=0;
		foreach ($this->tax as $key => $value) {
			if ($this->tax[$key]['value'] > 0 ) {
			$output .= $this->tax[$key]['desc'].": ".$vamPrice->Format($this->tax[$key]['value'], true)."<br />";
			$val = $this->tax[$key]['value'];
			}
		}
		if ($format) {
		return $output;
		} else {
			return $val;
		}
	}

	function generate_cart_id($length = 5) {
		return vam_create_random_value($length, 'digits');
	}

	function get_content_type() {
		$this->content_type = false;

		if ((DOWNLOAD_ENABLED == 'true') && ($this->count_contents() > 0)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				if (isset ($this->contents[$products_id]['attributes'])) {
					reset($this->contents[$products_id]['attributes']);
					while (list (, $value) = each($this->contents[$products_id]['attributes'])) {
						$virtual_check_query = vam_db_query("select count(*) as total from ".TABLE_PRODUCTS_ATTRIBUTES." pa, ".TABLE_PRODUCTS_ATTRIBUTES_DOWNLOAD." pad where pa.products_id = '".$products_id."' and pa.options_values_id = '".$value."' and pa.products_attributes_id = pad.products_attributes_id");
						$virtual_check = vam_db_fetch_array($virtual_check_query);

						if ($virtual_check['total'] > 0) {
							switch ($this->content_type) {
								case 'physical' :
									$this->content_type = 'mixed';
									return $this->content_type;
									break;

								default :
									$this->content_type = 'virtual';
									break;
							}
						} else {
							switch ($this->content_type) {
								case 'virtual' :
									$this->content_type = 'mixed';
									return $this->content_type;
									break;

								default :
									$this->content_type = 'physical';
									break;
							}
						}
					}
				} else {
					switch ($this->content_type) {
						case 'virtual' :
							$this->content_type = 'mixed';
							return $this->content_type;
							break;

						default :
							$this->content_type = 'physical';
							break;
					}
				}
			}
		} else {
			$this->content_type = 'physical';
		}
		return $this->content_type;
	}

	function unserialize($broken) {
		for (reset($broken); $kv = each($broken);) {
			$key = $kv['key'];
			if (gettype($this-> $key) != "user function")
				$this-> $key = $kv['value'];
		}
	}
	// GV Code Start
	// ------------------------ ICW CREDIT CLASS Gift Voucher Addittion-------------------------------Start
	// amend count_contents to show nil contents for shipping
	// as we don't want to quote for 'virtual' item
	// GLOBAL CONSTANTS if NO_COUNT_ZERO_WEIGHT is true then we don't count any product with a weight
	// which is less than or equal to MINIMUM_WEIGHT
	// otherwise we just don't count gift certificates

	function count_contents_virtual() { // get total number of items in cart disregard gift vouchers
		$total_items = 0;
		if (is_array($this->contents)) {
			reset($this->contents);
			while (list ($products_id,) = each($this->contents)) {
				$no_count = false;
				$gv_query = vam_db_query("select products_model from ".TABLE_PRODUCTS." where products_id = '".$products_id."'");
				$gv_result = vam_db_fetch_array($gv_query);
				if (preg_match('/^GIFT/', $gv_result['products_model'])) {
					$no_count = true;
				}
				if (NO_COUNT_ZERO_WEIGHT == 1) {
					$gv_query = vam_db_query("select products_weight from ".TABLE_PRODUCTS." where products_id = '".vam_get_prid($products_id)."'");
					$gv_result = vam_db_fetch_array($gv_query);
					if ($gv_result['products_weight'] <= MINIMUM_WEIGHT) {
						$no_count = true;
					}
				}
				if (!$no_count)
					$total_items += $this->get_quantity($products_id);
			}
		}
		return $total_items;
	}
	// ------------------------ ICW CREDIT CLASS Gift Voucher Addittion-------------------------------End
	//GV Code End
}
?>
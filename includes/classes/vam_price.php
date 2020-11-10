<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_price.php 1286 2007-02-06 20:23:03 VaM $ 

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(Coding Standards); www.oscommerce.com 
   (c) 2004 xt:Commerce (mmain.php); www.oscommerce.com 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
 
class vamPrice {
	var $currencies;

	// class constructor
	function __construct($currency, $cGroup, $customer_id = null) {
//		if (!$customer_id && $_SESSION['customer_id']) {
//			$customer_id=$_SESSION['customer_id'];
//		}
		$this->currencies = array ();
		$this->cStatus = array ();
		$this->actualGroup = $cGroup;
		$this->actualCurr = $currency;
		$this->TAX = array ();
		$this->SHIPPING = array();
		$this->showFrom_Attributes = true;


		// select Currencies

		$currencies_query = "SELECT *
				                                    FROM
				                                         ".TABLE_CURRENCIES;
		$currencies_query = vamDBquery($currencies_query);
		while ($currencies = vam_db_fetch_array($currencies_query, true)) {
			$this->currencies[$currencies['code']] = array (
			
			'title' => $currencies['title'], 
			'symbol_left' => $currencies['symbol_left'], 
			'symbol_right' => $currencies['symbol_right'], 
			'decimal_point' => $currencies['decimal_point'], 
			'thousands_point' => $currencies['thousands_point'], 
			'decimal_places' => $currencies['decimal_places'], 
			'value' => $currencies['value']
			
			);
		}
		// select Customers Status data
		$customers_status_query = "SELECT *
				                                        FROM
				                                             ".TABLE_CUSTOMERS_STATUS."
				                                        WHERE
				                                             customers_status_id = '".(int)$this->actualGroup."' AND language_id = '".(int)$_SESSION['languages_id']."'";
		$customers_status_query = vamDBquery($customers_status_query);
		$customers_status_value = vam_db_fetch_array($customers_status_query, true);

	$this->cStatus = array (
		
		'customers_status_id' => $this->actualGroup, 
		'customers_status_name' => $customers_status_value['customers_status_name'], 
		'customers_status_image' => $customers_status_value['customers_status_image'], 
		'customers_status_public' => $customers_status_value['customers_status_public'], 
		'customers_status_discount' => ($_SESSION['customers_status']['customers_status_discount'] > 0 ? $_SESSION['customers_status']['customers_status_discount'] : $customers_status_value['customers_status_discount']),
		'customers_status_ot_discount_flag' => $customers_status_value['customers_status_ot_discount_flag'], 
		'customers_status_ot_discount' => $customers_status_value['customers_status_ot_discount'], 
		'customers_status_discount_by_category' => $customers_status_value['customers_status_discount_by_category'], 
		'customers_status_discount_by_brand' => $customers_status_value['customers_status_discount_by_brand'], 
		'customers_status_graduated_prices' => $customers_status_value['customers_status_graduated_prices'], 
		'customers_status_show_price' => $customers_status_value['customers_status_show_price'], 
		'customers_status_show_price_tax' => $customers_status_value['customers_status_show_price_tax'], 
		'customers_status_add_tax_ot' => $customers_status_value['customers_status_add_tax_ot'], 
		'customers_status_payment_unallowed' => $customers_status_value['customers_status_payment_unallowed'], 
		'customers_status_shipping_unallowed' => $customers_status_value['customers_status_shipping_unallowed'], 
		'customers_status_discount_attributes' => $customers_status_value['customers_status_discount_attributes'], 
		'customers_fsk18' => $customers_status_value['customers_fsk18'], 
		'customers_fsk18_display' => $customers_status_value['customers_fsk18_display']
		);

		// prefetch tax rates for standard zone
		$zones_query = vamDBquery("SELECT tax_class_id as class FROM ".TABLE_TAX_CLASS);
		while ($zones_data = vam_db_fetch_array($zones_query,true)) {
			
			// calculate tax based on shipping or deliverey country (for downloads)
			if (isset($_SESSION['billto']) && isset($_SESSION['sendto'])) {
			$tax_address_query = vam_db_query("select ab.entry_country_id, ab.entry_zone_id from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) where ab.customers_id = '" . (int)$_SESSION['customer_id'] . "' and ab.address_book_id = '" . ($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . "'");
      		$tax_address = vam_db_fetch_array($tax_address_query);
			$this->TAX[$zones_data['class']]=vam_get_tax_rate($zones_data['class'],$tax_address['entry_country_id'], $tax_address['entry_zone_id']);				
			} else {
			$this->TAX[$zones_data['class']]=vam_get_tax_rate($zones_data['class']);		
			}
			
			
		}
				
	}

	// get products Price
	function GetPrice($pID, $format = true, $qty, $tax_class, $pPrice, $vpeStatus = 0, $cedit_id = 0) {

			// check if group is allowed to see prices
	if ($this->cStatus['customers_status_show_price'] == '0')
			return $this->ShowNote($vpeStatus, $vpeStatus);

		// get Tax rate
		if ($cedit_id != 0) {
			$cinfo = vam_oe_customer_infos($cedit_id);
			$products_tax = vam_get_tax_rate($tax_class, $cinfo['country_id'], $cinfo['zone_id']);
		} else {
			$products_tax = $this->TAX[$tax_class];
		}

		if ($this->cStatus['customers_status_show_price_tax'] == '0')
			$products_tax = '';

		// add taxes
		if ($pPrice == 0)
			$pPrice = $this->getPprice($pID);
		$pPrice = $this->AddTax($pPrice, $products_tax);

		if ($this->cStatus['customers_status_graduated_prices'] != '1' AND $this->GetGroupPrice($pID, 1)) {
		   $message_old_price=GROUP_PRICE;
		} else {
		   $message_old_price=RETAIL_PRICE;
		}


		// check specialprice
		if ($sPrice = $this->CheckSpecial($pID))
			return $this->FormatSpecial($pID, $this->AddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, $message_old_price);

		// check special manufacturer price
		if ($discount = $this->CheckManufacturerDiscount($_SESSION['customer_id'], $pID)) {
			return $this->FormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus, $message_old_price, YOUR_PRICE, MANUFACTURER_DISCOUNT);
		}

		// check discount by categories
		if ($this->cStatus['customers_status_discount'] <= '0') {
		if ($this->cStatus['customers_status_discount_by_category'] == '1') {
		if ($discount = $this->CheckCategoryByCustomerStatusDiscount($_SESSION['customer_id'], $pID)) {
			return $this->FormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus, $message_old_price, YOUR_PRICE, CATEGORY_DISCOUNT);
		}
		}
		}

		// check discount by brands
		if ($this->cStatus['customers_status_discount'] <= '0') {
		if ($this->cStatus['customers_status_discount_by_brand'] == '1') {
		if ($discount = $this->CheckBrandByCustomerStatusDiscount($_SESSION['customer_id'], $pID)) {
			return $this->FormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus, $message_old_price, YOUR_PRICE, BRAND_DISCOUNT);
		}
		}
		}

		// check graduated
		if ($this->cStatus['customers_status_graduated_prices'] == '1') {
			if ($sPrice = $this->GetGraduatedPrice($pID, $qty))
				return $this->FormatSpecialGraduated($pID, $this->AddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, $message_old_price, YOUR_GRADUATED_PRICE, "");
		} else {
			// check Group Price
			if ($sPrice = $this->GetGroupPrice($pID, 1)) 
				return $this->FormatSpecialGraduated($pID, $this->AddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, GROUP_PRICE, YOUR_PRICE, PERSONAL_DISCOUNT);
		}

		// check Product Discount
		if ($discount = $this->CheckDiscount($pID))
			return $this->FormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus, RETAIL_PRICE, YOUR_PRICE, PERSONAL_DISCOUNT);

		return $this->Format($pPrice, $format, 0, false, $vpeStatus, $pID);

	}

	function getPprice($pID) {
		$pQuery = "SELECT products_price FROM ".TABLE_PRODUCTS." WHERE products_id='".(int)$pID."'";
		$pQuery = vamDBquery($pQuery);
		$pData = vam_db_fetch_array($pQuery, true);
		return $pData['products_price'];


	}

	function AddTax($price, $tax) {
		$price = $price + $price / 100 * $tax;
		$price = $this->CalculateCurr($price);
		return round($price, (int)$this->currencies[$this->actualCurr]['decimal_places']);
	}

	function CheckDiscount($pID) {

		// check if group got discount
		if ($this->cStatus['customers_status_discount'] != '0.00') {

			$discount_query = "SELECT products_discount_allowed FROM ".TABLE_PRODUCTS." WHERE products_id = '".(int)$pID."'";
			$discount_query = vamDBquery($discount_query);
			$dData = vam_db_fetch_array($discount_query, true);

			$discount = $dData['products_discount_allowed'];
			if ($this->cStatus['customers_status_discount'] < $discount)
				$discount = $this->cStatus['customers_status_discount'];
			if ($discount == '0.00')
				return false;
				
			$discount = number_format($discount);
							
			return $discount;

		}
		return false;
	}

	function GetGraduatedPrice($pID, $qty) {
		if (GRADUATED_ASSIGN == 'true')
			if (vam_get_qty($pID) > $qty)
				$qty = vam_get_qty($pID);
		//if (!is_int($this->cStatus['customers_status_id']) && $this->cStatus['customers_status_id']!=0) $this->cStatus['customers_status_id'] = DEFAULT_CUSTOMERS_STATUS_ID_GUEST;
		$graduated_price_query = "SELECT max(quantity) as qty
				                                FROM ".TABLE_PERSONAL_OFFERS_BY.$this->actualGroup."
				                                WHERE products_id='".(int)$pID."'
				                                AND quantity<='".(int)$qty."'";
		$graduated_price_query = vamDBquery($graduated_price_query);
		$graduated_price_data = vam_db_fetch_array($graduated_price_query, true);
		if ($graduated_price_data['qty']) {
			$graduated_price_query = "SELECT personal_offer
						                                FROM ".TABLE_PERSONAL_OFFERS_BY.$this->actualGroup."
						                                WHERE products_id='".(int)$pID."'
						                                AND quantity='".(int)$graduated_price_data['qty']."'";
			$graduated_price_query = vamDBquery($graduated_price_query);
			$graduated_price_data = vam_db_fetch_array($graduated_price_query, true);

			$sPrice = $graduated_price_data['personal_offer'];
			if ($sPrice != 0.00)
				return $sPrice;
		} else {
			return;
		}

	}

	function GetGroupPrice($pID, $qty) {

		$graduated_price_query = "SELECT max(quantity) as qty
				                                FROM ".TABLE_PERSONAL_OFFERS_BY.$this->actualGroup."
				                                WHERE products_id='".(int)$pID."'
				                                AND quantity<='".(int)$qty."'";
		$graduated_price_query = vamDBquery($graduated_price_query);
		$graduated_price_data = vam_db_fetch_array($graduated_price_query, true);
		if ($graduated_price_data['qty']) {
			$graduated_price_query = "SELECT personal_offer
						                                FROM ".TABLE_PERSONAL_OFFERS_BY.$this->actualGroup."
						                                WHERE products_id='".(int)$pID."'
						                                AND quantity='".(int)$graduated_price_data['qty']."'";
			$graduated_price_query = vamDBquery($graduated_price_query);
			$graduated_price_data = vam_db_fetch_array($graduated_price_query, true);

			$sPrice = $graduated_price_data['personal_offer'];
			if ($sPrice != 0.00)
				return $sPrice;
		} else {
			return;
		}

	}

	function GetOptionPrice($pID, $option, $value) {
		$attribute_price_query = "select pd.products_discount_allowed,pd.products_tax_class_id, p.options_values_price, p.price_prefix, p.options_values_weight, p.weight_prefix from ".TABLE_PRODUCTS_ATTRIBUTES." p, ".TABLE_PRODUCTS." pd where p.products_id = '".(int)$pID."' and p.options_id = '".(int)$option."' and pd.products_id = p.products_id and p.options_values_id = '".(int)$value."'";
		$attribute_price_query = vamDBquery($attribute_price_query);
		$attribute_price_data = vam_db_fetch_array($attribute_price_query, true);
		$dicount = 0;
		if ($this->cStatus['customers_status_discount_attributes'] == 1 && $this->cStatus['customers_status_discount'] != 0.00) {
			$discount = $this->cStatus['customers_status_discount'];
			if ($attribute_price_data['products_discount_allowed'] < $this->cStatus['customers_status_discount'])
				$discount = $attribute_price_data['products_discount_allowed'];
		}
//		$price = $this->GetPrice($pID, $format = false, 1, $attribute_price_data['products_tax_class_id'], $attribute_price_data['options_values_price']);
		$price = $this->Format($attribute_price_data['options_values_price'], false, $attribute_price_data['products_tax_class_id'],true);
		if ($attribute_price_data['weight_prefix'] != '+')
			$attribute_price_data['options_values_weight'] *= -1;
		if ($attribute_price_data['price_prefix'] == '+') {
			$price = $price - $price / 100 * $discount;
		} else {
			$price *= -1;
		}
		return array ('weight' => $attribute_price_data['options_values_weight'], 'price' => $price);
	}

	function ShowNote($vpe, $vpeStatus = 0) {
		if ($vpeStatus == 1)
			return array ('formated' => NOT_ALLOWED_TO_SEE_PRICES, 'plain' => 0);
		return NOT_ALLOWED_TO_SEE_PRICES;
	}

	function CheckSpecial($pID) {
		$product_query = "select specials_new_products_price from ".TABLE_SPECIALS." where products_id = '".(int)$pID."' and status=1";
		$product_query = vamDBquery($product_query);
		$product = vam_db_fetch_array($product_query, true);

		return $product['specials_new_products_price'];

	}

	function CheckManufacturerDiscount($cID, $pID) {
		$product_query = "select manufacturers_id from ".TABLE_PRODUCTS." where products_id = '".(int)$pID."'";
		$product_query = vamDBquery($product_query);
		$product = vam_db_fetch_array($product_query, true);
		if ($product['manufacturers_id'] > 0) {
		$manufacturer_query = "SELECT discount FROM ".TABLE_CUSTOMERS_TO_MANUFACTURERS_DISCOUNT." WHERE customers_id = '".(int)$cID."' AND manufacturers_id = '".(int)$product['manufacturers_id']."'";
		$manufacturer_query = vamDBquery($manufacturer_query);
		$manufacturer = vam_db_fetch_array($manufacturer_query, true);
		} else {
		$manufacturer['discount'] = 0;
		}

		return $manufacturer['discount'];
	}

	function CheckCategoryByCustomerStatusDiscount($cID, $pID) {
		$category_id_query = "select p2c.categories_id from ".TABLE_PRODUCTS." p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c where p2c.products_id = p.products_id and p.products_id = '".(int)$pID."'";
		$category_id_query = vamDBquery($category_id_query);
		$category_id = vam_db_fetch_array($category_id_query, true);
		if ($category_id['categories_id'] > 0) {
		$category_discount_query = "SELECT discount FROM ".TABLE_CUSTOMERS_STATUS_TO_CATEGORIES." WHERE customers_status_id = '".(int)$this->actualGroup."' AND categories_id = '".(int)$category_id['categories_id']."'";
		$category_discount_query = vamDBquery($category_discount_query);
		$category_discount = vam_db_fetch_array($category_discount_query, true);
		} else {
		$category_discount['discount'] = 0;
		}

		return $category_discount['discount'];
	}

	function CheckBrandByCustomerStatusDiscount($cID, $pID) {
		$product_query = "select manufacturers_id from ".TABLE_PRODUCTS." where products_id = '".(int)$pID."'";
		$product_query = vamDBquery($product_query);
		$product = vam_db_fetch_array($product_query, true);
		if ($product['manufacturers_id'] > 0) {
		$manufacturer_query = "SELECT discount FROM ".TABLE_CUSTOMERS_STATUS_TO_MANUFACTURERS." WHERE customers_status_id = '".(int)$this->actualGroup."' AND manufacturers_id = '".(int)$product['manufacturers_id']."'";
		$manufacturer_query = vamDBquery($manufacturer_query);
		$manufacturer = vam_db_fetch_array($manufacturer_query, true);
		} else {
		$manufacturer['discount'] = 0;
		}

		return $manufacturer['discount'];
	}


	function CalculateCurr($price) {
		return $this->currencies[$this->actualCurr]['value'] * $price;
	}

	function calcTax($price, $tax) {
		return $price * $tax / 100;
	}

	function RemoveCurr($price) {

		// check if used Curr != DEFAULT curr
		if (DEFAULT_CURRENCY != $this->actualCurr) {
			return $price * (1 / $this->currencies[$this->actualCurr]['value']);
		} else {
			return $price;
		}

	}

	function RemoveTax($price, $tax) {
		$price = ($price / (($tax +100) / 100));
		return $price;
	}

	function GetTax($price, $tax) {
		$tax = $price - $this->RemoveTax($price, $tax);
		return $tax;
	}
	
	function RemoveDC($price,$dc) {
	
		$price = $price - ($price/100*$dc);
		
		return $price;	
	}
	
	function GetDC($price,$dc) {
		
		$dc = $price/100*$dc;
	
		return $dc;	
	}

	function checkAttributes($pID) {
		if (!$this->showFrom_Attributes) return;
		if ($pID == 0)
			return;
		$products_attributes_query = "select count(*) as total from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".$pID."' and patrib.options_id = popt.products_options_id and popt.language_id = '".(int) $_SESSION['languages_id']."'";
		$products_attributes = vamDBquery($products_attributes_query);
		$products_attributes = vam_db_fetch_array($products_attributes, true);
		if ($products_attributes['total'] > 0)
			return ' '.strtolower(FROM).' ';
	}

	function CalculateCurrEx($price, $curr) {
		return $price * ($this->currencies[$curr]['value'] / $this->currencies[$this->actualCurr]['value']);
	}

	/*
	*
	*    Format Functions
	*
	*
	*
	*/

	function Format($price, $format, $tax_class = 0, $curr = false, $vpeStatus = 0, $pID = 0) {

		if ($curr)
			$price = $this->CalculateCurr($price);

		if ($tax_class != 0) {
			$products_tax = $this->TAX[$tax_class];
			if ($this->cStatus['customers_status_show_price_tax'] == '0')
				$products_tax = '';
			$price = $this->AddTax($price, $products_tax);
		}

		if ($format) {
			$Pprice = number_format((double)$price, (int)$this->currencies[$this->actualCurr]['decimal_places'], $this->currencies[$this->actualCurr]['decimal_point'], $this->currencies[$this->actualCurr]['thousands_point']);
			$Pprice = $this->checkAttributes($pID).$this->currencies[$this->actualCurr]['symbol_left'].' '.$Pprice.' '.$this->currencies[$this->actualCurr]['symbol_right'];
			
         if ($price == 0) {
         $Pprice = TXT_FREE;
//         $price = TXT_FREE;
         }			
			
			if ($vpeStatus == 0) {
				return $Pprice;
			} else {
				return array ('formated' => '<span class="productPrice">'.$Pprice.'</span>', 'plain' => $price);
			}
		} else {

			return round($price, (int)$this->currencies[$this->actualCurr]['decimal_places']);

		}

	}

	function FormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus = 0, $message_old_price, $message_price, $message_discount) {
		$sPrice = $pPrice - ($pPrice / 100) * $discount;
		if ($format) {
		if ($pPrice > 0)
			$price = '<span class="productOldPrice">'.$message_old_price.$this->Format($pPrice, $format).'</span><span class="productPrice">'.$message_price.$this->checkAttributes($pID).$this->Format($sPrice, $format).'</span>'.$message_discount.number_format($discount).'%';
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function FormatSpecial($pID, $sPrice, $pPrice, $format, $vpeStatus = 0, $message_old_price) {
		if ($format) {
			$price = '<span class="productOldPrice">'.$message_old_price.$this->Format($pPrice, $format).'</span><span class="productPrice">'.YOUR_SPECIAL_PRICE.$this->checkAttributes($pID).$this->Format($sPrice, $format).'</span>';
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function FormatSpecialGraduated($pID, $sPrice, $pPrice, $format, $vpeStatus = 0, $message_old_price, $message_price, $message_discount) {
		$oldsPrice=$sPrice;
		if ($pPrice == 0)
			return $this->Format($sPrice, $format, 0, false, $vpeStatus);
		if ($discount = $this->CheckDiscount($pID))
			$sPrice -= $sPrice / 100 * $discount;
		if ($format) {
			if ($sPrice != $pPrice) {
				$price = '<span class="productOldPrice">'.$message_old_price.$this->Format($pPrice, $format).'</span><span class="productPrice">'.$message_price.$this->checkAttributes($pID).$this->Format($sPrice, $format).'</spann><br />'.$message_discount.$discount;
			} else {
				$price = FROM.$this->Format($sPrice, $format);
			}
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function get_decimal_places($code) {
		return $this->currencies[$this->actualCurr]['decimal_places'];
	}
 	
 }
 
 
?>
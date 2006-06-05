<?php


/* -----------------------------------------------------------------------------------------
   $Id: xtcPrice.php 1316 2005-10-21 15:30:58Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(currencies.php,v 1.15 2003/03/17); www.oscommerce.com
   (c) 2003         nextcommerce (currencies.php,v 1.9 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class xtcPrice {
	var $currencies;

	// class constructor
	function xtcPrice($currency, $cGroup) {

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
		$currencies_query = xtDBquery($currencies_query);
		while ($currencies = xtc_db_fetch_array($currencies_query, true)) {
			$this->currencies[$currencies['code']] = array ('title' => $currencies['title'], 'symbol_left' => $currencies['symbol_left'], 'symbol_right' => $currencies['symbol_right'], 'decimal_point' => $currencies['decimal_point'], 'thousands_point' => $currencies['thousands_point'], 'decimal_places' => $currencies['decimal_places'], 'value' => $currencies['value']);
		}
		// select Customers Status data
		$customers_status_query = "SELECT *
				                                        FROM
				                                             ".TABLE_CUSTOMERS_STATUS."
				                                        WHERE
				                                             customers_status_id = '".$this->actualGroup."' AND language_id = '".$_SESSION['languages_id']."'";
		$customers_status_query = xtDBquery($customers_status_query);
		$customers_status_value = xtc_db_fetch_array($customers_status_query, true);
		$this->cStatus = array ('customers_status_id' => $this->actualGroup, 'customers_status_name' => $customers_status_value['customers_status_name'], 'customers_status_image' => $customers_status_value['customers_status_image'], 'customers_status_public' => $customers_status_value['customers_status_public'], 'customers_status_discount' => $customers_status_value['customers_status_discount'], 'customers_status_ot_discount_flag' => $customers_status_value['customers_status_ot_discount_flag'], 'customers_status_ot_discount' => $customers_status_value['customers_status_ot_discount'], 'customers_status_graduated_prices' => $customers_status_value['customers_status_graduated_prices'], 'customers_status_show_price' => $customers_status_value['customers_status_show_price'], 'customers_status_show_price_tax' => $customers_status_value['customers_status_show_price_tax'], 'customers_status_add_tax_ot' => $customers_status_value['customers_status_add_tax_ot'], 'customers_status_payment_unallowed' => $customers_status_value['customers_status_payment_unallowed'], 'customers_status_shipping_unallowed' => $customers_status_value['customers_status_shipping_unallowed'], 'customers_status_discount_attributes' => $customers_status_value['customers_status_discount_attributes'], 'customers_fsk18' => $customers_status_value['customers_fsk18'], 'customers_fsk18_display' => $customers_status_value['customers_fsk18_display']);

		// prefetch tax rates for standard zone
		$zones_query = xtDBquery("SELECT tax_class_id as class FROM ".TABLE_TAX_CLASS);
		while ($zones_data = xtc_db_fetch_array($zones_query,true)) {
			
			// calculate tax based on shipping or deliverey country (for downloads)
			if (isset($_SESSION['billto']) && isset($_SESSION['sendto'])) {
			$tax_address_query = xtc_db_query("select ab.entry_country_id, ab.entry_zone_id from " . TABLE_ADDRESS_BOOK . " ab left join " . TABLE_ZONES . " z on (ab.entry_zone_id = z.zone_id) where ab.customers_id = '" . $_SESSION['customer_id'] . "' and ab.address_book_id = '" . ($this->content_type == 'virtual' ? $_SESSION['billto'] : $_SESSION['sendto']) . "'");
      		$tax_address = xtc_db_fetch_array($tax_address_query);
			$this->TAX[$zones_data['class']]=xtc_get_tax_rate($zones_data['class'],$tax_address['entry_country_id'], $tax_address['entry_zone_id']);				
			} else {
			$this->TAX[$zones_data['class']]=xtc_get_tax_rate($zones_data['class']);		
			}
			
			
		}
				
	}

	// get products Price
	function xtcGetPrice($pID, $format = true, $qty, $tax_class, $pPrice, $vpeStatus = 0, $cedit_id = 0) {

			// check if group is allowed to see prices
	if ($this->cStatus['customers_status_show_price'] == '0')
			return $this->xtcShowNote($vpeStatus, $vpeStatus);

		// get Tax rate
		if ($cedit_id != 0) {
			$cinfo = xtc_oe_customer_infos($cedit_id);
			$products_tax = xtc_get_tax_rate($tax_class, $cinfo['country_id'], $cinfo['zone_id']);
		} else {
			$products_tax = $this->TAX[$tax_class];
		}

		if ($this->cStatus['customers_status_show_price_tax'] == '0')
			$products_tax = '';

		// add taxes
		if ($pPrice == 0)
			$pPrice = $this->getPprice($pID);
		$pPrice = $this->xtcAddTax($pPrice, $products_tax);

		// check specialprice
		if ($sPrice = $this->xtcCheckSpecial($pID))
			return $this->xtcFormatSpecial($pID, $this->xtcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus);

		// check graduated
		if ($this->cStatus['customers_status_graduated_prices'] == '1') {
			if ($sPrice = $this->xtcGetGraduatedPrice($pID, $qty))
				return $this->xtcFormatSpecialGraduated($pID, $this->xtcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, $pID);
		} else {
			// check Group Price
			if ($sPrice = $this->xtcGetGroupPrice($pID, 1))
				return $this->xtcFormatSpecialGraduated($pID, $this->xtcAddTax($sPrice, $products_tax), $pPrice, $format, $vpeStatus, $pID);
		}

		// check Product Discount
		if ($discount = $this->xtcCheckDiscount($pID))
			return $this->xtcFormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus);

		return $this->xtcFormat($pPrice, $format, 0, false, $vpeStatus, $pID);

	}

	function getPprice($pID) {
		$pQuery = "SELECT products_price FROM ".TABLE_PRODUCTS." WHERE products_id='".$pID."'";
		$pQuery = xtDBquery($pQuery);
		$pData = xtc_db_fetch_array($pQuery, true);
		return $pData['products_price'];


	}

	function xtcAddTax($price, $tax) {
		$price = $price + $price / 100 * $tax;
		$price = $this->xtcCalculateCurr($price);
		return round($price, $this->currencies[$this->actualCurr]['decimal_places']);
	}

	function xtcCheckDiscount($pID) {

		// check if group got discount
		if ($this->cStatus['customers_status_discount'] != '0.00') {

			$discount_query = "SELECT products_discount_allowed FROM ".TABLE_PRODUCTS." WHERE products_id = '".$pID."'";
			$discount_query = xtDBquery($discount_query);
			$dData = xtc_db_fetch_array($discount_query, true);

			$discount = $dData['products_discount_allowed'];
			if ($this->cStatus['customers_status_discount'] < $discount)
				$discount = $this->cStatus['customers_status_discount'];
			if ($discount == '0.00')
				return false;
			return $discount;

		}
		return false;
	}

	function xtcGetGraduatedPrice($pID, $qty) {
		if (GRADUATED_ASSIGN == 'true')
			if (xtc_get_qty($pID) > $qty)
				$qty = xtc_get_qty($pID);
		//if (!is_int($this->cStatus['customers_status_id']) && $this->cStatus['customers_status_id']!=0) $this->cStatus['customers_status_id'] = DEFAULT_CUSTOMERS_STATUS_ID_GUEST;
		$graduated_price_query = "SELECT max(quantity) as qty
				                                FROM ".TABLE_PERSONAL_OFFERS_BY.$this->actualGroup."
				                                WHERE products_id='".$pID."'
				                                AND quantity<='".$qty."'";
		$graduated_price_query = xtDBquery($graduated_price_query);
		$graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);
		if ($graduated_price_data['qty']) {
			$graduated_price_query = "SELECT personal_offer
						                                FROM ".TABLE_PERSONAL_OFFERS_BY.$this->actualGroup."
						                                WHERE products_id='".$pID."'
						                                AND quantity='".$graduated_price_data['qty']."'";
			$graduated_price_query = xtDBquery($graduated_price_query);
			$graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);

			$sPrice = $graduated_price_data['personal_offer'];
			if ($sPrice != 0.00)
				return $sPrice;
		} else {
			return;
		}

	}

	function xtcGetGroupPrice($pID, $qty) {

		$graduated_price_query = "SELECT max(quantity) as qty
				                                FROM ".TABLE_PERSONAL_OFFERS_BY.$this->actualGroup."
				                                WHERE products_id='".$pID."'
				                                AND quantity<='".$qty."'";
		$graduated_price_query = xtDBquery($graduated_price_query);
		$graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);
		if ($graduated_price_data['qty']) {
			$graduated_price_query = "SELECT personal_offer
						                                FROM ".TABLE_PERSONAL_OFFERS_BY.$this->actualGroup."
						                                WHERE products_id='".$pID."'
						                                AND quantity='".$graduated_price_data['qty']."'";
			$graduated_price_query = xtDBquery($graduated_price_query);
			$graduated_price_data = xtc_db_fetch_array($graduated_price_query, true);

			$sPrice = $graduated_price_data['personal_offer'];
			if ($sPrice != 0.00)
				return $sPrice;
		} else {
			return;
		}

	}

	function xtcGetOptionPrice($pID, $option, $value) {
		$attribute_price_query = "select pd.products_discount_allowed,pd.products_tax_class_id, p.options_values_price, p.price_prefix, p.options_values_weight, p.weight_prefix from ".TABLE_PRODUCTS_ATTRIBUTES." p, ".TABLE_PRODUCTS." pd where p.products_id = '".$pID."' and p.options_id = '".$option."' and pd.products_id = p.products_id and p.options_values_id = '".$value."'";
		$attribute_price_query = xtDBquery($attribute_price_query);
		$attribute_price_data = xtc_db_fetch_array($attribute_price_query, true);
		$dicount = 0;
		if ($this->cStatus['customers_status_discount_attributes'] == 1 && $this->cStatus['customers_status_discount'] != 0.00) {
			$discount = $this->cStatus['customers_status_discount'];
			if ($attribute_price_data['products_discount_allowed'] < $this->cStatus['customers_status_discount'])
				$discount = $attribute_price_data['products_discount_allowed'];
		}
		$price = $this->xtcFormat($attribute_price_data['options_values_price'], false, $attribute_price_data['products_tax_class_id']);
		if ($attribute_price_data['weight_prefix'] != '+')
			$attribute_price_data['options_values_weight'] *= -1;
		if ($attribute_price_data['price_prefix'] == '+') {
			$price = $price - $price / 100 * $discount;
		} else {
			$price *= -1;
		}
		return array ('weight' => $attribute_price_data['options_values_weight'], 'price' => $price);
	}

	function xtcShowNote($vpeStatus, $vpeStatus = 0) {
		if ($vpeStatus == 1)
			return array ('formated' => NOT_ALLOWED_TO_SEE_PRICES, 'plain' => 0);
		return NOT_ALLOWED_TO_SEE_PRICES;
	}

	function xtcCheckSpecial($pID) {
		$product_query = "select specials_new_products_price from ".TABLE_SPECIALS." where products_id = '".$pID."' and status=1";
		$product_query = xtDBquery($product_query);
		$product = xtc_db_fetch_array($product_query, true);

		return $product['specials_new_products_price'];

	}

	function xtcCalculateCurr($price) {
		return $this->currencies[$this->actualCurr]['value'] * $price;
	}

	function calcTax($price, $tax) {
		return $price * $tax / 100;
	}

	function xtcRemoveCurr($price) {

		// check if used Curr != DEFAULT curr
		if (DEFAULT_CURRENCY != $this->actualCurr) {
			return $price * (1 / $this->currencies[$this->actualCurr]['value']);
		} else {
			return $price;
		}

	}

	function xtcRemoveTax($price, $tax) {
		$price = ($price / (($tax +100) / 100));
		return $price;
	}

	function xtcGetTax($price, $tax) {
		$tax = $price - $this->xtcRemoveTax($price, $tax);
		return $tax;
	}
	
	function xtcRemoveDC($price,$dc) {
	
		$price = $price - ($price/100*$dc);
		
		return $price;	
	}
	
	function xtcGetDC($price,$dc) {
		
		$dc = $price/100*$dc;
	
		return $dc;	
	}

	function checkAttributes($pID) {
		if (!$this->showFrom_Attributes) return;
		if ($pID == 0)
			return;
		$products_attributes_query = "select count(*) as total from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".$pID."' and patrib.options_id = popt.products_options_id and popt.language_id = '".(int) $_SESSION['languages_id']."'";
		$products_attributes = xtDBquery($products_attributes_query);
		$products_attributes = xtc_db_fetch_array($products_attributes, true);
		if ($products_attributes['total'] > 0)
			return ' '.strtolower(FROM).' ';
	}

	function xtcCalculateCurrEx($price, $curr) {
		return $price * ($this->currencies[$curr]['value'] / $this->currencies[$this->actualCurr]['value']);
	}

	/*
	*
	*    Format Functions
	*
	*
	*
	*/

	function xtcFormat($price, $format, $tax_class = 0, $curr = false, $vpeStatus = 0, $pID = 0) {

		if ($curr)
			$price = $this->xtcCalculateCurr($price);

		if ($tax_class != 0) {
			$products_tax = $this->TAX[$tax_class];
			if ($this->cStatus['customers_status_show_price_tax'] == '0')
				$products_tax = '';
			$price = $this->xtcAddTax($price, $products_tax);
		}

		if ($format) {
			$Pprice = number_format($price, $this->currencies[$this->actualCurr]['decimal_places'], $this->currencies[$this->actualCurr]['decimal_point'], $this->currencies[$this->actualCurr]['thousands_point']);
			$Pprice = $this->checkAttributes($pID).$this->currencies[$this->actualCurr]['symbol_left'].' '.$Pprice.' '.$this->currencies[$this->actualCurr]['symbol_right'];
			if ($vpeStatus == 0) {
				return $Pprice;
			} else {
				return array ('formated' => $Pprice, 'plain' => $price);
			}
		} else {

			return round($price, $this->currencies[$this->actualCurr]['decimal_places']);

		}

	}

	function xtcFormatSpecialDiscount($pID, $discount, $pPrice, $format, $vpeStatus = 0) {
		$sPrice = $pPrice - ($pPrice / 100) * $discount;
		if ($format) {
			$price = '<span class="productOldPrice">'.INSTEAD.$this->xtcFormat($pPrice, $format).'</span><br />'.ONLY.$this->checkAttributes($pID).$this->xtcFormat($sPrice, $format).'<br />'.YOU_SAVE.$discount.'%';
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function xtcFormatSpecial($pID, $sPrice, $pPrice, $format, $vpeStatus = 0) {
		if ($format) {
			$price = '<span class="productOldPrice">'.INSTEAD.$this->xtcFormat($pPrice, $format).'</span><br />'.ONLY.$this->checkAttributes($pID).$this->xtcFormat($sPrice, $format);
			if ($vpeStatus == 0) {
				return $price;
			} else {
				return array ('formated' => $price, 'plain' => $sPrice);
			}
		} else {
			return round($sPrice, $this->currencies[$this->actualCurr]['decimal_places']);
		}
	}

	function xtcFormatSpecialGraduated($pID, $sPrice, $pPrice, $format, $vpeStatus = 0, $pID) {
		if ($pPrice == 0)
			return $this->xtcFormat($sPrice, $format, 0, false, $vpeStatus);
		if ($discount = $this->xtcCheckDiscount($pID))
			$sPrice -= $sPrice / 100 * $discount;
		if ($format) {
			if ($sPrice != $pPrice) {
				$price = '<span class="productOldPrice">'.MSRP.$this->xtcFormat($pPrice, $format).'</span><br />'.YOUR_PRICE.$this->checkAttributes($pID).$this->xtcFormat($sPrice, $format);
			} else {
				$price = FROM.$this->xtcFormat($sPrice, $format);
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
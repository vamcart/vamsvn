<?php
/* -----------------------------------------------------------------------------------------
   $Id: ship2pay.php.php 1136 2007-02-06 20:23:03 VaM $ 

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(payment.php,v 1.36 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (payment.php,v 1.11 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (payment.php,v 1.11 2003/08/17); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Ship2Pay
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) 2003 Edwin Bekaert (edwin@ednique.com)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

////// Function to handle links between shipping and payment

function ship2pay() {
	global $order;
	$shipping = $_SESSION['shipping'];
	$shipping_module = substr($shipping['id'], 0, strpos($shipping['id'], '_')) . '.php';
	$q_ship2pay = vamDBquery("SELECT payments_allowed, zones_id FROM " . TABLE_SHIP2PAY . " where shipment = '" . $shipping_module . "' and status=1");
	$check_flag = false;
	while($mods = vam_db_fetch_array($q_ship2pay,true)) {
		if($mods['zones_id'] > 0) {
			$check_query = vamDBquery("select zone_id from " . TABLE_ZONES_TO_GEO_ZONES . " where geo_zone_id = '" . $mods['zones_id'] . "' and zone_country_id = '" . $order->delivery['country']['id'] . "' order by zone_id");
			while ($check = vam_db_fetch_array($check_query,true)) {
				if ($check['zone_id'] < 1) {
					$check_flag = true;
					break 2;
				} elseif ($check['zone_id'] == $order->delivery['zone_id']) {
					$check_flag = true;
					break 2;
				}
			}
		} else {
			$check_flag = true;
			break;
		}
	}
	if($check_flag)
		$modules = $mods['payments_allowed'];
	else
		$modules = MODULE_PAYMENT_INSTALLED;
	$modules = explode(';', $modules);
	return($modules);
}
?>
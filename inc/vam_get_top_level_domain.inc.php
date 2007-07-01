<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_top_level_domain.inc.php 1535 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_get_top_level_domain.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_top_level_domain.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
function vam_get_top_level_domain($url) {
	if (strpos($url, '://')) {
		$url = parse_url($url);
		$url = $url['host'];
	}
	$domain_array = explode('.', $url);
	$domain_size = sizeof($domain_array);
	if ($domain_size > 1) {
		if (is_numeric($domain_array[$domain_size -2]) && is_numeric($domain_array[$domain_size -1])) {
			return false;
		} else {
			for ($domain_part = 1; $domain_part < $domain_size; $domain_part++) {
				$domain_path .= $domain_array[$domain_part];
				if ($domain_part != ($domain_size -1))
					$domain_path .= '.';
			}
			return $domain_path;
		}
	} else {
		return false;
	}
}
?>
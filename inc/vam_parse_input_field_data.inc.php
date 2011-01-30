<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_parse_input_field_data.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_parse_input_field_data.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_parse_input_field_data.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// Parse the data used in the html tags to ensure the tags will not break
  function vam_parse_input_field_data($data, $parse) {
    return strtr(trim((string)$data), $parse);
  }
 ?>
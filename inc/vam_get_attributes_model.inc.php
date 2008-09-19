<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_attributes_model.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (vam_get_attributes_model.inc.php,v 1.1 2003/08/19); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_attributes_model.inc.php,v 1.1 2004/08/25); xt-commerce.com
   
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
function vam_get_attributes_model($product_id, $attribute_name,$options_name,$language='')
    {
    	if ($language=='') $language=$_SESSION['languages_id'];
    $options_value_id_query=vam_db_query("SELECT
pa.attributes_model
FROM
".TABLE_PRODUCTS_ATTRIBUTES." pa
Inner Join ".TABLE_PRODUCTS_OPTIONS." po ON po.products_options_id = pa.options_id
Inner Join ".TABLE_PRODUCTS_OPTIONS_VALUES." pov ON pa.options_values_id = pov.products_options_values_id
WHERE
po.language_id = '".$language."' AND
po.products_options_name = '".$options_name."' AND
pov.language_id = '".$language."' AND
pa.products_id = '".$product_id."' AND 
pov.products_options_values_name = '".$attribute_name."'");


    $options_attr_data = vam_db_fetch_array($options_value_id_query);
    return $options_attr_data['attributes_model'];	
    	
    }
?>
<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_products.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_address_format.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_products.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require(DIR_FS_CATALOG.'includes/classes/vam_price.php');   

function unserialize_session_data( $session_data ) {
   $variables = array();
   $a = preg_split( "/(\w+)\|/", $session_data, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE );
   for( $i = 0; $i < count( $a ); $i = $i+2 ) {
       $variables[$a[$i]] = unserialize( $a[$i+1] );
   }
   return( $variables );
}

function vam_get_products($session) {
      if (!is_array($session)) return false;

      $products_array = array();
      reset($session);

  if (is_array($session['cart']->contents)) {     
			      
      while (list($products_id, ) = each($session['cart']->contents)) {
        $products_query = vam_db_query("select p.products_id, pd.products_name,p.products_image, p.products_model, p.products_price, p.products_discount_allowed, p.products_weight, p.products_tax_class_id from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_id='" . vam_get_prid($products_id) . "' and pd.products_id = p.products_id and pd.language_id = '" . $_SESSION['languages_id'] . "'");
        if ($products = vam_db_fetch_array($products_query)) {
          $prid = $products['products_id'];


          // dirty workaround
          $vamPrice = new vamPrice($session['currency'],$session['customers_status']['customers_status_id'], $_SESSION['customer_id'] ? $_SESSION['customer_id'] : "");
          $products_price=$vamPrice->GetPrice($products['products_id'],
                                        $format=false,
                                        $session['cart']->contents[$products_id]['qty'],
                                        $products['products_tax_class_id'],
                                        $products['products_price']);


          $products_array[] = array('id' => $products_id,
                                    'name' => $products['products_name'],
                                    'model' => $products['products_model'],
                                    'image' => $products['products_image'],
                                    'price' => $products_price+attributes_price($products_id,$session),
                                    'quantity' => $session['cart']->contents[$products_id]['qty'],
                                    'weight' => $products['products_weight'],
                                    'final_price' => ($products_price+attributes_price($products_id,$session)),
                                    'tax_class_id' => $products['products_tax_class_id'],
                                    'attributes' => $session['contents'][$products_id]['attributes']);
        }
      }

      return $products_array;
		}
		return false;      
    }
    
function attributes_price($products_id,$session) {
      $vamPrice = new vamPrice($session['currency'],$session['customers_status']['customers_status_id'],$_SESSION['customer_id'] ? $_SESSION['customer_id'] : "");
      if (isset($session['contents'][$products_id]['attributes'])) {
        reset($session['contents'][$products_id]['attributes']);
        while (list($option, $value) = each($session['contents'][$products_id]['attributes'])) {
          $attribute_price_query = vam_db_query("select pd.products_tax_class_id, p.options_values_price, p.price_prefix from " . TABLE_PRODUCTS_ATTRIBUTES . " p, " . TABLE_PRODUCTS . " pd where p.products_id = '" . $products_id . "' and p.options_id = '" . $option . "' and pd.products_id = p.products_id and p.options_values_id = '" . $value . "'");
          $attribute_price = vam_db_fetch_array($attribute_price_query);
          if ($attribute_price['price_prefix'] == '+') {
            $attributes_price += $vamPrice->Format($attribute_price['options_values_price'],false,$attribute_price['products_tax_class_id']);
          } else {
            $attributes_price -= $vamPrice->Format($attribute_price['options_values_price'],false,$attribute_price['products_tax_class_id']);
          }
        }
      }
      return $attributes_price;
    }    

    
    
?>    
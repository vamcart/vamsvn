<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_draw_textarea_field.inc.php 1300 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_draw_textarea_field.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_draw_textarea_field.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// Output a form textarea field
  function vam_draw_textarea_field($name, $wrap, $width, $height, $text = '', $parameters = '', $reinsert_value = true) {
    $field = '<textarea name="' . vam_parse_input_field_data($name, array('"' => '&quot;')) . '" id="' . vam_parse_input_field_data($name, array('"' => '&quot;')) . '" cols="' . vam_parse_input_field_data($width, array('"' => '&quot;')) . '" rows="' . vam_parse_input_field_data($height, array('"' => '&quot;')) . '"';

    // Bootstrap form-control
    if (!vam_not_null($parameters)) $field .= ' class="form-control"';

    if (vam_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>';

    if ( (isset($GLOBALS[$name])) && ($reinsert_value == true) ) {
      $field .= $GLOBALS[$name];
    } elseif (vam_not_null($text)) {
      $field .= $text;
    }

    $field .= '</textarea>';

    return $field;
  }
 ?>
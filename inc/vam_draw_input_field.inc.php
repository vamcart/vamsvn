<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_draw_input_field.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com
   (c) 2003	 nextcommerce (vam_draw_input_field.inc.php,v 1.3 2003/08/13); www.nextcommerce.org 
   (c) 2004 xt:Commerce (vam_draw_input_field.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// Output a form input field
  function vam_draw_input_field($name, $value = '', $parameters = '', $type = 'text', $reinsert_value = true) {
    $field = '<input type="' . vam_parse_input_field_data($type, array('"' => '&quot;')) . '" name="' . vam_parse_input_field_data($name, array('"' => '&quot;')) . '"';

    if ( (isset($GLOBALS[$name])) && ($reinsert_value == true) ) {
      $field .= ' value="' . vam_parse_input_field_data($GLOBALS[$name], array('"' => '&quot;')) . '"';
    } elseif (vam_not_null($value)) {
      $field .= ' value="' . vam_parse_input_field_data($value, array('"' => '&quot;')) . '"';
    }

    // Bootstrap form-control
    if (!vam_not_null($parameters)) $field .= ' class="form-control"';

    if (vam_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= ' />';

    return $field;
  }
  
    function vam_draw_input_fieldNote($data, $value = '', $parameters = '', $type = 'text', $reinsert_value = true) {
    $field = '<input type="' . vam_parse_input_field_data($type, array('"' => '&quot;')) . '" name="' . vam_parse_input_field_data($data['name'], array('"' => '&quot;')) . '"';

    if ( (isset($GLOBALS[$data['name']])) && ($reinsert_value == true) ) {
      $field .= ' value="' . vam_parse_input_field_data($GLOBALS[$data['name']], array('"' => '&quot;')) . '"';
    } elseif (vam_not_null($value)) {
      $field .= ' value="' . vam_parse_input_field_data($value, array('"' => '&quot;')) . '"';
    }

    // Bootstrap form-control
    if (!vam_not_null($parameters)) $field .= ' class="form-control"';

    if (vam_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= ' />'.$data['text'];

    return $field;
  }
 ?>
<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_draw_selection_field.inc.php 812 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_draw_selection_field.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_draw_selection_field.inc.php,v 1.3 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
  
// Output a selection field - alias function for vam_draw_checkbox_field() and vam_draw_radio_field()

  function vam_draw_selection_field($name, $type, $value = '', $checked = false, $parameters = '') {
    $selection = '<input type="' . vam_parse_input_field_data($type, array('"' => '&quot;')) . '" name="' . vam_parse_input_field_data($name, array('"' => '&quot;')) . '"';

    if (vam_not_null($value)) $selection .= ' value="' . vam_parse_input_field_data($value, array('"' => '&quot;')) . '"';

    if ( ($checked == true) || ($GLOBALS[$name] == 'on') || ( (isset($value)) && ($GLOBALS[$name] == $value) ) ) {
      $selection .= ' checked="checked"';
    }

    // Bootstrap form-control
    if (!vam_not_null($parameters)) $selection .= ' class="form-check-input"';

    if (vam_not_null($parameters)) $selection .= ' ' . $parameters;

    $selection .= ' />';

    return $selection;
  }
  
    function vam_draw_selection_fieldNote($data, $type, $value = '', $checked = false, $parameters = '') {
    $selection = $data['suffix'].'<input type="' . vam_parse_input_field_data($type, array('"' => '&quot;')) . '" name="' . vam_parse_input_field_data($data['name'], array('"' => '&quot;')) . '"';

    if (vam_not_null($value)) $selection .= ' value="' . vam_parse_input_field_data($value, array('"' => '&quot;')) . '"';

    if ( ($checked == true) || ($GLOBALS[$data['name']] == 'on') || ( (isset($value)) && ($GLOBALS[$data['name']] == $value) ) ) {
      $selection .= ' checked="checked"';
    }

    // Bootstrap form-control
    if (!vam_not_null($parameters)) $selection .= ' class="form-check-input"';

    if (vam_not_null($parameters)) $selection .= ' ' . $parameters;

    $selection .= ' />'.$data['text'];

    return $selection;
  }
 ?>
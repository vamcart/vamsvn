<?php
// Output a form pull down menu
  function vam_special_categories_menu($name, $values, $default = '', $parameters = '', $required = false) {
    $field = '<ul>';
    //$field = '<select name="' . vam_parse_input_field_data($name, array('"' => '&quot;')) . '"';

    //if (vam_not_null($parameters)) $field .= ' ' . $parameters;

    //$field .= '>';

    if (empty($default) && isset($GLOBALS[$name])) $default = $GLOBALS[$name];

// Start Products Specifications
    foreach ($values as $link_data) {
      switch (true) {
        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'none'):
          break;
        
        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'grey'):
          $field .= '<optgroup class="no_results" label="';
          $field .= vam_output_string ($link_data['text'] );
          if (SPECIFICATIONS_FILTER_SHOW_COUNT == 'True' && $link_data['count'] != '') {
            $field .= ' (' . $link_data['count'] . ')';
          }
          $field .= '"></optgroup>';
          break;
        
        default:
          $field .= '<li><a href="specials.php?categories_id=' . vam_output_string ($link_data['id']) . '"';
          if (in_array ($link_data['id'], (array) $default) ) {
            $field .= ' class="current"';
          }

          $field .= '>' . vam_output_string ($link_data['text'], array (
            '"' => '&quot;',
            '\'' => '&#039;',
            '<' => '&lt;',
            '>' => '&gt;'
          ));
            
          //if (SPECIFICATIONS_FILTER_SHOW_COUNT == 'True' && $link_data['count'] != '') {
            //$field .= ' (' . $link_data['count'] . ')';
          //}
          $field .= '</a></li>';
          break;
      } // switch (true)
    } // foreach ($values
// End Products Specifications

    //$field .= '</select>';
    $field .= '</ul>';

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
  }
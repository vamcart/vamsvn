<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_image_submit.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_image_submit.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_image_submit.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
// The HTML form submit button wrapper function
// Outputs a button in the selected language
  function vam_image_submit($image, $alt = '', $parameters = '') {

    $image_submit = '<input type="image" src="' . vam_parse_input_field_data('templates/'.CURRENT_TEMPLATE.'/buttons/' . $_SESSION['language'] . '/'. $image, array('"' => '&quot;')) . '" alt="' . vam_parse_input_field_data($alt, array('"' => '&quot;')) . '"';

    if (vam_not_null($alt)) $image_submit .= ' title=" ' . vam_parse_input_field_data($alt, array('"' => '&quot;')) . ' "';

    if (vam_not_null($parameters)) $image_submit .= ' ' . $parameters;

    $image_submit .= ' />';

    return $image_submit;
  }
 ?>
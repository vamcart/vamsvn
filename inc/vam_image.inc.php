<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_image.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_image.inc.php,v 1.5 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_image.inc.php,v 1.5 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
 // include needed functions
 require_once(DIR_FS_INC . 'vam_parse_input_field_data.inc.php');
 require_once(DIR_FS_INC . 'vam_not_null.inc.php');
// The HTML image wrapper function
  function vam_image($src, $alt = '', $width = '', $height = '', $parameters = '') {
    if ( (empty($src) || ($src == DIR_WS_IMAGES) || ( $src == DIR_WS_THUMBNAIL_IMAGES))) {
      return false;
    }

// alt is added to the img tag even if it is null to prevent browsers from outputting
// the image filename as default
    $image = '<img class="img-fluid" src="' . vam_parse_input_field_data($src, array('"' => '&quot;')) . '" alt="' . vam_parse_input_field_data($alt, array('"' => '&quot;')) . '"';

    if (vam_not_null($alt)) {
      $image .= ' title=" ' . vam_parse_input_field_data($alt, array('"' => '&quot;')) . ' "';
    }

    if ( (CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height)) ) {
      if ($image_size = @getimagesize($src)) {
        if (empty($width) && vam_not_null($height)) {
          $ratio = $height / $image_size[1];
          $width = $image_size[0] * $ratio;
        } elseif (vam_not_null($width) && empty($height)) {
          $ratio = $width / $image_size[0];
          $height = $image_size[1] * $ratio;
        } elseif (empty($width) && empty($height)) {
          $width = $image_size[0];
          $height = $image_size[1];
        }
      } elseif (IMAGE_REQUIRED == 'false') {
        return false;
      }
    }

    if (vam_not_null($width) && vam_not_null($height)) {
      $image .= ' width="' . vam_parse_input_field_data($width, array('"' => '&quot;')) . '" height="' . vam_parse_input_field_data($height, array('"' => '&quot;')) . '"';
    }

    if (vam_not_null($parameters)) $image .= ' ' . $parameters;

    $image .= ' />';
    return $image;
  }
 ?>
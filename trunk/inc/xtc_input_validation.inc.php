<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_input_validation.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (vam_input_validation.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_input_validation.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


   function vam_input_validation($var,$type,$replace_char) {

      switch($type) {
                case 'cPath':
                        $replace_param='/[^0-9_]/';
                        break;
                case 'int':
                        $replace_param='/[^0-9]/';
                        break;
                case 'char':
                        $replace_param='/[^a-zA-Z]/';
                        break;

      }

    $val=preg_replace($replace_param,$replace_char,$var);

    return $val;
   }



?>
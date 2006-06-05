<?php
/* -----------------------------------------------------------------------------------------
   $Id: xtc_input_validation.inc.php 899 2005-04-29 02:40:57Z hhgag $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


   function xtc_input_validation($var,$type,$replace_char) {

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
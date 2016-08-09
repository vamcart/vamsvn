<?php
/* -----------------------------------------------------------------------------------------
   $Id: outputfilter.template_translate.php 899 2007-10-18 20:14:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 pvginkel (prefilter.template_translate.php,v 1.1 2003/03/17); 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
 function smarty_outputfilter_template_translate($source, &$smarty) { 

  return preg_replace_callback('/\[\[(?:([\w-_]+)\!)?(.*?)\]\]/',
    'translate_template_item', $source);
}

function translate_template_item($matches) {
    return t($matches[2]);
}

?>
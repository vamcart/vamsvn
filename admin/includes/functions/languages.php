<?php
/* --------------------------------------------------------------
   $Id: languages.php 950 2007-02-08 12:28:21 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(languages.php,v 1.5 2002/11/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (languages.php,v 1.6 2003/08/18); www.nextcommerce.org
   (c) 2004 xt:Commerce (languages.php,v 1.6 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );
  function vam_get_languages_directory($code) {
    $language_query = vam_db_query("select languages_id, directory from " . TABLE_LANGUAGES . " where code = '" . $code . "'");
    if (vam_db_num_rows($language_query)) {
      $lang = vam_db_fetch_array($language_query);
      $_SESSION['languages_id'] = $lang['languages_id'];
      return $lang['directory'];
    } else {
      return false;
    }
  }
?>
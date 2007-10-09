<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_expire_banners.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner.php,v 1.10 2003/02/11); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_expire_banners.inc.php,v 1.5 2003/08/1); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_expire_banners.inc.php,v 1.5 2004/08/25); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require_once(DIR_FS_INC . 'vam_set_banner_status.inc.php');
   
// Auto expire banners
  function vam_expire_banners() {
    $banners_query = vam_db_query("select b.banners_id, b.expires_date, b.expires_impressions, sum(bh.banners_shown) as banners_shown from " . TABLE_BANNERS . " b, " . TABLE_BANNERS_HISTORY . " bh where b.status = '1' and b.banners_id = bh.banners_id group by b.banners_id");
    if (vam_db_num_rows($banners_query)) {
      while ($banners = vam_db_fetch_array($banners_query)) {
        if (vam_not_null($banners['expires_date'])) {
          if (date('Y-m-d H:i:s') >= $banners['expires_date']) {
            vam_set_banner_status($banners['banners_id'], '0');
          }
        } elseif (vam_not_null($banners['expires_impressions'])) {
          if ($banners['banners_shown'] >= $banners['expires_impressions']) {
            vam_set_banner_status($banners['banners_id'], '0');
          }
        }
      }
    }
  }
 ?>

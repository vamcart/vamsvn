<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_get_vpe_name.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (vam_get_vpe_name.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_get_vpe_name.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
   
   function vam_get_label_name($label_id) {
   	
   	if ($label_id > 0) {
   	  $vpe_query="SELECT alias, name, html FROM " . TABLE_PRODUCT_LABELS . " WHERE active='1' and id='".$label_id."'";
   	  $vpe_query = vamDBquery($vpe_query);
   	  $vpe = vam_db_fetch_array($vpe_query,true);
   	  $vpe['name'] = '<span class="label '.$vpe['alias'].'">'.$vpe['name'].'</span>';
   	  if ($vpe['html']) $vpe['name'] = '<span class="label html">'.$vpe['html'].'</span>';
   	  return $vpe['name'];
   	}
   	
   }
   
    
?>

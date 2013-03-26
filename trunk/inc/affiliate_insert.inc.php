<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_insert.inc.php,v 1.2 2005/05/25 18:20:23 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_functions.php, v 1.15 2003/09/17);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

function affiliate_insert ($sql_data_array, $affiliate_parent = 0) {
    // LOCK TABLES
    @vam_db_query("LOCK TABLES " . TABLE_AFFILIATE . " WRITE");
    if ($affiliate_parent > 0) {
    	$affiliate_root_query = vam_db_query("select affiliate_root, affiliate_rgt, affiliate_lft from  " . TABLE_AFFILIATE . " where affiliate_id = '" . $affiliate_parent . "' ");
    	// Check if we have a parent affiliate
    	if ($affiliate_root_array = vam_db_fetch_array($affiliate_root_query)) {
    		vam_db_query("update " . TABLE_AFFILIATE . " SET affiliate_lft = affiliate_lft + 2 WHERE affiliate_root  =  '" . $affiliate_root_array['affiliate_root'] . "' and  affiliate_lft > "  . $affiliate_root_array['affiliate_rgt'] . "  AND affiliate_rgt >= " . $affiliate_root_array['affiliate_rgt'] . " ");
        	vam_db_query("update " . TABLE_AFFILIATE . " SET affiliate_rgt = affiliate_rgt + 2 WHERE affiliate_root  =  '" . $affiliate_root_array['affiliate_root'] . "' and  affiliate_rgt >= "  . $affiliate_root_array['affiliate_rgt'] . "  ");
            $sql_data_array['affiliate_root'] = $affiliate_root_array['affiliate_root'];
            $sql_data_array['affiliate_lft'] = $affiliate_root_array['affiliate_rgt'];
            $sql_data_array['affiliate_rgt'] = ($affiliate_root_array['affiliate_rgt'] + 1);
            vam_db_perform(TABLE_AFFILIATE, $sql_data_array);
            $affiliate_id = vam_db_insert_id();
        }
        // no parent -> new root
    }
	else {
		$sql_data_array['affiliate_lft'] = '1';
		$sql_data_array['affiliate_rgt'] = '2';
		vam_db_perform(TABLE_AFFILIATE, $sql_data_array);
		$affiliate_id = vam_db_insert_id();
		vam_db_query ("update " . TABLE_AFFILIATE . " set affiliate_root = '" . $affiliate_id . "' where affiliate_id = '" . $affiliate_id . "' ");
    }
    // UNLOCK TABLES
    @vam_db_query("UNLOCK TABLES");
    return $affiliate_id;
}
?>

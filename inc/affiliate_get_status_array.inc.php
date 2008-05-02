<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_get_status_array.inc.php,v 1.1 2003/12/21 20:13:07 hubi74 Exp $

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

/**
 * affiliate_get_status_array()
 *
 * @return  array of available order status in current language
 **/
function affiliate_get_status_array() {

    $status_array = array();
    $status_sql = "select orders_status_id, orders_status_name"
                            . " FROM " . TABLE_ORDERS_STATUS
                            . " WHERE language_id = " . $_SESSION['languages_id']
                            . " ORDER BY orders_status_id" ;
    $status = vam_db_query( $status_sql );
    while ( $status_values = vam_db_fetch_array( $status ) ) {
    	$status_array[] = array('orders_status_id' => $status_values['orders_status_id'],
                                'orders_status_name' => $status_values['orders_status_name']);
    }
    return $status_array;
}
?>

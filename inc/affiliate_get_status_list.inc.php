<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_get_status_list.inc.php,v 1.1 2003/12/21 20:13:07 hubi74 Exp $

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
 * affiliate_get_status_list()
 *
 * @param $name
 * @param string $selected
 * @param string $parameters
 * @param bool $show_all - show "All Status" or not
 * @return  Dropdown listbox with order status
 **/
function affiliate_get_status_list($name, $selected = '', $parameters = '', $show_all = true) {
    if ( $show_all == true ) {
    	$status_array = array(array('id' => '', 'text' => TEXT_AFFILIATE_ALL_STATUS ) );
    }
	else {
		$status_array = array(array('id' => '', 'text' => PULL_DOWN_DEFAULT) );
    }

    $status = affiliate_get_status_array();
    for ($i=0, $n=sizeof( $status ); $i<$n; $i++) {
    	$status_array[] = array('id' => $status[$i]['orders_status_id'], 'text' => $status[$i]['orders_status_name']);
    }

    return vam_draw_pull_down_menu($name, $status_array, $selected, $parameters);
}
?>

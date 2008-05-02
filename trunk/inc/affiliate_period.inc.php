<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_period.inc.php,v 1.2 2005/05/25 18:20:23 hubi74 Exp $

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
   
   require_once(DIR_FS_INC . 'vam_draw_pull_down_menu.inc.php');
   

/**
 * affiliate_period()
 *
 * @param $start_year
 * @param $start_month
 * @param boolean $return_dropdown
 * @param string $selected_period
 * @return
 **/
function affiliate_period( $name, $start_year, $start_month, $return_dropdown = TRUE, $selected_period = '', $parameters ) {
    $return_array = array(array('id' => '', 'text' => TEXT_AFFILIATE_ALL_PERIODS ) );
    for($period_year = $start_year; $period_year <= date("Y"); $period_year++ ) {
    	for($period_month = 1; $period_month <= 12; $period_month++ ) {
    		if ($period_year == $start_year && $period_month < $start_month) continue;
    		if ($period_year ==  date("Y") && $period_month > date("m")) continue;
    		$return_array[] = array( 'id' => $period_year . '-' . $period_month, 'text' => $period_year . '-' . $period_month) ;
    	}
    }

    if ( $return_dropdown ) {
    	return vam_draw_pull_down_menu($name, $return_array, $selected_period, $parameters);
    }
}
?>

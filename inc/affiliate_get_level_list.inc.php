<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_get_level_list.inc.php,v 1.1 2003/12/21 20:13:07 hubi74 Exp $

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
 * affiliate_get_level_list()
 *
 * @param $name
 * @param string $selected
 * @param string $parameters
 * @return Dropdown Listbox.  Note personal level value is  AFFILIATE_TIER_LEVELS + 1
 **/
function affiliate_get_level_list($name, $selected = '', $parameters = '' ) {
    $status_array = array(array('id' => '', 'text' => TEXT_AFFILIATE_ALL_LEVELS ) );
    $status_array[] = array('id' => '0'  , 'text' => TEXT_AFFILIATE_PERSONAL_LEVEL );

    for ( $i = 1 ; $i <= AFFILIATE_TIER_LEVELS; $i++ ) {
    	$status_array[] = array('id' => $i, 'text' => TEXT_AFFILIATE_LEVEL_SUFFIX . $i );
    }

    return vam_draw_pull_down_menu($name, $status_array, $selected, $parameters);
}
?>

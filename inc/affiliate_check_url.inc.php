<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_check_url.inc.php,v 1.1 2003/12/21 20:13:07 hubi74 Exp $

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

function affiliate_check_url($url) {
    return preg_match('@^https?://[a-z0-9]([-_.]?[a-z0-9])+[.][a-z0-9][a-z0-9/=?.&\~_-]+$@i',$url);
}
?>

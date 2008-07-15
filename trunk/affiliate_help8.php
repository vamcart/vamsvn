<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_help8.php,v 1.1 2003/12/21 20:13:07 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_help8.php, v 1.4 2003/02/17);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

require('includes/application_top.php');

// create smarty elements
$vamTemplate = new vamTemplate;

$vamTemplate->assign(array(
			'HTML_PARAMS' => HTML_PARAMS,
			'HREF' => (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG,
			'TITLE' => TITLE));

$vamTemplate->assign('help_file', 'help8');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;

$vamTemplate->display(CURRENT_TEMPLATE . '/module/affiliate_help.html');?>

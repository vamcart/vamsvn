<?php
/* -----------------------------------------------------------------------------------------
   $Id: down_for_maintenance.php 1124 2008-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce (account.php,v 1.59 2003/05/19); www.oscommerce.com
   (c) 2003      nextcommerce (account.php,v 1.12 2003/08/17); www.nextcommerce.org
   (c) 2004      xt:Commerce (account.php,v 1.12 2003/08/17); xt:Commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
   
include ('includes/application_top.php');

// create smarty elements
$vamTemplate = new vamTemplate;

require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/down_for_maintenance.html');
$vamTemplate->assign('main_content', $main_content);
if (!defined(RM))
$vamTemplate->loadFilter('output', 'note');
$vamTemplate->display(CURRENT_TEMPLATE.'/module/down_for_maintenance.html');

?>
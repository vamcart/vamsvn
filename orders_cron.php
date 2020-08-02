<?php
/* --------------------------------------------------------------
   $Id: orders.php 1189 2011-04-24 11:13:01Z VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders.php,v 1.109 2003/05/28); www.oscommerce.com
   (c) 2003	 nextcommerce (orders.php,v 1.19 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (orders.php,v 1.19 2003/08/24); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contribution:
   OSC German Banktransfer v0.85a       	Autor:	Dominik Guder <osc@guder.org>
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   credit card encryption functions for the catalog module
   BMC 2003 for the CC CVV Module

   Released under the GNU General Public License
   --------------------------------------------------------------*/
set_time_limit(0);
require_once('includes/application_top.php');
require_once(DIR_FS_CATALOG.'includes/external/phpmailer/class.phpmailer.php');
require_once(DIR_FS_INC.'vam_php_mail.inc.php');
require_once(DIR_FS_INC.'vam_add_tax.inc.php');
require_once(DIR_FS_INC.'vam_validate_vatid_status.inc.php');
require_once(DIR_FS_INC.'vam_get_attributes_model.inc.php');
require_once(DIR_WS_CLASSES . 'order.php');

// initiate template engine for mail
$vamTemplate = new vamTemplate;

     
        $configuration_query = vam_db_query("select configuration_key,configuration_id, configuration_value, use_function,set_function from " . TABLE_CONFIGURATION . " where configuration_group_id = 1 and sort_order in (47,48,49) order by sort_order");

	$conf1=array();
  while($configuration = vam_db_fetch_array($configuration_query))
  $conf1[]=$configuration;
  
  $count_days=(int)$conf1[0]['configuration_value'];
  $have_status=(int)$conf1[1]['configuration_value'];
  $new_status=(int)$conf1[2]['configuration_value'];
 
  if ($count_days && $new_status && $have_status)
  {
  $orders_sql = vam_db_query("SELECT * FROM `orders`
WHERE (UNIX_TIMESTAMP(DATE_SUB(DATE_FORMAT( date_purchased, '%Y-%m-%d' ), INTERVAL -$count_days
DAY))<=UNIX_TIMESTAMP(DATE_FORMAT( CURDATE(), '%Y-%m-%d' ))) AND orders_status='$have_status'
ORDER BY date_purchased DESC");
 while($orders = vam_db_fetch_array($orders_sql)){
 $oID=$orders['orders_id'];
 $order_id = $oID; 
 $oStatus=$new_status;
 $notify = 'on';
 $notify_comments = 'on';

 $insert_id=$oID;

vam_db_query("update  ".TABLE_ORDERS." set orders_status='$new_status' where orders_id='$oID'");
   
   
include DIR_FS_CATALOG."send_answer_template.php";
 
 //sleep(2);
 vam_db_query("insert into ".TABLE_ORDERS_STATUS_HISTORY." (orders_id, orders_status_id, date_added, customer_notified, comments) values ('".vam_db_input($oID)."', '".vam_db_input($new_status)."', now(), '1', '".vam_db_input($notify_comments)."')");

 
 }
  }
  die();
	  
	  


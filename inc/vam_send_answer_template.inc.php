<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_send_answer_template.inc.php 899 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(general.php,v 1.225 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (vam_round.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_round.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
   
function vam_send_answer_template ( $oID = 0, $status = 0, $notify = "off", $notify_comments = "off") {
	
		$url = HTTP_SERVER.DIR_WS_CATALOG.'/send_answer_template.php?oID='.$oID.'&status='.$status.'&notify='.$notify.'&notify_comments='.$notify_comments;
		$ch = curl_init( $url );

		curl_setopt( $ch, CURLOPT_POST, 0 );
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 0 );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

		return curl_exec( $ch );
}

?>
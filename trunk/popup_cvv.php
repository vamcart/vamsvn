<?php
/*------------------------------------------------------------------------------
  $Id: popup_cvv.php 1310 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
  -----------------------------------------------------------------------------
   based on:
   (c) 2004 xt:Commerce (popup_cvv.php,v 1.1.2.5 2003/05/02); xt-commerce.com

  XTC-CC - Contribution for XT-Commerce http://www.xt-commerce.com
  modified by http://www.netz-designer.de

  Copyright (c) 2003 netz-designer

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
------------------------------------------------------------------------------*/

require ('includes/application_top.php');

require (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/payment/cc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>" /> 
<meta http-equiv="Content-Style-Type" content="text/css" />
<script type="text/javascript">
<!-- 
// prevent click click
document.oncontextmenu = function(){return false}
if(document.layers) {
window.captureEvents(Event.MOUSEDOWN);
window.onmousedown = function(e){
if(e.target==document)return false;
}
}
else {
document.onmousedown = function(){return false}
}

var i=0;
function resize() {
  if (navigator.appName == 'Netscape') i=40;
  window.resizeTo(480, 460-i);
   self.focus();
}

//-->
</script>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo 'templates/'.CURRENT_TEMPLATE.'/stylesheet.css'; ?>" />
</head>
<body onload="resize();">

<div class="page">
<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>
<div class="pagecontent">
<p>
<span class="bold"><?php echo $content_data['content_heading']; ?></span>
</p>
<p>
<?php echo HEADING_CVV; ?>
</p>
<p>
<?php echo TEXT_CVV; ?>
</p>
</div>
<b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b>
<div class="pagecontentfooter">
<a href="javascript:window.close()"><?php echo TEXT_CLOSE_WINDOW; ?></a>
</div>
</div>
</body>
</html>
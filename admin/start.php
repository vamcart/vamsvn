<?php
/* --------------------------------------------------------------
   $Id: start.php 1235 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project 
   (c) 2002-2003 osCommerce coding standards (a typical file) www.oscommerce.com
   (c) 2003      nextcommerce (start.php,1.5 2004/03/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (start.php,1.5 2004/03/17); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

require ('includes/application_top.php');

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<style type="text/css">
.h2 {
  font-family: Trebuchet MS,Palatino,Times New Roman,serif;
  font-size: 13pt;
  font-weight: bold;
}

.h3 {
  font-family: Verdana,Arial,Helvetica,sans-serif;
  font-size: 9pt;
  font-weight: bold;
}
</style> 

</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'false') { ?>
    <td width="<?php echo BOX_WIDTH; ?>" align="left" valign="top">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </td>
<?php } ?>
<!-- body_text //-->
    <td class="boxCenter" width="100%" valign="top">
    
    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td colspan="2">
        <?php include(DIR_WS_MODULES.FILENAME_SECURITY_CHECK); ?>
        </td>
        </tr>

       <tr>
      <td width="50%" valign="top">
        <table valign="top" width="100%" cellpadding="0" cellspacing="4">

<?php include(DIR_WS_MODULES . 'summary/customers.php'); ?>


        </table></td>
      <td width="50%" valign="top">
        <table valign="top" width="100%" cellpadding="0" cellspacing="4">

<?php include(DIR_WS_MODULES . 'summary/orders.php'); ?>


        </table></td>
      </tr>		 

       <tr>
      <td width="50%" valign="top">
        <table valign="top" width="100%" cellpadding="0" cellspacing="4">

<?php include(DIR_WS_MODULES . 'summary/products.php'); ?>


        </table></td>
      <td width="50%" valign="top">
        <table valign="top" width="100%" cellpadding="0" cellspacing="4">

<?php include(DIR_WS_MODULES . 'summary/news.php'); ?>


        </table></td>
      </tr>		 
  
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
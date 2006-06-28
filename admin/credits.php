<?php
/* --------------------------------------------------------------
   $Id: credits.php 1263 2005-09-30 10:14:08Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards (a typical file) www.oscommerce.com 
   (c) 2003	 nextcommerce ( start.php,v 1.6 2003/08/19); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">


</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<!-- body_text //-->
    <td class="boxCenter" width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr> 
    <td width="80" rowspan="2"><?php echo xtc_image(DIR_WS_ICONS.'heading_news.gif'); ?></td>
    <td class="pageHeading">Credits</td>
  </tr>
  <tr> 
    <td class="main" valign="top">XT Credits</td>
  </tr>
</table></td>
      </tr>
      <tr>
        <td class="main">
<font color="D68000" size="2" face="Verdana, Arial, Helvetica, sans-serif"><b><?php echo PROJECT_VERSION; ?></b></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><br />
Release
Datum: 1 Okt 2005</strong><br />
Released under the GNU General Public License<br />
<br />
 This program is distributed
in the hope that it will be useful, but <b>WITHOUT ANY WARRANTY</b>;<br />
without even the implied warranty of <b>MERCHANTABILITY</b> or <b>FITNESS FOR
A PARTICULAR PURPOSE</b>.<br />
See the GNU General Public License for more details. You should have received
a copy of the<br />
GNU General Public License along with this program; if not, write to the<br />
Free Software Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.<br />
See <a href="http://www.gnu.org/copyleft/gpl.html">http://www.gnu.org/copyleft/gpl.html</a>
for details. <br />
<br />
<b>Das XT-Commerce-Team dankt allen Programmierern und Entwicklern die Ihre Software<br />
zur Verf&uuml;gung gestellt haben. Sollten wir jemanden vergessen haben hier zu nennen,<br />
bitten wir um Entschuldigung. In diesem Fall bitten wir um einen Hinweis in unter:</b><br />
<a href="mailto://team@xtcommerce.com">team@xtcommerce.com</a><br />
<br />
<br />
<font color="D68000"><b>Programmierer
von XT-Commerce:</b></font><br />
</font>
<hr align="center" width="100%">
<table width="100%" border="0" cellpadding="0" cellspacing="4" border-color: #ff0000;" bgcolor="FDAC00">
  <tr>
    <td width="100"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Mario Zanier</b></font></td>
    <td width="80%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <a href="mailto:mzanier@xtcommerce.com">mzanier@xtcommerce.com</a></font>
      <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Donations: <a href="http://www.amazon.de/exec/obidos/registry/ACSF85VB5HIH/ref%3Dwl%5Fs%5F3/302-6541675-2166421" target="new">Amazon
      (DE)</a></font></td>
  </tr>
  <tr>

    <td width="100"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Guido Winger</b></font></td>
    <td width="80%"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <a href="mailto:gwinger@xtcommerce.com">gwinger@xtcommerce.com</a></font>
      <font size="2" face="Verdana, Arial, Helvetica, sans-serif">Donations: <a href="http://www.amazon.de/exec/obidos/wishlist/3S5KFCG2166KD/302-5779377-6867251" target="new">Amazon (DE)</a></font></td>
  </tr>
</table>
<font size="2" face="Verdana, Arial, Helvetica, sans-serif"> <br />
<br />
<font color="D68000"><b>Die
Shopsoftware basiert auf:</b></font><br />
</font>
<hr align="center" width="100%">
<font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>© 2000-2001 The Exchange Project</b></font>
<font size="2" face="Verdana, Arial, Helvetica, sans-serif">© Harald Ponce de Leon | http://www.oscommerce.com</font>
<font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br />
<b>© 2002-2003 osCommerce (Milestone2)</b></font>
<font size="2" face="Verdana, Arial, Helvetica, sans-serif">© Harald Ponce de Leon | http://www.oscommerce.com<br />
Released under the GNU General
Public License - die exakten Versionsnummern der Originalfiles entnehmen Sie den
Copyright-Headern der einzelnen Dateien<br />
<br />
<b>© neXTCommerce
(XTC 0.9 RC3 CVS)</b> © 2003 neXTCommerce | http://www.nextcommerce.org ( code-modifications &amp; redesign by Guido Winger/Mario Zanier/Andreas Oberzier)<br />
Mario Zanier <a href="mailto:mzanier@xtcommerce.com">mzanier@xtcommerce.com</a> / Guido Winger <a href="mailto:gwinger@xtcommerce.com">gwinger@xtcommerce.com</a> / Andreas Oberzier <a href="mailto:aoberzier@nextcommerce.org">aoberzier@nextcommerce.org</a><br />
Released under the GNU General Public License - die exakten Versionsnummern
der Originaldateien entnehmen Sie den Copyright-Headern der einzelnen Dateien<br />
<br />
<br />
<font color="D68000"> <b>XT-Commerce
nutzt die folgende Software</b></font><br />
</font>
<hr align="center" width="100%">

<font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Enable_Disable_Categories 1.3 </b> -Autor:
Mikel Williams | mikel@ladykatcostumes.com<br />
Released under the
GNU General Public License</font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br />
<b>New Attribute Manager v4b</b> -Autor:
Mike G | mp3man@internetwork.net | http://downloads.ephing.com<br />
Released under the
GNU General Public License <br />
<b>Customers Status v3.x </b>-© 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/<br />
CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist<br />
Released under the
GNU General Public License</font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br />
<b>agree_conditions_1.01</b> -Autor:
Thomas Pl&auml;nkers (webmaster@oscommerce.at)<br />
Released under the
GNU General Public License<br />
<b>Category Descriptions (Version: 1.5 MS2)</b> -Autor:
Brian Lowe (blowe@wpcusrgrp.org) | Editor: Lord Illicious (shaolin-venoms@illicious.net)<br />
Released under the
GNU General Public License<br />
<b>austrian_post_1.05</b> -Autor:
Copyright © 2002 - 2003 TheMedia, Dipl.-Ing Thomas Pl&auml;nkers | http://www.themedia.at
& http://www.oscommerce.at<br />
Released under the
GNU General Public License</font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br />
<b>swiss_post_1.02</b> -Autor:
Copyright © 2002 - 2003 TheMedia, Dipl.-Ing Thomas Pl&auml;nkers | http://www.themedia.at
& http://www.oscommerce.at<br />
Released under the
GNU General Public License <br />
<b>chronopost-1.0.1 </b>-Autor:
devteam@e-network.fr | www.oscommerce-fr.info</font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br />
Released under the
GNU General Public License</font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br />
<b>dhl_austria_1.02</b> -Autor:
Copyright © 2002 - 2003 TheMedia, Dipl.-Ing Thomas Pl&auml;nkers | http://www.themedia.at
& http://www.oscommerce.at<br />
Released under the
GNU General Public License</font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br />
<b>German Post (Deutsche Post WorldNet)</b> -Autor:
Copyright © 2002 - 2003 TheMedia, Dipl.-Ing Thomas Pl&auml;nkers | http://www.themedia.at
& http://www.oscommerce.at<br />
Released under the
GNU General Public License</font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br />
<b>fedex_europe_1.02</b> -Autor:
Copyright © 2002 - 2003 TheMedia, Dipl.-Ing Thomas Pl&auml;nkers | http://www.themedia.at
& http://www.oscommerce.at<br />
Released under the
GNU General Public License <br />
<b>freeamountv2-p1</b> -Autor:
dwk<br />
Released under the
GNU General Public License<br />
<b>phpMailer Library for PHP4</b> -Autor: © Brent R. Matzelle bmatzelle@yahoo.com | http://phpmailer.sourceforge.net<br />
Released under GNU
Lesser GPL library license.<br />
<b>CaRP v2.7.5 </b>-Autor: © 2002-3 Antone Roundy | http://www.mouken.com/rss/<br />
Released under the
GNU General Public License</font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br />
<font size="2" face="Verdana, Arial, Helvetica, sans-serif"><b>Smarty Templateengine</b> | version 2.6.3 | http://smarty.php.net <br />
Released under the GNU General Public License</font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br />
<br />
<b>Ps: Wir weisen darauf hin, dass wir keine Garantie auf Vollst&auml;ndigkeit dieser Liste geben.</b><br />
  </font>
</td>
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
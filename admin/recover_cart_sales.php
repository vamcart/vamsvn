<?php
/* --------------------------------------------------------------
   $Id: recover_cart_sales.php 1125 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(recover_cart_sales.php,v 1.19 2003/02/06); www.oscommerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

 require('includes/application_top.php');
 require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.phpmailer.php');
 if (EMAIL_TRANSPORT == 'smtp')
 require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.smtp.php');
 require_once (DIR_FS_INC.'vam_php_mail.inc.php');

// initiate template engine for mail
$vamTemplate = new vamTemplate;
require (DIR_WS_CLASSES.'currencies.php');
$currencies = new currencies();

$custid = $_POST['custid'];

// Delete Entry Begin
if ($_GET['action']=='delete') { 
   $reset_query_raw = "delete from " . TABLE_CUSTOMERS_BASKET . " where customers_id=$_GET[customer_id]"; 
   vam_db_query($reset_query_raw); 
   $reset_query_raw2 = "delete from " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " where customers_id=$_GET[customer_id]"; 
   vam_db_query($reset_query_raw2); 
   vam_redirect(vam_href_link(FILENAME_RECOVER_CART_SALES, 'delete=1&customer_id='. $_GET['customer_id'] . '&tdate=' . $_GET['tdate'])); 
} 
if ($_GET['delete']) { 
   $messageStack->add(MESSAGE_STACK_CUSTOMER_ID . $_GET['customer_id'] . MESSAGE_STACK_DELETE_SUCCESS, 'success'); 
} 
// Delete Entry End

/**
 * CONFIGURATION VARIABLES
 */

  // E-mail Time to Live :: Default=90
  $EMAIL_TTL = 90;

  // Default number of days to look back from today for
  // abadoned carts, today equals 0 (zero) :: Default=10
  $BASE_DAYS = 10;

  // Display item attributes. Some sites have attributes
  // for their items some do not, if you need them
  // then set this to TRUE. :: Default=FALSE
  $SHOW_ATTRIBUTES = FALSE;

  // If set to TRUE then it will use the first
  // name of the customer in the e-mail :: Defualt=TRUE
  $IS_FRIENDLY_EMAIL_HEADER = TRUE;

  // Color for the word/phrase used to notate a current customer
  // A current customer is someone who has
  // purchased items in the past :: Default=0000FF (Blue)
  $CURCUST_COLOR = "#0000FF";

  // Row highlight color for Uncontacted Customers
  // A uncontacted customer is one that you have not used
  // this tool to send an e-mail for :: Default=0000FF (Light Red)
  $UNCONTACTED_COLOR = "#80FFFF";

  // Row highlight color for a Contacted Customers
  // A contacted customer is one that you have used
  // this tool to send an e-mail for :: Default=FF9FA2 (Teal/Baby Blue)
  $CONTACTED_COLOR = "#FF9FA2";

  function seadate($day)
  {
    $rawtime = strtotime("-".$day." days");
    $ndate = date("Ymd", $rawtime);
    return $ndate;
  }

  function cart_date_short($raw_date) {
    if ( ($raw_date == '00000000') || ($raw_date == '') ) return false;

    $year = substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 4, 2);
    $day = (int)substr($raw_date, 6, 2);

    if (@date('Y', mktime(0, 0, 0, $month, $day, $year)) == $year) {
      return date(DATE_FORMAT, mktime(0, 0, 0, $month, $day, $year));
    } else {
      return preg_replace('/2037/' . '$', $year, date(DATE_FORMAT, mktime(0, 0, 0, $month, $day, 2037)));
    }

  }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
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
    <td class="boxCenter" valign="top">
    
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE_RECOVER; ?></td>
            <td class="pageHeading" align="right"><a class="button" href="<?php echo MANUAL_LINK_RCS; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td align="left" colspan="2">
<?php //We are doing an e-mail to some customers ?>
          <tr>

 <?php if (count($custid) > 0 ) {  ?>
         <table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
            <tr>
              <td class="main" align="left" colspan=8 width="100%"><?php echo HEADING_EMAIL_SENT; ?> </td>
            </tr>
            <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent" align="left" colspan="1" width="15%" nowrap><?php echo TABLE_HEADING_CUSTOMER; ?></td>
              <td class="dataTableHeadingContent" align="left" colspan="1" width="30%" nowrap>&nbsp;</td>
              <td class="dataTableHeadingContent" align="left" colspan="1" width="25%" nowrap>&nbsp;</td>
              <td class="dataTableHeadingContent" align="left" colspan="1" width="10%" nowrap>&nbsp;</td>
              <td class="dataTableHeadingContent" align="left" colspan="1" width="10%" nowrap>&nbsp;</td>
              <td class="dataTableHeadingContent" align="left" colspan="1" width="10%" nowrap>&nbsp;</td>
            </tr><tr>&nbsp;<br></tr>
            <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent" align="left"   colspan="1"  width="15%" nowrap><?php echo TABLE_HEADING_MODEL; ?></td>
              <td class="dataTableHeadingContent" align="left"   colspan="2"  width="55%" nowrap><?php echo TABLE_HEADING_DESCRIPTION; ?></td>
              <td class="dataTableHeadingContent" align="center" colspan="1"  width="10%" nowrap> <?php echo TABLE_HEADING_QUANTY; ?></td>
              <td class="dataTableHeadingContent" align="right"  colspan="1"  width="10%" nowrap><?php echo TABLE_HEADING_PRICE; ?></td>
              <td class="dataTableHeadingContent" align="right"  colspan="1"  width="10%" nowrap><?php echo TABLE_HEADING_TOTAL; ?></td>
            </tr>

<?php
    if (count($custid) > 0 ) {
      foreach ($custid as $cid) {
  $query1 = vam_db_query("select    cb.products_id pid,
                                    cb.customers_basket_quantity qty,
                                    cb.customers_basket_date_added bdate,
                                    cus.customers_firstname fname,
                                    cus.customers_lastname lname,
                                    cus.customers_email_address email
                          from      " . TABLE_CUSTOMERS_BASKET . " cb,
                                    " . TABLE_CUSTOMERS . " cus
                          where     cb.customers_id = cus.customers_id  and
                                    cus.customers_id = '".$cid."'
                          order by  cb.customers_basket_date_added desc ");



  $knt = vam_db_num_rows($query1);
  for ($i = 0; $i < $knt; $i++) {
    $inrec = vam_db_fetch_array($query1);

// set new cline and curcus
    if ($lastcid != $cid) {
      if ($lastcid != "") {
        $tcart_formated = $currencies->format($tprice);
        $cline .= "
        <tr>
          <td class='dataTableContent' align='right' colspan='6' nowrap><b>" . TABLE_CART_TOTAL . "</b>" . $tcart_formated . "</td>
        </tr>
        <tr>
        <!-- Delete Button //-->
          <td colspan='6' align='right'><a class=button href=" . vam_href_link(FILENAME_RECOVER_CART_SALES,"action=delete&customer_id=$curcus&tdate=$tdate") . "><span>" . BUTTON_DELETE . "</span></a></td>
        </tr>\n";
       echo $cline;
      }
    $cline = "<tr> <td class='dataTableContent' align='left' colspan='6' nowrap><a href='" . vam_href_link(FILENAME_CUSTOMERS, 'search=' . $inrec['lname'], 'NONSSL') . "'>" . $inrec['fname'] . " " . $inrec['lname'] . "</a>".$customer."</td></tr>";
     $tprice = 0;
     }
     $lastcid = $cid;
// get the shopping cart
    $query2 = vam_db_query("select  p.products_price price,
                                    p.products_model model,
                                    pd.products_name name
                            from    " . TABLE_PRODUCTS . " p,
                                    " . TABLE_PRODUCTS_DESCRIPTION . " pd,
                                    " . TABLE_LANGUAGES . " l
                            where   p.products_id = '" . $inrec['pid'] . "' and
                                    pd.products_id = p.products_id and
                                    pd.language_id = '" .  $_SESSION['languages_id'] . "' ");

    $inrec2 = vam_db_fetch_array($query2);

    $tprice = $tprice + ($inrec['qty'] * $inrec2['price']);

      $pprice_formated  = $currencies->format($inrec2['price']);
      $tpprice_formated = $currencies->format(($inrec['qty'] * $inrec2['price']));
      $cline .= "<tr class='dataTableRow'>
                    <td class='dataTableContent' align='left'   width='15%' nowrap>" . $inrec2['model'] . "</td>
                    <td class='dataTableContent' align='left'  colspan='2' width='55%'><a href='" . vam_href_link(FILENAME_CATEGORIES, 'action=new_product&read=only&pID=' . $inrec['pid'] . '&origin=' . FILENAME_RECOVER_CART_SALES . '?page=' . $_GET['page'], 'NONSSL') . "'>" . $inrec2['name'] . "</a></td>
                    <td class='dataTableContent' align='center' width='10%' nowrap>" . $inrec['qty'] . "</td>
                    <td class='dataTableContent' align='right'  width='10%' nowrap>" . $pprice_formated . "</td>
                    <td class='dataTableContent' align='right'  width='10%' nowrap>" . $tpprice_formated . "</td>
                 </tr>";

  $mline .= $inrec['qty']." x ".$inrec2['name']."\n";
  }

   $cline .= "</td></tr>";

// E-mail Processing - Requires EMAIL_* defines in the
// includes/languages/english/recover_cart_sales.php file

//  $cquery = vam_db_query("select * from orders where customers_id = '".$cid."'" );

//  if ($IS_FRIENDLY_EMAIL_HEADER){
//    $email = EMAIL_TEXT_SALUTATION . $inrec['fname'] . ",";
//  } else {
//    $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . vam_catalog_href_link(FILENAME_CATALOG_LOGIN, '', 'SSL') . "\n";
//  }

//  if (vam_db_num_rows($cquery) < 1) {
//    $email .= sprintf(EMAIL_TEXT_NEWCUST_INTRO, $mline);
//  } else {
//    $email .= sprintf(EMAIL_TEXT_CURCUST_INTRO, $mline);
//  }

//  $email .= sprintf(EMAIL_TEXT_COMMON_BODY, $mline) . "\n". $_POST['message'];

$custname = $inrec['fname']." ".$inrec['lname'];

				// assign language to template for caching
				$vamTemplate->assign('language', $_SESSION['language']);
				$vamTemplate->caching = false;

				$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
				$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

				$vamTemplate->assign('STORE_NAME', STORE_NAME);
				$vamTemplate->assign('NAME', $custname);
				$vamTemplate->assign('MESSAGE', $_POST['message']);
				$vamTemplate->assign('PRODUCTS', $mline);

				$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/recover_cart_mail.html');
				$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/recover_cart_mail.txt');

				vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $inrec['email'], $custname, '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', EMAIL_TEXT_SUBJECT, $html_mail, $txt_mail);

   $mline = "";
   
// vam_php_mail($custname, $inrec['email'], EMAIL_TEXT_SUBJECT, $email, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
//   $mline = "";

 vam_db_query("insert into " . TABLE_SCART . " (customers_id, dateadded ) values ('" . $cid . "', '" . seadate('0') . "')");
   echo $cline;
   $cline = "";
}
}
      $tcart_formated = $currencies->format($tprice);
      echo  "<tr> <td class='dataTableContent' align='right' colspan='8'><b>" . TABLE_CART_TOTAL . "</b>" . $tcart_formated . "</td> </tr>";
  echo "<tr><td colspan=6 align=center><a class=button href=" . vam_href_link(FILENAME_RECOVER_CART_SALES) . "><span>" . TEXT_RETURN . "</span></a></td></tr>";
} else {
//

?>
<?php //we are not doing an e-mail to some customers ?>
        <!-- REPORT TABLE BEGIN //-->
          <table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
            <tr>
              <td class="pageHeading" align="left" width="100%" colspan="8">
                <?php  $tdate = $_POST['tdate'];
                    if ($_POST['tdate'] == '') $tdate = $BASE_DAYS;?>
                <?php echo vam_draw_form('form', FILENAME_RECOVER_CART_SALES); ?>
                  <table align="right" width="100%" border="0">
                    <tr class="dataTableContent" align="right">
                      <td><?php echo DAYS_FIELD_PREFIX; ?><?php echo vam_draw_input_field('tdate', $tdate, 'size="4"'); ?><?php echo DAYS_FIELD_POSTFIX; ?><span class="button"><button type="submit" value="<?php echo DAYS_FIELD_BUTTON; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;<?php echo DAYS_FIELD_BUTTON; ?></button></span></td>
                    </tr>
                  </table>
                </form>
              </td>
            </tr>
<?php echo vam_draw_form('form', FILENAME_RECOVER_CART_SALES); ?>
            <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent" align="left" colspan="2" width="10%" nowrap><?php echo TABLE_HEADING_CONTACT; ?></td>
              <td class="dataTableHeadingContent" align="left" colspan="1" width="15%" nowrap><?php echo TABLE_HEADING_DATE; ?></td>
              <td class="dataTableHeadingContent" align="left" colspan="1" width="30%" nowrap><?php echo TABLE_HEADING_CUSTOMER; ?></td>
              <td class="dataTableHeadingContent" align="left" colspan="2" width="30%" nowrap><?php echo TABLE_HEADING_EMAIL; ?></td>
              <td class="dataTableHeadingContent" align="left" colspan="2" width="15%" nowrap><?php echo TABLE_HEADING_PHONE; ?></td>
            </tr><tr>&nbsp;<br></tr>
            <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent" align="left"   colspan="2"  width="10%" nowrap>&nbsp; </td>
              <td class="dataTableHeadingContent" align="left"   colspan="1"  width="15%" nowrap><?php echo TABLE_HEADING_MODEL; ?></td>
              <td class="dataTableHeadingContent" align="left"   colspan="2" width="55%" nowrap><?php echo TABLE_HEADING_DESCRIPTION; ?></td>
              <td class="dataTableHeadingContent" align="center" colspan="1" width="5%" nowrap> <?php echo TABLE_HEADING_QUANTY; ?></td>
              <td class="dataTableHeadingContent" align="right"  colspan="1"  width="5%" nowrap><?php echo TABLE_HEADING_PRICE; ?></td>
              <td class="dataTableHeadingContent" align="right"  colspan="1" width="10%" nowrap><?php echo TABLE_HEADING_TOTAL; ?></td>
            </tr>

<?php
 $tdate = $_POST['tdate'];
 if ($_POST['tdate'] == '') $tdate = $BASE_DAYS;
 $ndate = seadate($tdate);
 $query1 = vam_db_query("select cb.customers_id cid,
                                cb.products_id pid,
                                cb.customers_basket_quantity qty,
                                cb.customers_basket_date_added bdate,
                                cus.customers_firstname fname,
                                cus.customers_lastname lname,
                                cus.customers_telephone phone,
                                cus.customers_email_address email
                         from   " . TABLE_CUSTOMERS_BASKET . " cb,
                                " . TABLE_CUSTOMERS . " cus
                         where  cb.customers_basket_date_added >= '" . $ndate . "' and
                                cb.customers_id = cus.customers_id order by cb.customers_basket_date_added desc,
                                cb.customers_id ");
 $results = 0;
 $curcus = "";
 $tprice = 0;
 $totalAll = 0;
 $knt = vam_db_num_rows($query1);
 $first_line = true;

 for ($i = 0; $i <= $knt; $i++)
 {
  $inrec = vam_db_fetch_array($query1);

    if ($curcus != $inrec['cid'])
    {
      // output line
      $totalAll += $tprice;
      $tcart_formated = $currencies->format($tprice);
      $cline .= "       </td>
                        <tr>
                          <td class='dataTableContent' align='right' colspan='8'><b>" . TABLE_CART_TOTAL . "</b>" . $tcart_formated . "</td>
                        </tr>
                        <tr>
                        <!-- Delete Button //-->
                          <td colspan='8' align='right'><a class=button href=" . vam_href_link(FILENAME_RECOVER_CART_SALES,"action=delete&customer_id=$curcus&tdate=$tdate") . "><span>" . BUTTON_DELETE . "</span></a></td>
                        </tr>
                        <tr align='left'> 
                        <td colspan='8'><?php echo vam_draw_separator('pixel_trans.gif', '1', '40'); ?></td>
                        </tr>\n";

      if ($curcus != "")
        echo $cline;

      // set new cline and curcus
      $curcus = $inrec['cid'];
      if ($curcus != "") {
      $tprice = 0;
//
// change the color on those we have contacted
// add customer tag to customers
//
  $fcolor = $UNCONTACTED_COLOR;
  $sentdate = "";
  $customer = "";
  $donequery = vam_db_query("select * from ". TABLE_SCART ." where customers_id = '".$curcus."' ORDER BY dateadded DESC");
  $emailttl = seadate($EMAIL_TTL);
  if (vam_db_num_rows($donequery) > 0) {
    $ttl = vam_db_fetch_array($donequery);
    if ($emailttl <= $ttl['dateadded']) {
      $sentdate = $ttl['dateadded'];
      $fcolor = $CONTACTED_COLOR;
    }
  }
  $ccquery = vam_db_query("select * from " . TABLE_ORDERS . " where customers_id = '".$curcus."'" );
  if (vam_db_num_rows($ccquery) > 0) $customer = '&nbsp;[<font color="' . $CURCUST_COLOR . '">' . TEXT_CURRENT_CUSTOMER . '</font>]';

    $sentInfo = TEXT_NOT_CONTACTED;

    if ($sentdate != ''){
      $sentInfo = cart_date_short($sentdate);
    }

      $cline = "
        <tr bgcolor=" . $fcolor . ">
          <td class='dataTableContent' align='center' width='1%'>" . vam_draw_checkbox_field('custid[]', $curcus) . "</td>
          <td class='dataTableContent' align='left' width='9%' nowrap><b>" . $sentInfo . "</b></td>
          <td class='dataTableContent' align='left' width='15%' nowrap> " . cart_date_short($inrec['bdate']) . "</td>
          <td class='dataTableContent' align='left' width='30%' nowrap><a href='" . vam_href_link(FILENAME_CUSTOMERS, 'search=' . $inrec['lname'], 'NONSSL') . "'>" . $inrec['fname'] . " " . $inrec['lname'] . "</a>".$customer."</td>
          <td class='dataTableContent' align='left' colspan='2' width='30%' nowrap><a href='" . vam_href_link('mail.php', 'selected_box=tools&customer=' . $inrec['email']) . "'>" . $inrec['email'] . "</a></td>
          <td class='dataTableContent' align='left' colspan='2' width='15%' nowrap>" . $inrec['phone'] . "</td>
        </tr>";
      }
    }

    // empty the shopping cart
    $query2 = vam_db_query("select  p.products_price price,
                                    p.products_model model,
                                    pd.products_name name
                            from    " . TABLE_PRODUCTS . " p,
                                    " . TABLE_PRODUCTS_DESCRIPTION . " pd,
                                    " . TABLE_LANGUAGES . " l
                            where   p.products_id = '" . $inrec['pid'] . "' and
                                    pd.products_id = p.products_id and
                                    pd.language_id = '" . $_SESSION['languages_id'] . "' ");

    $inrec2 = vam_db_fetch_array($query2);

    // BEGIN OF ATTRIBUTE DB CODE
    $prodAttribs = ''; // DO NOT DELETE

    if ($SHOW_ATTRIBUTES) {
      $attribquery = vam_db_query("select  cba.products_id pid,
                                           po.products_options_name poname,
                                           pov.products_options_values_name povname
                                   from    " . TABLE_CUSTOMERS_BASKET_ATTRIBUTES . " cba,
                                           " . TABLE_PRODUCTS_OPTIONS . " po,
                                           " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov,
                                           " . TABLE_LANGUAGES . " l
                                   where   cba.products_id ='" . $inrec['pid'] . "' and
                                           po.products_options_id = cba.products_options_id and
                                           pov.products_options_values_id = cba.products_options_value_id and
                                           po.language_id = '" . $_SESSION['languages_id'] . "' and
                                           pov.language_id = '" . $_SESSION['languages_id'] . "'
                                ");
      $hasAttributes = false;

      if (vam_db_num_rows($attribquery)){
        $hasAttributes = true;
        $prodAttribs = '<br>';

        while ($attribrecs = vam_db_fetch_array($attribquery)){
          $prodAttribs .= '<small><i> - ' . $attribrecs['poname'] . ' ' . $attribrecs['povname'] . '</i></small><br>';
        }
      }
    }
    // END OF ATTRIBUTE DB CODE

    $tprice = $tprice + ($inrec['qty'] * $inrec2['price']);

    if ($inrec['qty'] != 0)
    {
      $pprice_formated  = $currencies->format($inrec2['price']);
      $tpprice_formated = $currencies->format(($inrec['qty'] * $inrec2['price']));

      $cline .= "<tr class='dataTableRow'>
                    <td class='dataTableContent' align='left' vAlign='top' colspan='2' width='12%' nowrap> &nbsp;</td>
                    <td class='dataTableContent' align='left' vAlign='top' width='13%' nowrap>" . $inrec2['model'] . "</td>
                    <td class='dataTableContent' align='left' vAlign='top' colspan='2' width='55%'><a href='" . vam_href_link(FILENAME_CATEGORIES, 'action=new_product&read=only&pID=' . $inrec['pid'] . '&origin=' . FILENAME_RECOVER_CART_SALES . '?page=' . $_GET['page'], 'NONSSL') . "'><b>" . $inrec2['name'] . "</b></a>
                    " . $prodAttribs . "
                    </td>
                    <td class='dataTableContent' align='center' vAlign='top' width='5%' nowrap>" . $inrec['qty'] . "</td>
                    <td class='dataTableContent' align='right'  vAlign='top' width='5%' nowrap>" . $pprice_formated . "</td>
                    <td class='dataTableContent' align='right'  vAlign='top' width='10%' nowrap>" . $tpprice_formated . "</td>
                 </tr>";
    }
  }
  $totalAll_formated = $currencies->format($totalAll);
  $cline = "<tr></tr><td class='dataTableContent' align='right' colspan='8'><b>" . TABLE_GRAND_TOTAL . "</b>" . $totalAll_formated . "</td>
              </tr>";

  echo $cline;
 echo "<tr><td colspan=8><b>". PSMSG ."</b><br>". vam_draw_textarea_field('message', 'soft', '80', '5') ."<br /><span class=button><button type=submit value=.TEXT_SEND_EMAIL.>".TEXT_SEND_EMAIL."</button></span></td></tr>";
?>
 </form>
<?php }
//
// end footer of both e-mail and report
//
?>

            </table>
          <!-- REPORT TABLE END //-->
          </td>
        </tr>
      </table>
    </td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>

</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
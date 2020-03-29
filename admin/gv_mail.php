<?php
/* -----------------------------------------------------------------------------------------
   $Id: gv_mail.php 1030 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce (gv_mail.php,v 1.3.2.4 2003/05/12); www.oscommerce.com
   (c) 2004	 xt:Commerce (gv_mail.php,v 1.3.2.4 2003/05/12); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


  require('includes/application_top.php');
  require_once(DIR_FS_INC . 'vam_wysiwyg_tiny.inc.php'); 

  require(DIR_WS_CLASSES . 'currencies.php');
  $currencies = new currencies();
  
  require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.phpmailer.php');
  if (EMAIL_TRANSPORT == 'smtp')
  require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.smtp.php');
  require_once(DIR_FS_INC . 'vam_php_mail.inc.php');

  // initiate template engine for mail
  $vamTemplate = new vamTemplate;

  if ( ($_GET['action'] == 'send_email_to_user') && ($_POST['customers_email_address'] || $_POST['email_to']) && (!$_POST['back_x']) ) {
    switch ($_POST['customers_email_address']) {
      case '***':
        $mail_query = vam_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS);
        $mail_sent_to = TEXT_ALL_CUSTOMERS;
        break;
      case '**D':
        $mail_query = vam_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_newsletter = '1'");
        $mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
        break;
      default:
        $customers_email_address = vam_db_prepare_input($_POST['customers_email_address']);

        $mail_query = vam_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_email_address = '" . vam_db_input($customers_email_address) . "'");
        $mail_sent_to = $_POST['customers_email_address'];
        if ($_POST['email_to']) {
          $mail_sent_to = $_POST['email_to'];
        }
        break;
    }

    $from = vam_db_prepare_input($_POST['from']);
    $subject = vam_db_prepare_input($_POST['subject']);
    while ($mail = vam_db_fetch_array($mail_query)) {
      $id1 = create_coupon_code($mail['customers_email_address']);

      // assign language to template for caching
      $vamTemplate->assign('language', $_SESSION['language']);
      $vamTemplate->caching = false;

      $vamTemplate->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
      $vamTemplate->assign('logo_path',HTTP_SERVER  . DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

      $vamTemplate->assign('AMMOUNT', $currencies->format($_POST['amount']));
      $vamTemplate->assign('MESSAGE', $_POST['message']);
      $vamTemplate->assign('GIFT_ID', $id1);
      $vamTemplate->assign('WEBSITE', HTTP_SERVER  . DIR_WS_CATALOG);


      $link = HTTP_SERVER  . DIR_WS_CATALOG . 'gv_redeem.php' . '?gv_no='.$id1;


      $vamTemplate->assign('GIFT_LINK',$link);

      $html_mail=$vamTemplate->fetch(CURRENT_TEMPLATE . '/admin/mail/'.$_SESSION['language'].'/send_gift.html');
      $txt_mail=$vamTemplate->fetch(CURRENT_TEMPLATE . '/admin/mail/'.$_SESSION['language'].'/send_gift.txt');

      if ($subject=='') $subject=EMAIL_BILLING_SUBJECT;
      vam_php_mail(EMAIL_BILLING_ADDRESS,EMAIL_BILLING_NAME, $mail['customers_email_address'] , $mail['customers_firstname'] . ' ' . $mail['customers_lastname'] , '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $subject, $html_mail , $txt_mail);


	  // Now create the coupon main and email entry
      $insert_query = vam_db_query("insert into " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $id1 . "', 'G', '" . $_POST['amount'] . "', now())");
      $insert_id = vam_db_insert_id();
      $insert_query = vam_db_query("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $insert_id ."', '0', 'Admin', '" . $mail['customers_email_address'] . "', now() )");
    }
    if ($_POST['email_to']) {
      $id1 = create_coupon_code($_POST['email_to']);

      // assign language to template for caching
      $vamTemplate->assign('language', $_SESSION['language']);
      $vamTemplate->caching = false;

      $vamTemplate->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
      $vamTemplate->assign('logo_path',HTTP_SERVER  . DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

      $vamTemplate->assign('AMMOUNT', $currencies->format($_POST['amount']));
      $vamTemplate->assign('MESSAGE', $_POST['message']);
      $vamTemplate->assign('GIFT_ID', $id1);
      $vamTemplate->assign('WEBSITE', HTTP_SERVER  . DIR_WS_CATALOG);

      if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') {
        $link = HTTP_SERVER  . DIR_WS_CATALOG . 'gv_redeem.php' . '/gv_no,'.$id1;
      } else {
        $link = HTTP_SERVER  . DIR_WS_CATALOG . 'gv_redeem.php' . '?gv_no='.$id1;
      }

      $vamTemplate->assign('GIFT_LINK',$link);

      $html_mail=$vamTemplate->fetch(CURRENT_TEMPLATE . '/admin/mail/'.$_SESSION['language'].'/send_gift.html');
      $txt_mail=$vamTemplate->fetch(CURRENT_TEMPLATE . '/admin/mail/'.$_SESSION['language'].'/send_gift.txt');


      vam_php_mail(EMAIL_BILLING_ADDRESS,EMAIL_BILLING_NAME, $_POST['email_to'] , '' , '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', EMAIL_BILLING_SUBJECT, $html_mail , $txt_mail);


      // Now create the coupon email entry
      $insert_query = vam_db_query("insert into " . TABLE_COUPONS . " (coupon_code, coupon_type, coupon_amount, date_created) values ('" . $id1 . "', 'G', '" . $_POST['amount'] . "', now())");
      $insert_id1 = vam_db_insert_id();
      $insert_query = vam_db_query("insert into " . TABLE_COUPON_EMAIL_TRACK . " (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('" . $insert_id1 ."', '0', 'Admin', '" . $_POST['email_to'] . "', now() )");
    }
    vam_redirect(vam_href_link(FILENAME_GV_MAIL, 'mail_sent_to=' . urlencode($mail_sent_to)));
  }

  if ( ($_GET['action'] == 'preview') && (!$_POST['customers_email_address']) && (!$_POST['email_to']) ) {
    $messageStack->add(ERROR_NO_CUSTOMER_SELECTED, 'error');
  }

  if ( ($_GET['action'] == 'preview') && (!$_POST['amount']) ) {
    $messageStack->add(ERROR_NO_AMOUNT_SELECTED, 'error');
  }

  if ($_GET['mail_sent_to']) {
    $messageStack->add(sprintf(NOTICE_EMAIL_SENT_TO, $_GET['mail_sent_to']), 'notice');
  }
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
<?php if ($_GET['action'] != 'preview') {
 $query=vam_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".$_SESSION['languages_id']."'");
 $data=vam_db_fetch_array($query);
 echo vam_wysiwyg_tiny('gv_mail',$data['code']);
 } ?>
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
    <td class="boxCenter" valign="top">
    
    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ( ($_GET['action'] == 'preview') && ($_POST['customers_email_address'] || $_POST['email_to']) ) {
    switch ($_POST['customers_email_address']) {
      case '***':
        $mail_sent_to = TEXT_ALL_CUSTOMERS;
        break;
      case '**D':
        $mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
        break;
      default:
        $mail_sent_to = $_POST['customers_email_address'];
        if ($_POST['email_to']) {
          $mail_sent_to = $_POST['email_to'];
        }
        break;
    }
?>
          <tr><?php echo vam_draw_form('mail', FILENAME_GV_MAIL, 'action=send_email_to_user'); ?>
            <td><table border="0" width="100%" cellpadding="0" cellspacing="2">
              <tr>
                <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_CUSTOMER; ?></b><br /><?php echo $mail_sent_to; ?></td>
              </tr>
              <tr>
                <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_FROM; ?></b><br /><?php echo htmlspecialchars(stripslashes($_POST['from'])); ?></td>
              </tr>
              <tr>
                <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_SUBJECT; ?></b><br /><?php echo htmlspecialchars(stripslashes($_POST['subject'])); ?></td>
              </tr>
              <tr>
                <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_AMOUNT; ?></b><br /><?php echo nl2br(htmlspecialchars(stripslashes($_POST['amount']))); ?></td>
              </tr>
              <tr>
                <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TEXT_MESSAGE; ?></b><br /><?php echo $_POST['message']; ?></td>
              </tr>
              <tr>
                <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td>
<?php
/* Re-Post all POST'ed variables */
      foreach ($_POST as $key => $value) {
        if (!is_array($_POST[$key])) {
          echo vam_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
        }
      }
?>
                <table border="0" width="100%" cellpadding="0" cellspacing="2">
                  <tr>
                    <td><?php echo '<span class="button"><button type="submit" name="back" value="' . BUTTON_BACK . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . BUTTON_BACK . '</button></span>'; ?></td>
                    <td align="right"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_GV_MAIL) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a> <span class="button"><button type="submit" value="' . BUTTON_SEND_EMAIL . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_SEND_EMAIL . '</button></span>'; ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </form></tr>
<?php
  } else {
?>
          <tr><?php echo vam_draw_form('mail', FILENAME_GV_MAIL, 'action=preview'); ?>
            <td><table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
<?php
    if ($_GET['cID']) {
    $select='where customers_id='.$_GET['cID'];
    } else {
    $customers = array();
    $customers[] = array('id' => '', 'text' => TEXT_SELECT_CUSTOMER);
    $customers[] = array('id' => '***', 'text' => TEXT_ALL_CUSTOMERS);
    $customers[] = array('id' => '**D', 'text' => TEXT_NEWSLETTER_CUSTOMERS);
    }
    $mail_query = vam_db_query("select customers_id, customers_email_address, customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " ".$select." order by customers_lastname");
    while($customers_values = vam_db_fetch_array($mail_query)) {
      $customers[] = array('id' => $customers_values['customers_email_address'],
                           'text' => $customers_values['customers_lastname'] . ', ' . $customers_values['customers_firstname'] . ' (' . $customers_values['customers_email_address'] . ')');
    }
?>
              <tr>
                <td class="main"><?php echo TEXT_CUSTOMER; ?></td>
                <td><?php echo vam_draw_pull_down_menu('customers_email_address', $customers, $_GET['customer']);?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
               <tr>
                <td class="main"><?php echo TEXT_TO; ?></td>
                <td><?php echo vam_draw_input_field('email_to'); ?><?php echo '&nbsp;&nbsp;' . TEXT_SINGLE_EMAIL; ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
             <tr>
                <td class="main"><?php echo TEXT_FROM; ?></td>
                <td><?php echo vam_draw_input_field('from', EMAIL_FROM); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td class="main"><?php echo TEXT_SUBJECT; ?></td>
                <td><?php echo vam_draw_input_field('subject'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td valign="top" class="main"><?php echo TEXT_AMOUNT; ?></td>
                <td><?php echo vam_draw_input_field('amount'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td valign="top" class="main"><?php echo TEXT_MESSAGE; ?></td>
                <td><?php echo vam_draw_textarea_field('message', 'soft', '100%', '55'); ?><br /><a href="javascript:toggleHTMLEditor('message');"><?php echo TEXT_TOGGLE_EDITOR; ?></a></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td colspan="2" align="right"><?php echo '<span class="button"><button type="submit" value="' . BUTTON_SEND_EMAIL . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_SEND_EMAIL . '</button></span>'; ?></td>
              </tr>
            </table></td>
          </form></tr>
<?php
  }
?>
<!-- body_text_eof //-->
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
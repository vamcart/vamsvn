<?php
/* --------------------------------------------------------------
   $Id: mail.php 955 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(mail.php,v 1.30 2002/03/16 01:07:28); www.oscommerce.com 
   (c) 2003	 nextcommerce (mail.php,v 1.11 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (mail.php,v 1.11 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------
   Third Party contribution:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.phpmailer.php');
  if (EMAIL_TRANSPORT == 'smtp')
  require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.smtp.php');
  require_once(DIR_FS_INC . 'vam_php_mail.inc.php');
  require_once(DIR_FS_INC . 'vam_wysiwyg_tiny.inc.php'); 

  if ( ($_GET['action'] == 'send_email_to_user') && ($_POST['customers_email_address']) && (!$_POST['back_x']) ) {
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
        if (is_numeric($_POST['customers_email_address'])) {
          $mail_query = vam_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_status = " . $_POST['customers_email_address']);
          $sent_to_query = vam_db_query("select customers_status_name from " . TABLE_CUSTOMERS_STATUS . " WHERE customers_status_id = '" . $_POST['customers_email_address'] . "' AND language_id='" . $_SESSION['languages_id'] . "'");
          $sent_to = vam_db_fetch_array($sent_to_query);
          $mail_sent_to = $sent_to['customers_status_name'];
        } else {
          $customers_email_address = vam_db_prepare_input($_POST['customers_email_address']);
          $mail_query = vam_db_query("select customers_firstname, customers_lastname, customers_email_address from " . TABLE_CUSTOMERS . " where customers_email_address = '" . vam_db_input($customers_email_address) . "'");
          $mail_sent_to = $_POST['customers_email_address'];
        }
        break;
    }

    $from = vam_db_prepare_input($_POST['from']);
    $subject = vam_db_prepare_input($_POST['subject']);
    $message = vam_db_prepare_input($_POST['message']);


    while ($mail = vam_db_fetch_array($mail_query)) {

      vam_php_mail(EMAIL_SUPPORT_ADDRESS,
               EMAIL_SUPPORT_NAME,
               $mail['customers_email_address'] ,
               $mail['customers_firstname'] . ' ' . $mail['customers_lastname'] ,
               '',
               EMAIL_SUPPORT_REPLY_ADDRESS,
               EMAIL_SUPPORT_REPLY_ADDRESS_NAME,
                '',
                '',
                $subject,
                $message,
                $message);
    }



    vam_redirect(vam_href_link(FILENAME_MAIL, 'mail_sent_to=' . urlencode($mail_sent_to)));
  }

  if ( ($_GET['action'] == 'preview') && (!$_POST['customers_email_address']) ) {
    $messageStack->add(ERROR_NO_CUSTOMER_SELECTED, 'error');
  }

  if ($_GET['mail_sent_to']) {
    $messageStack->add(sprintf(NOTICE_EMAIL_SENT_TO, $_GET['mail_sent_to']), 'notice');
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<?php 
if (!isset($_GET['action'])) {
$query=vam_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".$_SESSION['languages_id']."'");
$data=vam_db_fetch_array($query);
echo vam_wysiwyg_tiny('mail',$data['code']);
} 
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
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
  if ( ($_GET['action'] == 'preview') && ($_POST['customers_email_address']) ) {
    switch ($_POST['customers_email_address']) {
      case '***':
        $mail_sent_to = TEXT_ALL_CUSTOMERS;
        break;

      case '**D':
        $mail_sent_to = TEXT_NEWSLETTER_CUSTOMERS;
        break;

      default:
        if (is_numeric($_POST['customers_email_address'])) {
          echo "hier bin ich";
          $sent_to_query = vam_db_query("select customers_status_name from " . TABLE_CUSTOMERS_STATUS . " WHERE customers_status_id = '" . $_POST['customers_email_address'] . "' AND language_id='" . $_SESSION['languages_id'] . "'");
          $sent_to = vam_db_fetch_array($sent_to_query);
          $mail_sent_to = $sent_to['customers_status_name'];
        } else {
          $mail_sent_to = $_POST['customers_email_address'];
        }
        break;
    }
?>
          <tr><?php echo vam_draw_form('mail', FILENAME_MAIL, 'action=send_email_to_user'); ?>
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
                <td class="smallText"><b><?php echo TEXT_MESSAGE; ?></b><br /><?php echo nl2br(htmlspecialchars(stripslashes($_POST['message']))); ?></td>
              </tr>
              <tr>
                <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td><?php
    // Re-Post all POST'ed variables
    foreach ($_POST as $key => $value) {
      if (!is_array($_POST[$key])) {
        echo vam_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
      }
    }
?>
                <table border="0" width="100%" cellpadding="0" cellspacing="2">
                  <tr>
                    <td><span class="button"><button type="submit" onClick="return confirm('<?php echo SAVE_ENTRY; ?>')" value="<?php echo BUTTON_BACK; ?>" name="back"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12'); ?>&nbsp;<?php echo BUTTON_BACK; ?></button></span></td>
                    <td align="right"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_MAIL) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a> <span class="button"><button type="submit" value="'.BUTTON_SEND_EMAIL.'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_SEND_EMAIL . '</button></span>' ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </form></tr>
<?php
  } else {
?>
          <tr><?php echo vam_draw_form('mail', FILENAME_MAIL, 'action=preview'); ?>
            <td><table border="0" cellpadding="0" cellspacing="2">
              <tr>
                <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
<?php
    $customers = array();
    $customers[] = array('id' => '', 'text' => TEXT_SELECT_CUSTOMER);
    $customers[] = array('id' => '***', 'text' => TEXT_ALL_CUSTOMERS);
    $customers[] = array('id' => '**D', 'text' => TEXT_NEWSLETTER_CUSTOMERS);
    // Customers Status 1.x
//    $customers_statuses_array = vam_get_customers_statuses();
    $customers_statuses_array = vam_db_query("select customers_status_id , customers_status_name from " . TABLE_CUSTOMERS_STATUS . " WHERE language_id='" . $_SESSION['languages_id'] . "' order by customers_status_name");
    while ($customers_statuses_value = vam_db_fetch_array($customers_statuses_array)) {
      $customers[] = array('id' => $customers_statuses_value['customers_status_id'],
                           'text' => $customers_statuses_value['customers_status_name']);
    }
    // End customers Status 1.x
    $mail_query = vam_db_query("select customers_email_address, customers_firstname, customers_lastname from " . TABLE_CUSTOMERS . " order by customers_lastname");
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
                <td valign="top" class="main"><?php echo TEXT_MESSAGE; ?></td>
                <td><?php echo vam_draw_textarea_field('message', 'soft', '100%', '20'); ?><br /><a href="javascript:toggleHTMLEditor('message');"><?php echo TEXT_TOGGLE_EDITOR; ?></a></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
              </tr>
              <tr>
                <td colspan="2" align="right"><span class="button"><button type="submit" value="<?php echo BUTTON_SEND_EMAIL; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12');?>&nbsp;<?php echo BUTTON_SEND_EMAIL; ?></button></span></td>
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
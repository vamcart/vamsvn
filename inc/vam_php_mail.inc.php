<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_php_mail.inc.php 1129 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (vam_php_mail.inc.php,v 1.17 2003/08/24); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_php_mail.inc.php,v 1.17 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
// include the mail classes
function vam_php_mail($from_email_address, $from_email_name, $to_email_address, $to_name, $forwarding_to, $reply_address, $reply_address_name, $path_to_attachement, $path_to_more_attachements, $email_subject, $message_body_html, $message_body_plain) {
	global $mail_error;

	$mail = new PHPMailer();
	$mail->PluginDir = DIR_FS_DOCUMENT_ROOT.'includes/external/phpmailer/';

	if (isset ($_SESSION['language_charset'])) {
		$mail->CharSet = $_SESSION['language_charset'];
	} else {
		$lang_query = "SELECT * FROM ".TABLE_LANGUAGES." WHERE code = '".DEFAULT_LANGUAGE."'";
		$lang_query = vam_db_query($lang_query);
		$lang_data = vam_db_fetch_array($lang_query);
		$mail->CharSet = $lang_data['language_charset'];
	}
	if ($_SESSION['language'] == 'russian') {
		$mail->SetLanguage("ru", DIR_FS_DOCUMENT_ROOT.'includes/external/phpmailer/language/');
	} else {
		$mail->SetLanguage("en", DIR_FS_DOCUMENT_ROOT.'includes/external/phpmailer/language/');
	}
	if (EMAIL_TRANSPORT == 'smtp') {
		$mail->IsSMTP();
		$mail->SMTPKeepAlive = true; // set mailer to use SMTP
		$mail->SMTPAuth = SMTP_AUTH; // turn on SMTP authentication true/false
		$mail->Port = SMTP_PORT;
		$mail->Username = SMTP_USERNAME; // SMTP username
		$mail->Password = SMTP_PASSWORD; // SMTP password
		$mail->Host = SMTP_MAIN_SERVER.';'.SMTP_Backup_Server; // specify main and backup server "smtp1.example.com;smtp2.example.com"
	}

	if (EMAIL_TRANSPORT == 'sendmail') { // set mailer to use SMTP
		$mail->IsSendmail();
		$mail->Sendmail = SENDMAIL_PATH;
	}
	if (EMAIL_TRANSPORT == 'mail') {
		$mail->IsMail();
	}

	if (EMAIL_USE_HTML == 'true') // set email format to HTML
		{
		$mail->IsHTML(true);
		$mail->Body = $message_body_html;
		// remove html tags
		$message_body_plain = str_replace('<br />', " \n", $message_body_plain);
		$message_body_plain = strip_tags($message_body_plain);
		//$mail->AltBody = $message_body_plain;
	} else {
		$mail->IsHTML(false);
		//remove html tags
		$message_body_plain = str_replace('<br />', " \n", $message_body_plain);
		$message_body_plain = strip_tags($message_body_plain);
		$mail->Body = $message_body_plain;
	}

	$mail->From = $from_email_address;
	$mail->Sender = $from_email_address;
	$mail->FromName = $from_email_name;
	$mail->AddAddress($to_email_address, $to_name);
	if ($forwarding_to != '')
		$mail->AddBCC($forwarding_to);
	
	$mail->AddReplyTo($reply_address, $reply_address_name);

	$mail->WordWrap = 100; // set word wrap to 50 characters
	//$mail->AddAttachment($path_to_attachement);                     // add attachments
	//$mail->AddAttachment($path_to_more_attachements);               // optional name                                          

	$mail->Subject = $email_subject;

if (SEND_EMAILS == 'true') {
	if (!$mail->Send()) {
		//echo TEXT_PHP_MAILER_ERROR;
		//echo TEXT_PHP_MAILER_ERROR1 . $mail->ErrorInfo;
		//exit;
	}
}
}
?>
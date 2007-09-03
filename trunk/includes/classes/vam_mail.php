<?php

require_once (HOME_DIR . '/includes/external/phpmailer/class.phpmailer.php');

// Настройки для MY site

// Настройки Email
$site['from_name'] = 'my name'; // from (от) имя
$site['from_email'] = 'email@mywebsite.com'; // from (от) email адрес
// На всякий случай указываем настройки
// для дополнительного (внешнего) SMTP сервера.
$site['smtp_mode'] = 'disabled'; // enabled or disabled (включен или выключен)
$site['smtp_host'] = null;
$site['smtp_port'] = null;
$site['smtp_username'] = null;

class vamMail extends PHPMailer
{
    var $charset = 'utf-8';
    var $priority = 3;
    var $to_name;
    var $to_email;
    var $From = null;
    var $FromName = null;
    var $Sender = null;
  
    function vamMail()
    {
      global $site;
      
      if($site['smtp_mode'] == 'enabled')
      {
        $this->Host = $site['smtp_host'];
        $this->Port = $site['smtp_port'];
        if($site['smtp_username'] != '')
        {
         $this->SMTPAuth  = true;
         $this->Username  = $site['smtp_username'];
         $this->Password  =  $site['smtp_password'];
        }
        $this->Mailer = "smtp";
      }
      if(!$this->From)
      {
        $this->From = $site['from_email'];
      }
      if(!$this->FromName)
      {
        $this-> FromName = $site['from_name'];
      }
      if(!$this->Sender)
      {
        $this->Sender = $site['from_email'];
      }
      $this->Priority = $this->priority;
    }
}

// инициализируем класс
$vamMail = new vamMail();

?>
<?php

require_once (DIR_FS_CATALOG.'includes/external/gettext/gettext.inc');

define(LOCALE_DIR, HOME_DIR .'/locale');
define(DEFAULT_LOCALE, 'ru_RU');

$encoding = 'UTF-8';

$locale = DEFAULT_LOCALE;
$locale = (isset($_GET['lang']))? $_GET['lang'] : DEFAULT_LOCALE;

// gettext setup
T_setlocale(LC_ALL, $locale);
// Set the text domain
$domain = 'messages';
T_bindtextdomain($domain, LOCALE_DIR);
T_bind_textdomain_codeset($domain, $encoding);
T_textdomain($domain);

      $data = new FileReader(LOCALE_DIR . '/' .  $locale . '/LC_MESSAGES/messages.mo');

//    Then, use that as a parameter to gettext_reader constructor:
      
      $vamLocalization = new gettext_reader($data, false);

?>
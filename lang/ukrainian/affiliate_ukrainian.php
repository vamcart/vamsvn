<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_english.php,v 1.1 2012/12/21 20:13:07 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_german.php, v 1.12 2003/08/18);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

define('BOX_INFORMATION_AFFILIATE', 'партнерки');
define('BOX_AFFILIATE_INFO', 'Інформація');
define('BOX_AFFILIATE_SUMMARY', 'Загальна статистика');
define('BOX_AFFILIATE_ACCOUNT', 'Змінити дані');
define('BOX_AFFILIATE_CLICKRATE', 'Кліки');
define('BOX_AFFILIATE_PAYMENT', 'Виплати');
define('BOX_AFFILIATE_SALES', 'Продажі');
define('BOX_AFFILIATE_BANNERS', 'Отримати HTML-код');
define('BOX_AFFILIATE_CONTACT', 'Зв\'яжіться з нами');
define('BOX_AFFILIATE_FAQ', 'FAQ');
define('BOX_AFFILIATE_LOGIN', 'Вхід / Реєстрація');
define('BOX_AFFILIATE_LOGOUT', 'Вийти');

define('ENTRY_AFFILIATE_ACCEPT_AGB', 'Ви повинні погодитися з <a target="_new" href="%s"> правилами нашої партнерської програми </a>.');
define('ENTRY_AFFILIATE_AGB_ERROR', '&nbsp; <small> <font color="#FF0000">Ви повинні погодитися з правилами нашої партнерської програми </font></small>');
define('ENTRY_AFFILIATE_PAYMENT_CHECK_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_CHECK_ERROR', '&nbsp; <small> <font color="#FF0000">обов\'язково </font></small>');
define('ENTRY_AFFILIATE_PAYMENT_PAYPAL_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_PAYPAL_ERROR', '&nbsp; <small> <font color="#FF0000">обов\'язково </font></small>');
define('ENTRY_AFFILIATE_PAYMENT_BANK_NAME_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_BANK_NAME_ERROR', '&nbsp; <small> <font color="#FF0000">обов\'язково </font></small>');
define('ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME_ERROR', '&nbsp; <small> <font color="#FF0000">обов\'язково </font></small>');
define('ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER_ERROR', '&nbsp; <small> <font color="#FF0000">обов\'язково </font></small>');
define('ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER_ERROR', '&nbsp; <small> <font color="#FF0000">обов\'язково </font></small>');
define('ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE_TEXT', '');
define('ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE_ERROR', '&nbsp; <small> <font color="#FF0000">обов\'язково </font></small>');
define('ENTRY_AFFILIATE_COMPANY_TEXT', '');
define('ENTRY_AFFILIATE_COMPANY_ERROR', '&nbsp; <small> <font color="#FF0000">обов\'язково </font></small>');
define('ENTRY_AFFILIATE_COMPANY_TAXID_TEXT', '');
define('ENTRY_AFFILIATE_COMPANY_TAXID_ERROR', '&nbsp; <small> <font color="#FF0000">обов\'язково </font></small>');
define('ENTRY_AFFILIATE_HOMEPAGE_TEXT', '');
define('ENTRY_AFFILIATE_HOMEPAGE_ERROR', '&nbsp; <small> <font color="#FF0000">обов\'язково (http://) </font></small>');

define('TEXT_AFFILIATE_PERIOD', 'Період:');
define('TEXT_AFFILIATE_STATUS', 'Статус:');
define('TEXT_AFFILIATE_LEVEL', 'Рівень:');
define('TEXT_AFFILIATE_ALL_PERIODS', 'Все періоди');
define('TEXT_AFFILIATE_ALL_STATUS', 'Все статуси');
define('TEXT_AFFILIATE_ALL_LEVELS', 'Всі рівні');
define('TEXT_AFFILIATE_PERSONAL_LEVEL', 'Ви');
define('TEXT_AFFILIATE_LEVEL_SUFFIX', 'Рівень');
define('TEXT_AFFILIATE_NAME', 'Назва банера:');
define('TEXT_AFFILIATE_INFO', 'Скопіюйте код, розташований нижче і розмістіть його на своєму сайті. Даний код Ви можете розміщувати в будь-якому місці свого сайту.');
define('TEXT_DISPLAY_NUMBER_OF_CLICKS', 'Показано <b>%d</b> - <b>%d</b> (всього <b>%d</b> кліків)');
define('TEXT_DISPLAY_NUMBER_OF_SALES', 'Показано <b>%d</b> - <b>%d</b> (всього <b>%d </b> продажів)');
define('TEXT_DISPLAY_NUMBER_OF_PAYMENTS', 'Показано <b>%d</b> - <b>%d</b> (всього <b>%d</b> виплат)');
define('TEXT_DELETED_ORDER_BY_ADMIN', 'Вилучений адміністратором');
define('TEXT_AFFILIATE_PERSONAL_LEVEL_SHORT', 'Ви');
define('TEXT_COMMISSION_LEVEL_TIER', 'Рівень:');
define('TEXT_COMMISSION_RATE_TIER', 'Комісія:');
define('TEXT_COMMISSION_TIER_COUNT', 'Продажі:');
define('TEXT_COMMISSION_TIER_TOTAL', 'Сума:');
define('TEXT_COMMISSION_TIER', 'Комісія:');

define('EMAIL_PASSWORD_REMINDER_SUBJECT', STORE_NAME. '- Новий пароль');
define('EMAIL_PASSWORD_REMINDER_BODY', 'Ви запросили новий пароль з адреси'. $REMOTE_ADDR. '.'. "\n \n". 'Ваш новий пароль:'. "\n \n". '% s'. "\n \n ");

define('MAIL_AFFILIATE_SUBJECT', 'Партнерська програма'. STORE_NAME);
define('MAIL_AFFILIATE_HEADER', 'Спасибі, що приєдналися до нашої партнерської програми!
Ваші дані:
');
define('MAIL_AFFILIATE_ID', 'Партнерський код:');
define('MAIL_AFFILIATE_USERNAME', 'E-mail:');
define('MAIL_AFFILIATE_PASSWORD', 'Пароль:');
define('MAIL_AFFILIATE_LINK', 'Вхід в систему:');
define('MAIL_AFFILIATE_FOOTER', 'Сподіваємося на взаємовигідне співробітництво, дякуємо!');

define('EMAIL_SUBJECT', 'Партнерська програма');

define('NAVBAR_TITLE', 'Партнерська програма');
define('NAVBAR_TITLE_AFFILIATE', 'Вхід');
define('NAVBAR_TITLE_BANNERS', 'Банери');
define('NAVBAR_TITLE_CLICKS', 'Кліки');
define('NAVBAR_TITLE_CONTACT', 'Зворотній зв\'язок');
define('NAVBAR_TITLE_DETAILS', 'Змінити дані');
define('NAVBAR_TITLE_DETAILS_OK', 'Дані змінено');
define('NAVBAR_TITLE_FAQ', 'Питання і відповіді');
define('NAVBAR_TITLE_INFO', 'Інформація');
define('NAVBAR_TITLE_LOGOUT', 'Вихід');
define('NAVBAR_TITLE_PASSWORD_FORGOTTEN', 'Забули пароль');
define('NAVBAR_TITLE_PAYMENT', 'Виплати');
define('NAVBAR_TITLE_SALES', 'Продажі');
define('NAVBAR_TITLE_SIGNUP', 'Реєстрація');
define('NAVBAR_TITLESIGNUP_OK', 'Реєстрація успішно завершена');
define('NAVBAR_TITLE_SUMMARY', 'Загальна статистика');
define('NAVBAR_TITLE_TERMS', 'Умови');

define('IMAGE_BANNERS', 'Банери');
define('IMAGE_CLICKTHROUGHS', 'Кліки');
define('IMAGE_SALES', 'Продажі');
?>
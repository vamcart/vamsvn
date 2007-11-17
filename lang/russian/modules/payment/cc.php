<?php
/*------------------------------------------------------------------------------
  $Id: cc.php 1003 2007/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
  -----------------------------------------------------------------------------
  based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cc.php,v 1.28 2003/02/14); www.oscommerce.com
   (c) 2003	 nextcommerce (cc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (cc.php,v 1.4 2003/08/13); xt-commerce.com

  Released under the GNU General Public License
------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_CC_TEXT_TITLE', 'Оплата кредитной карточкой');
  define('MODULE_PAYMENT_CC_TEXT_DESCRIPTION', 'Информация о кредитной карточке для теста:<br><br>Номер карточки: 4111111111111111<br>Действительна до: Любая дата');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_TYPE', 'Тип кредитной карточки:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_OWNER', 'Владелец кредитной карточки:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_NUMBER', 'Номер кредитной карточки:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_START', 'Дата выдачи:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_EXPIRES', 'Действительна до:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_ISSUE', 'Порядковый номер карточки:');
  define('MODULE_PAYMENT_CC_TEXT_CREDIT_CARD_CVV', '3 или 4 значный код cvv:');      
  define('MODULE_PAYMENT_CC_TEXT_JS_CC_OWNER', '* Поле Владелец кредитной карточки должно содержать как минимум ' . CC_OWNER_MIN_LENGTH . ' символов.\n');
  define('MODULE_PAYMENT_CC_TEXT_JS_CC_NUMBER', '* Поле Номер кредитной карточки должно содержать как минимум ' . CC_NUMBER_MIN_LENGTH . ' символов.\n');
  define('MODULE_PAYMENT_CC_TEXT_ERROR', 'Ошибка!');
  define('TEXT_CARD_NOT_ACZEPTED','Извините, но мы не принимаем кредитные карточки <b>%s</b>, используйте другой тип кредитной карточки!<br />Мы принимаем к оплате следующие кредитные карточки: ');
  define('MODULE_PAYMENT_CC_TEXT_JS_CC_CVV', 'CVV код должен быть обязательно указан.\n Без него заказ оформить нельзя.\n CVV код - это 3- или 4- (карточки American Express) значный код на Вашей кредитной карточке.');
  define('MODULE_PAYMENT_CC_TEXT_CVV_LINK', '<u>[нужна помощь?]</u>');
  define('HEADING_CVV', 'Помощь');
  define('TEXT_CVV', '<span class="bold">Карточки Visa, Mastercard, Discover имеют трёхзначный код верификации</span><br />Для Вашей безопасноти, мы требуем в обязательном порядке указывать данный код. Код верификации - это трёхзначный номер, напечатанный на обратной стороне Вашей карточки. Он находится правее номера кредитной карточки.<br /><img src="images/cv_card.gif" alt="" /><br /><span class="bold">Карточки American Express имеют 4 значный код</span><br />Для Вашей безопасноти, мы требуем в обязательном порядке указывать данный код. Код верификации - это четырёхзначный номер, напечатанный на карточке. Он находится выше и правее номера кредитной карточки.<br /><img src="images/cv_amex_card.gif" alt="" /><br />');
  define('TEXT_CLOSE_WINDOW', '<u>Закрыть окно</u> [x]');
    define('MODULE_PAYMENT_CC_ACCEPTED_CARDS','Мы принимаем к оплате следующие кредитные карточки:');
  define('MODULE_PAYMENT_CC_TEXT_INFO','');
  define('MODULE_PAYMENT_CC_STATUS_TITLE', 'Разрешить модуль Оплата кредитной карточкой');
  define('MODULE_PAYMENT_CC_STATUS_DESC', 'Вы хотите разрешить использование модуля при оформлении заказов?');
  define('MODULE_PAYMENT_CC_ALLOWED_TITLE' , 'Разрешённые страны');
  define('MODULE_PAYMENT_CC_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
  define('CC_VAL_TITLE', 'Разрешить проверку карточек');
  define('CC_VAL_DESC', 'Вы хотите разрешить проверку указанных карточек?');
  define('CC_BLACK_TITLE', 'Разрешить проверку чёрного списка');
  define('CC_BLACK_DESC', 'Вы хотите разрешить провеку чёрного списка?');
  define('CC_ENC_TITLE', 'Кодировать информацию о кредитной карточке');
  define('CC_ENC_DESC', 'Вы хотите кодировать информацию о кредитной карточке?');
  define('MODULE_PAYMENT_CC_SORT_ORDER_TITLE', 'Порядок сортировки');
  define('MODULE_PAYMENT_CC_SORT_ORDER_DESC', 'Порядок сортировки модуля.');
  define('MODULE_PAYMENT_CC_ZONE_TITLE', 'Зона');
  define('MODULE_PAYMENT_CC_ZONE_DESC', 'Если выбрана зона, то данный модуль оплаты будет виден только покупателям из выбранной зоны.');
  define('MODULE_PAYMENT_CC_ORDER_STATUS_ID_TITLE', 'Статус заказа');
  define('MODULE_PAYMENT_CC_ORDER_STATUS_ID_DESC', 'Заказы, оформленные с использованием данного модуля оплаты будут принимать указанный статус.');
  define('USE_CC_CVV_TITLE', 'Собирать CVV номера');
  define('USE_CC_CVV_DESC', 'Вы хотите собирать CVV номера?');
  define('USE_CC_ISS_TITLE', 'Собирать порядковые номера');
  define('USE_CC_ISS_DESC', 'Вы хотите собирать порядковые номера?');
  define('USE_CC_START_TITLE', 'Собирать дату выдачи');
  define('USE_CC_START_DESC', 'Вы хотите собирать дату выдачи?');
  define('CC_CVV_MIN_LENGTH_TITLE', 'Длина CVV кода');
  define('CC_CVV_MIN_LENGTH_DESC', 'Определите длину CVV кода. По умолчанию указано 3.');
  define('MODULE_PAYMENT_CC_EMAIL_TITLE', 'Разделять номер карточки');
  define('MODULE_PAYMENT_CC_EMAIL_DESC', 'Если указан E-Mail, средние цифры номера кредитной карточки будут отправлены на указанный E-Mail (остальные цифры номера хранятся в базе данных, те цифры, что отправлены на E-Mail, будут вырезаны из номера кредитной карточки.');
define('TEXT_CCVAL_ERROR_INVALID_DATE', 'Поле "Действительно до" заполнено неправильно.<br />Попробуйте ещё раз.');
define('TEXT_CCVAL_ERROR_INVALID_NUMBER', 'Поле "Номер кредитной карточки", заполнено неправильно.<br />Попробуйте ещё раз.');
define('TEXT_CCVAL_ERROR_UNKNOWN_CARD', 'Первые 4 цифры Вашей кредитной карточки: %s<br />Если Вы указали номер правильно, то мы не принимаем к оплате данный тип кредитных карточек.<br />Попробуйте ещё раз.');

  define('MODULE_PAYMENT_CC_ACCEPT_DINERSCLUB_TITLE', 'Принимать к оплате кредитные карточки DINERS CLUB');
  define('MODULE_PAYMENT_CC_ACCEPT_DINERSCLUB_DESC', 'Принимать к оплате кредитные карточки DINERS CLUB');
  define('MODULE_PAYMENT_CC_ACCEPT_AMERICANEXPRESS_TITLE', 'Принимать к оплате кредитные карточки AMERICAN EXPRESS');
  define('MODULE_PAYMENT_CC_ACCEPT_AMERICANEXPRESS_DESC', 'Принимать к оплате кредитные карточки AMERICAN EXPRESS');
  define('MODULE_PAYMENT_CC_ACCEPT_CARTEBLANCHE_TITLE', 'Принимать к оплате кредитные карточки CARTE BLANCHE');
  define('MODULE_PAYMENT_CC_ACCEPT_CARTEBLANCHE_DESC', 'Принимать к оплате кредитные карточки CARTE BLANCHE');
  define('MODULE_PAYMENT_CC_ACCEPT_OZBANKCARD_TITLE', 'Принимать к оплате кредитные карточки AUSTRALIAN BANKCARD');
  define('MODULE_PAYMENT_CC_ACCEPT_OZBANKCARD_DESC', 'Принимать к оплате кредитные карточки AUSTRALIAN BANKCARD');
  define('MODULE_PAYMENT_CC_ACCEPT_DISCOVERNOVUS_TITLE', 'Принимать к оплате кредитные карточки DISCOVER/NOVUS');
  define('MODULE_PAYMENT_CC_ACCEPT_DISCOVERNOVUS_DESC', 'Принимать к оплате кредитные карточки DISCOVER/NOVUS');
  define('MODULE_PAYMENT_CC_ACCEPT_DELTA_TITLE', 'Принимать к оплате кредитные карточки DELTA');
  define('MODULE_PAYMENT_CC_ACCEPT_DELTA_DESC', 'Принимать к оплате кредитные карточки DELTA');
  define('MODULE_PAYMENT_CC_ACCEPT_ELECTRON_TITLE', 'Принимать к оплате кредитные карточки ELECTRON');
  define('MODULE_PAYMENT_CC_ACCEPT_ELECTRON_DESC', 'Принимать к оплате кредитные карточки ELECTRON');
  define('MODULE_PAYMENT_CC_ACCEPT_MASTERCARD_TITLE', 'Принимать к оплате кредитные карточки MASTERCARD');
  define('MODULE_PAYMENT_CC_ACCEPT_MASTERCARD_DESC', 'Принимать к оплате кредитные карточки MASTERCARD');
  define('MODULE_PAYMENT_CC_ACCEPT_SWITCH_TITLE', 'Принимать к оплате кредитные карточки SWITCH');
  define('MODULE_PAYMENT_CC_ACCEPT_SWITCH_DESC', 'Принимать к оплате кредитные карточки SWITCH');
  define('MODULE_PAYMENT_CC_ACCEPT_SOLO_TITLE', 'Принимать к оплате кредитные карточки SOLO');
  define('MODULE_PAYMENT_CC_ACCEPT_SOLO_DESC', 'Принимать к оплате кредитные карточки SOLO');
  define('MODULE_PAYMENT_CC_ACCEPT_JCB_TITLE', 'Принимать к оплате кредитные карточки JCB');
  define('MODULE_PAYMENT_CC_ACCEPT_JCB_DESC', 'Принимать к оплате кредитные карточки JCB');
  define('MODULE_PAYMENT_CC_ACCEPT_MAESTRO_TITLE', 'Принимать к оплате кредитные карточки MAESTRO');
  define('MODULE_PAYMENT_CC_ACCEPT_MAESTRO_DESC', 'Принимать к оплате кредитные карточки MAESTRO');
  define('MODULE_PAYMENT_CC_ACCEPT_VISA_TITLE', 'Принимать к оплате кредитные карточки VISA');
  define('MODULE_PAYMENT_CC_ACCEPT_VISA_DESC', 'Принимать к оплате кредитные карточки VISA');
?>
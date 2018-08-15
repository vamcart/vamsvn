<?php
/* -----------------------------------------------------------------------------------------
   $Id: smscoin.php 2008-08-02 etles.ru $

   http://etles.ru

   Copyright (c) 2007 etles.ru
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cod.php,v 1.28 2003/02/14); www.oscommerce.com
   (c) 2003	 nextcommerce (cod.php,v 1.7 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (cod.php,v 1.7 2003/08/23); xt-commerce.com
   (c) 2007-04-29 21:07:20 VaM Shop (smscoin.php); http://vamshop.ru (http://vamshop.com)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

  define('MODULE_PAYMENT_SMSCOIN_TEXT_TITLE', 'Оплата sms сообщением с мобильного телефона');
  define('MODULE_PAYMENT_SMSCOIN_TEXT_DESCRIPTION', 'После нажатия кнопки подтвердить заказ Вы перейдёте на сайт http://smscoin.com, на котором Вы получите информацию с инструкциями об оплате с помощью sms сообщения, после оплаты Вы вернётесь в магазин и сможете сразу получить заказанный товар.');

  define('MODULE_PAYMENT_SMSCOIN_ID_TITLE' , 'Идентификатор Вашего смс банка в системе');
  define('MODULE_PAYMENT_SMSCOIN_ID_DESC' , 'Укажите номер своего идентификатора');

  define('MODULE_PAYMENT_SMSCOIN_SECRET_KEY_TITLE' , 'Секретный ключ Вашего смс банка');
  define('MODULE_PAYMENT_SMSCOIN_SECRET_KEY_DESC' , 'Укажите секретный ключ');

  define('MODULE_PAYMENT_SMSCOIN_STATUS_TITLE' , 'Включить модуль оплаты sms сообщением.');
  define('MODULE_PAYMENT_SMSCOIN_STATUS_DESC' , 'Вы хотите принимать оплату через sms сообщения?');

  define('MODULE_PAYMENT_SMSCOIN_ALLOWED_TITLE' , 'Разрешённые страны');
  define('MODULE_PAYMENT_SMSCOIN_ALLOWED_DESC' , 'Введите <b>раздельно</b> страны, для которых будет доступен данный модуль (например RU,DE) или оставьте пустым если хотите разрешить модуль для всех стран.');

  define('MODULE_PAYMENT_SMSCOIN_SORT_ORDER_TITLE' , 'Порядок сортировки');
  define('MODULE_PAYMENT_SMSCOIN_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');

  define('MODULE_PAYMENT_SMSCOIN_ZONE_TITLE' , 'Зоны оплаты');
  define('MODULE_PAYMENT_SMSCOIN_ZONE_DESC' , 'Если зона выбрана, то данный способ оплаты будет доступен только покупателям данной зоны.');

  define('MODULE_PAYMENT_SMSCOIN_ORDER_STATUS_ID_TITLE' , 'Статус заказа по умолчанию');
  define('MODULE_PAYMENT_SMSCOIN_ORDER_STATUS_ID_DESC' , 'Установите статус заказа по умолчанию при оплате этим способом.');

  define('MODULE_PAYMENT_SMSCOIN_HTTP_ADDR_TITLE' , 'Адрес шлюза');
  define('MODULE_PAYMENT_SMSCOIN_HTTP_ADDR_DESC' , 'Установите адрес шлюза вашего смс-кошелька.<br>Адрес шлюза имеет вид:<br>http://XXXX.bank.smscoin.com/bank/');

  define('MODULE_PAYMENT_SMSCOIN_TEXT_ERROR_MESSAGE', 'При попытке перечисления денег произошла ошибка, пожалуйста, попробуйте еще раз или выберите другой способ оплаты.');

?>
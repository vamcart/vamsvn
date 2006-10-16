<?php
/* -----------------------------------------------------------------------------------------
   $Id: russian.php 1260 2005-09-29 17:48:04Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(german.php,v 1.119 2003/05/19); www.oscommerce.com
   (c) 2003  nextcommerce (german.php,v 1.25 2003/08/25); www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

/*
 *
 *  DATE / TIME
 *
 */

define('TITLE', STORE_NAME);
define('HEADER_TITLE_TOP', 'Начало');     
define('HEADER_TITLE_CATALOG', 'Каталог');

define('HTML_PARAMS','dir="ltr" lang="ru"');

@setlocale(LC_TIME, 'ru_RU.CP1251', 'Russian');

define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d. %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('DOB_FORMAT_STRING', 'dd.mm.jjjj');

function xtc_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 3, 2) . substr($date, 0, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2); 
  }
}

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'USD');

define('MALE', 'уважаемый');
define('FEMALE', 'уважаемая');

/*
 *
 *  BOXES
 *
 */

// text for gift voucher redeeming
define('IMAGE_REDEEM_GIFT','Использовать сертификат!');

define('BOX_TITLE_STATISTICS','Статистика:');
define('BOX_ENTRY_CUSTOMERS','Клиенты');
define('BOX_ENTRY_PRODUCTS','Товары');
define('BOX_ENTRY_REVIEWS','Отзывы');
define('TEXT_VALIDATING','Не проверено');

// manufacturer box text
define('BOX_MANUFACTURER_INFO_HOMEPAGE', 'Официальный сайт %s');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Другие товары данного производителя');

define('BOX_HEADING_ADD_PRODUCT_ID','Добавить в корзину');
  
define('BOX_LOGINBOX_STATUS','Группа:');     
define('BOX_LOGINBOX_DISCOUNT','Скидка');
define('BOX_LOGINBOX_DISCOUNT_TEXT','Скидка');
define('BOX_LOGINBOX_DISCOUNT_OT','');

// reviews box text in includes/boxes/reviews.php
define('BOX_REVIEWS_WRITE_REVIEW', 'Оставить отзыв!');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s из 5 звёзд!');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Выберите');

// javascript messages
define('JS_ERROR', 'Не указана необходимая информация!\nПожалуйста, исправьте допущенные ошибки.\n\n');

define('JS_REVIEW_TEXT', '* Поле Текст отзыва должно содержать не менее ' . REVIEW_TEXT_MIN_LENGTH . ' символов.\n');
define('JS_REVIEW_RATING', '* Вы не указали рейтинг.\n');
define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Выберите способ оплаты для Вашего заказа.\n');
define('JS_ERROR_SUBMITTED', 'Эта форма уже заполнена. Нажимайте Ok.');
define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Выберите способ оплаты для Вашего заказа.\n');

/*
 *
 * ACCOUNT FORMS
 *
 */

define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER_ERROR', 'Вы должны указать свой пол.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME_ERROR', 'Поле Имя должно содержать как минимум ' . ENTRY_FIRST_NAME_MIN_LENGTH . ' символа.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_LAST_NAME_ERROR', 'Поле Фамилия должно содержать как минимум ' . ENTRY_LAST_NAME_MIN_LENGTH . ' символа.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Дату рождения необходимо вводить в следующем формате: DD/MM/YYYY (пример 21/05/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (пример 21/05/1970)');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Поле E-Mail должно правильно заполнено и содержать как минимум ' . ENTRY_EMAIL_ADDRESS_MIN_LENGTH . ' символов.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Ваш E-Mail адрес указан неправильно, попробуйте ещё раз.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Введённый Вами E-Mail уже зарегистрирован в нашем магазине, попробуйте указать другой E-Mail адрес.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS_ERROR', 'Поле Улица и номер дома должно содержать как минимум ' . ENTRY_STREET_ADDRESS_MIN_LENGTH . ' символов.');
define('ENTRY_STREET_ADDRESS_TEXT', '* Пример: ул. Мира 346, кв. 78');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE_ERROR', 'Поле Почтовый индекс должно содержать как минимум ' . ENTRY_POSTCODE_MIN_LENGTH . ' символа.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY_ERROR', 'Поле Город должно содержать как минимум ' . ENTRY_CITY_MIN_LENGTH . ' символа.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE_ERROR', 'Поле Регион должно содержать как минимум ' . ENTRY_STATE_MIN_LENGTH . ' символа.');
define('ENTRY_STATE_ERROR_SELECT', 'Укажите регион.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY_ERROR', 'Укажите страну.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Поле Телефон должно содержать как минимум ' . ENTRY_TELEPHONE_MIN_LENGTH . ' символа.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_PASSWORD_ERROR', 'Ваш пароль должен содержать как минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Поле Подтвердите пароль должно совпадать с полем Пароль.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Поле Пароль должно содержать как минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Ваш Новый пароль должен содержать как минимум ' . ENTRY_PASSWORD_MIN_LENGTH . ' символов.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Поля Подтвердите пароль и Новый пароль должны совпадать.');

/*
 *
 *  RESTULTPAGES
 *
 */

define('TEXT_RESULT_PAGE', 'Страницы:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> позиций)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> заказов)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> отзывов)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> новинок)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> специальных предложений)');
define('TEXT_DISPLAY_NUMBER_OF_FEATURED', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> рекомендуемых товаров)');

/*
 *
 * SITE NAVIGATION
 *
 */

define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'Предыдущая страница');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Следующая страница');
define('PREVNEXT_TITLE_PAGE_NO', 'Страница %d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Предыдущие %d страниц');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Следующие %d страниц');

/*
 *
 * PRODUCT NAVIGATION
 *
 */

define('PREVNEXT_BUTTON_PREV', 'Предыдущая');
define('PREVNEXT_BUTTON_NEXT', 'Следующая');

/*
 *
 * IMAGE BUTTONS
 *
 */

define('IMAGE_BUTTON_ADD_ADDRESS', 'Добавить адрес');
define('IMAGE_BUTTON_BACK', 'Назад');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Изменить адрес');
define('IMAGE_BUTTON_CHECKOUT', 'Оформить заказ');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Подтвердить Заказ');
define('IMAGE_BUTTON_CONTINUE', 'Продолжить');
define('IMAGE_BUTTON_DELETE', 'Удалить');
define('IMAGE_BUTTON_LOGIN', 'Продолжить');
define('IMAGE_BUTTON_IN_CART', 'Добавить в корзину');
define('IMAGE_BUTTON_SEARCH', 'Искать');
define('IMAGE_BUTTON_UPDATE', 'Обновить');
define('IMAGE_BUTTON_UPDATE_CART', 'Пересчитать');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Написать отзыв');
define('IMAGE_BUTTON_ADMIN', 'Админка');
define('IMAGE_BUTTON_PRODUCT_EDIT', 'Редактировать товар');

define('SMALL_IMAGE_BUTTON_DELETE', 'Удалить');
define('SMALL_IMAGE_BUTTON_EDIT', 'Изменить');
define('SMALL_IMAGE_BUTTON_VIEW', 'Смотреть');

define('ICON_ARROW_RIGHT', 'Перейти');
define('ICON_CART', 'В корзину');
define('ICON_SUCCESS', 'Выполнено');
define('ICON_WARNING', 'Внимание');

/*
 *
 *  GREETINGS
 *
 */

define('TEXT_GREETING_PERSONAL', 'Добро пожаловать, <span class="greetUser">%s!</span> Вы хотите посмотреть какие <a style="text-decoration:underline;" href="%s">новые товары</a> поступили в наш магазин?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>Если Вы не %s, пожалуйста, <a style="text-decoration:underline;" href="%s">введите</a> свои данные для входа.</small>');
define('TEXT_GREETING_GUEST', 'Добро пожаловать, <span class="greetUser">УВАЖАЕМЫЙ ГОСТЬ!</span><br /> Если Вы наш постоянный клиент, <a style="text-decoration:underline;" href="%s">введите Ваши персональные данные</a> для входа. Если Вы у нас впервые и хотите сделать покупки, Вам необходимо <a style="text-decoration:underline;" href="%s">зарегистрироваться</a>.');

define('TEXT_SORT_PRODUCTS', 'Сортировать товар по ');
define('TEXT_DESCENDINGLY', 'убыванию');
define('TEXT_ASCENDINGLY', 'возрастанию');
define('TEXT_BY', ' по ');

define('TEXT_REVIEW_BY', '- %s');
define('TEXT_REVIEW_WORD_COUNT', '%s слов');
define('TEXT_REVIEW_RATING', 'Рейтинг: %s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Отзыв добавлен: %s');
define('TEXT_NO_REVIEWS', 'К настоящему времени нет отзывов.');
define('TEXT_NO_NEW_PRODUCTS', 'На данный момент нет новых товаров.');
define('TEXT_UNKNOWN_TAX_RATE', 'Неизвестная налоговая ставка');

/*
 *
 * WARNINGS
 *
 */

define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Предупреждение: Не удалена директория установки магазина: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/install. Пожалуйста, удалите эту директорию в целях безопасности.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Предупреждение: Файл конфигурации доступен для записи: ' . dirname($HTTP_SERVER_VARS['SCRIPT_FILENAME']) . '/includes/configure.php. Это - потенциальный риск безопасности - пожалуйста, установите необходимые права доступа к этому файлу.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Предупреждение: директория сессий не существует: ' . xtc_session_save_path() . '. Сессии не будут работать пока эта директория не будет создана.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Предупреждение: Нет доступа к директории сессий: ' . xtc_session_save_path() . '. Сессии не будут работать пока не установлены необходимые права доступа.');
define('WARNING_SESSION_AUTO_START', 'Предупреждение: опция session.auto_start включена - пожалуйста, выключите данную опцию в файле php.ini и перезапустите веб-сервер.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Предупреждение: Директория отсутствует: ' . DIR_FS_DOWNLOAD . '. Создайте директорию.');

define('SUCCESS_ACCOUNT_UPDATED', 'Ваши данные обновлены!');
define('SUCCESS_PASSWORD_UPDATED', 'Ваш пароль изменён!');
define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', 'Указанный пароль не совпадает с текущим паролем. Попробуйте ещё раз.');
define('TEXT_MAXIMUM_ENTRIES', '<font color="#ff0000"><b>ЗАМЕЧАНИЕ:</b></font> Максимальный объем адресной книги - <b>%s</b> записей');
define('SUCCESS_ADDRESS_BOOK_ENTRY_DELETED', 'Выбранный адрес удалён из адресной книги.');
define('SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED', 'Ваша адресная книга обновлена.');
define('WARNING_PRIMARY_ADDRESS_DELETION', 'Адрес, установленный по умолчанию, не может быть удалён. Установите статус по умолчанию на другой адрес и попробуйте ещё раз.');
define('ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY', 'Адресная книга не найдена.');
define('ERROR_ADDRESS_BOOK_FULL', 'Ваша адресная книга полностью заполнена. Удалите ненужный Вам адрес и только после этого Вы сможете добавить новый адрес.');

//  conditions check

define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Мы не сможем принять Ваш заказ пока Вы не согласитесь с условиями!');

define('SUB_TITLE_OT_DISCOUNT','Скидка:');

define('TAX_ADD_TAX','включая ');
define('TAX_NO_TAX','плюс ');

define('NOT_ALLOWED_TO_SEE_PRICES','У Вас нет доступа для просмотра цен ');
define('NOT_ALLOWED_TO_SEE_PRICES_TEXT','У Вас нет доступа для просмотра цен, пожалуйста, зарегистрируйтесь.');

define('TEXT_DOWNLOAD','Загрузки');
define('TEXT_VIEW','Смотреть');

define('TEXT_BUY', 'Купить \'');
define('TEXT_NOW', '\'');
define('TEXT_GUEST','Посетитель');

/*
 *
 * ADVANCED SEARCH
 *
 */

define('TEXT_ALL_CATEGORIES', 'Все категории');
define('TEXT_ALL_MANUFACTURERS', 'Все производители');
define('JS_AT_LEAST_ONE_INPUT', '* Одно из полей должно быть заполнено:\n    Ключевые слова\n    Дата добавления от:\n    Дата добавления до:\n    Цена от \n    Цена до\n');
define('AT_LEAST_ONE_INPUT', 'Одно из полей должно быть заполнено:<br />Ключевые слова как минимум 3 символа<br />Цена от<br />Цена до<br />');
define('JS_INVALID_FROM_DATE', '* Дата указана в неверном формате\n');
define('JS_INVALID_TO_DATE', '* Неправильная дата добавления до\n');
define('JS_TO_DATE_LESS_THAN_FROM_DATE', '* Дата до должна быть больше даты от\n');
define('JS_PRICE_FROM_MUST_BE_NUM', '* Цена от должна быть номером\n');
define('JS_PRICE_TO_MUST_BE_NUM', '* Цена до должна быть номером\n');
define('JS_PRICE_TO_LESS_THAN_PRICE_FROM', '* Цена до должна быть больше цены от.\n');
define('JS_INVALID_KEYWORDS', '* Неверные ключевые слова\n');
define('TEXT_LOGIN_ERROR', '<font color="#ff0000"><b>ОШИБКА:</b></font> Указанный \'Email\' и/или \'пароль\' неверный.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', '<font color="#ff0000"><b>ПРЕДУПРЕЖДЕНИЕ:</b></font> Указанный Email не найден. Попробуйте ещё раз.');
define('TEXT_PASSWORD_SENT', 'Новый пароль был отправлен на Email.');
define('TEXT_PRODUCT_NOT_FOUND', 'Товар не найден!');
define('TEXT_MORE_INFORMATION', 'Для получения дополнительной информации посетите <a style="text-decoration:underline;" href="%s" onclick="window.open(this.href); return false;">сайт</a> товара.');

define('TEXT_DATE_ADDED', 'Товар был добавлен в наш каталог %s');
define('TEXT_DATE_AVAILABLE', '<font color="#ff0000">Товар будет в наличии %s</font>');
define('SUB_TITLE_SUB_TOTAL', 'Стоимость товара:');

define('OUT_OF_STOCK_CANT_CHECKOUT', 'Товары, выделенные ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' имеются на нашем складе в недостаточном для Вашего заказа количестве.<br />Пожалуйста, измените количество продуктов выделенных (' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '), благодарим Вас.');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'Товары, выделенные ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' имеются на нашем складе в недостаточном для Вашего заказа количестве.<br />Тем не менее, Вы можете оформить заказ для поэтапной доставки заказанного товара.');

define('MINIMUM_ORDER_VALUE_NOT_REACHED_1', 'Минимальная сумма заказа должна быть: ');
define('MINIMUM_ORDER_VALUE_NOT_REACHED_2', ' <br />Увеличьте Ваш заказ как минимум на: ');
define('MAXIMUM_ORDER_VALUE_REACHED_1', 'Вы превысили максимально разрешённую сумму заказа, установленную в: ');
define('MAXIMUM_ORDER_VALUE_REACHED_2', '<br /> Уменьшите Ваш заказ как минимум на: ');

define('ERROR_INVALID_PRODUCT', 'Товар не найден!');

/*
 *
 * NAVBAR Titel
 *
 */

define('NAVBAR_TITLE_ACCOUNT', 'Ваши данные');
define('NAVBAR_TITLE_1_ACCOUNT_EDIT', 'Ваши данные');
define('NAVBAR_TITLE_2_ACCOUNT_EDIT', 'Редактирование данных');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY', 'Ваши данные');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY', 'Ваши заказы');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY_INFO', 'Ваши данные');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY_INFO', 'Оформленные заказы');
define('NAVBAR_TITLE_3_ACCOUNT_HISTORY_INFO', 'Заказ номер %s');
define('NAVBAR_TITLE_1_ACCOUNT_PASSWORD', 'Ваши данные');
define('NAVBAR_TITLE_2_ACCOUNT_PASSWORD', 'Изменить пароль');
define('NAVBAR_TITLE_1_ADDRESS_BOOK', 'Ваши данные');
define('NAVBAR_TITLE_2_ADDRESS_BOOK', 'Адресная книга');
define('NAVBAR_TITLE_1_ADDRESS_BOOK_PROCESS', 'Ваши данные');
define('NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS', 'Адресная книга');
define('NAVBAR_TITLE_ADD_ENTRY_ADDRESS_BOOK_PROCESS', 'Добавить запись');
define('NAVBAR_TITLE_MODIFY_ENTRY_ADDRESS_BOOK_PROCESS', 'Изменить запись');
define('NAVBAR_TITLE_DELETE_ENTRY_ADDRESS_BOOK_PROCESS', 'Удалить запись');
define('NAVBAR_TITLE_ADVANCED_SEARCH', 'Расширенный поиск');
define('NAVBAR_TITLE1_ADVANCED_SEARCH', 'Расширенный поиск');
define('NAVBAR_TITLE2_ADVANCED_SEARCH', 'Результаты поиска');
define('NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION', 'Оформление заказа');
define('NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION', 'Подтверждение');
define('NAVBAR_TITLE_1_CHECKOUT_PAYMENT', 'Оформление заказа');
define('NAVBAR_TITLE_2_CHECKOUT_PAYMENT', 'Способ оплаты');
define('NAVBAR_TITLE_1_PAYMENT_ADDRESS', 'Оформление заказа');
define('NAVBAR_TITLE_2_PAYMENT_ADDRESS', 'Изменить адрес покупателя');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING', 'Оформление заказа');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING', 'Способ доставки');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING_ADDRESS', 'Оформление заказа');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING_ADDRESS', 'Изменить адрес доставки');
define('NAVBAR_TITLE_1_CHECKOUT_SUCCESS', 'Оформление заказа');
define('NAVBAR_TITLE_2_CHECKOUT_SUCCESS', 'Заказ успешно оформлен');
define('NAVBAR_TITLE_CREATE_ACCOUNT', 'Регистрация');
if ($navigation->snapshot['page'] == FILENAME_CHECKOUT_SHIPPING) {
  define('NAVBAR_TITLE_LOGIN', 'Заказ');
} else {
  define('NAVBAR_TITLE_LOGIN', 'Вход');
}
define('NAVBAR_TITLE_LOGOFF','Выход');
define('NAVBAR_TITLE_PRODUCTS_NEW', 'Новые товары');
define('NAVBAR_TITLE_SHOPPING_CART', 'Корзина');
define('NAVBAR_TITLE_SPECIALS', 'Скидки');
define('NAVBAR_TITLE_FEATURED', 'Рекомендуемые товары');
define('NAVBAR_TITLE_COOKIE_USAGE', 'Ошибка cookies');
define('NAVBAR_TITLE_PRODUCT_REVIEWS', 'Отзывы');
define('NAVBAR_TITLE_REVIEWS_WRITE', 'Написать отзыв');
define('NAVBAR_TITLE_REVIEWS','Отщывы');
define('NAVBAR_TITLE_SSL_CHECK', 'Безопасный режим');
define('NAVBAR_TITLE_CREATE_GUEST_ACCOUNT','Регистрация');
define('NAVBAR_TITLE_PASSWORD_DOUBLE_OPT','Забыли пароль?');
define('NAVBAR_TITLE_NEWSLETTER','Рассылка');
define('NAVBAR_GV_REDEEM', 'Использовать сертификат');
define('NAVBAR_GV_SEND', 'Отправить сертификат');

/*
 *
 *  MISC
 *
 */

define('TEXT_NEWSLETTER','Хотите узнавать о новинках первым?<br />Подпишитесь на наши новости и Вы первым узнаете обо всех изменениях и новинках.');
define('TEXT_EMAIL_INPUT','Ваш E-Mail адрес был успешно зарегистрирован в нашей системе.<br />Вам было отправлено письмо с персональной ссылкой на подтверждение. Пожалуйста, перейдите по ссылке, указаной в письме. В противном случае Вы не будете получать почтовую рассылку!');

define('TEXT_WRONG_CODE','<font color="FF0000">Заполните поля E-mail и Секретный код.<br />Пожалуйста, будьте внимательны!<br />Учитывайте регистр, если на картинке заглавная буква, то нужно писать именно заглавную букву, а не строчную.');
define('TEXT_EMAIL_EXIST_NO_NEWSLETTER','<font color="FF0000">Указанный Email адрес зарегистрирован, но не активирован!</font>');
define('TEXT_EMAIL_EXIST_NEWSLETTER','<font color="FF0000">Указанный Email адрес зарегистрирован и активирован!</font>');
define('TEXT_EMAIL_NOT_EXIST','<font color="FF0000">Указанный Email адрес не зарегистрирован!</font>');
define('TEXT_EMAIL_DEL','Указанный Email адрес был успешно удалён.');
define('TEXT_EMAIL_DEL_ERROR','<font color="FF0000">Произошла ошибка, Email адрес не был удалён!</font>');
define('TEXT_EMAIL_ACTIVE','<font color="FF0000">Ваш Email адрес был добавлен к списку рассылки!</font>');
define('TEXT_EMAIL_ACTIVE_ERROR','<font color="FF0000">Произошла ошибка, Email адрес не был активирован!</font>');
define('TEXT_EMAIL_SUBJECT','Почтовая рассылка');

define('TEXT_CUSTOMER_GUEST','Гость');

define('TEXT_LINK_MAIL_SENDED','Вам отправлено письмо с персональной ссылкой на подтверждение о восстановлении пароля. <br />Вам необходимо перейти по ссылке, указанной в письме. После подтверждения запроса на восстановление пароля мы отправим Вам новый пароль для входа в магазин. Если Вы не перейдёте по указанной ссылке, новый пароль не будет отправлен!');
define('TEXT_PASSWORD_MAIL_SENDED','Вам отправлено письмо с новым паролем к Вашей персональной информации.<br />Пожалуйста, не забудьте изменить Ваш новый пароль после первого входа в магазин.');
define('TEXT_CODE_ERROR','Заполните поле EMail и Секретный код ещё раз. <br />Пожалуйста, будьте внимательны!');
define('TEXT_EMAIL_ERROR','Заполните поле E-Mail и Секретный код ещё раз. <br />Пожалуйста, будьте внимательны!');
define('TEXT_NO_ACCOUNT','К сожалению, запрос-подтверждение на новый пароль неверный либо устарел. Возможно, Вы активируете старую ссылку, в то время как была отправлена более новая. Пожалуйста, попробуйте ещё раз.');

define('HEADING_PASSWORD_FORGOTTEN','Забыли пароль?');
define('TEXT_PASSWORD_FORGOTTEN','Измените пароль в три шага.');
define('TEXT_EMAIL_PASSWORD_FORGOTTEN','Подтверждение email для отправки нового пароля');
define('TEXT_EMAIL_PASSWORD_NEW_PASSWORD','Ваш новый пароль');
define('ERROR_MAIL','Пожалуйста, проверьте указанные в форме данные');

define('CATEGORIE_NOT_FOUND','Категория не найдена');

define('GV_FAQ', 'Вопросы и ответы по сертификатам');
define('ERROR_NO_REDEEM_CODE', 'Вы не указали код сертификата ');  
define('ERROR_NO_INVALID_REDEEM_GV', 'Неверный код сертификата '); 
define('TABLE_HEADING_CREDIT', 'Здесь Вы можете указать номер сертификата/купона, если он у Вас есть:<br />(Если у Вас нет сертификата/купона, просто продолжайте оформлять заказ, нажав внизу страницы кнопку "Продолжить")');
define('EMAIL_GV_TEXT_SUBJECT', 'Подарок от %s');
define('MAIN_MESSAGE', 'Вы решили отправить сертификат на сумму %s своему знакомому %s, его Email адрес: %s<br /><br />Получатель сертификата получит следующее сообщение:<br /><br />Уважаемый %s<br /><br />
                        Вам отправлен сертификат на сумму %s, отправитель: %s');
define('ERROR_REDEEMED_AMOUNT', 'Ваш сертификат использован ');
define('REDEEMED_COUPON','Ваш купон записан и будет использован при оформлении следующего заказа.');

define('ERROR_INVALID_USES_USER_COUPON','Клиент может использовать только данный купон ');
define('ERROR_INVALID_USES_COUPON','Покупатели могут использовать данный купон ');
define('TIMES',' раз.');
define('ERROR_INVALID_STARTDATE_COUPON','Ваш купон ещё недоступен.');
define('ERROR_INVALID_FINISDATE_COUPON','Ваш купон устарел.');
define('PERSONAL_MESSAGE', '%s пишет:');

//Popup Window
define('TEXT_CLOSE_WINDOW', 'Закрыть окно.');

/*
 *
 * CUOPON POPUP
 *
 */

define('TEXT_CLOSE_WINDOW', 'Закрыть окно [x]');
define('TEXT_COUPON_HELP_HEADER', 'Поздравляем, Вы использовали купон.');
define('TEXT_COUPON_HELP_NAME', '<br /><br />Название купона: %s');
define('TEXT_COUPON_HELP_FIXED', '<br /><br />Купон предоставляет скидку в размере %s');
define('TEXT_COUPON_HELP_MINORDER', '<br /><br />Заказ должен быть минимум на сумму %s чтобы у Вас появилась возможность использовать купон');
define('TEXT_COUPON_HELP_FREESHIP', '<br /><br />Данный купон предоставляет возможность бесплатной доставки Вашего заказа');
define('TEXT_COUPON_HELP_DESC', '<br /><br />Описание купона: %s');
define('TEXT_COUPON_HELP_DATE', '<br /><br />Данный купон действителен с %s до %s');
define('TEXT_COUPON_HELP_RESTRICT', '<br /><br />Ограничения Товары / Категории');
define('TEXT_COUPON_HELP_CATEGORIES', 'Категория');
define('TEXT_COUPON_HELP_PRODUCTS', 'Товар');

// VAT ID
define('ENTRY_VAT_TEXT','* только для Германии и стран Евросоюза');
define('ENTRY_VAT_ERROR', 'Выбранный VatID неверный! Укажите правильно ID или оставьте данное поле пустым.');
define('MSRP','Розничная цена ');
define('YOUR_PRICE','Ваша цена ');
define('ONLY',' всего ');
define('FROM','от ');
define('YOU_SAVE','Вы экономите ');
define('INSTEAD','вместо ');
define('TXT_PER',' за ');
define('TAX_INFO_INCL','включая %s налог');
define('TAX_INFO_EXCL','исключая %s налог');
define('TAX_INFO_ADD','плюс %s налог');
define('SHIPPING_EXCL','+');
define('SHIPPING_COSTS','доставка');

// Сборка VaM

define('BOX_HEADING_SEARCH', 'Поиск');
define('ICON_ERROR', 'Ошибка');

// RSS2 Info
define('NAVBAR_TITLE_RSS2_INFO','RSS каналы');
define('TEXT_RSS2_INFO', '
<h2>Основные запросы</h2>
<dl>
<dt>Категории</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=categories' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=categories</a>
<dt>Товары</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;limit=10</a>
<dt>Товар с id кодом 43</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;products_id=43' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;products_id=43</a>
<dt>Товары в категории</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;cPath=25&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;cPath=25&amp;limit=10</a><br />
		Товары в категории (25 это идентификатор категории, идентификаторы можно узнать, к примеру в ?feed=categories, в ссылке категории, т.е. Вы можете показывать товары только из определённых категорий).
</dl>

<h2>Дополнительные запросы</h2>
<dl>
<dt>Новинки</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products&amp;limit=10</a></dd>
<dt>Лучшие товары</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers&amp;limit=10</a></dd>
<dt>Рекомендуемые</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured&amp;limit=10</a></dd>
<dt>Скидки</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials&amp;limit=10</a></dd>
<dt>Ожидаемые товары</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming&amp;limit=10</a></dd>
</dl>

<h2>Случайные товары</h2>
<dl>
<dt>Случайный товар из новых товаров</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products_random</a></dd>
<dt>Случайный товар из лучших товаров</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers_random</a></dd>
<dt>Случайный товар из рекомендуемых</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured_random</a></dd>
<dt>Случайный товар из скидок</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials_random</a></dd>
<dt>Случайный товар из ожидаемых товаров</dt>
	<dd><a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming_random</a></dd>
</dl>

<h2>Лимит запросов</h2>
<p>Обратите внимание на параметр limit.<br />
Можно выводить, к примеру, не все новинки (rss2.php?feed=new_products), а только 10, просто добавляете параметр limit (rss2.php?feed=new_products&amp;limit=10)</p>
');

define('ENTRY_STATE_RELOAD', 'Нажмите на кнопку <b>"Обновить"</b> чтобы заполнить поле Регион');
define('ENTRY_NOSTATE_AVAILIABLE', 'У выбранной страны нет регионов');
define('ENTRY_STATEXML_LOADING', 'Загрузка регионов ...');

define('SHIPPING_TIME','Время доставки: ');
define('MORE_INFO','[Подробнее]');

define('TABLE_HEADING_LATEST_NEWS', 'Последние новости');
define('NAVBAR_TITLE_NEWS', 'Новости');

define('TEXT_DISPLAY_NUMBER_OF_LATEST_NEWS', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> новостей)');
define('TEXT_NO_NEWS', 'Нет новостей.');

define('TEXT_INFO_SHOW_PRICE_NO','У Вас нет доступа для просмотра цен');

define('TEXT_OF_5_STARS', '%s из 5 звёзд!');

?>
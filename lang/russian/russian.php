<?php
/* -----------------------------------------------------------------------------------------
   $Id: russian.php 1260 2014/08/09 13:25:47 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(german.php,v 1.119 2003/05/19); www.oscommerce.com
   (c) 2003  nextcommerce (german.php,v 1.25 2003/08/25); www.nextcommerce.org
   (c) 2004	 xt:Commerce (russian.php,v 1.25 2003/08/25); xt-commerce.com

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

define('HTML_PARAMS','xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"');

@setlocale(LC_TIME, 'en_US');

define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('DOB_FORMAT_STRING', 'dd.mm.jjjj');

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'RUB');

define('MALE', 'уважаемый');
define('FEMALE', 'уважаемая');

/*
 *
 *  BOXES
 *
 */

// text for gift voucher redeeming
define('IMAGE_REDEEM_GIFT','Использовать');

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
define('BOX_LOGINBOX_DISCOUNT','Ваша скидка');
define('BOX_LOGINBOX_DISCOUNT_TEXT','Скидка от суммы заказа');
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
define('JS_REVIEW_CAPTCHA', '* Вы не указали код с картинки.\n');
define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Выберите способ оплаты для Вашего заказа.\n');
define('JS_ERROR_SUBMITTED', 'Эта форма уже заполнена. Нажимайте Ok.');
define('ERROR_NO_PAYMENT_MODULE_SELECTED', '* Выберите способ оплаты для Вашего заказа.');

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
define('ENTRY_SECOND_NAME_TEXT', '');
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
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всего позиций: <span class="bold">%d</span>)');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всего заказов: <span class="bold">%d</span>)');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всего отзывов: <span class="bold">%d</span>)');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всего новинок: <span class="bold">%d</span>)');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всего специальных предложений: <span class="bold">%d</span>)');
define('TEXT_DISPLAY_NUMBER_OF_FEATURED', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всего рекомендуемых товаров: <span class="bold">%d</span>)');
define('TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всего брэндов: <span class="bold">%d</span>)');
define('TEXT_DISPLAY_NUMBER_OF_BEST_SELLERS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всего популярных товаров: <span class="bold">%d</span>)');

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
define('IMAGE_BUTTON_ARTICLE_EDIT', 'Редактировать статью');

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

define('TEXT_GREETING_PERSONAL', 'Добро пожаловать, <span class="greetUser">%s!</span> Вы хотите посмотреть какие <a href="%s">новые товары</a> поступили в наш магазин?');
define('TEXT_GREETING_PERSONAL_RELOGON', '<small>Если Вы не %s, пожалуйста, <a href="%s">введите</a> свои данные для входа.</small>');
define('TEXT_GREETING_GUEST', 'Добро пожаловать, <span class="greetUser">УВАЖАЕМЫЙ ГОСТЬ!</span><br /> Если Вы наш постоянный клиент, <a href="%s">введите Ваши персональные данные</a> для входа. Если Вы у нас впервые и хотите сделать покупки, Вам необходимо <a href="%s">зарегистрироваться</a>.');

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

define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Предупреждение: Не удалена директория установки магазина: ' . dirname($_SERVER['SCRIPT_FILENAME']) . '/install. Пожалуйста, удалите эту директорию в целях безопасности.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Предупреждение: Файл конфигурации доступен для записи: ' . dirname($_SERVER['SCRIPT_FILENAME']) . '/includes/configure.php. Это - потенциальный риск безопасности - пожалуйста, установите необходимые права доступа к этому файлу.');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Предупреждение: директория сессий не существует: ' . vam_session_save_path() . '. Сессии не будут работать пока эта директория не будет создана.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Предупреждение: Нет доступа к директории сессий: ' . vam_session_save_path() . '. Сессии не будут работать пока не установлены необходимые права доступа.');
define('WARNING_SESSION_AUTO_START', 'Предупреждение: опция session.auto_start включена - пожалуйста, выключите данную опцию в файле php.ini и перезапустите веб-сервер.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Предупреждение: Директория отсутствует: ' . DIR_FS_DOWNLOAD . '. Создайте директорию.');

define('SUCCESS_ACCOUNT_UPDATED', 'Ваши данные обновлены!');
define('SUCCESS_PASSWORD_UPDATED', 'Ваш пароль изменён!');
define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', 'Указанный пароль не совпадает с текущим паролем. Попробуйте ещё раз.');
define('TEXT_MAXIMUM_ENTRIES', '<span class="bold">ЗАМЕЧАНИЕ:</span> Максимальный объем адресной книги - <span class="bold">%s</span> записей');
define('SUCCESS_ADDRESS_BOOK_ENTRY_DELETED', 'Выбранный адрес удалён из адресной книги.');
define('SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED', 'Ваша адресная книга обновлена.');
define('WARNING_PRIMARY_ADDRESS_DELETION', 'Адрес, установленный по умолчанию, не может быть удалён. Установите статус по умолчанию на другой адрес и попробуйте ещё раз.');
define('ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY', 'Адресная книга не найдена.');
define('ERROR_ADDRESS_BOOK_FULL', 'Ваша адресная книга полностью заполнена. Удалите ненужный Вам адрес и только после этого Вы сможете добавить новый адрес.');

//  conditions check

define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Мы не сможем принять Ваш заказ пока Вы не согласитесь с условиями!');

define('SUB_TITLE_OT_DISCOUNT','Скидка:');

define('TAX_ADD_TAX','Включая ');
define('TAX_NO_TAX','Плюс ');

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
define('TEXT_LOGIN_ERROR', '<span class="bold">ОШИБКА:</span> Указанный \'E-Mail\' и/или \'пароль\' неверный.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', '<span class="bold">ПРЕДУПРЕЖДЕНИЕ:</span> Указанный E-Mail не найден. Попробуйте ещё раз.');
define('TEXT_PASSWORD_SENT', 'Новый пароль был отправлен на E-Mail.');
define('TEXT_PRODUCT_NOT_FOUND', 'Товар не найден!');
define('TEXT_MORE_INFORMATION', 'Для получения дополнительной информации посетите <a href="%s" onclick="window.open(this.href); return false;">сайт</a> товара.');

define('TEXT_DATE_ADDED', 'Товар был добавлен в наш каталог %s');
define('TEXT_DATE_AVAILABLE', 'Товар будет в наличии %s');
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
define('NAVBAR_TITLE_LOGIN', 'Вход');
define('NAVBAR_TITLE_LOGOFF','Выход');
define('NAVBAR_TITLE_PRODUCTS_NEW', 'Новые товары');
define('NAVBAR_TITLE_SHOPPING_CART', 'Корзина');
define('NAVBAR_TITLE_SPECIALS', 'Скидки');
define('NAVBAR_TITLE_FEATURED', 'Рекомендуемые товары');
define('NAVBAR_TITLE_COOKIE_USAGE', 'Ошибка cookies');
define('NAVBAR_TITLE_PRODUCT_REVIEWS', 'Отзывы');
define('NAVBAR_TITLE_REVIEWS_WRITE', 'Написать отзыв');
define('NAVBAR_TITLE_REVIEWS','Отзывы');
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

define('TEXT_WRONG_CODE','Заполните поля E-mail и Секретный код.<br />Пожалуйста, будьте внимательны!');
define('TEXT_EMAIL_EXIST_NO_NEWSLETTER','Указанный E-Mail адрес зарегистрирован, но не активирован!');
define('TEXT_EMAIL_EXIST_NEWSLETTER','Указанный E-Mail адрес зарегистрирован и активирован!');
define('TEXT_EMAIL_NOT_EXIST','Указанный E-Mail адрес не зарегистрирован!');
define('TEXT_EMAIL_DEL','Указанный E-Mail адрес был успешно удалён.');
define('TEXT_EMAIL_DEL_ERROR','Произошла ошибка, E-Mail адрес не был удалён!');
define('TEXT_EMAIL_ACTIVE','Ваш E-Mail адрес был добавлен к списку рассылки!');
define('TEXT_EMAIL_ACTIVE_ERROR','Произошла ошибка, E-Mail адрес не был активирован!');
define('TEXT_EMAIL_SUBJECT','Почтовая рассылка');

define('TEXT_CUSTOMER_GUEST','Гость');

define('TEXT_LINK_MAIL_SENDED','Вам отправлено письмо с персональной ссылкой на подтверждение о восстановлении пароля. <br />Вам необходимо перейти по ссылке, указанной в письме. После подтверждения запроса на восстановление пароля мы отправим Вам новый пароль для входа в магазин. Если Вы не перейдёте по указанной ссылке, новый пароль не будет отправлен!');
define('TEXT_PASSWORD_MAIL_SENDED','Вам отправлено письмо с новым паролем к Вашей персональной информации.<br />Пожалуйста, не забудьте изменить Ваш новый пароль после первого входа в магазин.');
define('TEXT_CODE_ERROR','Вы ввели неправильный e-mail и/или надпись на картинке.');
define('TEXT_EMAIL_ERROR','Вы ввели неправильный e-mail и/или надпись на картинке.');
define('TEXT_NO_ACCOUNT','К сожалению, запрос-подтверждение на новый пароль неверный либо устарел. Возможно, Вы активируете старую ссылку, в то время как была отправлена более новая. Пожалуйста, попробуйте ещё раз.');

define('HEADING_PASSWORD_FORGOTTEN','Забыли пароль?');
define('TEXT_PASSWORD_FORGOTTEN','Измените пароль в три шага.');
define('TEXT_EMAIL_PASSWORD_FORGOTTEN','Подтверждение E-Mail для отправки нового пароля');
define('TEXT_EMAIL_PASSWORD_NEW_PASSWORD','Ваш новый пароль');
define('ERROR_MAIL','Пожалуйста, проверьте указанные в форме данные');

define('CATEGORIE_NOT_FOUND','Категория не найдена');

define('GV_FAQ', 'Вопросы и ответы по сертификатам');
define('ERROR_NO_REDEEM_CODE', 'Вы не указали код сертификата ');  
define('ERROR_NO_INVALID_REDEEM_GV', 'Неверный код сертификата '); 
define('TABLE_HEADING_CREDIT', 'Использовать купон/сертификат');
define('EMAIL_GV_TEXT_SUBJECT', 'Подарок от %s');
define('MAIN_MESSAGE', 'Вы решили отправить сертификат на сумму %s своему знакомому %s, его E-Mail адрес: %s<br /><br />Получатель сертификата получит следующее сообщение:<br /><br />Уважаемый %s<br /><br />
                        Вам отправлен сертификат на сумму %s, отправитель: %s');
define('ERROR_REDEEMED_AMOUNT', 'Ваш сертификат использован ');
define('REDEEMED_AMOUNT', 'Ваш подарочный сертификат успешно активирован. Сумма сертификата: ');
define('REDEEMED_COUPON','Ваш купон активирован и будет использован при оформлении заказа.');

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
define('ONLY',' всего ');
define('FROM',' ');
define('YOU_SAVE','Вы экономите ');
define('INSTEAD','вместо ');
define('TXT_PER',' за ');
define('TAX_INFO_INCL','включая %s налог');
define('TAX_INFO_EXCL','исключая %s налог');
define('TAX_INFO_ADD','плюс %s налог');
define('SHIPPING_EXCL','+');
define('SHIPPING_COSTS','доставка');
define('MSRP','');
define('YOUR_PRICE','');
define('YOUR_SPECIAL_PRICE','');
define('YOUR_GRADUATED_PRICE','');
define('RETAIL_PRICE','');
define('GROUP_PRICE','Базовая цена группы');
define('MANUFACTURER_DISCOUNT','Личная скидка на производителя ');
define('PRODUCT_DISCOUNT','Скидка на товар ');
define('PERSONAL_DISCOUNT','Ваша скидка ');

// Сборка VaM

define('BOX_HEADING_SEARCH', 'Поиск');
define('ICON_ERROR', 'Ошибка');

// RSS2 Info
define('NAVBAR_TITLE_RSS2_INFO','RSS каналы');
define('TEXT_RSS2_INFO', '
<h3>Основные запросы</h3>
Новости - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=news' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=news</a><br />
Статьи - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=articles' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=articles</a><br />
Категории - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=categories' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=categories</a><br />
Товары - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;limit=10</a><br />
Товар с id кодом 43 - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;products_id=43' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;products_id=43</a><br />
Товары в категории - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;cPath=25&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=products&amp;cPath=25&amp;limit=10</a><br />
Товары в категории (25 это идентификатор категории, идентификаторы можно узнать, к примеру в ?feed=categories, в ссылке категории, т.е. Вы можете показывать товары только из определённых категорий).<br />
<br />
<h3>Дополнительные запросы</h3>
Новинки - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products&amp;limit=10</a><br />
Лидеры продаж - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers&amp;limit=10</a><br />
Рекомендуемые - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured&amp;limit=10</a><br />
Скидки - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials&amp;limit=10</a><br />
Ожидаемые товары - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming&amp;limit=10' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming&amp;limit=10</a><br />
<br />
<h3>Случайные товары</h3>
Случайный товар из новых товаров - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=new_products_random</a><br />
Случайный товар из лучших товаров - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=best_sellers_random</a><br />
Случайный товар из рекомендуемых - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=featured_random</a><br />
Случайный товар из скидок - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=specials_random</a><br />
Случайный товар из ожидаемых товаров - <a href="' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming_random' .'">' . HTTP_SERVER . DIR_WS_CATALOG . FILENAME_RSS2. '?feed=upcoming_random</a><br />
<br />
<h3>Лимит запросов</h3>
<p>Обратите внимание на параметр limit.<br />
Можно выводить, к примеру, не все новинки (rss2.php?feed=new_products), а только 10, просто добавляете параметр limit (rss2.php?feed=new_products&amp;limit=10)</p>
<h3>Партнёрский ID код</h3>
<p>Обратите внимание на параметр ref.<br />
Если у Вас в магазине установлен модуль партнёрской программы, Ваши партнёры могут получать RSS каналы со своим партнёрским кодом, например, партнёр с id кодом 1 может получить список новинок следующим образом rss2.php?feed=new_products&amp;ref=1</p>
');

define('ENTRY_STATE_RELOAD', 'Нажмите на кнопку <span class="bold">"Обновить"</span> чтобы заполнить поле Регион');
define('ENTRY_NOSTATE_AVAILIABLE', 'У выбранной страны нет регионов');
define('ENTRY_STATEXML_LOADING', 'Загрузка регионов ...');

define('SHIPPING_TIME','Время доставки: ');
define('MORE_INFO','[Подробнее]');

define('TABLE_HEADING_LATEST_NEWS', 'Последние новости');
define('NAVBAR_TITLE_NEWS', 'Новости');

define('TEXT_DISPLAY_NUMBER_OF_LATEST_NEWS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всего <span class="bold">%d</span> новостей)');
define('TEXT_NO_NEWS', 'Нет новостей.');

define('TEXT_INFO_SHOW_PRICE_NO','У Вас нет доступа для просмотра цен');

define('TEXT_OF_5_STARS', '%s из 5 звёзд!');

define('IMAGE_BUTTON_PRINT', 'Распечатать');

define('TEXT_AJAX_QUICKSEARCH_TOP', 'Первые %s позиций...');
define('TEXT_AJAX_ADDQUICKIE_SEARCH_TOP', 'Первые %s товаров...');

define('BOX_ALL_ARTICLES', 'Все статьи');
define('BOX_NEW_ARTICLES', 'Новые статьи');
define('TEXT_DISPLAY_NUMBER_OF_ARTICLES', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> статей)');
define('TEXT_DISPLAY_NUMBER_OF_ARTICLES_NEW', 'Показано <b>%d</b> - <b>%d</b> (всего <b>%d</b> новых статей)');
define('TABLE_HEADING_AUTHOR', 'Автор');
define('TABLE_HEADING_ABSTRACT', 'Резюме');
define('BOX_HEADING_AUTHORS', 'Авторы статей');
define('NAVBAR_TITLE_DEFAULT', 'Статьи');
define('ARTICLES_BY','Статьи автора ');

define('MODULE_PAYMENT_SCHET_PRINT','Распечатать счёт для оплаты');
define('MODULE_PAYMENT_PACKINGSLIP_PRINT','Распечатать накладную');
define('MODULE_PAYMENT_KVITANCIA_PRINT','Распечатать квитанцию для оплаты');

define('ENTRY_CAPTCHA_ERROR','Вы указали неправильный код картинки.');

define('TEXT_FIRST_REVIEW','Ваш отзыв может быть первым.');

define('TEXT_PHP_MAILER_ERROR','Не удалось отправить email.<br />');
define('TEXT_PHP_MAILER_ERROR1','Ошибка: ');

define('BOX_TEXT_DOWNLOAD', 'Ваши загрузки: ');
define('BOX_TEXT_DOWNLOAD_NOW', 'Загрузить');

define('TABLE_HEADING_DOWNLOAD_DATE','Ссылка активна до: ');
define('TABLE_HEADING_DOWNLOAD_COUNT','Осталось загрузок: ');
define('TEXT_FOOTER_DOWNLOAD','Все доступные загрузки также можно найти в ');
define('TEXT_DOWNLOAD_MY_ACCOUNT','Истории заказов');

define('NAVBAR_TITLE_ASK','Вопрос о товаре');
define('TEXT_EMAIL_SUCCESSFUL_SENT','Ваш вопрос о товаре <b>%s</b> успешно отправлен, мы ответим на него в самое ближайшее время.');
define('THX_SUCCESSFUL_SENT','Спасибо большое!');
define('TEXT_MESSAGE_ERROR','Вы не заполнили поле Ваш вопрос.');

define('NAVBAR_TITLE_MAINTENANCE','Тех. обслуживание');

define('TABLE_HEADING_FAQ', 'Последние вопросы');
define('NAVBAR_TITLE_FAQ', 'Вопросы и ответы');
define('TEXT_DISPLAY_NUMBER_OF_FAQ', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всего <span class="bold">%d</span> вопросов)');
define('TEXT_NO_FAQ', 'Нет вопросов.');

require_once(DIR_WS_LANGUAGES . $_SESSION['language'].'/'.'affiliate_' . $_SESSION['language'] .'.php');

define('ENTRY_EXTRA_FIELDS_ERROR', 'Поле %s должно содержать как минимум %d символов');
define('CATEGORY_EXTRA_FIELDS', 'Дополнительная информация');

define('TEXT_RSS_NEWS','Новости');
define('TEXT_RSS_ARTICLES','Статьи');
define('TEXT_RSS_CATEGORIES','Категории');
define('TEXT_RSS_NEW_PRODUCTS','Новинки');
define('TEXT_RSS_FEATURED_PRODUCTS','Рекомендуемые товары');
define('TEXT_RSS_BEST_SELLERS','Лидеры продаж');

define('TEXT_CHECKOUT_ALTERNATIVE', 'Оформление заказа');

define('TEXT_PRODUCT_COMPARE','Сравнить');
define('TEXT_PRODUCT_FILTER','Фильтровать');

define('TXT_FREE','бесплатно');

define('PRODUCTS_ORDER_QTY_MIN_TEXT_INFO','Минимум единиц для заказа: ');define('PRODUCTS_ORDER_QTY_MAX_TEXT_INFO','Максимум единиц для заказа: ');

define('WARNING_VAMSHOP_KEY', 'Незарегистрированная копия VamShop. Зарегистрируйте Вашу копию по адресу <a href="https://vamshop.ru/key.php" target="_blank">https://vamshop.ru/key.php</a>');
define('WARNING_VAMSHOP_DEMO', 'Демонстрационная версия VamShop. Оформите заказ на полноценную, неограниченнцю версию VamShop с технической поддержкой и обновлениями в официальном магазине <a href="https://vamshop.ru/vamshop.html" target="_blank">https://vamshop.ru/vamshop.html</a>');

define('text_zero', 'ноль');
define('text_three', 'три');
define('text_four', 'четыре');
define('text_five', 'пять');
define('text_six', 'шесть');
define('text_seven', 'семь');
define('text_eight', 'восемь');
define('text_nine', 'девять');
define('text_ten', 'десять');
define('text_eleven', 'одиннадцать');
define('text_twelve', 'двенадцать');
define('text_thirteen', 'тринадцать');
define('text_fourteen', 'четырнадцать');
define('text_fifteen', 'пятнадцать');
define('text_sixteen', 'шестнадцать');
define('text_seventeen', 'семнадцать');
define('text_eighteen', 'восемнадцать');
define('text_nineteen', 'девятнадцать');
define('text_twenty', 'двадцать');
define('text_thirty', 'тридцать');
define('text_forty', 'сорок');
define('text_fifty', 'пятьдесят');
define('text_sixty', 'шестьдесят');
define('text_seventy', 'семьдесят');
define('text_eighty', 'восемьдесят');
define('text_ninety', 'девяносто');
define('text_hundred', 'сто');
define('text_two_hundred', 'двести');
define('text_three_hundred', 'триста');
define('text_four_hundred', 'четыреста');
define('text_five_hundred', 'пятьсот');
define('text_six_hundred', 'шестьсот');
define('text_seven_hundred', 'семьсот');
define('text_eight_hundred', 'восемьсот');
define('text_nine_hundred', 'девятьсот');
define('text_penny', 'копейки');
define('text_kopecks', 'копеек');
define('text_single_kopek', 'одна копейка');
define('text_two_penny', 'две копейки');
define('text_ruble', 'рубля');
define('text_rubles', 'рублей');
define('text_one_ruble', 'один рубль');
define('text_two_rubles', 'два рубля');
define('text_thousands', 'тысячи');
define('text_thousand', 'тысяч');
define('text_one_thousand', 'одна тысяча');
define('text_two_thousand', 'две тысячи');
define('text_million', 'миллиона');
define('text_millions', 'миллионов');
define('text_one_million', 'один миллион');
define('text_two_million', 'два миллиона');
define('text_billion', 'миллиарда');
define('text_billions', 'миллиардов');
define('text_one_billion', 'один миллиард');
define('text_two_billion', 'два миллиарда');
define('text_trillion', 'триллиона');
define('text_trillions', 'триллионов');
define('text_one_trillion', 'один триллион');
define('text_two_trillion', 'два триллиона');

define('PIN_NOT_AVAILABLE', 'Товар закончился на складе. Отправлено уведомление на почту.');

// Start Products Specifications
// Products Filter box text in includes/boxes/products_filter.php
define('BOX_HEADING_PRODUCTS_FILTER', 'Фильтры');
define('TEXT_SHOW_ALL', 'Показать все');
define('TEXT_FIND_PRODUCTS', 'Найти подходящие товары');
// End Products Specifications

// Products Specifications
define('TEXT_NOT_AVAILABLE', 'нет данных');

define('FREE_SHIPPING_TITLE', 'Бесплатная доставка');

define('BUTTON_PRINT_SCHET', 'Распечатать счёт');
define('BUTTON_PRINT_PACKINGSLIP', 'Распечатать накладную');
define('BUTTON_PRINT_KVITANCIA', 'Распечатать квитанцию');

define('TEXT_NO_PRODUCTS_AVAILABLE', 'Товары для сравнения не найдены.');
define('TEXT_NO_COMPARISON_AVAILABLE', 'Администратором не были заданы спецификации товара для сравнения. <a href="http://vamshop.ru/manual/ch06.html" target="_blank">Настройка спецификаций</a>.');
define('TEXT_COMPARE','Сравнение товара');

define('TEXT_BUY_BUTTON', 'Купить');

define('TEXT_BEST_BUY', 'успей купить!');
define('TEXT_BEST_BUY_UP', 'Успей купить!');
define('TEXT_READ_MORE', 'подробнее');
define('TEXT_READ_MORE_UP', 'Подробнее');
define('TEXT_VIEW_PRODUCTS', 'смотреть товары');
define('TEXT_VIEW_PRODUCTS_UP', 'Смотреть товары');
define('TEXT_VIEW_PRODUCTS_GO', 'Далее');

define('TEXT_PRODUCT_DESCRIPTION', 'Описание');
define('TEXT_PRODUCT_REVIEWS', 'Отзывы');
define('NAVBAR_TITLE_SITE_REVIEW', 'Отзыв');
define('NAVBAR_TITLE_SITE_REVIEWS','Отзывы о магазине');
define('TEXT_PAGE_PRODUCT_REVIEWS', 'Отзывы');
define('TEXT_PRODUCT_QTY', 'Количество:');

define('TEXT_PAGE_IN_CAT', 'Страница');

define('TEXT_TOTAL_REVIEWS', 'Отзывы');
define('TEXT_REVIEWS_RATING', 'Рейтинг');

define('TEXT_CHECKOUT_PROCESS_PAYMENT', 'Оплатить заказ');

define('TEXT_MY_ORDERS', 'Мои заказы');
define('TEXT_MY_PROFILE', 'Профиль');
define('TEXT_MY_ACCOUNT', 'Аккаунт');
define('TEXT_BACK', 'Вернуться');

define('PRIVACY_TEXT','Нажимая кнопку, я даю согласие на обработку своих персональных данных. <a href="privacy.html">Подробнее о защите персональной информации.</a>');

//BOF Bundled Products

define('TEXT_PRODUCTS_BY_BUNDLE', 'Данный набор включает в себя следующие товары:');
define('TEXT_RATE_COSTS', 'Стоимость товаров по отдельности:');
define('TEXT_IT_SAVE', 'Вы экономите');
define('TEXT_SOLD_IN_BUNDLE', 'Данный товар может будет куплен только в следующем комплекте:');

define('IMAGE_BUTTON_OUT_OF_STOCK', 'Нет на складе');
define('TEXT_BUNDLE_ONLY', 'Не продаётся отдельно');
//EOF Bundled Products

define('TEXT_POPUP_CART_ADD','Товар добавлен в корзину!');
define('TEXT_POPUP_CART_CONTINUE','Продолжить покупки');
define('TEXT_POPUP_CART_CART', 'Перейти в корзину');
define('TEXT_POPUP_CART_CHECKOUT', 'Оформить заказ');

define('TITLE_DEFAULT_PAGE', 'Главная');
define('TITLE_SPECIALS_DEFAULT', 'Скидки');
define('TITLE_MANUFACTURERS_DEFAULT', 'Бренды');
define('TITLE_BEST_SELLERS_DEFAULT', 'Популярные товары');
define('TITLE_NEW_PRODUCTS_DEFAULT', 'Новинки');
define('TITLE_FEATURED_DEFAULT', 'Рекомендуемые товары');
define('TITLE_FEATURED_DEFAULT_SHORT', 'Рекомендуемые');
define('TITLE_SPECIALS_DEFAULT', 'Скидки');

define('TEXT_NOT_FOUND', 'Не найдено.');

define('TEXT_SOCIAL_LOGIN', 'Войти через');
define('TEXT_SOCIAL_LOGIN_GOOGLE', 'Google');
define('TEXT_SOCIAL_LOGIN_FACEBOOK', 'Facebook');
define('TEXT_SOCIAL_LOGIN_VK', 'ВКонтакте');

define('TEXT_PRODUCT_SHIPPING', 'Доставка');
define('TEXT_PRODUCT_PAYMENT', 'Оплата');

define('TEXT_CITY', 'Город');
define('TEXT_CITY_LOCATION', 'Ваш город');
define('TEXT_CITY_NAME', 'Город');
define('TEXT_CITY_CLOSE', 'Закрыть');
define('TEXT_CITY_SAVE', 'Сохранить');

define('TEXT_ALERT_COOKIE', 'Мы используем файлы cookie для обеспечения работоспособности и улучшения качества обслуживания, используя наш сайт вы соглашаетесь с использованием файлов cookie.');
define('TEXT_COOKIE_CLOSE', 'Закрыть');
define('TEXT_COOKIE_OK', 'Разрешаю');

define('TEXT_SELECT_OPTIONS','Выбрать опции');

define('TEXT_TAGS','Тэги');

define('TEXT_AUTHOR_COMMENTS','Отзывы об авторе');
define('TEXT_AUTHOR_RATING','Рейтинг автора');
define('TEXT_ARTICLE_COMMENTS','Отзывы о статье');
define('TEXT_ARTICLE_RATING','Рейтинг статьи');
define('TEXT_ARTICLE_REVIEWS_READ','читать все отзывы о статье');
define('TEXT_ARTICLE_REVIEWS_ADD','добавить отзыв о статье');
define('TEXT_AUTHOR_REVIEWS_READ','читать все отзывы об авторе');
define('TEXT_AUTHOR_REVIEWS_ADD','добавить отзыв об авторе');

define('VOICE_SEARCH','Голосовой поиск');

define('TEXT_BADGE_CUSTOMER','Реальный покупатель');

define('ENTRY_REMEMBER_ME', 'Запомнить');

define('TEXT_LIKE', 'Нравится');
define('TEXT_DISLIKE', 'Не нравится');

define('TEXT_READ_REVIEW', 'Читать отзыв');

define('TEXT_BUTTON_SUBMIT', 'Применить');
define('TEXT_PRODUCTS_IN_CART', 'Товаров в корзине');
define('TEXT_PRODUCTS_TOTAL', 'Всего товаров');
define('TEXT_PIECE', 'шт.');

define('TEXT_CUSTOMER_REVIEW', 'Отзыв покупателя:');
define('TEXT_STORE_ANSWER', 'Ответ магазина:');

define('ONE_CLICK_BUY_NAVBAR_TITLE','Купить в 1 клик');
define('ONE_CLICK_BUY_TEXT_EMAIL_SUCCESSFUL_SENT','Ваш заказ <b>%s</b> успешно оформлен, мы свяжемся с Вами в самое ближайшее время.');
define('ONE_CLICK_BUY_THX_SUCCESSFUL_SENT','Спасибо большое!');
define('ONE_CLICK_BUY_TEXT_MESSAGE_ERROR','Вы не заполнили поле комментарий.');

define('TEXT_OUT_OF_STOCK','Нет в наличии');

define('TEXT_ALL_NEW_PRODUCTS','Все новинки');
define('TEXT_ALL_SPECIAL_PRODUCTS','Все скидки');
define('TEXT_ALL_BEST_SELLERS','Все популярные товары');
define('TEXT_ALL_FEATURED_PRODUCTS','Все рекомендуемые');
define('TEXT_ALL_REVIEWS','Все отзывы');
define('TEXT_ALL_SITE_REVIEWS','Все отзывы о магазине');
define('TEXT_ALL_NEWS','Все новости');
define('TEXT_ALL_ARTICLES','Все статьи');

?>
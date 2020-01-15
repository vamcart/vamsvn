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
define('HEADER_TITLE_TOP', 'Початок');     
define('HEADER_TITLE_CATALOG', 'Каталог');

define('HTML_PARAMS','xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru"');

@setlocale(LC_TIME, 'en_US');

define('DATE_FORMAT_SHORT', '%d.%m.%Y');  // this is used for strftime()
define('DATE_FORMAT_LONG', '%A, %d %B %Y'); // this is used for strftime()
define('DATE_FORMAT', 'd.m.Y');  // this is used for strftime()
define('DATE_TIME_FORMAT', DATE_FORMAT_SHORT . ' %H:%M:%S');
define('DOB_FORMAT_STRING', 'dd.mm.jjjj');

// if USE_DEFAULT_LANGUAGE_CURRENCY is true, use the following currency, instead of the applications default currency (used when changing language)
define('LANGUAGE_CURRENCY', 'UAH');

define('MALE', 'шановний');
define('FEMALE', 'шановна');

/*
 *
 *  BOXES
 *
 */

// text for gift voucher redeeming
define('IMAGE_REDEEM_GIFT', 'Використати');

define('BOX_TITLE_STATISTICS', 'Статистика:');
define('BOX_ENTRY_CUSTOMERS', 'Клієнти');
define('BOX_ENTRY_PRODUCTS', 'Товари');
define('BOX_ENTRY_REVIEWS', 'Відгуки');
define('TEXT_VALIDATING', 'не підтверджено');

// manufacturer box text
define('BOX_MANUFACTURER_INFO_HOMEPAGE', 'Офіційний сайт %s');
define('BOX_MANUFACTURER_INFO_OTHER_PRODUCTS', 'Інші товари даного виробника');

define('BOX_HEADING_ADD_PRODUCT_ID','Додати в кошик');
  
define('BOX_LOGINBOX_STATUS','Група:');     
define('BOX_LOGINBOX_DISCOUNT','Ваша снижка');
define('BOX_LOGINBOX_DISCOUNT_TEXT','Знижка від суми замовлення');
define('BOX_LOGINBOX_DISCOUNT_OT','');

// reviews box text in includes/boxes/reviews.php
define('BOX_REVIEWS_WRITE_REVIEW', 'Оставить отзыв!');
define('BOX_REVIEWS_TEXT_OF_5_STARS', '%s из 5 звёзд!');

// pull down default text
define('PULL_DOWN_DEFAULT', 'Виберіть');

// javascript messages
define('JS_ERROR', 'Чи не вказана необхідна інформація! \nБудь ласка, виправте допущені помилки. \n \n');

define('JS_REVIEW_TEXT', '* Поле Текст відгуку має містити не менше'. REVIEW_TEXT_MIN_LENGTH. 'символів. \n');
define('JS_REVIEW_RATING', '* Ви не вказали рейтинг. \n');
define('JS_REVIEW_CAPTCHA', '* Ви не вказали код з зображення. \n');
define('JS_ERROR_NO_PAYMENT_MODULE_SELECTED', '* Виберіть спосіб оплати для Вашого замовлення. \n');
define('JS_ERROR_SUBMITTED', 'Ця форма вже заповнена. Натискайте Ok.');
define('ERROR_NO_PAYMENT_MODULE_SELECTED', '* Виберіть спосіб оплати для Вашого замовлення.');
/*
 *
 * ACCOUNT FORMS
 *
 */

define('ENTRY_COMPANY_ERROR', '');
define('ENTRY_COMPANY_TEXT', '');
define('ENTRY_GENDER_ERROR', 'Ви повинні вказати свою стать.');
define('ENTRY_GENDER_TEXT', '*');
define('ENTRY_FIRST_NAME_ERROR', 'Поле Ім\'я повинно містити як мінімум'. ENTRY_FIRST_NAME_MIN_LENGTH. 'символів.');
define('ENTRY_FIRST_NAME_TEXT', '*');
define('ENTRY_SECOND_NAME_TEXT', '');
define('ENTRY_LAST_NAME_ERROR', 'Поле Прізвище повинно містити як мінімум'. ENTRY_LAST_NAME_MIN_LENGTH. 'символів.');
define('ENTRY_LAST_NAME_TEXT', '*');
define('ENTRY_DATE_OF_BIRTH_ERROR', 'Дату народження необхідно вводити в такому форматі: DD / MM / YYYY (приклад 21/05/1970)');
define('ENTRY_DATE_OF_BIRTH_TEXT', '* (приклад 21/05/1970)');
define('ENTRY_EMAIL_ADDRESS_ERROR', 'Поле E-Mail має правильно заповнено і містити як мінімум'. ENTRY_EMAIL_ADDRESS_MIN_LENGTH. 'символів.');
define('ENTRY_EMAIL_ADDRESS_CHECK_ERROR', 'Ваша E-Mail адреса вказана невірно, спробуйте ще раз.');
define('ENTRY_EMAIL_ADDRESS_ERROR_EXISTS', 'Ваша E-Mail адреса вже зареєстрова в нашому магазині, спробуйте вказати іншу E-Mail адресу.');
define('ENTRY_EMAIL_ADDRESS_TEXT', '*');
define('ENTRY_STREET_ADDRESS_ERROR', 'Поле Вулиця та номер будинку повинно містити як мінімум'. ENTRY_STREET_ADDRESS_MIN_LENGTH. 'символів.');
define('ENTRY_STREET_ADDRESS_TEXT', '* Приклад: вул. Незалежності 346, кв. 78');
define('ENTRY_SUBURB_TEXT', '');
define('ENTRY_POST_CODE_ERROR', 'Поле Поштовий індекс має містити як мінімум'. ENTRY_POSTCODE_MIN_LENGTH. 'символів.');
define('ENTRY_POST_CODE_TEXT', '*');
define('ENTRY_CITY_ERROR', 'Поле Місто повинно містити як мінімум'. ENTRY_CITY_MIN_LENGTH. 'символів.');
define('ENTRY_CITY_TEXT', '*');
define('ENTRY_STATE_ERROR', 'Поле Регіон має містити як мінімум'. ENTRY_STATE_MIN_LENGTH. 'символів.');
define('ENTRY_STATE_ERROR_SELECT', 'Вкажіть регіон.');
define('ENTRY_STATE_TEXT', '*');
define('ENTRY_COUNTRY_ERROR', 'Вкажіть країну.');
define('ENTRY_COUNTRY_TEXT', '*');
define('ENTRY_TELEPHONE_NUMBER_ERROR', 'Поле Телефон має містити як мінімум'. ENTRY_TELEPHONE_MIN_LENGTH. 'символів.');
define('ENTRY_TELEPHONE_NUMBER_TEXT', '*');
define('ENTRY_FAX_NUMBER_TEXT', '');
define('ENTRY_NEWSLETTER_TEXT', '');
define('ENTRY_PASSWORD_ERROR', 'Ваш пароль повинен містити як мінімум'. ENTRY_PASSWORD_MIN_LENGTH. 'символів.');
define('ENTRY_PASSWORD_ERROR_NOT_MATCHING', 'Поле Підтвердіть пароль має збігатися з полем Пароль.');
define('ENTRY_PASSWORD_TEXT', '*');
define('ENTRY_PASSWORD_CONFIRMATION_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_TEXT', '*');
define('ENTRY_PASSWORD_CURRENT_ERROR', 'Поле Пароль має містити як мінімум'. ENTRY_PASSWORD_MIN_LENGTH. 'символів.');
define('ENTRY_PASSWORD_NEW_TEXT', '*');
define('ENTRY_PASSWORD_NEW_ERROR', 'Ваш Новий пароль повинен містити як мінімум'. ENTRY_PASSWORD_MIN_LENGTH. 'символів.');
define('ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING', 'Поля Підтвердіть пароль і Новий пароль повинні збігатися.');
/*
 *
 *  RESTULTPAGES
 *
 */

define('TEXT_RESULT_PAGE', 'Сторінки:');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всього позицій: <span class="bold">%d</span>) ');
define('TEXT_DISPLAY_NUMBER_OF_ORDERS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всього замовлень: <span class="bold">%d</span>) ');
define('TEXT_DISPLAY_NUMBER_OF_REVIEWS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всього відгуків: <span class="bold">%d</span>) ');
define('TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всього новинок: <span class="bold">%d</span>) ');
define('TEXT_DISPLAY_NUMBER_OF_SPECIALS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всього спеціальних пропозицій: <span class="bold">%d</span>) ');
define('TEXT_DISPLAY_NUMBER_OF_FEATURED', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всього рекомендованих товарів: <span class="bold">%d</span>) ');
define('TEXT_DISPLAY_NUMBER_OF_MANUFACTURERS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всього брендів: <span class="bold">%d</span>) ');
define('TEXT_DISPLAY_NUMBER_OF_BEST_SELLERS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всього популярних товарів: <span class="bold">%d</span>) ');

/*
 *
 * SITE NAVIGATION
 *
 */

define('PREVNEXT_TITLE_PREVIOUS_PAGE', 'попередня сторінка');
define('PREVNEXT_TITLE_NEXT_PAGE', 'Наступна сторінка');
define('PREVNEXT_TITLE_PAGE_NO', 'Сторінка% d');
define('PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE', 'Попередні% d сторінок');
define('PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE', 'Наступні% d сторінок');

/*
 *
 * PRODUCT NAVIGATION
 *
 */

define('PREVNEXT_BUTTON_PREV', 'Попередня');
define('PREVNEXT_BUTTON_NEXT', 'Наступна');

/*
 *
 * IMAGE BUTTONS
 *
 */

define('IMAGE_BUTTON_ADD_ADDRESS', 'Додати адресу');
define('IMAGE_BUTTON_BACK', 'Назад');
define('IMAGE_BUTTON_CHANGE_ADDRESS', 'Змінити адресу');
define('IMAGE_BUTTON_CHECKOUT', 'Оформити замовлення');
define('IMAGE_BUTTON_CONFIRM_ORDER', 'Підтвердити Замовлення');
define('IMAGE_BUTTON_CONTINUE', 'Продовжити');
define('IMAGE_BUTTON_DELETE', 'Видалити');
define('IMAGE_BUTTON_LOGIN', 'Продовжити');
define('IMAGE_BUTTON_IN_CART', 'Додати в кошик');
define('IMAGE_BUTTON_SEARCH', 'Шукати');
define('IMAGE_BUTTON_UPDATE', 'Оновити');
define('IMAGE_BUTTON_UPDATE_CART', 'Перерахувати');
define('IMAGE_BUTTON_WRITE_REVIEW', 'Написати відгук');
define('IMAGE_BUTTON_ADMIN', 'Адаменко');
define('IMAGE_BUTTON_PRODUCT_EDIT', 'Редагувати товари');
define('IMAGE_BUTTON_ARTICLE_EDIT', 'Редагувати статтю');

define('SMALL_IMAGE_BUTTON_DELETE', 'Видалити');
define('SMALL_IMAGE_BUTTON_EDIT', 'Змінити');
define('SMALL_IMAGE_BUTTON_VIEW', 'Дивитися');

define('ICON_ARROW_RIGHT', 'Перейти');
define('ICON_CART', 'В кошик');
define('ICON_SUCCESS', 'Виконано');
define('ICON_WARNING', 'Увага');
/*
 *
 *  GREETINGS
 *
 */

define('TEXT_GREETING_PERSONAL', 'Ласкаво просимо, <span class="greetUser">%s! </span> Ви хочете подивитися які <a href="%s"> нові товари </a> надійшли в наш магазин?' );
define('TEXT_GREETING_PERSONAL_RELOGON', '<small> Якщо Ви не %s, будь ласка, <a href="%s"> введіть </a> свої дані для входу. </ small>');
define('TEXT_GREETING_GUEST', 'Ласкаво просимо, <span class="greetUser"> шановний відвідувач </span> <br /> Якщо Ви наш постійний клієнт, <a href="%s"> введіть Ваші персональні дані </a> для входу. Якщо Ви у нас вперше і хочете зробити покупки, Вам необхідно <a href="%s"> зареєструватися </a>. ');

define('TEXT_SORT_PRODUCTS', 'Сортувати товар за');
define('TEXT_DESCENDINGLY', 'спаданням');
define('TEXT_ASCENDINGLY', 'зростанням');
define('TEXT_BY', 'за');

define('TEXT_REVIEW_BY', '- %s');
define('TEXT_REVIEW_WORD_COUNT', '%s слів');
define('TEXT_REVIEW_RATING', 'Рейтинг:%s [%s]');
define('TEXT_REVIEW_DATE_ADDED', 'Відгук доданий:%s');
define('TEXT_NO_REVIEWS', 'До теперішнього часу немає відгуків.');
define('TEXT_NO_NEW_PRODUCTS', 'На даний момент немає нових товарів.');
define('TEXT_UNKNOWN_TAX_RATE', 'Невідома податкова ставка');

/*
 *
 * WARNINGS
 *
 */

define('WARNING_INSTALL_DIRECTORY_EXISTS', 'Попередження: Не видалена директорія установки магазину:'. dirname($_SERVER['SCRIPT_FILENAME']). '/ install. Будь ласка, видаліть цю директорію з метою безпеки.');
define('WARNING_CONFIG_FILE_WRITEABLE', 'Попередження: Файл конфігурації доступний для запису:'. dirname($_SERVER['SCRIPT_FILENAME']). '/includes/configure.php. Це - потенційний ризик безпеки - будь ласка, встановіть необхідні права доступу до цього дозвіл. ');
define('WARNING_SESSION_DIRECTORY_NON_EXISTENT', 'Попередження: директорія сесій не існує:'. vam_session_save_path (). '. Сесії не працюватимуть поки ця директорія не буде створена.');
define('WARNING_SESSION_DIRECTORY_NOT_WRITEABLE', 'Попередження: Не вдається скористатися послугами директорії сесій:'. vam_session_save_path (). '. Сесії не працюватимуть поки не встановлені необхідні права доступу.');
define('WARNING_SESSION_AUTO_START', 'Попередження: опція session.auto_start включена - будь ласка, вимкніть цю опцію у файлі php.ini і перезапустити веб-сервер.');
define('WARNING_DOWNLOAD_DIRECTORY_NON_EXISTENT', 'Попередження: Директорія відсутня:'. DIR_FS_DOWNLOAD. '. Створіть директорію.');

define('SUCCESS_ACCOUNT_UPDATED', 'Ваші дані оновлені!');
define('SUCCESS_PASSWORD_UPDATED', 'Ваш пароль змінено!');
define('ERROR_CURRENT_PASSWORD_NOT_MATCHING', 'Зазначений пароль не збігається з поточним паролем. Спробуйте ще раз.');
define('TEXT_MAXIMUM_ENTRIES', '<span class="bold"> ЗАУВАЖЕННЯ: </span> Максимальний об\'єм адресної книги - <span class="bold">%s</span> записів');
define('SUCCESS_ADDRESS_BOOK_ENTRY_DELETED', 'Обраний адреса видалений з адресної книги.');
define('SUCCESS_ADDRESS_BOOK_ENTRY_UPDATED', 'Ваша адресна книга була поновлена.');
define('WARNING_PRIMARY_ADDRESS_DELETION', 'Адреса, встановлений за замовчуванням, не може бути видалений. Встановіть статус за замовчуванням на іншу адресу і спробуйте ще раз.');
define('ERROR_NONEXISTING_ADDRESS_BOOK_ENTRY', 'Адресна книга не знайдена.');
define('ERROR_ADDRESS_BOOK_FULL', 'Ваша адресна книга повністю заповнена. Видаліть непотрібний Вам адресу і тільки після цього Ви зможете додати нову адресу.');

//  conditions check

define('ERROR_CONDITIONS_NOT_ACCEPTED', 'Ми не зможемо прийняти Ваше замовлення поки Ви не погодитеся з умовами!');

define('SUB_TITLE_OT_DISCOUNT', 'Знижка:');

define('TAX_ADD_TAX', 'Включаючи');
define('TAX_NO_TAX', 'Плюс');

define('NOT_ALLOWED_TO_SEE_PRICES', 'У Вас немає доступу для перегляду цін');
define('NOT_ALLOWED_TO_SEE_PRICES_TEXT', 'У Вас немає доступу для перегляду цін, будь ласка, зареєструйтесь.');

define('TEXT_DOWNLOAD', 'Завантаження');
define('TEXT_VIEW', 'Дивитися');

define('TEXT_BUY', 'Купити \' ');
define('TEXT_NOW', '\' ');
define('TEXT_GUEST', 'Відвідувач');
/*
 *
 * ADVANCED SEARCH
 *
 */

define('TEXT_ALL_CATEGORIES', 'Всі категорії');
define('TEXT_ALL_MANUFACTURERS', 'Всі виробники');
define('JS_AT_LEAST_ONE_INPUT', '* Одне з полів має бути заповнено: \n Ключові слова \n Дата додавання від: \n Дата додавання до: \n Ціна від \n Ціна до \n');
define('AT_LEAST_ONE_INPUT', 'Одне з полів має бути заповнено: <br /> Ключові слова як мінімум 3 символу <br /> Ціна від <br /> Ціна до <br />');
define('JS_INVALID_FROM_DATE', '* Дата вказана в невірному форматі \n');
define('JS_INVALID_TO_DATE', '* Неправильна дата додавання до \n');
define('JS_TO_DATE_LESS_THAN_FROM_DATE', '* Дата до повинна бути більше дати від \n');
define('JS_PRICE_FROM_MUST_BE_NUM', '* Ціна від повинна бути номером \n');
define('JS_PRICE_TO_MUST_BE_NUM', '* Ціна до повинна бути номером \n');
define('JS_PRICE_TO_LESS_THAN_PRICE_FROM', '* Ціна до повинна бути більшою за ціну від. \n');
define('JS_INVALID_KEYWORDS', '* Невірні ключові слова \n');
define('TEXT_LOGIN_ERROR', '<span class="bold"> ПОМИЛКА: </span> Зазначений E-Mail і/або пароль невірний.');
define('TEXT_NO_EMAIL_ADDRESS_FOUND', '<span class="bold"> ПОПЕРЕДЖЕННЯ: </span> Зазначена E-Mail адреса не знайдена. Спробуйте ще раз.');
define('TEXT_PASSWORD_SENT', 'Новий пароль був відправлений на E-Mail.');
define('TEXT_PRODUCT_NOT_FOUND', 'Товар не знайден!');
define('TEXT_MORE_INFORMATION', 'Для отримання додаткової інформації відвідайте <a href="%s" onclick="window.open(this.href); return false;"> сайт </a> товару.');

define('TEXT_DATE_ADDED', 'Товар був доданий в наш каталог %s');
define('TEXT_DATE_AVAILABLE', 'Товар буде в наявності %s');
define('SUB_TITLE_SUB_TOTAL', 'Вартість товару:');

define('OUT_OF_STOCK_CANT_CHECKOUT', 'Товари, виділені'. STOCK_MARK_PRODUCT_OUT_OF_STOCK. 'є на нашому складі в недостатньому для Вашого замовлення кількості. <br /> Будь ласка, поміняйте кількість продуктів виділених ('. STOCK_MARK_PRODUCT_OUT_OF_STOCK. '), дякуємо Вам.');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'Товари, виділені'. STOCK_MARK_PRODUCT_OUT_OF_STOCK. 'є на нашому складі в недостатньому для Вашого замовлення кількості. <br /> Проте, Ви можете оформити замовлення для поетапної доставки замовленого товару.');

define('MINIMUM_ORDER_VALUE_NOT_REACHED_1', 'Мінімальна сума замовлення повинна бути:');
define('MINIMUM_ORDER_VALUE_NOT_REACHED_2', '<br /> Збільште Ваше замовлення як мінімум на:');
define('MAXIMUM_ORDER_VALUE_REACHED_1', 'Ви перевищили максимально дозволену суму замовлення, встановлену в:');
define('MAXIMUM_ORDER_VALUE_REACHED_2', '<br /> Зменшіть Ваше замовлення як мінімум на:');
define('ERROR_INVALID_PRODUCT', 'Товар не знайден!');

/*
 *
 * NAVBAR Titel
 *
 */

define('NAVBAR_TITLE_ACCOUNT', 'Ваші дані');
define('NAVBAR_TITLE_1_ACCOUNT_EDIT', 'Ваші дані');
define('NAVBAR_TITLE_2_ACCOUNT_EDIT', 'Редагування даних');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY', 'Ваші дані');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY', 'Ваші замовлення');
define('NAVBAR_TITLE_1_ACCOUNT_HISTORY_INFO', 'Ваші дані');
define('NAVBAR_TITLE_2_ACCOUNT_HISTORY_INFO', 'Оформлені замовлення');
define('NAVBAR_TITLE_3_ACCOUNT_HISTORY_INFO', 'Замовлення номер %s');
define('NAVBAR_TITLE_1_ACCOUNT_PASSWORD', 'Ваші дані');
define('NAVBAR_TITLE_2_ACCOUNT_PASSWORD', 'Змінити пароль');
define('NAVBAR_TITLE_1_ADDRESS_BOOK', 'Ваші дані');
define('NAVBAR_TITLE_2_ADDRESS_BOOK', 'Адресна книга');
define('NAVBAR_TITLE_1_ADDRESS_BOOK_PROCESS', 'Ваші дані');
define('NAVBAR_TITLE_2_ADDRESS_BOOK_PROCESS', 'Адресна книга');
define('NAVBAR_TITLE_ADD_ENTRY_ADDRESS_BOOK_PROCESS', 'Додати запис');
define('NAVBAR_TITLE_MODIFY_ENTRY_ADDRESS_BOOK_PROCESS', 'Змінити запис');
define('NAVBAR_TITLE_DELETE_ENTRY_ADDRESS_BOOK_PROCESS', 'Видалити запис');
define('NAVBAR_TITLE_ADVANCED_SEARCH', 'Розширений пошук');
define('NAVBAR_TITLE1_ADVANCED_SEARCH', 'Розширений пошук');
define('NAVBAR_TITLE2_ADVANCED_SEARCH', 'Результати пошуку');
define('NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION', 'Оформлення замовлення');
define('NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION', 'Підтвердження');
define('NAVBAR_TITLE_1_CHECKOUT_PAYMENT', 'Оформлення замовлення');
define('NAVBAR_TITLE_2_CHECKOUT_PAYMENT', 'Спосіб оплати');
define('NAVBAR_TITLE_1_PAYMENT_ADDRESS', 'Оформлення замовлення');
define('NAVBAR_TITLE_2_PAYMENT_ADDRESS', 'Змінити адресу покупця');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING', 'Оформлення замовлення');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING', 'Спосіб доставки');
define('NAVBAR_TITLE_1_CHECKOUT_SHIPPING_ADDRESS', 'Оформлення замовлення');
define('NAVBAR_TITLE_2_CHECKOUT_SHIPPING_ADDRESS', 'Змінити адресу доставки');
define('NAVBAR_TITLE_1_CHECKOUT_SUCCESS', 'Оформлення замовлення');
define('NAVBAR_TITLE_2_CHECKOUT_SUCCESS', 'Замовлення успішно оформлений');
define('NAVBAR_TITLE_CREATE_ACCOUNT', 'Реєстрація');
define('NAVBAR_TITLE_LOGIN', 'Вхід');
define('NAVBAR_TITLE_LOGOFF', 'Вихід');
define('NAVBAR_TITLE_PRODUCTS_NEW', 'Нові товари');
define('NAVBAR_TITLE_SHOPPING_CART', 'Кошик');
define('NAVBAR_TITLE_SPECIALS', 'Знижки');
define('NAVBAR_TITLE_FEATURED', 'Рекомендовані товари');
define('NAVBAR_TITLE_COOKIE_USAGE', 'Помилка cookies');
define('NAVBAR_TITLE_PRODUCT_REVIEWS', 'Відгуки');
define('NAVBAR_TITLE_REVIEWS_WRITE', 'Написати відгук');
define('NAVBAR_TITLE_REVIEWS', 'Відгуки');
define('NAVBAR_TITLE_SSL_CHECK', 'Безпечний режим');
define('NAVBAR_TITLE_CREATE_GUEST_ACCOUNT', 'Реєстрація');
define('NAVBAR_TITLE_PASSWORD_DOUBLE_OPT', 'Забули пароль?');
define('NAVBAR_TITLE_NEWSLETTER', 'Розсилка');
define('NAVBAR_GV_REDEEM', 'Використати сертифікат');
define('NAVBAR_GV_SEND', 'Відправити сертифікат');
/*
 *
 *  MISC
 *
 */

define('TEXT_NEWSLETTER', 'Хочете дізнаватися про новинки першим? <br /> Підпишіться на наші новини і Ви першим дізнаєтеся про всі зміни і новинки.');
define('TEXT_EMAIL_INPUT', 'Ваш E-Mail адреса був успішно зареєстрований в нашій системі. <br /> Вам було відправлено лист з персональної посиланням на підтвердження. Будь ласка, перейдіть за посиланням, вказаної в листі. В іншому випадку Ви не будете отримувати поштову розсилку! ');

define('TEXT_WRONG_CODE', 'Заповніть поля E-mail і Секретний код. <br /> Будь ласка, будьте уважні!');
define('TEXT_EMAIL_EXIST_NO_NEWSLETTER', 'Вказана E-Mail адреса зареєстрована, але не активована!');
define('TEXT_EMAIL_EXIST_NEWSLETTER', 'Вказана E-Mail адреса зареєстрована і активована!');
define('TEXT_EMAIL_NOT_EXIST', 'Вказана E-Mail адреса не зареєстрована!');
define('TEXT_EMAIL_DEL', 'Вказана E-Mail адреса успішно видалена.');
define('TEXT_EMAIL_DEL_ERROR', 'Помилка, E-Mail адреса не була видалена!');
define('TEXT_EMAIL_ACTIVE', 'Ваша E-Mail адреса була додана до списку розсилки!');
define('TEXT_EMAIL_ACTIVE_ERROR', 'Помилка, E-Mail адреса не був активована!');
define('TEXT_EMAIL_SUBJECT', 'Поштова розсилка');

define('TEXT_CUSTOMER_GUEST', 'Гість');

define('TEXT_LINK_MAIL_SENDED', 'Вам надіслано листа з персональної посиланням на підтвердження про відновлення пароля. <br /> Вам необхідно перейти за посиланням, зазначеної в листі. Після підтвердження запиту на відновлення пароля ми відправимо Вам новий пароль для входу в магазин. Якщо ви не перейдете за вказаним URL, новий пароль не буде відправлено! ');
define('TEXT_PASSWORD_MAIL_SENDED', 'Вам надіслано листа з новим паролем до Вашої персональної інформації. <br /> Будь ласка, не забудьте змінити Ваш новий пароль після першого входу в магазин.');
define('TEXT_CODE_ERROR', 'Ви ввели неправильний e-mail і / або напис на зображенні.');
define('TEXT_EMAIL_ERROR', 'Ви ввели неправильний e-mail і / або напис на зображенні.');
define('TEXT_NO_ACCOUNT', 'На жаль, запит-підтвердження на новий пароль невірний або застарів. Можливо, Ви активуєте старе посилання, в той час як була відправлена ​​новіше. Будь ласка, спробуйте ще раз.');

define('HEADING_PASSWORD_FORGOTTEN', 'Забули пароль?');
define('TEXT_PASSWORD_FORGOTTEN', 'Змініть пароль в три кроки.');
define('TEXT_EMAIL_PASSWORD_FORGOTTEN', 'Підтвердження E-Mail для відправки нового пароля');
define('TEXT_EMAIL_PASSWORD_NEW_PASSWORD', 'Ваш новий пароль');
define('ERROR_MAIL', 'Будь ласка, перевірте зазначені в формі дані');
define('CATEGORIE_NOT_FOUND', 'Категорія не знайдена');
define('GV_FAQ', 'Питання і відповіді за сертифікатами');
define('ERROR_NO_REDEEM_CODE', 'Ви не вказали код сертифіката');
define('ERROR_NO_INVALID_REDEEM_GV', 'Невірний код сертифіката');
define('TABLE_HEADING_CREDIT', 'Використовувати купон / сертифікат');
define('EMAIL_GV_TEXT_SUBJECT', 'Подарунок від %s');
define('MAIN_MESSAGE', 'Ви вирішили відправити сертифікат на суму %s своєму знайомому %s, його E-Mail адреса: %s <br /> <br /> Одержувач сертифікату отримає наступне повідомлення: <br /> <br /> Шановний %s <br /> <br />
                        Вам відправлений сертифікат на суму %s, відправник: %s ');
define('ERROR_REDEEMED_AMOUNT', 'Ваш сертифікат використаний');
define('REDEEMED_AMOUNT', 'Ваш подарочный сертификат успешно активирован. Сумма сертификата: ');
define('REDEEMED_COUPON', 'Ваш купон активований і буде використаний при оформленні замовлення.');

define('ERROR_INVALID_USES_USER_COUPON', 'Клієнт може використовувати тільки даний купон');
define('ERROR_INVALID_USES_COUPON', 'Покупці можуть використовувати даний купон');
define('TIMES', 'раз.');
define('ERROR_INVALID_STARTDATE_COUPON', 'Ваш купон ще недоступний.');
define('ERROR_INVALID_FINISDATE_COUPON', 'Ваш купон застарів.');
define('PERSONAL_MESSAGE', '%s пише:');
//Popup Window
define('TEXT_CLOSE_WINDOW', 'Закрити вікно.');

/*
 *
 * CUOPON POPUP
 *
 */

define('TEXT_COUPON_HELP_HEADER', 'Вітаємо, Ви використовували купон.');
define('TEXT_COUPON_HELP_NAME', '<br /> <br /> Назва купона: %s');
define('TEXT_COUPON_HELP_FIXED', '<br /> <br /> Купон надає знижку в розмірі %s');
define('TEXT_COUPON_HELP_MINORDER', '<br /> <br /> Замовлення повинен бути мінімум на суму %s щоб у Вас з\'явилася можливість використовувати купон');
define('TEXT_COUPON_HELP_FREESHIP', '<br /> <br /> Даний купон надає можливість безкоштовної доставки Вашого замовлення');
define('TEXT_COUPON_HELP_DESC', '<br /> <br /> Опис купона: %s');
define('TEXT_COUPON_HELP_DATE', '<br /> <br /> Даний купон дійсний з %s до %s');
define('TEXT_COUPON_HELP_RESTRICT', '<br /> <br /> Обмеження Товари / Категорії');
define('TEXT_COUPON_HELP_CATEGORIES', 'Категорія');
define('TEXT_COUPON_HELP_PRODUCTS', 'Товар');

// VAT ID
define('ENTRY_VAT_TEXT', '* тільки для Німеччини і країн Євросоюзу');
define('ENTRY_VAT_ERROR', 'Обраний VatID невірний! Вкажіть правильно ID або залиште дане поле порожнім.');
define('ONLY', 'все');
define('FROM', '');
define('YOU_SAVE', 'Ви економите');
define('INSTEAD', 'замість');
define('TXT_PER', 'за');
define('TAX_INFO_INCL', 'включаючи %s податок');
define('TAX_INFO_EXCL', 'виключаючи %s податок');
define('TAX_INFO_ADD', 'плюс %s податок');
define('SHIPPING_EXCL', '+');
define('SHIPPING_COSTS', 'доставка');
define('MSRP', '');
define('YOUR_PRICE', '');
define('YOUR_SPECIAL_PRICE', '');
define('YOUR_GRADUATED_PRICE', '');
define('RETAIL_PRICE', '');
define('GROUP_PRICE', 'Базова ціна групи');
define('MANUFACTURER_DISCOUNT', 'Особиста знижка на виробника');
define('PRODUCT_DISCOUNT', 'Знижка на товар');
define('PERSONAL_DISCOUNT', 'Ваша знижка');
// Сборка VaM

define('BOX_HEADING_SEARCH', 'Пошук');
define('ICON_ERROR', 'Помилка');

// RSS2 Info
define('NAVBAR_TITLE_RSS2_INFO','RSS канали');
define('TEXT_RSS2_INFO', '
<h3>Основні запити </h3>
Новини - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=news' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=news</a><br />
Статті - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=articles' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=articles</a><br />
Категорії - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=categories' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=categories</a><br />
Товари - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=products&amp;limit=10' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=products & amp; limit = 10</a><br />
Товар з id кодом 43 - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=products&amp;products_id=43' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=products & amp; products_id = 43</a><br />
Товари в категорії - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=products&amp;cPath=25&amp;limit=10' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=products & amp; cPath = 25 & amp; limit = 10</a><br />
Товари в категорії (25 це ідентифікатор категорії, ідентифікатори можна дізнатися, наприклад в? Feed = categories, на засланні категорії, тобто Ви можете показувати товари тільки з певних категорій). <br />
<br />
<h3>Додаткові запити </h3>
Новинки - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=new_products&amp;limit=10' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=new_products & amp; limit = 10</a><br />
Лідери продажів - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=best_sellers&amp;limit=10' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=best_sellers & amp; limit = 10</a><br />
Рекомендовані - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=featured&amp;limit=10' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=featured & amp; limit = 10</a><br />
Знижки - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=specials&amp;limit=10' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=specials & amp; limit = 10</a><br />
Очікувані товари - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=upcoming&amp;limit=10' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=upcoming & amp; limit = 10</a><br />
<br />
<h3>Випадкові товари </h3>
Випадковий товар з нових товарів - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=new_products_random' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=new_products_random</a><br />
Випадковий товар з кращих товарів - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=best_sellers_random' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=best_sellers_random</a><br />
Випадковий товар з рекомендованих - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=featured_random' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=featured_random</a><br />
Випадковий товар з знижок - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=specials_random' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=specials_random</a><br />
Випадковий товар з очікуваних товарів - <a href="'.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2.'?feed=upcoming_random' .'"> '.HTTP_SERVER.DIR_WS_CATALOG.FILENAME_RSS2. '?feed=upcoming_random</a><br />
<br />
<h3>Ліміт запитів </h3>
<p>Зверніть увагу на параметр limit. <br />
Можна виводити, наприклад, не всі новинки (rss2.php?feed=new_products), а тільки 10, просто додаєте параметр limit (rss2.php?feed=new_products& amp;limit = 10) </ p>
<h3>Партнерський ID код </h3>
<p>Зверніть увагу на параметр ref. <br />
Якщо у Вас в магазині встановлено модуль партнерської програми, Ваші партнери можуть отримувати RSS канали зі своїм партнерським кодом, наприклад, партнер з id кодом 1 може отримати список новинок наступним чином rss2.php?feed=new_products& amp;ref=1</p>
');
define('ENTRY_STATE_RELOAD', 'Натисніть на кнопку <span class="bold"> "Оновити" </span> щоб заповнити поле Регіон');
define('ENTRY_NOSTATE_AVAILIABLE', 'У обраної країни немає регіонів');
define('ENTRY_STATEXML_LOADING', 'Завантаження регіонів ...');

define('SHIPPING_TIME', 'Час доставки:');
define('MORE_INFO', '[Детальніше]');

define('TABLE_HEADING_LATEST_NEWS', 'Останні новини');
define('NAVBAR_TITLE_NEWS', 'Новини');

define('TEXT_DISPLAY_NUMBER_OF_LATEST_NEWS', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всього <span class="bold">% d < / span> новин) ');
define('TEXT_NO_NEWS', 'Ні новин.');
define('TEXT_INFO_SHOW_PRICE_NO', 'У Вас немає доступу для перегляду цін');
define('TEXT_OF_5_STARS', '%s з 5 зірок!');
define('IMAGE_BUTTON_PRINT', 'Роздрукувати');
define('TEXT_AJAX_QUICKSEARCH_TOP', 'Перші %s позицій ...');
define('TEXT_AJAX_ADDQUICKIE_SEARCH_TOP', 'Перші %s товарів ...');
define('BOX_ALL_ARTICLES', 'Всі статті');
define('BOX_NEW_ARTICLES', 'Нові статті');
define('TEXT_DISPLAY_NUMBER_OF_ARTICLES', 'Показано <b>%d</b> - <b>%d</b> (всього <b>%d</b> статей)');
define('TEXT_DISPLAY_NUMBER_OF_ARTICLES_NEW', 'Показано <b>%d</b> - <b>%d</b> (всього <b>%d</b> нових статей)');
define('TABLE_HEADING_AUTHOR', 'Автор');
define('TABLE_HEADING_ABSTRACT', 'Резюме');
define('BOX_HEADING_AUTHORS', 'Автори статей');
define('NAVBAR_TITLE_DEFAULT', 'Статті');
define('ARTICLES_BY', 'Статті автора');
define('MODULE_PAYMENT_SCHET_PRINT', 'Роздрукувати рахунок для оплати');
define('MODULE_PAYMENT_PACKINGSLIP_PRINT', 'Роздрукувати накладну');
define('MODULE_PAYMENT_KVITANCIA_PRINT', 'Роздрукувати квитанцію для оплати');
define('ENTRY_CAPTCHA_ERROR', 'Ви вказали правильний код зображення.');
define('TEXT_FIRST_REVIEW', 'Ваш відгук може бути першим.');
define('TEXT_PHP_MAILER_ERROR', 'Не вдалося відправити e-mail. <br />');
define('TEXT_PHP_MAILER_ERROR1', 'Помилка:');

define('BOX_TEXT_DOWNLOAD', 'Ваші завантаження:');
define('BOX_TEXT_DOWNLOAD_NOW', 'Завантажити');

define('TABLE_HEADING_DOWNLOAD_DATE', 'Посилання активне до:');
define('TABLE_HEADING_DOWNLOAD_COUNT', 'Залишилося завантажень:');
define('TEXT_FOOTER_DOWNLOAD', 'Всі доступні завантаження також можна знайти в');
define('TEXT_DOWNLOAD_MY_ACCOUNT', 'Історії замовлень');

define('NAVBAR_TITLE_ASK', 'Питання про товар');
define('TEXT_EMAIL_SUCCESSFUL_SENT', 'Ваше питання про товар <b>%s </b> успішно відправлене, ми відповімо на нього в самий найближчий час.');
define('THX_SUCCESSFUL_SENT', 'Дякуємо!');
define('TEXT_MESSAGE_ERROR', 'Ви не заповнили поле Ваше питання.');
define('NAVBAR_TITLE_MAINTENANCE', 'Тех. обслуговування');
define('TABLE_HEADING_FAQ', 'Останні питання');
define('NAVBAR_TITLE_FAQ', 'Питання і відповіді');
define('TEXT_DISPLAY_NUMBER_OF_FAQ', 'Показано <span class="bold">%d</span> - <span class="bold">%d</span> (всього <span class="bold">% d < / span> питань) ');
define('TEXT_NO_FAQ', 'Немає питань.');
require_once(DIR_WS_LANGUAGES . $_SESSION['language'].'/'.'affiliate_' . $_SESSION['language'] .'.php');

define('ENTRY_EXTRA_FIELDS_ERROR', 'Поле %s повинно містити як мінімум% d символів');
define('CATEGORY_EXTRA_FIELDS', 'Додаткова інформація');

define('TEXT_RSS_NEWS', 'Новини');
define('TEXT_RSS_ARTICLES', 'Статті');
define('TEXT_RSS_CATEGORIES', 'Категорії');
define('TEXT_RSS_NEW_PRODUCTS', 'Новинки');
define('TEXT_RSS_FEATURED_PRODUCTS', 'Рекомендовані товари');
define('TEXT_RSS_BEST_SELLERS', 'Лідери продажів');

define('TEXT_CHECKOUT_ALTERNATIVE', 'Оформлення замовлення');

define('TEXT_PRODUCT_COMPARE', 'Порівняти');
define('TEXT_PRODUCT_FILTER', 'Фільтрувати');

define('TXT_FREE', 'безкоштовно');

define('PRODUCTS_ORDER_QTY_MIN_TEXT_INFO', 'Мінімум одиниць для замовлення:');
define('PRODUCTS_ORDER_QTY_MAX_TEXT_INFO', 'Максимум одиниць для замовлення:');

define('WARNING_VAMSHOP_KEY', 'Незареєстрована копія VaM Shop. Внести свою копію за адресою <a href="http://vamshop.ru/key.php" target="_blank"> http://vamshop.ru/key. php </a> ');
define('WARNING_VAMSHOP_DEMO', 'Демонстрационная версия VamShop. Оформите заказ на полноценную, неограниченнцю версию VamShop с технической поддержкой и обновлениями в официальном магазине <a href="https://vamshop.ru/vamshop.html" target="_blank">https://vamshop.ru/vamshop.html</a>');

define('text_zero', 'нуль');
define('text_three', 'три');
define('text_four', 'чотири');
define('text_five', 'п\'ять');
define('text_six', 'шість');
define('text_seven', 'сім');
define('text_eight', 'вісім');
define('text_nine', 'дев\'ять');
define('text_ten', 'десять');
define('text_eleven', 'одинадцять');
define('text_twelve', 'дванадцять');
define('text_thirteen', 'тринадцять');
define('text_fourteen', 'чотирнадцять');
define('text_fifteen', 'п\'ятнадцять');
define('text_sixteen', 'шістнадцять');
define('text_seventeen', 'сімнадцять');
define('text_eighteen', 'вісімнадцять');
define('text_nineteen', 'дев\'ятнадцять');
define('text_twenty', 'двадцять');
define('text_thirty', 'тридцять');
define('text_forty', 'сорок');
define('text_fifty', 'п\'ятдесят');
define('text_sixty', 'шістдесят');
define('text_seventy', 'сімдесят');
define('text_eighty', 'вісімдесят');
define('text_ninety', 'дев\'яносто');
define('text_hundred', 'сто');
define('text_two_hundred', 'двісті');
define('text_three_hundred', 'триста');
define('text_four_hundred', 'чотириста');
define('text_five_hundred', 'п\'ятсот');
define('text_six_hundred', 'шістсот');
define('text_seven_hundred', 'сімсот');
define('text_eight_hundred', 'вісімсот');
define('text_nine_hundred', 'дев\'ятсот');
define('text_penny', 'копійки');
define('text_kopecks', 'копійок');
define('text_single_kopek', 'одна копійка');
define('text_two_penny', 'дві копійки');
define('text_ruble', 'рубля');
define('text_rubles', 'рублів');
define('text_one_ruble', 'один рубль');
define('text_two_rubles', 'два рубля');
define('text_thousands', 'тисячі');
define('text_thousand', 'тисяч');
define('text_one_thousand', 'одна тисяча');
define('text_two_thousand', 'дві тисячі');
define('text_million', 'мільйона');
define('text_millions', 'мільйонів');
define('text_one_million', 'один мільйон');
define('text_two_million', 'два мільйони');
define('text_billion', 'мільярда');
define('text_billions', 'мільярдів');
define('text_one_billion', 'один мільярд');
define('text_two_billion', 'два мільярди');
define('text_trillion', 'трильйона');
define('text_trillions', 'трильйонів');
define('text_one_trillion', 'один трильйон');
define('text_two_trillion', 'два трильйони');

define('PIN_NOT_AVAILABLE', 'Товар закінчився на складі. Відправлено повідомлення на пошту.');

// Start Products Specifications
// Products Filter box text in includes / boxes / products_filter.php
define('BOX_HEADING_PRODUCTS_FILTER', 'Фільтри');
define('TEXT_SHOW_ALL', 'Показати всі');
define('TEXT_FIND_PRODUCTS', 'Знайти підходящі товари');
// End Products Specifications

// Products Specifications
define('TEXT_NOT_AVAILABLE', 'немає даних');

define('FREE_SHIPPING_TITLE', 'Безкоштовна доставка');
define('BUTTON_PRINT_SCHET', 'Роздрукувати рахунок');
define('BUTTON_PRINT_PACKINGSLIP', 'Роздрукувати накладну');
define('BUTTON_PRINT_KVITANCIA', 'Роздрукувати квитанцію');
define('TEXT_NO_PRODUCTS_AVAILABLE', 'Товари для порівняння не знайдені.');
define('TEXT_NO_COMPARISON_AVAILABLE', 'Адміністратором були задані специфікації товару для порівняння. <a href="http://vamshop.ru/manual/ch06.html" target="_blank"> Налаштування специфікацій </a>.') ;
define('TEXT_COMPARE', 'Порівняння товару');
define('TEXT_BUY_BUTTON', 'Купити');
define('TEXT_BEST_BUY', 'встигни придбати!');
define('TEXT_BEST_BUY_UP', 'Встигни прибдати!');
define('TEXT_READ_MORE', 'докладніше');
define('TEXT_READ_MORE_UP', 'Детальніше');
define('TEXT_VIEW_PRODUCTS', 'дивитися товари');
define('TEXT_VIEW_PRODUCTS_UP', 'Дивитись товари');
define('TEXT_VIEW_PRODUCTS_GO', 'Далі');
define('TEXT_PRODUCT_DESCRIPTION', 'Опис');
define('TEXT_PRODUCT_REVIEWS', 'Відгуки');
define('NAVBAR_TITLE_SITE_REVIEW', 'Відгук');
define('NAVBAR_TITLE_SITE_REVIEWS', 'Відгуки про магазин');
define('TEXT_PAGE_PRODUCT_REVIEWS', 'Відгуки');
define('TEXT_PRODUCT_QTY', 'Кількість:');
define('TEXT_PAGE_IN_CAT', 'Сторінка');
define('TEXT_TOTAL_REVIEWS', 'Відгуки');
define('TEXT_REVIEWS_RATING', 'Рейтинг');
define('TEXT_CHECKOUT_PROCESS_PAYMENT', 'Оплатити замовлення');
define('TEXT_MY_ORDERS', 'Мої замовлення');
define('TEXT_BACK', 'Повернутися');
define('PRIVACY_TEXT', 'Натискаючи кнопку, я даю згоду на обробку своїх персональних даних. <a href="privacy.html"> Детальніше про захист персональної інформації. </a>');

// BOF Bundled Products

define('TEXT_PRODUCTS_BY_BUNDLE', 'Даний набір включає в себе наступні товари:');
define('TEXT_RATE_COSTS', 'Вартість товарів окремо:');
define('TEXT_IT_SAVE', 'Ви економите');
define('TEXT_SOLD_IN_BUNDLE', 'Даний товар може буде куплений тільки в наступному комплекті:');
define('IMAGE_BUTTON_OUT_OF_STOCK', 'Ні на складі');
define('TEXT_BUNDLE_ONLY', 'Чи не продається окремо');
// EOF Bundled Products

define('TEXT_POPUP_CART_ADD', 'Товар доданий в кошик!');
define('TEXT_POPUP_CART_CONTINUE', 'Продовжити покупки');
define('TEXT_POPUP_CART_CART', 'Перейти в корзину');
define('TEXT_POPUP_CART_CHECKOUT', 'Оформити замовлення');
define('TITLE_DEFAULT_PAGE', 'Головна');
define('TITLE_SPECIALS_DEFAULT', 'Знижки');
define('TITLE_MANUFACTURERS_DEFAULT', 'Бренди');
define('TITLE_BEST_SELLERS_DEFAULT', 'Популярні товари');
define('TITLE_NEW_PRODUCTS_DEFAULT', 'Новинки');
define('TITLE_FEATURED_DEFAULT', 'Рекомендовані товари');
define('TITLE_FEATURED_DEFAULT_SHORT', 'Рекомендовані');
define('TITLE_SPECIALS_DEFAULT', 'Знижки');

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

?>
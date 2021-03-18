<?php
/* -----------------------------------------------------------------------------------------
   $Id: iml.php 899 2009/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(iml.php,v 1.6 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (iml.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (iml.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_IML_TEXT_TITLE', 'IML - Пункт выдачи заказов');
define('MODULE_SHIPPING_IML_TEXT_DESCRIPTION', 'IML');

define('MODULE_SHIPPING_IML_JS', '
<script>
$(function () {
$("select#pvz_iml").on("change", function() {
    $("[name=shipping]").val(["iml_iml"]);
});
});
</script>
');

define('MODULE_SHIPPING_IML_TEXT_SELECT_ADDRESS','Выбрать ПВЗ');
define('MODULE_SHIPPING_IML_TEXT_ADDRESS_HELP','(откроется во всплывающем окне)');
define('MODULE_SHIPPING_IML_TEXT_ADDRESS','На указанный адрес доставки');
define('MODULE_SHIPPING_IML_TEXT_ANOTHER_ADDRESS','Выбрать другой адрес');

define('MODULE_SHIPPING_IML_TEXT_WAY', 'Заказ будет доставлен на указанный адрес.');

define('MODULE_SHIPPING_IML_TEXT_TITLE_2', 'ПВЗ');

define('MODULE_SHIPPING_IML_STATUS_TITLE' , 'Разрешить модуль iml');
define('MODULE_SHIPPING_IML_STATUS_DESC' , 'Вы хотите разрешить модуль iml?');
define('MODULE_SHIPPING_IML_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_SHIPPING_IML_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_SHIPPING_IML_COST_TITLE' , 'Стоимость доставки');
define('MODULE_SHIPPING_IML_COST_DESC' , 'Стоимость доставки данным способом.');
define('MODULE_SHIPPING_IML_CITY_TITLE' , 'Город отправки');
define('MODULE_SHIPPING_IML_CITY_DESC' , 'Укажите город отправки заказов.');
define('MODULE_SHIPPING_IML_TAX_CLASS_TITLE' , 'Налог');
define('MODULE_SHIPPING_IML_TAX_CLASS_DESC' , 'Использовать налог.');
define('MODULE_SHIPPING_IML_ZONE_TITLE' , 'Зона');
define('MODULE_SHIPPING_IML_ZONE_DESC' , 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.');
define('MODULE_SHIPPING_IML_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_SHIPPING_IML_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');
define('MODULE_SHIPPING_IML_LOGIN_TITLE' , 'IML API Логин');
define('MODULE_SHIPPING_IML_LOGIN_DESC' , 'Укажите ваш логин.');
define('MODULE_SHIPPING_IML_PASSWORD_TITLE' , 'IML API Логин');
define('MODULE_SHIPPING_IML_PASSWORD_DESC' , 'Укажите ваш логин.');

?>
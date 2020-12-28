<?php
/* -----------------------------------------------------------------------------------------
   $Id: flat.php 899 2009/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(flat.php,v 1.6 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (flat.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (flat.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_GRASTINPVZ_TEXT_TITLE', 'Grastin');
define('MODULE_SHIPPING_GRASTINPVZ_TEXT_DESCRIPTION', '');
define('MODULE_SHIPPING_GRASTINPVZ_JS', '
<script>
$(function () {
$("select#pvz_grastin").on("change", function() {
    $("[name=shipping]").val(["grastinpvz_grastinpvz"]);
});
});
</script>
');
define('MODULE_SHIPPING_GRASTINPVZ_TEXT_TITLE_2', 'ПВЗ');
define('MODULE_SHIPPING_GRASTINPVZ_STATUS_TITLE' , 'Разрешить модуль грастин');
define('MODULE_SHIPPING_GRASTINPVZ_STATUS_DESC' , 'Вы хотите разрешить модуль грастин?');
define('MODULE_SHIPPING_GRASTINPVZ_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_SHIPPING_GRASTINPVZ_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_SHIPPING_GRASTINPVZ_COST_TITLE' , 'Стоимость доставки (вес выше 0.35 кг.)');
define('MODULE_SHIPPING_GRASTINPVZ_COST_DESC' , 'Стоимость доставки данным способом.');
define('MODULE_SHIPPING_GRASTINPVZ_COST_2_TITLE' , 'Стоимость доставки (вес ниже 0.35 кг.)');
define('MODULE_SHIPPING_GRASTINPVZ_COST_2_DESC' , 'Стоимость доставки данным способом.');
define('MODULE_SHIPPING_GRASTINPVZ_API_LOGIN_TITLE' , 'Ваш Grastin API ключ');
define('MODULE_SHIPPING_GRASTINPVZ_API_LOGIN_DESC' , 'Ваш Grastin API ключ');
define('MODULE_SHIPPING_GRASTINPVZ_TAX_CLASS_TITLE' , 'Налог');
define('MODULE_SHIPPING_GRASTINPVZ_TAX_CLASS_DESC' , 'Использовать налог.');
define('MODULE_SHIPPING_GRASTINPVZ_ZONE_TITLE' , 'Зона');
define('MODULE_SHIPPING_GRASTINPVZ_ZONE_DESC' , 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.');
define('MODULE_SHIPPING_GRASTINPVZ_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_SHIPPING_GRASTINPVZ_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');

define('MODULE_SHIPPING_GRASTINPVZ_MIN_SUM_TITLE' , 'Мин. сумма от которой действует скидка');
define('MODULE_SHIPPING_GRASTINPVZ_PROCENT_TITLE' , 'Процент скидки');
define('MODULE_SHIPPING_GRASTINPVZ_MIN_SUM_ORDER_TITLE' , 'Минимальная сумма от которой действует доставка');
?>
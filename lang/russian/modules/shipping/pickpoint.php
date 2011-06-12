<?php
/* -----------------------------------------------------------------------------------------
   $Id: pickpoint.php 899 2009/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(pickpoint.php,v 1.6 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (pickpoint.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (pickpoint.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_PICKPOINT_TEXT_TITLE', 'Постаматы PickPoint.Ru');
define('MODULE_SHIPPING_PICKPOINT_TEXT_DESCRIPTION', 'Постаматы PickPoint.Ru');

define('MODULE_SHIPPING_PICKPOINT_TEXT_SELECT_ADDRESS','Выберите адрес доставки в Москве');
define('MODULE_SHIPPING_PICKPOINT_TEXT_ADDRESS_HELP','(откроется во всплывающем окне)');
define('MODULE_SHIPPING_PICKPOINT_TEXT_ADDRESS','Ваш заказ доставят по адресу: ');
define('MODULE_SHIPPING_PICKPOINT_TEXT_ANOTHER_ADDRESS','Выбрать другой адрес');

define('MODULE_SHIPPING_PICKPOINT_TEXT_WAY', '

<script type="text/javascript" src="http://www.pickpoint.ru/select/postamat.js"></script>

<script type="text/javascript">
function pickpoint_call(id_this){
  PickPoint.open(pickpoint_callback_function, pickpoint_options);
}
function pickpoint_callback_function(result){
  var pickpoint_id = document.getElementById("pickpoint_id");
  var pickpoint_address = document.getElementById("pickpoint_address");
  var pickpoint_address_text = document.getElementById("pickpoint_address_text");
  var pickpoint_link = document.getElementById("pickpoint_link");
  var pickpoint_error = document.getElementById("pickpoint_error");
  var pickpoint_link_help = document.getElementById("pickpoint_link_help");
  pickpoint_id.value = result["id"];
  pickpoint_address.value = result["address"];
  // textContent innerHTML
  pickpoint_address_text.innerHTML = "'.MODULE_SHIPPING_PICKPOINT_TEXT_ADDRESS.'" + result["address"] + " ";
  pickpoint_link.innerHTML = "'.MODULE_SHIPPING_PICKPOINT_TEXT_ANOTHER_ADDRESS.'";
  if (pickpoint_error) pickpoint_error.innerHTML="";
//  if (pickpoint_link_help) pickpoint_link_help.innerHTML="";
}
var pickpoint_options={city:"moscow"};
</script>
<input type="hidden" name="pickpoint_id" id="pickpoint_id" value="" />
<input type="hidden" name="pickpoint_address" id="pickpoint_address" value="" />
<span id="pickpoint_address_text"></span>
<u><a href="" onclick="pickpoint_call(this);return false;"><span id="pickpoint_link" style="color:blue;">'.MODULE_SHIPPING_PICKPOINT_TEXT_SELECT_ADDRESS.'</span></a></u> <span id="pickpoint_link_help">'.MODULE_SHIPPING_PICKPOINT_TEXT_ADDRESS_HELP.'</span>

');

define('MODULE_SHIPPING_PICKPOINT_STATUS_TITLE' , 'Разрешить модуль pickpoint');
define('MODULE_SHIPPING_PICKPOINT_STATUS_DESC' , 'Вы хотите разрешить модуль pickpoint?');
define('MODULE_SHIPPING_PICKPOINT_ALLOWED_TITLE' , 'Разрешённые страны');
define('MODULE_SHIPPING_PICKPOINT_ALLOWED_DESC' , 'Укажите коды стран, для которых будет доступен данный модуль (например RU,DE (оставьте поле пустым, если хотите что б модуль был доступен покупателям из любых стран))');
define('MODULE_SHIPPING_PICKPOINT_COST_TITLE' , 'Стоимость доставки');
define('MODULE_SHIPPING_PICKPOINT_COST_DESC' , 'Стоимость доставки данным способом.');
define('MODULE_SHIPPING_PICKPOINT_TAX_CLASS_TITLE' , 'Налог');
define('MODULE_SHIPPING_PICKPOINT_TAX_CLASS_DESC' , 'Использовать налог.');
define('MODULE_SHIPPING_PICKPOINT_ZONE_TITLE' , 'Зона');
define('MODULE_SHIPPING_PICKPOINT_ZONE_DESC' , 'Если выбрана зона, то данный модуль доставки будет виден только покупателям из выбранной зоны.');
define('MODULE_SHIPPING_PICKPOINT_SORT_ORDER_TITLE' , 'Порядок сортировки');
define('MODULE_SHIPPING_PICKPOINT_SORT_ORDER_DESC' , 'Порядок сортировки модуля.');

?>
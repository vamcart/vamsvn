<?php
/* -----------------------------------------------------------------------------------------
   $Id: ot_shipping.php 899 2007/02/07 13:24:46 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_shipping.php,v 1.4 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (ot_shipping.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (ot_shipping.php,v 1.4 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('MODULE_ORDER_TOTAL_SHIPPING_TITLE', 'Доставка');
  define('MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION', 'Доставка');

  define('FREE_SHIPPING_TITLE', 'Бесплатная доставка');
  define('FREE_SHIPPING_DESCRIPTION', 'Бесплатная доставка для заказов на сумму свыше %s');

  define('MODULE_ORDER_TOTAL_SHIPPING_STATUS_TITLE','Показывать доставку');
  define('MODULE_ORDER_TOTAL_SHIPPING_STATUS_DESC','Вы хотите показывать стоимость доставки?');

  define('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER_TITLE','Порядок сортировки');
  define('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER_DESC', 'Порядок сортировки модуля.');

  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_TITLE','Разрешить бесплатную доставку');
  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_DESC','Вы хотите разрешить беслатную доставку?');

  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_TITLE','Бесплатная доставка для заказов свыше');
  define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_DESC','Для заказов, свыше указанной величины, доставка будет бесплатной.');

  define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_TITLE','Бесплатная доставка для заказов');
  define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_DESC','Укажите, для каких именно заказов будет действительна бесплатная доставка.');
  
  define('MODULE_ORDER_TOTAL_SHIPPING_TAX_CLASS_TITLE','Налог');
  define('MODULE_ORDER_TOTAL_SHIPPING_TAX_CLASS_DESC','Использовать налог (только при редактировании заказа в админке).');   
?>
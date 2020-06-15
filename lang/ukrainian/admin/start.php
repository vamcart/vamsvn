<?php
/* --------------------------------------------------------------
   $Id: start.php 890 2007-02-07 17:36:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (start.php,v 1.1 2003/08/19); www.nextcommerce.org
   (c) 2004	 xt:Commerce (start.php,v 1.1 2003/08/19); xt-commerce.com
   
   Released under the GNU General Public License 
   --------------------------------------------------------------*/
 
  define('HEADING_TITLE','Добро пожаловать');
  define('ATTENTION_TITLE','! ВНИМАНИЕ !');

  // text for Warnings:
  define('TEXT_FILE_WARNING','<b>ВНИМАНИЕ:</b><br />Следующие файлы не закрыты от записи. Установите права доступа <b>444</b> для юникса, или <b>read-only</b> для Windows.');
  define('TEXT_FOLDER_WARNING','<b>ВНИМАНИЕ:</b><br />Следующие папки закрыты от записи. Измените права доступа на эти папки. Например установите <b>777</b> для юникса, или <b>(read-write)</b> для Windows.');
  define('REPORT_GENERATED_FOR','Report For:');
  define('REPORT_GENERATED_ON','Generated On:');
  define('FIRST_VISIT_ON','First Visit:');
  define('HEADING_QUICK_STATS','Quick stats');
  define('VISITS_TODAY','Visits Today:');
  define('UNIQUE_TODAY','Unique Today:');
  define('DAILY_AVERAGE','Daily Average:');
  define('TOTAL_VISITS','Total Visits:');
  define('TOTAL_UNIQUE','Total Unique:');
  define('TOP_REFFERER','Top Referring Host:');
  define('TOP_ENGINE','Top Search Engine:');
  define('DAY_SUMMARY','30 Day Summary:');
  define('VERY_LAST_VISITORS','Last 10 Visitors:');
  define('TODAY_VISITORS','Visitors of today:');
  define('LAST_VISITORS','Last 100 Visitors:');
  define('ALL_LAST_VISITORS','All Visitors:');
  define('DATE_TIME','Date / Time:');
  define('IP_ADRESS','IP Adress:');
  define('OPERATING_SYSTEM','Operating System:');
  define('REFFERING_HOST','Referring Host:');
  define('ENTRY_PAGE','Entry Page:');
  define('HOURLY_TRAFFIC_SUMMARY','Hourly Traffic Summary');
  define('WEB_BROWSER_SUMMARY','Web Browser Summary');
  define('OPERATING_SYSTEM_SUMMARY','Operatin System Summary');
  define('TOP_REFERRERS','Top 10 Referrers');
  define('TOP_HOSTS','Top Ten Hosts');
  define('LIST_ALL','List all');    
  define('SEARCH_ENGINE_SUMMARY','Search Engine Summary');
  define('SEARCH_ENGINE_SUMMARY_TEXT',' ( Percentage is based on total visits referred from search engines. )');
  define('SEARCH_QUERY_SUMMARY','Search Query Summary');
  define('SEARCH_QUERY_SUMMARY_TEXT',' ) ( Percentage is based on total search query strings logged. )');
  define('REFERRING_URL','Reffering Url');
  define('HITS','Hits');
  define('PERCENTAGE','Percentage');
  define('HOST','Host');

  define('TEXT_SUMMARY_VAMSHOP_NEWS','Новости VamShop');
  define('TEXT_SUMMARY_TOTAL_ORDERS','Всего заказов');
  define('TEXT_SUMMARY_AVERAGE_ORDERS','Средний чек');
  define('TEXT_SUMMARY_TOTAL_SALES','Сумма продаж');
  define('TEXT_SUMMARY_TOTAL_CUSTOMERS','Всего клиентов');
  define('TEXT_SUMMARY_PENDING_ORDERS','Новых заказов');

  define('HEADING_TITLE', 'Кто сейчас в магазине');

  define('TABLE_HEADING_ONLINE', 'Онлайн');
  define('TABLE_HEADING_FULL_NAME', 'Имя');
  define('TABLE_HEADING_CUSTOMER_ID', 'ID');
  define('TABLE_HEADING_IP_ADDRESS', 'IP Адрес');
  define('TABLE_HEADING_ENTRY_TIME', 'Время Входа');
  define('TABLE_HEADING_LAST_CLICK', 'Последний Клик');
  define('TABLE_HEADING_ACTION', 'Действие');
  define('TABLE_HEADING_LAST_PAGE_URL', 'Последний URL');
  define('TABLE_HEADING_SHOPPING_CART', 'Корзина пользователя');
  define('TEXT_SHOPPING_CART_SUBTOTAL', 'Стоимость товара');
  define('TEXT_NUMBER_OF_CUSTOMERS', 'На данный момент в магазине клиентов: %s');

?>
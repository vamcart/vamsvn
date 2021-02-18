<?php
/**
 * yml.php
 *
 * @package yml feed
 * @copyright Copyright 2005-2008 Andrew Berezin eCommerce-Service.com
 * @copyright Portions Copyright 2003-2006 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: yml.php,v 3.12 27.07.2008 17:52 Andrew Berezin $
 */
// http://partner.market.yandex.ru/legal/tt/
/*
1. Язык, в котором отдаётся yml, определяется по умолчанию или задаётся в адресной строке.
2. Валюта, в которой отдаются цены, определяется по умолчанию или задаётся в адресной строке.
   Т.е. можно определять для сторонних сайтов ссылки вида:
   http://<domain>/yml.php?language=ru&currency=RUR
3. Изготовителя может быть задан, а может и не быть задан;
4. Короткие описания могут быть установлены, а могут и не быть установлены;
5. Поле yml-флага в таблице товаров может существовать, а может и не существовать.
6. Все валюты и их курсы формируются автоматически;
7. Все ссылки на товар и картинки преобразуются в соответсвии с правилами (urlencode()),
   что решает проблему с использованием нестандарных символов в ссылках.
8. Поддержка yml-флага для категорий, содержащих только товары;
9. Поддержка нескольких категорий для товара;
10. Поддержка доступа по паролю (логин/пароль можно задать в админе или определить здесь,
    в константах). Константы YML_AUTH_USER, YML_AUTH_PW;
11. Доставка включена или нет определяется константой доступа по паролю (логин/пароль можно
    задать в админе или определить здесь, в константах). Константа YML_DELIVERYINCLUDED;
12. Поддерживает типы продуктов (страницы отображения информации о товаре для разных типов
    товара);
13. Поддержка <offer available; Константа YML_AVAILABLE может принимать одно из трёх значений:
    "true", "false" и "stock". В последнем случае доступность товара определяется по наличию его на складе
    (поле products_quantity);
14. Добавлены константы YML_NAME & YML_COMPANY;
15. Добавлены константы YML_REF_ID и YML_REF_IP (для тех, кто не умеет отслеживать заходы иначе);
16. Добавлена опция "убирания" тегов (константа YML_STRIP_TAGS);
17. Добавлена опция перекодирования в utf-8 (константа YML_UTF8);
18. Поддержка специальных цен;
19. Кеширование производителей;
20. Добавлена опция генерации тега <vendor> (константа YML_VENDOR);
21. Добавлен тег <vendorCode>;
22. Добавлена замена кода валюты RUB на RUR для совместимости с Яндекс.Маркет;
23. Добавлена возможность генерации статического файла. Для этого надо задать имя файла в параметре $_GET['file']. В этом случае надо помнить о YML_REF_IP - при запуске по cron использование этого параметра теряет смысл;
24. Добавлена возможность задания параметра $_GET['ref']. Это удобно при генерации разных статических файлов для разных торговых площадок. Не забывайте об YML_REF_ID - в данном случае его использование не должно быть противоречивым и избыточным;
25. Добавлена опция генерации тега <vendorCode> (константа YML_VENDORCODE);
26. Добавлена опция использования тега CDATA (константа YML_USE_CDATA);
27. Убрал YML_REF_IP;
28. Использование yml_bid, yml_cbid, yml_bid, yml_cbid;
29. Добавлен параметр cats=all/master. По умолчанию - cats=master;
30. Параметр YML_UTF8 заменён на YML_CHARSET. Определяет выходную кодировку по умолчанию.
31. Добавлен параметр charset=. Задаёт выходную кодировку;

TODO:
1.


-- Константы в админе:
INSERT INTO configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (NULL, 'Яндекс-Маркет', 'Конфигурирование Яндекс-Маркет', '1', '1');
SET @configuration_group_id = last_insert_id();
UPDATE configuration_group SET sort_order = @configuration_group_id WHERE configuration_group_id = @configuration_group_id;

INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES (NULL, 'Название магазина', 'YML_NAME', '', 'Название магазина для Яндекс-Маркет. Если поле пустое, то используется STORE_NAME.', @configuration_group_id, 1, NOW(), NULL,  NULL),
(NULL, 'Название компании', 'YML_COMPANY', '', 'Название компании для Яндекс-Маркет. Если поле пустое, то используется STORE_OWNER.', @configuration_group_id, 2, NOW(), NULL,  NULL),
(NULL, 'Доставка включена', 'YML_DELIVERYINCLUDED', 'true', 'Доставка включена в стоимость товара?', @configuration_group_id, 3, NOW(), NULL, 'vam_cfg_select_option(array(\'true\', '\false\'),'),
(NULL, 'Товар в наличии', 'YML_AVAILABLE', 'stock', 'Товар в наличии или под заказ?', @configuration_group_id, 4, NOW(), NULL, 'vam_cfg_select_option(array(\'true\', \'false\', \'stock\'),'),
(NULL, 'Теги', 'YML_STRIP_TAGS', 'true', 'Убирать html-теги в строках?', @configuration_group_id, 6, NOW(), NULL, 'vam_cfg_select_option(array(\'false\', \'true\'),'),
(NULL, 'Тег CDATA', 'YML_USE_CDATA', 'true', 'Использовать тег CDATA для наименований и описаний товарови категорий', @configuration_group_id, 6, NOW(), NULL, 'vam_cfg_select_option(array(\'false\', \'true\'),'),
(NULL, 'Ссылка', 'YML_REF_ID', 'ref=yml', 'Добавить в адрес товара параметр', @configuration_group_id, 9, NOW(), NULL, NULL),
(NULL, 'Генерация <vendor>', 'YML_VENDOR', 'false', 'Генерировать тег <vendor>?', @configuration_group_id, 8, NOW(), NULL, 'vam_cfg_select_option(array(\'false\', \'true\'),'),
(NULL, 'Генерация <vendorCode>', 'YML_VENDORCODE', 'true', 'Генерировать тег <vendorCode>?', @configuration_group_id, 8, NOW(), NULL, 'vam_cfg_select_option(array(\'false\', \'true\'),'),
(NULL, 'Использовать cPath', YML_USE_CPATH', 'true', 'Использовать cPath в адресе товара?', @configuration_group_id, 8, NOW(), NULL, 'vam_cfg_select_option(array(\'false\', \'true\'),'),
(NULL, 'Сжатие', 'YML_GZIP', 'false', 'Использование сжатие GZIP', @configuration_group_id, 10, NOW(), NULL, 'vam_cfg_select_option(array(\'false\', \'true\'),'),
(NULL, 'Логин', 'YML_AUTH_USER', '', 'Логин для доступа к YML', @configuration_group_id, 11, NOW(), NULL, NULL),
(NULL, 'Пароль', 'YML_AUTH_PW', '', 'Пароль для доступа к YML', @configuration_group_id, 12, NOW(), NULL, NULL);

ALTER TABLE categories ADD yml_enable TINYINT(1) DEFAULT '1' NOT NULL;
ALTER TABLE products ADD yml_enable TINYINT(1) DEFAULT '1' NOT NULL;

ALTER TABLE categories ADD yml_bid INT(4) DEFAULT '0' NOT NULL;
ALTER TABLE categories ADD yml_cbid INT(4) DEFAULT '0' NOT NULL;

ALTER TABLE products ADD yml_bid INT(4) DEFAULT '0' NOT NULL;
ALTER TABLE products ADD yml_cbid INT(4) DEFAULT '0' NOT NULL;
*/
@define('GZIP_LEVEL','0');
require('includes/application_top.php');
require_once (DIR_FS_INC.'vam_get_products_mo_images.inc.php');

@define('YML_NAME', '');
@define('YML_COMPANY', '');
@define('YML_AVAILABLE', 'stock');
@define('YML_DELIVERYINCLUDED', 'false');
@define('YML_AUTH_USER', '');
@define('YML_AUTH_PW', '');
@define('YML_REF_ID', '');
@define('YML_STRIP_TAGS', 'true');
@define('YML_USE_CDATA', 'true');
@define('YML_UTF8', '');
@define('YML_VENDOR', 'false');
@define('YML_VENDORCODE', 'true');
@define('YML_USE_CPATH', 'false');
@define('YML_OUTPUT_BUFFER_MAXSIZE', 1024);
@define('YML_OUTPUT_DIRECTORY', 'temp/');
@define('YML_GZIP', 'false');

if (!get_cfg_var('safe_mode') && function_exists('set_time_limit')) {
  set_time_limit(0);
}

if (YML_AUTH_USER != "" && YML_AUTH_PW != "") {
  if (!isset($_SERVER["PHP_AUTH_USER"]) || $_SERVER["PHP_AUTH_USER"] != YML_AUTH_USER || $_SERVER["PHP_AUTH_PW"] != YML_AUTH_PW) {
    header('WWW-Authenticate: Basic realm="Realm-Name"');
    header("HTTP/1.0 401 Unauthorized");
    die;
  }
}

$charset = (YML_UTF8 == 'true') ? 'windows-1251' : $_SESSION['language_charset'];

$yml_referer = YML_REF_ID;
$referrer = (YML_REF_ID != '' ? '&' . YML_REF_ID : '');
$referrer .= (!empty($_GET['ref']) ? '&ref=' . $_GET['ref'] : '');

if($_SESSION["language_code"] != DEFAULT_LANGUAGE) $language_get = '&language=' . $_SESSION["language_code"];

$display_all_categories = (isset($_GET['cats']) && $_GET['cats'] == 'all');

if(!vam_yml_out()) {
  echo 'Ошибка при создании yml-файла'; // Убрать в константы
  die;
}

vam_yml_out('<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">');
vam_yml_out('<channel>');
vam_yml_out('<title>' . vam_yml_clear_string((YML_NAME == '' ? STORE_NAME : YML_NAME)) .'</title>');
vam_yml_out('<link>' . HTTP_SERVER . DIR_WS_CATALOG . '</link>');
vam_yml_out('<description>' . vam_yml_clear_string((YML_COMPANY == '' ? STORE_OWNER : YML_COMPANY)) . '</description>');

$products_short_description = vam_db_query('describe ' . TABLE_PRODUCTS_DESCRIPTION . ' products_short_description');
$yml_select = vam_db_query('describe ' . TABLE_PRODUCTS . ' products_to_xml');
$products_sql = "SELECT distinct c.google_category_id, p.products_id, p2c.categories_id, p.products_model, p.products_ean, p.products_quantity, p.products_image, p.products_ean, p.products_price, s.status, s.specials_new_products_price as price, p.products_tax_class_id, p.manufacturers_id, p.products_sort, GREATEST(p.products_date_added, IFNULL(p.products_last_modified, 0), IFNULL(p.products_date_available, 0)) AS base_date, pd.products_name, m.manufacturers_name, pd.products_description" .
                (($products_short_description > 0) ? ", pd.products_short_description " : " ") . "as proddesc " .
                (($yml_select > 0) ? ", p.yml_bid, p.yml_cbid " : "") .
                "FROM " . TABLE_PRODUCTS . " p
                    LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd ON (p.products_id = pd.products_id)
                    LEFT JOIN " . TABLE_MANUFACTURERS . " m ON (p.manufacturers_id = m.manufacturers_id)
                    LEFT JOIN " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c ON (p.products_id = p2c.products_id)
                    LEFT JOIN " . TABLE_SPECIALS . " s ON (p.products_id = s.products_id)
                    LEFT JOIN " . TABLE_CATEGORIES . " c ON (c.categories_id = p2c.categories_id)
                 WHERE p.products_status = 1" .
                   (($yml_select > 0) ? " and p.products_to_xml = 1" : "") .
                 " AND pd.language_id = " . (int)$_SESSION['languages_id'] . "
                 group by p.products_id 
                 ORDER BY p.products_id ASC";
$products_query = vam_db_query($products_sql);
while ($products = vam_db_fetch_array($products_query)) {
  $available = "false";
  switch(YML_AVAILABLE) {
    case "stock":
      if($products['products_quantity'] > 0)
        $available = "in stock";
      else
        $available = "out of stock";
      break;
    case "false":
    case "true":
      $available = YML_AVAILABLE;
      break;
  }
  $cbid = $bid = '';
  $products["yml_bid"] = max((!isset($products["yml_bid"]) ? 0 : $products["yml_bid"]), $categories_bid[$products["categories_id"]]);
  if($products["yml_bid"] > 0) $bid = ' bid="' . $products["yml_bid"] . '"';
  $products["yml_cbid"] = max((!isset($products["yml_cbid"]) ? 0 : $products["yml_cbid"]), $categories_cbid[$products["categories_id"]]);
  if($products["yml_cbid"] > 0) $cbid = ' cbid="' . $products["yml_cbid"] . '"';
  $price = $products['products_price'];
  $price = $vamPrice->GetPrice($products['products_id'], $format = false, 1, $products['products_tax_class_id'], $price);

  $old_price = $products['price'];
  $old_price = $vamPrice->GetPrice($products['products_id'], $format = false, 1, $products['products_tax_class_id'], $old_price);

  $url = vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($products['products_id'], $products['products_name']) . (isset($_GET['ref']) ? '&amp;ref=' . $_GET['ref'] : null) . $yml_referer, 'NONSSL', false);
  vam_yml_out('<item>');
  vam_yml_out('  <link>' . $url . '</link>');
  vam_yml_out('  <title>' . vam_yml_clear_string($products['products_name']) . '</title>');
  vam_yml_out('  <description>' . vam_yml_clear_string($products['proddesc']) . '</description>');
  vam_yml_out('  <g:id>' . $products['products_id'] . '</g:id>');
  vam_yml_out('  <g:price>' . number_format($vamPrice->Format($products['products_price'], false),2,'.','') . ' ' . $_SESSION['currency'] . '</g:price>');
  if ($products['price'] > 0 && $products['status'] == 1) vam_yml_out('  <g:sale_price>' . ($old_price > 0 && $products['status'] == 1  ? number_format($old_price,2,'.','') : number_format($price,2,'.','')) . ' ' . $_SESSION['currency'] . '</g:sale_price>');
  vam_yml_out('  <g:availability>' . $available . '</g:availability>');
  if(vam_not_null($products['products_image'])) vam_yml_out('  <g:image_link>' . HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_ORIGINAL_IMAGES . urldecode($products['products_image']) . '</g:image_link>');
		$mo_images = vam_get_products_mo_images($products['products_id']);
        if ($mo_images != false) {
            foreach ($mo_images as $img) {
                vam_yml_out('  <g:additional_image_link>' . HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_ORIGINAL_IMAGES . urldecode($img['image_name']) . '</g:additional_image_link>');
            }
        }
  if(YML_VENDOR == "true" && $products['manufacturers_id'] != 0) {
    vam_yml_out('  <g:brand>' . vam_yml_clear_string($products['manufacturers_name']) . '</g:brand>');
  }
  if(YML_VENDORCODE == "true" && vam_not_null($products['products_model'])) {
    vam_yml_out('  <g:mpn>' . $products['products_model'] . '</g:mpn>');
  }
  if(vam_not_null($products['products_ean'])) {
    vam_yml_out('  <g:gtin>' . $products['products_ean'] . '</g:gtin>');
  }
  if(vam_not_null($products['google_category_id'])) {
    vam_yml_out('  <g:google_product_category>' . $products['google_category_id'] . '</g:google_product_category>');
  }
  vam_yml_out('</item>' . "\n");

}
vam_yml_out('</channel>');
vam_yml_out('</rss>');
vam_yml_out();

  function vam_yml_out($output='') {
    static $fp = false;
    static $output_buffer = "";
    $retval = true;
    if($output == '') {
      if(!$fp) {
        if(isset($_GET['file'])) {
          if(YML_GZIP == 'true') {
            $retval = $fp = gzopen(DIR_FS_CATALOG . YML_OUTPUT_DIRECTORY . $_GET['file'] . '.gz', "wb");
          } else {
            $retval = $fp = fopen(DIR_FS_CATALOG . YML_OUTPUT_DIRECTORY . $_GET['file'], "wb");
          }
        } else {
          if(YML_GZIP == 'true') {
            if (($ini_zlib_output_compression = (int)ini_get('zlib.output_compression')) < 1) {
              ob_start('ob_gzhandler');
            } else {
              @ini_set('zlib.output_compression_level', GZIP_LEVEL);
            }
          }
          header('Content-Type: text/xml');
          $fp = true;
        }
      } else {
        if(strlen($output_buffer) > 0) {
          if(isset($_GET['file'])) {
            if(YML_GZIP == 'true') {
              $retval = gzwrite($fp, $output_buffer, strlen($output_buffer));
            } else {
              $retval = fwrite($fp, $output_buffer, strlen($output_buffer));
            }
          } else {
            echo $output_buffer;
          }
          $output_buffer = "";
        }
        if(isset($_GET['file'])) {
          fclose($fp);
          $fp = false;
        }
      }
    } else {
      if(strlen($output_buffer) > YML_OUTPUT_BUFFER_MAXSIZE) {
        if(isset($_GET['file'])) {
          if(YML_GZIP == 'true') {
            $retval = gzwrite($fp, $output_buffer, strlen($output_buffer));
          } else {
            $retval = fwrite($fp, $output_buffer, strlen($output_buffer));
          }
        } else {
          echo $output_buffer;
        }
        $output_buffer = "";
      }
      $output_buffer .= $output . "\n";
    }
    return $retval;
  }

  function vam_yml_clear_string($str) {
  	global $charset;
//    $str = htmlspecialchars_decode($str, ENT_QUOTES);
    if (YML_STRIP_TAGS == 'true') {
      $str = strip_tags($str);
    }
    if (function_exists('iconv')) {
    if ($charset != $_SESSION['language_charset']) {
      $str = iconv($_SESSION['language_charset'], $charset, $str);
    }
    }
    if (YML_USE_CDATA == 'true') {
      $str = '<![CDATA[' . $str . ']]>';
    } else {
      $str = htmlspecialchars($str, ENT_QUOTES);
    }

    return $str;
  }
?>
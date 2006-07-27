<?php
/*
1. ����, � ������� ������� xml, ������������ �� ��������� ��� ������� � �������� ������.
2. ������, � ������� �������� ����, ������������ �� ��������� ��� ������� � �������� ������.
	 �.�. ����� ���������� ��� ��������� ������ ������ ����:
	 http://<domain>/xml_yml_catalog.php?language=ru&currency=RUR
3. ������������ ����� ���� �����, � ����� � �� ���� �����;
4. �������� �������� ����� ���� �����������, � ����� � �� ���� �����������;
5. ���� xml-����� � ������� ������� ����� ������������, � ����� � �� ������������.
6. ��� ������ � �� ����� ����������� �������������;
7. ��� ������ �� ����� � �������� ������������� � ����������� � ��������� (urlencode()),
	 ��� ������ �������� � �������������� ������������ �������� � �������.
8. ��������� xml-����� ��� ���������, ���������� ������ ������;
9. ��������� ���������� ��������� ��� ������;
10. ��������� ������� �� ������ (�����/������ ����� ������ � ������ ��� ���������� �����,
		� ����������). ��������� YML_AUTH_USER, YML_AUTH_PW;
11. �������� �������� ��� ��� ������������ ���������� ������� �� ������ (�����/������ �����
		������ � ������ ��� ���������� �����, � ����������). ��������� YML_DELIVERYINCLUDED;
12. ������������ ���� ��������� (�������� ����������� ���������� � ������ ��� ������ �����
		������);
13. ��������� <offer available; ��������� YML_AVAILABLE ����� ��������� ���� �� ��� 
		��������: "true", "false" � "stock". � ��������� ������ ����������� ������ ������������
		�� ������� ��� �� ������ (���� products_quantity);
14. ��������� ��������� YML_NAME & YML_COMPANY;
15. ��������� ��������� YML_REFERER (��� ���, ��� �� ����� ����������� ������ ����� 
		��������);
16. ��������� ����� "��������" ����� (��������� YML_STRIP_TAGS);
17. ��������� ����� ��������������� � utf-8 (��������� YML_UTF8);
18. ��������� ����������� ���;
19. ����������� ��������������;


-- TODO:
1. ��������� xml-����� ��� ���������, ������� ��������� ���������;

-- ��������� � ������:
insert into configuration values ('', '�������� ��������', 'YML_NAME', '', '�������� �������� ��� ������-������. ���� ���� ������, �� ������������ STORE_NAME.', 999, 2, NULL, NOW(), NULL,  NULL);
insert into configuration values ('', '�������� ��������', 'YML_COMPANY', '', '�������� �������� ��� ������-������. ���� ���� ������, �� ������������ STORE_OWNER.', 999, 2, NULL, NOW(), NULL,  NULL);
insert into configuration values ('', '�������� ��������', 'YML_DELIVERYINCLUDED', 'true', '�������� �������� � ��������� ������?', 999, 2, NULL, NOW(), NULL, 'zen_cfg_select_option(array(\'true\', '\false\'),');
insert into configuration values ('', '����� � �������', 'YML_AVAILABLE', 'stock', '����� � ������� ��� ��� �����?', 999, 2, NULL, NOW(), NULL, 'zen_cfg_select_option(array(\'true\', \'false\', \'stock\'),');
insert into configuration values ('', '�����', 'YML_AUTH_USER', '', '����� ��� ������� � YML', 999, 2, NULL, NOW(), NULL, NULL);
insert into configuration values ('', '������', 'YML_AUTH_PW', '', '������ ��� ������� � YML', 999, 2, NULL, NOW(), NULL, NULL);
insert into configuration values ('', '������', 'YML_REFERER', 'stock', '�������� � ����� ������ �������� � ������� �� User agent ��� ip?', 999, 2, NULL, NOW(), NULL, 'zen_cfg_select_option(array(\'false\', \'ip\', \'agent\'),');
insert into configuration values ('', '����', 'YML_STRIP_TAGS', 'true', '������� html-���� � �������?', 999, 2, NULL, NOW(), NULL, 'zen_cfg_select_option(array(\'false\', \'true\'),');
insert into configuration values ('', '������������� � UTF-8', 'YML_UTF8', 'true', '�������������� � UTF-8?', 999, 2, NULL, NOW(), NULL, 'zen_cfg_select_option(array(\'false\', \'true\'),');

insert into configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) values ('', '������-������', '���������������� ������-������', '99', '1');
update configuration set configuration_group_id=last_insert_id() where configuration_group_id='999';
*/

 require('includes/application_top.php');
 require('inc/xtc_round.inc.php');

if (!defined('YML_NAME')) define('YML_NAME','');
if (!defined('YML_COMPANY')) define('YML_COMPANY','');
if (!defined('YML_AVAILABLE')) define('YML_AVAILABLE','stock');
if (!defined('YML_DELIVERYINCLUDED')) define('YML_DELIVERYINCLUDED','false');
if (!defined('YML_AUTH_USER')) define('YML_AUTH_USER','');
if (!defined('YML_AUTH_PW')) define('YML_AUTH_PW','');
if (!defined('YML_REFERER')) define('YML_REFERER','false');
if (!defined('YML_STRIP_TAGS')) define('YML_STRIP_TAGS','true');
if (!defined('YML_UTF8')) define('YML_UTF8','false');

$yml_referer = (YML_REFERER == 'false' ? "" : (YML_REFERER == 'ip' ? '&amp;ref_ip=' . $_SERVER["REMOTE_ADDR"] : '&amp;ref_ua=' . $_SERVER["HTTP_USER_AGENT"]));

if (YML_AUTH_USER != "" && YML_AUTH_PW != "") {
	if (!isset($PHP_AUTH_USER) || $PHP_AUTH_USER != YML_AUTH_USER || $PHP_AUTH_PW != YML_AUTH_PW) {
		header('WWW-Authenticate: Basic realm="Realm-Name"');
		header("HTTP/1.0 401 Unauthorized");
		die;
	} 
}

$charset = (YML_UTF8 == 'true') ? 'utf-8' : $_SESSION['language_charset'];

$manufacturers_array = array();

header('Content-Type: text/xml');

echo "<?xml version=\"1.0\" encoding=\"" . $charset ."\"?><!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n" .
		 "<yml_catalog date=\"" . date('Y-m-d H:i') . "\">\n\n" .
		 "<shop>\n" .
		 "<name>" . _clear_string((YML_NAME == "" ? STORE_NAME : YML_NAME)) ."</name>\n" .
		 "<company>" . _clear_string((YML_COMPANY == "" ? STORE_OWNER : YML_COMPANY)) . "</company>\n" .
		 "<url>" . HTTP_SERVER . "/</url>\n\n";

echo "  <currencies>\n";
foreach($xtPrice->currencies as $code => $v){
	echo "    <currency id=\"" . $code . "\" rate=\"" . number_format(1/$v["value"],4) . "\"/>\n";
}
echo "  </currencies>\n\n";

echo "  <categories>\n";
$categories_to_xml_query = xtc_db_query('describe ' . TABLE_CATEGORIES . ' categories_to_xml');
$categories_query = xtc_db_query("select c.categories_id, cd.categories_name, c.parent_id " .((xtc_db_num_rows($categories_to_xml_query) > 0) ? ", c.categories_to_xml " : "") . "
														from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
														where c.categories_status = '1'
															and c.categories_id = cd.categories_id
															and cd.language_id='" . (int)$languages_id ."'
														order by c.parent_id, c.sort_order, cd.categories_name"
													);
$categories_disable = array();
while ($categories = xtc_db_fetch_array($categories_query)) {
	if (!isset($categories["categories_to_xml"]) || $categories["categories_to_xml"] == 1) {
		echo "<category id=\"" . $categories["categories_id"] . "\"" .
				 (($categories["parent_id"] == "0") ? ">" : " parentId=\"" . $categories["parent_id"] . "\">" ) .
				 _clear_string($categories["categories_name"]) .
				 "</category>\n";
	} else {
		$categories_disable[] = $categories["categories_id"];
	}
}
echo "  </categories>\n";

echo"<offers>\n";
$products_short_desc_query = xtc_db_query('describe ' . TABLE_PRODUCTS_DESCRIPTION . ' products_short_description');
$products_to_xml_query = xtc_db_query('describe ' . TABLE_PRODUCTS . ' products_to_xml');
$products_sql = "select p.products_id, p.products_model, p.products_quantity, p.products_image, p.products_price, products_tax_class_id, p.manufacturers_id, pd.products_name, p2c.categories_id, pd.products_description" .
								((xtc_db_num_rows($products_short_desc_query) > 0) ? ", pd.products_short_description " : " ") . ", l.code as language " .
								"from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_LANGUAGES . " l
								 where p.products_id = pd.products_id
									 and p.products_status = 1" .
									 ((xtc_db_num_rows($products_to_xml_query) > 0) ? " and p.products_to_xml = 1" : "") .
								 " and p.products_id = p2c.products_id
									 and pd.language_id = " . (int)$languages_id . "
									 and p.products_price > 0
									 and l.languages_id=pd.language_id
								 order by pd.products_name";
$products_query = xtc_db_query($products_sql);
$prev_prod['products_id'] = 0;
$cats_id = array();

for ($iproducts = 0, $nproducts = xtc_db_num_rows($products_query); $iproducts <= $nproducts; $iproducts++) {
	$products = xtc_db_fetch_array($products_query);
	if ($prev_prod['products_id'] == $products['products_id']) {
		if (!in_array($products['categories_id'], $categories_disable)) {
			$cats_id[] = $products['categories_id'];
		}
	} else {
		if (sizeof($cats_id) > 0) {
		$available = "false";
			switch(YML_AVAILABLE) {
				case "stock":
					if($prev_prod['products_quantity'] > 0)
						$available = "true";
					else
						$available = "false";
					break;
				case "false":
				case "true":
					$available = YML_AVAILABLE;
					break;
			}

//			if ($products_price = xtc_get_products_special_price($prev_prod['products_id'])) {
			if ($products_price = $xtPrice->xtcGetPrice($prev_prod['products_id'], $format = false, 1, $prev_prod['products_tax_class_id'], $prev_prod['products_price'])) {
			} else {
				$products_price = $prev_prod['products_price'];
			}

			echo "<offer id=\"" . $prev_prod['products_id'] . "\" available=\"" . $available . "\">\n" .
					 "  <url>" . xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $prev_prod['products_id'] . '&amp;language=' . $prev_prod['language'] . $yml_referer, 'NONSSL', false) . "</url>\n" .
//					 "  <price>" . number_format(xtc_round(xtc_add_tax($products_price, xtc_get_tax_rate($prev_prod['products_tax_class_id']))*$currencies->currencies[$currency]['value'],$currencies->currencies[$currency]['decimal_places']),$currencies->currencies[$currency]['decimal_places'],'.','') . "</price>\n" .
					 "  <price>" . $xtPrice->xtcGetPrice($prev_prod['products_id'], $format = false, 1, $prev_prod['products_tax_class_id'], $prev_prod['products_price']) . "</price>\n" .
					 "  <currencyId>" . $currency . "</currencyId>\n";
			for ($ic=0,$nc=sizeof($cats_id); $ic < $nc; $ic++) {
				echo "  <categoryId>" . $cats_id[$ic] . "</categoryId>\n";
			}
			echo (xtc_not_null($prev_prod['products_image']) ? "<picture>" . dirname(HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . $prev_prod['products_image']) . "/" . urlencode(basename($prev_prod['products_image'])) . "</picture>\n" : "") .
					 (YML_DELIVERYINCLUDED == "true" ? "  <deliveryIncluded/>\n" : "") .
					 "  <name>" . _clear_string($prev_prod['products_name']) . "</name>\n";
			if ($prev_prod['manufacturers_id'] != 0) {
				if(!isset($manufacturers_array[$prev_prod['manufacturers_id']])) {
					$manufacturer_query = xtc_db_query("select manufacturers_name
																							from " . TABLE_MANUFACTURERS . "
																							where manufacturers_id ='" . $prev_prod['manufacturers_id'] . "'");
					$manufacturer = xtc_db_fetch_array($manufacturer_query);
					$manufacturers_array[$prev_prod['manufacturers_id']] = $manufacturer['manufacturers_name'];
				}
//				echo "  <vendor>" . _clear_string($manufacturers_array[$prev_prod['manufacturers_id']]) . "</vendor>\n";
			} 
			if (isset($prev_prod['products_short_description']) && xtc_not_null($prev_prod['products_short_description'])) {
				echo "  <description>" . _clear_string($prev_prod['products_short_description']) . "</description>\n";
			} elseif (xtc_not_null($prev_prod['products_description'])) {
				echo "  <description>" . _clear_string($prev_prod['products_description']) . "</description>\n";
			}
			echo "</offer>\n\n";
		}
		$prev_prod = $products;
		$cats_id = array();
		if (!in_array($products['categories_id'], $categories_disable)) {
			$cats_id[] = $products['categories_id'];
		}
	}
}
echo "</offers>\n" .
		 "</shop>\n" .
		 "</yml_catalog>\n";

	function _clear_string($str) {
		if (YML_STRIP_TAGS == 'true') {
			$str = strip_tags($str);
		}
		if (YML_UTF8 == 'true')
			$str = iconv($_SESSION['language_charset'], "UTF-8", $str);
		return htmlspecialchars($str, ENT_QUOTES);
	}
?>
<?php
/* -----------------------------------------------------------------------------------------
   $Id: search_filters.php 1262 2009-04-29 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// reset var
$box = new vamTemplate;
$box_content='';
$flag='';
$box->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

$box_content = MY_BOX_CONTENT;


$params_current = array();
$exlude = array('page', 'direction', 'info','x','y', 'p', 'c');
if (is_array($_GET) && sizeof($_GET) > 0)
{
    foreach($_GET as $key => $value)
    {
        if (preg_match("!^p([\d]+)$!", $key, $r))
        {
            $exlude[] = $key;
            $v = explode('-', $value);
            if (is_array($v) && sizeof($v) > 0)
                $params_current[$r[1]] = $v;
        }
    }
}

function get_params_to_str($exclude_param = -1, $exclude_value = -1, $include_param = -1, $include_value = -1)
{
    global $params_current;
    if (!is_array($params_current)) $params_current = array();


    $result = array();
    foreach($params_current as $k => $v)
    {
        $idx = array_search($exclude_value, $v);
        if ($k == $exclude_param && $idx !== false) unset($v[$idx]);
        if (!is_array($v)) $v = array();
        if ($include_param == $k && $include_value > -1 && !in_array($include_value, $v))
        {
            $v[] = ''.$include_value;
        }
        sort($v);
        if (is_array($v) && sizeof($v) > 0) $result[] = 'p'.$k.'='.implode('-', $v);
    }

    if ($include_param > -1 && $include_value > -1 && (!is_array($params_current[$include_param]) || sizeof($params_current[$include_param]) < 1))
    {
        $result[] = 'p'.$include_param.'='.$include_value;
    }
    return implode('&', $result);
}

$price_max = doubleval($_GET['price_max']);
$price_min = doubleval($_GET['price_min']);
$_GET['c'] = intval($_GET['c']);

$used_products_status = 1;
if (isset($_GET['status']))
{
    $used_products_status = -1;
    if ($_GET['status'] === 'all')
        $count_query = str_replace("and products_status = 1", "", $count_query);
    else
        $used_products_status = intval($_GET['status']);
}


$module_content = $params_list = $ids = array();

// получаем общий список параметров для категории
$parameters_all_query = vamDBquery("SELECT products_parameters.* FROM products_parameters WHERE categories_id = ".intval($_GET['cat']).' and products_parameters_useinsearch = 1 ORDER by products_parameters_order');
while ($row = vam_db_fetch_array($parameters_all_query, true))
{
    $ids[] = $row['products_parameters_id'];
    $row['products_parameters_intervals'] = unserialize($row['products_parameters_intervals']);

    // если параметр с интервалами - формируем список значений
    if (is_array($row['products_parameters_intervals']) && sizeof($row['products_parameters_intervals']) > 0)
    {
        foreach($row['products_parameters_intervals'] as $num => $interval)
        {
            // для параметров с интервалами для указания значения используется номер интервала по порядку
            $is_selected = is_array($params_current[$row['products_parameters_id']]) && in_array($num, $params_current[$row['products_parameters_id']]);
            $params_list[$row['products_parameters_id']]['selected_count'] += $is_selected ? 1 : 0;

            $params_list[$row['products_parameters_id']]['hidden_count'] = 0;

            $row['values_list'][$num] = array('value' => $interval['title'],
                                              'count' => 0,
                                              'value_url_part' => vam_href_link(basename($PHP_SELF),vam_get_all_get_params($exlude).get_params_to_str(-1, -1, $row['products_parameters_id'], $num)),
                                              'value_url_part_exclude' => vam_href_link(basename($PHP_SELF),vam_get_all_get_params($exlude).get_params_to_str($row['products_parameters_id'], $num)),
                                              'is_selected' => $is_selected,
                                              'is_hidden' => false);
            $row['hidden_count'] += $row['products_parameters_maxopened'] > 0 &&  $num > $row['products_parameters_maxopened'] - 1 ? 1 : 0;
        }
    }
    else
        $row['products_parameters_intervals'] =  false;

    $row['is_selected'] = is_array($params_current[$row['products_parameters_id']]) && sizeof($params_current[$row['products_parameters_id']]) > 0;
    $params_list[$row['products_parameters_id']] = $row;
}

// получаем список всех значений для выбранных параметров, необходимо для правильной фильтрации
// заодно создаем список md5 значений, для получения списка ID товаров
$products_query = array(); // общая переменная для фильтрации товаров

$parameters_values_selected_list = array();
if (is_array($params_current) && sizeof($params_current) > 0)
{
    $parameters_values_query = vamDBquery("SELECT products_parameters2products.products_parameters_id, products_parameters2products_value, products_parameters2products_md5 FROM `products_parameters2products` LEFT JOIN products_parameters USING (products_parameters_id) WHERE products_parameters2products.products_parameters_id IN (".implode(", ", array_keys($params_current)).") and products_parameters.products_parameters_id IS NOT NULL and products_parameters2products_value <> '' GROUP by CONCAT(products_parameters2products.products_parameters_id, '_', products_parameters2products_md5) ORDER by products_parameters2products_value");
    while ($row = vam_db_fetch_array($parameters_values_query, true))
    {
        $parameters_values_selected_list[$row['products_parameters_id']]['values'][] = $row['products_parameters2products_value'];
        $parameters_values_selected_list[$row['products_parameters_id']]['md5'][] = $row['products_parameters2products_md5'];
    }

    // если список значений есть - переходим к фитрованию
    if (is_array($parameters_values_selected_list) && sizeof($parameters_values_selected_list) > 0)
    {
        $products_sub_query = array();
        foreach($params_current as $p_id => $p_values)
        {
            // если такой параметр существует (проверка на всякий пожарный)
            if (is_array($params_list[$p_id]))
            {
                $t_param_value = array();
                $intervals_values = array();

                // если у параметра заданы интервалы
                if (is_array($params_list[$p_id]['products_parameters_intervals']))
                {
                    foreach($p_values as $interval_num)
                    {
                        if (is_array($params_list[$p_id]['products_parameters_intervals'][$interval_num]['values']))
                        {
                            $t_param_value[] = $params_list[$p_id]['products_parameters_intervals'][$interval_num]['title'];
                            $intervals_values = array_merge($intervals_values, $params_list[$p_id]['products_parameters_intervals'][$interval_num]['values']);
                        }
                    }
                    if (is_array($intervals_values) && sizeof($intervals_values) > 0)
                    {
                        $products_sub_query[] = "products_parameters2products.products_parameters_id = ".$p_id." and products_parameters2products_md5 IN ('".implode("', '", $intervals_values)."')";
                        $products_sub_query1[$p_id][] = "products_parameters2products.products_parameters_id = ".$p_id." and products_parameters2products_md5 IN ('".implode("', '", $intervals_values)."')";
                    }
                    //echo "int $p_id<br />\r\n";
                    //print_r($intervals_values);
                }
                else
                {
                    foreach($p_values as $value_num)
                    {
                        $t_param_value[] = $parameters_values_selected_list[$p_id]['values'][$value_num];
                        if (!in_array($parameters_values_selected_list[$p_id]['md5'][$value_num], $intervals_values)) $intervals_values[] = $parameters_values_selected_list[$p_id]['md5'][$value_num];
                    }

                    if (is_array($intervals_values) && sizeof($intervals_values) > 0)
                    {
                        $products_sub_query[] = "products_parameters2products.products_parameters_id = ".$p_id." and products_parameters2products_md5 IN ('".implode("', '", $intervals_values)."')";
                        $products_sub_query1[$p_id][] = "products_parameters2products.products_parameters_id = ".$p_id." and products_parameters2products_md5 IN ('".implode("', '", $intervals_values)."')";
                    }
                    //echo "list $p_id<br />\r\n";
                    //print_r($intervals_values);
                }

                if (strpos($params_list[$p_id]['products_parameters_titlename'], '{values}') !== false)
                {
                    $meta_title_params[$params_list[$p_id]['products_parameters_order']][] = str_replace('{values}', implode(", ", $t_param_value)." ".$params_list[$p_id]['products_parameters_titlesuff'], $params_list[$p_id]['products_parameters_titlename']);
                }
                else
                    $meta_title_params[$params_list[$p_id]['products_parameters_order']][] = (!empty($params_list[$p_id]['products_parameters_titlename']) ? $params_list[$p_id]['products_parameters_titlename'] : $params_list[$p_id]['products_parameters_title'])." ".implode(", ", $t_param_value)." ".$params_list[$p_id]['products_parameters_titlesuff'];
            }
        }

        ksort($meta_title_params);
        $temp = array();
        foreach($meta_title_params as $tp)
        {
            foreach($tp as $t)
                $temp[] = $t;
        }
        $meta_title_params = $temp;

        if (is_array($products_sub_query) && sizeof($products_sub_query) > 0)
        {
            $products_query['md5'] = "(".implode(" or ", $products_sub_query).")";
        }
    }
}

// если зданы лимиты цен - накладываем ограничение по ним
if ($price_max > 0 || $price_min > 0)
{

    if (DEFAULT_CURRENCY != $_SESSION['currency'])
    {
        $currencies = array();                                                                //'".DEFAULT_CURRENCY."',
        $currency_query = vam_db_query("SELECT value FROM ".TABLE_CURRENCIES." WHERE code IN ('".addcslashes($_SESSION['currency'], "'")."')");
        $currency = vam_db_fetch_array($currency_query);

        //if ($currency['value']) $currency['value'] = 1;

        $price_max = $price_max / $currency['value'];
        $price_min = $price_min / $currency['value'];
    }

    if (!isset($search_by_params_ids)) $search_by_params_ids = "";

    if ($price_min > 0)
        $products_query[] = 'products_price >= '.$price_min.'';
    if ($price_max > 0)
        $products_query[] = 'products_price <= '.$price_max.'';
}

// если заданы ограничения получаем ID товаров
if (is_array($products_query) && sizeof($products_query) > 0)
{
    if ($used_products_status > -1) $products_query[] = 'products_status = '.$used_products_status;

    if (isset($products_query['md5']))
        $r = vamDBquery("SELECT DISTINCT products_parameters2products.products_parameters_id, products_parameters2products.products_id FROM products_parameters2products LEFT JOIN products USING(products_id) WHERE products.products_id IS NOT NULL and ".implode(' and ', $products_query));
    else
        $r = vamDBquery("SELECT DISTINCT products_id FROM products WHERE ".implode(' and ', $products_query));
    //echo "<br>"."SELECT DISTINCT products_parameters2products.products_id FROM products_parameters2products LEFT JOIN products USING(products_id) WHERE products.products_id IS NOT NULL and ".implode(' and ', $products_query)."<br>".mysql_error()."<br>";
    $products_ids = array(-1);
    while($row = mysql_fetch_assoc($r))
    {
        $products_ids[] = $row['products_id'];
    }

    //if (is_array($products_sub_query) && sizeof($products_sub_query) > 1)
    if (is_array($products_sub_query1) && sizeof($products_sub_query1) > 1)
    {
        $products_ids1 = array();
        foreach($products_sub_query1 as $psq)
        {
            $psq = implode(' or ', $psq);
            $temp = array();
            $r = vamDBquery("SELECT DISTINCT products_parameters2products.products_parameters_id, products_parameters2products.products_id FROM products_parameters2products LEFT JOIN products USING(products_id) WHERE products.products_id IS NOT NULL and ".$psq);
            while($row = mysql_fetch_assoc($r))
            {
                $temp[] = $row['products_id'];
            }
            $products_ids1 = sizeof($products_ids1) > 0 ? array_intersect($products_ids1, $temp) : $temp;
        }

        /*
        foreach($products_sub_query as $psq)
        {
            $temp = array();
            $r = vamDBquery("SELECT DISTINCT products_parameters2products.products_parameters_id, products_parameters2products.products_id FROM products_parameters2products LEFT JOIN products USING(products_id) WHERE products.products_id IS NOT NULL and ".$psq);
            //echo "<br>"."SELECT DISTINCT products_id FROM products WHERE ".$psq."<br>".mysql_error()."<br>";
            while($row = mysql_fetch_assoc($r))
            {
                $temp[$row['products_parameters_id']][] = $row['products_id'];
            }
        }
        foreach($temp as $p_id => $v)
        {
            if ($p_id != $_GET['c'] && is_array($v)) $products_ids1 = sizeof($products_ids1) > 0 ? array_intersect($products_ids1, $v) : $v;
        }
        if ($_GET['c'] > 0 && is_array($temp[$_GET['c']])) $products_ids1 = array_merge($products_ids1, $temp[$_GET['c']]);
        */

        $products_ids1[] = '-1';
    }
    else
        $products_ids1 = $products_ids;

    $search_by_params_ids = 'pd.products_id IN ('.implode(', ', $products_ids1).') and ';
}

if (is_array($ids) && sizeof($ids) > 0)
{
    // повторно получаем все значения для параметров и количество товаров в них, с уже положенным фильтром
    // количество товаров считаем как сумму 1 если попал в список выбранных или 0 если не попал
    if (is_array($products_ids) && sizeof($products_ids) > 0)
    {
        $parameters_count_query = vamDBquery("SELECT products_parameters_id, products_parameters2products_value, products_parameters2products_md5, SUM(IF(products_id IN (".implode(', ', $products_ids).") or products_parameters2products.products_parameters_id = ".intval($_GET['c']).", 1, 0)) as `count` FROM `products_parameters2products` WHERE products_parameters2products.products_parameters_id IN (".implode(", ", $ids).") and products_parameters2products_value <> '' GROUP by CONCAT(products_parameters2products.products_parameters_id, '_', products_parameters2products_md5) ORDER by products_parameters2products_value");
        //echo "<br>"."SELECT products_parameters_id, products_parameters2products_value, products_parameters2products_md5, SUM(IF(products_id IN (".implode(', ', $products_ids).") or products_parameters2products.products_parameters_id = ".intval($_GET['c']).", 1, 0)) as `count` FROM `products_parameters2products` WHERE products_parameters2products.products_parameters_id IN (".implode(", ", $ids).") and products_parameters2products_value <> '' GROUP by CONCAT(products_parameters2products.products_parameters_id, '_', products_parameters2products_md5) ORDER by products_parameters2products_value"."<br>".mysql_error()."<br>";
    }
    else
    {
        $parameters_count_query = vamDBquery("SELECT products_parameters_id, products_parameters2products_value, products_parameters2products_md5, SUM(IF(".($used_products_status > -1 ? 'products_status = '.$used_products_status : '1=1').", 1, 0)) as `count` FROM `products_parameters2products` LEFT JOIN products USING (products_id) WHERE products_parameters2products.products_parameters_id IN (".implode(", ", $ids).") and products_parameters2products_value <> '' GROUP by CONCAT(products_parameters2products.products_parameters_id, '_', products_parameters2products_md5) ORDER by products_parameters2products_value");
        //echo "<br>"."SELECT products_parameters_id, products_parameters2products_value, products_parameters2products_md5, SUM(IF(".($used_products_status > -1 ? 'products_status = '.$used_products_status : '1=1').", 1, 0)) as `count` FROM `products_parameters2products` LEFT JOIN products USING (products_id) WHERE products_parameters2products.products_parameters_id IN (".implode(", ", $ids).") and products_parameters2products_value <> '' GROUP by CONCAT(products_parameters2products.products_parameters_id, '_', products_parameters2products_md5) ORDER by products_parameters2products_value"."<br>".mysql_error()."<br>";
    }
    while ($row = vam_db_fetch_array($parameters_count_query, true))
    {
        // если такой параметр существует (проверка на всякий пожарный)
        if (is_array($params_list[$row['products_parameters_id']]))
        {
            // если у параметра заданы интервалы
            if (is_array($params_list[$row['products_parameters_id']]['products_parameters_intervals']))
            {
                // пересчитываем количество, учитывая попадает ли полученное значение в интервал
                foreach($params_list[$row['products_parameters_id']]['products_parameters_intervals'] as $num => $interval)
                {
                    if (in_array($row['products_parameters2products_md5'], $interval['values']))
                    {
                        $params_list[$row['products_parameters_id']]['values_list'][$num]['count'] += $row['count'];
                        break;
                    }
                }
            }
            // если параметр без интервалов, добавляем значение в список
            else
            {
                // для параметров без интервалов для указания значения используется его номер по алфавиту

                // получаем индекс значения - это размер массива значений
                $num = !is_array($params_list[$row['products_parameters_id']]['values_list']) ? 0 : sizeof($params_list[$row['products_parameters_id']]['values_list']);
                $is_selected = is_array($params_current[$row['products_parameters_id']]) && in_array($num, $params_current[$row['products_parameters_id']]);
                $params_list[$row['products_parameters_id']]['selected_count'] += $is_selected ? 1 : 0;

                $is_hidden = !$is_selected && $row['count'] > 0 && $params_list[$row['products_parameters_id']]['products_parameters_maxopened'] > 0 && $params_list[$row['products_parameters_id']]['unhidden_count'] >= $params_list[$row['products_parameters_id']]['products_parameters_maxopened'];
                $params_list[$row['products_parameters_id']]['disabled_count'] = $row['count'] > 0 ? 0 : 1;
                $params_list[$row['products_parameters_id']]['unhidden_count'] += !$is_hidden && !$is_selected && $row['count'] > 0 ? 1 : 0;
                $params_list[$row['products_parameters_id']]['hidden_count'] += $is_hidden ? 1 : 0;//= sizeof($params_list[$row['products_parameters_id']]['values_list']) - $params_list[$row['products_parameters_id']]['unhidden_count'] - $params_list[$row['products_parameters_id']]['selected_count'] + 1 - $params_list[$row['products_parameters_id']]['disabled_count'];
                if ($_GET['d'] && $row['products_parameters_id'] == 3)
                {
                    echo '$is_selected = '.$is_selected.'<br />'.
                          '$is_hidden='.$is_hidden.'<br />'.
                          'disabled_count='.$params_list[$row['products_parameters_id']]['disabled_count'].'<br />'.
                          'unhidden_count='.$params_list[$row['products_parameters_id']]['unhidden_count'].'<br />'.
                          'hidden_count='.$params_list[$row['products_parameters_id']]['hidden_count'].'<hr>';

                }

                $params_list[$row['products_parameters_id']]['values_list'][$row['products_parameters2products_md5']] = array('value' => $row['products_parameters2products_value'],
                                                                                                                                'count' => $row['count'],
                                                                                                                                'value_url_part' => vam_href_link(basename($PHP_SELF),vam_get_all_get_params($exlude).get_params_to_str(-1, -1, $row['products_parameters_id'], $num)),
                                                                                                                                'value_url_part_exclude' => vam_href_link(basename($PHP_SELF),vam_get_all_get_params($exlude).get_params_to_str($row['products_parameters_id'], $num)),
                                                                                                                                'is_selected' => $is_selected,
                                                                                                                                'is_hidden' => $is_hidden);
            }
        }
    }
}

$current_filters = array();
if (is_array($params_current))
{
    foreach($params_current as $k => $p)
    {
	    $current_filters[] = array('name' => 'p'.$k, 'value' => implode('-', $p));
    }
}

$box->assign('categories_id', intval($_GET['cat']));
$box->assign('params_list', $params_list);
$box->assign('current_filters', $current_filters);
$box->assign('price_min', $_GET['price_min']);
$box->assign('price_max', $_GET['price_max']);
$box->assign('filtes_url', $filtes_url);

if ($flag==true) define('SEARCH_ENGINE_FRIENDLY_URLS',true);

$box->caching = 0;
$box->assign('language', $_SESSION['language']);
$box_admin= $box->fetch(CURRENT_TEMPLATE.'/boxes/box_search_filters.html');
$vamTemplate->assign('box_SEARCH_FILTERS',$box_admin);

?>
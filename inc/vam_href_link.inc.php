<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_href_link.inc.php 804 2007-02-07 10:51:57 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(html_output.php,v 1.52 2003/03/19); www.oscommerce.com 
   (c) 2003      nextcommerce (vam_href_link.inc.php,v 1.3 2003/08/13); www.nextcommerce.org
   (c) 2004 xt:Commerce (vam_href_link.inc.php,v 1.3 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
  // Categories/Products URL begin
  function vam_href_link($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true)
  {
    $param_array = array();
    $params = '';
    $action = '';
    $products_id = '';
    $sort = '';
    $direction = '';
    $filter_id = '';
    $on_page = '';
    $q = '';
    $price_min = '';
    $price_max = '';
    $manufacturers_id = '';
    $language = '';
    $currency = '';
    $page_num = '';
    $matches = array();

    if ($page == FILENAME_DEFAULT) {
      if (strpos($parameters, 'cat') === false && strpos($parameters, 'manufacturers_id') === false) {
        return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
      } else {
        $categories_id = -1;
        $param_array = explode('&', $parameters);

        for ($i = 0, $n = sizeof($param_array); $i < $n; $i++) {
          $parsed_param = explode('=', $param_array[$i]);
          if ($parsed_param[0] === 'cat') {
            $pos = strrpos($parsed_param[1], '_');
            if ($pos === false) {
              $categories_id = $parsed_param[1];
            } else {  
              if (preg_match('/^c(.*)_/', $parsed_param[1], $matches)) {
                $categories_id = $matches[1];
              }
            }
          } elseif ($parsed_param[0] === 'action') {
            $action = $parsed_param[1];
          } elseif ($parsed_param[0] === 'BUYproducts_id') {
            $products_id = $parsed_param[1];
          } elseif ($parsed_param[0] === 'sort') {
            $sort = $parsed_param[1];
          } elseif ($parsed_param[0] === 'direction') {
            $direction = $parsed_param[1];
          } elseif ($parsed_param[0] === 'filter_id') {
            $filter_id = $parsed_param[1];
          } elseif ($parsed_param[0] === 'language') {
            $language = $parsed_param[1];
          } elseif ($parsed_param[0] === 'currency') {
            $currency = $parsed_param[1];
          } elseif ($parsed_param[0] === 'q') {
            $q = $parsed_param[1];
           } elseif ($parsed_param[0] === 'p') {
            $p = $parsed_param[1];
          } elseif ($parsed_param[0] === 'price_min') {
            $price_min = $parsed_param[1];
          } elseif ($parsed_param[0] === 'price_max') {
            $price_max = $parsed_param[1];
	       } elseif ($parsed_param[0] === 'manufacturers_id') {
            $manufacturers_id = $parsed_param[1];            
          } elseif ($parsed_param[0] === 'on_page') {
            if (vam_not_null($parsed_param[1])) {
              $on_page = $parsed_param[1];
            } else {
              $on_page = -1;
            }
          } elseif ($parsed_param[0] === 'page') {
            $page_num = $parsed_param[1];
          }
        }

        $categories_url = vamDBquery('select categories_url from ' . TABLE_CATEGORIES . ' where categories_id="' . $categories_id . '"');
        $categories_url = vam_db_fetch_array($categories_url,true);
        $categories_url = $categories_url['categories_url'];

        if ($categories_url == '' && $manufacturers_id > 0) {
        $categories_url = vamDBquery('select manufacturers_seo_url from ' . TABLE_MANUFACTURERS . ' where manufacturers_id="' . $manufacturers_id . '"');
        $categories_url = vam_db_fetch_array($categories_url,true);
        $categories_url = $categories_url['manufacturers_seo_url'];
        }


        if ($categories_url == '') {
          return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
        } else {
// BOF cat2brand
          if (!empty($filter_id)) {
//            echo '<pre>';var_export($filter_id);echo '</pre>';
            $sql = "SELECT s.*
                    FROM " . TABLE_SPECIFICATION . " AS s
                    WHERE products_column_name = 'manufacturers_id'";
//            echo '<pre>';var_export($sql);echo '</pre>';
            $specification_query = vamDBquery($sql);
            $specification = vam_db_fetch_array($specification_query);
            $sql = "SELECT m.*
                    FROM " . TABLE_MANUFACTURERS . " AS m
                    WHERE manufacturers_id = " . (int)$filter_id;
//            echo '<pre>';var_export($sql);echo '</pre>';
            $manufacturers_query = vamDBquery($sql);
            $manufacturers = vam_db_fetch_array($manufacturers_query);
            if (!empty($specification['specifications_id']) && !empty($manufacturers['manufacturers_name'])) {
//              echo '<pre>';var_export($specification);echo '</pre>';
//              echo '<pre>';var_export($manufacturers);echo '</pre>';
              $query = vam_get_path($categories_id) . '&cat=' . $categories_id . '&f' . $specification['specifications_id'] . '[]=' . $manufacturers['manufacturers_name'];
              parse_str($parameters, $get);
              unset($get['cPath']);
              unset($get['cat']);
              unset($get['filter_id']);
              $parms = http_build_query($get);
              if (!empty($parms)) $query .= '&' . $parms;
//              echo '<pre>';var_export($query);echo '</pre>';
              $link = vam_href_link(FILENAME_PRODUCTS_FILTERS, $query);
//              echo '<pre>';var_export($link);echo '</pre>';
              return $link;
            }
          }
// EOF cat2brand

          if ($connection == 'NONSSL') {
            $link = HTTP_SERVER;
          } elseif ($connection == 'SSL') {
            if (ENABLE_SSL == 'true') {
              $link = HTTPS_SERVER ;
            } else {
              $link = HTTP_SERVER;
            }
          } else {
            die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL</strong><br /><br />');
          }

          if ($connection == 'SSL' && ENABLE_SSL == 'true') {
            //$link .= DIR_WS_HTTPS_CATALOG;
            $link .= DIR_WS_CATALOG;
          } else {
            $link .= DIR_WS_CATALOG;
          }

          if (vam_not_null($action)) {
            $params .= '&action=' . $action;
          }

          if (vam_not_null($products_id)) {
            $params .= '&BUYproducts_id=' . $products_id;
          }

          if (vam_not_null($sort)) {
            $params .= '&sort=' . $sort;
          }

          if (vam_not_null($direction)) {
            $params .= '&direction=' . $direction;
          }

          if (vam_not_null($filter_id)) {
            $params .= '&filter_id=' . $filter_id;
          }

          if (vam_not_null($language)) {
            $params .= '&language=' . $language;
          }

          if (vam_not_null($currency)) {
            $params .= '&currency=' . $currency;
          }

          if (vam_not_null($q)) {
            $params .= '&q=' . $q;
          }

          if (vam_not_null($price_min)) {
            $params .= '&price_min=' . $price_min;
          }

          if (vam_not_null($price_max)) {
            $params .= '&price_max=' . $price_max;
          }

          //if (vam_not_null($manufacturers_id)) {
            //$params .= '&manufacturers_id=' . $manufacturers_id;
          //}

          if ($on_page === -1) {
            $params .= '&on_page=';
          } elseif ($on_page > 0) {
            $params .= '&on_page=' . $on_page;
          }

          if (vam_not_null($page_num)) {
            $params .= '&page=' . $page_num;
          }


          if (vam_not_null($params)) {
            if (strpos($params, '&') === 0) {
              $params = substr($params, 1);
            }
            
            $params = str_replace('&', '&amp;', $params);

            $categories_url .= '?' . $params;
          }

          return $link . $categories_url;
        }
      }
    } elseif ($page == FILENAME_PRODUCT_INFO) {

      $products_id = -1;
      $action = '';
      $language = '';
      $currency = '';
      $param_array = explode('&', $parameters);

      for ($i = 0, $n = sizeof($param_array); $i < $n; $i++) {
        $parsed_param = explode('=', $param_array[$i]);
        if ($parsed_param[0] === 'products_id') {
          $products_id = $parsed_param[1];
        } elseif ($parsed_param[0] === 'action') {
          $action = $parsed_param[1];
        } elseif ($parsed_param[0] === 'language') {
          $language = $parsed_param[1];
        } elseif ($parsed_param[0] === 'currency') {
          $currency = $parsed_param[1];
        } elseif ($parsed_param[0] === 'info') {
          if (preg_match('/^p(.*)_/', $parsed_param[1], $matches)) {
            $products_id = $matches[1];
          }
        }
      }

      $products_page_url = vamDBquery('select products_page_url from ' . TABLE_PRODUCTS . ' where products_id="' . $products_id . '"');
      $products_page_url = vam_db_fetch_array($products_page_url,true);
      $products_page_url = $products_page_url['products_page_url'];

      if ($products_page_url == '') {
        return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
      } else {

          if ($connection == 'NONSSL') {
            $link = HTTP_SERVER;
          } elseif ($connection == 'SSL') {
            if (ENABLE_SSL == 'true') {
              $link = HTTPS_SERVER ;
            } else {
              $link = HTTP_SERVER;
            }
          } else {
            die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL</strong><br /><br />');
          }

          if ($connection == 'SSL' && ENABLE_SSL == 'true') {
            //$link .= DIR_WS_HTTPS_CATALOG;
            $link .= DIR_WS_CATALOG;
          } else {
            $link .= DIR_WS_CATALOG;
          }

          if (vam_not_null($action)) {
            $products_page_url .= '?action=' . $action;
          }

          if (vam_not_null($language)) {
            $products_page_url .= '?language=' . $language;
          }

          if (vam_not_null($currency)) {
            $products_page_url .= '?currency=' . $currency;
          }

          return $link . $products_page_url;
      }

    } elseif ($page == FILENAME_ARTICLE_INFO) {

      $a_id = -1;
      $param_array = explode('&', $parameters);

      for ($i = 0, $n = sizeof($param_array); $i < $n; $i++) {
        $parsed_param = explode('=', $param_array[$i]);
        if ($parsed_param[0] === 'articles_id') {
          $a_id = $parsed_param[1];
        } elseif ($parsed_param[0] === 'language') {
          $language = $parsed_param[1];
        } elseif ($parsed_param[0] === 'currency') {
          $currency = $parsed_param[1];
        } 
      }

      $a_url = vamDBquery('select articles_page_url from ' . TABLE_ARTICLES . ' where articles_id="' . $a_id . '"');
      $a_url = vam_db_fetch_array($a_url,true);
      $a_url = $a_url['articles_page_url'];

      if ($a_url == '') {
        return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
      } else {

          if ($connection == 'NONSSL') {
            $link = HTTP_SERVER;
          } elseif ($connection == 'SSL') {
            if (ENABLE_SSL == 'true') {
              $link = HTTPS_SERVER ;
            } else {
              $link = HTTP_SERVER;
            }
          } else {
            die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL</strong><br /><br />');
          }

          if ($connection == 'SSL' && ENABLE_SSL == 'true') {
            //$link .= DIR_WS_HTTPS_CATALOG;
            $link .= DIR_WS_CATALOG;
          } else {
            $link .= DIR_WS_CATALOG;
          }

          if (vam_not_null($language)) {
            $a_url .= '?language=' . $language;
          }

          if (vam_not_null($currency)) {
            $a_url .= '?currency=' . $currency;
          }

          return $link . $a_url;
      }

    } elseif ($page == FILENAME_NEWS) {

      $n_id = -1;
      $param_array = explode('&', $parameters);

      for ($i = 0, $n = sizeof($param_array); $i < $n; $i++) {
        $parsed_param = explode('=', $param_array[$i]);
        if ($parsed_param[0] === 'news_id') {
          $n_id = $parsed_param[1];
        } elseif ($parsed_param[0] === 'language') {
          $language = $parsed_param[1];
        } elseif ($parsed_param[0] === 'currency') {
          $currency = $parsed_param[1];
        } 
      }

      $n_url = vamDBquery('select news_page_url from ' . TABLE_LATEST_NEWS . ' where news_id="' . $n_id . '"');
      $n_url = vam_db_fetch_array($n_url,true);
      $n_url = $n_url['news_page_url'];

      if ($n_url == '') {
        return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
      } else {

          if ($connection == 'NONSSL') {
            $link = HTTP_SERVER;
          } elseif ($connection == 'SSL') {
            if (ENABLE_SSL == 'true') {
              $link = HTTPS_SERVER ;
            } else {
              $link = HTTP_SERVER;
            }
          } else {
            die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL</strong><br /><br />');
          }

          if ($connection == 'SSL' && ENABLE_SSL == 'true') {
            //$link .= DIR_WS_HTTPS_CATALOG;
            $link .= DIR_WS_CATALOG;
          } else {
            $link .= DIR_WS_CATALOG;
          }

          if (vam_not_null($language)) {
            $n_url .= '?language=' . $language;
          }

          if (vam_not_null($currency)) {
            $n_url .= '?currency=' . $currency;
          }

          return $link . $n_url;
      }

    } elseif ($page == FILENAME_FAQ) {

      $f_id = -1;
      $param_array = explode('&', $parameters);

      for ($i = 0, $n = sizeof($param_array); $i < $n; $i++) {
        $parsed_param = explode('=', $param_array[$i]);
        if ($parsed_param[0] === 'faq_id') {
          $f_id = $parsed_param[1];
        } elseif ($parsed_param[0] === 'language') {
          $language = $parsed_param[1];
        } elseif ($parsed_param[0] === 'currency') {
          $currency = $parsed_param[1];
        } 
      }

      $f_url = vamDBquery('select faq_page_url from ' . TABLE_FAQ . ' where faq_id="' . $f_id . '"');
      $f_url = vam_db_fetch_array($f_url,true);
      $f_url = $f_url['faq_page_url'];

      if ($f_url == '') {
        return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
      } else {

          if ($connection == 'NONSSL') {
            $link = HTTP_SERVER;
          } elseif ($connection == 'SSL') {
            if (ENABLE_SSL == 'true') {
              $link = HTTPS_SERVER ;
            } else {
              $link = HTTP_SERVER;
            }
          } else {
            die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL</strong><br /><br />');
          }

          if ($connection == 'SSL' && ENABLE_SSL == 'true') {
            //$link .= DIR_WS_HTTPS_CATALOG;
            $link .= DIR_WS_CATALOG;
          } else {
            $link .= DIR_WS_CATALOG;
          }

          if (vam_not_null($language)) {
            $f_url .= '?language=' . $language;
          }

          if (vam_not_null($currency)) {
            $f_url .= '?currency=' . $currency;
          }

          return $link . $f_url;
      }

    } elseif ($page == FILENAME_ARTICLES) {

      $tPath = -1;
      $action = '';
      $language = '';
      $currency = '';
      $page_num = '';
      $param_array = explode('&', $parameters);

      if (strpos($parameters, 'tPath') === false) {
        return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
      } else {
        $t_id = -1;
        $param_array = explode('&', $parameters);

        for ($i = 0, $n = sizeof($param_array); $i < $n; $i++) {
          $parsed_param = explode('=', $param_array[$i]);
          if ($parsed_param[0] === 'tPath') {
            $pos = strrpos($parsed_param[1], '_');
            if ($pos === false) {
              $t_id = $parsed_param[1];
            } else {  
              if (preg_match('/^c(.*)_/', $parsed_param[1], $matches)) {
                $t_id = $matches[1];
              }
            }
          } elseif ($parsed_param[0] === 'language') {
            $language = $parsed_param[1];
          } elseif ($parsed_param[0] === 'currency') {
            $currency = $parsed_param[1];
          } elseif ($parsed_param[0] === 'page') {
            $page_num = $parsed_param[1];
          }
        }

      $t_url = vamDBquery('select topics_page_url from ' . TABLE_TOPICS . ' where topics_id="' . $t_id . '"');
      $t_url = vam_db_fetch_array($t_url,true);
      $t_url = $t_url['topics_page_url'];

        if ($t_url == '') {
          return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
        } else {

          if ($connection == 'NONSSL') {
            $link = HTTP_SERVER;
          } elseif ($connection == 'SSL') {
            if (ENABLE_SSL == 'true') {
              $link = HTTPS_SERVER ;
            } else {
              $link = HTTP_SERVER;
            }
          } else {
            die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL</strong><br /><br />');
          }

          if ($connection == 'SSL' && ENABLE_SSL == 'true') {
            //$link .= DIR_WS_HTTPS_CATALOG;
            $link .= DIR_WS_CATALOG;
          } else {
            $link .= DIR_WS_CATALOG;
          }

          if (vam_not_null($language)) {
            $params .= '&language=' . $language;
          }

          if (vam_not_null($currency)) {
            $params .= '&currency=' . $currency;
          }

          if (vam_not_null($page_num)) {
            $params .= '&page=' . $page_num;
          }


          if (vam_not_null($params)) {
            if (strpos($params, '&') === 0) {
              $params = substr($params, 1);
            }
            
            $params = str_replace('&', '&amp;', $params);

            $t_url .= '?' . $params;
          }

          return $link . $t_url;
            }
}

    } elseif ($page == FILENAME_CONTENT) {

      $co_id = -1;
      $param_array = explode('&', $parameters);

      for ($i = 0, $n = sizeof($param_array); $i < $n; $i++) {
        $parsed_param = explode('=', $param_array[$i]);
        if ($parsed_param[0] === 'coID') {
          $co_id = $parsed_param[1];
        } elseif ($parsed_param[0] === 'language') {
          $language = $parsed_param[1];
        } elseif ($parsed_param[0] === 'action') {
          $action = $parsed_param[1];
        } elseif ($parsed_param[0] === 'currency') {
          $currency = $parsed_param[1];
        } 
      }

      $co_url = vam_db_query('select content_page_url from ' . TABLE_CONTENT_MANAGER . ' where content_id="' . $co_id . '"');
      $co_url = vam_db_fetch_array($co_url);
      $co_url = $co_url['content_page_url'];

      if ($co_url == '') {
        return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
      } else {

          if ($connection == 'NONSSL') {
            $link = HTTP_SERVER;
          } elseif ($connection == 'SSL') {
            if (ENABLE_SSL == 'true') {
              $link = HTTPS_SERVER ;
            } else {
              $link = HTTP_SERVER;
            }
          } else {
            die('</td></tr></table></td></tr></table><br /><br /><strong class="note">Error!<br /><br />Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL</strong><br /><br />');
          }

          if ($connection == 'SSL' && ENABLE_SSL == 'true') {
            //$link .= DIR_WS_HTTPS_CATALOG;
            $link .= DIR_WS_CATALOG;
          } else {
            $link .= DIR_WS_CATALOG;
          }

          if (vam_not_null($language)) {
            $co_url .= '?language=' . $language;
          }

          if (vam_not_null($action)) {
            $co_url .= '?action=' . $action;
          }

          if (vam_not_null($currency)) {
            $co_url .= '?currency=' . $currency;
          }

          return $link . $co_url;
      }
// BOF products_filters_seo
    } elseif ($page == FILENAME_PRODUCTS_FILTERS) {
      define('TABLE_SPECIFICATION_URL', 'specification_url');
      static $filter_no_seo;
      static $specification_url_cache = array();
      if (!isset($filter_no_seo)) {
        $filter_no_seo = array();
        $sql = "SELECT *
                FROM " . TABLE_SPECIFICATION . "
                WHERE specification_seo_active = 0";
        $specification_seo_active_query = vamDBquery($sql);
        while ($specification_seo_active = vam_db_fetch_array($specification_seo_active_query)) {
          $filter_no_seo[$specification_seo_active['specifications_id']] = $specification_seo_active['specifications_id'];
        }
      }
//error_log(__LINE__ . ': ' . ' $parameters=' . var_export($parameters, true) . "\n", 3, __FILE__.'.log');
      parse_str($parameters, $get);
//error_log(__LINE__ . ': ' . ' $get=' . var_export($get, true) . "\n", 3, __FILE__.'.log');
      ksort($get);
//error_log(__LINE__ . ': ' . ' $get=' . var_export($get, true) . "\n", 3, __FILE__.'.log');
      $parameters = http_build_query($get);
//error_log(__LINE__ . ': ' . ' $parameters=' . var_export($parameters, true) . "\n", 3, __FILE__.'.log');
//      $parameters = preg_replace('/%5B[0-9]+%5D/simU', '%5B%5D', $parameters);
      $parameters = preg_replace('/%5B[0-9]+%5D/simU', '[]', $parameters);
//error_log(__LINE__ . ': ' . ' $parameters=' . var_export($parameters, true) . "\n", 3, __FILE__.'.log');
      $get_in = $get;
      if (!isset($get['cat'])) {
        return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
      }

      if (($pos = strrpos($get['cat'], '_')) === false) {
        $categories_id = $get['cat'];
      } else {
        if (preg_match('/^c(.*)_/', $get['cat'], $matches)) {
          $categories_id = $matches[1];
        }
      }
      unset($get['cat']);
      unset($get['cPath']);
      if (sizeof($get) == 0) {
        return vam_href_link(FILENAME_DEFAULT, 'cat=' . $categories_id);
      }
      $categories_url_query = vamDBquery('select categories_url from ' . TABLE_CATEGORIES . ' where categories_id="' . $categories_id . '"');
      if (!($categories_url_data = vam_db_fetch_array($categories_url_query, true))) {
        return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
      }
      $categories_url = $categories_url_data['categories_url'];
      $categories_url = str_replace(array('.html', '.htm'), '', $categories_url);
      //$categories_url = strtolower(vam_cleanName($categories_url));
      $categories_url = strtolower($categories_url);

      $f_array = array();
//error_log(__LINE__ . ': ' . ' $get=' . var_export($get, true) . "\n", 3, __FILE__.'.log');
      foreach ($get as $key => $val) {
//        if (substr($key, 0, 1) == 'f') {
        if (preg_match('@^f[0-9]+$@', $key)) {
          if (is_array($val) && sizeof($val) > SPECIFICATIONS_FILTERS_SEO_MAX_FILTER_VALUES) {
            $f_array = array();
            break;
          }
          $specifications_id = substr($key, 1);
          if (!in_array($specifications_id, $filter_no_seo)) {
            $f_array[$specifications_id] = $val;
            unset($get[$key]);
          }
        }
      }
      if (sizeof($f_array) == 0 || sizeof($f_array) > SPECIFICATIONS_FILTERS_SEO_MAX_FILTER_IDS) {
//error_log(__LINE__ . ': ' . ' $parameters=' . var_export($parameters, true) . "\n", 3, __FILE__.'.log');
        return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
      }

      $s_get = array_diff_key($get_in, $get);
      ksort($s_get);
      foreach ($s_get as $k => $v) {
        if (is_array($v)) {
          sort($s_get[$k]);
        }
      }
      $specifications_request_query = http_build_query($s_get);
      $specifications_request_query = preg_replace('/%5B[0-9]+%5D/simU', '%5B%5D', $specifications_request_query);
//      $specifications_request_query = urldecode($specifications_request_query);

      if (isset($specification_url_cache[$specifications_request_query])) {
//error_log(__LINE__ . ': ' . ' $specifications_request_query=' . var_export($specifications_request_query, true) . "\n", 3, __FILE__.'.log');
//error_log(__LINE__ . ': ' . ' $specification_url_cache[$specifications_request_query]=' . var_export($specification_url_cache[$specifications_request_query], true) . "\n", 3, __FILE__.'.log');
//error_log(__LINE__ . ': ' . ' $get=' . var_export($get, true) . "\n", 3, __FILE__.'.log');
        $specifications_uri = $specification_url_cache[$specifications_request_query];
        $href = vam_href_link_original($specifications_uri, http_build_query($get, '&amp;'), $connection, $add_session_id, $search_engine_safe);
//error_log(__LINE__ . ': ' . ' $href=' . var_export($href, true) . "\n", 3, __FILE__.'.log');
        return $href;
      }
//error_log(__LINE__ . ': ' . ' $parameters=' . var_export($parameters, true) . "\n", 3, __FILE__.'.log');

      $specifications_uri_parts = array();

      $sql = "SELECT s.*, sd.*
              FROM " . TABLE_SPECIFICATION . " AS s
                INNER JOIN " . TABLE_SPECIFICATION_DESCRIPTION . " sd ON (sd.specifications_id = s.specifications_id AND sd.language_id = " . (int)$_SESSION['languages_id'] . ")
              WHERE s.specifications_id IN (" . implode(',', array_keys($f_array)) . ")
              ORDER BY s.specification_sort_order, sd.specification_name";
      $specification_query = vamDBquery($sql);
      while ($specification = vam_db_fetch_array($specification_query)) {
        if (empty($specification['specification_seo_url'])) {
          $specification['specification_seo_url'] = $specification['specification_name'];
        }
//error_log(__LINE__ . ': ' . ' $specification[specification_seo_url]=' . var_export($specification['specification_seo_url'], true) . "\n", 3, __FILE__.'.log');
        $specification['specification_seo_url'] = strtolower(vam_cleanName(trim($specification['specification_seo_url'])));
        $specification['specification_seo_url'] = preg_replace('@\-[\-]+@', '/', $specification['specification_seo_url']);
//error_log(__LINE__ . ': ' . ' $specification[specification_seo_url]=' . var_export($specification['specification_seo_url'], true) . "\n", 3, __FILE__.'.log');
        if (is_array($f_array[$specification['specifications_id']])) {
          sort($f_array[$specification['specifications_id']]);
          foreach ($f_array[$specification['specifications_id']] as $fk => $fv) {
            $f_array[$specification['specifications_id']][$fk] = trim($f_array[$specification['specifications_id']][$fk]);
          }
        } else {
          $f_array[$specification['specifications_id']] = trim($f_array[$specification['specifications_id']]);
        }
//error_log(__LINE__ . ': ' . ' $f_array[$specification[specifications_id]]=' . var_export($f_array[$specification['specifications_id']], true) . "\n", 3, __FILE__.'.log');
// BOF use filter_id
        if (!is_array($f_array[$specification['specifications_id']])) {
          $f_array[$specification['specifications_id']] = array($f_array[$specification['specifications_id']]);
        }
//error_log(__LINE__ . ': ' . ' $f_array[$specification[specifications_id]]=' . var_export($f_array[$specification['specifications_id']], true) . "\n", 3, __FILE__.'.log');
//error_log(__LINE__ . ': ' . ' $specification[products_column_name]=' . var_export($specification['products_column_name'], true) . "\n", 3, __FILE__.'.log');
        if ($specification['products_column_name'] == 'manufacturers_id') {
          $sql = "SELECT m.manufacturers_id as specification_filters_id,
                         m.manufacturers_name as filter
                  FROM " . TABLE_MANUFACTURERS . " m
                  WHERE m.manufacturers_id IN (" . implode(',', $f_array[$specification['specifications_id']]) . ")
                  ORDER BY m.manufacturers_name";
        } else {
        	$test = implode(" ", $f_array[$specification['specifications_id']]);
        	$test = explode(" ", $test);
        	$test = array_filter($test);
        	$test = implode(',', $test);
        	if (!$test) $test = 0;
        	//echo var_dump($test);
        	//echo var_dump($f_array[$specification['specifications_id']]);
          $sql = "SELECT sf.specification_filters_id,
                         sf.filter_sort_order,
                         sfd.filter
                  FROM " . TABLE_SPECIFICATIONS_FILTERS . " sf
                    INNER JOIN " . TABLE_SPECIFICATIONS_FILTERS_DESCRIPTION . " sfd ON (sfd.specification_filters_id = sf.specification_filters_id AND sfd.language_id = " . (int)$_SESSION['languages_id'] . ")
                  WHERE sf.specifications_id = " . (int)$specification['specifications_id'] . "
                    AND sf.specification_filters_id IN (" . $test . ")
                  ORDER BY sf.filter_sort_order, sfd.filter";
        }
//error_log(__LINE__ . ': ' . ' $sql=' . var_export($sql, true) . "\n", 3, __FILE__.'.log');
        $filter_values_query = vamDBquery($sql);
        $filter_values_array = array();
//error_log(__LINE__ . ': ' . ' vam_db_num_rows($filter_values_query)=' . var_export(vam_db_num_rows($filter_values_query), true) . "\n", 3, __FILE__.'.log');
        while ($filter_values = vam_db_fetch_array($filter_values_query, true)) {
//error_log(__LINE__ . ': ' . ' $filter_values=' . var_export($filter_values, true) . "\n", 3, __FILE__.'.log');
          $filter_values_array[] = $filter_values['filter'];
        }
//error_log(__LINE__ . ': ' . ' $filter_values_array=' . var_export($filter_values_array, true) . "\n", 3, __FILE__.'.log');
        $specifications_values = implode('/', $filter_values_array);
//        $specifications_values = (is_array($f_array[$specification['specifications_id']]) ? implode('-', $f_array[$specification['specifications_id']]) : $f_array[$specification['specifications_id']]);
// EOF use filter_id
//error_log(__LINE__ . ': ' . ' $specifications_values=' . var_export($specifications_values, true) . "\n", 3, __FILE__.'.log');
        $specifications_values = vam_cleanName($specifications_values);
        $specifications_values = preg_replace('@\-[\-]+@', '/', $specifications_values);
        $specifications_values = strtolower($specifications_values);
//error_log(__LINE__ . ': ' . ' $specifications_values=' . var_export($specifications_values, true) . "\n", 3, __FILE__.'.log');
        if ($specification['products_column_name'] == 'manufacturers_id') {
          $specifications_uri_parts[] = $specifications_values;
        } else {
          $specifications_uri_parts[] = $specification['specification_seo_url'] . '/' . $specifications_values;
        }
      }
//error_log(__LINE__ . ': ' . ' $specifications_uri_parts=' . var_export($specifications_uri_parts, true) . "\n", 3, __FILE__.'.log');
      $uri_page = implode('/', $specifications_uri_parts);
//error_log(__LINE__ . ': ' . ' $uri_page=' . var_export($uri_page, true) . "\n", 3, __FILE__.'.log');
      $uri_page = preg_replace('@\-[\-]+@', '/', $uri_page);
      $uri_page = trim($uri_page, '/');
//error_log(__LINE__ . ': ' . ' $uri_page=' . var_export($uri_page, true) . "\n", 3, __FILE__.'.log');
      if ($uri_page == '') {
        return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
      }
      $uri_page .= '.html';
      $specifications_uri = $categories_url . '/' . $uri_page;
//if ($specifications_uri == 'vinos-velosipedniy-dlya-rulya/satori-tip-adaptery-pauki.html') {
//  error_log(__LINE__ . ': ' . ' $specifications_uri=' . var_export($specifications_uri, true) . "\n", 3, __FILE__.'.log');
//  error_log(__LINE__ . ': ' . ' $specifications_request_query=' . var_export($specifications_request_query, true) . "\n", 3, __FILE__.'.log');
//}

//      $sql = "SELECT * FROM " . TABLE_SPECIFICATION_URL . " WHERE query = '" . vam_db_input($specifications_request_query) . "' AND uri = '" . vam_db_input($specifications_uri) . "'";
      $sql = "SELECT * FROM " . TABLE_SPECIFICATION_URL . " WHERE uri = '" . vam_db_input($specifications_uri) . "'";
      $specification_db_uri_query = vam_db_query($sql);
      if (vam_db_num_rows($specification_db_uri_query) == 0) {
        $sql = "INSERT INTO " . TABLE_SPECIFICATION_URL . " (uri, query, current_id) VALUES ('" . vam_db_input($specifications_uri) . "', '" . vam_db_input($specifications_request_query) . "', 0)";
//if ($specifications_uri == 'vinos-velosipedniy-dlya-rulya/satori-tip-adaptery-pauki.html') {
  error_log(__LINE__ . ': ' . ' $sql=' . var_export($sql, true) . "\n", 3, __FILE__.'.log');
//}
        vam_db_query($sql);
        $id = vam_db_insert_id();
      } else {
        $specification_db_uri = vam_db_fetch_array($specification_db_uri_query);
        $id = $specification_db_uri['id'];
        if ($specification_db_uri['query'] != $specifications_request_query) {
          $sql = "UPDATE " . TABLE_SPECIFICATION_URL . " SET query = '" . vam_db_input($specifications_request_query) . "' WHERE id = " . (int)$id . "";
          vam_db_query($sql);
        }
      }
      $sql = "SELECT * FROM " . TABLE_SPECIFICATION_URL . " WHERE uri = '" . vam_db_input($specifications_uri) . "' AND id != " . (int)$id . "";
      $check_query = vam_db_query($sql);
      if (vam_db_num_rows($check_query) > 0) {
        error_log(__LINE__ . ': ' . ' $sql=' . var_export($sql, true) . "\n", 3, __FILE__.'.log');
        error_log(__LINE__ . ': ' . ' vam_db_num_rows($check_query)=' . var_export(vam_db_num_rows($check_query), true) . "\n", 3, __FILE__.'.log');
        while ($check = vam_db_fetch_array($check_query)) {
          error_log(__LINE__ . ': ' . ' $check=' . var_export($check, true) . "\n", 3, __FILE__.'.log');
        }
      }
      if (vam_db_num_rows($check_query) > 0) {
        $sql = "DELETE FROM " . TABLE_SPECIFICATION_URL . " WHERE uri = '" . vam_db_input($specifications_uri) . "' AND id != " . (int)$id . "";
        vam_db_query($sql);
      }
      $sql = "SELECT * FROM " . TABLE_SPECIFICATION_URL . " WHERE query = '" . vam_db_input($specifications_request_query) . "' AND current_id != " . (int)$id . " AND id != " . (int)$id . "";
      $check_query = vam_db_query($sql);
      if (vam_db_num_rows($check_query) > 0) {
        $sql = "UPDATE " . TABLE_SPECIFICATION_URL . " SET current_id = " . (int)$id . " WHERE query = '" . vam_db_input($specifications_request_query) . "' AND current_id != " . (int)$id . " AND id != " . (int)$id . "";
        vam_db_query($sql);
      }
      $specification_url_cache[$specifications_request_query] = $specifications_uri;
      $href = vam_href_link_original($specifications_uri, http_build_query($get, '&amp;'), $connection, $add_session_id, $search_engine_safe);
      return $href;
// EOF products_filters_seo
    } else {
      return vam_href_link_original($page, $parameters, $connection, $add_session_id, $search_engine_safe);
    } 
  }

  // Categories/Products URL end



  // The HTML href link wrapper function
  // Categories/Products URL
  // functions name is changed from vam_href_link() to vam_href_link_original()
  function vam_href_link_original($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true) {
    global $request_type, $session_started, $http_domain, $https_domain,$truncate_session_id;

    if (!vam_not_null($page)) {
      die('</td></tr></table></td></tr></table><br /><br /><font color="#ff0000"><b>Error!</b></font><br /><br /><b>Unable to determine the page link!<br /><br />');
    }

    if ($connection == 'NONSSL') {
      $link = HTTP_SERVER . DIR_WS_CATALOG;
    } elseif ($connection == 'SSL') {
      if (ENABLE_SSL == true) {
        $link = HTTPS_SERVER . DIR_WS_CATALOG;
      } else {
        $link = HTTP_SERVER . DIR_WS_CATALOG;
      }
    } else {
      die('</td></tr></table></td></tr></table><br /><br /><font color="#ff0000"><b>Error!</b></font><br /><br /><b>Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL</b><br /><br />');
    }

    if (vam_not_null($parameters)) {
      $link .= $page . '?' . $parameters;
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
    if ( ($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False') ) {
      if (defined('SID') && vam_not_null(SID)) {
        $sid = SID;
      } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == true) ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
        if ($http_domain != $https_domain) {
          $sid = session_name() . '=' . session_id();
        }
      }        
    }
        
        // remove session if useragent is a known Spider
    if ($truncate_session_id) $sid=NULL;

    if (isset($sid)) {
      $link .= $separator . $sid;
    }

      //$link = str_replace('&', '&amp;', $link);
      
    if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
      while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);
    $link = str_replace('?', '/', $link);
      $link = str_replace('&', '/', $link);
      $link = str_replace('=', '/', $link);
      $separator = '?';
    }

    return $link;
  }

    function vam_href_link_admin($page = '', $parameters = '', $connection = 'NONSSL', $add_session_id = true, $search_engine_safe = true) {
    global $request_type, $session_started, $http_domain, $https_domain;

    if (!vam_not_null($page)) {
      die('</td></tr></table></td></tr></table><br /><br /><font color="#ff0000"><b>Error!</b></font><br /><br /><b>Unable to determine the page link!<br /><br />');
    }

    if ($connection == 'NONSSL') {
      $link = HTTP_SERVER . DIR_WS_CATALOG;
    } elseif ($connection == 'SSL') {
      if (ENABLE_SSL == true) {
        $link = HTTPS_SERVER . DIR_WS_CATALOG;
      } else {
        $link = HTTP_SERVER . DIR_WS_CATALOG;
      }
    } else {
      die('</td></tr></table></td></tr></table><br /><br /><font color="#ff0000"><b>Error!</b></font><br /><br /><b>Unable to determine connection method on a link!<br /><br />Known methods: NONSSL SSL</b><br /><br />');
    }

    if (vam_not_null($parameters)) {
      $link .= $page . '?' . $parameters;
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

// Add the session ID when moving from different HTTP and HTTPS servers, or when SID is defined
    if ( ($add_session_id == true) && ($session_started == true) && (SESSION_FORCE_COOKIE_USE == 'False') ) {
      if (defined('SID') && vam_not_null(SID)) {
        $sid = SID;
      } elseif ( ( ($request_type == 'NONSSL') && ($connection == 'SSL') && (ENABLE_SSL == true) ) || ( ($request_type == 'SSL') && ($connection == 'NONSSL') ) ) {
        if ($http_domain != $https_domain) {
          $sid = session_name() . '=' . session_id();
        }
      }
    }

    if ($truncate_session_id) $sid=NULL;

    if (isset($sid)) {
      $link .= $separator . $sid;
    }


    return $link;
  }

 ?>
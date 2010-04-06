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
    $language = '';
    $currency = '';
    $page_num = '';
    $matches = array();

    if ($page == FILENAME_DEFAULT) {
      if (strpos($parameters, 'cat') === false) {
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
          } elseif ($parsed_param[0] === 'price_min') {
            $price_min = $parsed_param[1];
          } elseif ($parsed_param[0] === 'price_max') {
            $price_max = $parsed_param[1];
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

        if ($categories_url == '') {
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
            $link .= DIR_WS_HTTPS_CATALOG;
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

          $link_ajax = '';

          if (AJAX_CART == 'true') {
            if( vam_not_null($parameters) && preg_match("/buy_now/i", $parameters) && $page != 'ajax_shopping_cart.php'){
              $link_ajax = '" onclick="doBuyNowGet(\'' . vam_href_link( 'ajax_shopping_cart.php', $parameters, $connection, $add_session_id, $search_engine_safe) . '\'); return false;';
            }
          }


          return $link . $categories_url . $link_ajax;
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
            $link .= DIR_WS_HTTPS_CATALOG;
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
            $link .= DIR_WS_HTTPS_CATALOG;
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
            $link .= DIR_WS_HTTPS_CATALOG;
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
            $link .= DIR_WS_HTTPS_CATALOG;
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

      $t_id = -1;
      $page_num = '';
      $param_array = explode('&', $parameters);

      for ($i = 0, $n = sizeof($param_array); $i < $n; $i++) {
        $parsed_param = explode('=', $param_array[$i]);
        if ($parsed_param[0] === 'tPath') {
          $t_id = $parsed_param[1];
        } 
        if ($parsed_param[0] === 'page') {
          $page_num = $parsed_param[1];
        } elseif ($parsed_param[0] === 'language') {
          $language = $parsed_param[1];
        } elseif ($parsed_param[0] === 'currency') {
          $currency = $parsed_param[1];
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
            $link .= DIR_WS_HTTPS_CATALOG;
          } else {
            $link .= DIR_WS_CATALOG;
          }

          if (vam_not_null($page_num)) {
            $t_url .= '?page=' . $page_num;
          }

          if (vam_not_null($language)) {
            $t_url .= '?language=' . $language;
          }

          if (vam_not_null($currency)) {
            $t_url .= '?currency=' . $currency;
          }

          return $link . $t_url;
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
            $link .= DIR_WS_HTTPS_CATALOG;
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

    if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
      while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);
    $link = str_replace('?', '/', $link);
      $link = str_replace('&', '/', $link);
      $link = str_replace('=', '/', $link);
      $separator = '?';
    }

    $link_ajax = '';

    if (AJAX_CART == 'true') {
      if( vam_not_null($parameters) && preg_match("/buy_now/i", $parameters) && $page != 'ajax_shopping_cart.php'){
        $link_ajax = '" onclick="doBuyNowGet(\'' . vam_href_link( 'ajax_shopping_cart.php', $parameters, $connection, $add_session_id, $search_engine_safe) . '\'); return false;';
      }
    }

    return $link . $link_ajax;
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
<?php
/*
  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  Released under the GNU General Public License
  
  @Author: Raphael Vullriede (osc@rvdesign.de)
*/

  // XML-Specification: https://www.google.com/webmasters/sitemaps/docs/de/protocol.html

  require('includes/application_top.php');

  define('CHANGEFREQ_CATEGORIES', 'weekly');  // Valid values are "always", "hourly", "daily", "weekly", "monthly", "yearly" and "never".
  define('CHANGEFREQ_PRODUCTS', 'daily'); // Valid values are "always", "hourly", "daily", "weekly", "monthly", "yearly" and "never".

  define('PRIORITY_CATEGORIES', '1.0');
  define('PRIORITY_PRODUCTS', '0.5');

  define('MAX_ENTRYS', 50000);
  define('MAX_SIZE', 10000000);

  define('SITEMAPINDEX_HEADER', "<?xml version='1.0' encoding='UTF-8'?>"."\n".'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"'."\n".'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'."\n".'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9'."\n".'http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd">'."\n");
  define('SITEMAPINDEX_FOOTER', '</sitemapindex>');
  define('SITEMAPINDEX_ENTRY', "\t".'<sitemap>'."\n\t\t".'<loc>%s</loc>'."\n\t\t".'<lastmod>%s</lastmod>'."\n\t".'</sitemap>'."\n");

  define('SITEMAP_HEADER', "<rss xmlns:yandex='http://news.yandex.ru' xmlns:media='http://search.yahoo.com/mrss/' xmlns:turbo='http://turbo.yandex.ru' version='2.0'>"."\n".'<channel>'."\n".'<turbo:cms_plugin>vamshop</turbo:cms_plugin>'."\n");
  define('SITEMAP_FOOTER', '</channel>'."\n".'</rss>');
  define('SITEMAP_ENTRY', "\t".'<item turbo="true">'."\n\t\t".'<link>%s</link>'."\n\t\t".'<turbo:content><![CDATA['."\n\t\t".'<figure><img src="%s" /><figcaption>%s</figcaption></figure>'."\n\t\t".'<header><h1>%s</h1></header>'."\n\t\t".'<button formaction="%s" data-background-color="orange" data-turbo="false" data-color="white" data-primary="true">Перейти в магазин</button> '."\n\t".']]></turbo:content></item>'."\n");


  $usegzip        = false;
  $autogenerate   = false;
  $output_to_file = false;
  $notify_google  = false;
  $notify_url     = '';

  // request over http or command line?
  if (!isset($_SERVER['SERVER_PROTOCOL'])) {

    if (count($_SERVER['argv'] > 1)) {
      
      // option p ist only possible of min 1 more option isset
      if ( (strlen($_SERVER['argv'][1]) >= 2) && strpos($_SERVER['argv'][1], 'p') !== true) {
        $notify_google = true;
        $_SERVER['argv'][1] = str_replace('p', '', $_SERVER['argv'][1]);
      }
      
      switch($_SERVER['argv'][1]) {
      
        // dump to file
        case '-f':
          $output_to_file = true;
          $filename = $_SERVER['argv'][2];
          break;
          
        // dump to compressed file
        case '-zf':
          $usegzip        = true;
          $output_to_file = true;
          $filename = $_SERVER['argv'][2];
          break;
          
        // autogenerate sitemaps. useful for sites with more the 500000 Urls
        case '-a':
          $autogenerate = true;
          break;
          
        // autogenerate sitemaps and use gzip
        case '-za':
          $autogenerate   = true;
          $usegzip        = true;
          break;
      }
    }
  } else {

    if (count($_GET) > 0) {

      // dump to file
      if (isset($_GET['f'])) {
        $output_to_file = true;
        $filename = $_GET['f'];
      }
      // use gzip
      $usegzip = (isset($_GET['gzip']) && $_GET['gzip'] == true) ? true : false;
      
      // autogenerate sitemaps
      $autogenerate = (isset($_GET['auto']) && $_GET['auto'] == true) ? true : false;
      
      // notify google
      $notify_google = (isset($_GET['ping']) && $_GET['ping'] == true) ? true : false;
    }
  }

  // use gz... functions for compressed files
  if ($usegzip) {
    $function_open  = 'gzopen';
    $function_close = 'gzclose';
    $function_write = 'gzwrite';
    
    $file_extension = '.xml.gz';
  } else {
    $function_open  = 'fopen';
    $function_close = 'fclose';
    $function_write = 'fwrite';
    
    $file_extension = '.xml';
  }

  // < PHP5
  if (!function_exists('file_put_contents')) {
  
    function file_put_contents($filename, $content) {
    
      $fp = fopen($filename, 'w');
      fwrite($fp, $content);
      fclose($fp);
    }
  }

  // < PHP5
  function iso8601_date($timestamp) {
  
    if (PHP_VERSION < 5) {
       $tzd = date('O',$timestamp);
       $tzd = substr(chunk_split($tzd, 3, ':'),0,6);
       return date('Y-m-d\TH:i:s', $timestamp) . $tzd;
    } else {
      return date('c', $timestamp);
    }
  }

  // generates cPath with helper array
  function rv_get_path($cat_id, $code) {
    global $cat_array;
    
    $my_cat_array = array($cat_id);
    
    while($cat_array[$cat_id][$code]['parent_id'] != 0) {
      $my_cat_array[] = $cat_array[$cat_id][$code]['parent_id'];
      $cat_id = $cat_array[$cat_id][$code]['parent_id'];
    }
    
    return 'cat='.implode('_', array_reverse($my_cat_array));
  }


  function output($string) {
    global $function_open, $function_close, $function_write, $output_to_file, $fp, $autogenerate;
    
    if ($output_to_file || $autogenerate) {
      $function_write($fp, $string);
    } else {
      echo $string;
    }
  }

  $c = 0;
  $i = 1;

  if ($autogenerate) {
    $fp = $function_open('sitemap'.$i.$file_extension, 'w');
    $notify_url = HTTP_SERVER.DIR_WS_HTTP_CATALOG.'sitemap'.$i.$file_extension;
  } else {
    if ($output_to_file) {
      $fp = $function_open($filename, 'w');
      $notify_url = HTTP_SERVER.DIR_WS_HTTP_CATALOG.'sitemap'.$i.$file_extension;
    } 
  }


  output(SITEMAP_HEADER);
  $strlen = strlen(SITEMAP_HEADER);


  $cat_result = vam_db_query("
    SELECT
      c.categories_id,
      c.categories_image,
      c.parent_id,
      cd.language_id,
      cd.categories_name,
      UNIX_TIMESTAMP(c.date_added) as date_added,
      UNIX_TIMESTAMP(c.last_modified) as last_modified,
      l.code
    FROM 
      ".TABLE_CATEGORIES." c,
      ".TABLE_CATEGORIES_DESCRIPTION." cd,
      ".TABLE_LANGUAGES." l
    WHERE c.categories_status = '1' and cd.language_id = '".$_SESSION['languages_id']."' and 
      c.categories_id = cd.categories_id AND
      cd.language_id = l.languages_id
    ORDER by 
      cd.categories_id
  ");

  $cat_array = array();
  if (vam_db_num_rows($cat_result) > 0) {
    while($cat_data = vam_db_fetch_array($cat_result)) {
      $cat_array[$cat_data['categories_id']][$cat_data['code']] = $cat_data;
    }
  }
  reset($cat_array);


  foreach($cat_array as $lang_array) {
    foreach($lang_array as $cat_id => $cat_data) {
    
      $lang_param = ($cat_data['code'] != DEFAULT_LANGUAGE) ? '&language='.$cat_data['code'] : '';
      $date = ($cat_data['last_modified'] != NULL) ? $cat_data['last_modified'] : $cat_data['date_added'];

      $string = sprintf(SITEMAP_ENTRY, htmlspecialchars(utf8_encode(vam_href_link(FILENAME_DEFAULT, vam_category_link($cat_data['categories_id'], $cat_data['categories_name']), 'NONSSL', false, SEARCH_ENGINE_FRIENDLY_URLS))) ,HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . 'categories/' . $cat_data['categories_image'], $cat_data['categories_name'], $cat_data['categories_name'], htmlspecialchars(utf8_encode(vam_href_link(FILENAME_DEFAULT, vam_category_link($cat_data['categories_id'], $cat_data['categories_name']), 'NONSSL', false, SEARCH_ENGINE_FRIENDLY_URLS))));
      
      output($string);
      $strlen += strlen($string);
      
      $c++;
      if ($autogenerate) {
        // 500000 entrys or filesize > 10,485,760 - some space for the last entry
        if ( $c == MAX_ENTRYS || $strlen >= MAX_SIZE) {
          output(SITEMAP_FOOTER);
          $function_close($fp);
          $c = 0;
          $i++;
          $fp = $function_open('sitemap'.$i.$file_extension, 'w');
          output(SITEMAP_HEADER);
          $strlen = strlen(SITEMAP_HEADER);
        }
      }
    }
  }

  $cat_result = vam_db_query("
    SELECT
      t.topics_id,
      t.parent_id,
      td.language_id,
      td.topics_name,
      UNIX_TIMESTAMP(t.date_added) as date_added,
      UNIX_TIMESTAMP(t.last_modified) as last_modified,
      l.code
    FROM 
      ".TABLE_TOPICS." t,
      ".TABLE_TOPICS_DESCRIPTION." td,
      ".TABLE_LANGUAGES." l
    WHERE td.language_id = '".$_SESSION['languages_id']."' and 
      t.topics_id = td.topics_id AND
      td.language_id = l.languages_id
    ORDER by 
      td.topics_id
  ");

  $cat_array = array();
  if (vam_db_num_rows($cat_result) > 0) {
    while($cat_data = vam_db_fetch_array($cat_result)) {
      $cat_array[$cat_data['topics_id']][$cat_data['code']] = $cat_data;
    }
  }
  reset($cat_array);


  foreach($cat_array as $lang_array) {
    foreach($lang_array as $cat_id => $cat_data) {
    
      $lang_param = ($cat_data['code'] != DEFAULT_LANGUAGE) ? '&language='.$cat_data['code'] : '';
      $date = ($cat_data['last_modified'] != NULL) ? $cat_data['last_modified'] : $cat_data['date_added'];

      $string = sprintf(SITEMAP_ENTRY, htmlspecialchars(utf8_encode(vam_href_link(FILENAME_ARTICLES, 'tPath='.$cat_data['topics_id'] . $SEF_parameter_cat))) ,HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . 'pixel_trans.gif', $cat_data['topics_name'], $cat_data['topics_name'], htmlspecialchars(utf8_encode(vam_href_link(FILENAME_ARTICLES, 'tPath='.$cat_data['topics_id'] . $SEF_parameter_cat))));
      
      output($string);
      $strlen += strlen($string);
      
      $c++;
      if ($autogenerate) {
        // 500000 entrys or filesize > 10,485,760 - some space for the last entry
        if ( $c == MAX_ENTRYS || $strlen >= MAX_SIZE) {
          output(SITEMAP_FOOTER);
          $function_close($fp);
          $c = 0;
          $i++;
          $fp = $function_open('sitemap'.$i.$file_extension, 'w');
          output(SITEMAP_HEADER);
          $strlen = strlen(SITEMAP_HEADER);
        }
      }
    }
  }
  
  $product_result = vam_db_query("
    SELECT
      p.products_id,
      p.products_image,
      p.products_price,
      pd.products_name,
      pd.language_id,
      UNIX_TIMESTAMP(p.products_date_added) as products_date_added,
      UNIX_TIMESTAMP(p.products_last_modified) as products_last_modified,
      l.code
    FROM
      ".TABLE_PRODUCTS." p, 
      ".TABLE_PRODUCTS_DESCRIPTION." pd,
      ".TABLE_LANGUAGES." l
    WHERE pd.language_id = '".$_SESSION['languages_id']."' and 
      p.products_status='1' AND
      p.products_id = pd.products_id AND
      pd.language_id = l.languages_id
    ORDER BY
      p.products_id
  ");

  if (vam_db_num_rows($product_result) > 0) {
    while($product_data = vam_db_fetch_array($product_result)) {
    
      $lang_param = ($product_data['code'] != DEFAULT_LANGUAGE) ? '&language='.$product_data['code'] : '';
      $date = ($product_data['products_last_modified'] != NULL) ? $product_data['products_last_modified'] : $product_data['products_date_added'];
      
      $string = sprintf(SITEMAP_ENTRY, htmlspecialchars(utf8_encode(vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($product_data['products_id'], $product_data['products_name']), 'NONSSL', false, SEARCH_ENGINE_FRIENDLY_URLS))) , HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_POPUP_IMAGES . $product_data['products_image'], $product_data['products_name'], $product_data['products_name'], htmlspecialchars(utf8_encode(vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($product_data['products_id'], $product_data['products_name']), 'NONSSL', false, SEARCH_ENGINE_FRIENDLY_URLS))));
      
      output($string);
      $strlen += strlen($string);
      
      $c++;
      if ($autogenerate) {
        // 500000 entrys or filesize > 10,485,760 - some space for the last entry
        if ( $c == MAX_ENTRYS || $strlen >= MAX_SIZE) {
          output(SITEMAP_FOOTER);
          $function_close($fp);
          $c = 0;
          $i++;
          $fp = $function_open('sitemap'.$i.$file_extension, 'w');
          output(SITEMAP_HEADER);
          $strlen = strlen(SITEMAP_HEADER);
        }
      }
    }
  }

  $product_result = vam_db_query("
    SELECT
      a.articles_id,
      ad.articles_name,
      ad.language_id,
      UNIX_TIMESTAMP(a.articles_date_added) as articles_date_added,
      UNIX_TIMESTAMP(a.articles_last_modified) as articles_last_modified,
      l.code
    FROM
      ".TABLE_ARTICLES." a, 
      ".TABLE_ARTICLES_DESCRIPTION." ad,
      ".TABLE_LANGUAGES." l
    WHERE ad.language_id = '".$_SESSION['languages_id']."' and 
      a.articles_status='1' AND
      a.articles_id = ad.articles_id AND
      ad.language_id = l.languages_id
    ORDER BY
      a.articles_id
  ");

  if (vam_db_num_rows($product_result) > 0) {
    while($product_data = vam_db_fetch_array($product_result)) {
    
      $lang_param = ($product_data['code'] != DEFAULT_LANGUAGE) ? '&language='.$product_data['code'] : '';
      $date = ($product_data['articles_last_modified'] != NULL) ? $product_data['articles_last_modified'] : $product_data['articles_date_added'];
      
      $string = sprintf(SITEMAP_ENTRY, htmlspecialchars(utf8_encode(vam_href_link(FILENAME_ARTICLE_INFO, 'articles_id='.$product_data['articles_id']))) , HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . 'pixel_trans.gif', $product_data['articles_name'], $product_data['articles_name'], htmlspecialchars(utf8_encode(vam_href_link(FILENAME_ARTICLE_INFO, 'articles_id='.$product_data['articles_id']))));
      
      output($string);
      $strlen += strlen($string);
      
      $c++;
      if ($autogenerate) {
        // 500000 entrys or filesize > 10,485,760 - some space for the last entry
        if ( $c == MAX_ENTRYS || $strlen >= MAX_SIZE) {
          output(SITEMAP_FOOTER);
          $function_close($fp);
          $c = 0;
          $i++;
          $fp = $function_open('sitemap'.$i.$file_extension, 'w');
          output(SITEMAP_HEADER);
          $strlen = strlen(SITEMAP_HEADER);
        }
      }
    }
  }

  $product_result = vam_db_query("
    SELECT
      c.content_id,
      c.content_title,
      c.content_text,
      c.languages_id,
      UNIX_TIMESTAMP(now()) as date_added,
      UNIX_TIMESTAMP(now()) as last_modified,
      l.code
    FROM
      ".TABLE_CONTENT_MANAGER." c, 
      ".TABLE_LANGUAGES." l
    WHERE c.languages_id = '".$_SESSION['languages_id']."' and 
      c.content_status='1' AND
      c.content_url='' AND
      c.content_id!='5' AND
      c.content_group!='5' AND
      c.languages_id = l.languages_id
    ORDER BY
      c.content_id
  ");

  if (vam_db_num_rows($product_result) > 0) {
    while($product_data = vam_db_fetch_array($product_result)) {
    
      $lang_param = ($product_data['code'] != DEFAULT_LANGUAGE) ? '&language='.$product_data['code'] : '';
      $date = ($product_data['last_modified'] != NULL) ? $product_data['last_modified'] : $product_data['date_added'];
      
      $string = sprintf(SITEMAP_ENTRY, htmlspecialchars(utf8_encode(vam_href_link(FILENAME_CONTENT, 'coID='.$product_data['content_id']))) , HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . 'pixel_trans.gif', $product_data['content_title'], $product_data['content_title'], htmlspecialchars(utf8_encode(vam_href_link(FILENAME_CONTENT, 'coID='.$product_data['content_id']))));
      
      output($string);
      $strlen += strlen($string);
      
      $c++;
      if ($autogenerate) {
        // 500000 entrys or filesize > 10,485,760 - some space for the last entry
        if ( $c == MAX_ENTRYS || $strlen >= MAX_SIZE) {
          output(SITEMAP_FOOTER);
          $function_close($fp);
          $c = 0;
          $i++;
          $fp = $function_open('sitemap'.$i.$file_extension, 'w');
          output(SITEMAP_HEADER);
          $strlen = strlen(SITEMAP_HEADER);
        }
      }
    }
  }

  $product_result = vam_db_query("
    SELECT
      n.news_id,
      n.headline,
      n.content,
      n.language,
      UNIX_TIMESTAMP(n.date_added) as date_added,
      UNIX_TIMESTAMP(now()) as last_modified,
      l.code
    FROM
      ".TABLE_LATEST_NEWS." n, 
      ".TABLE_LANGUAGES." l
    WHERE n.language = '".$_SESSION['languages_id']."' and 
      n.status='1' AND
      n.language = l.languages_id
    ORDER BY
      n.news_id
  ");

  if (vam_db_num_rows($product_result) > 0) {
    while($product_data = vam_db_fetch_array($product_result)) {
    
      $lang_param = ($product_data['code'] != DEFAULT_LANGUAGE) ? '&language='.$product_data['code'] : '';
      $date = ($product_data['last_modified'] != NULL) ? $product_data['last_modified'] : $product_data['date_added'];
      
      $string = sprintf(SITEMAP_ENTRY, htmlspecialchars(utf8_encode(vam_href_link(FILENAME_NEWS, 'news_id='.$product_data['news_id']))) , HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . 'pixel_trans.gif', $product_data['headline'], $product_data['headline'], htmlspecialchars(utf8_encode(vam_href_link(FILENAME_NEWS, 'news_id='.$product_data['news_id']))));
      
      output($string);
      $strlen += strlen($string);
      
      $c++;
      if ($autogenerate) {
        // 500000 entrys or filesize > 10,485,760 - some space for the last entry
        if ( $c == MAX_ENTRYS || $strlen >= MAX_SIZE) {
          output(SITEMAP_FOOTER);
          $function_close($fp);
          $c = 0;
          $i++;
          $fp = $function_open('sitemap'.$i.$file_extension, 'w');
          output(SITEMAP_HEADER);
          $strlen = strlen(SITEMAP_HEADER);
        }
      }
    }
  }

  $product_result = vam_db_query("
    SELECT
      f.faq_id,
      f.question,
      f.answer,
      f.language,
      UNIX_TIMESTAMP(f.date_added) as date_added,
      UNIX_TIMESTAMP(now()) as last_modified,
      l.code
    FROM
      ".TABLE_FAQ." f, 
      ".TABLE_LANGUAGES." l
    WHERE f.language = '".$_SESSION['languages_id']."' and 
      f.status='1' AND
      f.language = l.languages_id
    ORDER BY
      f.faq_id
  ");

  if (vam_db_num_rows($product_result) > 0) {
    while($product_data = vam_db_fetch_array($product_result)) {
    
      $lang_param = ($product_data['code'] != DEFAULT_LANGUAGE) ? '&language='.$product_data['code'] : '';
      $date = ($product_data['last_modified'] != NULL) ? $product_data['last_modified'] : $product_data['date_added'];
      
      $string = sprintf(SITEMAP_ENTRY, htmlspecialchars(utf8_encode(vam_href_link(FILENAME_FAQ, 'faq_id='.$product_data['faq_id']))) , HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . 'pixel_trans.gif', $product_data['question'], $product_data['question'], htmlspecialchars(utf8_encode(vam_href_link(FILENAME_FAQ, 'faq_id='.$product_data['faq_id']))));
      
      output($string);
      $strlen += strlen($string);
      
      $c++;
      if ($autogenerate) {
        // 500000 entrys or filesize > 10,485,760 - some space for the last entry
        if ( $c == MAX_ENTRYS || $strlen >= MAX_SIZE) {
          output(SITEMAP_FOOTER);
          $function_close($fp);
          $c = 0;
          $i++;
          $fp = $function_open('sitemap'.$i.$file_extension, 'w');
          output(SITEMAP_HEADER);
          $strlen = strlen(SITEMAP_HEADER);
        }
      }
    }
  }

  output(SITEMAP_FOOTER);
  if ($output_to_file || $autogenerate) {
    $function_close($fp);
  }

  // generates sitemap-index file
  if ($autogenerate && $i > 1) {
    $notify_url = HTTP_SERVER.DIR_WS_HTTP_CATALOG.'sitemap_index'.$file_extension;
    $fp = $function_open('sitemap_index'.$file_extension, 'w');
    $function_write($fp, SITEMAPINDEX_HEADER);
    for($ii=1; $ii<=$i; $ii++) {
      $function_write($fp, sprintf(SITEMAPINDEX_ENTRY, HTTP_SERVER.DIR_WS_HTTP_CATALOG.'sitemap'.$ii.$file_extension, iso8601_date(time())));
    }
    $function_write($fp, SITEMAPINDEX_FOOTER);
    $function_close($fp);
  }

  if ($notify_google) {
    fopen('http://www.google.com/webmasters/sitemaps/ping?sitemap='.urlencode($notify_url), 'r');
  }

?>
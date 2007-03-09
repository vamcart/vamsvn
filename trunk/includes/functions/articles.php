<?php
/* --------------------------------------------------------------
   $Id: articles.php 1249 2007-03-09 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   (c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/

// Parse and secure the tPath parameter values
  function xtc_parse_topic_path($tPath) {
    // make sure the topic IDs are integers
    $tPath_array = array_map('xtc_string_to_int', explode('_', $tPath));

// make sure no duplicate topic IDs exist which could lock the server in a loop
    $tmp_array = array();
    $n = sizeof($tPath_array);
    for ($i=0; $i<$n; $i++) {
      if (!in_array($tPath_array[$i], $tmp_array)) {
        $tmp_array[] = $tPath_array[$i];
      }
    }

    return $tmp_array;
  }

////
// Generate a path to topics
// TABLES: topics
  function xtc_get_topic_path($current_topic_id = '') {
    global $tPath_array;

    if (xtc_not_null($current_topic_id)) {
      $cp_size = sizeof($tPath_array);
      if ($cp_size == 0) {
        $tPath_new = $current_topic_id;
      } else {
        $tPath_new = '';
        $last_topic_query = xtc_db_query("select parent_id from " . TABLE_TOPICS . " where topics_id = '" . (int)$tPath_array[($cp_size-1)] . "'");
        $last_topic = xtc_db_fetch_array($last_topic_query);

        $current_topic_query = xtc_db_query("select parent_id from " . TABLE_TOPICS . " where topics_id = '" . (int)$current_topic_id . "'");
        $current_topic = xtc_db_fetch_array($current_topic_query);

        if ($last_topic['parent_id'] == $current_topic['parent_id']) {
          for ($i=0; $i<($cp_size-1); $i++) {
            $tPath_new .= '_' . $tPath_array[$i];
          }
        } else {
          for ($i=0; $i<$cp_size; $i++) {
            $tPath_new .= '_' . $tPath_array[$i];
          }
        }
        $tPath_new .= '_' . $current_topic_id;

        if (substr($tPath_new, 0, 1) == '_') {
          $tPath_new = substr($tPath_new, 1);
        }
      }
    } else {
      $tPath_new = implode('_', $tPath_array);
    }

    return 'tPath=' . $tPath_new;
  }

////
// Return the number of articles in a topic
// TABLES: articles, articles_to_topics, topics
  function xtc_count_articles_in_topic($topic_id, $include_inactive = false) {
    $articles_count = 0;
    if ($include_inactive == true) {
      $articles_query = xtc_db_query("select count(*) as total from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_TO_TOPICS . " a2t where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a2t.topics_id = '" . (int)$topic_id . "'");
    } else {
      $articles_query = xtc_db_query("select count(*) as total from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_TO_TOPICS . " a2t where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a2t.topics_id = '" . (int)$topic_id . "'");
    }
    $articles = xtc_db_fetch_array($articles_query);
    $articles_count += $articles['total'];

    $child_topics_query = xtc_db_query("select topics_id from " . TABLE_TOPICS . " where parent_id = '" . (int)$topic_id . "'");
    if (xtc_db_num_rows($child_topics_query)) {
      while ($child_topics = xtc_db_fetch_array($child_topics_query)) {
        $articles_count += xtc_count_articles_in_topic($child_topics['topics_id'], $include_inactive);
      }
    }

    return $articles_count;
  }

////
// Return true if the topic has subtopics
// TABLES: topics
  function xtc_has_topic_subtopics($topic_id) {
    $child_topic_query = xtc_db_query("select count(*) as count from " . TABLE_TOPICS . " where parent_id = '" . (int)$topic_id . "'");
    $child_topic = xtc_db_fetch_array($child_topic_query);

    if ($child_topic['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }

////
// Return all topics
// TABLES: topics, topic_descriptions
  function xtc_get_topics($topics_array = '', $parent_id = '0', $indent = '') {
    global $languages_id;

    if (!is_array($topics_array)) $topics_array = array();

    $topics_query = xtc_db_query("select t.topics_id, td.topics_name from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where parent_id = '" . (int)$parent_id . "' and t.topics_id = td.topics_id and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by sort_order, td.topics_name");
    while ($topics = xtc_db_fetch_array($topics_query)) {
      $topics_array[] = array('id' => $topics['topics_id'],
                                  'text' => $indent . $topics['topics_name']);

      if ($topics['topics_id'] != $parent_id) {
        $topics_array = xtc_get_topics($topics_array, $topics['topics_id'], $indent . '&nbsp;&nbsp;');
      }
    }

    return $topics_array;
  }

////
// Return all authors
// TABLES: authors
  function xtc_get_authors($authors_array = '') {
    if (!is_array($authors_array)) $authors_array = array();

    $authors_query = xtc_db_query("select authors_id, authors_name from " . TABLE_AUTHORS . " order by authors_name");
    while ($authors = xtc_db_fetch_array($authors_query)) {
      $authors_array[] = array('id' => $authors['authors_id'], 'text' => $authors['authors_name']);
    }

    return $authors_array;
  }

////
// Return all subtopic IDs
// TABLES: topics
  function xtc_get_subtopics(&$subtopics_array, $parent_id = 0) {
    $subtopics_query = xtc_db_query("select topics_id from " . TABLE_TOPICS . " where parent_id = '" . (int)$parent_id . "'");
    while ($subtopics = xtc_db_fetch_array($subtopics_query)) {
      $subtopics_array[sizeof($subtopics_array)] = $subtopics['topics_id'];
      if ($subtopics['topics_id'] != $parent_id) {
        xtc_get_subtopics($subtopics_array, $subtopics['topics_id']);
      }
    }
  }

////
// Recursively go through the topics and retreive all parent topic IDs
// TABLES: topics
  function xtc_get_parent_topics(&$topics, $topics_id) {
    $parent_topics_query = xtc_db_query("select parent_id from " . TABLE_TOPICS . " where topics_id = '" . (int)$topics_id . "'");
    while ($parent_topics = xtc_db_fetch_array($parent_topics_query)) {
      if ($parent_topics['parent_id'] == 0) return true;
      $topics[sizeof($topics)] = $parent_topics['parent_id'];
      if ($parent_topics['parent_id'] != $topics_id) {
        xtc_get_parent_topics($topics, $parent_topics['parent_id']);
      }
    }
  }

////
// Construct a topic path to the article
// TABLES: articles_to_topics
  function xtc_get_article_path($articles_id) {
    $tPath = '';

    $topic_query = xtc_db_query("select a2t.topics_id from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_TO_TOPICS . " a2t where a.articles_id = '" . (int)$articles_id . "' and a.articles_status = '1' and a.articles_id = a2t.articles_id limit 1");
    if (xtc_db_num_rows($topic_query)) {
      $topic = xtc_db_fetch_array($topic_query);

      $topics = array();
      xtc_get_parent_topics($topics, $topic['topics_id']);

      $topics = array_reverse($topics);

      $tPath = implode('_', $topics);

      if (xtc_not_null($tPath)) $tPath .= '_';
      $tPath .= $topic['topics_id'];
    }

    return $tPath;
  }

////
// Return an article's name
// TABLES: articles
  function xtc_get_articles_name($article_id, $language = '') {
    global $languages_id;

    if (empty($language)) $language = $_SESSION['languages_id'];

    $article_query = xtc_db_query("select articles_name from " . TABLE_ARTICLES_DESCRIPTION . " where articles_id = '" . (int)$article_id . "' and language_id = '" . (int)$language . "'");
    $article = xtc_db_fetch_array($article_query);

    return $article['articles_name'];
  }

////
//! Cache the articles box
// Cache the articles box
  function xtc_cache_topics_box($auto_expire = false, $refresh = false) {
    global $tPath, $language, $languages_id, $tree, $tPath_array, $topics_string;

    if (($refresh == true) || !read_cache($cache_output, 'topics_box-' . $language . '.cache' . $tPath, $auto_expire)) {
      ob_start();
      include(DIR_WS_BOXES . 'articles.php');
      $cache_output = ob_get_contents();
      ob_end_clean();
      write_cache($cache_output, 'topics_box-' . $language . '.cache' . $tPath);
    }

    return $cache_output;
  }

////
//! Cache the authors box
// Cache the authors box
  function xtc_cache_authors_box($auto_expire = false, $refresh = false) {
    global $_GET, $language;

    $authors_id = '';
    if (isset($_GET['authors_id']) && xtc_not_null($_GET['authors_id'])) {
      $authors_id = $_GET['authors_id'];
    }

    if (($refresh == true) || !read_cache($cache_output, 'authors_box-' . $language . '.cache' . $authors_id, $auto_expire)) {
      ob_start();
      include(DIR_WS_BOXES . 'authors.php');
      $cache_output = ob_get_contents();
      ob_end_clean();
      write_cache($cache_output, 'authors_box-' . $language . '.cache' . $authors_id);
    }

    return $cache_output;
  }

?>

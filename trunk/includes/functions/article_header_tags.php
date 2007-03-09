<?php
/* --------------------------------------------------------------
   $Id: article_header_tags.php 1249 2007-03-09 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   (c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/

// Modification of Header Tags Contribution
// WebMakers.com Added: Header Tags Generator v2.0 

////
// Get articles_head_title_tag
// TABLES: articles_description
function xtc_get_header_tag_articles_title($article_id) {
  global $languages_id, $_GET; 

  $article_header_tags = xtc_db_query("select articles_head_title_tag from " . TABLE_ARTICLES_DESCRIPTION . " where language_id = '" . (int)$_SESSION['languages_id'] . "' and articles_id = '" . (int)$_GET['articles_id'] . "'");
  $article_header_tags_values = xtc_db_fetch_array($article_header_tags);

  return clean_html_comments($article_header_tags_values['articles_head_title_tag']);
  }


////
// Get articles_head_keywords_tag
// TABLES: articles_description
function xtc_get_header_tag_articles_keywords($article_id) {
  global $languages_id, $_GET; 

  $article_header_tags = xtc_db_query("select articles_head_keywords_tag from " . TABLE_ARTICLES_DESCRIPTION . " where language_id = '" . (int)$_SESSION['languages_id'] . "' and articles_id = '" . (int)$_GET['articles_id'] . "'");
  $article_header_tags_values = xtc_db_fetch_array($article_header_tags);

  return $article_header_tags_values['articles_head_keywords_tag'];
  }


////
// Get articles_head_desc_tag
// TABLES: articles_description
function xtc_get_header_tag_articles_desc($article_id) {
  global $languages_id, $_GET; 

  $article_header_tags = xtc_db_query("select articles_head_desc_tag from " . TABLE_ARTICLES_DESCRIPTION . " where language_id = '" . (int)$_SESSION['languages_id'] . "' and articles_id = '" . (int)$_GET['articles_id'] . "'");
  $article_header_tags_values = xtc_db_fetch_array($article_header_tags);

  return $article_header_tags_values['articles_head_desc_tag'];
  }

?>
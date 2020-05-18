<?php
/* -----------------------------------------------------------------------------------------
   $Id: rss2.php 1238 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2005	 maurycy (rss2.php,v 1.1 2003/08/24); zen-cart.com
   (c) 2005	 Andrew Berezin (rss2.php,v 1.1 2003/08/24); zen-cart.com
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

/*
Ver 1.5:
1. Using <![CDATA[ ]] for text fields;
2. Add new feed types: specials_random, featured_random, best_sellers_random, upcoming_random, new_products_random.
3. Add support for aditional xmlns;
4. Add parameter products_id for "products" feed;
Ver 1.5.1:
1. Add headers:
header('Last-Modified: ' . gmdate("r") . ' GMT');
header('Expires: ' . gmdate("r", (time()+600)) . ' GMT');
Ver 1.5.2:
1. Fixed bug with non-active products;
Ver 1.5.3:
1. Fixed bug with products images;

*/
/*
<a href="http://feedvalidator.org/check.cgi?url=http://zen-cart.spb.ru/rss2.php%3Frsstype%3Dnew_products"><img src="valid-rss.png" alt="[Valid RSS]" title="Validate my RSS feed" /></a>
*/

require('includes/application_top.php');
require('inc/vam_count_products_in_category.inc.php');
require('inc/vam_has_category_subcategories.inc.php');
require('inc/vam_random_select.inc.php');

// some settings first
$cdata_open = "<![CDATA[";
$cdata_close = "]]>";

$cdata_open = "";
$cdata_close = "";

$days_limit = "";

// 0 - no description in feed; 1 - give it in...
define('RSS_FEED_DESCRIPTION', 'false');
// how many characters in description (0 for no limit)
define('RSS_FEED_DESCRIPTION_CHARACTERS', '0');
define('RSS_TTL', '1440'); // time to live - time after reader should refresh the info in minutes
define('RSS_STRIP_TAGS', 'true');
define('RSS_IMAGE', 'logo.png');
define('RSS_IMAGE_NAME', STORE_NAME);

if(RSS_STRIP_TAGS == 'false') {
	define('CDATA_OPEN', "<![CDATA[");
	define('CDATA_CLOSE', "]]>");
} else {
	define('CDATA_OPEN', "");
	define('CDATA_CLOSE', "");
}

define('RSS_GENERATOR', 'VaM Shop RSS 2.0 Feed');
define('RSS_CONTENT_COPYRIGHT', 'Copyright &copy; ' . date('Y') . ' ' . STORE_OWNER);

/*--------- END OF CONFIGURATION ------------------*/

//	$rss = new rss_feed('xmlns:dc="http://purl.org/dc/elements/1.1/"');
	$rss = new rss_feed();

//	$rss->rss_feed_xmlns('xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"');
//	$rss->rss_feed_xmlns('xmlns:admin="http://webns.net/mvcb/"');
//	$rss->rss_feed_xmlns(array('xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"', 'xmlns:content="http://purl.org/rss/1.0/modules/content/"'));

//	$rss->rss_feed_style('rss.css', 'text/css');
	$rss->rss_feed_style('rss.xsl', 'text/xsl');
	$rss->rss_feed_description_set(RSS_FEED_DESCRIPTION, RSS_FEED_DESCRIPTION_CHARACTERS);
	$rss->rss_feed_set('encoding', $_SESSION['language_charset']);
	$rss->rss_feed_set('content_type', 'text/xml');
	$rss->rss_feed_set('title', STORE_NAME);
	$rss->rss_feed_set('link', HTTP_SERVER . DIR_WS_CATALOG);
	$rss->rss_feed_set('description', STORE_NAME_ADDRESS);
	$rss->rss_feed_set('lastBuildDate', date('r'));
	$rss->rss_feed_set('generator', RSS_GENERATOR);
	$rss->rss_feed_set('copyright', RSS_CONTENT_COPYRIGHT);
	$rss->rss_feed_set('managingEditor', STORE_OWNER_EMAIL_ADDRESS . " (" . STORE_OWNER . ")");
	$rss->rss_feed_set('ttl', RSS_TTL);
	$rss->rss_feed_image(RSS_IMAGE_NAME, HTTP_SERVER . DIR_WS_CATALOG, HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_IMAGES . RSS_IMAGE);

// get the language code...
//$lang_code_query = vam_db_query("select code from " . TABLE_LANGUAGES . " where languages_id = " . $languages_id);
//   if($lang_code = vam_db_fetch_array($lang_code_query))
//      $lang_code = $lang_code['code'];
//   else
//      $lang_code = DEFAULT_LANGUAGE;

//   $rss->rss_feed_set('language', $lang_code);
   $rss->rss_feed_set('language', $_SESSION['language_code']);

	$random = false;
	$limit = "";

	switch($_GET["feed"]) {

/*
		case "orders":
			if(isset($_SERVER["PHP_AUTH_USER"]) && isset($_SERVER["PHP_AUTH_PW"])) {
				$message = false;
				$admin_name = zen_db_prepare_input($_SERVER["PHP_AUTH_USER"]);
				$admin_pass = zen_db_prepare_input($_SERVER["PHP_AUTH_PW"]);
				$sql = "select admin_id, admin_name, admin_pass from " . TABLE_ADMIN . " where admin_name = '" . zen_db_input($admin_name) . "'";
				$result = $db->Execute($sql);
				if (!($admin_name == $result->fields['admin_name'])) {
					$message = true;
					$pass_message = ERROR_WRONG_LOGIN;
				}
				if (!zen_validate_password($admin_pass, $result->fields['admin_pass'])) {
					$message = true;
					$pass_message = ERROR_WRONG_LOGIN;
				}
				if ($message == false) {
					$_SESSION['admin_id'] = $result->fields['admin_id'];
					zen_redirect(zen_href_link(FILENAME_DEFAULT, '', 'SSL'));
				}
			} else {
				$message = true;
			}
			break;
*/

		case "categories":
			// don't build a tree when no categories
			$check_categories_query = vam_db_query("select categories_id from " . TABLE_CATEGORIES . " where categories_status=1 limit 1");
			if (vam_db_num_rows($check_categories_query) > 0) {
				vam_rss_category_tree(0, '', (isset($_GET['limit']) && (int)$_GET['limit'] > 0) ? (int)$_GET['limit'] : null);
				$rss->rss_feed_out();
			}
			break;

		case "news":
			$news_query = "
      SELECT
          news_id,
          headline,
          content,
          date_added
      FROM " . TABLE_LATEST_NEWS . "
      WHERE
          status = '1'
          and language = '" . (int)$_SESSION['languages_id'] . "'
      ORDER BY date_added DESC
      ";
			vam_rss_news($news_query);
			break;

		case "articles":
			$articles_query = "SELECT ad.articles_id, ad.articles_name, ad.articles_description, a.articles_date_added 
			                                            FROM " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad
			                                            WHERE ad.articles_id = a.articles_id and ad.language_id='" . (int)$_SESSION['languages_id'] . "'";
			                                            
			vam_rss_articles($articles_query);
			break;

		case "specials_random":
			$random = true;
			$limit = " limit " . MAX_RANDOM_SELECT_SPECIALS;
		case "specials":
			$specials_product_query = "select p.products_id, pd.products_name, pd.products_description, p.products_image, p.products_date_added, p.products_last_modified, p.products_price, p.products_tax_class_id, s.specials_new_products_price
														 from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, "
																		. TABLE_SPECIALS . " s
														 where p.products_status = '1'
														 and p.products_id = s.products_id
														 and pd.products_id = s.products_id
														 and pd.language_id = '" . (int) $_SESSION['languages_id'] . "'
														 and s.status = '1'" . $limit;
			vam_rss_products($specials_product_query);
			break;

		case "featured_random":
			$random = true;
			$limit = " limit " . MAX_RANDOM_SELECT_FEATURED;
		case "featured":
			$featured_product_query = "select p.products_id, pd.products_name, pd.products_description, p.products_image, p.products_date_added, p.products_last_modified, p.products_price, p.products_tax_class_id
														 from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, "
																		. TABLE_FEATURED . " f
														 where p.products_status = '1'
														 and p.products_id = f.products_id
														 and pd.products_id = f.products_id
														 and pd.language_id = '" . (int) $_SESSION['languages_id'] . "'
														 and f.status = '1'" . $limit;
			vam_rss_products($featured_product_query);
			break;

		case "best_sellers_random":
			$random = true;
			$limit = " limit " . MAX_DISPLAY_BESTSELLERS;
		case "best_sellers":
			$cat_where = $cat_from = "";
			if (isset($current_category_id) && ($current_category_id > 0)) {
				$cat_from = ", " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c ";
				$cat_where = "and p.products_id = p2c.products_id
											and c.categories_id = '" . $current_category_id . "'
											and p2c.categories_id = '" . $current_category_id . "' ";
			}
			$best_sellers_query = "select distinct p.products_id, pd.products_name, pd.products_description, p.products_image, products_date_added, p.products_last_modified, p.products_ordered
														 from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd" . $cat_from . "
														 where p.products_status = '1'
														 and p.products_ordered > 0
														 and p.products_id = pd.products_id
														 and pd.language_id = '" . (int) $_SESSION['languages_id'] . "'" . $cat_where ."
														 order by p.products_ordered desc, pd.products_name" . $limit;
			vam_rss_products($best_sellers_query);
			break;

		case "upcoming_random":
			$random = true;
			$limit = " limit " . MAX_DISPLAY_UPCOMING_PRODUCTS;
		case "upcoming":
			$cat_where = $cat_from = "";
			if (isset($current_category_id) && ($current_category_id > 0)) {
				$cat_from = ", " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c ";
				$cat_where = "and p.products_id = p2c.products_id
											and c.categories_id = '" . $current_category_id . "'
											and p2c.categories_id = '" . $current_category_id . "' ";
			}
			$expected_query = "select p.products_id, pd.products_name, pd.products_description, p.products_image, products_date_added, p.products_last_modified, products_date_available as date_expected
												 from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd" . $cat_from . "
												 where to_days(products_date_available) >= to_days(now())
												 and p.products_status = '1'
												 and p.products_id = pd.products_id
												 and pd.language_id = '" . (int) $_SESSION['languages_id'] .
												$cat_where . "'
												 order by " . EXPECTED_PRODUCTS_FIELD . " " . EXPECTED_PRODUCTS_SORT . $limit;
			vam_rss_products($expected_query);
			break;

		case "new_products_random":
			$random = true;
			$limit = " limit " . MAX_RANDOM_SELECT_NEW;
		case "new_products":
					$days_limit = ' and p.products_startpage = 1';

		case "products":
		default:
		$days_limit = "";
			if (isset($_GET['products_id']) && (int)$_GET['products_id'] > 0)
				$days_limit .= ' and p.products_id=' . (int)$_GET['products_id'];
			$sql_products = "select p.products_id, pd.products_name, pd.products_description, p.products_image, p.products_date_added, p.products_last_modified
												from " . TABLE_PRODUCTS . " p, " .
																 TABLE_PRODUCTS_DESCRIPTION . " pd ";
			if (isset($current_category_id) && ($current_category_id > 0)) {
				$sql_products .= ", " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c  ";
			}
			$sql_products .= "where p.products_id = pd.products_id ";
			if (isset($current_category_id) && ($current_category_id > 0)) {
				$sql_products .= "and p.products_id = p2c.products_id
													and c.categories_id = '" . $current_category_id . "'
													and p2c.categories_id = '" . $current_category_id . "' ";
			}
			$sql_products .= "and pd.language_id = " . (int) $_SESSION['languages_id'] . "
												and p.products_status = '1'" . $days_limit . "
												order by p.products_last_modified desc" . $limit;

			vam_rss_products($sql_products);
			break;
	}

	function vam_rss_products($sql_products){
		global $db, $rss, $random;

		$sql_maxdate = "select max(products_date_added) as max_date_added, max(products_last_modified) as max_date_modified
										from " . TABLE_PRODUCTS . "
										where products_status = 1";
		$maxdate = vam_db_query($sql_maxdate);
		if(!$maxdate) {
			$rss->rss_feed_set('lastBuildDate', date('r', strtotime(max($maxdate['max_date_added'], $maxdate['max_date_modified']))));
		}

		if(isset($_GET['limit']) && (int)$_GET['limit'] > 0 && !$random)
			$sql_products .= ' limit ' . (int)$_GET['limit'];

		if ($random)
			$products = vam_random_select($sql_products);
		else
		$products_query = vam_db_query($sql_products);


		 if ($random) {
         $products = vam_random_select($sql_products);
         $link = vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($products['products_id'], $products['products_name']) . (isset($_GET['ref']) ? '&ref=' . $_GET['ref'] : null), 'NONSSL', false);
         $rss->rss_feed_item($products['products_name'], $link, $link, date('r', strtotime(max($products['products_date_added'], $products['products_last_modified']))), $products['products_description'], $products['products_image'], vam_href_link(FILENAME_PRODUCT_REVIEWS,'products_id='.$products['products_id'] . (isset($_GET['ref']) ? '&ref=' . $_GET['ref'] : null), 'NONSSL', false));
      } else {
         $products_query = vam_db_query($sql_products);
         while($products = vam_db_fetch_array($products_query)) {
            $link = vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($products['products_id'], $products['products_name']) . (isset($_GET['ref']) ? '&ref=' . $_GET['ref'] : null), 'NONSSL', false);
            $rss->rss_feed_item($products['products_name'], $link, $link, date('r', strtotime(max($products['products_date_added'], $products['products_last_modified']))), $products['products_description'], $products['products_image'], vam_href_link(FILENAME_PRODUCT_REVIEWS,'products_id='.$products['products_id'] . (isset($_GET['ref']) ? '&ref=' . $_GET['ref'] : null), 'NONSSL', false));
            if ($random)
               break;
         }
      }
		
		
		
		$rss->rss_feed_out();
	}

/////////////////////////////////////////////////////////////////////////////
// рекурсивная функция, получает категории каталога в иерархии по порядку
// get all groups
function vam_rss_category_tree($id_parent=0, $cPath='', $limit = null){
	global $db, $rss;
	if($limit != null && $limit < 0)
		return;
	if($limit != null) $limit--;
	$groups_cat_query = vam_db_query("select c.categories_id, c.parent_id, c.date_added, c.last_modified, c.categories_image, cd.categories_name, cd.categories_description
											 from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
											 where c.parent_id = '" . (int)$id_parent . "'
											 and c.categories_id = cd.categories_id
											 and cd.language_id='" . (int) $_SESSION['languages_id'] . "'
											 and c.categories_status= '1'
											 order by c.sort_order, cd.categories_name");
	if (vam_db_num_rows($groups_cat_query) == 0)
		return;
	while ($groups_cat = vam_db_fetch_array($groups_cat_query)) {
		$link_categories = addslashes(vam_href_link(FILENAME_DEFAULT, vam_category_link($groups_cat['categories_id'], $groups_cat['categories_name']) . (isset($_GET['ref']) ? '&ref=' . $_GET['ref'] : null), 'NONSSL', false));
		$products_in_category = vam_count_products_in_category($groups_cat['categories_id']);
		if ((CATEGORIES_COUNT_ZERO == '1' && $products_in_category == 0) or $products_in_category >= 1) {
			$rss->rss_feed_item($groups_cat['categories_name'], $link_categories, $link_categories, date('r', strtotime(max($groups_cat['date_added'],$groups_cat['last_modified']))), $groups_cat['categories_description'], $groups_cat['categories_image'], false, STORE_OWNER_EMAIL_ADDRESS . " (" . STORE_OWNER . ")");
		}
		if (vam_has_category_subcategories($groups_cat['categories_id'])) {
			vam_rss_category_tree($groups_cat['categories_id'],
									(vam_not_null($cPath) ?
										$cPath . '_' . $groups_cat['categories_id'] :
										$groups_cat['categories_id']), $limit); // следующая группа
		}
//		$groups_cat->MoveNext();
	}
}

	function vam_rss_news($sql_products){
		global $db, $rss, $random;

		$sql_maxdate = "select max(date_added) as max_date_added, max(date_added) as max_date_modified
										from " . TABLE_LATEST_NEWS . "
										where status = 1";
		$maxdate = vam_db_query($sql_maxdate);
		if(!$maxdate) {
			$rss->rss_feed_set('lastBuildDate', date('r', strtotime(max($maxdate['max_date_added'], $maxdate['max_date_modified']))));
		}

		if(isset($_GET['limit']) && !$random)
			$sql_products .= ' limit ' . $_GET['limit'];

         $products_query = vam_db_query($sql_products);
         while($products = vam_db_fetch_array($products_query)) {

		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&headline='.vam_cleanName($products['headline']);

            $link = vam_href_link(FILENAME_NEWS, 'news_id='.$products['news_id'] . $SEF_parameter . (isset($_GET['ref']) ? '&ref=' . $_GET['ref'] : null), 'NONSSL', false);
            $rss->rss_feed_item($products['headline'], $link, $link, date('r', strtotime(max($products['date_added'], $products['date_added']))), $products['content'], '', '');
         }
	
		$rss->rss_feed_out();
	}

	function vam_rss_articles($sql_products){
		global $db, $rss, $random;

		$sql_maxdate = "select max(articles_date_added) as max_date_added, max(articles_last_modified) as max_date_modified
										from " . TABLE_ARTICLES . "
										where articles_status = 1";
		$maxdate = vam_db_query($sql_maxdate);
		if(!$maxdate) {
			$rss->rss_feed_set('lastBuildDate', date('r', strtotime(max($maxdate['max_date_added'], $maxdate['max_date_modified']))));
		}

		if(isset($_GET['limit']) && !$random)
			$sql_products .= ' limit ' . $_GET['limit'];

         $products_query = vam_db_query($sql_products);
         while($products = vam_db_fetch_array($products_query)) {
         
		$SEF_parameter = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter = '&article='.vam_cleanName($products['articles_name']);
         
            $link = vam_href_link(FILENAME_ARTICLE_INFO, 'articles_id='.$products['articles_id'] . $SEF_parameter . (isset($_GET['ref']) ? '&ref=' . $_GET['ref'] : null), 'NONSSL', false);
            $rss->rss_feed_item($products['articles_name'], $link, $link, date('r', strtotime(max($products['articles_date_added'], $products['articles_last_modified']))), $products['articles_description'], '', '');
         }
	
		$rss->rss_feed_out();
	}




/////////////////////////////////////////////////////////////////////////////
//
//
/////////////////////////////////////////////////////////////////////////////
class rss_feed {
	var $xmlns = array();
	var $description_out = true;
	var $description_out_max = 0;
	var $encoding = "UTF-8";
	var $title = "";
	var $language = "en-us";
	var $description = "";
	var $link = "";
	var $generator = "rss_generator";
	var $copyright = false;
	var $lastBuildDate = false;
	var $managingEditor = false;
	var $webMaster = false;
	var $category = false;
	var $docs = false;
	var $ttl = 1440;
	var $version = "2.0";
	var $content_type = "text/xml";
	var $stylesheet_type = "text/css";
	var $stylesheet_href = "";
	var $image = false;
	var $textInput = false;
	var $item = array();

	function __constructor($xmlns = array()) {
		if (is_array($xmlns))
			$this->xmlns = $xmlns;
		elseif (is_string($xmlns))
			$this->xmlns = array("0" => $xmlns);
	}

	function rss_feed_xmlns($xmlns = "") {
		if (is_array($xmlns)) {
			for ($i=0,$n=sizeof($xmlns);$i<$n;$i++) {
				$this->xmlns[] = $xmlns[$i];
			}
		} elseif (is_string($xmlns))
			$this->xmlns[] = $xmlns;
	}

	function rss_feed_set($name, $value) {
		switch ($name) {
			case 'encoding':
				$this->encoding = $this->_clear_string($value);
				break;
			case 'title':
				$this->title = $this->_clear_string($value);
				break;
			case 'language':
				$this->language = $this->_clear_string($value);
				break;
			case 'description':
				$this->description = $this->_clear_string($value);
				break;
			case 'generator':
				$this->generator = $this->_clear_string($value);
				break;
			case 'link':
				$this->link = $this->_clear_string($value);
				break;
			case 'content_type':
				$this->content_type = $value;
				break;
			case 'lastBuildDate':
				$this->lastBuildDate = $value;
				break;
			case 'copyright':
				$this->copyright = $this->_clear_string($value);
				break;
			case 'managingEditor':
				$this->managingEditor = $this->_clear_string($value);
				break;
			case 'ttl':
				$this->ttl = $value;
				break;
			case 'webMaster':
				$this->webMaster = $value;
				break;
			case 'category':
				$this->category = $value;
				break;
			case 'docs':
				$this->docs = $value;
				break;
		}
		return;
	}

	function rss_feed_style($href, $type = "text/css") {
		$this->stylesheet_type = $type;
		$this->stylesheet_href = $href;
	}

	function rss_feed_image($title, $link, $url) {
		$this->image['title'] = $this->_clear_string($title);
		$this->image['link'] = $this->_clear_string($link);
		$this->image['url'] = $this->_clear_string($url);
	}

	function rss_feed_textInput($title, $link, $description, $name) {
		$this->textInput['title'] = $this->_clear_string($title);
		$this->textInput['link'] = $this->_clear_string($link);
		$this->textInput['description'] = $this->_clear_string($description);
		$this->textInput['name'] = $this->_clear_string($name);
	}

	function rss_feed_item($title, $link, $guid = false, $pubDate = false, $description = false, $enclosure = 'NULL', $comments = false, $author = false, $category = false) {
		$this->item['title'][] = $this->_clear_string($title);
		$this->item['link'][] = $this->_clear_string($link);
		$this->item['guid'][] = $this->_clear_string($guid);
		$this->item['pubDate'][] = $this->_clear_string($pubDate);
		$this->item['author'][] = $this->_clear_string($author);
		$this->item['description'][] = $this->_clear_string($description);
		$this->item['category'][] = $this->_clear_string($category);
		$this->item['comments'][] = $this->_clear_string($comments);
		$this->item['enclosure'][] = $enclosure;
	}

	function rss_feed_description_set($out, $max) {
		$this->description_out = $out;
		$this->description_out_max = $max;
	}

	function rss_feed_out() {
		header('Last-Modified: ' . gmdate("r") . ' GMT');
		header('Expires: ' . gmdate("r", (time()+600)) . ' GMT');
		header("Content-Type: " . $this->content_type . "; charset=" . $this->encoding);
		header("Content-disposition: inline; filename=rss.xml");
		echo '<?xml version="1.0" encoding="' . $this->encoding . '"?>' . "\n";
		if ($this->stylesheet_href != "")
			echo '<?xml-stylesheet type="' . $this->stylesheet_type . '" href="' . $this->stylesheet_href . '"?>' . "\n";
		if (!$this->lastBuildDate)
			$this->lastBuildDate = date('r');
		if (sizeof($this->xmlns) > 0) {
			$xmlns = "\n" . implode("\n", $this->xmlns);
		} else {
			$xmlns = "";
		}
		echo '<rss version="' . $this->version . '"' . $xmlns . '>' . "\n" .
				 '  <channel>' . "\n" .
				 '    <title>' . CDATA_OPEN . $this->title . CDATA_CLOSE . '</title>' . "\n" .
				 '    <link>' . $this->link . '</link>' . "\n" .
				 '    <description>' . CDATA_OPEN . $this->description . CDATA_CLOSE . '</description>' . "\n" .
				 '    <language>' . $this->language . '</language>' . "\n" .
				 '    <ttl>' . $this->ttl . '</ttl>' . "\n";
		if ($this->lastBuildDate)
			echo '    <lastBuildDate>' . $this->lastBuildDate . '</lastBuildDate>' . "\n";
		else
			echo '    <lastBuildDate>' . date('r') . '</lastBuildDate>' . "\n";
		if ($this->generator)
			echo '    <generator>' . CDATA_OPEN . $this->generator . CDATA_CLOSE . '</generator>' . "\n";
		if ($this->copyright)
			echo '    <copyright>' . CDATA_OPEN . $this->copyright . CDATA_CLOSE . '</copyright>' . "\n";
		if ($this->managingEditor)
			echo '    <managingEditor>' . $this->managingEditor . '</managingEditor>' . "\n";
		if ($this->webMaster)
			echo '    <webMaster>' . $this->webMaster . '</webMaster>' . "\n";
		if ($this->category)
			echo '    <category>' . CDATA_OPEN . $this->category . CDATA_CLOSE . '</category>' . "\n";
		if ($this->docs)
			echo '    <docs>' . $this->docs . '</docs>' . "\n";
		if ($this->image) {
			echo '    <image>' . "\n" .
					 '      <title>' . CDATA_OPEN . $this->image['title'] . CDATA_CLOSE . '</title>' . "\n" .
					 '      <link>' . $this->image['link'] . '</link>' . "\n" .
					 '      <url>' . $this->image['url'] . '</url>' . "\n" .
					 '    </image>' . "\n";
		}
		if ($this->textInput) {
			echo '    <textInput>' . "\n" .
					 '     <title>' . CDATA_OPEN . $this->textInput_title . CDATA_CLOSE . '</title>' . "\n" .
					 '     <description>' . CDATA_OPEN . $this->textInput_description . CDATA_CLOSE . '</description>' . "\n" .
					 '     <name>' . CDATA_OPEN . $this->textInput_name . CDATA_CLOSE . '</name' . "\n" .
					 '     <link>' . $this->textInput_link . '</link>' . "\n" .
					 '   </textInput>' . "\n";
		}

		for($i=0,$n=sizeof($this->item['title']);$i<$n;$i++) {
			echo '    <item>' . "\n" .
					 '      <title>' . CDATA_OPEN . $this->item['title'][$i] . CDATA_CLOSE . '</title>' . "\n" .
					 '      <link>' . $this->item['link'][$i] . '</link>' . "\n";
			if ($this->item['comments'][$i])
				echo '      <comments>' . CDATA_OPEN . $this->item['comments'][$i] . CDATA_CLOSE . '</comments>' . "\n";
			if ($this->description_out == true && $this->item['description'][$i]) {
				if (strlen($this->item['description'][$i]) > $this->description_out_max && $this->description_out_max > 0)
					$this->item['description'][$i] = substr($this->item['description'][$i], 0, $this->description_out_max) . ' ...';
				echo '      <description>' . CDATA_OPEN . $this->item['description'][$i] . CDATA_CLOSE . '</description>' . "\n";
			}
			if ($this->item['author'][$i])
				echo '      <author>' . $this->item['author'][$i] . '</author>' . "\n";
			if ($this->item['category'][$i])
				echo '      <category>' . CDATA_OPEN . $this->item['category'][$i] . CDATA_CLOSE . '</category>' . "\n";
			if($this->item['enclosure'][$i] != 'NULL' && $this->item['enclosure'][$i] != '' && is_file(DIR_FS_CATALOG . DIR_WS_INFO_IMAGES . $this->item['enclosure'][$i])) {
				$imageinfo = getimagesize(DIR_FS_CATALOG . DIR_WS_INFO_IMAGES . $this->item['enclosure'][$i]);
				echo '      <enclosure url="' . HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_INFO_IMAGES . $this->item['enclosure'][$i] . '" length="' . filesize(DIR_FS_CATALOG . DIR_WS_INFO_IMAGES . $this->item['enclosure'][$i]) . '" type="' . $imageinfo['mime'] . '" />' . "\n";
			}
			if ($this->item['guid'][$i])
				echo '      <guid>' . $this->item['guid'][$i] . '</guid>' . "\n";
			if ($this->item['pubDate'][$i])
				echo '      <pubDate>' . $this->item['pubDate'][$i] . '</pubDate>' . "\n";
			echo '    </item>' . "\n";
		}
		echo '  </channel>' . "\n" .
				 '</rss>' . "\n";
	}

	function _clear_string($str) {
		$in[] = '@&(nbsp|#160);@i'; $out[] = ' ';
		if(RSS_STRIP_TAGS == 'true') {
			$in[] = '@<br>@'; $out[] = "\n";
			$in[] = '@<br />@'; $out[] = "\n";
		}
		$in[] = '@&(hellip|#8230);@i'; $out[] = '. . .';
		$in[] = '@&(copy|#169);@i'; $out[] = '(c)';
		$in[] = '@&(trade|#129);@i'; $out[] = '(tm)';
		$in[] = '@&(amp|#38);@i'; $out[] = '&';
		$in[] = '@&(lt|#60);@i'; $out[] = '<';
		$in[] = '@&(gt|#62);@i'; $out[] = '>';
		$str = preg_replace($in, $out, $str);
		if(RSS_STRIP_TAGS == 'true')
			$str = strip_tags($str);
		$str = htmlspecialchars($str, ENT_QUOTES);
		return($str);
	}
}
?>
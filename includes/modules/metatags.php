<?php
/* -----------------------------------------------------------------------------------------
   $Id: metatags.php 1140 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (metatags.php,v 1.7 2003/08/14); www.nextcommerce.org
   (c) 2004	 xt:Commerce (metatags.php,v 1.7 2003/08/14); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
?>
<meta name="robots" content="<?php echo META_ROBOTS; ?>" />
<meta name="company" content="<?php echo META_COMPANY; ?>" />
<meta name="author" content="<?php echo META_AUTHOR; ?>" />
<meta name="publisher" content="<?php echo META_PUBLISHER; ?>" />
<meta name="distribution" content="global" />
<meta name="reply-to" content="<?php echo META_REPLY_TO; ?>" />
<meta name="revisit-after" content="<?php echo META_REVISIT_AFTER; ?>" />
<meta name="page-topic" content="<?php echo META_TOPIC; ?>" />
<meta name="language" content="<?php echo $_SESSION['language_code']; ?>" />
<?php

if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO)) {

	if ($product->isProduct()) {
        $description = $product->data['products_meta_description'];
        if (strlen($description) == 0){
            $description = $product->data['products_name'];
        }
?>	
<meta name="description" content="<?php echo $description; ?>" />
<meta name="keywords" content="<?php echo $product->data['products_meta_keywords']; ?>" />
<title><?php echo $product->data['products_meta_title'].' '.$product->data['products_name'].' '.$product->data['products_model'] . ' - ' . TITLE; ?></title>
	<?php

	} else {
?>
<meta name="description" content="<?php echo META_DESCRIPTION; ?>" />
<meta name="keywords" content="<?php echo META_KEYWORDS; ?>" />
<title><?php echo TITLE; ?></title>	
	<?php

	}

} else {
	if ($_GET['cPath']) {
		if (strpos($_GET['cPath'], '_') == '1') {
			$arr = explode('_', xtc_input_validation($_GET['cPath'], 'cPath', ''));
			$_cPath = $arr[1];
		} else {
			//$_cPath=(int)$_GET['cPath'];
			if (isset ($_GET['cat'])) {
				$site = explode('_', $_GET['cat']);
				$cID = $site[0];
				$_cPath = str_replace('c', '', $cID);
			}
		}
		$categories_meta_query = xtDBquery("SELECT categories_meta_keywords,
		                                            categories_meta_description,
		                                            categories_meta_title,
		                                            categories_name
		                                            FROM " . TABLE_CATEGORIES_DESCRIPTION . "
		                                            WHERE categories_id='" . $_cPath . "' and
		                                            language_id='" . $_SESSION['languages_id'] . "'");
		$categories_meta = xtc_db_fetch_array($categories_meta_query, true);
		if ($categories_meta['categories_meta_keywords'] == '') {
			$categories_meta['categories_meta_keywords'] = META_KEYWORDS;
		}
		if ($categories_meta['categories_meta_description'] == '') {
			$categories_meta['categories_meta_description'] = META_DESCRIPTION;
		}
		if ($categories_meta['categories_meta_title'] == '') {
			$categories_meta['categories_meta_title'] = $categories_meta['categories_name'];
		}
?>
<meta name="description" content="<?php echo $categories_meta['categories_meta_description']; ?>" />
<meta name="keywords" content="<?php echo $categories_meta['categories_meta_keywords']; ?>" />
<title><?php echo $categories_meta['categories_meta_title'] . ' - ' . TITLE; ?></title>
<?php

	} else {

switch (true) {
  case ($_GET['coID']):

			$contents_meta_query = xtDBquery("SELECT content_heading
			                                            FROM " . TABLE_CONTENT_MANAGER . "
			                                            WHERE content_group='" . $_GET['coID'] . "' and
			                                            languages_id='" . $_SESSION['languages_id'] . "'");
			$contents_meta = xtc_db_fetch_array($contents_meta_query, true);
?>
<meta name="description" content="<?php echo META_DESCRIPTION; ?>" />
<meta name="keywords" content="<?php echo META_KEYWORDS; ?>" />
<title><?php echo $contents_meta['content_heading'] . ' - ' . TITLE; ?></title>
<?php

    break;

  case ($_GET['news_id']):

			$news_meta_query = xtDBquery("SELECT headline
			                                            FROM " . TABLE_LATEST_NEWS . "
			                                            WHERE news_id='" . (int)$_GET['news_id'] . "' and
			                                            language='" . (int)$_SESSION['languages_id'] . "'");
			$news_meta = xtc_db_fetch_array($news_meta_query, true);
?>
<meta name="description" content="<?php echo META_DESCRIPTION; ?>" />
<meta name="keywords" content="<?php echo META_KEYWORDS; ?>" />
<title><?php echo $news_meta['headline'] . ' - ' . TITLE; ?></title>
<?php

    break;

  case ($_GET['tPath']):

			$articles_cat_meta_query = xtDBquery("SELECT topics_name, topics_heading_title, topics_description
			                                            FROM " . TABLE_TOPICS_DESCRIPTION . "
			                                            WHERE topics_id='" . (int)$current_topic_id . "' and
			                                            language_id='" . (int)$_SESSION['languages_id'] . "'");
			$articles_cat_meta = xtc_db_fetch_array($articles_cat_meta_query, true);

		if ($articles_cat_meta['topics_heading_title'] == '') {
			$articles_cat_title = $articles_cat_meta['topics_name'];
		} else {
			$articles_cat_title = $articles_cat_meta['topics_heading_title'];
		}

		if ($articles_cat_meta['topics_description'] == '') {
			$articles_cat_desc = META_DESCRIPTION;
		} else {
			$articles_cat_desc = $articles_cat_meta['topics_description'];
		}

?>
<meta name="description" content="<?php echo $articles_cat_desc; ?>" />
<meta name="keywords" content="<?php echo META_KEYWORDS; ?>" />
<title><?php echo $articles_cat_title . ' - ' . TITLE; ?></title>
<?php

    break;

  case ($_GET['articles_id']):

			$articles_meta_query = xtDBquery("SELECT articles_name, articles_head_title_tag, articles_head_desc_tag, articles_head_keywords_tag
			                                            FROM " . TABLE_ARTICLES_DESCRIPTION . "
			                                            WHERE articles_id='" . (int)$_GET['articles_id'] . "' and
			                                            language_id='" . (int)$_SESSION['languages_id'] . "'");
			$articles_meta = xtc_db_fetch_array($articles_meta_query, true);

		if ($articles_meta['articles_head_title_tag'] == '') {
			$articles_title = $articles_meta['articles_name'];
		} else {
			$articles_title = $articles_meta['articles_head_title_tag'];
		}

		if ($articles_meta['articles_head_desc_tag'] == '') {
			$articles_desc = META_DESCRIPTION;
		} else {
			$articles_desc = $articles_meta['articles_head_desc_tag'];
		}

		if ($articles_meta['articles_head_keywords_tag'] == '') {
			$articles_key = META_KEYWORDS;
		} else {
			$articles_key = $articles_meta['articles_head_keywords_tag'];
		}

?>
<meta name="description" content="<?php echo $articles_desc; ?>" />
<meta name="keywords" content="<?php echo $articles_key; ?>" />
<title><?php echo $articles_title . ' - ' . TITLE; ?></title>
<?php

    break;

  case ($_GET['authors_id']):

			$authors_meta_query = xtDBquery("SELECT authors_name
			                                            FROM " . TABLE_AUTHORS . "
			                                            WHERE authors_id='" . (int)$_GET['authors_id'] . "'");
			$authors_meta = xtc_db_fetch_array($authors_meta_query, true);
?>
<meta name="description" content="<?php echo META_DESCRIPTION; ?>" />
<meta name="keywords" content="<?php echo META_KEYWORDS; ?>" />
<title><?php echo $authors_meta['authors_name'] . ' - ' . TITLE; ?></title>
<?php

    break;

default:
?>
<meta name="description" content="<?php echo META_DESCRIPTION; ?>" />
<meta name="keywords" content="<?php echo META_KEYWORDS; ?>" />
<title><?php echo TITLE; ?></title>
<?php
     }
	}
}
?>
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
<?php

if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO)) {

	if ($product->isProduct()) {
        $description = vam_parse_input_field_data($product->data['products_meta_description'], array('"' => '&quot;'));
        if (strlen($description) == 0){
            $description = vam_parse_input_field_data($product->data['products_name'], array('"' => '&quot;'));
        }

        $title = vam_parse_input_field_data($product->data['products_meta_title'], array('"' => '&quot;'));
        if (strlen($title) == 0){
            $title = vam_parse_input_field_data($product->data['products_name'], array('"' => '&quot;'));
        }

$cat_query = vamDBquery("SELECT
                                 categories_name
                                 FROM ".TABLE_CATEGORIES_DESCRIPTION." 
                                 WHERE categories_id='".$current_category_id."'
                                 and language_id = '".(int) $_SESSION['languages_id']."'"
                                 );
$cat_data = vam_db_fetch_array($cat_query, true);         
?>	
<title><?php echo $title.' '.$product->data['products_model'] . ' - ' . $cat_data['categories_name'] . ' - ' . TITLE; ?></title>
<meta name="description" content="<?php echo $description; ?>" />
<meta name="keywords" content="<?php echo $product->data['products_meta_keywords']; ?>" />
	<?php

	} else {
?>
<title><?php echo TITLE; ?></title>	
<meta name="description" content="<?php echo META_DESCRIPTION; ?>" />
<meta name="keywords" content="<?php echo META_KEYWORDS; ?>" />
	<?php

	}

} else {
	if ($_GET['cPath']) {
		if (strpos($_GET['cPath'], '_') == '1') {
			$arr = explode('_', vam_input_validation($_GET['cPath'], 'cPath', ''));
			$size = count($arr);
			$_cPath = $arr[$size-1];
		} else {
			//$_cPath=(int)$_GET['cPath'];
			if (isset ($_GET['cat'])) {
				$site = explode('_', $_GET['cat']);
				$cID = $site[0];
				$_cPath = str_replace('c', '', $cID);
			}
		}
		$categories_meta_query = vamDBquery("SELECT categories_meta_keywords,
		                                            categories_meta_description,
		                                            categories_meta_title,
		                                            categories_name
		                                            FROM " . TABLE_CATEGORIES_DESCRIPTION . "
		                                            WHERE categories_id='" . $_cPath . "' and
		                                            language_id='" . $_SESSION['languages_id'] . "'");
		$categories_meta = vam_db_fetch_array($categories_meta_query, true);
		if ($categories_meta['categories_meta_keywords'] == '') {
			$categories_meta['categories_meta_keywords'] = META_KEYWORDS;
		}
		if ($categories_meta['categories_meta_description'] == '') {
			$categories_meta['categories_meta_description'] = META_DESCRIPTION;
		}
		if ($categories_meta['categories_meta_title'] == '') {
			$categories_meta['categories_meta_title'] = $categories_meta['categories_name'];
		}
		if (isset($_GET['filter_id']) or isset($_GET['manufacturers_id'])) {		

	$mID = (isset($_GET['filter_id']) ? $_GET['filter_id'] : $_GET['manufacturers_id']);
		
		    $manufacturer_query = vamDBquery("select m.manufacturers_name, mi.manufacturers_meta_title, mi.manufacturers_meta_description, mi.manufacturers_meta_keywords from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on mi.manufacturers_id = m.manufacturers_id where m.manufacturers_id = '" . $mID . "'");
		      $manufacturer = vam_db_fetch_array($manufacturer_query,true);		

   $mName = (isset($manufacturer['manufacturers_meta_title']) ? ' - ' . $manufacturer['manufacturers_meta_title'] : ' - ' . $manufacturer['manufacturers_name']);
   $mDesc = (isset($manufacturer['manufacturers_meta_description']) ? ' ' . $manufacturer['manufacturers_meta_description'] : null);
   $mKey = (isset($manufacturer['manufacturers_meta_keywords']) ? ' ' . $manufacturer['manufacturers_meta_keywords'] : null);


		}		
?>
<title><?php echo $categories_meta['categories_meta_title'] . $mName . ' - ' . TITLE; ?></title>
<meta name="description" content="<?php echo $categories_meta['categories_meta_description'] . $mDesc; ?>" />
<meta name="keywords" content="<?php echo $categories_meta['categories_meta_keywords'] . $mKey; ?>" />
<?php

	} else {

switch (true) {
  case ($_GET['coID']):

$content_meta_query = vamDBquery("select cm.content_heading, cm.content_meta_title, cm.content_meta_description,  cm.content_meta_keywords from " . TABLE_CONTENT_MANAGER . " cm where cm.content_group = '" . (int)$_GET['coID'] . "' and cm.languages_id = '" . (int)$_SESSION['languages_id'] . "'");

if (vam_db_num_rows($content_meta_query, true) > 0) {

$content_meta = vam_db_fetch_array($content_meta_query);

		if ($content_meta['content_meta_title'] == '') {
			$content_title = $content_meta['content_heading'];
		} else {
			$content_title = $content_meta['content_meta_title'];
		}

		if ($content_meta['content_meta_description'] == '') {
			$content_desc = META_DESCRIPTION;
		} else {
			$content_desc = $content_meta['content_meta_description'];
		}

		if ($content_meta['content_meta_keywords'] == '') {
			$content_key = META_KEYWORDS;
		} else {
			$content_key = $content_meta['content_meta_keywords'];
		}

}

?>
<title><?php echo $content_title . ' - ' . TITLE; ?></title>
<meta name="description" content="<?php echo $content_desc; ?>" />
<meta name="keywords" content="<?php echo $content_key; ?>" />
<?php

    break;

  case ($_GET['news_id']):

			$news_meta_query = vamDBquery("SELECT headline
			                                            FROM " . TABLE_LATEST_NEWS . "
			                                            WHERE news_id='" . (int)$_GET['news_id'] . "' and
			                                            language='" . (int)$_SESSION['languages_id'] . "'");
			$news_meta = vam_db_fetch_array($news_meta_query, true);
?>
<title><?php echo $news_meta['headline'] . ' - ' . TITLE; ?></title>
<meta name="description" content="<?php echo META_DESCRIPTION; ?>" />
<meta name="keywords" content="<?php echo META_KEYWORDS; ?>" />
<?php

    break;

  case ($_GET['tPath']):

			$articles_cat_meta_query = vamDBquery("SELECT topics_name, topics_heading_title, topics_description
			                                            FROM " . TABLE_TOPICS_DESCRIPTION . "
			                                            WHERE topics_id='" . (int)$current_topic_id . "' and
			                                            language_id='" . (int)$_SESSION['languages_id'] . "'");
			$articles_cat_meta = vam_db_fetch_array($articles_cat_meta_query, true);

			$articles_cat_title = $articles_cat_meta['topics_name'];

		if ($articles_cat_meta['topics_description'] == '') {
			$articles_cat_desc = META_DESCRIPTION;
		} else {
			$articles_cat_desc = $articles_cat_meta['topics_heading_title'];
		}

?>
<title><?php echo $articles_cat_title . ' - ' . TITLE; ?></title>
<meta name="description" content="<?php echo $articles_cat_desc; ?>" />
<meta name="keywords" content="<?php echo META_KEYWORDS; ?>" />
<?php

    break;

  case ($_GET['articles_id']):

			$articles_meta_query = vamDBquery("SELECT articles_name, articles_head_title_tag, articles_head_desc_tag, articles_head_keywords_tag
			                                            FROM " . TABLE_ARTICLES_DESCRIPTION . "
			                                            WHERE articles_id='" . (int)$_GET['articles_id'] . "' and
			                                            language_id='" . (int)$_SESSION['languages_id'] . "'");
			$articles_meta = vam_db_fetch_array($articles_meta_query, true);

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
<title><?php echo $articles_title . ' - ' . TITLE; ?></title>
<meta name="description" content="<?php echo $articles_desc; ?>" />
<meta name="keywords" content="<?php echo $articles_key; ?>" />
<?php

    break;

  case ($_GET['authors_id']):

			$authors_meta_query = vamDBquery("SELECT authors_name
			                                            FROM " . TABLE_AUTHORS . "
			                                            WHERE authors_id='" . (int)$_GET['authors_id'] . "'");
			$authors_meta = vam_db_fetch_array($authors_meta_query, true);
?>
<title><?php echo $authors_meta['authors_name'] . ' - ' . TITLE; ?></title>
<meta name="description" content="<?php echo META_DESCRIPTION; ?>" />
<meta name="keywords" content="<?php echo META_KEYWORDS; ?>" />
<?php

    break;

default:

if (strstr($PHP_SELF, FILENAME_DEFAULT) && !isset($_GET['cat'])) {

$content_meta_default_query = vamDBquery("select cm.content_heading, cm.content_meta_title, cm.content_meta_description,  cm.content_meta_keywords from " . TABLE_CONTENT_MANAGER . " cm where cm.content_group = '5' and cm.languages_id = '" . (int)$_SESSION['languages_id'] . "'");

$content_meta_default = vam_db_fetch_array($content_meta_default_query);

		if ($content_meta_default['content_meta_title'] == '') {
			$content_default_title = $content_meta_default['content_heading'];
		} else {
			$content_default_title = $content_meta_default['content_meta_title'];
		}

} else {
			$content_default_title = TITLE;
}

   $mDesc = (isset($content_meta_default['content_meta_description']) ? ' ' . $content_meta_default['content_meta_description'] : null);
   $mKey = (isset($content_meta_default['content_meta_keywords']) ? ' ' . $content_meta_default['content_meta_keywords'] : null);

		if (isset($_GET['filter_id']) or isset($_GET['manufacturers_id'])) {		

	$mID = (isset($_GET['filter_id']) ? $_GET['filter_id'] : $_GET['manufacturers_id']);
		
		    $manufacturer_query = vamDBquery("select m.manufacturers_name, mi.manufacturers_meta_title, mi.manufacturers_meta_description, mi.manufacturers_meta_keywords from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on mi.manufacturers_id = m.manufacturers_id where m.manufacturers_id = '" . $mID . "'");
		      $manufacturer = vam_db_fetch_array($manufacturer_query,true);		

   $mName = (isset($manufacturer['manufacturers_meta_title']) ? ' - ' . $manufacturer['manufacturers_meta_title'] : ' - ' . $manufacturer['manufacturers_name']);
   $mDesc = (isset($manufacturer['manufacturers_meta_description']) ? ' ' . $manufacturer['manufacturers_meta_description'] : null);
   $mKey = (isset($manufacturer['manufacturers_meta_keywords']) ? ' ' . $manufacturer['manufacturers_meta_keywords'] : null);


		}	
		
?>
<title><?php echo $content_default_title . $mName; ?></title>
<meta name="description" content="<?php echo META_DESCRIPTION . $mDesc; ?>" />
<meta name="keywords" content="<?php echo META_KEYWORDS . $mKey; ?>" />
<?php
     }
	}
}
?>
<?php

/* -----------------------------------------------------------------------------------------
   $Id: metatags.php 1140 2005-08-10 10:16:00Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2003	 nextcommerce (metatags.php,v 1.7 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
?>
<meta name="robots" content="<?php echo META_ROBOTS; ?>" />
<meta name="language" content="<?php echo $_SESSION['language_code']; ?>" />
<meta name="author" content="<?php echo META_AUTHOR; ?>" />
<meta name="publisher" content="<?php echo META_PUBLISHER; ?>" />
<meta name="company" content="<?php echo META_COMPANY; ?>" />
<meta name="page-topic" content="<?php echo META_TOPIC; ?>" />
<meta name="reply-to" content="<?php echo META_REPLY_TO; ?>" />
<meta name="distribution" content="global" />
<meta name="revisit-after" content="<?php echo META_REVISIT_AFTER; ?>" />
<?php

if (strstr($PHP_SELF, FILENAME_PRODUCT_INFO)) {

	if ($product->isProduct()) {
?>	
<meta name="description" content="<?php echo $product->data['products_meta_description']; ?>" />
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
		if ($_GET['coID']) {
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

		} else {
?>
<meta name="description" content="<?php echo META_DESCRIPTION; ?>" />
<meta name="keywords" content="<?php echo META_KEYWORDS; ?>" />
<title><?php echo TITLE; ?></title>
<?php

		}
	}
}
?>
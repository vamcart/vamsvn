<?php
/* -----------------------------------------------------------------------------------------
   $Id: product_reviews_write.php 1101 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_reviews_write.php,v 1.51 2003/02/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (product_reviews_write.php,v 1.13 2003/08/1); www.nextcommerce.org
   (c) 2004	 xt:Commerce (product_reviews_write.php,v 1.13 2003/08/1); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
require_once (DIR_FS_INC.'vam_random_charcode.inc.php');
require_once (DIR_FS_INC.'vam_render_vvcode.inc.php');
require_once (DIR_FS_INC.'vam_row_number_format.inc.php');
require_once (DIR_FS_INC.'vam_date_short.inc.php');
require_once (DIR_FS_INC.'vam_word_count.inc.php');
require_once (DIR_FS_INC.'vam_date_long.inc.php');

// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

if ($_SESSION['customers_status']['customers_status_write_reviews'] == 0) {
             vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));
}

		$spam_flag = false;

		if ( trim( $_POST['anti-bot-q'] ) != date('Y') ) { // answer is wrong - maybe spam
			$spam_flag = true;
			if ( empty( $_POST['anti-bot-q'] ) ) { // empty answer - maybe spam
				$antispam_error_message .= 'Error: empty answer. ['.$_POST['anti-bot-q'].']<br> ';
			} else {
				$antispam_error_message .= 'Error: answer is wrong. ['.$_POST['anti-bot-q'].']<br> ';
			}
		}
		if ( ! empty( $_POST['anti-bot-e-email-url'] ) ) { // field is not empty - maybe spam
			$spam_flag = true;
			$antispam_error_message .= 'Error: field should be empty. ['.$_POST['anti-bot-e-email-url'].']<br> ';
		}
		
if (isset ($_GET['action']) && $_GET['action'] == 'process' && $spam_flag == false) {
	if (is_object($product) && $product->isProduct()) { // We got to the process but it is an illegal product, don't write

    $rating = vam_db_prepare_input($_POST['rating']);
    $review = vam_db_prepare_input($_POST['review']);

    $error = false;
    
    if ($_POST['captcha'] == '' or $_POST['captcha'] != $_SESSION['vvcode']) {
      $error = true;
	   $vamTemplate->assign('captcha_error', ENTRY_CAPTCHA_ERROR);
    }

    if (strlen($review) < REVIEW_TEXT_MIN_LENGTH) {
      $error = true;
   	$vamTemplate->assign('error', ERROR_INVALID_PRODUCT);
    }

    if (($rating < 1) || ($rating > 5)) {
      $error = true;
   	$vamTemplate->assign('error', ERROR_INVALID_PRODUCT);
    }

    if ($error == false) {
		$customer = vam_db_query("select customers_firstname, customers_lastname from ".TABLE_CUSTOMERS." where customers_id = '".(int) $_SESSION['customer_id']."'");
		$customer_values = vam_db_fetch_array($customer);
		if ($customer_values['customers_firstname'] == '') {
			$customer_values['customers_firstname'] = TEXT_GUEST;
		}		
		$date_now = date('Ymd');
		//if ($customer_values['customers_lastname'] == '')
			//$customer_values['customers_lastname'] = TEXT_GUEST;
		vam_db_query("insert into ".TABLE_REVIEWS." (products_id, customers_id, customers_name, reviews_rating, date_added) values ('".$product->data['products_id']."', '".(int) $_SESSION['customer_id']."', '".addslashes($customer_values['customers_firstname'])."', '".addslashes($_POST['rating'])."', now())");
		$insert_id = vam_db_insert_id();
		vam_db_query("insert into ".TABLE_REVIEWS_DESCRIPTION." (reviews_id, languages_id, reviews_text) values ('".$insert_id."', '".(int) $_SESSION['languages_id']."', '".addslashes($_POST['review'])."')");
		
		if ($_SESSION['temp_reviews_id'] > 0) vam_db_query("update ".TABLE_REVIEWS_IMAGES." set reviews_id =  '".$insert_id."' where reviews_id = '".(int) $_SESSION['temp_reviews_id']."'");
		
		unset($_SESSION['temp_reviews_id']);

          if ($_POST['review'] != '') {

				// assign language to template for caching
				$vamTemplate->assign('language', $_SESSION['language']);
				$vamTemplate->caching = false;

				$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
				$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

		
				$vamTemplate->assign('CUSTOMERS_NAME', addslashes($customer_values['customers_firstname']));

				$vamTemplate->assign('CUSTOMERS_FIRST_NAME', $customer_values['customers_firstname']);
				$vamTemplate->assign('CUSTOMERS_LAST_NAME', $customer_values['customers_lastname']);

				$customer_id = $_SESSION['customer_id'];
				
				if ($customer_id > 0) {

				$customer_info_query = vam_db_query("select * from " . TABLE_CUSTOMERS . " c where c.customers_id = '" . vam_db_input($customer_id) . "'");
				$customer_info = vam_db_fetch_array($customer_info_query);

				$vamTemplate->assign('CUSTOMERS_TELEPHONE', $customer_info['customers_telephone']);
				$vamTemplate->assign('CUSTOMERS_EMAIL_ADDRESS', $customer_info['customers_email_address']);

				}

				$vamTemplate->assign('PRODUCTS_NAME', $product->data['products_name']);
				$vamTemplate->assign('PRODUCTS_IMAGE', $product->data['products_image']);
				$vamTemplate->assign('PRODUCTS_LINK', vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($product->data['products_id'], $product->data['products_name'])));
				$vamTemplate->assign('REVIEWS_LINK', vam_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id='.$product->data['products_id'].'&reviews_id='.$insert_id)); 
				$vamTemplate->assign('REVIEWS_ALL_LINK', vam_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id='.$product->data['products_id'])); 
				$vamTemplate->assign('REVIEW_TEXT', addslashes($_POST['review']));

				$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/review_added_mail.html');
				$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/review_added_mail.txt');

            // create subject
           $review_added_subject = REVIEW_NEW_SUBJECT;

				if (filter_var(CONTACT_US_EMAIL_ADDRESS, FILTER_VALIDATE_EMAIL)) {

				vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, CONTACT_US_EMAIL_ADDRESS, CONTACT_US_NAME, '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $review_added_subject, $html_mail, $txt_mail);
				
				}
				
          }

   $_SESSION['error_cart_msg'] = sprintf(TEXT_REVIEW_DATE_ADDED, $product->data['products_name']);          

	vam_redirect(vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($product->data['products_id'], $product->data['products_name'])).'#reviews');
	}
 }
}

// lets retrieve all $HTTP_GET_VARS keys and values..
$get_params = vam_get_all_get_params();
$get_params_back = vam_get_all_get_params(array ('reviews_id')); // for back button
$get_params = substr($get_params, 0, -1); //remove trailing &
if (vam_not_null($get_params_back)) {
	$get_params_back = substr($get_params_back, 0, -1); //remove trailing &
} else {
	$get_params_back = $get_params;
}

$breadcrumb->add(NAVBAR_TITLE_REVIEWS_WRITE);

$customer_info_query = vam_db_query("select customers_firstname, customers_lastname from ".TABLE_CUSTOMERS." where customers_id = '".(int) $_SESSION['customer_id']."'");
$customer_info = vam_db_fetch_array($customer_info_query);

if (!$product->isProduct()) {
	$vamTemplate->assign('error', ERROR_INVALID_PRODUCT);
} else {
	$name = $customer_info['customers_firstname'];
	if ($name == '') {
		$customer_info['customers_firstname'] = TEXT_GUEST;
		$customer_info['customers_lastname'] = TEXT_GUEST;
	}
	$vamTemplate->assign('PRODUCTS_NAME', $product->data['products_name']);
	$vamTemplate->assign('AUTHOR', $customer_info['customers_firstname']);
	$vamTemplate->assign('INPUT_TEXT', vam_draw_textarea_field('review', 'soft', 60, 7, $_POST['review'], 'class="form-control" id="review"', false));
	$vamTemplate->assign('INPUT_RATING', 
	
	vam_draw_radio_field('rating', '5', '', 'id="star5" class="star-rating"').'<label for="star5" title="'.RATING_STAR_5.'">'.TEXT_STAR_5.'</label>' .
	vam_draw_radio_field('rating', '4', '', 'id="star4" class="star-rating"').'<label for="star4" title="'.RATING_STAR_4.'">'.TEXT_STAR_4.'</label>'.
	vam_draw_radio_field('rating', '3', '', 'id="star3" class="star-rating"').'<label for="star3" title="'.RATING_STAR_3.'">'.TEXT_STAR_3.'</label>'.
	vam_draw_radio_field('rating', '2', '', 'id="star2" class="star-rating"').'<label for="star2" title="'.RATING_STAR_2.'">'.TEXT_STAR_2.'</label>'.
	vam_draw_radio_field('rating', '1', '', 'id="star1" class="star-rating"').'<label for="star1" title="'.RATING_STAR_1.'">'.TEXT_STAR_1.'</label>'
	
	);
	$vamTemplate->assign('FORM_ACTION', vam_draw_form('product_reviews_write', vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE_POPUP, 'action=process&'.vam_product_link($product->data['products_id'],$product->data['products_name'])), 'post', 'enctype="multipart/form-data" cf="true" onsubmit="return checkForm();"'));
	$vamTemplate->assign('BUTTON_BACK', '<a class="button" href="javascript:history.back(1)">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');
	$vamTemplate->assign('BUTTON_SUBMIT', vam_image_submit('submit.png',  IMAGE_BUTTON_CONTINUE).vam_draw_hidden_field('get_params', $get_params));
	$vamTemplate->assign('CAPTCHA_IMG', '<img src="'.vam_href_link(FILENAME_DISPLAY_CAPTCHA).'" alt="captcha" name="captcha" />');
	$vamTemplate->assign('CAPTCHA_INPUT', vam_draw_input_field('captcha', '', 'size="6" id="captcha" class="form-control"', 'text', false));
	$vamTemplate->assign('FORM_END', '</form>');
	
}

if ($messageStack->size('uploads') > 0)
	$vamTemplate->assign('upload', $messageStack->output('uploads'));

$vamTemplate->assign('REVIEWS_ALL_LINK', vam_href_link(FILENAME_REVIEWS));
$vamTemplate->assign('REVIEWS_TOTAL', vam_db_num_rows($reviews_query));

$vamTemplate->assign('BUTTON_BACK', '<a class="btn btn-inverse" href="'.vam_href_link(FILENAME_PRODUCT_INFO, $get_params_back).'">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');
$vamTemplate->assign('BUTTON_WRITE', '<a class="btn btn-inverse btn-block" href="'.vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE_POPUP, $get_params).'">'.vam_image_button('add.png', IMAGE_BUTTON_WRITE_REVIEW).'</a>');

if ($_GET['products_id'] > 0) {

$rating_count = $product->getReviewsCount();

$one_star_query = vamDBquery("select count(*) as total from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".(int)$_GET['products_id']."' and r.reviews_rating = 1 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
$one_star = vam_db_fetch_array($one_star_query,true);
$one_star_count = $one_star['total'];

$vamTemplate->assign('PRODUCTS_RATING_ONE', $one_star_count);
$vamTemplate->assign('PRODUCTS_RATING_ONE_PERCENT', number_format(($one_star_count*100)/$rating_count));

$two_star_query = vamDBquery("select count(*) as total from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".(int)$_GET['products_id']."' and r.reviews_rating = 2 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
$two_star = vam_db_fetch_array($two_star_query,true);
$two_star_count = $two_star['total'];

$vamTemplate->assign('PRODUCTS_RATING_TWO', $two_star_count);
$vamTemplate->assign('PRODUCTS_RATING_TWO_PERCENT', number_format(($two_star_count*100)/$rating_count));

$three_star_query = vamDBquery("select count(*) as total from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".(int)$_GET['products_id']."' and r.reviews_rating = 3 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
$three_star = vam_db_fetch_array($three_star_query,true);
$three_star_count = $three_star['total'];

$vamTemplate->assign('PRODUCTS_RATING_THREE', $three_star_count);
$vamTemplate->assign('PRODUCTS_RATING_THREE_PERCENT', number_format(($three_star_count*100)/$rating_count));

$four_star_query = vamDBquery("select count(*) as total from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".(int)$_GET['products_id']."' and r.reviews_rating = 4 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
$four_star = vam_db_fetch_array($four_star_query,true);
$four_star_count = $four_star['total'];

$vamTemplate->assign('PRODUCTS_RATING_FOUR', $four_star_count);
$vamTemplate->assign('PRODUCTS_RATING_FOUR_PERCENT', number_format(($four_star_count*100)/$rating_count));

$five_star_query = vamDBquery("select count(*) as total from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd where r.products_id = '".(int)$_GET['products_id']."' and r.reviews_rating = 5 and r.reviews_id = rd.reviews_id and rd.languages_id = '".$_SESSION['languages_id']."'");
$five_star = vam_db_fetch_array($five_star_query,true);
$five_star_count = $five_star['total'];
		
$vamTemplate->assign('PRODUCTS_RATING_FIVE', $five_star_count);
$vamTemplate->assign('PRODUCTS_RATING_FIVE_PERCENT', number_format(($five_star_count*100)/$rating_count));

}

$vamTemplate->assign('language', $_SESSION['language']);

$products_price = $vamPrice->GetPrice($product->data['products_id'], $format = true, 1, $product->data['products_tax_class_id'], $product->data['products_price'], 1);
		
$vamTemplate->assign('PRODUCTS_PRICE', $products_price['formated']);
$vamTemplate->assign('PRODUCTS_PRICE_PLAIN', $products_price['plain']);
if ($product->data['products_vpe_status'] == 1 && $product->data['products_vpe_value'] != 0.0 && $products_price['plain'] > 0)
$vamTemplate->assign('PRODUCTS_VPE', $vamPrice->Format($products_price['plain'] * (1 / $product->data['products_vpe_value']), true).TXT_PER.vam_get_vpe_name($product->data['products_vpe']));
$vamTemplate->assign('PRODUCTS_ID', $product->data['products_id']);
if ($vamPrice->CheckSpecial($product->data['products_id']) > 0) {
$vamTemplate->assign('PRODUCTS_SPECIAL', 100-($vamPrice->CheckSpecial($product->data['products_id'])*100/$vamPrice->GetPprice($product->data['products_id'])));
}
$vamTemplate->assign('LABEL_ID', $product->data['label_id']);
$vamTemplate->assign('PRODUCT_LABEL', vam_get_label_name($product->data['label_id']));
$vamTemplate->assign('PRODUCTS_NAME', vam_parse_input_field_data($product->data['products_name'], array('"' => '&quot;')));
if ($_SESSION['customers_status']['customers_status_show_price'] != 0) {
// price incl tax
$tax_rate = $vamPrice->TAX[$product->data['products_tax_class_id']];				
$tax_info = $main->getTaxInfo($tax_rate);
$vamTemplate->assign('PRODUCTS_TAX_INFO', $tax_info);
$vamTemplate->assign('PRODUCTS_SHIPPING_LINK',$main->getShippingLink());
}
$vamTemplate->assign('PRODUCTS_MODEL', $product->data['products_model']);
$vamTemplate->assign('PRODUCTS_URL_INFO', vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($product->data['products_id'], $product->data['products_name'])));
$vamTemplate->assign('PRODUCTS_REVIEWS_URL', vam_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id='.$product->data['products_id']));
$vamTemplate->assign('PRODUCTS_EAN', $product->data['products_ean']);
$vamTemplate->assign('PRODUCTS_QUANTITY', $product->data['products_quantity']);
$vamTemplate->assign('PRODUCTS_LENGTH', $product->data['products_length']);
$vamTemplate->assign('PRODUCTS_WIDTH', $product->data['products_width']);
$vamTemplate->assign('PRODUCTS_HEIGHT', $product->data['products_height']);
$vamTemplate->assign('PRODUCTS_VOLUME', $product->data['products_volume']);
$vamTemplate->assign('PRODUCTS_WEIGHT', $product->data['products_weight']);
$vamTemplate->assign('PRODUCTS_STATUS', $product->data['products_status']);
$vamTemplate->assign('PRODUCTS_ORDERED', $product->data['products_ordered']);
$vamTemplate->assign('PRODUCTS_PRINT', '<img src="images/icons/buttons/print.png" alt="" />');
$vamTemplate->assign('PRODUCTS_PRINT_LINK', vam_href_link(FILENAME_PRINT_PRODUCT_INFO, 'products_id='.$product->data['products_id']));      
if ($_SESSION['customers_status']['customers_status_id'] == 0) $vamTemplate->assign('PRODUCTS_EDIT_LINK', vam_href_link_admin(FILENAME_EDIT_PRODUCTS, 'cPath=' . $cPath . '&amp;pID=' . $product->data['products_id'] . '&amp;action=new_product'));      
$vamTemplate->assign('PRODUCTS_DESCRIPTION', stripslashes($product->data['products_description']));
$vamTemplate->assign('PRODUCTS_SHORT_DESCRIPTION', stripslashes($product->data['products_short_description']));

$manufacturer_query = vamDBquery("select m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url from " . TABLE_MANUFACTURERS . " m left join " . TABLE_MANUFACTURERS_INFO . " mi on (m.manufacturers_id = mi.manufacturers_id and mi.languages_id = '" . (int)$_SESSION['languages_id'] . "'), " . TABLE_PRODUCTS . " p  where p.products_id = '" . $product->data['products_id'] . "' and p.manufacturers_id = m.manufacturers_id");
$manufacturer = vam_db_fetch_array($manufacturer_query,true);

$vamTemplate->assign('CATEGORY', $cat_data['categories_name']);
$vamTemplate->assign('CATEGORY_ID', $current_category_id);
$vamTemplate->assign('MANUFACTURER_ID',$manufacturer['manufacturers_id']);
$vamTemplate->assign('MANUFACTURER_IMAGE',$manufacturer['manufacturers_image']);
$vamTemplate->assign('MANUFACTURER_LINK',vam_href_link(FILENAME_DEFAULT, 'manufacturers_id='.$manufacturer['manufacturers_id']));
$vamTemplate->assign('MANUFACTURER',$manufacturer['manufacturers_name']);

if (AJAX_CART == 'true' && !vam_has_product_attributes($product->data['products_id'])) {
$link = '<a class="btn btn-add-to-cart btn-block" href="'.vam_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='.$product->data['products_id'], 'NONSSL').'" onclick="doBuyNow(\''.$product->data['products_id'].'\',\'1\'); return false;"><i class="fa fa-shopping-cart"></i> '.IMAGE_BUTTON_IN_CART.'</a>';
} else {
$link = '<a class="btn btn-add-to-cart btn-block" href="'.vam_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='.$product->data['products_id'], 'NONSSL').'"><i class="fa fa-shopping-cart"></i> '.IMAGE_BUTTON_IN_CART.'</a>';
}

$vamTemplate->assign('PRODUCTS_BUY_NOW',$link);

if ($product->data['products_image'] != '')
$image = DIR_WS_THUMBNAIL_IMAGES.$product->data['products_image'];

if (!file_exists($image)) $image = DIR_WS_THUMBNAIL_IMAGES.'../noimage.png';

$vamTemplate->assign('PRODUCTS_IMAGE', $image);
$vamTemplate->assign('PRODUCTS_IMAGE_DESCRIPTION', htmlentities(strip_tags($product->data['products_image_description'])));

$module_content = array();
$reviews_query = vam_db_query("select r.reviews_id, r.products_id, rd.reviews_text, rd.reviews_answer, r.reviews_rating, r.date_added, p.*, pd.*, r.customers_name, r.customers_id from ".TABLE_REVIEWS." r, ".TABLE_REVIEWS_DESCRIPTION." rd, ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where r.products_id = '".(int) $_GET['products_id']."' and p.products_status = '1' and p.products_id = r.products_id and r.reviews_id = rd.reviews_id and p.products_id = pd.products_id and pd.language_id = '".(int) $_SESSION['languages_id']."' and rd.languages_id = '".(int) $_SESSION['languages_id']."' order by r.reviews_id DESC");
if (vam_db_num_rows($reviews_query)) {

	$star_rating = '';
	while ($reviews = vam_db_fetch_array($reviews_query)) {

		$star_rating = '';
		for($i=0;$i<number_format($reviews['reviews_rating']);$i++)	{
		$star_rating .= '<span class="rating"><i class="fa fa-star"></i></span> ';
		}
				
		$module_content[] = array ( 
		
		'PRODUCT' => $product->buildDataArray($reviews),

		'REVIEW' => array(

		'PRODUCTS_LINK' => vam_href_link(FILENAME_PRODUCT_INFO, 'products_id='.$reviews['products_id']), 
		'REVIEWS_LINK' => vam_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id='.$reviews['products_id'].'&reviews_id='.$reviews['reviews_id']), 
		'REVIEWS_ALL_LINK' => vam_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id='.$reviews['products_id']), 
		'PRODUCTS_NAME' => $reviews['products_name'], 
		'AUTHOR' => $reviews['customers_name'], 
		'CUSTOMER' => $product->getReviewsCustomer((int)$reviews['products_id'],(int)$reviews['customers_id']), 
		'REVIEWS_IMAGES' => $product->getReviewsImages((int)$reviews['reviews_id'],(int)$reviews['customers_id']), 
		'ID' => $reviews['reviews_id'], 
		'URL' => vam_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id='.$reviews['products_id'].'&reviews_id='.$reviews['reviews_id']), 
		'DATE' => vam_date_short($reviews['date_added']), 
		'TEXT_COUNT' => '('.sprintf(TEXT_REVIEW_WORD_COUNT, vam_word_count($reviews['reviews_text'], ' ')).')<br />'.vam_break_string(htmlspecialchars($reviews['reviews_text']), 60, '-<br />').'..', 
		'TEXT' => $reviews['reviews_text'], 
		'ANSWER' => $reviews['reviews_answer'], 
		'RATING' => $reviews['reviews_rating'],
		'STAR_RATING' => $star_rating,
		'RATING_IMG' => vam_image('templates/'.CURRENT_TEMPLATE.'/img/stars_'.$reviews['reviews_rating'].'.png', sprintf(TEXT_OF_5_STARS, $reviews['reviews_rating']))
		
		)
		);		
		
	}
	
}

$vamTemplate->assign('module_content', $module_content);

$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/product_reviews_write.html');

require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_PRODUCT_REVIEWS_WRITE_POPUP.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_PRODUCT_REVIEWS_WRITE_POPUP.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>
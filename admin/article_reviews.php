<?php
/* --------------------------------------------------------------
   $Id: reviews.php 1129 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(reviews.php,v 1.40 2003/03/22); www.oscommerce.com 
   (c) 2003	 nextcommerce (reviews.php,v 1.9 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (reviews.php,v 1.9 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once(DIR_FS_INC . 'vam_wysiwyg_tiny.inc.php');
  
  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'update':
        $reviews_id = vam_db_prepare_input($_GET['rID']);
        $reviews_rating = vam_db_prepare_input($_POST['reviews_rating']);
        $customers_name = vam_db_prepare_input($_POST['customers_name']);
        $date_added = vam_db_prepare_input($_POST['date_added']);
        $last_modified = vam_db_prepare_input($_POST['last_modified']);
        $reviews_text = vam_db_prepare_input($_POST['reviews_text']);
        $reviews_answer = vam_db_prepare_input($_POST['reviews_answer']);

        $avatar = $_POST['customers_avatar'];

			if ($avatar == '' && $_POST['customers_avatar_name'] != '' && $avatar != $_POST['customers_avatar_name']) {
        $avatar = $_POST['customers_avatar_name'];
        }

        vam_db_query("update " . TABLE_ARTICLE_REVIEWS . " set reviews_rating = '" . vam_db_input($reviews_rating) . "',date_added = '" . vam_db_input($date_added) . "', customers_name = '" . vam_db_input($customers_name) . "', customers_avatar = '" . vam_db_input($avatar) . "', customers_avatar = '" . vam_db_input($avatar) . "', last_modified = now() where reviews_id = '" . vam_db_input($reviews_id) . "'");
        vam_db_query("update " . TABLE_ARTICLE_REVIEWS_DESCRIPTION . " set reviews_text = '" . vam_db_input($reviews_text) . "', reviews_answer = '" . vam_db_input($reviews_answer) . "' where reviews_id = '" . vam_db_input($reviews_id) . "'");

        vam_redirect(vam_href_link(FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $reviews_id));
        break;

      case 'deleteconfirm':
        $reviews_id = vam_db_prepare_input($_GET['rID']);

        vam_db_query("delete from " . TABLE_ARTICLE_REVIEWS . " where reviews_id = '" . vam_db_input($reviews_id) . "'");
        vam_db_query("delete from " . TABLE_ARTICLE_REVIEWS_DESCRIPTION . " where reviews_id = '" . vam_db_input($reviews_id) . "'");

        vam_redirect(vam_href_link(FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page']));
        break;
    }
  }
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<!--<meta name="viewport" content="initial-scale=1.0, width=device-width" />-->
<meta http-equiv="Content-Type" content="text/html; charset="<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
<script type="text/javascript"><!--

$(document).ready(function() {

$( "#date_added" ).datepicker({ dateFormat: "dd-mm-yy" }).val();

   });
   
//--></script>
<?php 
 echo vam_wysiwyg_tiny('latest_news',$data['code']); 
?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'false') { ?>
    <td width="<?php echo BOX_WIDTH; ?>" align="left" valign="top">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </td>
<?php } ?>
<!-- body_text //-->
    <td class="boxCenter" valign="top">
    
    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ($_GET['action'] == 'edit') {
    $rID = vam_db_prepare_input($_GET['rID']);

    $reviews_query = vam_db_query("select r.reviews_id, r.articles_id, r.customers_name, r.customers_avatar, r.date_added, r.last_modified, r.reviews_read, rd.reviews_text, rd.reviews_answer, r.reviews_rating from " . TABLE_ARTICLE_REVIEWS . " r, " . TABLE_ARTICLE_REVIEWS_DESCRIPTION . " rd where r.reviews_id = '" . vam_db_input($rID) . "' and r.reviews_id = rd.reviews_id");
    $reviews = vam_db_fetch_array($reviews_query);
    $products_query = vam_db_query("select articles_image from " . TABLE_ARTICLES . " where articles_id = '" . $reviews['articles_id'] . "'");
    $products = vam_db_fetch_array($products_query);

    $article_name_query = vam_db_query("select articles_name from " . TABLE_ARTICLES_DESCRIPTION . " where articles_id = '" . $reviews['articles_id'] . "' and language_id = '" . $_SESSION['languages_id'] . "'");
    $article_name = vam_db_fetch_array($article_name_query);

    $rInfo_array = vam_array_merge($reviews, $products, $article_name);
    $rInfo = new objectInfo($rInfo_array);
?>
      <tr><?php echo vam_draw_form('review', FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $_GET['rID'] . '&action=preview', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_PRODUCT; ?></b> <?php echo $rInfo->articles_name; ?><br /><b><?php echo ENTRY_FROM; ?></b> <?php echo $rInfo->customers_name; ?><br /><br /></td>
            <td class="main" align="right" valign="top"><?php if (vam_not_null($rInfo->articles_image)) echo vam_image(DIR_WS_CATALOG_IMAGES.'articles/'.$rInfo->articles_image, $rInfo->articles_name); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_FIRST_NAME; ?></b><?php echo vam_draw_input_field('customers_name', $rInfo->customers_name); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_AVATAR; ?></b> <?php echo vam_draw_input_field('customers_avatar_name', $rInfo->customers_avatar) . '&nbsp;&nbsp;' .  vam_draw_file_field('customers_avatar'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_DATE; ?></b><?php echo vam_draw_input_field('date_added', $rInfo->date_added, 'id="date_added"'); ?></td>
            <td class="main star-rating"><?php for ($i=1; $i<=5; $i++) echo vam_draw_radio_field('reviews_rating', $i, (($i == $rInfo->reviews_rating) ? true : false), '', 'class="star-rating" id="star'.$i.'"').'<label for="star'.$i.'" title="'.constant('RATING_STAR_'.$i).'">'.constant('TEXT_STAR_'.$i).'</label>'; ?>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_REVIEW; ?></b><?php echo vam_draw_textarea_field('reviews_text', 'soft', '60', '15', $rInfo->reviews_text); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_REVIEW_ANSWER; ?></b><?php echo vam_draw_textarea_field('reviews_answer', 'soft', '60', '15', $rInfo->reviews_answer); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo vam_draw_hidden_field('reviews_id', $rInfo->reviews_id) . vam_draw_hidden_field('articles_id', $rInfo->articles_id) . vam_draw_hidden_field('articles_name', $rInfo->articles_name) . vam_draw_hidden_field('products_image', $rInfo->products_image) . '<span class="button"><button type="submit" value="' . BUTTON_PREVIEW . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_PREVIEW . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $_GET['rID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?></td>
      </form></tr>
<?php
  } elseif ($_GET['action'] == 'preview') {
    if ($_POST) {
      $rInfo = new objectInfo($_POST);
      
			if ($_POST['customers_avatar'] == '' && $_POST['customers_avatar_name'] != '' && $_POST['customers_avatar'] != $_POST['customers_avatar_name']) {
        $_POST['customers_avatar'] = $_POST['customers_avatar_name'];
        }

        $customers_avatar = new upload('customers_avatar');
        $customers_avatar->set_destination(DIR_FS_CATALOG_IMAGES .'avatars/');

        if ($customers_avatar->parse() && $customers_avatar->save()) {
            
            $avatar = vam_db_input($customers_avatar->filename);
        }
        
        
        $customers_avatar = $avatar;         

    } else {
      $reviews_query = vam_db_query("select r.reviews_id, r.articles_id, r.customers_name, r.customers_avatar, r.date_added, r.last_modified, r.reviews_read, rd.reviews_text, rd.reviews_answer, r.reviews_rating from " . TABLE_ARTICLE_REVIEWS . " r, " . TABLE_ARTICLE_REVIEWS_DESCRIPTION . " rd where r.reviews_id = '" . $_GET['rID'] . "' and r.reviews_id = rd.reviews_id");
      $reviews = vam_db_fetch_array($reviews_query);
      $products_query = vam_db_query("select articles_image from " . TABLE_ARTICLES . " where articles_id = '" . $reviews['articles_id'] . "'");
      $products = vam_db_fetch_array($products_query);

      $article_name_query = vam_db_query("select articles_name from " . TABLE_ARTICLES_DESCRIPTION . " where articles_id = '" . $reviews['articles_id'] . "' and language_id = '" . $_SESSION['languages_id'] . "'");
      $article_name = vam_db_fetch_array($article_name_query);

      $rInfo_array = vam_array_merge($reviews, $products, $article_name);
      $rInfo = new objectInfo($rInfo_array);
    }
?>
      <tr><?php echo vam_draw_form('update', FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $_GET['rID'] . '&action=update', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_PRODUCT; ?></b> <?php echo $rInfo->articles_name; ?><br /><b><?php echo ENTRY_FROM; ?></b> <?php echo $rInfo->customers_name; ?><br /><br /></td>
            <td class="main" align="right" valign="top"><?php if (vam_not_null($rInfo->articles_image)) echo vam_image(DIR_WS_CATALOG_IMAGES.'articles/'.$rInfo->articles_image, $rInfo->articles_name); ?></td>
          </tr>
        </table>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" class="main"><b><?php echo ENTRY_REVIEW; ?></b><?php echo nl2br(vam_db_output($rInfo->reviews_text)); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" class="main"><b><?php echo ENTRY_REVIEW_ANSWER; ?></b><?php echo nl2br(vam_db_output($rInfo->reviews_answer)); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo ENTRY_RATING; ?></b>&nbsp;<?php echo vam_image(HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'templates/'. CURRENT_TEMPLATE .'/img/stars_' . $rInfo->reviews_rating . '.gif', sprintf(TEXT_OF_5_STARS, $rInfo->reviews_rating)); ?>&nbsp;<small>[<?php echo sprintf(TEXT_OF_5_STARS, $rInfo->reviews_rating); ?>]</small></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
    if ($_POST) {
      // Re-Post all POST'ed variables
      foreach ($_POST as $key => $value) echo '<input type="hidden" name="' . $key . '" value="' . htmlspecialchars(stripslashes($value)) . '">';

        echo vam_draw_hidden_field('customers_avatar', htmlspecialchars(stripslashes($customers_avatar)));

?>
      <tr>
        <td align="right" class="smallText"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . BUTTON_BACK . '</span></a> <span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?></td>
      </form></tr>
<?php
    } else {
      if ($_GET['origin']) {
        $back_url = $_GET['origin'];
        $back_url_params = '';
      } else {
        $back_url = FILENAME_ARTICLE_REVIEWS;
        $back_url_params = 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id;
      }
?>
      <tr>
        <td align="right"><?php echo '<a class="button" href="' . vam_href_link($back_url, $back_url_params, 'NONSSL') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . BUTTON_BACK . '</span></a>'; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_RATING; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_DATE_ADDED; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $reviews_query_raw = "select reviews_id, articles_id, date_added, last_modified, reviews_rating from " . TABLE_ARTICLE_REVIEWS . " order by reviews_id DESC";
    $reviews_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $reviews_query_raw, $reviews_query_numrows);
    $reviews_query = vam_db_query($reviews_query_raw);
    while ($reviews = vam_db_fetch_array($reviews_query)) {
      if ( ((!$_GET['rID']) || ($_GET['rID'] == $reviews['reviews_id'])) && (!$rInfo) ) {
        $reviews_text_query = vam_db_query("select r.*, rd.*, length(rd.reviews_text) as reviews_text_size from " . TABLE_ARTICLE_REVIEWS . " r, " . TABLE_ARTICLE_REVIEWS_DESCRIPTION . " rd where r.reviews_id = '" . $reviews['reviews_id'] . "' and r.reviews_id = rd.reviews_id");
        $reviews_text = vam_db_fetch_array($reviews_text_query);

        $products_image_query = vam_db_query("select articles_image from " . TABLE_ARTICLES . " where articles_id = '" . $reviews['articles_id'] . "'");
        $products_image = vam_db_fetch_array($products_image_query);

        $article_name_query = vam_db_query("select articles_name from " . TABLE_ARTICLES_DESCRIPTION . " where articles_id = '" . $reviews['articles_id'] . "' and language_id = '" . $_SESSION['languages_id'] . "'");
        $article_name = vam_db_fetch_array($article_name_query);

        $reviews_average_query = vam_db_query("select (avg(reviews_rating) / 5 * 100) as average_rating from " . TABLE_ARTICLE_REVIEWS . " where articles_id = '" . $reviews['articles_id'] . "'");
        $reviews_average = vam_db_fetch_array($reviews_average_query);

        $rInfo_array = vam_array_merge($reviews_text, $article_name, $products_image, $reviews_average);
        $rInfo = new objectInfo($rInfo_array);
      }

      if ( (is_object($rInfo)) && ($reviews['reviews_id'] == $rInfo->reviews_id) ) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=preview') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $reviews['reviews_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . vam_href_link(FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $reviews['reviews_id'] . '&action=preview') . '">' . vam_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . vam_get_articles_name($reviews['articles_id']); ?></td>
                <td class="dataTableContent" align="right"><?php echo vam_image(HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'templates/'. CURRENT_TEMPLATE .'/img/stars_' . $reviews['reviews_rating'] . '.gif'); ?></td>
                <td class="dataTableContent" align="right"><?php echo vam_date_short($reviews['date_added']); ?></td>
                <td class="dataTableContent" align="right"><?php if ( (is_object($rInfo)) && ($reviews['reviews_id'] == $rInfo->reviews_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . vam_href_link(FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $reviews['reviews_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $reviews_split->display_count($reviews_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></td>
                    <td class="smallText" align="right"><?php echo $reviews_split->display_links($reviews_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>

                  <tr>
                    <td class="smallText">&nbsp;</td>
                    <td align="right" class="smallText"><?php echo '&nbsp;<a class="button" href="' . vam_href_link(FILENAME_ARTICLE_REVIEWS_ADD, 'action=add_review') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . TEXT_ADD_REVIEW . '</span></a>'; ?>&nbsp;</td>
                  </tr>																																		  
                  
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($_GET['action']) {
      case 'delete':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_REVIEW . '</b>');

        $contents = array('form' => vam_draw_form('reviews', FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=deleteconfirm'));
        $contents[] = array('text' => TEXT_INFO_DELETE_REVIEW_INTRO);
        $contents[] = array('text' => '<br /><b>' . $rInfo->articles_name . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<br /><span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;

      default:
      if (is_object($rInfo)) {
        $heading[] = array('text' => '<b>' . $rInfo->articles_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button"href="' . vam_href_link(FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_ARTICLE_REVIEWS, 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_DATE_ADDED . ' ' . $rInfo->date_added);
        if (vam_not_null($rInfo->last_modified)) $contents[] = array('text' => TEXT_INFO_LAST_MODIFIED . ' ' . vam_date_short($rInfo->last_modified));
        if (vam_not_null($rInfo->customers_avatar)) $contents[] = array('text' => '<br />' . vam_image(DIR_WS_CATALOG_IMAGES.'avatars/'.$rInfo->customers_avatar, $rInfo->customers_name));
        $contents[] = array('text' => '<br />' . TEXT_INFO_REVIEW_AUTHOR . ' ' . $rInfo->customers_name);
        $contents[] = array('text' => TEXT_INFO_REVIEW_RATING . ' ' . vam_image(HTTP_CATALOG_SERVER . DIR_WS_CATALOG . 'templates/'. CURRENT_TEMPLATE .'/img/stars_' . $rInfo->reviews_rating . '.gif'));
        $contents[] = array('text' => TEXT_INFO_REVIEW_READ . ' ' . $rInfo->reviews_read);
        $contents[] = array('text' => '<br />' . TEXT_INFO_REVIEW_SIZE . ' ' . $rInfo->reviews_text_size . ' bytes');
        $contents[] = array('text' => '<br />' . TEXT_INFO_PRODUCTS_AVERAGE_RATING . ' ' . number_format($rInfo->average_rating, 2) . '%');
      }
        break;
    }

    if ( (vam_not_null($heading)) && (vam_not_null($contents)) ) {
      echo '            <td width="25%" valign="top">' . "\n";

      $box = new box;
      echo $box->infoBox($heading, $contents);

      echo '            </td>' . "\n";
    }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
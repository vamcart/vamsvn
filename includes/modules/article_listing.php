<?php
/* --------------------------------------------------------------
   $Id: article_listing.php 1249 2007-03-09 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   (c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/

$listing_split = new splitPageResults($listing_sql, MAX_ARTICLES_PER_PAGE);
  if (($listing_split->number_of_rows > 0) && ((ARTICLE_PREV_NEXT_BAR_LOCATION == 'top') || (ARTICLE_PREV_NEXT_BAR_LOCATION == 'both'))) {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="smallText"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo xtc_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
  }
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php
  if ($listing_split->number_of_rows > 0) {
    $articles_listing_query = xtc_db_query($listing_split->sql_query);
?>
      <tr>
        <td class="main"><?php echo TEXT_ARTICLES; ?></td>
      </tr>
      <tr>
        <td><?php echo xtc_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
<?php
    while ($articles_listing = xtc_db_fetch_array($articles_listing_query)) {
?>
          <tr>
            <td valign="top" class="main" width="75%">
<?php
  echo '<a href="' . xtc_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $articles_listing['articles_id']) . '"><b>' . $articles_listing['articles_name'] . '</b></a> ';
  if (DISPLAY_AUTHOR_ARTICLE_LISTING == 'true' && xtc_not_null($articles_listing['authors_name'])) {
   echo TEXT_BY . ' ' . '<a href="' . xtc_href_link(FILENAME_ARTICLES, 'authors_id=' . $articles_listing['authors_id']) . '"> ' . $articles_listing['authors_name'] . '</a>';
  }
?>
            </td>
<?php
      if (DISPLAY_TOPIC_ARTICLE_LISTING == 'true' && xtc_not_null($articles_listing['topics_name'])) {
?>
            <td valign="top" class="main" width="25%" nowrap><?php echo TEXT_TOPIC . '&nbsp;<a href="' . xtc_href_link(FILENAME_ARTICLES, 'tPath=' . $articles_listing['topics_id']) . '">' . $articles_listing['topics_name'] . '</a>'; ?></td>
<?php
      }
?>
          </tr>
<?php
      if (DISPLAY_ABSTRACT_ARTICLE_LISTING == 'true') {
?>
          <tr>
            <td class="main" style="padding-left:15px"><?php echo clean_html_comments(substr($articles_listing['articles_head_desc_tag'],0, MAX_ARTICLE_ABSTRACT_LENGTH)) . ((strlen($articles_listing['articles_head_desc_tag']) >= MAX_ARTICLE_ABSTRACT_LENGTH) ? '...' : ''); ?></td>
          </tr>
<?php
      }
      if (DISPLAY_DATE_ADDED_ARTICLE_LISTING == 'true') {
?>
          <tr>
            <td class="smalltext" style="padding-left:15px"><?php echo TEXT_DATE_ADDED . ' ' . xtc_date_long($articles_listing['articles_date_added']); ?></td>
          </tr>
<?php
      }
      if (DISPLAY_ABSTRACT_ARTICLE_LISTING == 'true' || DISPLAY_DATE_ADDED_ARTICLE_LISTING) {
?>
          <tr>
            <td><?php echo xtc_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
<?php
 }
    } // End of listing loop
  } else {
?>
          <tr>
            <td class="main"><?php if ($topic_depth == 'articles') {
                                     echo TEXT_NO_ARTICLES;
                                   } else if (isset($_GET['authors_id'])) {
                                    echo  TEXT_NO_ARTICLES2;
                                   } ?></td>
          </tr>
          <tr>
            <td><?php echo xtc_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
<?php
  }
?>
          <tr>
            <td><?php echo xtc_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  if (($listing_split->number_of_rows > 0) && ((ARTICLE_PREV_NEXT_BAR_LOCATION == 'bottom') || (ARTICLE_PREV_NEXT_BAR_LOCATION == 'both'))) {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="smallText"><?php echo $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_ARTICLES); ?></td>
            <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $listing_split->display_links(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array('page', 'info', 'x', 'y'))); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>

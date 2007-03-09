
<?php
/* 
  $Id: articles_xsell.php, v1.0 2003/12/04 12:00:00 ra Exp $

osCommerce, Open Source E-Commerce Solutions 
  http://www.oscommerce.com

Copyright (c) 2003 osCommerce 

Released under the GNU General Public License 
*/ 

if ($HTTP_GET_VARS['articles_id']) {
$xsell_query = tep_db_query("select distinct a.products_id, a.products_image, ad.products_name from " . TABLE_ARTICLES_XSELL . " ax, " . TABLE_PRODUCTS . " a, " . TABLE_PRODUCTS_DESCRIPTION . " ad where ax.articles_id = '" . $HTTP_GET_VARS['articles_id'] . "' and ax.xsell_id = a.products_id and a.products_id = ad.products_id and ad.language_id = '" . $languages_id . "' and a.products_status = '1' order by ax.sort_order asc limit " . MAX_DISPLAY_ARTICLES_XSELL);
$num_products_xsell = tep_db_num_rows($xsell_query); 
if ($num_products_xsell >= MIN_DISPLAY_ARTICLES_XSELL) {
?> 
<!-- xsell_articles //-->
<?php
  $info_box_contents = array();
  $info_box_contents[] = array('text' => TEXT_XSELL_ARTICLES);
  new infoBoxHeading($info_box_contents, false, false);

      $row = 0;
      $col = 0;
      $info_box_contents = array();
      while ($xsell = tep_db_fetch_array($xsell_query)) {
        $xsell['products_name'] = tep_get_products_name($xsell['products_id']);
        $info_box_contents[$row][$col] = array('align' => 'center',
                                               'params' => 'class="smallText" width="33%" valign="top"',
                                               'text' => '<a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $xsell['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $xsell['products_image'], $xsell['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $xsell['products_id']) . '">' . $xsell['products_name'] . '</a>');
        $col ++;
        if ($col > 2) {
          $col = 0;
          $row ++;
        }
      }
      new contentBox($info_box_contents);
      $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => tep_draw_separator('pixel_trans.gif', '100%', '1')
                              );
  new infoboxFooter($info_box_contents, true, true);

?>
<!-- xsell_articles_eof //-->
<?php
    }
  }
?>
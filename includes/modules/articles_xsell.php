<?php
/* --------------------------------------------------------------
   $Id: articles_xsell.php 1249 2007-03-09 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   (c) 2002-2003 osCommerce(categories.php,v 1.140 2003/03/24); www.oscommerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/

if ($_GET['articles_id']) {
$xsell_query = xtc_db_query("select distinct a.products_id, a.products_image, ad.products_name from " . TABLE_ARTICLES_XSELL . " ax, " . TABLE_PRODUCTS . " a, " . TABLE_PRODUCTS_DESCRIPTION . " ad where ax.articles_id = '" . $_GET['articles_id'] . "' and ax.xsell_id = a.products_id and a.products_id = ad.products_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and a.products_status = '1' order by ax.sort_order asc limit " . MAX_DISPLAY_ARTICLES_XSELL);
$num_products_xsell = xtc_db_num_rows($xsell_query); 
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
      while ($xsell = xtc_db_fetch_array($xsell_query)) {
        $xsell['products_name'] = xtc_get_products_name($xsell['products_id']);
        $info_box_contents[$row][$col] = array('align' => 'center',
                                               'params' => 'class="smallText" width="33%" valign="top"',
                                               'text' => '<a href="' . xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $xsell['products_id']) . '">' . xtc_image(DIR_WS_IMAGES . $xsell['products_image'], $xsell['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br><a href="' . xtc_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $xsell['products_id']) . '">' . $xsell['products_name'] . '</a>');
        $col ++;
        if ($col > 2) {
          $col = 0;
          $row ++;
        }
      }
      new contentBox($info_box_contents);
      $info_box_contents = array();
  $info_box_contents[] = array('align' => 'left',
                                'text'  => xtc_draw_separator('pixel_trans.gif', '100%', '1')
                              );
  new infoboxFooter($info_box_contents, true, true);

?>
<!-- xsell_articles_eof //-->
<?php
    }
  }
?>
<?php
/*
  $Id: products_tabs.php, v 1.0 20090909 kymation Exp $
  Modified from the original Products Tabs Addon file of the same name
  $Loc: catalog/admin/includes/modules/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2009 osCommerce

  Released under the GNU General Public License
*/


  $products_tabs = array();
  for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
    $products_tabs[$i] = vam_get_products_tabs ( (int) $_GET['pID'], $languages[$i]['id']);
  }
  
?>
<!-- Products Tabs BOF -->
    <table cellpadding="0" cellspacing="0" width="100%" style="BORDER:none;background:none;">
      <tr align="left">
        <td>
          <div id="tabContainer">
            <div id="tabMenu">
              <ul class="menu">
                <li><a href="spec" class="active"><span><?php echo TEXT_TAB_SPECIFICATIONS; ?></span></a></li>
                <li><a href="tab_1"><span><?php echo TEXT_TAB_1; ?></span></a></li>
                <li><a href="tab_2"><span><?php echo TEXT_TAB_2; ?></span></a></li>
                <li><a href="tab_3"><span><?php echo TEXT_TAB_3; ?></span></a></li>
                <li><a href="tab_4"><span><?php echo TEXT_TAB_4; ?></span></a></li>
                <li><a href="tab_5"><span><?php echo TEXT_TAB_5; ?></span></a></li>
                <li><a href="tab_6"><span><?php echo TEXT_TAB_6; ?></span></a></li>
              </ul>
            </div> 
            <div id="tabContent">
              <div id="spec" class="content active">
                <table border="0" cellspacing="0" cellpadding="1">
                  <tr align="left">
                    <td>
<?php
      require (DIR_WS_MODULES . FILENAME_PRODUCTS_SPECIFICATIONS_INPUT);
?>
                    </td>
                  </tr>
                </table>
              </div>
              <div id="tab_1" class="content">
                <table border="0" cellspacing="0" cellpadding="1">
                  <tr align="left">
                    <td valign="top" class="main"><?php echo TEXT_TITLE_1; ?>&nbsp;</td>
                    <td><table border="0" cellspacing="0" cellpadding="0">
<?php
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
                      <tr>
                        <td valign="top"><?php echo vam_image (DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;</td>
                        <td class="main"><?php echo vam_draw_textarea_field ('products_tab_1[' . $languages[$i]['id'] . ']', 'soft', '120', '15', (isset($products_tab_1[$languages[$i]['id']]) ? $products_tab_1[$languages[$i]['id']] : $products_tabs[$languages[$i]['id']]['1']) ); ?></td>
                      </tr>
                      <tr>
                        <td><?php echo vam_draw_separator ('pixel_trans.gif', '100%', '10'); ?></td>
                      </tr>
<?php
      }
?>
                    </table></td>
                  </tr>
                </table>
              </div>
              <div id="tab_2" class="content">
                <table border="0" cellspacing="0" cellpadding="1">
                  <tr align="left">
                    <td valign="top" class="main"><?php echo TEXT_TITLE_2; ?>&nbsp;</td>
                    <td><table border="0" cellspacing="0" cellpadding="0">
<?php
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
                      <tr>
                        <td valign="top"><?php echo vam_image (DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']); ?>&nbsp;</td>
                        <td valign="top" class="main" width="0"><?php echo vam_draw_textarea_field ('products_tab_2[' . $languages[$i]['id'] . ']', 'soft', '120', '15', (isset($products_tab_2[$languages[$i]['id']]) ? $products_tab_2[$languages[$i]['id']] : $products_tabs[$languages[$i]['id']]['2']) ); ?></td>
                      </tr>
                      <tr>
                        <td><?php echo vam_draw_separator ('pixel_trans.gif', '100%', '10'); ?></td>
                      </tr>
<?php
      }
?>
                    </table></td>
                  </tr>
                </table>
              </div>
              <div id="tab_3" class="content">
                <table border="0" cellspacing="0" cellpadding="1">
                  <tr align="left">
                    <td valign="top" class="main"><?php echo TEXT_TITLE_3; ?>&nbsp;</td>
                    <td><table border="0" cellspacing="0" cellpadding="0">
<?php
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
                      <tr>
                        <td valign="top"><?php echo vam_image (DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']); ?></td>
                        <td valign="top" class="main" width="0"><?php echo vam_draw_textarea_field ('products_tab_3[' . $languages[$i]['id'] . ']', 'soft', '120', '15', (isset($products_tab_3[$languages[$i]['id']]) ? $products_tab_3[$languages[$i]['id']] : $products_tabs[$languages[$i]['id']]['3']) ); ?></td>
                      </tr>
                      <tr>
                        <td><?php echo vam_draw_separator ('pixel_trans.gif', '100%', '10'); ?></td>
                      </tr>
<?php
      }
?>
                    </table>
                  </tr>
                </table>
              </div>
              <div id="tab_4" class="content">
                <table border="0" cellspacing="0" cellpadding="1">
                  <tr align="left">
                    <td valign="top" class="main"><?php echo TEXT_TITLE_4; ?>&nbsp;</td>
                    <td><table border="0" cellspacing="0" cellpadding="0">
<?php
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
                      <tr>
                        <td valign="top"><?php echo vam_image (DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']); ?></td>
                        <td valign="top" class="main" width="0"><?php echo vam_draw_textarea_field ('products_tab_4[' . $languages[$i]['id'] . ']', 'soft', '120', '15', (isset($products_tab_4[$languages[$i]['id']]) ? $products_tab_4[$languages[$i]['id']] : $products_tabs[$languages[$i]['id']]['4']) ); ?></td>
                      </tr>
                      <tr>
                        <td><?php echo vam_draw_separator ('pixel_trans.gif', '100%', '10'); ?></td>
                      </tr>
<?php
      }
?>
                    </table></td>
                  </tr>
                </table>
              </div>
              <div id="tab_5" class="content">
                <table border="0" cellspacing="0" cellpadding="1">
                  <tr align="left">
                    <td valign="top" class="main"><?php echo TEXT_TITLE_5; ?>&nbsp;</td>
                    <td><table border="0" cellspacing="0" cellpadding="0">
<?php
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
                      <tr>
                        <td valign="top"><?php echo vam_image (DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']); ?></td>
                        <td class="main" width="0"><?php echo vam_draw_textarea_field ('products_tab_5[' . $languages[$i]['id'] . ']', 'soft', '120', '15', (isset ($products_tab_5[$languages[$i]['id']]) ? $products_tab_5[$languages[$i]['id']] : $products_tabs[$languages[$i]['id']]['5']) ); ?></td>
                      </tr>
                      <tr>
                        <td><?php echo vam_draw_separator ('pixel_trans.gif', '100%', '10'); ?></td>
                      </tr>
<?php
      }
?>
                    </table></td>
                  </tr>
                </table>
              </div>
              <div id="tab_6" class="content">
                <table border="0" cellspacing="0" cellpadding="1">
                  <tr align="left">
                    <td valign="top" class="main"><?php  echo TEXT_TITLE_6; ?>&nbsp;</td>
                    <td><table border="0" cellspacing="0" cellpadding="0">
<?php
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
                      <tr>
                        <td valign="top"><?php echo vam_image (DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']); ?></td>
                        <td class="main"><?php echo vam_draw_textarea_field ('products_tab_6[' . $languages[$i]['id'] . ']', 'soft', '120', '15', (isset($products_tab_6[$languages[$i]['id']]) ? $products_tab_6[$languages[$i]['id']] : $products_tabs[$languages[$i]['id']]['6']) ); ?></td>
                      </tr>
                      <tr>
                        <td><?php echo vam_draw_separator ('pixel_trans.gif', '100%', '10'); ?></td>
                      </tr>
<?php
      }
?>
                    </table></td>
                  </tr>
                </table>
              </div>
            </td>
          </tr></table>
<!-- Products Tabs EOF -->

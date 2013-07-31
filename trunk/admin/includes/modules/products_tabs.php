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
            </td>
          </tr></table>
<!-- Products Tabs EOF -->

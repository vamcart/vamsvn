<?php
/*
  $Id: customers.php 814 2006-08-27 15:28:23Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2005 osCommerce

  Released under the GNU General Public License
*/

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

?>
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
				  <tr> 
				    <td class="pageHeading">
				    
<table width="100%" border="0" cellpadding="0" cellspacing="0">  <tr>
    <td class="contentBoxHeading1"><img src="images/heading1.gif" border="0" alt="" /></td>
    <td height="14" class="contentBoxHeading1" width="100%"><?php echo TABLE_HEADING_NEWS; ?></td>
  </tr>
  <tr>
    <td class="line" width="100%" colspan="2"><img src="images/pixel_trans.gif" border="0" alt="" width="1" height="2" /></td>
  </tr>
  <tr>
    <td width="100%" colspan="2"><img src="images/pixel_trans.gif" border="0" alt="" width="1" height="1" /></td>
  </tr>
</table>				    
				    </td>
				  </tr>

              <tr>
                <td class="dataTableContentRss" valign="top">
                
                
<?php

CarpConf('iorder','link,date,desc');

        CarpConf('cborder','link,desc');
        CarpConf('caorder','image');
        CarpConf('bcb','<div style="font-size:10; font-weight: bold; background:#f1f1f1; border: 1px solid #CCCCCC; padding:4px;">');
        CarpConf('acb','</div>');
        CarpConf('bca','<center>');
        CarpConf('aca','</center>');
CarpConf('maxitems',5);

        
        // before each item
        CarpConf('bi','<div style="font-size:10; font-family: verdana; background:#F6F6F6; border-bottom: 1px dashed #cccccc; padding:5px;">');
        
        // after each item
        CarpConf('ai','</div>');
CarpShow('http://oscommerce.su/modules/news/backendt.php?topicid=2');

?>
                
                
                
                </td>
              </tr>

                </table></td>
              </tr>
<?php
/* -----------------------------------------------------------------------------------------
   $Id: news.php 950 2007-02-08 12:51:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 osCommerce (news.php,v 1.25 2003/08/19); oscommerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

defined('_VALID_VAM') or die('Direct Access to this location is not allowed.');

?>
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
				  <tr> 
				    <td colspan="3" class="pageHeading" width="100%">

    <h1 class="contentBoxHeading"><?php echo TABLE_HEADING_NEWS; ?></h1>
				    
				    </td>
				  </tr>

              <tr>
                <td class="dataTableContentRss" valign="top">
                
                
<iframe src="http://vamshop.ru/rss2.php?feed=news&limit=20" frameborder="0" width="100%"></iframe>

                
                </td>
              </tr>

                </table></td>
              </tr>
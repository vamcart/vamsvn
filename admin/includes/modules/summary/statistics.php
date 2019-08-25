<?php
/* -----------------------------------------------------------------------------------------
   $Id: statistics.php 950 2007-12-15 12:51:57 VaM $   

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
<table border="0" width="100%" cellspacing="0" cellpadding="2">

				  <tr> 
				    <td colspan="2" class="pageHeading" width="100%">

    <h1 class="contentBoxHeading"><?php echo '<a href="' . vam_href_link(FILENAME_STATS_SALES_REPORT2, '', 'NONSSL') . '">' . BOX_SALES_REPORT . '</a>'; ?></h1>
				    
				    </td>
				  </tr>
				  
              <tr>
                <td class="dataTableContentRss" valign="top" width="50%">
                <div id="chart1"></div>
                </td>
              </tr>
              <tr>
                <td class="dataTableContentRss" valign="top" width="50%">
                <div id="chart2"></div>
                </td>
              </tr>
</table>
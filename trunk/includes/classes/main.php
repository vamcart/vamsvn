<?php
/* -----------------------------------------------------------------------------------------
   $Id: main.php 1286 2007-02-06 20:23:03 VaM $ 

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(Coding Standards); www.oscommerce.com 
   (c) 2004 xt:Commerce (main.php); www.oscommerce.com 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
 
 class main {
 	
 	function main () {
 		$this->SHIPPING = array();
 		
 		
 		
 		
 				// prefetch shipping status
		$status_query=vamDBquery("SELECT
                                     shipping_status_name,
                                     shipping_status_image,shipping_status_id
                                     FROM ".TABLE_SHIPPING_STATUS."
                                     where language_id = '".(int)$_SESSION['languages_id']."'");
         
         while ($status_data=vam_db_fetch_array($status_query,true)) {
         	$this->SHIPPING[$status_data['shipping_status_id']]=array('name'=>$status_data['shipping_status_name'],'image'=>$status_data['shipping_status_image']);
         }
         
         
 	}
 	
    function getShippingStatusName($id) {
           if (SHOW_SHIPPING == 'true') {
        return $this->SHIPPING[$id]['name'];
    }
         return;
     }
    function getShippingStatusImage($id) {
           if (SHOW_SHIPPING == 'true') {
        if ($this->SHIPPING[$id]['image'])
        return 'admin/images/icons/'.$this->SHIPPING[$id]['image'];
        }
        return;
    }
 	
 		function getShippingLink() {
        if (SHOW_SHIPPING == 'true') {
		return ' '.SHIPPING_EXCL.'<a href="'. vam_href_link(FILENAME_POPUP_CONTENT, 'coID='.SHIPPING_INFOS) .'" target="_blank" onclick="window.open(\'' . vam_href_link(FILENAME_POPUP_CONTENT, 'coID='.SHIPPING_INFOS) . '\', \'popUp\', \'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=395,height=320\'); return false;">'.SHIPPING_COSTS.'</a>';
	}
        return;
        }
   
	function getTaxNotice() {

		// no prices
		if ($_SESSION['customers_status']['customers_status_show_price'] == 0)
			return;

		if ($_SESSION['customers_status']['customers_status_show_price_tax'] != 0) {
			return TAX_INFO_INCL_GLOBAL;
		}
		// excl tax + tax at checkout
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
			return TAX_INFO_ADD_GLOBAL;
		}
		// excl tax
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) {
			return TAX_INFO_EXCL_GLOBAL;
		}
		
		return;
	}
	
	function getTaxInfo($tax_rate) {
		
		// price incl tax
				if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] != 0) {
					$tax_info = sprintf(TAX_INFO_INCL, $tax_rate.' %');
				}
				// excl tax + tax at checkout
				if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
					$tax_info = sprintf(TAX_INFO_ADD, $tax_rate.' %');
				}
				// excl tax
				if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) {
					$tax_info = sprintf(TAX_INFO_EXCL, $tax_rate.' %');
				}
		return $tax_info;
	}
	
	function getShippingNotice() {
		if (SHOW_SHIPPING == 'true') {
			return ' '.SHIPPING_EXCL.'<a href="'.vam_href_link(FILENAME_CONTENT, 'coID='.SHIPPING_INFOS).'">'.SHIPPING_COSTS.'</a>';
		}
		return;
	}
	
	function getContentLink($coID,$text) {
		return '<a href="'. vam_href_link(FILENAME_POPUP_CONTENT, 'coID='.$coID) .'" target="_blank" onclick="window.open(\'' . vam_href_link(FILENAME_POPUP_CONTENT, 'coID='.$coID) . '\', \'popUp\', \'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=1,width=395,height=320\'); return false;">'.$text.'</a>';
	}
 	
 }
 
 
?>

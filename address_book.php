<?php
/* -----------------------------------------------------------------------------------------
   $Id: address_book.php 867 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(address_book.php,v 1.57 2003/05/29); www.oscommerce.com 
   (c) 2003	 nextcommerce (address_book.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (address_book.php,v 1.14 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'vam_address_label.inc.php');
require_once (DIR_FS_INC.'vam_get_country_name.inc.php');
require_once (DIR_FS_INC.'vam_count_customer_address_book_entries.inc.php');

if (!isset ($_SESSION['customer_id']))
	vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));

$breadcrumb->add(NAVBAR_TITLE_1_ADDRESS_BOOK, vam_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ADDRESS_BOOK, vam_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));

require (DIR_WS_INCLUDES.'header.php');

if ($messageStack->size('addressbook') > 0)
	$vamTemplate->assign('error', $messageStack->output('addressbook'));

$vamTemplate->assign('ADDRESS_DEFAULT', vam_address_label($_SESSION['customer_id'], $_SESSION['customer_default_address_id'], true, ' ', '<br />'));

$addresses_data = array ();
$addresses_query = vam_db_query("select address_book_id, entry_firstname as firstname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from ".TABLE_ADDRESS_BOOK." where customers_id = '".(int) $_SESSION['customer_id']."' order by firstname, lastname");
while ($addresses = vam_db_fetch_array($addresses_query)) {
	$format_id = vam_get_address_format_id($addresses['country_id']);
	if ($addresses['address_book_id'] == $_SESSION['customer_default_address_id']) {
		$primary = 1;
	} else {
		$primary = 0;
	}
	$addresses_data[] = array ('NAME' => $addresses['firstname'].' '.$addresses['lastname'], 'BUTTON_EDIT' => '<a class="button" href="'.vam_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'edit='.$addresses['address_book_id'], 'SSL').'">'.vam_image_button('edit.png', SMALL_IMAGE_BUTTON_EDIT).'</a>', 'BUTTON_DELETE' => '<a class="button" href="'.vam_href_link(FILENAME_ADDRESS_BOOK_PROCESS, 'delete='.$addresses['address_book_id'], 'SSL').'">'.vam_image_button('delete.png', SMALL_IMAGE_BUTTON_DELETE).'</a>', 'ADDRESS' => vam_address_format($format_id, $addresses, true, ' ', '<br />'), 'PRIMARY' => $primary);

}
$vamTemplate->assign('addresses_data', $addresses_data);

$vamTemplate->assign('BUTTON_BACK', '<a class="button" href="'.vam_href_link(FILENAME_ACCOUNT, '', 'SSL').'">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');

if (vam_count_customer_address_book_entries() < MAX_ADDRESS_BOOK_ENTRIES) {

	$vamTemplate->assign('BUTTON_NEW', '<a class="button" href="'.vam_href_link(FILENAME_ADDRESS_BOOK_PROCESS, '', 'SSL').'">'.vam_image_button('add.png', IMAGE_BUTTON_ADD_ADDRESS).'</a>');
}

$vamTemplate->assign('ADDRESS_COUNT', sprintf(TEXT_MAXIMUM_ENTRIES, MAX_ADDRESS_BOOK_ENTRIES));

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/address_book.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_ADDRESS_BOOK.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_ADDRESS_BOOK.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>
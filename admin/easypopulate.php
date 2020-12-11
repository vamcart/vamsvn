<?php
/* --------------------------------------------------------------
   $Id: easypopulate.php 899 2011-02-07 17:36:57 oleg_vamsoft $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2011 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2003	 osCommerce (easypopulate.php,v 1.4 2003/08/14); oscommerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

// Current EP Version
define ('EP_CURRENT_VERSION', '2.77a');

require('includes/application_top.php');
require('easypopulate_functions.php');

require_once (DIR_FS_INC.'vam_get_products_mo_images.inc.php');
	
$system = vam_get_system_information();

//
//*******************************
//*******************************
// C O N F I G U R A T I O N
// V A R I A B L E S
//*******************************
//*******************************


//////////////////////////////////////////////////////
// *** Show all these settings on EP main page ***
// use this to debug your settings. Copy the settings 
// to your post on the forum if you need help.
//////////////////////////////////////////////////////
define ('EP_SHOW_EP_SETTINGS', true); // default is: false


// **** Temp directory **** 
/* ////////////////////////////////////////////////////////////////////////
//
// *IF* you changed your directory structure from stock and do not 
// have /catalog/temp/, then you'll need to change this accordingly.
//
// *IF* your shop is in the default /catalog/ installation directory
// on your website, skip this Temp Directory settings info.
//
///////////////////////////////////////////////////////////////////////////

   CREATING THE TEMP DIRECTORY

   If your shop is in the root of your public site ( /home/myaccount/public_html/index.php ), 
   you should create a folder called temp from the root of your web space so that the
   full path looks like this: /home/myaccount/public_html/temp/
   
   Then you must set the permissions to 777. If you don't know how, ask your host.


   THE DIR_FS_DOCUMENT_ROOT SETTING

   DIR_FS_DOCUMENT_ROOT is set in your /catalog/admin/includes/configure.php
   You should look at the setting DIR_FS_DOCUMENT_ROOT setting.
   if it looks like this (recommended, but doesn't always work): 

       define ('DIR_FS_DOCUMENT_ROOT', $DOCUMENT_ROOT);

   then leave it alone. If it looks like this: 

       define ('DIR_FS_DOCUMENT_ROOT', '/home/myaccount/public_html'); 

   ask your host if the "/home/myaccount/public_html" portion points to your public
   web space and is correct. Whether you add the trailing slash on the
   path or not doesn't matter to this contrib, as long as you make the 
   right choice on the following setting. The best thing is to leave it
   alone as long as your host can confirm it is correct and everything else
   is working fine. Having said that, NO trailing slash is technically correct.



   THE DIR_WS_CATALOG & DIR_FS_CATALOG SETTINGS
   
   DIR_WS_CATALOG & DIR_FS_CATALOG are set in your /catalog/admin/includes/configure.php
   They may look like this if your shop is in the root of your web space. 
   If you have something different, don't just change it to this. 
   There is probably a good reason. I'm providing this as a reference 
   to you-all. The DIR_FS_DOCUMENT_ROOT, the DIR_WS_CATALOG, and the 
   DIR_FS_CATALOG settings all combine to create the temp location below.
   
       define('DIR_WS_CATALOG', '/');
       define('DIR_FS_CATALOG', DIR_FS_DOCUMENT_ROOT . DIR_WS_CATALOG);



   THIS EP_TEMP_DIRECTORY SETTING

   Next, the following setting should set so that the DIR_FS_CATALOG setting
   plus this following setting makes a correct full path to your temporary 
   location, like this: /home/myaccount/public_html/temp/

   if /home/myaccount/public_html/temp/ is the correct full path to your temp
   location, then: 

       define ('EP_TEMP_DIRECTORY', DIR_FS_CATALOG . 'temp/');

   is the correct setting here.  Wow, I really hope this stops the forum traffic about this !!

////////////////////////////////////////////////////////////////////////// */
// **** Temp directory **** 
define ('EP_TEMP_DIRECTORY', DIR_FS_CATALOG . 'export/'); 


//**** File Splitting Configuration ****
// we attempt to set the timeout limit longer for this script to avoid having to split the files
// NOTE:  If your server is running in safe mode, this setting cannot override the timeout set in php.ini
// uncomment this if you are not on a safe mode server and you are getting timeouts
// set_time_limit(330);

// if you are splitting files, this will set the maximum number of records to put in each file.
// if you set your php.ini to a long time, you can make this number bigger
define ('EP_SPLIT_MAX_RECORDS', 300);  // default, seems to work for most people.  Reduce if you hit timeouts
//define ('EP_SPLIT_MAX_RECORDS', 4); // for testing


//**** Image Defaulting ****
// set them to your own default "We don't have any picture" gif
//define ('EP_DEFAULT_IMAGE_MANUFACTURER', 'no_image_manufacturer.gif'); 
//define ('EP_DEFAULT_IMAGE_PRODUCT', 'no_image_product.gif'); 
//define ('EP_DEFAULT_IMAGE_CATEGORY', 'no_image_category.gif'); 

// or let them get set to nothing
define ('EP_DEFAULT_IMAGE_MANUFACTURER', ''); 
define ('EP_DEFAULT_IMAGE_PRODUCT', ''); 
define ('EP_DEFAULT_IMAGE_CATEGORY', ''); 


//**** Status Field Setting ****
// Set the v_status field to "Inactive" if you want the status=0 in the system
define ('EP_TEXT_ACTIVE', 'Active'); 
define ('EP_TEXT_INACTIVE', 'Inactive'); 

// Set the v_status field to "Delete" if you want to remove the item from the system
define ('EP_DELETE_IT', 'Delete');


// If zero_qty_inactive is true, then items with zero qty will automatically be inactive in the store.
define ('EP_INACTIVATE_ZERO_QUANTITIES', false);  // default is false


//**** Size of products_model in products table ****
// set this to the size of your model number field in the db.  We check to make 
// sure all models are no longer than this value. this prevents the database from 
// getting fubared.  Just making this number bigger won't help your database!  They must match!
// If you increase the Model Number size, you must increase the size of the field
// in the database. Use a SQL tool like phpMyAdmin (see your host) and change the
// "products_model" field of the "products" table in your osCommerce Database.
define ('EP_MODEL_NUMBER_SIZE', 100); // default is 12


//**** Price includes tax? ****
// Set the EP_PRICE_WITH_TAX to
// false if you want the price that is exported to be the same value as stored in the database (no tax added).
// true if you want the tax to be added to the export price and subtracted from the import price.
define ('EP_PRICE_WITH_TAX', false);  // default is false


//**** Price calculation precision ****
// NOTE: when entering into the database all prices will be converted to 4 decimal places.
define ('EP_PRECISION', 2);  // default is 2


// **** Quote -> Escape character conversion ****
// If you have extensive html in your descriptions and it's getting mangled on upload, turn this off
// set to true = replace quotes with escape characters
// set to false = no quote replacement
define ('EP_REPLACE_QUOTES', false);  // default is false

// **** Field Separator ****
// change this if you can't use the default of tabs
// Tab is the default, comma and semicolon are commonly supported by various progs
// Remember, if your descriptions contain this character, you will confuse EP!
// if EP_EXCEL_SAFE_OUTPUT if false (below) you must make EP_PRESERVE_TABS_CR_LF false also.
//$ep_separator = "\t"; // tab is default
//$ep_separator = ',';  // comma
$ep_separator = ';';  // semi-colon
//$ep_separator = '~';  // tilde
//$ep_separator = '*';  // splat

// *** Excel safe output ***
// this setting will supersede the previous $ep_separator setting and create a file
// that excel will import without spanning cells from embedded commas or tabs in your products.
// if EP_EXCEL_SAFE_OUTPUT if false (below) you must make EP_PRESERVE_TABS_CR_LF false also.
define ('EP_EXCEL_SAFE_OUTPUT', true); // default is: true

// if EP_EXCEL_SAFE_OUTPUT if true (above) there is an alternative line parsing routine
//  provided by Maynard that will use a manual php approach.  There is a bug in some
// PHP versions that may require you to use this routine.  This should also provide proper
// parsing when quotes are used within a string. I suspect this should also resolve an issue
// recently reported in which characters with a german "Umlaute" like ÄäÖöÜü at the Beginning 
// of some text, they will disappear when importing some csv-file, reported by TurboTB.
define ('EP_EXCEL_SAFE_OUTPUT_ALT_PARCE', true); // default is: false


// *** Preserve Tabs, Carriage returns and Line feeds ***
// this setting will preserve the special chars that can cause problems in 
// a text based output. When used with EP_EXCEL_SAFE_OUTPUT, it will safely
// preserve these elements in the export and import.
define ('EP_PRESERVE_TABS_CR_LF', false); // default is: false


// **** Max Category Levels ****
// change this if you need more or fewer categories.
// set this to the maximum depth of your categories.
define ('EP_MAX_CATEGORIES', 7); // default is 7


// VJ product attributes begin
// **** Product Attributes ****
// change this to false, if do not want to download product attributes
define ('EP_PRODUCTS_WITH_ATTRIBUTES', false);  // default is true

// change this to true, if you use QTYpro and want to set attributes stock with EP.
define ('EP_PRODUCTS_ATTRIBUTES_STOCK', false); // default is false

// change this if you want to download only selected product options (attributes).
// If you have a lot of product options, and your output file exceeds 256 columns, 
// which is the max. limit MS Excel is able to handle, then load-up this array with
// attributes to skip when generating the export.
$attribute_options_select = '';
// $attribute_options_select = array('Size', 'Model'); // uncomment and fill with product options name you wish to download // comment this line, if you wish to download all product options
// VJ product attributes end


// ******************************************************************
// BEGIN Define Custom Fields for your products database
// ******************************************************************
// the following line is always left as is.
$custom_fields = array();
//
// The following setup will allow you to define any additional 
// field into the "products" and "products_description" tables
// in your shop. If you have  installed a custom contribution
// that adds fields to these tables you may simply and easily add
// them to the EasyPopulate system.
//
// ********************
// ** products table **
// Lets say you have added a field to your "products" table called
// "products_upc". The header name in your import file will be
// called "v_products_upc".  Then below you will change the line
// that looks like this (without the comment double-slash at the beginning):
// $custom_fields[TABLE_PRODUCTS] = array(); // this line is used if you have no custom fields to import/export
//
// TO:
// $custom_fields[TABLE_PRODUCTS] = array( 'products_upc' => 'UPC' );
//
// If you have multiple fields this is what it would look like:
// $custom_fields[TABLE_PRODUCTS] = array( 'products_upc' => 'UPC', 'products_restock_quantity' => 'Restock' );
//
// ********************************
// ** products_description table **
// Lets say you have added a field to your "products_description" table called
// "products_short_description". The header name in your import file will be
// called "v_products_short_description_1" for English, "v_products_short_description_2" for German,
// "v_products_short_description_3" for Spanish. Other languages will vary. Be sure to use the 
// langugage ID of the custom language you installed if it is other then the original
// 3 installed languages of osCommerce. If you are unsure what language ID you need to
// use, do a complete export and examine the file headers EasyPopulate produces.
//
// Then below you will change the line that looks like this (without the comment double-slash at the beginning):
// $custom_fields[TABLE_PRODUCTS_DESCRIPTION] = array(); // this line is used if you have no custom fields to import/export
//
// TO:
// $custom_fields[TABLE_PRODUCTS_DESCRIPTION] = array( 'products_short_description' => 'short' );
//
// If you have multiple fields this is what it would look like:
// $custom_fields[TABLE_PRODUCTS_DESCRIPTION] = array( 'products_short_description' => 'short', 'products_viewed' => 'Viewed' );
//
// the array format is: array( 'table_field_name' => 'Familiar Name' )
// the array key ('table_field_name') is always the exact name of the 
// field in the table. The array value ('Familiar Name') is any text
// name that will be used in the custom EP export download checkbox.
//
// I believe this will only work for text/varchar and numeric field
// types.  If your custom field is a date/time or any other type, you
// may need to incorporate custom code to correctly import your data.
//

$custom_fields[TABLE_PRODUCTS] = array('products_quantity_min' => TEXT_EASYPOPULATE_LABEL_QUANTITY_MIN,'products_quantity_max' => TEXT_EASYPOPULATE_LABEL_QUANTITY_MAX,'products_length' => TEXT_EASYPOPULATE_LABEL_LENGTH,'products_width' => TEXT_EASYPOPULATE_LABEL_WIDTH,'products_height' => TEXT_EASYPOPULATE_LABEL_HEIGHT,'products_volume' => TEXT_EASYPOPULATE_LABEL_VOLUME,'products_sort' => TEXT_EASYPOPULATE_LABEL_SORT,'products_page_url' => TEXT_EASYPOPULATE_LABEL_PAGE_URL,'products_discount_allowed' => TEXT_EASYPOPULATE_LABEL_DISCOUNT_ALLOWED,'products_startpage' => TEXT_EASYPOPULATE_LABEL_STARTPAGE,'products_startpage_sort' => TEXT_EASYPOPULATE_LABEL_STARTPAGE_SORT,'products_to_xml' => TEXT_EASYPOPULATE_LABEL_XML); // this line is used if you have no custom fields to import/export
$custom_fields[TABLE_PRODUCTS_DESCRIPTION] = array('products_short_description' => TEXT_EASYPOPULATE_LABEL_SHORT_DESCRIPTION,'products_keywords' => TEXT_EASYPOPULATE_LABEL_KEYWORDS); // this line is used if you have no custom fields to import/export

//
// FINAL NOTE: this currently only works with the "products" & "products_description" table.
// If it works well and I don't get a plethora of problems reported,
// I may expand it to more tables. Feel free to make requests, but
// as always, only as me free time allows.
//
// ******************************************************************
// END Define Custom Fields for your products database
// ******************************************************************



// ****************************************
// Froogle configuration variables
// Here are some links regarding Bulk uploads
// http://www.google.com/base/attributes.html
// http://www.google.com/base/help/custom-attributes.html
// ****************************************

// **** Froogle product info page path ****
// We can't use the tep functions to create the link, because the links will point to the 
// admin, since that's where we're at. So put the entire path to your product_info.php page here
define ('EP_FROOGLE_PRODUCT_INFO_PATH', HTTP_CATALOG_SERVER . DIR_WS_CATALOG . "product_info.php");

// **** Froogle product image path ****
// Set this to the path to your images directory
define ('EP_FROOGLE_IMAGE_PATH', HTTP_CATALOG_SERVER . DIR_WS_CATALOG_IMAGES);

// **** Froogle - search engine friendly setting
// if your store has SEARCH ENGINE FRIENDLY URLS set, then turn this to true
// I did it this way because I'm having trouble with the code seeing the constants
// that are defined in other places.
define ('EP_FROOGLE_SEF_URLS', false);  // default is false

// **** Froogle Currency Setting
define ('EP_FROOGLE_CURRENCY', 'USD');  // default is 'USD'

// ****************************************
// End: Froogle configuration variables
// 


// ***********************************
// *** Other Contributions Support ***
// ***********************************

// More Pics 6 v1.3
define ('EP_MORE_PICS_6_SUPPORT', false);  // default is false

// Header Tags Controller Support v2.0
define ('EP_HTC_SUPPORT', true);  // default is false

// Separate Pricing Per Customer (SPPC) v4.1.x
define ('EP_SPPC_SUPPORT', false);  // default is false

// X-Sell 2.6 Support
define ('EP_XSELL_SUPPORT', true);  // default is false

// Additional Images v2.1.1
define ('EP_ADDITIONAL_IMAGES', false);  // default is false
define ('EP_ADDITIONAL_IMAGES_MAX', 6);  // default is 6, maximum number of columns

// Unlimited Images
define ('EP_UNLIMITED_IMAGES', false);  // default is false

// Multi Vendor System (MVS) 1.2 support
define ('EP_MVS_SUPPORT', false);  // default is false

// Extra Fields Contribution 
define ('EP_EXTRA_FIELDS_SUPPORT', true);  // default is false

// Categories 
define ('EP_CATEGORIES_SUPPORT', true);  // default is false

// Tags 
define ('EP_TAGS_SUPPORT', true);  // default is false

// UltraPics 2.05 LightBox Contrib (***FUNCTIONAL***)
define ('EP_ULTRPICS_SUPPORT', false);  // default is false

// PDF File Upload and Display v2.01 (***FUNCTIONAL***)
define ('EP_PDF_UPLOAD_SUPPORT', false);  // default is false

// Enable Quick Backup Button for oscommerce backup.php
define ('EP_QUICK_BACKUP', true);  // default is true

//*******************************
//*******************************
// E N D
// C O N F I G U R A T I O N
// V A R I A B L E S
//*******************************
//*******************************





//*******************************
//*******************************
// S T A R T
// INITIALIZATION
//*******************************
//*******************************

// modify tableBlock for use here.
  class epbox extends tableBlock {
    // constructor
    function epbox($contents, $direct_ouput = true) {
      $this->table_class = 'exportTable';
      $this->table_width = '';
      if (!empty($contents) && $direct_ouput == true) {
        echo $this->tableBlock($contents);
      }
    }
    // only member function
    function output($contents) {
      return $this->tableBlock($contents);
    }
  }

if (!empty($_SESSION['languages_id']) && !empty($_SESSION['language'])) {
  define ('EP_DEFAULT_LANGUAGE_ID', $_SESSION['languages_id']);
  define ('EP_DEFAULT_LANGUAGE_NAME', $_SESSION['language']);
} else {
  //elari check default language_id from configuration table DEFAULT_LANGUAGE
  $epdlanguage_query = vam_db_query("select languages_id, name from " . TABLE_LANGUAGES . " where code = '" . DEFAULT_LANGUAGE . "'");
  if (vam_db_num_rows($epdlanguage_query) > 0) {
    $epdlanguage = vam_db_fetch_array($epdlanguage_query);
    define ('EP_DEFAULT_LANGUAGE_ID', $epdlanguage['languages_id']);
    define ('EP_DEFAULT_LANGUAGE_NAME', $epdlanguage['name']);
  } else {
    echo EASY_ERROR_1;
  }
}

$languages = vam_get_languages();

// VJ product attributes begin
$attribute_options_array = array();

if (EP_PRODUCTS_WITH_ATTRIBUTES == true) {
    if (is_array($attribute_options_select) && (count($attribute_options_select) > 0)) {
        foreach ($attribute_options_select as $value) {
            $attribute_options_query = "select distinct products_options_id from " . TABLE_PRODUCTS_OPTIONS . " where products_options_name = '" . $value . "'";

            $attribute_options_values = vam_db_query($attribute_options_query);

            if ($attribute_options = vam_db_fetch_array($attribute_options_values)){
                $attribute_options_array[] = array('products_options_id' => $attribute_options['products_options_id']);
            }
        }
    } else {
        $attribute_options_query = "select distinct products_options_id from " . TABLE_PRODUCTS_OPTIONS . " order by products_options_id";

        $attribute_options_values = vam_db_query($attribute_options_query);

        while ($attribute_options = vam_db_fetch_array($attribute_options_values)){
            $attribute_options_array[] = array('products_options_id' => $attribute_options['products_options_id']);
        }
    }
}
// VJ product attributes end


// these are the fields that will be defaulted to the current values in 
// the database if they are not found in the incoming file
$default_these = array();
foreach ($languages as $key => $lang){
  $default_these[] = 'v_products_name_' . $lang['id'];
  $default_these[] = 'v_products_description_' . $lang['id'];
  $default_these[] = 'v_products_url_' . $lang['id'];
  foreach ($custom_fields[TABLE_PRODUCTS_DESCRIPTION] as $key => $name) { 
    $default_these[] = 'v_' . $key . '_' . $lang['id'];
  }
  if (EP_HTC_SUPPORT == true) {
    $default_these[] = 'v_products_meta_title_' . $lang['id'];
    $default_these[] = 'v_products_meta_description_' . $lang['id'];
    $default_these[] = 'v_products_meta_keywords_' . $lang['id'];
  }
}
$default_these[] = 'v_products_image';
foreach ($custom_fields[TABLE_PRODUCTS] as $key => $name) { 
  $default_these[] = 'v_' . $key;
}
if (EP_MVS_SUPPORT == true) { 
  $default_these[] = 'v_vendor';
}
if (EP_ADDITIONAL_IMAGES == true) { 
  $default_these[] = 'v_products_image_description';
  for ($i=2;$i<=EP_ADDITIONAL_IMAGES_MAX+1;$i++) {
    $default_these[] = 'v_products_image_' . $i;
    $default_these[] = 'v_products_image_description_' . $i;
  }
}

if (EP_UNLIMITED_IMAGES)
{ 
 $default_these[] = 'v_products_image_array';
}

if (EP_MORE_PICS_6_SUPPORT == true) { 
  $default_these[] = 'v_products_subimage1';
  $default_these[] = 'v_products_subimage2';
  $default_these[] = 'v_products_subimage3';
  $default_these[] = 'v_products_subimage4';
  $default_these[] = 'v_products_subimage5';
  $default_these[] = 'v_products_subimage6';
}
if (EP_ULTRPICS_SUPPORT == true) { 
  $default_these[] = 'v_products_image_med';
  $default_these[] = 'v_products_image_lrg';
  $default_these[] = 'v_products_image_sm_1';
  $default_these[] = 'v_products_image_xl_1';
  $default_these[] = 'v_products_image_sm_2';
  $default_these[] = 'v_products_image_xl_2';
  $default_these[] = 'v_products_image_sm_3';
  $default_these[] = 'v_products_image_xl_3';
  $default_these[] = 'v_products_image_sm_4';
  $default_these[] = 'v_products_image_xl_4';
  $default_these[] = 'v_products_image_sm_5';
  $default_these[] = 'v_products_image_xl_5';
  $default_these[] = 'v_products_image_sm_6';
  $default_these[] = 'v_products_image_xl_6';
}

if (EP_PDF_UPLOAD_SUPPORT == true) { 
  $default_these[] = 'v_products_pdfupload';
  $default_these[] = 'v_products_fileupload';
}

$default_these[] = 'v_categories_id';
$default_these[] = 'v_products_price';
$default_these[] = 'v_products_quantity';
$default_these[] = 'v_products_weight';
$default_these[] = 'v_status_current';
$default_these[] = 'v_date_avail';
$default_these[] = 'v_date_added';
$default_these[] = 'v_tax_class_title';
$default_these[] = 'v_manufacturers_name';
$default_these[] = 'v_manufacturers_id';

$filelayout = '';
$filelayout_count = '';
$filelayout_sql = '';
$fileheaders = '';



if ( !empty($_GET['dltype']) ) {
    // if dltype is set, then create the filelayout.  Otherwise it gets read from the uploaded file
    list($filelayout, $filelayout_count, $filelayout_sql, $fileheaders) = ep_create_filelayout($_GET['dltype'], $attribute_options_array, $languages, $custom_fields); // get the right filelayout for this download
}

//*******************************
//*******************************
// E N D
// INITIALIZATION
//*******************************
//*******************************




//*******************************
//*******************************
// DOWNLOAD FILE (EXPORT)
//*******************************
//*******************************
if ( !empty($_GET['download']) && ($_GET['download'] == 'stream' or $_GET['download'] == 'activestream' or $_GET['download'] == 'tempfile') ){
    $filestring = ""; // this holds the csv file we want to download
    $result = vam_db_query($filelayout_sql);
    $row =  vam_db_fetch_array($result);


    // $EXPORT_TIME=time();  // start export time when export is started.
    $EXPORT_TIME = strftime('%Y%b%d-%H%I');
    if ($dltype=="froogle"){
        $EXPORT_TIME = "FroogleEP" . $EXPORT_TIME;
    } else {
        $EXPORT_TIME = "EP" . $EXPORT_TIME;
    }

    // Here we need to allow for the mapping of internal field names to external field names
    // default to all headers named like the internal ones
    // the field mapping array only needs to cover those fields that need to have their name changed
    if ( count($fileheaders) != 0 ){
        $filelayout_header = $fileheaders; // if they gave us fileheaders for the dl, then use them
    } else {
        $filelayout_header = $filelayout; // if no mapping was spec'd use the internal field names for header names
    }
    //We prepare the table heading with layout values
    foreach( $filelayout_header as $key => $value ){
        $filestring .= $key . $ep_separator;
    }
    // now lop off the trailing tab
    $filestring = substr($filestring, 0, strlen($filestring)-1);

    // set the type
    if ( $dltype == 'froogle' ){
        $endofrow = "\n";
    } else {
        // default to normal end of row
        $endofrow = $ep_separator . 'EOREOR' . "\n";
    }
    $filestring .= $endofrow;

    if ($_GET['download'] == 'activestream'){
//		header('Content-Transfer-Encoding: none');
        if (EP_EXCEL_SAFE_OUTPUT == true) {
		header("Content-type: text/x-csv");
//		header('Content-type: text/x-csv; charset="utf-8"');
//		header("Content-type: application/vnd.ms-excel");
//		header('Content-type: application/vnd.ms-excel; charset="utf-8"');
		} else {
		header("Content-type: text/plain");
		}
      header("Content-disposition: attachment; filename=$EXPORT_TIME" . ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"));
      // Changed if using SSL, helps prevent program delay/timeout (add to backup.php also)
      if ($request_type== 'NONSSL'){
        header("Pragma: no-cache");
      } else {
        header("Pragma: ");
      }
      header("Expires: 0");
      echo $filestring;
    }

    $num_of_langs = count($languages);
    while ($row){


        // if the filelayout says we need a products_name, get it
        // build the long full froogle image path
        $row['v_products_fullpath_image'] = EP_FROOGLE_IMAGE_PATH . $row['v_products_image'];
        // Other froogle defaults go here for now
        $row['v_froogle_quantitylevel']     = $row['v_products_quantity'];
        $row['v_froogle_manufacturer_id']   = '';
        $row['v_froogle_exp_date']          = date('Y-m-d', strtotime('+30 days'));
        $row['v_froogle_product_type']      = $row['v_categories_id'];
        $row['v_froogle_product_id']        = $row['v_products_model'];
        $row['v_froogle_currency']          = EP_FROOGLE_CURRENCY;
        
        // names and descriptions require that we loop thru all languages that are turned on in the store
        foreach ($languages as $key => $lang){
            $lid = $lang['id'];

if ($row['v_products_id']) {

            // for each language, get the description and set the vals
            $sql2 = "SELECT *
                FROM ".TABLE_PRODUCTS_DESCRIPTION."
                WHERE
                    products_id = " . $row['v_products_id'] . " AND
                    language_id = '" . $lid . "'
                ";
            $result2 = vam_db_query($sql2);
            $row2 =  vam_db_fetch_array($result2);
}
            // I'm only doing this for the first language, since right now froogle is US only.. Fix later!
            // adding url for froogle, but it should be available no matter what
            if (EP_FROOGLE_SEF_URLS == true){
                // if only one language
                if ($num_of_langs == 1){
                    $row['v_froogle_products_url_' . $lid] = EP_FROOGLE_PRODUCT_INFO_PATH . '/products_id/' . $row['v_products_id'];
                } else {
                    $row['v_froogle_products_url_' . $lid] = EP_FROOGLE_PRODUCT_INFO_PATH . '/products_id/' . $row['v_products_id'] . '/language/' . $lid;
                }
            } else {
                if ($num_of_langs == 1){
                    $row['v_froogle_products_url_' . $lid] = EP_FROOGLE_PRODUCT_INFO_PATH . '?products_id=' . $row['v_products_id'];
                } else {
                    $row['v_froogle_products_url_' . $lid] = EP_FROOGLE_PRODUCT_INFO_PATH . '?products_id=' . $row['v_products_id'] . '&language=' . $lid;
                }
            }

            $row['v_products_name_' . $lid]          = $row2['products_name'];
            $row['v_products_description_' . $lid]   = $row2['products_description'];
            $row['v_products_url_' . $lid]           = $row2['products_url'];
            foreach ($custom_fields[TABLE_PRODUCTS_DESCRIPTION] as $key => $name) { 
              $row['v_' . $key . '_' . $lid]           = $row2[$key];
            }
            // froogle advanced format needs the quotes around the name and desc
            $row['v_froogle_products_name_' . $lid] = '"' . strip_tags(str_replace('"','""',$row2['products_name'])) . '"';
            $row['v_froogle_products_description_' . $lid] = '"' . strip_tags(str_replace('"','""',$row2['products_description'])) . '"';

            // support for Linda's Header Controller 2.0 here
            if(isset($filelayout['v_products_meta_title_' . $lid])){
                $row['v_products_meta_title_' . $lid]     = $row2['products_meta_title'];
                $row['v_products_meta_description_' . $lid]      = $row2['products_meta_description'];
                $row['v_products_meta_keywords_' . $lid]  = $row2['products_meta_keywords'];
            }
            // end support for Header Controller 2.0
		
        }

            if (EP_ADDITIONAL_IMAGES == true) {
              $i = 2;
              $ai_result = vam_db_query("SELECT * FROM ".TABLE_ADDITIONAL_IMAGES."  WHERE products_id = " . $row['v_products_id'] . " limit " . EP_ADDITIONAL_IMAGES_MAX);
              while ($ai_row = vam_db_fetch_array($ai_result)) {
                $row['v_products_image_'.$i] = (!empty($ai_row['popup_images'])?$ai_row['popup_images']:$ai_row['thumb_images']);
                $row['v_products_image_description_'.$i] = $ai_row['images_description'];
                $i++;
              }
            }
		
		
            if (EP_MVS_SUPPORT == true) { 
              $vend_result = vam_db_query("select vendors_name from ".TABLE_VENDORS." where vendors_id = " . $row['v_vendor_id'] . "");
              if ($vend_row = vam_db_fetch_array($vend_result)) {
                $row['v_vendor'] = $vend_row['vendors_name'];
              }
            }

		// for the categories, we need to keep looping until we find the root category
		// start with v_categories_id
		// Get the category description
		// set the appropriate variable name
		// if parent_id is not null, then follow it up.
		// we'll populate an aray first, then decide where it goes in the
		$thecategory_id = $row['v_categories_id'];
		$fullcategory = ''; // this will have the entire category stack for froogle
		for( $categorylevel=1; $categorylevel<=EP_MAX_CATEGORIES; $categorylevel++){
			if ($thecategory_id){

				$sql3 = "SELECT parent_id, 
								categories_image
						 FROM ".TABLE_CATEGORIES."
						 WHERE    
								categories_id = " . $thecategory_id . '';
				$result3 = vam_db_query($sql3);
				if ($row3 = vam_db_fetch_array($result3)) {
					$temprow['v_categories_image_' . $categorylevel] = $row3['categories_image'];
				}

				foreach ($languages as $key => $lang){
					$sql2 = "SELECT categories_name
							 FROM ".TABLE_CATEGORIES_DESCRIPTION."
							 WHERE    
									categories_id = " . $thecategory_id . " AND
									language_id = " . $lang['id'];
					$result2 = vam_db_query($sql2);
					if ($row2 =  vam_db_fetch_array($result2)) {
						$temprow['v_categories_name_' . $categorylevel . '_' . $lang['id']] = $row2['categories_name'];
					}
					if ($lang['id'] == '1') {
						//$fullcategory .= " > " . $row2['categories_name'];
						$fullcategory = $row2['categories_name'] . " > " . $fullcategory;
					}

				}

				// now get the parent ID if there was one
				$theparent_id = $row3['parent_id'];
				if ($theparent_id != ''){
					// there was a parent ID, lets set thecategoryid to get the next level
					$thecategory_id = $theparent_id;
				} else {
					// we have found the top level category for this item,
					$thecategory_id = false;
				}
 
			} else {
				$temprow['v_categories_image_' . $categorylevel] = '';
				foreach ($languages as $key => $lang){
					$temprow['v_categories_name_' . $categorylevel . '_' . $lang['id']] = '';
				}
			}
		}

		// now trim off the last ">" from the category stack
		$row['v_category_fullpath'] = substr($fullcategory,0,strlen($fullcategory)-3);

		// temprow has the old style low to high level categories.
		$newlevel = 1;
		// let's turn them into high to low level categories
		for( $categorylevel=EP_MAX_CATEGORIES; $categorylevel>0; $categorylevel--){
			$found = false;
			if ($temprow['v_categories_image_' . $categorylevel] != ''){
				$row['v_categories_image_' . $newlevel] = $temprow['v_categories_image_' . $categorylevel];
				$found = true;
			}
			foreach ($languages as $key => $lang){
				if ($temprow['v_categories_name_' . $categorylevel . '_' . $lang['id']] != ''){
					$row['v_categories_name_' . $newlevel . '_' . $lang['id']] = $temprow['v_categories_name_' . $categorylevel . '_' . $lang['id']];
					$found = true;
				}
			}
			if ($found == true) {
				$newlevel++;
			}
		}


        // if the filelayout says we need a manufacturers name, get it
        if (isset($filelayout['v_manufacturers_name'])){
            if ($row['v_manufacturers_id'] != ''){
                $sql2 = "SELECT manufacturers_name
                    FROM ".TABLE_MANUFACTURERS."
                    WHERE
                    manufacturers_id = " . $row['v_manufacturers_id']
                    ;
                $result2 = vam_db_query($sql2);
                $row2 =  vam_db_fetch_array($result2);
                $row['v_manufacturers_name'] = $row2['manufacturers_name'];
            }
        }


        // If you have other modules that need to be available, put them here

        // VJ product attribs begin
        if (isset($filelayout['v_attribute_options_id_1'])){

            $attribute_options_count = 1;
      foreach ($attribute_options_array as $attribute_options) {
                $row['v_attribute_options_id_' . $attribute_options_count]     = $attribute_options['products_options_id'];

                for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
                    $lid = $languages[$i]['id'];

                    $attribute_options_languages_query = "select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options['products_options_id'] . "' and language_id = '" . (int)$lid . "'";

                    $attribute_options_languages_values = vam_db_query($attribute_options_languages_query);

                    $attribute_options_languages = vam_db_fetch_array($attribute_options_languages_values);

                    $row['v_attribute_options_name_' . $attribute_options_count . '_' . $lid] = $attribute_options_languages['products_options_name'];
                }

                $attribute_values_query = "select products_options_values_id from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options['products_options_id'] . "' order by products_options_values_id";

                $attribute_values_values = vam_db_query($attribute_values_query);

                $attribute_values_count = 1;
                while ($attribute_values = vam_db_fetch_array($attribute_values_values)) {
                    $row['v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count]     = $attribute_values['products_options_values_id'];

                    $attribute_values_price_query = "select options_values_price, price_prefix, attributes_model, attributes_stock, options_values_weight, weight_prefix, sortorder from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$row['v_products_id'] . "' and options_id = '" . (int)$attribute_options['products_options_id'] . "' and options_values_id = '" . (int)$attribute_values['products_options_values_id'] . "'";

                    $attribute_values_price_values = vam_db_query($attribute_values_price_query);

                    $attribute_values_price = vam_db_fetch_array($attribute_values_price_values);

                    $row['v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count]     = $attribute_values_price['price_prefix'] . $attribute_values_price['options_values_price'];

                    $row['v_attribute_values_model_' . $attribute_options_count . '_' . $attribute_values_count]     = $attribute_values_price['attributes_model'];

                    $row['v_attribute_values_stock_' . $attribute_options_count . '_' . $attribute_values_count]     = $attribute_values_price['attributes_stock'];

                    $row['v_attribute_values_weight_' . $attribute_options_count . '_' . $attribute_values_count]     = $attribute_values_price['weight_prefix'] . $attribute_values_price['options_values_weight'];

                    $row['v_attribute_values_sort_' . $attribute_options_count . '_' . $attribute_values_count]     = $attribute_values_price['sortorder'];

                    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
                        $lid = $languages[$i]['id'];

                        $attribute_values_languages_query = "select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$attribute_values['products_options_values_id'] . "' and language_id = '" . (int)$lid . "'";

                        $attribute_values_languages_values = vam_db_query($attribute_values_languages_query);

                        $attribute_values_languages = vam_db_fetch_array($attribute_values_languages_values);

                        $row['v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $lid] = $attribute_values_languages['products_options_values_name'];
                    }

                    $attribute_values_count++;
                }

                $attribute_options_count++;
            }
        }
        // VJ product attribs end

        // this is for the cross sell contribution
        if (isset($filelayout['v_cross_sell'])){
            $px_models = '';
			$sql2 = "SELECT
                    px.products_id,
                    px.xsell_id,
					p.products_model
                FROM
                    ".TABLE_PRODUCTS_XSELL." px, 
					".TABLE_PRODUCTS." p
                WHERE
                px.xsell_id = p.products_id and 
                px.products_id = " . $row['v_products_id'] . "
                ";
            $cross_sell_result = vam_db_query($sql2);
			while( $cross_sell_row = vam_db_fetch_array($cross_sell_result) ){
				$px_models .= $cross_sell_row['products_model'] . ',';
			}
			if (strlen($px_models) > 0) { $px_models = substr($px_models, 0, -1); }
			$row['v_cross_sell'] = $px_models;
		}

        // this is for the separate price per customer module
        if (isset($filelayout['v_customer_price_1'])){
            $sql2 = "SELECT
                    customers_group_price,
                    customers_group_id
                FROM
                    ".TABLE_PRODUCTS_GROUPS."
                WHERE
                products_id = " . $row['v_products_id'] . "
                ORDER BY
                customers_group_id"
                ;
            $result2 = vam_db_query($sql2);
            $ll = 1;
            $row2 =  vam_db_fetch_array($result2);
	    
            // do pricing specials
            if (isset($filelayout['v_customer_specials_price_1'])){
              $sppc_specials = array();
              $specials_result = vam_db_query("SELECT specials_new_products_price, status, customers_group_id FROM ".TABLE_SPECIALS." WHERE products_id = " . $row['v_products_id'] . " and customers_group_id <> 0 and expires_date < CURRENT_TIMESTAMP ORDER BY specials_id DESC");
              while( $specials_result_row = vam_db_fetch_array($specials_result) ){
                $sppc_specials[$specials_result_row['customers_group_id']] = $specials_result_row['specials_new_products_price'];
              }
            }
			
            while( $row2 ){
                $row['v_customer_group_id_' . $ll]     = $row2['customers_group_id'];
                $row['v_customer_price_' . $ll]     = $row2['customers_group_price'];
                // do pricing specials
                if (isset($filelayout['v_customer_specials_price_1'])){
                  $row['v_customer_specials_price_' . $ll]     = $sppc_specials[$ll];
                }
                $row2 = vam_db_fetch_array($result2);
                $ll++;
            }
            // do pricing specials
            $specials_result = vam_db_query("SELECT specials_new_products_price, status FROM ".TABLE_SPECIALS." WHERE products_id = " . $row['v_products_id'] . " and customers_group_id <> 0 and expires_date < CURRENT_TIMESTAMP ORDER BY specials_id DESC");
            if( $specials_result_row = vam_db_fetch_array($specials_result) ){
              if ($specials_result_row['status'] == 1) {
                $row['v_products_specials_price']     = $specials_result_row['specials_new_products_price'];
              } else {
                $row['v_products_specials_price']     = $specials_result_row['specials_new_products_price'];
              }
            } else {
              $row['v_products_specials_price']     = '';
            }

        }

        if ($dltype == 'froogle'){
            // For froogle, we check the specials prices for any applicable specials, and use that price
            // by grabbing the specials id descending, we always get the most recently added special price
            // I'm checking status because I think you can turn off specials
            $sql2 = "SELECT
                    specials_new_products_price
                FROM
                    ".TABLE_SPECIALS."
                WHERE
                products_id = " . $row['v_products_id'] . " and
                status = 1 and
                expires_date < CURRENT_TIMESTAMP
                ORDER BY
                    specials_id DESC"
                ;
            $result2 = vam_db_query($sql2);
            $ll = 1;
            $row2 =  vam_db_fetch_array($result2);
            if( $row2 ){
                // reset the products price to our special price if there is one for this product
                $row['v_products_price']     = $row2['specials_new_products_price'];
            }
        }

        //elari -
        //We check the value of tax class and title instead of the id
        //Then we add the tax to price if EP_PRICE_WITH_TAX is set to true
        $row_tax_multiplier         = vam_get_tax_class_rate($row['v_tax_class_id']);
        $row['v_tax_class_title']   = vam_get_tax_class_title($row['v_tax_class_id']);
        $row['v_products_price']    = $row['v_products_price'] +
                (EP_PRICE_WITH_TAX == true ? round( ($row['v_products_price'] * $row_tax_multiplier / 100), EP_PRECISION) : 0);

        // do pricing specials
        if (EP_SPPC_SUPPORT == true) { $SPPC_extra_query = 'and customers_group_id = 0 '; } else { $SPPC_extra_query = ''; }
        if (isset($filelayout['v_products_specials_price'])){
            $specials_result = vam_db_query("SELECT specials_new_products_price, status FROM ".TABLE_SPECIALS." WHERE products_id = " . $row['v_products_id'] . " " . $SPPC_extra_query . "and (expires_date < CURRENT_TIMESTAMP or expires_date is null) ORDER BY specials_id DESC");
            if( $specials_result_row = vam_db_fetch_array($specials_result) ){
              if ($specials_result_row['status'] == 1) {
                $row['v_products_specials_price']     = $specials_result_row['specials_new_products_price'];
              } else {
                $row['v_products_specials_price']     = $specials_result_row['specials_new_products_price'];
              }
            } else {
              $row['v_products_specials_price']     = '';
            }
        }

        // Now set the status to a word the user specd in the config vars
        if ( $row['v_status'] == '1' ){
            $row['v_status'] = EP_TEXT_ACTIVE;
        } else {
            $row['v_status'] = EP_TEXT_INACTIVE;
        }

// BOF mo_image
		for ($i = 0; $i < MO_PICS; $i ++) {
			$row['v_mo_image_'.($i+1)] = "";
		}
		if($mo_image = vam_get_products_mo_images($row['v_products_id'])) {
//			echo '<pre>';var_dump($mo_image);echo '</pre>';
			for($i=0, $n=sizeof($mo_image); $i<$n; $i++) {
				$row['v_mo_image_'.$mo_image[$i]["image_nr"]] = $mo_image[$i]["image_name"];
			}
		}
// EOF mo_image

         if (strlen($row['v_products_image_array'])>0)  $row['v_products_image_array']=implode("|", unserialize($row['v_products_image_array']));

        // remove any bad things in the texts that could confuse EasyPopulate
        $therow = '';
        foreach( $filelayout as $key => $value ){
            //echo "The field was $key<br />";

            $thetext = $row[$key];
            // kill the carriage returns and tabs in the descriptions, they're killing me!
            if (EP_PRESERVE_TABS_CR_LF == false || $dltype == 'froogle') {
              $thetext = str_replace("\r",' ',$thetext);
              $thetext = str_replace("\n",' ',$thetext);
              $thetext = str_replace("\t",' ',$thetext);
            }
            if (EP_EXCEL_SAFE_OUTPUT == true && $dltype != 'froogle') {
              // use quoted values and escape the embedded quotes for excel safe output.
              $therow .= '"'.str_replace('"','""',$thetext).'"' . $ep_separator;
            } else {
              // and put the text into the output separated by $ep_separator defined above
              $therow .= $thetext . $ep_separator;
            }
        }

			if ($_GET['export_charset'] == 'cp1251'){
    			$therow = Utf8ToWin($therow);
   		}

        // lop off the trailing separator, then append the end of row indicator
        $therow = substr($therow,0,strlen($therow)-1) . $endofrow;

        if ($_GET['download'] == 'activestream'){
          echo $therow;
        } else {
          $filestring .= $therow;
        }
        // grab the next row from the db
        $row =  vam_db_fetch_array($result);
    }

    // now either stream it to them or put it in the temp directory
    if ($_GET['download'] == 'activestream'){
        die();
    } elseif ($_GET['download'] == 'stream'){
        //*******************************
        // STREAM FILE
        //*******************************
//		header('Content-Transfer-Encoding: none');
        if (EP_EXCEL_SAFE_OUTPUT == true) {
		header("Content-type: text/x-csv");
//		header('Content-type: text/x-csv; charset="utf-8"');
//		header("Content-type: application/vnd.ms-excel");
//		header('Content-type: application/vnd.ms-excel; charset="utf-8"');
		} else {
		header("Content-type: text/plain");
		}
        header("Content-disposition: attachment; filename=$EXPORT_TIME" . ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"));
        // Changed if using SSL, helps prevent program delay/timeout (add to backup.php also)
        if ($request_type== 'NONSSL'){
          header("Pragma: no-cache");
        } else {
          header("Pragma: ");
        }
        header("Expires: 0");
        echo $filestring;
        die();
    } elseif ($_GET['download'] == 'tempfile') {
        //*******************************
        // PUT FILE IN TEMP DIR
        //*******************************
        $tmpfname = EP_TEMP_DIRECTORY . "$EXPORT_TIME" . ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt");
        //unlink($tmpfname);
        $fp = fopen( $tmpfname, "w+");
        fwrite($fp, $filestring);
        fclose($fp);
		$ep_message_stack = EASY_FILE_LOCATE . EP_TEMP_DIRECTORY . "EP" . $EXPORT_TIME . ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt");
        //die();
    }
} 



//*******************************
//*******************************
// S T A R T
// PAGE DELIVERY
//*******************************
//*******************************
?>

<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<!--<meta name="viewport" content="initial-scale=1.0, width=device-width" />-->
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
<?php if (ENABLE_TABS == 'true') { ?>
		<script type="text/javascript">
			$(function(){
				$('#tabs').tabs({ fx: { opacity: 'toggle', duration: 'fast' } });
			});
		</script>
<?php } ?>
<script type="text/javascript"><!--
  function switchForm( field ) {
    var d = document;
    var frm = field.form;
    var tbl = d.getElementById('customtable');
        
    if(d.getElementById)
    {
      if(field.options[field.selectedIndex].text == '<?php echo TEXT_EASYPOPULATE_COMPLETE; ?>' || field.options[field.selectedIndex].text == '<?php echo TEXT_EASYPOPULATE_FROOGLE; ?>') 
      {
        tbl.style.backgroundColor='lightgrey';
        for ( var index = 0; index < frm.elements.length; index++ )
        {
            var oElement = frm.elements[ index ];
            if ( oElement.type == "checkbox" )
            {
                if ( oElement.checked )
                {
                  oElement.checked = false;
                }
                oElement.disabled = true;
            }
        }
      } 
      else if(field.options[field.selectedIndex].text == '<?php echo TEXT_EASYPOPULATE_PRICE_QTY; ?>' || field.options[field.selectedIndex].text == '<?php echo TEXT_EASYPOPULATE_CATEGORIES; ?>' || field.options[field.selectedIndex].text == '<?php echo TEXT_EASYPOPULATE_ATTRIBUTES; ?>' ) 
      {
        tbl.style.backgroundColor='lightgrey';
        for ( var index = 0; index < frm.elements.length; index++ )
        {
            var oElement = frm.elements[ index ];
            if ( oElement.type == "checkbox" )
            {
                if ( oElement.checked )
                {
                  oElement.checked = false;
                }
                if ( (oElement.name == 'epcust_price' || oElement.name == 'epcust_quantity') && field.options[field.selectedIndex].text == '<?php echo TEXT_EASYPOPULATE_PRICE_QTY; ?>')
                {
                  oElement.disabled = false;
                  oElement.checked = true;
                } 
                else if ( oElement.name == 'epcust_category' && field.options[field.selectedIndex].text == '<?php echo TEXT_EASYPOPULATE_CATEGORIES; ?>' )
                {
                  oElement.disabled = false;
                  oElement.checked = true;
                } 
                else if ( oElement.name == 'epcust_attributes' && field.options[field.selectedIndex].text == '<?php echo TEXT_EASYPOPULATE_ATTRIBUTES; ?>' )
                {
                  oElement.disabled = false;
                  oElement.checked = true;
                } 
                else 
                {
                  oElement.disabled = true;
                }
            }
        }
      } 
      else 
      { 
        tbl.style.backgroundColor='white';
        for ( var index = 0; index < frm.elements.length; index++ )
        {
            var oElement = frm.elements[ index ];
            if ( oElement.type == "checkbox" )
            {
                oElement.disabled = false;
            }
        }
      }
    }
  }
//--></script> 
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'false') { ?>
    <td width="<?php echo BOX_WIDTH; ?>" align="left" valign="top">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </td>
<?php } ?>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><a class="button" href="<?php echo MANUAL_LINK_EASYPOPULATE; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>
        
<p class="smallText"><?php
echo $ep_message_stack;

//*******************************
//*******************************
// UPLOAD AND INSERT FILE
//*******************************
//*******************************
if (!empty($_POST['localfile']) or (isset($_FILES['usrfl']) && isset($_GET['split']) && $_GET['split']==0)) {

		?>
		</p>
		<form name="clear_form" action="easypopulate.php<?php if (defined('SID') && vam_not_null(SID)) { echo '?'.vam_session_name().'='.vam_session_id(); } ?>" method="post" id="clear_form">
		<span class="button"><button type="submit" name="clear_button" value="<?php echo TEXT_EASYPOPULATE_CLEAR; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_EASYPOPULATE_CLEAR; ?></button></span></form>
		<?php

    if (isset($_FILES['usrfl'])){
        // move the file to where we can work with it
        $file = vam_get_uploaded_file('usrfl');
        if (is_uploaded_file($file['tmp_name'])) {
            vam_copy_uploaded_file($file, EP_TEMP_DIRECTORY);
        }

        echo "<p class=smallText>";
        echo EASY_UPLOAD_FILE . "<br />";
        echo EASY_UPLOAD_TEMP . $file['tmp_name'] . "<br />";
        echo EASY_UPLOAD_USER_FILE . $file['name'] . "<br />";
        echo EASY_SIZE . $file['size'] . "<br />";

        // get the entire file into an array
        $readed = file(EP_TEMP_DIRECTORY . $file['name']);
    }
    if (!empty($_POST['localfile'])){
        // move the file to where we can work with it
        //$file = vam_get_uploaded_file('usrfl');

        //$attribute_options_query = "select distinct products_options_id from " . TABLE_PRODUCTS_OPTIONS . " order by products_options_id";
        //$attribute_options_values = vam_db_query($attribute_options_query);
        //$attribute_options_count = 1;
        //while ($attribute_options = vam_db_fetch_array($attribute_options_values)){

        //if (is_uploaded_file($file['tmp_name'])) {
        //    vam_copy_uploaded_file($file, EP_TEMP_DIRECTORY);
        //}

        echo "<p class=smallText>";
        echo EASY_FILENAME . $_POST['localfile'] . "<br />";

        // get the entire file into an array
        $readed = file(EP_TEMP_DIRECTORY . $_POST['localfile']);
    }
    
    if (EP_EXCEL_SAFE_OUTPUT == true) {
    
        // do excel safe input
        $fp = fopen(EP_TEMP_DIRECTORY . (isset($_FILES['usrfl'])?$file['name']:$_POST['localfile']),'r') or die(EASY_ERROR_7);  // open file
        // determine the separator character.
        $header_line = fgets($fp);
        if (strpos($header_line,',') !== false) { $ep_separator = ','; }
        if (strpos($header_line,';') !== false) { $ep_separator = ';'; }
        if (strpos($header_line,"\t") !== false) { $ep_separator = "\t"; }
        if (strpos($header_line,'~') !== false) { $ep_separator = '~'; }
        if (strpos($header_line,'-') !== false) { $ep_separator = '-'; }
        if (strpos($header_line,'*') !== false) { $ep_separator = '*'; }
        fclose($fp); 

        if (EP_EXCEL_SAFE_OUTPUT_ALT_PARCE == false) {
            
            unset($readed);                    // kill array setup with above code
            $readed = array();                 // start a new one for excel_safe_output
            $fp = fopen(EP_TEMP_DIRECTORY . (isset($_FILES['usrfl'])?$file['name']:$_POST['localfile']),'r') or die(EASY_ERROR_7);  // open file
            while($line = fgetcsv($fp,32768,$ep_separator))   // read new line (max 32K bytes)
            {
                unset($line[(sizeof($line)-1)]);  // remove EOREOR at the end of the array
                $readed[] = $line;                // add to array we will process later
            }
            $theheaders_array = $readed[0];     // pull out header line
            fclose($fp);                        // close file

        } else {
        
            // Maynard's CSV Fix ###################################################
            // some versions of fgetcsv don't like a field beginning with "", so we'll parse it ourselves
            // use readed, but parse it ourselves according to $ep_separator, and " as field encloser
            
            // I copied this from below:
            // now we string the entire thing together in case there were carriage returns in the data
              $newreaded = "";

			if ($_POST['import_charset'] == 'cp1251'){
        
        foreach ($readed as $read){
        $newreaded .= CP1251toUTF8($read);
        }

			} else {

        foreach ($readed as $read){
        $newreaded .= $read;
        }

			}

              // now newreaded has the entire file together without the carriage returns.
              // if for some reason excel put qoutes around our EOREOR, remove them then split into rows
              $newreaded = str_replace('"EOREOR"', 'EOREOR', $newreaded);
              $readed = explode( $ep_separator . 'EOREOR',$newreaded);
            // dump the last entry - it's blank
            unset($readed[sizeof($readed)-1]);    
            // parse it all!
            foreach ($readed as $key => $line) {
                $ppp = 0; // pointer
                $line1 = array();
                $remains = trim($line);
                while ($remains != '') {
                    if (substr($remains,0,1) == '"') {
                        // this is an enclosed portion
                        $ppp1 = -1; // so that our first loop points to the right place in $remains
                        $ppp2 = -1;
                        // we've got to find the next " that isn't ""    
                        while($ppp1 < strlen($remains) && $ppp1 == $ppp2 && $ppp1 !== FALSE) {
                            $ppp1 = strpos($remains, '"', $ppp2+2);
                            $ppp2 = strpos($remains, '""', $ppp2+2); // use ppp2 because then """ will get properly understood                
                        }
                        // now $ppp1 points to the closing "
                        // we are pulling out the determined chunk and 
                        // replacing any double quotes with single quotes 
                        // since that is how CSV handles quotes
                        $line1[] = str_replace('""','"',substr($remains,1,$ppp1-1));
                        // find the next separator - for a well formed CSV file, it MUST be a separator (and not in quoted text)
                        $ppp1 = strpos($remains, $ep_separator, $ppp1);
                        $remains = ($ppp1 !== false) ? substr($remains,$ppp1+1) : '';             
                    } else {
                        // this is an un-enclosed portion - find the next separator
                        $ppp1 = strpos($remains, $ep_separator, 0);
                        $line1[] = ($ppp1 !== false) ? substr($remains,0,$ppp1) : $remains;
                        $remains = ($ppp1 !== false) ? substr($remains,$ppp1+1) : '';                        
                    }
                }
                // replace that line with our new array
                $readed[$key] = $line1;
            }
            $theheaders_array = $readed[0];     // pull out header line    
            // EOF Maynard's CSV Fix ###################################################      
        }

    } else {
      // do normal EP input
      // now we string the entire thing together in case there were carriage returns in the data
      $newreaded = "";

			if ($_POST['import_charset'] == 'cp1251'){
        
        foreach ($readed as $read){
        $newreaded .= CP1251toUTF8($read);
        }

			} else {

        foreach ($readed as $read){
        $newreaded .= $read;
        }

			}

      // now newreaded has the entire file together without the carriage returns.
      // if for some reason excel put qoutes around our EOREOR, remove them then split into rows
      $newreaded = str_replace('"EOREOR"', 'EOREOR', $newreaded);
      $readed = explode( $ep_separator . 'EOREOR',$newreaded);

      // Now we'll populate the filelayout based on the header row.
      $theheaders_array = explode( $ep_separator, $readed[0] ); // explode the first row, it will be our filelayout
    }
    
    $lll = 0;
    $filelayout = array();
    foreach( $theheaders_array as $header ){
        $cleanheader = str_replace( '"', '', $header);
        // echo "Fileheader was $header<br /><br /><br />";
        $filelayout[ $cleanheader ] = $lll++; //
    }
    unset($readed[0]); //  we don't want to process the headers with the data

    // now we've got the array broken into parts by the expicit end-of-row marker.
    foreach ($readed as $tkey => $readed_row) {
      process_row($readed_row, $filelayout, $filelayout_count, $default_these, $ep_separator, $languages, $custom_fields);
    }
    // isn't working in PHP 5
    // array_walk($readed, $filelayout, $filelayout_count, $default_these, 'process_row');
	  	?>
		</p>
		<form name="clear_form2" action="easypopulate.php<?php if (defined('SID') && vam_not_null(SID)) { echo '?'.vam_session_name().'='.vam_session_id(); } ?>" method="post" id="clear_form2">
		<span class="button"><button type="submit" name="clear_button" value="<?php echo TEXT_EASYPOPULATE_CLEAR; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_EASYPOPULATE_CLEAR; ?></button></span></form>
		<?php



//*******************************
//*******************************
// UPLOAD AND SPLIT FILE
//*******************************
//*******************************
} elseif (isset($_FILES['usrfl']) && isset($_GET['split']) && $_GET['split']==1) {

		?>
		</p>
		<form name="clear_form2" action="easypopulate.php<?php if (defined('SID') && vam_not_null(SID)) { echo '?'.vam_session_name().'='.vam_session_id(); } ?>" method="post" id="clear_form2">
		<span class="button"><button type="submit" name="clear_button" value="<?php echo TEXT_EASYPOPULATE_CLEAR; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_EASYPOPULATE_CLEAR; ?></button></span></form>
		<?php
        echo "<p class=smallText>";
    // move the file to where we can work with it
    $file = vam_get_uploaded_file('usrfl');
    //echo "Trying to move file...";
    if (is_uploaded_file($file['tmp_name'])) {
        vam_copy_uploaded_file($file, EP_TEMP_DIRECTORY);
    }

    $infp = fopen(EP_TEMP_DIRECTORY . $file['name'], "r");

    $ext_tmp = substr( $file['name'], -3 , 3 );
	
    //toprow has the field headers
    $toprow = fgets($infp,32768);

    $filecount = 1;

    echo EASY_LABEL_FILE_COUNT_1 . $filecount . '.'.$ext_tmp.' ...  ';
    $tmpfname = EP_TEMP_DIRECTORY . "EP_Split" . $filecount.'.'.$ext_tmp;
    $fp = fopen( $tmpfname, "w+");
    fwrite($fp, $toprow);

    $linecount = 0;
    $line = fgets($infp,32768);
    while ($line){
        // walking the entire file one row at a time
        // but a line is not necessarily a complete row, we need to split on rows that have "EOREOR" at the end
        $line = str_replace('"EOREOR"', 'EOREOR', $line);
        fwrite($fp, $line);
        if (strpos($line, 'EOREOR')){
            // we found the end of a line of data, store it
            $linecount++; // increment our line counter
            if ($linecount >= EP_SPLIT_MAX_RECORDS){
                echo EASY_LABEL_LINE_COUNT_1 . $linecount . EASY_LABEL_LINE_COUNT_2 . "<br />";
                $linecount = 0; // reset our line counter
                // close the existing file and open another;
                fclose($fp);
                // increment filecount
                $filecount++;
                echo EASY_LABEL_FILE_COUNT_1 . $filecount . '.'.$ext_tmp.' ...  ';
                $tmpfname = EP_TEMP_DIRECTORY . "EP_Split" . $filecount.'.'.$ext_tmp;
                //Open next file name
                $fp = fopen( $tmpfname, "w+");
                fwrite($fp, $toprow);
            }
        }
        $line=fgets($infp,32768);
    }
    echo EASY_LABEL_LINE_COUNT_1 . $linecount . EASY_LABEL_LINE_COUNT_2 . "<br /><br /> ";
    fclose($fp);
    fclose($infp);

    echo EASY_SPLIT_DOWN . EP_TEMP_DIRECTORY;

}


//*******************************
//*******************************
// MAIN MENU
//*******************************
//*******************************
?>
      </p>

      <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td class="main" width="100%"><span style="background-color:#FFFFCC; width:100%;">&nbsp; &nbsp;<?php echo TEXT_EASYPOPULATE_PLEASE; ?> <a href="<?php echo vam_href_link(FILENAME_BACKUP); ?>"><u><?php echo TEXT_EASYPOPULATE_BACKUP_TEXT; ?></u></a><?php echo TEXT_EASYPOPULATE_BACKUP_TEXT1; ?></span>&nbsp;
		  <?php
		  // Quick Backup Button
		   if (EP_QUICK_BACKUP == true){
		   ?>
		   <form name="skb" action="backup.php" method="post" id="quick_backup">
				<span class="button"><button type="submit" name="quick_backup_button" value="<?php echo TEXT_EASYPOPULATE_BACKUP_BUTTON; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/backup.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_EASYPOPULATE_BACKUP_BUTTON; ?></button></span></form>
		   <?php
			} 
			?>
			
<div id="tabs">

			<ul>
				<li><a href="#import"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/import.png', '', '16', '16'); ?>&nbsp;<?php echo EASYPOPULATE_TAB_IMPORT; ?></a></li>
				<li><a href="#import-temp"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/import-temp.png', '', '16', '16'); ?>&nbsp;<?php echo EASYPOPULATE_TAB_IMPORT_TEMP; ?></a></li>
				<li><a href="#split"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/split.png', '', '16', '16'); ?>&nbsp;<?php echo EASYPOPULATE_TAB_SPLIT; ?></a></li>
				<li><a href="#export"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/export.png', '', '16', '16'); ?>&nbsp;<?php echo EASYPOPULATE_TAB_EXPORT; ?></a></li>
				<li><a href="#quick-links"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/links.png', '', '16', '16'); ?>&nbsp;<?php echo EASYPOPULATE_TAB_QUICK_LINKS; ?></a></li>
          <?php if (EP_SHOW_EP_SETTINGS == true) { ?>
				<li><a href="#info"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/info.png', '', '16', '16'); ?>&nbsp;<?php echo EASYPOPULATE_TAB_INFO; ?></a></li>
          <?php } ?>
			</ul>

<div id="import">			
			
           <?php echo vam_draw_form('easypopulate', FILENAME_EASYPOPULATE, 'split=0', 'post', 'enctype="multipart/form-data"'); ?>       
                <p><b><?php echo EASY_UPLOAD_EP_FILE; ?></b></p>
                <p>
                  <input type="hidden" name="MAX_FILE_SIZE" value="100000000">
                  <input name="usrfl" type="file" size="50">
                  <select name="imput_mode">
                      <option value="normal"><?php echo TEXT_EASYPOPULATE_NORMAL; ?></option>
                      <option value="addnew"><?php echo TEXT_EASYPOPULATE_ADD; ?></option>
                      <option value="update"><?php echo TEXT_EASYPOPULATE_UPDATE; ?></option>
                      <option value="delete"><?php echo TEXT_EASYPOPULATE_DELETE; ?></option>
                  </select>
                  <select name="import_charset">
                      <option selected value="utf8" size="5">utf8</option>
                      <option value ="cp1251" size="5">cp1251</option>
                  </select>
                  <span class="button"><button type="submit" name="buttoninsert" value="<?php echo EASY_INSERT;?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;<?php echo EASY_INSERT; ?></button></span>
                <br />
                </p>
              </form>

</div>

<div id="import-temp">			

           <?php echo vam_draw_form('localfile_insert', FILENAME_EASYPOPULATE, '', 'post', 'enctype="multipart/form-data"'); ?>       
                <p><b><?php echo EASY_IMPORT_TEMP_DIR; ?></b></p>
                <p>
                  <?php
                    //<input type="text" name="localfile" size="50">
                    $the_array = Array();
                    if (is_readable(EP_TEMP_DIRECTORY)) {
                        $handle = opendir(EP_TEMP_DIRECTORY);
                        while (false!== ($file = readdir($handle))) {
                          if ($file!= "." && $file!= ".." &&!is_dir($file)) {
                           $namearr = preg_split('/\./',$file);
                           if ($namearr[count($namearr)-1] == 'csv' || $namearr[count($namearr)-1] == 'txt') $the_array[] = $file;
                          }
                        }
                        closedir($handle);
                    }
                        
                    $array_size = count($the_array);
                    if($array_size == 0){
                      echo ('            <input type="text" name="localfile" size="50">' . "\n");
                    } else {
                      echo ('            <select name="localfile" size="1">' . "\n");
                      foreach ($the_array as $list){
                       echo ('                <option value="' . $list . '">' . $list . '</option>' . "\n");
                      }
                      echo ('            </select>' . "\n");
                    }
                    ?>
                  <select name="imput_mode">
                      <option value="normal"><?php echo TEXT_EASYPOPULATE_NORMAL; ?></option>
                      <option value="addnew"><?php echo TEXT_EASYPOPULATE_ADD; ?></option>
                      <option value="update"><?php echo TEXT_EASYPOPULATE_UPDATE; ?></option>
                      <option value="delete"><?php echo TEXT_EASYPOPULATE_DELETE; ?></option>
                  </select>
                  <span class="button"><button type="submit" name="buttoninsert" value="<?php echo EASY_INSERT; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;<?php echo EASY_INSERT; ?></button></span>
                  <br />
                </p>
             </form>
             
</div>

<div id="split">			

           <?php echo vam_draw_form('easypopulate', FILENAME_EASYPOPULATE, 'split=1', 'post', 'enctype="multipart/form-data"'); ?>
                <p><b><?php echo EASY_SPLIT_EP_FILE; ?></b></p>
                <p>
                  <input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
                  <input name="usrfl" type="file" size="50">
                  <span class="button"><button type="submit" name="buttonsplit" value="<?php echo EASYPOPULATE_BUTTON_SPLIT; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;<?php echo EASYPOPULATE_BUTTON_SPLIT; ?></button></span>
                <br />
                </p>
             </form>

</div>

<div id="export">			

        <p><b><?php echo TEXT_EASYPOPULATE_EXPORT; ?></b></p>
        <p><!-- Download file links -  Add your custom fields here -->
          <table border="0" cellpadding="0" cellspacing="0">
          <?php echo vam_draw_form('custom', 'easypopulate.php', ((defined('SID') && vam_not_null(SID)) ? vam_session_name().'='.vam_session_id() : ''), 'get','id="custom"'); ?><?php if (defined('SID') && vam_not_null(SID)) { echo vam_draw_hidden_field(vam_session_name(), vam_session_id()); } ?>
          <tr><td class="smallText"><?php 
          
          echo vam_draw_pull_down_menu('download',array( 0 => array( "id" => 'activestream', 'text' => TEXT_EASYPOPULATE_ON_THE_FLY), 1 => array( "id" => 'stream', 'text' => TEXT_EASYPOPULATE_CREATE_THEN_DOWNLOAD), 2 => array( "id" => 'tempfile', 'text' => TEXT_EASYPOPULATE_CREATE_IN_TEMP)));
          echo '&nbsp;' . TEXT_EASYPOPULATE_TYPE . '&nbsp;' . vam_draw_pull_down_menu('dltype',array( 0 => array( "id" => 'full', 'text' => TEXT_EASYPOPULATE_COMPLETE), 1 => array( "id" => 'custom', 'text' => TEXT_EASYPOPULATE_CUSTOM), 2 => array( "id" => 'priceqty', 'text' => TEXT_EASYPOPULATE_PRICE_QTY), 3 => array( "id" => 'category', 'text' => TEXT_EASYPOPULATE_CATEGORIES), 4 => array( "id" => 'attrib', 'text' => TEXT_EASYPOPULATE_ATTRIBUTES), 5 => array( "id" => 'froogle', 'text' => TEXT_EASYPOPULATE_FROOGLE)),'custom','onChange="return switchForm(this);"');
          
          echo '<select name="export_charset">
			<option selected value="utf8" size="5">utf8</option>
			<option value ="cp1251" size="5">cp1251</option>
			</select>';
			
          echo '&nbsp;' . ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt") . TEXT_EASYPOPULATE_FILE_FORMAT; 

          $cells = array();
          $cells[0][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_name', 'show', (!empty($_GET['epcust_name'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_NAME.'</td></tr></table>');
          $cells[0][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_description', 'show', (!empty($_GET['epcust_description'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_DESC.'</td></tr></table>');
          $cells[0][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_url', 'show', (!empty($_GET['epcust_url'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_URL.'</td></tr></table>');
          $cells[0][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_image', 'show', (!empty($_GET['epcust_image'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_IMAGE.'</td></tr></table>');
          if (EP_PRODUCTS_WITH_ATTRIBUTES == true) {
            $cells[0][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_attributes', 'show', (!empty($_GET['epcust_attributes'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_ATTRIBUTES.'</td></tr></table>');
          }

          $cells[0][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_category', 'show', (!empty($_GET['epcust_category'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_CATEGORIES.'</td></tr></table>');
          $cells[0][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_manufacturer', 'show', (!empty($_GET['epcust_manufacturer'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_MANUFACTURERS.'</td></tr></table>');

          $cells[1][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_price', 'show', (!empty($_GET['epcust_price'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_PRICE.'</td></tr></table>');
          $cells[1][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_quantity', 'show', (!empty($_GET['epcust_quantity'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_QUANTITY.'</td></tr></table>');
          $cells[1][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_weight', 'show', (!empty($_GET['epcust_weight'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_WEIGHT.'</td></tr></table>');
          $cells[1][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_tax_class', 'show', (!empty($_GET['epcust_tax_class'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_TAX_CLASS.'</td></tr></table>');
          $cells[1][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_avail', 'show', (!empty($_GET['epcust_avail'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_AVAILABLE.'</td></tr></table>');
          $cells[1][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_date_added', 'show', (!empty($_GET['epcust_date_added'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_DATE_ADDED.'</td></tr></table>');
          $cells[1][] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_status', 'show', (!empty($_GET['epcust_status'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_STATUS.'</td></tr></table>');

          $tmp_row_count = 2;
          $tmp_col_count = 0;
          $cells[$tmp_row_count][$tmp_col_count++] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_specials_price', 'show', (!empty($_GET['epcust_specials_price'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_SPECIALS.'</td></tr></table>');
          if (EP_ADDITIONAL_IMAGES == true) {
            $cells[$tmp_row_count][$tmp_col_count++] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_add_images', 'show', (!empty($_GET['epcust_sppc'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_ADD_IMAGES.'</td></tr></table>');
          }
          if (EP_MVS_SUPPORT == true) { 
            $cells[$tmp_row_count][$tmp_col_count++] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_vendor', 'show', (!empty($_GET['epcust_vendor'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_VENDOR.'</td></tr></table>');
          }
          if (EP_XSELL_SUPPORT == true) { 
            $cells[$tmp_row_count][$tmp_col_count++] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_cross_sell', 'show', (!empty($_GET['epcust_cross_sell'])?true:false)) . '</td><td class="smallText"> '.TEXT_EASYPOPULATE_LABEL_XSELL.'</td></tr></table>');
          }

          foreach ($custom_fields[TABLE_PRODUCTS] as $key => $name) { 
            $cells[$tmp_row_count][$tmp_col_count++] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_' . $key, 'show', (!empty($_GET['epcust_' . $key])?true:false)) . '</td><td class="smallText"> ' . $name . '</td></tr></table>');
            if ($tmp_col_count >= 7) { 
              $tmp_row_count += 1; 
              $tmp_col_count = 0; 
            }
          }

          foreach ($custom_fields[TABLE_PRODUCTS_DESCRIPTION] as $key => $name) { 
            $cells[$tmp_row_count][$tmp_col_count++] = array('text' => '<table border="0" cellpadding="0" cellspacing="0"><tr><td class="smallText">' . vam_draw_checkbox_field('epcust_' . $key, 'show', (!empty($_GET['epcust_' . $key])?true:false)) . '</td><td class="smallText"> ' . $name . '</td></tr></table>');
            if ($tmp_col_count >= 7) { 
              $tmp_row_count += 1; 
              $tmp_col_count = 0; 
            }
          }

          $bigbox = new epbox('',false);
          $bigbox->table_parameters = 'id="customtable" style="border: 1px solid #CCCCCC; padding: 2px; margin: 3px;"';
          echo $bigbox->output($cells);

          $manufacturers_array = array();
          $manufacturers_array[] = array( "id" => '', 'text' => TEXT_EASYPOPULATE_FILTER_MANUFACTURER);
          $manufacturers_query = vam_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
          while ($manufacturers = vam_db_fetch_array($manufacturers_query)) {
            $manufacturers_array[] = array( "id" => $manufacturers['manufacturers_id'], 'text' => $manufacturers['manufacturers_name'] );
          }

          $status_array = array(array( "id" => '', 'text' => TEXT_EASYPOPULATE_FILTER_STATUS),array( "id" => '1', 'text' => TEXT_EASYPOPULATE_FILTER_STATUS_ACTIVE),array( "id" => '0', 'text' => TEXT_EASYPOPULATE_FILTER_STATUS_DISABLED));

          echo TEXT_EASYPOPULATE_FILTER_BY . vam_draw_pull_down_menu('epcust_category_filter', array_merge(array( 0 => array( "id" => '', 'text' => TEXT_EASYPOPULATE_FILTER_CATEGORY)), vam_get_category_tree()));
          echo ' ' . vam_draw_pull_down_menu('epcust_manufacturer_filter', $manufacturers_array) . ' ';
          echo ' ' . vam_draw_pull_down_menu('epcust_status_filter', $status_array) . ' ';
          ?>
          <span class="button"><button type="submit" name="build_button" value="<?php echo TEXT_EASYPOPULATE_BUILD_BUTTON; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_EASYPOPULATE_BUILD_BUTTON; ?></button></span>          
          </td></tr>
          </form>
          </table>
        </p>
        
</div>

<div id="quick-links">			

        <p><b><?php echo TEXT_EASYPOPULATE_QUICK_LINKS; ?></b></p>
        <table width="100%" border="0" cellpadding="3" cellspacing="3"><tr><td width="50%" valign="top">
        <p style="margin-top: 8px;"><b><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_1; ?></b><br />
        <font size="-2"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_2; ?></font></p>
        <p><!-- Download file links -  Add your custom fields here -->
          <a href="easypopulate.php?download=stream&dltype=full<?php if (defined('SID') && vam_not_null(SID)) { echo '&'.vam_session_name().'='.vam_session_id(); } ?>"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_3; ?><?php if (EP_SPPC_SUPPORT == true) { echo TEXT_EASYPOPULATE_QUICK_LINKS_4; } ?></b> <?php echo ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"); ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_5; ?></a><br />
<?php if (EP_EXTRA_FIELDS_SUPPORT == true) { ?>
          <a href="easypopulate.php?download=stream&dltype=extra_fields<?php if (defined('SID') && vam_not_null(SID)) { echo '&'.vam_session_name().'='.vam_session_id(); } ?>"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_7; ?> <?php echo ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"); ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_5; ?></a><br />
<?php } ?>
<?php if (EP_CATEGORIES_SUPPORT == true) { ?>
          <a href="easypopulate.php?download=stream&dltype=categories<?php if (defined('SID') && vam_not_null(SID)) { echo '&'.vam_session_name().'='.vam_session_id(); } ?>"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_CATEGORIES; ?> <?php echo ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"); ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_5; ?></a><br />
<?php } ?>
<?php if (EP_TAGS_SUPPORT == true) { ?>
          <a href="easypopulate.php?download=stream&dltype=tags<?php if (defined('SID') && vam_not_null(SID)) { echo '&'.vam_session_name().'='.vam_session_id(); } ?>"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_TAGS; ?> <?php echo ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"); ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_5; ?></a><br />
<?php } ?>
          <a href="easypopulate.php?download=stream&dltype=priceqty<?php if (defined('SID') && vam_not_null(SID)) { echo '&'.vam_session_name().'='.vam_session_id(); } ?>"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_8; ?><?php if (EP_SPPC_SUPPORT == true) { echo TEXT_EASYPOPULATE_QUICK_LINKS_4; } ?></b> <?php echo ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"); ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_5; ?></a><br />
          <a href="easypopulate.php?download=stream&dltype=category<?php if (defined('SID') && vam_not_null(SID)) { echo '&'.vam_session_name().'='.vam_session_id(); } ?>"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_9; ?></b> <?php echo ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"); ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_5; ?></a><br />
          <a href="easypopulate.php?download=stream&dltype=froogle<?php if (defined('SID') && vam_not_null(SID)) { echo '&'.vam_session_name().'='.vam_session_id(); } ?>"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_10; ?></b> <?php echo ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"); ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_12; ?></a><br />
          <!-- VJ product attributes begin //-->
          <?php if (EP_PRODUCTS_WITH_ATTRIBUTES == true) { ?>
          <a href="easypopulate.php?download=stream&dltype=attrib<?php if (defined('SID') && vam_not_null(SID)) { echo '&'.vam_session_name().'='.vam_session_id(); } ?>"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_11; ?></b> <?php echo ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"); ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_12; ?></a><br />
          <?php } ?>
          <!-- VJ product attributes end //-->
        </p><br />
        </td><td width="50%" valign="top">
        <p style="margin-top: 8px;"><b><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_13; ?></b><br />
        <font size="-2"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_14; ?></font></p>
        <p>
          <a href="easypopulate.php?download=tempfile&dltype=full<?php if (defined('SID') && vam_not_null(SID)) { echo '&'.vam_session_name().'='.vam_session_id(); } ?>"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_15; ?> <?php echo ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"); ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_6; ?></a><br />
          <a href="easypopulate.php?download=tempfile&dltype=priceqty<?php if (defined('SID') && vam_not_null(SID)) { echo '&'.vam_session_name().'='.vam_session_id(); } ?>"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_16; ?> <?php echo ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"); ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_6; ?></a><br />
          <a href="easypopulate.php?download=tempfile&dltype=category<?php if (defined('SID') && vam_not_null(SID)) { echo '&'.vam_session_name().'='.vam_session_id(); } ?>"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_17; ?> <?php echo ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"); ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_6; ?></a><br />
          <a href="easypopulate.php?download=tempfile&dltype=froogle<?php if (defined('SID') && vam_not_null(SID)) { echo '&'.vam_session_name().'='.vam_session_id(); } ?>"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_18; ?> <?php echo ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"); ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_6; ?></a><br />
          <!-- VJ product attributes begin //-->
          <?php if (EP_PRODUCTS_WITH_ATTRIBUTES == true) { ?>
          <a href="easypopulate.php?download=tempfile&dltype=attrib<?php if (defined('SID') && vam_not_null(SID)) { echo '&'.vam_session_name().'='.vam_session_id(); } ?>"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_19; ?> <?php echo ((EP_EXCEL_SAFE_OUTPUT == true)?".csv":".txt"); ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_6; ?></a><br />
          <?php } ?>
          <!-- VJ product attributes end //-->
        </p><br />
        </td></tr></table>

</div>

          <?php if (EP_SHOW_EP_SETTINGS == true) { ?>
          
<div id="info">			

             <br /><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_20; ?><br />
             <?php echo EP_TEMP_DIRECTORY; ?><br />
             <?php if (is_writable(EP_TEMP_DIRECTORY)) { ?><font color="#009900"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_21; ?></font><?php } else { ?><font color="#FF0000"><?php echo TEXT_EASYPOPULATE_QUICK_LINKS_22; ?></font><?php } ?><br />
             <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_23; ?> <?php if (ini_get('magic_quotes_runtime') == 1){ echo TEXT_EASYPOPULATE_QUICK_LINKS_42; } else { echo TEXT_EASYPOPULATE_QUICK_LINKS_43; } ?><br />
             <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_24; ?> <?php if (ini_get(register_globals)) { echo TEXT_EASYPOPULATE_QUICK_LINKS_42; } else { echo TEXT_EASYPOPULATE_QUICK_LINKS_43; } ?><br />
             <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_25; ?> <?php echo EP_SPLIT_MAX_RECORDS; ?> <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_44; ?><br />
             <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_26; ?> <?php echo EP_MODEL_NUMBER_SIZE; ?><br />
             <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_27; ?> <?php echo (EP_PRICE_WITH_TAX?'true':'false'); ?><br />
             <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_28; ?> <?php echo EP_PRECISION; ?><br />
             <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_29; ?> <?php echo (EP_REPLACE_QUOTES?'true':'false'); ?><br />
             <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_30; ?>
             <?php switch ($ep_separator) {
               case "\t";
                 echo TEXT_EASYPOPULATE_QUICK_LINKS_31;
                 break;
               case ",";
                 echo TEXT_EASYPOPULATE_QUICK_LINKS_32;
                 break;
               case ";";
                 echo TEXT_EASYPOPULATE_QUICK_LINKS_33;
                 break;
               case "~";
                 echo TEXT_EASYPOPULATE_QUICK_LINKS_34;
                 break;
               case "-";
                 echo TEXT_EASYPOPULATE_QUICK_LINKS_35;
                 break;
               case "*";
                 echo TEXT_EASYPOPULATE_QUICK_LINKS_36;
                 break;
             }
             ?><br />
             <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_37; ?> <?php echo (EP_EXCEL_SAFE_OUTPUT?'true':'false'); ?><br />
             <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_38; ?> <?php echo (EP_PRESERVE_TABS_CR_LF?'true':'false'); ?><br />
             <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_39; ?> <?php echo EP_MAX_CATEGORIES; ?><br />
             <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_40; ?> <?php echo (EP_PRODUCTS_WITH_ATTRIBUTES?'true':'false'); ?><br />
             <?php echo TEXT_EASYPOPULATE_QUICK_LINKS_41; ?> <?php echo (EP_FROOGLE_SEF_URLS?'true':'false'); ?><br />
             <br />

</div>

          <?php } ?>

 
      
    </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>


<?php
//*******************************
//*******************************
// end: MAIN MENU
//*******************************
//*******************************






///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
// 
// ep_create_filelayout()
// 
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
function ep_create_filelayout($dltype, $attribute_options_array, $languages, $custom_fields){

    // depending on the type of the download the user wanted, create a file layout for it.
    $fieldmap = array(); // default to no mapping to change internal field names to external.

    // build filters
    $sql_filter = '';
    if (!empty($_GET['epcust_category_filter'])) {
      $sub_categories = array();
      $categories_query_addition = 'ptoc.categories_id = ' . (int)$_GET['epcust_category_filter'] . '';
      vam_get_sub_categories($sub_categories, $_GET['epcust_category_filter']);
      foreach ($sub_categories AS $ckey => $category ) {
        $categories_query_addition .= ' or ptoc.categories_id = ' . (int)$category . '';
      }
      $sql_filter .= ' and (' . $categories_query_addition . ')';
    }
    if ($_GET['epcust_manufacturer_filter']!='') {
      $sql_filter .= ' and p.manufacturers_id = ' . (int)$_GET['epcust_manufacturer_filter'];
    }
    if ($_GET['epcust_status_filter']!='') {
      $sql_filter .= ' and p.products_status = ' . (int)$_GET['epcust_status_filter'];
    }

    // /////////////////////////////////////////////////////////////////////
    //
    // Start: Support for other contributions
    //
    // /////////////////////////////////////////////////////////////////////
    
    $ep_additional_layout_product = '';
    $ep_additional_layout_product_select = '';
    $ep_additional_layout_product_description = '';
    $ep_additional_layout_pricing = '';
    
    if ( $dltype == 'full'){
        foreach ($custom_fields[TABLE_PRODUCTS] as $key => $name) { 
          $ep_additional_layout_product .= '$filelayout[\'v_' . $key . '\'] = $iii++;
                                            ';
          $ep_additional_layout_product_select .= 'p.' . $key . ' as v_' . $key . ',';
        }
    }


    if (EP_ADDITIONAL_IMAGES == true) { 
      $ep_additional_layout_product .= '$filelayout[\'v_products_image_description\'] = $iii++;
                                       ';
	  for ($i=2;$i<=EP_ADDITIONAL_IMAGES_MAX+1;$i++) {
        $ep_additional_layout_product .= '$filelayout[\'v_products_image_'.$i.'\'] = $iii++;
                                          $filelayout[\'v_products_image_description_'.$i.'\'] = $iii++;
                                          ';
	  }
	} 
    if (EP_ADDITIONAL_IMAGES == true) { 
      $ep_additional_layout_product_select .= 'p.products_image_description as v_products_image_description,';
    }    

    if (EP_MORE_PICS_6_SUPPORT == true) { 
      $ep_additional_layout_product .= '$filelayout[\'v_products_subimage1\'] = $iii++;
                                        $filelayout[\'v_products_subimage2\'] = $iii++;
                                        $filelayout[\'v_products_subimage3\'] = $iii++;
                                        $filelayout[\'v_products_subimage4\'] = $iii++;
                                        $filelayout[\'v_products_subimage5\'] = $iii++;
                                        $filelayout[\'v_products_subimage6\'] = $iii++;
                                        ';
    }    
    if (EP_MORE_PICS_6_SUPPORT == true) { 
      $ep_additional_layout_product_select .= 'p.products_subimage1 as v_products_subimage1, p.products_subimage2 as v_products_subimage2, p.products_subimage3 as v_products_subimage3, p.products_subimage4 as v_products_subimage4, p.products_subimage5 as v_products_subimage5, p.products_subimage6 as v_products_subimage6,';
    }    

    if (EP_UNLIMITED_IMAGES == true) { 
      $ep_additional_layout_product .= '$filelayout[\'v_products_image_array\'] = $iii++;';
      $ep_additional_layout_product_select .= 'p.products_image_array as v_products_image_array,';
    }    

    if (EP_ULTRPICS_SUPPORT == true) { 
      $ep_additional_layout_product .= '$filelayout[\'v_products_image_med\'] = $iii++;
					$filelayout[\'v_products_image_lrg\'] = $iii++;
					$filelayout[\'v_products_image_sm_1\'] = $iii++;
					$filelayout[\'v_products_image_xl_1\'] = $iii++;
					$filelayout[\'v_products_image_sm_2\'] = $iii++;
					$filelayout[\'v_products_image_xl_2\'] = $iii++;
					$filelayout[\'v_products_image_sm_3\'] = $iii++;
					$filelayout[\'v_products_image_xl_3\'] = $iii++;
					$filelayout[\'v_products_image_sm_4\'] = $iii++;
					$filelayout[\'v_products_image_xl_4\'] = $iii++;
					$filelayout[\'v_products_image_sm_5\'] = $iii++;
					$filelayout[\'v_products_image_xl_5\'] = $iii++;
					$filelayout[\'v_products_image_sm_6\'] = $iii++;
					$filelayout[\'v_products_image_xl_6\'] = $iii++;
                                        ';
    }
    if (EP_ULTRPICS_SUPPORT == true) { 
      $ep_additional_layout_product_select .= 'p.products_image_med as v_products_image_med, p.products_image_lrg as v_products_image_lrg, p.products_image_sm_1 as v_products_image_sm_1, p.products_image_xl_1 as v_products_image_xl_1, p.products_image_sm_2 as v_products_image_sm_2, p.products_image_xl_2 as v_products_image_xl_2, p.products_image_sm_3 as v_products_image_sm_3, p.products_image_xl_3 as v_products_image_xl_3, p.products_image_sm_4 as v_products_image_sm_4, p.products_image_xl_4 as v_products_image_xl_4, p.products_image_sm_5 as v_products_image_sm_5, p.products_image_xl_5 as v_products_image_xl_5, p.products_image_sm_6 as v_products_image_sm_6,p.products_image_xl_6 as v_products_image_xl_6,';
    }
	
    if (EP_PDF_UPLOAD_SUPPORT == true) { 
      $ep_additional_layout_product .= '$filelayout[\'v_products_pdfupload\'] = $iii++;
					$filelayout[\'v_products_fileupload\'] = $iii++;
					';
    }
	
    if (EP_PDF_UPLOAD_SUPPORT == true) {
      $ep_additional_layout_product_select .='p.products_pdfupload as v_products_pdfupload,p.products_fileupload as v_products_fileupload,';
    }
    
    if (EP_SPPC_SUPPORT == true) { 
      if (!empty($_GET['epcust_specials_price'])) { 
      $ep_additional_layout_pricing .= '$filelayout[\'v_customer_price_1\'] = $iii++;
                                        $filelayout[\'v_customer_specials_price_1\'] = $iii++;
                                        $filelayout[\'v_customer_group_id_1\'] = $iii++;
                                        $filelayout[\'v_customer_price_2\'] = $iii++;
                                        $filelayout[\'v_customer_specials_price_2\'] = $iii++;
                                        $filelayout[\'v_customer_group_id_2\'] = $iii++;
                                        $filelayout[\'v_customer_price_3\'] = $iii++;
                                        $filelayout[\'v_customer_specials_price_3\'] = $iii++;
                                        $filelayout[\'v_customer_group_id_3\'] = $iii++;
                                        $filelayout[\'v_customer_price_4\'] = $iii++;
                                        $filelayout[\'v_customer_specials_price_4\'] = $iii++;
                                        $filelayout[\'v_customer_group_id_4\'] = $iii++;
                                        ';
      } else {
      $ep_additional_layout_pricing .= '$filelayout[\'v_customer_price_1\'] = $iii++;
                                        $filelayout[\'v_customer_group_id_1\'] = $iii++;
                                        $filelayout[\'v_customer_price_2\'] = $iii++;
                                        $filelayout[\'v_customer_group_id_2\'] = $iii++;
                                        $filelayout[\'v_customer_price_3\'] = $iii++;
                                        $filelayout[\'v_customer_group_id_3\'] = $iii++;
                                        $filelayout[\'v_customer_price_4\'] = $iii++;
                                        $filelayout[\'v_customer_group_id_4\'] = $iii++;
                                        ';
      }
    }
    if (EP_HTC_SUPPORT == true) {
      $ep_additional_layout_product_description .= '$filelayout[\'v_products_meta_title_\'.$lang[\'id\']]    = $iii++;
                                                    $filelayout[\'v_products_meta_description_\'.$lang[\'id\']]     = $iii++;
                                                    $filelayout[\'v_products_meta_keywords_\'.$lang[\'id\']] = $iii++;
                                                    ';
    }
    
    if (EP_MVS_SUPPORT == true) {
      $ep_additional_layout_product_select .= 'p.vendors_id as v_vendor_id,';
    }

    // /////////////////////////////////////////////////////////////////////
    // End: Support for other contributions
    // /////////////////////////////////////////////////////////////////////



    switch( $dltype ){

    case 'full':
        // The file layout is dynamically made depending on the number of languages
        $iii = 0;
        $filelayout = array();

        $filelayout['v_products_model'] = $iii++;

        foreach ($languages as $key => $lang){
            $filelayout['v_products_name_'.$lang['id']]        = $iii++;
            $filelayout['v_products_description_'.$lang['id']] = $iii++;
            $filelayout['v_products_url_'.$lang['id']]         = $iii++;
            foreach ($custom_fields[TABLE_PRODUCTS_DESCRIPTION] as $key => $name) { 
              $filelayout['v_' . $key . '_'.$lang['id']]         = $iii++;
            }
            if (!empty($ep_additional_layout_product_description)) {
              eval($ep_additional_layout_product_description);
            }
			
        }

        $filelayout['v_products_image'] = $iii++;

        if (!empty($ep_additional_layout_product)) {
          eval($ep_additional_layout_product);
        }

        $filelayout['v_products_price']    = $iii++;
        $filelayout['v_products_specials_price'] = $iii++;

        if (EP_MVS_SUPPORT == true) { 
          $filelayout['v_vendor']    = $iii++;
        }

        if (!empty($ep_additional_layout_pricing)) {
          eval($ep_additional_layout_pricing);
        }

        $filelayout['v_products_quantity'] = $iii++;
        $filelayout['v_products_weight']   = $iii++;
        $filelayout['v_date_avail']        = $iii++;
        $filelayout['v_date_added']        = $iii++;

		// build the categories name section of the array based on the number of categores the user wants to have
		for($i=1; $i<EP_MAX_CATEGORIES+1; $i++){
			$filelayout['v_categories_image_' . $i] = $iii++;
			foreach ($languages as $key => $lang){
				$filelayout['v_categories_name_' . $i . '_' . $lang['id']] = $iii++;
			}
		}

        $filelayout['v_manufacturers_name'] = $iii++;

        // VJ product attribs begin
        $attribute_options_count = 1;
        foreach ($attribute_options_array as $tkey => $attribute_options_values) {
            $filelayout['v_attribute_options_id_'.$attribute_options_count] = $iii++;
            foreach ($languages as $tkey => $lang ) {
                $filelayout['v_attribute_options_name_'.$attribute_options_count.'_'.$lang['id']] = $iii++;
            }

            $attribute_values_query = "select products_options_values_id  from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options_values['products_options_id'] . "' order by products_options_values_id";
            $attribute_values_values = vam_db_query($attribute_values_query);

            $attribute_values_count = 1;
            while ($attribute_values = vam_db_fetch_array($attribute_values_values)) {
                $filelayout['v_attribute_values_id_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                foreach ($languages as $tkey => $lang ) {
                    $filelayout['v_attribute_values_name_'.$attribute_options_count.'_'.$attribute_values_count.'_'.$lang['id']] = $iii++;
                }
                $filelayout['v_attribute_values_price_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                $filelayout['v_attribute_values_model_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                $filelayout['v_attribute_values_stock_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                $filelayout['v_attribute_values_weight_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                $filelayout['v_attribute_values_sort_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                //// attributes stock add start        
                if ( EP_PRODUCTS_ATTRIBUTES_STOCK == true ) { 
                    $filelayout['v_attribute_values_stock_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                }                
                //// attributes stock add end         
                $attribute_values_count++;
             }
            $attribute_options_count++;
        }
        // VJ product attribs end

        $filelayout['v_tax_class_title']  = $iii++;
        $filelayout['v_status']           = $iii++;

        $filelayout_sql = "SELECT
            p.products_id as v_products_id,
            p.products_model as v_products_model,
            p.products_image as v_products_image,
            $ep_additional_layout_product_select
            p.products_price as v_products_price,
            p.products_weight as v_products_weight,
            p.products_date_available as v_date_avail,
            p.products_date_added as v_date_added,
            p.products_tax_class_id as v_tax_class_id,
            p.products_quantity as v_products_quantity,
            p.manufacturers_id as v_manufacturers_id,
            subc.categories_id as v_categories_id,
            p.products_status as v_status
            FROM
            ".TABLE_PRODUCTS." as p,
            ".TABLE_CATEGORIES." as subc,
            ".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
            WHERE
            p.products_id = ptoc.products_id AND
            ptoc.categories_id = subc.categories_id
            " . $sql_filter;

// BOF mo_image
//		echo '<pre>';var_dump($fileheaders);echo '</pre>';
		for ($i = 0; $i < MO_PICS; $i ++) {
			$filelayout['v_mo_image_'.($i+1)] = $iii++;
		}
// EOF mo_image

        break;

    case 'priceqty':
        $iii = 0;
        $filelayout = array();

        $filelayout['v_products_model']    = $iii++;
        $filelayout['v_products_price']    = $iii++;
        $filelayout['v_products_quantity'] = $iii++;
        
        if (!empty($ep_additional_layout_pricing)) {
          eval($ep_additional_layout_pricing);
        }

        $filelayout_sql = "SELECT
            p.products_id as v_products_id,
            p.products_model as v_products_model,
            p.products_price as v_products_price,
            p.products_tax_class_id as v_tax_class_id,
            p.products_quantity as v_products_quantity
            FROM
            ".TABLE_PRODUCTS." as p
            ";
        break;

    case 'custom':
        $iii = 0;
        $filelayout = array();

        $filelayout['v_products_model'] = $iii++;

        if (!empty($_GET['epcust_status'])) { $filelayout['v_status'] = $iii++; }

        foreach ($languages as $key => $lang){
            if (!empty($_GET['epcust_name'])) { $filelayout['v_products_name_'.$lang['id']] = $iii++; }
            if (!empty($_GET['epcust_description'])) { $filelayout['v_products_description_'.$lang['id']] = $iii++; }
            if (!empty($_GET['epcust_url'])) { $filelayout['v_products_url_'.$lang['id']] = $iii++; }
            foreach ($custom_fields[TABLE_PRODUCTS_DESCRIPTION] as $key => $name) { 
              if (!empty($_GET['epcust_' . $key])) { $filelayout['v_' . $key . '_'.$lang['id']] = $iii++; }
            }
        }

        if (!empty($_GET['epcust_image']) || !empty($_GET['epcust_add_images'])) {
          $filelayout['v_products_image'] = $iii++;

          if (!empty($ep_additional_layout_product)) {
            eval($ep_additional_layout_product);
          }
        }
 
        foreach ($custom_fields[TABLE_PRODUCTS] as $key => $name) { 
            if (!empty($_GET['epcust_' . $key])) {
                $filelayout['v_' . $key] = $iii++;
                $ep_additional_layout_product_select .= 'p.' . $key . ' as v_' . $key . ',';
            }
        }

        if (!empty($_GET['epcust_price'])) { $filelayout['v_products_price'] = $iii++; }
        if (!empty($_GET['epcust_specials_price'])) { $filelayout['v_products_specials_price'] = $iii++; }
        if (!empty($_GET['epcust_quantity'])) { $filelayout['v_products_quantity'] = $iii++; }
        if (!empty($_GET['epcust_weight'])) { $filelayout['v_products_weight'] = $iii++; }
        if (!empty($_GET['epcust_avail'])) { $filelayout['v_date_avail'] = $iii++; }
        if (!empty($_GET['epcust_date_added'])) { $filelayout['v_date_added'] = $iii++; }
		
		if (!empty($_GET['epcust_category'])) {
		  // build the categories name section of the array based on the number 
		  // of categores the user wants to have
		  for($i=1; $i<=EP_MAX_CATEGORIES; $i++){
			$filelayout['v_categories_image_'.$i] = $iii++;
			foreach ($languages as $key => $lang){
			  $filelayout['v_categories_name_'.$i.'_'.$lang['id']] = $iii++;
			}
		  }
		}

        if (!empty($_GET['epcust_manufacturer'])) { $filelayout['v_manufacturers_name'] = $iii++; }

        if (!empty($_GET['epcust_attributes'])) {
          // VJ product attribs begin
          $attribute_options_count = 1;
          foreach ($attribute_options_array as $tkey => $attribute_options_values) {
            $filelayout['v_attribute_options_id_'.$attribute_options_count] = $iii++;
            foreach ($languages as $tkey => $lang ) {
                $filelayout['v_attribute_options_name_'.$attribute_options_count.'_'.$lang['id']] = $iii++;
            }

            $attribute_values_query = "select products_options_values_id  from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options_values['products_options_id'] . "' order by products_options_values_id";
            $attribute_values_values = vam_db_query($attribute_values_query);

            $attribute_values_count = 1;
            while ($attribute_values = vam_db_fetch_array($attribute_values_values)) {
                $filelayout['v_attribute_values_id_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                foreach ($languages as $tkey => $lang ) {
                    $filelayout['v_attribute_values_name_'.$attribute_options_count.'_'.$attribute_values_count.'_'.$lang['id']] = $iii++;
                }
                $filelayout['v_attribute_values_price_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                $filelayout['v_attribute_values_model_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                $filelayout['v_attribute_values_stock_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                $filelayout['v_attribute_values_weight_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                $filelayout['v_attribute_values_sort_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                //// attributes stock add start        
                if ( EP_PRODUCTS_ATTRIBUTES_STOCK == true ) { 
                    $filelayout['v_attribute_values_stock_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                }                
                //// attributes stock add end         
                $attribute_values_count++;
             }
            $attribute_options_count++;
          }
          // VJ product attribs end
        }
        if (EP_MVS_SUPPORT == true) {
          if (!empty($_GET['epcust_vendor'])) { $filelayout['v_vendor'] = $iii++; }
        }

        if (!empty($_GET['epcust_sppc'])) {
         if (!empty($ep_additional_layout_pricing)) {
          eval($ep_additional_layout_pricing);
         }
        }

        if (!empty($_GET['epcust_tax_class'])) { $filelayout['v_tax_class_title'] = $iii++; }
        if (!empty($_GET['epcust_comment'])) { $filelayout['v_products_comment'] = $iii++; }
        if (!empty($_GET['epcust_cross_sell'])) { $filelayout['v_cross_sell'] = $iii++; }

        $filelayout_sql = "SELECT
            p.products_id as v_products_id,
            p.products_model as v_products_model,
            p.products_status as v_status,
            p.products_price as v_products_price,
            p.products_quantity as v_products_quantity,
            p.products_weight as v_products_weight,
            p.products_image as v_products_image,
            $ep_additional_layout_product_select
            p.manufacturers_id as v_manufacturers_id,
            p.products_date_available as v_date_avail,
            p.products_date_added as v_date_added,
            p.products_tax_class_id as v_tax_class_id,
            subc.categories_id as v_categories_id
            FROM
            ".TABLE_PRODUCTS." as p,
            ".TABLE_CATEGORIES." as subc,
            ".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
            WHERE
            p.products_id = ptoc.products_id AND
            ptoc.categories_id = subc.categories_id
            " . $sql_filter;
        break;

    case 'category':
        $iii = 0;
        $filelayout = array();
        
        $filelayout['v_products_model'] = $iii++;

		for($i=1; $i<EP_MAX_CATEGORIES+1; $i++){
			$filelayout['v_categories_image_'.$i] = $iii++;
			foreach ($languages as $key => $lang){
					$filelayout['v_categories_name_'.$i.'_'.$lang['id']] = $iii++;
			}
		}

        $filelayout_sql = "SELECT
            p.products_id as v_products_id,
            p.products_model as v_products_model,
            subc.categories_id as v_categories_id
            FROM
            ".TABLE_PRODUCTS." as p,
            ".TABLE_CATEGORIES." as subc,
            ".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc            
            WHERE
            p.products_id = ptoc.products_id AND
            ptoc.categories_id = subc.categories_id
            ";
        break;

    case 'extra_fields':
    // start EP for product extra field ============================= DEVSOFTVN - 10/20/2005     
        $iii = 0;
        $filelayout = array(
            'v_products_model'        => $iii++,
            'v_products_extra_fields_name'        => $iii++, 
            'v_products_extra_fields_id'        => $iii++,
//            'v_products_id'        => $iii++,
            'v_products_extra_fields_value'        => $iii++,
                        );
    
        $filelayout_sql = "SELECT
                        p.products_id as v_products_id,
                        p.products_model as v_products_model,
                        subc.products_extra_fields_id as v_products_extra_fields_id,
                        subc.products_extra_fields_value as v_products_extra_fields_value,
                        ptoc.products_extra_fields_name as v_products_extra_fields_name
                        FROM
                        ".TABLE_PRODUCTS." as p,
                        ".TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS." as subc,
                        ".TABLE_PRODUCTS_EXTRA_FIELDS." as ptoc
                        WHERE
                        p.products_id = subc.products_id AND
                        ptoc.products_extra_fields_id = subc.products_extra_fields_id
                        ";    
    // end of EP for extra field code ======= DEVSOFTVN================       
        break;

    case 'categories':
    // start EP for product extra field ============================= DEVSOFTVN - 10/20/2005     
        $iii = 0;
        $filelayout = array(
            'v_categories_id'        => $iii++,
            'v_categories_parent_id'        => $iii++,
            'v_categories_name'        => $iii++,
            'v_categories_heading_title'        => $iii++,
            'v_categories_description'        => $iii++,
            'v_categories_meta_title'        => $iii++,
            'v_categories_meta_description'        => $iii++,
            'v_categories_meta_keywords'        => $iii++,
            'v_categories_url'        => $iii++,
            'v_categories_image'        => $iii++,
            'v_categories_icon'        => $iii++,
            'v_categories_sort_order'        => $iii++,
            'v_categories_status'        => $iii++,
            'v_categories_yml_enable'        => $iii++,
            'v_categories_google_category_id'        => $iii++,
            'v_categories_label_id'        => $iii++,
            'v_categories_likes'        => $iii++,
            'v_categories_dislikes'        => $iii++,
                        );
    
        $filelayout_sql = "SELECT
                        c.categories_id as v_categories_id,
                        cd.categories_name as v_categories_name,
                        cd.categories_heading_title as v_categories_heading_title,
                        cd.categories_description as v_categories_description,
                        cd.categories_meta_title as v_categories_meta_title,
                        cd.categories_meta_description as v_categories_meta_description,
                        cd.categories_meta_keywords as v_categories_meta_keywords,
                        c.categories_url as v_categories_url,
                        c.categories_image as v_categories_image,
                        c.icon as v_categories_icon,
                        c.sort_order as v_categories_sort_order,
                        c.categories_status as v_categories_status,
                        c.parent_id as v_categories_parent_id,
                        c.yml_enable as v_categories_yml_enable,
                        c.google_category_id as v_categories_google_category_id,
                        c.label_id as v_categories_label_id,
                        c.likes as v_categories_likes,
                        c.dislikes as v_categories_dislikes,        
                        c.listing_template as v_categories_listing_template,        
                        c.products_sorting as v_categories_products_sorting,        
                        c.products_sorting2 as v_categories_products_sorting2        
                        FROM
                        ".TABLE_CATEGORIES." as c,
                        ".TABLE_CATEGORIES_DESCRIPTION." as cd
                        WHERE
                        cd.categories_id = c.categories_id
                        ";    
    // end of EP for extra field code ======= DEVSOFTVN================       
        break;

    case 'tags':
    // start EP for product extra field ============================= DEVSOFTVN - 10/20/2005     
        $iii = 0;
        $filelayout = array(
            'v_tags_id'        => $iii++,
            'v_tags_name'        => $iii++,
            'v_tags_url'        => $iii++,
            'v_tags_title'        => $iii++,
            'v_tags_description'        => $iii++,
            'v_tags_mainpage'        => $iii++,
            'v_tags_sort_order'        => $iii++,
            'v_tags_status'        => $iii++,
            'v_tags_to_products'        => $iii++,
            'v_tags_to_categories'        => $iii++
                        );
    
        $filelayout_sql = "SELECT
                        t.tags_id as v_tags_id,
                        t.tags_name as v_tags_name,
                        t.tags_url as v_tags_url,
                        t.tags_title as v_tags_title,
                        t.tags_description as v_tags_description,
                        t.tags_mainpage as v_tags_mainpage,
                        t.sort_order as v_tags_sort_order,
                        t.status as v_tags_status
                        FROM
                        ".TABLE_TAGS." as t
                        ";    
    // end of EP for extra field code ======= DEVSOFTVN================       
        break;
        
    case 'froogle':
        // this is going to be a little interesting because we need
        // a way to map from internal names to external names
        //
        // Before it didn't matter, but with froogle needing particular headers,
        // The file layout is dynamically made depending on the number of languages
        $iii = 0;
        $filelayout = array();

        $filelayout['v_froogle_products_url_1'] = $iii++;
        $filelayout['v_froogle_products_name_'.EP_DEFAULT_LANGUAGE_ID] = $iii++;
        $filelayout['v_froogle_products_description_'.EP_DEFAULT_LANGUAGE_ID] = $iii++;
        $filelayout['v_products_price'] = $iii++;
        $filelayout['v_products_fullpath_image'] = $iii++;
        $filelayout['v_froogle_product_id'] = $iii++;
        $filelayout['v_froogle_quantitylevel'] = $iii++;
        $filelayout['v_category_fullpath'] = $iii++;
        $filelayout['v_froogle_exp_date'] = $iii++;
        $filelayout['v_froogle_currency'] = $iii++;

        $iii=0;
        $fileheaders = array();

        // EP Support mapping new names to the export headers.
        // use the $fileheaders[''] vars to do that.
        $fileheaders['link'] = $iii++;
        $fileheaders['title'] = $iii++;
        $fileheaders['description'] = $iii++;
        $fileheaders['price'] = $iii++;
        $fileheaders['image_link'] = $iii++;
        $fileheaders['id'] = $iii++;
        $fileheaders['quantity'] = $iii++;
        $fileheaders['product_type'] = $iii++;
        $fileheaders['expiration_date'] = $iii++;
        $fileheaders['currency'] = $iii++;

        $filelayout_sql = "SELECT
            p.products_id as v_products_id,
            p.products_model as v_products_model,
            p.products_image as v_products_image,
            p.products_price as v_products_price,
            p.products_weight as v_products_weight,
            p.products_date_added as v_date_added,
            p.products_date_available as v_date_avail,
            p.products_tax_class_id as v_tax_class_id,
            p.products_quantity as v_products_quantity,
            p.manufacturers_id as v_manufacturers_id,
            subc.categories_id as v_categories_id
            FROM
            ".TABLE_PRODUCTS." as p,
            ".TABLE_CATEGORIES." as subc,
            ".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
            WHERE
            p.products_id = ptoc.products_id AND
            ptoc.categories_id = subc.categories_id
            " . $sql_filter;
        break;

    // VJ product attributes begin
    case 'attrib':
        $iii = 0;
        $filelayout = array();

        $filelayout['v_products_model'] = $iii++;

        $attribute_options_count = 1;
        foreach ($attribute_options_array as $tkey1 => $attribute_options_values) {
            $filelayout['v_attribute_options_id_'.$attribute_options_count] = $iii++;
            foreach ($languages as $tkey => $lang ) {
                $filelayout['v_attribute_options_name_'.$attribute_options_count.'_'.$lang['id']] = $iii++;
            }

            $attribute_values_query = "select products_options_values_id  from " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$attribute_options_values['products_options_id'] . "' order by products_options_values_id";
            $attribute_values_values = vam_db_query($attribute_values_query);

            $attribute_values_count = 1;
            while ($attribute_values = vam_db_fetch_array($attribute_values_values)) {
                $filelayout['v_attribute_values_id_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                foreach ($languages as $tkey2 => $lang ) {
                    $filelayout['v_attribute_values_name_'.$attribute_options_count.'_'.$attribute_values_count.'_'.$lang['id']] = $iii++;
                }
                $filelayout['v_attribute_values_price_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                $filelayout['v_attribute_values_model_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                $filelayout['v_attribute_values_stock_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                $filelayout['v_attribute_values_weight_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                $filelayout['v_attribute_values_sort_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                //// attributes stock add start        
                if ( EP_PRODUCTS_ATTRIBUTES_STOCK    == true ) { 
                    $header_array['v_attribute_values_stock_'.$attribute_options_count.'_'.$attribute_values_count] = $iii++;
                }                
                //// attributes stock add end         
                $attribute_values_count++;
            }
            $attribute_options_count++;
        }

        $filelayout_sql = "SELECT
                            p.products_id as v_products_id,
                            p.products_model as v_products_model
                            FROM
                            ".TABLE_PRODUCTS." as p
                            ";

        break;
        // VJ product attributes end
    }


    $filelayout_count = count($filelayout);

  return array($filelayout, $filelayout_count, $filelayout_sql, $fileheaders);

}






///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
// 
// process_row()
//
//   Processes one row of the import file
// 
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
function process_row( $item1, $filelayout, $filelayout_count, $default_these, $ep_separator, $languages, $custom_fields ) {

    // first we clean up the row of data
    if (EP_EXCEL_SAFE_OUTPUT == true) {
      $items = $item1;
    } else {
      // chop blanks from each end
      $item1 = ltrim(rtrim($item1));
    
      // blow it into an array, splitting on the tabs
      $items = explode($ep_separator, $item1);
    }

    // make sure all non-set things are set to '';
    // and strip the quotes from the start and end of the stings.
    // escape any special chars for the database.
    foreach( $filelayout as $key => $value){
        $i = $filelayout[$key];
        if (isset($items[$i]) == false) {
            $items[$i]='';
        } else {
            // Check to see if either of the magic_quotes are turned on or off;
            // And apply filtering accordingly.
            if (function_exists('ini_get')) {
                //echo "Getting ready to check magic quotes<br />";
                if (ini_get('magic_quotes_runtime') == 1){
                    // The magic_quotes_runtime are on, so lets account for them
                    // check if the first & last character are quotes;
                    // if it is, chop off the quotes.
                    if (substr($items[$i],-1) == '"' && substr($items[$i],0,1) == '"'){
                        $items[$i] = substr($items[$i],2,strlen($items[$i])-4);
                    }
                    // now any remaining doubled double quotes should be converted to one doublequote
                    if (EP_REPLACE_QUOTES == true){
                        if (EP_EXCEL_SAFE_OUTPUT == true) {
                          $items[$i] = str_replace('\"\"',"&#34;",$items[$i]);
                        }
                        $items[$i] = str_replace('\"',"&#34;",$items[$i]);
                        $items[$i] = str_replace("\'","&#39;",$items[$i]);
                    }
                } else { // no magic_quotes are on
                    // check if the last character is a quote;
                    // if it is, chop off the 1st and last character of the string.
                    if (substr($items[$i],-1) == '"' && substr($items[$i],0,1) == '"'){
                        $items[$i] = substr($items[$i],1,strlen($items[$i])-2);
                    }
                    // now any remaining doubled double quotes should be converted to one doublequote
                    if (EP_REPLACE_QUOTES == true){
                        if (EP_EXCEL_SAFE_OUTPUT == true) {
                          $items[$i] = str_replace('""',"&#34;",$items[$i]);
                        }
                        $items[$i] = str_replace('"',"&#34;",$items[$i]);
                        $items[$i] = str_replace("'","&#39;",$items[$i]);
                    }
                }
            }
        }
    }


    // /////////////////////////////////////////////////////////////
    // Do specific functions without processing entire range of vars
    // /////////////////////////////
    // first do product extra fields
    if (isset($items[$filelayout['v_products_extra_fields_id']]) ){    
    
        $v_products_model = $items[$filelayout['v_products_model']];
        // EP for product extra fields Contrib by minhmaster DEVSOFTVN ==========
        $v_products_extra_fields_id = $items[$filelayout['v_products_extra_fields_id']];
//        $v_products_id    =    $items[$filelayout['v_products_id']];
        $v_products_extra_fields_value    =    $items[$filelayout['v_products_extra_fields_value']];
        
        $sql = "SELECT p.products_id as v_products_id FROM ".TABLE_PRODUCTS." as p WHERE p.products_model = '" . $v_products_model . "'";
        $result = vam_db_query($sql);
        $row =  vam_db_fetch_array($result);

		$sql_exist	=	"SELECT products_extra_fields_value FROM ".TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS. " WHERE (products_id ='".$row['v_products_id']. "') AND (products_extra_fields_id ='".$v_products_extra_fields_id ."')";

		if (vam_db_num_rows(vam_db_query($sql_exist)) > 0) {
			$sql_extra_field	=	"UPDATE ".TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS." SET products_extra_fields_value='".$v_products_extra_fields_value."' WHERE (products_id ='". $row['v_products_id'] . "') AND (products_extra_fields_id ='".$v_products_extra_fields_id ."')";
			$str_err_report= " $v_products_extra_fields_id | $v_products_id  | $v_products_model | $v_products_extra_fields_value | <b><font color=black>".EASY_EXTRA_FIELD_UPDATED."</font></b><br />";
		} else {
			$sql_extra_field	=	"INSERT INTO ".TABLE_PRODUCTS_TO_PRODUCTS_EXTRA_FIELDS."(products_id,products_extra_fields_id,products_extra_fields_value) VALUES ('". $row['v_products_id'] ."','".$v_products_extra_fields_id."','".$v_products_extra_fields_value."')";
			$str_err_report= " $v_products_extra_fields_id | $v_products_id | $v_products_model | $v_products_extra_fields_value | <b><font color=green>".EASY_EXTRA_FIELD_ADDED."</font></b><br />";
		}

        $result = vam_db_query($sql_extra_field);
        
        echo $str_err_report;
        // end (EP for product extra fields Contrib by minhmt DEVSOFTVN) ============
        
    // /////////////////////
    // or do product deletes
    
    } elseif (isset($items[$filelayout['v_categories_id']]) ){    
    
        $v_categories_status = $items[$filelayout['v_categories_status']];
        $v_categories_id = $items[$filelayout['v_categories_id']];
        $v_categories_parent_id = $items[$filelayout['v_categories_parent_id']];
        $v_categories_url    =    $items[$filelayout['v_categories_url']];
        $v_categories_image    =    $items[$filelayout['v_categories_image']];
        $v_categories_icon    =    $items[$filelayout['v_categories_icon']];
        $v_categories_sort_order    =    $items[$filelayout['v_categories_sort_order']];
        $v_categories_yml_enable    =    $items[$filelayout['v_categories_yml_enable']];
        $v_categories_google_category_id    =    $items[$filelayout['v_categories_google_category_id']];
        $v_categories_label_id    =    $items[$filelayout['v_categories_label_id']];
        $v_categories_likes    =    $items[$filelayout['v_categories_likes']];
        $v_categories_dislikes    =    $items[$filelayout['v_categories_dislikes']];
        $v_categories_listing_template    =    $items[$filelayout['v_categories_listing_template']];
        $v_categories_products_sorting    =    $items[$filelayout['v_categories_products_sorting']];
        $v_categories_products_sorting2    =    $items[$filelayout['v_categories_products_sorting2']];

        $v_categories_name = $items[$filelayout['v_categories_name']];
        $v_categories_description    =    $items[$filelayout['v_categories_description']];
        $v_categories_heading_title    =    $items[$filelayout['v_categories_heading_title']];
        $v_categories_meta_title    =    $items[$filelayout['v_categories_meta_title']];
        $v_categories_meta_description    =    $items[$filelayout['v_categories_meta_description']];
        $v_categories_meta_keywords    =    $items[$filelayout['v_categories_meta_keywords']];

        $sql = "SELECT categories_id as v_categories_id FROM ".TABLE_CATEGORIES." WHERE categories_id = '" . $v_categories_id . "'";
        $result = vam_db_query($sql);
        $row =  vam_db_fetch_array($result);

		$sql_exist	=	"SELECT categories_id FROM ".TABLE_CATEGORIES. " WHERE categories_id ='".$row['v_categories_id']. "'";

		if (vam_db_num_rows(vam_db_query($sql_exist)) > 0) {
			
			$sql_categories_field	=	"UPDATE ".TABLE_CATEGORIES." SET 
			categories_status='".$v_categories_status."', 
			categories_url='".$v_categories_url."', 
			categories_image='".$v_categories_image."', 
			icon='".$v_categories_icon."', 
			sort_order='".$v_categories_sort_order."', 
			parent_id='".$v_categories_parent_id."', 
			yml_enable='".$v_categories_yml_enable."', 
			google_category_id='".$v_categories_google_category_id."', 
			label_id='".$v_categories_label_id."', 
			likes='".$v_categories_likes."', 
			dislikes='".$v_categories_dislikes."', 
			listing_template='".$v_categories_listing_template."', 
			products_sorting='".$v_categories_products_sorting."', 
			products_sorting2='".$v_categories_products_sorting2."' 

			WHERE categories_id ='".$v_categories_id ."'";

			$sql_categories_description_field	=	"UPDATE ".TABLE_CATEGORIES_DESCRIPTION." SET 
			categories_name='".$v_categories_name."', 
			categories_description='".$v_categories_description."', 
			categories_heading_title='".$v_categories_heading_title."', 
			categories_meta_title='".$v_categories_meta_title."', 
			categories_meta_description='".$v_categories_meta_description."', 
			categories_meta_keywords='".$v_categories_meta_keywords."' 
			WHERE categories_id ='".$v_categories_id ."'";
			
			$str_err_report= " $v_categories_id | $v_categories_name | <b><font color=black>".EASY_CATEGORIES_UPDATED."</font></b><br />";
		} else {
			$sql_categories_field	=	"INSERT INTO ".TABLE_CATEGORIES."
			(
			categories_id,
			categories_status,
			categories_url,
			categories_image,
			icon,
			sort_order,
			parent_id,
			yml_enable,
			google_category_id,
			label_id,
			likes,
			dislikes,
			listing_template,
			products_sorting,
			products_sorting2
			) 
			VALUES 
			(
			'".$v_categories_id."',
			'".$v_categories_status."',
			'".$v_categories_url."',
			'".$v_categories_image."',
			'".$v_categories_icon."',
			'".$v_categories_sort_order."',
			'".$v_categories_parent_id."',
			'".$v_categories_yml_enable."',
			'".$v_categories_google_category_id."',
			'".$v_categories_label_id."',
			'".$v_categories_likes."',
			'".$v_categories_dislikes."',
			'".$v_categories_listing_template."',
			'".$v_categories_products_sorting."',
			'".$v_categories_products_sorting2."'
			)";

			$sql_categories_description_field	=	"INSERT INTO ".TABLE_CATEGORIES_DESCRIPTION."
			(
			categories_id,
			categories_name,
			categories_description,
			categories_heading_title,
			categories_meta_title,
			categories_meta_description,
			categories_meta_keywords
			) 
			VALUES 
			(
			'".$v_categories_id."',
			'".$v_categories_name."',
			'".$v_categories_description."',
			'".$v_categories_heading_title."',
			'".$v_categories_meta_title."',
			'".$v_categories_meta_description."',
			'".$v_categories_meta_keywords."'
			);";
			$str_err_report= " $v_categories_id | $v_categories_name | <b><font color=green>".EASY_CATEGORIES_ADDED."</font></b><br />";
		}

        $result = vam_db_query($sql_categories_field);
        vam_db_query($sql_categories_description_field);
        
        echo $str_err_report;
        // end (EP for product extra fields Contrib by minhmt DEVSOFTVN) ============

    } elseif (isset($items[$filelayout['v_tags_id']]) ){    
    
        $v_tags_id = $items[$filelayout['v_tags_id']];
        $v_tags_name    =    $items[$filelayout['v_tags_name']];
        $v_tags_url    =    $items[$filelayout['v_tags_url']];
        $v_tags_title    =    $items[$filelayout['v_tags_title']];
        $v_tags_description    =    $items[$filelayout['v_tags_description']];
        $v_tags_mainpage    =    $items[$filelayout['v_tags_mainpage']];
        $v_tags_sort_order    =    $items[$filelayout['v_tags_sort_order']];
        $v_tags_status    =    $items[$filelayout['v_tags_status']];
        $v_tags_to_products    =    $items[$filelayout['v_tags_to_products']];
        $v_tags_to_categories    =    $items[$filelayout['v_tags_to_categories']];

			$px_models .= $v_tags_to_products;

			$row['v_tags_to_products'] = $px_models;

        $sql = "SELECT tags_id as v_tags_id FROM ".TABLE_TAGS." WHERE tags_id = '" . $v_tags_id . "'";
        $result = vam_db_query($sql);
        $row =  vam_db_fetch_array($result);

		$sql_exist	=	"SELECT tags_id FROM ".TABLE_TAGS. " WHERE tags_id ='".$row['v_tags_id']. "'";

		if (vam_db_num_rows(vam_db_query($sql_exist)) > 0) {
			
			$sql_tags_field	=	"UPDATE ".TABLE_TAGS." SET 
			tags_name='".$v_tags_name."', 
			tags_url='".$v_tags_url."', 
			tags_title='".$v_tags_title."', 
			tags_description='".$v_tags_description."', 
			tags_mainpage='".$v_tags_mainpage."', 
			sort_order='".$v_tags_sort_order."', 
			status='".$v_tags_status."' 

			WHERE tags_id ='".$v_tags_id ."'";

			$str_err_report= " $v_tags_id | $v_tags_name | <b><font color=black>".EASY_TAGS_UPDATED."</font></b><br />";
		} else {
			$sql_tags_field	=	"INSERT INTO ".TABLE_TAGS."
			(
			tags_id,
			tags_name,
			tags_url,
			tags_title,
			tags_description,
			tags_mainpage,
			sort_order,
			status
			) 
			VALUES 
			(
			'".$v_tags_id."',
			'".$v_tags_name."',
			'".$v_tags_url."',
			'".$v_tags_title."',
			'".$v_tags_description."',
			'".$v_tags_mainpage."',
			'".$v_tags_sort_order."',
			'".$v_tags_status."'
			)";

			$str_err_report= " $v_tags_id | $v_tags_name | <b><font color=green>".EASY_TAGS_ADDED."</font></b><br />";
		}

        $result = vam_db_query($sql_tags_field);

                if (isset($v_tags_to_products)){

                  if (!empty($v_tags_to_products)){
                    $products_array = explode(',',$v_tags_to_products);
                      foreach ($products_array as $product_key => $product_value ) {
                        vam_db_query("delete from ".TABLE_TAGS_TO_PRODUCTS." where products_id = " . $product_value . " and tags_id=".$v_tags_id."");
                        vam_db_query("insert into ".TABLE_TAGS_TO_PRODUCTS." (tags_id, products_id) 
                                      values ( ".$v_tags_id.", ".$product_value.")");
                    }
                  }
                  }

                if (isset($v_tags_to_categories)){

                  if (!empty($v_tags_to_categories)){
                    $categories_array = explode(',',$v_tags_to_categories);
                      foreach ($categories_array as $category_key => $category_value ) {
                        vam_db_query("delete from ".TABLE_TAGS_TO_CATEGORIES." where categories_id = " . $category_value . " and tags_id=".$v_tags_id."");
                        vam_db_query("insert into ".TABLE_TAGS_TO_CATEGORIES." (tags_id, categories_id) 
                                      values ( ".$v_tags_id.", ".$category_value.")");
                    }
                  }
                  }

        echo $str_err_report;
        // end (EP for product extra fields Contrib by minhmt DEVSOFTVN) ============
        
    // /////////////////////
    // or do product deletes
    } elseif ( $items[$filelayout['v_status']] == EP_DELETE_IT ) {
      // Get the ID
      $sql = "SELECT p.products_id as v_products_id    FROM ".TABLE_PRODUCTS." as p WHERE p.products_model = '" . $items[$filelayout['v_products_model']] . "'";
      $result = vam_db_query($sql);
      $row =  vam_db_fetch_array($result);
      if (vam_db_num_rows($result) == 1 ) {
        vam_db_query("delete from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $row['v_products_id'] . "'");

        $product_categories_query = vam_db_query("select count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " where products_id = '" . $row['v_products_id'] . "'");
        $product_categories = vam_db_fetch_array($product_categories_query);

        if ($product_categories['total'] == '0') {
          // gather product attribute data
          $result = vam_db_query("select pov.products_options_values_id from " . TABLE_PRODUCTS_ATTRIBUTES . " pa left join " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov on pa.options_values_id=pov.products_options_values_id where pa.products_id = '" . (int)$row['v_products_id'] . "'");
          $remove_attribs = array();
          while ($tmp_attrib = vam_db_fetch_array($result)) {
            $remove_attribs[] = $tmp_attrib;
          }

          // check each attribute name for links to other products
          foreach ($remove_attribs as $rakey => $ravalue) {
            $product_attribs_query = vam_db_query("select count(*) as total from " . TABLE_PRODUCTS_ATTRIBUTES . " where options_values_id = '" . (int)$ravalue['products_options_values_id'] . "'");
            $product_attribs = vam_db_fetch_array($product_attribs_query);
            // if no other products linked, remove attribute name
            if ((int)$product_attribs['total'] == 1) {
              vam_db_query("delete from " . TABLE_PRODUCTS_OPTIONS_VALUES. " where products_options_values_id = '" . (int)$ravalue['products_options_values_id'] . "'");
            }
          }
          // remove attribute records
          vam_db_query("delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$row['v_products_id'] . "'");

          // remove product
          vam_remove_product($row['v_products_id']);
        }

        if (USE_CACHE == 'true') {
          vam_reset_cache_block('categories');
          vam_reset_cache_block('also_purchased');
        }
        echo EASY_TEXT_DELETED . $items[$filelayout['v_products_model']] . EASY_TEXT_DELETED . "<br />";
        
      } else {
          echo EASY_TEXT_NOT_DELETE . $items['v_products_model'] . EASY_TEXT_NOT_DELETE . "<br> ";
      }
  
    // //////////////////////////////////
    // or do regular product processing
    // //////////////////////////////////
    } else {

        // /////////////////////////////////////////////////////////////////////
        //
        // Start: Support for other contributions in products table
        //
        // /////////////////////////////////////////////////////////////////////
        $ep_additional_select = '';
	
        if (EP_ADDITIONAL_IMAGES == true) {
          $ep_additional_select .= 'p.products_image_description as v_products_image_description,';
        }

        if (EP_MORE_PICS_6_SUPPORT == true) { 
          $ep_additional_select .= 'p.products_subimage1 as v_products_subimage1,p.products_subimage2 as v_products_subimage2,p.products_subimage3 as v_products_subimage3,p.products_subimage4 as v_products_subimage4,p.products_subimage5 as v_products_subimage5,p.products_subimage6 as v_products_subimage6,';
        }    

        if (EP_UNLIMITED_IMAGES == true) { 
          $ep_additional_select .= 'p.products_image_array as v_products_image_array,';
        }    

        if (EP_ULTRPICS_SUPPORT == true) { 
          $ep_additional_select .= 'products_image_med as v_products_image_med,products_image_lrg as v_products_image_lrg,products_image_sm_1 as v_products_image_sm_1,products_image_xl_1 as v_products_image_xl_1,products_image_sm_2 as v_products_image_sm_2,products_image_xl_2 as v_products_image_xl_2,products_image_sm_3 as v_products_image_sm_3,products_image_xl_3 as v_products_image_xl_3,products_image_sm_4 as v_products_image_sm_4,products_image_xl_4 as v_products_image_xl_4,products_image_sm_5 as v_products_image_sm_5,products_image_xl_5 as v_products_image_xl_5,products_image_sm_6 as v_products_image_sm_6,products_image_xl_6 as v_products_image_xl_6,';
        }
		
        if (EP_PDF_UPLOAD_SUPPORT == true) { 
          $ep_additional_select .='p.products_pdfupload as v_products_pdfupload, p.products_fileupload as v_products_fileupload,';
        }

        if (EP_MVS_SUPPORT == true) {
          $ep_additional_select .= 'vendors_id as v_vendor_id,';
        }

        foreach ($custom_fields[TABLE_PRODUCTS] as $key => $name) { 
          $ep_additional_select .= 'p.' . $key . ' as v_' . $key . ',';
        }

        // /////////////////////////////////////////////////////////////////////
        // End: Support for other contributions in products table
        // /////////////////////////////////////////////////////////////////////
    
    
        // now do a query to get the record's current contents
        $sql = "SELECT
                    p.products_id as v_products_id,
                    p.products_model as v_products_model,
                    p.products_image as v_products_image,
                    $ep_additional_select
                    p.products_price as v_products_price,
                    p.products_weight as v_products_weight,
                    p.products_date_available as v_date_avail,
                    p.products_date_added as v_date_added,
                    p.products_tax_class_id as v_tax_class_id,
                    p.products_quantity as v_products_quantity,
                    p.manufacturers_id as v_manufacturers_id,
                    subc.categories_id as v_categories_id,
                    p.products_status as v_status_current
                FROM
                    ".TABLE_PRODUCTS." as p,
                    ".TABLE_CATEGORIES." as subc,
                    ".TABLE_PRODUCTS_TO_CATEGORIES." as ptoc
                WHERE
                    p.products_model = '" . $items[$filelayout['v_products_model']] . "' AND
                    p.products_id = ptoc.products_id AND
                    ptoc.categories_id = subc.categories_id
                LIMIT 1
            ";

        $result = vam_db_query($sql);
        $row =  vam_db_fetch_array($result);

        // determine processing status based on dropdown choice on EP menu
		// Delete product included in normal & update options
        if ((sizeof($row) > 0) && ($_POST['imput_mode'] == "normal" || $_POST['imput_mode'] == "update")) {
            $process_product = true;
		// For Delete Only option (product exists) & (v_status = EP_DELETE_IT) & (Delete Only)
		} elseif ((sizeof($row) > 0) && ($items[$filelayout['v_status']] == EP_DELETE_IT) && ($_POST['imput_mode'] == "delete")) {
            $process_product = true;			
        } elseif ((sizeof($row) == 0) && ($_POST['imput_mode'] == "normal" || $_POST['imput_mode'] == "addnew")) {
            $process_product = true;
        } else {
            $process_product = false;
        }

        if ($process_product == true) {

            while ($row){
                // OK, since we got a row, the item already exists.
                // Let's get all the data we need and fill in all the fields that need to be defaulted 
                // to the current values for each language, get the description and set the vals
                foreach ($languages as $key => $lang){
                    // products_name, products_description, products_url
                    $sql2 = "SELECT * 
                            FROM ".TABLE_PRODUCTS_DESCRIPTION."
                            WHERE
                                products_id = " . $row['v_products_id'] . " AND
                                language_id = '" . $lang['id'] . "'
                            LIMIT 1
                            ";
                    $result2 = vam_db_query($sql2);
                    $row2 =  vam_db_fetch_array($result2);
                    // Need to report from ......_name_1 not ..._name_0
                    $row['v_products_name_' . $lang['id']]         = $row2['products_name'];
                    $row['v_products_description_' . $lang['id']]     = $row2['products_description'];
                    $row['v_products_url_' . $lang['id']]         = $row2['products_url'];
                    foreach ($custom_fields[TABLE_PRODUCTS_DESCRIPTION] as $key => $name) { 
                      $row['v_' . $key . '_' . $lang['id']]         = $row2[$key];
                    }
                    // header tags controller support
                    if(isset($filelayout['v_products_meta_title_' . $lang['id'] ])){
                        $row['v_products_meta_title_' . $lang['id']]     = $row2['products_meta_title'];
                        $row['v_products_meta_description_' . $lang['id']]     = $row2['products_meta_description'];
                        $row['v_products_meta_keywords_' . $lang['id']]     = $row2['products_meta_keywords'];
                    }
                    // end: header tags controller support
                }
        
                // start with v_categories_id
                // Get the category description
                // set the appropriate variable name
                // if parent_id is not null, then follow it up.
				$thecategory_id = $row['v_categories_id'];
				for( $categorylevel=1; $categorylevel<=(EP_MAX_CATEGORIES+1); $categorylevel++){
					if ($thecategory_id){
		
						$sql3 = "SELECT parent_id, 
						                categories_image
							     FROM ".TABLE_CATEGORIES."
							     WHERE    
								        categories_id = " . $thecategory_id . '';
						$result3 = vam_db_query($sql3);
						if ($row3 = vam_db_fetch_array($result3)) {
							$temprow['v_categories_image_' . $categorylevel] = $row3['categories_image'];
						}
		
						foreach ($languages as $key => $lang){
							$sql2 = "SELECT categories_name
								     FROM ".TABLE_CATEGORIES_DESCRIPTION."
								     WHERE    
									        categories_id = " . $thecategory_id . " AND
									        language_id = " . $lang['id'];
							$result2 = vam_db_query($sql2);
							if ($row2 =  vam_db_fetch_array($result2)) {
								$temprow['v_categories_name_' . $categorylevel . '_' . $lang['id']] = $row2['categories_name'];
							}
						}
		
						// now get the parent ID if there was one
						$theparent_id = $row3['parent_id'];
						if ($theparent_id != ''){
							// there was a parent ID, lets set thecategoryid to get the next level
							$thecategory_id = $theparent_id;
						} else {
							// we have found the top level category for this item,
							$thecategory_id = false;
						}
		 
					} else {
						$temprow['v_categories_image_' . $categorylevel] = '';
						foreach ($languages as $key => $lang){
							$temprow['v_categories_name_' . $categorylevel . '_' . $lang['id']] = '';
						}
					}
				}
                // temprow has the old style low to high level categories.
				$newlevel = 1;
				// let's turn them into high to low level categories
				for( $categorylevel=EP_MAX_CATEGORIES+1; $categorylevel>0; $categorylevel--){
					$found = false;
					if ($temprow['v_categories_image_' . $categorylevel] != ''){
						$row['v_categories_image_' . $newlevel] = $temprow['v_categories_image_' . $categorylevel];
						$found = true;
					}
					foreach ($languages as $key => $lang){
						if ($temprow['v_categories_name_' . $categorylevel . '_' . $lang['id']] != ''){
							$row['v_categories_name_' . $newlevel . '_' . $lang['id']] = $temprow['v_categories_name_' . $categorylevel . '_' . $lang['id']];
							$found = true;
						}
					}
					if ($found == true) {
						$newlevel++;
					}
				}


				// default the manufacturer        
                if ($row['v_manufacturers_id'] != ''){
                    $sql2 = "SELECT manufacturers_name
                        FROM ".TABLE_MANUFACTURERS."
                        WHERE manufacturers_id = " . $row['v_manufacturers_id']
                        ;
                    $result2 = vam_db_query($sql2);
                    $row2 =  vam_db_fetch_array($result2);
                    $row['v_manufacturers_name'] = $row2['manufacturers_name'];
                }

                if (EP_MVS_SUPPORT == true) {
                  $result2 = vam_db_query("select vendors_name from ".TABLE_VENDORS." WHERE vendors_id = " . $row['v_vendor_id']);
                  $row2 =  vam_db_fetch_array($result2);		
                  $row['v_vendor'] = $row2['vendors_name'];
                }

                //elari -
                //We check the value of tax class and title instead of the id
                //Then we add the tax to price if EP_PRICE_WITH_TAX is set to true
                $row_tax_multiplier = vam_get_tax_class_rate($row['v_tax_class_id']);
                $row['v_tax_class_title'] = vam_get_tax_class_title($row['v_tax_class_id']);
                if (EP_PRICE_WITH_TAX == true){
                    $row['v_products_price'] = $row['v_products_price'] + round(($row['v_products_price'] * $row_tax_multiplier / 100), EP_PRECISION);
                }
                // now create the internal variables that will be used
                // the $$thisvar is on purpose: it creates a variable named what ever was in $thisvar and sets the value
                foreach ($default_these as $tkey => $thisvar){
                    $$thisvar = $row[$thisvar];
                }
        
                $row =  vam_db_fetch_array($result);
            }
        
            // this is an important loop.  What it does is go thru all the fields in the incoming 
            // file and set the internal vars. Internal vars not set here are either set in the 
            // loop above for existing records, or not set at all (null values) the array values 
            // are handled separatly, although they will set variables in this loop, we won't use them.
            foreach( $filelayout as $key => $value ){
                if (!($key == 'v_date_added' && empty($items[ $value ]))) {
                     $$key = $items[ $value ];
                }
            }
        
            //elari... we get the tax_clas_id from the tax_title
            //on screen will still be displayed the tax_class_title instead of the id....
            if ( isset( $v_tax_class_title) ){
                $v_tax_class_id          = vam_get_tax_title_class_id($v_tax_class_title);
            }
            //we check the tax rate of this tax_class_id
                $row_tax_multiplier = vam_get_tax_class_rate($v_tax_class_id);
        
            //And we recalculate price without the included tax...
            //Since it seems display is made before, the displayed price will still include tax
            //This is same problem for the tax_clas_id that display tax_class_title
            if (EP_PRICE_WITH_TAX == true){
                $v_products_price = round( $v_products_price / (1 + ($row_tax_multiplier * .01)), EP_PRECISION);
            }
        
            // if they give us one category, they give us all categories. convert data structure to a multi-dim array
            unset ($v_categories_name); // default to not set.
            unset ($v_categories_image); // default to not set.
			foreach ($languages as $key => $lang){
			  $baselang_id = $lang['id'];
			  break;
			}
            if ( isset( $filelayout['v_categories_name_1_' . $baselang_id] ) ){
				$v_categories_name = array();
				$v_categories_image = array();
                $newlevel = 1;
                for( $categorylevel=EP_MAX_CATEGORIES; $categorylevel>0; $categorylevel--){
					$found = false;
					if ($items[$filelayout['v_categories_image_' . $categorylevel]] != '') {
					  $v_categories_image[$newlevel] = $items[$filelayout['v_categories_image_' . $categorylevel]];
					  $found = true;
					}
					foreach ($languages as $key => $lang){
						if ( $items[$filelayout['v_categories_name_' . $categorylevel . '_' . $lang['id']]] != ''){
							$v_categories_name[$newlevel][$lang['id']] = $items[$filelayout['v_categories_name_' . $categorylevel . '_' . $lang['id']]];
							$found = true;
						}
                    }
					if ($found == true) {
					  $newlevel++;
					}
                }
                while( $newlevel < EP_MAX_CATEGORIES+1){
                    $v_categories_image[$newlevel] = ''; // default the remaining items to nothing
					foreach ($languages as $key => $lang){
                      $v_categories_name[$newlevel][$lang['id']] = ''; // default the remaining items to nothing
					}
                    $newlevel++;
                }
            }
        
            if (ltrim(rtrim($v_products_quantity)) == '') {
                $v_products_quantity = 1;
            }
        
            if (empty($v_date_avail)) {
                $v_date_avail = 'NULL';
            } else {
                $v_date_avail = "'" . date("Y-m-d H:i:s",strtotime($v_date_avail)) . "'";
            }
        
            if (empty($v_date_added)) {
                $v_date_added = "'" . date("Y-m-d H:i:s") . "'";
            } else {
                $v_date_added = "'" . date("Y-m-d H:i:s",strtotime($v_date_added)) . "'";
            }
        
            // default the stock if they spec'd it or if it's blank
            if (isset($v_status_current)){
              $v_db_status = strval($v_status_current); // default to current value
            } else {
              $v_db_status = '1'; // default to active
            }
            if (trim($v_status) == EP_TEXT_INACTIVE){
                // they told us to deactivate this item
                $v_db_status = '0';
            } elseif (trim($v_status) == EP_TEXT_ACTIVE) {
                $v_db_status = '1';
            }    
        
            if (EP_INACTIVATE_ZERO_QUANTITIES == true && $v_products_quantity == 0) {
                // if they said that zero qty products should be deactivated, let's deactivate if the qty is zero
                $v_db_status = '0';
            }
        
            if ($v_manufacturer_id==''){
                $v_manufacturer_id="NULL";
            }
        
            if (trim($v_products_image)==''){
                $v_products_image = EP_DEFAULT_IMAGE_PRODUCT;
            } else {
                if (USE_EP_IMAGE_MANIPULATOR == 'true') { prepare_image($v_products_image); } else { $v_products_image; }
            }
        
            if (strlen($v_products_model) > EP_MODEL_NUMBER_SIZE ){
                echo EASY_ERROR_2.EP_MODEL_NUMBER_SIZE."<br />".EASY_ERROR_2A;
                die();
            }
        
        
            // OK, we need to convert the manufacturer's name into id's for the database
            if ( isset($v_manufacturers_name) && $v_manufacturers_name != '' ){
                $sql = "SELECT man.manufacturers_id
                    FROM ".TABLE_MANUFACTURERS." as man
                    WHERE man.manufacturers_name = '" . vam_db_input($v_manufacturers_name) . "'";
                $result = vam_db_query($sql);
                $row =  vam_db_fetch_array($result);
                if ( $row != '' ){
                    foreach( $row as $item ){
                        $v_manufacturer_id = $item;
                    }
                } else {
                    // to add, we need to put stuff in categories and categories_description
                    $sql = "SELECT MAX( manufacturers_id) max FROM ".TABLE_MANUFACTURERS;
                    $result = vam_db_query($sql);
                    $row =  vam_db_fetch_array($result);
                    $max_mfg_id = $row['max']+1;
                    // default the id if there are no manufacturers yet
                    if (!is_numeric($max_mfg_id) ){
                        $max_mfg_id=1;
                    }
        
                    // Uncomment this query if you have an older 2.2 codebase
                    /*
                    $sql = "INSERT INTO ".TABLE_MANUFACTURERS."(
                        manufacturers_id,
                        manufacturers_image
                        ) VALUES (
                        $max_mfg_id,
                        '".EP_DEFAULT_IMAGE_MANUFACTURER."'
                        )";
                    */
        
                    // Comment this query out if you have an older 2.2 codebase
                    $sql = "INSERT INTO ".TABLE_MANUFACTURERS."(
                        manufacturers_id,
                        manufacturers_name,
                        manufacturers_image,
                        date_added,
                        last_modified
                        ) VALUES (
                        $max_mfg_id,
                        '".vam_db_input($v_manufacturers_name)."',
                        '".EP_DEFAULT_IMAGE_MANUFACTURER."',
                        '".date("Y-m-d H:i:s")."',
                        '".date("Y-m-d H:i:s")."'
                        )";
                    $result = vam_db_query($sql);
                    $v_manufacturer_id = $max_mfg_id;
        
                    $sql = "INSERT INTO ".TABLE_MANUFACTURERS_INFO."(
                        manufacturers_id,
                        manufacturers_meta_title,
                        manufacturers_meta_description,
                        manufacturers_meta_keywords,
                        manufacturers_url,
                        manufacturers_description,
                        languages_id
                        ) VALUES (
                        $max_mfg_id,
                        '',
                        '',
                        '',
                        '',
                        '',
                        '".EP_DEFAULT_LANGUAGE_ID."'
                        )";
                    $result = vam_db_query($sql);
                }
            }
            
            // if the categories names are set then try to update them
			foreach ($languages as $key => $lang){
			  $baselang_id = $lang['id'];
			  break;
			}
            if ( isset( $filelayout['v_categories_name_1_' . $baselang_id] ) ){
                // start from the highest possible category and work our way down from the parent
                $v_categories_id = 0;
                $theparent_id = 0;
                for ( $categorylevel=EP_MAX_CATEGORIES+1; $categorylevel>0; $categorylevel-- ){
				  //foreach ($languages as $key => $lang){
                    $thiscategoryname = $v_categories_name[$categorylevel][$baselang_id];
                    if ( $thiscategoryname != ''){
                        // we found a category name in this field, look for database entry
                        $sql = "SELECT cat.categories_id
                            FROM ".TABLE_CATEGORIES." as cat, 
                                 ".TABLE_CATEGORIES_DESCRIPTION." as des
                            WHERE
                                cat.categories_id = des.categories_id AND
                                des.language_id = " . $baselang_id . " AND
                                cat.parent_id = " . $theparent_id . " AND
                                des.categories_name like '" . vam_db_input($thiscategoryname) . "'";
                        $result = vam_db_query($sql);
                        $row =  vam_db_fetch_array($result);

                        if ( $row != '' ){
                            // we have an existing category, update image and date
							foreach( $row as $item ){
                                $thiscategoryid = $item;
                            }
							$cat_image = '';
							if (!empty($v_categories_image[$categorylevel])) {
							   $cat_image = "categories_image='".vam_db_input($v_categories_image[$categorylevel])."', ";
							} elseif (isset($filelayout['v_categories_image_' . $categorylevel])) {
							   $cat_image = "categories_image='', ";
							} 
                            $query = "UPDATE ".TABLE_CATEGORIES."
                                      SET 
                                        $cat_image
                                        last_modified = '".date("Y-m-d H:i:s")."'
                                      WHERE 
                                        categories_id = '".$row['categories_id']."'
                                      LIMIT 1";
                
                            vam_db_query($query);
                        } else {
                            // to add, we need to put stuff in categories and categories_description
                            $sql = "SELECT MAX( categories_id) max FROM ".TABLE_CATEGORIES;
                            $result = vam_db_query($sql);
                            $row =  vam_db_fetch_array($result);
                            $max_category_id = $row['max']+1;
                            if (!is_numeric($max_category_id) ){
                                $max_category_id=1;
                            }
                            $sql = "INSERT INTO ".TABLE_CATEGORIES." (
                                        categories_id,
                                        parent_id,
                                        categories_image,
                                        sort_order,
                                        date_added,
                                        last_modified
                                   ) VALUES (
                                        $max_category_id,
                                        $theparent_id,
                                        '".vam_db_input($v_categories_image[$categorylevel])."',
                                        0,
                                        '".date("Y-m-d H:i:s")."',
                                        '".date("Y-m-d H:i:s")."'
                                   )";
                            $result = vam_db_query($sql);
                            
                            foreach ($languages as $key => $lang){
                                $sql = "INSERT INTO ".TABLE_CATEGORIES_DESCRIPTION." (
                                                categories_id,
                                                language_id,
                                                categories_name
                                       ) VALUES (
                                                $max_category_id,
                                                '".$lang['id']."',
                                                '".(!empty($v_categories_name[$categorylevel][$lang['id']])?vam_db_input($v_categories_name[$categorylevel][$lang['id']]):'')."'
                                       )";
                                vam_db_query($sql);
                            }
                            
                            $thiscategoryid = $max_category_id;
                        }
                        // the current catid is the next level's parent
                        $theparent_id = $thiscategoryid;
                        $v_categories_id = $thiscategoryid; // keep setting this, we need the lowest level category ID later
                    }
				 // }
                }
            }

              
            if ($v_products_model != "") {
                //   products_model exists!
                foreach ($items as $tkey => $item) {
                  print_el($item);
                }
        
                // find the vendor id from the name imported
                if (EP_MVS_SUPPORT == true) {
                  $vend_result = vam_db_query("SELECT vendors_id FROM ".TABLE_VENDORS." WHERE vendors_name = '". $v_vendor . "'");
                  $vend_row = vam_db_fetch_array($vend_result);
                  $v_vendor_id = $vend_row['vendors_id'];
                }

                // process the PRODUCTS table
                $result = vam_db_query("SELECT products_id FROM ".TABLE_PRODUCTS." WHERE (products_model = '". $v_products_model . "')");
        
                // First we check to see if this is a product in the current db.
                if (vam_db_num_rows($result) == 0)  {
                
                    //   insert into products
                    echo EASY_LABEL_NEW_PRODUCT;
        
                    // /////////////////////////////////////////////////////////////////////
                    //
                    // Start: Support for other contributions
                    //
                    // /////////////////////////////////////////////////////////////////////
                    $ep_additional_fields = '';
                    $ep_additional_data = '';

                    if (EP_ADDITIONAL_IMAGES == true) { 
                      $ep_additional_fields .= 'products_image_description,';
                      $ep_additional_data .= "'".vam_db_input($v_products_image_description)."',";
                    } 
			
                    foreach ($custom_fields[TABLE_PRODUCTS] as $key => $name) { 
                      $ep_additional_fields .= $key . ',';
                    }

                    foreach ($custom_fields[TABLE_PRODUCTS] as $key => $name) { 
                      $tmp_var = 'v_' . $key;
                      $ep_additional_data .= "'" . $$tmp_var . "',";
                    }

                    if (EP_MORE_PICS_6_SUPPORT == true) { 
                      $ep_additional_fields .= 'products_subimage1,products_subimage2,products_subimage3,products_subimage4,products_subimage5,products_subimage6,';
                      $ep_additional_data .= "'$v_products_subimage1','$v_products_subimage2','$v_products_subimage3','$v_products_subimage4','$v_products_subimage5','$v_products_subimage6',";
                    }    

                    if (EP_UNLIMITED_IMAGES == true) { 
                      $ep_additional_fields .= 'products_image_array,';
                      $ep_additional_data .= "'".serialize(explode("|", $v_products_image_array))."',";
                    }    
        
                    if (EP_ULTRPICS_SUPPORT == true) { 
                      $ep_additional_fields .= 'products_image_med,products_image_lrg,products_image_sm_1,products_image_xl_1,products_image_sm_2,products_image_xl_2,products_image_sm_3,products_image_xl_3,products_image_sm_4,products_image_xl_4,products_image_sm_5,products_image_xl_5,products_image_sm_6,products_image_xl_6,';
                      $ep_additional_data .= "'$v_products_image_med','$v_products_image_lrg','$v_products_image_sm_1','$v_products_image_xl_1','$v_products_image_sm_2','$v_products_image_xl_2','$v_products_image_sm_3','$v_products_image_xl_3','$v_products_image_sm_4','$v_products_image_xl_4','$v_products_image_sm_5','$v_products_image_xl_5','$v_products_image_sm_6','$v_products_image_xl_6',";
                    }
					
                    if (EP_PDF_UPLOAD_SUPPORT == true) { 
                      $ep_additional_fields .= 'products_pdfupload,products_fileupload,';
                      $ep_additional_data .= "'$v_products_pdfupload','$v_products_fileupload',";
                    }
					
                    if (EP_MVS_SUPPORT == true) {
                      $ep_additional_fields .= 'vendors_id,';
                      $ep_additional_data .= "'$v_vendor_id',";
                    }
			
                    // /////////////////////////////////////////////////////////////////////
                    // End: Support for other contributions
                    // /////////////////////////////////////////////////////////////////////
                    
                    $query = "INSERT INTO ".TABLE_PRODUCTS." (
                                products_image,
                                $ep_additional_fields
                                products_model,
                                products_price,
                                products_status,
                                products_last_modified,
                                products_date_added,
                                products_date_available,
                                products_tax_class_id,
                                products_weight,
                                products_quantity,
                                manufacturers_id )
                              VALUES (
                                ".(!empty($v_products_image)?"'".$v_products_image."'":'NULL').",
                                $ep_additional_data
                                '$v_products_model',
                                '$v_products_price',
                                '$v_db_status',
                                '".date("Y-m-d H:i:s")."',
                                ".$v_date_added.",
                                ".$v_date_avail.",
                                '$v_tax_class_id',
                                '$v_products_weight',
                                '$v_products_quantity',
                                ".(!empty($v_manufacturer_id)?$v_manufacturer_id:'NULL').")
                                ";
                    $result = vam_db_query($query);
                    
                    $v_products_id = vam_db_insert_id();
        
                } else {
        
                  // existing product(s), get the id from the query
                  // and update the product data
                  while ($row = vam_db_fetch_array($result)) {
        
                    $v_products_id = $row['products_id'];
                    echo EASY_LABEL_UPDATED;
                    
                    // /////////////////////////////////////////////////////////////////////
                    //
                    // Start: Support for other contributions
                    //
                    // /////////////////////////////////////////////////////////////////////
                    $ep_additional_updates = '';

                    foreach ($custom_fields[TABLE_PRODUCTS] as $key => $name) { 
                      $tmp_var = 'v_' . $key;
                      $ep_additional_updates .= $key . "='" . $$tmp_var . "',";
                    }

                    if (EP_ADDITIONAL_IMAGES == true && isset($v_products_image_description)) { 
                      $ep_additional_updates .= "products_image_description='".vam_db_input($v_products_image_description)."',";
                    } 

                    if (EP_MORE_PICS_6_SUPPORT == true) { 
                      $ep_additional_updates .= "products_subimage1='$v_products_subimage1',products_subimage2='$v_products_subimage2',products_subimage3='$v_products_subimage3',products_subimage4='$v_products_subimage4',products_subimage5='$v_products_subimage5',products_subimage6='$v_products_subimage6',";
                    }    

                    if (EP_UNLIMITED_IMAGES == true) { 
                      $ep_additional_updates .= "products_image_array='".serialize(explode("|", $v_products_image_array))."',";
                    }    

                    if (EP_ULTRPICS_SUPPORT == true) { 
                      $ep_additional_updates .= "products_image_med='$v_products_image_med',products_image_lrg='$v_products_image_lrg',products_image_sm_1='$v_products_image_sm_1',products_image_xl_1='$v_products_image_xl_1',products_image_sm_2='$v_products_image_sm_2',products_image_xl_2='$v_products_image_xl_2',products_image_sm_3='$v_products_image_sm_3',products_image_xl_3='$v_products_image_xl_3',products_image_sm_4='$v_products_image_sm_4',products_image_xl_4='$v_products_image_xl_4',products_image_sm_5='$v_products_image_sm_5',products_image_xl_5='$v_products_image_xl_5',products_image_sm_6='$v_products_image_sm_6',products_image_xl_6='$v_products_image_xl_6',";
                    }
					
                    if (EP_PDF_UPLOAD_SUPPORT == true) { 					
                      $ep_additional_updates .= "products_pdfupload='$v_products_pdfupload',products_fileupload='$v_products_fileupload',";
                    }
					
                    if (EP_MVS_SUPPORT == true) {
                      $ep_additional_updates .= "vendors_id='$v_vendor_id',";
                    }
			
                    // /////////////////////////////////////////////////////////////////////
                    // End: Support for other contributions
                    // /////////////////////////////////////////////////////////////////////
                    // only include the products image if it has been included in the spreadsheet
                    $tmp_products_image_update = '';
                    if (isset($v_products_image)) {
                      $tmp_products_image_update = "products_image=".(!empty($v_products_image)?"'".$v_products_image."'":'NULL').", 
										    ";
                      if (EP_ADDITIONAL_IMAGES == true && isset($filelayout['v_products_image'])) { 
                        $tmp_products_image_update .= "products_image_med=NULL, 
                                                     products_image_pop=NULL, ";
                      }
                    }
			
                    $query = "UPDATE ".TABLE_PRODUCTS."
                              SET
                                products_price='$v_products_price', 
                                $tmp_products_image_update 
                                $ep_additional_updates
                                products_weight='$v_products_weight', 
                                products_tax_class_id='$v_tax_class_id', 
                                products_date_available=".$v_date_avail.", 
                                products_date_added=".$v_date_added.", 
                                products_last_modified='".date("Y-m-d H:i:s")."', 
                                products_quantity = $v_products_quantity, 
                                manufacturers_id = ".(!empty($v_manufacturer_id)?$v_manufacturer_id:'NULL').", 
                                products_status = $v_db_status
                              WHERE
                                (products_id = $v_products_id)
                              LIMIT 1";
        
                    vam_db_query($query);
                  }
                }
		
		  if (isset($v_products_specials_price)) {
		      if (EP_SPPC_SUPPORT == true) { $SPPC_extra_query = ' and customers_group_id = 0'; } else { $SPPC_extra_query = ''; }
			  $result = vam_db_query('select * from '.TABLE_SPECIALS.' WHERE products_id = ' . $v_products_id . $SPPC_extra_query );

			  if ($v_products_specials_price == '') {
			  
				  $result = vam_db_query('DELETE FROM '.TABLE_SPECIALS.' WHERE products_id = ' . $v_products_id . $SPPC_extra_query );
			      if (EP_SPPC_SUPPORT == true) { 
				    $result = vam_db_query('DELETE FROM specials_retail_prices WHERE products_id = ' . $v_products_id );
			      }

			  } else {
				  if ($specials = vam_db_fetch_array($result)) {
					  $sql_data_array = array('products_id' => $v_products_id,
											  'specials_quantity' => 10000,
											  'specials_new_products_price' => $v_products_specials_price,
											  'specials_last_modified' => 'now()'
					  );
					  vam_db_perform(TABLE_SPECIALS, $sql_data_array, 'update', 'specials_id = '.$specials['specials_id']);
					  
			          if (EP_SPPC_SUPPORT == true) { 
					    $sql_data_array = array('products_id' => $v_products_id,
											    'specials_new_products_price' => $v_products_specials_price
					    );
					    vam_db_perform('specials_retail_prices', $sql_data_array, 'update', 'products_id = '.$v_products_id);
				      }
				  } else {
					  $sql_data_array = array('products_id' => $v_products_id,
											  'specials_quantity' => 10000,
											  'specials_new_products_price' => $v_products_specials_price,
											  'specials_date_added' => 'now()',
											  'status' => '1'
					  );
		              if (EP_SPPC_SUPPORT == true) { $sql_data_array = array_merge($sql_data_array,array('customers_group_id' => '0')); }
					  vam_db_perform(TABLE_SPECIALS, $sql_data_array, 'insert');
					  
			          if (EP_SPPC_SUPPORT == true) { 
					    $sql_data_array = array('products_id' => $v_products_id,
											    'specials_new_products_price' => $v_products_specials_price,
											    'status' => '1',
											    'customers_group_id' => '0'
					    );
					    vam_db_perform('specials_retail_prices', $sql_data_array, 'insert');
				      }
				  }
			  }
          }
			
        
			if (EP_ADDITIONAL_IMAGES == true) { 
			  if (isset($filelayout['v_products_image_2'])) {
				  vam_db_query("delete from " . TABLE_ADDITIONAL_IMAGES . " where products_id = '" . (int)$v_products_id . "'");
				  for ($i=2;$i<=EP_ADDITIONAL_IMAGES_MAX+1;$i++) {
					$ai_description_var = 'v_products_image_description_'.$i;
					$ai_image_var = 'v_products_image_'.$i;
					if (!empty($$ai_image_var) || !empty($$ai_description_var)) {
					  vam_db_query("insert into " . TABLE_ADDITIONAL_IMAGES . " (products_id, images_description, thumb_images) values ('" . (int)$v_products_id . "', '" . vam_db_input($$ai_description_var) . "', '" . vam_db_input($$ai_image_var) . "')");
					}
				  }
			  }
			}
                // process the PRODUCTS_DESCRIPTION table
                foreach ($languages as $tkey => $lang){

                    $doit = false;
                    foreach ($custom_fields[TABLE_PRODUCTS_DESCRIPTION] as $key => $name) { 
                      if (isset($filelayout['v_' . $key . '_'.$lang['id']])) { $doit = true; }
                    }

                    if ( isset($filelayout['v_products_name_'.$lang['id']]) || isset($filelayout['v_products_description_'.$lang['id']]) || isset($filelayout['v_products_url_'.$lang['id']]) || isset($filelayout['v_products_meta_title_'.$lang['id']]) || $doit == true ) {
        
                        $sql = "SELECT * FROM ".TABLE_PRODUCTS_DESCRIPTION." WHERE
                                products_id = $v_products_id AND
                                language_id = " . $lang['id'];
                        $result = vam_db_query($sql);
        
                        $products_var = 'v_products_name_'.$lang['id'];
                        $description_var = 'v_products_description_'.$lang['id'];
                        $url_var = 'v_products_url_'.$lang['id'];

                        // /////////////////////////////////////////////////////////////////////
                        //
                        // Start: Support for other contributions
                        //
                        // /////////////////////////////////////////////////////////////////////
                        $ep_additional_updates = '';
                        $ep_additional_fields = '';
                        $ep_additional_data = '';

                        foreach ($custom_fields[TABLE_PRODUCTS_DESCRIPTION] as $key => $name) { 
                          $tmp_var = 'v_' . $key . '_' . $lang['id'];
                          $ep_additional_updates .= $key . " = '" . vam_db_input($$tmp_var) ."',";
                          $ep_additional_fields .= $key . ",";
                          $ep_additional_data .= "'". vam_db_input($$tmp_var) . "',";
                        }

                        // header tags controller support
                        if (isset($filelayout['v_products_meta_title_'.$lang['id']])){
                          $meta_title_var = 'v_products_meta_title_'.$lang['id'];
                          $meta_description_var = 'v_products_meta_description_'.$lang['id'];
                          $meta_keywords_var = 'v_products_meta_keywords_'.$lang['id'];
        
                          $ep_additional_updates .= "products_meta_title = '" . vam_db_input($$meta_title_var) ."', products_meta_description = '" . vam_db_input($$meta_description_var) ."', products_meta_keywords = '" . vam_db_input($$meta_keywords_var) ."',";
                          $ep_additional_fields .= "products_meta_title,products_meta_description,products_meta_keywords,";
                          $ep_additional_data .= "'". vam_db_input($$meta_title_var) . "','". vam_db_input($$meta_description_var) . "','". vam_db_input($$meta_keywords_var) . "',";
                        }
                        // end: header tags controller support
                        
                        // /////////////////////////////////////////////////////////////////////
                        // End: Support for other contributions
                        // /////////////////////////////////////////////////////////////////////
        
                        
                        // existing product?
                        if (vam_db_num_rows($result) > 0) {
                            // already in the description, let's just update it
                            $sql =
                                "UPDATE ".TABLE_PRODUCTS_DESCRIPTION." 
                                 SET
                                    products_name='" . vam_db_input($$products_var) . "',
                                    products_description='" . vam_db_input($$description_var) . "',
                                    $ep_additional_updates
                                    products_url='" . $$url_var . "'
                                 WHERE
                                    products_id = '$v_products_id' AND
                                    language_id = '".$lang['id']."'
                                 LIMIT 1";
                            $result = vam_db_query($sql);
        
                        } else {
        
                            // nope, this is a new product description
                            $result = vam_db_query($sql);
                            $sql =
                                "INSERT INTO ".TABLE_PRODUCTS_DESCRIPTION."
                                    ( products_id,
                                      language_id,
                                      products_name,
                                      products_description,
                                      $ep_additional_fields
                                      products_url
                                    )
                                 VALUES (
                                        '" . $v_products_id . "',
                                        " . $lang['id'] . ",
                                        '". vam_db_input($$products_var) . "',
                                        '". vam_db_input($$description_var) . "',
                                        $ep_additional_data
                                        '". $$url_var . "'
                                        )";
                            $result = vam_db_query($sql);
                        }
                    }
                }
        
        
        
                if (isset($v_categories_id)){
                    //find out if this product is listed in the category given
                    $result_incategory = vam_db_query('SELECT
                                '.TABLE_PRODUCTS_TO_CATEGORIES.'.products_id,
                                '.TABLE_PRODUCTS_TO_CATEGORIES.'.categories_id
                                FROM
                                    '.TABLE_PRODUCTS_TO_CATEGORIES.'
                                WHERE
                                '.TABLE_PRODUCTS_TO_CATEGORIES.'.products_id='.$v_products_id.' AND
                                '.TABLE_PRODUCTS_TO_CATEGORIES.'.categories_id='.$v_categories_id);
        
                    if (vam_db_num_rows($result_incategory) == 0) {
                        // nope, this is a new category for this product
                        $res1 = vam_db_query('INSERT INTO '.TABLE_PRODUCTS_TO_CATEGORIES.' (products_id, categories_id)
                                              VALUES ("' . $v_products_id . '", "' . $v_categories_id . '")');
                    } else {
                        // already in this category, nothing to do!
                    }
                }
        
                // this is for the cross sell contribution
                if (isset($v_cross_sell)){
                  vam_db_query("delete from ".TABLE_PRODUCTS_XSELL." where products_id = " . $v_products_id . " or xsell_id = " . $v_products_id . "");
                  if (!empty($v_cross_sell)){
                    $xsells_array = explode(',',$v_cross_sell);
                    //echo var_dump($xsells_array);
                    //exit;
                      foreach ($xsells_array as $xs_key => $xs_model ) {
                        $cross_sell_sql = "select products_id from ".TABLE_PRODUCTS." where products_model = '" . trim($xs_model) . "' limit 1";
                        $cross_sell_result = vam_db_query($cross_sell_sql);
                        $cross_sell_row = vam_db_fetch_array($cross_sell_result);
                        
                        vam_db_query("insert into ".TABLE_PRODUCTS_XSELL." (products_id, xsell_id, sort_order) values ( ".$v_products_id.", ".$cross_sell_row['products_id'].", 1)");
                        //vam_db_query("insert into ".TABLE_PRODUCTS_XSELL." (products_id, xsell_id, sort_order) values ( ".$cross_sell_row['products_id'].", ".$v_products_id.", 1)");
                    }
                  }
		}

                // for the separate prices per customer (SPPC) module
                $ll=1;
                if (isset($v_customer_price_1)){
                    
                    if (($v_customer_group_id_1 == '') AND ($v_customer_price_1 != ''))  {
                        echo "<font color=red>ERROR - v_customer_group_id and v_customer_price must occur in pairs</font>";
                        die();
                    }
                    // they spec'd some prices, so clear all existing entries
                    $result = vam_db_query('
                                DELETE
                                FROM
                                    '.TABLE_PRODUCTS_GROUPS.'
                                WHERE
                                    products_id = ' . $v_products_id
                                );
                    // and insert the new record
                    if ($v_customer_price_1 != ''){
                        $result = vam_db_query('
                                    INSERT INTO
                                        '.TABLE_PRODUCTS_GROUPS.'
                                    VALUES
                                    (
                                        ' . $v_customer_group_id_1 . ',
                                        ' . $v_customer_price_1 . ',
                                        ' . $v_products_id . '
                                        )'
                                    );
                    }
                    if ($v_customer_price_2 != ''){
                        $result = vam_db_query('
                                    INSERT INTO
                                        '.TABLE_PRODUCTS_GROUPS.'
                                    VALUES
                                    (
                                        ' . $v_customer_group_id_2 . ',
                                        ' . $v_customer_price_2 . ',
                                        ' . $v_products_id . '
                                        )'
                                    );
                    }
                    if ($v_customer_price_3 != ''){
                        $result = vam_db_query('
                                    INSERT INTO
                                        '.TABLE_PRODUCTS_GROUPS.'
                                    VALUES
                                    (
                                        ' . $v_customer_group_id_3 . ',
                                        ' . $v_customer_price_3 . ',
                                        ' . $v_products_id . '
                                        )'
                                    );
                    }
                    if ($v_customer_price_4 != ''){
                        $result = vam_db_query('
                                    INSERT INTO
                                        '.TABLE_PRODUCTS_GROUPS.'
                                    VALUES
                                    (
                                        ' . $v_customer_group_id_4 . ',
                                        ' . $v_customer_price_4 . ',
                                        ' . $v_products_id . '
                                        )'
                                    );
                    }

                    if (isset($v_customer_specials_price_1)) {
                    $result = vam_db_query('select * from '.TABLE_SPECIALS.' WHERE products_id = ' . $v_products_id . ' and customers_group_id = 1' );

                      if ($v_customer_specials_price_1 == '') {
			  
                        $result = vam_db_query('DELETE FROM '.TABLE_SPECIALS.' WHERE products_id = ' . $v_products_id . ' and customers_group_id = 1' );

                      } else {
                        if ($specials = vam_db_fetch_array($result)) {
					  $sql_data_array = array('products_id' => $v_products_id,
											  'specials_new_products_price' => $v_customer_specials_price_1,
											  'specials_last_modified' => 'now()'
					  );
					  vam_db_perform(TABLE_SPECIALS, $sql_data_array, 'update', 'specials_id = '.$specials['specials_id']);
                        } else {
					  $sql_data_array = array('products_id' => $v_products_id,
											  'specials_new_products_price' => $v_customer_specials_price_1,
											  'specials_date_added' => 'now()',
											  'status' => '1',
											  'customers_group_id' => '1'
					  );
					  vam_db_perform(TABLE_SPECIALS, $sql_data_array, 'insert');
                        }
                      }
                    }
			
                }
                // end: separate prices per customer (SPPC) module
        
        
                // VJ product attribs begin
                if (isset($v_attribute_options_id_1)){
                    $attribute_rows = 1; // master row count
        
                    // product options count
                    $attribute_options_count = 1;
                    $v_attribute_options_id_var = 'v_attribute_options_id_' . $attribute_options_count;
        
                    while (isset($$v_attribute_options_id_var) && !empty($$v_attribute_options_id_var)) {
                        // remove product attribute options linked to this product before proceeding further
                        // this is useful for removing attributes linked to a product
                        $attributes_clean_query = "delete from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$v_products_id . "' and options_id = '" . (int)$$v_attribute_options_id_var . "'";
        
                        vam_db_query($attributes_clean_query);
        
                        $attribute_options_query = "select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$$v_attribute_options_id_var . "'";
        
                        $attribute_options_values = vam_db_query($attribute_options_query);
        
                        // option table update begin
                        if ($attribute_rows == 1) {
                            // insert into options table if no option exists
                            if (vam_db_num_rows($attribute_options_values) <= 0) {
                                for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
                                    $lid = $languages[$i]['id'];
        
                                  $v_attribute_options_name_var = 'v_attribute_options_name_' . $attribute_options_count . '_' . $lid;
        
                                    if (isset($$v_attribute_options_name_var)) {
                                        $attribute_options_insert_query = "insert into " . TABLE_PRODUCTS_OPTIONS . " (products_options_id, language_id, products_options_name) values ('" . (int)$$v_attribute_options_id_var . "', '" . (int)$lid . "', '" . $$v_attribute_options_name_var . "')";
        
                                        $attribute_options_insert = vam_db_query($attribute_options_insert_query);
                                    }
                                }
                            } else { // update options table, if options already exists
                                for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
                                    $lid = $languages[$i]['id'];
        
                                    $v_attribute_options_name_var = 'v_attribute_options_name_' . $attribute_options_count . '_' . $lid;
        
                                    if (isset($$v_attribute_options_name_var)) {
                                        $attribute_options_update_lang_query = "select products_options_name from " . TABLE_PRODUCTS_OPTIONS . " where products_options_id = '" . (int)$$v_attribute_options_id_var . "' and language_id ='" . (int)$lid . "'";
        
                                        $attribute_options_update_lang_values = vam_db_query($attribute_options_update_lang_query);
        
                                        // if option name doesn't exist for particular language, insert value
                                        if (vam_db_num_rows($attribute_options_update_lang_values) <= 0) {
                                            $attribute_options_lang_insert_query = "insert into " . TABLE_PRODUCTS_OPTIONS . " (products_options_id, language_id, products_options_name) values ('" . (int)$$v_attribute_options_id_var . "', '" . (int)$lid . "', '" . $$v_attribute_options_name_var . "')";
        
                                            $attribute_options_lang_insert = vam_db_query($attribute_options_lang_insert_query);
                                        } else { // if option name exists for particular language, update table
                                            $attribute_options_update_query = "update " . TABLE_PRODUCTS_OPTIONS . " set products_options_name = '" . $$v_attribute_options_name_var . "' where products_options_id ='" . (int)$$v_attribute_options_id_var . "' and language_id = '" . (int)$lid . "'";
        
                                            $attribute_options_update = vam_db_query($attribute_options_update_query);
                                        }
                                    }
                                }
                            }
                        }
                        // option table update end
        
                        // product option values count
                        $attribute_values_count = 1;
                        $v_attribute_values_id_var = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;
        
                        while (isset($$v_attribute_values_id_var) && !empty($$v_attribute_values_id_var)) {
                            $attribute_values_query = "select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$$v_attribute_values_id_var . "'";
        
                            $attribute_values_values = vam_db_query($attribute_values_query);
        
                            // options_values table update begin
                            if ($attribute_rows == 1) {
                                // insert into options_values table if no option exists
                                if (vam_db_num_rows($attribute_values_values) <= 0) {
                                    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
                                        $lid = $languages[$i]['id'];
        
                                        $v_attribute_values_name_var = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $lid;
        
                                        if (isset($$v_attribute_values_name_var)) {
                                            $attribute_values_insert_query = "insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name) values ('" . (int)$$v_attribute_values_id_var . "', '" . (int)$lid . "', '" . vam_db_input($$v_attribute_values_name_var) . "')";
        
                                            $attribute_values_insert = vam_db_query($attribute_values_insert_query);
                                        }
                                    }
        
        
                                    // insert values to pov2po table
                                    $attribute_values_pov2po_query = "insert into " . TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS . " (products_options_id, products_options_values_id) values ('" . (int)$$v_attribute_options_id_var . "', '" . (int)$$v_attribute_values_id_var . "')";
        
                                    $attribute_values_pov2po = vam_db_query($attribute_values_pov2po_query);
                                } else { // update options table, if options already exists
                                    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
                                        $lid = $languages[$i]['id'];
        
                                        $v_attribute_values_name_var = 'v_attribute_values_name_' . $attribute_options_count . '_' . $attribute_values_count . '_' . $lid;
        
                                        if (isset($$v_attribute_values_name_var)) {
                                            $attribute_values_update_lang_query = "select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$$v_attribute_values_id_var . "' and language_id ='" . (int)$lid . "'";
        
                                            $attribute_values_update_lang_values = vam_db_query($attribute_values_update_lang_query);
        
                                            // if options_values name doesn't exist for particular language, insert value
                                            if (vam_db_num_rows($attribute_values_update_lang_values) <= 0) {
                                                $attribute_values_lang_insert_query = "insert into " . TABLE_PRODUCTS_OPTIONS_VALUES . " (products_options_values_id, language_id, products_options_values_name) values ('" . (int)$$v_attribute_values_id_var . "', '" . (int)$lid . "', '" . vam_db_input($$v_attribute_values_name_var) . "')";
        
                                                $attribute_values_lang_insert = vam_db_query($attribute_values_lang_insert_query);
                                            } else { // if options_values name exists for particular language, update table
                                                $attribute_values_update_query = "update " . TABLE_PRODUCTS_OPTIONS_VALUES . " set products_options_values_name = '" . vam_db_input($$v_attribute_values_name_var) . "' where products_options_values_id ='" . (int)$$v_attribute_values_id_var . "' and language_id = '" . (int)$lid . "'";
        
                                                $attribute_values_update = vam_db_query($attribute_values_update_query);
                                            }
                                        }
                                    }
                                }
                            }
                            // options_values table update end
        
                            // options_values price update begin
                          $v_attribute_values_price_var = 'v_attribute_values_price_' . $attribute_options_count . '_' . $attribute_values_count;
                          $v_attribute_values_model = 'v_attribute_values_model_' . $attribute_options_count . '_' . $attribute_values_count;
                          $v_attribute_values_stock = 'v_attribute_values_stock_' . $attribute_options_count . '_' . $attribute_values_count;
                          $v_attribute_values_weight = 'v_attribute_values_weight_' . $attribute_options_count . '_' . $attribute_values_count;
                          $v_attribute_values_sort = 'v_attribute_values_sort_' . $attribute_options_count . '_' . $attribute_values_count;
        
                            if (isset($$v_attribute_values_price_var) && ($$v_attribute_values_price_var != '')) {
                                $attribute_prices_query = "select options_values_price, price_prefix, attributes_model, attributes_stock, options_values_weight, weight_prefix, sortorder from " . TABLE_PRODUCTS_ATTRIBUTES . " where products_id = '" . (int)$v_products_id . "' and options_id ='" . (int)$$v_attribute_options_id_var . "' and options_values_id = '" . (int)$$v_attribute_values_id_var . "'";
        
                                $attribute_prices_values = vam_db_query($attribute_prices_query);
        
                                $attribute_values_price_prefix = ($$v_attribute_values_price_var < 0) ? '-' : '+';

                                $attribute_values_weight_prefix = ($$v_attribute_values_weight < 0) ? '-' : '+';

                                // if negative, remove the negative sign for storing since the prefix is stored in another field.
                                if ( $$v_attribute_values_price_var < 0 ) $$v_attribute_values_price_var = strval(-((float)$$v_attribute_values_price_var));
        
                                // options_values_prices table update begin
                                // insert into options_values_prices table if no price exists
                                if (vam_db_num_rows($attribute_prices_values) <= 0) {
                                    $attribute_prices_insert_query = "insert into " . TABLE_PRODUCTS_ATTRIBUTES . " (products_id, options_id, options_values_id, options_values_price, price_prefix, attributes_model, attributes_stock, options_values_weight, weight_prefix, sortorder) values ('" . (int)$v_products_id . "', '" . (int)$$v_attribute_options_id_var . "', '" . (int)$$v_attribute_values_id_var . "', '" . (float)$$v_attribute_values_price_var . "', '" . $attribute_values_price_prefix . "', '" . $$v_attribute_values_model . "', '" . $$v_attribute_values_stock . "', '" . (float)$$v_attribute_values_weight . "', '" . $$v_attribute_values_weight_prefix . "', '" . $$v_attribute_values_sort . "')";
        
                                    $attribute_prices_insert = vam_db_query($attribute_prices_insert_query);
                                } else { // update options table, if options already exists
                                    $attribute_prices_update_query = "update " . TABLE_PRODUCTS_ATTRIBUTES . " set options_values_price = '" . $$v_attribute_values_price_var . "', price_prefix = '" . $attribute_values_price_prefix . "', set attributes_model = '" . $$v_attribute_values_model . "', set attributes_stock = '" . $$v_attribute_values_stock . "', set options_values_weight = '" . $$v_attribute_values_weight . "', set weight_prefix = '" . $$v_attribute_values_weight_prefix . "', set sortorder = '" . $$v_attribute_values_sort . "' where products_id = '" . (int)$v_products_id . "' and options_id = '" . (int)$$v_attribute_options_id_var . "' and options_values_id ='" . (int)$$v_attribute_values_id_var . "'";
        
                                    $attribute_prices_update = vam_db_query($attribute_prices_update_query);
                                }
                            }
                            // options_values price update end
                            
                            $attribute_values_count++;
                            $v_attribute_values_id_var = 'v_attribute_values_id_' . $attribute_options_count . '_' . $attribute_values_count;
                        }
        
                        $attribute_options_count++;
                        $v_attribute_options_id_var = 'v_attribute_options_id_' . $attribute_options_count;
                    }
        
                    $attribute_rows++;
                }
                // VJ product attribs end
        
// BOF mo_image
		for ($i = 0; $i < MO_PICS; $i++) {
			if(isset($filelayout['v_mo_image_'.($i+1)])) {
//				echo '<pre>';var_dump($items[$filelayout['v_mo_image_'.($i+1)]]);echo '</pre>';
				if($items[$filelayout['v_mo_image_'.($i+1)]] != "") {
					$items[$filelayout['v_mo_image_'.($i+1)]];
      		if (USE_EP_IMAGE_MANIPULATOR == 'true') { prepare_image($items[$filelayout['v_mo_image_'.($i+1)]]); } else { $items[$filelayout['v_mo_image_'.($i+1)]]; }
				}
				$check_query = vam_db_query("select image_id, image_name from " . TABLE_PRODUCTS_IMAGES . " where products_id='" . (int)$v_products_id . "' and image_nr='" . ($i+1) . "'");
				if (vam_db_num_rows($check_query) <= 0) {
					if($items[$filelayout['v_mo_image_'.($i+1)]] != "") {
						vam_db_query("insert into " . TABLE_PRODUCTS_IMAGES . " (products_id, image_nr, image_name) values ('" . (int)$v_products_id . "', '" . ($i+1) . "', '" . $items[$filelayout['v_mo_image_'.($i+1)]] . "')");
					}
				} else {
					$check = vam_db_fetch_array($check_query);
					if($items[$filelayout['v_mo_image_'.($i+1)]] == "") {
						vam_db_query("delete from " . TABLE_PRODUCTS_IMAGES . " where image_id='" . $check['image_id'] . "'");
					} elseif ($items[$filelayout['v_mo_image_'.($i+1)]] != $check['image_name']) {
						vam_db_query("update " . TABLE_PRODUCTS_IMAGES . " set image_name='" . $items[$filelayout['v_mo_image_'.($i+1)]] . "' where image_id='" . $check['image_id'] . "'");
					}
				}
			}
		}
// EOF mo_image        
        
            } else {
                // this record was missing the product_model
                echo "<p class=smallText>".EASY_LABEL_TEXT_NO_MODEL;
                foreach ($items as $tkey => $item) {
                  print_el($item);
                }
                echo "<br /><br /></p>";
            }
            // end of row insertion code
            
        }

    // EP for product extra fields Contrib by minhmaster DEVSOFTVN ==========
    }
    // end (EP for product extra fields Contrib by minhmt DEVSOFTVN) ============

}

require(DIR_WS_INCLUDES . 'application_bottom.php'); 
?>
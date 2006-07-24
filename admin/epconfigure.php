<?php


/*
  $Id: epconfigure.php,v 1.0 2004/09/23 teo $
*/

//
//*******************************
//*******************************
// C O N F I G U R A T I O N
// V A R I A B L E S
//*******************************
//*******************************

// **** Temp directory ****
// if you changed your directory structure from stock and do not have /catalog/temp/, then you'll need to change this accordingly.
//
$tempdir = "tmp/";
$tempdir2 = "/tmp/";

//**** File Splitting Configuration ****
// we attempt to set the timeout limit longer for this script to avoid having to split the files
// NOTE:  If your server is running in safe mode, this setting cannot override the timeout set in php.ini
// uncomment this if you are not on a safe mode server and you are getting timeouts
// set_time_limit(330);

// if you are splitting files, this will set the maximum number of records to put in each file.
// if you set your php.ini to a long time, you can make this number bigger
global $maxrecs;
$maxrecs = 300; // default, seems to work for most people.  Reduce if you hit timeouts
//$maxrecs = 4; // for testing

//**** Image Defaulting ****
global $default_images, $default_image_manufacturer, $default_image_product, $default_image_category;

// set them to your own default "We don't have any picture" gif
//$default_image_manufacturer = 'no_image_manufacturer.gif';
//$default_image_product = 'no_image_product.gif';
//$default_image_category = 'no_image_category.gif';

// or let them get set to nothing
$default_image_manufacturer = '';
$default_image_product = '';
$default_image_category = '';

//**** Status Field Setting ****
// Set the v_status field to "Inactive" if you want the status=0 in the system
// Set the v_status field to "Delete" if you want to remove the item from the system <- THIS IS NOT WORKING YET!
// If zero_qty_inactive is true, then items with zero qty will automatically be inactive in the store.
global $active, $inactive, $zero_qty_inactive, $deleteit;
$active = 'Active';
$inactive = 'Inactive';
//$deleteit = 'Delete'; // not functional yet
$zero_qty_inactive = false;

//**** Size of products_model in products table ****
// set this to the size of your model number field in the db.  We check to make sure all models are no longer than this value.
// this prevents the database from getting fubared.  Just making this number bigger won't help your database!  They must match!
global $modelsize;
$modelsize = 25;

//**** Price includes tax? ****
// Set the v_price_with_tax to
// 0 if you want the price without the tax included
// 1 if you want the price to be defined for import & export including tax.
global $price_with_tax;
$price_with_tax = false;

// **** Quote -> Escape character conversion ****
// If you have extensive html in your descriptions and it's getting mangled on upload, turn this off
// set to 1 = replace quotes with escape characters
// set to 0 = no quote replacement
global $replace_quotes;
$replace_quotes = true;

// **** Field Separator ****
// change this if you can't use the default of tabs
// Tab is the default, comma and semicolon are commonly supported by various progs
// Remember, if your descriptions contain this character, you will confuse EP!
global $separator;
$separator = "\t"; // tab is default
//$separator = ","; // comma
//$separator = ";"; // semi-colon
//$separator = "~"; // tilde
//$separator = "-"; // dash
//$separator = "*"; // splat

// **** Max Category Levels ****
// change this if you need more or fewer categories
global $max_categories;
$max_categories = 7; // 7 is default

// VJ product attributes begin
// **** Product Attributes ****
// change this to false, if do not want to download product attributes
global $products_with_attributes;
$products_with_attributes = true;

// change this if you want to download selected product options
// this might be handy, if you have a lot of product options, and your output file exceeds 256 columns (which is the max. limit MS Excel is able to handle)
global $attribute_options_select;
//$attribute_options_select = array('Size', 'Model'); // uncomment and fill with product options name you wish to download // comment this line, if you wish to download all product options
// VJ product attributes end


// ****************************************
// Froogle configuration variables
// -- YOU MUST CONFIGURE THIS!  IT WON'T WORK OUT OF THE BOX!
// ****************************************

// **** Froogle product info page path ****
// We can't use the tep functions to create the link, because the links will point to the admin, since that's where we're at.
// So put the entire path to your product_info.php page here
global $froogle_product_info_path;
$froogle_product_info_path =  HTTP_SERVER . DIR_WS_CATALOG . "product_info.php";

// **** Froogle product image path ****
// Set this to the path to your images directory
global $froogle_image_path;
$froogle_image_path =   HTTP_SERVER . DIR_WS_CATALOG . "images/";

// **** Froogle - search engine friendly setting
// if your store has SEARCH ENGINE FRIENDLY URLS set, then turn this to true
// I did it this way because I'm having trouble with the code seeing the constants
// that are defined in other places.
global $froogle_SEF_urls;
$froogle_SEF_urls = true;


// ****************************************
// End Froogle configuration variables
// ****************************************

//*******************************
//*******************************
// E N D
// C O N F I G U R A T I O N
// V A R I A B L E S
//*******************************
//*******************************


?>

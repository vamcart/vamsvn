<?php
/* -----------------------------------------------------------------------------------------
   categories2.php 2013-04-07

   VaM Shop
   Author: Mironov Andrey (Skype: xenlil)
   
   Version: 1

   -----------------------------------------------------------------------------------------

   Бокс со списком категорий с использованием всплывающего CSS-меню

   ---------------------------------------------------------------------------------------*/

require_once (DIR_FS_INC.'vam_has_category_subcategories.inc.php');
require_once (DIR_FS_INC.'vam_count_products_in_category.inc.php');

$box = new vamTemplate;
global $cPath;
$split_cPath_array = array();
if ( $cPath ) $split_cPath_array = preg_split( '/_/', $cPath );
$categories_string2 = '';


function vam_category2_get_category_products( $cat_id )
{

    global $categories_string2;

    $products_query = "select p.products_id, pd.products_name from ".TABLE_PRODUCTS." as p "
    . "left join ".TABLE_PRODUCTS_DESCRIPTION." as pd on (p.products_id = pd.products_id) "
    . "left join ".TABLE_PRODUCTS_TO_CATEGORIES." as ptc on (p.products_id = ptc.products_id) "
    . "where ptc.categories_id = '".$cat_id."' and p.products_status = '1' and pd.language_id='" . (int)$_SESSION[ 'languages_id' ] . "' "
    . "order by p.products_sort";

    $products_query = vamDBquery( $products_query );

    while ( $products = vam_db_fetch_array( $products_query, true ) )
    {
        $p_url = vam_product_link( $products[ 'products_id' ], $products[ 'products_name' ] );
        $p_url = vam_href_link( FILENAME_PRODUCT_INFO, $p_url );

        $categories_string2 .= '<li class="categorie_product"><a href="' . $p_url . '">' . $products[ 'products_name' ] . '</a></li>';

    };  // while ( $products = vam_db_fetch_array( $products_query, true ) )

    
}  // function vam_category2_get_category_products( $cat_id )


function vam_category2_get_subcategory( $owner_cat_id, $owner_cat_name = '', $owner_cat_image = '', $current_cPath = '', $level = 0 )
{

    global $categories_string2;
    
    $cPath_new = vam_category_link( $owner_cat_id, $owner_cat_name );
    $cPath_new_url = vam_href_link( FILENAME_DEFAULT, $cPath_new );
    

    if ( $owner_cat_id )
    {
        $products_count_string = '';
        if (SHOW_COUNTS == 'true')
        {
            require_once ( DIR_FS_INC . 'vam_count_products_in_category.inc.php' );
            $products_in_category = vam_count_products_in_category( $owner_cat_id );
            if ( $products_in_category > 0 )
            {
                $products_count_string .= '&nbsp;(' . $products_in_category . ')';
            };
        };

        $categories_string2 .= '<li'.((vam_has_category_subcategories($owner_cat_id)) ? " class=\"dropdown\" " : "").'><a'.((vam_has_category_subcategories($owner_cat_id)) ? " class=\"dropdown-item dropdown-toggle\" data-bs-toggle=\"dropdown\" " : " class=\"dropdown-item\" ").'href="' . $cPath_new_url . '">' . $owner_cat_name . $products_count_string . '</a>'."\n";

    };  // if ( $owner_cat_id )

    $group_check = '';
    if ( GROUP_CHECK == 'true' )
    {
        $group_check = "and c.group_permission_" . $_SESSION[ 'customers_status' ][ 'customers_status_id' ] . "=1 "; 
    };

    $categories_query = "select c.categories_id,
                       cd.categories_name,
                       c.categories_image,
                       c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                       where c.categories_status = '1'
                       and c.parent_id = '" . (int)$owner_cat_id . "'
                       " . $group_check . "
                       and c.categories_id = cd.categories_id
                       and cd.language_id='" . (int)$_SESSION[ 'languages_id' ] . "'
                       order by sort_order, cd.categories_name";

    $categories_query = vamDBquery( $categories_query );
    
    $categories_current_level = array();

    while ( $categories = vam_db_fetch_array( $categories_query, true ) )
    {
        $categories_current_level[ $categories[ 'categories_id' ] ] = array (
            'id' => $categories[ 'categories_id' ],
            'name' => $categories[ 'categories_name' ],
            'image' => $categories[ 'categories_image' ],
            'parent' => $categories[ 'parent_id' ],
            'path' => ( $current_cPath ? $current_cPath . '_' . $categories[ 'categories_id' ] : $categories[ 'categories_id' ] ),
            'level' => substr_count($current_cPath,'_')
        );

    };  // while ( $categories = vam_db_fetch_array( $categories_query, true ) )

    if ( $categories_current_level )
    {
        if ( $owner_cat_id ) $categories_string2 .= '<ul class="dropdown-menu">';
        
        $level = 0;

        foreach ( $categories_current_level as $v )
        {
        	$level++;
            vam_category2_get_subcategory(
                $v[ 'id' ],
                $v[ 'name' ],
                $v[ 'image' ],
                $v[ 'path' ],
                substr_count($current_cPath,'_')
            );
            
        };

// Uncomment this for output products in CSS menu
//        vam_category2_get_category_products( $owner_cat_id );

        if ( $owner_cat_id ) $categories_string2 .= '</ul>';

    }  // if ( $categories_current_level )

// Uncomment this for output products in CSS menu
//    else {
//        if ( $owner_cat_id ) $categories_string2 .= '<ul>';
//        vam_category2_get_category_products( $owner_cat_id );
//        if ( $owner_cat_id ) $categories_string2 .= '</ul>';
//    }  // if ( $categories_current_level )
    ;
    

    if ( $owner_cat_id ) $categories_string2 .= '</li>';
    
}  // function vam_category2_get_subcategory( ... )



$box->assign( 'language', $_SESSION[ 'language' ] );

// set cache ID
if ( !CacheCheck() )
{
	$cache = false;
	$box->caching = 0;
} else {
	$cache = true;
	$box->caching = 1;
	$box->cache_lifetime = CACHE_LIFETIME;
	$box->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION[ 'language' ] . $_SESSION[ 'customers_status' ][ 'customers_status_id' ] . $current_category_id;
};

if( !$box->isCached( CURRENT_TEMPLATE . '/boxes/box_categories2.html', $cache_id ) || !$cache )
{

  $box->assign('tpl_path', 'templates/' . CURRENT_TEMPLATE . '/');

  // include needed functions
//  require_once ( DIR_FS_INC . 'vam_has_category_subcategories.inc.php' );

  vam_category2_get_subcategory( 0 );
  
  //echo var_dump($categories_string2); 


$box->assign( 'BOX_CONTENT', '<ul class="dropdown-menu">' . $categories_string2 . '</ul>' );

};  // if( !$box->isCached( CURRENT_TEMPLATE . '/boxes/box_categories2.html', $cache_id ) || !$cache )

// set cache ID
if ( !$cache )
{
	$box_categories2 = $box->fetch( CURRENT_TEMPLATE . '/boxes/box_categories2.html' );
} else {
	$box_categories2 = $box->fetch( CURRENT_TEMPLATE . '/boxes/box_categories2.html', $cache_id );
};

$vamTemplate->assign( 'box_CATEGORIES2', $box_categories2 );
?>
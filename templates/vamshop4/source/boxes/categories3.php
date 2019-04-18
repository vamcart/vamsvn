<?php
/* -----------------------------------------------------------------------------------------
   $Id: categories.php 1302 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (categories.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (categories.php,v 1.10 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
// reset var
$start = microtime();
$box = new vamTemplate;
$box_content = '';

$box->assign('language', $_SESSION['language']);
// set cache ID
if (!CacheCheck()) {
	$cache=false;
	$box->caching = 0;
} else {
	$cache=true;
	$box->caching = 1;
	$box->cache_lifetime = CACHE_LIFETIME;
	$box->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'].$cPath;
}

if(!$box->isCached(CURRENT_TEMPLATE.'/boxes/box_categories.html', $cache_id) || !$cache){

$box->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

  function vam_get_category_tree($parent_id = '0', $spacing = '', $exclude = '', $category_tree_array = '', $include_itself = true) {
    global $languages_id;

    if (!is_array($category_tree_array)) $category_tree_array = array();
    if ( (sizeof($category_tree_array) < 1) && ($exclude != '0') ) $category_tree_array[] = array('id' => '0', 'text' => PULL_DOWN_DEFAULT);

    if ($include_itself) {
      $category_query = vam_db_query("select cd.categories_name from " . TABLE_CATEGORIES_DESCRIPTION . " cd where cd.language_id = '" . (int)$_SESSION['languages_id'] . "' and cd.categories_id = '" . (int)$parent_id . "'");
      $category = vam_db_fetch_array($category_query);
      $category_tree_array[] = array(
      
      'id' => $parent_id, 
      'parent' => null, 
      'text' => $category['categories_name']
      
      );
    }

if (GROUP_CHECK == 'true') {
	$group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}

    $categories_query = vam_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_status = '1' and c.categories_id = cd.categories_id ".$group_check." and cd.language_id = '" . (int)$_SESSION['languages_id'] . "' and c.parent_id = '" . (int)$parent_id . "' order by c.sort_order, cd.categories_name");
    while ($categories = vam_db_fetch_array($categories_query)) {
      if ($exclude != $categories['categories_id']) $category_tree_array[] = array(
      
      'id' => $categories['categories_id'], 
      'parent' => $categories['parent_id'], 
      'text' => $spacing . $categories['categories_name']
      
      );
      
      $category_tree_array = vam_get_category_tree($categories['categories_id'], $spacing . '&nbsp;', $exclude, $category_tree_array);
    }

    return $category_tree_array;
  }

$box->assign('BOX_CONTENT', vam_draw_form('goto', FILENAME_DEFAULT, 'get', '') . vam_draw_categories_menu('cat', vam_get_category_tree(), $current_category_id, 'onChange="this.form.submit();"') . '</form>');

}

// set cache ID
if (!$cache) {
	$box_categories = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_categories3.html');
} else {
	$box_categories = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_categories3.html', $cache_id);
}

$vamTemplate->assign('box_CATEGORIES3', $box_categories);





  function vam_draw_categories_menu($name, $values, $default = '', $parameters = '', $required = false) {
    //$field = '<select name="' . vam_parse_input_field_data($name, array('"' => '&quot;')) . '"';

    //if (vam_not_null($parameters)) $field .= ' ' . $parameters;

    //$field .= '>';

    if (empty($default) && isset($GLOBALS[$name])) $default = $GLOBALS[$name];

// Start Products Specifications
    foreach ($values as $link_data) {
      switch (true) {
        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'none'):
          break;
        
        case ($link_data['count'] != '' && $link_data['count'] < 1 && SPECIFICATIONS_FILTER_NO_RESULT == 'grey'):
          $field .= '<optgroup class="no_results" label="';
          $field .= vam_output_string ($link_data['text'] );
          if (SPECIFICATIONS_FILTER_SHOW_COUNT == 'True' && $link_data['count'] != '') {
            $field .= ' (' . $link_data['count'] . ')';
          }
          $field .= '"></optgroup>';
          break;
        
        default:
          //$field .= '<option value="' . vam_output_string ($link_data['id']) . '"';
          //if (in_array ($link_data['id'], (array) $default) ) {
            //$field .= ' SELECTED';
          //}

          //$field .= '>' . vam_output_string ($link_data['text'], array (
            //'"' => '&quot;',
            //'\'' => '&#039;',
            //'<' => '&lt;',
            //'>' => '&gt;'
          //));
            
          //if (SPECIFICATIONS_FILTER_SHOW_COUNT == 'True' && $link_data['count'] != '') {
            //$field .= '<span class="filter_count"> (' . $link_data['count'] . ')</span>';
          //}
          //$field .= '</option>';

          $field .= $link_data['id'] . '-' . vam_output_string($link_data['text']).'<br />'."\n";
          
          
          break;
      } // switch (true)
    } // foreach ($values
// End Products Specifications

    //$field .= '</select>';

    if ($required == true) $field .= TEXT_FIELD_REQUIRED;

    return $field;
  }
  
  
//echo vam_draw_categories_tree();  
  
//vam_draw_categories_tree

  function vam_draw_categories_tree($drawExpanded=true,$root_id = 0,$mainUlClass='',$submenuUlClass='submenu'){
    global $cPath_array;
        
    //GET ALL CATEGORIES
    $categories_query = vam_db_query("select c.categories_id, cd.categories_name, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_status = '1' and c.categories_id = cd.categories_id and cd.language_id='" . (int)$_SESSION['languages_id'] ."' order by sort_order, cd.categories_name");
    
    $items = array();
    
    while ($categories = vam_db_fetch_array($categories_query))  {
        $items[$categories['categories_id']] = array('name' => $categories['categories_name'], 'parent_id' => $categories['parent_id'], 'id' => $categories['categories_id']);
    }
    
    $citems=count($items);
    
    if($citems<=0) return '';
    elseif($citems==1) $children[] = $items; //in case we have one category item without subcategories, rare but possible
    else foreach( $items as $item ) $children[$item['parent_id']][] = $item;
        
		// loop will be false if the root has no children (i.e., an empty categories!)
		$loop = !empty( $children[$root_id] );

		$parent = $root_id;
		$parent_stack = array();
    $html=array();//store html code
		$stack=array();//helper array so to know the current level
    
    $pic=''; //products_in_category string
    
		$html[]='<ul class="'.$mainUlClass.'">';
		while ( $loop && ( ( $option = each( $children[$parent] ) ) || ( $parent > $root_id ) ) ){

			if ( $option === false ){

				$parent = array_pop( $parent_stack );
				
				$html[] = str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 ) . '</ul>';
				$html[] = str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 - 1 ) . '</li>';
				
				array_pop( $stack );
				
			}elseif ( !empty( $children[$option['value']['id']] ) ){
			
				$tab = str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 - 1 );
				$stack[]=$option['value']['id'];
				
  				$rt=$root_id>0 ? $root_id.'_' : '';

	  			$cpath_new=count($stack)<=0 ? 'cPath='.$rt.$option['value']['id'] : 'cPath='.$rt.implode('_',$stack);        
                    
          $html[]=$tab.'<li><a href="'.vam_href_link(FILENAME_DEFAULT, $cpath_new).'">';
        
          if (SHOW_COUNTS == 'true') { //THIS SHOULD BE CHANGED SO NOT TO USE vam_count_products_in_category WHICH IS RECURSIVE
            $products_in_category = vam_count_products_in_category($option['value']['id']);
            if ($products_in_category > 0) {
              $pic=' (' . $products_in_category . ')';
            }
          }
          
          $sm=0;        
          
          if((isset($cPath_array) && in_array($option['value']['id'], $cPath_array))){
                    
            $sm=1;
          
            $html[]='<strong>'.stripslashes($option['value']['name']).'->'.$pic.'</strong>';
            
          }else{
          
            $html[]=stripslashes($option['value']['name']).'->'.$pic;
            
          }
      
          $html[]='</a>';

				  $html[] = $tab . "\t" . '<ul class="'.$submenuUlClass.'" style="'.($sm!==1 && !$drawExpanded ?'display:none;':'').'">';

				$parent_stack[]=$option['value']['parent_id'];
				$parent = $option['value']['id'];

			}else{
				
        $rt=$root_id>0 ? $root_id.'_' : '';

				$cpath_new= count($stack)<=0 ? 'cPath='.$rt.$option['value']['id'] : 'cPath='.$rt.implode('_',$stack).'_'.$option['value']['id'];
  			
				$html[]=str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 - 1 ).'<li><a href="'.vam_href_link(FILENAME_DEFAULT, $cpath_new).'" >';
				
        if (SHOW_COUNTS == 'true') { //THIS SHOULD BE CHANGED SO NOT TO USE vam_count_products_in_category WHICH IS RECURSIVE
          $products_in_category = vam_count_products_in_category($option['value']['id']);
          if ($products_in_category > 0) {
            $pic=' (' . $products_in_category . ')';
          }
        }
				
				if (isset($cPath_array) && in_array($option['value']['id'], $cPath_array)) {

          $html[]='<strong>'.stripslashes($option['value']['name']).$pic.'</strong>';

        }else{

          $html[]=stripslashes($option['value']['name']).$pic;

        }
				
				$html[]='</a></li>';
				
			}
				
		}
    $html[]='</ul>';
		echo implode( "\r\n", $html );

  }  


/* Menu cats box*/

//echo '<br /><br />'.vam_show_tree_box();

function vam_show_tree_box($root_id = 0,$mainUlClass='nav nav-list',$submenuUlClass='nav nav-list submenu'){
    global $cPath_array, $datas;
    $categories_query = vam_db_query("select c.categories_id, cd.categories_name, c.categories_status, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd where c.categories_status = 1 and c.categories_id = cd.categories_id and cd.language_id='" . (int)$_SESSION['languages_id'] ."' and c.categories_status = '1' order by sort_order, cd.categories_name");
    $items = array();
    while ($categories = vam_db_fetch_array($categories_query))  {
        $items[$categories['categories_id']] = array('name' => $categories['categories_name'], 'parent_id' => $categories['parent_id'], 'id' => $categories['categories_id']);
    }
    $citems=count($items);
    
    if($citems<=0) return '';
    elseif($citems==1) $children[] = $items; //in case we have one category item without subcategories, rare but possible
    else foreach( $items as $item ) $children[$item['parent_id']][] = $item;
        $loop = !empty( $children[$root_id] );
        $parent = $root_id;
        $parent_stack = array();
        $stack=array();//helper array so to know the current level
    $pic=''; //products_in_category string
        $datas .='<ul class="'.$mainUlClass.'">';
        while ( $loop && ( ( $option = each( $children[$parent] ) ) || ( $parent > $root_id ) ) ){
            if ( $option === false ){
                $parent = array_pop( $parent_stack );
                $datas .= '</ul>';
                $datas .= '</li>';
                array_pop( $stack );
            }elseif ( !empty( $children[$option['value']['id']] ) ){
                $stack[]=$option['value']['id'];
                  $rt=$root_id>0 ? $root_id.'_' : '';
                  $cpath_new=count($stack)<=0 ? 'cPath='.$rt.$option['value']['id'] : 'cPath='.$rt.implode('_',$stack);
                $datas .= '<li><a class="trigger right-caret" href="'.vam_href_link(FILENAME_DEFAULT, $cpath_new).'">';
          $sm=0;        
          if((isset($cPath_array) && in_array($option['value']['id'], $cPath_array))){
            $sm=1;
            $datas .='<strong>'.stripslashes($option['value']['name']).'</strong>';
          }else{
            $datas .=stripslashes($option['value']['name']);
          }
            $datas .='</a>';
            $datas .= '<ul class="'.$submenuUlClass.'">';
                $parent_stack[]=$option['value']['parent_id'];
                $parent = $option['value']['id'];
          }else{
        $rt=$root_id>0 ? $root_id.'_' : '';
                $cpath_new= count($stack)<=0 ? 'cPath='.$rt.$option['value']['id'] : 'cPath='.$rt.implode('_',$stack).'_'.$option['value']['id'];
                $datas .= '<li><a href="'.vam_href_link(FILENAME_DEFAULT, $cpath_new).'" >';

                if (isset($cPath_array) && in_array($option['value']['id'], $cPath_array)) {
          $datas .='<strong>'.stripslashes($option['value']['name']).'</strong>';
        }else{
          $datas .=stripslashes($option['value']['name']);
        }
        $datas .='</a></li>';
        }
       }
        $datas .='</ul>';

      return $datas;
  } 
  
?>
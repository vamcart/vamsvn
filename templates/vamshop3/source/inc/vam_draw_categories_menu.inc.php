<?php
/* -----------------------------------------------------------------------------------------
   $Id: vam_show_category.inc.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com
   (c) 2003	 nextcommerce (vam_show_category.inc.php,v 1.4 2003/08/13); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (vam_show_category.inc.php,v 1.4 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  function vam_draw_categories_menu($drawExpanded=true,$root_id = 0,$mainUlClass='',$submenuUlClass='submenu'){
    global $cPath_array;
    $categories_tree = '';


if (GROUP_CHECK == 'true') {
	$group_check = "and c.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 "; 
 } else { $group_check=''; }

    //GET ALL CATEGORIES
    $categories_query = "select c.categories_id,
                                           cd.categories_name,
                                           c.categories_image,
                                           c.icon,
                                           c.label_id,
                                           c.parent_id from ".TABLE_CATEGORIES." c, ".TABLE_CATEGORIES_DESCRIPTION." cd
                                           where c.categories_status = '1'
                                           ".$group_check."
                                           and c.categories_id = cd.categories_id
                                           and cd.language_id='".(int) $_SESSION['languages_id']."'
                                           order by sort_order, cd.categories_name";
    $categories_query = vamDBquery($categories_query);

    $items = array();
    
    while ($categories = vam_db_fetch_array($categories_query,true))  {
        $items[$categories['categories_id']] = array(
        
        'name' => $categories['categories_name'], 
        'icon' => $categories['icon'], 
        'label_id' => $categories['label_id'], 
        'image' => $categories['categories_image'], 
        'parent_id' => $categories['parent_id'], 
        'id' => $categories['categories_id']
        
        );
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
    
		//$categories_tree='<div class="'.$mainUlClass.'">'."\n";
		while ( $loop && ( ( $option = each( $children[$parent] ) ) || ( $parent > $root_id ) ) ){

			if ( $option === false ){

				$parent = array_pop( $parent_stack );
				
				$categories_tree.= str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 ) . '</ul>'."\n";
				//$categories_tree.= str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 - 1 ) . '</p>'."\n";
				
				array_pop( $stack );
				
			}elseif ( !empty( $children[$option['value']['id']] ) ){
			
				$tab = str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 - 1 );
				$stack[]=$option['value']['id'];
				
  				$rt=$root_id>0 ? $root_id.'_' : '';

	  			$cpath_new=count($stack)<=0 ? 'cPath='.$rt.$option['value']['id'] : 'cPath='.$rt.implode('_',$stack);        
                    
          //$categories_tree.=$tab.'<li class="vamshop_menu'.$rt.$option['value']['id'].'"><a href="'.vam_href_link(FILENAME_DEFAULT, $cpath_new).'">';
          $categories_tree.=$tab.'<li class="vamshop_menu'.$rt.$option['value']['id'].'">';
        
          //if (SHOW_COUNTS == 'true') { //THIS SHOULD BE CHANGED SO NOT TO USE vam_count_products_in_category WHICH IS RECURSIVE
            //$products_in_category = vam_count_products_in_category($option['value']['id']);
            //if ($products_in_category > 0) {
              //$pic=' (' . $products_in_category . ')';
            //}
          //}
          
          $sm=0;        
          
          //if((isset($cPath_array) && in_array($option['value']['id'], $cPath_array))){
                    
            //$sm=1;
          
            //$categories_tree.='<strong>'.stripslashes($option['value']['name']).'->'.$pic.'</strong>';
            //$categories_tree.='<strong>'.stripslashes($option['value']['name']).$pic.'</strong>';
            
          //}else{
          
            $categories_tree.='<label for="vamshop_menu'.$option['value']['id'].'">'.(($option['value']['icon'] != '') ? '<i class="'.$option['value']['icon'].'"></i> ' : false).stripslashes($option['value']['name']).'</label><label for="vamshop_menu'.(($option['value']['parent_id'] > 0)?$option['value']['parent_id']:'00').'"></label>'.$pic;

          //}
      
          //$categories_tree.='</a>';
          $categories_tree.='</li>';

				  //$categories_tree.= $tab . "\t" . "\n" . '<div class="'.$submenuUlClass.'" style="'.($sm!==1 && !$drawExpanded ?'display:none;':'').'">'."\n";
				  $categories_tree.= $tab . "\t" . "\n" . '<ul>'."\n";

				$parent_stack[]=$option['value']['parent_id'];
				$parent = $option['value']['id'];

			}else{
				
        $rt=$root_id>0 ? $root_id.'_' : '';

				$cpath_new= count($stack)<=0 ? 'cPath='.$rt.$option['value']['id'] : 'cPath='.$rt.implode('_',$stack).'_'.$option['value']['id'];
  			
  			   $cPath_url=vam_category_link($option['value']['id'],$option['value']['name']);
				$categories_tree.=str_repeat( "\t", ( count( $parent_stack ) + 1 ) * 2 - 1 ).'<li><a href="'.vam_href_link(FILENAME_DEFAULT, $cPath_url).'" >';
				
        //if (SHOW_COUNTS == 'true') { //THIS SHOULD BE CHANGED SO NOT TO USE vam_count_products_in_category WHICH IS RECURSIVE
          //$products_in_category = vam_count_products_in_category($option['value']['id']);
          //if ($products_in_category > 0) {
            //$pic=' (' . $products_in_category . ')';
          //}
        //}
				
				if (isset($cPath_array) && in_array($option['value']['id'], $cPath_array)) {

          $categories_tree.=(($option['value']['icon'] != '') ? '<i class="'.$option['value']['icon'].'"></i> ' : false).'<strong>'.stripslashes($option['value']['name']).$pic.'</strong>';

        }else{

          $categories_tree.=(($option['value']['icon'] != '') ? '<i class="'.$option['value']['icon'].'"></i> ' : false).stripslashes($option['value']['name']).$pic;

        }
				
				//$categories_tree.='</a></li>'."\n";
				$categories_tree.='</a></li>'."\n";
				
			}
				
		}
    //$categories_tree.='</div>'."\n";
    
		return $categories_tree;

  }  

?>
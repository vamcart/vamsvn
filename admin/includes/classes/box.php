<?php
/* --------------------------------------------------------------
   $Id: box.php 950 2007-02-08 12:17:21Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(box.php,v 1.5 2002/03/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (box.php,v 1.5 2003/08/18); www.nextcommerce.org
   (c) 2004	 xt:Commerce (box.php,v 1.5 2003/08/18); xt-commerce.com

   Released under the GNU General Public License 
    
   Example usage:

   $heading = array();
   $heading[] = array('params' => 'class="menuBoxHeading"',
                      'text'  => BOX_HEADING_TOOLS,
                      'link'  => vam_href_link(basename($_SERVER['PHP_SELF']), vam_get_all_get_params(array('selected_box')) . 'selected_box=tools'));

   $contents = array();
   $contents[] = array('text'  => SOME_TEXT);

   $box = new box;
   echo $box->infoBox($heading, $contents);   
   --------------------------------------------------------------
*/
defined( '_VALID_VAM' ) or die( 'Direct Access to this location is not allowed.' );

  class box extends tableBlock {
    function __construct() {
      $this->heading = array();
      $this->contents = array();
      
      $this->table_class = 'headTable';
      $this->table_cellspacing = '0';
      $this->table_width = '97%';
      $this->table_parameters = 'align="center"';
      $this->table_row_parameters = 'class="infoBoxHeading"';
      $this->table_data_parameters = 'class="infoBoxHeading"';
      $this->heading = $this->tableBlock($heading);

      $this->table_class = 'contentTable';
      $this->table_row_parameters = '';
      $this->table_data_parameters = 'class="infoBoxContent"';
      $this->contents = $this->tableBlock($contents);
            
    }

    function infoBox($heading, $contents) {

      $this->table_class = 'headTable';
      $this->table_cellspacing = '0';
      $this->table_width = '97%';
      $this->table_parameters = 'align="center"';
      $this->table_row_parameters = 'class="infoBoxHeading"';
      $this->table_data_parameters = 'class="infoBoxHeading"';
      $this->heading = $this->tableBlock($heading);

      $this->table_class = 'contentTable';
      $this->table_row_parameters = '';
      $this->table_data_parameters = 'class="infoBoxContent"';
      $this->contents = $this->tableBlock($contents);

      return $this->heading . $this->contents;
    }

    function menuBox($heading, $contents) {

      $this->table_data_parameters = 'class="menuBoxHeading"';
      if ($heading[0]['link']) {
        $this->table_data_parameters .= ' onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . $heading[0]['link'] . '\'"';
        $heading[0]['text'] = '&nbsp;<a href="' . $heading[0]['link'] . '" class="menuBoxHeadingLink">' . $heading[0]['text'] . '</a>&nbsp;';
      } else {
        $heading[0]['text'] = '&nbsp;' . $heading[0]['text'] . '&nbsp;';
      }
      $this->heading = $this->tableBlock($heading);

      $this->table_data_parameters = 'class="menuBoxContent"';
      $this->contents = $this->tableBlock($contents);

      return $this->heading . $this->contents;
    }
  }
?>
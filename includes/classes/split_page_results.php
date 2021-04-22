<?php
/* -----------------------------------------------------------------------------------------
   $Id: split_page_results.php 1166 2007-02-06 20:23:03 VaM $ 

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(split_page_results.php,v 1.14 2003/05/27); www.oscommerce.com 
   (c) 2003	 nextcommerce (split_page_results.php,v 1.6 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (split_page_results.php,v 1.6 2003/08/13); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  class splitPageResults {
    var $sql_query, $number_of_rows, $current_page_number, $number_of_pages, $number_of_rows_per_page;

    // class constructor
    function __construct($query, $page, $max_rows, $count_key = '*') {
      $this->sql_query = $query;

      if (empty($page) || (is_numeric($page) == false)) $page = 1;
      $this->current_page_number = $page;

      $this->number_of_rows_per_page = $max_rows;

      $pos_to = strlen($this->sql_query);
      $pos_from = strpos($this->sql_query, ' FROM', 0);

      $pos_group_by = strpos($this->sql_query, ' GROUP BY', $pos_from);
      if (($pos_group_by < $pos_to) && ($pos_group_by != false)) $pos_to = $pos_group_by;

      $pos_having = strpos($this->sql_query, ' HAVING', $pos_from);
      if (($pos_having < $pos_to) && ($pos_having != false)) $pos_to = $pos_having;

      $pos_order_by = strpos($this->sql_query, ' ORDER BY', $pos_from);
      if (($pos_order_by < $pos_to) && ($pos_order_by != false)) $pos_to = $pos_order_by;

      if (strpos($this->sql_query, 'DISTINCT') || strpos($this->sql_query, 'GROUP BY')) {
        $count_string = 'DISTINCT ' . vam_db_input($count_key);
        //$count_string = vam_db_input($count_key);
      } else {
        $count_string = vam_db_input($count_key);
      }

      $count_query = vamDBquery($query);
      $count = vam_db_num_rows($count_query,true);

      $this->number_of_rows = $count;
      $this->number_of_pages = ceil($this->number_of_rows / $this->number_of_rows_per_page);

      if ($this->current_page_number > $this->number_of_pages) {
        $this->current_page_number = $this->number_of_pages;
      }

      $offset = ($this->number_of_rows_per_page * ($this->current_page_number - 1));

      $this->sql_query .= " LIMIT " . max($offset, 0) . ", " . $this->number_of_rows_per_page;

    }

    // class functions

    // display split-page-number-links
    function display_links($max_page_links, $parameters = '') {
      global $PHP_SELF, $request_type;

      if ($this->number_of_pages == 1) return;

      if (vam_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';


      // previous button - not displayed on first page
      $display_links_string .= '<ul class="pagination">';
		if ($this->current_page_number > 1) { 
			if(($this->current_page_number - 1) == '1'){
				$display_links_string .= '<li class="page-item"><a class="page-link" href="' . vam_href_link(basename($PHP_SELF), $parameters, $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' "><i class="fas fa-chevron-left me-2"></i> ' . PREVNEXT_BUTTON_PREV . '</a></li>';
			} else {
				$display_links_string .= '<li class="page-item"><a class="page-link" href="' . vam_href_link(basename($PHP_SELF), $parameters . 'page=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' "><i class="fas fa-chevron-left me-2"></i> ' . PREVNEXT_BUTTON_PREV . '</a></li>';
			}
		} else {
				$display_links_string .= '<li class="page-item disabled"><a class="page-link border-0" href="' . vam_href_link(basename($PHP_SELF), $parameters . 'page=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' "><i class="fas fa-chevron-left me-2"></i> ' . PREVNEXT_BUTTON_PREV . '</a></li>';
		}
      $display_links_string .= '</ul>';
		
      $display_links_string .= '<ul class="pagination">';
		$display_links_string .= '<li class="page-item d-sm-none"><span class="page-link page-link-static">'.$this->current_page_number.' / '.$this->number_of_pages.'</span></li>';

      // check if number_of_pages > $max_page_links
      $cur_window_num = intval($this->current_page_number / $max_page_links);
      if ($this->current_page_number % $max_page_links) $cur_window_num++;

      $max_window_num = intval($this->number_of_pages / $max_page_links);
      if ($this->number_of_pages % $max_page_links) $max_window_num++;

      // previous window of pages
      if ($cur_window_num > 1) $display_links_string .= '<li class="page-item d-none d-sm-block"><a class="page-link" href="' . vam_href_link(basename($PHP_SELF), $parameters . 'page=' . (($cur_window_num - 1) * $max_page_links), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE, $max_page_links) . ' ">...</a></li>';

      // page nn button
      for ($jump_to_page = 1 + (($cur_window_num - 1) * $max_page_links); ($jump_to_page <= ($cur_window_num * $max_page_links)) && ($jump_to_page <= $this->number_of_pages); $jump_to_page++) {
       $count = ++$i;
        if ($jump_to_page == $this->current_page_number) {
          $display_links_string .= '<li class="page-item active d-none d-sm-block" aria-current="page"><span class="page-link">' . $jump_to_page . '<span class="visually-hidden">(current)</span></span></li>';
        } else {
			if( ($count == '1') and ($cur_window_num == '1') ){
				$display_links_string .= '<li class="page-item d-none d-sm-block"><a class="page-link" href="' . vam_href_link(basename($PHP_SELF), $parameters, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $jump_to_page . '</a></li>';
			} else {
				$display_links_string .= '<li class="page-item d-none d-sm-block"><a class="page-link" href="' . vam_href_link(basename($PHP_SELF), $parameters . 'page=' . $jump_to_page, $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $jump_to_page . '</a></li>';
			}
        }
      }

      // next window of pages
      if ($cur_window_num < $max_window_num) $display_links_string .= '<li class="page-item d-sm-none"><a class="page-link" href="' . vam_href_link(basename($PHP_SELF), $parameters . 'page=' . (($cur_window_num) * $max_page_links + 1), $request_type) . '" title=" ' . sprintf(PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE, $max_page_links) . ' ">...</a></li>';

      $display_links_string .= '</ul>';

       // next button
      $display_links_string .= '<ul class="pagination">';
      if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1)) {
      $display_links_string .= '<li class="page-item"><a class="page-link" href="' . vam_href_link(basename($PHP_SELF), $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . PREVNEXT_BUTTON_NEXT . ' <i class="fas fa-chevron-right ms-2"></i></a></li>';
      } else {
      $display_links_string .= '<li class="page-item disabled"><a class="page-link border-0" href="' . vam_href_link(basename($PHP_SELF), $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . PREVNEXT_BUTTON_NEXT . ' <i class="fas fa-chevron-right ms-2"></i></a></li>';
      }	
      $display_links_string .= '</ul>';
      
      return $display_links_string;
    }

    // display compact split-page-number-links
    function display_links_compact($max_page_links, $parameters = '') {
      global $PHP_SELF, $request_type;
      
      if ($this->number_of_pages == 1) return;

      if (vam_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';


      // previous button - not displayed on first page

		if ($this->current_page_number > 1) { 
			if(($this->current_page_number - 1) == '1'){
				$display_links_string .= '<a class="nav-link-style nav-link-light me-3" href="' . vam_href_link(basename($PHP_SELF), $parameters, $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' "><i class="fas fa-chevron-left me-2"></i></a>';
			} else {
				$display_links_string .= '<a class="nav-link-style nav-link-light me-3" href="' . vam_href_link(basename($PHP_SELF), $parameters . 'page=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' "><i class="fas fa-chevron-left me-2"></i></a>';
			}
		} else {
				$display_links_string .= '<span class="nav-link-style nav-link-light me-3 disabled" href="' . vam_href_link(basename($PHP_SELF), $parameters . 'page=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' "><i class="fas fa-chevron-left me-2"></i></span>';
		}
		
		$display_links_string .= '<span class="fs-md text-light">'.$this->current_page_number.' / '.$this->number_of_pages.'</span>';

      // check if number_of_pages > $max_page_links
      $cur_window_num = intval($this->current_page_number / $max_page_links);
      if ($this->current_page_number % $max_page_links) $cur_window_num++;

      $max_window_num = intval($this->number_of_pages / $max_page_links);
      if ($this->number_of_pages % $max_page_links) $max_window_num++;

       // next button
      if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1)) {
      $display_links_string .= '<a class="nav-link-style nav-link-light ms-3" href="' . vam_href_link(basename($PHP_SELF), $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' "><i class="fas fa-chevron-right ms-2"></i></a>';
      } else {
      $display_links_string .= '<span class="nav-link-style nav-link-light ms-3 disabled" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' "><i class="fas fa-chevron-right ms-2"></i></span>';
      }	
      
      return $display_links_string;
    }
    
    // display number of total products found
    function display_count($text_output) {
      $to_num = ($this->number_of_rows_per_page * $this->current_page_number);
      if ($to_num > $this->number_of_rows) $to_num = $this->number_of_rows;

      $from_num = ($this->number_of_rows_per_page * ($this->current_page_number - 1));

      if ($to_num == 0) {
        $from_num = 0;
      } else {
        $from_num++;
      }

      return sprintf($text_output, $from_num, $to_num, $this->number_of_rows);
    }
  }
?>
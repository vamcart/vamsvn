<?php
/* --------------------------------------------------------------
   $Id: faq1.php 1180 2007-04-02 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(latest_news.php,v 1.33 2003/05/07); www.oscommerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');
  require_once(DIR_FS_INC . 'vam_wysiwyg_tiny.inc.php');
  require_once (DIR_FS_INC.'vam_image_submit.inc.php');
  require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');

// initiate template engine for mail
$vamTemplate = new vamTemplate;

  require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.phpmailer.php');
  if (EMAIL_TRANSPORT == 'smtp')
  require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.smtp.php');
  require_once (DIR_FS_INC.'vam_php_mail.inc.php');
  require_once(DIR_FS_INC . 'vam_wysiwyg_tiny.inc.php');

  
  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'setflag': //set the status of a faq1 item.
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
          if ($_GET['faq1_id']) {
            vam_db_query("update " . TABLE_FAQ1 . " set status = '" . $_GET['flag'] . "' where faq1_id = '" . $_GET['faq1_id'] . "'");
          }
        }

  //      vam_redirect(vam_href_link(FILENAME_FAQ1));
        break;

      case 'delete_faq1_confirm': //user has confirmed deletion of faq1.
        if ($_POST['faq1_id']) {
          $faq1_id = vam_db_prepare_input($_POST['faq1_id']);
          vam_db_query("delete from " . TABLE_FAQ1 . " where faq1_id = '" . vam_db_input($faq1_id) . "'");
        }

   //     vam_redirect(vam_href_link(FILENAME_FAQ1));
        break;

      case 'insert_faq1': //insert a new faq1.
        if ($_POST['question']) {

					if ($_POST['faq1_page_url'] == '' && file_exists(DIR_FS_CATALOG . '.htaccess') && AUTOMATIC_SEO_URL == 'true') {
						$alias = $_POST['question'];
						
						$alias = make_alias($alias);
                  $faq1_page_url = $alias;

					} else {
						
                $faq1_page_url = $_POST['faq1_page_url'];
					}
					
          $sql_data_array = array('question'   => vam_db_prepare_input($_POST['question']),
                                  'faq1_page_url'    => vam_db_prepare_input($faq1_page_url),
                                  'faq1_head_title' => vam_db_prepare_input($_POST['faq1_head_title']),
                                  'faq1_head_desc' => vam_db_prepare_input($_POST['faq1_head_desc']),
                                  'faq1_head_keys' => vam_db_prepare_input($_POST['faq1_head_keys']),
                                  'answer'    => vam_db_prepare_input($_POST['answer']),
                                  'name'  => vam_db_prepare_input($_POST['name']),
                                  'email_address'  => vam_db_prepare_input($_POST['email_address']),
                                  'sort_order'    => vam_db_prepare_input($_POST['sort_order']),
                                  'show_popular_products'    => vam_db_prepare_input($_POST['show_popular_products']),
                                  'show_discount_products'    => vam_db_prepare_input($_POST['show_discount_products']),
                                  'date_added' => 'now()', //uses the inbuilt mysql function 'now'
                                  'language'   => vam_db_prepare_input($_POST['item_language']),
                                  'status'     => '1' );
          vam_db_perform(TABLE_FAQ1, $sql_data_array);
          $faq1_id = vam_db_insert_id(); //not actually used ATM -- just there in case
        }
 //       vam_redirect(vam_href_link(FILENAME_FAQ1));
 
      //if (isset($_POST['faq1_to_categories_id']) && $faq1_id > 0) {
      //foreach ($_POST['faq1_to_categories_id'] as $key => $value) {
        //if (!is_array($_POST[$key])) {
			//vam_db_query("INSERT INTO ".TABLE_FAQ1_TO_CATEGORIES."
								              //SET faq1_id   = '".$faq1_id."',
								              //categories_id = '".$value."'");
        //}
      //}
      //}

      //if (isset($_POST['faq1_to_products_id']) && $faq1_id > 0) {
      //foreach ($_POST['faq1_to_products_id'] as $key => $value) {
        //if (!is_array($_POST[$key])) {
			//vam_db_query("INSERT INTO ".TABLE_FAQ1_TO_PRODUCTS."
								              //SET faq1_id   = '".$faq1_id."',
								              //products_id = '".$value."'");
        //}
      //}
      //}
 
        break;

      case 'update_faq1': //user wants to modify a faq1.
        if($_GET['faq1_id']) {

          if ($_POST['answer'] != '') {

				// assign language to template for caching
				$vamTemplate->assign('language', $_SESSION['language']);
				$vamTemplate->caching = false;

				$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
				$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

		
				$vamTemplate->assign('CUSTOMERS_NAME', $_POST['name']);

				$vamTemplate->assign('QUESTION', $_POST['question']);
				$vamTemplate->assign('ANSWER', $_POST['answer']);

				$vamTemplate->assign('CUSTOMERS_FIRST_NAME', $_POST['name']);
				$vamTemplate->assign('CUSTOMERS_LAST_NAME', '');

				$vamTemplate->assign('PRODUCTS_NAME', vam_get_products_name($_POST['products_id'], 1));
				$vamTemplate->assign('PRODUCT_LINK', HTTP_SERVER . DIR_WS_CATALOG . 'product_info.php?products_id='.$_POST['products_id']);

				$customer_query = vam_db_query("select * from " . TABLE_FAQ1 . " f where f.faq1_id = '" . vam_db_input($_GET['faq1_id']) . "'");
				$customer_id = vam_db_fetch_array($customer_query);
				
				if ($customer_id['customer_id'] > 0) {

				$customer_info_query = vam_db_query("select * from " . TABLE_CUSTOMERS . " c where c.customers_id = '" . vam_db_input($customer_id['customer_id']) . "'");
				$customer_info = vam_db_fetch_array($customer_info_query);

				$vamTemplate->assign('CUSTOMERS_TELEPHONE', $customer_info['customers_telephone']);
				$vamTemplate->assign('CUSTOMERS_EMAIL_ADDRESS', $customer_info['customers_email_address']);

				}

				$question_query = vam_db_query("select * from " . TABLE_FAQ1 . " f where f.faq1_id = '" . vam_db_input($_GET['faq1_id']) . "' and f.language = '" . $_SESSION['languages_id'] . "'");
				$question = vam_db_fetch_array($question_query);
				
				if (md5($question['answer']) == md5($_POST['answer'])) {
				$changed = false;
				} else { 
				$changed = true;
				}

				if ($changed) {

				$vamTemplate->assign('REVIEWS_LINK', HTTP_SERVER . DIR_WS_CATALOG . 'product_info.php?products_id='.$_POST['products_id'].'#product-questions'); 
				$vamTemplate->assign('REVIEWS_ANSWER', $_POST['answer']);

				$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/question_answer_mail.html');
				$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/question_answer_mail.txt');

            // create subject
           $review_answer_subject = ANSWER_SUBJECT;

				if (filter_var($_POST['email_address'], FILTER_VALIDATE_EMAIL)) {

				vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $_POST['email_address'], $_POST['name'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $review_answer_subject, $html_mail, $txt_mail);
				
				}

            }
            
          }   


          $sql_data_array = array('question' => vam_db_prepare_input($_POST['question']),
                                  'faq1_page_url'    => vam_db_prepare_input($_POST['faq1_page_url']),
                                  'faq1_head_title' => vam_db_prepare_input($_POST['faq1_head_title']),
                                  'faq1_head_desc' => vam_db_prepare_input($_POST['faq1_head_desc']),
                                  'faq1_head_keys' => vam_db_prepare_input($_POST['faq1_head_keys']),
                                  'answer'  => vam_db_prepare_input($_POST['answer']),
                                  'name'  => vam_db_prepare_input($_POST['name']),
                                  'email_address'  => vam_db_prepare_input($_POST['email_address']),
                                  'sort_order'    => vam_db_prepare_input($_POST['sort_order']),
                                  'show_popular_products'    => vam_db_prepare_input($_POST['show_popular_products']),
                                  'show_discount_products'    => vam_db_prepare_input($_POST['show_discount_products']),
                                  'date_added'  => vam_db_prepare_input($_POST['date_added']),
                                  'language'   => vam_db_prepare_input($_POST['item_language']),
                                  );
          vam_db_perform(TABLE_FAQ1, $sql_data_array, 'update', "faq1_id = '" . vam_db_prepare_input($_GET['faq1_id']) . "'");
          
        }

		//$faq1_to_categories_array = array();
		//if ($_GET['faq1_id'] > 0) {
		//$faq1_to_categories_query = vam_db_query("select f2c.categories_id from " . TABLE_FAQ1_TO_CATEGORIES . " f2c where f2c.faq1_id = ".$_GET['faq1_id']."");
		//while ($faq1_to_categories = vam_db_fetch_array($faq1_to_categories_query))
		//{
			//$faq1_to_categories_array[] = $faq1_to_categories['categories_id'];
		//}
		//}

      //if (isset($_POST['faq1_to_categories_id']) && $_GET['faq1_id'] > 0) {
      //vam_db_query("DELETE FROM " . TABLE_FAQ1_TO_CATEGORIES . " WHERE faq1_id = '" . (int)$_GET['faq1_id'] . "'");
      //foreach ($_POST['faq1_to_categories_id'] as $key => $value) {
        //if (!is_array($_POST[$key])) {
        //if (in_array_column($value, "categories_id", $faq1_to_categories_array)) {        	
			//vam_db_query("INSERT INTO ".TABLE_FAQ1_TO_CATEGORIES."
								              //SET faq1_id   = '".$_GET['faq1_id']."',
								              //categories_id = '".$value."'");
        //}
        //}
      //}
      //}

      //if (isset($_POST['faq1_to_products_id']) && $faq1_id > 0) {
      //vam_db_query("DELETE FROM " . TABLE_FAQ1_TO_PRODUCTS . " WHERE faq1_id = '" . (int)$_GET['faq1_id'] . "'");
      //foreach ($_POST['faq1_to_products_id'] as $key => $value) {
        //if (!is_array($_POST[$key])) {
			//vam_db_query("INSERT INTO ".TABLE_FAQ1_TO_PRODUCTS."
								              //SET faq1_id   = '".$_GET['faq1_id']."',
								              //products_id = '".$value."'");
        //}
      //}
      //}
              
  //      vam_redirect(vam_href_link(FILENAME_FAQ1));
        break;
    }
  }
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<!--<meta name="viewport" content="initial-scale=1.0, width=device-width" />-->
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
<?php
 $query=vam_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".$_SESSION['languages_id']."'");
 $data=vam_db_fetch_array($query);
 if ($_GET['action']=='new_faq1') echo vam_wysiwyg_tiny('faq1',$data['code']);
?>
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
    <td class="boxCenter" valign="top">
    
<?php 
$manual_link = 'add-faq1';
if ($_GET['action'] == 'new_faq1' and isset($_GET['faq1_id'])) {
$manual_link = 'edit-faq1';
}  
if ($_GET['action'] == 'delete_faq1') {
$manual_link = 'delete-faq1';
}  
?>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading" colspan="2"><?php echo HEADING_TITLE; ?></td>
          </tr>
        </table>
  
  </td>
  </tr>
  <tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
  if ($_GET['action'] == 'new_faq1') { //insert or edit a faq1
    if ( isset($_GET['faq1_id']) ) { //editing exsiting faq1
      $faq1_query = vam_db_query("select * from " . TABLE_FAQ1 . " where faq1_id = '" . $_GET['faq1_id'] . "'");
      $faq1 = vam_db_fetch_array($faq1_query);
    } else { //adding new faq1
      $faq1 = array();
    }
    
if ($faq1['show_popular_products'] == '1'){ $show_popular_products_checked = true; } else { $show_popular_products_checked = false; }    
if ($faq1['show_discount_products'] == '1'){ $show_discount_products_checked = true; } else { $show_discount_products_checked = false; }    
?>
      <tr><?php echo vam_draw_form('new_faq1', FILENAME_FAQ1, isset($_GET['faq1_id']) ? vam_get_all_get_params(array('action')) . 'action=update_faq1' : vam_get_all_get_params(array('action')) . 'action=insert_faq1', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" cellspacing="0" cellpadding="2" width="100%">
          <tr>
            <td class="main"><?php echo TEXT_FAQ1_NAME; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('name', $faq1['name'], 'size="60"', true); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_FAQ1_EMAIL_ADDRESS; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('email_address', $faq1['email_address'], 'size="60"', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo '<strong>'.TEXT_FAQ1_PRODUCT_NAME.':</strong><br><a href="' . HTTP_SERVER.DIR_WS_CATALOG .'product_info.php?products_id='.$faq1['products_id'].'" target="_blank">' . vam_get_products_name($faq1['products_id'], 1).'</a>'; ?>:</td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_FAQ1_QUESTION; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('question', $faq1['question'], 'size="60"', true); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_hidden_field('products_id', $faq1['products_id']).vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_FAQ1_ANSWER; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_textarea_field('answer', '', '100%', '12', stripslashes($faq1['answer'])); ?><br /><a href="javascript:toggleHTMLEditor('answer');"><?php echo TEXT_TOGGLE_EDITOR; ?></a></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_FAQ1_SORT_ORDER; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' .  vam_draw_input_field('sort_order', $faq1['sort_order'], '', true); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          

<?php
if ( isset($_GET['faq1_id']) ) {
?>
          <tr>
            <td class="main"><?php echo TEXT_FAQ1_DATE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' .  vam_draw_input_field('date_added', $faq1['date_added'], '', true); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<?php
}
?>

          <tr>
            <td class="main"><?php echo TEXT_FAQ1_LANGUAGE; ?>:</td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;'; ?>

<?php

  $languages = vam_get_languages();
  $languages_array = array();

  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
                        
  if ($languages[$i]['id']==$faq1['language']) {
         $languages_selected=$languages[$i]['id'];
         $languages_id=$languages[$i]['id'];
        }               
    $languages_array[] = array('id' => $languages[$i]['id'],
               'text' => $languages[$i]['name']);

  } // for
  
echo vam_draw_pull_down_menu('item_language',$languages_array,$languages_selected); ?>

</td>
          </tr>


        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main" align="right">
          <?php
            isset($_GET['faq1_id']) ? $cancel_button = '&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_FAQ1, 'faq1_id=' . $_GET['faq1_id']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>' : $cancel_button = '';
            echo '<span class="button"><button type="submit" value="' . BUTTON_INSERT .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' .BUTTON_INSERT . '</button></span>' . $cancel_button;
          ?>
        </td>
      </form></tr>
<?php

  } else {
?>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FAQ1_QUESTION; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_FAQ1_ANSWER; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_FAQ1_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_FAQ1_SORT_ORDER; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_FAQ1_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $rows = 0;

    $faq1_count = 0;
    $faq1_query_raw = 'select * from ' . TABLE_FAQ1 . ' order by faq1_id desc, sort_order asc, date_added desc';

	$faq1_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $faq1_query_raw, $faq1_query_numrows);

    $faq1_query = vam_db_query($faq1_query_raw);
	    
    while ($faq1 = vam_db_fetch_array($faq1_query)) {
      $faq1_count++;
      $rows++;
      
		if (((!$_GET['faq1_id']) || (@ $_GET['faq1_id'] == $faq1['faq1_id'])) && (!$fInfo)) {
			$fInfo = new objectInfo($faq1);
		}

		if ((is_object($fInfo)) && ($faq1['faq1_id'] == $fInfo->faq1_id)) {
		
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_FAQ1, vam_get_all_get_params(array('faq1_id','action')) . 'faq1_id=' . $faq1['faq1_id']) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_FAQ1, vam_get_all_get_params(array('faq1_id','action')) . 'faq1_id=' . $faq1['faq1_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo $faq1['question']; ?></td>
                <td class="dataTableContent" align="center"><?php echo (($faq1['answer'] != '') ? '<span style="color: green;">'.YES.'</span>' : '<span style="color: red;">'.NO.'</span>'); ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($faq1['status'] == '1') {
        echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_FAQ1, vam_get_all_get_params(array('faq1_id','action', 'flag')) . 'action=setflag&flag=0&faq1_id=' . $faq1['faq1_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link(FILENAME_FAQ1, vam_get_all_get_params(array('faq1_id','action', 'flag')) . 'action=setflag&flag=1&faq1_id=' . $faq1['faq1_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="center"><?php echo $faq1['sort_order']; ?></td>
                <td class="dataTableContent" align="right"><?php if ($faq1['faq1_id'] == $_GET['faq1_id']) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_FAQ1, vam_get_all_get_params(array('faq1_id','action', 'flag')) . 'faq1_id=' . $faq1['faq1_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" colspan="2"><?php echo '<br>' . TEXT_FAQ1_ITEMS . '&nbsp;' . $faq1_count; ?></td>
                  </tr>																																		  
                </table></td>
              </tr>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $faq1_split->display_count($faq1_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_FAQ1S); ?></td>
                    <td class="smallText" align="right"><?php echo $faq1_split->display_links($faq1_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], vam_get_all_get_params(array('page', 'action', 'x', 'y', 'faq1_id'))); ?></td>
                  </tr>              
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($_GET['action']) {
      case 'delete_faq1': //generate box for confirming a faq1deletion
        $heading[] = array('text'   => '<b>' . TEXT_INFO_HEADING_DELETE_ITEM . '</b>');
        
        $contents = array('form'    => vam_draw_form('faq1', FILENAME_FAQ1, vam_get_all_get_params(array('action')) . 'action=delete_faq1_confirm') . vam_draw_hidden_field('faq1_id', $_GET['faq1_id']));
        $contents[] = array('text'  => TEXT_DELETE_ITEM_INTRO);
        $contents[] = array('text'  => '<br><b>' . $selected_item['question'] . '</b>');
        
        $contents[] = array('align' => 'center',
                            'text'  => '<br><span class="button"><button type="submit" value="' . BUTTON_DELETE .'">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span><a class="button" href="' . vam_href_link(FILENAME_FAQ1,  vam_get_all_get_params(array ('faq1_id', 'action')).'faq1_id=' . $selected_item['faq1_id']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;

      default:
        if ($rows > 0) {
          if (is_object($fInfo)) { //an item is selected, so make the side box
            $heading[] = array('text' => '<b>' . $fInfo->question . '</b>');

            $contents[] = array('align' => 'center', 
                                'text' => '<a class="button" href="' . vam_href_link(FILENAME_FAQ1, vam_get_all_get_params(array ('faq1_id', 'action')).'faq1_id=' . $fInfo->faq1_id . '&action=new_faq1') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_FAQ1,  vam_get_all_get_params(array ('faq1_id', 'action')).'faq1_id=' . $fInfo->faq1_id . '&action=delete_faq1') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');

            if ($fInfo->products_id > 0) $contents[] = array('text' => '<strong>'.TEXT_FAQ1_PRODUCT_NAME.':</strong><br><a href="' . HTTP_SERVER.DIR_WS_CATALOG .'product_info.php?products_id='.$fInfo->products_id.'" target="_blank">' . vam_get_products_name($fInfo->products_id, 1).'</a>');
            $contents[] = array('text' => '<strong>'.TEXT_FAQ1_QUESTION.':</strong><br>' . vam_break_string(strip_tags($fInfo->question), 128, '...'));
            if ($fInfo->answer != '') $contents[] = array('text' => '<strong>'.TEXT_FAQ1_ANSWER.':</strong><br>' . vam_break_string(strip_tags($fInfo->answer), 128, '...'));
          }
        } else { // create category/product info
          //$heading[] = array('text' => '<b>' . EMPTY_CATEGORY . '</b>');

          //$contents[] = array('text' => sprintf(TEXT_NO_CHILD_CATEGORIES_OR_PRODUCTS, $parent_categories_name));
        }
        break;
    }

    if ( (vam_not_null($heading)) && (vam_not_null($contents)) ) {
      echo '            <td width="25%" valign="top">' . "\n";

      $box = new box;
      echo $box->infoBox($heading, $contents);

      echo '            </td>' . "\n";
    }
?>
          </tr>
        </table></td>
      </tr>
<?php
  }
?>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?><!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>

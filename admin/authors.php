<?php
/* --------------------------------------------------------------
   $Id: authors.php 1125 2007-03-09 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.40 2002/12/29); www.oscommerce.com 

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (vam_not_null($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        if (isset($_GET['auID'])) $authors_id = vam_db_prepare_input($_GET['auID']);
        $authors_name = vam_db_prepare_input($_POST['authors_name']);

        $authorsImg = '';
        $authors_image = new upload('authors_image');
        $authors_image->set_destination(DIR_FS_CATALOG_IMAGES .'articles/authors/');

        if ($authors_image->parse() && $authors_image->save()) {
            $authorsImg = vam_db_input($authors_image->filename);
        }

			if ($authorsImg == '' && $_POST['authors_image_name'] != '' && $authorsImg != $_POST['authors_image_name']) {
        $authorsImg = $_POST['authors_image_name'];
        }

        $sql_data_array = array('authors_name' => $authors_name,
                                 'authors_image' => $authorsImg,
                                 );

        if ($action == 'insert') {
          $insert_sql_data = array('date_added' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          vam_db_perform(TABLE_AUTHORS, $sql_data_array);
          $authors_id = vam_db_insert_id();
        } elseif ($action == 'save') {
          $update_sql_data = array('last_modified' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $update_sql_data);

          vam_db_perform(TABLE_AUTHORS, $sql_data_array, 'update', "authors_id = '" . (int)$authors_id . "'");
        }

        $languages = vam_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $authors_desc_array = $_POST['authors_description'];
          $authors_url_array = $_POST['authors_url'];
          $language_id = $languages[$i]['id'];

          $sql_data_array = array('authors_description' => vam_db_prepare_input($authors_desc_array[$language_id]),
                                  'authors_url' => vam_db_prepare_input($authors_url_array[$language_id]));

          if ($action == 'insert') {
            $insert_sql_data = array('authors_id' => $authors_id,
                                     'languages_id' => $language_id);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            vam_db_perform(TABLE_AUTHORS_INFO, $sql_data_array);
          } elseif ($action == 'save') {
            vam_db_perform(TABLE_AUTHORS_INFO, $sql_data_array, 'update', "authors_id = '" . (int)$authors_id . "' and languages_id = '" . (int)$language_id . "'");
          }
        }

        if (USE_CACHE == 'true') {
          vam_reset_cache_block('authors');
        }

        vam_redirect(vam_href_link(FILENAME_AUTHORS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'auID=' . $authors_id));
        break;
      case 'deleteconfirm':
        $authors_id = vam_db_prepare_input($_GET['auID']);

        vam_db_query("delete from " . TABLE_AUTHORS . " where authors_id = '" . (int)$authors_id . "'");
        vam_db_query("delete from " . TABLE_AUTHORS_INFO . " where authors_id = '" . (int)$authors_id . "'");

        if (isset($_POST['delete_articles']) && ($_POST['delete_articles'] == 'on')) {
          $articles_query = vam_db_query("select articles_id from " . TABLE_ARTICLES . " where authors_id = '" . (int)$authors_id . "'");
          while ($articles = vam_db_fetch_array($articles_query)) {
            vam_remove_article($articles['articles_id']);
          }
        } else {
          vam_db_query("update " . TABLE_ARTICLES . " set authors_id = '' where authors_id = '" . (int)$authors_id . "'");
        }

        if (USE_CACHE == 'true') {
          vam_reset_cache_block('authors');
        }

        vam_redirect(vam_href_link(FILENAME_AUTHORS, 'page=' . $_GET['page']));
        break;
    }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
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
<?php
  if ($action == 'new') {
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" class="pageHeading"><h1 class="contentBoxHeading"><?php echo TEXT_HEADING_NEW_AUTHOR; ?></h1></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo vam_draw_form('authors', FILENAME_AUTHORS, 'action=insert', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" colspan="2"><?php echo TEXT_NEW_INTRO; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_AUTHORS_NAME; ?></td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('authors_name', '', 'size="20"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="smallText"><?php echo TEXT_AUTHORS_IMAGE; ?></td>
            <td><?php echo vam_draw_file_field('authors_image'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

<!--
<?php
  $languages = vam_get_languages();
  for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_AUTHORS_DESCRIPTION; ?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="main" valign="top"><?php echo $languages[$i]['name'] . '&nbsp;'; ?></td>
                  <td class="main" valign="top"><?php echo vam_draw_textarea_field('authors_description[' . $languages[$i]['id'] . ']', 'soft', '70', '15', ''); ?></td>
                </tr>
              </table>
            </td>
          <tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_AUTHORS_URL; ?></td>
            <td class="main" valign="top"><?php echo $languages[$i]['name'] . '&nbsp;' . vam_draw_input_field('authors_url[' . $languages[$i]['id'] . ']', '', 'size="30"'); ?></td>
          <tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
<?php
  }
?>
-->
      <tr>
        <td class="main">&nbsp;</td>
        <td class="main" align="left"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . '<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>' . ' <a class="button" href="' . vam_href_link(FILENAME_AUTHORS, 'page=' . $_GET['page'] . '&auID=' . $_GET['auID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?></td>
      </form>
      </tr>
          </tr>
        </table></td>
      </tr>
<?php
  } elseif ($action == 'edit') {

    $authors_query = vam_db_query("select authors_id, authors_name, authors_image from " . TABLE_AUTHORS . " where authors_id = '" . $_GET['auID'] . "'");
    $authors = vam_db_fetch_array($authors_query)
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" class="pageHeading"><h1 class="contentBoxHeading"><?php echo TEXT_HEADING_EDIT_AUTHOR; ?></h1></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr><?php echo vam_draw_form('authors', FILENAME_AUTHORS, 'page=' . $_GET['page'] . '&auID=' . $authors['authors_id'] . '&action=save', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main" colspan="2"><?php echo TEXT_EDIT_INTRO; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_AUTHORS_NAME; ?></td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('authors_name', $authors['authors_name'], 'size="20"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="smallText"><?php echo TEXT_AUTHORS_IMAGE; ?></td>
            <td><?php echo vam_draw_input_field('authors_image_name', $authors['authors_image']) . '&nbsp;&nbsp;' .  vam_draw_file_field('authors_image'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
<!--          
<?php
  $languages = vam_get_languages();
  for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
?>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_AUTHORS_DESCRIPTION; ?></td>
            <td>
              <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="main" valign="top"><?php echo $languages[$i]['name'] . '&nbsp;'; ?></td>
                  <td class="main" valign="top"><?php echo vam_draw_textarea_field('authors_description[' . $languages[$i]['id'] . ']', 'soft', '70', '15', vam_get_author_description($authors['authors_id'], $languages[$i]['id'])); ?></td>
                </tr>
              </table>
            </td>
          <tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main" valign="top"><?php echo TEXT_AUTHORS_URL; ?></td>
            <td class="main" valign="top"><?php echo $languages[$i]['name'] . '&nbsp;' . vam_draw_input_field('authors_url[' . $languages[$i]['id'] . ']', vam_get_author_url($authors['authors_id'], $languages[$i]['id']), 'size="30"'); ?></td>
          <tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
<?php
  }
?>
-->
      <tr>
        <td class="main">&nbsp;</td>
        <td class="main" align="left"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . '<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>' . ' <a class="button" href="' . vam_href_link(FILENAME_AUTHORS, 'page=' . $_GET['page'] . '&auID=' . $authors['authors_id']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?></td>
      </form>
      </tr>
          </tr>
        </table></td>
      </tr>
<?php
  } else { ?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" class="pageHeading"><h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_AUTHORS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $authors_query_raw = "select authors_id, authors_name, authors_image, date_added, last_modified from " . TABLE_AUTHORS . " order by authors_id DESC";
  $authors_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $authors_query_raw, $authors_query_numrows);
  $authors_query = vam_db_query($authors_query_raw);
  while ($authors = vam_db_fetch_array($authors_query)) {
    if ((!isset($_GET['auID']) || (isset($_GET['auID']) && ($_GET['auID'] == $authors['authors_id']))) && !isset($auInfo) && (substr($action, 0, 3) != 'new')) {
      $author_articles_query = vam_db_query("select count(*) as articles_count from " . TABLE_ARTICLES . " where authors_id = '" . (int)$authors['authors_id'] . "'");
      $author_articles = vam_db_fetch_array($author_articles_query);

     $auInfo_array = array_merge($authors, $author_articles);
      $auInfo = new objectInfo($auInfo_array);
    }

    if (isset($auInfo) && is_object($auInfo) && ($authors['authors_id'] == $auInfo->authors_id)) {
      echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . vam_href_link(FILENAME_AUTHORS, 'page=' . $_GET['page'] . '&auID=' . $authors['authors_id'] . '&action=edit') . '\'">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . vam_href_link(FILENAME_AUTHORS, 'page=' . $_GET['page'] . '&auID=' . $authors['authors_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo $authors['authors_name']; ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($auInfo) && is_object($auInfo) && ($authors['authors_id'] == $auInfo->authors_id)) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . vam_href_link(FILENAME_AUTHORS, 'page=' . $_GET['page'] . '&auID=' . $authors['authors_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $authors_split->display_count($authors_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_AUTHORS); ?></td>
                    <td class="smallText" align="right"><?php echo $authors_split->display_links($authors_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
  if (empty($action)) {
?>
              <tr>
                <td align="right" colspan="2" class="smallText"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_AUTHORS, 'page=' . $_GET['page'] . '&auID=' . $auInfo->authors_id . '&action=new') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</span></a>'; ?></td>
              </tr>
<?php
  }
?>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_HEADING_DELETE_AUTHOR . '</b>');

      $contents = array('form' => vam_draw_form('authors', FILENAME_AUTHORS, 'page=' . $_GET['page'] . '&auID=' . $auInfo->authors_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br><b>' . $auInfo->authors_name . '</b>');

      if ($auInfo->articles_count > 0) {
        $contents[] = array('text' => '<br>' . vam_draw_checkbox_field('delete_articles') . ' ' . TEXT_DELETE_ARTICLES);
        $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_ARTICLES, $auInfo->articles_count));
      }

      $contents[] = array('align' => 'center', 'text' => '<br>' . '<span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span>' . ' <a class="button" href="' . vam_href_link(FILENAME_AUTHORS, 'page=' . $_GET['page'] . '&auID=' . $auInfo->authors_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
      break;
    default:
      if (isset($auInfo) && is_object($auInfo)) {
        $heading[] = array('text' => '<b>' . $auInfo->authors_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_AUTHORS, 'page=' . $_GET['page'] . '&auID=' . $auInfo->authors_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_AUTHORS, 'page=' . $_GET['page'] . '&auID=' . $auInfo->authors_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');
        if ($auInfo->authors_image != '') $contents[] = array('text' => '<br>' . vam_image(DIR_WS_CATALOG.DIR_WS_IMAGES . 'articles/'.$auInfo->authors_image, 200, 300));
        $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . vam_date_short($auInfo->date_added));
        if (vam_not_null($auInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . vam_date_short($auInfo->last_modified));
        $contents[] = array('text' => '<br>' . TEXT_ARTICLES . ' ' . $auInfo->articles_count);
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
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
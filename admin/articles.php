<?php
/* --------------------------------------------------------------
   $Id: articles.php 1125 2007-03-09 11:13:01Z VaM $   

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
  require_once(DIR_FS_INC . 'vam_wysiwyg_tiny.inc.php');

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (vam_not_null($action)) {
    switch ($action) {
      case 'setflag':
        if ( ($_GET['flag'] == '0') || ($_GET['flag'] == '1') ) {
          if (isset($_GET['aID'])) {
            vam_set_article_status($_GET['aID'], $_GET['flag']);
          }

          if (USE_CACHE == 'true') {
            vam_reset_cache_block('topics');
          }
        }

        vam_redirect(vam_href_link(FILENAME_ARTICLES, 'tPath=' . $_GET['tPath'] . '&aID=' . $_GET['aID']));
        break;
      case 'new_topic':
      case 'edit_topic':
        $_GET['action']=$_GET['action'] . '_ACD';
        break;
      case 'insert_topic':
      case 'update_topic':
        if ( ($_POST['edit_x']) || ($_POST['edit_y']) ) {
          $_GET['action'] = 'edit_topic_ACD';
        } else {
        if (isset($_POST['topics_id'])) $topics_id = vam_db_prepare_input($_POST['topics_id']);
          if ($topics_id == '') {
            $topics_id = vam_db_prepare_input($_GET['tID']);
            }
        $sort_order = vam_db_prepare_input($_POST['sort_order']);

					if ($_POST['topics_page_url'] == '' && file_exists(DIR_FS_CATALOG . '.htaccess') && AUTOMATIC_SEO_URL == 'true') {
						$alias = $_POST['topics_name'][$_SESSION['languages_id']];
						
						$alias = make_alias($alias);
                  $topics_page_url = $alias;

					} else {
						
                $topics_page_url = $_POST['topics_page_url'];
					}

        $sql_data_array = array('sort_order' => $sort_order,
                                   'topics_page_url' => vam_db_prepare_input($topics_page_url),
       );

        if ($action == 'insert_topic') {
        	
					if ($_POST['topics_page_url'] == '' && file_exists(DIR_FS_CATALOG . '.htaccess') && AUTOMATIC_SEO_URL == 'true') {
						$alias = $_POST['topics_name'][$_SESSION['languages_id']];
						
						$alias = make_alias($alias);
                  $topics_page_url = $alias;

					} else {
						
                $topics_page_url = $_POST['topics_page_url'];
					}        	
        	
          $insert_sql_data = array('parent_id' => $current_topic_id,
                                   'topics_page_url' => vam_db_prepare_input($topics_page_url),
                                   'date_added' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

          vam_db_perform(TABLE_TOPICS, $sql_data_array);

          $topics_id = vam_db_insert_id();
        } elseif ($action == 'update_topic') {
          $update_sql_data = array('last_modified' => 'now()');

          $sql_data_array = array_merge($sql_data_array, $update_sql_data);

          vam_db_perform(TABLE_TOPICS, $sql_data_array, 'update', "topics_id = '" . (int)$topics_id . "'");
        }

        $languages = vam_get_languages();
        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {

          $language_id = $languages[$i]['id'];

          $sql_data_array = array('topics_name' => vam_db_prepare_input($_POST['topics_name'][$language_id]),
                                  'topics_heading_title' => vam_db_prepare_input($_POST['topics_heading_title'][$language_id]),
                                  'topics_meta_title' => vam_db_prepare_input($_POST['topics_meta_title'][$language_id]),
                                  'topics_meta_description' => vam_db_prepare_input($_POST['topics_meta_description'][$language_id]),
                                  'topics_meta_keywords' => vam_db_prepare_input($_POST['topics_meta_keywords'][$language_id]),
                                  'topics_description' => vam_db_prepare_input($_POST['topics_description'][$language_id]));

          if ($action == 'insert_topic') {
            $insert_sql_data = array('topics_id' => $topics_id,
                                     'language_id' => $languages[$i]['id']);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            vam_db_perform(TABLE_TOPICS_DESCRIPTION, $sql_data_array);
          } elseif ($action == 'update_topic') {
            vam_db_perform(TABLE_TOPICS_DESCRIPTION, $sql_data_array, 'update', "topics_id = '" . (int)$topics_id . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          }
        }

        if (USE_CACHE == 'true') {
          vam_reset_cache_block('topics');
        }

        vam_redirect(vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $topics_id));
        break;
        }
      case 'delete_topic_confirm':
        if (isset($_POST['topics_id'])) {
          $topics_id = vam_db_prepare_input($_POST['topics_id']);

          $topics = vam_get_topic_tree($topics_id, '', '0', '', true);
          $articles = array();
          $articles_delete = array();

          for ($i=0, $n=sizeof($topics); $i<$n; $i++) {
            $article_ids_query = vam_db_query("select articles_id from " . TABLE_ARTICLES_TO_TOPICS . " where topics_id = '" . (int)$topics[$i]['id'] . "'");

            while ($article_ids = vam_db_fetch_array($article_ids_query)) {
              $articles[$article_ids['articles_id']]['topics'][] = $topics[$i]['id'];
            }
          }

          foreach ($articles as $key => $value) {
            $topic_ids = '';

            for ($i=0, $n=sizeof($value['topics']); $i<$n; $i++) {
              $topic_ids .= "'" . (int)$value['topics'][$i] . "', ";
            }
            $topic_ids = substr($topic_ids, 0, -2);

            $check_query = vam_db_query("select count(*) as total from " . TABLE_ARTICLES_TO_TOPICS . " where articles_id = '" . (int)$key . "' and topics_id not in (" . $topic_ids . ")");
            $check = vam_db_fetch_array($check_query);
            if ($check['total'] < '1') {
              $articles_delete[$key] = $key;
            }
          }

// removing topics can be a lengthy process
          vam_set_time_limit(0);
          for ($i=0, $n=sizeof($topics); $i<$n; $i++) {
            vam_remove_topic($topics[$i]['id']);
          }

          foreach ($articles_delete as $key => $value) {
            vam_remove_article($key);
          }
        }

        if (USE_CACHE == 'true') {
          vam_reset_cache_block('topics');
        }

        vam_redirect(vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath));
        break;
      case 'delete_article_confirm':
        if (isset($_POST['articles_id']) && isset($_POST['article_topics']) && is_array($_POST['article_topics'])) {
          $article_id = vam_db_prepare_input($_POST['articles_id']);
          $article_topics = $_POST['article_topics'];

          for ($i=0, $n=sizeof($article_topics); $i<$n; $i++) {
            vam_db_query("delete from " . TABLE_ARTICLES_TO_TOPICS . " where articles_id = '" . (int)$article_id . "' and topics_id = '" . (int)$article_topics[$i] . "'");
          }

          $article_topics_query = vam_db_query("select count(*) as total from " . TABLE_ARTICLES_TO_TOPICS . " where articles_id = '" . (int)$article_id . "'");
          $article_topics = vam_db_fetch_array($article_topics_query);

          if ($article_topics['total'] == '0') {
            vam_remove_article($article_id);
          }
        }

        if (USE_CACHE == 'true') {
          vam_reset_cache_block('topics');
        }

        vam_redirect(vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath));
        break;
      case 'move_topic_confirm':
        if (isset($_POST['topics_id']) && ($_POST['topics_id'] != $_POST['move_to_topic_id'])) {
          $topics_id = vam_db_prepare_input($_POST['topics_id']);
          $new_parent_id = vam_db_prepare_input($_POST['move_to_topic_id']);

          $path = explode('_', vam_get_generated_topic_path_ids($new_parent_id));

          if (in_array($topics_id, $path)) {
            $messageStack->add_session(ERROR_CANNOT_MOVE_TOPIC_TO_PARENT, 'error');

            vam_redirect(vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $topics_id));
          } else {
            vam_db_query("update " . TABLE_TOPICS . " set parent_id = '" . (int)$new_parent_id . "', last_modified = now() where topics_id = '" . (int)$topics_id . "'");

            if (USE_CACHE == 'true') {
              vam_reset_cache_block('topics');
            }

            vam_redirect(vam_href_link(FILENAME_ARTICLES, 'tPath=' . $new_parent_id . '&tID=' . $topics_id));
          }
        }

        break;
      case 'move_article_confirm':
        $articles_id = vam_db_prepare_input($_POST['articles_id']);
        $new_parent_id = vam_db_prepare_input($_POST['move_to_topic_id']);

        $duplicate_check_query = vam_db_query("select count(*) as total from " . TABLE_ARTICLES_TO_TOPICS . " where articles_id = '" . (int)$articles_id . "' and topics_id = '" . (int)$new_parent_id . "'");
        $duplicate_check = vam_db_fetch_array($duplicate_check_query);
        if ($duplicate_check['total'] < 1) vam_db_query("update " . TABLE_ARTICLES_TO_TOPICS . " set topics_id = '" . (int)$new_parent_id . "' where articles_id = '" . (int)$articles_id . "' and topics_id = '" . (int)$current_topic_id . "'");

        if (USE_CACHE == 'true') {
          vam_reset_cache_block('topics');
        }

        vam_redirect(vam_href_link(FILENAME_ARTICLES, 'tPath=' . $new_parent_id . '&aID=' . $articles_id));
        break;
      case 'insert_article':
      case 'update_article':
        if (isset($_POST['edit_x']) || isset($_POST['edit_y'])) {
          $action = 'new_article';
        } else {
          if (isset($_GET['aID'])) $articles_id = vam_db_prepare_input($_GET['aID']);
          $articles_date_available = vam_db_prepare_input($_POST['articles_date_available']);
          $articles_date_added = vam_db_prepare_input($_POST['articles_date_added']);
          $articles_date_modified = $articles_date_added;

          $articles_keywords = vam_db_prepare_input($_POST['articles_keywords']);

          $articles_date_available = (date('Y-m-d') < $articles_date_available) ? $articles_date_available : 'null';

					if ($_POST['articles_page_url'] == '' && file_exists(DIR_FS_CATALOG . '.htaccess') && AUTOMATIC_SEO_URL == 'true') {
						$alias = $_POST['articles_name'][$_SESSION['languages_id']];
						
						$alias = make_alias($alias);
                  $articles_page_url = $alias;

					} else {
						
                $articles_page_url = $_POST['articles_page_url'];
					}    


$authorsImg = $_POST['articles_image'];

			if ($authorsImg == '' && $_POST['articles_image_name'] != '' && $authorsImg != $_POST['articles_image_name']) {
        $authorsImg = $_POST['articles_image_name'];
        }

					
          $sql_data_array = array('articles_date_available' => $articles_date_available,
                                  'articles_status' => vam_db_prepare_input($_POST['articles_status']),
                                  'articles_page_url' => vam_db_prepare_input($articles_page_url),
                                  'articles_keywords' => vam_db_prepare_input($articles_keywords),
                                  'sort_order' => vam_db_prepare_input($_POST['sort_order']),
                                  'articles_image' => vam_db_prepare_input($authorsImg),
                                  'authors_id' => vam_db_prepare_input($_POST['authors_id']));

          if ($action == 'insert_article') {

            // If expected article then articles_date _added becomes articles_date_available
            if (isset($_POST['articles_date_available']) && vam_not_null($_POST['articles_date_available'])) {
              $insert_sql_data = array('articles_date_added' => vam_db_prepare_input($_POST['articles_date_available']));
            } else {
              $insert_sql_data = array('articles_date_added' => 'now()');
            }
            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            vam_db_perform(TABLE_ARTICLES, $sql_data_array);
            $articles_id = vam_db_insert_id();

            vam_db_query("insert into " . TABLE_ARTICLES_TO_TOPICS . " (articles_id, topics_id) values ('" . (int)$articles_id . "', '" . (int)$current_topic_id . "')");
          } elseif ($action == 'update_article') {
            $update_sql_data = array('articles_last_modified' => 'now()');
            // If expected article then articles_date _added becomes articles_date_available
            if (isset($_POST['articles_date_available']) && vam_not_null($_POST['articles_date_available'])) {
              $update_sql_data = array('articles_date_added' => vam_db_prepare_input($_POST['articles_date_available']));
            }

              $update_sql_data = array('articles_date_added' => vam_db_prepare_input($_POST['articles_date_added']));

            $sql_data_array = array_merge($sql_data_array, $update_sql_data);

            vam_db_perform(TABLE_ARTICLES, $sql_data_array, 'update', "articles_id = '" . (int)$articles_id . "'");
          }

          $languages = vam_get_languages();
          for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
            $language_id = $languages[$i]['id'];


					if ($articles_head_title_tag == '') {
                  $articles_head_title_tag = $_POST['articles_name'][$language_id];
					} else {
                  $articles_head_title_tag = $_POST['articles_head_title_tag'][$language_id];
					}  

					if ($articles_head_desc_tag == '') {
                  $articles_head_desc_tag = $_POST['articles_name'][$language_id];
					} else {
                  $articles_head_desc_tag = $_POST['articles_head_desc_tag'][$language_id];
					}  

					if ($articles_head_keywords_tag == '') {
                  $articles_head_keywords_tag = $_POST['articles_name'][$language_id];
					} else {
                  $articles_head_keywords_tag = $_POST['articles_head_keywords_tag'][$language_id];
					}  

            $sql_data_array = array('articles_name' => vam_db_prepare_input($_POST['articles_name'][$language_id]),
                                    'articles_description' => vam_db_prepare_input($_POST['articles_description'][$language_id]),
                                    'articles_url' => vam_db_prepare_input($_POST['articles_url'][$language_id]),
                                    'articles_head_title_tag' => vam_db_prepare_input($_POST['articles_head_title_tag'][$language_id]),
                                    'articles_head_desc_tag' => vam_db_prepare_input($_POST['articles_head_desc_tag'][$language_id]),
                                    'articles_head_keywords_tag' => vam_db_prepare_input($_POST['articles_head_keywords_tag'][$language_id]));

            if ($action == 'insert_article') {
              $insert_sql_data = array('articles_id' => $articles_id,
                                       'language_id' => $language_id);

              $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

              vam_db_perform(TABLE_ARTICLES_DESCRIPTION, $sql_data_array);
            } elseif ($action == 'update_article') {
              vam_db_perform(TABLE_ARTICLES_DESCRIPTION, $sql_data_array, 'update', "articles_id = '" . (int)$articles_id . "' and language_id = '" . (int)$language_id . "'");
            }
          }

          if (USE_CACHE == 'true') {
            vam_reset_cache_block('topics');
          }

          vam_redirect(vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&aID=' . $articles_id));
        }
        break;
      case 'copy_to_confirm':
        if (isset($_POST['articles_id']) && isset($_POST['topics_id'])) {
          $articles_id = vam_db_prepare_input($_POST['articles_id']);
          $topics_id = vam_db_prepare_input($_POST['topics_id']);

          if ($_POST['copy_as'] == 'link') {
            if ($topics_id != $current_topic_id) {
              $check_query = vam_db_query("select count(*) as total from " . TABLE_ARTICLES_TO_TOPICS . " where articles_id = '" . (int)$articles_id . "' and topics_id = '" . (int)$topics_id . "'");
              $check = vam_db_fetch_array($check_query);
              if ($check['total'] < '1') {
                vam_db_query("insert into " . TABLE_ARTICLES_TO_TOPICS . " (articles_id, topics_id) values ('" . (int)$articles_id . "', '" . (int)$topics_id . "')");
              }
            } else {
              $messageStack->add_session(ERROR_CANNOT_LINK_TO_SAME_TOPIC, 'error');
            }
          } elseif ($_POST['copy_as'] == 'duplicate') {
            $article_query = vam_db_query("select articles_date_available, authors_id, authors_keywords, articles_page_url, sort_order from " . TABLE_ARTICLES . " where articles_id = '" . (int)$articles_id . "'");
            $article = vam_db_fetch_array($article_query);

            vam_db_query("insert into " . TABLE_ARTICLES . " (articles_date_added, articles_date_available, articles_status, authors_id, authors_keywords, articles_page_url, sort_order) values (now(), '" . vam_db_input($article['articles_date_available']) . "', '0', '" . (int)$article['authors_id'] . "', '" . (int)$article['articles_page_url'] . "', '" . (int)$article['sort_order'] . "')");
            $dup_articles_id = vam_db_insert_id();

            $description_query = vam_db_query("select language_id, articles_name, articles_description, articles_url, articles_head_title_tag, articles_head_desc_tag, articles_head_keywords_tag from " . TABLE_ARTICLES_DESCRIPTION . " where articles_id = '" . (int)$articles_id . "'");
            while ($description = vam_db_fetch_array($description_query)) {
              vam_db_query("insert into " . TABLE_ARTICLES_DESCRIPTION . " (articles_id, language_id, articles_name, articles_description, articles_url, articles_head_title_tag, articles_head_desc_tag, articles_head_keywords_tag, articles_viewed) values ('" . (int)$dup_articles_id . "', '" . (int)$description['language_id'] . "', '" . vam_db_input($description['articles_name']) . "', '" . vam_db_input($description['articles_description']) . "', '" . vam_db_input($description['articles_url']) . "', '" . vam_db_input($description['articles_head_title_tag']) . "', '" . vam_db_input($description['articles_head_desc_tag']) . "', '" . vam_db_input($description['articles_head_keywords_tag']) . "', '0')");
            }

            vam_db_query("insert into " . TABLE_ARTICLES_TO_TOPICS . " (articles_id, topics_id) values ('" . (int)$dup_articles_id . "', '" . (int)$topics_id . "')");
            $articles_id = $dup_articles_id;
          }

          if (USE_CACHE == 'true') {
            vam_reset_cache_block('topics');
          }
        }

        vam_redirect(vam_href_link(FILENAME_ARTICLES, 'tPath=' . $topics_id . '&aID=' . $articles_id));
        break;
    }
  }

// check if the catalog image directory exists
  if (is_dir(DIR_FS_CATALOG_IMAGES)) {
    if (!is_writeable(DIR_FS_CATALOG_IMAGES)) $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_NOT_WRITEABLE, 'error');
  } else {
    $messageStack->add(ERROR_CATALOG_IMAGE_DIRECTORY_DOES_NOT_EXIST, 'error');
  }
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset="<?php echo $_SESSION['language_charset']; ?>">
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
<?php 
	$query = vam_db_query("SELECT code FROM ".TABLE_LANGUAGES." WHERE languages_id='".$_SESSION['languages_id']."'");
	$data = vam_db_fetch_array($query);
	// generate editor for categories EDIT
	$languages = vam_get_languages();

	// generate editor for categories
  if ($_GET['action'] == 'new_topic_ACD' || $_GET['action'] == 'edit_topic_ACD') {
    //for ($i=0; $i<sizeof($languages); $i++) {
			echo vam_wysiwyg_tiny('topics_description', $data['code'], $languages[$i]['id']);
		//}
	}

	// generate editor for products
	if ($_GET['action'] == 'new_article') {
		//for ($i = 0; $i < sizeof($languages); $i ++) {
			echo vam_wysiwyg_tiny('articles_description', $data['code'], $languages[$i]['id']);
		//}
	} 
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
    <td class="boxCenter" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
 <?php
   //----- new_topic / edit_topic  -----
  if ($_GET['action'] == 'new_topic_ACD' || $_GET['action'] == 'edit_topic_ACD') {
    if ( ($_GET['tID']) && (!$_POST) ) {
      $topics_query = vam_db_query("select t.topics_id, td.topics_name, td.topics_heading_title, td.topics_meta_title, td.topics_meta_description, td.topics_meta_keywords, td.topics_description, t.parent_id, t.sort_order, t.date_added, t.last_modified, t.topics_page_url from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.topics_id = '" . $_GET['tID'] . "' and t.topics_id = td.topics_id and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by t.sort_order, td.topics_name");
      $topic = vam_db_fetch_array($topics_query);

      $tInfo = new objectInfo($topic);
    } elseif ($_POST) {
      $tInfo = new objectInfo($_POST);
      $topics_name = $_POST['topics_name'];
      $topics_heading_title = $_POST['topics_heading_title'];
      $topics_meta_title = $_POST['topics_meta_title'];
      $topics_meta_description = $_POST['topics_meta_description'];
      $topics_meta_keywords = $_POST['topics_meta_keywords'];
      $topics_description = $_POST['topics_description'];
      $topics_url = $_POST['topics_url'];
    } else {
      $tInfo = new objectInfo(array());
    }

    $languages = vam_get_languages();

    $text_new_or_edit = ($_GET['action']=='new_topic_ACD') ? TEXT_INFO_HEADING_NEW_TOPIC : TEXT_INFO_HEADING_EDIT_TOPIC;
?>
      <tr>
        <td>
<?php 
$manual_link = 'add-topic';
?>
       <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo sprintf($text_new_or_edit, vam_output_generated_topic_path($current_topic_id)); ?></td>
            <td class="pageHeading" align="right"><a class="button" href="<?php echo MANUAL_LINK_ARTICLES.'#'.$manual_link; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>
        
       </td>
      </tr>
      <tr><?php echo vam_draw_form('new_topic', FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $_GET['tID'] . '&action=new_topic_preview', 'post', 'enctype="multipart/form-data"'); ?>
        <td>

<?php echo vam_draw_hidden_field('topics_date_added', (($tInfo->date_added) ? $tInfo->date_added : date('Y-m-d'))) . vam_draw_hidden_field('parent_id', $tInfo->parent_id) . '<span class="button"><button type="submit" value="' . BUTTON_PREVIEW . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_PREVIEW . '</button></span>' . '&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $_GET['tID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?>

<div id="tabs">


			<ul>
<?php
    for ($i=0; $i<sizeof($languages); $i++) {
?>
				<li><a href="#tab<?php echo $i; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/'.$languages[$i]['code'].'.png', '', '16', '16'); ?>&nbsp;<?php echo $languages[$i]['name']; ?></a></li>
<?php 
}
?>
				<li><a href="#other"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/other.png', '', '16', '16'); ?>&nbsp;<?php echo TEXT_ARTICLE_OTHER; ?></a></li>
			</ul>

<?php
    for ($i=0; $i<sizeof($languages); $i++) {
?>

       <div id="tab<?php echo $i; ?>">
          <table border="0">

          <tr>
            <td class="main"><?php echo TEXT_EDIT_TOPICS_NAME; ?></td>
            <td class="main"><?php echo vam_draw_input_field('topics_name[' . $languages[$i]['id'] . ']', (($topics_name[$languages[$i]['id']]) ? stripslashes($topics_name[$languages[$i]['id']]) : vam_get_topic_name($tInfo->topics_id, $languages[$i]['id']))); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_EDIT_TOPICS_HEADING_TITLE; ?></td>
            <td class="main"><?php echo vam_draw_input_field('topics_heading_title[' . $languages[$i]['id'] . ']', (($topics_heading_title[$languages[$i]['id']]) ? stripslashes($topics_heading_title[$languages[$i]['id']]) : vam_get_topic_heading_title($tInfo->topics_id, $languages[$i]['id']))); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_ARTICLES_HEAD_TITLE_TAG; ?></td>
            <td class="main"><?php echo vam_draw_textarea_field('topics_meta_title[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($topics_meta_title[$languages[$i]['id']]) ? $topics_meta_title[$languages[$i]['id']] : vam_get_topic_meta_title($tInfo->topics_id, $languages[$i]['id'])),'class="notinymce"'); ?>
				<div id="title-result"></div>            
<script>
				function wordCount( val ){
    var wom = val.match(/\S+/g);
    return {
        charactersNoSpaces : val.replace(/\s+/g, '').length,
        characters         : val.length,
        words              : wom ? wom.length : 0,
        lines              : val.split(/\r*\n/).length
    };
}


var textarea = document.getElementById("topics_meta_title[1]");
var result_title   = document.getElementById("title-result");

textarea.addEventListener("input", function(){
  var v = wordCount( this.value );
  result_title.innerHTML = (
      //"<br>Characters (no spaces):  "+ v.charactersNoSpaces +
      + v.characters
      //"<br>Words: "+ v.words +
      //"<br>Lines: "+ v.lines
  );
}, false);
</script>
            </td>
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main" valign="top"><?php echo TEXT_ARTICLES_HEAD_DESC_TAG; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main"><?php echo vam_draw_textarea_field('topics_meta_description[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($topics_meta_description[$languages[$i]['id']]) ? $topics_meta_description[$languages[$i]['id']] : vam_get_topic_meta_description($tInfo->topics_id, $languages[$i]['id'])),'class="notinymce"'); ?></td>
              </tr>
            </table>
				<div id="desc-result"></div>            
<script>
var textarea = document.getElementById("topics_meta_description[1]");
var result_desc   = document.getElementById("desc-result");

textarea.addEventListener("input", function(){
  var v = wordCount( this.value );
  result_desc.innerHTML = (
      //"<br>Characters (no spaces):  "+ v.charactersNoSpaces +
      + v.characters
      //"<br>Words: "+ v.words +
      //"<br>Lines: "+ v.lines
  );
}, false);
</script>
            </td>            
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main" valign="top"><?php echo TEXT_ARTICLES_HEAD_KEYWORDS_TAG; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main"><?php echo vam_draw_textarea_field('topics_meta_keywords[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($topics_meta_keywords[$languages[$i]['id']]) ? $topics_meta_keywords[$languages[$i]['id']] : vam_get_topic_meta_keywords($tInfo->topics_id, $languages[$i]['id'])),'class="notinymce"'); ?></td>
              </tr>
            </table>
				<div id="key-result"></div>            
<script>
var textarea = document.getElementById("topics_meta_keywords[1]");
var result_key   = document.getElementById("key-result");

textarea.addEventListener("input", function(){
  var v = wordCount( this.value );
  result_key.innerHTML = (
      //"<br>Characters (no spaces):  "+ v.charactersNoSpaces +
      + v.characters
      //"<br>Words: "+ v.words +
      //"<br>Lines: "+ v.lines
  );
}, false);
</script>
            </td>             
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          
          <tr>
            <td class="main" valign="top"><?php echo TEXT_EDIT_TOPICS_DESCRIPTION; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
<td class="main">

<?php
          echo vam_draw_textarea_field('topics_description[' . $languages[$i]['id'] . ']', 'soft', '95', '25', (($topics_description[$languages[$i]['id']]) ? stripslashes($topics_description[$languages[$i]['id']]) : vam_get_topic_description($tInfo->topics_id, $languages[$i]['id']))); 
?>
<br /><a href="javascript:toggleHTMLEditor('<?php echo 'topics_description[' . $languages[$i]['id'] . ']';?>');"><?php echo TEXT_TOGGLE_EDITOR; ?></a>
</td>
              </tr>
            </table></td>
          </tr>

          </table>
        </div>
          
<?php
    }
?>

        <div id="other">
          <table border="0">

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_TOPIC_PAGE_URL; ?></td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('topics_page_url', $tInfo->topics_page_url, ''); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_EDIT_SORT_ORDER; ?></td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_input_field('sort_order', $tInfo->sort_order, 'size="2"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      
          </table>
        </div>
</div>      

      </form>
<?php
  //----- new_topic_preview -----
  } elseif ($_GET['action'] == 'new_topic_preview') {
    if ($_POST) {
      $tInfo = new objectInfo($_POST);
      $topics_name = $_POST['topics_name'];
      $topics_heading_title = $_POST['topics_heading_title'];
      $topics_meta_title = $_POST['topics_meta_title'];
      $topics_meta_description = $_POST['topics_meta_description'];
      $topics_meta_keywords = $_POST['topics_meta_keywords'];
      $topics_description = $_POST['topics_description'];
    } else {
      $topic_query = vam_db_query("select t.topics_id, td.language_id, td.topics_name, td.topics_heading_title, td.topics_meta_title, td.topics_meta_description, td.topics_meta_keywords, td.topics_description, t.sort_order, t.date_added, t.last_modified, t.topics_page_url from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.topics_id = td.topics_id and t.topics_id = '" . $_GET['tID'] . "'");
      $topic = vam_db_fetch_array($topic_query);

      $tInfo = new objectInfo($topic);
    }

    $form_action = ($_GET['tID']) ? 'update_topic' : 'insert_topic';

    echo vam_draw_form($form_action, FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $_GET['tID'] . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"');

    $languages = vam_get_languages();
    for ($i=0; $i<sizeof($languages); $i++) {
      if ($_GET['read'] == 'only') {
        $tInfo->topics_name = vam_get_topic_name($tInfo->topics_id, $languages[$i]['id']);
        $tInfo->topics_heading_title = vam_get_topic_heading_title($tInfo->topics_id, $languages[$i]['id']);
        $tInfo->topics_meta_title = vam_get_topic_meta_title($tInfo->topics_id, $languages[$i]['id']);
        $tInfo->topics_meta_description = vam_get_topic_meta_description($tInfo->topics_id, $languages[$i]['id']);
        $tInfo->topics_meta_keywords = vam_get_topic_meta_keywords($tInfo->topics_id, $languages[$i]['id']);
        $tInfo->topics_description = vam_get_topic_description($tInfo->topics_id, $languages[$i]['id']);
      } else {
        $tInfo->topics_name = vam_db_prepare_input($topics_name[$languages[$i]['id']]);
        $tInfo->topics_heading_title = vam_db_prepare_input($topics_heading_title[$languages[$i]['id']]);
        $tInfo->topics_meta_title = vam_db_prepare_input($topics_meta_title[$languages[$i]['id']]);
        $tInfo->topics_meta_description = vam_db_prepare_input($topics_meta_description[$languages[$i]['id']]);
        $tInfo->topics_meta_keywords = vam_db_prepare_input($topics_meta_keywords[$languages[$i]['id']]);
        $tInfo->topics_description = vam_db_prepare_input($topics_description[$languages[$i]['id']]);
      }
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo $languages[$i]['name'] . '&nbsp;' . $tInfo->topics_heading_title; ?></td>
          </tr>
          <tr>
            <td class="pageHeading"><?php echo $languages[$i]['name'] . '&nbsp;' . $tInfo->topics_name; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo $tInfo->topics_description; ?></td>
      </tr>

<?php
    }
    if ($_GET['read'] == 'only') {
      if ($_GET['origin']) {
        $pos_params = strpos($_GET['origin'], '?', 0);
        if ($pos_params != false) {
          $back_url = substr($_GET['origin'], 0, $pos_params);
          $back_url_params = substr($_GET['origin'], $pos_params + 1);
        } else {
          $back_url = $_GET['origin'];
          $back_url_params = '';
        }
      } else {
        $back_url = FILENAME_ARTICLES;
        $back_url_params = 'tPath=' . $tPath . '&tID=' . $tInfo->topics_id;
      }
?>
      <tr>
        <td align="right"><?php echo '<a class="button" href="' . vam_href_link($back_url, $back_url_params, 'NONSSL') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . BUTTON_BACK . '</span></a>'; ?></td>
      </tr>
<?php
    } else {
?>
      <tr>
        <td align="right" class="smallText">
<?php
/* Re-Post all POST'ed variables */
      foreach ($_POST as $key => $value) {
        if (!is_array($_POST[$key])) {
          echo vam_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
        }
      }
      $languages = vam_get_languages();
      for ($i=0; $i<sizeof($languages); $i++) {
        echo vam_draw_hidden_field('topics_name[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($topics_name[$languages[$i]['id']])));
        echo vam_draw_hidden_field('topics_heading_title[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($topics_heading_title[$languages[$i]['id']])));
        echo vam_draw_hidden_field('topics_meta_title[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($topics_meta_title[$languages[$i]['id']])));
        echo vam_draw_hidden_field('topics_meta_description[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($topics_meta_description[$languages[$i]['id']])));
        echo vam_draw_hidden_field('topics_meta_keywords[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($topics_meta_keywords[$languages[$i]['id']])));
        echo vam_draw_hidden_field('topics_description[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($topics_description[$languages[$i]['id']])));
      }

      echo '<span class="button"><button type="submit" value="' . BUTTON_BACK . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . BUTTON_BACK . '</button></span>&nbsp;&nbsp;';

      if ($_GET['tID']) {
        echo '<span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>';
      } else {
        echo '<span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>';
      }
      echo '&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $_GET['tID']) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>';
?></td>
      </form></tr>
<?php
    }
  } elseif ($action == 'new_article') {
    $parameters = array('articles_name' => '',
                       'articles_description' => '',
                       'articles_url' => '',
                       'articles_head_title_tag' => '',
                       'articles_head_desc_tag' => '',
                       'articles_head_keywords' => '',
                       'articles_id' => '',
                       'articles_date_added' => '',
                       'articles_last_modified' => '',
                       'articles_date_available' => '',
                       'articles_status' => '',
                       'authors_id' => '',
                       'articles_page_url' => '',
                       'articles_keywords' => '',
                       'sort_order' => '');

    $aInfo = new objectInfo($parameters);

    if (isset($_GET['aID']) && empty($_POST)) {
      $article_query = vam_db_query("select ad.articles_name, ad.articles_description, ad.articles_url, ad.articles_head_title_tag, ad.articles_head_desc_tag, ad.articles_head_keywords_tag, a.articles_id, a.articles_keywords, a.articles_date_added, a.articles_last_modified, date_format(a.articles_date_available, '%Y-%m-%d') as articles_date_available, a.articles_status, a.articles_page_url, a.articles_image, a.sort_order, a.authors_id from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_id = '" . (int)$_GET['aID'] . "' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "'");
      $article = vam_db_fetch_array($article_query);

      $aInfo->objectInfo($article);
    } elseif (vam_not_null($_POST)) {
      $aInfo->objectInfo($_POST);
      $articles_name = $_POST['articles_name'];
      $articles_description = $_POST['articles_description'];
      $articles_url = $_POST['articles_url'];
      $articles_head_title_tag = $_POST['articles_head_title_tag'];
      $articles_head_desc_tag = $_POST['articles_head_desc_tag'];
      $articles_head_keywords_tag = $_POST['articles_head_keywords_tag'];
      
					if ($articles_head_title_tag == '') {
                  $articles_head_title_tag = $_POST['articles_name'];
					}

					if ($articles_head_desc_tag == '') {
                  $articles_head_desc_tag = $_POST['articles_name'];
					}

					if ($articles_head_keywords_tag == '') {
                  $articles_head_keywords_tag = $_POST['articles_name'];
					}      
      
      
    }

    $authors_array = array(array('id' => '', 'text' => TEXT_NONE));
    $authors_query = vam_db_query("select authors_id, authors_name from " . TABLE_AUTHORS . " order by authors_name");
    while ($authors = vam_db_fetch_array($authors_query)) {
      $authors_array[] = array('id' => $authors['authors_id'],
                                     'text' => $authors['authors_name']);
    }

    $languages = vam_get_languages();

    if (!isset($aInfo->articles_status)) $aInfo->articles_status = '1';
    switch ($aInfo->articles_status) {
      case '0': $in_status = false; $out_status = true; break;
      case '1':
      default: $in_status = true; $out_status = false;
    }
?>
<link href="includes/javascript/date-picker/css/datepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/javascript/date-picker/js/datepicker.js"></script>
    <?php echo vam_draw_form('new_article', FILENAME_ARTICLES, 'tPath=' . $tPath . (isset($_GET['aID']) ? '&aID=' . $_GET['aID'] : '') . '&action=article_preview', 'post', 'enctype="multipart/form-data"'); ?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td>
        
<?php 
$manual_link = 'add-article';
if ($_GET['action'] == 'new_article' and isset($_GET['aID'])) {
$manual_link = 'edit-article';
}  
?>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo sprintf(TEXT_NEW_ARTICLE, vam_output_generated_topic_path($current_topic_id)); ?></td>
            <td class="pageHeading" align="right"><a class="button" href="<?php echo MANUAL_LINK_ARTICLES.'#'.$manual_link; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>
                
        </td>
      </tr>
      <tr>
        <td>

<?php echo vam_draw_hidden_field('articles_date_added', (vam_not_null($aInfo->articles_date_added) ? $aInfo->articles_date_added : date('Y-m-d'))) . '<span class="button"><button type="submit" value="' . BUTTON_PREVIEW . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_PREVIEW . '</button></span>' . '&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . (isset($_GET['aID']) ? '&aID=' . $_GET['aID'] : '')) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?>

<div id="tabs">

			<ul>
<?php
    for ($i=0; $i<sizeof($languages); $i++) {
?>
				<li><a href="#tab<?php echo $i; ?>"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/'.$languages[$i]['code'].'.png', '', '16', '16'); ?>&nbsp;<?php echo $languages[$i]['name']; ?></a></li>
<?php 
}
?>
				<li><a href="#other"><?php echo vam_image(DIR_WS_IMAGES . 'icons/tabs/other.png', '', '16', '16'); ?>&nbsp;<?php echo TEXT_ARTICLE_OTHER; ?></a></li>
			</ul>

<?php
    for ($i=0; $i<sizeof($languages); $i++) {
?>

        <div id="tab<?php echo $i; ?>">
          <table border="0">

          <tr>
            <td class="main"><?php echo TEXT_ARTICLES_NAME; ?></td>
            <td class="main"><?php echo vam_draw_input_field('articles_name[' . $languages[$i]['id'] . ']', (isset($articles_name[$languages[$i]['id']]) ? $articles_name[$languages[$i]['id']] : vam_get_articles_name($aInfo->articles_id, $languages[$i]['id'])), 'size="35"'); ?></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_ARTICLES_HEAD_TITLE_TAG; ?></td>
            <td class="main"><?php echo vam_draw_textarea_field('articles_head_title_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($articles_head_title_tag[$languages[$i]['id']]) ? $articles_head_title_tag[$languages[$i]['id']] : vam_get_articles_head_title_tag($aInfo->articles_id, $languages[$i]['id'])),'class="notinymce"'); ?>
				<div id="title-result"></div>            
<script>
				function wordCount( val ){
    var wom = val.match(/\S+/g);
    return {
        charactersNoSpaces : val.replace(/\s+/g, '').length,
        characters         : val.length,
        words              : wom ? wom.length : 0,
        lines              : val.split(/\r*\n/).length
    };
}


var textarea = document.getElementById("articles_head_title_tag[1]");
var result_title   = document.getElementById("title-result");

textarea.addEventListener("input", function(){
  var v = wordCount( this.value );
  result_title.innerHTML = (
      //"<br>Characters (no spaces):  "+ v.charactersNoSpaces +
      + v.characters
      //"<br>Words: "+ v.words +
      //"<br>Lines: "+ v.lines
  );
}, false);
</script>
            </td>
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main" valign="top"><?php echo TEXT_ARTICLES_HEAD_DESC_TAG; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main"><?php echo vam_draw_textarea_field('articles_head_desc_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($articles_head_desc_tag[$languages[$i]['id']]) ? $articles_head_desc_tag[$languages[$i]['id']] : vam_get_articles_head_desc_tag($aInfo->articles_id, $languages[$i]['id'])),'class="notinymce"'); ?></td>
              </tr>
            </table>
				<div id="desc-result"></div>            
<script>
var textarea = document.getElementById("articles_head_desc_tag[1]");
var result_desc   = document.getElementById("desc-result");

textarea.addEventListener("input", function(){
  var v = wordCount( this.value );
  result_desc.innerHTML = (
      //"<br>Characters (no spaces):  "+ v.charactersNoSpaces +
      + v.characters
      //"<br>Words: "+ v.words +
      //"<br>Lines: "+ v.lines
  );
}, false);
</script>
            </td>            
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main" valign="top"><?php echo TEXT_ARTICLES_HEAD_KEYWORDS_TAG; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="main"><?php echo vam_draw_textarea_field('articles_head_keywords_tag[' . $languages[$i]['id'] . ']', 'soft', '70', '5', (isset($articles_head_keywords_tag[$languages[$i]['id']]) ? $articles_head_keywords_tag[$languages[$i]['id']] : vam_get_articles_head_keywords_tag($aInfo->articles_id, $languages[$i]['id'])),'class="notinymce"'); ?></td>
              </tr>
            </table>
				<div id="key-result"></div>            
<script>
var textarea = document.getElementById("articles_head_keywords_tag[1]");
var result_key   = document.getElementById("key-result");

textarea.addEventListener("input", function(){
  var v = wordCount( this.value );
  result_key.innerHTML = (
      //"<br>Characters (no spaces):  "+ v.charactersNoSpaces +
      + v.characters
      //"<br>Words: "+ v.words +
      //"<br>Lines: "+ v.lines
  );
}, false);
</script>
            </td>             
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main" valign="top"><?php echo TEXT_ARTICLES_DESCRIPTION; ?></td>
            <td><table border="0" cellspacing="0" cellpadding="0">
              <tr>

<td class="main">

<?php
          echo vam_draw_textarea_field('articles_description[' . $languages[$i]['id'] . ']', 'soft', '95', '25', (($articles_description[$languages[$i]['id']]) ? stripslashes($articles_description[$languages[$i]['id']]) : vam_get_articles_description($aInfo->articles_id, $languages[$i]['id'])));
?>
<br /><a href="javascript:toggleHTMLEditor('<?php echo 'articles_description[' . $languages[$i]['id'] . ']';?>');"><?php echo TEXT_TOGGLE_EDITOR; ?></a>
</td>

              </tr>
            </table></td>
          </tr>

          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_ARTICLES_URL . '<br><small>' . TEXT_ARTICLES_URL_WITHOUT_HTTP . '</small>'; ?></td>
            <td class="main"><?php echo vam_draw_input_field('articles_url[' . $languages[$i]['id'] . ']', (isset($articles_url[$languages[$i]['id']]) ? $articles_url[$languages[$i]['id']] : vam_get_articles_url($aInfo->articles_id, $languages[$i]['id'])), 'size="35"'); ?></td>
          </tr>
          
          </table>
          </div>
<?php
    }


//$image_field = vam_draw_input_field('articles_image', $aInfo->articles_image, 'disabled size="20"');	
$image_field .= vam_draw_input_field('articles_image_name', $aInfo->articles_image, 'size="20"');	
$image_field .= vam_draw_file_field('articles_image');	

?>
        <div id="other">
          <table border="0">
          <tr>
            <td class="smallText"><?php echo TEXT_ARTICLE_IMAGE; ?></td>
            <td><?php echo $image_field; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>

          <tr>
            <td class="main"><?php echo TEXT_ARTICLE_KEYWORDS; ?></td>
            <td class="main"><?php echo vam_draw_input_field('articles_keywords', $aInfo->articles_keywords, ''); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_ARTICLE_PAGE_URL; ?></td>
            <td class="main"><?php echo vam_draw_input_field('articles_page_url', $aInfo->articles_page_url, ''); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_ARTICLES_STATUS; ?></td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_radio_field('articles_status', '0', $out_status) . '&nbsp;' . TEXT_ARTICLE_NOT_AVAILABLE . '&nbsp;' . vam_draw_radio_field('articles_status', '1', $in_status) . '&nbsp;' . TEXT_ARTICLE_AVAILABLE; ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_ARTICLES_DATE_AVAILABLE; ?><br><small>(YYYY-MM-DD)</small></td>
            <td class="main"><?php echo vam_draw_input_field('articles_date_available', $aInfo->articles_date_available, 'size="20" class="format-y-m-d dividor-slash"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_DATE_ADDED; ?><br><small>(YYYY-MM-DD)</small></td>
            <td class="main"><?php echo vam_draw_input_field('articles_date_added', $aInfo->articles_date_added, 'size="20" class="format-y-m-d dividor-slash"'); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
          <tr>
            <td class="main"><?php echo TEXT_ARTICLES_AUTHOR; ?></td>
            <td class="main"><?php echo vam_draw_separator('pixel_trans.gif', '24', '15') . '&nbsp;' . vam_draw_pull_down_menu('authors_id', $authors_array, $aInfo->authors_id); ?></td>
          </tr>
          <tr>
            <td colspan="2"><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_ARTICLE_SORT_ORDER; ?></td>
            <td class="main"><?php echo vam_draw_input_field('sort_order', $aInfo->sort_order, 'size="5"'); ?></td>
          </tr>

</table>
</div>

</div>

        </table></td>
      </tr>
    </table></form>
<?php
  } elseif ($action == 'article_preview') {
    if (vam_not_null($_POST)) {
      $aInfo = new objectInfo($_POST);
      $articles_name = $_POST['articles_name'];
      //$articles_image = $_POST['articles_image'];
      $articles_description = $_POST['articles_description'];
      $articles_url = $_POST['articles_url'];
      $articles_head_title_tag = $_POST['articles_head_title_tag'];
      $articles_head_desc_tag = $_POST['articles_head_desc_tag'];
      $articles_head_keywords_tag = $_POST['articles_head_keywords_tag'];
      

        $authorsImg = '';
        $authors_image = new upload('articles_image');
        $authors_image->set_destination(DIR_FS_CATALOG_IMAGES .'articles/');

        if ($authors_image->parse() && $authors_image->save()) {
            $authorsImg = vam_db_input($authors_image->filename);
        }

      $articles_image = $authorsImg;
      
					if ($articles_head_title_tag == '') {
                  $articles_head_title_tag = $_POST['articles_name'];
					}

					if ($articles_head_desc_tag == '') {
                  $articles_head_desc_tag = $_POST['articles_name'];
					}

					if ($articles_head_keywords_tag == '') {
                  $articles_head_keywords_tag = $_POST['articles_name'];
					}        
      
    } else {
      $article_query = vam_db_query("select a.articles_id, a.articles_image, ad.language_id, ad.articles_name, ad.articles_description, ad.articles_url, ad.articles_head_title_tag, ad.articles_head_desc_tag, ad.articles_head_keywords_tag, a.articles_date_added, a.articles_last_modified, a.articles_date_available, a.articles_status, a.authors_id  from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad where a.articles_id = ad.articles_id and a.articles_id = '" . (int)$_GET['aID'] . "'");
      $article = vam_db_fetch_array($article_query);

      $aInfo = new objectInfo($article);
    }

    $form_action = (isset($_GET['aID'])) ? 'update_article' : 'insert_article';


    echo vam_draw_form($form_action, FILENAME_ARTICLES, 'tPath=' . $tPath . (isset($_GET['aID']) ? '&aID=' . $_GET['aID'] : '') . '&action=' . $form_action, 'post', 'enctype="multipart/form-data"');

    $languages = vam_get_languages();
    for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
      if (isset($_GET['read']) && ($_GET['read'] == 'only')) {
        $aInfo->articles_name = vam_get_articles_name($aInfo->articles_id, $languages[$i]['id']);
        $aInfo->articles_image = $aInfo->articles_image;
        $aInfo->articles_description = vam_get_articles_description($aInfo->articles_id, $languages[$i]['id']);
        $aInfo->articles_url = vam_get_articles_url($aInfo->articles_id, $languages[$i]['id']);
        $aInfo->articles_head_title_tag = vam_get_articles_head_title_tag($aInfo->articles_id, $languages[$i]['id']);
        $aInfo->articles_head_desc_tag = vam_get_articles_head_desc_tag($aInfo->articles_id, $languages[$i]['id']);
        $aInfo->articles_head_keywords_tag = vam_get_articles_head_keywords_tag($aInfo->articles_id, $languages[$i]['id']);
      } else {
        $aInfo->articles_image = vam_db_prepare_input($articles_image);
        $aInfo->articles_name = vam_db_prepare_input($articles_name[$languages[$i]['id']]);
        $aInfo->articles_description = vam_db_prepare_input($articles_description[$languages[$i]['id']]);
        $aInfo->articles_url = vam_db_prepare_input($articles_url[$languages[$i]['id']]);
        $aInfo->articles_head_title_tag = vam_db_prepare_input($articles_head_title_tag[$languages[$i]['id']]);
        $aInfo->articles_head_desc_tag = vam_db_prepare_input($articles_head_desc_tag[$languages[$i]['id']]);
        $aInfo->articles_head_keywords_tag = vam_db_prepare_input($articles_head_keywords_tag[$languages[$i]['id']]);
      }
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading" colspan="2"><?php echo $languages[$i]['name'] . '&nbsp;' . $aInfo->articles_name; ?></td>
          </tr>
        </table></td>
      </tr>
<?php
      if ($aInfo->articles_description) {
?>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo $aInfo->articles_description; ?></td>
      </tr>
<?php
      }
?>
<?php
      if ($aInfo->articles_url) {
?>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><?php echo sprintf(TEXT_ARTICLE_MORE_INFORMATION, $aInfo->articles_url); ?></td>
      </tr>
<?php
      }
?>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
      if ($aInfo->articles_date_available > date('Y-m-d')) {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_ARTICLE_DATE_AVAILABLE, vam_date_long($aInfo->articles_date_available)); ?></td>
      </tr>
<?php
      } else {
?>
      <tr>
        <td align="center" class="smallText"><?php echo sprintf(TEXT_ARTICLE_DATE_ADDED, vam_date_long($aInfo->articles_date_added)); ?></td>
      </tr>
<?php
      }
?>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php
    }

    if (isset($_GET['read']) && ($_GET['read'] == 'only')) {
      if (isset($_GET['origin'])) {
        $pos_params = strpos($_GET['origin'], '?', 0);
        if ($pos_params != false) {
          $back_url = substr($_GET['origin'], 0, $pos_params);
          $back_url_params = substr($_GET['origin'], $pos_params + 1);
        } else {
          $back_url = $_GET['origin'];
          $back_url_params = '';
        }
      } else {
        $back_url = FILENAME_ARTICLES;
        $back_url_params = 'tPath=' . $tPath . '&aID=' . $aInfo->articles_id;
      }
?>
      <tr>
        <td align="right"><?php echo '<a class="button" href="' . vam_href_link($back_url, $back_url_params, 'NONSSL') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . BUTTON_BACK . '</span></a>'; ?></td>
      </tr>
<?php
    } else {
?>
      <tr>
        <td align="right" class="smallText">
<?php





/* Re-Post all POST'ed variables */
      foreach ($_POST as $key => $value) {
        if (!is_array($_POST[$key])) {
          echo vam_draw_hidden_field($key, htmlspecialchars(stripslashes($value)));
        }
      }
        echo vam_draw_hidden_field('articles_image', htmlspecialchars(stripslashes($articles_image)));

      $languages = vam_get_languages();
      for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
        echo vam_draw_hidden_field('articles_name[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($articles_name[$languages[$i]['id']])));
        echo vam_draw_hidden_field('articles_description[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($articles_description[$languages[$i]['id']])));
        echo vam_draw_hidden_field('articles_url[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($articles_url[$languages[$i]['id']])));
        echo vam_draw_hidden_field('articles_head_title_tag[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($articles_head_title_tag[$languages[$i]['id']])));
        echo vam_draw_hidden_field('articles_head_desc_tag[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($articles_head_desc_tag[$languages[$i]['id']])));
        echo vam_draw_hidden_field('articles_head_keywords_tag[' . $languages[$i]['id'] . ']', htmlspecialchars(stripslashes($articles_head_keywords_tag[$languages[$i]['id']])));
      }

      echo '<span class="button"><button type="submit" name="edit" value="' . BUTTON_BACK . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . BUTTON_BACK . '</button></span>' . '&nbsp;&nbsp;';

      if (isset($_GET['aID'])) {
        echo '<span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>';
      } else {
        echo '<span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>';
      }
      echo '&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . (isset($_GET['aID']) ? '&aID=' . $_GET['aID'] : '')) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>';
?></td>
      </tr>
    </table></form>
<?php
    }
  } else {
?>
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2" class="pageHeading">
            
            
<?php 
$manual_link = 'add-article';
if ($_GET['action'] == 'delete_article') {
$manual_link = 'delete-article';
}  
if ($_GET['action'] == 'move_article') {
$manual_link = 'move-article';
}  
if ($_GET['action'] == 'copy_to') {
$manual_link = 'copy-article';
}  
?>
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php if (sizeof($tPath_array) > 0) echo '<a class="button" href="' . vam_href_link(FILENAME_ARTICLES, $tPath_back . 'tID=' . $current_topic_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . BUTTON_BACK . '</span></a>&nbsp;'; if (!isset($_GET['search'])) echo '<a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&action=new_topic') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/categories.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_TOPIC . '</span></a>&nbsp;<a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&action=new_article') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/products.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_ARTICLE . '</span></a>'; ?>&nbsp;<a class="button" href="<?php echo MANUAL_LINK_ARTICLES.'#'.$manual_link; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?>&nbsp;<?php echo TEXT_MANUAL_LINK; ?></span></a></td>
          </tr>
        </table>
            
            
            </td>
          </tr>
          <tr>
            <td class="pageHeading" align="right"><?php echo vam_draw_separator('pixel_trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr>
                <td class="smallText" align="right">
<?php
    echo vam_draw_form('search', FILENAME_ARTICLES, '', 'get');
    echo HEADING_TITLE_SEARCH . ' ' . vam_draw_input_field('search');
    echo '</form>';
?>
                </td>
              </tr>
              <tr>
                <td class="smallText" align="right">
<?php
    echo vam_draw_form('goto', FILENAME_ARTICLES, '', 'get');
    echo HEADING_TITLE_GOTO . ' ' . vam_draw_pull_down_menu('tPath', vam_get_topic_tree(), $current_topic_id, 'onChange="this.form.submit();"');
    echo '</form>';
?>
                </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TOPICS_ARTICLES; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ID; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $topics_count = 0;
    $rows = 0;
    if (isset($_GET['search'])) {
      $search = vam_db_prepare_input($_GET['search']);

      $topics_query = vam_db_query("select t.topics_id, td.topics_name, t.parent_id, t.sort_order, t.date_added, t.last_modified from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.topics_id = td.topics_id and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.topics_name like '%" . vam_db_input($search) . "%' order by t.sort_order, td.topics_name");
    } else {
      $topics_query = vam_db_query("select t.topics_id, td.topics_name, t.parent_id, t.sort_order, t.date_added, t.last_modified from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.parent_id = '" . (int)$current_topic_id . "' and t.topics_id = td.topics_id and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by t.sort_order, td.topics_name");
    }
    while ($topics = vam_db_fetch_array($topics_query)) {
      $topics_count++;
      $rows++;

// Get parent_id for subtopics if search
      if (isset($_GET['search'])) $tPath= $topics['parent_id'];

      if ((!isset($_GET['tID']) && !isset($_GET['aID']) || (isset($_GET['tID']) && ($_GET['tID'] == $topics['topics_id']))) && !isset($tInfo) && (substr($action, 0, 3) != 'new')) {
        $topic_childs = array('childs_count' => vam_childs_in_topic_count($topics['topics_id']));
        $topic_articles = array('articles_count' => vam_articles_in_topic_count($topics['topics_id']));

        $tInfo_array = array_merge($topics, $topic_childs, $topic_articles);
        $tInfo = new objectInfo($tInfo_array);
      }

      if (isset($tInfo) && is_object($tInfo) && ($topics['topics_id'] == $tInfo->topics_id) ) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . vam_href_link(FILENAME_ARTICLES, vam_get_topic_path($topics['topics_id'])) . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $topics['topics_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . vam_href_link(FILENAME_ARTICLES, vam_get_topic_path($topics['topics_id'])) . '">' . vam_image(DIR_WS_ICONS . 'folder.gif', ICON_FOLDER) . '</a>&nbsp;<b>' . $topics['topics_name'] . '</b>'; ?></td>
                <td class="dataTableContent" align="center"><?php echo $topics['topics_id']; ?></td>
                <td class="dataTableContent" align="center">&nbsp;</td>
                <td class="dataTableContent" align="right"><?php if (isset($tInfo) && is_object($tInfo) && ($topics['topics_id'] == $tInfo->topics_id) ) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $topics['topics_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

    $articles_count = 0;
    if (isset($_GET['search'])) {
      $articles_query = vam_db_query("select a.articles_id, a.articles_image, ad.articles_name, a.articles_date_added, a.articles_last_modified, a.articles_date_available, a.articles_status, a2t.topics_id from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t where a.articles_id = ad.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and a.articles_id = a2t.articles_id and ad.articles_name like '%" . vam_db_input($search) . "%' order by a.articles_id DESC");    } else {
      $articles_query = vam_db_query("select a.articles_id, a.articles_image, ad.articles_name, a.articles_date_added, a.articles_last_modified, a.articles_date_available, a.articles_status from " . TABLE_ARTICLES . " a, " . TABLE_ARTICLES_DESCRIPTION . " ad, " . TABLE_ARTICLES_TO_TOPICS . " a2t where a.articles_id = ad.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and a.articles_id = a2t.articles_id and a2t.topics_id = '" . (int)$current_topic_id . "' order by a.articles_id DESC");
    }
    while ($articles = vam_db_fetch_array($articles_query)) {
      $articles_count++;
      $rows++;

// Get topics_id for article if search
      if (isset($_GET['search'])) $tPath = $articles['topics_id'];

      if ( (!isset($_GET['aID']) && !isset($_GET['tID']) || (isset($_GET['aID']) && ($_GET['aID'] == $articles['articles_id']))) && !isset($aInfo) && !isset($tInfo) && (substr($action, 0, 3) != 'new')) {
        $aInfo_array = array_merge($articles);
        $aInfo = new objectInfo($aInfo_array);
      }

      if (isset($aInfo) && is_object($aInfo) && ($articles['articles_id'] == $aInfo->articles_id) ) {
        echo '              <tr id="defaultSelected" class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&aID=' . $articles['articles_id'] . '&action=article_preview&read=only') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)" onclick="document.location.href=\'' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&aID=' . $articles['articles_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&aID=' . $articles['articles_id'] . '&action=article_preview&read=only') . '">' . vam_image(DIR_WS_ICONS . 'preview.gif', ICON_PREVIEW) . '</a>' . '&nbsp;' . $articles['articles_name']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $articles['articles_id']; ?></td>
                <td class="dataTableContent" align="center">
<?php
      if ($articles['articles_status'] == '1') {
        echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_ARTICLES, 'action=setflag&flag=0&aID=' . $articles['articles_id'] . '&tPath=' . $tPath) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
      } else {
        echo '<a href="' . vam_href_link(FILENAME_ARTICLES, 'action=setflag&flag=1&aID=' . $articles['articles_id'] . '&tPath=' . $tPath) . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
      }
?></td>
                <td class="dataTableContent" align="right"><?php if (isset($aInfo) && is_object($aInfo) && ($articles['articles_id'] == $aInfo->articles_id)) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&aID=' . $articles['articles_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }

    $tPath_back = '';
    if (sizeof($tPath_array) > 0) {
      for ($i=0, $n=sizeof($tPath_array)-1; $i<$n; $i++) {
        if (empty($tPath_back)) {
          $tPath_back .= $tPath_array[$i];
        } else {
          $tPath_back .= '_' . $tPath_array[$i];
        }
      }
    }

    $tPath_back = (vam_not_null($tPath_back)) ? 'tPath=' . $tPath_back . '&' : '';
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo TEXT_TOPICS . '&nbsp;' . $topics_count . '<br>' . TEXT_ARTICLES . '&nbsp;' . $articles_count; ?></td>
                    <td align="right" class="smallText"><?php if (sizeof($tPath_array) > 0) echo '<a class="button" href="' . vam_href_link(FILENAME_ARTICLES, $tPath_back . 'tID=' . $current_topic_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12') . '&nbsp;' . BUTTON_BACK . '</span></a>&nbsp;'; if (!isset($_GET['search'])) echo '<a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&action=new_topic') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/categories.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_TOPIC . '</span></a>&nbsp;<a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&action=new_article') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/products.png', '', '12', '12') . '&nbsp;' . BUTTON_NEW_ARTICLE . '</span></a>'; ?>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();
    switch ($action) {
      case 'new_topic':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_TOPIC . '</b>');

        $contents = array('form' => vam_draw_form('newtopic', FILENAME_ARTICLES, 'action=insert_topic&tPath=' . $tPath, 'post', 'enctype="multipart/form-data"'));
        $contents[] = array('text' => TEXT_NEW_TOPIC_INTRO);

        $topic_inputs_string = '';
        $languages = vam_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $topic_inputs_string .= '<br>' . $languages[$i]['name'] . '&nbsp;' . vam_draw_input_field('topics_name[' . $languages[$i]['id'] . ']');
        }

        $contents[] = array('text' => '<br>' . TEXT_TOPICS_NAME . $topic_inputs_string);
        $contents[] = array('text' => '<br>' . TEXT_SORT_ORDER . '<br>' . vam_draw_input_field('sort_order', '', 'size="2"'));
        $contents[] = array('align' => 'center', 'text' => '<br>' . '<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>' . ' <a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;
      case 'edit_topic':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_TOPIC . '</b>');

        $contents = array('form' => vam_draw_form('topics', FILENAME_ARTICLES, 'action=update_topic&tPath=' . $tPath, 'post', 'enctype="multipart/form-data"') . vam_draw_hidden_field('topics_id', $tInfo->topics_id));
        $contents[] = array('text' => TEXT_EDIT_INTRO);

        $topic_inputs_string = '';
        $languages = vam_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $topic_inputs_string .= '<br>' . $languages[$i]['name'] . '&nbsp;' . vam_draw_input_field('topics_name[' . $languages[$i]['id'] . ']', vam_get_topic_name($tInfo->topics_id, $languages[$i]['id']));
        }

        $contents[] = array('text' => '<br>' . TEXT_EDIT_TOPICS_NAME . $topic_inputs_string);
        $contents[] = array('text' => '<br>' . TEXT_EDIT_SORT_ORDER . '<br>' . vam_draw_input_field('sort_order', $tInfo->sort_order, 'size="2"'));
        $contents[] = array('align' => 'center', 'text' => '<br>' . '<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . '&nbsp;' . BUTTON_SAVE . '</button></span>' . ' <a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $tInfo->topics_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;
      case 'delete_topic':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_TOPIC . '</b>');

        $contents = array('form' => vam_draw_form('topics', FILENAME_ARTICLES, 'action=delete_topic_confirm&tPath=' . $tPath) . vam_draw_hidden_field('topics_id', $tInfo->topics_id));
        $contents[] = array('text' => TEXT_DELETE_TOPIC_INTRO);
        $contents[] = array('text' => '<br><b>' . $tInfo->topics_name . '</b>');
        if ($tInfo->childs_count > 0) $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_CHILDS, $tInfo->childs_count));
        if ($tInfo->articles_count > 0) $contents[] = array('text' => '<br>' . sprintf(TEXT_DELETE_WARNING_ARTICLES, $tInfo->articles_count));
        $contents[] = array('align' => 'center', 'text' => '<br>' . '<span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span>' . ' <a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $tInfo->topics_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;
      case 'move_topic':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_TOPIC . '</b>');

        $contents = array('form' => vam_draw_form('topics', FILENAME_ARTICLES, 'action=move_topic_confirm&tPath=' . $tPath) . vam_draw_hidden_field('topics_id', $tInfo->topics_id));
        $contents[] = array('text' => sprintf(TEXT_MOVE_TOPICS_INTRO, $tInfo->topics_name));
        $contents[] = array('text' => '<br>' . sprintf(TEXT_MOVE, $tInfo->topics_name) . '<br>' . vam_draw_pull_down_menu('move_to_topic_id', vam_get_topic_tree(), $current_topic_id));
        $contents[] = array('align' => 'center', 'text' => '<br>' . '<span class="button"><button type="submit" value="' . BUTTON_MOVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/move.png', '', '12', '12') . '&nbsp;' . BUTTON_MOVE . '</button></span>' . ' <a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $tInfo->topics_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;
      case 'delete_article':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ARTICLE . '</b>');

        $contents = array('form' => vam_draw_form('articles', FILENAME_ARTICLES, 'action=delete_article_confirm&tPath=' . $tPath) . vam_draw_hidden_field('articles_id', $aInfo->articles_id));
        $contents[] = array('text' => TEXT_DELETE_ARTICLE_INTRO);
        $contents[] = array('text' => '<br><b>' . $aInfo->articles_name . '</b>');

        $article_topics_string = '';
        $article_topics = vam_generate_topic_path($aInfo->articles_id, 'article');
        for ($i = 0, $n = sizeof($article_topics); $i < $n; $i++) {
          $topic_path = '';
          for ($j = 0, $k = sizeof($article_topics[$i]); $j < $k; $j++) {
            $topic_path .= $article_topics[$i][$j]['text'] . '&nbsp;&gt;&nbsp;';
          }
          $topic_path = substr($topic_path, 0, -16);
          $article_topics_string .= vam_draw_checkbox_field('article_topics[]', $article_topics[$i][sizeof($article_topics[$i])-1]['id'], true) . '&nbsp;' . $topic_path . '<br>';
        }
        $article_topics_string = substr($article_topics_string, 0, -4);

        $contents[] = array('text' => '<br>' . $article_topics_string);
        $contents[] = array('align' => 'center', 'text' => '<br>' . '<span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span>' . ' <a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&aID=' . $aInfo->articles_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;
      case 'move_article':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_MOVE_ARTICLE . '</b>');

        $contents = array('form' => vam_draw_form('articles', FILENAME_ARTICLES, 'action=move_article_confirm&tPath=' . $tPath) . vam_draw_hidden_field('articles_id', $aInfo->articles_id));
        $contents[] = array('text' => sprintf(TEXT_MOVE_ARTICLES_INTRO, $aInfo->articles_name));
        $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENT_TOPICS . '<br><b>' . vam_output_generated_topic_path($aInfo->articles_id, 'article') . '</b>');
        $contents[] = array('text' => '<br>' . sprintf(TEXT_MOVE, $aInfo->articles_name) . '<br>' . vam_draw_pull_down_menu('move_to_topic_id', vam_get_topic_tree(), $current_topic_id));
        $contents[] = array('align' => 'center', 'text' => '<br>' . '<span class="button"><button type="submit" value="' . BUTTON_MOVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/move.png', '', '12', '12') . '&nbsp;' . BUTTON_MOVE . '</button></span>' . ' <a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&aID=' . $aInfo->articles_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;
      case 'copy_to':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_COPY_TO . '</b>');

        $contents = array('form' => vam_draw_form('copy_to', FILENAME_ARTICLES, 'action=copy_to_confirm&tPath=' . $tPath) . vam_draw_hidden_field('articles_id', $aInfo->articles_id));
        $contents[] = array('text' => TEXT_INFO_COPY_TO_INTRO);
        $contents[] = array('text' => '<br>' . TEXT_INFO_CURRENT_TOPICS . '<br><b>' . vam_output_generated_topic_path($aInfo->articles_id, 'article') . '</b>');
        $contents[] = array('text' => '<br>' . TEXT_TOPICS . '<br>' . vam_draw_pull_down_menu('topics_id', vam_get_topic_tree(), $current_topic_id));
        $contents[] = array('text' => '<br>' . TEXT_HOW_TO_COPY . '<br>' . vam_draw_radio_field('copy_as', 'link', true) . ' ' . TEXT_COPY_AS_LINK . '<br>' . vam_draw_radio_field('copy_as', 'duplicate') . ' ' . TEXT_COPY_AS_DUPLICATE);
        $contents[] = array('align' => 'center', 'text' => '<br>' . '<span class="button"><button type="submit" value="' . BUTTON_COPY . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/copy.png', '', '12', '12') . '&nbsp;' . BUTTON_COPY . '</button></span>' . ' <a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&aID=' . $aInfo->articles_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
        break;

      default:
        if ($rows > 0) {
          if (isset($tInfo) && is_object($tInfo)) { // topic info box contents
            $heading[] = array('text' => '<b>' . $tInfo->topics_name . '</b>');

            $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $tInfo->topics_id . '&action=edit_topic') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $tInfo->topics_id . '&action=delete_topic') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&tID=' . $tInfo->topics_id . '&action=move_topic') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/move.png', '', '12', '12') . '&nbsp;' . BUTTON_MOVE . '</span></a>');
            $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . vam_date_short($tInfo->date_added));
            if (vam_not_null($tInfo->last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . vam_date_short($tInfo->last_modified));
            $contents[] = array('text' => '<br>' . TEXT_SUBTOPICS . ' ' . $tInfo->childs_count . '<br>' . TEXT_ARTICLES . ' ' . $tInfo->articles_count);
          } elseif (isset($aInfo) && is_object($aInfo)) { // article info box contents
            $heading[] = array('text' => '<b>' . vam_get_articles_name($aInfo->articles_id, $_SESSION['languages_id']) . '</b>');

            $contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&aID=' . $aInfo->articles_id . '&action=new_article') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&aID=' . $aInfo->articles_id . '&action=delete_article') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&aID=' . $aInfo->articles_id . '&action=move_article') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/move.png', '', '12', '12') . '&nbsp;' . BUTTON_MOVE . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_ARTICLES, 'tPath=' . $tPath . '&aID=' . $aInfo->articles_id . '&action=copy_to') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/copy.png', '', '12', '12') . '&nbsp;' . BUTTON_COPY_TO . '</span></a>');            $contents[] = array('text' => '<br>' . TEXT_DATE_ADDED . ' ' . vam_date_short($aInfo->articles_date_added));
            if ($aInfo->articles_image != '') $contents[] = array('text' => '<br>' . vam_image(DIR_WS_CATALOG.DIR_WS_IMAGES . 'articles/'.$aInfo->articles_image, 200, 300));
            if (vam_not_null($aInfo->articles_last_modified)) $contents[] = array('text' => TEXT_LAST_MODIFIED . ' ' . vam_date_short($aInfo->articles_last_modified));
            if (date('Y-m-d') < $aInfo->articles_date_available) $contents[] = array('text' => TEXT_DATE_AVAILABLE . ' ' . vam_date_short($aInfo->articles_date_available));
            $contents[] = array('text' => '<br>' . TEXT_ARTICLES_AVERAGE_RATING . ' ' . number_format($aInfo->average_rating, 2) . '%');
          }
        } else { // create topic/article info
          $heading[] = array('text' => '<b>' . EMPTY_TOPIC . '</b>');

          $contents[] = array('text' => TEXT_NO_CHILD_TOPICS_OR_ARTICLES);
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
    </table>
<?php
  }
?>
    </td>
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
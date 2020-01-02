<?php
/* -----------------------------------------------------------------------------------------
   $Id: admin.php 1262 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com 
   (c) 2003	 nextcommerce (admin.php,v 1.12 2003/08/13); www.nextcommerce.org
   (c) 2004	 xt:Commerce (admin.php,v 1.12 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$box = new vamTemplate;
$content_string = '';

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
	$cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'].$tPath;
}

if (!$box->isCached(CURRENT_TEMPLATE.'/boxes/box_articles.html', $cache_id) || !$cache) {

	$box->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

  function vam_show_topic($counter) {
    global $tree, $topics_string, $tPath_array;

    for ($i=0; $i<$tree[$counter]['level']; $i++) {
      //$topics_string .= "&nbsp;&nbsp;";
    }

    $topics_string .= '<li class="list-inline-item topic-'.$tree[$counter]['level'].'"><a href="';

    if ($tree[$counter]['parent'] == 0) {
      $tPath_new = 'tPath=' . $counter;
    } else {
      $tPath_new = 'tPath=' . $tree[$counter]['path'];
    }

		$SEF_parameter_cat = '';
		if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
			$SEF_parameter_cat = '&category='.vam_cleanName($tree[$counter]['name']);

    $topics_string .= vam_href_link(FILENAME_ARTICLES, $tPath_new . $SEF_parameter_cat) . '"><span class="btn btn-outline-primary">';

    if (isset($tPath_array) && in_array($counter, $tPath_array)) {
      $topics_string .= '<b>';
    }

// display topic name
    $topics_string .= $tree[$counter]['name'];

    if (isset($tPath_array) && in_array($counter, $tPath_array)) {
      $topics_string .= '</b>';
    }

    if (vam_has_topic_subtopics($counter)) {
      $topics_string .= ' -&gt;';
    }

    if (SHOW_ARTICLE_COUNTS == 'true') {
      $articles_in_topic = vam_count_articles_in_topic($counter);
      if ($articles_in_topic > 0) {
        $topics_string .= '&nbsp;(' . $articles_in_topic . ')';
      }
    }
    
    $topics_string .= '</span></a>';

    $topics_string .= '</li>';

    if ($tree[$counter]['next_id'] != false) {
      vam_show_topic($tree[$counter]['next_id']);
    }
  }
?>
<?php

  $topics_string = '';
  $tree = array();

  $topics_query = vam_db_query("select t.topics_id, td.topics_name, t.parent_id from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.parent_id = '0' and t.topics_id = td.topics_id and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by sort_order, td.topics_name");
  while ($topics = vam_db_fetch_array($topics_query))  {
    $tree[$topics['topics_id']] = array('name' => $topics['topics_name'],
                                        'parent' => $topics['parent_id'],
                                        'level' => 0,
                                        'path' => $topics['topics_id'],
                                        'next_id' => false);

    if (isset($parent_id)) {
      $tree[$parent_id]['next_id'] = $topics['topics_id'];
    }

    $parent_id = $topics['topics_id'];

    if (!isset($first_topic_element)) {
      $first_topic_element = $topics['topics_id'];
    }
  }

  //------------------------
  if (vam_not_null($tPath)) {
    $new_path = '';
    foreach ($tPath_array as $key => $value) {	
      unset($parent_id);
      unset($first_id);
      $topics_query = vam_db_query("select t.topics_id, td.topics_name, t.parent_id from " . TABLE_TOPICS . " t, " . TABLE_TOPICS_DESCRIPTION . " td where t.parent_id = '" . (int)$value . "' and t.topics_id = td.topics_id and td.language_id = '" . (int)$_SESSION['languages_id'] . "' order by sort_order, td.topics_name");
      if (vam_db_num_rows($topics_query)) {
        $new_path .= $value;
        while ($row = vam_db_fetch_array($topics_query)) {
          $tree[$row['topics_id']] = array('name' => $row['topics_name'],
                                           'parent' => $row['parent_id'],
                                           'level' => $key+1,
                                           'path' => $new_path . '_' . $row['topics_id'],
                                           'next_id' => false);

          if (isset($parent_id)) {
            $tree[$parent_id]['next_id'] = $row['topics_id'];
          }

          $parent_id = $row['topics_id'];

          if (!isset($first_id)) {
            $first_id = $row['topics_id'];
          }

          $last_id = $row['topics_id'];
        }
        $tree[$last_id]['next_id'] = $tree[$value]['next_id'];
        $tree[$value]['next_id'] = $first_id;
        $new_path .= '_';
      } else {
        break;
      }
    }
  }
  vam_show_topic($first_topic_element);

  $new_articles_string = '';
  $all_articles_string = '';

  if (DISPLAY_NEW_ARTICLES=='true') {
    if (SHOW_ARTICLE_COUNTS == 'true') {
      $articles_new_query = "select a.articles_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "' and a.articles_date_added > SUBDATE(now( ), INTERVAL '" . NEW_ARTICLES_DAYS_DISPLAY . "' DAY)";
     $articles_new_query = vamDBquery($articles_new_query);
      $articles_new_count = ' (' . vam_db_num_rows($articles_new_query,true) . ')';
    } else {
      $articles_new_count = '';
    }

    if (strstr($PHP_SELF,FILENAME_ARTICLES_NEW) or strstr($PHP_SELF,FILENAME_ARTICLES_NEW)) {
      $new_articles_string = '<b>';
    }

    $new_articles_string .= '<li class="list-inline-item"><a href="' . vam_href_link(FILENAME_ARTICLES_NEW, '', 'NONSSL') . '"><span class="btn btn-outline-primary">' . BOX_NEW_ARTICLES . (($articles_new_count > 0) ? " " . $articles_new_count : "") . '</span></a>';

    if (strstr($PHP_SELF,FILENAME_ARTICLES_NEW) or strstr($PHP_SELF,FILENAME_ARTICLES_NEW)) {
      $new_articles_string .= '</b>';
    }

    $new_articles_string .= '</li>' . "\n";

  }

  if (DISPLAY_ALL_ARTICLES=='true') {
    if (SHOW_ARTICLE_COUNTS == 'true') {
      $articles_all_query = "select a.articles_id from " . TABLE_ARTICLES . " a left join " . TABLE_AUTHORS . " au on a.authors_id = au.authors_id, " . TABLE_ARTICLES_TO_TOPICS . " a2t left join " . TABLE_TOPICS_DESCRIPTION . " td on a2t.topics_id = td.topics_id, " . TABLE_ARTICLES_DESCRIPTION . " ad where (a.articles_date_available IS NULL or to_days(a.articles_date_available) <= to_days(now())) and a.articles_id = a2t.articles_id and a.articles_status = '1' and a.articles_id = ad.articles_id and ad.language_id = '" . (int)$_SESSION['languages_id'] . "' and td.language_id = '" . (int)$_SESSION['languages_id'] . "'";
     $articles_all_query = vamDBquery($articles_all_query);
      $articles_all_count = ' (' . vam_db_num_rows($articles_all_query,true) . ')';
    } else {
      $articles_all_count = '';
    }

    if ($topic_depth == 'top') {
      $all_articles_string = '<b>';
    }

    $all_articles_string .= '<li class="list-inline-item"><a href="' . vam_href_link(FILENAME_ARTICLES, '', 'NONSSL') . '"><span class="btn btn-outline-primary">' . BOX_ALL_ARTICLES . (($articles_all_count > 0) ? " " . $articles_all_count : "") . '</span></a>';

    if ($topic_depth == 'top') {
      $all_articles_string .= '</b>';
    }

    $all_articles_string .= '</li>' . "\n";

  }


  $box_content = $all_articles_string . $new_articles_string . $topics_string;

    $box->assign('BOX_CONTENT', $box_content);

}

if (!$cache) {
	$box_articles = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_articles.html');
} else {
	$box_articles = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_articles.html', $cache_id);
}

//if (vam_db_num_rows($topics_query, true) > 0) {
	$vamTemplate->assign('box_ARTICLES',$box_articles);
//}	

?>
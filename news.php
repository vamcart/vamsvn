<?php
include( 'includes/application_top.php');
// create smarty elements
  $smarty = new Smarty;
  require(DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes.php'); 
  $breadcrumb->add(NAVBAR_TITLE_NEWS, xtc_href_link(FILENAME_NEWS));
  require(DIR_WS_INCLUDES . 'header.php');
 // $news_id = 3;
  if (isset ($news_id) )
  	{
	$listing_sql = "SELECT 
  						news_id, 
						headline, 
						content, 
						date_added 
					FROM " . TABLE_LATEST_NEWS . "
					WHERE 
						status = '1' 
						and language = '" . (int)$_SESSION['languages_id'] . "'
						and news_id = '" . $news_id . "'
					ORDER BY date_added 
					DESC";
	
	}
  else
  	{
	$listing_sql = "SELECT 
  						news_id, 
						headline, 
						content, 
						date_added 
					FROM " . TABLE_LATEST_NEWS . "
					WHERE 
						status = '1' 
						and language = '" . (int)$_SESSION['languages_id'] . "'
					ORDER BY date_added 
					DESC";
	$sub = MAX_DISPLAY_LATEST_NEWS_CONTENT;
	}
						
						
	$module_content = array();
	$listing_sql = xtDBquery($listing_sql);
	while ($new_listing = xtc_db_fetch_array($listing_sql,true)) 
		{
		if ($sub)
			{
			$content = substr($new_listing['content'], 0, $sub)."...";
			}
		else 
			{
			$content = $new_listing['content'];
			}
			$module_content[]=array(
									'NEWS_HEADING' => $new_listing['headline'],
                         		  	'NEWS_CONTENT' => $content,
									'NEWS_ID' => $new_listing['news_id'],
                       				'NEWS_DATA' => $new_listing['date_added']);
		}
	//	substr($new_listing['content'], 0, $sub); // возвращает "abcd"

	$link = xtc_href_link(FILENAME_NEWS);
//	echo ($link."<hr>");
	$smarty->assign('NEWS_LINK', $link);
  $smarty->assign('language', $_SESSION['language']);
  $smarty->caching = 0;
  $smarty->assign('module_content',$module_content);
  $main_content=$smarty->fetch(CURRENT_TEMPLATE . '/module/latest_news.html');
  $smarty->assign('main_content',$main_content);
  $smarty->assign('language', $_SESSION['language']);
  $smarty->caching = 0;
  if (!defined(RM)) $smarty->load_filter('output', 'note');
  $smarty->display(CURRENT_TEMPLATE . '/index.html');
?>
<?php
$box_smarty = new smarty;
$box_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');

$listing_sql = 'select 
  					news_id, 
					headline, 
					content, 
					date_added 
				from ' . TABLE_LATEST_NEWS . " news 
				where 
					status = '1' 
					and language = '". (int)$_SESSION['languages_id'] . "' 
					order by date_added 
					DESC limit " . MAX_DISPLAY_LATEST_NEWS;

	$row = 0;
	$module_content = array();
	$listing_sql = xtDBquery($listing_sql);
	while ($new_listing = xtc_db_fetch_array($listing_sql,true)) 
		{
		$content = substr($new_listing['content'], 0, MAX_DISPLAY_LATEST_NEWS_CONTENT/2)."...";
		$module_content[]=array(
		'NEWS_HEADING' => $new_listing['headline'],
	    'NEWS_CONTENT' => $content,
		'NEWS_ID' => $new_listing['news_id'],
   		'NEWS_DATA' => $new_listing['date_added']);
		}
							
  if (sizeof($module_content)>=1)
	{
	$link = xtc_href_link(FILENAME_NEWS);
	//	echo ($link."<hr>");
	$box_smarty->assign('NEWS_LINK', $link);
	$box_smarty->assign('language', $_SESSION['language']);
	$box_smarty->assign('module_content',$module_content);
	// set cache ID
	if (USE_CACHE=='false') 
		{
		$box_smarty->caching = 0;
		$module= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_latest_news.html');
		}
	else
		{
  		$box_smarty->caching = 1;
  		$box_smarty->cache_lifetime=CACHE_LIFETIME;
  		$box_smarty->cache_modified_check=CACHE_CHECK;
		$module= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_latest_news.html',$cache_id);
  		}
	$smarty->assign('box_LATESTNEWS',$module);
	}
  
  ?>
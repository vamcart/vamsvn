<?php
/* --------------------------------------------------------------
   $Id: module_newsletter.php 1142 2007-02-08 11:13:01Z VaM $   
   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com
   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards www.oscommerce.com
   (c) 2003  nextcommerce (templates_boxes.php,v 1.14 2003/08/18); www.nextcommerce.org
   (c) 2004  xt:Commerce (module_newsletter.php,v 1.9 2003/08/18); xt-commerce.com
   Released under the GNU General Public License
   --------------------------------------------------------------*/
  require('includes/application_top.php');
  require_once (DIR_FS_INC.'vam_make_alias.inc.php');
  require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.phpmailer.php');
  if (EMAIL_TRANSPORT == 'smtp')
  require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.smtp.php');
  require_once(DIR_FS_INC . 'vam_php_mail.inc.php');
  require_once(DIR_FS_INC . 'vam_wysiwyg_tiny.inc.php');

function make_translit ($alias)
{
  //Replace cyrillic symbols to translit
  $trdic = array(
  "ё"=>"jo",
  "ж"=>"zh",
  "ф"=>"ph",
  "х"=>"kh",
  "ц"=>"ts",
  "ч"=>"ch",
  "ш"=>"sh",
  "щ"=>"sch",
  "э"=>"je",
  "є"=>"je",
  "ї"=>"ji",
  "ю"=>"ju",
  "я"=>"ja",

  "а"=>"a",
  "б"=>"b",
  "в"=>"v",
  "г"=>"g",
  "д"=>"d",
  "е"=>"e",
  "з"=>"z",
  "и"=>"i",
  "і"=>"i",
  "й"=>"j",
  "к"=>"k",
  "л"=>"l",
  "м"=>"m",
  "н"=>"n",
  "о"=>"o",
  "п"=>"p",
  "р"=>"r",
  "с"=>"s",
  "т"=>"t",
  "у"=>"u",
  "х"=>"h",
  "ц"=>"c",
  "ы"=>"y",

  "Ё"=>"E",
  "Ж"=>"ZH",
  "Ф"=>"PH",
  "Х"=>"KH",
  "Ц"=>"TS",
  "Ч"=>"CH",
  "Ш"=>"SH",
  "Щ"=>"SCH",
  "Э"=>"JE",
  "Є"=>"JE",
  "Ї"=>"JI",
  "Ю"=>"JU",
  "Я"=>"JA",

  "А"=>"A",
  "Б"=>"B",
  "В"=>"V",
  "Г"=>"G",
  "Д"=>"D",
  "Е"=>"E",
  "З"=>"Z",
  "И"=>"I",
  "І"=>"I",
  "Й"=>"J",
  "К"=>"K",
  "Л"=>"L",
  "М"=>"M",
  "Н"=>"N",

  "О"=>"O",
  "П"=>"P",
  "Р"=>"R",
  "С"=>"S",
  "Т"=>"T",
  "У"=>"U",
  "Х"=>"H",
  "Ц"=>"C",
  "Ы"=>"Y",

  // -----------------------
  "Ъ" => "",
  "Ь" => "",
  "ъ" => "",
  "ь" => ""
  ); 
        if($alias == "") {
        $alias = rand(1000,9999);
        }
     
        //Replace cyrillic symbols to translit
        $alias = strtr(stripslashes($alias), $trdic);
        $alias = strtolower($alias);
    
              
  return $alias;
}
  switch ($_GET['action']) {  // actions for datahandling
        case 'save': // save newsletter
        $id=vam_db_prepare_input((int)$_POST['ID']);
        $status_all=vam_db_prepare_input($_POST['status_all']);
        if ($newsletter_title=='') $newsletter_title='no title';
        $customers_status=vam_get_customers_statuses();
    
        $rzp='';
        for ($i=0,$n=sizeof($customers_status);$i<$n; $i++) {
        if (vam_db_prepare_input($_POST['status'][$i])=='yes') {
                if ($rzp!='') $rzp.=',';
                $rzp.=$customers_status[$i]['id'];
        }
        }
    
        if (vam_db_prepare_input($_POST['status_all'])=='yes') $rzp.=',all';
   $error=false; // reset error flag
   if ($error == false) {
        $sql_data_array = array( 'title'=> vam_db_prepare_input($_POST['title']),
                                'status' => '0',
                                'bc'=>$rzp,
                                'cc'=>vam_db_prepare_input($_POST['cc']),
                                'date' => 'now()',
                                'body' => vam_db_prepare_input($_POST['newsletter_body']));
   if ($id!='') {
   vam_db_perform(TABLE_MODULE_NEWSLETTER, $sql_data_array, 'update', "newsletter_id = '" . $id . "'");
   // create temp table
   vam_db_query("DROP TABLE IF EXISTS ".TABLE_NEWSLETTER_TEMP.$id);
   vam_db_query("CREATE TABLE ".TABLE_NEWSLETTER_TEMP.$id."
                (
                        id int(11) NOT NULL auto_increment,
                        customers_id int(11) NOT NULL default '0',
                        customers_status int(11) NOT NULL default '0',
                        customers_firstname varchar(64) NOT NULL default '',
                        customers_lastname varchar(64) NOT NULL default '',
                        customers_email_address text NOT NULL,
                        mail_key varchar(32) NOT NULL,
                        date datetime NOT NULL default '0000-00-00 00:00:00',
                        comment varchar(64) NOT NULL default '',
                        PRIMARY KEY  (id)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci");
   } else {
   vam_db_perform(TABLE_MODULE_NEWSLETTER, $sql_data_array);
   // create temp table
   $id=vam_db_insert_id();
   vam_db_query("DROP TABLE IF EXISTS ".TABLE_NEWSLETTER_TEMP.$id);
   vam_db_query("CREATE TABLE ".TABLE_NEWSLETTER_TEMP.$id."
                (
                        id int(11) NOT NULL auto_increment,
                        customers_id int(11) NOT NULL default '0',
                        customers_status int(11) NOT NULL default '0',
                        customers_firstname varchar(64) NOT NULL default '',
                        customers_lastname varchar(64) NOT NULL default '',
                        customers_email_address text NOT NULL,
                        mail_key varchar(32) NOT NULL,
                        date datetime NOT NULL default '0000-00-00 00:00:00',
                        comment varchar(64) NOT NULL default '',
                        PRIMARY KEY  (id)
                        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE utf8_general_ci");
   }
   // filling temp table with data!
   $flag='';
   if (!strpos($rzp,'all')) $flag='true';
   $rzp=str_replace(',all','',$rzp);
   $groups=explode(',',$rzp);
   $sql_data_array='';
   for ($i=0,$n=sizeof($groups);$i<$n;$i++) {
   // check if customer wants newsletter
  
   if (vam_db_prepare_input($_POST['status_all'])=='yes') {
   $customers_query=vam_db_query("SELECT
                                customers_id,
                                customers_firstname,
                                customers_lastname,
                                customers_email_address
                                FROM ".TABLE_CUSTOMERS."
                                WHERE
                                customers_status='".$groups[$i]."'");
   } else {
        $customers_query=vam_db_query("SELECT
                                customers_email_address,
                                customers_id,
                                customers_firstname,
                                customers_lastname,
                                mail_key       
                                FROM ".TABLE_NEWSLETTER_RECIPIENTS."
                                WHERE
                                customers_status='".$groups[$i]."' and
                                mail_status='1'");
   }
   while ($customers_data=vam_db_fetch_array($customers_query)){
        $sql_data_array=array(
                                'customers_id'=>$customers_data['customers_id'],
                                'customers_status'=>$groups[$i],
                                'customers_firstname'=>$customers_data['customers_firstname'],
                                'customers_lastname'=>$customers_data['customers_lastname'],
                                'customers_email_address'=>$customers_data['customers_email_address'],
                                'mail_key'=>$customers_data['mail_key'],
                                'date'=>'now()');
   vam_db_perform(TABLE_NEWSLETTER_TEMP.$id, $sql_data_array);
   }

   }
   vam_redirect(vam_href_link(FILENAME_MODULE_NEWSLETTER));
   }
   break;
   case 'delete':
   vam_db_query("DELETE FROM ".TABLE_MODULE_NEWSLETTER." WHERE   newsletter_id='".(int)$_GET['ID']."'");
   vam_redirect(vam_href_link(FILENAME_MODULE_NEWSLETTER));
   break;
   case 'send':
   // max email package  -> should be in admin area!
   $package_size='30';
   vam_redirect(vam_href_link(FILENAME_MODULE_NEWSLETTER,'send=0,'.$package_size.'&ID='.(int)$_GET['ID']));
   }
// action for sending mails!
if ($_GET['send']) {
$limits=explode(',',$_GET['send']);
$limit_low = $limits['0'];
$limit_up = $limits['1'];
        $limit_query=vam_db_query("SELECT count(*) as count
                                FROM ".TABLE_NEWSLETTER_TEMP.(int)$_GET['ID']."
                                ");
        $limit_data=vam_db_fetch_array($limit_query);
// select emailrange from db
        $email_query=vam_db_query("SELECT
                                customers_firstname,
                                customers_lastname,
                                customers_email_address,
                                mail_key ,
                                id
                                FROM  ".TABLE_NEWSLETTER_TEMP.(int)$_GET['ID']."
                                LIMIT ".$limit_low.",".$limit_up);
        $email_data=array();
while ($email_query_data=vam_db_fetch_array($email_query)) {
$email_data[]=array('id' => $email_query_data['id'],
                        'firstname'=>$email_query_data['customers_firstname'],
                        'lastname'=>$email_query_data['customers_lastname'],
                        'email'=>$email_query_data['customers_email_address'],
                        'key'=>$email_query_data['mail_key']);
}
// ok lets send the mails in package of 30 mails, to prevent php timeout
$package_size='30';
$break='0';
if ($limit_data['count']<$limit_up) {
        $limit_up=$limit_data['count'];
        $break='1';
}
$max_runtime=$limit_up-$limit_low;
  $newsletters_query=vam_db_query("SELECT
                                title,
                                        body,
                                        bc,
                                        cc
                                FROM ".TABLE_MODULE_NEWSLETTER."
                                WHERE  newsletter_id='".(int)$_GET['ID']."'");
$newsletters_data=vam_db_fetch_array($newsletters_query);
if ($newsletters_data['cc']!='') {
if (filter_var($newsletters_data['cc'], FILTER_VALIDATE_EMAIL)) {
vam_php_mail(EMAIL_SUPPORT_ADDRESS,
                EMAIL_SUPPORT_NAME,
                $newsletters_data['cc'],
                '' ,
                '',
                EMAIL_SUPPORT_REPLY_ADDRESS,
                EMAIL_SUPPORT_REPLY_ADDRESS_NAME,
                '',
                '',
                $newsletters_data['title'],
                $newsletters_data['body'],
                $newsletters_data['body']);
}                
}
for ($i=1;$i<=$max_runtime;$i++)
{
  // mail
$link1 = chr(13).chr(10).chr(13).chr(10).TEXT_NEWSLETTER_REMOVE.chr(13).chr(10).chr(13).chr(10).HTTP_CATALOG_SERVER.DIR_WS_CATALOG.FILENAME_CATALOG_NEWSLETTER.'?action=remove&email='.$email_data[$i-1]['email'].'&key='.$email_data[$i-1]['key'];
$link2 = $link2 = '<br /><br /><hr>'.TEXT_NEWSLETTER_REMOVE.'<br /><a href="'.HTTP_CATALOG_SERVER.DIR_WS_CATALOG.FILENAME_CATALOG_NEWSLETTER.'?action=remove&email='.$email_data[$i-1]['email'].'&key='.$email_data[$i-1]['key'].'">' . TEXT_REMOVE_LINK . '</a>';

if (filter_var($email_data[$i-1]['email'], FILTER_VALIDATE_EMAIL)) {
  vam_php_mail(EMAIL_SUPPORT_ADDRESS,
                EMAIL_SUPPORT_NAME,
                $email_data[$i-1]['email'],
                $email_data[$i-1]['lastname'] . ' ' . $email_data[$i-1]['firstname'] ,
                '',
                EMAIL_SUPPORT_REPLY_ADDRESS,
                EMAIL_SUPPORT_REPLY_ADDRESS_NAME,
                '',
                '',
                $newsletters_data['title'],
                $newsletters_data['body'].$link2,
                $newsletters_data['body'].$link1);
}                
                
  vam_db_query("UPDATE ".TABLE_NEWSLETTER_TEMP.(int)$_GET['ID']." SET comment='send' WHERE id='".$email_data[$i-1]['id']."'");
}
if ($break=='1') {
        // finished
        $limit1_query=vam_db_query("SELECT count(*) as count
                                FROM ".TABLE_NEWSLETTER_TEMP.(int)$_GET['ID']."
                                WHERE comment='send'");
        $limit1_data=vam_db_fetch_array($limit1_query);
        if ($limit1_data['count']-$limit_data['count']<=0)
        {
        vam_db_query("UPDATE ".TABLE_MODULE_NEWSLETTER." SET status='1' WHERE newsletter_id='".(int)$_GET['ID']."'");
        vam_redirect(vam_href_link(FILENAME_MODULE_NEWSLETTER));
        } else {
        echo '<b>'.$limit1_data['count'].'<b> emails send<br />';
        echo '<b>'.$limit1_data['count']-$limit_data['count'].'<b> emails left';
        }

} else {
$limit_low=$limit_up+1;
$limit_up=$limit_low+$package_size;
vam_redirect(vam_href_link(FILENAME_MODULE_NEWSLETTER,'send='.$limit_low.','.$limit_up.'&ID='.(int)$_GET['ID']));
}

}

?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<!--<meta name="viewport" content="initial-scale=1.0, width=device-width" />-->
<meta http-equiv="Content-Type" content="text/html; charset="<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
<?php
$query=vam_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".$_SESSION['languages_id']."'");
$data=vam_db_fetch_array($query);
if ($_GET['action']!='') echo vam_wysiwyg_tiny('mail',$data['code']);
?>
<?php if ($_GET['action'] == 'new') {
$query=vam_db_query("SELECT code FROM ". TABLE_LANGUAGES ." WHERE languages_id='".$_SESSION['languages_id']."'");
$data=vam_db_fetch_array($query);
echo vam_wysiwyg_tiny('mail',$data['code']);
} ?>
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
   
        <table border="0" width="100%" cellspacing="0" cellpadding="0">
        <tr>
                <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
                <td class="pageHeading" align="right"><a class="button" href="<?php echo MANUAL_LINK_NEWSLETTER; ?>" target="_blank"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/information.png', '', '12', '12'); ?> <?php echo TEXT_MANUAL_LINK; ?></span></a></td>
        </tr>
        </table>
   
        <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
if ($_GET['send'])
{
?>
        <tr><td>
        Sending
        </td></tr>
<?php
}
?>
        <tr>
        <td><table width="100%" border="0">
        <tr>
                <td>
<?php
// Default seite
switch ($_GET['action']) {
        default:
// Get Customers Groups
$customer_group_query=vam_db_query("SELECT
                                        customers_status_name,
                                        customers_status_id,
                                        customers_status_image
                                        FROM ".TABLE_CUSTOMERS_STATUS."
                                        WHERE
                                        language_id='".$_SESSION['languages_id']."'");
$customer_group=array();
while ($customer_group_data=vam_db_fetch_array($customer_group_query)) {
        // get single users
        $group_query=vam_db_query("SELECT count(*) as count
                                FROM ".TABLE_NEWSLETTER_RECIPIENTS."
                                WHERE mail_status='1' and
                                customers_status='".$customer_group_data['customers_status_id']."'");
        $group_data=vam_db_fetch_array($group_query);

$customer_group[]=array( 'ID'=>$customer_group_data['customers_status_id'],
                        'NAME'=>$customer_group_data['customers_status_name'],
                        'IMAGE'=>$customer_group_data['customers_status_image'],
                        'USERS'=>$group_data['count']);

}
?>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
        <td><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
        <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" width="150" ><?php echo TITLE_CUSTOMERS; ?></td>
        <td class="dataTableHeadingContent"  ><?php echo TITLE_STK; ?></td>
        </tr>
        <?php
for ($i=0,$n=sizeof($customer_group); $i<$n; $i++) {
?>
        <tr>
        <td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" valign="middle" align="left"><?php echo vam_image(DIR_WS_ICONS . $customer_group[$i]['IMAGE'], ''); ?><?php echo $customer_group[$i]['NAME']; ?></td>
        <td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" align="left"><?php echo $customer_group[$i]['USERS']; ?></td>
        </tr>
        <?php
}
?>
        </table></td>
        <td width="30%" align="right" valign="top""><?php
        echo '<a class="button" href="'.vam_href_link(FILENAME_MODULE_NEWSLETTER,'action=new').'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/add.png', '', '12', '12') . ' ' .BUTTON_NEW_NEWSLETTER.'</span></a>';

        ?></td>
  </tr>
</table>
<br />
<?php
// get data for newsletter overwiev
$newsletters_query=vam_db_query("SELECT
                                newsletter_id,date,title
                                FROM ".TABLE_MODULE_NEWSLETTER."
                                WHERE status='0'");
$news_data=array();
while ($newsletters_data=vam_db_fetch_array($newsletters_query)) {
$news_data[]=array(     'id' => $newsletters_data['newsletter_id'],
                        'date'=>$newsletters_data['date'],
                        'title'=>$newsletters_data['title']);
}
?>
<table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
        <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" width="30" ><?php echo TITLE_DATE; ?></td>
        <td class="dataTableHeadingContent" width="80%" ><?php echo TITLE_NOT_SEND; ?></td>
        <td class="dataTableHeadingContent"  >.</td>
        </tr>
<?php
for ($i=0,$n=sizeof($news_data); $i<$n; $i++) {
if ($news_data[$i]['id']!='') {
?>
        <tr>
        <td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" align="left"><?php echo $news_data[$i]['date']; ?></td>
        <td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" valign="middle" align="left"><?php echo vam_image(DIR_WS_CATALOG.'images/icons/arrow.gif'); ?><a href="<?php echo vam_href_link(FILENAME_MODULE_NEWSLETTER,'ID='.$news_data[$i]['id']); ?>"><b><?php echo $news_data[$i]['title']; ?></b></a></td>
        <td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" align="left">
        </td>
        </tr>
<?php
if ($_GET['ID']!='' && $_GET['ID']==$news_data[$i]['id']) {
$total_query=vam_db_query("SELECT
                        count(*) as count
                        FROM ".TABLE_NEWSLETTER_TEMP.(int)$_GET['ID']."");
$total_data=vam_db_fetch_array($total_query);
?>
<tr>
<td class="dataTableContent_products" style="border-bottom: 1px solid; border-color: #f1f1f1;" align="left"></td>
<td colspan="2" class="dataTableContent_products" style="border-bottom: 1px solid; border-color: #f1f1f1;" align="left"><?php echo TEXT_SEND_TO.$total_data['count']; ?></td>
</tr>
<td class="dataTableContent" valign="top" style="border-bottom: 1px solid; border-color: #999999;" align="left">
  <a class="button" href="<?php echo vam_href_link(FILENAME_MODULE_NEWSLETTER,'action=delete&ID='.$news_data[$i]['id']); ?>" onClick="return confirm('<?php echo CONFIRM_DELETE; ?>')"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12'); ?> <?php echo BUTTON_DELETE.'</span></a><br />'; ?>
  <a class="button" href="<?php echo vam_href_link(FILENAME_MODULE_NEWSLETTER,'action=edit&ID='.$news_data[$i]['id']); ?>"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12'); ?> <?php echo BUTTON_EDIT.'</span></a>'; ?>
  <br /><br /><div style="height: 1px; background: Black; margin: 3px 0;"></div>
  <a class="button" href="<?php echo vam_href_link(FILENAME_MODULE_NEWSLETTER,'action=send&ID='.$news_data[$i]['id']); ?>"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12'); ?> <?php echo BUTTON_SEND.'</span></a>'; ?>
</td>
<td colspan="2" class="dataTableContent" style="border-bottom: 1px solid; border-color: #999999; text-align: left;">
<?php
// get data
        $newsletters_query=vam_db_query("SELECT
                                title,body,cc,bc
                                FROM ".TABLE_MODULE_NEWSLETTER."
                                WHERE newsletter_id='".(int)$_GET['ID']."'");
   $newsletters_data=vam_db_fetch_array($newsletters_query);
echo TEXT_TITLE.$newsletters_data['title'].'<br />';
        $customers_status=vam_get_customers_statuses();
        for ($i=0,$n=sizeof($customers_status);$i<$n; $i++) {
        $newsletters_data['bc']=str_replace($customers_status[$i]['id'],$customers_status[$i]['text'],$newsletters_data['bc']);
        }
echo TEXT_TO.$newsletters_data['bc'].'<br />';
echo TEXT_CC.$newsletters_data['cc'].'<br /><br />'.TEXT_PREVIEW;
echo '<table style="border-color: #cccccc; border: 1px solid;" width="100%"><tr><td>'.$newsletters_data['body'].'</td></tr></table>';
?>
</td></tr>
<?php
}
?>
<?php
}
}

?>
</table>
<br /><br />
<?php
$newsletters_query=vam_db_query("SELECT
                                newsletter_id,date,title
                                FROM ".TABLE_MODULE_NEWSLETTER."
                                WHERE status='1'");
$news_data=array();
while ($newsletters_data=vam_db_fetch_array($newsletters_query)) {
$news_data[]=array(     'id' => $newsletters_data['newsletter_id'],
                        'date'=>$newsletters_data['date'],
                        'title'=>$newsletters_data['title']);
}
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" width="80%" ><?php echo TITLE_SEND; ?></td>
        <td class="dataTableHeadingContent"><?php echo TITLE_ACTION; ?></td>
        </tr>
<?php
for ($i=0,$n=sizeof($news_data); $i<$n; $i++) {
if ($news_data[$i]['id']!='') {
?>
        <tr>
        <td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" valign="middle" align="left"><?php echo $news_data[$i]['date'].'  '; ?><b><?php echo $news_data[$i]['title']; ?></b></td>
        <td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" align="left">
  <a href="<?php echo vam_href_link(FILENAME_MODULE_NEWSLETTER,'action=delete&ID='.$news_data[$i]['id']); ?>" onClick="return confirm('<?php echo CONFIRM_DELETE; ?>')">
  <?php
  echo vam_image(DIR_WS_ICONS.'delete.gif','Delete','','','style="cursor: pointer" onClick="return confirm(\''.DELETE_ENTRY.'\')"').'  '.TEXT_DELETE.'</a>  ';
  ?>
<a href="<?php echo vam_href_link(FILENAME_MODULE_NEWSLETTER,'action=edit&ID='.$news_data[$i]['id']); ?>">
<?php echo vam_image(DIR_WS_ICONS.'icon_edit.gif','Edit','','').'  '.TEXT_EDIT.'</a>'; ?>
 
        </td>
        </tr>
<?php
}
}

?>
</table>
<?php

  break;        // end default page
  case 'edit':
   $newsletters_query=vam_db_query("SELECT title,body,cc,bc FROM ".TABLE_MODULE_NEWSLETTER." WHERE newsletter_id='".(int)$_GET['ID']."'");
   $newsletters_data=vam_db_fetch_array($newsletters_query);
  case 'safe':
  case 'new':  // action for NEW newsletter!
$customers_status=vam_get_customers_statuses();

  echo vam_draw_form('edit_newsletter',FILENAME_MODULE_NEWSLETTER,'action=save','post','enctype="multipart/form-data"').vam_draw_hidden_field('ID',$_GET['ID']);
  ?>
  <br /><br />
<table class="main" width="100%" border="0">
   </tr>
        <tr>
        <td width="10%"><?php echo TEXT_TITLE; ?></td>
        <td width="90%"><?php echo vam_draw_input_field('title',$newsletters_data['title'],'size=100'); ?></td>
   </tr>
   <tr>
        <td width="10%"><?php echo TEXT_TO; ?></td>
        <td width="90%"><?php
for ($i=0,$n=sizeof($customers_status);$i<$n; $i++) {
        $group_query=vam_db_query("SELECT count(*) as count
                                FROM ".TABLE_NEWSLETTER_RECIPIENTS."
                                WHERE mail_status='1' and
                                customers_status='".$customers_status[$i]['id']."'");
        $group_data=vam_db_fetch_array($group_query);
        $group_query=vam_db_query("SELECT count(*) as count
                                FROM ".TABLE_CUSTOMERS."
                                WHERE
                                customers_status='".$customers_status[$i]['id']."'");
        $group_data_all=vam_db_fetch_array($group_query);
        $bc_array = explode(',', $newsletters_data['bc']);
echo vam_draw_checkbox_field('status['.$i.']','yes', in_array($customers_status[$i]['id'], $bc_array)).' '.$customers_status[$i]['text'].'  <i>(<b>'.$group_data['count'].'</b> '.TEXT_USERS.$group_data_all['count'].TEXT_CUSTOMERS.'<br />';
}
echo vam_draw_checkbox_field('status_all', 'yes',in_array('all', $bc_array)).' <b>'.TEXT_NEWSLETTER_ONLY.'</b>';
        ?></td>
   </tr>
        <tr>
        <td width="10%"><?php echo TEXT_CC; ?></td>
        <td width="90%"><?php
        echo vam_draw_input_field('cc',$newsletters_data['cc'],'size=100'); ?></td>
   </tr>
        </tr>
        <tr>
        <td width="10%" valign="top"><?php echo TEXT_BODY; ?></td>
        <td width="90%"><?php
echo vam_draw_textarea_field('newsletter_body', 'soft', '95', '25', stripslashes($newsletters_data['body']));
        ?><br /><a href="javascript:toggleHTMLEditor('newsletter_body');"><?php echo TEXT_TOGGLE_EDITOR; ?></a></td>
   </tr>
   </table>
   <a class="button" href="<?php echo vam_href_link(FILENAME_MODULE_NEWSLETTER); ?>"><span><?php echo vam_image(DIR_WS_IMAGES . 'icons/buttons/back.png', '', '12', '12'); ?> <?php echo BUTTON_BACK; ?></span></a>
   <right><?php echo '<span class="button"><button type="submit" value="' . BUTTON_SAVE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/save.png', '', '12', '12') . ' ' . BUTTON_SAVE . '</button></span>'; ?></right>
  </form>
  <?php
  break;
} // end switch
?>

</td>
        </tr>
        </table></td>
        </tr>
        </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->
<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
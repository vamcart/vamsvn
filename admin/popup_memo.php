<?php
/* --------------------------------------------------------------
   $Id: popup_memo.php 1125 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards www.oscommerce.com
   (c) 2004	 xt:Commerce (popup_memo.php,v 1.7 2003/08/18); xt-commerce.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/

   require('includes/application_top.php');
   include(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/customers.php');

if ($_GET['action']) {
switch ($_GET['action']) {

        case 'save':

        $memo_title = vam_db_prepare_input($_POST['memo_title']);
        $memo_text = vam_db_prepare_input($_POST['memo_text']);

        if ($memo_text != '' && $memo_title != '' ) {
          $sql_data_array = array(
            'customers_id' => $_POST['ID'],
            'memo_date' => date("Y-m-d"),
            'memo_title' =>$memo_title,
            'memo_text' => nl2br($memo_text),
            'poster_id' => $_SESSION['customer_id']);

          vam_db_perform(TABLE_CUSTOMERS_MEMO, $sql_data_array);
          }
        break;

        case 'remove':
        vam_db_query("DELETE FROM ".TABLE_CUSTOMERS_MEMO." where memo_id='".$_GET['mID']."'");
        break;

}
}
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<!--<meta name="viewport" content="initial-scale=1.0, width=device-width" />-->
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo $page_title; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

</head>
<body>
<div class="pageHeading"><?php echo TITLE_MEMO; ?></div></p>
    <table width="100%">
      <tr>
      <form name="customers_memo" method="POST" action="popup_memo.php?action=save&ID=<?php echo (int)$_GET['ID'];?>">
        <td class="main" style="border-top: 1px solid; border-color: #cccccc;"><b><?php echo TEXT_TITLE ?></b>: <?php echo vam_draw_input_field('memo_title').vam_draw_hidden_field('ID',(int)$_GET['ID']); ?><br /><?php echo vam_draw_textarea_field('memo_text', 'soft', '60', '5'); ?><br /><?php echo '<span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>'; ?></td>
      </tr>
    </table></form>
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

  <tr>
    <td>



    <td class="main"><?php
  $memo_query = vam_db_query("SELECT
                                  *
                              FROM
                                  " . TABLE_CUSTOMERS_MEMO . "
                              WHERE
                                  customers_id = '" . (int)$_GET['ID'] . "'
                              ORDER BY
                                  memo_id DESC");
  while ($memo_values = vam_db_fetch_array($memo_query)) {
    $poster_query = vam_db_query("SELECT customers_firstname, customers_lastname FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . $memo_values['poster_id'] . "'");
    $poster_values = vam_db_fetch_array($poster_query);
?><table width="100%">
      <tr>
        <td class="main"><hr noshade><b><?php echo TEXT_DATE; ?></b>: <i><?php echo $memo_values['memo_date']; ?><br /></i> <b><?php echo TEXT_TITLE; ?></b>: <?php echo $memo_values['memo_title']; ?><br /><b>  <?php echo TEXT_POSTER; ?></b>: <?php echo $poster_values['customers_lastname']; ?> <?php echo $poster_values['customers_firstname']; ?></td>
      </tr>
      <tr>
        <td width="142" class="main" style="border: 1px solid; border-color: #cccccc;"><?php echo $memo_values['memo_text']; ?></td>
      </tr>
      <tr>
        <td><a class="button" href="<?php echo vam_href_link('popup_memo.php', 'ID=' . $_GET['ID'] . '&action=remove&mID=' . $memo_values['memo_id']); ?>" onClick="return confirm('<?php echo DELETE_ENTRY; ?>')"><span><?php echo BUTTON_DELETE; ?></span></a></td>
      </tr>
    </table>
<?php
  }
?>
  </td>
    </td>
  </tr>
</table>

</body>
</html>
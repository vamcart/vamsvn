<?php
/* -----------------------------------------------------------------------------------------
   $Id: products.php 950 2007-02-08 12:51:57 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2006	 osCommerce (products.php,v 1.25 2003/08/19); oscommerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

defined('_VALID_VAM') or die('Direct Access to this location is not allowed.');

  $xx_mins_ago = (time() - 900);

  require(DIR_FS_INC. 'vam_get_products.inc.php');

  // remove entries that have expired
  vam_db_query("delete from " . TABLE_WHOS_ONLINE . " where time_last_click < '" . $xx_mins_ago . "'");

?>

<h1 class="contentBoxHeading"><?php echo '<a href="' . vam_href_link(FILENAME_WHOS_ONLINE, '', 'NONSSL') . '">' . TABLE_HEADING_ONLINE . '</a>'; ?></h1>

<?php
  $whos_online_query = vam_db_query("select customer_id, full_name, ip_address, time_entry, time_last_click, last_page_url, session_id from " . TABLE_WHOS_ONLINE ." order by time_last_click desc");
  $products = false;
  while ($whos_online = vam_db_fetch_array($whos_online_query)) {
    $time_online = (time() - $whos_online['time_entry']);
    //if ( ((!$_GET['info']) || (@$_GET['info'] == $whos_online['session_id'])) && (!$info) ) {
      $info = $whos_online['session_id'];
    //}
?>

<?php
//$tooltip .= '<span class="text-left">';
$tooltip = 
TABLE_HEADING_ONLINE . ": " . gmdate('H:i:s', $time_online)."<br />".
TABLE_HEADING_CUSTOMER_ID . ": " . $whos_online['customer_id']."<br />".
TABLE_HEADING_FULL_NAME . ": " . $whos_online['full_name']."<br />".
TABLE_HEADING_IP_ADDRESS . ": " . $whos_online['ip_address']."<br />".
TABLE_HEADING_ENTRY_TIME . ": " . date('H:i:s', $whos_online['time_entry'])."<br />".
TABLE_HEADING_LAST_CLICK . ": " . date('H:i:s', $whos_online['time_last_click'])
;

  if ($info) {
$tooltip .= "<br />";
$tooltip .= TABLE_HEADING_SHOPPING_CART . ": <br />";

    if (STORE_SESSIONS == 'mysqli') {
      $session_data = vam_db_query("select value from " . TABLE_SESSIONS . " WHERE sesskey = '" . $info . "'");
      $session_data = vam_db_fetch_array($session_data);
      $session_data = trim($session_data['value']);
    } else {
      if ( (file_exists(vam_session_save_path() . '/sess_' . $info)) && (filesize(vam_session_save_path() . '/sess_' . $info) > 0) ) {
        $session_data = file(vam_session_save_path() . '/sess_' . $info);
        $session_data = trim(implode('', $session_data));
      }
    }

      $user_session = unserialize_session_data($session_data);
      $products = false;
		
      if ($user_session) {
        $products = vam_get_products($user_session);
        for ($i = 0, $n = sizeof($products); $i < $n; $i++) {
        	 $tooltip .= "<br />";
          $tooltip .= $products[$i]['quantity'] . ' x ' . $products[$i]['name'];
        }

        if (sizeof($products) > 0) {
        	 $tooltip .= "<br /><br />";
          $tooltip .= TEXT_SHOPPING_CART_SUBTOTAL . ': ' . $user_session['cart']->total . ' ' . $user_session['currency'];
        } else {
          $tooltip .= '&nbsp;';
        }
      }
    }

//$tooltip .= '</span>';

?>

<div class="chip<?php if (sizeof($products) > 0) { ?> cart<?php } ?>" data-toggle="tooltip" data-html="true" data-placement="top" title="" data-original-title="<?php echo $tooltip; ?>">
<a href="<?php echo vam_href_link(FILENAME_WHOS_ONLINE, vam_get_all_get_params(array('info', 'action')) . 'info=' . $whos_online['session_id'], 'NONSSL'); ?>">
<?php if (sizeof($products) > 0) { ?>
  <div class="icon pulse-button"><i class="fas fa-shopping-basket"></i></div> <?php echo $whos_online['full_name']; ?>
<?php } elseif ($whos_online['customer_id'] > 0) { ?>
  <div class="icon"><i class="fas fa-user-circle"></i></div> <?php echo $whos_online['full_name']; ?>
<?php } else { ?>
  <div class="icon"><i class="fas fa-eye"></i></div> <?php echo $whos_online['full_name']; ?>
<?php } ?>
</a>  
</div>

             
<?php
  }
?>

<div>
<span class="small text-muted">
<?php echo sprintf(TEXT_NUMBER_OF_CUSTOMERS, vam_db_num_rows($whos_online_query)); ?>
</span>
</div>

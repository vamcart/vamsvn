<?php
/* --------------------------------------------------------------
   $Id: category_specials.php 1125 2008-02-26 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2008 VaM Shop
   --------------------------------------------------------------
   based on:
   category_specials.php (c) 2005 WTM Technologies http://wtmtechnologies.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/

require('includes/application_top.php');

require(DIR_WS_CLASSES . 'currencies.php');
$currencies = new currencies();

$action = (isset($_GET['action']) ? $_GET['action'] : '');

if (vam_not_null($action))
{
	switch ($action)
	{
		case 'setflag':
			$specials_id = (int)$_GET['id'];
			$flag = (int)$_GET['flag'];
	
			$query = "update ". TABLE_SPECIAL_CATEGORY. " set status = '$flag' where special_id = $specials_id";
			vam_db_query($query);
	
			$specials_query = vam_db_query("select product_id from ". TABLE_SPECIAL_PRODUCT. " where special_id = $specials_id");
			while($specials = vam_db_fetch_array($specials_query))
			{
				$product_id[] = $specials['product_id'];
			}
	
			$product_id = implode(", ", $product_id);
	
			$query = "update ". TABLE_SPECIALS. " set status = '$flag' where products_id in ($product_id)";
			vam_db_query($query);
	
			vam_redirect(vam_href_link(FILENAME_CATEGORY_SPECIALS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'sID=' . $_GET['id'], 'NONSSL'));
			break;
		case 'subsetflag':
			$specials_id = (int)$_GET['id'];
			$flag = (int)$_GET['flag'];
	
			$query = "update ". TABLE_SPECIALS. " set status = '$flag' where specials_id = $specials_id";
			vam_db_query($query);
	
			vam_redirect(vam_href_link(FILENAME_CATEGORY_SPECIALS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'sID=' . $_GET['sID']. '&action=edit', 'NONSSL'));
			break;
		case 'noflag':
			$product_id = (int)$_GET['pid'];
			$special_id = (int)$_GET['sID'];
	
			$query = "select discount, discount_type, expire_date, status from ". TABLE_SPECIAL_CATEGORY. " where special_id = $special_id";
			$special_query = vam_db_query($query);
			$special = vam_db_fetch_array($special_query);
			
			$query = "select products_price from ". TABLE_PRODUCTS. " where products_id = $product_id";
			$product_query = vam_db_query($query);
			$product = vam_db_fetch_array($product_query);

			$specials_price = $special['discount_type'] == "p" ? $product['products_price'] - ($product['products_price'] * $special['discount'] / 100) : $product['products_price'] - $special['discount'];
			$specials_price = sprintf("%0.2f", $specials_price);

			$query = "insert into ". TABLE_SPECIALS. " (products_id, specials_quantity, specials_new_products_price, specials_date_added, expires_date, status) 
					values ($product_id, '100000', $specials_price, now(), '". $special['expire_date']. "', '". $special['status']. "')";
			vam_db_query($query);
	
			vam_redirect(vam_href_link(FILENAME_CATEGORY_SPECIALS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'sID=' . $_GET['sID']. "&action=edit", 'NONSSL'));
			break;
		case 'insert':
			$categ_id = vam_db_prepare_input($_POST['categ_id']);
			$specials_price = vam_db_prepare_input($_POST['specials_price']);
         $day = vam_db_prepare_input($_POST['expires-dd']);
         $month = vam_db_prepare_input($_POST['expires-mm']);
         $year = vam_db_prepare_input($_POST['expires']);
			$override = vam_db_prepare_input($_POST['override']);
	
			$query = "select special_id from ". TABLE_SPECIAL_CATEGORY. " where categ_id = $categ_id";
			$result = vam_db_query($query);
			if(vam_db_num_rows($result) < 1)
			{
				$discount_type = substr($specials_price, -1) == '%' ? "p" : "f";
				$specials_price = sprintf("%0.2f", $specials_price);
	
				$expires_date = '';
				if (vam_not_null($day) && vam_not_null($month) && vam_not_null($year))
				{
					$expires_date = $year;
					$expires_date .= (strlen($month) == 1) ? '0' . $month : $month;
					$expires_date .= (strlen($day) == 1) ? '0' . $day : $day;
				}
	
	
				$query = "insert into ". TABLE_SPECIAL_CATEGORY. " (categ_id, discount, discount_type, special_date_added, special_last_modified, expire_date, date_status_change, status)
							values ($categ_id, $specials_price, '$discount_type', now(), now(), '$expires_date', now(), 1)";
				vam_db_query($query);
	
				$specials_id = vam_db_insert_id();
	
				if($override == "y")
				{
					$query = "select A.products_id, A.products_price from ". TABLE_PRODUCTS. " A, ". TABLE_PRODUCTS_TO_CATEGORIES. " C
								where C.categories_id = $categ_id and A.products_id = C.products_id";
					$specials_query = vam_db_query($query);
					while($specials = vam_db_fetch_array($specials_query))
					{
						$product_id = (int)$specials['products_id'];
						$new_price = $discount_type == "p" ? $specials['products_price'] - ($specials['products_price'] * $specials_price / 100) : $specials['products_price'] - $specials_price;
						$new_price = sprintf("%0.2f", $new_price);
	
						$query = "insert into ". TABLE_SPECIAL_PRODUCT. " values (null, $specials_id, $product_id)";
						vam_db_query($query);
	
						$query = "select products_id from ". TABLE_SPECIALS. " where products_id = $product_id";
						$product_query = vam_db_query($query);
						if(vam_db_num_rows($product_query) < 1)
						{
							$query = "insert into ". TABLE_SPECIALS. " (products_id, specials_quantity, specials_new_products_price, expires_date) values ($product_id, '100000', $new_price, '$expires_date')";
							vam_db_query($query);
						}
						else
						{
							vam_db_query("update " . TABLE_SPECIALS . " set specials_new_products_price = '$new_price', specials_last_modified = now(),
											expires_date = '" . vam_db_input($expires_date) . "' where products_id = '" . (int)$product_id . "'");
						}
					}
				}
				else
				{
//					$query = "select A.products_id, B.products_price from ". TABLE_PRODUCTS_TO_CATEGORIES. " A, ". TABLE_PRODUCTS. " B left join ". TABLE_SPECIALS. " C on C.products_id = A.products_id
//								where A.categories_id = $categ_id and B.products_id = A.products_id and C.products_id IS NULL";
					$query = "select A.products_id, B.products_price from (". TABLE_PRODUCTS_TO_CATEGORIES. " A, ". TABLE_PRODUCTS. " B) left join ". TABLE_SPECIALS. " C on C.products_id = A.products_id
								where A.categories_id = $categ_id and B.products_id = A.products_id and C.products_id IS NULL";
						$specials_query = vam_db_query($query);
					while($specials = vam_db_fetch_array($specials_query))
					{
						$product_id = $specials['products_id'];
						$new_price = $discount_type == "p" ? $specials['products_price'] - ($specials['products_price'] * $specials_price / 100) : $specials['products_price'] - $specials_price;
						$new_price = sprintf("%0.2f", $new_price);
	
						$query = "insert into ". TABLE_SPECIAL_PRODUCT. " values (null, $specials_id, $product_id)";
						vam_db_query($query);
	
						$query = "insert into ". TABLE_SPECIALS. " (products_id, specials_quantity, specials_new_products_price, expires_date) values ($product_id, '100000', $new_price, '$expires_date')";
						vam_db_query($query);
					}
				}
	
				vam_redirect(vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page']));
				break;
			}
			else
			{
				$specials_id = vam_db_fetch_array($result);
				$_POST['specials_id'] = $specials_id['special_id'];
				$action = "update";
			}
		case 'update':
			$specials_id = vam_db_prepare_input($_POST['specials_id']);
			$specials_price = vam_db_prepare_input($_POST['specials_price']);
			$day = vam_db_prepare_input($_POST['day']);
			$month = vam_db_prepare_input($_POST['month']);
			$year = vam_db_prepare_input($_POST['year']);
			$override = vam_db_prepare_input($_POST['override']);
	
			$discount_type = substr($specials_price, -1) == '%' ? "p" : "f";
			$specials_price = sprintf("%0.2f", $specials_price);
	
			$expires_date = '';
			if (vam_not_null($day) && vam_not_null($month) && vam_not_null($year))
			{
				$expires_date = $year;
				$expires_date .= (strlen($month) == 1) ? '0' . $month : $month;
				$expires_date .= (strlen($day) == 1) ? '0' . $day : $day;
			}
	
			vam_db_query("update ". TABLE_SPECIAL_CATEGORY. " set discount = '" . vam_db_input($specials_price) . "', special_last_modified = now(),
							expire_date = '" . vam_db_input($expires_date) . "', discount_type = '$discount_type' 
							where special_id = '" . (int)$specials_id . "'");
	
			$query = "select status from ". TABLE_SPECIAL_CATEGORY. " where special_id = $specials_id";
			$status_query = vam_db_query($query);
			$status = vam_db_fetch_array($status_query);
			$status = $status['status'];
	
			if($override == "y")
			{
				$query = "select A.products_id, A.products_price from ". TABLE_PRODUCTS. " A, ". TABLE_SPECIAL_CATEGORY. " B, ". TABLE_PRODUCTS_TO_CATEGORIES. " C
							where C.categories_id = B.categ_id and B.special_id = $specials_id
							and A.products_id = C.products_id";
				$specials_query = vam_db_query($query);
				while($specials = vam_db_fetch_array($specials_query))
				{
					$product_id = (int)$specials['products_id'];
					$new_price = $discount_type == "p" ? $specials['products_price'] - ($specials['products_price'] * $specials_price / 100) : $specials['products_price'] - $specials_price;
					$new_price = sprintf("%0.2f", $new_price);
	
					$query = "select product_id from ". TABLE_SPECIAL_PRODUCT. " where product_id = $product_id and special_id = $specials_id";
					$product_query = vam_db_query($query);
					if(vam_db_num_rows($product_query) < 1)
					{
						$query = "insert into ". TABLE_SPECIAL_PRODUCT. " values (null, $specials_id, $product_id)";
						vam_db_query($query);
	
						$query = "insert into ". TABLE_SPECIALS. " (products_id, specials_quantity, specials_new_products_price, expires_date, status) values
									($product_id, '100000', $new_price, '$expires_date', '$status')";
						vam_db_query($query);
					}
					else
					{
						vam_db_query("update " . TABLE_SPECIALS . " set specials_new_products_price = '$new_price', specials_last_modified = now(),
										expires_date = '" . vam_db_input($expires_date) . "' where products_id = '" . (int)$product_id . "'");
					}
				}
			}
			else
			{
				$query = "select A.product_id, B.products_price from ". TABLE_SPECIAL_PRODUCT. " A, ". TABLE_PRODUCTS. " B where A.special_id = $specials_id
							and B.products_id = A.product_id";
				$specials_query = vam_db_query($query);
				while($specials = vam_db_fetch_array($specials_query))
				{
					$product_id = $specials['product_id'];
					$new_price = $discount_type == "p" ? $specials['products_price'] - ($specials['products_price'] * $specials_price / 100) : $specials['products_price'] - $specials_price;
					$new_price = sprintf("%0.2f", $new_price);
	
					vam_db_query("update " . TABLE_SPECIALS . " set specials_new_products_price = '$new_price', specials_last_modified = now(),
									expires_date = '" . vam_db_input($expires_date) . "' where products_id = '" . (int)$product_id . "'");
				}
			}
	
			vam_redirect(vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $specials_id));
			break;
		case 'deleteconfirm':
			$specials_id = vam_db_prepare_input($_GET['sID']);
			$product_id = array();
			$product_id[] = 0;
	
			$specials_query = vam_db_query("select product_id from ". TABLE_SPECIAL_PRODUCT. " where special_id = $specials_id");
			while($specials = vam_db_fetch_array($specials_query))
			{
				$product_id[] = $specials['product_id'];
			}
	
			$product_id = implode(", ", $product_id);
	
			@vam_db_query("delete from " . TABLE_SPECIALS . " where products_id in ($product_id)");
			vam_db_query("delete from ". TABLE_SPECIAL_CATEGORY. " where special_id = '" . (int)$specials_id . "'");
			vam_db_query("delete from ". TABLE_SPECIAL_PRODUCT. " where special_id = '" . (int)$specials_id . "'");
	
			vam_redirect(vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page']));
			break;
		case 'subcity':
			$act = vam_db_prepare_input($_POST['act']);
			$product_id = vam_db_prepare_input($_POST['product_id']);
			$new_price = vam_db_prepare_input($_POST['new_price']);
			$new_price = sprintf("%0.2f", $new_price);
			$special_id = vam_db_prepare_input($_GET['sID']);

			switch($act)
			{
				case 're-add':
					if($new_price > 0.00)
					{
						$query = "select expire_date, status from ". TABLE_SPECIAL_CATEGORY. " where special_id = $special_id";
						$special_query = vam_db_query($query);
						$special = vam_db_fetch_array($special_query);
		
						$query = "insert into ". TABLE_SPECIALS. " (products_id, specials_quantity, specials_new_products_price, specials_date_added, expires_date, status)
							values ($product_id, '100000', $new_price, now(), '". $special['expire_date']. "', '". $special['status']. "')";
						vam_db_query($query);
					}	

					vam_redirect(vam_href_link(FILENAME_CATEGORY_SPECIALS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'sID=' . $_GET['sID']. "&action=edit", 'NONSSL'));
					break;
				case 'delete':
					$query = "delete from ". TABLE_SPECIAL_PRODUCT. " where product_id = $product_id and special_id = $special_id";
					vam_db_query($query);
					
					$query = "delete from ". TABLE_SPECIALS. " where products_id = $product_id";
					vam_db_query($query);

					vam_redirect(vam_href_link(FILENAME_CATEGORY_SPECIALS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'sID=' . $_GET['sID']. "&action=edit", 'NONSSL'));
					break;
				case 'update':
					if($new_price > 0.00)
					{
						$query = "update ". TABLE_SPECIALS. " set specials_new_products_price = $new_price, specials_last_modified = now() 
							where products_id = $product_id";
						vam_db_query($query);
					}	

					vam_redirect(vam_href_link(FILENAME_CATEGORY_SPECIALS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'sID=' . $_GET['sID']. "&action=edit", 'NONSSL'));
					break;
				case 'make-special':
					if($new_price > 0.00)
					{
						$query = "insert into ". TABLE_SPECIALS. " (products_id, specials_quantity, specials_new_products_price, specials_date_added, expires_date, status)
							values ($product_id, '100000', $new_price, now(), '0000-00-00', '1')";
						vam_db_query($query);
					}	
					else 
					{
						$query = "select discount, discount_type, expire_date, status from ". TABLE_SPECIAL_CATEGORY. " where special_id = $special_id";
						$special_query = vam_db_query($query);
						$special = vam_db_fetch_array($special_query);

						$query = "select products_price from ". TABLE_PRODUCTS. " where products_id = $product_id";
						$product_query = vam_db_query($query);
						$product = vam_db_fetch_array($product_query);

						$specials_price = $special['discount_type'] == "p" ? $product['products_price'] - ($product['products_price'] * $special['discount'] / 100) : $product['products_price'] - $special['discount'];
						$specials_price = sprintf("%0.2f", $specials_price);

						$query = "insert into ". TABLE_SPECIALS. " (products_id, specials_quantity, specials_new_products_price, specials_date_added, expires_date, status)
								values ($product_id, '100000', $specials_price, now(), '". $special['expire_date']. "', '". $special['status']. "')";
						vam_db_query($query);

						$query = "insert into ". TABLE_SPECIAL_PRODUCT. " (special_id, product_id) values ($special_id, $product_id)";
						vam_db_query($query);
					}

					vam_redirect(vam_href_link(FILENAME_CATEGORY_SPECIALS, (isset($_GET['page']) ? 'page=' . $_GET['page'] . '&' : '') . 'sID=' . $_GET['sID']. "&action=edit", 'NONSSL'));
					break;
			}
	}
}
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta name="viewport" content="initial-scale=1.0, width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
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
    
    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
<?php
if ( ($action == 'new') || ($action == 'edit') )
{
	$form_action = 'insert';
	if ( ($action == 'edit') && isset($_GET['sID']) )
	{
		$form_action = 'update';

		$product_query = vam_db_query("select A.categ_id, B.categories_name, A.discount, A.discount_type, A.expire_date from ". TABLE_SPECIAL_CATEGORY. " A, " .
		TABLE_CATEGORIES_DESCRIPTION . " B where A.categ_id = B.categories_id and B.language_id = '" . (int)$_SESSION['languages_id'] . "'
					and A.special_id = '" . (int)$_GET['sID'] . "'");
		$product = vam_db_fetch_array($product_query);
		$sInfo = new objectInfo($product);
	}
	else
	{
		$sInfo = new objectInfo(array());

		// create an array of products on special, which will be excluded from the pull down menu of products
		// (when creating a new product on special)
		$specials_array = array();
		$specials_query = vam_db_query("select p.products_id from " . TABLE_PRODUCTS . " p, " . TABLE_SPECIALS . " s where s.products_id = p.products_id");
		while ($specials = vam_db_fetch_array($specials_query))
		{
			$specials_array[] = $specials['products_id'];
		}
	}

	$per =  $sInfo->discount_type == "p" ? "%" : "";
?>
<form name="new_special" <?php echo 'action="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, vam_get_all_get_params(array('action', 'info', 'sID')) . 'action=' . $form_action, 'NONSSL') . '"'; ?> method="post">
        <td><br /><table border="0" cellspacing="0" cellpadding="2">
      <tr><?php if ($form_action == 'update') echo vam_draw_hidden_field('specials_id', $_GET['sID']); ?>
        <td><br>
          <table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><?php echo TEXT_SPECIALS_CATEGORY; ?>&nbsp;</td>
            <td class="main"><?php echo (isset($sInfo->categories_name)) ? $sInfo->categories_name 
				: vam_draw_pull_down_menu('categ_id', vam_get_category_tree(), $specials_array); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_SPECIALS_SPECIAL_PRICE; ?>&nbsp;</td>
            <td class="main"><?php echo vam_draw_input_field('specials_price', (isset($sInfo->discount) ? ($sInfo->discount . $per) : '')); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_SPECIALS_EXPIRES_DATE; ?>&nbsp;</td>
            <td class="main"><?php echo vam_draw_input_field('expires-dd', substr($sInfo->expires_date, 8, 2), "size=\"2\" maxlength=\"2\" id=\"expires-dd\""); ?> / <?php echo vam_draw_input_field('expires-mm', substr($sInfo->expires_date, 5, 2), "size=\"2\" maxlength=\"2\" id=\"expires-mm\" class=\"\""); ?> / <?php echo vam_draw_input_field('expires', substr($sInfo->expires_date, 0, 4), "size=\"4\" maxlength=\"4\" id=\"expires\" class=\"format-d-m-y split-date\""); ?></td>
          </tr>
          <tr>
            <td colspan="2" valign="middle" class="main"><?php echo vam_draw_checkbox_field('override', 'y'); ?> &nbsp; <?php echo TEXT_SPECIALS_OVERRIDE; ?></td>
          </tr>
        </table></td>
      </tr>
	
      <tr>
        <td>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><br><?php echo TEXT_SPECIALS_PRICE_TIP; ?></td>
            <td class="main" align="right" valign="top"><br><?php echo (($form_action == 'insert') ? '<span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>' : '<span class="button"><button type="submit" value="' . BUTTON_UPDATE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span>'). '&nbsp;&nbsp;&nbsp;<a class="button" href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page'] . (isset($_GET['sID']) ? '&sID=' . $_GET['sID'] : '')) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?></td>
          </tr></TABLE>	  
	  </td>
      </tr>
</form></tr>
<?php
if($action == 'edit')
{
?>
          <tr>
            <td class="main" colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                  <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
                      <tr class="dataTableHeadingRow">
                        <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRODUCTS_PRICE; ?>&nbsp;</td>
                        <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCTS_SPECIAL_PRICE; ?></td>
                        <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_STATUS; ?></td>
                        <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
                      </tr>
<?php
$categ_id = ($sInfo->categ_id > 0) ? $sInfo->categ_id : 0;			    
$specials_query_raw = "select A.products_id, B.products_name, A.products_price, C.specials_id, C.specials_new_products_price, 
				C.specials_date_added, C.specials_last_modified, C.expires_date, C.date_status_change, C.status, F.special_id from " . 
				TABLE_PRODUCTS . " A, " . TABLE_PRODUCTS_DESCRIPTION . " B , products_to_categories E 
				left join " . TABLE_SPECIALS . " C on C.products_id = E.products_id left join special_product F on F.product_id = C.products_id
				left join special_category D on E.categories_id = D.categ_id where E.categories_id = $categ_id and E.products_id = A.products_id and 
				A.products_id = B.products_id and B.language_id = '" . (int)$_SESSION['languages_id'] . "' order by F.special_id, C.specials_id, B.products_name ";
$specials_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $specials_query_raw, $specials_query_numrows);
$specials_query = vam_db_query($specials_query_raw);
while ($specials = vam_db_fetch_array($specials_query))
{
	if($specials['specials_id'] > 0 && $specials['special_id'] > 0)
	{
		echo '                  <tr class="dataTableRowWTM3" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
	}
	else if($specials['specials_id'] > 0 && $specials['special_id'] < 1)
	{
		echo '                  <tr class="dataTableRowSelected" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
	}
	else if($specials['specials_id'] < 1 && $specials['special_id'] > 0)
	{
		echo '                  <tr class="dataTableRowWTM1" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
	}
	else
	{
		echo '                  <tr class="dataTableRowWTM2" onmouseover="rowOverEffect(this)" onmouseout="rowOutEffect(this)">' . "\n";
	}
	$class = $specials['specials_new_products_price'] != "" ? "oldPrice" : "specialPrice";
	$specials['specials_new_products_price'] = $specials['specials_new_products_price'] != "" ? sprintf("%0.2f", $specials['specials_new_products_price']) : "";
?>
<form action="?sID=<?php echo $_GET["sID"]; ?>&action=subcity&page=<?php echo $_GET["page"]; ?>" method="post">
<input type="hidden" name="product_id" value="<?php echo $specials['products_id']; ?>">
<input type="hidden" name="act">
		<td  class="dataTableContent"><?php echo $specials['products_name']; ?></td>
            <td  class="dataTableContent" align="right"><span class="<?php echo $class; ?>"><?php echo $currencies->format($specials['products_price']); ?></span>&nbsp;</td>
            <td  class="dataTableContent">&nbsp;<span class="specialPrice">$<input type="text" size="10" name="new_price" value="<?php echo $specials['specials_new_products_price']; ?>"></span></td>
		<td  class="dataTableContent" align="center">
<?php
	if($specials['specials_id'] > 0)
	{
		if ($specials['status'] == '1')
		{
			echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page='. $_GET["page"]. '&sID='. $_GET["sID"]. '&action=subsetflag&flag=0&id=' . $specials['specials_id'], 'NONSSL') . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
		}
		else
		{
			echo '<a href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page='. $_GET["page"]. '&sID='. $_GET["sID"]. '&action=subsetflag&flag=1&id=' . $specials['specials_id'], 'NONSSL') . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
		}
	}
	else if($specials['special_id'] > 0)
	{
			echo '<a href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page='. $_GET["page"]. '&sID='. $_GET["sID"]. '&action=noflag&pid=' . $specials['products_id'], 'NONSSL') . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;&nbsp;&nbsp;';
	}
	else
	{
		echo "N/A";
	}
?>
		</td>
                      <td class="dataTableContent" align="right">
<?php
if($specials['specials_id'] > 0)
{
?>
			    <span class="button"><input type="button" value="<?php echo BUTTON_UPDATE; ?>" onClick="this.form.act.value = 'update'; this.form.submit();"></span>&nbsp;&nbsp;<span class="button"><input type="button" value="<?php echo BUTTON_DELETE; ?>" onClick="this.form.act.value = 'delete'; this.form.submit();"></span>
<?php
}
else if($specials['special_id'] > 0 )
{
?>
			    <span class="button"><input type="button" value="<?php echo BUTTON_RE_ADD; ?>" onClick="this.form.act.value = 're-add'; this.form.submit();"></span>&nbsp;&nbsp;<span class="button"><input type="button" value="<?php echo BUTTON_DELETE; ?>" onClick="this.form.act.value = 'delete'; this.form.submit();"></span>
<?php
}
else
{
?>
			    <span class="button"><input type="button" value="<?php echo BUTTON_MAKE_SPECIAL; ?>" onClick="this.form.act.value = 'make-special'; this.form.submit();"></span>
<?php
}
?>			    
			    
			    </td>
</form>

                    </tr>
                    <?php
}
?>
                    <tr>
                      <td colspan="5"><table border="0" width="100%" cellpadding="0"cellspacing="2">
                        <tr>
                          <td class="smallText" valign="top"><?php echo $specials_split->display_count($specials_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_SPECIALS); ?></td>
                          <td class="smallText" align="right"><?php echo $specials_split->display_links($specials_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], "sID=". $_GET["sID"]. "&action=edit"); ?></td>
                        </tr>
                        <?php
          if (empty($action))
          {
?>
                        <tr>
                          <td colspan="2" align="right"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . BUTTON_NEW_PRODUCTS . '</span></a>'; ?></td>
                        </tr>
                        <?php
          }
?>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
              </table>
              </td>
          </tr>
<?php
}
?>  
        </table></td>
      </tr>
<?php
}
else
{
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="2" cellpadding="0" class="contentListingTable">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CATEGORY; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_SPECIAL_PRODUCT; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_CATEGORY_DISCOUNT; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
$specials_query_raw = "select A.special_id, A.categ_id, A.discount, A.discount_type, A.status, B.categories_name, A.special_date_added, A.special_last_modified, A.expire_date,
					A.date_status_change from ". TABLE_SPECIAL_CATEGORY. " A, " . TABLE_CATEGORIES_DESCRIPTION . " B where A.categ_id = B.categories_id and 
					B.language_id = '" . (int)$_SESSION['languages_id'] . "' order by B.categories_name";
$specials_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ADMIN_PAGE, $specials_query_raw, $specials_query_numrows);
$specials_query = vam_db_query($specials_query_raw);
while ($specials = vam_db_fetch_array($specials_query))
{
	if ((!isset($_GET['sID']) || (isset($_GET['sID']) && ($_GET['sID'] == $specials['special_id']))) && !isset($sInfo))
	{
		$products_query = vam_db_query("select categories_image from " . TABLE_CATEGORIES . " where categories_id = '" . (int)$specials['categ_id'] . "'");
		$products = vam_db_fetch_array($products_query);
		$sInfo_array = array_merge($specials, $products);
		$sInfo = new objectInfo($sInfo_array);
	}

	if (isset($sInfo) && is_object($sInfo) && ($specials['special_id'] == $sInfo->special_id))
	{
		echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->special_id . '&action=edit') . '\'">' . "\n";
	}
	else
	{
		echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $specials['special_id']) . '\'">' . "\n";
	}

	$query = "select count(*) as cnt from ". TABLE_SPECIAL_PRODUCT. " where special_id = ". $specials['special_id'];
	$prod_count = vam_db_query($query);
	$prod_count = vam_db_fetch_array($prod_count);
	$special_product = $prod_count['cnt'];


	$query = "select count(A.products_id) as cnt from ". TABLE_PRODUCTS_TO_CATEGORIES. " A, ". TABLE_SPECIAL_CATEGORY. " B where A.categories_id = B.categ_id and B.special_id = ". $specials['special_id'];
	$prod_count = vam_db_query($query);
	$prod_count = vam_db_fetch_array($prod_count);
	$total_product = $prod_count['cnt'];
?>
                <td  class="dataTableContent"><?php echo $specials['categories_name']; ?></td>
                <td  class="dataTableContent" align="center"><?php echo $special_product. " / ". $total_product; ?></td>
                <td  class="dataTableContent" align="right"><span class="specialPrice"><?php echo $specials['discount_type'] == "f" ? "$" : "%"; ?> <?php echo sprintf("%0.2f", $specials['discount']); ?></span></td>
                <td  class="dataTableContent" align="right">
<?php
if ($specials['status'] == '1')
{
	echo vam_image(DIR_WS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_GREEN, 10, 10) . '&nbsp;&nbsp;<a href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'action=setflag&flag=0&id=' . $specials['special_id'], 'NONSSL') . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_red_light.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
}
else
{
	echo '<a href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'action=setflag&flag=1&id=' . $specials['special_id'], 'NONSSL') . '">' . vam_image(DIR_WS_IMAGES . 'icon_status_green_light.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>&nbsp;&nbsp;' . vam_image(DIR_WS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_RED, 10, 10);
}
?>                </td>
                <td class="dataTableContent" align="right"><?php if (isset($sInfo) && is_object($sInfo) && ($specials['special_id'] == $sInfo->special_id)) { echo vam_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $specials['special_id']) . '">' . vam_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
      </tr>
<?php
}
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellpadding="0"cellspacing="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $specials_split->display_count($specials_query_numrows, MAX_DISPLAY_ADMIN_PAGE, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_SPECIAL_CATEGORY); ?></td>
                    <td class="smallText" align="right"><?php echo $specials_split->display_links($specials_query_numrows, MAX_DISPLAY_ADMIN_PAGE, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
if (empty($action))
{
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a class="button" href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . BUTTON_NEW_CATEGORIES . '</span></a>'; ?>&nbsp;<?php echo '<a class="button" href="' . vam_href_link(FILENAME_SPECIALS, 'page=' . $_GET['page'] . '&action=new') . '"><span>' . BUTTON_NEW_PRODUCTS . '</span></a>'; ?></td>
                  </tr>
<?php
}
?>
                </table></td>
              </tr>
            </table></td>
<?php
$heading = array();
$contents = array();

switch ($action)
{
	case 'delete':
	$heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_SPECIALS . '</b>');

	$contents = array('form' => vam_draw_form('specials', FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->special_id . '&action=deleteconfirm'));
	$contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
	$contents[] = array('text' => '<br><b>' . $sInfo->categories_name . '</b>');
	$contents[] = array('align' => 'center', 'text' => '<br><span class="button"><button type="submit" value="' . BUTTON_DELETE . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</button></span>&nbsp;<a class="button" href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->special_id) . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>');
	break;
	default:
	if (is_object($sInfo))
	{
		$discount_type = $sInfo->discount_type == "p" ? "Percentage" : "Flat Rate Diduction";
		$discount = $sInfo->discount_type == "p" ? sprintf("%0.2f", $sInfo->discount). " %" : $currencies->format($sInfo->discount);

		$heading[] = array('text' => '<b>' . $sInfo->categories_name . '</b>');

		$contents[] = array('align' => 'center', 'text' => '<a class="button" href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->special_id . '&action=edit') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/edit.png', '', '12', '12') . '&nbsp;' . BUTTON_EDIT . '</span></a> <a class="button" href="' . vam_href_link(FILENAME_CATEGORY_SPECIALS, 'page=' . $_GET['page'] . '&sID=' . $sInfo->special_id . '&action=delete') . '"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/delete.png', '', '12', '12') . '&nbsp;' . BUTTON_DELETE . '</span></a>');
		$contents[] = array('text' => '<br>' . TEXT_INFO_DATE_ADDED . ' ' . vam_date_short($sInfo->special_date_added));
		$contents[] = array('text' => '' . TEXT_INFO_LAST_MODIFIED . ' ' . vam_date_short($sInfo->special_last_modified));
		$contents[] = array('align' => 'center', 'text' => '<br>' . vam_info_image($sInfo->categories_image, $sInfo->categories_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT));
		$contents[] = array('text' => '<br>' . TEXT_INFO_DISCOUNT_TYPE . ' ' . $discount_type);
		$contents[] = array('text' => '' . TEXT_INFO_DISCOUNT . ' ' . $discount);

		$contents[] = array('text' => '<br>' . TEXT_INFO_EXPIRES_DATE . ' <b>' . vam_date_short($sInfo->expire_date) . '</b>');
		$contents[] = array('text' => '' . TEXT_INFO_STATUS_CHANGE . ' ' . vam_date_short($sInfo->date_status_change));
	}
	break;
}
if ( (vam_not_null($heading)) && (vam_not_null($contents)) )
{
	echo '            <td width="25%" valign="top">' . "\n";

	$box = new box;
	echo $box->infoBox($heading, $contents);

	echo '            </td>' . "\n";
}
}
?>
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
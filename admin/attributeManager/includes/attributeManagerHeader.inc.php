<?php
/*
  $Id: attributeManagerHeader.inc.php,v 1.0 21/02/06 Sam West$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Released under the GNU General Public License
  
  Copyright © 2006 Kangaroo Partners
  http://kangaroopartners.com
  osc@kangaroopartners.com
*/

if('new_product' == $_GET['action'] || 'update_product' == $_GET['action']) {
$amSessionVar = vam_session_name().'='.vam_session_id();
echo <<<HEADER
<script language="JavaScript" type="text/JavaScript">
	var productsId='{$_GET['pID']}';
	var pageAction='{$_GET['action']}';
	var sessionId='{$amSessionVar}';
</script>
<script language="JavaScript" type="text/JavaScript" src="attributeManager/javascript/requester.js"></script>
<script language="JavaScript" type="text/JavaScript" src="attributeManager/javascript/alertBoxes.js"></script>
<script language="JavaScript" type="text/JavaScript" src="attributeManager/javascript/attributeManager.js"></script>

<link rel="stylesheet" type="text/css" href="attributeManager/css/attributeManager.css" />
HEADER;
}
?>

<script language="JavaScript" type="text/javascript">

function goOnLoad() {
	<?php	if('new_product' == $_GET['action'] || 'update_product' == $_GET['action']) echo 'attributeManagerInit();';	?>
	SetFocus();
}

</script>

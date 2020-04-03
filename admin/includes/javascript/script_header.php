<script type="text/javascript" src="../jscript/jquery/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../jscript/jquery/plugins/ui/jquery-ui-min.js"></script>
<script type="text/javascript" src="includes/javascript/jquery/plugins/ui/datepicker-<?php echo $_SESSION['language_code']; ?>.js"></script>

<script type="text/javascript" src="includes/css/bootstrap4/popper.min.js"></script>
<script type="text/javascript" src="includes/css/bootstrap4/bootstrap.min.js"></script>

<script src="includes/javascript/vamshop-menu/js/vamshop-menu.min.js"></script>
<script src="includes/javascript/vamshop-menu/js/vamshop-menu-settings.js"></script> 	 
<script src="includes/javascript/vamshop-menu/js/lib/jquery.mCustomScrollbar.concat.min.js"></script> 
<script src="includes/javascript/vamshop-menu/js/lib/jquery.mousewheel.min.js"></script> 

<script type="text/javascript" src="/jscript/jquery/plugins/select2/select2.js"></script>

<script type="text/javascript" src="/jscript/jquery/plugins/maskedinput/jquery.maskedinput.min.js"></script>

<script language="javascript" src="includes/javascript/categories.js"></script>
<script type="text/javascript" src="includes/javascript/modified.js"></script>
<script language="javascript" src="includes/general.js"></script>

<?php
  if ( ($_GET['action'] == 'new') || ($_GET['action'] == 'edit') ) {
?>
<link href="includes/javascript/date-picker/css/datepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/javascript/date-picker/js/datepicker.js"></script>
<?php
  }
?>

<script src="<?php echo DIR_WS_CATALOG; ?>jscript/jquery/plugins/scrollup/jquery.scrollup.min.js"></script>
<script src="<?php echo DIR_WS_ADMIN; ?>includes/javascript/vamshop.js"></script>

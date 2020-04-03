<script src="../jscript/jquery/jquery-3.4.1.min.js"></script>
<script src="../jscript/jquery/plugins/ui/jquery-ui-min.js"></script>

<script src="includes/css/bootstrap4/popper.min.js"></script>
<script src="includes/css/bootstrap4/bootstrap.min.js"></script>

<script src="/jscript/jquery/plugins/select2/select2.js"></script>
<script src="/jscript/jquery/plugins/maskedinput/jquery.maskedinput.min.js"></script>

<script src="includes/javascript/categories.js"></script>
<script src="includes/javascript/modified.js"></script>
<script src="includes/general.js"></script>

<script src="includes/javascript/jquery/plugins/ui/datepicker-<?php echo $_SESSION['language_code']; ?>.js"></script>

<?php
  if ( ($_GET['action'] == 'new') || ($_GET['action'] == 'edit') ) {
?>
<link href="includes/javascript/date-picker/css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="includes/javascript/date-picker/js/datepicker.js"></script>
<?php
  }
?>
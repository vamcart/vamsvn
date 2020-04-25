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

<script src="includes/javascript/vamshop-menu/js/lib/jquery.mCustomScrollbar.concat.min.js"></script> 
<script src="includes/javascript/vamshop-menu/js/lib/jquery.mousewheel.min.js"></script> 

<script src="includes/javascript/vamshop-menu/js/vamshop-menu.min.js"></script>
<script src="includes/javascript/vamshop-menu/js/vamshop-menu-settings.js"></script> 	 

<script type="text/javascript" src="includes/javascript/jquery.limitText.min.js"></script>
<script type="text/javascript">
$(function(){
			
$(".meta-title").textcounter({
	type: "character",
	max: 70,
	countDown: false,
	countDownText: "%d символов из 70",
	displayErrorText: false,
	stopInputAtMaximum: false
});

$(".meta-description").textcounter({
	type: "character",
	max: 160,
	countDown: false,
	countDownText: "%d символов из 160",
	displayErrorText: false,
	stopInputAtMaximum: false
});

$(".meta-keywords").textcounter({
	type: "comma",
	max: 30,
	countDown: false,
	countDownText: "%d символов из 30",
	displayErrorText: false,
	stopInputAtMaximum: false
});

			});
		</script>


<?php
  if ( ($_GET['action'] == 'new') || ($_GET['action'] == 'edit') ) {
?>
<link href="includes/javascript/date-picker/css/datepicker.css" rel="stylesheet" type="text/css" />
<script src="includes/javascript/date-picker/js/datepicker.js"></script>
<?php
  }
?>
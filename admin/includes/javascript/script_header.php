<script type="text/javascript" src="../jscript/jquery/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="../jscript/jquery/plugins/ui/jquery-ui-min.js"></script>
<script type="text/javascript" src="includes/javascript/jquery/plugins/ui/datepicker-<?php echo $_SESSION['language_code']; ?>.js"></script>

<script type="text/javascript" src="includes/css/bootstrap4/popper.min.js"></script>
<script type="text/javascript" src="includes/css/bootstrap4/bootstrap.min.js"></script>

<script src="includes/javascript/scoop/js/scoop.min.js"></script>
<script src="includes/javascript/scoop/js/scoop-settings.js"></script> 	 
<script src="includes/javascript/scoop/js/lib/jquery.mCustomScrollbar.concat.min.js"></script> 
<script src="includes/javascript/scoop/js/lib/jquery.mousewheel.min.js"></script> 

<script type="text/javascript" src="/jscript/jquery/plugins/select2/select2.js"></script>

<script type="text/javascript"><!--
// Select2 added
$(function() {

var customSorter = function(data) {
     return data.sort(function(a,b){
         a = a.text.toLowerCase();
         b = b.text.toLowerCase();
         if(a > b) {
             return 1;
         } else if (a < b) {
             return -1;
         }
         return 0;
     });
};
	
	  $("select").select2({
	      theme: "bootstrap",
	      sorter: customSorter
	  });        
}); 
//--></script>

<script type="text/javascript" src="/jscript/jquery/plugins/maskedinput/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="/jscript/modified.js"></script>

<script language="javascript" src="includes/javascript/categories.js"></script>
<script language="javascript" src="includes/general.js"></script>
<script language="javascript"><!--
function popupWindow(url) {
  window.open(url,'popupWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=450,height=120,screenX=150,screenY=150,top=150,left=150')
}

function popupImageWindow(url) {
  window.open(url,'popupImageWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=100,height=100,screenX=150,screenY=150,top=150,left=150')
}
//--></script>

<script type="text/javascript">
	$(function() {
	$('a.tooltip').tooltip({
    content: function () {
        return this.getAttribute("title");
    }
	});
	});
</script>


<?php
  if ( ($_GET['action'] == 'new') || ($_GET['action'] == 'edit') ) {
?>
<link href="includes/javascript/date-picker/css/datepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="includes/javascript/date-picker/js/datepicker.js"></script>
<?php
  }
?>
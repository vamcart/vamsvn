<script src="jscript/jquery/jquery.js"></script>

<?php
require_once(DIR_FS_CATALOG."vendor/Bender/Bender.class.php");
$bender = new Bender();
?>

<?php
if (file_exists(dirname(__FILE__) . '/local.js.php')) include('local.js.php');
?>
<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $this->langCode; ?>" xml:lang="<?php echo $this->langCode; ?>">
<head>
<title><?php echo  $this->lang['title']; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="themes/<?php echo  $this->theme ?>/css/dialog.css" rel="stylesheet" type="text/css" media="all" />
<script language="javascript" type="text/javascript" src="themes/<?php echo $this->theme ?>/jscripts/general.js"></script>
<script language="javascript" type="text/javascript">
var demo = <?php echo  $this->data['demo'] ?>;
var demoMsg = "<?php echo  $this->data['demo_msg'] ?>";
var dirPath = "<?php echo  $this->data['dir_path'] ?>";

<?php if ($this->data['dirname'] && !$this->data['errorMsg']) { ?>
	if (window.opener)
		window.opener.execFileCommand("refresh", dirPath);

	top.close();
<?php } ?>

function init() {
<?php if ($this->data['errorMsg']) { ?>
	alert("<?php echo  isset($this->lang[$this->data['errorMsg']]) ? $this->lang[$this->data['errorMsg']] : $this->data['errorMsg'] ?>");
<?php } ?>
}

function verifyForm() {
	if (demo) {
		alert(demoMsg);
		return false;
	}

	return true;
}
</script>
</head>
<body onload="init();">
<form name="createdir" method="post" action="createdir.php" onsubmit="return verifyForm();">
<div class="mcBorderBottomWhite">
	<div class="mcHeader mcBorderBottomBlack">
		<div class="mcWrapper">
			<div class="mcHeaderLeft">
				<div class="mcHeaderTitle"><?php echo  $this->lang['title']; ?></div>
				<div class="mcHeaderTitleText"><?php echo  $this->lang['description']; ?></div>
			</div>
			<div class="mcHeaderRight">&nbsp;</div>
			<br style="clear: both" />
		</div>
	</div>
</div>
<div class="mcContent">
	<table border="0" cellspacing="0" cellpadding="4" width="100">
<?php if (count($this->data['templates']) > 1) { ?>
	  <tr>
		<td nowrap="nowrap"><?php echo  $this->lang['template']; ?> </td>
		<td>
		<select name="template" style="width: 200px" <?php echo (count($this->data['templates']) > 0 ? '' : 'disabled="disabled"')?>>
		  <option value="" selected><?php echo  $this->lang['select_template']; ?></option>
<?php foreach ($this->data['templates'] as $title => $path) { ?>
		  <option value="<?php echo $path?>" <?php echo ($path == $this->data['template'] ? "SELECTED" : "")?>><?php echo $title?></option>
<?php } ?>
		</select></td>
	  </tr>
<?php } ?>
	  <tr>
		<td nowrap="nowrap"><?php echo  $this->lang['directory_name']; ?></td>
		<td><input id="dirname" name="dirname" type="text" class="inputText" size="35" maxlength="100" style="width: 200px" value="<?php echo  $this->data['dirname']?>" /></td>
	  </tr>
	  <tr>
		<td nowrap="nowrap"><?php echo  $this->lang['create_in']; ?></td>
		<td><span title="<?php echo $this->data['full_path']?>"><?php echo $this->data['short_path']?></span></td>
	  </tr>
	</table>
	<input type="hidden" name="path" value="<?php echo $this->data['path']?>" />
	<input type="hidden" name="action" value="submit" />
</div>
<div class="mcFooter mcBorderTopBlack">
	<div class="mcBorderTopWhite">
		<div class="mcWrapper">
			<div class="mcFooterLeft"><input type="submit" name="Submit" value="<?php echo  $this->lang['button_create']; ?>" class="button" /></div>
			<div class="mcFooterRight"><input type="button" name="Cancel" value="<?php echo  $this->lang['button_cancel']; ?>" class="button" onclick="top.close();" /></div>
			<br style="clear: both" />
		</div>
	</div>
</div>
</form>
</body>
</html>

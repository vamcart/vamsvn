<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $this->langCode; ?>" xml:lang="<?php echo $this->langCode; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo  $this->lang['title']; ?> (<?php echo  ($this->data['gd_support'] ? "GD enabled" : "GD disabled"); ?> <?php echo  ($this->data['exif_support'] ? "EXIF enabled" : "EXIF disabled"); ?>)</title>
<script language="javascript" type="text/javascript">
	// Setup some variables.
	var disabledTools = '<?php echo $this->data['disabled_tools'] ?>';
	var hasReadAccess = <?php echo $this->data['hasReadAccess'] ?>;
	var hasWriteAccess = <?php echo $this->data['hasWriteAccess'] ?>;
	var path = "<?php echo $this->data['path'] ?>";
	var full_path = "<?php echo $this->data['full_path'] ?>";
	var errorMsg = "<?php echo (isset($this->data['errorMsg']) && isset($this->lang[$this->data['errorMsg']])) ? $this->lang[$this->data['errorMsg']] : ""; ?>";
	var formname = "<?php echo $this->data['formname'] ?>";
	var elementnames = "<?php echo  $this->data['elementnames'] ?>";
	var js = "<?php echo $this->data['js'] ?>";
	var demo = "<?php echo $this->data['demo'] ?>";
	var demo_msg = "<?php echo $this->data['demo_msg'] ?>";
	var filemanger_urlprefix = "<?php echo $this->data['filemanager_urlprefix']; ?>";
	var deleteConfirm = '<?php echo $this->lang["confirm_delete"] ?>';
	var editNoWriteAccess = "<?php echo $this->lang["editwriteaccess"]; ?>";
	var current = "";
</script>
<script language="javascript" type="text/javascript" src="themes/<?php echo $this->theme ?>/jscripts/general.js"></script>
<script language="javascript" type="text/javascript" src="themes/<?php echo $this->theme ?>/jscripts/ajax.js"></script>
<script language="javascript" type="text/javascript" src="themes/<?php echo $this->theme ?>/jscripts/mclayer.js"></script>
<script language="javascript" type="text/javascript" src="themes/<?php echo $this->theme ?>/jscripts/imagetools.js"></script>
<link href="themes/<?php echo  $this->theme ?>/css/general.css" rel="stylesheet" media="screen" type="text/css" />
<style type="text/css">
	.thumbnail { width: <?php echo  $this->data['thumbnail_width']; ?>px; height: <?php echo  ($this->data['thumbnail_height'] + 20); ?>px; margin: 0 <?php echo  $this->data['thumbnail_margin_around']; ?>px <?php echo  $this->data['thumbnail_margin_around']; ?>px <?php echo  $this->data['thumbnail_margin_around']; ?>px; }
	.image { width: <?php echo  $this->data['thumbnail_width']+2; ?>px;	height: <?php echo  $this->data['thumbnail_height']+2; ?>px; border: <?php echo  $this->data['thumbnail_border_style']; ?>; }
	.imagename { width: <?php echo  $this->data['thumbnail_width']; ?>px; }
	.imageinfo { width: <?php echo  $this->data['thumbnail_width']; ?>px; border: <?php echo  $this->data['thumbnail_border_style']; ?>; }
	.infowrap { width: 100%; }
	.infowrap div { width: 49%; float: left;}
</style>
</head>

<body onload="init();gotoAnchor('<?php echo $this->data['anchor']; ?>');">
<div class="imageinfo" id="imginfo">
	<div style="margin: 5px;">
		<div id="loadinfo"><?php echo $this->lang['loading']; ?></div>
		<?php if (count($this->data['information']) != 0) { ?>
		<div id="infowrap" class="infowrap">
			<?php if (in_array("width", $this->data['information'])) { ?>
				<div><?php echo $this->lang['width']; ?></div><div id="img_width">&nbsp;</div>
			<?php } ?>
			<?php if (in_array("height", $this->data['information'])) { ?>
				<div><?php echo $this->lang['height']; ?></div><div id="img_height">&nbsp;</div>
			<?php } ?>
			<?php if (in_array("type", $this->data['information'])) { ?>
				<div><?php echo $this->lang['type']; ?></div><div id="img_type">&nbsp;</div>
			<?php } ?>
			<?php if (in_array("size", $this->data['information'])) { ?>
				<div><?php echo $this->lang['size']; ?></div><div id="img_size">&nbsp;</div>
			<?php } ?>
			<?php if (in_array("scale", $this->data['information'])) { ?>
				<div><?php echo $this->lang['scale']; ?></div><div id="img_scale">&nbsp;</div>
			<?php } ?>
			<br style="clear: both;" />
		</div>
		<?php } ?>
	</div>
</div>

	<div class="toolbar">
		<div class="toolbarwrap">
			<fieldset style="width: auto;">
			<legend align="left"><?php echo  $this->lang['subtitle']; ?></legend>
				<div style="float: left;">
				<table border="0">
					<tr>
					<? if ($this->data['category_dropdown']) { ?>
						<td>&nbsp;<?php echo $this->lang['select_category']; ?>&nbsp;</td>
						<td>
							<select name="category" onchange="selectPath(this);">
							<?php foreach($this->data['rdirList'] as $rkey => $rval) { ?>
								<option value="<?php echo $rval; ?>" <?php echo ($this->data['root_path'] == $rval) ? "selected=\"selected\"" : ""; ?>><?php echo $rkey; ?></option>
							<? } ?>
							</select>
						</td>
				<? } ?>
						<td>&nbsp;<?php echo $this->lang['select_directory']; ?>&nbsp;</td>
						<td>
							<select name="folder" onchange="selectPath(this);">
							<?php foreach($this->data['dirlist'] as $dir) { ?>
								<option value="<?php echo $dir['abs_path']; ?>" <?php if ($this->data['selectedPath'] == $dir['path']) { echo "selected"; } ?>><?php echo $dir['path']; ?></option>
							<?php } ?>
							</select>
						</td>
					</tr>
				</table>
				</div>
				<div style="float: right;">
					<?php
						foreach ($this->data['toolbar'] as $item) {
							if ($item['command'] == "separator")
								echo '<img src="themes/' . $this->theme . '/images/spacer.gif" width="1" height="15" class="mceSeparatorLine" />';
							else
								echo '<a href="javascript:void(0);" onclick="execFileCommand(\'' . $item['command'] . '\');"><img id="' . $item['command'] . '" src="themes/' . $this->theme . '/images/' . $item['icon'] . '" alt="' . $this->lang[$item['command']] . '" title="' . $this->lang[$item['command']] . '" border="0" class="mceButtonDisabled" width="20" height="20" /></a>';
						}
					?>
				</div>
				<br style="clear:both;" />
			</fieldset>
		</div>
	</div>
	<div class="thwrapper" id="thwrapperdiv">
		<div class="thwrapperwrapper">
			<?php if (count($this->data['files']) == 0) { ?>
				<?php echo $this->lang['no_files']; ?>
			<?php } ?>
			<?php $imcount = 0; ?>
			<?php foreach($this->data['files'] as $file) { ?>
				<div class="thumbnail" id="th_<?php echo $file['name']; ?>">
					<a name="f_<?php echo $file['name']; ?>"></a>
					<div class="image loading" id="thi_<?php echo $file['name']; ?>">
						<div class="imagewrapper">
							<div style="float: left;" id="thc_<?php echo $file['name']; ?>">
							<?php if (in_array("preview", $this->data['image_tools'])) { ?>
								<a href="javascript:imagePreview(<?php echo $file['real_width']; ?>,<?php echo $file['real_height']; ?>,'<?php echo  $file['path'] ?>');"><img src="themes/<?php echo  $this->theme ?>/images/tool_preview.gif" width="16" height="16" border="0" alt="" /></a>
							<?php } ?>
							<?php if (in_array("info", $this->data['image_tools'])) { ?>
								<a href="javascript:void(0);"><img src="themes/<?php echo $this->theme ?>/images/tool_info.gif" width="16" height="16" onmouseover="getImageData('<?php echo $file['name'] ?>','<?php echo $file['path'] ?>');" onmouseout="hideImageData('<?php echo $file['name'] ?>');" border="0" alt="" /></a>
							<?php } ?>
							<?php if (in_array("delete", $this->data['image_tools'])) { ?>
								<a href="javascript:imageDelete('<?php echo $file['name']; ?>','<?php echo $file['path'] ?>');"><img src="themes/<?php echo $this->theme ?>/images/tool_del.gif" width="16" height="16" border="0" alt="" /></a>
							<?php } ?>
							<?php if (in_array("edit", $this->data['image_tools']) && $file['editable']) { ?>
								<a href="javascript:imageEdit('<?php echo $file['path'] ?>');"><img src="themes/<?php echo $this->theme ?>/images/tool_edit.gif" width="16" height="16" border="0" alt="" /></a>
							<?php } ?>
							</div>
							<?php if ($this->data['extension_image']) { ?>
							<div style="float: right;"><img src="themes/<?php echo $this->theme ?>/images/filetypes/<?php echo $file['icon']; ?>" width="16" height="16" alt="" /></div>
							<?php } ?>
							<br style="clear:both;" />
						</div>
						<div style="text-align: center;">
							<?php if ($this->data['insert']) { ?>
							<a href="javascript:insertURL('<?php echo $file['previewurl']; ?>');">
							<? } ?>
							<img name="img_spacer_<?php echo $imcount++; ?>" src="themes/<?php echo $this->theme ?>/images/spacer.gif" alt="<?php echo $file['name']; ?>" title="<?php echo htmlentities($file['url']); ?>" style="margin-top: <?php echo $file['margin']; ?>px;" border="0" width="<?php echo ($file['width']); ?>" height="<?php echo ($file['height']); ?>" />
							<?php if ($this->data['insert']) { ?></a><? } ?>
						</div>
					</div>
					<div class="imagename" style="position: absolute; top: <?php echo $this->data['thumbnail_height']+5; ?>px; width:<?php echo  $this->data['thumbnail_width']+2; ?>px; text-align: center;"><?php echo $file['name']; ?></div>
				</div>
			<?php } ?>
		</div>
	</div>
</body>
</html>

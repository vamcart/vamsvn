<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $this->langCode; ?>" xml:lang="<?php echo $this->langCode; ?>">
<head>
<title><?php echo  $this->lang['title']; ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="themes/<?php echo  $this->theme ?>/css/dialog.css" rel="stylesheet" type="text/css" media="all" />
<script language="javascript" type="text/javascript" src="themes/<?php echo  $this->theme ?>/jscripts/general.js"></script>
<script language="javascript" type="text/javascript">

// Setup extension check
var filesystemExtensions = "<?php echo  $this->data['filesystem.extensions'] ?>";
var filesystemInvalidExtensionMSG = "<?php echo  $this->data['filesystem.invalid_extension_msg'] ?>";
var uploadExtensions = "<?php echo  $this->data['upload.extensions'] ?>";
var uploadInvalidExtensionMSG = "<?php echo  $this->data['upload.invalid_extension_msg'] ?>";
var demo = <?php echo  $this->data['demo'] ?>;
var demoMsg = "<?php echo  $this->data['demo_msg'] ?>";

<?php if ($this->data['filename0'] && !$this->data['errorMsg']) { ?>
	if (window.opener)
		window.opener.execFileCommand("refresh");

	top.close();
<?php } ?>

function updateFileName(form, elm) {
	var fileName = elm.value;
	var elements;
	var name;

	var pos = fileName.lastIndexOf('/');
	pos = pos == -1 ? fileName.lastIndexOf('\\') : pos;

	fileName = cleanFileName(fileName.substring(pos+1));

	if (pos > 0) {
		if ((pos = fileName.lastIndexOf('.')) != -1)
			fileName = fileName.substring(0, pos);

		elements = document.forms['uploadForm'].elements;

		for (i=0; i<elements.length; i++) {
			name = elements[i].getAttribute("name");
			if (name == "filename"+ form)
				elements[i].value = fileName;
		}
	}
}

function validateExtension(file_name, extensions) {
	var fileExt = "";

	file_name = file_name.toLowerCase();
	extensions = extensions.toLowerCase();

	if (extensions == "" || extensions == "*")
		return true;

	// Get file ext
	if (file_name.lastIndexOf('.') != -1)
		fileExt = file_name.substring(file_name.lastIndexOf('.')+1);

	var extensions = extensions.split(',');
	for (var i=0; i<extensions.length; i++) {
		var ext = extensions[i];
		if (ext != "" && ext == fileExt)
			return true;
	}

	return false;
}

function validateForm(form) {

	if (demo) {
		alert(demoMsg);
		return false;
	}

	var elements = form.elements;

	for (i=0; i<elements.length; i++) {
		var name = elements[i].getAttribute("name");
		var value = elements[i].value;

		if (name == null)
			continue;

		//var indexfilename = name.indexOf("filename");
		//var indexfile = name.indexOf("file");
		var isFile = ((name.indexOf("file") == 0) && (name.indexOf("filename") == -1)) ? true : false;

		if (isFile) {
			fileid = name.substring(4);
			if (value != "") {
				var filename = document.getElementById('filename'+fileid);

				if (filename.value != "") {
					if (!validateExtension(value, filesystemExtensions)) {
						alert(filesystemInvalidExtensionMSG);
						elements[i].focus();
						return false;
					}

					// Do javascript check (Much faster)
					if (!validateExtension(value, uploadExtensions)) {
						alert(uploadInvalidExtensionMSG);
						elements[i].focus();
						return false;
					}
				} else {
					alert('<?php echo  $this->lang['required_filename']; ?>');
					return false;
				}
			}
		}
	}

	form.SubmitBtn.disabled = true;

	return true;
}

var numRows = <?php echo  $this->data['numfiles']; ?>;
var scrollCount = 0;

function addRow(id, addheight, skip_add) {
	var html = "";

	if (!skip_add)
		numRows++;

	scrollCount++;

	var elm = document.createElement("div");
	elm.id = 'row_' + numRows;

	html += '<hr />';
	html += '<table border="0" cellspacing="0" cellpadding="4">';
	html += '<tr><td nowrap="nowrap"><?php echo  $this->lang['file_to_upload']; ?></td>';
	html += '<td><input name="file' + numRows + '" type="file" size="23" onchange="updateFileName('+ numRows +', this);" /></td>';
	html += '<td><a href="javascript:delRow(\'row_'+ numRows +'\')" class="mceButtonNormal"><img src="themes/<?php echo $this->theme ?>/images/tool_upload_del.gif" alt="<?php echo  $this->lang['remove'] ?>" title="<?php echo  $this->lang['remove'] ?>" border="0" /></a></td>';
	html += '</tr><tr><td nowrap="nowrap"><?php echo  $this->lang['as_file_name']; ?></td>';
	html += '<td colspan="2"><input id="filename' + numRows + '" name="filename' + numRows + '" type="text" class="inputText" size="35" maxlength="255" style="width: 200px" /></td>';
	html += '</tr></table>';

	elm.innerHTML = html;

	document.getElementById(id).appendChild(elm);
	document.forms['uploadForm'].numfiles.value = numRows;
}

function delRow(id) {
	var elm = document.getElementById(id);
	if (elm) {
		elm.parentNode.removeChild(elm);
		scrollCount--;
		document.forms['uploadForm'].numfiles.value = (document.forms['uploadForm'].numfiles.value - 1);
	}
}

function init() {
	var myRows = parseInt(numRows);
	if (myRows != 0) {
		for (var i=0; i<myRows; i++) {
			addRow('addPosition', false, true);
		}
	}

<?php if ($this->data['errorMsg']) { ?>
	alert("<?php echo  isset($this->lang[$this->data['errorMsg']]) ? $this->lang[$this->data['errorMsg']] : $this->data['errorMsg'] ?>");
<?php } ?>
}
</script>

</head>
<body onload="init();">
<form name="uploadForm" method="post" action="upload.php" enctype="multipart/form-data" onsubmit="return validateForm(this);">
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
	<table border="0" cellspacing="0" cellpadding="4">
	  <tr>
		<td nowrap="nowrap"><?php echo  $this->lang['upload_in']; ?></td>
		<td><span title="<?php echo $this->data['full_path']?>"><?php echo $this->data['short_path']?></span></td>
	  </tr>
	  <?php if ($this->data['valid_extensions'] != "" && $this->data['valid_extensions'] != "*") { ?>
		  <tr>
			<td nowrap="nowrap"><?php echo  $this->lang['valid_extensions']; ?></td>
			<td><?php echo  $this->data['valid_extensions'] ?></td>
		  </tr>
	  <?php } ?>
	  <?php if ($this->data['max_file_size'] != "") { ?>
		  <tr>
			<td nowrap="nowrap"><?php echo  $this->lang['max_upload_size']; ?></td>
			<td><?php echo  $this->data['max_file_size'] ?></td>
		  </tr>
	  <?php } ?>
	</table>
	<hr />
	<table id="row_0" border="0" cellspacing="0" cellpadding="4">
	  <tr>
		<td nowrap="nowrap"><?php echo  $this->lang['file_to_upload']; ?></td>
		<td><input name="file0" type="file" size="23" onchange="updateFileName(0, this);" value="" /></td>
		<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	  </tr>
	  <tr>
		<td nowrap="nowrap"><?php echo  $this->lang['as_file_name']; ?></td>
		<td colspan="2"><input id="filename0" name="filename0" type="text" class="inputText" size="35" maxlength="255" style="width: 200px" value="" /></td>
	  </tr>
	</table>
	  <div id="addPosition"></div>
	<input type="hidden" name="path" value="<?php echo $this->data['path']?>" />
	<input type="hidden" name="numfiles" value="<?php echo $this->data['numfiles']?>" />
<br /><br />
</div>
	<div class="mcFooter mcBorderTopBlack">
		<div class="mcBorderTopWhite">
			<div class="mcWrapper">
				<div class="mcFooterLeft"><input type="submit" name="SubmitBtn" value="<?php echo  $this->lang['button_upload']; ?>" class="button" />&nbsp;&nbsp;<input type="button" name="addupload" value="<?php echo  $this->lang['button_add_upload']; ?>" class="button" onclick="addRow('addPosition', true);" /></div>
				<div class="mcFooterRight"><input type="button" name="Cancel" value="<?php echo  $this->lang['button_cancel']; ?>" class="button" onclick="top.close();" /></div>
				<br style="clear: both" />
			</div>
		</div>
	</div>
</form>
</body>
</html>

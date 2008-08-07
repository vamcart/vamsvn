<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $this->langCode; ?>" xml:lang="<?php echo $this->langCode; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo  $this->lang['title']; ?> - <?php echo  $this->data['name']; ?> - <?php echo  $this->data['width']; ?>x<?php echo  $this->data['height']; ?> - <?php echo  $this->data['size']; ?></title>
<link href="themes/<?php echo  $this->theme ?>/css/preview.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="themes/<?php echo  $this->theme ?>/jscripts/general.js"></script>

<script language="javascript" type="text/javascript">
	var nexturl = "<?php echo $this->data['next']['path']; ?>";
	var nextwidth = <?php echo $this->data['next']['width']; ?>;
	var nextheight = <?php echo $this->data['next']['height']; ?>;

	var previousurl = "<?php echo $this->data['previous']['path']; ?>";
	var previouswidth = <?php echo $this->data['previous']['width']; ?>;
	var previousheight = <?php echo $this->data['previous']['height']; ?>;

	var firsturl = "<?php echo $this->data['first']['path']; ?>";
	var firstwidth = <?php echo $this->data['first']['width']; ?>;
	var firstheight = <?php echo $this->data['first']['height']; ?>;

	var lasturl = "<?php echo $this->data['last']['path']; ?>";
	var lastwidth = <?php echo $this->data['last']['width']; ?>;
	var lastheight = <?php echo $this->data['last']['height']; ?>;

	var heightmodifier = 105; // 50 + 25 for prev/next links
	var widthmodifier = 130;

	function previewimage(url) {
		if (url != "")
			window.document.location.href = "preview.php?path=" + url +"";
	}

	function setsize(width, height) {
		height += heightmodifier;
		width += widthmodifier;

		// need to have space for previous / next buttons
		if (width < 300)
			width = 300;

		if (height < 200)
			height = 200;

		var isMSIE = (navigator.appName == "Microsoft Internet Explorer");
		var x = Math.round(parseInt(screen.width / 2.0) - (width / 2.0));
		var y = Math.round(parseInt(screen.height / 2.0) - (height / 2.0));
		
		if (x < 0)
			x = 0;

		if (y < 0)
			y = 0;

		window.resizeTo(1, 1);
		window.moveTo(0,0);
		window.moveTo(x,y);

		if (width > screen.availWidth) {
			width = screen.availWidth;
			height = screen.availHeight;
		}

		window.resizeTo(width, height);
		window.status = "XY: " + x + ","+ y + " | WH:" + width + "," + height;
	}

	function checkKey(event) {
		var key = getkey(event);
		switch (key) {
			case 32: // space
			case 110: // n
			case 34: // page down
			case 39: // right arrow
				previewimage("<?php echo $this->data['next']['path']; ?>");
			break;
			case 102: // p
			case 33: // page up
			case 37: // left arrow
				previewimage("<?php echo $this->data['previous']['path']; ?>");
			break;
		}

		if (key == 27)
			window.close(); // escape
	}

	function getkey(e) {
		if (window.event)
			return window.event.keyCode;
		else if (e)
			return e.keyCode;
		else
			return null;
	}

	function imageError(name) {
		var image = document.getElementById("i_"+ name);
		image.style.display = "none";
		var container = document.getElementById("imagecontainer");
		container.className = container.className + " error";
	}

	setsize(<?php echo $this->data['width']; ?>,<?php echo $this->data['height']; ?>);

</script>
</head>
<body onkeypress="checkKey(event);" onkeydown="checkKey(event);" onload="">
<div class="next_prev">
	<?php if (($this->data['first']['path'] != "") AND ($this->data['first']['path'] != $this->data['path'])) { ?>
		<a href="javascript:previewimage('<?php echo $this->data['first']['path']; ?>');" title="<?php echo $this->lang['keyboard_prev']; ?>"><img src="themes/<?php echo $this->theme ?>/images/preview_bbackward.gif" width="22" height="22" alt="<?php echo $this->lang['first']; ?>" title="<?php echo $this->lang['first']; ?>" border="0" /></a>
	<?php } else { ?>
		<img src="themes/<?php echo $this->theme ?>/images/preview_bbackward.gif" width="22" height="22" alt="<?php echo $this->lang['first']; ?>" title="<?php echo $this->lang['first']; ?>" class="inactive" />
	<?php } ?>

	<?php if ($this->data['previous']['path'] != "") { ?>
		<a href="javascript:previewimage('<?php echo $this->data['previous']['path']; ?>');" title="<?php echo $this->lang['keyboard_prev']; ?>"><img src="themes/<?php echo $this->theme ?>/images/preview_backward.gif" width="22" height="22" alt="<?php echo $this->lang['prev']; ?>" title="<?php echo $this->lang['prev']; ?>" border="0" /></a>
	<?php } else { ?>
		<img src="themes/<?php echo $this->theme ?>/images/preview_backward.gif" width="22" height="22" alt="<?php echo $this->lang['prev']; ?>" title="<?php echo $this->lang['prev']; ?>" class="inactive" />
	<?php } ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php if ($this->data['next']['path'] != "") { ?>
	<a href="javascript:previewimage('<?php echo $this->data['next']['path']; ?>');" title="<?php echo $this->lang['keyboard_next']; ?>"><img src="themes/<?php echo $this->theme ?>/images/preview_forward.gif" width="22" height="22" alt="<?php echo $this->lang['next']; ?>" title="<?php echo $this->lang['next']; ?>" border="0" /></a>
	<?php } else { ?>
		<img src="themes/<?php echo $this->theme ?>/images/preview_forward.gif" width="22" height="22" alt="<?php echo $this->lang['next']; ?>" title="<?php echo $this->lang['next']; ?>" class="inactive" />
	<?php } ?>

	<?php if (($this->data['last']['path'] != "") AND ($this->data['last']['path'] != $this->data['path'])) { ?>
		<a href="javascript:previewimage('<?php echo $this->data['last']['path']; ?>');" title="<?php echo $this->lang['keyboard_prev']; ?>"><img src="themes/<?php echo $this->theme ?>/images/preview_fforward.gif" width="22" height="22" alt="<?php echo $this->lang['last']; ?>" title="<?php echo $this->lang['last']; ?>" border="0" /></a>
	<?php } else { ?>
		<img src="themes/<?php echo $this->theme ?>/images/preview_fforward.gif" width="22" height="22" alt="<?php echo $this->lang['last']; ?>" title="<?php echo $this->lang['last']; ?>" class="inactive" />
	<?php } ?>
</div>
<div class="preview_container">
	<div class="preview_image" id="imagecontainer">
		<img src="<?php echo $this->data['previewurl']; ?>?time=<?php echo time(); ?>" width="<?php echo $this->data['width']; ?>" height="<?php echo $this->data['height']; ?>" alt="<?php echo $this->data['name']; ?>" title="<?php echo $this->data['name']; ?>" id="i_<?php echo $this->data['name']; ?>" onerror="imageError('<?php echo $this->data['name']; ?>');" />
	</div>
</div>
</body>
</html>

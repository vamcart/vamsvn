<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?> 
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php echo $this->langCode; ?>" xml:lang="<?php echo $this->langCode; ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?= $this->data['title']; ?></title>
<meta http-equiv="imagetoolbar" content="no" />
<link href="themes/<?php echo $this->theme ?>/css/general.css" rel="stylesheet" type="text/css" />
</head>
<body id="errorBody">
<table border="0" width="100%" height="100%">
	<tr height="100%">
		<td height="100%" valign="middle" width="100%" align="middle">
			<table border="0">
				<tr>
					<td>
						<fieldset style="width: 600px;padding: 0; margin: 0;">
							<legend style="margin-left: 9px;">&nbsp;<?= $this->data['title']; ?>&nbsp;</legend>
							<div style="padding: 15px;">
								<div style="float: left;">
									<img src="themes/<?php echo $this->theme ?>/images/alert.gif" />
								</div>
								<div style="float: right; width: 520px; overflow: auto;">
								An error has occured, this might be cause by bad configuration, user error or a bug in the system, review the following information.<br /><br />
								<strong>Error message: </strong><br /><?php echo $this->data['errstr'] ?><br /><br />
								<? if (count($this->data['backtrace']) > 0) { ?>
									<? 
									foreach($this->data['backtrace'] as $key => $val) {
										for ($i=0; $i<count($val['args']); $i++) {
											if (is_array($val['args'][$i]))
												$val['args'][$i] = "{array}";

											if (is_object($val['args'][$i]))
												$val['args'][$i] = "{object}";
										}

										if ($key > 1)
											echo "Error on line <strong>" . $val['line'] ."</strong>, function <span title=\"". htmlentities(implode(", ", $val['args'])) ."\" onclick=\"alert('Arguments: ' + this.getAttribute('title'));\" style=\"font-weight: bold;\">". $val['function'] ."</span> in file <strong>". $val['file'] ."</strong><br />";
									} 
									?>
								<br />
								<? } ?>
								</div>
								
							</div>
							<br style="clear: both"/>
							<br />
						</fieldset>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>

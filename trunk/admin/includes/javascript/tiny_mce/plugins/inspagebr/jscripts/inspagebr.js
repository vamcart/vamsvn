function init() {
	tinyMCEPopup.resizeToInnerSize();

	var formObj = document.forms[0];

	formObj.insert.value = tinyMCE.getLang('lang_' + tinyMCE.getWindowArg('mceDo'),'Insert',true);
}

function cancelAction() {
	tinyMCEPopup.close();
}

  function insertPageBrake(el) {
  	var pageBreakTag = 'PAGEBR';
    var html = '{'+pageBreakTag+' title="'+document.getElementById('title').value+'" keyws="'+document.getElementById('keys').value+'" desc="'+document.getElementById('desc').value+'"'+'}';
//    var_dump([sourceValue, sourceStart, sourceEnd, sourceValue.substring(0, sourceStart), sourceValue.substring(sourceEnd)]);

	tinyMCEPopup.execCommand("mceInsertContent", true, html);
	tinyMCEPopup.close();

    return true;
  }

function GenericCheckInput(id, type, msg, radioListCount) {
	var err = 0;

	if (type == "file") {
		if (document.getElementById(id).files.length == 0) {
			err = 1;
		}
	} else if (type == "text") {
		if (document.getElementById(id).value.trim() == "") {
			err = 1;
		}
	} else if (type == "integer") {
		if (document.getElementById(id).value.trim() == "") {
			err = 1;
		} else if (!isNumber(document.getElementById(id).value)) {
			err = 1;
		}
	} else if (type == "decimal") {
		if (document.getElementById(id).value.trim() == "") {
			err = 1;
		} else if (!isNumber(document.getElementById(id).value) && !IsDecmial(document.getElementById(id).value)) {
			err = 1;
		}
	} else if (type == "select") {
		var selectDropDown = document.getElementById(id);
		if (selectDropDown.options[selectDropDown.selectedIndex].value == 0 || selectDropDown.options[selectDropDown.selectedIndex].value == "") {
			err = 1;
		}
	} else if (type == "checkboxList") {
		var checkboxList = document.getElementsByName(id);
		var checkboxListValue = 0;
		for (var i = 0, length = checkboxList.length; i < length; i++) {
			if (checkboxList[i].checked) {
				checkboxListValue = checkboxList[i].value;
				break;
			}
		}
		if (checkboxListValue == 0) {
			err = 1;
		}
	} else if (type == "email") {
		if (document.getElementById(id).value == "") {
			err = 1;
		} else if (!validateEmail(document.getElementById(id).value)) {
			err = 1;
		}
	} else if (type == "phone") {
		if (document.getElementById(id).value == "") {
			err = 1;
		} else if (document.getElementById(id).value.length < 8) {
			err = 1;
		}
	} else if (type == "radio") {
		var value = '';
		for (var i = 0; i < radioListCount; i++) {
			if (document.getElementById(id + i).checked) {
				value = document.getElementById(id + i).value;
				break;
			}
		}
		if (value == '') {
			err = 1;
		}
	}

	if (err == 0) {
		SetInnerHtml(id + 'Error', '');
		return 0;
	} else {
		document.getElementById(id).focus();
		SetInnerHtml(id + 'Error', '<font class = "error">' + msg + '</font>');
		return 1;
	}
}


function isNumber(n) {
	return !isNaN(parseFloat(n)) && isFinite(n);
}

function IsDecmial(input) {
	//var RE = new RegExp("/^{0,1}\d*\.{0,1}\d+$/");
	return input.match(/^(\d+\.?\d*|\.\d+)$/);
	//return (RE.test(input));
}

function SetInnerHtml(id, msg) {
	document.getElementById(id).innerHTML = msg;
}
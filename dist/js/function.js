var domain = "";
function SetDomain(inComeDomain) {
	domain = inComeDomain;
}

function OpenModal(id) {
	$(document).ready(function () {
		 $("#" + id).modal('show'); 
	});
}

function CloseModal(id) {
	$(document).ready(function () {
		 $("#" + id).modal('hide'); 
	});
}


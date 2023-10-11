function checkupload(transID) {
        var files = $("#fileupload"+transID).val();
        if(files =='') {
                alert("Please select the file before submit");
                return false;
        }
	if(!$("#firmupload"+transID).is(':checked')) {
                alert("Please Click the ready for delivery checkbox before to submit");
                return false;
        }	
	if($("#timestamping"+transID).length > 0) {
		if(!$("#timestamping"+transID).is(':checked')) {
			alert("Please Click the Document is complete with timestamp checkbox before to submit");
			return false;
		}
	}
        return true;
}

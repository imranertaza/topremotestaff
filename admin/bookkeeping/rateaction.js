function rateit(selectpos) {
        var haverate = 0;
	var URL = "ranking.php";
        var error = rateval = type = ID = "";
        $('input.star:input[name='+selectpos+']').each(function() {
//              if($("#"+selectpos).checked) {
                if(this.checked) {
//                      alert(this.name+':'+this.value);
                        haverate = 1;
                        rateval = this.value;
                        type = this.name.split("_")[0];
                        ID = this.name.split("_")[1];
                }
        });
        if(haverate == 0) {
                error += "Please rate before submit\n";
        }
        if($("#"+selectpos+"comment").val() == "") {
                error += "Please type the comment before submit\n";
        }
        if(error != "") {
                alert(error);
                return false;
        }
        $.post(URL , { IDtype: type , stars: rateval , comment: $("#"+selectpos+"comment").val() , ID: ID} , function(data) {
//		alert(data);
		if(data == "success") {
			window.location.reload();	
		}	
        });
}

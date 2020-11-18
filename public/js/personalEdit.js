window.addEventListener("load", function(){
	
	var cargo = $("#car").val();
	var situacion = $("#situacion").val();
	var zona = $("#zo").val();
	var depende = $("#depende").val();

	console.log(cargo+' '+situacion+' '+zona);
	$('#cargo option[value="'+ cargo +'"]').attr("selected",true);
	$('#situacionLaboral option[value="'+ situacion +'"]').attr("selected",true);
	$('#zona option[value="'+ zona +'"]').attr("selected",true);
	$('#enlazar option[value="'+ depende +'"]').attr("selected",true);
	
	$('#dni').keyup(function () { 
	    this.value = this.value.replace(/[^0-9]/g,'');
	    validDNI();
	});

});

function validDNI(){
	var valid = $("#dni").val();
	if (valid.length == 8) {
		if (valid > 6000000 && valid < 40000000) {
			$("#dnilHelp").show();
		}else{
			$("#dni").addClass('is-invalid');
			$("#dnilHelp").hide();
			$("#mess").show();
		}
	}else{
		$("#mess").hide();
		$("#btn").addClass('disabled');
	}
}


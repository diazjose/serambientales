window.addEventListener("load", function(){
	
	var status = $("#status").val();
	var barrio = $("#barrio_id").val();

	$('#barrio option[value="'+ barrio +'"]').attr("selected",true);	

});




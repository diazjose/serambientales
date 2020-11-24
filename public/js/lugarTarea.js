function tarea(){
	$("#Title").html('');
	$("#boton").text('');
	$("#idTarea").val('');
    $('#tarea').val('');
    $('#fechaInicio').val('');
    $('#fechaFin').val('');	
	$('#estado').val("");
	$("#formTarea").attr("action",'');
	$("#formTarea").attr("action",'http://localhost/serambientales/public/designarLugar/crear');
	$("#Title").append('Agregar Tarea');
	$("#boton").text('Agregar Tarea');
	$("#boton").removeClass('btn-success');
	$("#boton").addClass('btn-primary');
	
}

function editTarea(idTarea,tarea,inicio,fin,estado){
	$("#Title").html('');
	$("#boton").text('');
	$("#idTarea").val('');
    $('#tarea').val('');
    $('#fechaInicio').val('');
    $('#fechaFin').val('');	
	$('#estado').val("");
	$("#formTarea").attr("action",'');
	$("#formTarea").attr("action",'http://localhost/serambientales/public/designarLugar/editar');
	$("#Title").append('Editar Tarea');
	$("#idTarea").val(idTarea);
    $('#tarea option[value="'+ tarea +'"]').attr("selected",true);	
    $('#estado option[value="'+ estado +'"]').attr("selected",true);
    $('#fechaInicio').val(inicio);
    $('#fechaFin').val(fin);
	$("#boton").text('Actializar Tarea');
	$("#boton").removeClass('btn-primary');
	$("#boton").addClass('btn-success');	
}
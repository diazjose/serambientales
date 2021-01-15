window.addEventListener("load", function(){

});

function nuevo(){
	$("#Title").html('');
	$("#boton").text('');
	$("#tarea_id").val('');
	$('#nombre').val('');
	$("#formTarea").attr("action",'');
	$("#formTarea").attr("action",'tarea/create');
	$("#Title").append('Agregar Tarea');
	$("#boton").text('Agregar Tarea');
	$("#boton").removeClass('btn-success');
	$("#boton").addClass('btn-rojo');
	
}

function editTarea(id,nombre,estado){
	$("#Title").html('');
	$("#boton").text('');
	$("#tarea_id").val('');
	$("#formTarea").attr("action",'');
	$("#formTarea").attr("action",'tarea/update');
	$("#Title").append('Actualizar Tarea');
	$("#tarea_id").val(id);
	$("#nombre").val(nombre);
	$('#estado option[value="'+ estado +'"]').attr("selected",true);
	$("#boton").text('Actualizar Tarea');
	$("#boton").removeClass('btn-rojo');
	$("#boton").addClass('btn-success');
	
}

function deleteTarea(id,nombre){
	$("#nombreTarea").text(nombre);
	$("#tareaNombre").val(nombre);
	$("#id_tarea").val(id);
}
      
               
function tarea(){
	$("#Title").html('');
	$("#boton").text('');
	$("#idTarea").val('');
    $('#tarea').val('');
    $('#fechaInicio').val('');
    $('#fechaFin').val('');	
	$('#estado').val("");
	$("#formTarea").attr("action",'');
	$("#formTarea").attr("action",'../../designarLugar/crear');
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
	$("#formTarea").attr("action",'../../designarLugar/editar');
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

function denuncia(){
	$("#dTitle").html('');
	$("#dboton").text('');
	$("#idDenuncia").val('');
    $('#denunciante').val('');
	$('#denuncia').val('');
	$("#dstatus").hide();
    $("#formDenuncia").attr("action",'');
	$("#formDenuncia").attr("action",'../../denuncia/registrar');
	$("#dTitle").append('Registrar Denuncia');
	$("#dboton").text('Registrar Denuncia');
	$("#dboton").removeClass('btn-success');
	$("#dboton").addClass('btn-primary');
	
}

function editDenuncia(idDenuncia,denunciante,denuncia,estado){
	$("#dTitle").html('');
	$("#dboton").text('');
	$("#idDenuncia").val('');
    $('#denunciante').val('');
    $('#denuncia').val('');
    $("#formDenuncia").attr("action",'');
	$("#formDenuncia").attr("action",'../../denuncia/update');
	$("#dTitle").append('Editar Denuncia');
	$("#idDenuncia").val(idDenuncia);
	$("#dstatus").show();
    $('#destado option[value="'+ estado +'"]').attr("selected",true);
    $('#denunciante').val(denunciante);
    $('#denuncia').val(denuncia);
	$("#dboton").text('Actializar Denuncia');
	$("#dboton").removeClass('btn-primary');
	$("#dboton").addClass('btn-success');	
}
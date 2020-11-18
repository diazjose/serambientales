window.addEventListener("load", function(){

});

function nuevo(){
	$("#Title").html('');
	$("#boton").text('');
	$("#barrio_id").val('');
	$('#nombre').val('');
	$("#formBarrio").attr("action",'');
	$("#formBarrio").attr("action",'http://localhost/serambientales/public/barrio/create');
	$("#Title").append('Agregar Barrio');
	$("#boton").text('Agregar Barrio');
	$("#boton").removeClass('btn-success');
	$("#boton").addClass('btn-rojo');
	
}

function editBarrio(id,nombre,zona){
	$("#Title").html('');
	$("#boton").text('');
	$("#barrio_id").val('');
	$("#formBarrio").attr("action",'');
	$("#formBarrio").attr("action",'http://localhost/serambientales/public/barrio/update');
	$("#Title").append('Actualizar Barrio');
	$("#barrio_id").val(id);
	$("#nombre").val(nombre);
	$('#zona option[value="'+ zona +'"]').attr("selected",true);
	$("#boton").text('Actualizar Barrio');
	$("#boton").removeClass('btn-rojo');
	$("#boton").addClass('btn-success');
	
}

function deleteBarrio(id,nombre){
	$("#nombreBarrio").text(nombre);
	$("#barrioNombre").val(nombre);
	$("#id_barrio").val(id);
}
      
               
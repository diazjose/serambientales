window.addEventListener("load", function(){
	$("#bus_per").click(function(){
		var dni = $("#dni").val();
		var form = $("#form-search");
		var url = form.attr('action');
		$("#form_buscar").val(dni);
		var data = form.serialize();
		$.ajax({          
	        url: '../../personal/buscar',
	        type: 'POST',
	        data : data,
	        success: function(data){
	        	if(data.status == 'success'){
	        		var persona = data.persona;
	        		$("#id_persona").val(persona[0].id);
					$("#name").val(persona[0].apellidos+" "+persona[0].nombre);
					$("#btn").prop('disabled', false);
	        	}else{
	        		$("#id_persona").val("");
					$("#name").val("");
					$("#btn").prop('disabled', true);
	        	}
	        }
	    });
	});
	$('#dni').keyup(function () { 
	    this.value = this.value.replace(/[^0-9]/g,'');
	    validDNI();
	});
	

});

function editInsumo(id,nombre,cantidad){
	$("#insumo_id").val(id);
	$("#enombre").val(nombre);
    $('#ecantidad').val(cantidad);
}

function deleteBarrio(id,nombre){
	$("#nombreBarrio").text(nombre);
	$("#barrioNombre").val(nombre);
	$("#id_barrio").val(id);
}

function editEntrega(id,nombre,apellido,cantidad,fecha){
	$("#intregarInsumo_id").val(id);
	$("#epersona").val(apellido+", "+nombre);
	$('#ecantidad').val(cantidad);
	$("#edevolucion").val(fecha);	
}

function deletePrestar(id){
	$("#id_prestar").val(id);
}
	  
function validDNI(){
	var valid = $("#dni").val();
	if (valid.length == 8) {
		if (valid > 6000000 && valid < 40000000) {
			$("#bus_per").prop('disabled', false);
			$("#dni").removeClass('is-invalid');
			$("#mess").hide();
		}else{
			$("#bus_per").prop('disabled', true);
			$("#dni").addClass('is-invalid');
			$("#mess").show();
		}
	}else{
		$("#mess").hide();
		$("#bus_per").prop('disabled', true);
	}
}
               
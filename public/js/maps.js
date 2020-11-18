var marker;  //variable del marcador
var coords	= {}; // coordenadas obtenidas con la geolocalizacion

//funcion principal

iniMap = function(){

	//Usamos la API para golocalizar el usuario
	navigator.geolocation.getCurrentPosition(
		function(position){
			coords = {
				lng: position.coords.longitude,
				lat: position.coords.latitude
			};
			setMapa(coords); //pasamos la coordenadas al metodo para crear el mapa

		},function(error){console.log(error);});
}

function setMapa(coords){

	// Se crea  una nueva instancia del objeto mapa
	var map = 	new google.maps.Map(document.getElementById('map'),
	{
		zoom: 16,
		center: new google.maps.LatLng(coords.lat, coords.lng),
	});

	//Creamos el marcador en el mapa con sus propiedades
	//para nuestro objetivo tenemos que poner al atributo draggable en true
	//position pondremos las misma coordenadas que obtuvimos en la geolocalizacion
	marker = new google.maps.Marker({
		map: map,
		draggable: true,
		animation: google.maps.Animation.DROP,
		position: new google.maps.LatLng(coords.lat,coords.lng),
	});

	//agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica
	//cuando el usuario al soltar el marcador
	marker.addListener('click', toggleBounce);
	marker.addListener('dragend', function(event){
		//escribimos las coordenadas de la posicion actual del marcador dentro del input #coors
		document.getElementById("coords").value = this.getPosition().lat()+","+this.getPosition().lng();
	});	
}

//callback añ hacer click en el marcador lo que hace es quitar y poner la animacion BOUNCE
function toggleBounce(){
	if (marker.getAnimation() !== null ) {
		marker.setAnimation(null);
	}else{
		marker.setAnimation(google.maps.Animacion.BOUNCE);
	}
}


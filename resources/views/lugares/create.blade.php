@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card border-red">
                <div class="card-header text-white title bg-rojo"><h3>{{ __('Registrar Lugar') }}</h3></div>

                <div class="card-body bg-camel">
                    <form method="POST" action="{{ route('lugar.create') }}">

                    <div class="row">
                        <div class="col-md-4">
                            
                                @csrf
                                <div class="form-group">
                                    <label for="calle" class="title">{{ __('Calle') }}</label>
                                    <input id="calle" type="text" class="form-control @error('calle') is-invalid @enderror" name="calle" value="{{ old('calle') }}" required autocomplete="calle" autofocus>
                                    @error('calle')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="numero" class="title">{{ __('Numero') }}</label>
                                    <input id="numero" type="number" class="form-control @error('numero') is-invalid @enderror" name="numero" value="{{ old('numero') }}" required autocomplete="numero" autofocus>
                                    @error('numero')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="barrio" class="title">Barrio</label>
                                    <select class="custom-select" id="barrio" name="barrio" required>
                                        <option selected disabled value="">-- Elegir Opcion --</option>
                                        @foreach($barrios as $ba)
                                        <option value="{{$ba->id}}">{{$ba->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                   
                                <div class="form-group">
                                    <label for="latitud" class="title">{{ __('latitud') }}</label>
                                    <input id="latitud" type="text" class="form-control @error('latitud') is-invalid @enderror" name="latitud" value="{{ old('latitud') }}" autocomplete="latitud">
                                    @error('latitud')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="longitud" class="title">{{ __('Longitud') }}</label>
                                    <input id="longitud" type="text" class="form-control @error('longitud') is-invalid @enderror" name="longitud" value="{{ old('longitud') }}" autocomplete="longitud">
                                    @error('longitud')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
 
                        </div>
                            
                        <!-- MAPS -->
                        <div class="col-md-8">
                            <div id="map" class="google_canvas"></div>
                        </div>
                    </div>
                    <hr class="border-red">        
                    <div class="form-group">
                        <button type="submit" class="btn btn-rojo btn-lg title btn-block">
                            <i class="fas fa-map-marker-alt"></i> {{ __('Regitrar Lugar') }}
                        </button>
                    </div>
                    </form>                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('js/consultas.js')}}"></script>

    <script>
        var marker;          //variable del marcador
        var coords = {};    //coordenadas obtenidas con la geolocalización
         
        //Funcion principal
        initMap = function () 
        {
         
            //usamos la API para geolocalizar el usuario
                /*
                navigator.geolocation.getCurrentPosition(
                  function (position){
                    coords =  {
                      lng: position.coords.longitude,
                      lat: position.coords.latitude
                    };
                    setMapa(coords);  //pasamos las coordenadas al metodo para crear el mapa
                    
                   
                  },function(error){console.log(error);});
                */
                coords = {
                    lng: -66.862471,
                    lat: -29.432384
                }    
                setMapa(coords);
        }
         
         
         
        function setMapa (coords)
        {   
              //Se crea una nueva instancia del objeto mapa
              var map = new google.maps.Map(document.getElementById('map'),
              {
                zoom: 14,
                center:new google.maps.LatLng(coords.lat,coords.lng),
         
              });
         
              //Creamos el marcador en el mapa con sus propiedades
              //para nuestro obetivo tenemos que poner el atributo draggable en true
              //position pondremos las mismas coordenas que obtuvimos en la geolocalización
              marker = new google.maps.Marker({
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                position: new google.maps.LatLng(coords.lat,coords.lng),
         
              });
              //agregamos un evento al marcador junto con la funcion callback al igual que el evento dragend que indica 
              //cuando el usuario a soltado el marcador
              marker.addListener('click', toggleBounce);
              
              marker.addListener( 'dragend', function (event)
              {
                //escribimos las coordenadas de la posicion actual del marcador dentro del input #coords
                document.getElementById("latitud").value = this.getPosition().lat();
                document.getElementById("longitud").value = this.getPosition().lng();
              });
        }
         
        //callback al hacer clic en el marcador lo que hace es quitar y poner la animacion BOUNCE
        function toggleBounce() {
          if (marker.getAnimation() !== null) {
            marker.setAnimation(null);
          } else {
            marker.setAnimation(google.maps.Animation.BOUNCE);
          }
        }
         
        // Carga de la libreria de google maps 
 
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCsPND1hxm0AB7SsyOmPA1a_yJsDxnmJ3k&callback=initMap"></script>

@endsection
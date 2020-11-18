@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="text-center my-3">
            <h2 class="title display-3">Administrar Lugares</h2>
        </div><br>
        <a href="{{route('lugar.register')}}"  class="btn btn-rojo title"><i class="fas fa-city"></i> Agregar Lugar</a>
        <br><hr>
        @if(session('message'))
        <div class="alert alert-{{ session('status') }}">
            <strong>{{ session('message') }}</strong>   
        </div>  
        @endif 
        <div class="card">
            <div class="card-header bg-rojo text-white title"><h3>Listado de Lugares</h3></div>
            <div class="card-body"> 
                @if(count($lugares)>0)
                <div class="table-responsive my-5 justify-content-center" id="resultado">
                    <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Dirección</th>
                                <th>Barrio</th>
                                <th>Zona</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($lugares as $l)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$l->calle}} N° {{$l->numero}}</td>
                                <td>{{$l->barrio->nombre}}</td>
                                <td>{{$l->barrio->zona}}</td>
                                <td>
                                    <a href="{{route('lugar.view',[$l->id])}}" class="btn btn-outline-info"  title="Ver Lugar" ><i class="fas fa-eye"></i></a>
                                    <a href="{{route('lugar.edit',[$l->id])}}" class="btn btn-outline-success"  title="Editar Lugar" ><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-outline-danger" title="Eliminar Lugar" ><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            @php($i++)
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Dirección</th>
                                <th>Barrio</th>
                                <th>Zona</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center my-5">
                    <h4 class="text-danger my-5"><strong>NO SE REGISTRO NINGUN LUGAR...</strong></h4>
                </div>    
                @endif
            </div>    
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="barrioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-rojo text-white">
        <h4 class="modal-title title" id="exampleModalCenterTitle"><strong id="Title"></strong></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-camel">
            <form method="POST" action="" id="formBarrio">
                @csrf
                <input type="hidden" name="id" id="barrio_id" value="">
                <div class="form-group">
                    <label for="nombre" class="title"><h5>{{ __('Nombre') }}</h5></label>
                    <input type="text" name="nombre" id="nombre" style="text-transform:uppercase;" class="form-control">
                </div>

                <div class="form-group">
                    <label for="zona" class="title"><h5>{{ __('Zona') }}</h5></label>
                    <select name="zona" id="zona" class="form-control" required>
                        <option selected disabled>--Elegir Opción--</option>
                        <option value="Norte">Norte</option>
                        <option value="Sur">Sur</option>
                        <option value="Este">Este</option>
                        <option value="Oeste">Oeste</option>
                        <option value="Centro">Centro</option>
                    </select>
                </div>                
                <hr>
                <div class="form-group mx-2">
                    <button type="submit" class="btn btn-success title" id="boton"></button>
                </div>
            </form>        
      </div>      
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="confirm">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><strong>¿Estas seguro de realizar esta accion?</strong></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#confirm-si">Si</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="confirm-si">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">¿Desea eliminar el barrio <strong>"<span id="nombreBarrio"></span>"</strong>?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form method="POST" action="{{route('barrio.destroy')}}">
          @csrf
          <input type="hidden" name="id" id="id_barrio" value="">
          <input type="hidden" name="name" id="barrioNombre" value="">
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Si</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
          </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('script')
    <script src="{{ asset('js/consultas.js') }}"></script>
    <script src="{{ asset('js/barrios.js') }}"></script>
@endsection
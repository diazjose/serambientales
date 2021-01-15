@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="text-center my-3">
            <h2 class="title display-3">Administrar Maquinarias</h2>
        </div><hr>
        <div class="card">
          <div class="card-header bg-rojo text-white title">
            <h3>Agregar Herramienta</h3>
          </div>
          <div class="card-body bg-camel">
            <form class="form" method="POST" action="{{route('maquinaria.create')}}">
              @csrf
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="nombre" class="title">Maquinaria</label>
                  <input type="text" class="form-control" id="nombre" name="nombre" required>
                </div>
                <div class="form-group col-md-6">
                  <label for="dominio" class="title">Dominio</label>
                  <input type="text" class="form-control" id="dominio" name="dominio" required>
                </div>
              </div>
              <button type="submit" class="btn btn-rojo mb-2 title">Agregar Maquinaria</button>
            </form>
          </div>
        </div>  
        <!--
        <a href="#" data-toggle="modal" data-target="#barrioModal" onclick="nuevo()" class="btn btn-rojo title"><i class="fas fa-city"></i> Agregar Herramienta</a>
        -->
        <hr><br>
        @if(session('message'))
        <div class="alert alert-{{ session('status') }}">
            <strong>{{ session('message') }}</strong>   
        </div>  
        @endif 
        <div class="card">
            <div class="card-header bg-rojo text-white title"><h3>Listado de Maquinarias</h3></div>
            <div class="card-body"> 
                @if(count($maquinarias)>0)
                <div class="table-responsive my-5 justify-content-center" id="resultado">
                    <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Maquinaria</th>
                                <th>Dominio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($maquinarias as $he)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$he->nombre}}</td>
                                <td>{{$he->dominio}}</td>
                                <td>
                                    <h4 class="text-white">
                                      @if($he->estado == 'Libre')
                                      <span class="badge rounded-pill bg-success" id="status">{{$he->estado}}</span>
                                      @else
                                      <span class="badge rounded-pill bg-danger" id="status">{{$he->estado}}</span>
                                      @endif
                                    </h4>  
                                </td>
                                <td>
                                    <a href="#" onclick="editMaquinaria({{$he->id}},'{{$he->nombre}}','{{$he->dominio}}')" class="btn btn-outline-success" data-toggle="modal" data-target="#maquinariaModal" title="Editar Maquinaria" ><i class="fas fa-edit"></i></a>
                                    <a href="{{route('maquinaria.view',$he->id)}}" class="btn btn-outline-info" title="Ver Herramienta" ><i class="far fa-eye"></i></a>
                                </td>
                            </tr>
                            @php($i++)
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Maquinaria</th>
                                <th>Dominio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center my-5">
                    <h4 class="text-danger my-5"><strong>NO SE REGISTRO NINGUNA MAQUINARIA...</strong></h4>
                </div>    
                @endif
            </div>    
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="maquinariaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-rojo text-white">
        <h4 class="modal-title title" id="exampleModalCenterTitle"><strong id="Title">Actualizar Maquinaria</strong></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-camel">
            <form method="POST" action="{{route('maquinaria.update')}}" >
                @csrf
                <input type="hidden" name="id" id="maquinaria_id" value="">
                <div class="form-group">
                    <label for="enombre" class="title"><h5>{{ __('Nombre') }}</h5></label>
                    <input type="text" name="nombre" id="enombre" style="text-transform:uppercase;" class="form-control">
                </div>

                <div class="form-group">
                    <label for="edominio" class="title"><h5>{{ __('Dominio') }}</h5></label>
                    <input type="text" name="dominio" id="edominio" class="form-control">
                </div>                
                <hr>
                <div class="form-group mx-2">
                    <button type="submit" class="btn btn-success title" id="boton">Actualizar</button>
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
        <h4 class="modal-title" id="myModalLabel">¿Desea eliminar esta Maquinaria?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form method="POST" action="">
          @csrf
          <input type="hidden" name="id" id="id_barrio" value="">
          <input type="hidden" name="name" id="maquinariaNombre" value="">
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
    <script src="{{ asset('js/maquinarias.js') }}"></script>
@endsection
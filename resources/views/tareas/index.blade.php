@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="text-center my-3">
            <h2 class="title display-3">Administrar Tareas</h2>
        </div><br>
        <a href="#" data-toggle="modal" data-target="#tareaModal" onclick="nuevo()" class="btn btn-rojo title"><i class="fas fa-tasks"></i> Agregar Tarea</a>
        <br><hr>
        @if(session('message'))
        <div class="alert alert-{{ session('status') }}">
            <strong>{{ session('message') }}</strong>   
        </div>  
        @endif 
        <div class="card">
            <div class="card-header bg-rojo text-white title"><h3>Listado de Tareas</h3></div>
            <div class="card-body"> 
                @if(count($tareas)>0)
                <div class="table-responsive my-5 justify-content-center" id="resultado">
                    <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($tareas as $t)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$t->nombre}}</td>
                                <td>
                                    @if($t->estado == 'Activo')
                                    <h3 class="text-primary"><i class="far fa-check-circle"></i></h3>
                                    @else
                                    <h3 class="text-danger"><i class="far fa-times-circle"></i></h3>
                                    @endif
                                </td>
                                <td>
                                    <a href="#" onclick="editTarea({{$t->id}},'{{$t->nombre}}','{{$t->estado}}')" class="btn btn-outline-success" data-toggle="modal" data-target="#tareaModal" title="Editar Tarea" ><i class="fas fa-edit"></i></a>
                                    <a href="#" onclick="deleteTarea({{$t->id}},'{{$t->nombre}}')" data-toggle="modal" data-target="#confirm" class="btn btn-outline-danger" title="Eliminar Tarea" ><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            @php($i++)
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center my-5">
                    <h4 class="text-danger my-5"><strong>NO SE REGISTRO NINGUNA TAREA...</strong></h4>
                </div>    
                @endif
            </div>    
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="tareaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-rojo text-white">
        <h4 class="modal-title title" id="exampleModalCenterTitle"><strong id="Title"></strong></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-camel">
            <form method="POST" action="" id="formTarea">
                @csrf
                <input type="hidden" name="id" id="tarea_id" value="">
                <div class="form-group">
                    <label for="nombre" class="title"><h5>{{ __('Nombre') }}</h5></label>
                    <input type="text" name="nombre" id="nombre" style="text-transform:uppercase;" class="form-control">
                </div>

                <div class="form-group">
                    <label for="estado" class="title"><h5>{{ __('Estado') }}</h5></label>
                    <select name="estado" id="estado" class="form-control" required>
                        <option selected disabled>--Elegir Opción--</option>
                        <option value="Activo">Activo</option>
                        <option value="DesActivo">Bloquear</option>
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
        <h4 class="modal-title" id="myModalLabel">¿Desea eliminar la Tarea <strong>"<span id="nombreTarea"></span>"</strong>?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form method="POST" action="{{route('tarea.destroyTask')}}">
          @csrf
          <input type="hidden" name="id" id="id_tarea" value="">
          <input type="hidden" name="name" id="tareaNombre" value="">
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
    <script src="{{ asset('js/tarea.js') }}"></script>
@endsection
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="text-center my-3">
            <h2 class="title display-3">Ficha Personal</h2> 
        </div>
        <hr class="border-red">
        @if(session('message'))
        <div class="alert alert-{{ session('status') }}">
            <strong>{{ session('message') }}</strong>   
        </div>  
        @endif 
        <div class="mx-2">
            <div class="card">
                <div class="card-header bg-rojo text-white title">
                    <h3>Datos Personales</h3>
                </div>
                <div class="card-body bg-camel"> 
                    <h5 class="mx-3"> 
                        <div class="row my-2">   
                            <div class="form-group col-md-3">
                                <label for="nombre" class="title">{{ __('Nombre') }}</label><br>
                                {{$auth->apellidos}} {{$auth->nombre}}      
                            </div>
                            <div class="form-group col-md-3">
                                <label class="title">{{ __('N° Documento') }}</label><br>
                                {{$auth->dni}}
                            </div>
                            <div class="form-group col-md-3">
                                <label for="nombre" class="title">{{ __('Fecha de Nacimiento') }}</label><br>
                                {{date('d/m/Y', strtotime($auth->fechaNac))}}     
                            </div>
                            <div class="form-group col-md-3">
                                <label class="title">{{ __('N° Teléfono') }}</label><br>
                                {{$auth->telefono}}
                            </div>
                        </div>    
                        <div class="row my-2">
                            <div class="form-group col-md-3">
                                <label for="nombre" class="title">{{ __('Correo Electrónico') }}</label><br>
                                @if($auth->email != '') {{$auth->email}} @else No Tiene...@endif     
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nombre" class="title">{{ __('Domicilio') }}</label><br>
                                {{$auth->direccion}}     
                            </div>
                             <div class="form-group col-md-3" >
                                <label class="title">Depende de</label><br>
                                @if(count($auth->depende)>0)
                                    @foreach($auth->depende as $dep)
                                        @if($dep->persona_id == $auth->id)
                                        {{$dep->coordinador->apellidos}} {{$dep->coordinador->nombre}}
                                        @endif
                                    @endforeach    
                                @else
                                NADIE...
                                @endif
                            </div>                          
                        </div>
                    </h5>
                    <a href="{{route('personal.edit', [$auth->id])}}" class="btn btn-success btn-lg title"><i class="fas fa-id-card"></i> Editar</a>
                    <a href="#" class="btn btn-danger btn-lg title"  data-toggle="modal" data-target="#confirmDelete"><i class="fas fa-user-minus"></i> Eliminar</a>
                    <a href="{{route('personal.asistencia',[$auth->id])}}" class="btn btn-light border border-dark btn-lg title"><i class="far fa-clipboard"></i> Asistencia</a>
                    
                </div>                    
            </div>    
            @if($auth->cargo != 'PERSONAL VOLUNTARIO')
            <br>
            <div class="card">
                <div class="card-header bg-rojo text-white title">
                    <h3>Datos del Personal a cargo</h3>
                </div>
                
                @if(count($dependiente)>0)
                <div class="mx-2">
                    <div class="table-responsive my-5 justify-content-center" id="resultado">
                        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Lugar</th>
                                    <th>Tarea</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach($dependiente as $dep)
                                <tr>
                                    @if($dep->persona->habilitado != 'No')
                                    <td>{{$i}}</td>
                                    <td>{{$dep->persona->apellidos}} {{$dep->persona->nombre}}</td>
                                    <td>{{$dep->persona->telefono}}</td>
                                    <td>
                                        @if(isset($dep->persona->tarea)) 
                                        {{$dep->persona->tarea->lugar->denominacion}}<br>
                                        Tarea: {{$dep->persona->tarea->tarea}}<br>
                                        Horario: {{date('H:i', strtotime($dep->persona->tarea->horaEntrada))}} a {{date('H:i', strtotime($dep->persona->tarea->horaSalida))}}
                                        @else
                                        NINGUNO...
                                        @endif
                                    </td>
                                    <td>
                                        @if($dep->persona->tarea)
                                        <a href="#" class="btn btn-outline-success" onclick="editTarea({{$dep->persona->tarea->id}},{{$dep->persona->id}},'{{$dep->persona->apellidos}}','{{$dep->persona->nombre}}','{{$dep->persona->tarea->lugar->id}}','{{$dep->persona->tarea->horaEntrada}}','{{$dep->persona->tarea->horaSalida}}','{{$dep->persona->tarea->tarea}}')" data-toggle="modal" data-target="#tareaModal" title="Editar Tarea" ><i class="far fa-edit"></i></a>
                                        <a href="#" class="btn btn-outline-danger" onclick="eliminarTarea({{$dep->persona->tarea->id}}, '{{$dep->persona->apellidos}} {{$dep->persona->nombre}}')" data-toggle="modal" data-target="#confirm"  title="Eliminar Tarea" ><i class="far fa-trash-alt"></i></a>
                                        @else
                                        <a href="#" class="btn btn-outline-primary" onclick="tarea({{$dep->persona->id}},'{{$dep->persona->apellidos}}','{{$dep->persona->nombre}}')" data-toggle="modal" data-target="#tareaModal" title="Agregar Tarea" ><i class="fas fa-clipboard-list"></i></a>
                                        <a href="#" class="btn btn-outline-success disabled" title="Editar Tarea" ><i class="far fa-edit"></i></a>
                                        @endif

                                    </td>
                                    @endif
                                </tr>
                                @php($i++)
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>    
                @else
                <div class="text-center my-5">
                    <h4 class="text-danger my-5"><strong>NO SE REGISTRO NINGUN PERSONAL...</strong></h4>
                </div>    
                @endif
            </div>
            @endif
        </div>
    </div>    
</div>



<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="confirmDelete">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><strong>¿Estas seguro de realizar esta accion?</strong></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#confirm-siDelete">Si</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="confirm-siDelete">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">¿Desea eliminar a <strong>"<span id="nombrePersona">{{$auth->apellidos}} {{$auth->nombre}}</span>"</strong>?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form method="POST" action="{{route('personal.destroy')}}">
          @csrf
          <input type="hidden" name="id" value="{{$auth->id}}">
          <input type="hidden" name="name" value="{{$auth->apellidos}} {{$auth->nombre}}">
          <div class="modal-footer">
            <button type="submit" class="btn btn-danger">Si</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
          </div>
      </form>
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
        <h4 class="modal-title" id="myModalLabel">¿Desea eliminar la tarea de <strong>"<span id="nombreTarea"></span>"</strong>?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form method="POST" action="{{route('personal.destroyTarea')}}">
          @csrf
          <input type="hidden" name="id" value="{{$auth->id}}">
          <input type="hidden" name="idTarea" id="deleteTarea" value="">
          <input type="hidden" name="name" id="tareaName" value="">
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
@endsection
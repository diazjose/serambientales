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
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Lugar</th>
                                    <th>Asistencia</th>
                                    <th>Tarea</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dependiente as $dep)
                                <tr>
                                    @if($dep->persona->habilitado != 'No')
                                    <td>{{$dep->persona->apellidos}} {{$dep->persona->nombre}}</td>
                                    <td>{{$dep->persona->telefono}}</td>
                                    <td>
                                        @if($dep->persona->tarea) 
                                        {{$dep->persona->tarea->lugar->calle}} N° {{$dep->persona->tarea->lugar->numero}} B° {{$dep->persona->tarea->lugar->barrio->nombre}}<br>
                                        Tarea: {{$dep->persona->tarea->tarea->nombre}}<br>
                                        @else
                                        NINGUNO...
                                        @endif
                                    </td>
                                    <td>
                                        @if($dep->persona->tarea)
                                          @if($dep->persona->tarea->estado == 'Ausente')
                                          <a href="#" onclick="asistencia({{$dep->persona->tarea->id}},'{{$dep->persona->apellidos}}','{{$dep->persona->nombre}}','{{$dep->persona->tarea->estado}}','{{$dep->persona->tarea->observacion}}')" data-toggle="modal" data-target="#asistenciaModal"><h4><span class="badge badge-pill badge-danger">{{$dep->persona->tarea->estado}} <i class="far fa-times-circle"></i></span></h4></a>
                                          @else
                                          <a href="#" onclick="asistencia({{$dep->persona->tarea->id}},'{{$dep->persona->apellidos}}','{{$dep->persona->nombre}}','{{$dep->persona->tarea->estado}}','{{$dep->persona->tarea->observacion}}')" data-toggle="modal" data-target="#asistenciaModal"><h4><span class="badge badge-pill badge-primary">{{$dep->persona->tarea->estado}} <i class="far fa-check-circle"></i></span></h4></a>
                                          @endif
                                        @endif
                                    </td>
                                    <td>
                                        @if($dep->persona->tarea)
                                        <a href="#" class="btn btn-outline-success" onclick="editTarea({{$dep->persona->tarea->id}},{{$dep->persona->id}},'{{$dep->persona->apellidos}}','{{$dep->persona->nombre}}','{{$dep->persona->tarea->lugar->id}}','{{$dep->persona->tarea->tarea_id}}')" data-toggle="modal" data-target="#tareaModal" title="Editar Tarea" ><i class="far fa-edit"></i></a>
                                        <a href="#" class="btn btn-outline-danger" onclick="eliminarTarea({{$dep->persona->tarea->id}}, '{{$dep->persona->apellidos}} {{$dep->persona->nombre}}')" data-toggle="modal" data-target="#confirm"  title="Eliminar Tarea" ><i class="far fa-trash-alt"></i></a>
                                        @else
                                        <a href="#" class="btn btn-outline-primary" onclick="tarea({{$dep->persona->id}},'{{$dep->persona->apellidos}}','{{$dep->persona->nombre}}')" data-toggle="modal" data-target="#tareaModal" title="Agregar Tarea" ><i class="fas fa-clipboard-list"></i></a>
                                        <a href="#" class="btn btn-outline-success disabled" title="Editar Tarea" ><i class="far fa-edit"></i></a>
                                        @endif

                                    </td>
                                    @endif
                                </tr>
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


<!-- Modal -->
<div class="modal fade" id="tareaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-rojo">
        <h4 class="modal-title title text-white" id="Title"></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-camel">
            <form method="POST" action="" id="formTarea">
                @csrf
                <input type="hidden" name="idTarea" id="tarea_id">
                <input type="hidden" name="id" value="{{$auth->id}}">
                <input type="hidden" name="persona_id" id="persona_id" value="">
                <div class="form-group">
                    <label for="nombre" class="title">Asignar Tarea a:</label>
                    <p id="nombre"></p>
                </div>
                <div class="form-group">
                    <label for="lugar" class="title">Lugar</label>
                    <select class="custom-select" id="lugar" name="lugar" required>
                        <option selected disabled value="">-- Elegir Lugar --</option>
                        @foreach($lugares as $lu)
                        <option value="{{$lu->lugar_id}}">{{$lu->lugar->calle}} N° {{$lu->lugar->numero}} {{$lu->lugar->barrio->nombre}}</option>
                        @endforeach
                    </select>
                </div>
               <!--
                <div class="form-group">
                    <label for="horaEntrada" class="title">{{ __('Hora de Entrada') }}</label>
                    <input id="horaEntrada" type="time"  class="form-control @error('horaEntrada') is-invalid @enderror" name="horaEntrada" placeholder="00:00" autocomplete="horaEntrada" autofocus>
                </div>
                <div class="form-group">
                    <label for="horaSalida" class="title">{{ __('Hora de Salida') }}</label>
                    <input id="horaSalida" type="time" class="form-control @error('horaSalida') is-invalid @enderror" name="horaSalida" autocomplete="horaSalida" placeholder="00:00" autofocus>
                </div>
-->
                <div class="form-group">
                    <label for="tarea" class="title">Tarea Asignada</label>
                    <select class="custom-select" id="tarea" name="tarea" required>
                        <option selected disabled value="">-- Elegir Tarea --</option>
                        @foreach($tareas as $t)
                        <option value="{{$t->id}}">{{$t->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                
                <hr>
                <div class="form-group mx-2">
                    <button type="submit" class="btn btn-primary title" id="boton"></button>
                </div>
            </form>        
      </div>      
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
      <form method="POST" action="{{route('tarea.destroy')}}">
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

<div class="modal fade" id="asistenciaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-rojo">
        <h4 class="modal-title title text-white" id="Title">Registrar Asistencia</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-camel">
            <form method="POST" action="{{route('tarea.assistance')}}" id="formTarea">
                @csrf
                <input type="hidden" name="idTarea" id="idTarea">
                <input type="hidden" name="id" value="{{$auth->id}}">
                <input type="hidden" name="name" id="nameTarea" value="">
                <div class="form-group">
                    <label for="name" class="title">Asistencia de:</label>
                    <p id="name"></p>
                </div>
                <div class="form-group">
                    <label for="asis" class="title">Estado</label>
                    <select class="custom-select" id="asis" name="estado" required>
                        <option selected disabled value="">-- Elegir Opción --</option>
                        <option value="Ausente">Ausente</option>
                        <option value="Presente">Presente</option>
                    </select>
                </div>      
                <div class="form-group">
                    <label for="observacion" class="title">observación</label>
                    <textarea name="" id="" cols="30" rows="3" class="form-control"></textarea>
                </div>                    
                
                <hr>
                <div class="form-group mx-2">
                    <button type="submit" class="btn btn-primary title">Registrar Asistencia</button>
                </div>
            </form>        
      </div>      
    </div>
  </div>
</div>


@endsection
@section('script')
    <script src="{{ asset('js/consultas.js') }}"></script>
@endsection
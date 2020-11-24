@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <!--<div class="text-center my-3">
            <h2 class="title display-3">Ficha del Lugar</h2> 
        </div>-->
        <hr class="border-red">
        @if(session('message'))
        <div class="alert alert-{{ session('status') }}">
            <strong>{{ session('message') }}</strong>   
        </div>  
        @endif 
        <div class="mx-2">
            <div class="card">
                <div class="card-header bg-rojo text-white title"><h3>Ficha del Lugar</h3></div>
                <div class="card-body bg-camel">
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="title my-3 mx-3 p-2">Datos del Lugar</h3> 
                            <hr class=" mx-3">
                            <h5 class="mx-3"> 
                                <div class="form-group">
                                    <label for="nombre" class="title">{{ __('Calle') }}</label><br>
                                    {{$lugar->calle}}      
                                </div>
                                <div class="form-group">
                                    <label class="title">{{ __('Numero') }}</label><br>
                                    {{$lugar->numero}}
                                </div>
                                <div class="form-group">
                                    <label for="nombre" class="title">{{ __('Barrio') }}</label><br>
                                    {{$lugar->barrio->nombre}}  
                                </div>
                            </h5>
                            <hr>
                            @if(Auth::user()->role == 'ADMIN')
                            <a href="{{route('lugar.edit', [$lugar->id])}}" class="btn btn-success btn-lg title"><i class="fas fa-map-marker-alt"></i> Editar Lugar</a>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="google_canvas_view">
                                {!! Mapper::render() !!}
                            </div> 
                        </div>
                    </div>
                </div>
            </div>    
            <hr class="border-red">

            <div class="row">
                <div class="col-md-8">
                    <h3 class="title my-3">Tareas Realizadas</h3>
                </div>
                <div class="col-md-4 my-3"> 
                    <div class="form-group">
                        <a href="#" onclick="tarea()" data-toggle="modal" data-target="#tareaModal" class="btn btn-outline-dark title"  title="Asignar Tarea" ><img src="{{asset('images/trabajo1.png')}}" width="23" alt=""> Nueva Tarea</a>
                    </div>
                </div>
            </div>    

            <hr class="border-red">
            @if(count($lugar->tareas) > 0)
                <div class="table-responsive my-5 justify-content-center" id="resultado">
                    <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tarea</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = 1)
                            @foreach($lugar->tareas as $tarea)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$tarea->tarea}}</td>
                                <td>{{date('d/m/Y', strtotime($tarea->fechaInicio))}}</td>
                                <td>
                                    @if($tarea->fechaFin != NULL)
                                    {{date('d/m/Y', strtotime($tarea->fechaFin))}}
                                    @endif
                                </td>
                                <td>
                                    @if($tarea->estado == 'Activo')
                                    <h4><span class="badge badge-pill badge-primary">{{$tarea->estado}}</span></h4>
                                    @else
                                    <h4><span class="badge badge-pill badge-success">{{$tarea->estado}}</span></h4>
                                    @endif
                                </td>
                                <td>
                                <a href="#" onclick="editTarea({{$tarea->id}},'{{$tarea->tarea}}','{{$tarea->fechaInicio}}','{{$tarea->fechaFin}}','{{$tarea->estado}}')" data-toggle="modal" data-target="#tareaModal" class="btn btn-outline-success title"  title="Asignar Tarea" ><i class="fas fa-edit"></i></a>
                                </td>
                            </tr>
                            @php($i++)
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
            <div class="text-center my-5">
                <h4 class="text-danger my-5"><strong>NO SE REGISTRO NINGUN TAREA...</strong></h4>
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
                <input type="hidden" name="idTarea" id="idTarea">
                <input type="hidden" name="lugar_id" value="{{$lugar->id}}">
                <div class="form-group">
                    <label for="tarea" class="title">Tarea Asignada</label>
                    <select class="custom-select" id="tarea" name="tarea" required>
                        <option selected disabled value="">-- Elegir Tarea --</option>
                        <option value="Desmalezamiento">Desmalezamiento</option>
                        <option value="Descacharreo">Descacharreo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="fechaInicio" class="title">Fecha Inicio</label>
                    <input type="date" name="fechaInicio" id="fechaInicio" class="form-control">
                </div>
                <div class="form-group">
                    <label for="fechaFin" class="title">Fecha Finalizacion</label>
                    <input type="date" name="fechaFin" id="fechaFin" class="form-control">
                </div>
                <div class="form-group">
                    <label for="asis" class="title">Estado</label>
                    <select class="custom-select" id="estado" name="estado" required>
                        <option selected disabled value="">-- Elegir Opción --</option>
                        <option value="Activo">Activo</option>
                        <option value="Terminado">Terminado</option>
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
@endsection
@section('script')
    <script src="{{ asset('js/lugarTarea.js') }}"></script>
@endsection
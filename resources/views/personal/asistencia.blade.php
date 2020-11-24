@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center my-3">
            <h2 class="title display-3">Asistencia del Personal</h2> 
        </div>
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
            </div>                    
        </div> 
        <hr>
        <div class="card">
            <div class="card-header bg-rojo text-white title">
                <h3>Asistencia del Mes de {{$mes}}</h3>
            </div>
            <div class="card-body">
                <div class="col my-3"> 
                    <form class="form-inline">
                        <input type="hidden" id="personal_id" value="{{$auth->id}}">
                        <div class="form-group">
                            <input type="month" class="form-control" id="fecha" name="fecha">
                        </div>
                        <div class="form-group">
                            <a href="#" id="fechaTarea" class="mx-md-2 btn btn-primary btn-md-block"><strong><i class="fas fa-search"></i> Buscar Fecha</strong></a>
                        </div>
                    </form>
                </div>
                @if(count($asistencias)>0)
                <div class="table-responsive my-5 justify-content-center" id="resultado">
                        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Lugar de trabajo</th>
                                    <th>Tarea</th>
                                    <th>Asistencia</th>
                                    <th>Observación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($asistencias as $as)
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{date('d/m/Y', strtotime($as->fecha))}}</td>
                                    <td>{{$as->lugar->calle}} N° {{$as->lugar->numero}} - B° {{$as->lugar->barrio->nombre}} ({{$as->lugar->barrio->zona}})</td>
                                    <td>{{$as->tarea}}</td>
                                    <td>
                                        @if($dep->persona->tarea)
                                          @if($dep->persona->tarea->estado == 'Ausente')
                                          <h4><span class="badge badge-pill badge-danger">{{$dep->persona->tarea->estado}}</span></h4> 
                                          @else
                                          <h4><span class="badge badge-pill badge-primary">{{$dep->persona->tarea->estado}}</span></h4>
                                          @endif
                                        @endif
                                    </td>
                                    <td>{{$as->observacion}}</td>
                                </tr>
                                @php($i++)   
                                @endforeach   
                            </tbody>
                        </table>
                    </div>
                @else
                <h3 class="text-danger text-center">No tiene asistencia este mes...</h3>
                @endif
            </div>    
        </div>    
    </div>

@endsection
@section('script')
    <script src="{{ asset('js/consultas.js') }}"></script>
@endsection
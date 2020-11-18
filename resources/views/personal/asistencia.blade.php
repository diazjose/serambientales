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
                <h3>Datos del Personal a cargo</h3>
            </div>
            <div class="card-body">
                
                @if(count($asistencias)>0)
                <div class="table-responsive my-5 justify-content-center" id="resultado">
                        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Hora Entrada</th>
                                    <th>Hora Salida</th>
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
                                    <td>{{date('H:i', strtotime($as->horaEntrada))}}</td>
                                    <td>{{date('H:i', strtotime($as->horaSalida))}}</td>
                                    <td>{{$as->tarea}}</td>
                                    <td>{{$as->estado}}</td>
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
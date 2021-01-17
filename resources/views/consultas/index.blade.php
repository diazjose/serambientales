@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="card">
            <div class="card-header bg-rojo text-white title">
                <h3><i class="fas fa-search-location"></i> Realizar Busqueda</h3>
            </div>
            <div class="card-body bg-camel"> 
                <form class="form" method="GET" action="{{route('consulta.index')}}">     
                                  
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="buscar" class="title mx-1">Tarea</label>
                            <select name="search" id="buscar" class="form-control">
                                <option selected disabled value="">-- Elegir Opción --</option>                                @foreach($tareas as $t)
                                <option value="{{$t->id}}">{{$t->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="estado" class="title mx-1">Estado</label>
                            <select name="status" id="estado" class="form-control">
                                <option value="TODOS">TODOS</option>
                                <option value="Activo">ACTIVOS</option>
                                <option value="Terminado">TERMINADOS</option>
                            </select>
                        </div>
                    </div>
                    <button class="btn btn-rojo mb-2 title" id="btn-search">Buscar</button>
                </form>
            </div>                    
        </div>  
        
        <hr>
        <h3 class="title">{{$title}}</h3>
        <hr>
        <div class="google_canvas">
            {!! Mapper::render() !!}
        </div> 
        <br><hr>
        <div class="card">
            <div class="card-header bg-rojo text-white title"><h3>Resultados de la Búsqueda</h3></div>
            <div class="card-body"> 
                @if($consultas)
                <div class="table-responsive my-5 justify-content-center" id="resultado">
                    <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Tarea</th>
                                <th>Lugar</th>
                                <th>Zona</th>
                                <th>Fecha de Ini.</th>
                                <th>Fecha Fin</th>
                                <th>Estado</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($consultas as $d)
                            <tr>
                                <td>{{$d->tarea->nombre}}</td>
                                <td>{{$d->lugar->calle}} N° {{$d->lugar->calle}} B° {{$d->lugar->barrio->nombre}}</td>
                                <td>{{$d->lugar->barrio->zona}}</td>
                                <td>{{date('d/m/Y', strtotime($d->fechaInicio))}}</td>
                                <td>
                                    @if($d->fechaFin!=NULL)
                                    {{date('d/m/Y', strtotime($d->fechaFin))}}
                                    @else
                                    ---
                                    @endif
                                </td>
                                <td>
                                    @if($d->estado == 'Activo')
                                    <h4>
                                        <span class="badge badge-pill badge-success">
                                            {{$d->estado}}
                                        </span>
                                    </h4>
                                    @else
                                    <h4>
                                        <span class="badge badge-pill badge-info">
                                            {{$d->estado}} 
                                            <i class="far fa-check-circle"></i>
                                        </span>
                                    </h4>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('lugar.view', [$d->lugar_id])}}" class="btn btn-outline-primary" title="Ver Personal" ><i class="far fa-eye"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Tarea</th>
                                <th>Lugar</th>
                                <th>Zona</th>
                                <th>Fecha de Ini.</th>
                                <th>Fecha Fin</th>
                                <th>Estado</th>
                                <th>Ver</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center my-5">
                    <h4 class="text-danger my-5"><strong>NO EXISTE NINGUNA TAREA...</strong></h4>
                </div>    
                @endif
            </div>    
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/consultas.js') }}"></script>
<script src="{{ asset('js/search.js') }}"></script>
@endsection
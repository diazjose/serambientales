@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="text-center my-3">
            <h2 class="title display-3">Administrar Denuncias</h2>
        </div>
        <br>
        <div class="google_canvas">
            {!! Mapper::render() !!}
        </div> 
        <br><hr>
        <div class="card">
            <div class="card-header bg-rojo text-white title"><h3>Listado de Denuncias Pendientes</h3></div>
            <div class="card-body"> 
                @if(count($denuncias)>0)
                <div class="table-responsive my-5 justify-content-center" id="resultado">
                    <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Denunciante</th>
                                <th>Denuncia</th>
                                <th>Lugar</th>
                                <th>Zona</th>
                                <th>Estado</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($denuncias as $d)
                            <tr>
                                <td>{{date('d/m/Y', strtotime($d->fecha))}}</td>
                                <td>{{$d->denunciante}}</td>
                                <td>{{$d->denuncia}}</td>
                                <td>{{$d->lugar->calle}} N° {{$d->lugar->calle}} B° {{$d->lugar->barrio->nombre}}</td>
                                <td>{{$d->lugar->barrio->zona}}</td>
                                <td>
                                    @if($d->estado == 'Atender')
                                    <h4>
                                        <span class="badge badge-pill badge-danger">
                                            {{$d->estado}}
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span>
                                    </h4>
                                    @else
                                    <h4>
                                        <span class="badge badge-pill badge-success">
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
                                <th>Fecha</th>
                                <th>Denunciante</th>
                                <th>Denuncia</th>
                                <th>Lugar</th>
                                <th>Zona</th>
                                <th>Estado</th>
                                <th>Ver</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center my-5">
                    <h4 class="text-danger my-5"><strong>NO EXISTE NINGUNA DENUNCIA POR ATENDER...</strong></h4>
                </div>    
                @endif
            </div>    
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('js/consultas.js') }}"></script>
@endsection
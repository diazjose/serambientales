@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="text-center my-3">
            <h2 class="title display-3">Administrar Insumos</h2>
        </div><hr>
        <div class="card">
          <div class="card-header bg-rojo text-white title">
            <h3>Agregar Insumo</h3>
          </div>
          <div class="card-body bg-camel">
            <form class="form" method="POST" action="{{route('insumo.create')}}">
              @csrf
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="nombre" class="title">Insumo</label>
                  <input type="text" value="{{ old('nombre') }}" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" required>
                  @error('nombre')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
                <div class="form-group col-md-6">
                  <label for="cantidad" class="title">Cantidad</label>
                  <input type="number" value="{{ old('cantidad') }}" class="form-control" id="cantidad" name="cantidad" required>
                </div>
              </div>
              <button type="submit" class="btn btn-rojo mb-2 title">Agregar Insumo</button>
            </form>
          </div>
        </div>          
        <hr><br>
        @if(session('message'))
        <div class="alert alert-{{ session('status') }}">
            <strong>{{ session('message') }}</strong>   
        </div>  
        @endif 
        <div class="card">
            <div class="card-header bg-rojo text-white title"><h3>Listado de Insumos</h3></div>
            <div class="card-body"> 
                @if(count($insumos)>0)
                <div class="table-responsive my-5 justify-content-center" id="resultado">
                    <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Insumo</th>
                                <th>Cantidad en Existencia</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @foreach($insumos as $he)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$he->nombre}}</td>
                                <td>{{$he->cantidad}}</td>                                
                                <td>
                                    <a href="#" onclick="editInsumo({{$he->id}},'{{$he->nombre}}','{{$he->cantidad}}')" class="btn btn-outline-success" data-toggle="modal" data-target="#insumoModal" title="Editar Insumo" ><i class="fas fa-edit"></i></a>
                                    <a href="{{route('insumo.view',$he->id)}}" class="btn btn-outline-info" title="Ver Insumo" ><i class="far fa-eye"></i></a>
                                </td>
                            </tr>
                            @php($i++)
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Herramienta</th>
                                <th>Cantidad en Existencia</th>
                                <th>Acciones</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center my-5">
                    <h4 class="text-danger my-5"><strong>NO SE REGISTRO NINGUN INSUMO...</strong></h4>
                </div>    
                @endif
            </div>    
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="insumoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-rojo text-white">
        <h4 class="modal-title title" id="exampleModalCenterTitle"><strong id="Title">Actualizar Insumo</strong></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-camel">
            <form method="POST" action="{{route('insumo.update')}}" >
                @csrf
                <input type="hidden" name="id" id="insumo_id" value="">
                <div class="form-group">
                    <label for="enombre" class="title"><h5>{{ __('Nombre') }}</h5></label>
                    <input type="text" name="nombre" id="enombre" style="text-transform:uppercase;" class="form-control">
                </div>

                <div class="form-group">
                    <label for="ecantidad" class="title"><h5>{{ __('Cantidad') }}</h5></label>
                    <input type="number" name="cantidad" id="ecantidad" class="form-control">
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
        <h4 class="modal-title" id="myModalLabel">¿Desea eliminar el este Insumo?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form method="POST" action="{{route('insumo.prestarDelete')}}">
          @csrf
          <input type="hidden" name="id" id="id_insumo" value="">
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
    <script src="{{ asset('js/insumos.js') }}"></script>
@endsection
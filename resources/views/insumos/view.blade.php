@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
        <div class="text-center my-3">
            <h2 class="title display-3">Ficha de Insumo</h2> 
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
                    <h3>Datos</h3>
                </div>
                <div class="card-body bg-camel"> 
                    <h5 class="mx-3"> 
                        <div class="row my-2">   
                            <div class="form-group col-md-5">
                                <label class="title">{{ __('Insumo') }}</label><br>
                                {{$insumo->nombre}}      
                            </div>
                            <div class="form-group col-md-4">
                                <label class="title">{{ __('Cantidad en Existencia') }}</label><br>
                                {{$insumo->cantidad}}
                            </div>                            
                        </div>                            
                    </h5>
                </div>                    
            </div>             
        </div>
        <hr>
        <div class="card">
          <div class="card-header bg-rojo text-white title">
            <h3>Entregar Insumo</h3>
          </div>
          <div class="card-body bg-camel">
            <div class="row mx-1">
                <div class="form-group col-md-3">
                    <input type="text" id="dni" class="form-control" placeholder="Buscar personal por DNI..." size="10"  maxlength="8" pattern="[0-9]{8}" title="Debe poner DNI números">
                    <div class="alert-danger my-2" style="display: none;" id="mess">
                        <strong class="mx-3"> DNI no valido</strong>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-light border border-dark title" id="bus_per" disabled><i class="fas fa-search"></i> Buscar</button>
                </div>
                <div style="display: none">
                    <form action="" method="POST" id="form-search">
                        @csrf
                        <input type="text" name="buscar" value="" id="form_buscar" />                        
                    </form>
                </div>
            </div><br>
            <form class="form" method="POST" action="{{route('insumo.prestar')}}">
              @csrf
              <div class="row">
                <div class="form-group col-md-6">
                  <label for="nombre" class="title">Personal</label>
                  <input type="hidden" name="id_persona" id="id_persona">
                  <input type="hidden" name="id_insumo" value="{{$insumo->id}}">
                  <input type="text" class="form-control" id="name" name="nombre" required disabled>
                </div>
                <div class="form-group col-md-6">
                  <label for="cantidad" class="title">Cantidad</label>
                  <input type="number" class="form-control" id="cantidad" name="cantidad" required>                  
                </div>
              </div>
              <button type="submit" class="btn btn-rojo mb-2 title" id="btn" disabled>Entregar</button>
            </form>
          </div>
        </div>  
        <hr>
        <div class="mx-2">
            <div class="card">
                <div class="card-header bg-rojo text-white title">
                    <h3>Entregas de Insumo</h3>
                </div>
                <div class="card-body bg-camel"> 
                    @if($insumo->entregados)
                    <div class="table-responsive my-5 justify-content-center" id="resultado">
                        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Personal</th>
                                    <th>Cantidad</th>
                                    <th>Fecha de Entrega</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($insumo->entregados as $he)
                                <tr>
                                    <td>{{$he->personal->apellidos}}, {{$he->personal->nombre}}</td>
                                    <td>{{$he->cantidad}}</td>
                                    <td>{{date('d/m/Y', strtotime($he->fecha))}}</td>                                    
                                    <td>
                                        <a href="#" onclick="editEntrega({{$he->id}},'{{$he->personal->nombre}}','{{$he->personal->apellidos}}','{{$he->cantidad}}','{{$he->fecha}}')" class="btn btn-outline-success" data-toggle="modal" data-target="#insumoModal" title="Editar Entrega" ><i class="fas fa-edit"></i></a>
                                        <a href="#" onclick="deletePrestar({{$he->id}})" class="btn btn-outline-danger" title="Eliminar Entrega" data-toggle="modal" data-target="#confirm"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @php($i++)
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Personal</th>
                                    <th>Cantidad</th>
                                    <th>Fecha de Entrega</th>
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    @else
                    <h4 class="text-danger">No se registro ninguna entrega de Insumo ...</h4>
                    @endif
                </div>                    
            </div>             
        </div>
        
    </div>    
</div>

<!-- Modal -->
<div class="modal fade" id="insumoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-rojo text-white">
        <h4 class="modal-title title" id="exampleModalCenterTitle"><strong id="Title">Actualizar Asignación</strong></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body bg-camel">
            <form method="POST" action="{{route('insumo.prestarEdit')}}" >
                @csrf
                <input type="hidden" name="id" id="intregarInsumo_id" value="">
                <input type="hidden" name="id_insumo" value="{{$insumo->id}}">
                <div class="form-group">
                    <label for="epersona" class="title"><h5>{{ __('Se le presto a:') }}</h5></label>
                    <input type="text" name="persona" id="epersona" class="form-control" disabled>                    
                </div>
                
                <div class="form-group">
                    <label for="ecantidad" class="title"><h5>{{ __('Cantidad') }}</h5></label>
                    <input type="number" name="cantidad" id="ecantidad" class="form-control">
                </div>    
                <div class="form-group">
                    <label for="edevolucion" class="title"><h5>{{ __('Fecha') }}</h5></label>
                    <input type="date" name="fecha" id="edevolucion" class="form-control">
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
        <h4 class="modal-title" id="myModalLabel">¿Desea eliminar este Registro?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <form method="POST" action="{{route('insumo.prestarDelete')}}">
          @csrf
          <input type="hidden" name="id" id="id_prestar" value="">
          <input type="hidden" name="insumo" value="{{$insumo->id}}">
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
    <script src="{{ asset('js/insumos.js') }}"></script>
    <script src="{{ asset('js/table.js') }}"></script>
@endsection
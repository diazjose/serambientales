@csrf
                        <h4 class="title">Datos Personales</h4><hr>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="nombre" class="title">{{ __('Nombre') }}</label>
                                <input id="nombre" type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" value="@if(isset($persona)){{$persona->nombre}}@endif" required autocomplete="nombre" style="text-transform:uppercase;" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="apellidos" class="title">{{ __('Apellidos') }}</label>
                                <input id="paellidos" type="text" class="form-control @error('apellidos') is-invalid @enderror" name="apellidos" value="@if(isset($persona)){{$persona->apellidos}}@endif" required autocomplete="apellidos" style="text-transform:uppercase;" autofocus>
                                @error('apellidos')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label for="dni" class="title">{{ __('N° Documento') }}</label>
                                <input id="dni" type="text" class="form-control @error('dni') is-invalid @enderror" name="dni" value="@if(isset($persona)){{$persona->dni}}@endif" size="10" maxlength="8" pattern="[0-9]{8}" required autocomplete="dni">
                                <div class="alert-danger my-2" style="display: none;" id="mess">
                                    <strong class="mx-3">* DNI no valido</strong>
                                </div>
                                @error('dni')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label for="fechaNac" class="title">{{ __('Fecha de Nac.') }}</label>
                                <input id="fechaNac" type="date" class="form-control @error('fechaNac') is-invalid @enderror" name="fechaNac" value="@if(isset($persona)){{$persona->fechaNac}}@endif" autocomplete="fechaNac">
                                @error('fechaNac')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="email" class="title">{{ __('Correo Electrónico') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="@if(isset($persona)){{$persona->email}}@endif" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label for="telefono" class="title">{{ __('Teléfono') }}</label>
                                <input id="telefono" type="text" class="form-control @error('telefono') is-invalid @enderror" name="telefono" value="@if(isset($persona)){{$persona->telefono}}@endif"  autocomplete="telefono">
                                @error('telefono')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                 </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="direccion" class="title">{{ __('Domicilio') }}</label>
                                <input id="direccion" type="text" class="form-control @error('direccion') is-invalid @enderror" name="direccion" value="@if(isset($persona)){{$persona->direccion}}@endif" required autocomplete="direccion" style="text-transform:uppercase;">
                                @error('direccion')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>                            
                        </div>
                        <hr><h4 class="title">Datos Laborales</h4><hr>
                        <div class="row">                             
                            <div class="form-group col-md-3">
                                <label for="cargo" class="title">{{ __('Cargo') }}</label>
                                <select name="cargo" class="form-control" id="cargo" required> 
                                    <option selected disabled>--Elegir Opción--</option>
                                    <option value="JEFE DE CUADRILLA">JEFE DE CUADRILLA</option>
                                    <option value="PERSONAL VOLUNTARIO">PERSONAL VOLUNTARIO</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="enlazar" id="enlazar" class="title">{{ __('Enlazar a') }}</label>
                                <select id="enlazar" name="enlazar" class="form-control">
                                    <option value="NADIE">NADIE</option>
                                    @foreach($auth as $per)
                                    <option value="{{$per->id}}">{{$per->apellidos}} {{$per->nombre}} ({{$per->cargo}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
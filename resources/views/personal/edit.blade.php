@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card border-red">
                <div class="card-header text-white title bg-rojo"><h3>{{ __('Actualizar Personal') }}</h3></div>

                <div class="card-body bg-camel">
                    <input type="hidden" id="zo" value="{{$persona->zona}}">
                    <input type="hidden" id="situacion" value="{{$persona->situacionLaboral}}">
                    <input type="hidden" id="car" value="{{$persona->cargo}}">
                    @if(!empty($persona->depende))
                        @foreach($persona->depende as $de)
                            @if($de->persona_id == $persona->id)
                            <input type="hidden" id="depende" value="{{$de->coordinador_id}}">    
                            @endif    
                        @endforeach
                    @endif

                    <form method="POST" action="{{ route('personal.update') }}">
                        @include('personal.formPersonal')
                        <input type="hidden" name="id" value="{{$persona->id}}">
                        <hr class="border-red">        
                        <div class="form-group">
                            <div class="row justify-content-end">
                                <button type="submit" class="btn btn-success btn-lg title mx-5">
                                    {{ __('Actualiar Personal') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript" src="{{asset('js/personalEdit.js')}}"></script>
@endsection
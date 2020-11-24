<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barrio;
use App\Lugar;
use Mapper;

class LugaresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
    	$barrios = Barrio::all();
    	$lugares = Lugar::all();
    	return view('lugares.index',['barrios' => $barrios, 'lugares' => $lugares]);
    }

    public function register(){
    	$barrios = Barrio::all();
    	return view('lugares.create',['barrios' => $barrios]);
    }

    public function create(Request $request){
    	$validate = $this->validate($request, [
                'calle' => ['required', 'string', 'max:255'],
	            'numero' => ['required', 'integer'],
                'barrio' => ['required', 'integer'],
	            'latitud' => ['required', 'string', 'max:255'],
	            'longitud' => ['required', 'string', 'max:255'],
            ]);

    	$lugar = new Lugar();
    	$lugar->calle = strtoupper($request->input('calle'));
    	$lugar->numero = $request->input('numero');
    	$lugar->barrio_id = $request->input('barrio');
    	$lugar->latitud = $request->input('latitud');
    	$lugar->longitud = $request->input('longitud');
    	$lugar->save();

    	return redirect()->route('lugares.index')
                         ->with(['message' => 'Un Nuevo Lugar fue cargado...', 'status' => 'success']);
   
    }

    public function edit($id){
        $barrios = Barrio::all();
        $lugar = Lugar::find($id);
        return view('lugares.edit',['lugar'=> $lugar,'barrios' => $barrios]);
    }

    public function update(Request $request){
        $validate = $this->validate($request, [
                'calle' => ['required', 'string', 'max:255'],
                'numero' => ['required', 'integer'],
                'barrio' => ['required', 'integer'],
                'latitud' => ['required', 'string', 'max:255'],
                'longitud' => ['required', 'string', 'max:255'],
            ]);
        $id = $request->input('lugar');
        $lugar = Lugar::find($id);
        $lugar->calle = strtoupper($request->input('calle'));
        $lugar->numero = $request->input('numero');
        $lugar->barrio_id = $request->input('barrio');
        $lugar->latitud = $request->input('latitud');
        $lugar->longitud = $request->input('longitud');
        $lugar->update();

        return redirect()->route('lugar.view', [$lugar->id])
                         ->with(['message' => 'Lugar actualizado con exito...', 'status' => 'success']);
   
    }

    public function view($id){
        $lugar = Lugar::find($id);
        Mapper::map($lugar->latitud, $lugar->longitud, ['zoom' => 15, 'markers' => ['title' => $lugar->calle.' N° '.$lugar->numero.' B° '.$lugar->barrio->nombre, 'animation' => 'DROP']]);
        return view('lugares.view',['lugar'=> $lugar, 'fecha' => date('Y-m-d'), 'personas' => []]);
    }
}

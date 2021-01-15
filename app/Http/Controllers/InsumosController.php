<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Insumo;
use App\Persona;

class InsumosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$insumos = Insumo::all();
    	return view('insumos.index',['insumos' => $insumos]);
    }

    public function create(Request $request){
        $he = new Insumo;
        
    	$validate = $this->validate($request, [
                'nombre' => ['required', 'string', 'max:255', 'unique:insumos'],
	            'cantidad' => ['required', 'integer', 'max:255'],
            ],
            [
            	'nombre.unique' => 'El Insumo ya existe en la Base de Datos',
            ]);
            
        $he->nombre = strtoupper($request->input('nombre'));
    	$he->cantidad = $request->input('cantidad');
		$he->save();     
        
        return redirect()->route('insumo.index')
                         ->with(['message' => 'Insumos cargado correctamente', 'status' => 'success']);

    }

    public function update(Request $request){

        $id = $request->input('id');
        $validate = $this->validate($request, [
            'nombre' => ['required', 'string', 'max:255', 'unique:insumos,nombre,'.$id],
            'cantidad' => ['required', 'integer', 'max:255'],
        ],
        [
            'nombre.unique' => 'El Insumo ya existe en la Base de Datos',
        ]);

        $he = Insumo::find($id);
        $he->nombre = strtoupper($request->input('nombre'));
    	$he->cantidad = $request->input('cantidad');
		$he->update();     
        
        return redirect()->route('insumo.index')
                         ->with(['message' => 'Insumo actualizado correctamente', 'status' => 'success']);

    }

    public function view($id){
        $insumo = Insumo::find($id);
        $personas = Persona::all();
        return view('insumos.view',['insumo' => $insumo]);
    }
}

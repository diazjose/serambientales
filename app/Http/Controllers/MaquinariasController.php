<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Maquinaria;
use App\AsignarMaquinaria;

class MaquinariasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$maquinas = Maquinaria::all();
    	return view('maquinarias.index',['maquinarias' => $maquinas]);
    }

    public function create(Request $request){
        $he = new Maquinaria;
        
    	$validate = $this->validate($request, [
                'nombre' => ['required', 'string', 'max:255'],
	            'dominio' => ['required', 'string', 'max:255', 'unique:maquinarias'],
            ],
            [
            	'dominio.unique' => 'El dominio ya existe en la Base de Datos',
            ]);
            
        $he->nombre = strtoupper($request->input('nombre'));
        $he->dominio = $request->input('dominio');
        $he->estado = 'Libre';
		$he->save();     
        
        return redirect()->route('maquinaria.index')
                         ->with(['message' => 'Maquinaria cargado correctamente', 'status' => 'success']);

    }

    public function update(Request $request){

        $id = $request->input('id');
        
        $validate = $this->validate($request, [
            'nombre' => ['required', 'string', 'max:255'],
            'dominio' => ['required', 'string', 'max:255', 'unique:maquinarias,dominio,'.$id],
        ],
        [
            'dominio.unique' => 'El dominio ya existe en la Base de Datos',
        ]);

        $he = Maquinaria::find($id);
        $he->nombre = strtoupper($request->input('nombre'));
    	$he->dominio = $request->input('dominio');
		$he->update();     
        
        return redirect()->route('maquinaria.index')
                         ->with(['message' => 'Maquinaria actualizado correctamente', 'status' => 'success']);

    }

    public function view($id){
        $maquina = Maquinaria::find($id);
        return view('maquinarias.view',['maquinaria' => $maquina]);
    }
}

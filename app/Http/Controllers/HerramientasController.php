<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Herramienta;
use App\Persona;

class HerramientasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$herramientas = Herramienta::all();

    	return view('herramientas.index',['herramientas' => $herramientas]);
    }
/*
    public function register(Request $request){
        $aut = Persona::where('cargo', '!=', 'PERSONAL VOLUNTARIO')->orderBy('apellidos','asc')->get();
        return view('personal.registrar', ['auth' => $aut]);
    }
*/
    public function create(Request $request){
        $he = new Herramienta;

    	$validate = $this->validate($request, [
                'nombre' => ['required', 'string', 'max:255', 'unique:herramientas'],
	            'cantidad' => ['required', 'integer', 'max:255'],
            ],
            [
            	'nombre.unique' => 'Esta Herramienta ya existe en la Base de Datos',
            ]);

        $he->nombre = strtoupper($request->input('nombre'));
    	$he->cantidad = $request->input('cantidad');
		$he->save();     
        
        return redirect()->route('herramienta.index')
                         ->with(['message' => 'Herramienta cargada correctamente', 'status' => 'success']);

    }

    public function update(Request $request){

        $id = $request->input('id');
        $validate = $this->validate($request, [
            'nombre' => ['required', 'string', 'max:255', 'unique:herramientas,nombre,'.$id],
            'cantidad' => ['required', 'integer', 'max:255'],
        ],
        [
            'nombre.unique' => 'Esta Herramienta ya existe en la Base de Datos',
        ]);

        $he = Herramienta::find($id);
        $he->nombre = strtoupper($request->input('nombre'));
    	$he->cantidad = $request->input('cantidad');
		$he->update();     
        
        return redirect()->route('herramienta.index')
                         ->with(['message' => 'Herramienta actualizada correctamente', 'status' => 'success']);

    }

    public function view($id){
        $herramienta = Herramienta::find($id);
        $personas = Persona::all();
        return view('herramientas.view',['herramienta' => $herramienta, 'personas' => $personas]);
    }
}

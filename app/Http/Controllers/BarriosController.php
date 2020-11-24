<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barrio;
class BarriosController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
	}
	
    public function index(){
    	$barrios = Barrio::all();
    	return view('barrios.index',['barrios' => $barrios]);
    }

    public function create(Request $request){
    	$validate = $this->validate($request, [
                'nombre' => ['required', 'string', 'max:255', 'unique:barrios'],
	            'zona' => ['required', 'string', 'max:255'],
            ],
            [
            	'nombre.unique' => 'Este Barrio ya existe en la Base de Datos',
            ]);

    	$barrio = new Barrio();
    	$barrio->nombre = strtoupper($request->input('nombre'));
    	$barrio->zona = $request->input('zona');
    	$barrio->save();

    	return redirect()->route('barrios.index')
                         ->with(['message' => 'El Barrio "'.$barrio->nombre.'" fue cargado correctamente!!', 'status' => 'success']);
    }

    public function update(Request $request){

    	$id = $request->input('id');
    	$validate = $this->validate($request, [
                'nombre' => ['required', 'string', 'max:255', 'unique:barrios,nombre,'.$id],
	            'zona' => ['required', 'string', 'max:255'],
            ],
            [
            	'nombre.unique' => 'Este Barrio ya existe en la Base de Datos',
            ]);

    	$barrio = Barrio::find($id);
    	$barrio->nombre = strtoupper($request->input('nombre'));
    	$barrio->zona = $request->input('zona');
    	$barrio->update();

    	return redirect()->route('barrios.index')
                         ->with(['message' => 'El Barrio "'.$barrio->nombre.'" fue actualizado correctamente...', 'status' => 'success']);
    }

    public function destroy(Request $request){
    	$id = $request->input('id');
    	$name = $request->input('name');
    	$barrio = Barrio::find($id);
    	$barrio->delete();

    	return redirect()->route('barrios.index')
                         ->with(['message' => 'El Barrio "'.$name.'" fue eliminado correctamente', 'status' => 'danger']);
    }
}

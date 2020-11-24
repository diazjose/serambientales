<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trabajo;

class TrabajosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function create(Request $request){
    	$tarea = new Trabajo;
        $validate = $this->validate($request, [
                'persona_id' => ['required', 'integer', 'max:255'],
	            'lugar' => ['required', 'integer', 'max:255'],
	            'tarea' => ['required', 'string', 'max:100'],
            ]);

        $tarea->persona_id = $request->input('persona_id');
    	$tarea->lugar_id = $request->input('lugar');
		$tarea->fecha = date('Y-m-d');
        $tarea->tarea = $request->input('tarea');
        $tarea->estado = 'Ausente';
    	
		$tarea->save();
        $id = $request->input('id');
        return redirect()->route('personal.viewAuth', [$id])
                         ->with(['message' => 'Se asigno tarea a '.$tarea->persona->apellidos.' '.$tarea->persona->nombre.' correctamente', 'status' => 'success']);

    }

    public function update(Request $request){
        
        $validate = $this->validate($request, [
                'persona_id' => ['required', 'integer', 'max:255'],
	            'lugar' => ['required', 'integer', 'max:255'],
	            'tarea' => ['required', 'string', 'max:100'],
            ]);
        
        $tarea = Trabajo::find($request->input('idTarea'));
        $idTarea = $request->input('persona_id');
    	$tarea->lugar_id = $request->input('lugar');
		$tarea->tarea = $request->input('tarea');
        
		$tarea->update();
        $id = $request->input('id');
        return redirect()->route('personal.viewAuth', [$id])
                         ->with(['message' => 'Se actualizo la tarea a '.$tarea->persona->apellido.' '.$tarea->persona->nombre, 'status' => 'success']);

    }

    public function destroy(Request $request){
        
        $u = $request->input('id');
        $id = $request->input('idTarea');
        $name = $request->input('name');
        $trabajo = Trabajo::find($id);
        $trabajo->delete();

        return redirect()->route('personal.viewAuth', [$u])
                         ->with(['message' => 'Se ha eliminado la tarea  de '.$name, 'status' => 'danger']);

    }

    public function assistance(Request $request){
        
        $u = $request->input('id');
        $id = $request->input('idTarea');
        $name = $request->input('name');
        $trabajo = Trabajo::find($id);
        $trabajo->estado = $request->input('estado');
        $trabajo->observacion = $request->input('observacion');
        $trabajo->update();

        return redirect()->route('personal.viewAuth', [$u])
                         ->with(['message' => 'Se actualizo el estado de tarea de '.$name, 'status' => 'success']);

    }
}

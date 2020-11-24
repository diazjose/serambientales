<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DesignarLugar;

class DesignarLugarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){
        $desLug = new DesignarLugar;
        
    	$validate = $this->validate($request, [
                'lugar_id' => ['required', 'string', 'max:255'],
	            'fechaInicio' => ['required', 'date'],
	            'tarea' => ['required', 'string', 'max:255'],
            ]);

        $desLug->lugar_id = $request->input('lugar_id');
        $desLug->fechaInicio = $request->input('fechaInicio');
        if (!empty($request->input('fechaFin'))) {
            $desLug->fechaFin = $request->input('fechaFin');
        }       
        $desLug->tarea = $request->input('tarea');
        $desLug->estado = $request->input('estado');
		$desLug->save();
        
        return redirect()->route('lugar.view', [$desLug->lugar_id])
                         ->with(['message' => 'Se ha designado una nueva tarea a este lugar!!', 'status' => 'success']);

    }

    public function update(Request $request){
        
        
    	$validate = $this->validate($request, [
                'lugar_id' => ['required', 'string', 'max:255'],
	            'fechaInicio' => ['required', 'date'],
	            'tarea' => ['required', 'string', 'max:255'],
            ]);
        $desLug = DesignarLugar::find($request->input('idTarea'));
        $desLug->fechaInicio = $request->input('fechaInicio');
        if (!empty($request->input('fechaFin'))) {
            $desLug->fechaFin = $request->input('fechaFin');
        }       
        $desLug->tarea = $request->input('tarea');
        $desLug->estado = $request->input('estado');
		$desLug->update();
        
        return redirect()->route('lugar.view', [$desLug->lugar_id])
                         ->with(['message' => 'Se ha actualizado la designado de una tarea de este lugar!!', 'status' => 'success']);

    }
}

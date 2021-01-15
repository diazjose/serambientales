<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Maquinaria;
use App\AsignarMaquinaria;

class AsignarMaquinariasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){
        $he = new AsignarMaquinaria;
        $validate = $this->validate($request, [
                'id_persona' => ['required', 'integer', 'max:255'],
                'id_maquinaria' => ['required', 'integer', 'max:255'],
	        ]);
        $maq = Maquinaria::find($request->input('id_maquinaria'));
        $maq->estado = 'Ocupada';
        $maq->update(); 
        $he->persona_id = $request->input('id_persona');
        $he->maquinaria_id = $request->input('id_maquinaria');
        $he->fechaEntrega = date('Y-m-d');
		$he->save();     
        
        return redirect()->route('maquinaria.view',[$he->maquinaria_id])
                         ->with(['message' => '¡¡Se registro el prestamo con exito!!', 'status' => 'success']);

    }

    public function update(Request $request){
        
        $id = $request->input('id');

    	$validate = $this->validate($request, [
                'id_maquinaria' => ['required', 'integer', 'max:255'],
            ]);
            
        $maq = Maquinaria::find($request->input('id_maquinaria'));
        $maq->estado = 'Libre';
        $maq->update();
        $he = AsignarMaquinaria::find($id);
        $he->fechaDevolucion = $request->input('devolucion');
        if (!empty($request->input('observacion'))) {
            $he->observacion = strtoupper($request->input('observacion'));
        }
        
		$he->update();     
        
        return redirect()->route('maquinaria.view',[$he->maquinaria_id])
                         ->with(['message' => '¡¡Se Actualizo el Registro con exito!!', 'status' => 'success']);

    }

    public function destroy(Request $request){
        $id = $request->input('id');
        
        $id_maquinaria = $request->input('maquinaria');
        $prestamo = AsignarMaquinaria::find($id);
        $maq = Maquinaria::find($prestamo->maquinaria_id);
        $maq->estado = 'Libre';
        $maq->update();
    	$prestamo->delete();

    	return redirect()->route('maquinaria.view',[$id_maquinaria])
                         ->with(['message' => '¡¡El Registro fue eliminado con exito!!', 'status' => 'success']);
    }
}

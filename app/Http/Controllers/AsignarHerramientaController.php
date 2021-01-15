<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Herramienta;
use App\AsignarHerramienta;

class AsignarHerramientaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){
        $he = new AsignarHerramienta;

    	$validate = $this->validate($request, [
                'id_persona' => ['required', 'integer', 'max:255'],
                'id_herramienta' => ['required', 'integer', 'max:255'],
	            'cantidad' => ['required', 'integer', 'max:255'],
            ]);

        $he->persona_id = $request->input('id_persona');
        $he->herramienta_id = $request->input('id_herramienta');
        $he->cantidad = $request->input('cantidad');
        $he->fechaEntrega = date('Y-m-d');
		$he->save();     
        
        return redirect()->route('herramienta.view',[$he->herramienta_id])
                         ->with(['message' => '¡¡Se prestaron herramientas con exito!!', 'status' => 'success']);

    }

    public function update(Request $request){
        
        $id = $request->input('id');

    	$validate = $this->validate($request, [
                'id_herramienta' => ['required', 'integer', 'max:255'],
	            'cantidad' => ['required', 'integer', 'max:255'],
            ]);
        
        $he = AsignarHerramienta::find($id);
        $he->herramienta_id = $request->input('id_herramienta');
        $he->cantidad = $request->input('cantidad');
        $he->fechaDevolucion = $request->input('devolucion');
        if (!empty($request->input('observacion'))) {
            $he->observacion = strtoupper($request->input('observacion'));
        }
        
		$he->update();     
        
        return redirect()->route('herramienta.view',[$he->herramienta_id])
                         ->with(['message' => '¡¡Se Actualizo el Registro con exito!!', 'status' => 'success']);

    }

    public function destroy(Request $request){
        $id = $request->input('id');
        $id_herramienta = $request->input('herramienta');
    	$prestamo = AsignarHerramienta::find($id);
    	$prestamo->delete();

    	return redirect()->route('herramienta.view',[$id_herramienta])
                         ->with(['message' => '¡¡El Registro fue eliminado con exito!!', 'status' => 'success']);
    }
}

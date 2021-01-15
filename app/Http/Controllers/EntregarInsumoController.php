<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EntregarInsumo;
use App\Insumo;


class EntregarInsumoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request){
        $he = new EntregarInsumo;

    	$validate = $this->validate($request, [
                'id_persona' => ['required', 'integer', 'max:255'],
                'id_insumo' => ['required', 'integer', 'max:255'],
	            'cantidad' => ['required', 'integer', 'max:255'],
            ]);
        
        $he->persona_id = $request->input('id_persona');
        $he->insumo_id = $request->input('id_insumo');
        $he->cantidad = $request->input('cantidad');
        $he->fecha = date('Y-m-d');
		$he->save();     
        $insumo = Insumo::find($request->input('id_insumo'));
        $cantidad = $insumo->cantidad - $he->cantidad;
        $insumo->cantidad = $cantidad;
        $insumo->update();

        return redirect()->route('insumo.view',[$he->insumo_id])
                         ->with(['message' => '¡¡Se entregaron Insumo con exito!!', 'status' => 'success']);

    }

    public function update(Request $request){
        
        $id = $request->input('id');
        $validate = $this->validate($request, [
                'id_insumo' => ['required', 'integer', 'max:255'],
	            'cantidad' => ['required', 'integer', 'max:255'],
            ]);
        
        $he = EntregarInsumo::find($id);
        $insumo = Insumo::find($request->input('id_insumo'));
        $i = $request->input('cantidad');
        
        if($he->cantidad < $i){
            $cant =  $request->input('cantidad') - $he->cantidad;
            $cantidad = $insumo->cantidad - $cant;
        }else{
            $cant = $he->cantidad - $request->input('cantidad');
            $cantidad = $insumo->cantidad + $cant;
        }
        $he->insumo_id = $request->input('id_insumo');
        $he->cantidad = $request->input('cantidad');
        $he->fecha = $request->input('fecha');
        
		$he->update();     
        
        
        $insumo->cantidad = $cantidad;
        $insumo->update();

        return redirect()->route('insumo.view',[$he->insumo_id])
                         ->with(['message' => '¡¡Se Actualizo el Registro con exito!!', 'status' => 'success']);

    }

    public function destroy(Request $request){
        $id = $request->input('id');        
        $prestamo = EntregarInsumo::find($id);
        $insumo = Insumo::find($prestamo->insumo_id);
        $cantidad = $insumo->cantidad + $prestamo->cantidad;
        $insumo->cantidad = $cantidad;
        $insumo->update();
    	$prestamo->delete();

    	return redirect()->route('insumo.view',[$insumo->id])
                         ->with(['message' => '¡¡El Registro fue eliminado con exito!!', 'status' => 'success']);
    }
}

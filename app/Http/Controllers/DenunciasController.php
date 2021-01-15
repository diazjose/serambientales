<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Denuncia;
use App\Barrio;
use Mapper;

class DenunciasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$denuncias = Denuncia::where('estado','Atender')->get();
        Mapper::map(-29.432468, -66.864249, ['zoom' => 13, 'markers' => ['title' => 'Base Operativa', 'animation' => 'DROP']]);
        //Recorremos los registros para generar las marcas
        foreach ($denuncias as $d) {
            if ($d->lugar->latitud != null) {
                Mapper::marker($d->lugar->latitud, $d->lugar->longitud,['title' => $d->lugar->calle." N° ".$d->lugar->numero." B° ".$d->lugar->barrio->nombre]);
            }
        }
        return view('denuncias.index',['denuncias' => $denuncias]);
    }

    public function register(){
    	$barrios = Barrio::all();
    	return view('denuncias.create',['barrios' => $barrios]);
    }

    public function create(Request $request){
        
    	$validate = $this->validate($request, [
                'lugar_id' => ['required', 'integer', 'max:255'],
	            'denunciante' => ['required', 'string'],
                'denuncia' => ['required', 'string'],
                ]);
    	$denuncia = new Denuncia;
    	$denuncia->lugar_id = $request->input('lugar_id');
    	$denuncia->denunciante = strtoupper($request->input('denunciante'));
        $denuncia->denuncia = strtoupper($request->input('denuncia'));
        $denuncia->fecha = date('Y-m-d');
    	$denuncia->estado = 'Atender';
    	$denuncia->save();

    	return redirect()->route('lugar.view', [$denuncia->lugar_id])
                         ->with(['message' => 'Se ha registrado una Denuncia...', 'status' => 'success']);
   
    }

    public function update(Request $request){
        
    	$validate = $this->validate($request, [
                'denunciante' => ['required', 'string'],
                'denuncia' => ['required', 'string'],
                ]);
        //var_dump($request->input());
        //die();
    	$denuncia = Denuncia::find($request->input('idDenuncia'));
    	$denuncia->denunciante = strtoupper($request->input('denunciante'));
        $denuncia->denuncia = strtoupper($request->input('denuncia'));
        $denuncia->estado = $request->input('destado');
    	$denuncia->update();

    	return redirect()->route('lugar.view', [$denuncia->lugar_id])
                         ->with(['message' => 'Se ha modificado una Denuncia...', 'status' => 'success']);
   
    }
}

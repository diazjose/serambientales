<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Lugar;
use App\Denuncia;
use App\Tarea;
use App\DesignarLugar;

use Mapper;

class ConsultasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request){
        if($request->input()){ 
            $tarea = Tarea::find($request->input('search'));
            $buscar = $request->input('search');
            $estado = $request->input('status');           
            if($estado!='TODOS'){
                $consulta = DesignarLugar::where('tarea_id',$buscar)->where('estado',$estado)->get();
            }else{
                $consulta = DesignarLugar::where('tarea_id',$buscar)->get();
            }
            $title = 'Resultados de '.$tarea->nombre.' - '.$estado;
        }else{
            $consulta = NULL;
            $title = '';
        }

    	Mapper::map(-29.432468, -66.864249, ['zoom' => 13, 'markers' => ['title' => 'Base Operativa', 'animation' => 'DROP']]);
        //Recorremos los registros para generar las marcas
        if($consulta){ 
            foreach ($consulta as $d) {
                if ($d->lugar->latitud != null) {
                    Mapper::marker($d->lugar->latitud, $d->lugar->longitud,['title' => $d->lugar->calle." N° ".$d->lugar->numero." B° ".$d->lugar->barrio->nombre]);
                }
            }
        }
        $tareas = Tarea::where('estado','Activo')->get();
        return view('consultas.index',['consultas' => $consulta,'tareas' => $tareas,'title' => $title]);
    }

    
}

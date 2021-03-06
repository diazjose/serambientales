<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Dependiente;
use App\Trabajo;
use App\Lugar;
use App\Tarea;
use App\DesignarLugar;

class PersonalController extends Controller
{
   	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	$personal = Persona::where('habilitado','Si')->get();

    	return view('personal.index',['personal' => $personal]);
    }

    public function register(Request $request){
        $aut = Persona::where('cargo', '!=', 'PERSONAL VOLUNTARIO')->orderBy('apellidos','asc')->get();
        return view('personal.registrar', ['auth' => $aut]);
    }

    public function create(Request $request){
        $persona = new Persona;

    	$validate = $this->validate($request, [
                'nombre' => ['required', 'string', 'max:255'],
	            'apellidos' => ['required', 'string', 'max:255'],
	            'dni' => ['required', 'string', 'max:255', 'unique:personas'],
	            //'fechaNac' => ['required', 'date', 'max:255'],
	            //'email' => ['required', 'email', 'unique:personas'],
	            //'direccion' => ['required', 'string', 'max:255'],
                //'telefono' => ['required', 'string', 'max:255'],
	            'cargo' => ['required', 'string', 'max:50'],
            ],
            [
            	//'email.unique' => 'Este correo ya existe en la Base de Datos para otro Personal',
            	'dni.unique' => 'Este N° de DNI ya existe en la Base de Datos para otro Personal',
            ]);

        $persona->nombre = strtoupper($request->input('nombre'));
    	$persona->apellidos = strtoupper($request->input('apellidos'));
		$persona->dni = $request->input('dni');
		if (!empty($request->input('fechaNac'))) {
            $persona->fechaNac = $request->input('fechaNac');
        }
        if (!empty($request->input('email'))) {
            $persona->email = $request->input('email');
        }
        if (!empty($request->input('direccion'))) {
            $persona->email = $request->input('direccion');
        }
        if (!empty($request->input('telefono'))) {
            $persona->email = $request->input('telefono');
        }
        
		$persona->cargo = strtoupper($request->input('cargo'));
    	$persona->habilitado = 'Si';
		$persona->save();

        if ($request->input('enlazar') != 'NADIE') {
            $dep = new Dependiente();
            $dep->coordinador_id = $request->input('enlazar');
            $dep->persona_id = $persona->id;

            $dep->save();
        }
        
        return redirect()->route('personal.viewAuth', [$persona->id]);
                         //->with(['message' => 'Persona cargada correctamente', 'status' => 'success']);

    }

    public function update(Request $request){

        $id = $request->input('id');
        $persona = Persona::find($id);  

        $validate = $this->validate($request, [
                'nombre' => ['required', 'string', 'max:255'],
                'apellidos' => ['required', 'string', 'max:255'],
                'dni' => ['required', 'string', 'max:8', 'unique:personas,dni,'.$id],
                //'fechaNac' => ['required', 'date', 'max:255'],
                //'email' => ['required', 'email', 'unique:personas,email,'.$id],
                //'direccion' => ['required', 'string', 'max:255'],
                //'telefono' => ['required', 'string', 'max:255'],
                'cargo' => ['required', 'string', 'max:50'],
            ],
            [
                //'email.unique' => 'Este correo ya existe en la Base de Datos para otro Personal',
                'dni.unique' => 'Este N° de DNI ya existe en la Base de Datos para otro Personal',
            ]);

        $persona->nombre = strtoupper($request->input('nombre'));
        $persona->apellidos = strtoupper($request->input('apellidos'));
        $persona->dni = $request->input('dni');
        if (!empty($request->input('fechaNac'))) {
            $persona->fechaNac = $request->input('fechaNac');
        }
        if (!empty($request->input('email'))) {
            $persona->email = $request->input('email');
        }
        if (!empty($request->input('direccion'))) {
            $persona->email = $request->input('direccion');
        }
        if (!empty($request->input('telefono'))) {
            $persona->email = $request->input('telefono');
        }
        $persona->cargo = strtoupper($request->input('cargo'));
        
        $persona->update();

        $de = $request->input('enlazar');
        if ($de != 'NADIE') {
            $depende = Dependiente::where('persona_id', $id)->first();
            if ($depende) {
               if ($de != $depende->coordinador_id) {
                    $depende->coordinador_id = $de;
                    $depende->update();           
                } 
            }else{
                $dep = new Dependiente();
                $dep->coordinador_id = $request->input('enlazar');
                $dep->persona_id = $persona->id;

                $dep->save();                
            }
        }else{
            $depende = Dependiente::where('persona_id', $id)->first();
            if ($depende) {
                $depende->delete();        
            }
        }


        return redirect()->route('personal.viewAuth',[$id])
                         ->with(['message' => 'Persona Actualizada correctamente', 'status' => 'success']);

    }

    public function edit($id){
        $persona = Persona::find($id);
        $aut = Persona::where('cargo', '!=', 'PERSONAL VOLUNTARIO')->orderBy('apellidos','asc')->get();
        return view('personal.edit', ['persona' => $persona, 'auth' => $aut]);
    }

    public function listAuth(){
        $aut = Persona::where('cargo', '!=', 'PERSONAL VOLUNTARIO')->get();
        return view('personal.autoridad', ['personas' => $aut]);
    }

    public function viewAuth($id){
        $auth = Persona::where('id',$id)->first();
        $personas = Dependiente::where('coordinador_id',$id)->get();
        $tareas = Tarea::where('estado','Activo')->orderBy('nombre')->get();
        $fecha = date('d/m/d');
        $lugares = DesignarLugar::where('estado','Activo')->get();
        return view('personal.viewAuth', ['auth' => $auth, 'dependiente' => $personas, 'lugares' => $lugares, 'tareas' => $tareas]);
    }    

    public function destroy(Request $request){
        
        $id = $request->input('id');
        $name = $request->input('name');
        $persona = Persona::find($id);
        $persona->habilitado = 'No';
        $persona->update();

        return redirect()->route('personal.index')
                         ->with(['message' => 'Se ha eliminado a '.$name, 'status' => 'danger']);

    }    

    public function asistencia($id, $d=""){
        
        $fecha = date('Y-m-01');
        if($d!=""){
            $fecha = date("Y-m-d",strtotime($d));
        }
        $fechaNueva = date("Y-m-d",strtotime($fecha."+ 1 month"));
        $persona = Persona::find($id);
        $asistencias = Trabajo::where('persona_id',$id)
                                ->where('fecha','>=', $fecha)
                                ->where('fecha','<', $fechaNueva)
                                ->get();
                                $mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"][date("n",strtotime($fecha)) - 1];
        return view('personal.asistencia',['asistencias' => $asistencias, 'auth' => $persona, 'mes' => $mes]);
    }

    public function search(Request $request){
        $buscar = $request->input('buscar');
        $persona = Persona::where('dni', $buscar)->get();

        if (count($persona)>0) {
            $data['status'] = 'success';
            $data['persona'] = $persona;
        }else{
            $data['status'] = 'danger';
        }
        return response()->json($data); 
    }
}


/* BATABASE


create table users(
id int(255) auto_increment not null,
name varchar(255),
surname varchar(255),
email varchar(255),
password varchar(255),
role varchar(255),
created_at datetime,
updated_at datetime,
remember_token varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id)    
)ENGINE=InnoDB;

create table personas(
id int(255) auto_increment not null,
nombre varchar(255),
apellidos varchar(255),
dni varchar(20),
fechaNac date,
email varchar(255),
direccion varchar(255),
telefono varchar(50),
cargo varchar(100),
image varchar(255),
habilitado varchar(10),
created_at datetime,
updated_at datetime,
remember_token varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id)    
)ENGINE=InnoDB;

create table dependiente(
id int(255) auto_increment not null,
coordinador_id int(255),
persona_id int(255),
created_at datetime,
updated_at datetime,
CONSTRAINT pk_dependiente PRIMARY KEY(id),
CONSTRAINT fk_dependiente_coordinador FOREIGN KEY(coordinador_id) REFERENCES personas(id),    
CONSTRAINT fk_dependiente_persona FOREIGN KEY(persona_id) REFERENCES personas(id)
)ENGINE=InnoDB;

create table barrios(
id int(255) auto_increment not null,
nombre varchar(200),
zona varchar(100),
created_at datetime,
updated_at datetime,
CONSTRAINT pk_barrios PRIMARY KEY(id)
)ENGINE=InnoDB;


create table lugares(
id int(255) auto_increment not null,
calle varchar(100),
numero int(10),
barrio_id int(255),
zona varchar(50),
estado varchar(50),
latitud varchar(100),
longitud varchar(100),
created_at datetime,
updated_at datetime,
CONSTRAINT pk_lugares PRIMARY KEY(id),
CONSTRAINT fk_lugares_barrio FOREIGN KEY(barrio_id) REFERENCES barrios(id)
)ENGINE=InnoDB;

create table tareas(
id int(255) auto_increment not null,
nombre varchar(100),
estado varchar(50),
created_at datetime,
updated_at datetime,
CONSTRAINT pk_tareas PRIMARY KEY(id)
)ENGINE=InnoDB;

create table trabajo(
id int(255) auto_increment not null,
persona_id int(255),
lugar_id int(255),
tarea_id int(255),
fecha date,
horaEntrada time,
horaSalida time,
observacion text,
estado varchar(100),
created_at datetime,
updated_at datetime,
CONSTRAINT pk_trabajo PRIMARY KEY(id),
CONSTRAINT fk_trabajo_persona FOREIGN KEY(persona_id) REFERENCES personas(id),
CONSTRAINT fk_trabajo_puesto FOREIGN KEY(lugar_id) REFERENCES lugares(id),
CONSTRAINT fk_trabajo_tarea FOREIGN KEY(tarea_id) REFERENCES tareas(id)
)ENGINE=InnoDB;

create table designar_lugar(
id int(255) auto_increment not null,
lugar_id int(255),
tarea_id int(255),
fechaInicio date,
fechaFin date,
estado varchar(100),
created_at datetime,
updated_at datetime,
CONSTRAINT pk_designar_lugar PRIMARY KEY(id),
CONSTRAINT fk_designar_lugar_lugar FOREIGN KEY(lugar_id) REFERENCES lugares(id),
CONSTRAINT fk_designar_lugar_tarea FOREIGN KEY(tarea_id) REFERENCES tareas(id)
)ENGINE=InnoDB;

create table denuncias(
id int(255) auto_increment not null,
lugar_id int(255),
denunciante varchar(255),
estado varchar(100),
fecha date,
denuncia text,
created_at datetime,
updated_at datetime,
CONSTRAINT pk_denuncias PRIMARY KEY(id),
CONSTRAINT fk_denuncias_lugar FOREIGN KEY(lugar_id) REFERENCES lugares(id)
)ENGINE=InnoDB;

create table herramientas(
id int(255) auto_increment not null,
nombre varchar(255),
cantidad int(100),
created_at datetime,
updated_at datetime,
CONSTRAINT pk_herramientas PRIMARY KEY(id)
)ENGINE=InnoDB;

create table asignacion_herramienta(
id int(255) auto_increment not null,
herramienta_id int(255),
persona_id int(255),
cantidad int(255),
fechaEntrega date,
fechaDevolucion date,
observacion text,
created_at datetime,
updated_at datetime,
CONSTRAINT pk_asignacion_herramiente PRIMARY KEY(id),
CONSTRAINT fk_asignacion_herramienta_as FOREIGN KEY(herramienta_id) REFERENCES herramientas(id),
CONSTRAINT fk_asignacion_herramienta_persona FOREIGN KEY(persona_id) REFERENCES personas(id)
)ENGINE=InnoDB;

create table insumos(
id int(255) auto_increment not null,
nombre varchar(255),
cantidad int(100),
created_at datetime,
updated_at datetime,
CONSTRAINT pk_insumos PRIMARY KEY(id)
)ENGINE=InnoDB;

create table compra_insumo(
id int(255) auto_increment not null,
insumo_id int(255),
cantidad int(255),
monto varchar(255),
fecha date,
created_at datetime,
updated_at datetime,
CONSTRAINT pk_compra_insumo PRIMARY KEY(id),
CONSTRAINT fk_compra_insumo_as FOREIGN KEY(insumo_id) REFERENCES insumos(id)
)ENGINE=InnoDB;

create table entrega_insumo(
id int(255) auto_increment not null,
insumo_id int(255),
persona_id int(255),
cantidad int(255),
fecha date,
created_at datetime,
updated_at datetime,
CONSTRAINT pk_entrega_insumo PRIMARY KEY(id),
CONSTRAINT fk_entrega_insumo_as FOREIGN KEY(insumo_id) REFERENCES insumos(id),
CONSTRAINT fk_entrega_insumo_persona FOREIGN KEY(persona_id) REFERENCES personas(id)
)ENGINE=InnoDB;

create table maquinarias(
id int(255) auto_increment not null,
nombre varchar(255),
dominio varchar(255),
estado varchar(20),
created_at datetime,
updated_at datetime,
CONSTRAINT pk_maquinarias PRIMARY KEY(id)
)ENGINE=InnoDB;

create table asignacion_maquinaria(
id int(255) auto_increment not null,
maquinaria_id int(255),
persona_id int(255),
fechaEntrega date,
fechaDevolucion date,
observacion text,
created_at datetime,
updated_at datetime,
CONSTRAINT pk_asignacion_maquinaria PRIMARY KEY(id),
CONSTRAINT fk_asignacion_maquinaria_as FOREIGN KEY(maquinaria_id) REFERENCES maquinarias(id),
CONSTRAINT fk_asignacion_maquinaria_persona FOREIGN KEY(persona_id) REFERENCES personas(id)
)ENGINE=InnoDB;

INSERT INTO users VALUES (1, "Luz" ,"Herrera", "luzherrera33967@gmail.com", "$2y$10$PjnHPCT6q/OKaK27IQqIm.5viEyR2W9j46wHGQkNA/AE37JZm4tEu", "ADMIN","2020-11-23 00:00:00", "2020-11-23 00:00:00");
*/
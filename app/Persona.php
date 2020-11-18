<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'personas';

    protected $fillable = [
        'nombre', 'apellidos', 'dni', 'email', 'direccion', 'telefono','fechaIngreso', 'cargo',
    ];

    public function depende(){
    	return $this->hasMany('App\Dependiente'); 
    }

    public function tarea(){
        return $this->hasOne('App\Trabajo')->where('fecha', date('Y-m-d'));   
    }
}

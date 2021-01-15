<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maquinaria extends Model
{
    protected $table = 'maquinarias';

    protected $fillable = [
    	'nombre','dominio',
    ];

    public function asignadas(){
    	return $this->hasMany('App\AsignarMaquinaria');//->where('fechaDevolucion', NULL);
    }
}

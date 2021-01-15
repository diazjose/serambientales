<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model
{
    protected $table = 'herramientas';

    protected $fillable = [
    	'nombre','cantidad',
    ];

    public function asignadas(){
    	return $this->hasMany('App\AsignarHerramienta');//->where('fechaDevolucion', NULL);
    }

}

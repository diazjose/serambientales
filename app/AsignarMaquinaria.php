<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsignarMaquinaria extends Model
{
    protected $table = 'asignacion_maquinaria';

    protected $fillable = [
    	'maquinaria_id','persona_id','fechaEntrega','fechaDevolucion','observacion',
    ];

    public function maquinaria(){
    	return $this->belongsTo('App\Maquinaria','maquinaria_id');
    }

    public function personal(){
    	return $this->belongsTo('App\Persona','persona_id');
    }
}

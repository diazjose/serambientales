<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AsignarHerramienta extends Model
{
    protected $table = 'asignacion_herramienta';

    protected $fillable = [
    	'herramienta_id','persona_id','cantidad','fechaEntrega','fechaDevolucion'
    ];

    public function herramienta(){
    	return $this->belongsTo('App\Herramienta','herramienta_id');
    }

    public function personal(){
    	return $this->belongsTo('App\Persona','persona_id');
    }

}

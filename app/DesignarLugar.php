<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesignarLugar extends Model
{
    protected $table = 'designar_lugar';

    protected $fillable = [
        'lugar_id', 'fechaInicio', 'fechaFin', 'tarea_id', 'estado',
    ];

    public function lugar(){
        return $this->belongsTo('App\Lugar', 'lugar_id'); 
    }

    public function tarea(){
        return $this->belongsTo('App\Tarea', 'tarea_id'); 
    }
}

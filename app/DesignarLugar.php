<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DesignarLugar extends Model
{
    protected $table = 'designar_lugar';

    protected $fillable = [
        'lugar_id', 'fechaInicio', 'fechaFin', 'tarea', 'estado',
    ];

    public function lugar(){
        return $this->belongsTo('App\Lugar', 'lugar_id'); 
    }
}

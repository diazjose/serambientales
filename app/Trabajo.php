<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    protected $table = 'trabajo';

    protected $fillable = [
        'persona_id', 'lugar_id', 'fecha', 'horaEntrada', 'horaSalida', 'tarea_id',
    ];
        
    public function lugar(){
        return $this->belongsTo('App\Lugar', 'lugar_id'); 
    }

    public function persona(){
        return $this->belongsTo('App\Persona', 'persona_id'); 
    }

    public function tarea(){
        return $this->belongsTo('App\Tarea', 'tarea_id'); 
    }
}

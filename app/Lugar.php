<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    protected $table = 'lugares';

    protected $fillable = [
    	'calle','numero','barrio_id','estado','latitud','longitud',
    ];

    public function barrio(){
    	return $this->belongsTo('App\Barrio','barrio_id');
    }

    public function tareas(){
    	return $this->hasMany('App\DesignarLugar'); 
    }

    public function denuncias(){
    	return $this->hasMany('App\Denuncia')->orderBy('fecha','DESC'); 
    }
}

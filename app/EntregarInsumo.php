<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntregarInsumo extends Model
{
    protected $table = 'entrega_insumo';

    protected $fillable = [
    	'insumo_id','persona_id','cantidad','fecha'
    ];

    public function insumo(){
    	return $this->belongsTo('App\Insumo','insumo_id');
    }

    public function personal(){
    	return $this->belongsTo('App\Persona','persona_id');
    }
}

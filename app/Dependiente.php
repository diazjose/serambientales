<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dependiente extends Model
{
    protected $table = 'dependiente';

    protected $fillable = [
        'coordinador_id', 'persona_id',
    ];

   public function persona(){
    	return $this->belongsTo('App\Persona', 'persona_id'); 
   }

   public function coordinador(){
    	return $this->belongsTo('App\Persona', 'coordinador_id'); 
   }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    protected $table = 'denuncias';

    protected $fillable = [
        'lugar_id', 'denunciante', 'estado', 'fecha', 'denuncia',
    ];

    public function lugar(){
    	return $this->belongsTo('App\Lugar', 'lugar_id'); 
   }

}

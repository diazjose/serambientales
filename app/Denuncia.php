<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Denuncia extends Model
{
    protected $table = 'denuncias';

    protected $fillable = [
        'designarLugar_id', 'denunciante', 'denuncia', 'estado', 'fecha',
    ];

    public function lugar(){
    	return $this->belongsTo('App\DesignarLugar', 'designarLugar_id'); 
   }

}

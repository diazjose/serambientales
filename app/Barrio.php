<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barrio extends Model
{
    protected $table = 'barrios';

    protected $fillable = [
    	'nombre','zona',
    ];

    public function lugares(){
    	return $this->hasMany('App\Lugar'); 
    }
}

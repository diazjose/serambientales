<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insumo extends Model
{
    protected $table = 'insumos';

    protected $fillable = [
    	'nombre','cantidad',
    ];
    
    public function entregados(){
    	return $this->hasMany('App\EntregarInsumo')->orderBy('fecha');
    }
}

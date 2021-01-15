<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


/*PERSONAL*/
Route::get('/personal', 'PersonalController@index')->name('personal.index');
Route::get('/personal/registrar', 'PersonalController@register')->name('personal.register');
Route::post('/personal/register', 'PersonalController@create')->name('personal.create');
Route::get('/personal/designado', 'PersonalController@listAuth')->name('personal.listAuth');
Route::get('/personal/ver/{id}', 'PersonalController@viewAuth')->name('personal.viewAuth');
Route::get('/personal/actualizar/{id}', 'PersonalController@edit')->name('personal.edit');
Route::post('/personal/update', 'PersonalController@update')->name('personal.update');
Route::post('/personal/delete', 'PersonalController@destroy')->name('personal.destroy');
Route::get('/personal/asistencia/{id}/{fecha?}', 'PersonalController@asistencia')->name('personal.asistencia');
Route::post('/personal/buscar', 'PersonalController@search')->name('personal.search');


/*BARRIOS*/
Route::get('/barrios', 'BarriosController@index')->name('barrios.index');
Route::post('/barrio/create', 'BarriosController@create')->name('barrio.create');
Route::post('/barrio/update', 'BarriosController@update')->name('barrio.update');
Route::post('/barrio/delete', 'BarriosController@destroy')->name('barrio.destroy');

/*LUGARES*/
Route::get('/lugares', 'LugaresController@index')->name('lugares.index');
Route::get('/lugar/registrar', 'LugaresController@register')->name('lugar.register');
Route::post('/lugar/create', 'LugaresController@create')->name('lugar.create');
Route::get('/lugar/ver/{id}', 'LugaresController@view')->name('lugar.view');
Route::get('/lugar/actualizar/{id}', 'LugaresController@edit')->name('lugar.edit');
Route::post('/lugar/update', 'LugaresController@update')->name('lugar.update');


/*TAREAS*/
Route::get('/tareas', 'TrabajosController@index')->name('tarea.index');
Route::post('/tarea/create', 'TrabajosController@createTask')->name('tarea.createTask');
Route::post('/tarea/update', 'TrabajosController@updateTask')->name('tarea.updateTask');
Route::post('/tarea/delete', 'TrabajosController@destroyTask')->name('tarea.destroyTask');
Route::post('/tarea/asignarTarea', 'TrabajosController@create')->name('tarea.create');
Route::post('/tarea/editarTarea', 'TrabajosController@update')->name('tarea.update');
Route::post('/tarea/deleteTarea', 'TrabajosController@destroy')->name('tarea.destroy');
Route::post('/tarea/asistTarea', 'TrabajosController@assistance')->name('tarea.assistance');


/*DESIGNAR TAREA LUGAR*/
Route::post('/designarLugar/crear', 'DesignarLugarController@create')->name('deslug.create');
Route::post('/designarLugar/editar', 'DesignarLugarController@update')->name('deslug.update');

/* DENUNCIAS */
Route::get('/denuncias', 'DenunciasController@index')->name('denuncias.index');
Route::post('/denuncia/registrar', 'DenunciasController@create')->name('denuncia.create');
Route::post('/denuncia/update', 'DenunciasController@update')->name('denuncia.update');

/* HERRAMIENTAS */
Route::get('/herramientas', 'HerramientasController@index')->name('herramienta.index');
Route::post('/herramienta/nueva', 'HerramientasController@create')->name('herramienta.create');
Route::post('/herramienta/update', 'HerramientasController@update')->name('herramienta.update');
Route::get('/herramienta/ver/{id}', 'HerramientasController@view')->name('herramienta.view');
Route::post('/herramienta/prestar', 'AsignarHerramientaController@create')->name('herramienta.prestar');
Route::post('/herramienta/prestarEdit', 'AsignarHerramientaController@update')->name('herramienta.prestarEdit');
Route::post('/herramienta/prestarDelete', 'AsignarHerramientaController@destroy')->name('herramienta.prestarDelete');

/* INSUMOS */
Route::get('/insumos', 'InsumosController@index')->name('insumo.index');
Route::post('/insumo/nueva', 'InsumosController@create')->name('insumo.create');
Route::post('/insumo/update', 'InsumosController@update')->name('insumo.update');
Route::get('/insumo/ver/{id}', 'InsumosController@view')->name('insumo.view');
Route::post('/insumo/prestar', 'EntregarInsumoController@create')->name('insumo.prestar');
Route::post('/insumo/prestarEdit', 'EntregarInsumoController@update')->name('insumo.prestarEdit');
Route::post('/insumo/prestarDelete', 'EntregarInsumoController@destroy')->name('insumo.prestarDelete');

/* HERRAMIENTAS */
Route::get('/maquinarias', 'MaquinariasController@index')->name('maquinaria.index');
Route::post('/maquinaria/nueva', 'MaquinariasController@create')->name('maquinaria.create');
Route::post('/maquinaria/update', 'MaquinariasController@update')->name('maquinaria.update');
Route::get('/maquinaria/ver/{id}', 'MaquinariasController@view')->name('maquinaria.view');
Route::post('/maquinaria/prestar', 'AsignarMaquinariasController@create')->name('maquinaria.prestar');
Route::post('/maquinaria/prestarEdit', 'AsignarMaquinariasController@update')->name('maquinaria.prestarEdit');
Route::post('/maquinaria/prestarDelete', 'AsignarMaquinariasController@destroy')->name('maquinaria.prestarDelete');

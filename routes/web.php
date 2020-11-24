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
Route::post('/tarea/asignarTarea', 'TrabajosController@create')->name('tarea.create');
Route::post('/tarea/editarTarea', 'TrabajosController@update')->name('tarea.update');
Route::post('/tarea/deleteTarea', 'TrabajosController@destroy')->name('tarea.destroy');
Route::post('/tarea/asistTarea', 'TrabajosController@assistance')->name('tarea.assistance');


/*DESIGNAR TAREA LUGAR*/
Route::post('/designarLugar/crear', 'DesignarLugarController@create')->name('deslug.create');
Route::post('/designarLugar/editar', 'DesignarLugarController@update')->name('deslug.update');

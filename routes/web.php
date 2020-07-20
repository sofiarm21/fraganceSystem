<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'WelcomeController@index');

Route::get('/Evaluacion', 'EvaluacionController@index');
Route::get('/Evaluacion/{id}', 'EvaluacionDetailController@view');
Route::get('/Evaluacion/creacion-formula-inicial/{id}', 'FormulaInicialController@view');
Route::get('/Evaluacion/creacion-escala/{id}', 'EscalaController@view');
Route::post('/Evaluacion/creacion-formula-inicial/create/{id}', 'FormulaInicialController@create');
Route::post('/Evaluacion/creacion-escala/create/{id}', 'EscalaController@create');



Route::get('/Compras', 'ComprasController@index');

Route::get('/Recomendador', 'RecomendadorController@index');

Route::get('/Productor', 'WelcomeProductorController@index');
Route::get('/ProductorCatalogo/{id}', 'ProductorController@view');




// Route::get('/', function () {
//     return view('welcome');
// });
//
// Route::get('/', 'HomeController@index');
// Route::get('/libro/{id}', 'LibroController@view');
// Route::post('/create', 'LibroController@create');

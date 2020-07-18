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
Route::get('/Productor', 'WelcomeProductorController@index');

// Route::get('/', function () {
//     return view('welcome');
// });
//
// Route::get('/', 'HomeController@index');
// Route::get('/libro/{id}', 'LibroController@view');
// Route::post('/create', 'LibroController@create');

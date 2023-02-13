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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Ruta de apartar cita;
Route::get('/evento', [App\Http\Controllers\EventoController::class, 'index']);
Route::get('/evento/mostrar', [App\Http\Controllers\EventoController::class, 'show']);
Route::post('/evento/agregar', [App\Http\Controllers\EventoController::class, 'store']);
Route::post('/evento/editar/{id}', [App\Http\Controllers\EventoController::class, 'edit']);
Route::post('/evento/update/{evento}', [App\Http\Controllers\EventoController::class, 'update']);
Route::post('/evento/delete/{id}', [App\Http\Controllers\EventoController::class, 'destroy']);


//Rutas de agendamiento de turnos.
Route::get('/turnos', [App\Http\Controllers\TurnosController::class, 'index']);
Route::get('/turnos/mostrar', [App\Http\Controllers\TurnosController::class, 'show']);
Route::post('/turnos/agregar', [App\Http\Controllers\TurnosController::class, 'store']);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

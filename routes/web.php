<?php

use App\Http\Controllers\ComprarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConsultarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarteiraController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\VenderController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('inicio');

Route::get('/cadastrar', function () {
    return view('cadastrar');
})->name('cadastrar');

Route::post('/cadastrar', [
    UserController::class,
    'store'
])->name('cadastrar.store');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::get('/consultar', [
    ConsultarController::class,
    'create'
])->middleware('auth')->name('consultar');

Route::post('/consultar', [
    ConsultarController::class,
    'consultar'
])->middleware('auth')->name('consultar');

Route::get('/comprar', [
    ComprarController::class,
    'create'
])->middleware('auth')->name('comprar');
Route::post('/comprar', [
    ComprarController::class,
    'comprar'
])->middleware('auth')->name('comprar');

Route::get('/carteira', [CarteiraController::class, 'index'])
    ->middleware('auth') // protege a rota
    ->name('carteira');

Route::get('/historico', [HistoricoController::class, 'index'])
    ->middleware('auth')
    ->name('historico');

Route::get('/vender', [VenderController::class, 'index'])
    ->middleware('auth')
    ->name('vender');

    
Route::post('/vender', [VenderController::class, 'vender'])
    ->middleware('auth')
    ->name('vender');
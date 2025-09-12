<?php

use App\Http\Controllers\ComprarController;
use App\Http\Controllers\CadastrarController;
use App\Http\Controllers\ConsultarController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarteiraController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VenderController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index'])->name('home.inicio');
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware('auth')->name('home.dashboard');

Route::get('/cadastrar', [CadastrarController::class, 'index'])->name('cadastrar.inicio');
Route::post('/cadastrar', [CadastrarController::class, 'store'])->name('cadastrar.store');

Route::get('/login', [AuthController::class, 'index'])->name('login.inicio');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


Route::get('/consultar', [ConsultarController::class, 'index'])->middleware('auth')->name('consultar.inicio');
Route::post('/consultar', [ConsultarController::class, 'consultar'])->middleware('auth')->name('consultar');

Route::get('/comprar', [ComprarController::class, 'index'])->middleware('auth')->name('comprar.inicio');
Route::post('/comprar', [ComprarController::class,'comprar'])->middleware('auth')->name('comprar');

Route::get('/carteira', [CarteiraController::class, 'index'])->middleware('auth')->name('carteira');

Route::get('/historico', [HistoricoController::class, 'index'])->middleware('auth')->name('historico.inicio');

Route::get('/vender', [VenderController::class, 'index'])->middleware('auth')->name('vender.inicio');
Route::post('/vender', [VenderController::class, 'vender'])->middleware('auth')->name('vender');

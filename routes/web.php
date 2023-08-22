<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;


Route::get('/',[StateController::class, 'index'])->name('index');
Route::get('getInfo/{id}',[StateController::class, 'getInfo'])->name('getInfo');
Route::get('sincronizarDatosINEGI',[StateController::class, 'sincronizarDatosINEGI'])->name('sincronizarDatosINEGI');


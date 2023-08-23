<?php

use App\Http\Controllers\NotasController;
use Illuminate\Support\Facades\Route;


Route::get('/', [NotasController::class, 'index'])->name('nota');
Route::post('/', [NotasController::class, 'store'])->name('nota.store');
Route::delete('/{nota}/delete', [NotasController::class, 'delete'])->name('nota.delete');

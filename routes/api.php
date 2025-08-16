<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/customers', [CustomerController::class, 'search'])->middleware('auth.token');

Route::post('/customers', [CustomerController::class, 'store'])->middleware('auth.token');

Route::get('/customers/{id}', [CustomerController::class, 'show'])->middleware('auth.token');

Route::put('/customers/{id}', [CustomerController::class, 'update'])->middleware('auth.token');

Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->middleware('auth.token');

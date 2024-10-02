<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\studentController;

Route::get('/student', [studentController::class, 'index']
);

Route::get('/student/{id}', [studentController::class,'show']);

Route::post('/student', [studentController::class,'store']);

Route::put('/student/{id}', [studentController::class,'update']);
Route::patch('/student/{id}', [studentController::class,'updatePartial']);

Route::delete('/student/{id}', [studentController::class, 'destroy']);

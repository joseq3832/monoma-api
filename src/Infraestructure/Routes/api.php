<?php

use Illuminate\Support\Facades\Route;
use Src\Infraestructure\Controllers\AuthController;
use Src\Infraestructure\Controllers\LeadController;

Route::get('/', function () {
    return response()->json([
        'message' => 'Laravel',
    ]);
});

Route::post('/auth', [AuthController::class, 'login']);

Route::middleware('auth.jwt')->group(function () {
    Route::get('/leads', [LeadController::class, 'index']);
    Route::post('/lead', [LeadController::class, 'store']);
    Route::get('/lead/{id}', [LeadController::class, 'show']);
});

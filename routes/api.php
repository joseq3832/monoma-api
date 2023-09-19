<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\LeadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return response()->json([
        'message' => 'Laravel',
    ]);
});

Route::post('/auth', [AuthController::class, 'login']);

Route::middleware('auth.jwt')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/leads', [LeadController::class, 'index']);
    Route::post('/lead', [LeadController::class, 'store']);
    Route::get('/lead/{id}', [LeadController::class, 'show']);
});

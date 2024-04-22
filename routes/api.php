
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassagerController;
use App\Http\Controllers\ConducteurController;

// Routes pour l'authentification des passagers
Route::post('passagers/register', [PassagerController::class, 'register']);
Route::put('passagers/update/{passager}', [PassagerController::class, 'update']);
Route::delete('passagers/{passager}', [PassagerController::class, 'delete']);
Route::post('passagers/login', [PassagerController::class, 'login']);
Route::post('passagers/{passager}', [PassagerController::class, 'show']);
Route::post('passagers/logout', [PassagerController::class, 'logout'])->middleware('auth:api');
//Route::post('passagers/refresh', [PassagerController::class, 'refresh'])->middleware('auth:api');
//Route::post('passagers/reset-password', [PassagerController::class, 'resetPassword']);

// Routes pour l'authentification des conducteurs
Route::post('conducteurs/register', [ConducteurController::class, 'register']);
Route::put('conducteurs/update/{conducteur}', [ConducteurController::class, 'update']);
Route::delete('conducteurs/{conducteur}', [ConducteurController::class, 'delete']);
Route::post('conducteurs/login', [ConducteurController::class, 'login']);
Route::post('conducteurs/{conducteur}', [PassagerController::class, 'show']);
Route::post('conducteurs/logout', [ConducteurController::class, 'logout'])->middleware('auth:api');
//Route::post('conducteurs/refresh', [ConducteurController::class, 'refresh'])->middleware('auth:api');
//Route::post('conducteurs/reset-password', [ConducteurController::class, 'resetPassword']);

// Autres routes pour les fonctionnalités supplémentaires
//Route::post('passagers/forgot-password', [PassagerController::class, 'forgotPassword']);
//Route::post('conducteurs/forgot-password', [ConducteurController::class, 'forgotPassword']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request){
    return $request->user();
});
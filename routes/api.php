<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfilController;
use App\Http\Controllers\Api\CommentaireController;

// Récupérer le token
Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/profils', [ProfilController::class, 'show']);

Route::middleware([
    'auth:sanctum'
])->group(function () {
    Route::post('/profils/create', [ProfilController::class, 'create']);
    Route::post('/profils/{profil_id}/update', [ProfilController::class, 'update']);
    Route::delete('/profils/{profil_id}/delete', [ProfilController::class, 'destroy']);
    Route::post('/profils/{profil_id}/commentaires/create', [CommentaireController::class, 'create']);
});

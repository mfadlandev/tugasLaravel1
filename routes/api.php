<?php

use App\Http\Controllers\Api\PetaniController as ApiPetaniController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('petani', ApiPetaniController::class)
    ->names('api.petani');
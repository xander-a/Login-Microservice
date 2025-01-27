<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::middleware(  ['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('create-user', [UserController::class, 'createUser']);
Route::post('login-user', [UserController::class, 'loginUser']);

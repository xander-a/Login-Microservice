<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::middleware(  ['auth:sanctum'])->get('/auth-check', function (Request $request) {
    if($request->user()){
        return response()->json(['message' => 'True'], 200);
    }});

Route::post('create-user', [UserController::class, 'createUser']);
Route::post('login-user', [UserController::class, 'loginUser']);

Route::post('logout', function (Request $request) {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logged out'], 200);
})->middleware('auth:sanctum');



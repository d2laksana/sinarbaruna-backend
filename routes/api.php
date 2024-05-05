<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CekToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::apiResource('/user', UserController::class)->middleware(CekToken::class);

<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\MouldingController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CekToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::apiResource('/user', UserController::class)->middleware(CekToken::class);
Route::post('/user/karyawan', [UserController::class, 'storeKaryawan'])->middleware(CekToken::class);
Route::apiResource('/moulding', MouldingController::class)->middleware(CekToken::class);
Route::apiResource('/trx', TransaksiController::class)->middleware(CekToken::class);
Route::apiResource('/jadwal', JadwalController::class)->middleware(CekToken::class);
Route::put('/jadwal/keterangan/{id}', [JadwalController::class, 'updateKeterangan'])->middleware(CekToken::class);
Route::get('/bagian', [JadwalController::class, 'getJadwal'])->middleware(CekToken::class);

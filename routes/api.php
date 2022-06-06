<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CandidateController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::resource('candidates', CandidateController::class)->except(['create', 'edit'])->middleware(['auth:api', 'admin']);

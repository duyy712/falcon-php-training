<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\TaskController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
// Route::apiResource('task', TaskController::class);
Route::middleware(['auth:api', 'role'])->group(function () {
    Route::middleware(['scope:admin,user'])->get('/tasks', [TaskController::class, 'index']);
    Route::middleware(['scope:admin'])->post('/task', [TaskController::class, 'store']);
    Route::middleware(['scope:admin'])->get('/task/{id}', [TaskController::class, 'show']);
    Route::middleware(['scope:admin'])->put('/task/{id}', [TaskController::class, 'update']);
    Route::middleware(['scope:admin'])->delete('/task/{id}', [TaskController::class, 'destroy']);
});

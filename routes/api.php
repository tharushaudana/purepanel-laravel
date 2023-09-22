<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**** Public routes ****/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

/**** Protected routes (Authenticated) ****/
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('/students')->group(function () {
        Route::get('/', [StudentController::class, 'index']);
        Route::get('/{student}', [StudentController::class, 'show']);
        Route::post('/', [StudentController::class, 'store'])->middleware('checkUserLevel:a|m');
        Route::patch('/{student}', [StudentController::class, 'update'])->middleware('checkUserLevel:a|m');
        Route::delete('/{student}', [StudentController::class, 'delete'])->middleware('checkUserLevel:a|m');
    });
});

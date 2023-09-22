<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\StudentController;
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
        Route::post('/', [StudentController::class, 'store'])->middleware('checkUserLevel:a|m');

        Route::prefix('/{student}')->group(function () {
            Route::get('/', [StudentController::class, 'show']);
            Route::patch('/', [StudentController::class, 'update'])->middleware('checkUserLevel:a|m');
            Route::delete('/', [StudentController::class, 'destroy'])->middleware('checkUserLevel:a|m');
        });
    });

    Route::prefix('/invitations')->group(function () {
        Route::get('/', [InvitationController::class, 'index']);
        Route::post('/', [InvitationController::class, 'store'])->middleware('checkUserLevel:a|m');

        Route::prefix('/{invitation}')->group(function () {
            Route::get('/', [InvitationController::class, 'show']);
            Route::delete('/', [InvitationController::class, 'destroy'])->middleware('checkUserLevel:a|m');
        });
    });

    Route::prefix('/panels')->group(function () {
        Route::get('/', [InvitationController::class, 'index']);
        Route::post('/', [InvitationController::class, 'store'])->middleware('checkUserLevel:a|m');

        Route::prefix('/{panel}')->group(function () {
            Route::get('/', [InvitationController::class, 'show']);
            Route::patch('/', [StudentController::class, 'update'])->middleware('checkUserLevel:a|m');
            Route::delete('/', [InvitationController::class, 'destroy'])->middleware('checkUserLevel:a|m');

            Route::prefix('/users')->group(function () {
                Route::get('/', [InvitationController::class, 'indexUsers']);
                Route::post('/', [InvitationController::class, 'addUser'])->middleware('checkUserLevel:a|m');
                Route::delete('/{user}', [InvitationController::class, 'removeUser'])->middleware('checkUserLevel:a|m');
            });
        });
    });
});

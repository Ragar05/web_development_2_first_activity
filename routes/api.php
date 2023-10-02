<?php

use App\Http\Controllers\Task\CreateTaskController;
use App\Http\Controllers\Task\DeleteTaskController;
use App\Http\Controllers\Task\GetAllTaskController;
use App\Http\Controllers\Task\UpdateTaskController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix("/v1/task")->group(function () {
    Route::get("/get_all", [GetAllTaskController::class, 'run']);
    Route::post("/create", [CreateTaskController::class, 'run']);
    Route::put("/update/{id}", [UpdateTaskController::class, 'run']);
    Route::delete("/delete/{id}", [DeleteTaskController::class, 'run']);
});

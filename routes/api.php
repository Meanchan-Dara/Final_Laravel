<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    //    AuthController
    Route::post('/logout', [AuthController::class, 'logout']);
    // ProdjuctController
    Route::get("/products", [ProductController::class, 'index']);
    Route::post("/products", [ProductController::class, 'store']);

    // CategoriesController
    Route::post("/catigorie", [CategoriesController::class, 'store']);

    // OderController
    Route::get("/order", [OrderController::class, 'index']);
    Route::post("/order", [OrderController::class, 'store']);
    Route::get("/order/{id}", [OrderController::class, 'show']);
    Route::post("/order/{id}", [OrderController::class, 'update']);
    Route::post("/order/{id}", [OrderController::class, 'destroy']);
});

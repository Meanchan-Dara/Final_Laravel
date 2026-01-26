<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('roles', [RoleController::class, 'store']);
});

Route::middleware('auth:sanctum')->group(function () {
    // ProdjuctController
    Route::get("/products", [ProductController::class, 'index']);
    Route::post("/products", [ProductController::class, 'store']);
    Route::post("/products", [ProductController::class, 'show']);
    Route::post("/products", [ProductController::class, 'update']);
    Route::post("/products", [ProductController::class, 'destroy']);

    // CategoriesController
    Route::post("/catigorie", [CategoriesController::class, 'store']);

    // OderController
    Route::get("/order", [OrderController::class, 'index']);
    Route::post("/order", [OrderController::class, 'store']);
    Route::get("/order/{id}", [OrderController::class, 'show']);
    Route::post("/order/{id}", [OrderController::class, 'update']);
    Route::post("/order/{id}", [OrderController::class, 'destroy']);

    // Oder_ItemController
    Route::get("/order-iteam", [OrderController::class, 'index']);
    Route::post("/order-iteam", [OrderController::class, 'store']);
});

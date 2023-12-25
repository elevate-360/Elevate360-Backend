<?php

use App\Http\Controllers\LoginControllers\LoginController;
use App\Http\Controllers\MenuControllers\MenuController;
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

// Public Routes
Route::post("/login", [LoginController::class, "login"]);
Route::post("/register", [LoginController::class, "register"]);

// Private Routes
Route::middleware(['auth.api'])->group(function () {
    Route::get("/menu/dashboard", [MenuController::class, "getMenu"]);
});

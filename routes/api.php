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

// Default rpute
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Public Routes
Route::post("/login", [LoginController::class, "login"]);
Route::post("/register", [LoginController::class, "register"]);
Route::get("/menu/dashboard", [MenuController::class, "getMenu"]);

// Route::middleware(["auth.api"])->group(function () {
//     // Define your protected API routes here
//     Route::get('/example', 'ExampleController@index');
// });

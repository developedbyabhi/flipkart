<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController; // ✅ Import at the top


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [ProductController::class, 'index'])->name('home');



Route::get("/products", [ProductController::class, "index"])->name("products.index");
Route::post("/products", [ProductController::class, "store"])->name("products.store");
Route::delete("/products/{product}", [ProductController::class, "destroy"])->name("products.destroy");



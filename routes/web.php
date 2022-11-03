<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// HomePage
Route::get('/', [ListingController::class, 'index']);

// Create listing
Route::get('/listing/create', [ListingController::class, 'create'])->middleware('auth');

// Save listing
Route::post('/listing', [ListingController::class, 'store'])->middleware('auth');

// Manage listings
Route::get("/listing/manage", [ListingController::class, 'manage'])->middleware("auth");

//Edit Listing
Route::get('/listing/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Update Listing
Route::put('/listing/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete Lisitng
Route::delete('/listing/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//Show single Listing
Route::get('/listing/{listing}', [ListingController::class, 'show']);


// Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware("guest");

// Create User
Route::post('/users', [UserController::class, 'store']);

//Log User out
Route::post("/logout", [UserController::class, 'logout'])->middleware('auth');

//Show login form
Route::get("/login", [UserController::class, "login"])->name("login")->middleware("guest");

//Log in user
Route::post("/users/authenticate", [UserController::class, "authenticate"]);

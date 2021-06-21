<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

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

// this route for getting dashboard view
Route::get('dashboard', [AuthController::class, 'dashboard']);

// these routes for getting login page and login post 
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('post-login', [CustomAuthController::class, 'customLogin'])->name('login.post'); 


// these routes for getting register page and register post 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('post-registration', [CustomAuthController::class, 'customRegistration'])->name('register.post'); 

// this route for logout user
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');


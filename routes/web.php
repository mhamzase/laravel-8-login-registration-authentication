<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Middleware\Authorize;

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


// these routes for getting login page and login post 
Route::get('login', [UserController::class, 'index'])->name('login');
Route::post('post-login', [UserController::class, 'postLogin'])->name('login.post'); 


// these routes for getting register page and register post 
Route::get('registration', [UserController::class, 'registration'])->name('register-user');
Route::post('post-registration', [UserController::class, 'postRegistration'])->name('register.post'); 

// this route for logout user
Route::get('logout', [UserController::class, 'logOut'])->name('logout');


// this route for verification of user email
Route::get('account/verify/{token}', [UserController::class, 'verifyAccount'])->name('verify.user'); 


// this route for getting dashboard view
Route::middleware([Authorize::class])->group(function(){
 
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
 
 });

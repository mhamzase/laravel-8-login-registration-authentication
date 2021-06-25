<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Middleware\Authorize;
use App\Http\Middleware\PublicRoutes;

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


// this is public middleware
Route::middleware([PublicRoutes::class])->group(function () {

    // these routes for getting login page and login post 
    Route::get('login', [UserController::class, 'index'])->name('login');
    Route::post('post-login', [UserController::class, 'postLogin'])->name('login.post');


    // these routes for getting register page and register post 
    Route::get('registration', [UserController::class, 'registration'])->name('register-user');
    Route::post('post-registration', [UserController::class, 'postRegistration'])->name('register.post');


    // these routes for getting register page and register post 
    Route::get('forgot-password', [UserController::class, 'forgotPassword'])->name('forgot.password');
    Route::post('post-forgotPassword', [UserController::class, 'postForgotPassword'])->name('forgotPassword.post');

    // send restore link or route to email
    Route::get('update-password/{token}', [UserController::class, 'updatePasswordForm'])->name('update.password');
    Route::post('update-password', [UserController::class, 'postUpdatePassword'])->name('updatePassword.post');

    // this route for verification of user email
    Route::get('account/verify/{token}', [UserController::class, 'verifyAccount'])->name('verify.user');
});



// this is auth middleware
Route::middleware([Authorize::class])->group(function () {

    Route::get('dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');


    // this route for logout user
    Route::get('logout', [UserController::class, 'logOut'])->name('logout');
});

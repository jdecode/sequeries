<?php

/** @noinspection PhpPossiblePolymorphicInvocationInspection */

use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/', function () {
    return Auth::check() ? redirect(route('user.dashboard')) : view('welcome');
})->name('home');

Route::middleware(['auth:admin'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin', 'index')->name('admin');
        Route::get('/admin/dashboard', 'dashboard')->name('admin.dashboard');
        Route::post('/admin/logout', 'logout')->name('admin.logout');
    });
});

Route::middleware(['guest'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin/login', 'loginForm')->name('admin.loginForm');
        Route::post('/admin/login', 'login')->name('admin.login');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/auth/github/login', 'login')->name('auth.github.login');
        Route::get('/auth/github/callback', 'callback')->name('auth.github.callback');
    });

});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('user.dashboard');
        Route::post('/logout', 'logout')->name('user.logout');
    });
});
